<?php

namespace App\Entity;

use App\Core\Constantes;

class Panier
{

    private $achats = [];

    public function delete($index){
        if(array_key_exists($index, $this->achats)){
            unset($this->achats[$index]);
        }
    }

    public function add(Achat $achat) {

        $achatExist = $this->checkIfExist($achat);

        if($achatExist == "false"){
            $this->achats[] = $achat;
        }
        else{
            $quantite = $this->achats[$achatExist]->getQuantite();
            $this->achats[$achatExist]->setQuantite($quantite + 1);
        }
    }

    //Need to add calculate sum and add 
    private ?float $shipping = 0;

    public function getShipping(){
        return $this->shipping;
    }
    private float $subtotal = 0;

    public function getSubtotal(){
        return $this->subtotal;
    }
    private float $priceTPS = 0;

    public function getPriceTPS(){
        return $this->priceTPS;
    }
    private float $priceTVQ = 0;

    public function getPriceTVQ(){
        return $this->priceTVQ;
    }
    private float $total = 0;

    public function getTotal(){
        return $this->total;
    }


    public function calculateSummary(){
        $this->shipping = 0;
        $this->priceTPS = 0;
        $this->priceTVQ = 0;
        $this->total = 0;
        $this->subtotal = 0;


        if(count($this->achats) != 0){
            $this->shipping = Constantes::SHIPPING;     
        }
        else{
            $this->shipping = 0;







            
        }
       

        foreach ($this->achats as $achat) {
            
            $this->subtotal += $achat->getPrixAchat() * $achat->getQuantite();
        }
        $this->priceTPS += round($this->subtotal * Constantes::TPS, 2);
        $this->priceTVQ += round($this->subtotal * Constantes::TVQ,2);

        $this->total = $this->shipping + $this->subtotal + $this->priceTPS + $this->priceTVQ;

    }

    public function update($newAchats){

        if(count($this->achats) > 0){
            $achatQTN = $newAchats["inputQTN"];
            foreach($this->achats as $key => $achat){


                if($achat->getQuantite() <= 0){
                    $this->delete($key);
                }else{
                    $newQTN = $achatQTN[$key];
                    if($newQTN >= 1){
                        $achat->update($newQTN);
                    }
                }

               
            }

        }
        

    }
    private function checkIfExist($achat){

        $i = 0;

        foreach ($this->achats as $achatOfList) {
            $i++;
            if($achatOfList->getProduit()->getIdProduit() == $achat->getProduit()->getIdProduit()){
                return $i -1;
            }
        }
        return "false";

    }

    

    public function getAchats(){
        return $this->achats;
    }

    public function getProduits(){
        return $this->achats;
    }

}
