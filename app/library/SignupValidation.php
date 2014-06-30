<?php

use Phalcon\Validation,
    Phalcon\Validation\Validator\PresenceOf,
    Phalcon\Validation\Validator\Email,
    Phalcon\Validation\Validator\Confirmation,
    Phalcon\Validation\Validator\Regex;

class SignupValidation extends Validation {

    public function initialize() {
        $this->add('name', new PresenceOf(array(
            'message' => 'ต้องใส่ชื่อ-นามสกุลด้วยครับ'
        )));

        $this->add('email', new PresenceOf(array(
            'message' => 'ต้องใส่ e-mail ด้วยครับ'
        )));

        $this->add('email', new Email(array(
            'message' => 'e-mail ไม่ถูกต้องครับ'
        )));
        $this->add('password', new Confirmation(array(
            'message' => 'รหัสผ่านไม่ตรงกันครับ',
            'with' => 'repeatPassword'
        )));
        $this->add('password', new Regex(array(
            'message' => 'รหัสผ่านต้องประกอบด้วยตัวอักษรตัวพิมพ์เล็ก ตัวพิมพ์ใหญ๋และตัวเลขไม่น้อยกว่า 5 ตัวอักษรครับ',
            'pattern' => '/^(?=.{5})(?=.*[A-Z])(?=.*[a-z])(?=.*\d)[-+%#a-zA-Z\d]+$/'
        )));        
    }
}
