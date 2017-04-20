<?php
	require_once('config.inc.php');
	require_once('util4p/util.php');
	require_once('util4p/CRObject.class.php');
	require_once('util4p/CRErrorCode.class.php');
	require_once('functions.php');
	require_once('init.inc.php');

	$res = array( 'errno' => CRErrorCode::UNKNOWN_REQUEST );


	$action = cr_get_GET('action');
	switch($action){
		case 'update_config':
			$config = new CRObject();
			$config->set('pattern', cr_get_POST('pattern'));
			$config->set('expire', cr_get_POST('expire'));
			$config->set('limitation', cr_get_POST('limitation'));
			$config->set('interval', cr_get_POST('interval'));
			$config->set('parallelism', cr_get_POST('parallelism'));
			$res = config_update($config);
			break;
		case 'get_config':
			$pattern = cr_get_GET('pattern');
			$res = config_get($pattern);
			break;

		case 'add_pattern':
			$pattern = cr_get_POST('pattern');
			$priority = cr_get_POST('priority');
			$res = pattern_add($pattern, $priority);
			break;
		case 'remove_pattern':
			$pattern = cr_get_POST('pattern');
			$res = pattern_remove($pattern);
			break;
		case 'get_patterns':
			$res = pattern_gets();
			break;

		case 'get_verify_site_token':
			$site = cr_get_GET('site');
			$res = site_verify_token_get($site);
			break;
		case 'verify_site':
			$site = cr_get_POST('site');
			$res = site_verify($site);
			break;
		default:
			;
	}

	if(!isset($res['msg'])){
		$res['msg'] = CRErrorCode::getErrorMsg($res['errno']);
	}
	echo json_encode($res);
