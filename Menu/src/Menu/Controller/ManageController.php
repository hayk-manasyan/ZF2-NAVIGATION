<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ManageController
 *
 * @author hayk
 */

namespace Menu\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use \Exception;

class ManageController extends AbstractActionController {

    public function indexAction ()
    {
        $view = new ViewModel();
        $menuModel = $this->getServiceLocator ()->get ('MenuModel');
        $view->menuList = $menuModel->fetchMenus ();
        return $view;
    }

    public function createAction ()
    {
        $form = $this->getServiceLocator ()->get ('MenuForm');

        $viewModel = new ViewModel (array(
            'form' => $form,
        ));

        if ($this->request->isPost ()) {
            $postData = $this->request->getPost ();
            $form->setData ($postData);

            if (!$form->isValid ()) {
                $viewModel->error = true;
                return $viewModel;
            }

            $menuModel = new \Menu\Model\MenuModel();
            $menuModel->exchangeArray ($postData);
            $menuTable = $this->getServiceLocator ()->get ('MenuModel');
            try {
                $menuTable->save ($menuModel);
                return $this->redirect ()->toRoute (NULL, array('controller' => 'manage',
                        'action' => 'index'
                ));
            } catch (\Exception $ex) {
                $viewModel->error = true;
                $viewModel->errorMessage = $ex->getMessage ();
            }
        }

        return $viewModel;
    }

    public function editAction ()
    {
        $request = $this->request;
        $menu_id = $this->params ()->fromRoute ('id');
        $menuTable = $this->getServiceLocator ()->get ('MenuModel');
        $form = $this->getServiceLocator ()->get ('MenuForm');
        $viewModel = new ViewModel ();

        if ($request->isPost ()) {
            $post = $request->getPost ();
            try {
                $menu_id = $post['menu_id'];
                $menuData = $menuTable->fetchMenuById ($menu_id);

                if (null !== $menuData) {
                    $menuModel = new \Menu\Model\MenuModel();
                    $menuModel->exchangeArray ((array) $post);
                    $menuData = $menuModel;
                    unset ($menuModel);
                    $menuTable->save ($menuData);
                    return $this->redirect ()->toRoute (NULL, array('controller' => 'manage',
                                'action' => 'index'
                    ));
                } else {
                    $viewModel->error = TRUE;
                    $viewModel->errorMessage = 'The menu row not found!';
                }
            } catch (Exception $ex) {
                $viewModel->error = TRUE;
                $viewModel->errorMessage = $ex->getMessage ();
                return;
            }
        } else if (isset ($menu_id)) {
            $menuData = $menuTable->fetchMenuById ($this->params ()->fromRoute ('id'));
        } else {
            return $this->redirect ()->toRoute (NULL, array('controller' => 'manage',
                        'action' => 'index'
            ));
        }

        $form->setData ((array) $menuData);

        $viewModel->form = $form;

        return $viewModel;
    }

    public function deleteAction ()
    {
        $menu_id = $this->params ()->fromRoute ('id');


        if (null === $menu_id) {
            return $this->redirect ()->toRoute (NULL, array('controller' => 'manage',
                        'action' => 'index'
            ));
        }

        try {
            $childItems = $this->getServiceLocator ()->get ('MenuModel')->fetchChildMenusByMenuId ($menu_id);
            if (count ($childItems) === 0) {
                $this->getServiceLocator ()->get ('MenuModel')->deleteMenu ($menu_id);
                return $this->redirect ()->toRoute (NULL, array('controller' => 'manage', 'action' => 'index'));
            } else {
                $viewModel = new ViewModel ();
                $viewModel->errorMessage = "This menu item has child menu items, So you can't delete it.";
                return $viewModel;
            }
        } catch (Exception $ex) {
            var_dump ($ex->getMessage ());
            exit;
        }
    }

}
