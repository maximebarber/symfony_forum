<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VisitorRepository")
 */
class Visitor
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $number_visitor;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pseudo_visitor;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pwd_visitor;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt_visitor;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Subject", mappedBy="visitor")
     */
    private $Subject;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="Message")
     */
    private $Message;

    public function __construct()
    {
        $this->Subject = new ArrayCollection();
        $this->Message = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumberVisitor(): ?int
    {
        return $this->number_visitor;
    }

    public function setNumberVisitor(int $number_visitor): self
    {
        $this->number_visitor = $number_visitor;

        return $this;
    }

    public function getPseudoVisitor(): ?string
    {
        return $this->pseudo_visitor;
    }

    public function setPseudoVisitor(string $pseudo_visitor): self
    {
        $this->pseudo_visitor = $pseudo_visitor;

        return $this;
    }

    public function getPwdVisitor(): ?string
    {
        return $this->pwd_visitor;
    }

    public function setPwdVisitor(string $pwd_visitor): self
    {
        $this->pwd_visitor = $pwd_visitor;

        return $this;
    }

    public function getCreatedAtVisitor(): ?\DateTimeInterface
    {
        return $this->createdAt_visitor;
    }

    public function setCreatedAtVisitor(\DateTimeInterface $createdAt_visitor): self
    {
        $this->createdAt_visitor = $createdAt_visitor;

        return $this;
    }

    /**
     * @return Collection|Subject[]
     */
    public function getSubject(): Collection
    {
        return $this->Subject;
    }

    public function addSubject(Subject $subject): self
    {
        if (!$this->Subject->contains($subject)) {
            $this->Subject[] = $subject;
            $subject->setVisitor($this);
        }

        return $this;
    }

    public function removeSubject(Subject $subject): self
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
    public function getMessage(): Collection
    {
        return $this->Message;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->Message->contains($message)) {
            $this->Message[] = $message;
            $message->setMessage($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
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
}
