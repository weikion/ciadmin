<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * 前端基类控制器
 */

class MY_Controller extends CI_Controller {

	public $_class;//当前控制器名
	public $_action;//当前动作名
	public $_bind = array();//模板数据绑定
	public $_template;//模板名
	public $_user = array();//当前用户

	public function __construct() {
		parent::__construct();
		
		
		//加载缓存类
		$this->load->driver('cache', array('adapter' => 'memcached', 'backup' => 'file', 'key_prefix' => 'ci_'));

		$this->_class = strtolower($this->router->class);
		if(empty($this->_class)) {
			$this->_class = 'index';
		}

		$this->_action = strtolower($this->router->method);
		if(empty($this->_action)) {
			$this->_action = 'index';
		}

		if($this->_class == 'index') {
			$this->_template = $this->_action;
		} else {
			$this->_template = $this->_class . '/' . $this->_action;
		}
		$this->_bind['_site_name'] =  $this->config->item('site_name');

	}
	
	public function index() {
		echo('hello world！');
		exit;
	}
	

	/**
	 * 视图渲染
	 * @param array $bind
	 * @param string $template
	 */
	public function _render($bind = array(), $template = null) {
		if($template) {
			$this->_template = $template;
		}

		$this->_bind['_header_view'] = $this->_class . '/header';
		$this->_bind['_footer_view'] = 'footer';
		$this->_bind['_body_view'] = $this->_template;
		$this->_bind = array_merge($this->_bind, $bind);
		$this->load->view('template', $this->_bind);
	}
	
	//操作提示信息
	public function _message($message, $params = array()) {
		
		if($this->input->post('ajax')) {
			output_error($message);
		}
		
		$params['message'] = $message;
		$params['click'] = '';
		if(!isset($params['redirect'])) {
			$params['redirect'] = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : site_url();
		}
		if($params['redirect'] == 'back') {// 返回历史，为保持状态
			$params['click'] = 'javascript:history.back();';
			$params['href'] = 'javascript:void(0);';
			$params['atext'] = '返回上一页';
		} else {// 重定向，会刷新
			$params['href'] = $params['redirect'];
			$params['atext'] = '继续';
		}
		
		if(!isset($params['index'])) {// 是否显示首页链接
			$params['index'] = true;
		}
		
		if(!isset($params['auto'])) {// 是否自动跳转
			$params['auto'] = true;
		}
		//print_r($params);
		$this->load->view('message', $params);
		echo($this->output->get_output());
		exit();
	}


}


/*
 * 后台基类控制器
 */
class MY_Admin extends CI_Controller {

	public $_class;//当前控制器名
	public $_action;//当前动作名
	public $_bind;//模板数据绑定
	public $_template;//模板名
	public $_admin = array();//当前用户
	public $_page_config = array();//分页配置


	/**
	 * 路由权限控制，配置以数组的形式，例如：控制器 => array('方法' => array(1,2),)
	 * 可以设置控制器总的权限，也可以细分到方法，方法的会高于控制器的
	 * 如果没有配置则表示默认允许所有，1，2 表示用户组id，超级管理员是1
	 * 
	 */
	private $_role_config = array(
		'index' => array(1,2,3,4,5),//所有用户都可以访问，可以不设置该值
		'analyze' => array('reset' => array(1)),//可以设置控制器总权限 array(1)
		'manager' => array(1),
		'online' => array(1)
	);

