<?php
namespace OrbitalExpress\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class Save
{
	public function continueAdventure(){
		$id_user = $app['security.token_storage']->getToken()->getUser()->getId_User();
		$saves = $app["dao.save"]->getAllSavesByIdUser($id_user);
		return $app['twig']->render('/game/yoursaves.html.twig', array("saves"=>$saves));
	}
}
