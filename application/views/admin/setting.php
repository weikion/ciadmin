<div class="container-fluid">
	<div class="page-header text-danger">
		<h3>设置</h3>
	</div>
	<div class="panel panel-default">

		<div class="panel-body">
			<form name="saveform" id="saveform" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">账号</label>
					<div class="col-sm-5 col-md-4 col-lg3 col-xs-12">
						<input type="text" class="form-control" name="username" value="<?php echo $_admin['username']; ?>" readonly />
						<span class="help-block"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">真名</label>
					<div class="col-sm-5 col-md-4 col-lg3 col-xs-12">
						<input type="text" class="form-control" name="realname" value="<?php echo $_admin['realname']; ?>" />
						<span class="help-block"></span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">新密码</label>
					<div class="col-sm-5 col-md-4 col-lg3 col-xs-12">
						<input type="password" class="form-control" name="newpassword" value="" />
						<span class="help-block">如果不修改，请留空</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">验证密码</label>
					<div class="col-sm-5 col-md-4 col-lg3 col-xs-12">
						<input type="password" class="form-control" name="renewpassword" value="" />
						<span class="help-block">如果不修改，请留空</span>
					</div>
				</div>
				
				
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">现密码</label>
					<div class="col-sm-5 col-md-4 col-lg3 col-xs-12">
						<input type="password" class="form-control" name="password" value="" />
						<span class="help-block">*必填，每次提交都需要输入登录密码</span>
					</div>
				</div>
				

				<div class="row form-group text-center">
					<button type="submit" class="btn btn-primary">提交</button>
				</div>
			</form>

		</div>
	</div>
</div>

