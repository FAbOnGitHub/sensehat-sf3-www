<?php

namespace FAb\SensorsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dataline
 *
 * @ORM\Table(name="dataline")
 * @ORM\Entity(repositoryClass="FAb\SensorsBundle\Repository\DatalineRepository")
 */
class Dataline
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
     * @var \DateTime
     *
     * @ORM\Column(name="datetime", type="datetime")
     */
    private $datetime;

    /**
     * @ORM\ManyToOne(targetEntity="Dataset", inversedBy="datalines")
     * @ORM\JoinColumn(name="dataset", referencedColumnName="id")
     */
    private $dataset;
    
    
    
    /**
     * @var float
     *
     * @ORM\Column(name="temperature", type="float", nullable=true)
     */
    private $temperature;

    /**
     * @var float
     *
     * @ORM\Column(name="humidity", type="float", nullable=true)
     */
    private $humidity;

    /**
     * @var float
     *
     * @ORM\Column(name="pressure", type="float", nullable=true)
     */
    private $pressure;

    /**
     * @var float
     *
     * @ORM\Column(name="magnetism", type="float", nullable=true)
     */
    private $magnetism;

   /**
     * @var float
     *
     * @ORM\Column(name="temperature_cpu", type="float", nullable=true)
     */
    private $temperature_cpu;

    
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
     * Set datetime
     *
     * @param \DateTime $datetime
     *
     * @return Dataline
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * Get datetime
     *
     * @return \DateTime
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * Set temperature
     *
     * @param float $temperature
     *
     * @return Dataline
     */
    public function setTemperature($temperature)
    {
        $this->temperature = $temperature;

        return $this;
    }

    /**
     * Get temperature
     *
     * @return float
     */
    public function getTemperature()
    {
        return $this->temperature;
    }

    /**
     * Set humidity
     *
     * @param float $humidity
     *
     * @return Dataline
     */
    public function setHumidity($humidity)
    {
        $this->humidity = $humidity;

        return $this;
    }

    /**
     * Get humidity
     *
     * @return float
     */
    public function getHumidity()
    {
        return $this->humidity;
    }

    /**
     * Set pressure
     *
     * @param float $pressure
     *
     * @return Dataline
     */
    public function setPressure($pressure)
    {
        $this->pressure = $pressure;

        return $this;
    }

    /**
     * Get pressure
     *
     * @return float
     */
    public function getPressure()
    {
        return $this->pressure;
    }

    /**
     * Set magnetism
     *
     * @param float $magnetism
     *
     * @return Dataline
     */
    public function setMagnetism($magnetism)
    {
        $this->magnetism = $magnetism;

        return $this;
    }

    /**
     * Get magnetism
     *
     * @return float
     */
    public function getMagnetism()
    {
        return $this->magnetism;
    }

    /**
     * Set dataset
     *
     * @param \FAb\SensorsBundle\Entity\Dataset $dataset
     *
     * @return Dataline
     */
    public function setDataset(\FAb\SensorsBundle\Entity\Dataset $dataset = null)
    {
        $this->dataset = $dataset;

        return $this;
    }

    /**
     * Get dataset
     *
     * @return \FAb\SensorsBundle\Entity\Dataset
     */
    public function getDataset()
    {
        return $this->dataset;
    }

    /**
     * Set temperatureCpu
     *
     * @param float $temperatureCpu
     *
     * @return Dataline
     */
    public function setTemperatureCpu($temperatureCpu)
    {
        $this->temperature_cpu = $temperatureCpu;

        return $this;
    }

    /**
     * Get temperatureCpu
     *
     * @return float
     */
    public function getTemperatureCpu()
    {
        return $this->temperature_cpu;
    }
}
