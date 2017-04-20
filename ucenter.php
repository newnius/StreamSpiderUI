<?php
	require_once('config.inc.php');
	require_once('util4p/util.php');
	require_once('util4p/Session.class.php');
	require_once('init.inc.php');

	$page_type = 'home';

	if(isset($_GET['patterns'])){
		$page_type='patterns';

	}elseif(isset($_GET['setting'])){
		$pattern = cr_get_GET('pattern');
		$page_type='setting';

	}elseif(isset($_GET['queue'])){
		$page_type='queue';

	}elseif(isset($_GET['count'])){
		$host = cr_get_GET('host');
		$page_type='count';
	}

	$entries = array(
		array('home', 'Home'),
		array('patterns', 'Patterns'),
		array('count', 'Counts'),
		array('queue', 'Pending Queue')
	);
	$visible_entries = array();
	foreach($entries as $entry){
		$visible_entries[] = array($entry[0], $entry[1]);
	}

?>
<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<meta name="keywords" content="StreamSpiderUI"/>
		<meta name="description" content="StreamSpider UI" />
		<meta name="author" content="Newnius"/>
		<link rel="icon" href="favicon.ico"/>
		<title>StreamSpider UI</title>
		<link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet"/>
		<link href="style.css" rel="stylesheet"/>
		<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
		<link href="//cdn.bootcss.com/bootstrap-table/1.11.1/bootstrap-table.min.css" rel="stylesheet">

		<script type="text/javascript">
			var page_type = "<?=$page_type?>";
		</script>
	</head>

	<body>
		<?php require_once('modals.php'); ?>
		<div class="wrapper">
			<?php require_once('header.php'); ?>
			<div class="container">
				<div class="row">

					<div class="hidden-xs hidden-sm col-md-2 col-lg-2">
						<div class="panel panel-default">
							<div class="panel-heading">Menubar</div>
							<ul class="nav nav-pills nav-stacked panel-body">
								<?php foreach($visible_entries as $entry){ ?>
								<li role="presentation" <?php if($page_type==$entry[0])echo 'class="disabled"'; ?> >
									<a href="?<?=$entry[0]?>"><?=$entry[1]?></a>
								</li>
								<?php } ?>
							</ul>
						</div>
					</div>
          
					<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
						
						<div class="visible-xs visible-sm">
							<div class=" panel panel-default">
								<div class="panel-heading">Menubar</div>
								<ul class="nav nav-pills panel-body">
									<?php foreach($visible_entries as $entry){ ?>
									<li role="presentation" <?php if($page_type==$entry[0])echo 'class="disabled"'; ?> >
										<a href="?<?=$entry[0]?>"><?=$entry[1]?></a>
									</li>
									<?php } ?>
								</ul>
							</div>
						</div>

						<?php if($page_type === 'home'){ ?>
						<div id="home">
							<div class="panel panel-default">
								<div class="panel-heading">Welcome</div> 
								<div class="panel-body">
									Curent IP: &nbsp; <?=cr_get_client_ip() ?>.<br/>
									Current time: &nbsp; <?php echo date('H:i:s',time()) ?>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">Notices</div> 
								<div class="panel-body">
									<h4 class="text-info">Notice</h4>
									<ul>
										<li>No notice</li>
									</ul>
								</div>
							</div>
						</div>

						<?php }elseif($page_type === 'patterns'){ ?>
						<div id="patterns">
							<div class="panel panel-default">
								<div class="panel-heading">Patterns</div> 
								<div class="panel-body">
									<div class="table-responsive">
										<div id="toolbar">
											<button id="btn-pattern-add" class="btn btn-primary">
												<i class="glyphicon glyphicon-plus"></i> Add
											</button>
										</div>
										<table id="table-pattern" data-toolbar="#toolbar" class="table table-striped">
										</table> 
									</div>
								</div>
							</div>
						</div>

						<?php }elseif($page_type === 'logs'){ ?>
						<div id="logs">
							<div class="panel panel-default">
								<div class="panel-heading">Recent activities</div> 
								<div class="panel-body">
									<div class="table-responsive">
										<div id="toolbar"></div>
										<table id="table-log" data-toolbar="#toolbar" class="table table-striped">
										</table> 
										<span class="text-info">* Last 20 recent records</span>
									</div>
								</div>
							</div>
						</div>
						<?php } ?>

					</div>
				</div>
			</div> <!-- /container -->
      
			<!--This div exists to avoid footer from covering main body-->
			<div class="push"></div>
		</div>
		<?php require_once('footer.php'); ?>

		<script src="static/util.js"></script>
		<script src="static/site.js"></script>
		<script src="static/config.js"></script>
		<script src="static/pattern.js"></script>
		<script src="static/ucenter.js"></script>

		<script src="//cdn.bootcss.com/bootstrap-table/1.11.1/bootstrap-table.min.js"></script>
		<script src="//cdn.bootcss.com/bootstrap-table/1.11.1/locale/bootstrap-table-en-US.min.js"></script>
		<script src="//cdn.bootcss.com/bootstrap-table/1.11.1/extensions/mobile/bootstrap-table-mobile.min.js"></script>
		<script src="//cdn.bootcss.com/bootstrap-table/1.11.1/extensions/export/bootstrap-table-export.min.js"></script>
		<script src="//cdn.bootcss.com/TableExport/3.3.9/js/tableexport.min.js"></script>
		<script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script src="//cdn.bootcss.com/jqueryui/1.11.4/jquery-ui.js"></script> 
	</body>
</html>
