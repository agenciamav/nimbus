<?php		
	class S72_Arquivo {
		private $_id;				
		private $_id_modulo;										//  todos arquivos estão relacionados a um módulo do sistema s72_modulo.
		private $_id_modulo_item;									//  item do módulo.			
		private $_ext;												//  extensao do arquivo
		private $_ext_permitidas = 0;								//  extensoes permitidas para o upload
		private $_ext_nao_permitidas;								//  extensoes nao permitidas para o upload
		private $_caminho;											//  caminho do arquivo
		private $_tamanho;											//  tamanho do arquivo
		private $_tamanho_maximo;									//  tamanho máximo permitido ao upload
		private $_legenda;											//  legenda do arquivo
		private $_legenda_flag = 1;									//  se o arquivo tem legenda ou nao.
		private $_arquivo;											//  arquivo temporario para upload.
		private $_msg_erro;											//  mensagem de erro
		private $_data;												//  data
		private $_arquivo_nome;										//  nome do arquivo
		private $_maximo_arquivos;									//  máximo de arquivos
		private $_modulo_nome;										//  nome do módulo de uploads
		
		
		
		public function __construct() {
			$this->setAtributos(null,null,null,null,null,null,null,null,$_legenda_flag,null,null,null,999,'Upload de Arquivos');
		}
		
		public function setAtributos($id, $id_modulo, $id_modulo_item, $ext, $caminho, $tamanho, $tamanho_maximo, $legenda, $legenda_flag, $arquivo, $data, $arquivo_nome, $maximo_arquivos, $modulo_nome) {
			$this->_id = $id;
			$this->_id_modulo = $id_modulo;
			$this->_id_modulo_item = $id_modulo_item;
			$this->_ext = $ext;
			$this->_caminho = $caminho;
			$this->_tamanho = $tamanho;
			$this->_tamanho_maximo = $tamanho_maximo;
			$this->_legenda = $legenda;
			$this->_legenda_flag = $legenda_flag;
			$this->_arquivo = $arquivo;
			$this->_data = $data;
			$this->_arquivo_nome = $arquivo_nome;
			$this->_maximo_arquivos = $maximo_arquivos;
			$this->_modulo_nome = $modulo_nome;
		}
		
		/*
		**	SET
		*/
				
		public function setMaximoArquivos($maximo_arquivos) {
			$this->_maximo_arquivos = $maximo_arquivos;
		}
		
		public function setModuloNome($modulo_nome) {
			$this->_modulo_nome = $modulo_nome;
		}
		
		public function setArquivo($arquivo) {
			$this->_arquivo = $arquivo;
		}
		
		public function setArquivoNome($arquivo_nome) {
			$this->_arquivo_nome = $arquivo_nome;
		}
		
		public function setId($id) {
			$this->_id = $id;
		}
		
		public function setIdModulo($id_modulo) {
			$this->_id_modulo = $id_modulo;
		}
		
		public function setIdModuloItem($id_modulo_item) {
			$this->_id_modulo_item = $id_modulo_item;
		}
		
		public function setExt($ext) {
			$this->_ext = $ext;
		}
		
		public function setExtPermitidas($ext_permitidas) {
			$this->_ext_permitidas = $ext_permitidas; // array
		}
		
		public function setCaminho($caminho) {
			$this->_caminho = $caminho;
		}
		
		public function setTamanho($tamanho) {
			$this->_tamanho = $tamanho;
		}
		
		public function setTamanhoMaximo($tamanho_maximo) {
			$this->_tamanho_maximo = $tamanho_maximo;
		}
		
		public function setLegenda($legenda) {
			$this->_legenda = $legenda;
		}
		
		public function setLegendaFlag($legenda_flag) {
			$this->_legenda_flag = $legenda_flag;
		}
		
		public function setMsgErro($msg_erro) {
			$this->_msg_erro = $msg_erro;
		}
		
		public function setData($data) {
			$this->_data = $data;
		}
		
		
		/*
		**	GET
		*/
		
		public function getNumRowsPorItem($id_modulo_item) {
			
			$query = "SELECT * FROM s72_arquivo WHERE id_modulo=".$this->_id_modulo." AND id_modulo_item=".$id_modulo_item;
			$result = mysql_query($query);
			$rows = mysql_num_rows($result);
			//echo $query."!".$rows;
			return($rows);
		}
		
		public function getMaximoArquivos() {
			return $this->_maximo_arquivos;
		}
		
		public function getModuloNome() {
			return $this->_modulo_nome;
		}
		
		public function getArquivo() {
			return $this->_arquivo;
		}
		
		public function getArquivoNome() {
			return $this->_arquivo_nome;
		}
		
		public function getId() {
			return $this->_id;
		}
		
		public function getIdModulo() {
			return $this->_id_modulo;
		}
		
		public function getIdModuloItem() {
			return $this->_id_modulo_item;
		}
		
		public function getExt() {
			return $this->_ext;
		}
		
		public function getExtPermitidas() {
			return $this->_ext_permitidas;
		}
		
		public function getCaminho() {
			return $this->_caminho;
		}
		
		public function getTamanho() {
			return $this->_tamanho;
		}
		
		public function getTamanhoMb() {
			
			$bytes = $this->_tamanho;
			$precision = 2;
			$kilobyte = 1024;
			$megabyte = $kilobyte * 1024;
			$gigabyte = $megabyte * 1024;
			$terabyte = $gigabyte * 1024;
		   
			if (($bytes >= 0) && ($bytes < $kilobyte)) {
				return $bytes . ' B';
		 
			} elseif (($bytes >= $kilobyte) && ($bytes < $megabyte)) {
				return round($bytes / $kilobyte, $precision) . ' KB';
		 
			} elseif (($bytes >= $megabyte) && ($bytes < $gigabyte)) {
				return round($bytes / $megabyte, $precision) . ' MB';
		 
			} elseif (($bytes >= $gigabyte) && ($bytes < $terabyte)) {
				return round($bytes / $gigabyte, $precision) . ' GB';
		 
			} elseif ($bytes >= $terabyte) {
				return round($bytes / $gigabyte, $precision) . ' TB';
			} else {
				return $bytes . ' B';
			}
		}
		
		public function getTamanhoMaximo() {
			return $this->_tamanho_maximo;
		}
		
		public function getTamanhoMaximoMb() {
			return number_format((($this->_tamanho_maximo/1024)/1024),2);
		}
		
		public function getLegenda() {
			return $this->_legenda;
		}
		
		public function getLegendaFlag() {
			return $this->_legenda_flag;
		}
		
		public function getNovoCaminho() {
			return '../'.$this->_caminho.$this->_arquivo_nome;
		}
		
		public function getNovoCaminho2() {
			return '../'.$this->_caminho.$this->_arquivo_nome.'_'.$this->_id.'.'.$this->_ext;
		}
		
		public function getNovoCaminhoAjax() {
			return '../../'.$this->_caminho.$this->_arquivo_nome;
		}
		
		public function getMsgErro() {
			return $this->_msg_erro;
		}
		
		public function getData() {
			return $this->_data;
		}
		
		/*
		** GENERICAS
		*/
		
		// verificar se o caminho para salvar o arquivo existe.
		private function verificarCaminho(){
			 if(!file_exists('../'.$this->_caminho)) {
				throw new Exception( 'O caminho "../'.$this->_caminho.'" nao existe, crie a pasta no local que voce esta tentando salvar.' );
			 }
		}
		
		
		// alterar a permissão de uma pasta.
		// OBS: caso o servidor não permita a alteração de permissão, habilitar manualmente (no servidor) e comentar TODAS chamadas dessa função.
		private function alterarPermissaoPasta($codigo_permissao){
			if(!chmod('../'.$this->_caminho, $codigo_permissao)){
				throw new Exception( 'Impossivel trocar a permissao da pasta.');
			}
		}
		
		// apagar um arquivo
		private function apagarArquivo(){
			if(!unlink($this->getNovoCaminho())){
				trigger_error('Impossivel apagar o arquivo em:'.$this->getNovoCaminho(), E_USER_WARNING);
			}
		}

		// apagar um arquivo
		private function apagarArquivoAjax(){
			if(!unlink($this->getNovoCaminhoAjax())){
				trigger_error('Impossivel apagar o arquivo em:'.$this->getNovoCaminho(), E_USER_WARNING);
			}
		}
		
		//verificar extensoes permitidas e as não permitidas.
		public function verificarExtensao(){
			
			$this->_ext_nao_permitidas = array('exe', 'bat', 'src', 'ini', 'bin', 'sys', 'dat', 'dll', 'pif', 'com', 'cmd', 'vbs', 'vbe', 'shs', 'js');
						
			if( !in_array($this->_ext,$this->_ext_nao_permitidas) ){
				
				
				if( $this->_ext_permitidas && !in_array($this->_ext,$this->_ext_permitidas) ){
					$this->setMsgErro("Essa extens&atilde;o n&atilde;o &eacute; permitida:".$this->_ext);
					return false;
				}
				return true;
			} else{
				$this->setMsgErro("Essa extens&atilde;o n&atilde;o &eacute; permitida:".$this->_ext);
				return false;
			}
		}
		
		
		// verificar tamanho máximo permitido para upload
		public function verificarTamanhoMaximo(){
			
			if($this->_tamanho > $this->_tamanho_maximo){
				$this->setMsgErro("O Tamanho m&aacute;ximo para envio de arquivos foi ultrapassado.<br />Limite:".$this->getTamanhoMaximoMb()." Mb");
				return false;
			}
			
			return true;
		}
		
		/*
		** INSERIR
		*/
		
		public function inserir(){
			
			$this->verificarCaminho();
		//	$this->alterarPermissaoPasta(0777);	
			$this->verificarTamanhoMaximo();
			
			$query = "INSERT INTO s72_arquivo (id_modulo, id_modulo_item, ext, caminho, tamanho, legenda, data) VALUES ('".$this->_id_modulo."', '".$this->_id_modulo_item."', '".$this->_ext."', '".$this->_caminho."', '".$this->_tamanho."', '".$this->_legenda."', '".$this->_data."')";
			if(!$result = mysql_query($query)){
				throw new Exception('Nao foi possivel inserir na tabela s72_arquivo : '.mysql_error().$query);
			}
			
			$this->setId(mysql_insert_id());
			
			if(!move_uploaded_file($this->getArquivo(),$this->getNovoCaminho2())){
				throw new Exception('Nao foi possivel realizar o upload do arquivo.');
			}

			//$this->alterarPermissaoPasta(0755);	
		}

		public function inserirLink(){

			$query = "INSERT INTO s72_arquivo (id_modulo, id_modulo_item, ext, caminho, tamanho, legenda, data) VALUES ('".$this->_id_modulo."', '".$this->_id_modulo_item."', '".$this->_ext."', '".$this->_caminho."', '".$this->_tamanho."', '".$this->_legenda."', '".$this->_data."')";
			$result = mysql_query($query);

			return($result);

		}
		
		public function editarArquivo($id, $arquivo_nome) {
			
			$query = "UPDATE s72_arquivo SET ";
		  	$query .="arquivo_nome='".$arquivo_nome."'";
		  	$query .= " WHERE id = ".$id;
			$result = mysql_query($query);
			
			return($result);
		}
		
		/*
		**	método que edita o nome da legenda
		*/
		public function editarLegenda() {
			$sql = "UPDATE s72_arquivo SET
					legenda	= '".$this->getLegenda()."'
			WHERE id='".$this->getId()."'";
			if(mysql_query($sql)) {
				return(true);
			} 
			
			return(false);
		}
		
		/*
		** DELETAR
		*/
		
		public function deletar(){
			
			$result = $this->listarPorId($this->_id);
			$row = mysql_fetch_object($result);
			
			if (substr($row->caminho, 0, 4) == 'img/'){
				$this->setExt($row->ext);
				$this->setCaminho($row->caminho);
				$this->setArquivoNome($row->arquivo_nome);
				$this->setIdModuloItem($row->id_modulo_item);
			//	$this->alterarPermissaoPasta(0777);	
				$this->apagarArquivo();
				$this->alterarPermissaoPasta(0755);	
			}
			
			$query = "DELETE FROM s72_arquivo WHERE id=".$this->_id;
			$result = mysql_query($query);
			
			if(!$result = mysql_query($query)){
				throw new Exception('Nao foi possivel deletar na tabela s72_arquivo : '.mysql_error().$query);
			}
		}
		
		public function deletarArquivo(){
			
			$result = $this->listarPorId($this->_id);
			$row = mysql_fetch_object($result);
			
			$this->setExt($row->ext);
			$this->setCaminho($row->caminho);
			$this->setArquivoNome($row->arquivo_nome);
			$this->setIdModuloItem($row->id_modulo_item);
			$this->apagarArquivoAjax();
			
			$query = "DELETE FROM s72_arquivo WHERE id=".$this->_id;
			$result = mysql_query($query);
			
			if(!$result = mysql_query($query)){
				throw new Exception('Nao foi possivel deletar na tabela s72_arquivo : '.mysql_error().$query);
			}
		}
		
		/*
		** LISTAR
		*/
		
		public function listarPorId($id) {
			
			$query = "SELECT * FROM s72_arquivo WHERE id=".$id;
			$result = mysql_query($query);
			$num_rows = mysql_num_rows($result);
			
			if($num_rows > 0){
				return($result);
			}
			else {
				return(false);
			}
		}
		
		public function listarPorItem($id_modulo_item, $extra="") {
			
			$query = "SELECT * FROM s72_arquivo WHERE id_modulo=".$this->_id_modulo." AND id_modulo_item=".$id_modulo_item." ".$extra;
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
		
		public function listarPorItemLista($id_modulo, $id_modulo_item, $caminho) {
			
			$query = "SELECT * FROM s72_arquivo WHERE id_modulo=".$id_modulo." AND id_modulo_item=".$id_modulo_item." AND caminho = '".$caminho."' ";
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
		
		
		public function listarTodas($extra='') {
			
			$query = "SELECT * FROM s72_arquivo ".$extra;
			$result = mysql_query($query);
			$num_rows = mysql_num_rows($result);
			
			if($num_rows > 0){
				return($result);
			}
			else {
				return(false);
			}
		}

	} // fim da classe
?>