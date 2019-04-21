<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use phpDocumentor\Reflection\Types\Self_;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PersonRepository")
 */
class Person
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="The name must be given")
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     * @Assert\GreaterThanOrEqual(value="0", message="The age must be a positive integer number")
     */
    private $age;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Person", inversedBy="father")
     * @Assert\Expression(
     *     "this.getId() != this.getFather().getId()",
     *     message="The person cannot be also their own father"
     * )
     *
     */
    private $father;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Person", inversedBy="mother")'
     * @Assert\Expression(
     *     "this.getId() != this.getMother().getId()",
     *     message="The person cannot be also their own mother"
     * )
     * @Assert\NotBlank(message="Name of mother must be given")
     */
    private $mother;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Sex", inversedBy="people")
     * @Assert\NotBlank(message="Sex must be given")
     */
    private $sex;

/*    public function __construct()
    {
        $this->father = new ArrayCollection();
        $this->mother = new ArrayCollection();

    }
*/
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getFather() //smazana Instance Person kvuli Null
    {
            return $this->father;
    }

    public function setFather(?self $father): self
    {
        $this->father = $father;

        return $this;
    }
/* tenhle bullshit se sem nejak automaticky natahl, jen u manyToMany asi???
    public function addFather(self $father): self
    {
        if (!$this->father->contains($father)) {
            $this->father[] = $father;
            $father->setFather($this);
        }

        return $this;
    }

    public function removeFather(self $father): self
    {
        if ($this->father->contains($father)) {
            $this->father->removeElement($father);
            // set the owning side to null (unless already changed)
            if ($father->getFather() === $this) {
                $father->setFather(null);
            }
        }

        return $this;
    }
*/
    public function getMother() //smazano ": Person" aby se vratila i instance of Null
    {
        return $this->mother;
    }

    public function setMother(?self $mother): self
    {
        $this->mother = $mother;

        return $this;
    }
    /* tenhle bullshit se sem nejak automaticky natahl, jen u manyToMany asi???
        public function addMother(self $mother): self
        {
            if (!$this->mother->contains($mother)) {
                $this->mother[] = $mother;
                $mother->setMother($this);
            }

            return $this;
        }

        public function removeMother(self $mother): self
        {
            if ($this->mother->contains($mother)) {
                $this->mother->removeElement($mother);
                // set the owning side to null (unless already changed)
                if ($mother->getMother() === $this) {
                    $mother->setMother(null);
                }
            }

            return $this;
        }
    */
    public function getSex(): ?Sex
    {
        return $this->sex;
    }

    public function setSex(?Sex $sex): self
    {
        $this->sex = $sex;

        return $this;
    }
}
