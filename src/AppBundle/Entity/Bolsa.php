<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bolsa
 *
 * @ORM\Table(name="bolsa")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BolsaRepository")
 */
class Bolsa
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
     * @ORM\Column(name="codigoBolsa", type="string", length=10)
     */
    private $codigoBolsa;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaCreacion", type="datetime")
     */
    private $fechaCreacion;

    /**
     * @var array
     *
     * @ORM\Column(name="listadoProductos", type="array")
     */
    private $listadoProductos;


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
     * Set codigoBolsa
     *
     * @param string $codigoBolsa
     *
     * @return Bolsa
     */
    public function setCodigoBolsa($codigoBolsa)
    {
        $this->codigoBolsa = $codigoBolsa;

        return $this;
    }

    /**
     * Get codigoBolsa
     *
     * @return string
     */
    public function getCodigoBolsa()
    {
        return $this->codigoBolsa;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return Bolsa
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fechaCreacion
     *
     * @return \DateTime
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    /**
     * Set listadoProductos
     *
     * @param array $listadoProductos
     *
     * @return Bolsa
     */
    public function setListadoProductos($listadoProductos)
    {
        $this->listadoProductos = $listadoProductos;

        return $this;
    }

    /**
     * Get listadoProductos
     *
     * @return array
     */
    public function getListadoProductos()
    {
        return $this->listadoProductos;
    }
}
