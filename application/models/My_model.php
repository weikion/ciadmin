<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_model  extends CI_Model  {
	public $_table_name;
	public $_primary_key = 'id';
	
	public function __construct() {
        parent::__construct();
		$this->_table_name = $this->db->dbprefix($this->_table_name);
    }
	
	public function exists_table($table_name = null) {
		if(empty($table_name)) {
			$table_name = $this->_table_name;
		} else {
			$table_name = $this->db->dbprefix($table_name);
		}
		
		$query = $this->db->query('SHOW TABLES LIKE \'' . $table_name . '\'');
		if($query->num_rows() == 1) { //|| $this->db->affected_rows() == 1
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * 可以使用当前模型跳到别的表去，执行本基类模型的函数
	 * @param string $table 表名
	 * @param string $primary_key 主键名
	 * @return \My_model
	 */
	public function _table($table, $primary_key = null) {
		$this->_table_name = $this->db->dbprefix($table);
		if($primary_key) {
			$this->_primary_key = $primary_key;
		}
		return $this;
	}


	/**
	 * 通用查询，必须有自增ID，并且名字为“id”
	 * @param mix $condition
	 * @param mix $limit
	 * @param mix $order_by
	 * @return array
	 */
	public function get_all($condition = null, $limit = 0, $order_by = 'id DESC') {
		if(empty($condition)) {
			$condition = '1=1';
		}
		$this->db->select('*');
		$this->db->from($this->_table_name);
		$this->db->where($condition);
		if($limit) {
			$this->db->limit($limit);
		}
		$this->db->order_by($order_by);
		$query = $this->db->get();
		$data = $query->result_array();

		return $data;
    }
	
	/**
	 * 获取查询的行数或者表的行数
	 * @param mix $condition
	 * @return type
	 */
	public function get_count($condition = null) {
		
		if($condition) {
			$this->db->select('*');
			$this->db->from($this->_table_name);
			$this->db->where($condition);
			$query = $this->db->get();
			$count = $query->num_rows();
		} else {//不传条件的时候，返回表的总行数
			$count = $this->db->count_all($this->_table_name);
		}
		
		return $count;
	}
	
	/**
	 * 通用单条查询，必须有自增ID，并且名字为“id”
	 * @param string $table
	 * @param number $id
	 * @param number $obj 是否返回对象
	 * @return array
	 */
	public function get_one($id = null, $return_obj = false) {
		$condition = '1=1';
		if($id) {
			$condition = array('id' => $id);
		}
		$order = 'id DESC';

		return $this->get_one_by($condition, $order, $return_obj);
	}
	
	/**
	 * 非主键数据，根据字段值，获得一条记录
	 * @param mix $condition  array('field' => $value)
	 * @param mix $order_by 排序
	 * @param boolean $return_obj
	 * @return array
	 */
	public function get_one_by($condition, $order_by = 'id DESC', $return_obj = false) {
		if(empty($condition)) {
			return false;
		}
		$this->db->select('*');
		$this->db->from($this->_table_name);
		$this->db->where($condition);
		$this->db->order_by($order_by);
		$query = $this->db->get();
		if($return_obj){
			$data = $query->row();
		} else {
			$data = $query->row_array();
		}
		return $data;
	}
	
	/**
	 * 通用添加
	 * @param array $post
	 * @return boolean
	 */
	public function add($post = array()) {
		if(empty($post)) {
			return false;
		}

		if(isset($post[$this->_primary_key])) {
			unset($post[$this->_primary_key]);// 如果存在主键，则剔除
		}
		
		$re = $this->db->insert($this->_table_name, $post);
		if($re) {
			return $this->db->insert_id();
		} else {
			return false;
		}
    }
	/**
	 * 通用添加
	 * @param array $post
	 * @return boolean
	 */
	public function add_batch($post = array()) {
		if(empty($post)) {
			return false;
		}
		foreach($post as $key =>$val){
			if(isset($post[$key][$this->_primary_key])) {
				unset($post[$key][$this->_primary_key]);// 如果存在主键，则剔除
			}
		}
		$re = $this->db->insert_batch($this->_table_name, $post);
		if($re) {
			return $this->db->insert_id();
		} else {
			return false;
		}
    }	
	/**
	 * 通用修改数据，注意ID名称必须是“id”
	 * @param array $post 更新的数据，必须要有id键值
	 * @param array $unescape 不用转义的字段
	 * @return boolean
	 */
	public function update($post = array(), $unescape = array()) {
		if(empty($post) || !isset($post[$this->_primary_key])) {
			return false;
		}
		
		$id = $post[$this->_primary_key];
		$condition = array($this->_primary_key => $id);
		unset($post[$this->_primary_key]);
		$data = $post;
		return $this->update_by($condition, $data, $unescape);
    }
	
	
	/**
	 * 非主键更新，有可能会更新多条
	 * @param mix $condition
	 * @param array $data
	 */
	public function update_by($condition, $data, $unescape = array()) {
		if(empty($condition) || empty($data)) {
			return false;
		}
		
		foreach($data as $field => $value) {//支持字段算法更新，算法的字段必须加入到unescape 中，例如：传递$post = array('field' => 'field+1');
			$escape = in_array($field, $unescape) ? false : true;
			$this->db->set($field, $value, $escape);
		}

		$this->db->where($condition);
		$result = $this->db->update($this->_table_name);
		return $result;//不使用$this->db->affected_rows() ，是因为有的更新数据都是没有变化的，影响的行数会是0
	}
	
	/**
	 * 批量修改
	 * @param array $data
	 * @return boolean
	 */
	public function update_batch($data){
		if(empty($data)) {
			return false;
		}
		$result = $this->db->update_batch($this->_table_name, $data, $this->_primary_key);
		return $result;
	}
	
	
	/**
	 * 通用删除数据，注意主键名称必须是“id”
	 * @param int $id
	 * @return boolean
	 */
	public function delete($id = null) {
		if(empty($id)) {
			return false;
		}
		
		return $this->delete_by(array($this->_primary_key => $id));
	}
	
	/**
	 * 非主键删除
	 * @param mix $condition
	 */
	public function delete_by($condition) {
		if(empty($condition)) {
			return false;
		}
		$this->db->where($condition);
		$this->db->delete($this->_table_name);
		
		return $this->db->affected_rows();
	}


	/**
	 * 通用单条查询，必须有自增ID，并且名字为“id”
	 * @param string $table
	 * @param number $id
	 * @param number $obj 是否返回对象
	 * @return array
	 * $sql = [
			'field'=>[ ['title'],['openid']],
			'where'=>$where,
			'join'=>['user',['user_id','id']],
			'page'=>['pagesize'=>3,'page'=>$page],
			
		];$query = $this->Question->pagination($sql);
	 */
	public function pagination($data,$obj = 0) {
//		if( isset ($data['field']) ) {
//			$this->db->select($data['field']);
//		}else{
//			$this->db->select('*');
//		}
		if( isset ($data['join_table']) ) {
			$this->db->join($data['join_table']);
		}
		if( isset ($data['join'])) {
			$join_table = $this->db->dbprefix($data['join'][0]);
			$join_type = isset($data['join'][2]) ?  $data['join'][2] : 'inner';
			if( isset ($data['field']) ) {
				if( is_array($data['field'])){
					$field = array();
					foreach( $data['field'][0] as $key => $val){
						if( is_numeric($key) ){
							$field[] = $this->_table_name.'.'.$data['field'][0][$key];
						}else{
							$field[] = $this->_table_name.'.'.$key.' AS '.$data['field'][0][$key];
						}	
					}
					foreach( $data['field'][1] as $key => $val){
						if( is_numeric($key) ){
							$field[] = $join_table.'.'.$data['field'][1][$key];
						}else{
							$field[] = $join_table.'.'.$key.' AS '.$data['field'][1][$key];
						}
					}
					$this->db->select(implode(',', $field));
					//var_dump($field);
				}else{
					$this->db->select($data['field']);
				}
			}else{
				$this->db->select('*');
			}
			
			
			$this->db->join($join_table,  $this->_table_name.'.'.$data['join'][1][0].'='.$join_table.'.'.$data['join'][1][1],$join_type);
		}else{
			if( isset ($data['field']) ) {
				$this->db->select($data['field']);
			}else{
				$this->db->select('*');
			}
		}
		if( isset ($data['where']) ) {
			$this->db->where($data['where']);
		}
		if( isset ($data['where_not_in']) ) {
			$this->db->where_not_in($this->_table_name.'.'.$data['where_not_in'][0],$data['where_not_in'][1]);
		}
		if( isset ($data['order_by']) ) {
			foreach($data['order_by'] as $key => $order){
				$this->db->order_by($data['order_by'][$key][0],$data['order_by'][$key][1]);
			}
		}
		if( isset ($data['page']) ) {
			$page = max((int)$data['page']['page'],1);
			$pagesize = empty($data['page']['pagesize']) ? $this->config->item('page_size') : (int)$data['page']['pagesize'];
			$offset = ($page - 1) * $pagesize;
			$this->db->limit($pagesize,$offset);
		}
		
		$sql = $this->db->get_compiled_select($this->_table_name);
		//var_dump($sql);die($sql);
		$query = $this->db->query($sql);
	
		if($obj){
			$data = $query->result();
		}else{
			$data = $query->result_array();
		}

		return $data;
	}
}
