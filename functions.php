<?php
	require_once('predis/autoload.php');
	require_once('config.inc.php');
	require_once('util4p/RedisDAO.class.php');
	require_once('util4p/util.php');
	require_once('util4p/CRObject.class.php');
	require_once('util4p/CRErrorCode.class.php');
	require_once('util4p/Random.class.php');
	require_once('init.inc.php');

	function pattern_add($pattern, $priority)
	{
		$redis = RedisDAO::instance();
		if($redis===null){
			$res['errno'] = CRErrnoCode::UNABLE_TO_CONNECT_REDIS;
			return $res;
		}
		$res['errno'] = CRErrorCode::SUCCESS;
		$key = 'allowed_url_patterns';
		$success = $redis->zadd($key, $priority, $pattern);
		if(!($success===1)){
			$res['errno'] = CRErrorCode::FAIL;
		}
		return $res;
	}


	function pattern_remove($pattern)
	{
		$redis = RedisDAO::instance();
		if($redis===null){
			$res['errno'] = CRErrnoCode::UNABLE_TO_CONNECT_REDIS;
			return $res;
		}
		$res['errno'] = CRErrorCode::SUCCESS;
		$key = 'allowed_url_patterns';
		$success = $redis->zrem($key, $pattern);
		if(!($success===1)){
			$res['errno'] = CRErrorCode::FAIL;
		}
		return $res;
	}

	function pattern_gets()
	{
		$redis = RedisDAO::instance();
		if($redis===null){
			$res['errno'] = CRErrnoCode::UNABLE_TO_CONNECT_REDIS;
			return $res;
		}
		$res['errno'] = CRErrorCode::SUCCESS;
		$key = 'allowed_url_patterns';
		$res['patterns'] = $redis->zrange($key, 0, -1, 'withscores');
		if($res['patterns']===null){
			$res['errno'] = CRErrorCode::FAIL;
		}
		return $res;
	}

	function config_get($pattern)
	{
		$redis = RedisDAO::instance();
		if($redis===null){
			$res['errno'] = CRErrnoCode::UNABLE_TO_CONNECT_REDIS;
			return $res;
		}
		$res['errno'] = CRErrorCode::SUCCESS;
		$key = 'url_pattern_setting_'.$pattern;
		$res['config'] = $redis->hgetall($key);
		if($res['config']===null){
			$res['errno'] = CRErrorCode::FAIL;
		}
		return $res;
	}

	function config_update($config){
		$redis = RedisDAO::instance();
		if($redis===null){
			$res['errno'] = CRErrnoCode::UNABLE_TO_CONNECT_REDIS;
			return $res;
		}
		$res['errno'] = CRErrorCode::SUCCESS;
		$key = 'url_pattern_setting_'.$config->get('pattern');
		$fields = array('expire', 'limitation', 'interval', 'parallelism');
		foreach($fields as $field){
			$redis->hset($key, $field, $config->getInt($field));
		}
		return $res;
	}
