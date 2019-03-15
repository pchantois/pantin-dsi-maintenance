<?php

namespace App\Controller\Admin;

use App\Entity\Admin\Computer;
use App\Form\Admin\ComputerType;
use App\Repository\Admin\ComputerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/computer")
 */
class ComputerController extends AbstractController
{
    /**
     * @Route("/", name="admin_computer_index", methods={"GET"})
     */
    public function index(ComputerRepository $computerRepository): Response
    {
        return $this->render('admin/computer/index.html.twig', [
            'computers' => $computerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_computer_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $computer = new Computer();
        $form = $this->createForm(ComputerType::class, $computer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($computer);
            $entityManager->flush();

            return $this->redirectToRoute('admin_computer_index');
        }

        return $this->render('admin/computer/new.html.twig', [
            'computer' => $computer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_computer_show", methods={"GET"})
     */
    public function show(Computer $computer): Response
    {
        return $this->render('admin/computer/show.html.twig', [
            'computer' => $computer,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_computer_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Computer $computer): Response
    {
        $form = $this->createForm(ComputerType::class, $computer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_computer_index', [
                'id' => $computer->getId(),
            ]);
        }

        return $this->render('admin/computer/edit.html.twig', [
            'computer' => $computer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_computer_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Computer $computer): Response
    {
        if ($this->isCsrfTokenValid('delete'.$computer->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($computer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_computer_index');
    }
}
