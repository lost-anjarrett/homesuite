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
use Symfony\Component\Form\FormInterface;
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
    public function home(EntityManagerInterface $manager, MenuService $menuService): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        /** @var Menu $menu */
        $menu = $manager
            ->getRepository(Menu::class)
            ->findOneBy(['house' => $user->getHouse()])
        ;

        if ($menu === null) {
            return $this->redirectToRoute('menu_new');
        }

        $comingDays = $menuService->getComingMenuDays($menu,7);

        return $this->render('menu/index.html.twig', ['comingDays' => $comingDays]);
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
    public function showDay(string $date, Request $request, EntityManagerInterface $manager, MenuService $menuService)
    {
        $date = date_create_from_format('YmdHis', $date . '000000');
        /** @var User $user */
        $user = $this->getUser();
        /** @var Menu $menu */
        $menu = $manager
            ->getRepository(Menu::class)
            ->findOneBy(['house' => $user->getHouse()])
        ;
        // Todo find meal from day and menu
        $dayMeals = $menuService->getDayMeals($menu, $date);

        $forms = [
            'breakfast' => $this->getMealForm('breakfast', $date, $dayMeals['breakfast'] ?? null)->createView(),
            'lunch'     => $this->getMealForm('lunch', $date, $dayMeals['lunch'] ?? null)->createView(),
            'dinner'    => $this->getMealForm('dinner', $date, $dayMeals['dinner'] ?? null)->createView(),
        ];

        return $this->render('menu/day.html.twig', ['forms' => $forms, 'date' => $date]);
    }

    private function getMealForm(string $type, \DateTime $date, Meal $meal = null): FormInterface
    {
        if ($meal === null) {
            $meal = new Meal();
            $meal->setType($type);
            $meal->setDate($date);
        }

        return $this->createFormBuilder($meal)
            ->add('description', TextType::class, ['label' => false])
            ->getForm()
        ;
    }
}
