<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * tcProvincia
 *
 * @ORM\Table(name="tc_provincia")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\tcProvinciaRepository")
 */
class tcProvincia
{
    /**
     * @ORM\OneToMany(targetEntity="tcMunicipio", mappedBy="provincia")
     */ 
    protected $municipios;
    
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
     * @ORM\Column(name="nombre", type="string", length=50)
     */
    private $nombre;

    public function __construct()
    {
        $this->municipios = new ArrayCollection();
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return tcProvincia
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
     * Add municipio
     *
     * @param \AppBundle\Entity\tcMunicipio $municipio
     *
     * @return tcProvincia
     */
    public function addMunicipio(\AppBundle\Entity\tcMunicipio $municipio)
    {
        $this->municipios[] = $municipio;

        return $this;
    }

    /**
     * Remove municipio
     *
     * @param \AppBundle\Entity\tcMunicipio $municipio
     */
    public function removeMunicipio(\AppBundle\Entity\tcMunicipio $municipio)
    {
        $this->municipios->removeElement($municipio);
    }

    /**
     * Get municipios
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMunicipios()
    {
        return $this->municipios;
    }
}
