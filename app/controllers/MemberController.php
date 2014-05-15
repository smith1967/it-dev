<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class MemberController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for member
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Member", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "mem_id";

        $member = Member::find($parameters);
        if (count($member) == 0) {
            $this->flash->notice("The search did not find any member");

            return $this->dispatcher->forward(array(
                "controller" => "member",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $member,
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
     * Edits a member
     *
     * @param string $mem_id
     */
    public function editAction($mem_id)
    {

        if (!$this->request->isPost()) {

            $member = Member::findFirstBymem_id($mem_id);
            if (!$member) {
                $this->flash->error("member was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "member",
                    "action" => "index"
                ));
            }

            $this->view->mem_id = $member->mem_id;

            $this->tag->setDefault("mem_id", $member->mem_id);
            $this->tag->setDefault("mem_user", $member->mem_user);
            $this->tag->setDefault("mem_pass", $member->mem_pass);
            $this->tag->setDefault("mem_fname_th", $member->mem_fname_th);
            $this->tag->setDefault("mem_fname_en", $member->mem_fname_en);
            $this->tag->setDefault("mem_lname_th", $member->mem_lname_th);
            $this->tag->setDefault("mem_lname_en", $member->mem_lname_en);
            $this->tag->setDefault("mem_disp_name", $member->mem_disp_name);
            $this->tag->setDefault("mem_birth", $member->mem_birth);
            $this->tag->setDefault("mem_nation", $member->mem_nation);
            $this->tag->setDefault("mem_race", $member->mem_race);
            $this->tag->setDefault("mem_religion", $member->mem_religion);
            $this->tag->setDefault("mem_nation_id", $member->mem_nation_id);
            $this->tag->setDefault("mem_position", $member->mem_position);
            $this->tag->setDefault("mem_org_name", $member->mem_org_name);
            $this->tag->setDefault("mem_org_prov", $member->mem_org_prov);
            $this->tag->setDefault("mem_email", $member->mem_email);
            $this->tag->setDefault("mem_mobile", $member->mem_mobile);
            $this->tag->setDefault("mem_tel", $member->mem_tel);
            $this->tag->setDefault("mem_fax", $member->mem_fax);
            $this->tag->setDefault("mem_teach", $member->mem_teach);
            $this->tag->setDefault("mem_other", $member->mem_other);
            $this->tag->setDefault("mem_talent", $member->mem_talent);
            $this->tag->setDefault("mem_prof1", $member->mem_prof1);
            $this->tag->setDefault("mem_prof2", $member->mem_prof2);
            $this->tag->setDefault("mem_photo", $member->mem_photo);
            $this->tag->setDefault("mem_reg_date", $member->mem_reg_date);
            $this->tag->setDefault("mem_active", $member->mem_active);
            $this->tag->setDefault("mem_role", $member->mem_role);
            $this->tag->setDefault("mem_last_login", $member->mem_last_login);
            $this->tag->setDefault("mem_last_ip", $member->mem_last_ip);
            $this->tag->setDefault("mem_club_admin", $member->mem_club_admin);
            
        }
    }

    /**
     * Creates a new member
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "member",
                "action" => "index"
            ));
        }

        $member = new Member();

        $member->mem_user = $this->request->getPost("mem_user");
        $member->mem_pass = $this->request->getPost("mem_pass");
        $member->mem_fname_th = $this->request->getPost("mem_fname_th");
        $member->mem_fname_en = $this->request->getPost("mem_fname_en");
        $member->mem_lname_th = $this->request->getPost("mem_lname_th");
        $member->mem_lname_en = $this->request->getPost("mem_lname_en");
        $member->mem_disp_name = $this->request->getPost("mem_disp_name");
        $member->mem_birth = $this->request->getPost("mem_birth");
        $member->mem_nation = $this->request->getPost("mem_nation");
        $member->mem_race = $this->request->getPost("mem_race");
        $member->mem_religion = $this->request->getPost("mem_religion");
        $member->mem_nation_id = $this->request->getPost("mem_nation_id");
        $member->mem_position = $this->request->getPost("mem_position");
        $member->mem_org_name = $this->request->getPost("mem_org_name");
        $member->mem_org_prov = $this->request->getPost("mem_org_prov");
        $member->mem_email = $this->request->getPost("mem_email");
        $member->mem_mobile = $this->request->getPost("mem_mobile");
        $member->mem_tel = $this->request->getPost("mem_tel");
        $member->mem_fax = $this->request->getPost("mem_fax");
        $member->mem_teach = $this->request->getPost("mem_teach");
        $member->mem_other = $this->request->getPost("mem_other");
        $member->mem_talent = $this->request->getPost("mem_talent");
        $member->mem_prof1 = $this->request->getPost("mem_prof1");
        $member->mem_prof2 = $this->request->getPost("mem_prof2");
        $member->mem_photo = $this->request->getPost("mem_photo");
        $member->mem_reg_date = $this->request->getPost("mem_reg_date");
        $member->mem_active = $this->request->getPost("mem_active");
        $member->mem_role = $this->request->getPost("mem_role");
        $member->mem_last_login = $this->request->getPost("mem_last_login");
        $member->mem_last_ip = $this->request->getPost("mem_last_ip");
        $member->mem_club_admin = $this->request->getPost("mem_club_admin");
        

        if (!$member->save()) {
            foreach ($member->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "member",
                "action" => "new"
            ));
        }

        $this->flash->success("member was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "member",
            "action" => "index"
        ));

    }

    /**
     * Saves a member edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "member",
                "action" => "index"
            ));
        }

        $mem_id = $this->request->getPost("mem_id");

        $member = Member::findFirstBymem_id($mem_id);
        if (!$member) {
            $this->flash->error("member does not exist " . $mem_id);

            return $this->dispatcher->forward(array(
                "controller" => "member",
                "action" => "index"
            ));
        }

        $member->mem_user = $this->request->getPost("mem_user");
        $member->mem_pass = $this->request->getPost("mem_pass");
        $member->mem_fname_th = $this->request->getPost("mem_fname_th");
        $member->mem_fname_en = $this->request->getPost("mem_fname_en");
        $member->mem_lname_th = $this->request->getPost("mem_lname_th");
        $member->mem_lname_en = $this->request->getPost("mem_lname_en");
        $member->mem_disp_name = $this->request->getPost("mem_disp_name");
        $member->mem_birth = $this->request->getPost("mem_birth");
        $member->mem_nation = $this->request->getPost("mem_nation");
        $member->mem_race = $this->request->getPost("mem_race");
        $member->mem_religion = $this->request->getPost("mem_religion");
        $member->mem_nation_id = $this->request->getPost("mem_nation_id");
        $member->mem_position = $this->request->getPost("mem_position");
        $member->mem_org_name = $this->request->getPost("mem_org_name");
        $member->mem_org_prov = $this->request->getPost("mem_org_prov");
        $member->mem_email = $this->request->getPost("mem_email");
        $member->mem_mobile = $this->request->getPost("mem_mobile");
        $member->mem_tel = $this->request->getPost("mem_tel");
        $member->mem_fax = $this->request->getPost("mem_fax");
        $member->mem_teach = $this->request->getPost("mem_teach");
        $member->mem_other = $this->request->getPost("mem_other");
        $member->mem_talent = $this->request->getPost("mem_talent");
        $member->mem_prof1 = $this->request->getPost("mem_prof1");
        $member->mem_prof2 = $this->request->getPost("mem_prof2");
        $member->mem_photo = $this->request->getPost("mem_photo");
        $member->mem_reg_date = $this->request->getPost("mem_reg_date");
        $member->mem_active = $this->request->getPost("mem_active");
        $member->mem_role = $this->request->getPost("mem_role");
        $member->mem_last_login = $this->request->getPost("mem_last_login");
        $member->mem_last_ip = $this->request->getPost("mem_last_ip");
        $member->mem_club_admin = $this->request->getPost("mem_club_admin");
        

        if (!$member->save()) {

            foreach ($member->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "member",
                "action" => "edit",
                "params" => array($member->mem_id)
            ));
        }

        $this->flash->success("member was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "member",
            "action" => "index"
        ));

    }

    /**
     * Deletes a member
     *
     * @param string $mem_id
     */
    public function deleteAction($mem_id)
    {

        $member = Member::findFirstBymem_id($mem_id);
        if (!$member) {
            $this->flash->error("member was not found");

            return $this->dispatcher->forward(array(
                "controller" => "member",
                "action" => "index"
            ));
        }

        if (!$member->delete()) {

            foreach ($member->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "member",
                "action" => "search"
            ));
        }

        $this->flash->success("member was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "member",
            "action" => "index"
        ));
    }

}
