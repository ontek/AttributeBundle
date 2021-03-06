<?php

namespace Padam87\AttributeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="attribute_schema")
 * @UniqueEntity("className")
 */
class Schema
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    protected $className;

    /**
     * @Assert\Valid
     * @ORM\OneToMany(targetEntity="Attribute", mappedBy="schema", orphanRemoval=true, cascade={"persist", "remove"})
     * @ORM\OrderBy({"orderIndex" = "ASC"})
     */
    protected $attributes;

    /**
     * @ORM\OneToMany(targetEntity="Group", mappedBy="schema", orphanRemoval=true, cascade={"persist", "remove"})
     * @ORM\OrderBy({"name" = "ASC"})
     */
    protected $groups;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->attributes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->className;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __get($name)
    {
        $getter = "get" . ucfirst($name);

        return $this->$getter();
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
     * Add attributes
     *
     * @param  \Padam87\AttributeBundle\Entity\Attribute $attributes
     * @return Schema
     */
    public function addAttribute(\Padam87\AttributeBundle\Entity\Attribute $attributes)
    {
        $attributes->setSchema($this);
        $this->attributes[] = $attributes;

        return $this;
    }

    /**
     * Remove attributes
     *
     * @param \Padam87\AttributeBundle\Entity\Attribute $attributes
     */
    public function removeAttribute(\Padam87\AttributeBundle\Entity\Attribute $attributes)
    {
        $this->attributes->removeElement($attributes);
    }

    /**
     * Get attributes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Set className
     *
     * @param  string $className
     * @return Schema
     */
    public function setClassName($className)
    {
        $this->className = $className;

        return $this;
    }

    /**
     * Get className
     *
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * Add groups
     *
     * @param  \Padam87\AttributeBundle\Entity\Group $groups
     * @return Schema
     */
    public function addGroup(\Padam87\AttributeBundle\Entity\Group $groups)
    {
        $groups->setSchema($this);
        $this->groups[] = $groups;

        return $this;
    }

    /**
     * Remove groups
     *
     * @param \Padam87\AttributeBundle\Entity\Group $groups
     */
    public function removeGroup(\Padam87\AttributeBundle\Entity\Group $groups)
    {
        $this->groups->removeElement($groups);
    }

    /**
     * Get groups
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGroups()
    {
        return $this->groups;
    }
}
