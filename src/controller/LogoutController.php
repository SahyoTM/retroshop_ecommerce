<?php

Class LogoutController
{
    public function index()
    {
        unset($_SESSION['token']);
        header('Location: /');
    }
}