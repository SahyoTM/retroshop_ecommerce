<?php

require_once __DIR__.'/AbstractController.php';

Class UserProfilController extends AbstractController
{
    //add method index to display the profil of the user logged in with token session
    public function index()
    {
        //check if the user is logged in with token session
        if($user = $this->checkUserIsLog())
        {
            //remove password from user array
            unset($user['password']);

            $template = $this->twig->load('UserProfil.html.twig');
            echo $template->render(['user' => $user]);
        }else{
            header('Location: /login');
            exit();
        }
    }

    //add method edit
    public function edit()
    {
        //check if the user is logged in with token session
        if($user = $this->checkUserIsLog())
        {
            //use db to edit user
            $req = $this->db->prepare('UPDATE users SET username = :username, email = :email, password = :password WHERE id = :id');
            $req->execute([
                'username' => $_POST['profil_username'],
                'email' => $_POST['profil_email'],
                'password' => sha1($_POST['profil_password']),
                'id' => $user['id']
            ]);

            //redirect to profil page
            header('Location: /user-profil');
        }else{
            header('Location: /login');
            exit();
        }
    }

}