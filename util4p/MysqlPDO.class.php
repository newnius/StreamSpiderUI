<?php

	require_once('CRObject.class.php');

	class MysqlPDO
	{
		private static $host = 'localhost';
		private static $port = '3307';
		private static $db = '';
		private static $user = 'root';
		private static $password = '';
		private static $charset = 'utf8';

		private $dbh;

		/*
		 */
		public static function configure($config)
		{
			self::$host = $config->get('host', self::$host);
			self::$port = $config->getInt('port', self::$port);
			self::$db = $config->get('db', self::$db);
			self::$user = $config->get('user', self::$user);
			self::$password = $config->get('password', self::$password);
			self::$charset = $config->get('charset', self::$charset);
		}


		/*
		 */
		public function MysqlPDO()
		{
			$this->connect();
		}


		/*
		 */
		private function connect()
		{
			try {
				$this->dbh = new PDO('mysql:host='.(self::$host).';port='.(self::$port).';dbname='.(self::$db), self::$user, self::$password);
				$this->dbh->exec('SET names '.self::$charset);
				return true;
			} catch (PDOException $e) {
				$this->dbh = null;
				var_dump($e->getMessage());
				return false;
			}
		}


		/*
		 */
		public function execute($sql, $a_params, $need_inserted_id=false)
		{
			if($this->dbh === null){
				return null;
			}
			try{
				$stmt = $this->dbh->prepare($sql);
				$stmt->execute($a_params);
				$affected_rows = $stmt->rowCount();
				if($need_inserted_id){
					return $affected_rows>0?$this->dbh->lastInsertId():null;
				}
				$this->dbh = null;
				return $affected_rows;
			}catch(Exception $e) {
				var_dump($e->getMessage());
				return null;
			}
		}


		/*
		 */
		function executeQuery($sql, $a_params)
		{
			if($this->dbh === null){
				return null;
			}
			try{
				$stmt = $this->dbh->prepare($sql);
				$stmt->setFetchMode(PDO::FETCH_ASSOC);
				$result = null;
				if($stmt->execute($a_params)){
					$result = $stmt->fetchAll();
				}
				$this->dbh = null;
				return $result;
			}catch(Exception $e) {
				var_dump($e->getMessage());
				return null;
			}
		}

	}
