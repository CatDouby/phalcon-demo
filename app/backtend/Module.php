<?php
/**
 * Created by PhpStorm.
 * User: sks
 * Date: 2015/10/9
 * Time: 16:10
 */

namespace Multiple\Frontend;

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\ModuleDefinitionInterface;


class Module implements ModuleDefinitionInterface
{

    /**
     * 注册自定义加载器
     */
    public function registerAutoloaders()
    {

        $loader = new Loader();

        $loader->registerNamespaces(
            array(
                'Multiple\Backend\Controllers' => '../backend/controllers/',
                'Multiple\Backend\Models'      => '../backend/models/',
            )
        );

        $loader->register();
    }

    /**
     * 注册自定义服务
     */
    public function registerServices($di)
    {

        // Registering a dispatcher
        $di->set('dispatcher', function () {
            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace("Multiple\Backend\Controllers");
            return $dispatcher;
        });

        // Registering the view component
        $di->set('view', function () {
            $view = new View();
            $view->setViewsDir('../apps/backend/views/');
            return $view;
        });
    }

}