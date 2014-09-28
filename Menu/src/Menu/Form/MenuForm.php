<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Menu
 *
 * @author hayk
 */

namespace Menu\Form;

use Zend\Form\Form;
use Zend\From\Element as ELEMENT;

class MenuForm extends Form {

    public function __construct ($name = null, $sm)
    {
        parent::__construct ('MenuForm');
        $this->setAttribute ('method', 'post');
        $this->setAttribute ('enctype', 'multipart/form-data');

        $menu_id = new \Zend\Form\Element\Hidden ('menu_id');
        $this->add ($menu_id);

        $menu_name = new \Zend\Form\Element\Text ('name', array(
            'label' => 'Menu Name',
        ));
        $menu_name->setAttributes (array(
            'placeholder' => 'Menu Name...',
            'required' => 'required',
            'class' => 'form-control',
            'min' => 3,
            'max' => 50,
        ));

        $this->add ($menu_name);



        $label = new \Zend\Form\Element\Text ('label', array(
            'label' => 'Label',
        ));
        $label->setAttributes (array(
            'placeholder' => 'Label...',
            'required' => 'required',
            'class' => 'form-control',
            'min' => 3,
            'max' => 50,
        ));

        $this->add ($label);

        $uri = new \Zend\Form\Element\Text ('uri', array(
            'label' => 'Uri',
        ));
        $uri->setAttributes (array(
            'placeholder' => 'Uri...',
            'required' => 'required',
            'class' => 'form-control',
            'min' => 1,
            'max' => 50,
        ));

        $this->add ($uri);

        $route = new \Zend\Form\Element\Text ('route', array(
            'label' => 'Route',
        ));
        $route->setAttributes (array(
            'placeholder' => 'Route...',
            'class' => 'form-control',
            'max' => 50,
        ));

        $this->add ($route);

        $parent_menu = new \Zend\Form\Element\Select ('parent_menu_id', array(
            'label' => 'Parent Menu'
        ));

        $parent_menu->setAttributes (array(
            'class' => 'form-control',
        ));


        $parent_options = array(
            '0' => 'None',
        );

        $parentMenus = $sm->get ('MenuModel')->fetchParentMenus ();
        if (0 !== count ($parentMenus)) {
            foreach ($parentMenus as $key => $menu) {

                $parent_options[$menu->menu_id] = $menu->name;
            }
        }
        unset ($parentMenus);
        $parent_menu->setValueOptions ($parent_options);

        $this->add ($parent_menu);

        $icon = new \Zend\Form\Element\Text ('icon', array(
            'label' => 'Icon',
        ));
        $icon->setAttributes (array(
            'placeholder' => 'Icon...',
            'class' => 'form-control',
            'max' => 50,
        ));

        $this->add ($icon);

        $this->add (array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Create',
                'class' => 'btn btn-primary col-xs-12'
            ),
        ));
    }

}
