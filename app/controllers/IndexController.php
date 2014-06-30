<?php

class IndexController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateAfter('main');
        Phalcon\Tag::setTitle('ยินดีต้อนรับ');
        parent::initialize();
    }

    public function indexAction()
    {
        if (!$this->request->isPost()) {
            //$this->getContent();
            $this->flash->notice('กำลังอยู่ในช่วงเริ่มต้นการศึกษาและพัฒนาระบบข้อมูลด้วย phalcon framework');
        }
    }

}

