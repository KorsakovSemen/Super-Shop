<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\MoneyTransaction;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ReplenishType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class BalanceController extends AbstractController
{
    /**
     * @Route("/profile/{id}/replanish", name="replanish")
     * @param Request $request
     * @return Response
     */
    public function balanceReplanish(Request $request): Response
    {

        $rep = new MoneyTransaction();

        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $rep->setUser($user);
        $form = $this->createForm(ReplenishType::class, $rep);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($rep);
            $em->flush();

            return $this->redirectToRoute('fos_user_profile_show');
        }


        return $this->render('profile/replenish.html.twig', [
            'form' => $form->createView(),
        ]);
    }


}
