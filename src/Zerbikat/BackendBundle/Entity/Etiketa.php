<?php

namespace Zerbikat\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zerbikat\BackendBundle\Annotation\UdalaEgiaztatu;

/**
 * Etiketa
 *
 * @ORM\Table(name="etiketa")
 * @ORM\Entity
 * @UdalaEgiaztatu(userFieldName="udala_id")
 */
class Etiketa
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="origenid", type="bigint", nullable=true)
     */
    private $origenid;

    /**
     * @var string
     *
     * @ORM\Column(name="etiketaeu", type="string", length=255, nullable=true)
     */
    private $etiketaeu;

    /**
     * @var string
     *
     * @ORM\Column(name="etiketaes", type="string", length=255, nullable=true)
     */
    private $etiketaes;


    /**
     *
     *      ERLAZIOAK
     *
     */

    /**
     * @var udala
     * @ORM\ManyToOne(targetEntity="Udala")
     * @ORM\JoinColumn(name="udala_id", referencedColumnName="id",onDelete="CASCADE")
     *
     */
    private $udala;


    /**
     * @var fitxak[]
     *
     * @ORM\ManyToMany(targetEntity="Fitxa", mappedBy="etiketak", cascade="persist"))
     */
    private $fitxak;
    
    

    public function __toString()
    {
        return (string) $this->getEtiketaeu();
    }
    
    
    

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fitxak = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set etiketaeu
     *
     * @param string $etiketaeu
     *
     * @return Etiketa
     */
    public function setEtiketaeu($etiketaeu)
    {
        $this->etiketaeu = $etiketaeu;

        return $this;
    }

    /**
     * Get etiketaeu
     *
     * @return string
     */
    public function getEtiketaeu()
    {
        return $this->etiketaeu;
    }

    /**
     * Set etiketaes
     *
     * @param string $etiketaes
     *
     * @return Etiketa
     */
    public function setEtiketaes($etiketaes)
    {
        $this->etiketaes = $etiketaes;

        return $this;
    }

    /**
     * Get etiketaes
     *
     * @return string
     */
    public function getEtiketaes()
    {
        return $this->etiketaes;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set udala
     *
     * @param \Zerbikat\BackendBundle\Entity\Udala $udala
     *
     * @return Etiketa
     */
    public function setUdala(\Zerbikat\BackendBundle\Entity\Udala $udala = null)
    {
        $this->udala = $udala;

        return $this;
    }

    /**
     * Get udala
     *
     * @return \Zerbikat\BackendBundle\Entity\Udala
     */
    public function getUdala()
    {
        return $this->udala;
    }

    /**
     * Add fitxak
     *
     * @param \Zerbikat\BackendBundle\Entity\Fitxa $fitxak
     *
     * @return Etiketa
     */
    public function addFitxak(\Zerbikat\BackendBundle\Entity\Fitxa $fitxak)
    {
        $this->fitxak[] = $fitxak;

        return $this;
    }

    /**
     * Remove fitxak
     *
     * @param \Zerbikat\BackendBundle\Entity\Fitxa $fitxak
     */
    public function removeFitxak(\Zerbikat\BackendBundle\Entity\Fitxa $fitxak)
    {
        $this->fitxak->removeElement($fitxak);
    }

    /**
     * Get fitxak
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFitxak()
    {
        return $this->fitxak;
    }

    /**
     * Set origenid
     *
     * @param integer $origenid
     *
     * @return Etiketa
     */
    public function setOrigenid($origenid)
    {
        $this->origenid = $origenid;

        return $this;
    }

    /**
     * Get origenid
     *
     * @return integer
     */
    public function getOrigenid()
    {
        return $this->origenid;
    }
}
