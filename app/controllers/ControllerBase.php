<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller {

    protected function initialize() {
        Phalcon\Tag::prependTitle('IT-Dev | ');
    }

    protected function forward($uri) {
        $uriParts = explode('/', $uri);
        return $this->dispatcher->forward(
                        array(
                            'controller' => $uriParts[0],
                            'action' => $uriParts[1]
                        )
        );
    }

    protected function redirect($uri) {
        $uriParts = explode('/', $uri);
        return $this->response->redirect(
                        array(
                            'controller' => $uriParts[0],
                            'action' => $uriParts[1]
                        )
        );
    }    
}
