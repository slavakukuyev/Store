<?php



namespace Store\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\TableGateway\TableGateway;
use Store\Entity\User; 
use Store\Form\LoginForm;
use Store\Form\LoginFilter;


class IndexController extends AbstractActionController {    
 private $productsTable;
 private $categoriesTable;

    //R -retrieve   //CRUD
    public function indexAction() {
        $id=$this->params()->fromRoute('id');  
        $greetingSrv = $this->getServiceLocator()->get('greetingService'); 
        $hello=$greetingSrv->getMyStoreGreeting();
        if(!$id)
        return new ViewModel(array('hello'=>$hello,
                                   'rowset' => $this->getProductsTable()->select(array('instock >= ?' => '1')),
                                   'categories'=>$this->getCategoriesTable()->select()));
        
        
        else return new ViewModel(array('hello'=>$hello,
                                        'rowset' => $this->getProductsTableByCategory($id), 
                                        'categories'=>$this->getCategoriesTable()->select(),
                                        'activecategory'=>$id
                ));
            
    }
    
    public function getProductsTableByCategory($id) {
        $this->productsTable = (new TableGateway(
                            'products',
                            $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter')
            ))->select(array('categoryid'=>$id, 'instock >= ?'=>'1'));
        return $this->productsTable;
    }
    
    public function getProductsTable() {
        if (!$this->productsTable) {
            $this->productsTable = new TableGateway(
                            'products',
                            $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter')
            );
        }

        return $this->productsTable;
    }
    
    function getCategoriesTable() {
         if (!$this->categoriesTable) {
            $this->categoriesTable = new TableGateway(
                            'categories',
                            $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter')
            );
        }

        return $this->categoriesTable;
    }

}

?>
