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
use App\Form\PlanningType;
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
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param MenuService $menuService
     *
     * @return Response
     * @throws \Exception
     */
    public function home(EntityManagerInterface $manager, Request $request, MenuService $menuService): Response
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

        $offset = $request->query->get('offset') ?: '+0';
        $plannedDays = $menuService->getMenuDays($menu, new \DateTime('today '.$offset.' days'));

        $form = $this->createForm(PlanningType::class, ['days' => $plannedDays]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $days = $form->getData()['days'];
            foreach ($days as $day) {
                $manager->persist($day);
            }
            $manager->flush();

            // If it was called from AJAX , no need to render whole view
            if ($request->isXmlHttpRequest()) {
                return new Response('OK');
            }
        }

        return $this->render('menu/index.html.twig', [
            'form' => $form->createView(),
            'offsets' => [
                'm7' => $offset -7,
                'm1' => $offset -1,
                'offset' => $offset,
                'p1' => $offset +1,
                'p7' => $offset +7,
            ],
        ]);
    }

    /**
     * @Route("/new", name="new")
     * 
     * @param EntityManagerInterface $manager
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
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
}
