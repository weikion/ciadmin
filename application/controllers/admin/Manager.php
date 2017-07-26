<?php

class Manager extends MY_Admin {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('Manager_model');
	}
	
	public function ls() {
		
		$data = $condition = array();
		$offset = (int)$this->input->get('per_page');
		
		
		$page = $offset / $this->_page_config['per_page'] + 1;
		$manager = $this->Manager_model->get_list($condition, $page, 'manager.id DESC', $this->_page_config['per_page']);
		$data['list'] = $manager;
		
		
		$this->load->library('pagination');
		$this->_page_config['base_url'] = site_url("admin/manager/ls");
		$this->_page_config['total_rows'] = $this->Manager_model->get_count($condition);
		$this->pagination->initialize($this->_page_config); 
		$data['page'] = $this->pagination->create_links();
		
		$this->_bind['_title'] = '管理员';
		$this->_render($data, 'admin/manager');
	}
	
	public function del($id) {
		$data = array();
		
		if($id == $this->_admin['id']) {
			output_json('不能修改自己！');
		}
		$this->Manager_model->delete($id);
		output_json($data, '删除成功！');

	}
	
	public function get($id = 0) {
		$data = array();
		if($id) {
			$group = $this->Manager_model->get_one($id);
		} else {
			$group = array();
		}
		$data['list'] = $group;
		output_json($data);
	}
	
	public function save($id = 0) {
		$data = $post = array();
		if($id == $this->_admin['id']) {
			output_json('不能修改自己！');
		}
		
		$post['role'] = (int)$this->input->post('role');
		$post['ip'] = $this->input->post('ip');
		$post['username'] = $this->input->post('username');
		$post['realname'] = $this->input->post('realname');
		$password = $this->input->post('password');
		$salt = salt();
		
		if($id) {
			$post['id'] = $id;
			if(!empty($password)) {
				$post['password'] = md5(md5($password). $salt);
				$post['salt'] = $salt;
			}
			
			$this->Manager_model->update($post);
			output_json($data, '修改成功！');
		} else {
			$post['password'] = md5(md5($password). $salt);
			$post['salt'] = $salt;
			$this->Manager_model->add($post);
			output_json($data, '添加成功！');
		}
	}

	
}
