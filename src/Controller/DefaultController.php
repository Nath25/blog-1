<?php


namespace App\Controller;
Use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{

	/**
	 * @Route app_index ("/")
	 */
	public function index(){

		return $this->render('default.html.twig');

	}
}