
<div class="container-fluid">
	<div class="page-header text-danger">
		<!--<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal" data-id="0" data-act="add">添加文章</button>-->
		<h3><?php echo validation_errors(); ?></h3>
	</div>

	<!-- Modal -->
	<div class="modal fade bs-example-modal-sm" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<form name="saveform" id="saveform" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">请确认</h4>
					</div>
					<div class="modal-body">
						<div class="text-danger"><h3>确定要删除此数据吗？</h3></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
						<button type="button" class="btn btn-primary" id="commit">提交</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<div class="panel panel-info">
		<div class="panel-body">
			<div class="form-group">
				<label for="user_id" class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">筛选</label>
				<div class="col-sm-3 col-lg-3 col-xs-6">
					<input type="text" class="form-control" id="user_id" name="user_id" value="<?php echo $user_id; ?>" placeholder="用户id" />
				</div>
				<div class=" col-xs-12 col-sm-2 col-lg-2">
					<input class="btn btn-success" name="submit" type="button" value="搜索" onclick="filter_ls()" />
				</div>
			</div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-body">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>编号</th>
						<th>用户</th>
						<th>token</th>
						<th>IP地址</th>
						<th>登陆时间</th>
						<th>退出时间</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($list as $value): ?>
					<tr>
						<td scope="row"><?php echo $value['id'] ?></td>
						<td><?php if ($value['realname'] != '') { ?><?php echo $value['realname'] ?><?php } else { ?>已被删除<?php } ?></td>
						<th><?php echo $value['token'] ?></th>
						<td><?php echo $value['ip'] ?></td>
						<td><?php echo date('Y-m-d H:i:s', $value['login_time']) ?></td>
						<td><?php echo($value['logout_time'] ? date('Y-m-d H:i:s', $value['logout_time']) : '') ?></td>
						<td><?php if($value['user_id'] != $_admin['id']) { ?><button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#myModal" data-id="<?php echo $value['id'] ?>" data-act="del">删除</button><?php } ?></td>
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
	$(function(){
					
		$('#myModal').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget);
			var id = button.data('id');
			var commit_url = '<?php echo site_url('admin/online/del') ?>/' + id;
			$('#commit').click(function() {
				$.ajax({
					url: commit_url,
					type: 'POST',
					cache: false,
					data: {},
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
	
	function filter_ls() {
		window.location.href = '<?php echo site_url('admin/online/ls') ?>/?user_id=' + $('#user_id').val();
	}

</script>

