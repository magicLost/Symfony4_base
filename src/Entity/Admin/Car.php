<?php

namespace App\Entity\Admin;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as MineAssert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Admin\CarRepository")
 */
class Car
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank()
     * @MineAssert\MineRegex(
     *     pattern="/[a-zA-Z0-9 -_]{0,}/"
     * )
     */
    private $model;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank()
     * @Assert\Country()
     */
    private $country;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Assert\NotBlank()
     * @Assert\Date()
     */
    private $madeAt;

    /**
     * @ORM\OneToMany(
     *     targetEntity="UserCar",
     *     mappedBy="car",
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


    public function getId()
    {
        return $this->id;
    }
    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param mixed $model
     */
    public function setModel($model): void
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country): void
    {
        $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getMadeAt()
    {
        return $this->madeAt;
    }

    /**
     * @param mixed $madeAt
     */
    public function setMadeAt($madeAt): void
    {
        $this->madeAt = $madeAt;
    }


    public function addUserCar(UserCar $user_car)
    {
        if($this->userCar->contains($user_car))
            return;

        $this->userCar[] = $user_car;

        $user_car->setCar($this);
    }

    public function removeUserCar(UserCar $user_car)
    {
        if(!$this->userCar->contains($user_car))
            return;

        $this->userCar->removeElement($user_car);

        $user_car->setCar(null);
    }

    /**
     * @return ArrayCollection|UserCar[]
     */
    public function getUserCar()
    {
        return $this->userCar;
    }

}