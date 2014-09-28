<?php

namespace Menu;


use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;
use Menu\Model\Menu;
use Menu\Model\MenuModel;

class Module implements AutoloaderProviderInterface {

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/', __NAMESPACE__),
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig()
    {
        return array(
            'initializers' => array(
                function ($instance, $sm) {
                    if ($instance instanceof \Zend\Db\Adapter\AdapterAwareInterface) {
                        $instance->setDbAdapter($sm->get('Zend\Db\Adapter\Adapter'));
                    }
                }
            ),
            'invokables' => array(
                 'menu' => 'Menu\Model\MenuTable'
            ),
            'factories' => array(
                'top_nav' => 'Menu\Navigation\NavigationFactory',
                // forms
                'MenuForm' => function ($sm) {
                    $form = new \Menu\Form\MenuForm(null, $sm);
                    return $form;
                },
                        
                // models
                'MenuModel' => function($sm) {
                    $tableGateway = $sm->get('MenuTableGateway');
                    $table = new Menu($tableGateway);
                    return $table;
                },
                'MenuTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new MenuModel ());
                    return new TableGateway('menu', $dbAdapter, null, $resultSetPrototype);
                }
            )
          );
    }

}
