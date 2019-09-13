<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderList;
use App\Entity\Product;
use App\Form\OrderListType;
use App\Services\BalanceManager;
use App\Services\CategoryManager;
use App\Services\OrderManager;
use App\Services\ProductManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ProductsController extends AbstractController
{
    /**
     * @Route("/{id}/product", name="product")
     * @param Request $request
     * @param OrderManager $orderManager
     * @param ProductManager $productManager
     * @param int $id
     * @return Response
     */
    public function catalogProduct(Request $request, OrderManager $orderManager, ProductManager $productManager, int $id): Response
    {

        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $order = $this->getDoctrine()->getRepository(Order::class)->findAllUserProducts($user->getId(), Order::STATUS_PENDING);

        $orderList = new OrderList();
        $quantityProductInCart = 0;

        if (empty($order)) {
            $orderList->setProduct($product);
            $order = $orderManager->createOrder($user, Order::STATUS_PENDING);
            $orderList->setCart($order);
        } else {
            $orderList = $productManager->checkProductInCart($order, $orderList, $id);
            if ($orderList->getId() == null) {
                $orderList->setCart($order);
                $orderList->setProduct($product);
            } else {
                $quantityProductInCart = $orderList->getCount();
            }
        }

        $form = $this->createForm(OrderListType::class, $orderList);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            if ($order->getRows()->contains($orderList)) {
                $count = $form->getData()->getCount();
                $orderList->setCount($count + $quantityProductInCart);
            } else {
                $em->persist($orderList);
            }

            $em->flush();
            return $this->redirectToRoute('catalog');
        }
        return $this->render('catalog/product.html.twig', [
            'form' => $form->createView(),
            'product' => $product
        ]);
    }


}



