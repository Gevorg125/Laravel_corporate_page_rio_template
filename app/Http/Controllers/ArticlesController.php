<?php

namespace Corp\Http\Controllers;

use Corp\Menu;
use Illuminate\Http\Request;
use Corp\Repositories\MenusRepository;
use Corp\Repositories\ArticlesRepository;
use Corp\Repositories\CommentsRepository;
use Corp\Repositories\PortfoliosRepository;

class ArticlesController extends SiteController
{
    public function __construct(PortfoliosRepository $p_rep, ArticlesRepository $a_rep, CommentsRepository $c_rep) {
        parent::__construct(new MenusRepository(new Menu()));

        $this->a_rep = $a_rep;
        $this->p_rep = $p_rep;
        $this->c_rep = $c_rep;

        $this->template = env('THEME').  '.articles';
        $this->bar = 'right';
    }

    public function index()
    {
        //
        $articles = $this->getArticles();

        $content = view(env('THEME'). '.articles_content')->with('articles', $articles)->render();
        $this->vars = array_add($this->vars, 'content', $content);

        $comments = $this->getComments(config('settings.recent_comments'));
        $portfolios = $this->getPortfolios(config('settings.recent_portfolios'));
        $this->contentRightBar = view(env('THEME'). '.articlesBar')->with(['comments'=>$comments, 'portfolios'=>$portfolios]);

        return $this->renderOutput();
    }

    public function getArticles($alias = False){

        //ete kan kapvac tablener, kapox dashten el en petq select anel tvyalner@ stanalu hamar
        $articles = $this->a_rep->get(['id','title', 'alias', 'created_at', 'img', 'desc','user_id', 'category_id'], False, config('settings.paginate'));

       //Query-neri optimizacia e ,, comentel u nayel AppServiceProvider->boot->DB functian-> commentac e
        if($articles){
            $articles->load('user', 'category', 'comments'); // kogni vercnel tvyalner irar het kapvac teble-neric(modelneric)
        }
        return $articles;
    }

    public function getComments($take){
        $comments = $this->c_rep->get(['text', 'name', 'email', 'site', 'article_id', 'user_id'], $take);

        if($comments){
            $comments->load('article', 'user'); // kogni vercnel tvyalner irar het kapvac teble-neric(modelneric)
        }
        return $comments;
    }

    public function getPortfolios($take){
        $portfolios = $this->p_rep->get(['title', 'text', 'alias', 'customer', 'img', 'filter_alias'], $take);
        return $portfolios;
    }
}
