<?php

namespace Task;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'api' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/api/customer[/:id]',
		    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                    ],
                ],
            ],

            'city' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/api/city[/:id]',
                    'defaults' => [
                        'controller' => Controller\CityRestController::class,

                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
	    Controller\CityRestController::class => InvokableFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'task/index/get' => __DIR__ . '/../view/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
