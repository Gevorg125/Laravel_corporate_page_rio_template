<?php

namespace Corp\Http\Controllers;

use Corp\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Corp\Comment;
class CommentController extends SiteController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $data = $request->except('_token','comment_post_ID','comment_parent');
        $data['article_id'] = $request->input('comment_post_ID');
        $data['parent_id'] = $request->input('comment_parent');

        $validator = Validator::make($data,[
            'article_id' => 'integer|required',
            'parent_id' => 'integer|required',
            'text' => 'string|required',
        ]);

        $validator->sometimes(
                            ['name', 'email'],
                            'required|max:255',
                            function($input){
                                    return !Auth::check();
                        });
        if($validator->fails()){
            return Response::json(['error' => $validator->errors()->all()]);
        }

        $user = Auth::user();

        $comment = new Comment($data);

        if($user){
            $comment->user_id = $user->id;
        }

        $post = Article::find($data['article_id']);
        $post->comments()->save($comment);// comments functian grac e Article modeli mej mek@ shatin kapi hamar

        $comment->load('user');
        $data['id'] = $comment->id; // $comment->id-n last id-n e

        //ete grancvac user e kvercnenq useri email@, ete grancvac che kvercnenq en email@ vor@ lracrel e comment greluc,,, grancvac userneri hamar email lracnel petq che
        $data['email'] = (!empty($data['email'])) ? $data['email'] : $comment->user->email;
        $data['name'] = (!empty($data['name'])) ? $data['name'] : $comment->user->name;

        $data['hash'] = md5($data['email']); // avatarki hamar gravatar url-in uxxarkelu hamar

        //kstexcvi arandzin commenti view,, klracvi nor grvac commentov, u kcucadrvi commentneri mej
        $view_comment = view(env('THEME') . '.content_one_comment')->with('data', $data)->render();

        return Response::json(['success' => True, 'comment' => $view_comment, 'data' => $data]);
        exit();

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
