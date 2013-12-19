<?php

namespace Delivery\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Delivery\Form\LoginForm;
use Zend\View\Model\ViewModel;
use \Zend\Form\Annotation\AnnotationBuilder;

class SessionController extends AbstractActionController {

    /**
     *
     * @var Zend\Authentication\AuthenticationService 
     */
    protected $authService;
            
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
    
    public function criarUsuarioAction(){
        $usuario = new \Delivery\Entity\Usuario();
        $builder = new AnnotationBuilder();
        $form = $builder->createForm($usuario);
        $form->add(array(
             'name' => 'submit',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Enviar',
                 'id' => 'submitbutton',
                 'class' => 'btn btn-primary'
             ),
         ));
        
        return array('form' => $form);
        
    }
    
    public function logoutAction(){
         $this->authService = $this->getServiceLocator()
                        ->get('Zend\Authentication\AuthenticationService');
         $this->authService->clearIdentity();
         $this->flashMessenger()
                            ->addMessage('Logout.');
         return $this->redirect()->toRoute('home');
    }
    
}
