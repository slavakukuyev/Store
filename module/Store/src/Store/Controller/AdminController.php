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
use Store\Form\EditUserForm;
use Store\Form\EditUserFilter;
use Store\Form\ProductForm;
use Store\Form\UploadForm;
use Store\Form\ProductFilter;
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
use Doctrine\Common\Collecttions\Criteria as DoctrineCriteria; // for criteria
use Zend\Paginator\Paginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use DoctrineModule\Paginator\Adapter\Collection as Adapter;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use ZfcDatagrid\Column\DataPopulation\Object;

class AdminController extends AbstractActionController {

    private $em;
    private $objectManager;
    private $cityTable;
    protected $categories;

    public function indexAction() {
        $this->check_is_admin();


        return new ViewModel(array(
                    'count_allusers' => $this->get_count_allrows('User'),
                    'count_allorders' => $this->get_count_allrows('Order'),
                    'count_allproducts' => $this->get_count_allrows('Product'),
                    'top_depositor' => $this->get_top_depositor(),
                    'top_orderer' => $this->get_top_orderer(),
                ));
    }

    private function get_count_allrows($entity) {
        $qb = $this->getEntityManager()->createQueryBuilder()
                ->select('count(u.id)')
                ->from('Store\\Entity\\' . $entity, 'u');
        return $qb->getQuery()->getSingleScalarResult();
    }

    
    
    private function get_top_orderer() {


//        $q = "SELECT o.userid, 
//       COUNT(o.userid) AS orderscount 
//FROM   Store\Entity\Order o
//GROUP  BY o.userid
//HAVING COUNT(o.userid) = (SELECT COUNT(ord.userid)
//                             FROM    Store\Entity\Order  ord
//                             GROUP  BY ord.userid
//                             ORDER  BY COUNT(ord.userid) DESC 
//                             LIMIT 1)";
        //query after equal sign
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select($qb->expr()->count('o.userid'))
                ->from('Store\Entity\Order', 'o')
                ->groupBy('o.userid')
                ->orderBy('o.userid', 'DESC')
                ->setMaxResults(1);
        $count = $qb->getQuery()->getSingleResult()['1'];
        //query before equal sign
        $qb2 = $this->getEntityManager()->createQueryBuilder();
        $qb2->select('o.userid')
                ->from('Store\Entity\Order', 'o')
                ->groupBy('o.userid')
                ->having($qb2->expr()->eq($qb2->expr()->count('o.userid'), $count))->setMaxResults(1);
        $userid = $qb2->getQuery()->getSingleResult()['userid'];
        $user = $this->getEntityManager()->find('Store\Entity\User', $userid);


        return array('user' => $user, 'count' => $count);
    }

    private function get_user($id) {
        
    }

    protected function get_top_depositor() {


        //$q="SELECT userid, SUM(amount) FROM deposit GROUP BY userid ORDER BY SUM(amount) DESC LIMIT 1";
        $query = $this->getEntityManager()->createQuery('SELECT d.userid, SUM(d.amount) as maxdeposit FROM Store\Entity\Deposit d GROUP BY d.userid ORDER BY maxdeposit DESC')->setMaxResults(1);
        return $query->getResult();
    }

    public function usersAction() {
        $message = $this->get_flash_message();
        return new ViewModel(array('paginator' => $this->getPaginatorCollectionAll('User'),
                    'message' => $message != null ? $message : ''));
    }

    public function ordersAction() {
        $message = $this->get_flash_message();
        return new ViewModel(array('paginator' => $this->getPaginatorCollectionAll('Order'),
                    'message' => $message !== null ? $message : ''));
    }

