<?php


namespace App\Controller;
use App\Form\ArticleType;
use App\Form\CategoryType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Request;
Use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{


	/**
	 * @param Request $request
	 * @param ObjectManager $formManager
	 * @return \Symfony\Component\HttpFoundation\Response
	 * @Route("/add/category", name="app_add_Category")
	 */
	public function add(Request $request, ObjectManager $formManager) {

		$category = new Category();

		$form = $this->createForm(CategoryType::class,$category);

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$data = $form->getData($request);
			$formManager->persist($data);
			$formManager->flush();
		}

		$catList = $this->getDoctrine()->getRepository(Category::class)->findAll();


		return $this->render('blog/add.html.twig', [
			'categories' => $catList,
			'form' => $form->createView()
		]);
	}
}