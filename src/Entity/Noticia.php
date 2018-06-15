<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NoticiaRepository")
 */
class Noticia
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $seccion;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $equipo;

    /**
     * @ORM\Column(type="string", length=8)
     */
    private $fecha;

    /**
     * @ORM\Column(type="text")
     */
    private $textoNoticia;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $textoTitular;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imagen;

    
    public function getId()
    {
        return $this->id;
    }

    public function getSeccion()
    {
        return $this->seccion;
    }

    public function setSeccion(string $seccion)
    {
        $this->seccion = $seccion;
        
    }

    public function getEquipo()
    {
        return $this->equipo;
    }

    public function setEquipo(string $equipo)
    {
        $this->equipo = $equipo;

    }

    public function getFecha(): ?string
    {
        return $this->fecha;
    }

    public function setFecha(string $fecha)
    {
        $this->fecha = $fecha;
        
    }

    public function getTextoNoticia(): ?string
    {
        return $this->textoNoticia;
    }

    public function setTextoNoticia(string $textoNoticia)
    {
        $this->textoNoticia = $textoNoticia;

        return $this;
    }

    public function getTextoTitular()
    {
        return $this->textoTitular;
    }

    public function setTextoTitular(string $textoTitular)
    {
        $this->textoTitular = $textoTitular;

        return $this;
    }

    public function getImagen()
    {
        return $this->imagen;
    }

    public function setImagen(string $imagen)
    {
        $this->imagen = $imagen;

        return $this;
    }
}
