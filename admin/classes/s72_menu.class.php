<?php
	class Menu{
		
		private $tabela;
		private $campo_busca;
		
		private $id;
		private $nome;
		
		public function __construct($id="",$nome="") {
			
			$this->id = $id;
			$this->nome = $nome;
			// automaticos
			$this->tabela = 's72_menu';
			$this->campo_busca = array('nome');
		}
		
		// METODOS GETS
		public function getId() {
			return $this->id;
		}
	
		public function getNome() {
			return $this->nome;
		}
	
		// METODOS SETS
		public function setId($id) {
			$this->id = $id;
		}
	
		public function setNome($nome) {
			$this->nome = $nome;
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
		**	método lista todos registros 
		*/
		public function listarTodos($where='') {
			
			$query = "SELECT * FROM ".$this->tabela." ".$where;
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
		**	método lista todos os submenu no menu selecionado
		*/
		public function listarMenuModulo($id_modulo) {
			
			$query = "
				SELECT * FROM ".$this->tabela." MEN
				INNER JOIN s72_modulo MOO
				ON MEN.id = MOO.id_menu
				WHERE MOO.id = ".$id_modulo;
						
			if($result = mysql_query($query)){
				return($result);
			} else {
				return(false);
			}
		}
		
		/*
		** método que lista todos menu_modulo
		*/
		public function verificarMenuSelecionado($id_menu, $id_modulo) {
			
			$query = "SELECT * FROM s72_modulo WHERE id_menu=".$id_menu." AND id=".$id_modulo;
			
			if($result = mysql_query($query)){
				if($num_rows = mysql_num_rows($result)){
					return(true);
				}
			}
			return(false);
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
			$dados .= "'".$this->getNome()."'";
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
					nome = '".$this->getNome()."'
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