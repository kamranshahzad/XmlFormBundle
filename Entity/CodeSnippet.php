<?php

namespace Kamran\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tags
 *
 * @ORM\Table(name="code_snippet")
 * @ORM\Entity
 */
class CodeSnippet
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="codetext", type="text")
     */
    private $codetext;

    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    public function setCodetext($text)
    {
        $this->codetext = $text;

        return $this;
    }

    public function getCodetext()
    {
        return $this->codetext;
    }

    /*
    * Relationships
    */
    public function __toString()
    {
        return $this->codetext;
    }

}
