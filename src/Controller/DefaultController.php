<?php


namespace App\Controller;
Use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route ("/Home", name="app_")
 */
class DefaultController extends AbstractController
{



	/**
	 * @Route("/blog/{page}",
	 *     	 methods = {"GET"},
	 *      defaults = {"page" = 1 },
	 *     requirements = {"page" = "\d+"},
	 *     name = "index")
	 */
	public function index($page){

		return $this->render('default.html.twig', ['page'=>$page]);

	}

	/**
	 * @route("/blog/redirecting",
	 *     		name = "redirecting")
	 */
	public function redirecting(){

		return $this->redirectToRoute("app_index", ['page' => 23]);

	}


}