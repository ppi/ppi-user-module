<?php $view->extend('::base.html.php'); ?>

<?php $view['slots']->start('include_css') ?>
<link rel="stylesheet" href="<?php echo $view['assets']->getUrl('user/css/account.css') ?>"/>
<link rel="stylesheet" href="<?php echo $view['assets']->getUrl('user/css/videos.css') ?>"/>
<?php $view['slots']->stop(); ?>

<?php $view['slots']->start('include_js_body') ?>
<script src="<?php echo $view['assets']->getUrl('js/libs/jquery.tongue.min.js') ?>"></script>
<script src="<?php echo $view['assets']->getUrl('user/js/pictures.js') ?>"></script>
<?php $view['slots']->stop(); ?>

<div class="well clearfix container">

    <?=$view->render('UserModule:account:sidebar.html.php'); ?>

    <section id="videos" class="content user-login clearfix well">

        <h3>Manage your Videos</h3>

        <section class="video-gallery">
            <p><a href="<?=$view['router']->generate('User_Video_Create');?>" class="btn btn-large">Create Video</a></p>

            <?php foreach ($videos as $video) : ?>
            <?php
                parse_str( parse_url($video->getLink(), PHP_URL_QUERY), $vars );
                $videoID = $vars['v'];
            ?>
            <div class="video">

                <p class="video-title"><?=$video->getTitle();?></p>

                <iframe src="http://www.youtube.com/embed/<?=$videoID;?>" frameborder="0" allowfullscreen></iframe>

                <div class="video-actions">
                    <a href="<?=$view['router']->generate('User_Remove_Video', array('id' => $video->getId()));?>" class="btn">
                        <i class="icon-trash"></i> Delete
                    </a>

                    <a href="<?=$view['router']->generate('User_Edit_Video', array('id' => $video->getId()));?>" class="btn">
                        <i class="icon-edit"></i> Edit
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </section>

    </section>

</div>