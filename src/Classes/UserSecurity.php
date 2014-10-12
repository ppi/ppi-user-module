<?php
namespace UserModule\Classes;

class UserSecurity
{

    protected $userStorage;
    protected $session;
    protected $user;
    protected $config;

    public function __construct()
    {

    }

    public function setUserStorage($storage)
    {
        $this->userStorage = $storage;
    }

    public function setSession($session)
    {
        $this->session = $session;
    }

    public function setConfig($config)
    {
        $this->config = $config;
    }

    public function isLoggedIn()
    {
        return $this->getUser() !== null;
    }

    public function logout()
    {
        $this->session->clear();
    }

    public function login($user)
    {
        $this->session->set('ppiAuthUser', $user);
    }

    public function getUser()
    {
        if ($this->user !== null) {
            return $this->user;
        }
        $this->user = $this->session->get('ppiAuthUser');
        return $this->user;
    }

    public function checkAuth($email, $password)
    {
        return $this->userStorage->checkAuth($email, $password, $this->config['authSalt']);
    }

}