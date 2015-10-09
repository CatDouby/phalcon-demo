<?php

use Phalcon\Mvc\Model;

class Ts extends Model
{
    public $a;

    public $b;

    // https://docs.phalconphp.com/zh/latest/reference/models.html

    public function onConstruct()
    {

    }

    public function beforeSave() {}

    public function afterSave() {}

    public function afterFetch() {}

    public function beforeCreate() {}

    public function beforeUpdate() {}


}