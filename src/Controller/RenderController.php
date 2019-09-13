<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RenderController extends AbstractController
{
    /**
     * @Route("/render", name="render")
     */
    public function index()
    {

        $category = $this->getDoctrine()->getRepository(Category::class)->findAll();

        return $this->render('render/index.html.twig', [
            'categories' => $category
        ]);
    }
}
