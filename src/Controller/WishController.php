<?php

namespace App\Controller;

use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends AbstractController
{

    /**
     * @Route("/wish", name="wish_list")
     */
    public function list(WishRepository $wishRepository): Response
    {
        // Requete BDD avec appel au repo"
        $wishes = $wishRepository->findBy(["isPublished" => true], ['dateCreated' => 'DESC'], 20, 0);

        return $this->render('wish/list.html.twig', [
            "wishes" => $wishes,
        ]);
    }

    /**
     * @Route("/detail/{id}", name="wish_detail", requirements={"id"="\d+"})
     */
    public function detail($id, WishRepository $wishRepository): Response
    {
        // Requete BDD avec appel au repo"
        $wish = $wishRepository->find($id);

        return $this->render('wish/detail.html.twig', [
            'wish' => $wish,
        ]);
    }
}
