<?php

namespace App\Entity;

use App\Entity\AbstractClass;
use App\Repository\FAQRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * @ORM\Entity(repositoryClass=FAQRepository::class)
 */
class FAQ 
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    public $title;

    /**
     * @ORM\Column(type="boolean")
     */
    public $promoted;

    /**
     * @ORM\Column(type="StatusFAQType", nullable=false)
     * @DoctrineAssert\Enum(entity="App\DBAL\Types\StatusFAQType")     
     */
    public $status;

    

    /**
     * @var DateTime $created
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     * @Gedmo\Timestampable(on="create")
     */
    protected $createdAt;

    /**
     * @var DateTime $updated
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     * @Gedmo\Timestampable(on="update")
     */
    protected $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=AnswersFAQ::class, mappedBy="fAQ")
     */
    public $answers;

    /**
     * @ORM\OneToMany(targetEntity=HistoricFaq::class, mappedBy="faq", orphanRemoval=true)
     */
    public $historicFaqs;

    public function __construct()
    {
        
        $this->answers = new ArrayCollection();
        $this->historicFaqs = new ArrayCollection();
    }

    
  
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

    public function getPromoted(): ?bool
    {
        return $this->promoted;
    }

    public function setPromoted(bool $promoted): self
    {
        $this->promoted = $promoted;

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

    /**
     * @return Collection|AnswersFAQ[]
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(AnswersFAQ $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers[] = $answer;
            $answer->setFAQ($this);
        }

        return $this;
    }

    public function removeAnswer(AnswersFAQ $answer): self
    {
        if ($this->answers->removeElement($answer)) {
            // set the owning side to null (unless already changed)
            if ($answer->getFAQ() === $this) {
                $answer->setFAQ(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|HistoricFaq[]
     */
    public function getHistoricFaqs(): Collection
    {
        return $this->historicFaqs;
    }

    public function addHistoricFaq(HistoricFaq $historicFaq): self
    {
        if (!$this->historicFaqs->contains($historicFaq)) {
            $this->historicFaqs[] = $historicFaq;
            $historicFaq->setFaq($this);
        }

        return $this;
    }

    public function removeHistoricFaq(HistoricFaq $historicFaq): self
    {
        if ($this->historicFaqs->removeElement($historicFaq)) {
            // set the owning side to null (unless already changed)
            if ($historicFaq->getFaq() === $this) {
                $historicFaq->setFaq(null);
            }
        }

        return $this;
    }

    

   

    

   
}
