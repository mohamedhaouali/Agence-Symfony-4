<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Proprety;
use App\Entity\PropertySearch;
use App\Form\ContactType;
use App\Form\PropretyType;
use App\Form\PropertySearchType;
use App\Repository\PropretyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Paginator;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\AbstractType;


class PropertyController extends  AbstractController
{
    /**
     * @var PropretyRepository
     */

    private $repository;


    public function __construct(PropretyRepository $repository, EntityManagerInterface $em)
    {

        $this->repository = $repository;
        $this->em = $em;

    }

    /**
     * @Route("/biens", name="property.index")
     * @return Response
     */

    public function index(PaginatorInterface $paginator,Request $request): Response
    {
        // Créer une entité qui va represente notre recherche
        //Créer un formulaire
        $search = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class, $search);
        $form->handleRequest($request);
        //Géerer le traitement dans le controller


        // on a ajouter PaginatorInterface $paginator pour pagination
        //findALLVisible fonction fi PropretyRepository
        $properties =$paginator->paginate(
            //pour le filtre $search
         $this->repository->findAllVisibleQuery($search),
         $request->query->getInt('page', 1),
            12

    );
        return $this->render('property/index.html.twig',
            ['current_menu' => 'properties',
             'properties' =>$properties,
              'form' => $form->createView()
                ]);
    }

    /**
     * @Route("/biens/{slug}-{id}",name="property.show",requirements={"slug":"[a-z0-9\-]*"})
     * @param Proprety $proprety
     * @return Response
     */

    public function show(Proprety $property, string $slug, Request $request): Response
    {



        if ($property->getSlug() !== $slug) {
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);

        }
        //ces 3 lignes pour formulaire Contact
        $contact = new Contact();
        $contact->setProperty($property);
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

         if($form->isSubmitted() && $form->isValid()) {

             $this->addFlash('success','votre email a bien eté envoyé');
             return $this->redirectToRoute('property.show', [
                 'id' => $property->getId(),
                 'slug' => $property->getSlug()
             ]);

         }


            return $this->render('property/show.html.twig',
                ['property' => $property,
                    'current_menu' => 'properties',
                    'form' => $form->createView()
                ]);

        }


}