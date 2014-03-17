<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Gy\CoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Product
{
    
    /**
     * @var MongoId $id
     */
    protected $id;

    /**
     * @var increment $gid
     */
    protected $gid;

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var collection $price
     */
    protected $price;

    /**
     * @var string $description
     */
    protected $description;

    /**
     * @var collection $category
     */
    protected $category;

    /**
     * @var hash $attributes
     */
    protected $attributes;

    /**
     * @var date $createdAt
     */
    protected $createdAt;

    

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set gid
     *
     * @param increment $gid
     * @return self
     */
    public function setGid($gid)
    {
        $this->gid = $gid;
        return $this;
    }

    /**
     * Get gid
     *
     * @return increment $gid
     */
    public function getGid()
    {
        return $this->gid;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set price
     *
     * @param collection $price
     * @return self
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * Get price
     *
     * @return collection $price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set category
     *
     * @param collection $category
     * @return self
     */
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * Get category
     *
     * @return collection $category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set attributes
     *
     * @param hash $attributes
     * @return self
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * Get attributes
     *
     * @return hash $attributes
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Set createdAt
     *
     * @param date $createdAt
     * @return self
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return date $createdAt
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    /**
     * @var string $chineseName
     */
    protected $chineseName;

    /**
     * @var float $cost
     */
    protected $cost;


    /**
     * Set chineseName
     *
     * @param string $chineseName
     * @return self
     */
    public function setChineseName($chineseName)
    {
        $this->chineseName = $chineseName;
        return $this;
    }

    /**
     * Get chineseName
     *
     * @return string $chineseName
     */
    public function getChineseName()
    {
        return $this->chineseName;
    }

    /**
     * Set cost
     *
     * @param float $cost
     * @return self
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
        return $this;
    }

    /**
     * Get cost
     *
     * @return float $cost
     */
    public function getCost()
    {
        return $this->cost;
    }
    /**
     * @var boolean $isSerial
     */
    protected $isSerial;


    /**
     * Set isSerial
     *
     * @param boolean $isSerial
     * @return self
     */
    public function setIsSerial($isSerial)
    {
        $this->isSerial = $isSerial;
        return $this;
    }

    /**
     * Get isSerial
     *
     * @return boolean $isSerial
     */
    public function getIsSerial()
    {
        return $this->isSerial;
    }
    /**
     * @var int $sold
     */
    protected $sold;


    /**
     * Set sold
     *
     * @param int $sold
     * @return self
     */
    public function setSold($sold)
    {
        $this->sold = $sold;
        return $this;
    }

    /**
     * Get sold
     *
     * @return int $sold
     */
    public function getSold()
    {
        return $this->sold;
    }
}
