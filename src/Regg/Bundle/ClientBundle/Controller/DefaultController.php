<?php

namespace Regg\Bundle\ClientBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Delete;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Exception\InvalidFieldNameException;
use Regg\Bundle\ClientBundle\Entity\User;
use Regg\Bundle\ClientBundle\Form\UserType;
class DefaultController extends FOSRestController
{
    /**
     *
     * @Post("/rest/login")
     *
     * @param Request $request
     * @return array
     */
    public function loginreggAction(Request $request)
    {
       $u=$this->getParams($request);
       $userService=$this->getUserService();
       if(isset($u["username"])&& isset($u["password"])){
       	try{
       	   $response=$userService->findBy(array("username"=>filter_var($u["username"],FILTER_SANITIZE_FULL_SPECIAL_CHARS),"password"=>filter_var($u["password"],FILTER_SANITIZE_FULL_SPECIAL_CHARS)));
           return $this->getResponse(array(count($response)),200);
          }catch(InvalidFieldNameException $e){
   	       return $this->getResponse(array(0),400);
          }
         }
          return $this->getResponse(array(0),400);
    }

    

    
    /**
     *
     * @Post("/rest/register")
     *
     * @param Request $request
     * @return array
     */
    public function registerreggAction(Request $request)
    {
       $u=$this->getParams($request);
       $userService=$this->getUserService();
       if(isset($u["username"])&& isset($u["password"])){
       	try{
       	   $response=$userService->findBy(array("username"=>filter_var($u["username"],FILTER_SANITIZE_FULL_SPECIAL_CHARS),"password"=>filter_var($u["password"],FILTER_SANITIZE_FULL_SPECIAL_CHARS)));
       	    }catch(InvalidFieldNameException $e){
   	        	
            }
        	  
       	   $user=$userService->register(array("username"=>filter_var($u["username"],FILTER_SANITIZE_FULL_SPECIAL_CHARS),"password"=>filter_var($u["password"],FILTER_SANITIZE_FULL_SPECIAL_CHARS)));
                 return $this->getResponse(array(1),200);
         }
          return $this->getResponse(array(0,"Invalid Data Form"),400);
      }

    /**
    *
    **/
    public function getUserService()
    {
        return $this->get('user_regg.user_service');

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
        return $this->json($data, $code);
       // $view = $this->view($data, $code);
       // return $this->handleView($view);
       
    }
}
