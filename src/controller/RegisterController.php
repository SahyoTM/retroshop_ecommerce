<?php

require_once __DIR__.'/AbstractController.php';

Class RegisterController extends AbstractController
{
    public function index()
    {
        $template = $this->twig->load('Register.html.twig');
        echo $template->render();
    }

    //add method register with post parameters $password and $username and use the database to create an user
    public function register()
    {
        include_once __DIR__.'/../database/database.php';

        //check if the user exists
        $query = $db->prepare('SELECT * FROM users WHERE username = :username');
        $query->execute(['username' => $_POST['username']]);
        $user = $query->fetch();

        //if the user exists
        if($user){
            //redirect to the register page
            //header('Location: /register');

            $template = $this->twig->load('Register.html.twig');
            echo $template->render(['error' => 'Username already exists']);

        }else{
            //create the user
            $query = $db->prepare('INSERT INTO users (username, email, password) VALUES (:username, :email, :password)');
            $query->execute(
                [
                    'username' => $_POST['username'], 
                    'password' => sha1($_POST['password']), 
                    'email' => $_POST['email']
                ]
            );

            //redirect to the login page
            header('Location: /login');
        }
    }
}
