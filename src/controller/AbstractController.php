<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Extra\Intl\IntlExtension;

require_once __DIR__.'/../../vendor/autoload.php';

abstract class AbstractController
{
    protected $twig;
    protected $db;
   
    public function __construct()
    {
        require_once __DIR__.'/../database/database.php';

        $this->db = $db;

        $loader = new FilesystemLoader(__DIR__ . '/../view');
        $this->twig = new Environment($loader);
        $this->twig->addExtension(new IntlExtension());
        
        $user = $this->checkUserIsLog();

        if($user)
        {
            $this->twig->addGlobal('primary_user', $user);
        }
    }

    //add function to check if the user is logged in with token session and if the user role is admin
    public function checkUserIsLogAndAdmin()
    {
        //check if the user is logged in with token session
        if(!isset($_SESSION['token']))
        {
            header('Location: /login');
            exit();
        }

        //check if the user role in the database with the token session
        $query = $this->db->prepare('SELECT * FROM users WHERE token = :token');
        $query->execute(['token' => $_SESSION['token']]);
        $user = $query->fetch();

        if($user['role'] != 'admin')
        {
            header('Location: /');
            exit();
        }
    }

    //check if user is logged in with token session
    public function checkUserIsLog()
    {
        $user = null;

        if(isset($_SESSION['token']))
        {
            $query = $this->db->prepare('SELECT username, email, role FROM users WHERE token = :token');
            $query->execute(['token' => $_SESSION['token']]);
            $user = $query->fetch();   
        }

        return $user;
    }
}