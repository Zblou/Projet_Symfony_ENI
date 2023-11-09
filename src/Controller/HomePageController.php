<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class HomePageController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->redirectToRoute('display_all_updated');
    }
}
