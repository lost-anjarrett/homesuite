<?php

namespace App\Controller;

use App\Entity\House;
use App\Entity\Meal;
use App\Entity\Menu;
use App\Entity\User;
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
 * @Route("/freezer", name="freezer_")
 */
class FreezerController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(EntityManagerInterface $manager): Response
    {
        return $this->render('freezer/index.html.twig', []);
    }

    /**
     * @Route("/new", name="new")
     */
    public function newFreezer()
    {
        throw new AccessDeniedException();
    }
}
