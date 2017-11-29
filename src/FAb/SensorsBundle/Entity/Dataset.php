<?php

namespace FAb\SensorsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dataset
 *
 * @ORM\Table(name="dataset")
 * @ORM\Entity(repositoryClass="FAb\SensorsBundle\Repository\DatasetRepository")
 */
class Dataset {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=64, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="Dataline", mappedBy="dataset")
     */
    private $datalines;

    /**
     * @ORM\ManyToOne(targetEntity="Station", inversedBy="datasets")
     * @ORM\JoinColumn(name="station", referencedColumnName="id")
     */
    private $station;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Dataset
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Dataset
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->datalines = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add dataline
     *
     * @param \FAb\SensorsBundle\Entity\Dataline $dataline
     *
     * @return Dataset
     */
    public function addDataline(\FAb\SensorsBundle\Entity\Dataline $dataline)
    {
        $this->datalines[] = $dataline;

        return $this;
    }

    /**
     * Remove dataline
     *
     * @param \FAb\SensorsBundle\Entity\Dataline $dataline
     */
    public function removeDataline(\FAb\SensorsBundle\Entity\Dataline $dataline)
    {
        $this->datalines->removeElement($dataline);
    }

    /**
     * Get datalines
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDatalines()
    {
        return $this->datalines;
    }

    /**
     * Set station
     *
     * @param \FAb\SensorsBundle\Entity\Station $station
     *
     * @return Dataset
     */
    public function setStation(\FAb\SensorsBundle\Entity\Station $station = null)
    {
        $this->station = $station;

        return $this;
    }

    /**
     * Get station
     *
     * @return \FAb\SensorsBundle\Entity\Station
     */
    public function getStation()
    {
        return $this->station;
    }
}
