<?php

namespace UserModule\Entity;

class User
{

    protected $id;

    protected $username;
    protected $name;
    protected $email;
    protected $github_uid;

    public function __construct($data = array())
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }

    }

    /**
     * @return integer
     */
    public function getID()
    {
        return $this->id;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param integer $githubUid
     */
    public function setGithubUid($githubUid)
    {
        $this->github_uid = $githubUid;
    }

    /**
     * @return integer
     */
    public function getGithubUid()
    {
        return $this->github_uid;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    public function toArray()
    {
        return get_object_vars($this);
    }

    public function toInsertArray()
    {
        $vars = get_object_vars($this);
        unset($vars['id']);
        return $vars;
    }

    public function getFullName()
    {
        return $this->name;
    }

    

}
