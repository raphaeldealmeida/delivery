<?php

namespace Delivery\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pedidos
 *
 * @ORM\Table(name="pedidos")
 * @ORM\Entity
 */
class Pedidos
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
     * @var \DateTime
     *
     * @ORM\Column(name="data_de_criacao", type="datetime", nullable=false)
     */
    private $dataDeCriacao;

    /**
     * @var integer
     *
     * @ORM\Column(name="situacao", type="integer", nullable=false)
     */
    private $situacao;

    /**
     * @var float
     *
     * @ORM\Column(name="desconto", type="float", precision=10, scale=0, nullable=false)
     */
    private $desconto;

    /**
     * @var integer
     *
     * @ORM\Column(name="endereco_id", type="integer", nullable=false)
     */
    private $enderecoId;

    /**
     * @var integer
     *
     * @ORM\Column(name="cliente_id", type="integer", nullable=false)
     */
    private $clienteId;


}
