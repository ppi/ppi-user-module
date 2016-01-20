<?php
namespace UserModule;

use PPI\Framework\Module\AbstractModule;

class Module extends AbstractModule
{
    protected $name = 'UserModule';

    /**
     * Get the configuration for this module
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->loadConfig(__DIR__ . '/resources/config/config.yml');
    }

    /**
     * Get the routes for this module
     *
     */
    public function getRoutes()
    {
        return $this->loadSymfonyRoutes(__DIR__ . '/resources/routes/symfony.yml');
    }

    public function getServiceConfig()
    {
        return array('factories' => array(

            'user.storage' => function ($sm) {
                 return new \UserModule\Storage\User($sm->get('datasource')->getConnection('main'));
            },

            'user.security' => function ($sm) {
                $us = new \UserModule\Classes\UserSecurity();
                $us->setSession($sm->get('session'));
                $us->setUserStorage($sm->get('user.storage'));
                $us->setConfig($sm->get('config'));
                return $us;
            },

            'login.helper' => function ($sm) {
                $us = new \UserModule\Classes\UserSecurity();
                $us->setSession($sm->get('session'));
                return $us;
            },

            'user.security.templating.helper' => function ($sm) {
                return new \UserModule\Classes\UserSecurityTemplatingHelper($sm->get('user.security'));
            },

            'user.account.helper' => function ($sm) {
                $helper = new \UserModule\Classes\AccountHelper();
                $helper->setUserStorage($sm->get('user.storage'));
                return $helper;
            }

        ));
    }
}