    public function productsAction() {
        /* @var $dataGrid \ZfcDatagrid\Datagrid */
        $dataGrid = $this->getServiceLocator()->get('zfcDatagrid');
        $dataGrid->setTitle('Products');
        $dataGrid->setDefaultItemsPerPage(5);
        //$dataGrid->setRowClickLink('/zfcDatagrid/example/edit');
        $dataGrid->setDataSource($this->getProductsArray()); {
            $colid = new Column\Standard('id');
            $colid->setIdentity();
            $dataGrid->addColumn($colid);
        } {
            /**
             * Gravatar example
             * - take the email from the datasource
             * - object makes the rest :-)
             *
             * @note Could be whatever you want -> Grab data from everywhere you want with dynamic parameters :-)
             */
            $colimage = new Column\Standard('image');
            $colimage->setIdentity();
            $dataGrid->addColumn($colimage);

            $dataPopulation = new Column\DataPopulation\Object();
            $dataPopulation->setObject(new Column\DataPopulation\Object\Gravatar());
            $dataPopulation->addObjectParameterColumn('image', $colimage);

            $col = new Column\ExternalData('image');
            $col->setLabel('Image');
            $col->setType(new Type\Image());
            $col->setDataPopulation($dataPopulation);
            $dataGrid->addColumn($col);
        } {
            $col = new Column\Standard('brand');
            $col->setLabel('Brand');
            $col->setWidth(10);
            $col->setSortDefault(1, 'ASC');
            $col->addStyle(new Style\Bold());
            $dataGrid->addColumn($col);
        } {
            $col = new Column\Standard('title');
            $col->setLabel('Title');
            $col->setWidth(15);
            $dataGrid->addColumn($col);
        } {


            $col = new Column\Standard('description');
            $col->setLabel('Description');
            $col->setWidth(50);
            $col->setSortDefault(2, 'DESC');
            $dataGrid->addColumn($col);
        } {
            $col = new Column\Standard('price');
            $col->setLabel('Price');
            $col->setWidth(10);
            $col->setSortDefault(2, 'DESC');
            $dataGrid->addColumn($col);
        } {

            $col = new Column\Standard('categoryid');
            $col->setLabel('Category');
            $col->setWidth(10);
            $col->setSortDefault(2, 'DESC');
            $dataGrid->addColumn($col);
        } {
            $col = new Column\Standard('instock');
            $col->setLabel('InStock');
            $col->setWidth(10);
            $col->setSortDefault(2, 'DESC');
            $dataGrid->addColumn($col);
        }

        $action = new Column\Action\Button();
        $action->setLabel('Edit');
        $action->setAttribute('href', $this->url()->fromRoute('store/default', array('controller' => 'admin', 'action' => 'edit-product', 'id' => $action->getRowIdPlaceholder(''))));
        $col = new Column\Action();
        $col->addAction($action);

        $dataGrid->addColumn($col);



        //$dataGrid->addColumn($colid);
//        $col = new Column\Standard('gender');
//        $col->setLabel('Gender');
//        $col->setWidth(10);
//        $col->setReplaceValues(array(
//            'm' => 'male',
//            'f' => 'female'
//        ));
//        $col->setTranslationEnabled(true);
//        $dataGrid->addColumn($col); {
//            $col = new Column\Standard('age');
//            $col->setLabel('Age');
//            $col->setWidth(5);
//            $col->setType(new Type\Number());
//
//            //$style = new Style\Color\Red();
//            // $style->setByValue($col, 20);
//            //$col->addStyle($style);
//
//            $dataGrid->addColumn($col);
//        } {
//            $colType = new Type\Number();
//            $colType->addAttribute(\NumberFormatter::FRACTION_DIGITS, 2);
//            $colType->setSuffix(' kg');
//
//            $col = new Column\Standard('weight');
//            $col->setLabel('Weight');
//            $col->setWidth(10);
//            $col->setType($colType);
//            $dataGrid->addColumn($col);
//        }
        //$this->getCategoryName()
//        $col = new Column\Standard('birthday');
//        $col->setLabel('Birthday');
//        $col->setWidth(10);
//        $col->setType(new Type\DateTime());
//        $col->setUserSortDisabled(true);
//        $dataGrid->addColumn($col); {
//            
//            $colType = new Type\DateTime('Y-m-d H:i:s', \IntlDateFormatter::MEDIUM, \IntlDateFormatter::MEDIUM);
//            $colType->setSourceTimezone('Europe/Vienna');
//            $colType->setOutputTimezone('UTC');
//
//            $col = new Column\Standard('changeDate');
//            $col->setLabel('Last change');
//            $col->setWidth(15);
//            $col->setType($colType);
//            $dataGrid->addColumn($col);
        //}

        $dataGrid->execute();

        return $dataGrid->getResponse();
    }

//    User's manipulation
    public function createUserAction() {
        return new ViewModel(array());
    }

