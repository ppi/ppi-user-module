<?php

namespace UserModule\Classes;

use UserModule\Entity\User as UserEntity;

class AccountHelper
{

    protected $uploadPath;
    protected $userStorage;

    public function __construct()
    {
    }

    public function setUserStorage($s)
    {
        $this->userStorage = $s;
    }

    public function setUploadPath($path)
    {
        $this->uploadPath = $path;
    }

    public function create(UserEntity $user)
    {
        return $this->userStorage->create($user);
    }

    /**
     * Get a user by ID
     *
     * @param integer $id
     * @return object
     */
    public function getUserByID($id)
    {
        return $this->userStorage->getByID($id);
    }

    /**
     * Delete a user and all their dependencies
     */
    public function deleteUser($userID)
    {
        // Wipe the user record
        $this->userStorage->deleteByID($userID);

        // Wipe data from meta data, gallery, music, video
        $this->userMetaStorage->deleteByUserID($userID);

    }

    /**
     * Normalise a username, removing characters which are not a-z, 0-9,
     *
     * @param string $string
     * @param boolean $lowerCase
     * @return mixed
     */
    public function normaliseUserName($string, $lowerCase = true)
    {
        $string = preg_replace("/[^A-Za-z0-9\._]/", '', $string);
        return $lowerCase ? strtolower($string) : $string;
    }

    public function existsByEmail($email)
    {
        return $this->userStorage->existsByEmail($email);
    }

    public function existsByGithubUID($uid)
    {
        return $this->userStorage->existsByGithubUID($uid);
    }

    public function createAccountFromProviderDetails($details)
    {
        $entity = new UserEntity();
        $entity->setName($details->name);
        $entity->setEmail($details->email);
        $entity->setUsername($details->nickname);
        $entity->setGithubUid($details->uid);
        return $this->userStorage->create($entity);
    }

    public function getByGithubUID($uid)
    {
        return $this->userStorage->getByGithubUID($uid);
    }

}