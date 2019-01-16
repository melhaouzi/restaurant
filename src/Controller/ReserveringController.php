<?php

namespace App\Controller;

use App\Entity\Reservering;
use App\Form\ReserveringType;
use App\Repository\ReserveringRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reserveringen")
 */
class ReserveringController extends AbstractController {
	/**
	 * @Route("/", name="reservering_index", methods={"GET"})
	 */
	public function index( ReserveringRepository $reserveringRepository ): Response {
		if ( $this->isGranted( "ROLE_SUPER_ADMIN" ) ) {
			return $this->render( 'reservering/index.html.twig', [
				'reserverings' => $reserveringRepository->findAll(),
			] );
		} else {
			return $this->render( 'reservering/index.html.twig', [
				'reserverings' => $reserveringRepository->findBy( [ 'klant' => $this->getUser() ] )
			] );
		}
	}

	/**
	 * @Route("/new", name="reservering_new", methods={"GET","POST"})
	 */
	public function new( Request $request ): Response {
		if ( $this->isGranted( "ROLE_SUPER_ADMIN" ) ) {
			$reservering = new Reservering();
			$form        = $this->createForm( ReserveringType::class, $reservering );
			$form->handleRequest( $request );

			if ( $form->isSubmitted() && $form->isValid() ) {
				$entityManager = $this->getDoctrine()->getManager();
				$entityManager->persist( $reservering );
				$entityManager->flush();

				return $this->redirectToRoute( 'reservering_index' );
			}

			return $this->render( 'reservering/new.html.twig', [
				'reservering' => $reservering,
				'form'        => $form->createView(),
			] );
		} else {
			return $this->render( 'default/accessdenied.html.twig' );
		}
	}

	/**
	 * @Route("/{id}", name="reservering_show", methods={"GET"})
	 */
	public function show( Reservering $reservering ): Response {
		if ( $this->isGranted( "ROLE_SUPER_ADMIN" ) || $reservering->getKlant() == $this->getUser() ) {
			return $this->render( 'reservering/show.html.twig', [
				'reservering' => $reservering,
			] );
		} else {
			return $this->render( 'default/accessdenied.html.twig' );
		}
	}

	/**
	 * @Route("/{id}/edit", name="reservering_edit", methods={"GET","POST"})
	 */
	public function edit( Request $request, Reservering $reservering ): Response {
		if($this->isGranted("ROLE_SUPER_ADMIN")) {
			$form = $this->createForm( ReserveringType::class, $reservering );
			$form->handleRequest( $request );

			if ( $form->isSubmitted() && $form->isValid() ) {
				$this->getDoctrine()->getManager()->flush();

				return $this->redirectToRoute( 'reservering_index', [
					'id' => $reservering->getId(),
				] );
			}

			return $this->render( 'reservering/edit.html.twig', [
				'reservering' => $reservering,
				'form'        => $form->createView(),
			] );
		}
		else{
			return $this->render('default/accessdenied.html.twig');
		}
	}

	/**
	 * @Route("/{id}", name="reservering_delete", methods={"DELETE"})
	 */
	public function delete( Request $request, Reservering $reservering ): Response {
		if ( $this->isCsrfTokenValid( 'delete' . $reservering->getId(), $request->request->get( '_token' ) ) ) {
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->remove( $reservering );
			$entityManager->flush();
		}

		return $this->redirectToRoute( 'reservering_index' );
	}
}
