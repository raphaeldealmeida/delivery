<?php

namespace Delivery\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Enderecos
 *
 * @ORM\Table(name="enderecos")
 * @ORM\Entity
 */
class Enderecos
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="cliente_id", type="integer", nullable=false)
     */
    private $clienteId;

    /**
     * @var string
     *
     * @ORM\Column(name="logradouro", type="string", length=255, nullable=false)
     */
    private $logradouro;

    /**
     * @var string
     *
     * @ORM\Column(name="numero", type="string", length=100, nullable=false)
     */
    private $numero;

    /**
     * @var string
     *
     * @ORM\Column(name="bairro", type="string", length=100, nullable=false)
     */
    private $bairro;

    /**
     * @var string
     *
     * @ORM\Column(name="cidade", type="string", length=100, nullable=false)
     */
    private $cidade;

    /**
     * @var string
     *
     * @ORM\Column(name="uf", type="string", length=2, nullable=false)
     */
    private $uf;

    /**
     * @var string
     *
     * @ORM\Column(name="cep", type="string", length=7, nullable=false)
     */
    private $cep;

    /**
     * @var integer
     *
     * @ORM\Column(name="tipo", type="integer", nullable=false)
     */
    private $tipo;


}
