<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\IdeaType;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends AbstractController
{

    private const MSG_IDEA_SUCCESS = "Votre idée a été enregistré avezc succès !";

    /**
     * @Route("/wish", name="wish_list")
     */
    public function list(WishRepository $wishRepository): Response
    {
        // Requete BDD avec appel au repo"
        $wishes = $wishRepository->findBy(["isPublished" => true], ['dateCreated' => 'DESC'], 30, 0);

        return $this->render('wish/list.html.twig', [
            "wishes" => $wishes,
        ]);
    }

    /**
     * @Route("/wish/detail/{id}", name="wish_detail", requirements={"id"="\d+"})
     */
    public function detail($id, WishRepository $wishRepository): Response
    {
        // Requete BDD avec appel au repo"
        $wish = $wishRepository->find($id);

        return $this->render('wish/detail.html.twig', [
            'wish' => $wish,
        ]);
    }

    /**
     * @Route("/wish/idea", name="wish_idea")
     */
    public function idea(Request $request, EntityManagerInterface $em): Response
    {

        // creation de notre objet Wish couplé fortement avec le formulaire
        $wish = new Wish();
        $wish->setIsPublished(true);
        $wish->setDateCreated(new \DateTime());

        // creation de notre formulaire
        $wishForm = $this->createForm(IdeaType::class, $wish);

        // soumission de la requete
        $wishForm->handleRequest($request);

        // on traite la reception de la requete :
        if ( $wishForm->isSubmitted() && $wishForm->isValid() ) {
            //dd($wish);
            // on enregistre l'objet Wish en BDD par l'EntityManager
            $em->persist($wish);    // requete à la BDD
            $em->flush();           // validation transaction

            $this->addFlash('success', self::MSG_IDEA_SUCCESS);
            // on redirige vers la page elle-même (rechargement)
            return $this->redirectToRoute('wish_detail', [
                'id' => $wish->getId(),
            ]);
        }


        return $this->render('wish/idea.html.twig', [
            "wishForm" => $wishForm ->createView(),
        ]);
    }




}
