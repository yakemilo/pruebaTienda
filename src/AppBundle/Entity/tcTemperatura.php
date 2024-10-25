<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * tcTemperatura
 *
 * @ORM\Table(name="tc_temperatura")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\tcTemperaturaRepository")
 */
class tcTemperatura
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
     * @ORM\Column(name="temperatura", type="string", length=50)
     */
    private $temperatura;


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
     * Set temperatura
     *
     * @param string $temperatura
     *
     * @return tcTemperatura
     */
    public function setTemperatura($temperatura)
    {
        $this->temperatura = $temperatura;

        return $this;
    }

    /**
     * Get temperatura
     *
     * @return string
     */
    public function getTemperatura()
    {
        return $this->temperatura;
    }
}

