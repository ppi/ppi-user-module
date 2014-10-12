<?php $view->extend('::base.html.php'); ?>

<?php $view['slots']->start('include_css') ?>
<link rel="stylesheet" href="<?php echo $view['assets']->getUrl('user/css/account.css') ?>"/>
<link rel="stylesheet" href="<?php echo $view['assets']->getUrl('user/css/music.css') ?>"/>
<?php $view['slots']->stop(); ?>

<?php $view['slots']->start('include_js_body') ?>
<script src="<?php echo $view['assets']->getUrl('js/libs/jquery.tongue.min.js') ?>"></script>
<script src="<?php echo $view['assets']->getUrl('user/js/pictures.js') ?>"></script>
<?php $view['slots']->stop(); ?>

<div class="well clearfix container">

    <?=$view->render('UserModule:account:sidebar.html.php'); ?>

    <section id="videos" class="content user-login clearfix well">

        <h3>Manage your Music</h3>

        <section class="video-gallery">
            <p><a href="<?=$view['router']->generate('User_Music_Create');?>" class="btn btn-large">Create Music</a></p>

            <?php foreach ($music as $song) : ?>
            <p class="music-title"><?=$song->getTitle();?></p>
            <?php
            $f = simplexml_load_file("http://soundcloud.com/oembed?url={$song->getLink()}");
            echo $f->html;
            ?>
            <div class="music-actions">
                <a href="<?=$view['router']->generate('User_Remove_Music', array('id' => $song->getId()));?>" class="btn">
                    <i class="icon-trash"></i> Delete Song
                </a>

                <a href="<?=$view['router']->generate('User_Edit_Music', array('id' => $song->getId()));?>" class="btn">
                    <i class="icon-edit"></i> Edit Song
                </a>
            </div>
            <?php endforeach; ?>
        </section>

    </section>

</div>