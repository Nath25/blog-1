<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class BlogController extends AbstractController
{

	/**
	 * @Route("/blog/show/{slug}",
	 *     requirements = {"slug" = "[a-z0-9\-]+"},
	 *     defaults = {"slug" = "article-sans-titre"},
		 *	  name = "blog_show"
 *     		)
	 *
	 */
	public function show($slug){

		$slug = ucwords(str_replace('-', ' ', $slug));

		return $this->render('blog/show.html.twig', ['slug'=>$slug]);

	}



	/**
	 * @Route("/Blog/index")
	 */
	public function index()
	{
		return $this->render('home.html.twig', [
			'owner' => 'Thomas. Mais par contre, c\'est vraiment mon nom, même s\'il est dans l\'exemple de la quête...'
		]);
	}
}