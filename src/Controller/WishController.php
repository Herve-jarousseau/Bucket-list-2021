<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends AbstractController
{

    /**
     * @Route("/wish", name="wish_list")
     */
    public function list(): Response
    {
        // Requete BDD

        return $this->render('wish/list.html.twig', [

        ]);
    }

    /**
     * @Route("/detail/{id}", name="wish_detail", requirements={"id"="\d+"})
     */
    public function detail($id): Response
    {
        // Requete BDD

        return $this->render('wish/detail.html.twig', [
            'id' => $id,
        ]);
    }
}
