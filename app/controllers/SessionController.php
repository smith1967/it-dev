<?php

use Phalcon\Tag as Tag;
use Phalcon\Validation,
    Phalcon\Mvc\Model\Validator\PresenceOf,
    Phalcon\Mvc\Model\Validator\Email,
    Phalcon\Validation\Validator\Regex;
        
class SessionController extends ControllerBase {

    public function initialize() {
        $this->view->setTemplateAfter('main');
        Tag::setTitle('สมัครสมาชิก/เข้าระบบ');
        parent::initialize();
    }

    public function indexAction() {
        if (!$this->request->isPost()) {
            Tag::setDefault('username', 'admin');
            Tag::setDefault('password', 'admin');
        }
    }

    public function loginAction() {
        //if(!$this->isUser()){
        Phalcon\Tag::setTitle('ล็อกอินเข้าสู่ระบบ :: IT-Dev');

        if ($this->request->isPost()) {

            if ($this->security->checkToken()) {
                //Receiving the variables sent by POST
                $username = $this->request->getPost('username');
                $password = $this->request->getPost('password');

                //Find the user in the database
                $user = Users::findFirst(array(
                            "username = :username: AND password = :password:",
                            "bind" => array('username' => $username,
                                'password' => md5($password)) // เข้ารหัส
                ));

                if ($user != false) {

                    $this->_registerSession($user);

                    $this->flash->success('ยินดีต้อนรับ คุณ ' . $user->name);

                    //Forward to the 'invoices' controller if the user is valid
                    return $this->dispatcher->forward(array(
                                'controller' => 'index',
                                'action' => 'index'
                    ));
                }

                $this->flash->error('กรุณาตรวจสอบชื่อผู้ใช้และรหัสผ่าน');
                return $this->dispatcher->forward(array(
                            'controller' => 'session',
                            'action' => 'message'
                ));
            } else {
                $this->flash->error('ท่านกำลังใช้ข้อมูลการเข้าระบบไม่ถูกต้อง');
                return $this->dispatcher->forward(array(
                            'controller' => 'session',
                            'action' => 'index'
                ));
            }
        } else {
            if ($this->isUser())
                $this->response->redirect('session/profile');
        }
    }


    /**
     * Register authenticated user into session data
     *
     * @param Users $user
     */
    private function _registerSession($user) {
        $this->session->set('auth', array(
            'id' => $user->id,
            'name' => $user->name
        ));
    }

    /**
     * This actions receive the input from the login form
     *
     */
    public function startAction() {
        if ($this->request->isPost()) {
            $email = $this->request->getPost('email', 'email');

            $password = $this->request->getPost('password');
            $password = md5($password);

            $user = Users::findFirst("email='$email' AND password='$password' AND active='Y'");
            if ($user != false) {
                $this->_registerSession($user);
                $this->flash->success('ยินดีต้อนรับ ' . $user->name);
                return $this->forward('index/index');
            }

//            $username = $this->request->getPost('email', 'alphanum');
//            $user = Users::findFirst("username='$username' AND password='$password' AND active='Y'");
//            if ($user != false) {
//                $this->_registerSession($user);
//                $this->flash->success('Welcome ' . $user->name);
//                return $this->forward('invoices/index');
//            }

            $this->flash->error('อีเมล์หรือรหัสผ่านผิดพลาด');
        }

        return $this->forward('session/index');
    }

    /**
     * Finishes the active session redirecting to the index
     *
     * @return unknown
     */
    public function endAction() {
        $this->session->remove('auth');
        $this->flash->success('Goodbye!');
        return $this->forward('index/index');
    }

}
