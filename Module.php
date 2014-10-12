<?php
namespace UserModule;

use PPI\Module\Module as BaseModule;
use PPI\Autoload;
use League\OAuth2\Client\Provider\Github as GithubProvider;

class Module extends BaseModule
{
    protected $_moduleName = 'UserModule';

    public function init($e)
    {
        Autoload::add(__NAMESPACE__, dirname(__DIR__));
//        if(!defined('PHP_QUERY_RFC1738')) {
//            define('PHP_QUERY_RFC1738', 1);
//        }
    }
    
    /**
     * Get the configuration for this module
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->loadConfig('config.yml');
    }

    /**
     * Get the routes for this module
     *
     * @return \Symfony\Component\Routing\RouteCollection
     */
    public function getRoutes()
    {
        return $this->loadYamlRoutes(__DIR__ . '/resources/config/routes.yml');
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
            },

            'auth.service.provider' => function($sm) {
                $config = $sm->get('config');

                if(!isset($config['auth'])) {
                    throw new \Exception('Missing auth config');
                }

                $authConfig   = $config['auth'];
                $clientId     = $authConfig['client_id'];
                $clientSecret = $authConfig['client_secret'];
                $redirectUri  = $sm->get('router')->generate($authConfig['redirect_uri_route'], array(), true);
                $provider = new GithubProvider(compact('clientId', 'clientSecret', 'redirectUri'));
                return $provider;
            }
            
        ));
    }



}
