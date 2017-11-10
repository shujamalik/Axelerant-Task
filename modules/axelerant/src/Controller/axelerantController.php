<?php


namespace Drupal\axelerant\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use \Drupal\node\Entity\Node;


/**
 * Controller routines for function routes.
 */
class axelerantController extends ControllerBase {

  public function axelerant_json() {
    $current_path = \Drupal::service('path.current')->getPath();
    $path_args = explode('/', $current_path);
    $node = Node::load($path_args[3]);
    $siteapikey = \Drupal::config('axelerant.settings')->get('siteapikey');
    if($node){
    if($siteapikey == $path_args[2] && $node->get('type')->getValue()[0]['target_id'] =='page'){
        $serializer = \Drupal::service('serializer');
        $data = $serializer->serialize($node, 'json', ['plugin_id' => 'entity']);
        return  new Response ($data);
      }
      else{
        return new JsonResponse('Access Denied.');
      }
    }
    else{
      return new JsonResponse('Access Denied.');
    }
    
    
    }
}
