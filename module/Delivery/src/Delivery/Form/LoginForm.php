<?php

namespace Delivery\Form;

use Zend\Form\Form;

class LoginForm extends Form {

    public function __construct($name = null) {
        parent::__construct('Login');
        
        $this->add(array(
            'name' => 'login',
             'type' => 'Text', 
             'options' => array(
                 'label' => 'Login',
             ),
        ));
        
        $this->add(array(
            'name' => 'senha',
             'type' => 'Password',
             'options' => array(
                 'label' => 'Senha',
             ),
        ));
        
        $this->add(array(
             'name' => 'submit',
             'type' => 'Submit',
             
             'attributes' => array(
                 'value' => 'Entrar',
                 'id' => 'submitbutton',
                 'class' => 'btn btn-primary'
             ),
         ));
        
    }
}

