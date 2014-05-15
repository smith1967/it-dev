<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class PositionController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for position
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Position", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "pos_id";

        $position = Position::find($parameters);
        if (count($position) == 0) {
            $this->flash->notice("The search did not find any position");

            return $this->dispatcher->forward(array(
                "controller" => "position",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $position,
            "limit"=> 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displayes the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a position
     *
     * @param string $pos_id
     */
    public function editAction($pos_id)
    {

        if (!$this->request->isPost()) {

            $position = Position::findFirstBypos_id($pos_id);
            if (!$position) {
                $this->flash->error("position was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "position",
                    "action" => "index"
                ));
            }

            $this->view->pos_id = $position->pos_id;

            $this->tag->setDefault("pos_id", $position->pos_id);
            $this->tag->setDefault("pos_name_th", $position->pos_name_th);
            $this->tag->setDefault("pos_name_en", $position->pos_name_en);
            $this->tag->setDefault("pos_order", $position->pos_order);
            $this->tag->setDefault("pos_max_member", $position->pos_max_member);
            
        }
    }

    /**
     * Creates a new position
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "position",
                "action" => "index"
            ));
        }

        $position = new Position();

        $position->pos_name_th = $this->request->getPost("pos_name_th");
        $position->pos_name_en = $this->request->getPost("pos_name_en");
        $position->pos_order = $this->request->getPost("pos_order");
        $position->pos_max_member = $this->request->getPost("pos_max_member");
        

        if (!$position->save()) {
            foreach ($position->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "position",
                "action" => "new"
            ));
        }

        $this->flash->success("position was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "position",
            "action" => "index"
        ));

    }

    /**
     * Saves a position edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "position",
                "action" => "index"
            ));
        }

        $pos_id = $this->request->getPost("pos_id");

        $position = Position::findFirstBypos_id($pos_id);
        if (!$position) {
            $this->flash->error("position does not exist " . $pos_id);

            return $this->dispatcher->forward(array(
                "controller" => "position",
                "action" => "index"
            ));
        }

        $position->pos_name_th = $this->request->getPost("pos_name_th");
        $position->pos_name_en = $this->request->getPost("pos_name_en");
        $position->pos_order = $this->request->getPost("pos_order");
        $position->pos_max_member = $this->request->getPost("pos_max_member");
        

        if (!$position->save()) {

            foreach ($position->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "position",
                "action" => "edit",
                "params" => array($position->pos_id)
            ));
        }

        $this->flash->success("position was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "position",
            "action" => "index"
        ));

    }

    /**
     * Deletes a position
     *
     * @param string $pos_id
     */
    public function deleteAction($pos_id)
    {

        $position = Position::findFirstBypos_id($pos_id);
        if (!$position) {
            $this->flash->error("position was not found");

            return $this->dispatcher->forward(array(
                "controller" => "position",
                "action" => "index"
            ));
        }

        if (!$position->delete()) {

            foreach ($position->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "position",
                "action" => "search"
            ));
        }

        $this->flash->success("position was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "position",
            "action" => "index"
        ));
    }

}
