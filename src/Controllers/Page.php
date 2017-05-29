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
    $msg = $app["dao.page"]->deletePagebyId($id_page);
    $pages = $app["dao.page"]->getAllPages();
    $url = $app['url_generator']->generate('listepage', ['id_adventure' =>$id_adventure]);
    return $app->redirect($url);
  }
}
