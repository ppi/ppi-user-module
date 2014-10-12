<?php
namespace UserModule\Storage;

use UserModule\Storage\Base as BaseStorage;
use UserModule\Entity\UserGallery as UserGalleryEntity;

class UserGallery extends BaseStorage
{
    protected $_meta = array(
        'conn'    => 'main',
        'table'   => 'user_gallery',
        'primary' => 'id'
    );

    public function create(array $insertData) {
        return parent::insert($insertData);
    }

    public function hasPictures($userID)
    {
        $row = $this->createQueryBuilder()
            ->select('count(id) as total')
            ->from($this->getTableName(), 'ug')
            ->andWhere('ug.user_id = :user_id')
            ->setParameter(':user_id', $userID)
            ->execute()
            ->fetch($this->getFetchMode());

        return $row['total'] > 0;
    }

    public function getFeaturedFromUserId($userID)
    {

        $row = $this->createQueryBuilder()
            ->select('ug.*')
            ->from($this->getTableName(), 'ug')
            ->andWhere('ug.user_id = :user_id')
            ->andWhere('ug.featured = 1')
            ->setParameter(':user_id', $userID)
            ->execute()
            ->fetch($this->getFetchMode());

        if($row === false) {
            $row = array();
        }
        
        return new UserGalleryEntity($row);
    }

    public function hasFeatured($userID)
    {
        $row = $this->createQueryBuilder()
            ->select('ug.*')
            ->from($this->getTableName(), 'ug')
            ->andWhere('ug.user_id = :user_id')
            ->andWhere('ug.featured = 1')
            ->setParameter(':user_id', $userID)
            ->execute()
            ->fetch($this->getFetchMode());

        return !empty($row);
    }

    public function getAllFromUserId($userID)
    {

        $entities = array();
        $rows = $this->createQueryBuilder()
            ->select('ug.*')
            ->from($this->getTableName(), 'ug')
            ->andWhere('ug.user_id = :user_id')
            ->setParameter(':user_id', $userID)
            ->execute()
            ->fetchAll($this->getFetchMode());

        foreach ($rows as $row) {
            $entities[] = new UserGalleryEntity($row);
        }

        return $entities;

    }

    public function getById($pictureId)
    {

        $row = $this->createQueryBuilder()
            ->select('ug.*')
            ->from($this->getTableName(), 'ug')
            ->andWhere('ug.id = :id')
            ->setParameter(':id', $pictureId)
            ->execute()
            ->fetch($this->getFetchMode());

        return new UserGalleryEntity($row);
    }

    /**
     * Delete a class by its primary key
     *
     * @param integer $contentID
     * @return mixed
     */
    public function deleteByID($pictureID)
    {
        return $this->delete(array($this->getPrimaryKey() => $pictureID));
    }
    
    /**
     * Delete records by user id
     * 
     * @param integer $userID
     * @return mixed
     */
    public function deleteByUserID($userID) {
        return $this->delete(array('user_id' => $userID));
    }

}

