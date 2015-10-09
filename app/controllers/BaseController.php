<?php

/**
 * Created by PhpStorm.
 * User: sks
 * Date: 2015/10/9
 * Time: 15:31
 */
use Phalcon\Mvc\Controller;

class BaseController extends Controller
{
    protected function initialize()
    {
        $uri = $this->request->getURI();

        $this->view->uri = $uri;
    }
}