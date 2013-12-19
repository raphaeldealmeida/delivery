<?php

namespace Delivery\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 * Usuarios
 *
 * @ORM\Table(name="usuarios")
 * @ORM\Entity
 */
class Usuario
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Annotation\Attributes({"type":"hidden"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=100, nullable=false)
     * @Annotation\Options({"label":"Login:"})
     * @Annotation\Required({"required":"true"})
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="senha", type="string", length=100, nullable=false)
     * @Annotation\Options({"label":"Senha:"})
     * @Annotation\Required({"required":"true"})
     */
    private $senha;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=100, nullable=true)
     * @Annotation\Options({"label":"Nome:"})
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="cpf", type="string", length=11, nullable=true)
     * @Annotation\Options({"label":"CPF:"})
     */
    private $cpf;

    /**
     * @var string
     *
     * @ORM\Column(name="telefone", type="string", length=20, nullable=true)
     * @Annotation\Options({"label":"Telefone:"})
     */
    private $telefone;

    /**
     * @var boolean
     *
     * @ORM\Column(name="habilitado", type="boolean", nullable=true)
     * @Annotation\Exclude
     */
    private $habilitado;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=10, nullable=true)
     * @Annotation\Exclude
     */
    private $tipo;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getLogin() {
        return $this->login;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getCpf() {
        return $this->cpf;
    }

    public function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    public function getTelefone() {
        return $this->telefone;
    }

    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    public function getHabilitado() {
        return $this->habilitado;
    }

    public function setHabilitado($habilitado) {
        $this->habilitado = $habilitado;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function exchangeArray($data) {
        $this->login = (!empty($data['login'])) ? $data['login'] : null;
        $this->nome = (!empty($data['nome'])) ? $data['nome'] : null;
        $this->senha = (!empty($data['senha'])) ? $data['senha'] : null;
        $this->telefone = (!empty($data['telefone'])) ? $data['telefone'] : null;
        $this->cpf = (!empty($data['cpf'])) ? $data['cpf'] : null;
    }
}
