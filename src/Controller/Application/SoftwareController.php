<?php

namespace App\Controller\Application;

use App\Entity\Application\Editor;
use App\Entity\Application\Software;
use App\Form\Application\SoftwareType;
use App\Repository\Application\SoftwareRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/software")
 */
class SoftwareController extends AbstractController {
	/**
	 * @Route("/", name="application_software_index", methods={"GET"})
	 */
	public function index(SoftwareRepository $softwareRepository): Response {
		return $this->render('application/software/index.html.twig', [
			'softwares' => $softwareRepository->findAll(),
			'header' => $this->getHeader(),
		]);
	}

	/**
	 * @Route("/new", name="application_software_new", methods={"GET","POST"})
	 */
	public function new (Request $request): Response{
		$software = new Software();
		$form = $this->createForm(SoftwareType::class, $software);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($software);
			$entityManager->flush();

			return $this->redirectToRoute('application_software_index');
		}

		return $this->render('application/software/new.html.twig', [
			'software' => $software,
			'form' => $form->createView(),
		]);
	}

	/**
	 * @Route("/editor-{editeur}", name="application_software_list", methods={"GET"})
	 */
	public function liste(SoftwareRepository $softwareRepository, Editor $editeur): Response {
		return $this->render('application/software/index.html.twig', [
			'softwares' => $softwareRepository->findBy(array('editor' => $editeur)),
			'header' => $this->getHeader(),
		]);
	}

	/**
	 * @Route("/{id}", name="application_software_show", methods={"GET"})
	 */
	public function show(Software $software): Response {
		return $this->render('application/software/show.html.twig', [
			'software' => $software,
			'header' => $this->getHeader(),
		]);
	}

	/**
	 * @Route("/{id}/edit", name="application_software_edit", methods={"GET","POST"})
	 */
	public function edit(Request $request, Software $software): Response{
		$form = $this->createForm(SoftwareType::class, $software);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$this->getDoctrine()->getManager()->flush();

			return $this->redirectToRoute('application_software_index', [
				'id' => $software->getId(),
			]);
		}

		return $this->render('application/software/edit.html.twig', [
			'software' => $software,
			'form' => $form->createView(),
		]);
	}

	/**
	 * @Route("/{id}", name="application_software_delete", methods={"DELETE"})
	 */
	public function delete(Request $request, Software $software): Response {
		if ($this->isCsrfTokenValid('delete' . $software->getId(), $request->request->get('_token'))) {
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->remove($software);
			$entityManager->flush();
		}

		return $this->redirectToRoute('application_software_index');
	}

	/**
	 * @Route("/{id}/commit", name="admin_versioning_commit", methods={"GET","POST"})
	 */
	public function commit(Request $request): Response{
		$em = $this->getDoctrine()->getManager();
		$repository = $this->getDoctrine()->getRepository('Versioning::class');

		$id = $request->query->get('id');
		$entity = $repository->find($id);

		//$process = new Process(['svn', 'slow-starting-server.php']);
		$process = new Process(['ls', '-lh']);
		$process->start();

		// ... do other things

		// waits until the given anonymous function returns true
		$process->waitUntil(function ($type, $output) {
			return $output === 'Ready. Waiting for commands...';
		});

		// ... do things after the process is ready

		// redirect to the 'list' view of the given entity ...
		return $this->redirectToRoute('easyadmin', array(
			'action' => 'list',
			'entity' => $this->request->query->get('entity'),
		));
	}

	private function getHeader() {
		return array(
			'logo' => [
				//'icon' => 'fa-wrench',
				'icon' => 'fa-folder-open',
			],
		);
	}
}
