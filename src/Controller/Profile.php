<?php
namespace UserModule\Controller;

use UserModule\Controller\Shared as SharedController;
use UserModule\Entity\AuthUser as AuthUserEntity;

class Profile extends SharedController
{

    public function viewAction()
    {

        $username = $this->getRouteParam('username');
        
        $us = $this->getService('user.storage');
        if(!$us->existsByUsername($username)) {
            $this->setFlash('error', 'Invalid username specified');
            return $this->redirectToRoute('Homepage');
        }
        
        $ugs      = $this->getService('user.gallery.storage');
        $user     = $us->getByUsername($username);
        $userMeta = $this->getService('user.meta.storage')->getMetaFieldsByUserID($user->getID());
        $gallery  = $ugs->getAllFromUserId($user->getID());

        $avatar   = false;
        if ($ugs->hasFeatured($user->getID())) {
            $avatar = $ugs->getFeaturedFromUserId($user->getID());
        }

        $videos   = $this->getService('user.videos.storage')->getAllByUserID($user->getID());
        $music    = $this->getService('user.music.storage')->getAllByUserID($user->getID());

        return $this->render(
            'UserModule:profile:view.html.php',
            compact('user', 'userMeta', 'gallery', 'videos', 'music', 'avatar')
        );
    }
}