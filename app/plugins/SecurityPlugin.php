<?php

/**
 * Created by PhpStorm.
 * User: sks
 * Date: 2015/9/9
 * Time: 17:03
 */

use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;

class SecurityPlugin extends Plugin
{
    /// hook
    public function beforeDispatch(Event $event, Dispatcher $dispatcher)
    {
//        echo $event->getType();//die;
//        print_r(get_class_methods($event));
    }
}