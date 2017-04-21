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
			if($config->getInt($field)!==null)
				$redis->hset($key, $field, $config->getInt($field));
		}
		return $res;
	}


	function counts_get()
	{
		$redis = RedisDAO::instance();
		if($redis===null){
			$res['errno'] = CRErrnoCode::UNABLE_TO_CONNECT_REDIS;
			return $res;
		}
		$res['errno'] = CRErrorCode::SUCCESS;
		$pattern = 'count_*';
		$keys = $redis->keys($pattern);
		$records = array();
		foreach($keys as $key){
			$record['count'] = $redis->get($key);
			$record['ttl'] = $redis->ttl($key);
			$record['key'] = $key;
			$records[] = $record;
		}
		$res['records'] = $records;
		return $res;
	}


	function count_reset($key)
	{
		$redis = RedisDAO::instance();
		if($redis===null){
			$res['errno'] = CRErrnoCode::UNABLE_TO_CONNECT_REDIS;
			return $res;
		}
		$res['errno'] = CRErrorCode::SUCCESS;
		$redis->del($key);
		return $res;
	}


	function queue_get($rule)
	{
		$redis = RedisDAO::instance();
		if($redis===null){
			$res['errno'] = CRErrnoCode::UNABLE_TO_CONNECT_REDIS;
			return $res;
		}
		$res['errno'] = CRErrorCode::SUCCESS;
		$key = 'urls_to_download';
		$start = $rule->getInt('offset', 0);
		$stop = $start + $rule->getInt('limit', 20) - 1;
		$members = $redis->zrange($key, $start, $stop, 'WITHSCORES');
		$res['members'] = $members;
		$total = $redis->zcard($key);
		$res['total'] = $total;
		return $res;
	}


	function queue_add_seed($seed)
	{
		$redis = RedisDAO::instance();
		if($redis===null){
			$res['errno'] = CRErrnoCode::UNABLE_TO_CONNECT_REDIS;
			return $res;
		}
		$res['errno'] = CRErrorCode::SUCCESS;
		$key = 'urls_to_download';
		$redis->zadd($key, time(), $seed);
		return $res;
	}


	function stats_get()
	{
		$redis = RedisDAO::instance();
		if($redis===null){
			$res['errno'] = CRErrnoCode::UNABLE_TO_CONNECT_REDIS;
			return $res;
		}
		$res['errno'] = CRErrorCode::SUCCESS;
		$stats = array();
		$key = 'urls_to_download';
		$stats['pending'] = $redis->zcard($key);
		$stats['dbsize'] = $redis->dbsize();
		$stats['patterns'] = $redis->zcard('allowed_url_patterns');
		$res['stats'] = $stats;
		return $res;
	}
