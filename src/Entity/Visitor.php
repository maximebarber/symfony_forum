<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VisitorRepository")
 * @UniqueEntity(
 *  fields={"pseudo_visitor"},
 *  message="Ce pseudo est déjà utilisé"
 * )
 */
class Visitor implements UserInterface
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
    private $pseudo_visitor;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8", minMessage="Votre mot de passe doit faire au moins 8 caractères")
     */
    private $pwd_visitor;

    //Pas de champ ORM car n'existe pas au sein de la bdd
    /**
     * @Assert\EqualTo(propertyPath="pwd_visitor", message="Vos mots de passe ne sont pas identiques")
     */
    public $confirm_pwd_visitor;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt_visitor;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Subject", mappedBy="visitor")
     */
    private $Subject;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="visitor")
     */
    private $Message;

    public function __construct()
    {
        $this->Subject = new ArrayCollection();
        $this->Message = new ArrayCollection();
    }

    public function getId() : ? int
    {
        return $this->id;
    }

    public function getPseudoVisitor() : ? string
    {
        return $this->pseudo_visitor;
    }

    //UserInterface method (identical to above)
    public function getUsername() : ? string
    {
        return $this->pseudo_visitor;
    }

    public function setPseudoVisitor(string $pseudo_visitor) : self
    {
        $this->pseudo_visitor = $pseudo_visitor;

        return $this;
    }

    public function getPwdVisitor() : ? string
    {
        return $this->pwd_visitor;
    }

    //UserInterface method (identical to above)
    public function getPassword() : ? string
    {
        return $this->pwd_visitor;
    }

    public function setPwdVisitor(string $pwd_visitor) : self
    {
        $this->pwd_visitor = $pwd_visitor;

        return $this;
    }

    public function getCreatedAtVisitor() : ? \DateTimeInterface
    {
        return $this->createdAt_visitor;
    }

    public function setCreatedAtVisitor(\DateTimeInterface $createdAt_visitor) : self
    {
        $this->createdAt_visitor = $createdAt_visitor;

        return $this;
    }

    /**
     * @return Collection|Subject[]
     */
    public function getSubject() : Collection
    {
        return $this->Subject;
    }

    public function addSubject(Subject $subject) : self
    {
        if (!$this->Subject->contains($subject)) {
            $this->Subject[] = $subject;
            $subject->setVisitor($this);
        }

        return $this;
    }

    public function removeSubject(Subject $subject) : self
    {
        if ($this->Subject->contains($subject)) {
            $this->Subject->removeElement($subject);
            // set the owning side to null (unless already changed)
            if ($subject->getVisitor() === $this) {
                $subject->setVisitor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessage() : Collection
    {
        return $this->Message;
    }

    public function addMessage(Message $message) : self
    {
        if (!$this->Message->contains($message)) {
            $this->Message[] = $message;
            $message->setMessage($this);
        }

        return $this;
    }

    public function removeMessage(Message $message) : self
    {
        if ($this->Message->contains($message)) {
            $this->Message->removeElement($message);
            // set the owning side to null (unless already changed)
            if ($message->getMessage() === $this) {
                $message->setMessage(null);
            }
        }

        return $this;
    }

    //Next 3 methods are required by UserInterface along with getPassword and getUsername
    public function eraseCredentials() {}

    public function getSalt() {}

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function __toString()
    {
        return $this->pseudo_visitor;
    }
}
