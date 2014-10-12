<aside class="left-menu">
    <div class="title">PROFILE MANAGEMENT</div>
    <ul>
        <li><a href="<?=$view['router']->generate('User_Profile', array('username' => $view['security']->getUser()->getUsername()));?>"><i class="icon-user"></i> View Profile</a></li>
        <li><a href="<?=$view['router']->generate('User_Account');?>"><i class="icon-user"></i> View Account</a></li>
        <li><a href="<?=$view['router']->generate('User_Edit_Account');?>"><i class="icon-pencil"></i> Edit Account</a></li>
        <li><a href="<?=$view['router']->generate('User_Edit_Password');?>"><i class="icon-cog"></i> Edit Password</a></li>
        <li><a href="<?=$view['router']->generate('User_My_Pictures');?>"><i class="icon-picture"></i> My Pictures</a></li>
        <li><a href="<?=$view['router']->generate('User_My_Music');?>"><i class="icon-headphones"></i> My Music</a></li>
        <li><a href="<?=$view['router']->generate('User_My_Videos');?>"><i class="icon-film"></i> My Videos</a></li>
    </ul>
</aside>