	public function __construct() {
		parent::__construct();
		
		$this->_class = strtolower($this->router->class);
		if(empty($this->_class)) {
			$this->_class = 'index';
		}
		
		$this->_action = strtolower($this->router->method);
		if(empty($this->_action)) {
			$this->_action = 'index';
		}
		
		$this->_template = 'admin/' . $this->_action;
		
		$this->_bind = array(
			'_site_name' => $this->config->item('site_name'),
		);
		
		$this->load->model('Online_model');
		$online = $this->Online_model->check_user();
		if (empty($online)) {
			redirect('admin/login');
		}
		
		$this->load->model('Manager_model');
		$this->_admin = $this->Manager_model->get_one($online['user_id']);
		
		$this->_bind['_action'] = $this->_action;
		$this->_bind['_admin'] = $this->_admin;
		
		if(isset($this->_role_config[$this->_class])) {
			$allow = true;
			if(isset($this->_role_config[$this->_class][0]) && !in_array($this->_admin['role'], $this->_role_config[$this->_class])) {
				$allow = false;
			}
			
			if(isset($this->_role_config[$this->_class][$this->_action]) && !in_array($this->_admin['role'], $this->_role_config[$this->_class][$this->_action])) {
				$allow = false;
			} else {
				
			}
			
			if(!$allow) {
				$this->_message('对不起！当前用户没有权限操作此项，请后退。');
			}
		}
		
		//分页配置
		$this->_page_config['uri_segment'] = 4;
		$this->_page_config['page_query_string'] = TRUE;
		$this->_page_config['num_links'] = 3;
		$this->_page_config['per_page'] = 20;
		$this->_page_config['full_tag_open'] = '<ul class="pagination">';
		$this->_page_config['full_tag_close'] = '</ul>';
		$this->_page_config['num_tag_open'] = '<li>';
		$this->_page_config['num_tag_close'] = '</li>';
		$this->_page_config['cur_tag_open'] = '<li class="active"><a href="#">';
		$this->_page_config['cur_tag_close'] = '</a></li>';
		$this->_page_config['next_link'] = '下一页>';
		$this->_page_config['next_tag_open'] = '<li>';
		$this->_page_config['next_tag_close'] = '</li>';
		$this->_page_config['prev_link'] = '<上一页';
		$this->_page_config['prev_tag_open'] = '<li>';
		$this->_page_config['prev_tag_close'] = '</li>';
		$this->_page_config['first_link'] = '第一页';
		$this->_page_config['first_tag_open'] = '<li>';
		$this->_page_config['first_tag_close'] = '</li>';
		$this->_page_config['last_link'] = '最后页';
		$this->_page_config['last_tag_open'] = '<li>';
		$this->_page_config['last_tag_close'] = '</li>';
		
		//加载缓存类
		$this->load->driver('cache', array('adapter' => 'memcached', 'backup' => 'file', 'key_prefix' => 'zy_'));
	}
	
	public function index() {
		echo('hello world！');
		exit;
	}
	
	public function _render($bind = array(), $template = null) {
		if($template) {
			$this->_template = $template;
		}
		$this->_bind['_body_view'] = $this->_template;
		$this->_bind = array_merge($this->_bind, $bind);
		
		
		$this->load->view('admin/template', $this->_bind);
	}
	
	public function _render_ajax($bind) {
		$json = json_encode($bind);
		echo($json);
		exit();
	}

	//操作提示信息
	public function _message($message, $params = array()) {
		if($this->input->post('ajax')) {
			output_error($message);
		}
		
		$params['message'] = $message;
		$params['click'] = '';
		if(!isset($params['redirect'])) {
			$params['redirect'] = $_SERVER['HTTP_REFERER'];
		}
		if($params['redirect'] == 'back') {// 返回历史，为保持状态
			$params['click'] = 'javascript:history.back();';
			$params['href'] = 'javascript:void(0);';
			$params['atext'] = isset($params['atext']) ? $params['atext'] : '返回';
		} else {// 重定向，会刷新
			$params['href'] = $params['redirect'];
			$params['atext'] = isset($params['atext']) ? $params['atext'] : '继续';
		}
		
		if(!isset($params['index'])) {// 是否显示首页链接
			$params['index'] = true;
		}
		
		if(!isset($params['auto'])) {// 是否自动跳转
			$params['auto'] = true;
		}
		//print_r($params);
		$this->load->view('admin/message', $params);
		echo($this->output->get_output());
		exit();
	}
}

