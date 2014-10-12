<?php
namespace UserModule\Storage;

use UserModule\Storage\Base as BaseStorage;
use UserModule\Entity\UserVideo as UserVideoEntity;

class UserVideo extends BaseStorage
{
    protected $_meta = array(
        'conn'    => 'main',
        'table'   => 'user_video',
        'primary' => 'id'
    );

    public function create(array $insertData)
    {
        return parent::insert($insertData);
    }

    public function getAllByUserID($userID)
    {

        $entities = array();
        $rows     = $this->createQueryBuilder()
            ->select('uv.*')
            ->from($this->getTableName(), 'uv')
            ->andWhere('uv.user_id = :user_id')
            ->setParameter(':user_id', $userID)
            ->execute()
            ->fetchAll($this->getFetchMode());

        foreach ($rows as $row) {
            $entities[] = new UserVideoEntity($row);
        }

        return $entities;

    }

    public function getByID($videoID)
    {
        $row = $this->createQueryBuilder()
            ->select('uv.*')
            ->from($this->getTableName(), 'uv')
            ->andWhere('uv.id = :id')
            ->setParameter(':id', $videoID)
            ->execute()
            ->fetch($this->getFetchMode());

        if ($row === false) {
            throw new \Exception('Unable to get a video by id: ' . $videoID);
        }

        return new UserVideoEntity($row);
    }

    /**
     * Delete video by its primary key
     *
     * @param integer $videoID
     *
     * @return mixed
     */
    public function deleteByID($videoID)
    {
        return $this->delete(array($this->getPrimaryKey() => $videoID));
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

    /**
     * Verify if a user owns a particular video ID
     *
     * @param integer $videoID
     * @param integer $userID
     *
     * @return bool
     */
    public function userOwnsVideoID($videoID, $userID)
    {

        $row = $this->_conn->createQueryBuilder()

            ->select('count(id) as total')
            ->from($this->_meta['table'], 'm')
            ->andWhere('m.id = :video_id')
            ->setParameter(':video_id', $videoID)
            ->andWhere('m.user_id = :user_id')
            ->setParameter(':user_id', $userID)
            ->execute()
            ->fetch($this->_meta['fetchmode']);

        return $row['total'] > 0;

    }

}

