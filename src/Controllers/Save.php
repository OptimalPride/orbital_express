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
  
	public function loadSavesByUser(Application $app){
		$id_user = $app['security.token_storage']->getToken()->getUser()->getId_User();
		$saves = $app["dao.save"]->getAllSavesByIdUser($id_user);
		return $app['twig']->render('/game/yoursaves.html.twig', array("saves"=>$saves));
	}

	public function gestionUserSaves(Application $app){
		$id_user = $app['security.token_storage']->getToken()->getUser()->getId_User();
		$saves = $app["dao.save"]->getAllSavesByIdUser($id_user);
		return $app['twig']->render('/game/manageyoursaves.html.twig', array("saves"=>$saves));	
	}

	public function deleteUserSave(Application $app, $id_save){
		$id_user = $app['security.token_storage']->getToken()->getUser()->getId_User();
		$infos = array("id_user"=>$id_user, "id_save"=>$id_save);
		$verify_save_owner = $app["dao.save"]->verfifySaveOwnership($infos);
		if($verify_save_owner){
			$msg = $app["dao.save"]->deleteSaveById($id_save);
		}
		else{
			$msg = "Ceci n'est pas votre sauvegarde.";
		}
		$url = $app['url_generator']->generate('tableau');
		return $app->redirect($url);
	}
}
