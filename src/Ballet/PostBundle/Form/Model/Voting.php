<?php

namespace Ballet\PostBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Ballet\ImageBundle\Entity\Image;

class Registration
{
    /**
     * @Assert\Type(type="Ballet\PostBundle\Entity\Image")
     * @Assert\Valid()
     */
    protected $user;
    protected $pass;
    protected $date;

    /**
     * @Assert\NotBlank()
     * @Assert\True()
     */
    protected $termsAccepted;

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getTermsAccepted()
    {
        return $this->termsAccepted;
    }

    public function setTermsAccepted($termsAccepted)
    {
        $this->termsAccepted = (Boolean) $termsAccepted;
    }

    public function setUserPassword($pass){
        $this->user->setPassword($pass);
    }

    public function setRegisterDate($date){
        $this->user->setRegistered($date);
    }

    public function setSalt(){
        $this->user->setSalt();
    }
}