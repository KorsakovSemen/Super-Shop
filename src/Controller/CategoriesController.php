<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController extends AbstractController
{
    /**
     * @Route("/{id}/category", name="category")
     * @param int $id
     * @return Response
     */
    public function catalogCategory(int $id): Response
    {
        $categoryName = $this->getDoctrine()->getRepository(Category::class)->find($id);
        $category = $this->getDoctrine()->getRepository(Category::class)->findAll();
        $product = $this->getDoctrine()->getRepository(Product::class)->findCategory($id);
        return $this->render('catalog/category.html.twig', [
            'products' => $product,
            'categoryTitle' => $categoryName,
            'categories' => $category
        ]);
    }
}
