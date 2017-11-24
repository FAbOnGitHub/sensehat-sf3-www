<?php

namespace FAb\SensorsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dataset
 *
 * @ORM\Table(name="dataset")
 * @ORM\Entity(repositoryClass="FAb\SensorsBundle\Repository\DatasetRepository")
 */
class Dataset
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
     * @ORM\Column(name="Datetime", type="datetime")
     */
    private $datetime;

    /**
     * @var float
     *
     * @ORM\Column(name="temperature", type="float", nullable=true)
     */
    private $temperature;

    /**
     * @var float
     *
     * @ORM\Column(name="humidiy", type="float", nullable=true)
     */
    private $humidiy;

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
     * @return Dataset
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
     * @return Dataset
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
     * Set humidiy
     *
     * @param float $humidiy
     *
     * @return Dataset
     */
    public function setHumidiy($humidiy)
    {
        $this->humidiy = $humidiy;

        return $this;
    }

    /**
     * Get humidiy
     *
     * @return float
     */
    public function getHumidiy()
    {
        return $this->humidiy;
    }

    /**
     * Set pressure
     *
     * @param float $pressure
     *
     * @return Dataset
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
     * @return Dataset
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
}

