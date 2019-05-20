<?php


namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{

	/**
	 * @Route("/blog/show/{id}",
	 *     requirements = {"id" = "[0-9]+"},
	 *     defaults = {"id" = "1"},
		 *	  name = "blog_show"
 *     		)
	 *
	 */
	public function show(Article $article){


		return $this->render('blog/show.html.twig', [

			'article'=>$article
			]);

	}

	/**
	 * @Route("/blog/index",
 *			name ="blog_index"
	 * )
	 */
	public function index()
	{

		$articles = $this->getDoctrine()->getRepository(Article::class)->findAll();

		if(!$articles) {
			throw $this->createNotFoundException(
				'No articles found in the table'
			);
		}

		return $this->render('home.html.twig', [
			'owner' => 'Thomas',
			'articles' => $articles
		]);
	}

	/**
	 * @Route ("/blog/category/{categoryName}", name="show_category")
	 */
	public function showByCategory(string $categoryName) {
		$articlePerCat = $this->getDoctrine()->getRepository(Category::class)
			->findOneByName("$categoryName")->getArticles();

		return $this->render('blog/category.html.twig', [
			'category' => $categoryName,
			"articlePerCat" => $articlePerCat
		]);

	}

}