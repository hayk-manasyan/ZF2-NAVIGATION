<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MenuModel
 *
 * @author hayk
 */

namespace Menu\Model;

class MenuModel {

    public $menu_id;
    public $name;
    public $label;
    public $uri;
    public $route;
    public $icon;
    public $parent_menu_id;
    public $menuArr = array();

    public function exchangeArray ($data)
    {

        $this->menu_id = !empty ($data['menu_id']) ? $data['menu_id'] : null;
        $this->name = !empty ($data['name']) ? $data['name'] : null;
        $this->label = !empty ($data['label']) ? $data['label'] : null;
        $this->uri = !empty ($data['uri']) ? $data['uri'] : null;
        $this->route = !empty ($data['route']) ? $data['route'] : null;
        $this->icon = !empty ($data['icon']) ? $data['icon'] : null;
        $this->parent_menu_id = !empty ($data['parent_menu_id']) ? $data['parent_menu_id'] : null;

        $this->menuArr = array(
            'menu_id' => $this->menu_id,
            'name' => $this->name,
            'label' => $this->label,
            'uri' => $this->uri,
            'route' => $this->route,
            'icon' => $this->icon,
            'parent_menu_id' => $this->parent_menu_id,
        );
        
        return TRUE;
    }

}
