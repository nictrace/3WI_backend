<?php

namespace Task;

class Module
{
    const VERSION = '3.0.3-dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap($e)
    {
        $application = $e->getApplication();
        $config      = $application->getConfig();
        $view        = $application->getServiceManager()->get('ViewHelperManager');
        // You must have these keys in you application config
//        $view->headTitle($config['view']['base_title']);

        // This is your custom listener
//        $listener   = new Listeners\ViewListener();
//        $listener->setView($view);
//        $listener->attach($application->getEventManager());
    }

}


?>
