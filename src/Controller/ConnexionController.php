<?php

namespace App\Controller;

use App\Core\Notification;
use App\Core\NotificationColor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ConnexionController extends AbstractController
{
    #[Route('/connexion', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        if($this->getUser()) {
            return $this->redirectToRoute('app_profile');
        }

        $notification = null;
        $error = $authenticationUtils->getLastAuthenticationError();
        if($error != null && $error->getMessageKey() === 'Invalid credentials.') {
            $message = "Mauvaise combinaison d'identifiant et de mot de passe.";
            $notification = new Notification('error', $message, NotificationColor::WARNING);
        }

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('connexion/index.html.twig', [
            'last_username' => $lastUsername,
            'notification' => $notification
        ]);
    }

    #[Route('/deconnexion', name: 'app_logout')]
    public function deconnexion()
    {
        throw new \Exception("Don't forget to activate logout in security.yaml");
    }
}
