<?php
	class Exemplo {
	
		private $tabela;
		private $campo_busca;
		
		private $id;
		private $nome;
		private $url;
		private $status;
	
		public function __construct($id="",$nome="",$url="",$status="") {
	
			$this->id 		= $id;
			$this->nome		= $nome;
			$this->url		= $url;
			$this->status 	= $status;
			// automaticos
			$this->tabela 		= 'exemplo';
			$this->campo_busca 	= array('nome_pt');
		}
	
		// METODOS GETS
		public function getId() {
			return $this->id;
		}
	
		public function getNome() {
			return $this->nome;
		}
	
		public function getUrl() {
			return $this->url;
		}
	
		public function getStatus() {
			return $this->status;
		}
	
	
		// METODOS SETS
		public function setId($id) {
			$this->id = $id;
		}
	
		public function setNome($nome) {
			$this->nome = $nome;
		}
		
		public function setUrl($url) {
			$this->url = $url;
		}
		
		public function setStatus($status) {
			$this->status = $status;
		}
		
	
		/*
		**	[SELECT]
		*/
		/*
		**	método que lista todos Registro ou com filtro passando @busca
		*/
		public function listar($busca='', $extra='') {
			
			if(!empty($busca)) {
				foreach($this->campo_busca as $campo){
					$likeBusca .= $campo." LIKE '%".$busca."%' OR ";
				}
				$likeBusca = 'AND ('.substr($likeBusca, 0, -4).')';
			} 
			
			$query = "SELECT * FROM ".$this->tabela." WHERE 1=1 ".$likeBusca." ".$extra;
			$result = mysql_query($query);
			$num_rows = mysql_num_rows($result);
			
			if($num_rows > 0){
				return($result);
			}
			else {
				return(false);
			}
		}
		
		
		/*
		**	método lista um registro por ID
		*/
		public function listarPorId($id) {
			
			$query = "SELECT * FROM ".$this->tabela." WHERE id = ".$id;
			//echo $query;
			$result = mysql_query($query);
			$num_rows = mysql_num_rows($result);
			
			if($num_rows > 0){
				return($result);
			}
			else {
				return(false);
			}
		}
		
		/*
		**	método que lista Registro por URL
		*/
		public function verificarUrl() {
			
			$query = "SELECT * FROM ".$this->tabela." WHERE urlist = '".$this->getUrlist()."'";
			$result = mysql_query($query);
			$num_rows = mysql_num_rows($result);
			
			if($num_rows <= 1){
				return($result);
			}
			else {
				return(false);
			}
		}

		/*
		**	método que retorna o numero de linhas totais
		*/
		public function numRows($busca='', $extra='') {
			
			if(!empty($busca)) {
				foreach($this->campo_busca as $campo){
					$likeBusca .= $campo." LIKE '%".$busca."%' OR ";
				}
				$likeBusca = 'AND ('.substr($likeBusca, 0, -4).')';
			} 
			
			$query = "SELECT * FROM ".$this->tabela." WHERE 1=1 ".$likeBusca." ".$extra;
			$result = mysql_query($query);
			$num_rows = mysql_num_rows($result);
			
			return($num_rows);
		}
		
		/*
		**	[INSERIR]
		*/
		/*
		**	método que insere Registro 
		*/
		public function inserir() {
			
			$dados  = "'',";
			$dados .= "'".$this->getNome()."',";
			$dados .= "'".$this->getUrl()."',";
			$dados .= "'".$this->getStatus()."',";
			$dados .= "'".date('Y-m-d H:i:s')."'";
			$sql = "INSERT INTO ".$this->tabela." VALUES (".$dados.")";
			//die($sql);
			if(mysql_query($sql)) {
				return(true);
			}
			
			return(false);
		}
		
		/*
		**	[EDITAR]
		*/
		/*
		**	método que edita Registro 
		*/
		public function editar() {
			$sql = "UPDATE ".$this->tabela." SET
					nome	= '".$this->getNome()."',
					url		= '".$this->getUrl()."',
					status	= '".$this->getStatus()."'
			WHERE id='".$this->getId()."'";
			
			if(mysql_query($sql)) {
				return(true);
			} 
			
			return(false);
		}
	
		/*
		**	[EXCLUIR]
		*/
		/*
		**	método que deleta Registro 
		*/
		public function deletar($id) {
			$sql = "DELETE FROM ".$this->tabela." WHERE id='".$id."'";
			if(mysql_query($sql)) {
				return(true);
			} 
			return(false);
		}

		
	}
?>