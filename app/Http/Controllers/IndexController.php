<?php

namespace Corp\Http\Controllers;

use Corp\Menu;
use Corp\Repositories\ArticlesRepository;
use Corp\Repositories\MenusRepository;
use Corp\Repositories\PortfoliosRepository;
use Corp\Repositories\SlidersRepository;
use Illuminate\Http\Request;


class IndexController extends SiteController
{

    public function __construct(SlidersRepository $s_rep, PortfoliosRepository $p_rep, ArticlesRepository $a_rep) {
        parent::__construct(new MenusRepository(new Menu()));

        $this->a_rep = $a_rep;
        $this->s_rep = $s_rep;
        $this->p_rep = $p_rep;

        $this->template = env('THEME').  '.index';
        $this->bar = 'right';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $this->keywords = 'Home Page';
        $this->meta_desc = 'Home Page';
        $this->title = 'Home Page';

        $portfolios = $this->getPortfolio();
        $content = view(env('THEME') . '.content')->with('portfolios', $portfolios)->render();
        $this->vars = array_add($this->vars, 'content', $content);

        $sliderItems = $this->getSliders();
        $sliders = view(env('THEME') . '.slider')->with('sliders', $sliderItems)->render();
        $this->vars = array_add($this->vars, 'sliders', $sliders);

        $articles = $this->getArticle();
        $this->contentRightBar = view(env('THEME'). '.indexBar')->with('articles', $articles)->render();

        return $this->renderOutput();
    }

    public function getSliders(){
        $sliders = $this->s_rep->get();

        if($sliders->isEmpty()){
            return false;
        }
        $sliders->transform(function($item, $key){
            $item->img = 'slider-cycle'.'/'.$item->img;//slideri path@ grac e configi setting.php file-i mej

            return $item;
        });

        return $sliders;

    }

    protected function getPortfolio(){
        $portfolio = $this->p_rep->get('*', 5);


        return $portfolio;
    }

    protected function getArticle(){

        $article = $this->a_rep->get(['title', 'created_at', 'img', 'alias'], 3);
        return $article;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
