<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[ORM\Table(name: 'produits')]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column('idProduit')]
    private ?int $idProduit = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column(name: 'quantiteEnStock')]
    private ?int $quantiteEnStock = null;

    #[ORM\Column(length: 2048)]
    private ?string $description = null;

    #[ORM\Column(name: 'imagePath', length: 1024)]
    private ?string $imagePath = null;

    #[ORM\ManyToOne(targetEntity:Categorie::class,inversedBy:"produits", cascade:["persist"])]
    #[ORM\JoinColumn(name:'idMainCategorie', referencedColumnName:'idCategorie')]
     private $mainCategorie;

     public function __construct($nom, $prix, $quantiteEnStock, $description, $imagePath)
     {
        $this->nom = $nom;
        $this->prix = $prix;
        $this->quantiteEnStock = $quantiteEnStock;
        $this->description = $description;
        $this->imagePath = $imagePath;
     }

     public function getMainCategorie(): ?Categorie
    {
        return $this->mainCategorie;
    }

    public function getIdProduit(): ?int
    {
        return $this->idProduit;
    }


    public function getNom(): ?string
    {
        return $this->nom;
    }


    public function getPrix(): ?float
    {
        return $this->prix;
    }


    public function getQuantiteEnStock(): ?int
    {
        return $this->quantiteEnStock;
    }



    public function getDescription(): ?string
    {
        return $this->description;
    }


    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }


}
