<?php
/**
 * Description of NavigationFactory
 *
 * @author Hayk
 */

namespace Menu\Navigation;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class NavigationFactory implements FactoryInterface {

    public function createService (ServiceLocatorInterface $serviceLocator)
    {
        $navigation = new Navigation();
        return $navigation->createService ($serviceLocator);
    }

}
