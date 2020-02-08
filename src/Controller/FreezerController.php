<?php

namespace App\Controller;

use App\Entity\Freezer;
use App\Entity\FreezerItem;
use App\Entity\User;
use App\Form\FreezerItemType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function home(): Response
    {
        return $this->render('freezer/index.html.twig', []);
    }

    /**
     * @Route("/new", name="new")
     */
    public function newFreezer(Request $request, EntityManagerInterface $manager)
    {
        /** @var User $user */
        $user = $this->getUser();
        $house = $user->getHouse();

        if ($house === null) {
            return $this->redirectToRoute('home');
        }

        $form = $this->createFormBuilder(new Freezer())
            ->add('name', TextType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $freezer = $form->getData();
            $freezer->setHouse($house);
            $manager->persist($freezer);
            $manager->flush();

            return $this->redirectToRoute('freezer_freezer', ['id' => $freezer->getId()]);
        }

        return $this->render('freezer/new-freezer.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/{id}", name="freezer")
     */
    public function freezer(Freezer $freezer, EntityManagerInterface $manager): Response
    {
        return $this->render('freezer/freezer.html.twig', ['freezer' => $freezer]);
    }

    /**
     * @Route("{id}/item/add", name="item_add", methods={"POST"})
     * @param Freezer $freezer
     * @param Request $request
     * @param EntityManagerInterface $manager
     *
     * @return Response|JsonResponse
     * @throws \Exception
     */
    public function addItem(Freezer $freezer, Request $request, EntityManagerInterface $manager)
    {
        /** @var User $user */
        $user = $this->getUser();

        $item = new FreezerItem();
        $item->setFreezer($freezer);
        $item->setDateExpiry(new \DateTime());
        $item->setCreator($user);

        $url = $this->generateUrl('freezer_item_add', ['id' => $freezer->getId()]);

        $form = $this->createForm(FreezerItemType::class, $item, ['action' => $url]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var FreezerItem $item */
            $item = $form->getData();
            $item->setFreezer($freezer);
            $manager->persist($item);
            $manager->flush();
            $this->addFlash('success', 'New item added to freezer');

            return $this->redirectToRoute('freezer_freezer', ['id' => $freezer->getId()]);
        }

        return $this->render('freezer/item-form.html.twig', ['freezerItemForm' => $form->createView()]);
    }

    /**
     * @Route("/item/update/{id}", name="item_update", methods={"POST"})
     * @param FreezerItem $item
     * @param Request $request
     * @param EntityManagerInterface $manager
     *
     * @return Response|JsonResponse
     */
    public function updateItem(FreezerItem $item, Request $request, EntityManagerInterface $manager)
    {
        $url = $this->generateUrl('freezer_item_update', ['id' => $item->getId()]);

        $form = $this->createForm(FreezerItemType::class, $item, ['action' => $url]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var FreezerItem $item */
            $item = $form->getData();

            // Quantity equals to zero means item must be removed
            if ($item->getQuantity() === 0) {
                return $this->redirectToRoute('freezer_item_remove', ['id' => $item->getId()], 307);
            }

            $manager->flush();
            $this->addFlash('success', 'Item updated');

            return $this->redirectToRoute('freezer_freezer', ['id' => $item->getFreezer()->getId()]);
        }

        return $this->render('freezer/item-form.html.twig', ['freezerItemForm' => $form->createView()]);
    }

    /**
     * @Route("/item/remove/{id}", name="item_remove", methods={"POST"})
     * @param FreezerItem $item
     * @param Request $request
     * @param EntityManagerInterface $manager
     *
     * @return Response|JsonResponse
     * @throws \Exception
     */
    public function removeItem(FreezerItem $item, Request $request, EntityManagerInterface $manager)
    {
        $item->setDateRemoval(new \DateTime('now'));
        $manager->flush();
        $this->addFlash('success', 'Item removed');

        return $this->redirectToRoute('freezer_freezer', ['id' => $item->getFreezer()->getId()]);
    }
}
