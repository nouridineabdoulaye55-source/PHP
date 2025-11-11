<?php
session_start();

function isLoggedIn()
{
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

function requireLogin()
{
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

function getUserInfo()
{
    if (isLoggedIn()) {
        return [
            'id' => $_SESSION['user_id'],
            'email' => $_SESSION['user_email'],
            'prenom' => $_SESSION['user_prenom'],
            'nom' => $_SESSION['user_nom']
        ];
    }
    return null;
}
