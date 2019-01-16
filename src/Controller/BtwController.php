<?php

namespace App\Controller;

use App\Entity\Btw;
use App\Form\BtwType;
use App\Repository\BtwRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/btw")
 */
class BtwController extends AbstractController {
	/**
	 * @Route("/", name="btw_index", methods={"GET"})
	 */
	public function index( BtwRepository $btwRepository ): Response {
		if ( $this->isGranted( "ROLE_SUPER_ADMIN" ) ) {
			return $this->render( 'btw/index.html.twig', [
				'btws' => $btwRepository->findAll(),
			] );
		} else {
			return $this->render( 'default/accessdenied.html.twig' );
		}
	}

	/**
	 * @Route("/new", name="btw_new", methods={"GET","POST"})
	 */
	public function new( Request $request ): Response {
		if ( $this->isGranted( "ROLE_SUPER_ADMIN" ) ) {
			$btw  = new Btw();
			$form = $this->createForm( BtwType::class, $btw );
			$form->handleRequest( $request );

			if ( $form->isSubmitted() && $form->isValid() ) {
				$entityManager = $this->getDoctrine()->getManager();
				$entityManager->persist( $btw );
				$entityManager->flush();

				return $this->redirectToRoute( 'btw_index' );
			}

			return $this->render( 'btw/new.html.twig', [
				'btw'  => $btw,
				'form' => $form->createView(),
			] );
		} else {
			return $this->render( 'default/accessdenied.html.twig' );
		}
	}

	/**
	 * @Route("/{id}", name="btw_show", methods={"GET"})
	 */
	public function show( Btw $btw ): Response {
		if ( $this->isGranted( "ROLE_SUPER_ADMIN" ) ) {
			return $this->render( 'btw/show.html.twig', [
				'btw' => $btw,
			] );
		} else {
			return $this->render( 'default/accessdenied.html.twig' );
		}
	}

	/**
	 * @Route("/{id}/edit", name="btw_edit", methods={"GET","POST"})
	 */
	public function edit( Request $request, Btw $btw ): Response {
		if($this->isGranted("ROLE_SUPER_ADMIN")) {
			$form = $this->createForm( BtwType::class, $btw );
			$form->handleRequest( $request );

			if ( $form->isSubmitted() && $form->isValid() ) {
				$this->getDoctrine()->getManager()->flush();

				return $this->redirectToRoute( 'btw_index', [
					'id' => $btw->getId(),
				] );
			}

			return $this->render( 'btw/edit.html.twig', [
				'btw'  => $btw,
				'form' => $form->createView(),
			] );
		}else{
			return $this->render('default/accessdenied.html.twig');
		}
	}

	/**
	 * @Route("/{id}", name="btw_delete", methods={"DELETE"})
	 */
	public function delete( Request $request, Btw $btw ): Response {
		if ( $this->isCsrfTokenValid( 'delete' . $btw->getId(), $request->request->get( '_token' ) ) ) {
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->remove( $btw );
			$entityManager->flush();
		}

		return $this->redirectToRoute( 'btw_index' );
	}
}
