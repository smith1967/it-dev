<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller {

    protected function initialize() {
        Phalcon\Tag::prependTitle('INVO | ');
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

}
