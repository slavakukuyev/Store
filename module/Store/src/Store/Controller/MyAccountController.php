<?php

namespace Store\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Store\Entity\User;
use Store\Entity\Address;
use Store\Entity\Product;
use Store\Entity\Status;
// Zend Annotation 
use Zend\Form\Annotation\AnnotationBuilder;
// for the form
use Zend\Form\Element;
use Store\Form\PersonalDetailsForm;
use Store\Form\PersonalDetailsFilter;
use Store\Form\AddressForm;
use Store\Form\AddressFilter;
use Store\Form\PasswordForm;
use Store\Form\PasswordFilter;
use Store\Form\DepositForm;
use Store\Form\DepositFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
// Doctrine Annotations
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder as DoctrineAnnotationBuilder;
use ZfcDatagrid\Column;
use ZfcDatagrid\Column\Type;
use ZfcDatagrid\Column\Style;
// Pagination
use DoctrineModule\Paginator\Adapter\Selectable as SelectableAdapter;
use Doctrine\Common\Collections\Selectable;
use Doctrine\Common\Collections\Criteria;
use Zend\Paginator\Paginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use DoctrineModule\Paginator\Adapter\Collection as Adapter;

class MyAccountController extends AbstractActionController {

    private $user;
    private $objectManager;
    private $address;
    private $cityTable;
    private $myDepositsTable;
    private $em;

    public function getEntityManager() {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }

    public function indexAction() {

        //if user not logged in redirect to login url
        $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        if (!$auth->hasIdentity()) {
            return $this->redirect()->toRoute('store/default', array('controller' => 'login', 'action' => 'index'));
        }

        $messageFromDeposit = null;
        $flashMessenger = $this->flashMessenger();
        if ($flashMessenger->hasMessages()) {
            foreach ($flashMessenger->getMessages() as $key => $value) {
                $messageFromDeposit .= $value;
            }
        }


        //Fill Personal Details form with data
        $em = $this->getEntityManager();
        $this->user = $auth->getIdentity();
        $pdform = new PersonalDetailsForm();
        $pdform->get('submit')->setValue('Edit Personal Details');
        $pdform->setHydrator(new DoctrineHydrator($em, 'Store\Entity\User'));
        $pdform->bind($this->user);
        $pdform->setData($this->user->getArrayCopy());
        //////////////////////////////////////////
        //Fill Address form if data exist
        $aform = new AddressForm();
        $aform->get('submit')->setValue('Edit Address');
        $aform->setHydrator(new DoctrineHydrator($em, 'Store\Entity\Address'));

        if ($this->user->addressid === null) {
            $this->address = new Address();
        } else {
            $this->address = $this->getEntityManager()->find('Store\Entity\Address', $this->user->addressid);
        }
        $aform->bind($this->address);
        $aform->setData($this->address->getArrayCopy());
        ///////////////////////////////////////////////////////////////////////
        //change password form
        $pform = new PasswordForm();


        $request = $this->getRequest();
        if ($request->isPost()) {
            //edit PD
            if ($request->getPost()['submit'] === "Edit Personal Details") {
                $pdform->setInputFilter(new PersonalDetailsFilter($this->getServiceLocator()));
                $pdform->setValidationGroup('firstname', 'lastname', 'birthdate');
                $pdform->setData($request->getPost());
                // echo "<h1>I am here1</h1>";
                if ($pdform->isValid()) {
                    $this->user->pd($request->getPost());
                    $em->persist($this->user);
                    $em->flush();
                    $message = "Your personal details have been successfully updated";
                }

                //edit user password
            } else if ($request->getPost()['submit'] === "Change Password") {
                $pform->setInputFilter(new PasswordFilter($this->getServiceLocator()));
                $pform->setValidationGroup('password', 'newPassword', 'confirmPassword');
                $pform->setData($request->getPost());
                if ($pform->isValid()) {
                    if (FALSE === $this->user->newPassword($request->getPost())) {
                        $message = "Your password NOT changed";
                    } else {
                        $em->persist($this->user);
                        $em->flush();
                        $message = "Your password has successfully updated";
                    }
                }
            }
            /////////////////////////////////
            //edit user address
            else {
                $aform->setInputFilter(new AddressFilter($this->getServiceLocator()));
                $aform->setValidationGroup('street', 'phone1', 'phone2');
                $aform->setData($request->getPost());
                if ($aform->isValid()){   
                    $this->address->populate($request->getPost());
                    $em->persist($this->address);
                    $em->flush();          
                    $adid=$em->getRepository('Store\Entity\Address')->findOneBy(array('userid' => $this->user->id))->id;                    
                    $this->user->addressid=$adid; 
                    $em->persist($this->user);                     
                    $em->flush();
                    
                    $message = "Your address has successfully updated";
                }
            }
            ///////////////////////////////////////////
        }

        return new ViewModel(array(
                    'message' => isset($message) ? $message : '',
                    'messageFromDeposit' => $messageFromDeposit,
                    'pdform' => $pdform,
                    'aform' => $aform,
                    'pform' => $pform,
                    'cityTable' => $this->getCityTable(),
                    'address'=>$this->address
                ));
    }

