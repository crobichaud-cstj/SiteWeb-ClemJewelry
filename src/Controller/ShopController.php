<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use SebastianBergmann\Environment\Console;

class ShopController extends AbstractController
{

    private $em = null;
    #[Route('/', name: 'app_shop')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        //! DANGER Ligne importante pour les donctions utilitaires
    $this->em = $doctrine->getManager();

    $categories = $request->query->get('categories'); // $_GET['role']
    $searchField = $request->request->get('search_field'); // $_POST['search_field']

        $categories = $this->retieveAllCategories();

        $categorie = $request->query->get('categorie'); // $_GET['role']

        $produits = $this->retrieveProduits($categorie, $searchField);


        return $this->render('shop/index.html.twig', ['produits' => $produits, 'categories' => $categories ]);
    }

    #[Route('/produit/{idProduit}', name:'produit_modal')]
    public function infoProduit($idProduit, Request $request, ManagerRegistry $doctrine):Response{

        $this->em = $doctrine->getManager();

        $produit = $this->em->getRepository(Produit::class)->find($idProduit);

        
        return $this->render('shop/produit.modal.twig', ['produit' => $produit]);

    }
    private function retieveAllCategories(){
        return $this->em->getRepository(Categorie::class)->findAll();
    }
    private function retrieveProduits($categorie, $searchField){
       return $this->em->getRepository(Produit::class)->findWithCriteria($categorie, $searchField);
    }


}
