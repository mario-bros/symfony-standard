<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Inventory
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InventoryRepository")
 * @ORM\Table(name="inventory")
 * @ORM\HasLifecycleCallbacks
 */
class Inventory
{
    /**
     * @var integer
     *
     * @ORM\Column(name="quantity_per_unit", type="integer", nullable=false)
     * @Assert\Type(type="integer")
     */
    private $quantityPerUnit = '1';

    /**
     * @var string
     *
     * @ORM\Column(name="unit_price", type="decimal", precision=10, scale=2, nullable=false)
     * @Assert\Type(type="float")
     */
    private $unitPrice = '0.00';

    /**
     * @var integer
     *
     * @ORM\Column(name="units_in_stock", type="integer", nullable=false)
     * @Assert\Type(type="integer")
     */
    private $unitsInStock = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="units_on_order", type="integer", nullable=false)
     * @Assert\Type(type="integer")
     */
    private $unitsOnOrder = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="safety_stock", type="integer", nullable=false)
     * @Assert\Type(type="integer")
     */
    private $safetyStock = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     * @Assert\Type(type="string")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="picture", type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @var string
     *
     * @ORM\Column(name="nama", type="string", length=255, nullable=false)
     * @Assert\Type(type="string")
     */
    private $nama;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;

    private $temp;

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;

        // check if we have an old image path
        if (isset($this->picture)) {
            // store the old name to delete after the update
            $this->temp = $this->picture;
            $this->picture = null;
        } else {
            $this->picture = $file->getFilename();
        }
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->getFile()) {
            // do whatever you want to generate a unique name
            $filename = sha1(uniqid(mt_rand(), true));
            $this->picture = $filename.'.'.$this->getFile()->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->getFile()->move($this->getUploadRootDir(), $this->picture);

        // check if we have an old image
        if (isset($this->temp)) {
            // delete the old image
            unlink($this->getUploadRootDir() . $this->temp);
            // clear the temp image path
            $this->temp = null;
        }
        $this->file = null;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set quantityPerUnit
     *
     * @param integer $quantityPerUnit
     *
     * @return Inventory
     */
    public function setQuantityPerUnit($quantityPerUnit)
    {
        $this->quantityPerUnit = $quantityPerUnit;

        return $this;
    }

    /**
     * Get quantityPerUnit
     *
     * @return integer
     */
    public function getQuantityPerUnit()
    {
        return $this->quantityPerUnit;
    }

    /**
     * Set unitPrice
     *
     * @param string $unitPrice
     *
     * @return Inventory
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    /**
     * Get unitPrice
     *
     * @return string
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * Set unitsInStock
     *
     * @param integer $unitsInStock
     *
     * @return Inventory
     */
    public function setUnitsInStock($unitsInStock)
    {
        $this->unitsInStock = $unitsInStock;

        return $this;
    }

    /**
     * Get unitsInStock
     *
     * @return integer
     */
    public function getUnitsInStock()
    {
        return $this->unitsInStock;
    }

    /**
     * Set unitsOnOrder
     *
     * @param integer $unitsOnOrder
     *
     * @return Inventory
     */
    public function setUnitsOnOrder($unitsOnOrder)
    {
        $this->unitsOnOrder = $unitsOnOrder;

        return $this;
    }

    /**
     * Get unitsOnOrder
     *
     * @return integer
     */
    public function getUnitsOnOrder()
    {
        return $this->unitsOnOrder;
    }

    /**
     * Set safetyStock
     *
     * @param integer $safetyStock
     *
     * @return Inventory
     */
    public function setSafetyStock($safetyStock)
    {
        $this->safetyStock = $safetyStock;

        return $this;
    }

    /**
     * Get safetyStock
     *
     * @return integer
     */
    public function getSafetyStock()
    {
        return $this->safetyStock;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Inventory
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set picture
     *
     * @param string $picture
     *
     * @return Inventory
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set nama
     *
     * @param string $nama
     *
     * @return Inventory
     */
    public function setNama($nama)
    {
        $this->nama = $nama;

        return $this;
    }

    /**
     * Get nama
     *
     * @return string
     */
    public function getNama()
    {
        return $this->nama;
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

    public function getAbsolutePath()
    {
        return $this->getUploadRootDir().'/';
    }

    public function getWebPath()
    {
        return $this->getUploadDir().'/';
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/images';
    }

    public function getPicturePath()
    {
        if ( $this->picture !== '' and !empty($this->picture) )
            return $this->picture;
        else
            return 'No_Image_Available.png';
    }
}
