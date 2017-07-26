<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>管理登陆 | <?php echo($this->config->item('site_name')); ?></title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url('resource/admin/bootstrap/dist/css/bootstrap.min.css') ?>" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo base_url('resource/admin/metisMenu/dist/metisMenu.min.css') ?>" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url('resource/admin/dist/css/sb-admin-2.css') ?>" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo base_url('resource/admin/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css">

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
						<?php if(isset($error) || validation_errors()){ ?>
						<div class="alert alert-warning" role="alert">
							<span class="glyphicon glyphicon-warning-sign"></span>
							<?php echo(isset($error) ? $error : ''); ?>
							<?php echo validation_errors(); ?>
						</div>
						<?php } ?>
                        <h3 class="panel-title">请登录</h3>
                    </div>
                    <div class="panel-body">
                        <?php echo form_open('admin/login'); ?>
                            <fieldset>
                                <div class="form-group">
                                    <div class="input-group"><div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div><?php echo form_input('username', set_value('username'), 'id="username" class="form-control input-lg" placeholder="账号" autofocus'); ?></div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group"><div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div><?php echo form_password('password', '', 'id="password" class="form-control input-lg" placeholder="密码"'); ?></div>
                                </div>
								<div class="form-group">
                                    <div class="input-group"><div class="input-group-addon"><span class="glyphicon glyphicon-unchecked"></span></div><?php echo form_input('captcha', '', 'id="captcha" class="form-control input-lg" placeholder="验证码"'); ?><div class="input-group-addon" style="padding:0px;"><img style="cursor:pointer" src="<?php echo site_url('admin/login/captcha') ?>" onclick="this.src = '<?php echo site_url('admin/login/captcha') ?>/?' + Math.random()" title="点击更换" alt="验证码" /><?php //echo $captcha ?></div></div>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">记住账号
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button class="btn btn-lg btn-success btn-block">提 交</button>
                            </fieldset>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="<?php echo base_url('resource/admin/jquery/dist/jquery.min.js') ?>"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url('resource/admin/bootstrap/dist/js/bootstrap.min.js') ?>"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url('resource/admin/metisMenu/dist/metisMenu.min.js') ?>"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url('resource/admin/dist/js/sb-admin-2.js') ?>"></script>

</body>

</html>
