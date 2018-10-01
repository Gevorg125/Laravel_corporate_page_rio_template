<?php

namespace Corp\Http\Controllers;


use Illuminate\Http\Request;
use Corp\Repositories\MenusRepository;


class SiteController extends Controller
{
    protected $p_rep; //for the saving logic of portfolio repository
    protected $s_rep; // for the slider repository
    protected $m_rep; //menu
    protected $a_rep; // articles
    protected $c_rep; //comments

    protected $template; //shablon
    protected $vars =[]; //the variables for the template

    protected $bar = 'no'; //will show if the is a sidebar( by default false)
    protected $contentRightBar = FALSE;
    protected $contentLeftBar = FALSE;

    protected $keywords; // keys
    protected $meta_desc; // metatags
    protected $title; //title tag

    public function __construct(MenusRepository $m_rep){

        $this->m_rep = $m_rep;

    }

    protected function renderOutput(){

        $menu =$this->getMenu();

        $navigation = view(env('THEME').'.navigation')->with('menu', $menu)->render();
        $this->vars = array_add($this->vars, 'navigation', $navigation);

        if($this->contentRightBar){
            $rightBar = view(env('THEME') . '.rightBar')->with('content_rightBar', $this->contentRightBar)->render();
            $this->vars = array_add($this->vars, 'rightBar', $rightBar);
        }

        if($this->contentLeftBar){
            $leftBar = view(env('THEME') . '.leftBar')->with('content_leftBar', $this->contentLeftBar)->render();
            $this->vars = array_add($this->vars, 'leftBar', $leftBar);
        }

        $this->vars = array_add($this->vars, 'bar', $this->bar);

        $footer = view(env('THEME').'.footer')->render();
        $this->vars = array_add($this->vars, 'footer', $footer);

        $this->vars = array_add($this->vars, 'keywords', $this->keywords);
        $this->vars = array_add($this->vars, 'meta_desc', $this->meta_desc);
        $this->vars = array_add($this->vars, 'title', $this->title);

        return view($this->template)->with($this->vars);
    }

    public function getMenu(){

        $menu = $this->m_rep->get();

        //Lavary extension
        // functiayin trvac $m argument@ callback e ayinqn da nuyn $mBuildern e
        $mBuilder = \Menu::make('MyNav', function($m) use ($menu){

            foreach($menu as $item){

                if($item->parent_id == 0){
                    $m->add($item->title, $item->path)->id($item->id);//id()-i functian ksarqi id
                }else {
                    if($m->find($item->parent_id)){
                        $m->find($item->parent_id)->add($item->title, $item->path)->id($item->id);
                    }
                }
            }
        });

        return $mBuilder;
    }

}
