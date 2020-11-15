<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @UniqueEntity(   fields= {"email"}, message="Désoler un client existe deja pour cette adresse email" )
 * @UniqueEntity(   fields= {"name_business"}, message="Désoler un client existe deja pour cette entreprise" )
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name_business;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Your name cannot contain a number"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Assert\Regex(
     *     pattern     = "/^[0-9]+$/i",
     *     htmlPattern = "^[0-9]+$"
     * )
     * @Assert\Length(
     *      min = 10,
     *      max = 10,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     */
    private $phone_number;

    /**
     * @ORM\OneToMany(targetEntity=Website::class, mappedBy="client", orphanRemoval=true)
     */
    private $client;

    public function __construct()
    {
        $this->client = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getId().' - '.$this->getName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameBusiness(): ?string
    {
        return $this->name_business;
    }

    public function setNameBusiness(string $name_business): self
    {
        $this->name_business = $name_business;

        return $this;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(?string $phone_number): self
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    /**
     * @return Collection|Website[]
     */
    public function getClient(): Collection
    {
        return $this->client;
    }

    public function addClient(Website $client): self
    {
        if (!$this->client->contains($client)) {
            $this->client[] = $client;
            $client->setClient($this);
        }

        return $this;
    }

    public function removeClient(Website $client): self
    {
        if ($this->client->removeElement($client)) {
            // set the owning side to null (unless already changed)
            if ($client->getClient() === $this) {
                $client->setClient(null);
            }
        }

        return $this;
    }
}
