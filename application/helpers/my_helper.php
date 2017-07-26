<?php

defined('BASEPATH') OR exit('No direct script access allowed');

function get_ip() {
	if(!empty($_SERVER["REMOTE_ADDR"])) {
		$cip = $_SERVER["REMOTE_ADDR"];
	} else if(!empty($_SERVER["HTTP_CLIENT_IP"])) {
		$cip = $_SERVER["HTTP_CLIENT_IP"];
	} else if(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
		$cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	} else {
		$cip = "无法获取！";
	}
	return $cip;
}

function format_month($time) {
	if (empty($time)) {
		return "";
	}
	$code = array('零月', '一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月');
	$month = intval(date('m', $time));
	return $code[$month];
}

function format_date($time) {
	$now_time = CURRENT_TIME;
	$dur = $now_time - $time;
	if ($dur < 0) {
		return date('Y-m-d', $time);
	} else {
		if ($dur < 60) {
			return $dur . '秒前';
		} else {
			if ($dur < 3600) {
				return floor($dur / 60) . '分钟前';
			} else {
				if ($dur < 86400) {
					return floor($dur / 3600) . '小时前';
				} else {
					if ($dur < 259200) {//3天内
						return floor($dur / 86400) . '天前';
					} else {
						return date('Y-m-d', $time);
					}
				}
			}
		}
	}
}

function date_diff_format($time) {
	$start = $time;
	$stop = time();

	$time = date('Y-m-d', $time);
	$extend = ($stop - $start) / 86400;
	$result = array('extends' => $extend, 'yearly' => null, 'monthly' => null, 'weekly' => null, 'daily' => null);
	if ($extend < 7) {				//如果小于7天直接返回天数
		$result['daily'] = $extend;
	} elseif ($extend <= 31) {		//小于28天则返回周数，由于闰年2月满足了
		if ($stop == strtotime($time . '+1 month')) {
			$result['monthly'] = 1;
		} else {
			$w = floor($extend / 7);
			$d = floor(($stop - strtotime($time . '+' . $w . ' week')) / 86400);
			$result['weekly'] = $w;
			$result['daily'] = $d;
		}
	} else {
		$y = floor($extend / 365);
		if ($y >= 1) {				//如果超过一年
			$start = strtotime($time . '+' . $y . 'year');
			$time = date('Y-m-d', $start);
			//判断是否真的已经有了一年了，如果没有的话就开减
			if ($start > $stop) {
				$time = date('Y-m-d', strtotime($time . '-1 month'));
				$m = 11;
				$y--;
			}
			$extend = ($stop - strtotime($time)) / 86400;
		}
		if (isset($m)) {
			$w = floor($extend / 7);
			$d = $extend - $w * 7;
		} else {
			$m = isset($m) ? $m : round($extend / 30);
			$stop >= strtotime($time . '+' . $m . 'month') ? $m : $m--;
			if ($stop >= strtotime($time . '+' . $m . 'month')) {
				$d = $w = ($stop - strtotime($time . '+' . $m . 'month')) / 86400;
				$w = floor($w / 7);
				$d = $d - $w * 7;
			}
		}
		$result['yearly'] = $y;
		$result['monthly'] = $m;
		$result['weekly'] = $w;
		$result['daily'] = isset($d) ? floor($d) : null;
	}
	$date = '';
	if ($result['yearly']) {
		$date .= $result['yearly'] . '年';
	}
	if ($result['monthly']) {
		$date .= $result['monthly'] . '个月';
	}

	if ($date == '') {
		if ($result['weekly']) {
			$date .= $result['weekly'] . '周';
		}
		if ($result['daily']) {
			$date .= $result['daily'] . '天';
		} else {
			$date .= '0天';
		}
	}
	return $date;
}

function output_json($bind = array(), $msg = '') {
	$bind = array_merge(array('list' => array()), $bind); //统一必须返回list 键值的数据，确保js那边不会报错，list 为数组
	$int = array('error' => 0, 'msg' => '提交成功！', 'data' => $bind, 'other' => '');
	if ($msg) {
		$int['msg'] = $msg;
	}
	$json = json_encode($int);
	echo($json);
	exit();
}

function output_error($msg) {
	$bind = array();
	$bind['error'] = 1;
	$bind['msg'] = $msg;
	$bind['data'] = array();
	$bind['other'] = '';
	$json = json_encode($bind);
	echo($json);
	exit();
}

