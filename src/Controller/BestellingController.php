<?php

namespace App\Controller;

use App\Entity\Bestelling;
use App\Entity\BestelRegel;
use App\Entity\Gerecht;
use App\Form\BestellingType;
use App\Repository\BestellingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/bestelling")
 */
class BestellingController extends AbstractController {
	/**
	 * @Route("/", name="bestelling_index", methods={"GET"})
	 */
	public function index( BestellingRepository $bestellingRepository ): Response {
		return $this->render( 'bestelling/index.html.twig', [
			'bestellings' => $bestellingRepository->findAll(),
		] );
	}

	/**
	 * @Route("/new", name="bestelling_new", methods={"GET","POST"})
	 */
	public function new( Request $request ): Response {
		$bestelling = new Bestelling();
		$form       = $this->createForm( BestellingType::class, $bestelling );
		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist( $bestelling );
			$entityManager->flush();

			return $this->redirectToRoute( 'bestelling_index' );
		}

		return $this->render( 'bestelling/new.html.twig', [
			'bestelling' => $bestelling,
			'form'       => $form->createView(),
		] );
	}

	/**
	 * @Route("/{id}", name="bestelling_show", methods={"GET"})
	 */
	public function show( Bestelling $bestelling ): Response {
		$em        = $this->getDoctrine()->getManager();
		$regels    = $em->getRepository( BestelRegel::class )->findby( [ 'bestelling' => $bestelling->getId() ] );
		$gerechten = $em->getRepository( Gerecht::class )->findall();

		// dump($regels);
		return $this->render( 'bestelling/show.html.twig', array(
			'bestelling'  => $bestelling,
			'gerechten' => $gerechten,
			'regels'   => $regels,
		) );
	}

	/**
	 * @Route("/{id}/edit", name="bestelling_edit", methods={"GET","POST"})
	 */
	public function edit( Request $request, Bestelling $bestelling ): Response {
		$form = $this->createForm( BestellingType::class, $bestelling );
		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {
			$this->getDoctrine()->getManager()->flush();

			return $this->redirectToRoute( 'bestelling_show', [
				'id' => $bestelling->getId(),
			] );
		}

		return $this->render( 'bestelling/edit.html.twig', [
			'bestelling' => $bestelling,
			'form'       => $form->createView(),
		] );
	}

	/**
	 * @Route("/{id}", name="bestelling_delete", methods={"DELETE"})
	 */
	public function delete( Request $request, Bestelling $bestelling ): Response {
		if ( $this->isCsrfTokenValid( 'delete' . $bestelling->getId(), $request->request->get( '_token' ) ) ) {
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->remove( $bestelling );
			$entityManager->flush();
		}

		return $this->redirectToRoute( 'bestelling_index' );
	}
}
