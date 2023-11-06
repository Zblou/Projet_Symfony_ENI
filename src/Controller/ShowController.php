<?php

namespace App\Controller;



use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ShowController extends AbstractController

{
    #[Route('/show/profile/{id}', name: 'show_profile',requirements: ['id' => '\d+'], methods: ['GET'])]
    public function showProfile(User $user, UserRepository $userRepository): Response{

        return $this->render('profile/showProfile.html.twig', [

            'user' => $user
        ]);
    }

}