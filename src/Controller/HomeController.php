<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home.index')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/home', 'home.home', methods:['GET'])]
    public function home(): Response
    {
        return new response("<h1>bonjour</h1>");
    }

    #[Route('/AfficheInfo', 'home.afficheinfo', methods:['GET'])]
    public function afficheinfo(): Response
    {   $today = date("d.m.y"); 
        $prenom = "nadia";
        $name = "hamiche";
        return $this->render('home/afficher.html.twig', [
            'name' => $name, 'prenom'=> $prenom, 'date'=>$today ]);

    }
    #[Route('/page1', name: 'home.page', methods:['GET'])]
    public function page(): Response
    {
        return $this->render('home/page1.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}