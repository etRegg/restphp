<?php
namespace Regg\Bundle\ClientBundle\Service;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Form\FormFactoryInterface;

abstract class EntityService implements EntityServiceInterface {
    
    /**
     * @var ObjectManager $_objectManager
     */
    protected $_objectManager;
    
    /**
     * @var String $_entityClass
     */
    protected $_entityClass;
    
    /**
     * @var FormFactoryInterface $_formFactory
     */
    protected $_formFactory;
    
    /**
     * @var ObjectRepository $_repository
     */
    protected $_repository;
    
    /**
     * @var String $_formType
     */
    protected $_formType;
    
    
    /**
     * CoreEntityService constructor.
     * @param ObjectManager $objectManager
     * @param $entityClass
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(
        ObjectManager $objectManager,
        $entityClass,
        FormFactoryInterface $formFactory
        ) {
            $this->_objectManager = $objectManager;
            $this->_entityClass = $entityClass;
            $this->_formFactory = $formFactory;
            $this->_repository = $this->_objectManager->getRepository($this->_entityClass);
    }
    
    /**
     * @param integer $id
     * @return Object
     **/
    public function get($id)
    {
        $_entity = $this->_objectManager->find($this->_entityClass, $id);
        return $_entity;
    }
    
    /**
     * @param integer $id
     * @return $this
     **/
    public function delete($id)
    {
        $_entity = $this->_objectManager->find($this->_entityClass, $id);
        $this->remove($_entity);
        return $this;
    }
    
    /**
     * @param array $criteria
     * @return Object
     */
    public function findBy($criteria) {
        return $this->_repository->findOneBy($criteria);
    }
    
    public function findByAll($criteria){
        return $this->_repository->findBy($criteria);
    }
    /**
     * @return array(Object)
     */
    public function findAll() {
        return $this->_repository->findAll();
    }
    
    public function findByNameSubordinateAll(String $id)
    {
        return $this->_repository->findAll();
    }
    
    /**
     * Create new Entity
     * @param array $parameters
     * @return Entity
     * @throws \Exception
     */
    public function create($parameters) {
        $entity = $this->entityClass();
    
        return $this->processForm($entity, $parameters);
    }
    
    /**
     * Update Entity
     * @param int $id
     * @param array $parameters
     * @return Entity
     * @throws \Exception
     */
    public function update($id, $parameters) {
        $entity = $this->get($id);
        if(is_null($entity)){
            throw new \Exception('Entity not fount');
        }
        $entity = $this->processForm($entity, $parameters, 'PUT');
        return $entity;
    }
    
    /**
     * @param $entity
     * @return $this
     */
    public function remove($entity)
    {
        $this->_objectManager->remove($entity);
        $this->_objectManager->flush();
        return $this;
    }
    
    /**
     * Processes the form.
     *
     * @param $entity
     * @param array $parameters
     * @param String $method
     * @return Entity
     */
    protected function processForm($entity, array $parameters, $method = 'POST') {
        $form = $this->createForm($entity, $method);
        $form->submit($parameters, 'PATCH' !== $method);
        $entity = $form->getData();
        return  $this->save($entity);
    }
    
    public function save($entity)
    {
        $this->_objectManager->persist($entity);
        $this->_objectManager->flush($entity);
        return $entity;
    }
    
    /**
     *  Override this method
     **/
    protected function createForm($entity, $method) {
        return $this->_formFactory->create($this->getFormType(), $entity, array('method' => $method));
    }
    
    /**
     * @return Object
     */
    protected function entityClass() {
        return new $this->_entityClass();
    }
    
    /**
     * @return String
     */
    protected function getFormType()
    {
        return $this->_formType;
    }
}

