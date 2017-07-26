<!DOCTYPE html>
<html lang="en">

	<head>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">

		<title><?php echo $_title . ' | ' . $_site_name ?></title>
		<!-- Bootstrap Core CSS -->
		<link href="<?php echo base_url('resource/admin/bootstrap/dist/css/bootstrap.min.css') ?>" rel="stylesheet">

		<!-- MetisMenu CSS -->
		<!--<link href="<?php echo base_url('resource/admin/metisMenu/dist/metisMenu.min.css') ?>" rel="stylesheet">-->

		<!-- Timeline CSS -->
		<!--<link href="<?php echo base_url('resource/admin/dist/css/timeline.css') ?>" rel="stylesheet">-->

		<!-- Custom CSS -->
		<link href="<?php echo base_url('resource/admin/dist/css/sb-admin-2.css') ?>" rel="stylesheet">

		<!-- Morris Charts CSS -->
		<!--<link href="<?php echo base_url('resource/admin/morrisjs/morris.css') ?>" rel="stylesheet">-->

		<!-- Custom Fonts -->
		<link href="<?php echo base_url('resource/admin/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css">
		<?php if (isset($_css_res)): ?>
			<?php if (is_array($_css_res)): ?>
				<?php foreach ($_css_res as $value): ?>
					<link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/admin/' . $value) ?>" />
				<?php endforeach; ?>
			<?php else: ?>
				<link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/admin/' . $_css_res) ?>" />
			<?php endif ?>
		<?php endif ?>
		
		<!-- jQuery -->
		<script src="<?php echo base_url('resource/admin/jquery/dist/jquery.min.js') ?>"></script>

		<!-- Bootstrap Core JavaScript -->
		<script src="<?php echo base_url('resource/admin/bootstrap/dist/js/bootstrap.min.js') ?>"></script>

		<!-- Metis Menu Plugin JavaScript -->
		<script src="<?php echo base_url('resource/admin/metisMenu/dist/metisMenu.min.js') ?>"></script>

		<!-- Morris Charts JavaScript -->
		<!--<script src="<?php echo base_url('resource/admin/raphael/raphael-min.js') ?>"></script>-->
		<!--<script src="<?php echo base_url('resource/admin/morrisjs/morris.min.js') ?>"></script>-->
		<!--<script src="<?php echo base_url('resource/admin/js/morris-data.js') ?>"></script>-->

		<!-- Custom Theme JavaScript -->
		<script src="<?php echo base_url('resource/admin/dist/js/sb-admin-2.js') ?>"></script>
		<script type="text/javascript" src="<?php echo base_url('resource/js/template.native.js') ?>"></script>

		<!-- Custom Theme JavaScript -->
		
		<?php if (isset($_js_res)): ?>
			<?php if (is_array($_js_res)): ?>
				<?php foreach ($_js_res as $value): ?>
					<script type="text/javascript" src="<?php echo base_url('resource/admin/' . $value) ?>"></script>
				<?php endforeach; ?>
			<?php else: ?>
				<script type="text/javascript" src="<?php echo base_url('resource/admin/' . $_js_res) ?>"></script>
			<?php endif ?>
		<?php endif; ?>

		<style>
			.navbar-header .navbar-brand {background: url(<?php echo base_url('resource/images/logo.png') ?>) no-repeat; background-size: 50px 50px; padding-left: 60px;}
		</style>
	</head>

	<body>

		<div id="wrapper">
			<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
				<div class="navbar-header">
					<a class="navbar-brand" href="<?php echo site_url('admin/index') ?>">CI后台系统</a>
				</div>
				<ul class="nav navbar-top-links navbar-right">
					<li><b><?php echo $_admin['realname'] ?></b></li>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
						</a>
						<ul class="dropdown-menu dropdown-user">
							<li><a href="<?php echo site_url('admin/index/profile')?>"><i class="fa fa-user fa-fw"></i> 我的资料</a></li>
							<li><a href="<?php echo site_url('admin/index/setting')?>"><i class="fa fa-gear fa-fw"></i> 修改</a></li>
							<li class="divider"></li>
							<li><a href="<?php echo site_url('admin/login/logout')?>"><i class="fa fa-sign-out fa-fw"></i> 退出</a></li>
						</ul>
					</li>
				</ul>
				<div class="navbar-default sidebar" role="navigation">
					<div class="sidebar-nav navbar-collapse">
						<ul class="nav" id="side-menu">
							<li class="sidebar-search">
								<div class="input-group custom-search-form">
									<input type="text" class="form-control" placeholder="暂停搜索...">
									<span class="input-group-btn">
										<button class="btn btn-default" type="button" onclick="javascript:alert('还点！！！都说暂停咯~~');">
											<i class="fa fa-search"></i>
										</button>
									</span>
								</div>
							</li>
							<li>
								<a href="#"><i class="fa fa-wrench fa-fw"></i> 设置<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level">
									<li>
										<a href="<?php echo site_url('admin/manager/ls')?>">管理员</a>
									</li>
									<li>
										<a href="<?php echo site_url('admin/online/ls')?>">在线情况</a>
									</li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</nav>
			<div id="page-wrapper" style="padding: 10px;">
				<?php $this->load->view($_body_view) ?><!-- 主题部分 -->
			</div>
		</div>
	</body>
</html>
