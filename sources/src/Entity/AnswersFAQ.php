<?php

namespace App\Entity;

use App\Repository\FAQRepository;
use Doctrine\ORM\Mapping as ORM;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=AnswersFAQRepository::class)
 */

class AnswersFAQ
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    

    /**
     * @ORM\Column(name="channel", type="AnswersChannelFAQType", nullable=false)
     * @DoctrineAssert\Enum(entity="App\DBAL\Types\AnswersChannelFAQType")     
     */
    private $channel;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $body;

    /**
     * @ORM\ManyToOne(targetEntity=FAQ::class, inversedBy="answers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fAQ;

    
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChannel(): ?string
    {
        return $this->channel;
    }

    public function setChannel(string $channel): self
    {
        $this->channel = $channel;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getFAQ(): ?FAQ
    {
        return $this->fAQ;
    }

    public function setFAQ(?FAQ $fAQ): self
    {
        $this->fAQ = $fAQ;

        return $this;
    }

}
