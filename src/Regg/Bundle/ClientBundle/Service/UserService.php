<?php

namespace Regg\Bundle\ClientBundle\Service;


use Regg\Bundle\ClientBundle\Entity\User;
use Regg\Bundle\ClientBundle\Form\UserType;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Validator\Tests\Fixtures\Entity;
use Regg\Bundle\ClientBundle\Security\SecurityAccess;

class UserService extends EntityService implements UserProviderInterface
{

    const CONTAINER_KEY = 'user_regg.user_service';//'security.authentication.provider.guard.main';

    protected $token;

    public function __construct(RegistryInterface $registry, FormFactoryInterface $formFactory)
    {
        parent::__construct($registry->getManager(), User::class, $formFactory);


        $this->_formType = UserType::class;
    }

    protected function validateParameters($parameters)
    {
        return true;
    }
    public function supportsClass($class)
    {}

    public function refreshUser(UserInterface $user)
    {}

    public function loadUserByUsername($username)
    {}

    /**
     * Create new Entity
     * @param Entity $parameters
     * @return Entity
     * @throws \Exception
     */
    public function register(array $parameters) {

        
      
        
        return  $this->create($parameters);
    
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
        $securityAccess= new SecurityAccess();
        $apikey=$securityAccess->generateATokenFromAutoritation($parameters["username"],$parameters["password"]);
        $entity->setApiKey($apikey);
        $entity->setClients(array());
        return  $this->save($entity);
    }
}

