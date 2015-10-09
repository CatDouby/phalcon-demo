<?php

/**
 * Created by PhpStorm.
 * User: sks
 * Date: 2015/10/9
 * Time: 16:54
 */

use Phalcon\Mvc\Controller;

class TestController extends Controller
{
    public function tsAction()
    {
        echo 'abcdef';
        die;
    }

}