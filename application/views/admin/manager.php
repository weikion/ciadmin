<div class="container-fluid">
	<div class="page-header text-danger">
		<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal" data-id="0" data-act="add">添加管理员</button>
		<h3><?php echo validation_errors(); ?></h3>
	</div>
	
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form name="saveform" id="saveform" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">请输入信息</h4>
					</div>
					<div class="modal-body" id="formdata">
						<div class="text-danger" id="confirm"><h3></h3></div>
						<script id="tp_formdata" type="text/html">
						<div class="form-group">
							<label for="username" class="col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label">账号</label>
							<div class="col-sm-6 col-lg-7 col-xs-12">
								<input type="text" class="form-control" id="username" name="username" value="<%=list.username%>" />
								<span class="help-block">必填</span>
							</div>
						</div>
						<div class="form-group">
							<label for="realname" class="col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label">名称</label>
							<div class="col-sm-6 col-lg-7 col-xs-12">
								<input type="text" class="form-control" id="realname" name="realname" value="<%=list.realname%>" />
								<span class="help-block">必填</span>
							</div>
						</div>
						<div class="form-group">
							<label for="password" class="col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label">密码</label>
							<div class="col-sm-6 col-lg-7 col-xs-12">
								<input type="password" class="form-control" id="password" name="password" value="" />
								<span class="help-block">新增用户必填，编辑用户如果不修改密码请留空</span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label">权限</label>
							<div class="col-sm-6 col-lg-7 col-xs-12">
								<label class="text-success" for="role1"><input type="radio" id="role1" name="role" value="1" />超级管理员</label>
								<label class="text-success" for="role2"><input type="radio" id="role2" name="role" value="2" checked="checked" />普通管理员</label>
							</div>
						</div>
						<div class="form-group">
							<label for="ip" class="col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label">绑定IP</label>
							<div class="col-sm-6 col-lg-7 col-xs-12">
								<input type="text" class="form-control" id="ip" name="ip" value="<%=list.ip%>" />
								<span class="help-block">选填，如果要限制某个用户</span>
							</div>
						</div>
						</script>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
						<button type="button" class="btn btn-primary" id="commit">提交</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<div class="panel panel-default">
		<div class="panel-body">
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>编号</th>
						<th>账号</th>
						<th>名称</th>
						<th>用户组</th>
						<th>绑定IP</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($list as $value): ?>
					<tr>
						<td scope="row"><?php echo $value['id'] ?></td>
						<td><?php echo $value['username'] ?></td>
						<td><?php echo $value['realname'] ?></td>
						<td><?php echo($value['role'] == 1 ? '超级管理员' : '普通管理员') ?></td>
						<td><?php echo $value['ip'] ?></td>
						<td><?php if($value['id'] != $_admin['id']) { ?><button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" data-id="<?php echo $value['id'] ?>" data-act="edit">修改</button> <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModal" data-id="<?php echo $value['id'] ?>" data-act="del">删除</button><?php } ?></td>
					</tr>

					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
	<nav>
		<?php echo($page); ?>
	</nav>
</div>

<script type="text/javascript">
	//var ue_image_ids = [];//编辑器内的图片
	$(function(){
					
		$('#myModal').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget);
			var act = button.data('act');
			var id = button.data('id');
			var modal = $(this);
			var out_html, commit_url;

			if(act == 'add') {
				commit_url = '<?php echo site_url('admin/manager/save') ?>/' + id;
				out_html = template('tp_formdata', {'list':{'username':'','realname':'','ip':''}});
				$('#formdata').html(out_html);
			} else if(act == 'edit') {
				commit_url = '<?php echo site_url('admin/manager/save') ?>/' + id;
				var get_url = '<?php echo site_url('admin/manager/get') ?>/' + id;
				$.get(get_url, function(result){
					var response = eval('('+result+')');
					console.log(response.data);
					if(parseInt(response.error) == 0) {
						out_html = template('tp_formdata', response.data);
						$('#formdata').html(out_html);
						
						role = response.data.list.role;
						$('#role' + role).attr("checked",true);
					} else {
						alert(response.msg);
					}
				});
			} else if(act == 'del') {
				commit_url = '<?php echo site_url('admin/manager/del') ?>/' + id;
				modal.find('#confirm h3').text('确定要删除此数据吗？');
				modal.find('#confirm').show();
			}
			
			$('#commit').click(function() {
				var formElement = $("#saveform");
				var form_data = new FormData(formElement[0]);
				//form_data.append("image_ids", ue_image_ids.join(','));
				$.ajax({
					url: commit_url,
					type: 'POST',
					cache: false,
					data: form_data,
					processData: false,
					contentType: false
				}).done(function(result) {
					var response = eval('('+result+')');
					if(parseInt(response.error) == 0) {
						alert(response.msg);
						window.location.reload();
					} else {
						alert(response.msg);
					}
				});
			});
			
		});
		
		$('#myModal').on('hidden.bs.modal', function (event) {
			window.location.reload();
		});

	});

</script>

