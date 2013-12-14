<?php

namespace Delivery\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class ProdutoController extends AbstractActionController{

    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    public function indexAction(){
        $produtos = $this->getEntityManager()
                         ->getRepository('Delivery\Entity\Produto')
                         ->findAll();
        
        return array('produtos' => $produtos);
//        return new \Zend\View\Model\ViewModel(
//                array('produtos' => $produtos)
//                );
    }
    
    public function getEntityManager() {
        if (!$this->em) {
            $sm = $this->getServiceLocator();
            $this->em= $sm->get('Doctrine\ORM\EntityManager');
        }
        return $this->em;
    }
}