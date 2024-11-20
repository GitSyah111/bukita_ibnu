<?php
class Logout
{
    // Mengganti nama metode menjadi 'index'
    public function index()
    {
        session_start();
        session_destroy();
        header('location: ' . base_url . '/login');
        exit;
    }
}
