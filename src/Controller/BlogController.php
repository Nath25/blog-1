<?php


namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Category;
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

		if(!$slug) {
			throw $this
			->createNotFoundException("No Slug has been sent to find an article in the articles' table");
		}

		$article = $this->getDoctrine()
			->getRepository(Articles::class)
			->findOneByTitle(mb_strtolower($slug));

		if(!$article){
			throw $this
			->createNotFoundException('no article with' . $slug . 'found in articles\' table');
		}

		return $this->render('blog/show.html.twig', [
			'slug'=>$slug,
			'article'=>$article
			]);

	}



	/**
	 * @Route("/Blog/index",
 *			name ="blog_index"
	 * )
	 */
	public function index()
	{

		$articles = $this->getDoctrine()->getRepository(Articles::class)->findAll();

		if(!$articles) {
			throw $this->createNotFoundException(
				'No articles found in the table'
			);
		}
		dump($articles);
		return $this->render('home.html.twig', [
			'owner' => 'Thomas',
			'articles' => $articles
		]);
	}

	/**
	 * @Route ("/blog/category/{categoryName}", name="show_category")
	 */
	public function showByCategory(string $categoryName) {
		$Category = $this->getDoctrine()->getRepository(Category::class)->findOneByName("$categoryName");

		$articlePerCategory = $this->getDoctrine()->getRepository(Articles::class)->findBy([
				'category' => $Category],
				['id' => 'DESC'],
				3,
				0
		);

		return $this->render('blog/category.html.twig', [
			'category' => $categoryName,
			"articlePerCat" => $articlePerCategory
		]);

	}

}