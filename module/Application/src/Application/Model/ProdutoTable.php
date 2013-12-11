<?php

namespace Application\Model;

 use Zend\Db\TableGateway\TableGateway;

 class ProdutoTable
 {
     protected $tableGateway;

     public function __construct(TableGateway $tableGateway)
     {
         $this->tableGateway = $tableGateway;
     }

     public function fetchAll()
     {
         $resultSet = $this->tableGateway->select();
         return $resultSet;
     }

     public function getProduto($id)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('id' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Não foi possível achar o registro $id");
         }
         return $row;
     }

     public function saveProduto(Produto $produto)
     {
         $data = array(
             'nome' => $produto->getNome(),
             'descricao'  => $produto->getDescricao(),
             'valor'  => $produto->getValor(),
             'disponivel'  => $produto->getDisponivel(),
         );

         $id = (int) $produto->getId();
         if ($id == 0) {
             $this->tableGateway->insert($data);
         } else {
             if ($this->getProduto($id)) {
                 $this->tableGateway->update($data, array('id' => $id));
             } else {
                 throw new \Exception('id do produto não existe');
             }
         }
     }

     public function deleteProduto($id)
     {
         $this->tableGateway->delete(array('id' => (int) $id));
     }
 }