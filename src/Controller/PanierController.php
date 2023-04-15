<?php

namespace App\Controller;

use App\Core\Constantes;
use App\Core\Notification;
use App\Core\NotificationColor;
use App\Entity\Panier;
use App\Entity\Produit;
use App\Entity\Achat;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    private $em = null;
    private $panier;


    #[Route('/panier', name: 'app_panier')]
    public function index(Request $request): Response
    {
        
        $this->initSession($request);
        $session = $request->getSession();
        $this->panier->calculateSummary();
        
        return $this->render('panier/index.html.twig', [
            'name' => $session->get('name'),
            'panier' => $this->panier
        ]);
        
    }



    
    #[Route('/panier/ajout/{idProduit}', name:'produit_add')]
    public function addProduit($idProduit, Request $request,ManagerRegistry $doctrine) : Response {

        

            $this->em = $doctrine->getManager();
            $this->initSession($request);
            $produit =  $this->em->find(Produit::class, $idProduit);
            if($produit !== null){
            $achat = new Achat($produit);
            $this->panier->add($achat);
            
            $this->panier->calculateSummary();
            return $this->redirectToRoute('app_panier');

        }
        return $this->redirectToRoute('app_panier');



    }
    

    #[Route('/panier/update', name:'produit_update', methods:['POST'])]
    public function updatePanier(Request $request) : Response {
        $post = $request->request->all();
        $this->initSession($request);

        $action = $request->request->get('action');

        
        if($action == "update" && count($this->panier->getAchats()) != 0)
        {
            $this->panier->update($post);
            $this->addFlash('panier', new Notification('success', 'Panier rechargé', NotificationColor::PRIMARY)); //$resquest->getSession()->getFlashBag()->add();

        }else if ($action == "empty"){
            $session = $request->getSession();
            $session->remove('panier');
        }
        $this->panier->update($post);

        $this->panier->calculateSummary();
        return $this->redirectToRoute('app_panier');
    }
    

    #[Route('/panier/supprimer/{index}', name:'produit_delete')]
    public function deleteAchat($index, Request $request) : Response {

        $this->initSession($request);
        $this->panier->delete($index);
        $this->panier->calculateSummary();
        return $this->redirectToRoute('app_panier');

    }

    private function initSession(Request $request) {

        $session = $request->getSession();

        $session->set('name', 'panier');

        $this->panier = $session->get('panier', new Panier());
        $session->set('panier', $this->panier);


    }

}
