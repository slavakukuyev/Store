<?php

namespace CsnUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\TableGateway\TableGateway;

use CsnUser\Form\UserForm;
use CsnUser\Form\UserFilter;

class UserController extends AbstractActionController {

    private $usersTable;

    //R -retrieve   //CRUD
    public function indexAction() {
        return new ViewModel(array('rowset' => $this->getUsersTable()->select()));
    }

    public function createAction() {
        $form=new UserForm();
        $request=$this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter(new UserFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data=$form->getData();
                $this->getUsersTable()->insert($data);
            }
        }
        return new ViewModel(array('form'=>$form));
    }

    public function updateAction() {
        return new ViewModel();
    }

    public function deleteAction() {
        return new ViewModel();
    }

    public function getUsersTable() {
        if (!$this->usersTable) {
            $this->usersTable = new TableGateway(
                            'users',
                            $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter')
            );
        }

        return $this->usersTable;
    }

}

?>
