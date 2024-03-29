<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Participant;
use App\Entity\Sortie;
use App\Form\ParticipantType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(EntityManagerInterface $em, Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(ParticipantType::class, $user);

        // dire au formulaire de gérer la requête
        $form->handleRequest($request);
    
        // Si le formulaire a déjà été soumis
        if($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $this->addFlash('success', 'Votre profil a bien été mis à jour !');

            $em->persist($user);
            $em->flush();
        }

        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/profile/{id}/{sortie}', name: 'app_profile_viewer', requirements:['id' => '\d+', 'sortie' => '\d+'])]
    public function profileViewer(Participant $participant, Sortie $sortie): Response
    {
        $user = $this->getUser();
        return $this->render('profile/profile-viewer.html.twig', [
            'controller_name' => 'ProfileController',
            'viewed_user' => $participant,
            'user' => $user,
            'sortie' => $sortie,
        ]);
    }
}
