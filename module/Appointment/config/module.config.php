<?php

use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\Router\Http\Segment;
use Appointment\Controller\AppointmentController;

return array(
    //Controllers used in this module
    'controllers' => array(
        'factories' => array(
            Controller\AppointmentController::class => InvokableFactory::class,
        ),
    ),
    //Handles routes in this module
    'router' => array(
        'routes' => array(
            'appointment' => array(
                'type'    => Segment::class,
                'options' => array(
                    //The structure of the route will define its action.
                    'route'    => '/appointment[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => AppointmentController::class,
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'appointment' => __DIR__ . '/../view',
        ),
    ),
);