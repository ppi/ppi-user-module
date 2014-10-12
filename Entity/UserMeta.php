<?php

namespace UserModule\Entity;

class UserMeta
{

    protected $_id = null;
    protected $_user_id = null;
    protected $_user_key = null;
    protected $_user_label = null;
    protected $_user_value = null;

    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, '_' . $key)) {
                $this->{'_' . $key} = $value;
            }
        }

    }

    public function setId($id)
    {
        $this->_id = $id;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setUserId($user_id)
    {
        $this->_user_id = $user_id;
    }

    public function getUserId()
    {
        return $this->_user_id;
    }

    public function setUserKey($user_key)
    {
        $this->_user_key = $user_key;
    }

    public function getUserKey()
    {
        return $this->_user_key;
    }

    public function setUserLabel($user_label)
    {
        $this->_user_label = $user_label;
    }

    public function getUserLabel()
    {
        return $this->_user_label;
    }

    public function setUserValue($user_value)
    {
        $this->_user_value = $user_value;
    }

    public function getUserValue()
    {
        return $this->_user_value;
    }

}
