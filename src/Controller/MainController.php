<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{

    /**
     * @Route("/", name="main_home")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function home() {
        return $this->render('main/home.html.twig');
    }

    /**
     * @Route("/about", name="main_about_us")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function about() {
        return $this->render('main/about_us.html.twig');
    }

}