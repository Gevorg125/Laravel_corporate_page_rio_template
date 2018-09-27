<?php

namespace Corp\Http\Controllers;


use Illuminate\Http\Request;
use Corp\Menu;
use Illuminate\Support\Facades\Mail;
use Corp\Repositories\MenusRepository;
class ContactsController extends SiteController
{
    public function __construct() {
        parent::__construct(new MenusRepository(new Menu()));

        $this->template = env('THEME').  '.contacts';
        $this->bar = 'left';
    }

    public function index(Request $request){

        if($request->isMethod('post')){
            $messages = [
                'required' => ":attribute is required ",
                'email' => " :attribute Error type "
            ];

            $this->validate($request, [
                'name' => 'required|max:255',
                'email' => 'required|email',
                'message' => 'required'
            ], $messages);

            $data = $request->all();

            $result = Mail::to(env('THEME').'.email',['data' => $data], function($message) use ($data)  {
                $mail_admin = env('MAIL_ADMIN');
                $message->from($data['email'], $data['name']);
                $message->to($mail_admin, 'Mr.')->subject('Question');
            });

            if($result){
                return redirect()->route('contacts')->with('status', 'Email is sent'); //with()--session e
            }else {
                return redirect()->route('contacts')->with('status', 'Email is not sent'); //with()--session e
            }
            //mail


        }

        $this->title = 'Contacts';
        $content = view(env('THEME') . '.contact_content')->render();

        $this->contentLeftBar = view(env('THEME'). '.contact_bar')->render();
        $this->vars = array_add($this->vars, 'content', $content);
        return $this->renderOutput();
    }
}
