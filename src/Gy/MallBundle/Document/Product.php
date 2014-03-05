<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Gy\MallBundle\Document;

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
     * @var string $name
     */
    protected $name;

    /**
     * @var float $price
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
     * @var date $createdat
     */
    protected $createdat;


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
     * @param float $price
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
     * @return float $price
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
     * Set createdat
     *
     * @param date $createdat
     * @return self
     */
    public function setCreatedat($createdat)
    {
        $this->createdat = $createdat;
        return $this;
    }

    /**
     * Get createdat
     *
     * @return date $createdat
     */
    public function getCreatedat()
    {
        return $this->createdat;
    }
}
