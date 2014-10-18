<?php
namespace UserModule;

use PPI\Module\Module as BaseModule;

class Module extends BaseModule
{
    protected $name = 'UserModule';

    public function __construct()
    {
        var_dump($this); exit;
    }

    public function init($e)
    {
    }
    
    /**
     * Get the configuration for this module
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->loadConfig(__DIR__ . '/src/resources/config/config.yml');
    }

    /**
     * Get the routes for this module
     *
     * @return \Symfony\Component\Routing\RouteCollection
     */
    public function getRoutes()
    {
        return $this->loadYamlRoutes(__DIR__ . '/src/resources/config/routes.yml');
    }
    
    public function getServiceConfig()
    {

        return array('factories' => array(
            
            'user.storage' => function($sm) {
                 return new \UserModule\Storage\User($sm->get('datasource')->getConnection('main'));
             },
            
            'user.security' => function($sm) {
                $us = new \UserModule\Classes\UserSecurity();
                $us->setSession($sm->get('session'));
                $us->setUserStorage($sm->get('user.storage'));
                $us->setConfig($sm->get('config'));
                return $us;
            },

            'login.helper' => function($sm) {
                $us = new \UserModule\Classes\UserSecurity();
                $us->setSession($sm->get('session'));
                return $us;
            },
            
            'user.security.templating.helper' => function($sm) {
                return new \UserModule\Classes\UserSecurityTemplatingHelper($sm->get('user.security'));
            },

            'user.account.helper' => function($sm) {
                $helper = new \UserModule\Classes\AccountHelper();
                $helper->setUserStorage($sm->get('user.storage'));
                return $helper;
            }

        ));
    }



}
