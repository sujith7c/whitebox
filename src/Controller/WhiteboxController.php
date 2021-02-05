<?php
/**
 * Whitebox Module definitions
 */

namespace Drupal\whitebox\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\JsonResponse;

class WhiteboxController extends ControllerBase {
    /**
     * return string
     */
    public function finder(){
        return [
            '#markup' => $this->t('WhiteBox Module')
        ];
    }

    /**
     * Serve JSON content to the client with API key
     */
    public function serveJSON($API){
    /**
    * {@inheritdoc}
    */

        $json_array = array(
            'data' => array()
        );
        $nids = \Drupal::entityQuery('node')->condition('type','page')->execute();
        $nodes =  Node::loadMultiple($nids);
        //iterate node arrary
        foreach($nodes as $node) {
            $json_array['data'][] = array(
                'id' => $node->get('nid')->value,
                'attributes' => array(
                    'title' =>  $node->get('title')->value,
                    'content' => $node->get('body')->value,
                  ),
            );
        }
        //return JSON
        return new JsonResponse($json_array);
    }

//End of class
}

