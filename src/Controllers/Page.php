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

class Page
{
  public function deletePage(Application $app, $id_page, $id_adventure){
    $role = $app['security.token_storage']->getToken()->getUser()->getRole();
    if($role != "ROLE_ADMIN"){
      $url = $app['url_generator']->generate('logout');
      return $app->redirect($url);
    }
    $msg = $app["dao.page"]->deletePagebyId($id_page);
    $url = $app['url_generator']->generate('listepage', ['id_adventure' =>$id_adventure]);
    return $app->redirect($url);
  }

  public function addPage(Application $app, $id_adventure){
    $role = $app['security.token_storage']->getToken()->getUser()->getRole();
    if($role != "ROLE_ADMIN"){
      $url = $app['url_generator']->generate('logout');
      return $app->redirect($url);
    }
  	$pages = $app["dao.page"]->getPagesByIdAdventure($id_adventure);
  	$choices = $app["dao.choice"]->getAllChoices();
  	return $app["twig"]->render('backoffice/pagecreation.html.twig', array("pages" => $pages, "choices" => $choices));
  }

  public function modifypage(Application $app){
    $role = $app['security.token_storage']->getToken()->getUser()->getRole();
  			if($role != "ROLE_ADMIN"){
  				$url = $app['url_generator']->generate('logout');
  				return $app->redirect($url);
  			}

  }
}
