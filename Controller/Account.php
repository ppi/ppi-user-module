<?php
namespace UserModule\Controller;

use UserModule\Controller\Shared as SharedController;
use UserModule\Entity\User as UserEntity;

class Account extends SharedController
{

    public function createAction()
    {

        // If no POST - render
        if(!$this->is('post')) {
            return $this->render('UserModule:account:create.html.php');
        }

        $missingFields = array();
        $post          = $this->post();
        $requiredKeys  = array('firstname', 'lastname', 'email', 'password');

        // Check for missing fields, or fields being empty.
        foreach ($requiredKeys as $field) {
            if (!isset($post[$field]) || empty($post[$field])) {
                $missingFields[] = $field;
            }
        }

        // If any fields were missing, inform the client
        if (!empty($missingFields)) {
            return $this->render('UserModule:account:create.html.php', compact('missingFields'));
        }

        $accountHelper = $this->getService('user.account.helper');


        // @todo - check email exists
        // Check if the user's email address already exists
        if ($accountHelper->existsByEmail($post['email'])) {
            return $this->createResponse(array(
                'status' => 'error',
                'code'   => 'E_EMAIL_ALREADY_EXISTS'
            ));
        }

        $userEntity = new \UserModule\Entity\User();
        $userEntity->setEmail($post['email']);
        $userEntity->setFirstName($post['firstname']);
        $userEntity->setLastName($post['lastname']);
        $userEntity->setPassword($post['password']);
        $userEntity->setSalt(base64_encode(openssl_random_pseudo_bytes(16)));

        // Create the user
        $newUserID = $accountHelper->createUser($userEntity);
        
        // Insert an activation token for this user
//        $accountHelper->createUserActivation($userEntity);

        // Send the user's activation email
//        $this->sendActivationEmail($userEntity);



    }
    
    public function activateAction()
    {
        
        $token = $this->getRouteParam('token');
        $uas   = $this->getService('user.activation.storage');
        
        // Check if this is a valid token and has not been used before
        $accountHelper = $this->getService('user.account.helper');
        
        if(!$accountHelper->isValidActivationToken($token)) {
            return $this->createResponse(array(
                'status' => 'error',
                'code'   => 'E_INVALID_TOKEN'
            ));
        }
        
        $accountHelper->activateUserByToken($token);
        
        // @todo - Sign the user up to mailchimp here
        
        $user         = $accountHelper->getByID($accountHelper->getUserIDFromActivationToken($token));
        $config       = $this->getConfig();
        $emailHelper  = $this->getService('email.helper');
        $fromUser     = new UserEntity($config['emailConfig']);
        $username     = $user->getUsername();
        $email        = $user->getEmail();
        $emailContent = $this->render('UserModule:auth:welcome.html.php', compact('emali', 'username'));
        
        // Send the welcome email to the user
        $emailHelper->sendEmail($fromUser, $user, 'Account Activated', $emailContent);

        // User entity preparation
        $config    = $this->getConfig();
        $adminUser = new UserEntity($config['adminEmailConfig']);
        
        return $this->createResponse(array(
            'status' => 'success',
            'code'   => 'OK'
        ));

//         Get the activation email content, it's in a view file.
//        $emailContent = $this->render('UserModule:auth:activateemail.html.php', compact('toUser', 'accountLink'));

        // Send the activation email to the user
//        $emailHelper->sendEmail($fromUser, $adminUser, 'User Signed Up', $emailContent);

    }
    
    public function checkExistsAction()
    {
        $email = $this->post('email');
        $customerID = 1;
        
        $accountHelper = $this->getService('user.account.helper');
        
        if($accountHelper->existsByEmail($customerID, $email)) {
            return $this->createResponse(array(
                'status'         => 'error',
                'code'           => 'E_EMAIL_EXISTS'
            ));
        }
        
        return $this->createResponse(array(
            'status' => 'success',
            'code'   => 'OK'
        ));

    }
    
}