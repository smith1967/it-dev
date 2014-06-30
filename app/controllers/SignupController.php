<?php

use Phalcon\Tag as Tag;

class SignupController extends ControllerBase {

    public function initialize() {
        $this->view->setTemplateAfter('main');
        Tag::setTitle('สมัครสมาชิก');
        parent::initialize();
    }

    public function indexAction() {
        $this->forward('signup/register');
    }

    public function registerAction() {

        if ($this->request->isPost()) {
            if ($this->security->checkToken()) {
            $validation = new SignupValidation();
            
            $messages = $validation->validate($_POST);
            if (count($messages)) {
                $errors = "<ul>";
                foreach ($messages as $message) {
                   $errors .= "<li>".$message."</li>";
                }
                $errors .= "</ul>";
                $this->flash->error($errors);
                return FALSE;
            }
                $user = new Users(); // Model

                $name = $this->request->getPost('name', 'striptags'); // ข้อมูลประเภท string
                $username = $this->request->getPost('username', 'alphanum');
                $password = $this->request->getPost('password');
                $email = $this->request->getPost('email', 'email'); // ข้อมูลประเภท email
                $repeatPassword = $this->request->getPost('repeatPassword');

                $user->name = $name;
                $user->username = $username;
                $user->password = md5($password); // เข้ารหัส SHA1 + MD5 (2 ชั้น)
                $user->email = $email;
                $user->created_at = new Phalcon\Db\RawValue('now()');
                $user->active = 'Y';
                if ($user->validation() == FALSE) {
                        $errors = "<ul>";
                        // getMessages from users models
                        foreach ($user->getMessages() as $message) {
                            $errors .= "<li>" . $message . "</li>";
                        }
                        $errors .= "</ul>";
                        $this->flash->error($errors);
                        return FALSE;                   
                }
                $success = $user->save();
                if ($success) {
                    $this->flash->success("สมัครสมาชิกเรียบร้อยแล้วครับ");
                    return $this->forward("index/index");
                }
            } else {
                $message = 'พบข้อผิดพลาด :: ระบบไม่สามารถบันทึกข้อมูลสมาชิกได้.กรุณาตรวจสอบข้อมูลใหม่ครับ';
                $this->flash->error($message);
                return $this->dispatcher->forward(array(
                            'controller' => 'signup',
                            'action' => 'index'
                ));
            }
        }
    }

}
