<?php

class Online extends MY_Admin {

	public function __construct() {
		parent::__construct();
		$this->load->model('Online_model', 'online');
	}
	
	public function ls() {
		$data = $condition = array();
		$offset = (int)$this->input->get('per_page');
		$user_id = $this->input->get('user_id');
		$data['user_id'] = $user_id;
		if($user_id) {
			$condition['online.user_id'] = $user_id;
		}

		$page = $offset / $this->_page_config['per_page'] + 1;
		$list = $this->online->get_list($condition, $page, 'online.login_time DESC', $this->_page_config['per_page']);
		$data['list'] = $list;
		
		$this->load->library('pagination');
		$this->_page_config['base_url'] = site_url("admin/online/ls/?user_id=$user_id");
		$this->_page_config['total_rows'] = $this->online->get_count($condition);
		$this->pagination->initialize($this->_page_config); 
		$data['page'] = $this->pagination->create_links();
		
		$this->_bind['_title'] = '在线情况';
		$this->_render($data, 'admin/online');
	}
	
	public function del($id) {
		
		$data = array();
		
		$this->online->delete($id);

		output_json($data, '删除成功！');
	}

	
}
