<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 *     fields= {"email"},message = "cet email est deja attribué à un autre utilisateur")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */

    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\Email(message = "Cet email '{{ value }}' n'est pas valide.", checkMX = true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     *@Assert\Length(min = 8, minMessage = "Le mot de passe doit contenir 8 caractères au minimum")
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath = "password", message ="Les mots de passe doivent être mêmes")
     */
    public $confirm_password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Sujet", mappedBy="user", orphanRemoval=true)
     */
    private $sujetuser;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function eraseCredentials(){}

    public function getSalt(){}

    public  function getRoles(){

        return ['ROLE_USER'];
    }

    /**
     * @return Collection|Sujet[]
     */
    public function getSujetuser(): Collection
    {
        return $this->sujetuser;
    }

    public function addSujetuser(Sujet $sujetuser): self
    {
        if (!$this->sujetuser->contains($sujetuser)) {
            $this->sujetuser[] = $sujetuser;
            $sujetuser->setUser($this);
        }

        return $this;
    }

    public function removeSujetuser(Sujet $sujetuser): self
    {
        if ($this->sujetuser->contains($sujetuser)) {
            $this->sujetuser->removeElement($sujetuser);
            // set the owning side to null (unless already changed)
            if ($sujetuser->getUser() === $this) {
                $sujetuser->setUser(null);
            }
        }

        return $this;
    }


}
