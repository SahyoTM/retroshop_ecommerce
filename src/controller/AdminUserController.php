<?php

require_once __DIR__.'/AbstractController.php';

Class AdminUserController extends AbstractController
{
    //add method index to display the list of users
    public function index()
    {
        //call the method to check if user is admin
        $this->checkUserIsLogAndAdmin();

        $req = $this->db->query('SELECT id, username, role, email FROM users');
        $users = $req->fetchAll();

        $template = $this->twig->load('AdminUser.html.twig');
        echo $template->render(['users' => $users]);
    }

    //add method to delete a user
    public function delete()
    {
        //call the method to check if user is admin
        $this->checkUserIsLogAndAdmin();
        $user = $this->checkUserIsLog();

        var_dump($_POST['user_id']);

        if($user['id'] != $_POST['user_id'])
        {
            $query = $this->db->prepare('DELETE FROM users WHERE id = :id');
            $query->execute(['id' => $_POST['user_id']]);

            //redirect to the list of users
            header('Location: /admin-user');
        }else{
            $req = $this->db->query('SELECT id, username, role, email FROM users');
            $users = $req->fetchAll();

            $template = $this->twig->load('AdminUser.html.twig');
            echo $template->render(['error' => 'You can\'t delete yourself', 'users' => $users]);
        }
    }

    //add method to add a user
    public function add()
    {
        //call the method to check if user is admin
        $this->checkUserIsLogAndAdmin();

        $query = $this->db->prepare('INSERT INTO users (username, password, email, role) VALUES (:username, :password, :email, :role)');
        $query->execute([
            'username' => $_POST['user_username'],
            'password' => sha1($_POST['user_password']),
            'email' => $_POST['user_email'],
            'role' => $_POST['user_role']
        ]);

        //redirect to the index method
        header('Location: /admin-user');
    }

    //add method to edit the role of an user
    public function role()
    {
        //call the method to check if user is admin
        $this->checkUserIsLogAndAdmin();
        $user = $this->checkUserIsLog();

        var_dump($_POST['user_id']);

        if($user['id'] != $_POST['user_id'])
        {
            $query = $this->db->prepare('UPDATE users SET role = :role WHERE id = :id');
            $query->execute([
                'role' => $_POST['user_role'],
                'id' => $_POST['user_id']
            ]);

            //redirect to the index method
            header('Location: /admin-user');
        }else{
            $req = $this->db->query('SELECT id, username, role, email FROM users');
            $users = $req->fetchAll();

            $template = $this->twig->load('AdminUser.html.twig');
            echo $template->render(['error' => 'You can\'t change your role to client', 'users' => $users]);
        }
    }
}