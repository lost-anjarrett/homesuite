<?php

namespace App\Controller;

use App\Entity\Breakfast;
use App\Entity\Day;
use App\Entity\Dinner;
use App\Entity\House;
use App\Entity\Lunch;
use App\Entity\Meal;
use App\Entity\Menu;
use App\Entity\User;
use App\Form\BreakfastType;
use App\Form\DayType;
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

        $comingDays = [];

        $day = new Day();
        $day->setMenu($menu);
        $day->setDate(new \DateTime());
        $breakfast = new Breakfast();
        $day->addMeal($breakfast);
        $lunch = new Lunch();
        $day->addMeal($lunch);
        $dinner = new Dinner();
        $day->addMeal($dinner);

        $form = $this->createForm(DayType::class, $day);

        return $this->render('menu/index_form.html.twig', [
            'comingDays' => $comingDays,
            'form' => $form->createView(),
            'breakfast' => $breakfast,
        ]);
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

    private function getMealForm(string $type, \DateTime $date, Meal $meal = null): FormInterface
    {
        if ($meal === null) {
            throw new \Exception('chauuuud');
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
        return;
    }
}
