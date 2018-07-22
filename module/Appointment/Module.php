<?php

namespace Appointment;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Appointment\Model\Appointment;
use Appointment\Model\AppointmentTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\AdapterInterface;


 class Module implements AutoloaderProviderInterface, ConfigProviderInterface
 {
    /**
     * getAutoloaderConfig gets called by the application
    */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * returns the config
    */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * returns the configs for the service
     */
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                Model\AppointmentTable::class => function($container) {
                    $tableGateway = $container->get(Model\AppointmentTableGateway::class);
                    return new Model\AppointmentTable($tableGateway);
                },
                Model\AppointmentTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Appointment());
                    return new TableGateway('appointment', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }

    /**
     * returns the configs for the controllers
     */
    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\AppointmentController::class => function($container) {
                    return new Controller\AppointmentController(
                        $container->get(Model\AppointmentTable::class)
                    );
                },
            ],
        ];
    }
 }