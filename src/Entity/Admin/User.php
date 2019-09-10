<?php

namespace App\Entity\Admin;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as MineAssert;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass="App\Repository\Admin\UserRepository")
 *
 * @UniqueEntity("name")
 * @UniqueEntity("email")
 */
class User
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     *
     * @Assert\NotBlank(message="Please, tell us your name")
     * @Assert\Length(
     *     min=3,
     *     max=100,
     * )
     * @MineAssert\MineRegex(
     *     message="Bad, bad name...",
     *     pattern="/[a-zA-Z0-9-_]{0,}/"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min=3,
     *     max=255
     * )
     * @MineAssert\MineRegex(
     *     message="What??",
     *     pattern="/[a-zA-Z0-9 -]{0,}/"
     * )
     */
    private $realName;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank()
     * @Assert\Email(message="Hey, it's email address...")
     */
    private $email;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank()
     * @Assert\Choice(
     *     choices={"male", "female"},
     *     message="You are not male or female? Come on..."
     * )
     */
    private $sex;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Assert\NotBlank()
     * @Assert\Date()
     */
    private $bornAt;

    /**
     * @ORM\Column(type="boolean")
     *
     * @Assert\Type("bool")
     */
    private $isBan;

    /**
     * @ORM\OneToMany(
     *     targetEntity="UserCar",
     *     mappedBy="user",
     *     orphanRemoval=true,
     *     cascade={"persist"}
     * )
     *
     * @Assert\Valid()
     */
    private $userCar;


    public function __construct()
    {
        $this->userCar = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getRealName()
    {
        return $this->realName;
    }

    /**
     * @param mixed $realName
     */
    public function setRealName($realName): void
    {
        $this->realName = $realName;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * @param mixed $sex
     */
    public function setSex($sex): void
    {
        $this->sex = $sex;
    }

    /**
     * @return mixed
     */
    public function getBornAt()
    {
        return $this->bornAt;
    }

    /**
     * @param mixed $bornAt
     */
    public function setBornAt($bornAt): void
    {
        $this->bornAt = $bornAt;
    }

    /**
     * @return mixed
     */
    public function getisBan()
    {
        return $this->isBan;
    }

    /**
     * @param mixed $isBan
     */
    public function setIsBan($isBan): void
    {
        $this->isBan = $isBan;
    }

    public function addUserCar(UserCar $user_car)
    {
        if($this->userCar->contains($user_car))
            return;

        $this->userCar[] = $user_car;

        $user_car->setUser($this);
    }

    public function removeUserCar(UserCar $user_car)
    {
        if(!$this->userCar->contains($user_car))
            return;

        $this->userCar->removeElement($user_car);

        $user_car->setUser(null);
    }

    /**
     * @return ArrayCollection|UserCar[]
     */
    public function getUserCar()
    {
        return $this->userCar;
    }


}