<?php
namespace Corp\Repositories;

use Corp\Article;

class ArticlesRepository extends Repository {

    public function __construct(Article $article) {
        $this->model = $article;
    }

    public function one($alias, $attribute =[]){
        $article = parent::one($alias, $attribute);

        if($article && !empty($attribute)){
            //kvercni article-i het kapvac commn\ent@
            $article->load('comments');


            //kveradarcni commenti het kapvac usernerin
            $article->comments->load('user');
        }

        return $article;
    }
}