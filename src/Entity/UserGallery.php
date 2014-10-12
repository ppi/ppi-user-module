<?php

namespace UserModule\Entity;

class UserGallery
{

    protected $_id = null;
    protected $_user_id = null;
    protected $_file_name = null;
    protected $_featured = null;

    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, '_' . $key)) {
                $this->{'_' . $key} = $value;
            }
        }

    }

    public function setFeatured($featured)
    {
        $this->_featured = $featured;
    }

    public function getFeatured()
    {
        return $this->_featured;
    }
    
    public function isFeatured()
    {
        return (bool) $this->_featured;
    }

    public function setFileName($file_name)
    {
        $this->_file_name = $file_name;
    }

    public function getFileName()
    {
        return $this->_file_name;
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

}
