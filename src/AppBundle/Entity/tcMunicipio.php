<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * tcMunicipio
 *
 * @ORM\Table(name="tc_municipio")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\tcMunicipioRepository")
 */
class tcMunicipio
{
    /**
     * @ORM\ManyToOne(targetEntity="tcProvincia", inversedBy="municipios")
     * @ORM\JoinColumn(name="provincia_id", referencedColumnName="id", onDelete="CASCADE")
     */ 
    protected $provincia;
    
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
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;


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
     * @return tcMunicipio
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
     * Set provincia
     *
     * @param \AppBundle\Entity\tcProvincia $provincia
     *
     * @return tcMunicipio
     */
    public function setProvincia(\AppBundle\Entity\tcProvincia $provincia = null)
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Get provincia
     *
     * @return \AppBundle\Entity\tcProvincia
     */
    public function getProvincia()
    {
        return $this->provincia;
    }
}
