<?php $view->extend('::base.html.php'); ?>

<?php $view['slots']->start('include_css') ?>
<link rel="stylesheet" href="<?php echo $view['assets']->getUrl('user/css/account.css') ?>"/>
<link rel="stylesheet" href="<?php echo $view['assets']->getUrl('user/css/account-edit.css') ?>"/>
<link rel="stylesheet" href="<?php echo $view['assets']->getUrl('css/libs/jquery-ui-1.9.1.custom.min.css') ?>"/>
<?php $view['slots']->stop(); ?>

<?php $view['slots']->start('include_js_body') ?>
<script src="<?php echo $view['assets']->getUrl('js/libs/jquery.validationEngine-en.js') ?>"></script>
<script src="<?php echo $view['assets']->getUrl('js/libs/jquery.validationEngine.js') ?>"></script>
<script src="<?php echo $view['assets']->getUrl('js/libs/jquery-ui-1.9.1.custom.min.js') ?>"></script>
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

        <form action="<?=$view['router']->generate('User_Edit_Account_Save');?>" method="post" class="form-horizontal">

            <legend>Edit your account</legend>

            <div class="control-group">
                <label class="control-label" for="formFirstName">First Name <em>*</em></label>

                <div class="controls">
                    <input type="text" class="input-xlarge validate[required]" id="formFirstName" name="userFirstName"
                           value="<?=$user->getFirstName();?>">
                    <span rel="formFirstName" class="help-inline"></span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="formLastName">Last Name <em>*</em></label>

                <div class="controls">
                    <input type="text" class="input-xlarge validate[required]" id="formLastName" name="userLastName"
                           value="<?=$user->getLastName();?>">
                    <span rel="formLastName" class="help-inline"></span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="formDOB">Date Of Birth <em>*</em></label>

                <div class="controls">
                    <input type="text" class="input-xlarge validate[required] datepicker" id="formDOB" name="userDOB"
                           readonly value="<?=$dob;?>">
                    <span class="add-on">
                        <i class="icon-calendar"></i>
                    </span>
                    <span rel="formDOB" class="help-inline"></span>
                    <input type="hidden" id="hiddenDOBData" name="userDOB" value="<?=$dob2;?>"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="formEmail">Email Address <em>*</em></label>

                <div class="controls">
                    <input type="text" class="input-xlarge validate[required,custom[email]]" id="formEmail"
                           name="userEmail" value="<?=$user->getEmail();?>">
                    <span rel="formEmail" class="help-inline"></span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="formJobTitle">Job Title</label>

                <div class="controls">
                    <input type="text" class="input-xlarge" id="formJobTitle" name="userJobTitle"
                           value="<?=$view->escape($userMeta->has('job_title') ? $userMeta->get('job_title')->getUserValue() : '');?>">
                    <span rel="formJobTitle" class="help-inline"></span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="formCompanyName">Company Name</label>

                <div class="controls">
                    <input type="text" class="input-xlarge" id="formCompanyName" name="userCompanyName"
                           value="<?=$view->escape($userMeta->has('company_name') ? $userMeta->get('company_name')->getUserValue() : '');?>">
                    <span rel="formCompanyName" class="help-inline"></span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="formWebsite">Website</label>

                <div class="controls">
                    <input type="text" class="input-xlarge" id="formWebsite" name="userWebsite"
                           value="<?=$view->escape($userMeta->has('website') ? $userMeta->get('website')->getUserValue() : '');?>">
                    <span rel="formWebsite" class="help-inline"></span>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="formCity">City</label>

                <div class="controls">
                    <input type="text" class="input-xlarge" id="formCity"
                           name="userCity" value="<?=$view->escape($userMeta->has('city') ? $userMeta->get('city')->getUserValue() : '');?>">
                    <span rel="formCity" class="help-inline"></span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="formPrimaryPhone">Primary Phone</label>

                <div class="controls">
                    <input type="text" class="input-xlarge" id="formPrimaryPhone"
                           name="userPrimaryPhone" value="<?=$view->escape($userMeta->has('primary_phone') ? $userMeta->get('primary_phone')->getUserValue() : '');?>">
                    <span rel="formPrimaryPhone" class="help-inline"></span>
                </div>
            </div>
            
            
            <div class="control-group">
                <label class="control-label" for="formTwitter">Twitter Handle</label>
                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on">@</span>
                        <input type="text" class="input-xlarge" id="formTwitter" name="userTwitter"
                               value="<?=$view->escape($userMeta->has('twitter') ? $userMeta->get('twitter')->getUserValue() : '');?>">
                        <span rel="formTwitter" class="help-inline"></span>
                    </div>
                </div>
            </div>
    
            <div class="control-group facebook-group">
                <label class="control-label" for="formFacebook">Facebook URL</label>
                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on">facebook.com/</span>
                        <input type="text" class="input-xlarge" id="formFacebook" name="userFacebook"
                               value="<?=$view->escape($userMeta->has('facebook') ? $userMeta->get('facebook')->getUserValue() : '');?>">
                        <span rel="formFacebook" class="help-inline"></span>
                    </div>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="formBiography">Biography</label>

                <div class="controls">
                    <textarea id="formBiography" name="userBiography" rows="7"
                              class="input-xxlarge"><?=$view->escape($userMeta->has('biography') ? $userMeta->get('biography')->getUserValue() : '');?></textarea>
                    <span rel="formBiography" class="help-inline"></span>
                </div>
            </div>

            <div class="form-actions buttons-area">
                <input type="submit" class="step1 btn btn-large" value="Save Changes">
            </div>

        </form>

    </section>

</div>

