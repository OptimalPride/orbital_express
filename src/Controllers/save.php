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
    public function afficheGestionSave(Application $app){
        $save = $app['dao.save']->getAllSaves();
        return $app['twig']->render('backoffice/gestionSave.html.twig', array("save" => $save, "msg" => ""));
    }

    public function deleteSave(Application $app, $id_save){
  		$msg = $app["dao.save"]->deleteSaveById($id_save);
  		$saves = $app["dao.save"]->getAllSaves();
  		return $app['twig']->render('backoffice/GestionSave.html.twig', array("saves" => $saves, "msg" => $msg));
  	}
}
