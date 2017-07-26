<nav>
	<a class="quessionNav" href="<?php echo site_url('question/ls') ?>" onclick="mui.toast('即将开放，敬请期待！'); return false;">
        <span>答赏</span>
    </a>
    <a class="logNav" href="<?php echo site_url('post/ls') ?>">
        <span>哈宠圈</span>
    </a>
    <a class="ucNav" href="<?php echo site_url('user/') ?>">
        <span>我的</span>
		<b><?php echo($_new_notify > 0 ? $_new_notify : ''); ?></b>
    </a>
</nav>