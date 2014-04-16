<?php

namespace Store\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\TableGateway\TableGateway;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder as DoctrineAnnotationBuilder;
use Store\Form\OrderForm;
use Store\Entity\User;
use Store\Entity\Order;
use Store\Entity\Status;

use Zend\Mail;

class ProductController extends AbstractActionController {

    private $product;
    private $order;
    private $user;
    private $em;

    public function getEntityManager() {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }

    public function indexAction() {
        $id = $this->params()->fromRoute('id');
        if (!$id)
            return $this->redirect()->toRoute('store/default', array('controller' => 'index', 'action' => 'index'));




        //if user not logged in redirect to login url
        $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        if ($this->user = $auth->hasIdentity()) {
            $form = new OrderForm();
            $form->setHydrator(new DoctrineHydrator($this->getEntityManager(), 'Store\Entity\Order'));

            $c = 1;
            while ($c <= $this->getProduct($id)->instock) {
                $counts[$c] = $c;
                $c++;
            }
        }

        if (isset($form)) {
            return new ViewModel(array('product' => $this->getProduct($id), 'form' => $form, 'counts' => $counts));
        }
        else
            return new ViewModel(array('product' => $this->getProduct($id)));
    }

    public function orderAction() {
        //if user not logged in redirect to login url
        $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        if (!$auth->hasIdentity()) {
            return $this->redirect()->toRoute('store/default', array('controller' => 'login', 'action' => 'index'));
        }



        $request = $this->getRequest();
        if ($request->isPost()) {
            $em = $this->getEntityManager();
            
            
            $this->order = new Order();
            
                
            $this->order->populate($request->getPost());            
            
            $this->user = $auth->getIdentity();            
            if ($this->user->order($request->getPost()) === false) {                
               return new ViewModel(array('message' => 'Not Success'));
            }
            $this->product = $em->find('Store\Entity\Product', $this->order->productid);

            if ($this->product->update_instock($this->order->count) === false) {                
               exit();
            }
            

            $em->persist($this->user);
            $em->persist($this->product);
            $em->persist($this->order);

            $em->flush();
            
            

            $mail = new Mail\Message();
            $mail->setBody('Thank you for Order.');
            $mail->setFrom('slava.speedo@gmail.com', 'MyStore');
            $mail->addTo($this->user->email, $this->user->firstname . " " . $this->user->lastname);
            $mail->setSubject('Order ThankYou');

            $transport = new Mail\Transport\Sendmail();
            $transport->send($mail);
            

            $message = "Success";
        } 
        return new ViewModel(array('message' => isset($message)?$message:'Not posted'));
    }

    public function getProduct($id) {
        if (!$this->product) {
            $this->product = (new TableGateway(
                            'products',
                            $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter')
                    ))->select(array('id' => $id))->current();
            //$this->product=$products
        }
        return $this->product;
    }
}

?>
