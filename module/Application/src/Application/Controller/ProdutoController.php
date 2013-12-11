<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\Produto;
use Application\Form\ProdutoForm;

class ProdutoController extends AbstractActionController {

    /**
     *
     * @var Application\Model\ProdutoTable
     */
    protected $produtoTable;

    public function indexAction() {
        return new ViewModel(array(
            'produtos' => $this->getProdutoTable()->fetchAll(),
        ));
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
                $this->getProdutoTable()->saveProduto($produto);

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
            $produto = $this->getProdutoTable()->getProduto($id);
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
                $this->getProdutoTable()->saveProduto($produto);


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

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getProdutoTable()->deleteProduto($id);
            }

            return $this->redirect()->toRoute('produto');
        }

        return array(
            'id' => $id,
            'produto' => $this->getProdutoTable()->getProduto($id)
        );
    }

    public function getProdutoTable() {
        if (!$this->produtoTable) {
            $sm = $this->getServiceLocator();
            $this->produtoTable = $sm->get('Application\Model\ProdutoTable');
        }
        return $this->produtoTable;
    }

}
