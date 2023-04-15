<?php

namespace App\Entity;

class Achat
{
    private ?int $id = null;

    private Produit $produit;

    private ?int $quantite = null;

    private ?float $prixAchat = null;



    public function __construct($produit)
    {
        $this->produit = $produit;
        $this->quantite = 1;
        $this->prixAchat = $produit->getPrix();
    }
    

    public function update($qtn) {
        $this->quantite = $qtn;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduit(){
        return $this->produit;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite($qnt)
    {
        return $this->quantite = $qnt;
    }

    public function getPrixAchat(): ?float
    {
        return $this->prixAchat;
    }

}
