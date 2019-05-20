<?php


namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class BlogController extends AbstractController
{

	/**
	 * @Route("/blog/show/{article}",
	 *     requirements = {"article" = "[0-9]+"},
	 *     defaults = {"article" = "1"},
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
	 * @ParamConverter ("name", class="App\Entity\Category", options = {"mapping" : {"categoryName" : "name"}})
	 */
	public function showByCategory(Category $name) {
		/*$articlePerCat = $this->getDoctrine()->getRepository(Category::class)
			->findOneByName("$categoryName")->getArticles();
		*/
		$articlePerCat = $name->getArticles();
		return $this->render('blog/category.html.twig', [
			'category' => $name,
			"articlePerCat" => $articlePerCat
		]);

	}

	/**
	 * @Route("/blog/categorylist/{category_id}", name="show_oneCat")
	 * @ParamConverter("id", class="App\Entity\Category", options={"id"="category_id"})
	 */
	public function showCategories(Category $id) {
		return $this->render('blog/categoryList.html.twig', [
			'category'=> $id
		]);
	}

}