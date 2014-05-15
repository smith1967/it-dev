<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class NewsController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for news
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "News", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "news_id";

        $news = News::find($parameters);
        if (count($news) == 0) {
            $this->flash->notice("The search did not find any news");

            return $this->dispatcher->forward(array(
                "controller" => "news",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $news,
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
     * Edits a new
     *
     * @param string $news_id
     */
    public function editAction($news_id)
    {

        if (!$this->request->isPost()) {

            $new = News::findFirstBynews_id($news_id);
            if (!$new) {
                $this->flash->error("new was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "news",
                    "action" => "index"
                ));
            }

            $this->view->news_id = $new->news_id;

            $this->tag->setDefault("news_id", $new->news_id);
            $this->tag->setDefault("news_title", $new->news_title);
            $this->tag->setDefault("news_detail", $new->news_detail);
            $this->tag->setDefault("news_url", $new->news_url);
            $this->tag->setDefault("news_by", $new->news_by);
            $this->tag->setDefault("news_level", $new->news_level);
            $this->tag->setDefault("news_date", $new->news_date);
            $this->tag->setDefault("news_pin", $new->news_pin);
            
        }
    }

    /**
     * Creates a new new
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "news",
                "action" => "index"
            ));
        }

        $new = new News();

        $new->news_title = $this->request->getPost("news_title");
        $new->news_detail = $this->request->getPost("news_detail");
        $new->news_url = $this->request->getPost("news_url");
        $new->news_by = $this->request->getPost("news_by");
        $new->news_level = $this->request->getPost("news_level");
        $new->news_date = $this->request->getPost("news_date");
        $new->news_pin = $this->request->getPost("news_pin");
        

        if (!$new->save()) {
            foreach ($new->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "news",
                "action" => "new"
            ));
        }

        $this->flash->success("new was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "news",
            "action" => "index"
        ));

    }

    /**
     * Saves a new edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "news",
                "action" => "index"
            ));
        }

        $news_id = $this->request->getPost("news_id");

        $new = News::findFirstBynews_id($news_id);
        if (!$new) {
            $this->flash->error("new does not exist " . $news_id);

            return $this->dispatcher->forward(array(
                "controller" => "news",
                "action" => "index"
            ));
        }

        $new->news_title = $this->request->getPost("news_title");
        $new->news_detail = $this->request->getPost("news_detail");
        $new->news_url = $this->request->getPost("news_url");
        $new->news_by = $this->request->getPost("news_by");
        $new->news_level = $this->request->getPost("news_level");
        $new->news_date = $this->request->getPost("news_date");
        $new->news_pin = $this->request->getPost("news_pin");
        

        if (!$new->save()) {

            foreach ($new->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "news",
                "action" => "edit",
                "params" => array($new->news_id)
            ));
        }

        $this->flash->success("new was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "news",
            "action" => "index"
        ));

    }

    /**
     * Deletes a new
     *
     * @param string $news_id
     */
    public function deleteAction($news_id)
    {

        $new = News::findFirstBynews_id($news_id);
        if (!$new) {
            $this->flash->error("new was not found");

            return $this->dispatcher->forward(array(
                "controller" => "news",
                "action" => "index"
            ));
        }

        if (!$new->delete()) {

            foreach ($new->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "news",
                "action" => "search"
            ));
        }

        $this->flash->success("new was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "news",
            "action" => "index"
        ));
    }

}
