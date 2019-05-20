<?php


namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Tag;
use App\Form\ArticleSearch;
use App\Form\CategoryType;
use PhpParser\Node\Expr\Cast\Object_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Form\FormInterface;
use Doctrine\Common\Persistence\ObjectManager;

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
	public function index(Request $request, ObjectManager $manager)
	{

		$form = $this->createForm(ArticleSearch::class, null, ['method'=>Request::METHOD_GET]);
		$form->handleRequest($request);
		$data=[];
		if($form->isSubmitted()){
			$data = $form->getData();
		}


		$categoryForm = new Category();

		$addForm = $this->createForm(CategoryType::class, $categoryForm);
		$addForm->handleRequest($request);
		if($addForm->isSubmitted() && $addForm->isValid()) {

		$dataAdd = $addForm->getData($request);
		$manager->persist($dataAdd);
		$manager->flush();
		}

		$articles = $this->getDoctrine()->getRepository(Article::class)->findAll();

		if(!$articles) {
			throw $this->createNotFoundException(
				'No articles found in the table'
			);
		}

		return $this->render('home.html.twig', [
			'owner' => 'Thomas',
			'articles' => $articles,
			'form' => $form->createView(),
			'addform' =>$addForm->createView(),
			'data' => $data
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
	 * @param $name
	 * @return Response
	 * @Route ("/tag/{tagName}", name="app_tag",
	 *	 defaults = {"tagName" = "developpement"})
	 * @ParamConverter ("tagName", class="App\Entity\Tag", options = {"mapping" :{"tagName" : "name"}})
	 */
	public function showTag(Tag $tagName) {

		$articlePerTag = $tagName->getArticles();
		return $this->render('blog/tag.html.twig', [
			'articlePerTag' => $articlePerTag
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