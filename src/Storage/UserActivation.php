<?php
namespace UserModule\Storage;

use UserModule\Storage\Base as BaseStorage;
use UserModule\Entity\User as UserEntity;

class UserActivation extends BaseStorage
{
    protected $_meta = array(
        'conn'    => 'main',
        'table'   => 'user_activation_token',
        'primary' => 'id'
    );
    
    public function create(array $insertData) {
        return parent::insert($insertData);
    }

    /**
     * Check if the user_id is activated or not
     * 
     * @param $userID
     * @return bool
     */
    public function isActivated($userID) {
        
        $row = $this->createQueryBuilder()
            ->select('count(id) as total')
            ->from($this->getTableName(), 'uat')
            ->andWhere('uat.user_id = :user_id')
            ->setParameter(':user_id', $userID)
            ->andWhere('uat.used = 1') // <-- Check if they have used/activated their token before. 
            ->execute()
            ->fetch($this->getFetchMode());

        return $row['total'] > 0;
        
    }

    /**
     * Check if the user has already been activated by their token.
     * 
     * @param  string   $token
     * @return boolean
     */
    public function isUserActivatedByToken($token)
    {
        
        $row = $this->createQueryBuilder()
              ->select('count(id) as total')
              ->from($this->getTableName(), 'uat')
              ->andWhere('uat.token = :token')
              ->setParameter(':token', $token)
              ->andWhere('uat.used = 1') // <-- Check if they have used/activated their token before. 
              ->execute()
              ->fetch($this->getFetchMode());
  
          return $row['total'] > 0;
    }

    /**
     * Check if a record exists for this token
     * 
     * @param string $token
     * @return bool
     */
    public function existsByToken($token)
    {
        $row = $this->createQueryBuilder()
              ->select('count(id) as total')
              ->from($this->getTableName(), 'uat')
              ->andWhere('uat.token = :token')
              ->setParameter(':token', $token)
              ->execute()
              ->fetch($this->getFetchMode());
  
          return $row['total'] > 0;
    }

    /**
     * Check that this token has been used before
     * 
     * @param string $token
     * @return bool
     */
    public function tokenHasBeenUsed($token)
    {
        $row = $this->createQueryBuilder()
              ->select('count(id) as total')
              ->from($this->getTableName(), 'uat')
              ->andWhere('uat.token = :token')
              ->setParameter(':token', $token)
                ->andWhere('uat.used = 1') // <-- Check if they have used/activated their token before.
              ->execute()
              ->fetch($this->getFetchMode());
        
        return $row['total'] > 0;
    }

    /**
     * Get the user is from the activation token.
     * 
     * @param integer $token
     * @return mixed
     * @throws \Exception
     */
    public function getUserIDFromToken($token)
    {
        $row = $this->createQueryBuilder()
              ->select('uat.user_id')
              ->from($this->getTableName(), 'uat')
              ->andWhere('uat.token = :token')
              ->setParameter(':token', $token) 
              ->execute()
              ->fetch($this->getFetchMode());
  
        if($row === false) {
            throw new \Exception('Unable to find user id by token: ' . $token);
        }
        
          return $row['user_id'];
    }

    /**
     * Activate the users token record
     * 
     * @param string $token
     */
    public function activateUserByToken($token) {
        
        $dateTime = new \DateTime();
        $this->update(
            array(
                'used'      => 1, 
                'date_used' => $dateTime->format("Y-m-d H:i:s")
            ), 
            array('token' => $token)
        );
    }
    
}

