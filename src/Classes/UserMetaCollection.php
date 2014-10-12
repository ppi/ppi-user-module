<?php

namespace UserModule\Classes;

class UserMetaCollection
{
    protected $fields;

    public function __construct($fields)
    {
        $this->fields = $fields;
    }

    public function get($key)
    {
        if (isset($this->fields[$key])) {
            return $this->fields[$key];
        }
    }
    
    public function has($key)
    {
        return isset($this->fields[$key]);
    }

}