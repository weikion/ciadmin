<!DOCTYPE html>
<html leng="ZH">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no"/>
<title><?php echo '提示信息 | ' . $this->config->item('site_name') ?></title>
<?php
echo $href ? '<meta http-equiv="refresh" content="3;url='.$href.'"> ':'';
?>
<style type="text/css">
	/************************************************下单成功***********************************************/
.content { width:100%; position:absolute; z-index:1; top:0; left:0; margin:0 auto; padding:50px 0 48px 0; overflow:hidden; -webkit-transition:top 300ms ease; -moz-transition:top 300ms ease;  -o-transition:top 300ms ease; transition:top 300ms ease; }
.success { width:80%; height:100%; float:inherit; margin:0 auto; display:table; }
.success_box { width:100%; display:table-cell; vertical-align:middle; text-align:center; overflow:hidden; }
.success b { width:100%; line-height:40px; color:#666; text-align:center; font-size:2.4em; }
.success p { float:inherit; margin:20px auto 0 auto; padding:20px 0%; border-top:1px dotted #ccc; color:#333; line-height:180%; font-size:1.4em; }
</style>
<script type="text/JavaScript" src="http://www.ngzb.com.cn/wap/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?php //echo base_url('resource/admin/jquery-1.7.2.min.js') ?>"></script>
</head>
<body>
<div class="content"><script type="text/javascript">$(function(){s_middle();})</script>
    <div class="success">
    <div class="success_box">
		<b>提示！</b><p><?php echo($message); ?><span>&nbsp;<a href="<?php echo($href); ?>" onclick="<?php echo($click); ?>"><?php echo($atext); ?></a></span></p>
    </div>
    </div>
</div>
<script type="text/javascript">
function s_middle() {
    var hh = $(window).height();
    $(".success_box").css("height", hh - 100 + "px");
}
</script>
</body></html>

