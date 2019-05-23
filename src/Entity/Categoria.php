<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoriaRepository")
 */
class Categoria
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
    private $nombre;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Incidencia", mappedBy="categoria")
     */
    private $incidencias;

    public function __construct()
    {
        $this->incidencias = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * @return Collection|Incidencia[]
     */
    public function getIncidencias(): Collection
    {
        return $this->incidencias;
    }

    public function addIncidencia(Incidencia $incidencia): self
    {
        if (!$this->incidencias->contains($incidencia)) {
            $this->incidencias[] = $incidencia;
            $incidencia->setCategoria($this);
        }

        return $this;
    }

    public function removeIncidencia(Incidencia $incidencia): self
    {
        if ($this->incidencias->contains($incidencia)) {
            $this->incidencias->removeElement($incidencia);
            // set the owning side to null (unless already changed)
            if ($incidencia->getCategoria() === $this) {
                $incidencia->setCategoria(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getNombre();
    }
}
