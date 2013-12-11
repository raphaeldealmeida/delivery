<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Application\Model\Produto;
use Application\Model\ProdutoTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module {

    public function onBootstrap(MvcEvent $e) {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig() {
        return array(
            
            //Inicializa o ProdutoTable        
            'factories' => array(
                'Application\Model\ProdutoTable' => function($sm) {
                    $tableGateway = $sm->get('ProdutoTableGateway');
                    $table = new ProdutoTable($tableGateway);
                    return $table;
                },
                        
                //Inicializa o TableGateway        
                'ProdutoTableGateway' => function ($sm) {
                    
                    // Carrega as configurações usando AdapterServiceFactory
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter'); 
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Produto());
                    return new TableGateway('produtos', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }

}
