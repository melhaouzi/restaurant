<?php

namespace App\Controller;

use App\Entity\Reservering;
use App\Entity\Tafel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reservering")
 */
class BoekingsController extends AbstractController {
	/**
	 * @Route("/", name="reserveren")
	 */
	public function index() {
		$session = $this->get( 'request_stack' )->getCurrentRequest()->getSession();
		$boeking = $session->get( 'boeking', array() );

		if ( empty( $boeking ) ) {
			$datum   = new \DateTime( "now" );
			$boeking = [ 'aantal' => 5, 'datumtijd' => $datum ];
		}

		return $this->render( 'boekings/index.html.twig', [
			'controller_name' => 'BoekingsController',
			'boeking'         => $boeking,
			'form'            => null,
		] );
	}

	/**
	 * @Route("/toevoegen", name="reservering_toevoegen")
	 */
	public function new( Request $request ) {

		$session = $this->get( 'request_stack' )->getCurrentRequest()->getSession();
		$boeking = $session->get( 'boeking', array() );

		if ( empty( $boeking ) ) {

			$datum   = new \DateTime( "now" );
			$boeking = [ 'aantal' => 5, 'datumtijd' => $datum ];
			$form    = $this->createFormBuilder( $boeking )
			                ->add( 'aantal', IntegerType::class )
			                ->add( 'datumtijd', DateTimeType::class )
			                ->add( 'save', SubmitType::class, array( 'label' => 'Zoek tafels' ) )
			                ->getForm();
		} else {

			$tafels = [];

			foreach ( $boeking['tafels'] as $key => $personen ) {
				$tafels[ $personen . ' personen ' ] = $key;
			}

			$form = $this->createFormBuilder( $boeking )
			             ->add( 'aantal', IntegerType::class )
			             ->add( 'datumtijd', DateTimeType::class )
			             ->add( 'save', SubmitType::class, array( 'label' => 'Reserveren?' ) )
			             ->getForm();
		}

		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {
			$boeking = $form->getData();
			$em      = $this->getDoctrine()->getManager();

			$repository = $this->getDoctrine()
			                   ->getRepository( Reservering::class );

			$start = date( "Y-m-d H:m:s", strtotime( '-4 hours', $boeking['datumtijd']->getTimestamp() ) );
			$eind  = date( "Y-m-d H:m:s", strtotime( '+4 hours', $boeking['datumtijd']->getTimestamp() ) );

			$query       = $repository->createQueryBuilder( 'p' )
			                          ->where( 'p.datum BETWEEN :startDateTime AND :endDateTime' )
			                          ->setParameter( 'startDateTime', $start )
			                          ->setParameter( 'endDateTime', $eind )
			                          ->getQuery();
			$reservaties = $query->getResult();

			$tafels = $em->getRepository( Tafel::class )->findAll();
			$rtafel = [];

			foreach ( $reservaties as $reservatie ) {

				foreach ( $reservatie->getTafels() as $tafel ) {
					array_push( $rtafel, $tafel->getId() );
				}
			}

			foreach ( $tafels as $key => $tafel ) {

				foreach ( $rtafel as $rt ) {

					if ( $tafel->getId() == $rt ) {
						unset( $tafels[ $key ] );
					}
				}
			}

			$boeking['tafels'] = $tafels;
			$session->set( 'boeking', $boeking );

			return $this->redirectToRoute( 'kies_tafel' );
		}

		return $this->render( 'boekings/index.html.twig', array(
			'controller_name' => 'BoekingsController',
			'boeking'         => $boeking,
			'form'            => $form->createView(),
		) );
	}


	/**
	 * @Route("/kies/tafel", name="kies_tafel")
	 */
	public function book( Request $request ) {

		$session = $this->get( 'request_stack' )->getCurrentRequest()->getSession();
		$boeking = $session->get( 'boeking', array() );

		if ( ! empty( $boeking['tafels'] ) ) {

			$tafels = [];

			foreach ( $boeking['tafels'] as $key => $personen ) {
				$tafels[ $personen . ' personen ' ] = $key;

			}

			$form = $this->createFormBuilder( $boeking )
			             ->add( 'aantal', IntegerType::class )
			             ->add( 'datumtijd', DateTimeType::class )
			             ->add( 'tafels', ChoiceType::class, [
				             'choices'  => $tafels,
				             'multiple' => true,
				             'attr'=>['class'=>'js-example-basic-multiple']
			             ] )
			             ->add( 'save', SubmitType::class, array( 'label' => 'Maak Boeking' ) )
			             ->getForm();
		}

		if ( ! isset( $form ) ) {
			return $this->render('boekings/index.html.twig',[
				'form'=>null,
				'message'=>'Geen tafel beschikbaar'
			]);
		}

		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {

			$boeking = $form->getData();
			$em         = $this->getDoctrine()->getManager();

			$reservatie = new Reservering();
			$reservatie->setAantalPersonen( $boeking['aantal'] );
			$reservatie->setDatum( $boeking['datumtijd'] );
			$reservatie->setKlant( $this->getUser() );

			foreach ( $boeking['tafels'] as $tfl ) {
				$tafel = $this->getDoctrine()->getRepository( 'App:Tafel' )->findOneBy( [ 'id' => ( $tfl + 1 ) ] );
				$reservatie->addTafel( $tafel );
			}

			$em->persist( $reservatie );
			$em->flush();
			$session->remove( 'boeking' );

			return $this->render('boekings/success.html.twig', [
				'form'=> null
			]);
		}

		return $this->render( 'boekings/index.html.twig', array(
			'controller_name' => 'BoekingsController',
			'boeking'         => $boeking,
			'form'            => $form->createView(),
		) );
	}
}