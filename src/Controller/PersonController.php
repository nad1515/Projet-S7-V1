<?php

namespace App\Controller;
use App\Entity\Person;
use App\Repository\PersonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonController extends AbstractController
{
    #[Route('/person', name: 'app_person')]
    public function index(): Response
    {
        return $this->render('person/index.html.twig', [
            'controller_name' => 'PersonController',
        ]);
    }

    
    #[Route('/create_person', name: 'create_person')]
    public function createPerson(EntityManagerInterface $entityManager): Response
    {
        $date_naissance = new \DateTime('1980-12-12');

        $person= new Person();
        $person->setNom('Regner');
        $person->setPrenom('Sylvain');
        $person->setVille('Marseille');
        $person->setDate($date_naissance);
        $person->setAdresse('chemin de la vie');

        $entityManager->persist($person);

        $entityManager->flush();
// ....................................pour extraire un element d'un objet en php on met -> mais en twig on met un .(point)$person->getId()  et getid pour avoir accé a un prvate attribut avec symfony on ecri getid ou $person.id
        return new Response('Saved new person with id ' .$person->getId());
      }


      #[Route('/persons', name: 'app_all_persons', methods:['GET'])]
    public function all_persons(PersonRepository $personRepository): Response
    {
        return $this->render('person/all_persons.html.twig', [
            'persons' =>$personRepository->findAll(),
            // $personRepository est l'objet a instancier de la class PersonRepository, avec la fonction findAll de la meme class, c'est la requete pour l'orm qui communique avec la BDD
        ]);
    }

    #[Route('/person/{id}', name: 'person_show')]
    public function show2(int $id, EntityManagerInterface $entityManager): Response 
    {
        $person = $entityManager->getRepository(Person::class)->find($id);

        if (!$person) {
            throw $this->createNotFoundException(
                'No person found for id '.$id
            );
        }
        return $this->render('person/show.html.twig', [
            'persons' => $person,
        ]);
    }

    #[Route('/personedit/{id}', name: 'person_edit')]
    public function edit(int $id, PersonRepository $personRepository)
        {
        $person = $personRepository->find($id);
        // var_dump($person);

        return $this->render('person/edit.html.twig', [
            'persons' => $person,
        ]);
      }

      
    #[Route('/person/{id}/delete', name: 'person_delete')]
    public function delete( int $id, EntityManagerInterface $entityManager,  PersonRepository $personRepository ): Response
    {
        $person = $personRepository->find($id);
        var_dump($person);
        $entityManager->remove($person);

        $entityManager->flush();
        return $this->redirectToRoute('app_all_persons');
    }
}


    


