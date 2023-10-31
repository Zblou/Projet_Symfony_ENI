<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\User;
use App\Form\MyProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('modify/profile/{id}', name: 'modify_profile', requirements: ['id' => '\d+'] ,methods: ['GET','POST'])]
    public function modify_profile(Participant $participant, Request $request, EntityManagerInterface $em): Response
    {
        $myProfileForm = $this->createForm(MyProfileType::class, $participant);
        $myProfileForm->handleRequest($request);
        return $this->render('profile/myProfile.html.twig',[
            'myProfileForm' => $myProfileForm
        ]);
    }
}
