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
        $this->render('login', ['flash' => $flash ]);
        
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
        echo 'cadastro';
    }
}