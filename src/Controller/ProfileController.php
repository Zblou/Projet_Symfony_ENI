<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\User;
use App\Form\MyProfileType;
use App\Services\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('modify/profile/{id}', name: 'modify_profile', requirements: ['id' => '\d+'] ,methods: ['GET','POST'])]
    public function modify_profile(User $user, Request $request, EntityManagerInterface $em,FileUploader $fileUploader): Response
    {
        $myProfileForm = $this->createForm(MyProfileType::class, $user);
        $myProfileForm->handleRequest($request);

        if($myProfileForm->isSubmitted() && $myProfileForm->isValid()){

            $imageURL = $myProfileForm->get('photoURL')->getData();

            if($imageURL){
                $user->setPhotoURL($fileUploader->upload($imageURL));
            }else{
                $user->setPhotoURL(null);
            }

            $this->addFlash('success','Your profile has been modified');

            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('modify_profile', ['id' => $user->getId()]);
        }
        return $this->render('profile/myProfile.html.twig',[
            'myProfileForm' => $myProfileForm
        ]);
    }
}
