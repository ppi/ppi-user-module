<?php $view->extend('::base.html.php'); ?>

<?php $view['slots']->start('include_css') ?>
<link rel="stylesheet" href="<?php echo $view['assets']->getUrl('user/css/account.css') ?>"/>
<link rel="stylesheet" href="<?php echo $view['assets']->getUrl('user/css/pictures.css') ?>"/>
<?php $view['slots']->stop(); ?>

<?php $view['slots']->start('include_js_body') ?>
<script src="<?php echo $view['assets']->getUrl('js/libs/jquery.tongue.min.js') ?>"></script>
<script src="<?php echo $view['assets']->getUrl('user/js/pictures.js') ?>"></script>
<?php $view['slots']->stop(); ?>

<div class="well clearfix container">

    <?=$view->render('UserModule:account:sidebar.html.php'); ?>

    <section id="pictures" class="content user-login clearfix well">

        <h3>Manage your Pictures</h3>

        <section class="gallery clearfix">
            
            <p><a href="<?=$view['router']->generate('User_Picture_Create');?>" class="btn btn-large">Create Picture</a></p>
            
            <?php foreach ($gallery as $picture) : ?>
                <article class="picture">
                    <img src="<?=$view['assets']->getUrl('uploads/gallery/' . $picture->getFileName());?>" />
                    <div class="tongue-content">
                        <div class="buttons-container">
                            <a href="javascript://" class="btn deletePicture first" data-pictureid='<?=$picture->getId();?>'>
                                <i class="icon-trash"></i> Delete
                            </a>
                            <a href="<?=$view['router']->generate('User_Edit_Picture', array('id' => $picture->getId()));?>" class="btn">
                                <i class="icon-edit"></i> Edit
                            </a>
                            
                            <?php if(!$picture->isFeatured()): ?>
                            <a href="<?=$view['router']->generate('User_Set_Featured_Picture', array('id' => $picture->getId()));?>" class="btn featured">
                                <i class="icon-picture"></i> Make Primary
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </section>

    </section>

</div>

