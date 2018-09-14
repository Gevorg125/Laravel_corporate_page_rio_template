<?php
namespace Corp\Repositories;

use Illuminate\Support\Facades\Config;

abstract class Repository {

    protected $model = False; //the object of the Model

    public function get(){

        $builder = $this->model->select('*');

        return $builder->get();
    }
}