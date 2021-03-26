<?php

namespace App\Controller;

use App\Entity\Reaction;
use App\Entity\Wish;
use App\Form\IdeaType;
use App\Form\ReactionType;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends AbstractController
{

    private const MSG_IDEA_SUCCESS = "Votre idée a été enregistré avezc succès !";
    private const MSG_REACTION_SUCCESS = "Merci pour votre commentaire, quel qu'il soit ;) ";

    /**
     * @Route("/wish/{page}", name="wish_list", requirements={"page": "\d+"})
     */
    public function list(WishRepository $wishRepository, int $page = 1): Response
    {
        // Requete BDD avec appel au repo"
        //$wishes = $wishRepository->findBy(["isPublished" => true], ['dateCreated' => 'DESC'], 30, 0);

        $result = $wishRepository->findWishesListByPage($page);

        return $this->render('wish/list.html.twig', [
            "wishes" => $result['result'],
            "totalResultCount" => $result['totalResultCount'],
            "currentPage" => $page,
            "pageStart" => 1,
            "pageEnd" => ceil($result['totalResultCount'] / 20),
        ]);
    }

    /**
     * @Route("/wish/detail/{id}", name="wish_detail", requirements={"id"="\d+"})
     */
    public function detail(Request $request, $id, WishRepository $wishRepository, EntityManagerInterface $em): Response
    {
        // Requete BDD avec appel au repo"
        try {
            $wish = $wishRepository->findWishAndReactionsByWishId($id);
        } catch ( \Exception $e ) {

        }

        // creation de notre objet Reaction couplé fortement avec le formulaire
        $reaction = new Reaction();
        // creation de notre formulaire
        $reactionForm = $this->createForm(ReactionType::class, $reaction);

        // soumission de la requete
        $reactionForm->handleRequest($request);

        // on traite la reception de la requete :
        if ( $reactionForm->isSubmitted() && $reactionForm->isValid() ) {
            // on enregistre l'objet Reaction en BDD par l'EntityManager
            $reaction->setDateCreated(new \DateTime());
            $reaction->setWish($wish);
            $em->persist($reaction);    // requete à la BDD
            $em->flush();               // validation transaction

            $this->addFlash('success', self::MSG_REACTION_SUCCESS);
            // on redirige vers la page detail
            return $this->redirectToRoute('wish_detail', [
                'id' => $wish->getId(),
            ]);
        }

        return $this->render('wish/detail.html.twig', [
            'wish' => $wish,
            "reactionForm" => $reactionForm->createView(),
        ]);
    }

    /**
     * @Route("/wish/idea", name="wish_idea")
     */
    public function idea(Request $request, EntityManagerInterface $em): Response
    {

        // creation de notre objet Wish couplé fortement avec le formulaire
        $wish = new Wish();

        // creation de notre formulaire
        $wishForm = $this->createForm(IdeaType::class, $wish);

        // soumission de la requete
        $wishForm->handleRequest($request);

        // on traite la reception de la requete :
        if ( $wishForm->isSubmitted() && $wishForm->isValid() ) {
            //dd($wish);
            // on enregistre l'objet Wish en BDD par l'EntityManager
            $wish->setLikes(0);
            $wish->setIsPublished(true);
            $wish->setDateCreated(new \DateTime());
            $em->persist($wish);    // requete à la BDD
            $em->flush();           // validation transaction

            $this->addFlash('success', self::MSG_IDEA_SUCCESS);
            // on redirige vers la page detail
            return $this->redirectToRoute('wish_detail', [
                'id' => $wish->getId(),
            ]);
        }


        return $this->render('wish/idea.html.twig', [
            "wishForm" => $wishForm ->createView(),
        ]);
    }




}
