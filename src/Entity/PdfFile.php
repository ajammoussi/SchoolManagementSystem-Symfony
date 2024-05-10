<?php

namespace App\Entity;

use App\Repository\PdfFileRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PdfFileRepository::class)]
class PdfFile
{

    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private ?string $filename = null;

    #[ORM\Column(type: 'blob')]
    private $content;

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): static
    {
        $this->filename = $filename;

        return $this;
    }

    public function getContent()
    {
        // Return content as a stream
        return stream_get_contents($this->content);
    }

    public function setContent($content): self
    {
        // If the passed content is a resource, use it directly
        if (is_resource($content)) {
            $this->content = $content;
        } else {
            // Else, create a stream from the string
            $this->content = fopen('php://memory', 'r+');
            fwrite($this->content, $content);
            rewind($this->content);
        }

        return $this;
    }
}
