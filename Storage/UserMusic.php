<?php
namespace UserModule\Storage;

use UserModule\Storage\Base as BaseStorage;
use UserModule\Entity\UserMusic as UserMusicEntity;

class UserMusic extends BaseStorage
{
    protected $_meta = array(
        'conn'    => 'main',
        'table'   => 'user_music',
        'primary' => 'id'
    );

    public function create(array $insertData) {
        return parent::insert($insertData);
    }

    public function getAllByUserID($userID)
    {

        $entities = array();
        $rows = $this->createQueryBuilder()
            ->select('um.*')
            ->from($this->getTableName(), 'um')
            ->andWhere('um.user_id = :user_id')
            ->setParameter(':user_id', $userID)
            ->execute()
            ->fetchAll($this->getFetchMode());

        foreach ($rows as $row) {
            $entities[] = new UserMusicEntity($row);
        }

        return $entities;

    }

    public function getByID($musicID)
    {

        $row = $this->createQueryBuilder()
            ->select('um.*')
            ->from($this->getTableName(), 'um')
            ->andWhere('um.id = :id')
            ->setParameter(':id', $musicID)
            ->execute()
            ->fetch($this->getFetchMode());
        
        if($row === false) {
            throw new \Exception('Unable to get a video by id: ' . $videoID);
        }

        return new UserMusicEntity($row);
    }

    /**
     * Delete music by its primary key
     *
     * @param integer $contentID
     * @return mixed
     */
    public function deleteByID($musicID)
    {
        return $this->delete(array($this->getPrimaryKey() => $musicID));
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
   	 * Verify if a user owns a particular music ID
   	 * 
   	 * @param integer $musicID
   	 * @param integer $userID
   	 * @return bool
   	 */
   	public function userOwnsMusicID($musicID, $userID) {
   		
   		$row = $this->_conn->createQueryBuilder()
   		
   			->select('count(id) as total')
   			->from($this->_meta['table'], 'm')
   		
   			->andWhere('m.id = :music_id')
   			->setParameter(':music_id', $musicID)
   		
   			->andWhere('m.user_id = :user_id')
   			->setParameter(':user_id', $userID)
   		
   			->execute()
   			->fetch($this->_meta['fetchmode']);
   		
   		return $row['total'] > 0;
   		
   	}

}

