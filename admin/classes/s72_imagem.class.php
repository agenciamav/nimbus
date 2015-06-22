<?php		
	class S72_Imagem {
	private $tabela;
		private $_id;				
		private $_id_modulo;				//  todos arquivos estão relacionados a um módulo do sistema s72_modulo.
		private $_id_modulo_item;			//  item do módulo.			
		private $_legenda;					//  legenda da imagem
		private $_arquivo;					//  nome da imagem
		private $_caminho;					//  caminho da imagem
		
		public function __construct($id="", $id_modulo="", $id_modulo_item="", $legenda="", $arquivo="", $caminho="") {
			$this->id = $id;
			$this->id_modulo = $id_modulo;
			$this->id_modulo_item = $id_modulo_item;
			$this->legenda = $legenda;
			$this->arquivo = $arquivo;
			$this->caminho = $caminho;
			// automaticos
			$this->tabela = 's72_imagem';
			$this->campo_busca = array('nome', 'valor', 'descritivo', 'aplicacao');
		}
		
		/*
		**	METODOS SET
		*/
		public function setId($id){
			$this->id = $id;
		}
		
		public function setIdModulo($id_modulo){
			$this->id_modulo = $id_modulo;
		}
				
		public function setIdModuloItem($id_modulo_item){
			$this->id_modulo_item = $id_modulo_item;
		}
				
		public function setLegenda($legenda){
			$this->legenda = $legenda;
		}
		
		public function setArquivo($arquivo){
			$this->arquivo = $arquivo;
		}
		
		public function setCaminho($caminho){
			$this->caminho = $caminho;
		}
		
		/*
		** METODOS GETS
		*/
		
		public function getId() {
			return $this->id;
		}
		
		public function getIdModulo() {
			return $this->id_modulo;
		}
		
		public function getIdModuloItem() {
			return $this->id_modulo_item;
		}
		
		public function getLegenda() {
			return $this->legenda;
		}
		
		public function getArquivo() {
			return $this->arquivo;
		}
		
		public function getCaminho() {
			return '../img/'.$this->caminho;
		}
		
		
		/*
		**	[SELECT]
		*/
		/*
		**	método que lista todos Registro ou com filtro 
		*/
		public function listar($extra='') {
			
			$query = "SELECT * FROM ".$this->tabela." ".$extra;
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
		**	método que lista todos por pai
		*/
		public function listarPorPai($id_pai, $extra = ''){
			
			$query = "SELECT * FROM ".$this->tabela." WHERE id_modulo_item = ".$id_pai." " .$extra;
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
		**	método que lista todos por id
		*/
		public function listarPorId($id){
			
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
		**	[EDITAR]
		*/
		/*
		**	método que edita o nome do arquivo
		*/
		public function editarArquivo($id, $arquivo_nome) {
			
			$query = "UPDATE ".$this->tabela." SET ";
		  	$query .="arquivo='".$arquivo_nome."'";
		  	$query .= " WHERE id = ".$id;
			$result = mysql_query($query);
			
			return($result);
		}
		
		/*
		**	método que edita o nome da legenda
		*/
		public function editarLegenda() {
			$sql = "UPDATE ".$this->tabela." SET
					legenda	= '".$this->getLegenda()."'
			WHERE id='".$this->getId()."'";
			if(mysql_query($sql)) {
				return(true);
			} 
			
			return(false);
		}
		
		/*
		**	método que retorna o numero de linhas totais
		*/
		public function numRows($extra='') {
			
			$query = "SELECT * FROM ".$this->tabela." ".$extra;
			$result = mysql_query($query);
			$num_rows = mysql_num_rows($result);
			
			return($num_rows);
		}
		
		/*
		**	[INSERIR]
		*/
		/*
		**	método que insere um registro
		*/
		public function inserir() {
			
			$query = "INSERT INTO s72_imagem (id_modulo, id_modulo_item, legenda, caminho) VALUES ('".$this->id_modulo."', '".$this->id_modulo_item."', '".$this->legenda."', 'img/".$this->caminho."/')";
			$result = mysql_query($query);
			return($result);
		}
		
		/*
		**	[DELETAR]
		*/
		/*
		**	método que deleta um registro
		*/
		public function deletar($id) {
			
			$query = "DELETE FROM ".$this->tabela." WHERE id=".$id;
			$result = mysql_query($query);
			return($result);
		}
		/*
		**	método que deleta todos os Registro na tabela de imagens desse modulo do item selecionado
		*/
		public function deletarTodas($extra="") {
			$sql = "DELETE FROM ".$this->tabela." ".$extra;
			if(mysql_query($sql)) {
				return(true);
			} 
			return(false);
		}
		
		
	} // fim da classe
?>