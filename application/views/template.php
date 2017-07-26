<!doctype html>
<html>
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
        <title><?php echo $_title ?></title>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/css/mui.min.css') ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/css/reset.css') ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/css/global.css') ?>" />
		<?php if(isset($_css_res)): ?>
			<?php if(is_array($_css_res)): ?>
				<?php foreach($_css_res as $value): ?>
					<link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/css/' . $value) ?>" />
				<?php endforeach; ?>
			<?php else: ?>
			<link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/css/' . $_css_res) ?>" />
			<?php endif ?>
		<?php endif ?>
		<script type="text/javascript" src="<?php echo base_url('resource/js/mui.min.js') ?>"></script>
		<script type="text/javascript" src="<?php echo base_url('resource/js/mui.pullToRefresh.js') ?>"></script>
		<script type="text/javascript" src="<?php echo base_url('resource/js/mui.lazyload.js') ?>"></script>
		<script type="text/javascript" src="<?php echo base_url('resource/js/mui.lazyload.img.js') ?>"></script>
		<script type="text/javascript" src="<?php echo base_url('resource/js/global.js') ?>"></script>
		<script type="text/javascript" src="<?php echo base_url('resource/js/template.native.js') ?>"></script>
		
		<?php if(isset($_js_res)): ?>
			<?php if(is_array($_js_res)): ?>
				<?php foreach ($_js_res as $value): ?>
					<script type="text/javascript" src="<?php echo base_url('resource/js/' . $value) ?>"></script>
				<?php endforeach; ?>
			<?php else: ?>
				<script type="text/javascript" src="<?php echo base_url('resource/js/' . $_js_res) ?>"></script>
			<?php endif ?>
		<?php endif; ?>
				
		<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
		<script type="text/javascript">
			wx.config({
				debug: false,
				appId: '<?php echo $_signPackage["appId"]; ?>',
				timestamp: <?php echo $_signPackage["timestamp"]; ?>,
				nonceStr: '<?php echo $_signPackage["nonceStr"]; ?>',
				signature: '<?php echo $_signPackage["signature"]; ?>',
				jsApiList: [
					// 所有要调用的 API 都要加到这个列表中
					'hideOptionMenu',
					'chooseImage',
					'previewImage',
					'uploadImage',
					'downloadImage',
					'onMenuShareTimeline',
					'onMenuShareAppMessage',
				]
			});
			wx.ready(function () {
				// 在这里调用 API
				//wx.hideOptionMenu();//答题页面隐藏分享按钮
			});
        </script>
	</head>

	<body>
		<?php if($_header_view): ?>
		<?php $this->load->view($_header_view) ?><!-- 头部/标题，可选 -->
		<?php endif ?>
		
		<?php $this->load->view($_body_view) ?><!-- 主题部分 -->

		<?php if($_footer_view): ?>
		<?php $this->load->view($_footer_view) ?><!-- 底部，可选 -->
		<?php endif ?>

	</body>
</html>