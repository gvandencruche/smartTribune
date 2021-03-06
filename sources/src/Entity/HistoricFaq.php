<?php

namespace App\Entity;

use App\Repository\HistoricFaqRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=HistoricFaqRepository::class)
 */
class HistoricFaq 
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    public $title;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    public $status;

    /**
     * @var DateTime $created
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     * @Gedmo\Timestampable(on="create")
     */
    public $createdAt;

    /**
     * @var DateTime $updated
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     * @Gedmo\Timestampable(on="update")
     */
    public $updatedAt;


    /**
     * @ORM\ManyToOne(targetEntity=FAQ::class, inversedBy="historicFaqs")
     * @ORM\JoinColumn(nullable=false)
     */
    public $faq;

    public function __toString()
    {
        return (string) $this;
    }
   
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getFaq(): ?FAQ
    {
        return $this->faq;
    }

    public function setFaq(?FAQ $faq): self
    {
        $this->faq = $faq;

        return $this;
    }

   
}
