<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MessageRepository")
 */
class Message
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt_message;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $modifiedAt_message;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Visitor", inversedBy="Message")
     */
    private $visitor;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Subject", inversedBy="Message")
     * @ORM\JoinColumn(nullable=false)
     */
    private $subject;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAtMessage(): ?\DateTimeInterface
    {
        return $this->createdAt_message;
    }

    public function setCreatedAtMessage(\DateTimeInterface $createdAt_message): self
    {
        $this->createdAt_message = $createdAt_message;

        return $this;
    }

    public function getNumberMessage(): ?int
    {
        return $this->number_message;
    }

    public function setNumberMessage(int $number_message): self
    {
        $this->number_message = $number_message;

        return $this;
    }

    public function getModifiedAtMessage(): ?\DateTimeInterface
    {
        return $this->modifiedAt_message;
    }

    public function setModifiedAtMessage(?\DateTimeInterface $modifiedAt_message): self
    {
        $this->modifiedAt_message = $modifiedAt_message;

        return $this;
    }

    public function getMessage(): ?Visitor
    {
        return $this->Message;
    }

    public function setMessage(?Visitor $Message): self
    {
        $this->Message = $Message;

        return $this;
    }

    public function getVisitor(): ?Visitor
    {
        return $this->visitor;
    }

    public function setVisitor(?Visitor $visitor): self
    {
        $this->visitor = $visitor;

        return $this;
    }

    public function getSubject(): ?Subject
    {
        return $this->subject;
    }

    public function setSubject(?Subject $subject): self
    {
        $this->subject = $subject;

        return $this;
    }
}
