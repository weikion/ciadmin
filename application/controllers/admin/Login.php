<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Online_model');
	}

	public function index() {
//		echo(md5(md5('happy@!23') . '8kAl2').'<br>');
//		echo(md5(md5('tl_ngzb@ngzb') . '23df23').'<br>');
//		echo(md5(md5('wahaha@ngzb') . 'hf32d3').'<br>');
//		echo(md5(md5('wenhua@ngzb') . 'sd32ds').'<br>');
		$data = array();
		$this->load->helper(array('form'));

		if ($this->Online_model->check_user()) {
			redirect('admin/index');
		}
		
		$this->load->helper('security');//xss_clean 安全过滤
		$this->load->library('form_validation'); // 使用CI的表单验证, 如下:
		$this->form_validation->set_rules('username', '用户名', 'trim|required|min_length[5]|max_length[12]|xss_clean');
		$this->form_validation->set_rules('password', '密码', 'min_length[6]|required');
		$this->form_validation->set_rules('captcha', '验证码', 'trim|required|callback_captcha_check');
		$this->form_validation->set_message('required', '请输入“%s”');
		$this->form_validation->set_message('min_length', '“%s”不能少于 %s 个字符');
		$this->form_validation->set_message('max_length', '“%s”不能超过 %s 个字符');
		$this->form_validation->set_error_delimiters('<p class="bg-warning">', '</p>');
		if($this->form_validation->run() !== false) {
			$sql = 'SELECT * FROM ' . $this->db->dbprefix('manager') . ' WHERE username = ?';
			$query = $this->db->query($sql, array($this->input->post('username')));
			$row = $query->row_array();
			if($row){
				$password = md5(md5($this->input->post('password')) . $row['salt']);
				//echo($password);
				if($password == $row['password']) {
					unset($row['password']);
					$rs = $this->Online_model->online($row);
					if($rs) {
						redirect('admin/index');
					} else {
						$data['error'] = '对不起！当前IP不允许登陆或者在其他地方已经登陆。';
					}
				} else {
					$data['error'] = '账号和密码错误！';
				}
			} else {
				$data['error'] = '账号不存在！';
			}
		}


		$this->load->view('admin/login', $data);
	}
	
	public function captcha() {
		//$this->load->helper('captcha');//xss_clean 安全过滤
		$this->load->library('captcha');
		//echo($this->captcha->font);
		$this->captcha->doimg();
		$this->session->set_userdata('captcha', $this->captcha->getCode());//验证码保存到SESSION中
		$this->captcha->outPut();
	}
	
	public function captcha_check($captcha) {
		if(strtolower($captcha) != $this->session->userdata('captcha')) {
			$this->form_validation->set_message('captcha_check', '验证码错误');
			return false;
		}
		return true;
	}

	public function logout() {
		$this->Online_model->offline();
		redirect('admin/login');
	}

}
