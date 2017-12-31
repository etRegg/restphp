<?php

namespace Regg\Bundle\ClientBundle\Service;

use Regg\Bundle\ClientBundle\Entity\Client;
use Regg\Bundle\ClientBundle\Form\ClientType;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Form\FormFactoryInterface;

class ClientService extends EntityService
{

    const CONTAINER_KEY = 'client_regg.user_service';

    protected $token;

    public function __construct(RegistryInterface $registry, FormFactoryInterface $formFactory)
    {
        parent::__construct($registry->getManager(), Client::class, $formFactory);


        $this->_formType = ClientType::class;
    }

    protected function validateParameters($parameters)
    {
        filter_var($parameters["name"], FILTER_VALIDATE_EMAIL);
        return true;
    }
}

