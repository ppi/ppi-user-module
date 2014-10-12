<?php
namespace UserModule\Storage;

use UserModule\Storage\Base as BaseStorage;
use UserModule\Entity\UserMeta as UserMetaEntity;
use UserModule\Classes\UserMetaCollection as UserMetaCollection;

class UserMeta extends BaseStorage
{
    protected $_meta = array(
        'conn' => 'main', 'table' => 'user_meta', 'primary' => 'id'
    );

    public function create($userID, array $insertData)
    {

        foreach ($insertData as $key => $value) {
            $this->insertMeta($userID, $key, $value);
        }

        return true;
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
     * Insert some meta data
     * 
     * @param integer $userID
     * @param string $key
     * @param string $value
     * @return integer
     */
    public function insertMeta($userID, $key, $value)
    {
        return $this->insert(
            array(
                 'user_id'    => $userID,
                 'user_key'   => $key,
                 'user_value' => $value,
                 'user_label' => ''
            )
        );
    }

    /**
     * Update some meta data
     * 
     * @param integer $userID
     * @param string $key
     * @param string $value
     */
    public function updateMeta($userID, $key, $value)
    {
        $this->update(
            array(
                 'user_id'    => $userID,
                 'user_key'   => $key,
                 'user_value' => $value,
                 'user_label' => ''
            ),
            array(
                 'user_id'  => $userID,
                 'user_key' => $key
            )
        );
    }

    public function existFromKeyAndUserId($key, $userId)
    {
        $row = $this->createQueryBuilder()
            ->select('um.*')
            ->from($this->getTableName(), 'um')
            ->where('um.user_key = :user_key')
            ->andWhere('um.user_id = :user_id')
            ->setParameter(':user_key', $key)
            ->setParameter(':user_id', $userId)
            ->execute()
            ->fetch($this->getFetchMode());

        return empty($row);
    }

    /**
     * Get all the users meta fields in a meta field collection
     * 
     * @param integer $userID
     * @return \UserModule\Classes\UserMetaCollection
     */
    public function getMetaFieldsByUserID($userID)
    {

        $rows = $this->createQueryBuilder()
            ->select('um.*')
            ->from($this->getTableName(), 'um')
            ->andWhere('um.user_id = :user_id')
            ->setParameter(':user_id', $userID)
            ->execute()
            ->fetchAll($this->getFetchMode());

        $map = array();
        foreach ($rows as $row) {
            $map[$row['user_key']] = new UserMetaEntity($row);
        }

        return new UserMetaCollection($map);
    }

}