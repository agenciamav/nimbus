<?php
	class Modulo{
		
		private $tabela;
		private $campo_busca;
		
		private $id;
		private $id_menu;
		private $descricao;
		private $modulo;
		private $ativo;
		
		public function __construct($id="",$id_menu="",$descricao="",$modulo="",$ativo="") {
			
			$this->id = $id;
			$this->id_menu = $id_menu;
			$this->descricao = $descricao;
			$this->modulo = $modulo;
			$this->ativo = $ativo;
			// automaticos
			$this->tabela = 's72_modulo';
			$this->campo_busca = array('descricao');
		}
		
		// METODOS GETS
		public function getId() {
			return $this->id;
		}
	
		public function getIdMenu() {
			return $this->id_menu;
		}
	
		public function getDescricao() {
			return $this->descricao;
		}
	
		public function getModulo() {
			return $this->modulo;
		}
	
		public function getAtivo() {
			return $this->ativo;
		}
	
		// METODOS SETS
		public function setId($id) {
			$this->id = $id;
		}
	
		public function setIdMenu($id_menu) {
			$this->id_menu = $id_menu;
		}
	
		public function setDescricao($descricao) {
			$this->descricao = $descricao;
		}
	
		public function setModulo($modulo) {
			$this->modulo = $modulo;
		}
	
		public function setAtivo($ativo) {
			$this->ativo = $ativo;
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
			$dados .= "'".$this->getIdMenu()."',";
			$dados .= "'".$this->getDescricao()."',";
			$dados .= "'".$this->getModulo()."',";
			$dados .= "'".$this->getAtivo()."',";
			$dados .= "'N'";
			$sql = "INSERT INTO ".$this->tabela." VALUES (".$dados.")";
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
					id_menu		= '".$this->getIdMenu()."',
					descricao	= '".$this->getDescricao()."',
					modulo		= '".$this->getModulo()."',
					ativo		= '".$this->getAtivo()."'
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
		
	} // fim da classe
?>