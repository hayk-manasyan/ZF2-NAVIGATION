<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Menu\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\HydratingResultSet;
use \Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Adapter\AdapterAwareInterface;
use Menu\Model\MenuModel;
use \Exception;

class Menu {

    protected $tableGateway;

    public function __construct (TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     *  - If menu_id is not setted insert data to db
     *  - Overwise update data  
     * 
     * @param MenuModel $menu
     * @throws Exception
     */
    public function save (MenuModel $menu)
    {
        $saveData = $menu->menuArr;
        $menu_id = $saveData['menu_id'];
        unset ($saveData['menu_id']);

        try {
            if (null === $menu_id) {
                $this->tableGateway->insert ($saveData);
            } else {
                $this->tableGateway->update ($saveData, array('menu_id' => $menu_id));
            }
        } catch (\Exception $ex) {
            var_dump ($ex->getMessage ());
            exit;
            throw new \Exception ('Could not save menu item ' . $menu);
        }
    }

    /**
     * Returns the list of menu items
     * 
     * @return null|object
     */
    public function fetchMenus ()
    {
        $resultSet = $this->tableGateway->select ();
        return $resultSet;
    }

    /**
     * Returns menu item row
     * 
     * @param int $menu_id
     * @return object
     * @throws Exception
     */
    public function fetchMenuById ($menu_id)
    {
        if (null === $menu_id) {
            throw new \Exception ("Row for inserted id not found!");
        }

        $resultSet = $this->tableGateway->select (array('menu_id' => $menu_id));
        $row = $resultSet->current ();

        if (!$row) {
            throw new \Exception ("Row for inserted id not found!");
        }

        return $row;
    }

    /**
     * Delete Menu item
     *  - If menu item has not child elements delete
     *  - Otherwise throw exception 
     * 
     * @param int $menu_id
     * @throws Exception
     */
    public function deleteMenu ($menu_id)
    {
        if (null === $menu_id) {
            throw new \Exception ("Row for inserted id not found!");
        }

        $this->tableGateway->delete (array('menu_id' => $menu_id));
    }

    /**
     * Returns child menu items for menu id
     * 
     * @param int $menu_id
     * @return obj ResultSet
     * @throws Exception
     */
    public function fetchChildMenusByMenuId ($menu_id)
    {
        if (null === $menu_id) {
            throw new \Exception ("Row for inserted id not found!");
        }

        $resultSet = $this->tableGateway->select (array('parent_menu_id' => $menu_id, 'parent_menu_id IS NOT NULL'));

        return $resultSet;
    }

    /**
     * Returns list of menu items which hasn't parment menu
     * 
     * @return null|obj
     */
    public function fetchParentMenus ()
    {
        $resultSet = $this->tableGateway->select (array('parent_menu_id IS NULL'));
        return $resultSet;
    }

}
