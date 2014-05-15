<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class NewsLikeController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for news_like
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "NewsLike", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "like_id";

        $news_like = NewsLike::find($parameters);
        if (count($news_like) == 0) {
            $this->flash->notice("The search did not find any news_like");

            return $this->dispatcher->forward(array(
                "controller" => "news_like",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $news_like,
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
     * Edits a news_like
     *
     * @param string $like_id
     */
    public function editAction($like_id)
    {

        if (!$this->request->isPost()) {

            $news_like = NewsLike::findFirstBylike_id($like_id);
            if (!$news_like) {
                $this->flash->error("news_like was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "news_like",
                    "action" => "index"
                ));
            }

            $this->view->like_id = $news_like->like_id;

            $this->tag->setDefault("like_id", $news_like->like_id);
            $this->tag->setDefault("news_id", $news_like->news_id);
            $this->tag->setDefault("mem_id", $news_like->mem_id);
            $this->tag->setDefault("like_date", $news_like->like_date);
            
        }
    }

    /**
     * Creates a new news_like
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "news_like",
                "action" => "index"
            ));
        }

        $news_like = new NewsLike();

        $news_like->news_id = $this->request->getPost("news_id");
        $news_like->mem_id = $this->request->getPost("mem_id");
        $news_like->like_date = $this->request->getPost("like_date");
        

        if (!$news_like->save()) {
            foreach ($news_like->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "news_like",
                "action" => "new"
            ));
        }

        $this->flash->success("news_like was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "news_like",
            "action" => "index"
        ));

    }

    /**
     * Saves a news_like edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "news_like",
                "action" => "index"
            ));
        }

        $like_id = $this->request->getPost("like_id");

        $news_like = NewsLike::findFirstBylike_id($like_id);
        if (!$news_like) {
            $this->flash->error("news_like does not exist " . $like_id);

            return $this->dispatcher->forward(array(
                "controller" => "news_like",
                "action" => "index"
            ));
        }

        $news_like->news_id = $this->request->getPost("news_id");
        $news_like->mem_id = $this->request->getPost("mem_id");
        $news_like->like_date = $this->request->getPost("like_date");
        

        if (!$news_like->save()) {

            foreach ($news_like->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "news_like",
                "action" => "edit",
                "params" => array($news_like->like_id)
            ));
        }

        $this->flash->success("news_like was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "news_like",
            "action" => "index"
        ));

    }

    /**
     * Deletes a news_like
     *
     * @param string $like_id
     */
    public function deleteAction($like_id)
    {

        $news_like = NewsLike::findFirstBylike_id($like_id);
        if (!$news_like) {
            $this->flash->error("news_like was not found");

            return $this->dispatcher->forward(array(
                "controller" => "news_like",
                "action" => "index"
            ));
        }

        if (!$news_like->delete()) {

            foreach ($news_like->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "news_like",
                "action" => "search"
            ));
        }

        $this->flash->success("news_like was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "news_like",
            "action" => "index"
        ));
    }

}
