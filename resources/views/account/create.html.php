<?php $view->extend('::base.html.php'); ?>


<?php $view['slots']->start('include_css') ?>
<link rel="stylesheet" href="<?php echo $view['assets']->getUrl('user/css/login.css') ?>"/>
<?php $view['slots']->stop(); ?>


<div class="page-header">
    <h1>Create Account</h1>
</div><!-- /.page-header -->

<?php if (isset($errors) && !empty($errors)): ?>
    <div class="alert alert-error">
        <?php foreach ($errors as $error): ?>
            <p><?= $view->escape($error); ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form action="<?= $view['router']->generate('UserModule_Login_Check'); ?>" method="post" class="form-horizontal" role="form" id="validation-form">

    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Full Name </label>
        <div class="col-sm-9">
            <input type="text" id="form-field-1" placeholder="Full Name" class="col-xs-10 col-sm-5" name="userEmail">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-2"> Email Address</label>
        <div class="col-sm-9">
            <input type="text" id="form-field-2" placeholder="Email Address" class="col-xs-10 col-sm-5" name="userPassword">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-2"> Password</label>
        <div class="col-sm-9">
            <input type="password" id="form-field-2" placeholder="Password" class="col-xs-10 col-sm-5" name="userPassword">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-2"> Confirm Password </label>
        <div class="col-sm-9">
            <input type="password" id="form-field-2" placeholder="Confirm Password" class="col-xs-10 col-sm-5" name="userPassword">
        </div>
    </div>

    <div class="clearfix form-actions">
        <div class="col-md-offset-3 col-md-9">
            <button class="btn btn-info" type="submit"><i class="icon-ok bigger-110"></i>Submit</button>
            &nbsp; &nbsp; &nbsp;
            <button class="btn" type="reset"><i class="icon-undo bigger-110"></i>Reset</button>
        </div>
    </div>

</form>

<?php $view['slots']->start('include_js_body') ?>
<script src="/assets/js/jquery.validate.min.js"></script>
<script type="text/javascript">
    jQuery(function($) {

        $('#validation-form').validate({
            errorElement: 'div',
            errorClass: 'help-block',
            focusInvalid: false,
            rules: {
                email: {
                    required: true,
                    email:true
                }
            },
            messages: {
                email: {
                    required: "Please provide a valid email.",
                    email: "Please provide a valid email."
                },
                password: {
                    required: "Please specify a password.",
                    minlength: "Please specify a secure password."
                },
                subscription: "Please choose at least one option",
                gender: "Please choose gender",
                agree: "Please accept our policy"
            },
            errorPlacement: function (error, element) {
                console.log(error, element);
                error.insertAfter(element.parent());
            }
        });
    });
</script>
<?php $view['slots']->stop(); ?>
