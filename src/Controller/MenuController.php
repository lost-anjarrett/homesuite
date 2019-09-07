<?php

namespace App\Controller;

use App\Entity\House;
use App\Entity\Meal;
use App\Entity\Menu;
use App\Entity\User;
use App\Repository\MealRepository;
use App\Service\MenuService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Validator\Constraints\Length;

/**
 * Class MenuController
 *
 * @package App\Controller
 *
 * @Route("/menu", name="menu_")
 */
class MenuController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(EntityManagerInterface $manager, MealRepository $repository, MenuService $menuService): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $menu = $manager
            ->getRepository(Menu::class)
            ->findOneBy(['house' => $user->getHouse()])
        ;

        if ($menu === null) {
            return $this->redirectToRoute('menu_new');
        }

        $meals = $repository->getComingMeals($menu);
        $nextDays = $menuService->getNextDays(7);

        return $this->render('menu/index.html.twig', ['nextDays' => $nextDays]);
    }

    /**
     * @Route("/new", name="new")
     */
    public function newMenu(EntityManagerInterface $manager)
    {
        /** @var User $user */
        $user = $this->getUser();
        $house = $user->getHouse();

        if ($house === null) {
            return $this->redirectToRoute('new_house');
        }

        $menu = new Menu();
        $menu->setHouse($house);
        $manager->persist($menu);
        $manager->flush();

        return $this->redirectToRoute('menu_home');
    }

    /**
     * @Route("/validate-meal", name="validate_meal", methods={"POST"})
     */
    public function validateMeal()
    {
        // TODO with ajax ??
        throw new AccessDeniedException('Hell no !');
    }

    /**
     * @Route("/day/{date}", name="day")
     */
    public function showDay(string $date, Request $request)
    {
        $date = date_create_from_format('YmdHis', $date . '000000');

        $breakfast = new Meal();
        $breakfast->setType('breakfast');
        $breakfast->setDate($date);
        $lunch = new Meal();
        $lunch->setType('lunch');
        $lunch->setDate($date);
        $dinner = new Meal();
        $dinner->setType('dinner');
        $dinner->setDate($date);
        $formBreakfast = $this->createFormBuilder($breakfast)
            ->add('description', TextType::class, ['label' => false])
            ->getForm()
        ;
        $formLunch = $this->createFormBuilder($lunch)
            ->add('description', TextType::class, ['label' => false])
            ->getForm()
        ;
        $formDinner = $this->createFormBuilder($dinner)
            ->add('description', TextType::class, ['label' => false])
            ->getForm()
        ;

        $forms = [
            'breakfast' => $formBreakfast->createView(),
            'lunch'     => $formLunch->createView(),
            'dinner'    => $formDinner->createView(),
        ];

        return $this->render('menu/day.html.twig', ['forms' => $forms, 'date' => $date]);
    }

    private function getMealForm($type, $date)
    {
        $meal = new Meal();
        $dinner->setType($type);
        $dinner->setDate($date);
        $formDinner = $this->createFormBuilder($dinner)
            ->add('description', TextType::class, ['label' => false])
            ->getForm()
        ;
    }
}
