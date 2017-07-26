<div class="container-fluid">
	<div class="col-lg-12">
		<h1 class="page-header">控制面板</h1>
	</div>
</div>

<div class="container-fluid">
	<div class="col-lg-3 col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-question fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge">0篇</div>
						<div>文章情况</div>
					</div>
				</div>
			</div>
			<a href="#">
				<div class="panel-footer">
					<span class="pull-left">查看详情</span>
					<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>
	<div class="col-lg-3 col-md-6">
		<div class="panel panel-green">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-clock-o fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge"><?php echo $onlines?>人</div>
						<div>在线情况</div>
					</div>
				</div>
			</div>
			<a href="<?php echo site_url('admin/online/ls')?>">
				<div class="panel-footer">
					<span class="pull-left">马上查看</span>
					<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>
</div>