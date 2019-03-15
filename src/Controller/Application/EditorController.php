<?php

namespace App\Controller\Application;

use App\Entity\Application\Editor;
use App\Form\Application\EditorType;
use App\Repository\Application\EditorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/editor")
 */
class EditorController extends AbstractController {
	/**
	 * @Route("/", name="application_editor_index", methods={"GET"})
	 */
	public function index(EditorRepository $editorRepository): Response {
		return $this->render('application/editor/index.html.twig', [
			'editors' => $editorRepository->findAll(),
			'header' => $this->getHeader(),
		]);
	}

	/**
	 * @Route("/new", name="application_editor_new", methods={"GET","POST"})
	 */
	public function new (Request $request): Response{
		$editor = new Editor();
		$form = $this->createForm(EditorType::class, $editor);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($editor);
			$entityManager->flush();

			return $this->redirectToRoute('application_editor_index');
		}

		return $this->render('application/editor/new.html.twig', [
			'editor' => $editor,
			'form' => $form->createView(),
		]);
	}

	/**
	 * @Route("/{id}", name="application_editor_show", methods={"GET"})
	 */
	public function show(Editor $editor): Response {
		return $this->render('application/editor/show.html.twig', [
			'editor' => $editor,
			'header' => $this->getHeader(),
		]);
	}

	/**
	 * @Route("/{id}/edit", name="application_editor_edit", methods={"GET","POST"})
	 */
	public function edit(Request $request, Editor $editor): Response{
		$form = $this->createForm(EditorType::class, $editor);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$this->getDoctrine()->getManager()->flush();

			return $this->redirectToRoute('application_editor_index', [
				'id' => $editor->getId(),
			]);
		}

		return $this->render('application/editor/edit.html.twig', [
			'editor' => $editor,
			'form' => $form->createView(),
		]);
	}

	/**
	 * @Route("/{id}", name="application_editor_delete", methods={"DELETE"})
	 */
	public function delete(Request $request, Editor $editor): Response {
		if ($this->isCsrfTokenValid('delete' . $editor->getId(), $request->request->get('_token'))) {
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->remove($editor);
			$entityManager->flush();
		}

		return $this->redirectToRoute('application_editor_index');
	}

	private function getHeader() {
		return array(
			'logo' => [
				'icon' => 'fa-folder',
			],
		);
	}
}
