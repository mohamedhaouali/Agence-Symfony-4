<?php

namespace App\Controller\Admin;

use App\Entity\Option;
use App\Entity\Proprety;
use App\Form\PropretyType;
use App\Repository\PropretyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AdminPropertyController extends AbstractController
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
     * @Route("/admin",name="admin.property.index")
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function index()
    {
        $properties = $this->repository->findAll();
        return $this->render('admin/property/index.html.twig',compact('properties'));

    }

    /**
     * @Route("/admin/property/create",name="admin.property.new")
     *
     */


    public function new(Request $request)
    {
      $property =new Proprety();
        //appel au formulaire
        $form=$this->createForm(PropretyType::class,$property);

        //Gerer la requete
        $form->handleRequest($request);
        //si le formulaire a eté envoye
        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($property);
            $this->em->flush();
            $this->addFlash('success','Bien creé avec succés');
            //redirection to route
            return $this->redirectToRoute('admin.property.index');

        }
        return $this->render('admin/property/new.html.twig',[
                'property'=>$property,
                'form'=>$form->createView()
            ]
        );
    }



    /**
     * @Route("/admin/property/{id}",name="admin.property.edit",methods="GET|POST")
     * @param Proprety $property
     * @param Request $request
     *  @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Proprety $property,Request $request)
    {


        //appel au formulaire
        $form=$this->createForm(PropretyType::class,$property);
        //Gerer la requete
        $form->handleRequest($request);
        //si le formulaire a eté envoye
        if($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            //message
            $this->addFlash('success','Bien modifie avec succés');
            //redirection to route
            return $this->redirectToRoute('admin.property.index');

        }
         return $this->render('admin/property/edit.html.twig',[
             'property'=>$property,
              'form'=>$form->createView()
             ]
             );
    }

    /**
     * @Route("/admin/property/{id}", name="admin.property.delete", methods="DELETE")
     * @param Proprety $property
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Proprety $property,Request $request)
    {
        if($this->isCsrfTokenValid('delete'.$property->getId(), $request->get('_token'))){
            $this->em->remove($property);
            $this->em->flush();
            $this->addFlash('success','Bien supprime avec succés');

        }
        //affiche mesage suppression
        //dump('suppression');

        return $this->redirectToRoute('admin.property.index');
    }

}