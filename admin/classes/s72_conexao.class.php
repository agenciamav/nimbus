<?php
	class Conexao{
		private $_server;
		private $_dbase;
		private $_user;
		private $_pass;
		
		public function __construct() {
			// verifica servidor interno ou servidor externo
			if($_SERVER['HTTP_HOST'] == '192.168.0.66'){
				$this->setAtributos('192.168.0.12','nimbus','master','123');
			} else
			if( in_array( $_SERVER['REMOTE_ADDR'], array( '127.0.0.1', '::1', 'localhost' ) ) ) { 
				$this->setAtributos('localhost','nimbus','root','');
			}else{
				$this->setAtributos(null,null,null,null);
			}
		}
		
		public function setAtributos($server, $dbase, $user, $pass) {
			$this->_server = $server;
			$this->_dbase = $dbase;
			$this->_user = $user;
			$this->_pass = $pass;
		}
		
		// função que conecta no Mysql
		public function conectarMysql() {
			$db = mysql_connect($this->_server, $this->_user, $this->_pass);
			if($db) {
				$db_select = mysql_select_db($this->_dbase, $db);
				if($db_select) {
					return(true);
				} else {
					return(false);
				}
			} else {
				return(false);
			}
		}	
	}
?>
