<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SubjectRepository")
 */
class Subject
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
    private $title_subject;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt_subject;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $modifiedAt_subject;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Visitor", inversedBy="Subject")
     */
    private $visitor;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="subject", orphanRemoval=true)
     */
    private $messages;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="subjects")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    public function __construct()
    {
        $this->Message = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

    public function getId() : ? int
    {
        return $this->id;
    }

    public function getTitleSubject() : ? string
    {
        return $this->title_subject;
    }

    public function setTitleSubject(string $title_subject) : self
    {
        $this->title_subject = $title_subject;

        return $this;
    }

    public function getCreatedAtSubject() : ? \DateTimeInterface
    {
        return $this->createdAt_subject;
    }

    public function setCreatedAtSubject(\DateTimeInterface $createdAt_subject) : self
    {
        $this->createdAt_subject = $createdAt_subject;

        return $this;
    }


    public function getModifiedAtSubject() : ? \DateTimeInterface
    {
        return $this->modifiedAt_subject;
    }

    public function setModifiedAtSubject(? \DateTimeInterface $modifiedAt_subject) : self
    {
        $this->modifiedAt_subject = $modifiedAt_subject;

        return $this;
    }

    public function getVisitor() : ? Visitor
    {
        return $this->visitor;
    }

    public function setVisitor(? Visitor $visitor) : self
    {
        $this->visitor = $visitor;

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
            $message->setSubject($this);
        }

        return $this;
    }

    public function removeMessage(Message $message) : self
    {
        if ($this->Message->contains($message)) {
            $this->Message->removeElement($message);
            // set the owning side to null (unless already changed)
            if ($message->getSubject() === $this) {
                $message->setSubject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function __toString()
    {
        return (string)($this->id);
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
