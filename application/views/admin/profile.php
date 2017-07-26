<div class="container-fluid">
	<div class="page-header text-danger">
		<h3>管理员资料</h3>
	</div>
	<div class="panel panel-default">

		<div class="panel-body">
			<form name="saveform" id="saveform" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">账号</label>
					<div class="col-sm-10 col-lg-9 col-xs-12">
						<?php echo $_admin['username']; ?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">真名</label>
					<div class="col-sm-10 col-lg-9 col-xs-12">
						<?php echo $_admin['realname']; ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">角色</label>
					<div class="col-sm-10 col-lg-9 col-xs-12">
						<?php echo ($_admin['role'] == 1 ? '超级管理员' : '普通管理员'); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">绑定IP</label>
					<div class="col-sm-10 col-lg-9 col-xs-12">
						<?php echo $_admin['ip']; ?>
					</div>
				</div>
				<div class="row form-group text-center">
					<a class="btn btn-info" href="<?php echo site_url('admin/index/setting')?>">修改</a>
				</div>

			</form>

		</div>
	</div>
</div>

