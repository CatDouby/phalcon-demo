<?php

use Phalcon\Loader;
use Phalcon\Tag;
use Phalcon\Mvc\Url;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\DI\FactoryDefault;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Session\Adapter\Files as Session;
use Phalcon\Events\Manager as EventsManager;


try {

    // Register an autoloader
    $loader = new Loader();
    $loader->registerDirs(
        array(
            '../app/controllers/',
            '../app/models/',
            '../app/plugins'
        )
    )->register();

    // Create a DI
    $di = new FactoryDefault();

    // Set the database service
    $di['db'] = function() {
        return new DbAdapter(array(
            "host"     => "localhost",
            "username" => "root",
            "password" => "123456",
            "dbname"   => "tutorial"
        ));
    };

    // Setting up the view component
    $di['view'] = function() {
        $view = new View();
        $view->setViewsDir('../app/views/');
        /*$view->registerEngines(array(
            ".volt" => 'Phalcon\Mvc\View\Engine\Volt'
        ));*/
        $view->registerEngines(array(
            ".phtml" => 'Phalcon\Mvc\View\Engine\Volt'
        ));
        return $view;
    };

    // Setup a base URI so that all generated URIs include the "tutorial" folder
    $di['url'] = function() {
        $url = new Url();
//        $url->setBaseUri('/tutorial/');
        $url->setBaseUri('/');
        return $url;
    };

    // Setup the tag helpers
    $di['tag'] = function() {
        return new Tag();
    };

    $di['session'] = function() {
        $session = new Session();
        $session->start();
        return $session;
    };

    // Setup the security plugin
    $di->set('dispatcher', function () {

        $eventsManager = new EventsManager;

        /* Check if the user is allowed to access certain action using the SecurityPlugin */
        $eventsManager->attach('dispatch:beforeDispatch', new SecurityPlugin);

        /* Handle exceptions and not-found exceptions using NotFoundPlugin */
//        $eventsManager->attach('dispatch:beforeException', new NotFoundPlugin);

        $dispatcher = new Dispatcher;
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    });

    // Handle the request
    $application = new Application($di);

    echo $application->handle()->getContent();

} catch (Exception $e) {
    echo "Exception: ", $e->getMessage();
}
