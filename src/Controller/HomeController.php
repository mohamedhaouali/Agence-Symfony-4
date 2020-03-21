<?php

namespace App\Controller;
use App\Repository\PropretyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\QueryBuilder;
use Twig\Environment;


class HomeController extends  AbstractController
{
    /**
     * @Route("/",name="home")
     *  @param PropretyRepository $repository
     * @return Response
     */

    public function index(PropretyRepository $repository): Response
    {
        $properties=$repository->findLatest();
        return  $this->render('pages/home.html.twig',[
            'properties'=>$properties
        ]);

    }




}
