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
    $url = $app['url_generator']->generate('modifyadventure', ['id_adventure' =>$id_adventure]);
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
  	return $app["twig"]->render('backoffice/pagecreation.html.twig', array("pages" => $pages, "choices" => $choices, "id_adventure"=>$id_adventure ));
  }


  public function modifyPage(Application $app, $id_adventure, $id_page){
    $role = $app['security.token_storage']->getToken()->getUser()->getRole();
  		if($role != "ROLE_ADMIN"){
  			$url = $app['url_generator']->generate('logout');
  			return $app->redirect($url);
  		}
    $page = $app["dao.page"]->getContentById($id_page);
    $pages = $app["dao.page"]->getPagesByIdAdventure($id_adventure);
    if($page["ending"] != NULL){
      if($page["ending"] == "success"){
        $ending = "success";
      }
      if($page["ending"] == "fail"){
        $ending = "fail";
      }
      $choices = "";
    }
    else{
      $ending = "";
      $choices = $app["dao.choice"]->getChoicesByPageId($id_page);
    }
    return $app["twig"]->render('backoffice/pagemodification.html.twig', array("page" => $page, "pages"=>$pages, "choices" => $choices, "ending"=>$ending));
  }

  public function addPageFormProcessing(Application $app, $id_adventure){
    $page_number = $_POST["page_number"];
    $story = $_POST["story"];
    $ending = $_POST["ending"];
    $infos = array("id_adventure"=>$id_adventure, "page_number"=>$page_number, "story"=>$story, "ending"=>$ending );
    $id_current_page = $app["dao.page"]->createPage($infos);

    $choice1 = array("id_landing_page"=>$_POST["id_landing_page1"], "crew"=>$_POST["crew1"], "response"=>$_POST["response1"]);

    $choice2 = array("id_landing_page"=>$_POST["id_landing_page2"], "crew"=>$_POST["crew2"], "response"=>$_POST["response2"]);

    $choice3 = array("id_landing_page"=>$_POST["id_landing_page3"], "crew"=>$_POST["crew3"], "response"=>$_POST["response3"]);

    $choices = array("1"=>$choice1, "2"=>$choice2, "3"=>$choice3, "id_current_page"=>$id_current_page);
    $resultat = $app["dao.choice"]->createChoicesForAPage($choices);
    return $resultat;
  }
//Incomplete function modifyPageFormProcessing, update, not insert, get id page, and done
  public function modifyPageFormProcessing(Application $app, $id_page){
    $page_number = $_POST["page_number"];
    $story = $_POST["story"];
    $ending = $_POST["ending"];
    $infos = array("id_page"=>$id_page, "page_number"=>$page_number, "story"=>$story, "ending"=>$ending );
    $resultat = $app["dao.page"]->updatePage($infos);

    if ($ending == "non") {
      $choice1 = array("id_choice"=>$_POST["id_choice1"], "id_landing_page"=>$_POST["id_landing_page1"], "crew"=>$_POST["crew1"], "response"=>$_POST["response1"]);

      $choice2 = array("id_choice"=>$_POST["id_choice2"], "id_landing_page"=>$_POST["id_landing_page2"], "crew"=>$_POST["crew2"], "response"=>$_POST["response2"]);

      $choice3 = array("id_choice"=>$_POST["id_choice3"], "id_landing_page"=>$_POST["id_landing_page3"], "crew"=>$_POST["crew3"], "response"=>$_POST["response3"]);

      $choices = array("1"=>$choice1, "2"=>$choice2, "3"=>$choice3, "id_current_page"=>$id_page);
      $resultat .= " et ";
      $resultat .= $app["dao.choice"]->updateChoicesForAPage($choices);  
    }

    return $resultat;
  }
}
