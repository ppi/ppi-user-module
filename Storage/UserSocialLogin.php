<?php
namespace UserModule\Storage;

use UserModule\Storage\Base as BaseStorage;
use UserModule\Entity\UserVideo as UserVideoEntity;

class UserSocialLogin extends BaseStorage
{
    protected $_meta = array(
        'conn'    => 'main',
        'table'   => 'user_social_login',
        'primary' => 'user_id'
    );

    public function create(array $insertData)
    {
        return parent::insert($insertData);
    }


    /**
     *
     * Check if a user record exists by Social Provider ID
     *
     * @param $identifier The Identifier
     *
     * @return bool
     */
    public function existByProviderId($identifier)
    {
        $row = $this->createQueryBuilder()
            ->select('count(id) as total')
            ->from($this->getTableName(), 'u')
            ->andWhere('u.provider_id = :identifier')
            ->setParameter(':identifier', $identifier)
            ->execute()
            ->fetch($this->getFetchMode());

        return $row['total'] > 0;
    }

}

