<?php

namespace Delivery\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Delivery\Entity\Produto;
use Delivery\Form\ProdutoForm;

class ProdutoController extends AbstractActionController {

    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    public function indexAction() {
        $produtos = $this->getEntityManager()
                ->getRepository('Delivery\Entity\Produto')
                ->findAll();

        return array('produtos' => $produtos);
//        return new \Zend\View\Model\ViewModel(
//                array('produtos' => $produtos)
//                );
    }

    public function addAction() {
        $form = new ProdutoForm();
        $form->get('submit')->setValue('Inserir');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $produto = new Produto();
            $form->setInputFilter($produto->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $produto->exchangeArray($form->getData());
                $this->getEntityManager()->persist($produto);
                $this->getEntityManager()->flush();

                // Redirecionar para lista de produtos
                return $this->redirect()->toRoute('produto');
            }
        }
        return array('form' => $form);
    }

    public function editAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('produto', array(
                        'action' => 'add'
            ));
        }

        //Recupera o produto antes de editar
        try {
            $produto = $this->getEntityManager()
                    ->getRepository('Delivery\Entity\Produto')
                    ->find($id);
        } catch (\Exception $ex) {
            return $this->redirect()->toRoute('produto', array(
                        'action' => 'index'
            ));
        }

        $form = new ProdutoForm();
        $form->bind($produto);
        $form->get('submit')->setAttribute('value', 'Editar');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($produto->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getEntityManager()->persist($produto);
                $this->getEntityManager()->flush();

                return $this->redirect()->toRoute('produto');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('produto');
        }
        
        try {
            $produto = $this->getEntityManager()
                    ->getRepository('Delivery\Entity\Produto')
                    ->find($id);
        } catch (\Exception $ex) {
            return $this->redirect()->toRoute('produto', array(
                        'action' => 'index'
            ));
        }
        
        

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                
                $this->getEntityManager()->remove($produto);
                $this->getEntityManager()->flush();

            }

            return $this->redirect()->toRoute('produto');
        }

        return array(
            'id' => $id,
            'produto' => $produto
        );
    }

    public function getEntityManager() {
        if (!$this->em) {
            $sm = $this->getServiceLocator();
            $this->em = $sm->get('Doctrine\ORM\EntityManager');
        }
        return $this->em;
    }

}