function salt($n = 5) {
	$seed = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+=-";
	$salt = '';
	for($i=0; $i<$n; $i++){
		$salt .= substr($seed, mt_rand(0, strlen($seed) - 1), 1);
	}

	return $salt;
}
	
function random_num($n = 5) {
	$seed = "1234567890";
	$num = '';
	for ($i = 0; $i < $n; $i++) {
		$num .= substr($seed, mt_rand(0, strlen($seed) - 1), 1);
	}

	return $num;
}

function get_year($time) {
	$year = date('Y', CURRENT_TIME);
	if(strpos($time, '月') !== false) {
		$month = substr($time, 0, strpos($time, '月'));
	}
	if(strpos($time, '-') !== false) {
		$month = substr($time, 0, strpos($time, '-'));
	}
	if($month >= date('m', CURRENT_TIME)) {
		$year = $year - 1;
	}
	return $year;
}

function baijiahao_to_unixtime($time) {
	if(strpos($time, '月') !== false && strpos($time, '日') !== false) {
		$year = get_year($time);
		$str = $year . "-" . str_replace(array('月', '日'), array('-', ''), $time);
		return strtotime($str);
	}
	if(count(explode(':', $time)) == 2) {
		$str = date('Y-m-d', CURRENT_TIME) . ' ' . $time;
	} else if(count(explode('-', $time)) == 2) {
		$str = get_year($time) . "-" . $time;
	} else {
		$str = $time;
	}
	return strtotime($str);
}

function baijiahao_tag_format($tags) {
	$tagstr = array();
	if(empty($tags)) {
		return '';
	}
	if(!is_array($tags)) {
		$tags = json_decode($tags, true);
	}
	foreach($tags as $value) {
		$tagstr[] = isset($value['m_name']) ? $value['m_name'] : $value['name'];
	}
	return $tagstr ? implode(',', $tagstr) : '';
}


function _curl($url, $rand_ip = false, $referer = '') {
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	if($rand_ip) {
		$ip_long = array(
			array('607649792', '608174079'), //36.56.0.0-36.63.255.255
			array('1038614528', '1039007743'), //61.232.0.0-61.237.255.255
			array('1783627776', '1784676351'), //106.80.0.0-106.95.255.255
			array('2035023872', '2035154943'), //121.76.0.0-121.77.255.255
			array('2078801920', '2079064063'), //123.232.0.0-123.235.255.255
			array('-1950089216', '-1948778497'), //139.196.0.0-139.215.255.255
			array('-1425539072', '-1425014785'), //171.8.0.0-171.15.255.255
			array('-1236271104', '-1235419137'), //182.80.0.0-182.92.255.255
			array('-770113536', '-768606209'), //210.25.0.0-210.47.255.255
			array('-569376768', '-564133889'), //222.16.0.0-222.95.255.255
		);
		$rand_key = mt_rand(0, 9);
		$ip = long2ip(mt_rand($ip_long[$rand_key][0], $ip_long[$rand_key][1]));
		$headers['CLIENT-IP'] = $ip; 
		$headers['X-FORWARDED-FOR'] = $ip; 

		$headerArr = array(); 
		foreach( $headers as $n => $v ) { 
			$headerArr[] = $n .':' . $v;  
		}
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headerArr);
	}
	curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.75 Safari/537.36");
	if($referer) {
		curl_setopt($curl, CURLOPT_REFERER, $referer);
	}
	curl_setopt($curl, CURLOPT_TIMEOUT, 500);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($curl, CURLOPT_URL, $url);

	$res = curl_exec($curl);
	$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	curl_close($curl);
	if (200 != $httpCode) {
		return 0;
	}
	return $res;
}


function json_curl($url, $rand_ip = false, $referer = '') {
	$data = array();
	$origin = _curl($url, $rand_ip, $referer);
	$origin = json_decode($origin, true);
	if(!empty($origin)) {
		$data = $origin;
	}
	return $data;
}

function show_id_as_name($index, $array) {
	if(empty($index) || empty($array) || !is_array($array)) {
		return '';
	}
	
	if(isset($array[$index])) {
		return $array[$index];
	} else {
		return '<span class="text-danger">分类已被删除</span>';
	}
	
}
