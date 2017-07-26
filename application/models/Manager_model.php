<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manager_model extends MY_model {
	
	public $_table_name = 'manager';

	public function __construct() {
		parent::__construct();
		
	}
	
	public function get_list(array $condition = array(), $page = 1, $order_by = 'id DESC', $perpage = 10) {
		$this->db->select('*');//注意字段先后顺序，后面的覆盖前面的
		$this->db->from('manager');
		if(!empty($condition)) {
			$this->db->where($condition);
		}
		$this->db->limit($perpage, $perpage * ($page -1));
		$this->db->order_by($order_by);
		$query = $this->db->get();
		$data = $query->result_array();
		return $data;
	}
	
}