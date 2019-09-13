<?php
declare(strict_types=1);


namespace App\Services;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;


class CategoryManager
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createCategory(string $name): Category
    {

        $category = new Category();

        $category->setName($name);

        $this->entityManager->persist($category);
        $this->entityManager->flush();

        return $category;
    }


    public function remove($id)
    {

        $category = $this->entityManager->getRepository(Category::class)->find($id);

        $this->entityManager->remove($category);
        $this->entityManager->flush();

    }


}