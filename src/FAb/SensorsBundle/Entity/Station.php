<?php

namespace FAb\SensorsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Station
 *
 * @ORM\Table(name="station")
 * @ORM\Entity(repositoryClass="FAb\SensorsBundle\Repository\StationRepository")
 */
class Station
{

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
     * @ORM\Column(name="name", type="string", length=64)
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(name="lat", type="float", nullable=true)
     */
    private $lat;

    /**
     * @var float
     *
     * @ORM\Column(name="lng", type="float", nullable=true)
     */
    private $lng;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;


    /**
     * @ORM\OneToMany(targetEntity="Dataset", mappedBy="station")
     */
    private $datasets;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->datasets = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add dataset
     *
     * @param \FAb\SensorsBundle\Entity\Dataset $dataset
     *
     * @return Station
     */
    public function addDataset(\FAb\SensorsBundle\Entity\Dataset $dataset)
    {
        $this->datasets[] = $dataset;

        return $this;
    }

    /**
     * Remove dataset
     *
     * @param \FAb\SensorsBundle\Entity\Dataset $dataset
     */
    public function removeDataset(\FAb\SensorsBundle\Entity\Dataset $dataset)
    {
        $this->datasets->removeElement($dataset);
    }

    /**
     * Get datasets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDatasets()
    {
        return $this->datasets;
    }

    public function __toArray()
    {
        return [
            'id' => $this->getId(),
             'name' => $this->getName(),
             'lat' => $this->getLat(),
             'long' => $this->getLng(),
             'description' => $this->getDescription(),
            ];
    }

    public function jsonSerialize()
    {
        return $this->__toArray();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Station
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get lat
     *
     * @return float
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set lat
     *
     * @param float $lat
     *
     * @return Station
     */
    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Get lng
     *
     * @return float
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * Set lng
     *
     * @param float $lng
     *
     * @return Station
     */
    public function setLng($lng)
    {
        $this->lng = $lng;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Station
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }
}
