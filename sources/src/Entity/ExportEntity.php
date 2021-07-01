<?php

namespace App\Entity;

use App\Repository\FAQRepository;
use Doctrine\ORM\Mapping as ORM;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;
use Gedmo\Mapping\Annotation as Gedmo;

class ExportEntity
{
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

    public function __construct($object)
    {
       
var_dump(get_class_vars(get_class($object)));
exit;

    }
    

    
    public function setFAQ(?FAQ $fAQ): self
    {
        $this->fAQ = $fAQ;

        return $this;
    }

}
