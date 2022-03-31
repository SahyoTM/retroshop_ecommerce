<?php

require_once __DIR__.'/AbstractController.php';

Class LoginController extends AbstractController
{
    public function index()
    {
        if($this->checkUserIsLog())
        {
            header('Location: /');
            exit();
        }
        
        $template = $this->twig->load('Login.html.twig');
        echo $template->render();
    }

    //add method login with post parameters $password and $username and use the database to check if the user exists and if the password is correct
    public function login()
    {
        //check if user is logged
        if($this->checkUserIsLog())
        {
            header('Location: /');
            exit();
        }

        //check if the user exists
        $query = $this->db->prepare('SELECT * FROM users WHERE username = :username');
        $query->execute(['username' => $_POST['username']]);
        $user = $query->fetch();

        if($user && (sha1($_POST['password']) == $user['password'])){
            $token = bin2hex(random_bytes(32));
            $_SESSION['token'] = $token;

            //add the token to the database
            $query = $this->db->prepare('UPDATE users SET token = :token WHERE username = :username');
            $query->execute(['username' => $_POST['username'], 'token' => $token]);

            //redirect to the index page
            header('Location: /');
        }else{
            $template = $this->twig->load('Login.html.twig');
            echo $template->render(['error' => 'Wrong username or password']);
        }
    }
}