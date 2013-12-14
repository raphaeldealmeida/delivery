<?php

namespace Delivery\Entity;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="produtos")
 */
class Produto {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column
     */
    protected $nome;
    
    /**
     * @ORM\Column
     */
    protected $descricao;
    
    /**
     * @ORM\Column(type="float", precision=2)
     */
    protected $valor = 0.00;
    
    /**
     * @ORM\Column(type="boolean")
     */
    protected $disponivel = 1;
    
    protected $inputFilter;

    /**
     * Método necessário para integração com TableGateway
     * 
     * @param array $data
     */
    public function exchangeArray($data) {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->nome = (!empty($data['nome'])) ? $data['nome'] : null;
        $this->descricao = (!empty($data['descricao'])) ? $data['descricao'] : null;
        $this->valor = (!empty($data['valor'])) ? $data['valor'] : 0.00;
        $this->disponivel = (!empty($data['disponivel'])) ? $data['disponivel'] : 1;
    }

    /**
     * Usado pelo Form::bind
     * 
     * @return array
     */
    public function getArrayCopy() {
        return get_object_vars($this);
    }

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getValor() {
        return number_format($this->valor, 2);
    }

    public function getDisponivel() {
        return $this->disponivel;
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("Not used");
    }

    public function getInputFilter() {

        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add(array(
                'name' => 'id',
                'required' => true,
                'filters' => array(
                    array('name' => 'Int'), //new Zend\Filter\Int
                ),
            ));

            $inputFilter->add(array(
                'name' => 'nome',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),  // new Zend\Filter\StripTags
                    array('name' => 'StringTrim'), //new Zend\Filter\StringTrim
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',  //new Zend\Validator\StringLength
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 1,
                            'max' => 100, 
                        ),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'descricao',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 1,
                            'max' => 400,
                        ),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'valor',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ), 
// depende da extensão PHP intl 
//                'validators' => array(
//                    array(
//                        'name' => 'Float',
//                    ),
//                ),
            ));

            $inputFilter->add(array(
                'name' => 'disponivel',
                'required' => false,
            ));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}