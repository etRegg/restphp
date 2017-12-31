<?php
namespace Regg\Bundle\ClientBundle\Service;
use Doctrine\ORM\Persisters\Entity;


interface EntityServiceInterface
{
    
    /**
     * @param integer $id
     * @return Entity
     */
    public function get($id);
    
    /**
     * @param array $criteria
     * @return Entity
     */
    public function findBy($criteria);
    
    /**
     * Create new Entity.
     * @param array $parameters
     * @return array
     */
    public function create($parameters);
    
    /**
     * Update new Entity.
     * @param int $id
     * @param array $parameters
     * @return array
     */
    public function update($id, $parameters);
    
    /**
     * @return array
     */
    public function findAll();
    
    /**
     *
     * @param int $id
     * @return array
     */
    public function findByNameSubordinateAll(String $id);
    
    /**
     * @param $id
     * @return $this
     * @throws \Exception
     */
    public function delete($id);
    
    /**
     * @param $entity
     * @return $this
     */
    public function remove($entity);
    
}

