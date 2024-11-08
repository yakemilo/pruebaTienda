<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
//use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
//use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Producto
 *
 * @ORM\Table(name="producto")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductoRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Producto
{
    /**
     * @ORM\ManyToOne(targetEntity="Almacen", inversedBy="productos")
     * @ORM\JoinColumn(name="almacen_id", referencedColumnName="id", onDelete="CASCADE")
     * @Assert\NotBlank()
     */ 
    protected $almacen;

    /**
     * @ORM\ManyToOne(targetEntity="tcTemperatura", inversedBy="productos")
     * @ORM\JoinColumn(name="temperatura_id", referencedColumnName="id", onDelete="CASCADE")
     * @Assert\NotBlank()
     */ 
    protected $temperatura;
    
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
     * @ORM\Column(name="codigo", type="string", length=25)
     * @Assert\NotBlank()
     */
    private $codigo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_creacion", type="datetime")
     */
    private $fechaCreacion;


    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_traduccion", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $nombreTraduccion;

    /**
     * @var float
     * 
     * @ORM\Column(name="peso", type="float")
     * @Assert\NotBlank()
     */
    private $peso;

    /**
     * @var float
     * 
     * @ORM\Column(name="volumen", type="float")
     * @Assert\NotBlank()
     */
    private $volumen;

    /**
     * @var float
     * 
     * @ORM\Column(name="precio", type="float")
     * @Assert\NotBlank()
     */
    private $precio;

    /**
     * @var string
     *
     * @ORM\Column(name="marca", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $marca;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $descripcion;


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
     * Set codigo
     *
     * @param string $codigo
     *
     * @return Producto
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return Producto
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fechaCreacion
     *
     * @return string
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    /**
     * @ORM\PrePersist
     */
    public function setFechaCracionValue()
    {
        $this->fechaCreacion = new \DateTime();
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Producto
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set nombreTraduccion
     *
     * @param string $nombreTraduccion
     *
     * @return Producto
     */
    public function setNombreTraduccion($nombreTraduccion)
    {
        $this->nombreTraduccion = $nombreTraduccion;

        return $this;
    }

    /**
     * Get nombreTraduccion
     *
     * @return string
     */
    public function getNombreTraduccion()
    {
        return $this->nombreTraduccion;
    }

    /**
     * Set peso
     *
     * @param float $peso
     *
     * @return Producto
     */
    public function setPeso($peso)
    {
        $this->peso = $peso;

        return $this;
    }

    /**
     * Get peso
     *
     * @return float
     */
    public function getPeso()
    {
        return $this->peso;
    }

    /**
     * Set volumen
     *
     * @param float $volumen
     *
     * @return Producto
     */
    public function setVolumen($volumen)
    {
        $this->volumen = $volumen;

        return $this;
    }

    /**
     * Get volumen
     *
     * @return float
     */
    public function getVolumen()
    {
        return $this->volumen;
    }

    /**
     * Set precio
     *
     * @param float $precio
     *
     * @return Producto
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get precio
     *
     * @return float
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set marca
     *
     * @param string $marca
     *
     * @return Producto
     */
    public function setMarca($marca)
    {
        $this->marca = $marca;

        return $this;
    }

    /**
     * Get marca
     *
     * @return string
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Producto
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set almacen
     *
     * @param \AppBundle\Entity\Almacen $almacen
     *
     * @return Producto
     */
    public function setAlmacen(\AppBundle\Entity\Almacen $almacen = null)
    {
        $this->almacen = $almacen;

        return $this;
    }

    /**
     * Get almacen
     *
     * @return \AppBundle\Entity\Almacen
     */
    public function getAlmacen()
    {
        return $this->almacen;
    }

    /**
     * Set temperatura
     *
     * @param \AppBundle\Entity\tcTemperatura $temperatura
     *
     * @return Producto
     */
    public function setTemperatura(\AppBundle\Entity\tcTemperatura $temperatura = null)
    {
        $this->temperatura = $temperatura;

        return $this;
    }

    /**
     * Get temperatura
     *
     * @return \AppBundle\Entity\tcTemperatura
     */
    public function getTemperatura()
    {
        return $this->temperatura;
    }
}
