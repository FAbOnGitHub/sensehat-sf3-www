<?php

/*
 * Les utilisateurs
 */

namespace AbundanceBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="greetings", type="string", length=256, nullable=true)
     */
    protected $greetings;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /*
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        // add your custom field
        $builder->add('greetings');
    }
*/
    /**
     * Set greetings
     *
     * @param string $greetings
     *
     * @return User
     */
    public function setGreetings($greetings)
    {
        $this->greetings = $greetings;

        return $this;
    }

    /**
     * Get greetings
     *
     * @return string
     */
    public function getGreetings()
    {
        return $this->greetings;
    }

}
