<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
#[ORM\Table(name:'categories')]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column('idCategorie')]
    private ?int $idCategorie = null;

    #[ORM\Column(length: 64)]
    private ?string $categorie = null;

    public function getIdCategorie(): ?int
    {
        return $this->idCategorie;
    }


    #[ORM\OneToMany(targetEntity:Produit::class, mappedBy:"mainCategorie", fetch:"LAZY")]
    private $produits;

    public function getProduits(): Collection {
        return $this->produits;
    }
    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    
}
