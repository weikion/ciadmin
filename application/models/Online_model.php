<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Online_model extends MY_model {
	public $_table_name = 'online';
	
	public function __construct() {
		parent::__construct();
	}
	
	public function get_list(array $condition = array(), $page = 1, $order_by = 'online.login_time DESC', $perpage = 10) {
		$this->db->select('online.*,manager.realname,manager.ip,manager.username');//注意字段先后顺序，后面的覆盖前面的
		$this->db->from('online');
		$this->db->join('manager', 'manager.id = online.user_id', 'left');
		
		$this->db->where($condition);
		
		$this->db->limit($perpage, $perpage * ($page -1));
		$this->db->order_by($order_by);
		$query = $this->db->get();
		$data = $query->result_array();
		return $data;
	}
	
	public function check_user() {
		$ip = get_ip();
		$token = md5($ip . md5($this->input->user_agent()));
		$online = $this->get_one_by(array('token' => $token));
		if($online) {
			if($online['login_time'] > CURRENT_TIME - 86400 && $online['logout_time'] == 0) {
				return $online;
			}
		}
		return false;
	}
	
	public function online($user) {
		if(empty($user)) {
			return false;
		}
		$ip = get_ip();
		$token = $token = md5($ip. md5($this->input->user_agent()));
		
		if(!empty($user['ip']) && $ip != $user['ip']) {
			return false;
		}
		
		//删除过期的，24小时
		//$this->delete_by(array('login_time <' => CURRENT_TIME - 86400));
		
		$exist = $this->get_one_by(array('user_id' => $user['id']));
		if($exist) {//如果已经存在，直接返回
			$data['id'] = $exist['id'];
			$data['token'] = $token;
			$data['login_time'] = CURRENT_TIME;
			$data['logout_time'] = 0;
			$result = $this->update($data);
		} else {
			$data = array('user_id' => $user['id'], 'login_time' => CURRENT_TIME, 'token' => $token, 'ip' => $ip);

			$result = $this->add($data);
		}
		return $result;
	}
	
	public function offline() {
		$ip = get_ip();
		$token = md5($ip . md5($this->input->user_agent()));
		$this->update_by(array('token' => $token), array('logout_time' => CURRENT_TIME));
	}
	
}