<?php

namespace App\Controller;

use App\Form\MyProfileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile', methods: ['GET','POST'])]
    public function index(User $user, Request $request): Response
    {

        $myProfileForm = $this->createForm(MyProfileType::class,$user);
        $myProfileForm->handleRequest($request);
        return $this->render('profile/myProfile.html.twig',[
            'myProfileForm' => $myProfileForm
        ]);
    }
}
