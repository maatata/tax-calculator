<?php
namespace Tax;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\CountryTable::class => function($container) {
                    $countryTableGateway = $container->get(Model\CountryTableGateway::class); 
                    return new Model\CountryTable($countryTableGateway);
                },
                Model\CountryTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Country());
                    return new TableGateway('countries', $dbAdapter, null, $resultSetPrototype);
                },
                Model\StateTable::class => function($container) {
                    $stateTableGateway = $container->get(Model\StateTableGateway::class);
                    return new Model\StateTable($stateTableGateway);
                },
                Model\StateTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\State());
                    return new TableGateway('states', $dbAdapter, null, $resultSetPrototype);
                },
                Model\CountyTable::class => function($container) {
                    $countyTableGateway = $container->get(Model\CountyTableGateway::class);
                    return new Model\CountyTable($countyTableGateway);
                },
                Model\CountyTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\County());
                    return new TableGateway('counties', $dbAdapter, null, $resultSetPrototype);
                },
                Model\PaymentTable::class => function($container) {
                    $paymentTableGateway = $container->get(Model\PaymentTableGateway::class);
                    $countyTableGateway = $container->get(Model\CountyTableGateway::class);
                    return new Model\PaymentTable($paymentTableGateway, $countyTableGateway);
                },
                Model\PaymentTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Payment());
                    return new TableGateway('payments', $dbAdapter, null, $resultSetPrototype);
                },
                Model\DashboardTable::class => function($container) {
                    $countryTableGateway = $container->get(Model\CountryTableGateway::class); 
                    $stateTableGateway = $container->get(Model\StateTableGateway::class); 
                    $countyTableGateway = $container->get(Model\CountyTableGateway::class); 
                    return new Model\DashboardTable($countryTableGateway, $stateTableGateway, $countyTableGateway);
                },
            ],
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\CountryController::class => function($container) {
                    return new Controller\CountryController(
                        $container->get(Model\CountryTable::class)
                    );
                },
                Controller\StateController::class => function($container) {
                    return new Controller\StateController(
                        $container->get(Model\StateTable::class),
                        $container->get(Model\CountryTable::class)
                    );
                },
                Controller\CountyController::class => function($container) {
                    return new Controller\CountyController(
                        $container->get(Model\CountyTable::class),
                        $container->get(Model\StateTable::class)
                    );
                },
                Controller\PaymentController::class => function($container) {
                    return new Controller\PaymentController(
                        $container->get(Model\PaymentTable::class),
                        $container->get(Model\CountyTable::class)
                    );
                },
                Controller\DashboardController::class => function($container) {
                    return new Controller\DashboardController(
                        $container->get(Model\DashboardTable::class)
                    );
                },
            ],
        ];
    }
}