<?php

namespace App\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ShowProfile extends AbstractController

{
    #[Route('Show/profile', name: 'Show_profile', methods: ['GET'])]
    public function Show_profile(Request $request);

}