<?php
namespace UserModule\Storage;

use UserModule\Storage\Base as BaseStorage;
use UserModule\Entity\User as UserEntity;

class User extends BaseStorage
{

    const TABLE_NAME = 'user';

    protected $_meta = array(
        'conn'    => 'main',
        'table'   => 'io_users',
        'primary' => 'id',
        'fetchMode' => \PDO::FETCH_ASSOC
    );

    /**
     * Find a user record by its ID
     *
     * @param $userID
     * @return mixed
     */
    public function findByID($userID)
    {
        return $this->find($userID);
    }

    /**
     * Get a user entity by its ID
     *
     * @param $userID
     * @return mixed
     * @throws \Exception
     */
    public function getByID($userID)
    {
        $row = $this->find($userID);
        if ($row === false) {
            throw new \Exception('Unable to obtain user row for id: ' . $userID);
        }

        return new UserEntity($row);

    }
    
    /**
     * Find a user record by the email
     *
     * @param  string $email
     * @return mixed
     */
    public function findByEmail($email)
    {
        return $this->createQueryBuilder()
            ->select('u.*')
            ->from($this->getTableName(), 'u')
            ->andWhere('u.email = :email')->setParameter(':email', $email)
            ->execute()
            ->fetch($this->getFetchMode());
    }
    
    public function getAllWithLevels()
    {
        
        $entities = array();
        $rows = $this->createQueryBuilder()
            ->select('u.*, ul.title user_level_title')
            ->from($this->getTableName(), 'u')
            ->leftJoin('u', 'user_level', 'ul', 'u.user_level_id = ul.id')
            ->execute()
            ->fetchAll($this->getFetchMode());
        
        foreach ($rows as $row) {
            $entities[] = new UserEntity($row);
        }

        return $entities;
        
    }

    /**
     * Get a user entity by the email address
     *
     * @param  string $email
     * @return UserEntity
     * @throws \Exception
     */
    public function getByEmail($email)
    {
        $row = $this->findByEmail($email);

        if ($row === false) {
            throw new \Exception('Unable to find user record by email: ' . $email);
        }

        return new UserEntity($row);

    }
    
    /**
     * Get a user entity by username
     *
     * @param  string $username
     * @return UserEntity
     * @throws \Exception
     */
    public function getByUsername($username)
    {
        $row = $this->createQueryBuilder()
            ->select('u.*')
            ->from($this->getTableName(), 'u')
            ->andWhere('u.username = :username')
            ->setParameter(':username', $username)
            ->execute()
            ->fetch($this->getFetchMode());

        if ($row === false) {
            throw new \Exception('Unable to find user record by username: ' . $username);
        }

        return new UserEntity($row);

    }

    /**
     * Check if a user record exists by email address
     *
     * @param $email
     * @return bool
     */
    public function existsByEmail($email)
    {
        $row = $this->createQueryBuilder()
            ->select('count(id) as total')
            ->from($this->getTableName(), 'u')
            ->andWhere('u.email = :email')
            ->setParameter(':email', $email)
            ->execute()
            ->fetch($this->getFetchMode());

        return $row['total'] > 0;
    }

    /**
     * Check if a user record exists by username
     *
     * @param $email
     * @return bool
     */
    public function existsByUsername($username)
    {
        $row = $this->createQueryBuilder()
            ->select('count(id) as total')
            ->from($this->getTableName(), 'u')
            ->andWhere('u.username = :username')
            ->setParameter(':username', $username)
            ->execute()
            ->fetch($this->getFetchMode());

        return $row['total'] > 0;
    }
    
    /**
     * Check if a user record exists by User ID
     *
     * @param integer $id
     * @return bool
     */
    public function existsByID($id)
    {
        $row = $this->createQueryBuilder()
            ->select('count(id) as total')
            ->from($this->getTableName(), 'u')
            ->andWhere('u.id = :id')
            ->setParameter(':id', $id)
            ->execute()
            ->fetch($this->getFetchMode());

        return $row['total'] > 0;
    }

    public function existsByGithubUID($uid)
    {
        $row = $this->ds->createQueryBuilder()
            ->select('count(id) as total')
            ->from($this->getTableName(), 'u')
            ->andWhere('u.github_uid = :id')
            ->setParameter(':id', $uid)
            ->execute()
            ->fetch($this->getFetchMode());

        return $row['total'] > 0;
    }


    public function getByGithubUID($uid)
    {

        $row = $this->ds->createQueryBuilder()
            ->select('u.*')
            ->from($this->getTableName(), 'u')
            ->andWhere('u.github_uid = :uid')
            ->setParameter(':uid', $uid)
            ->execute()
            ->fetch($this->getFetchMode());

        return $row !== false ? new UserEntity($row) : false;
    }

    /**
     * Delete a user by their email address
     *
     * @param  string $email
     * @return mixed
     */
    public function deleteByEmail($email)
    {
        return $this->delete(array('email' => $email));
    }
    
    /**
     * Delete a user by their ID
     *
     * @param  integer $userID
     * @return mixed
     */
    public function deleteByID($userID)
    {
        return $this->delete(array($this->getPrimaryKey() => $userID));
    }

    /**
     * Create a user record
     *
     * @param  UserEntity $user
     * @return integer
     */
    public function create(UserEntity $user)
    {
        return $this->ds->insert(self::TABLE_NAME, $user->toInsertArray());
    }
    
    public function rowsToEntities($rows) {
        $ent = array();
        foreach($rows as $r) {
            $ent[] = new UserEntity($r);
        }
        return $ent;
    }

    protected function getTableName()
    {
        return self::TABLE_NAME;
    }

    protected function getFetchMode()
    {
        return \PDO::FETCH_ASSOC;
    }

}
