<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * tcTemperatura
 *
 * @ORM\Table(name="tc_temperatura")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\tcTemperaturaRepository")
 */
class tcTemperatura
{
    /**
     * @ORM\OneToMany(targetEntity="Producto", mappedBy="temperatura")
     */ 
    protected $productos;
    
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

    public function __construct()
    {
        $this->productos = new ArrayCollection();
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

    /**
     * Add producto
     *
     * @param \AppBundle\Entity\Producto $producto
     *
     * @return tcTemperatura
     */
    public function addProducto(\AppBundle\Entity\Producto $producto)
    {
        $this->productos[] = $producto;

        return $this;
    }

    /**
     * Remove producto
     *
     * @param \AppBundle\Entity\Producto $producto
     */
    public function removeProducto(\AppBundle\Entity\Producto $producto)
    {
        $this->productos->removeElement($producto);
    }

    /**
     * Get productos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductos()
    {
        return $this->productos;
    }
}
