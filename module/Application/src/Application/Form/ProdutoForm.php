<?php

namespace Application\Form;

 use Zend\Form\Form;

 class ProdutoForm extends Form{
     
     public function __construct($name = null)
     {
         
         parent::__construct('Produto');

         $this->add(array(
             'name' => 'id',
             'type' => 'Hidden',
         ));
         
         $this->add(array(
             'name' => 'nome',
             'type' => 'Text', //new \Zend\Form\Element\Text()
             'options' => array(
                 'label' => 'Nome',
             ),
         ));
         
         $this->add(array(
             'name' => 'descricao',
             'type' => 'Textarea',
             'options' => array(
                 'label' => 'Descrição',
             ),
         ));
         
         $this->add(array(
             'name' => 'valor',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Valor',
             ),
         ));
         
         $this->add(array(
             'name' => 'disponivel',
             'type' => 'Checkbox', //new \Zend\Form\Element\Checkbox
             'options' => array(
                 'label' => 'Disponível',
                 'checked_value' => true,
                 'unchecked_value' => false,
             ),
         ));
         
         $this->add(array(
             'name' => 'submit',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Enviar',
                 'id' => 'submitbutton',
                 'class' => 'btn btn-primary'
             ),
         ));
     }
 }