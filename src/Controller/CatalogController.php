<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class CatalogController extends AbstractController
{
    /**
     * @Route("/", name="catalog")
     * @return Response
     */
    public function catalogList(): Response
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->findAll();

        return $this->render('catalog/list.html.twig', [
            'products' => $product
        ]);
    }


}
