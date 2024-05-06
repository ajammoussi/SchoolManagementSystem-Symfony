<?php

namespace App\Entity;

/**
* @ORM\Entity(repositoryClass="App\Repository\PdfFileRepository")
*/
class PdfFile
{
    /**
    * @ORM\Column(type="string", length=255, unique=true)
    * @ORM\Id()
    */
    private $filename;

    /**
    * @ORM\Column(type="blob")
    */
    private $content;

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

    return $this;
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
}
