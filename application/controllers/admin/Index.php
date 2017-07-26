<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends MY_Admin {
	

	public function __construct() {
		parent::__construct();
	}
    
	public function index() {
		$data = array();
		$this->load->model('Online_model');


		$data['onlines'] = $this->My_model->_table('online')->get_count();
		
		$this->_bind['_title'] = '控制面板';
		$this->_render($data);
	}
	
	public function profile() {
		$this->_bind['_title'] = '我的资料';
		$data = array();//圈子信息

		$this->_render($data);

	}
	
	public function setting() {
		$this->_bind['_title'] = '设置';
		$data = array();//圈子信息
		
		if($this->input->post('username')) {
			$id = $this->_admin['id'];
			$salt = $this->_admin['salt'];
			//$post['username'] = $this->input->post('username');
			$post['realname'] = $this->input->post('realname');
			$password = $this->input->post('password');
			$newpassword = $this->input->post('newpassword');
			$renewpassword = $this->input->post('renewpassword');
			
			$user = $this->My_model->_table('manager')->get_one_by(array('id' => $id, 'password' => md5(md5($password). $salt)));
			if($user) {
				$post['id'] = $id;
				if($newpassword != '' && $renewpassword != '') {
					if($newpassword == $renewpassword) {//如果修改密码
						$post['password'] = md5(md5($newpassword). $salt);
					} else {
						$this->_message('新密码两次输入不相同！');
					}
				}
				$this->My_model->_table('manager')->update($post);
				$row = $this->My_model->_table('manager')->get_one($id);
				$this->_admin = $row;
				redirect('admin/index/setting');
			} else {
				$this->_message('没有输入现密码或者现密码错误！');
			}
		}
		
		$this->_render($data);

	}
	
}
