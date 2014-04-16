<?php

namespace Store\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Store\Entity\User;
// Zend Annotation 
use Zend\Form\Annotation\AnnotationBuilder;
// for the form
use Zend\Form\Element;
use Store\Form\RegistrationForm;
use Store\Form\RegistrationFilter;
use Store\Form\ForgottenPasswordForm;
use Store\Form\ForgottenPasswordFilter;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
// Doctrine Annotations
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder as DoctrineAnnotationBuilder;

use Zend\Mail;
use Zend\Mime\Part as MimePart;  
use Zend\Mime\Message as MimeMessage;  

class RegistrationController extends AbstractActionController {

    private $em;

    public function getEntityManager() {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }

    public function indexAction() {

        $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        if ($auth->hasIdentity()) {
            return $this->redirect()->toRoute('store/default', array('controller' => 'index', 'action' => 'index'));
        }
        $entityManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        $form = new RegistrationForm();
        $form->get('submit')->setValue('Register');
        $form->setHydrator(new DoctrineHydrator($entityManager, 'Store\Entity\User'));
        $user = new User();
        $request = $this->getRequest();
        if ($request->isPost()) {

            $form->setInputFilter(new RegistrationFilter($this->getServiceLocator()));
            $form->setData($request->getPost());
            if ($form->isValid()) {

                $user->populate($form->getData());
                $password=$form->getData()['password'];
                $this->preparePassword($user);
                //$this->sendConfirmationEmail($user);
                //$this->flashMessenger()->addMessage($user->getUsrEmail());
                $entityManager->persist($user);
                $entityManager->flush();
                echo 'send';
                $this->sendConfirmationMail($user->email, $user->firstname . ' ' . $user->lastname, $password);
                 $this->flashMessenger()->addMessage($user->email);
                
                return $this->redirect()->toRoute('store/default', array('controller' => 'registration', 'action' => 'registration-success'));
            }
        }
        return new ViewModel(array('form' => $form));
    }
    
    private function sendConfirmationMail($email, $name, $password){
        
        
        
        $view = new ViewModel(array('title'=>'confirmation','email'=>$email, 'name'=>$name, 'password'=>$password));
        $view->setTemplate('store/email/confirmation');     
        $renderer = $this->getServiceLocator()->get('ViewRenderer');  
        $content = $renderer->render($view);  
        
        
        $html = new MimePart($content);  
        $html->type = "text/html";  
        $body = new MimeMessage();  
        $body->setParts(array($html,));  
        
        
         $mail = new Mail\Message();    
            $mail->setBody($body);
            $mail->setFrom('slava.speedo@gmail.com', 'MyStore');
            $mail->addTo($email, $name);
            $mail->setSubject('Confirmation Mail');

            $transport = new Mail\Transport\Sendmail();
            $transport->send($mail);
    }
    

    private function preparePassword($user) {
        $password = md5($user->email . $user->password . $user->registered);
        $user->password = $password;
        return $user;
    }

    public function registrationSuccessAction() {
        $email = null;
                $flashMessenger = $this->flashMessenger();
                if ($flashMessenger->hasMessages()) {
                        foreach($flashMessenger->getMessages() as $key => $value) {
                                $email .=  $value;
                        }
                }
                return new ViewModel(array('email' => $email));
    }

    public function forgottenPasswordAction() {
        $form = new ForgottenPasswordForm();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter(new ForgottenPasswordFilter($this->getServiceLocator()));
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $form->getData();                
                $em = $this->getEntityManager();                
                $user = $em->getRepository('Store\Entity\User')->findOneBy(array('email' => $data['email'])); // 
                $password = $this->generatePassword();
                $user->password=$password;
                $this->preparePassword($user);
                $em->persist($user);
                $em->flush();
                
                $this->sendPasswordByEmail($user->email,$user->firstname . " " . $user->lastname, $password);
                $this->flashMessenger()->addMessage($user->email);
                return $this->redirect()->toRoute('store/default', array('controller' => 'registration', 'action' => 'password-change-success'));
            }
        }
        return new ViewModel(array('form' => $form));
    }

    
    
    private function generatePassword() {
        $length = 6;
        $level = 2;
        list($usec, $sec) = explode(' ', microtime());
        srand((float) $sec + ((float) $usec * 100000));

        $validchars[1] = "0123456789abcdfghjkmnpqrstvwxyz";
        $validchars[2] = "0123456789abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $validchars[3] = "0123456789_!@#$%&*()-=+/abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_!@#$%&*()-=+/";

        $password = "";
        $counter = 0;

        while ($counter < $length) {
            $actChar = substr($validchars[$level], rand(0, strlen($validchars[$level]) - 1), 1);

            // All character must be different
            if (!strstr($password, $actChar)) {
                $password .= $actChar;
                $counter++;
            }
        }

        return $password;
    }
    
    private function sendPasswordByEmail($email, $name, $password){
            $mail = new Mail\Message();
            $mail->setBody('There is your new password: '.$password);
            $mail->setFrom('slava.speedo@gmail.com', 'MyStore');
            $mail->addTo($email, $name);
            $mail->setSubject('New Password');

            $transport = new Mail\Transport\Sendmail();
            $transport->send($mail);
    }
    
    public function passwordChangeSuccessAction()
        {
                $email = null;
                $flashMessenger = $this->flashMessenger();
                if ($flashMessenger->hasMessages()) {
                        foreach($flashMessenger->getMessages() as $key => $value) {
                                $email .=  $value;
                        }
                }
                return new ViewModel(array('email' => $email));
        }        

}

?>
