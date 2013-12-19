<?php

namespace Delivery\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Delivery\Form\LoginForm;
use Zend\View\Model\ViewModel;

class SessionController extends AbstractActionController {

    /**
     *
     * @var Zend\Authentication\AuthenticationService 
     */
    protected $authService;
    protected $em;
            
    public function loginAction(){
        
        $form = new LoginForm;
        
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $form->setData($request->getPost());
           // if ($form->isValid()) {
                $data = $request->getPost();
                $this->authService = $this->getServiceLocator()
                        ->get('Zend\Authentication\AuthenticationService');

                $adapter = $this->authService->getAdapter();
                $adapter->setIdentityValue($data['login']);
                $adapter->setCredentialValue($data['senha']);
                $authResult = $this->authService->authenticate();
                
                if($authResult->isValid()){
                    $this->flashMessenger()
                            ->addMessage('Login efetuado com sucesso.');
                    return $this->redirect()->toRoute('home');
                }else{
                    $this->flashMessenger()
                            ->addMessage('Usuário ou senha incorreto.');
                }
            //}
        }
        
        return new ViewModel(array(
            'loginForm' => $form
        ));
        
    }
    
    public function logoffAction(){
        $this->authService = $this->getServiceLocator()
                        ->get('Zend\Authentication\AuthenticationService');
        $this->authService->clearIdentity();
        $this->flashMessenger()
                            ->addMessage('Você saiu do sistema.');
        return $this->redirect()->toRoute('home');
    }
    
    public function criarContaAction(){
        
       $usuario = new \Delivery\Entity\Usuario();
       $builder = new \Zend\Form\Annotation\AnnotationBuilder();
       
       $form = $builder->createForm($usuario);
       $form->add(array(
             'name' => 'submit',
             'type' => 'Submit',
             
             'attributes' => array(
                 'value' => 'Criar conta',
                 'id' => 'submitbutton',
                 'class' => 'btn btn-primary'
             ),
         ));
       
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $usuario->exchangeArray($form->getData());
                $this->getEntityManager()->persist($usuario);
                $this->getEntityManager()->flush();
                
                $this->flashMessenger()
                        ->addMessage('Usuário criado com sucesso.');
                $this->redirect()->toRoute('login');
            }
        }
       
       return array('form' => $form); 
    }
    
    
    public function getEntityManager() {
        if (!$this->em) {
            $sm = $this->getServiceLocator();
            $this->em = $sm->get('Doctrine\ORM\EntityManager');
        }
        return $this->em;
    }
}