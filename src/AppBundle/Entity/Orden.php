<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Orden
 *
 * @ORM\Table(name="orden")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrdenRepository")
 */
class Orden
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
     * @ORM\Column(name="Numero", type="string", length=20)
     */
    private $numero;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaCompra", type="datetime")
     */
    private $fechaCompra;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaAprobacion", type="datetime")
     */
    private $fechaAprobacion;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=400)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="importeTotal", type="decimal", precision=10, scale=2)
     */
    private $importeTotal;

    /**
     * @var array
     *
     * @ORM\Column(name="listadoProductos", type="array")
     */
    private $listadoProductos;

    /**
     * @var array
     *
     * @ORM\Column(name="listadoBolsas", type="array", nullable=true)
     */
    private $listadoBolsas;


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
     * Set numero
     *
     * @param string $numero
     *
     * @return Orden
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set fechaCompra
     *
     * @param \DateTime $fechaCompra
     *
     * @return Orden
     */
    public function setFechaCompra($fechaCompra)
    {
        $this->fechaCompra = $fechaCompra;

        return $this;
    }

    /**
     * Get fechaCompra
     *
     * @return \DateTime
     */
    public function getFechaCompra()
    {
        return $this->fechaCompra;
    }

    /**
     * Set fechaAprobacion
     *
     * @param \DateTime $fechaAprobacion
     *
     * @return Orden
     */
    public function setFechaAprobacion($fechaAprobacion)
    {
        $this->fechaAprobacion = $fechaAprobacion;

        return $this;
    }

    /**
     * Get fechaAprobacion
     *
     * @return \DateTime
     */
    public function getFechaAprobacion()
    {
        return $this->fechaAprobacion;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     *
     * @return Orden
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set importeTotal
     *
     * @param string $importeTotal
     *
     * @return Orden
     */
    public function setImporteTotal($importeTotal)
    {
        $this->importeTotal = $importeTotal;

        return $this;
    }

    /**
     * Get importeTotal
     *
     * @return string
     */
    public function getImporteTotal()
    {
        return $this->importeTotal;
    }

    /**
     * Set listadoProductos
     *
     * @param array $listadoProductos
     *
     * @return Orden
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

    /**
     * Set listadoBolsas
     *
     * @param array $listadoBolsas
     *
     * @return Orden
     */
    public function setListadoBolsas($listadoBolsas)
    {
        $this->listadoBolsas = $listadoBolsas;

        return $this;
    }

    /**
     * Get listadoBolsas
     *
     * @return array
     */
    public function getListadoBolsas()
    {
        return $this->listadoBolsas;
    }
}

