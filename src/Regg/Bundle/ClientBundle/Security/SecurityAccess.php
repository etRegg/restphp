<?php
/**
 * Created by PhpStorm.
 * User: rodrigo
 * Date: 16/12/17
 * Time: 10:22
 */

namespace Regg\Bundle\ClientBundle\Security;
use FOS\RestBundle\Controller\FOSRestController;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Keys;
use Lcobucci\JWT\Signer\Ecdsa\Sha256;
use Lcobucci\JWT\Signer\Ecdsa\Sha512;
use Lcobucci\JWT\Signer\Key;
use Symfony\Component\HttpFoundation\Request;

use Regg\Bundle\ClientBundle\Service\UserService;
use Lcobucci\JWT\Token;


class SecurityAccess
{
    public static $id=null;
    use Keys;
    /**
     * @var Configuration
     */
    private $config;


   
  public function __construct()
    {
    
        $this->createConfiguration();
    }
    /**
     *
     */
    public function createConfiguration()
    {
        $this->config = Configuration::forAsymmetricSigner(
            Sha256::create(),
            static::$ecdsaKeys['private'],
            static::$ecdsaKeys['public1']
        );
    }

    public function generateATokenFromAutoritation(String $username,String $token)
    {
        $user    = ['username' => $username, 'apikey' => $token];
        $builder = $this->config->createBuilder();
        /**
         * @var Token $token
         */
        $token = $builder->identifiedBy('1')
            ->permittedFor('http://localhost:8000')
            ->permittedFor('http://127.0.0.1:8000')

            ->permittedFor('http://localhost:4200')
            ->permittedFor('http://127.0.0.1:4200')
            ->issuedBy('http://api.abc.com')
            ->withClaim('user', $user)
            ->withHeader('jki', ''+1)
            ->getToken($this->config->getSigner(), $this->config->getSigningKey());



        return $token;
    }
    public function getTokenWithDataFormHeader(String $data)
    {
        return  $this->config->getParser()->parse($data);
    }
    public function validate(String $data)
    {
        /**
         * @var Token $token
         */
        $token=$this->getTokenWithDataFormHeader($data);
        if($token->verify($this->config->getSigner(), $this->config->getSigningKey())){
            if(!$token->isExpired(new \DateTime())){
                static::$id=$token->getHeader('jki');
                return true;
            }
        }
        return false;
    }
    public function validateHeader(Request $request,UserService $service)
    {

        /**
         * @var string
         */
        $data="";
        if($this->validate($data)){

        }
    }
}