    public function editUserAction() {
        $this->check_is_admin();
        $id = $this->params()->fromRoute('id');
        $em = $this->getEntityManager();
        $user = $em->find('Store\Entity\User', $id);

        $uform = new EditUserForm();

        $uform->setHydrator(new DoctrineHydrator($em, 'Store\Entity\User'));
        $uform->bind($user);
        $uform->setData($user->getArrayCopy());
        //////////////////////////////////////////
        //Fill Address form if data exist
        $aform = new AddressForm();
        $aform->get('submit')->setValue('Edit Address');
        $aform->setHydrator(new DoctrineHydrator($em, 'Store\Entity\Address'));

        if ($user->addressid === null) {
            $address = new Address();
        } else {
            $address = $em->find('Store\Entity\Address', $user->addressid);
        }
        $aform->bind($address);
        $aform->setData($address->getArrayCopy());
        ///////////////////////////////////////////////////////////////////////



        $request = $this->getRequest();
        if ($request->isPost()) {
            //edit PD
            if ($request->getPost()['submit'] === "Edit") {
                $uform->setInputFilter(new EditUserFilter($this->getServiceLocator()));
                $uform->setValidationGroup('firstname', 'lastname', 'birthdate');
                $uform->setData($request->getPost());
                if ($uform->isValid()) {
                    $user->pd($request->getPost());
                    $em->persist($user);
                    $em->flush();
                    $message = "User's personal details have been successfully updated";
                }
            } else {
                $aform->setInputFilter(new AddressFilter($this->getServiceLocator()));
                $aform->setValidationGroup('street', 'phone1', 'phone2');
                $aform->setData($request->getPost());
                if ($aform->isValid()) {

                    $address->populate($request->getPost());
                    $em->persist($address);
                    $em->flush();
                    $user->addressid = $em->getRepository('Store\Entity\Address')->findOneBy(array('userid' => $id))->id;
                    $em->persist($user);
                    $em->flush();
                    $message = "User's address has  been successfully updated";
                }
            }
        }
        return new ViewModel(array(
                    'message' => isset($message) ? $message : '',
                    'uform' => $uform,
                    'aform' => $aform,
                    'userid' => $id,
                    'cityTable' => $this->getCityTable()));
    }

    public function deleteUserAction() {
        $this->check_is_admin();
        $id = $this->params()->fromRoute('id');
        $em = $this->getEntityManager();
        $user = $em->find('Store\Entity\User', $id);
        if ($user->enabled == '0') {
            $this->flashMessenger()->addMessage('User with (' . $user->email . ' login) already blocked');
            return $this->redirect()->toRoute('store/default', array('controller' => 'admin', 'action' => 'users'));
        }
        $user->enabled = '0';
        $em->persist($user);
        $em->flush();
        $this->flashMessenger()->addMessage('User with (' . $user->email . ' login) has been successfully blocked');
        return $this->redirect()->toRoute('store/default', array('controller' => 'admin', 'action' => 'users'));
        return new ViewModel(array());
    }

    //    Product's manipulation
    public function createProductAction() {
        return new ViewModel(array());
    }

    public function uploadImageAction() {
        $form = new UploadForm('upload-form');

        var_dump(getcwd() . '/public/img');
        $request = $this->getRequest();
        if ($request->isPost()) {
            // Make certain to merge the files info!
            $post = array_merge_recursive(
                    $request->getPost()->toArray(), $request->getFiles()->toArray()
            );

            $form->setData($post);
            if ($form->isValid()) {
                $data = $form->getData();
                // Form is valid, save the form!
                return $this->redirect()->toRoute('upload-form/success');
            }
        }

        return new ViewModel(array('form' => $form));
    }

    public function editProductAction() {
        $this->check_is_admin();
        $id = $this->params()->fromRoute('id');
        $em = $this->getEntityManager();
        $product = $em->find('Store\Entity\Product', $id);
        $form = new ProductForm();
        $form->setHydrator(new DoctrineHydrator($em, 'Store\Entity\Product'));
        $form->bind($product);
        $form->setData($product->getArrayCopy());
        $request = $this->getRequest();
        if ($request->isPost()) {
            //edit PD

            $form->setInputFilter(new ProductFilter($this->getServiceLocator()));
            $form->setValidationGroup('categoryid', 'brand', 'title', 'description', 'price', 'price_opt', 'instock', 'image');
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $product->populate($request->getPost());
                $em->persist($product);
                $em->flush();
                $message = "Product's details have been successfully updated";
            }
        }

