<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordFormType;
use App\Form\ModifyPasswordType;
use App\Form\MyProfileType;
use App\Services\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ProfileController extends AbstractController
{
    public function __construct(private readonly UserPasswordHasherInterface $userPasswordHasher)
    {

    }

    #[IsGranted('ROLE_USER')]
    #[Route('modify/profile', name: 'modify_profile', methods: ['GET','POST'])]
    public function modify_profile( Request $request, EntityManagerInterface $em,FileUploader $fileUploader): Response
    {
       
        $myProfileForm = $this->createForm(MyProfileType::class, $this->getUser());
        $myProfileForm->handleRequest($request);

        if($myProfileForm->isSubmitted() && $myProfileForm->isValid()){

            $imageURL = $myProfileForm->get('photoURL')->getData();

            if($imageURL){
                $this->getUser()->setPhotoURL($fileUploader->upload($imageURL));
            }

            $this->addFlash('success','Your profile has been modified');

            $em->persist($this->getUser());
            $em->flush();
            return $this->redirectToRoute('modify_profile');
        }
        return $this->render('profile/myProfile.html.twig',[
            'myProfileForm' => $myProfileForm
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/modify/password', name: 'modify_password',  methods: ['GET','POST'])]
    public function modifyPassword(EntityManagerInterface $em, Request $request): Response
    {
        $changePasswordForm = $this->createForm(ModifyPasswordType::class, $this->getUser());
        $changePasswordForm->handleRequest($request);

        if($changePasswordForm->isSubmitted() && $changePasswordForm->isValid()){
            $this->getUser()->setPassword($this->userPasswordHasher->hashPassword($this->getUser(),$this->getUser()->getPassword()));
            $this->addFlash('success', 'Your password has been modified');
            $em->persist($this->getUser());
            $em->flush();
            return $this->redirectToRoute('modify_profile');
        }
        return $this->render('profile/changepassword.html.twig',[
            'changePasswordForm' => $changePasswordForm
        ]);
    }
}
