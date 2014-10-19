<?php $view->extend('::base.html.php'); ?>

<?php $view['slots']->start('include_css') ?>
<link rel="stylesheet" href="<?php echo $view['assets']->getUrl('user/css/account.css') ?>"/>
<?php $view['slots']->stop(); ?>

<div class="well clearfix container">

    <?php include "sidebar.html.php"; ?>

    <section id="view-account" class="content user-login clearfix well">

        <h3><?=$view->escape($user->getFullName());?></h3>

        <dl class="dl-horizontal">
            <dt>Email Address</dt>
            <dd><?=$view->escape($user->getEmail());?></dd>
        </dl>

        <div class="buttons">
            <a class="btn btn-large" href="<?=$view['router']->generate('User_Edit_Account');?>">Edit Account</a>
            <a class="btn btn-large" href="<?=$view['router']->generate('User_Edit_Password');?>">Edit Password</a>
        </div>

</div>
</section>

</div>

