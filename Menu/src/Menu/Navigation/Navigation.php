<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MyNavigation
 *
 * @author hayk
 */

namespace Menu\Navigation;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Navigation\Service\DefaultNavigationFactory;
use \Exception;

class Navigation extends DefaultNavigationFactory {

    protected function getPages (ServiceLocatorInterface $serviceLocator)
    {


        if (null === $this->pages) {
            //FETCH data from table menu :
            $fetchMenu = $serviceLocator->get ('menu')->fetchAll ();

            $container = new \Zend\Navigation\Navigation();

            foreach ($fetchMenu as $key => $row) {
                if (null !== $row['parent_menu_id']) {
                    continue;
                }

                $container->addPage (array(
                    'id' => $row['menu_id'],
                    'label' => $row['label'],
                    'uri' => $row['uri'],
                    'icon' => $row['icon'],
                ));


                $i = 0;
                $menu_items = $fetchMenu;
                foreach ($menu_items as $item_key => $item) {
                    if ($item['parent_menu_id'] === null) {
                        continue;
                    }

                    if ($row['menu_id'] === $item['parent_menu_id']) {
                        $subPage = array(
                            'id' => $item['menu_id'],
                            'label' => $item['label'],
                            'icon' => $item['icon'],
                        );
                        if (null !== $item['uri']) {
                            $subPage['uri'] = $item['uri'];
                        } else if (null !== $item['route']) {
                            $subPage['route'] = $item['route'];
                        }
                        $container->findBy ('id', $row['menu_id'])->addPage ($subPage);
                        $i++;
                        unset ($fetchMenu[$item_key]);
                    }
                }
                if ($i === 0) {
                    if (null !== $row['uri']) {
                        $container->findBy ('id', $row['menu_id'])->setUri ($row['uri']);
                    } else if (null !== $row['route']) {
                        $container->findBy ('id', $row['menu_id'])->setUri ($row['uri']);
                    }
                    unset ($fetchMenu[$key]);
                }
            }

            $this->pages = $container;
        }
        return $this->pages;
    }

}
