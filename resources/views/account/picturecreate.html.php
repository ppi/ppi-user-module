<?php $view->extend('::base.html.php'); ?>

<?php $view['slots']->start('include_css') ?>
<link rel="stylesheet" href="<?php echo $view['assets']->getUrl('user/css/account.css') ?>"/>
<link rel="stylesheet" href="<?php echo $view['assets']->getUrl('user/css/account-edit.css') ?>"/>
<link rel="stylesheet" href="<?php echo $view['assets']->getUrl('css/libs/datepicker.css') ?>"/>
<?php $view['slots']->stop(); ?>

<?php $view['slots']->start('include_js_body') ?>
<script src="<?php echo $view['assets']->getUrl('js/libs/jquery.validationEngine-en.js') ?>"></script>
<script src="<?php echo $view['assets']->getUrl('js/libs/jquery.validationEngine.js') ?>"></script>
<script src="<?php echo $view['assets']->getUrl('js/libs/bootstrap-datepicker.js') ?>"></script>
<script src="<?php echo $view['assets']->getUrl('user/js/account-edit.js') ?>"></script>
<?php $view['slots']->stop(); ?>

<div class="well clearfix container">

    <?php include "sidebar.html.php"; ?>

    <section id="user-edit-account" class="content clearfix well">

        <?php if (isset($errors) && !empty($errors)): ?>
        <div class="alert alert-error">
            <?php foreach ($errors as $error): ?>
            <p><?=$view->escape($error);?></p>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <form action="<?=$view['router']->generate('User_Picture_Create_Submit');?>" method="post" class="form-horizontal" enctype="multipart/form-data">
            
            <legend>Create Picture</legend>

            <div class="control-group">
                <label class="control-label" for="userPicture">Select File <em>*</em></label>

                <div class="controls">
                    <input type="file" class="input-xlarge validate[required]" id="userPicture" name="userPicture">
                    <span rel="userPicture" class="help-inline"></span>
                </div>
            </div>

            <div class="form-actions buttons-area">
                <input type="submit" class="btn btn-large" value="Create Picture">
            </div>

        </form>

    </section>

</div>

