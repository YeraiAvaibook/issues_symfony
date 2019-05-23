<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IncidenciaRepository")
 */
class Incidencia
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(
     *     message="El título no puede ser nulo"
     * )
     * @Assert\Length(
     *     min="2",
     *     max="255",
     *     minMessage="Demasiado corto",
     *     maxMessage="Demasiado largo"
     * )
     */
    private $titulo;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\Column(name="fechaCreacion",type="datetime")
     * @Assert\NotNull(
     *     message="La fecha no puede ser nula"
     * )
     * @Assert\DateTime(
     *     message="Fecha incorrecta"
     * )
     */
    private $fechaCreacion;

    /**
     * @ORM\Column(type="boolean")
     */
    private $resuelta;

    /**
     * @ORM\Column(name="fechaResolucion",type="datetime", nullable=true)
     * @Assert\DateTime(
     *     message="Fecha incorrecta"
     * )
     */
    private $fechaResolucion;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categoria", inversedBy="incidencias")
     */
    private $categoria;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag")
     * @ORM\JoinTable(name="incidencias_tags",
     *     joinColumns={@ORM\JoinColumn(name="incidencia_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")}
     * )
     */
    private $tags;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $imagenes;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="incidencias")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;

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

    public function getFechaCreacion(): ?\DateTimeInterface
    {
        return $this->fechaCreacion;
    }

    public function setFechaCreacion(\DateTimeInterface $fechaCreacion): self
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    public function getResuelta(): ?bool
    {
        return $this->resuelta;
    }

    public function setResuelta(bool $resuelta): self
    {
        $this->resuelta = $resuelta;

        return $this;
    }

    public function getFechaResolucion(): ?\DateTimeInterface
    {
        return $this->fechaResolucion;
    }

    public function setFechaResolucion(\DateTimeInterface $fechaResolucion = null): self
    {
        $this->fechaResolucion = $fechaResolucion;

        return $this;
    }

    public function getCategoria(): ?Categoria
    {
        return $this->categoria;
    }

    public function setCategoria(?Categoria $categoria = null): self
    {
        $this->categoria = $categoria;

        return $this;
    }

    public function getTag(): ?Collection
    {
        return $this->tags;
    }

    public function setTag(?Tag $tags = null): self
    {
        $this->tags = $tags;

        return $this;
    }

    public function __toString()
    {
        return $this->getTitulo();
    }

    public function getImagenes(): ?string
    {
        return $this->imagenes;
    }

    public function setImagenes(?string $imagenes): self
    {
        $this->imagenes = $imagenes;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
