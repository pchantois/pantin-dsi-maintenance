<?php

namespace App\Controller\Admin;

use App\Entity\Admin\Versioning;
use App\Form\Admin\VersioningType;
use App\Repository\Admin\VersioningRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/versioning")
 */
class VersioningController extends AbstractController {
	/**
	 * @Route("/", name="admin_versioning_index", methods={"GET"})
	 */
	public function index(VersioningRepository $versioningRepository): Response {
		return $this->render('admin/versioning/index.html.twig', [
			'versionings' => $versioningRepository->findAll(),
		]);
	}

	/**
	 * @Route("/new", name="admin_versioning_new", methods={"GET","POST"})
	 */
	public function new (Request $request): Response{
		$versioning = new Versioning();
		$form = $this->createForm(VersioningType::class, $versioning);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($versioning);
			$entityManager->flush();

			return $this->redirectToRoute('admin_versioning_index');
		}

		return $this->render('admin/versioning/new.html.twig', [
			'versioning' => $versioning,
			'form' => $form->createView(),
		]);
	}

	/**
	 * @Route("/{id}", name="admin_versioning_show", methods={"GET"})
	 */
	public function show(Versioning $versioning): Response {
		return $this->render('admin/versioning/show.html.twig', [
			'versioning' => $versioning,
		]);
	}

	/**
	 * @Route("/{id}/edit", name="admin_versioning_edit", methods={"GET","POST"})
	 */
	public function edit(Request $request, Versioning $versioning): Response{
		$form = $this->createForm(VersioningType::class, $versioning);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$this->getDoctrine()->getManager()->flush();

			return $this->redirectToRoute('admin_versioning_index', [
				'id' => $versioning->getId(),
			]);
		}

		return $this->render('admin/versioning/edit.html.twig', [
			'versioning' => $versioning,
			'form' => $form->createView(),
		]);
	}

	/**
	 * @Route("/{id}", name="admin_versioning_delete", methods={"DELETE"})
	 */
	public function delete(Request $request, Versioning $versioning): Response {
		if ($this->isCsrfTokenValid('delete' . $versioning->getId(), $request->request->get('_token'))) {
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->remove($versioning);
			$entityManager->flush();
		}

		return $this->redirectToRoute('admin_versioning_index');
	}
}
