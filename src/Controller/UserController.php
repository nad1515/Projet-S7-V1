<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;


class UserController extends AbstractController
{     
    // 
    #[Route('/users', name: 'app_users',methods:['GET'])]
    public function index(UserRepository $usersRepository): Response
    {
        return $this->render('user/index.html.twig', [
           'users' => $usersRepository->findAll(),
        ]);
    }


    
    #[Route('/forme', name: 'forme_user')]
    public function forme(): Response
    {
        $form = $this->createForm(UserType::class);
          return $this->render('user\formulaire.html.twig', [
         'form' => $form->createView()
         ]);
    }

    #[Route('/create_user', name: 'create_user')]
    public function createUser(EntityManagerInterface $entityManager): Response
    {


        $user= new User();
        $user->setNom('Regner');
        $user->setPrenom('Sylvain');
        $user->setEmail('sylvain@yahoo.fr');
       
        $entityManager->persist($user);

        $entityManager->flush();
// ....................................pour extraire un element d'un objet en php on met -> mais en twig on met un .(point)$person->getId()  et getid pour avoir accé a un prvate attribut
        return new Response('Saved new user with id ' .$user->getId());
      }


      #[Route('/user/{id}/edit', name: 'app_user_edit',methods:['GET','POST'])]
      public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
      {
        $form= $this-> createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

        return $this->redirectToRoute('app_users',[],
        Response::HTTP_SEE_OTHER);
      }
      return $this->render('user/edit.html.twig', [
        'form'=> $form, 'user'=> $user
      ]);

  
}

}

