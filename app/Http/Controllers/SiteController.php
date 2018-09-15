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

    protected $template; //shablon
    protected $vars =[]; //the variables for the template

    protected $bar = FALSE; //will show if the is a sidebar( by default false)
    protected $ContentRightBar = FALSE;
    protected $ContentLestBar = FALSE;

    public function __construct(MenusRepository $m_rep){

        $this->m_rep = $m_rep;

    }

    protected function renderOutput(){

        $menu =$this->getMenu();

        $navigation = view(env('THEME').'.navigation')->with('menu', $menu)->render();
        $this->vars = array_add($this->vars, 'navigation', $navigation);
        return view($this->template)->with($this->vars);
    }

    protected function getMenu(){

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