    //set select values
    public function getCityTable() {
        if (!$this->cityTable) {
            $table = $this->getObjectManager()->getRepository('\Store\Entity\City')->findAll();
            foreach ($table as $t) {
                $data[$t->id] = $t->name;
            }
            $this->cityTable = $data;
        }
        return $this->cityTable;
    }

    protected function getObjectManager() {
        if (!$this->objectManager) {
            $this->objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }

        return $this->objectManager;
    }

    public function depositAction() {

        //if user not logged in redirect to login url
        $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        if (!$auth->hasIdentity()) {
            return $this->redirect()->toRoute('store/default', array('controller' => 'login', 'action' => 'index'));
        }

         $message = null;
        $flashMessenger = $this->flashMessenger();
        if ($flashMessenger->hasMessages()) {
            foreach ($flashMessenger->getMessages() as $key => $value) {
                $message .= $value;
            }
        }
        
        $em = $this->getEntityManager();
        $this->user = $auth->getIdentity();

        if ($this->user->addressid === NULL) {
            $this->flashMessenger()->addMessage('Please update your addrees before deposit.');
            return $this->redirect()->toRoute('store/default', array('controller' => 'myaccount', 'action' => 'index'));
        }

        $deposit = new \Store\Entity\Deposit();
        $form = new DepositForm();
        $form->setHydrator(new DoctrineHydrator($em, 'Store\Entity\Deposit'));
        $form->bind($deposit);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter(new DepositFilter($this->getServiceLocator()));
            $form->setValidationGroup('amount', 'creditcard', 'cvv');
            $form->setData($request->getPost());
            if ($form->isValid()) {
                var_dump($request->getPost());
                $deposit->populate($request->getPost());
                $balance = $deposit->amount;
                $this->user->balance+=$balance;
                $em->persist($this->user);
                $em->persist($deposit);
                $em->flush();                 
                
                $this->flashMessenger()->addMessage("Thank you for your depositing!");
                 return $this->redirect()->toRoute('store/default', array('controller' => 'myaccount', 'action' => 'deposit'));
        
                
            }
        }


        return new ViewModel(array('message' => isset($message) ? $message : '', 
            'balance' => $this->user->balance, 'form' => $form, 
            //'deposits' => $this->getMyDeposits(),
            'paginator' => $this->getMyPaginatorCollection('Deposit'))); //, 'paginator' => $paginator));
    }

    private function getMyDeposits() {
        if (!$this->myDepositsTable) {
            $this->myDepositsTable = $this->getObjectManager()->getRepository('\Store\Entity\Deposit')->findBy(
                    array('id'=>$this->user->id), array('id' => 'DESC')
            );
        }
        return $this->myDepositsTable;
    }

    public function historyAction() {

        //if user not logged in redirect to login url
        $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        if (!$auth->hasIdentity()) {
            return $this->redirect()->toRoute('store/default', array('controller' => 'login', 'action' => 'index'));
        }

        $this->user = $auth->getIdentity();
        $message = "No records with Your Orders found";

        return new ViewModel(array('message' => $message, 'orders' => $this->getMyOrders($this->user->id)));
    }

    private $myOrdersTable;

    private function getMyOrders($id) {
        if (!$this->myOrdersTable) {
            $table = $this->getObjectManager()->getRepository('\Store\Entity\Order')->findBy(
                    array('userid' => $id), array('ordered' => 'DESC')
            );

            $count = sizeof($table);
            if ($count == 0) {
                return $this->myOrdersTable = $table;
            }

            foreach ($table as $t) {
                $em = $this->getEntityManager();
                $product = $em->find('Store\Entity\Product', $t->productid);
                $status = $em->find('Store\Entity\Status', $t->status);

                $element = array(
                    'num' => $count--,
                    'id' => $t->id,
                    'title' => $product->title,
                    'price' => $t->price,
                    'count' => $t->count,
                    'dt' => $t->ordered,
                    'status' => $status->status
                );
                $data[] = $element;
            }

            $this->myOrdersTable = $data;
        }
        return $this->myOrdersTable;
    }
    
     private function getMyPaginatorCollection($entity) {
         
         
        $em = $this->getEntityManager();        
        $criteria = Criteria::create()
    ->where(Criteria::expr()->eq("userid", $this->user->id))
                ->orderBy(array("deposited" => Criteria::DESC));        
        
        $adapter = new SelectableAdapter($em->getRepository('Store\\Entity\\' . $entity),$criteria);

        // Create the paginator itself
        $paginator = new Paginator($adapter);
        $page = 1;
        if ($this->params()->fromRoute('page'))
            $page = $this->params()->fromRoute('page');
        $paginator->setCurrentPageNumber((int) $page)
                ->setItemCountPerPage(5);
        return $paginator;
    }

}

?>
