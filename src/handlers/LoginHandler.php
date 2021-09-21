<?php
namespace src\handlers;

use src\models\User;                         //reforçar o uso de use, namespace etc...

class LoginHandler {

    public static function checkLogin() {        //refoçar a criação de função, static, public etc...
        
        if(!empty($_SESSION['token'])) {
            
            $token = $_SESSION['token'];
            $data = User::select()->where('token', $token)->one();  //função one, do model 
            
            if(count($data) > 0) {

                $loggedUser = new User();
                $loggedUser->Id = $data['id'];
                $loggedUser->Name = $data['name'];

                return $loggedUser;

            } 
        }
   
        return false;
    }
    
    public static function verifyLogin($email, $password) {
        $user = User::select()->where('email', $email)->one();
        
        if($user) {
            if(password_verify($password, $user['password'])) { 
                $token = md5(time().rand(0,9999).time());
            
                User::update()
                ->set('token', $token)
                ->where('email', $email)
                ->execute();

                return $token;
           
            }


        }

        return false;

    }

    public function emailExists($email) {
        $user = User::select()->where('email', $email)->one();
        return $user ? true : false;                                        //estudar return ? e :
    }

    public function addUser($name, $email, $password, $birthdate) { 
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $token = md5(time().rand(0,9999).time());

        User::insert([
            'email' => $email,
            'name' => $name,
            'password' => $hash,
            'birthdate' => $birthdate,
            'avatar' => 'default.jpg',
            'cover' => 'cover.jpg',
            'token' => $token
        ])->execute();
    }

}