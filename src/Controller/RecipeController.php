<?php

namespace App\Controller;


use App\Entity\Recipe;
use App\Entity\User;
use App\Form\RecipeType as RecipeForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MenuController
 *
 * @package App\Controller
 *
 * @Route("/recipes", name="recipe_")
 */
class RecipeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(EntityManagerInterface $manager): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $house = $user->getHouse();

        if ($house === null) {
            return $this->redirectToRoute('new_house');
        }

        $recipes = $manager->getRepository(Recipe::class)->findBy(['house' => $house], ['updatedAt' => 'DESC']);

        return $this->render('recipe/index.html.twig', ['recipes' => $recipes]);
    }

    /**
     * @Route("/add", name="add", methods={"POST"})
     */
    public function add(Request $request, EntityManagerInterface $manager)
    {
        /** @var User $user */
        $user = $this->getUser();

        $recipe = new Recipe();
        $recipe->setHouse($user->getHouse());

        $url = $this->generateUrl('recipe_add');

        $form = $this->createForm(RecipeForm::class, $recipe, ['action' => $url]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recipe = $form->getData();
            $manager->persist($recipe);
            $manager->flush();
            $this->addFlash('success', 'Recipe registered');

            return $this->redirectToRoute('recipe_home');
        }

        return $this->render('recipe/recipe-form.html.twig', ['recipeForm' => $form->createView(), 'submitValue' => 'Add']);
    }

    /**
     * @Route("/update/{id}", name="update", methods={"GET", "POST"})
     */
    public function update(Recipe $recipe, Request $request, EntityManagerInterface $manager)
    {
        /** @var User $user */
        $user = $this->getUser();
        if ($recipe->getHouse()->getId() !== $user->getHouse()->getId()) {
            throw $this->createAccessDeniedException();
        }

        $url = $this->generateUrl('recipe_update', ['id' => $recipe->getId()]);

        $form = $this->createForm(RecipeForm::class, $recipe, ['action' => $url]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recipe = $form->getData();
            $manager->flush();
            $this->addFlash('success', 'Recipe updated');

            return $this->redirectToRoute('recipe_home');
        }

        return $this->render('recipe/recipe-form.html.twig', ['recipeForm' => $form->createView(), 'submitValue' => 'Update']);
    }
}
