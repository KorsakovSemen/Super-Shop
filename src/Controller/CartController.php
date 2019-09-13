<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Check;
use App\Entity\Order;
use App\Form\CheckType;
use App\Services\BalanceManager;
use App\Services\CheckManager;
use App\Services\Mailer;
use App\Services\OrderItemManager;
use App\Services\OrderManager;
use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart")
     * @param Mailer $mailer
     * @param CheckManager $checkManager
     * @param BalanceManager $balanceManager
     * @param OrderManager $orderManager
     * @param Request $request
     * @return Response
     */
    public function catalogCart(Mailer $mailer, CheckManager $checkManager, BalanceManager $balanceManager, OrderManager $orderManager, Request $request)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $cart = $this->getDoctrine()->getRepository(Order::class)->findAllUserProducts($user->getId(), Order::STATUS_PENDING);


        if (isset($cart) && count($cart->getRows()) > 0) {

            $total = $checkManager->getTotal($user);

            $check = new Check();

            $check->setPayed(false);
            $check->setMoney($total);
            $check->setCart($cart);

            $form = $this->createForm(CheckType::class, $check);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $balanceManager->createTransaction($user, -1 * abs($total));
                $orderManager->set($cart->getId(), 'Send');
                $em = $this->getDoctrine()->getManager();
                $em->persist($check);
                $em->flush();


                $mailer->sendMail($cart, $total, $user->getEmail(), $user->getUserName());


                return $this->render('catalog/check.html.twig');

            }

            return $this->render('catalog/cart.html.twig', [
                'total' => $total,
                'carts' => $cart,
                'form' => $form->createView(),
            ]);

        } else {
            return $this->render('catalog/emptyCart.html.twig');
        }

    }

    /**
     * @Route("/cart/{id}/remove", name="cart-remove",  methods={"DELETE"})
     * @param OrderItemManager $orderListManager
     * @param int $id
     * @param
     * @return Response
     */
    public function catalogCartRemoveItem(OrderItemManager $orderListManager, int $id): Response
    {
        $orderListManager->remove($id);

        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/profile/check", name="user-check")
     */
    public function profileCheck(): Response
    {

        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $check = $this->getDoctrine()->getRepository(Check::class)->findByExampleField($user->getId());
        return $this->render('profile/userCheck.html.twig', [
            'checks' => $check
        ]);

    }

    /**
     * @Route("/profile/check/{id}/products", name="user-check-products")
     * @param int $id
     * @return Response
     */
    public function profileCheckProducts(int $id)
    {
        $cart = $this->getDoctrine()->getRepository(Order::class)->findAllUserProductsInCart($id);

        return $this->render('profile/userProducts.html.twig', [
            'carts' => $cart,
            'total' => 0,
        ]);

    }
}
