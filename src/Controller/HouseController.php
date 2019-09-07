<?php

namespace App\Controller;

use App\Entity\House;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Validator\Constraints\Length;

class HouseController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $house = $user->getHouse();

        if ($house === null) {
            return $this->redirectToRoute('new_house');
        }

        return $this->render('house/index.html.twig', ['house' => $house]);
    }

    /**
     * @Route("/new-house", name="new_house")
     */
    public function newHouse(Request $request, EntityManagerInterface $manager)
    {
        /** @var User $user */
        $user = $this->getUser();
        $house = $user->getHouse();

        if ($house !== null) {
            return $this->redirectToRoute('home');
        }

        $form = $this->createFormBuilder(new House())
            ->add('name', TextType::class)
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $house = $form->getData();
            $user->setHouse($house);
            $manager->persist($house);
            $manager->flush();
        }

        return $this->render('house/new.html.twig', ['form' => $form->createView()]);
    }
}
