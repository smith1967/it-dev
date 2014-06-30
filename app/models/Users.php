<?php
use Phalcon\Mvc\Model\Validator\PresenceOf;
use Phalcon\Mvc\Model\Validator\Email;
use Phalcon\Mvc\Model\Validator\Uniqueness;
use Phalcon\Mvc\Model\Validator\Regex;

class Users extends Phalcon\Mvc\Model
{
    public function validation()
    {

        $this->validate(new Uniqueness(array(
            'field' => 'username',
            'message' => 'ชื่อผู้ใช้ถูกใช้ไปแล้วครับ'
        )));  
        $this->validate(new Uniqueness(array(
            'field' => 'email',
            'message' => 'อีเมล์ถูกใช้ไปแล้วครับ'
        )));         
        if ($this->validationHasFailed() == true) {
            return false;
        }
    }
}
