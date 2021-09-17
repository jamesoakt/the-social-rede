<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\LoginHandler;


class LoginController extends Controller {

    public function signin() {
        $flash = '';
        if(!empty($_SESSION['flash'])) { 
            $flash = $_SESSION['flash'];
            $_SESSION['flash'] = '';                //estudar diferença entre '' e "" teste
       }
        $this->render('signin', ['flash' => $flash ]);
        
    }

    public function signinAction() {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);   //revisar função filter_input
        $password = filter_input(INPUT_POST, 'password');

        if($email && $password) {
            $token = LoginHandler::verifyLogin($email, $password);
            if($token) {
                $_SESSION['token'] = $token;   //estudar a variável _SESSION  e a forma [ ] dentro da varivel
                $this->redirect('/');          //estudar a função REDIRECT
            } else {
                $_SESSION['flash'] = 'Email e/ou senha não conferem.';
                $this->redirect('/login');
            }
        } else {
            $_SESSION['flash'] = 'Digite os campos de e-mail e/ou senha.';
            $this->redirect('/login');
        }
    }

    public function signup() {
        $flash = '';
        if(!empty($_SESSION['flash'])) { 
            $flash = $_SESSION['flash'];
            $_SESSION['flash'] = '';                //estudar diferença entre '' e "" teste
       }
        $this->render('signup', ['flash' => $flash ]);
    }

    public function signupAction() {
        $name = filter_input(INPUT_POST, 'name');
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);   //revisar função filter_input
        $password = filter_input(INPUT_POST, 'password');
        $birthdate = filter_input(INPUT_POST, 'birthdate');

        if($name && $email && $password && $birthdate) {
            $birthdate = explode('/', $birthdate);
            if(count($birthdate) != 3) {
                $_SESSION['flash'] = 'Data de nascimento inválida 1';
                $this->redirect('/cadastro');
            }

        $birthdate = $birthdate[2].'-'.$birthdate[1].'-'.$birthdate[0];
        if(strtotime($birthdate) === false) {
            $_SESSION['flash'] = 'Data de nascimento inválida! 2';
            $this->redirect('/cadastro');
        }

        if(LoginHandler::emailExists($email) == false) {
            $token = LoginHandler::addUser($name, $email, $password, $birthdate);
            $_SESSION['token'] = $token;
            $this->redirect('/');
        } else {
            $_SESSION['flash'] = 'E-mail já cadastrado!';
            $this->redirect('/cadastro');
        }
        
        } else{
            $this->redirect('/cadastro');
        } 

    }

}