<?php
namespace Regg\Bundle\ClientBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Delete;
use Regg\Bundle\ClientBundle\Security\SecurityAccess;
use Symfony\Component\HttpFoundation\Request;
use Regg\Bundle\ClientBundle\Entity\Client;
use Regg\Bundle\ClientBundle\Service\EntityServiceInterface;
use Regg\Bundle\ClientBundle\Service\UserService;
use Regg\Bundle\ClientBundle\Service\ClientService;

class ApiController extends FOSRestController
{
    /**
     * @var SecurityAccess
     */
    private static $seccurity;

    public function __construct()
    {
        static::$seccurity=new SecurityAccess();


    }

    /**
     *
     *
     * @Get("/api/client/{id}")
     *
     * @param Request $request
     * @param int $id
     * @return array
     */
    public function getClientAction(Request $request, $id)
    {
        
        /**
         *
         * @var Ambiguous $client
         */
        $client = $this->getServiceClient()->get($id);
        return $this->getResponse(array(
            $client
        ), 
        200);
        ;
    }

    /**
     *
     * @Get("/api/client")
     *
     * @param Request $request
     * @return array
     */
    public function listClientAction(Request $request)
    {
        /**
         *
         * @var \Symfony\Component\HttpFoundation\ParameterBag $r
         */
        $r = $request->request;
        if ($r->count() == 2) {
            return $this->getResponse(array(
                $this->getServiceClient()
                    ->findBy($this->getParams($request))
            ), 200);
        } else {
            return $this->getResponse(array(), 400);
        }
    }

    /**
     *
     * @Put("/api/client/{id}")
     *
     * @param Request $request
     * @param int $id
     * @return array
     */
    public function updateClientAction(Request $request, $id)
    {
        $this->getServiceClient()->update($id, $this->getParams($request));
        return $this->getResponse(array(), 200);
    }

    /**
     *
     * @Post("/api/client")
     *
     * @param Request $request
     * @return array
     */
    public function createClientAction(Request $request)
    {
        $this->getServiceClient()->create($this->getParams($request));
        return $this->getResponse(array(), 200);
    }

    /**
     *
     *
     * @Delete("/api/client/{id}")
     *
     * @param Request $request
     * @param int $id
     * @return array
     */
    public function deleteClientAction(Request $request, $id)
    {
        return $this->getResponse(array(
            array(),
            200
        ), 200);
    }
    /**
     *
     * @Post("/api/login")
     *
     * @param Request $request
     * @return array
     */
    public function createUserLoginAction(Request $request)
    {
        $this->getServiceClient()->create($this->getParams($request));
        return $this->getResponse(array(), 200);
    }
    /**
     *
     * @Post("/api/register")
     *
     * @param Request $request
     * @return array
     */
    public function createUserRegisterAction(Request $request)
    {
        $this->getServiceClient()->create($this->getParams($request));
        return $this->getResponse(array(), 200);
    }

    /**
     *
     * @param
     *            $collection
     * @return array
     */
    protected function processEntityCollection($collection)
    {
        $processCollection = [];
        /** @var $user User */
        foreach ($collection as $entity) {
            $processCollection[] = $this->processEntity($entity);
        }
        return $processCollection;
    }

    /**
     *
     * @param
     *            $entity
     * @return array
     */
    protected function processEntity(Client $entity)
    {
        return [
            "id" => $entity->getId()
        ];
    }

    /**
     *
     * @param Request $request
     * @return array|bool
     */
    protected function getParams(Request $request)
    {
        if (is_null($request->getContent())) {
            return false;
        }
        return json_decode($request->getContent(), true);
    }

    protected function getResponse($data = null, $code = 200)
    {
        //return $this->json($data, $code);
        $view = $this->view($data, $code);
        return $this->handleView($view);
       
    }

    /**
     *
     * @return EntityServiceInterface | ClientService
     */
    protected function getServiceClient()
    {
        return $this->container->get(ClientService::CONTAINER_KEY);
    }

    /**
     *
     * @return EntityServiceInterface | UserService
     */
    protected function getServiceUser()
    {
        return $this->container->get(UserService::CONTAINER_KEY);
    }
}