        return new ViewModel(array(
                    'form' => $form,
                    'product' => $product,
                    'categories' => $this->getCategoriesTable(),
                    'orders' => $this->getNumberOfSellingProduct($product->id),
                    'percentage' => $this->getPersentageOfSellingProduct($product->id, $product->instock),
                    'netincome' => $this->getCurrentNetIncome($product),
                    'message' => isset($message) ? $message : ''));
    }

    public function deleteProductAction() {
        $this->check_is_admin();
        return new ViewModel(array());
    }

    //    Order's manipulation

    public function createOrderAction() {
        return new ViewModel(array());
    }

    public function editOrderAction() {
        $this->check_is_admin();
        return new ViewModel(array());
    }

    public function deleteOrderAction() {
        $this->check_is_admin();
        return new ViewModel(array());
    }

    private function getPaginatorCollectionAll($entity) {
        $em = $this->getEntityManager();
        $adapter = new SelectableAdapter($em->getRepository('Store\\Entity\\' . $entity));

        // Create the paginator itself
        $paginator = new Paginator($adapter);
        $page = 1;
        if ($this->params()->fromRoute('page'))
            $page = $this->params()->fromRoute('page');
        $paginator->setCurrentPageNumber((int) $page)
                ->setItemCountPerPage(5);
        return $paginator;
    }

    private function getEntityManager() {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }

    private function check_is_admin() {

        //if user not logged in redirect to login url
        $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        if (!$auth->hasIdentity()) {
            return $this->redirect()->toRoute('store/default', array('controller' => 'login', 'action' => 'index'));
        }
        if ($auth->getIdentity()->isadmin == '0') {
            return $this->redirect()->toRoute('store/default', array('controller' => 'index', 'action' => 'index'));
        }
    }

    private function getProductsArray() {

        //ZfcDataGrid Datasource gets doctrine\QueryBuilder
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder->select('p')
                ->from('Store\Entity\Product', 'p');

        return $queryBuilder->getQuery()->getResult(\Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY);



//        $data=array();
//        $table = $this->getObjectManager()->getRepository('\Store\Entity\Product')->findAll();      
//        foreach ($table as $t) {
//               array_push($data, array('id'=>$t->id, 'brand'=>$t->brand));
//            }
//            print_r($data);
//        return $data;        
    }

    private function getCategoryName($id) {
        return $this->getEntityManager()->getRepository('Store\Entity\Category')->findOneBy(array('id' => $id))->name;
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

    protected function getCategoriesTable() {
        if (!$this->categories) {
            $table = $this->getObjectManager()->getRepository('\Store\Entity\Category')->findAll();
            foreach ($table as $t) {
                $data[$t->id] = $t->name;
            }
            $this->categories = $data;
        }
        return $this->categories;
    }

    protected function getNumberOfSellingProduct($id) {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder->select('count(o)')
                ->from('Store\Entity\Order', 'o')
                ->where('o.productid = :id')
                ->setParameter('id', $id);
        ;

        return $queryBuilder->getQuery()->getSingleScalarResult();
    }

    protected function getPersentageOfSellingProduct($id, $instock) {
        $sells = $this->getNumberOfSellingProduct($id);
        $bought = $instock + $sells;
        return (100 / $bought) * $sells;
    }

    protected function getCurrentNetIncome($product) {
        $sells = $this->getNumberOfSellingProduct($product->id);
        $income = ($product->price - $product->price_opt) * $sells;
        return $income - (($income / 100) * 18);
    }

    protected function getObjectManager() {
        if (!$this->objectManager) {
            $this->objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        return $this->objectManager;
    }

    private function get_flash_message() {
        $text = null;
        $flashMessenger = $this->flashMessenger();
        if ($flashMessenger->hasMessages()) {
            foreach ($flashMessenger->getMessages() as $key => $value) {
                $text .= $value;
            }
        }
        return $text;
    }

    private function serialize($entity) {
        $className = get_class($entity);

        $uow = $this->getEntityManager()->getUnitOfWork();
        $entityPersister = $uow->getEntityPersister($className);
        $classMetadata = $entityPersister->getClassMetadata();

        $result = array();
        foreach ($uow->getOriginalEntityData($entity) as $field => $value) {
            if (isset($classMetadata->associationMappings[$field])) {
                $assoc = $classMetadata->associationMappings[$field];

                // Only owning side of x-1 associations can have a FK column.
                if (!$assoc['isOwningSide'] || !($assoc['type'] & \Doctrine\ORM\Mapping\ClassMetadata::TO_ONE)) {
                    continue;
                }

                if ($value !== null) {
                    $newValId = $uow->getEntityIdentifier($value);
                }

                $targetClass = $this->em->getClassMetadata($assoc['targetEntity']);
                $owningTable = $entityPersister->getOwningTable($field);

                foreach ($assoc['joinColumns'] as $joinColumn) {
                    $sourceColumn = $joinColumn['name'];
                    $targetColumn = $joinColumn['referencedColumnName'];

                    if ($value === null) {
                        $result[$sourceColumn] = null;
                    } else if ($targetClass->containsForeignIdentifier) {
                        $result[$sourceColumn] = $newValId[$targetClass->getFieldForColumn($targetColumn)];
                    } else {
                        $result[$sourceColumn] = $newValId[$targetClass->fieldNames[$targetColumn]];
                    }
                }
            } elseif (isset($classMetadata->columnNames[$field])) {
                $columnName = $classMetadata->columnNames[$field];
                $result[$columnName] = $value;
            }
        }

        return array($className, $result);
    }

}