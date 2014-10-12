<?php
namespace UserModule\Controller;

use PPI\Module\Controller as BaseController;

class Shared extends BaseController
{
    
    public function createResponse($data)
    {
        return json_encode($data);
    }

    /**
     * Render a template
     *
     * @param  string $template The template to render
     * @param  array  $params   The params to pass to the renderer
     * @param  array  $options  Extra options
     * @return string
     */
    protected function render($template, array $params = array(), array $options = array())
    {
        $options['helpers'][] = $this->getService('user.security.templating.helper');
        return parent::render($template, $params, $options);
    }

    /**
     * Add a template global variable
     * 
     * @param string $param
     * @param mixed $value
     */
    protected function addTemplateGlobal($param, $value)
    {
        $this->getService('templating')->addGlobal($param, $value);
    }

    protected function isLoggedIn()
    {
        return $this->getService('user.security')->isLoggedIn();
    }
    
}