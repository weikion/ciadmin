<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="format-detection" content="telephone=no" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black" />
		<meta content="yes" name="apple-touch-fullscreen" />
		<meta content="telephone=no,email=no" name="format-detection" />
		<meta http-equiv="Expires" content="0" />
		<meta http-equiv="Pragma" content="no-cache" />
		<meta http-equiv="Cache-control" content="no-cache" />
		<meta http-equiv="Cache" content="no-cache" />
        <title><?php echo '提示信息 | ' . $this->config->item('site_name') ?></title>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/css/mui.min.css') ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/css/reset.css') ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/css/global.css') ?>" />
		<script type="text/javascript" src="<?php echo base_url('resource/js/mui.min.js') ?>"></script>
		<script type="text/javascript" src="<?php echo base_url('resource/js/global.js') ?>"></script>
	</head>
<style>
body { background:#fff; }
</style>
	<body>
		<div class="msgPage">
			<div class="errorIcon"><img src="ui/errorIcon.png"></div>
			<strong>提示信息</strong>
			<p><?php echo($message); ?></p>
			<a href="<?php echo(site_url('user/')); ?>">个人中心</a>
			<a href="<?php echo($href); ?>" onclick="<?php echo($click); ?>"><?php echo($atext); ?></a>
		</div>
<!--		<header>
			<h1>提示信息</h1>
			<a class="backBtn">返回</a>
		</header>
		<div class="mui-content">
			<div class="mui-collapse-content">
				<h1><?php echo($message); ?></h1>
				<p>
					继续操作，请点击下面按钮！
				</p>
				<div class="mui-row">
					<div class="mui-col-sm-6 mui-col-xs-12"><a class="mui-btn" href="<?php echo($href); ?>" onclick="<?php echo($click); ?>"><?php echo($atext); ?></a></div>
					<div class="mui-col-sm-6 mui-col-xs-12"><?php if($index): ?><a class="mui-btn" href="<?php echo(site_url('/')); ?>">主页</a><?php endif ?></div>
				</div>
			</div>
		</div>-->

	</body>
</html>