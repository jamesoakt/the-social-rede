<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\LoginHandler;

class HomeController extends Controller {

    private $loggedUser;                    //refoçar os tipos de variavel

    public function __construct() {         //reforçar tipos de metodos __contruct
        $this->LoggedUser = LoginHandler::checkLogin();  //reforçar o para quê serve o this
        
        if($this->LoggedUser === false) {                      //diferença entre === e ==?
        
            $this->redirect('/login');              //estudar o THIS
        }
        
    }

    public function index() {
        $this->render('home', ['nome' => 'Bonieky']);
    }

}