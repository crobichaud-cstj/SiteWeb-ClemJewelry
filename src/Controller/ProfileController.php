<?php

namespace App\Controller;

use App\Core\Notification;
use App\Core\NotificationColor;
use App\Entity\Client;
use App\Form\ModificationFormType;
use App\Form\ModificationMotDePasseFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


class ProfileController extends AbstractController
{
    #[Route('/profil', name: 'app_profile')]
    public function index(Request $request, 
    UserPasswordHasherInterface $userPasswordHasher,
    Security $security, 
    EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ModificationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $this->addFlash('profile_info', new Notification('success', "Votre profile a été modifié", NotificationColor::PRIMARY));


            $entityManager->persist($user);
            $entityManager->flush();

            $security->login($user);

            return $this->redirectToRoute('app_profile');
        }

        if($form->isSubmitted() && !($form->isValid())){
            $this->addFlash('profile_info', new Notification('error', "Impossible de modifier votre profil, consulter les erreurs ci-dessous.", NotificationColor::DANGER));
        }

        $formPass = $this->createForm(ModificationMotDePasseFormType::class);
        $formPass->handleRequest($request);

        if ($formPass->isSubmitted() && $formPass->isValid()) {

            $newPass = $formPass->getData()["password"];
            $oldPass = $formPass->getData()["oldPassword"];


            if($userPasswordHasher->isPasswordValid($user, $oldPass)){
                
                

                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $newPass
                    )
                );

                $this->addFlash('profile_pass', new Notification('success', "Le mot de passe est changé", NotificationColor::PRIMARY));

                $entityManager->persist($user);
                $entityManager->flush();
    
                $security->login($user);
    
                return $this->redirectToRoute('app_profile');
            }
            else{
                $this->addFlash('profile_pass', new Notification('error', "Le mot de passe actuel n'est pas le bon", NotificationColor::DANGER));
            }




        }

        return $this->render('profile/index.html.twig', [
            'modificationForm' => $form->createView(),
            'motDePasseForm' => $formPass->createView()
        ]);
    }

    
}
