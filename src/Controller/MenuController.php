<?php

namespace App\Controller;

use App\Entity\House;
use App\Entity\Meal;
use App\Entity\Menu;
use App\Entity\User;
use App\Form\MealType;
use App\Repository\MealRepository;
use App\Service\MenuService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
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

        $dayMeals = $menuService->getDayMeals($menu, $date);

        $forms = [
            'breakfast' => $this->getMealForm('breakfast', $date, $dayMeals['breakfast'] ?? null),
            'lunch'     => $this->getMealForm('lunch', $date, $dayMeals['lunch'] ?? null),
            'dinner'    => $this->getMealForm('dinner', $date, $dayMeals['dinner'] ?? null),
        ];

        /** @var FormInterface $form */
        foreach ($forms as $form) {
            $form->handleRequest($request);
            if ($request->isXmlHttpRequest()) {
                die('tptp');
                /** @var Meal $meal */
                $meal = $form->getData();
                $meal->setMenu($menu);
                $meal->setCreator($user);
                $manager->persist($meal);
                $manager->flush();
            }
        }

        $formViews = array_map(function(FormInterface $form) {
            return $form->createView();
        }, $forms);

        return $this->render('menu/day.ajax.html.twig', ['forms' => $formViews, 'date' => $date, 'y' => $dayMeals]);
    }

    private function getMealForm(string $type, \DateTime $date, Meal $meal = null): FormInterface
    {
        if ($meal === null) {
            $meal = new Meal();
            $meal->setType($type);
            $meal->setDate($date);
        }

        return $this->get('form.factory')->createNamed($date->format(('Ymd')).'_'.$type, MealType::class, $meal);
    }

    /**
     * TODO allow POST only ?
     * @Route("/meal-delete/{id}", name="meal_delete")
     * @param Meal $meal
     * @param EntityManagerInterface $manager
     */
    public function delete(Meal $meal, Request $request, EntityManagerInterface $manager, RouterInterface $router)
    {
        $manager->remove($meal);
        $manager->flush();

        $referer = $request->headers->get('referer');
        $refererPathInfo = Request::create($referer)->getPathInfo();
        $routeInfos = $router->match($refererPathInfo);

        // get the Symfony route name
        $refererRoute = $routeInfos['_route'];
        unset($routeInfos['_route']);
        unset($routeInfos['_controller']);

        return $this->redirectToRoute($refererRoute, $routeInfos);
    }
}
