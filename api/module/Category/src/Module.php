<?php
namespace Category;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module implements ConfigProviderInterface {

  public function getConfig() {
        return include __DIR__ . '/../config/module.config.php';
  }

  public function getServiceConfig() {
        return [
            'factories' => [
                Model\CategoryTable::class => function($container) {
                    $tableGateway = $container->get(Model\CategoryTableGateway::class);
                    return new Model\CategoryTable($tableGateway);
                },
                Model\CategoryTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Category());
                    return new TableGateway('category', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
  }

  public function getControllerConfig() {
      return [
          'factories' => [
              Controller\CategoryController::class => function($container) {
                  return new Controller\CategoryController(
                      $container->get(Model\CategoryTable::class)
                  );
              },
          ],
      ];
  }
}
