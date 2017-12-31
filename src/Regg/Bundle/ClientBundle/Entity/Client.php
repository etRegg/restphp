<?php
namespace Regg\Bundle\ClientBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;

use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
/**
 * @ORM\Entity
 * @ORM\Table(name="cliente")
 */
class Client
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=100)
     * @var string $name
     */
    private $name;
    /**
     * @ORM\Column(type="string", length=100)
     * @var string $lastname
     */
    private $lastname;
    /**
     * @ORM\Column(type="integer")
     * @var string $saldo
     */
    private $saldo;
    /**
     * /**
     * @ManyToOne(targetEntity="Regg\Bundle\ClientBundle\Entity\User")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     * @var User
     */
    private $user;
    }
