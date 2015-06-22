<?php
	class Usuario{
		
		private $tabela;
		private $campo_busca;
		
		private $id;
		private $nome;
		private $login;
		private $senha;
		private $permissoes;
		private $administrador;
		private $template;
		private $moduloDescricao;
		private $moduloId;

		
		public function __construct($id="",$nome="",$login="",$senha="",$permissoes="",$template="") {
			
			$this->id 		= $id;
			$this->nome 	= $nome;
			$this->login 	= $login;
			if(!empty($senha)){
				$this->senha = md5($senha);
			}
			$this->permissoes = $permissoes;
			$this->template = $template;
			$this->tabela 	= 's72_usuario';
			$this->campo_busca = array('nome', 'login');
		}
		
		// METODOS GETS
		public function getId() {
			return $this->id;
		}
	
		public function getNome() {
			return $this->nome;
		}
	
		public function getLogin() {
			return $this->login;
		}
	
		public function getSenha() {
			return $this->senha;
		}
	
		public function getPermissoes() {
			return $this->permissoes;
		}
	
		public function getModuloId() {
			return $this->moduloId;
		}
		
		public function getModuloDescricao() {
			return $this->moduloDescricao;
		}
		
		public function getTemplate() {
			return $this->template;
		}

		public function getAcaoAdicionar() {
			return $this->acaoAdicionar;
		}

		public function getAcaoEditar() {
			return $this->acaoEditar;
		}

		public function getAcaoEditarTrue() {
			return $this->acaoEditarTrue;
		}

		public function getAcaoExcluir() {
			return $this->acaoExcluir;
		}

		public function getAcaoExcluirInput() {
			return $this->acaoExcluirInput;
		}

		
		// METODOS SETS
		public function setId($id) {
			$this->id = $id;
		}
	
		public function setNome($nome) {
			$this->nome = $nome;
		}
	
		public function setLogin($login) {
			$this->login = $login;
		}
	
		public function setSenha($senha) {
			$this->senha = $senha;
		}
	
		public function setPermissoes($permissoes) {
			$this->permissoes = $permissoes;
		}
		
		public function setTemplate($template) {
			$this->template = $template;
		}
		
		/*
		**	[SELECT]
		*/
		/*
		** método que faz o login do usuário no sistema
		*/
		public function login($login, $senha){
			
			$sqlUsuario = 'SELECT id, nome, administrador FROM '.$this->tabela.' WHERE login  = "'.$login.'" AND senha = "'.md5($senha).'"';
			$resUsuario = mysql_query($sqlUsuario);
			$numUsuario = mysql_num_rows($resUsuario);
			$rowUsuario = mysql_fetch_array($resUsuario);
			
			if($numUsuario){
				
				$_SESSION['CONTROLE'] = 'CONTROLE';
				$_SESSION['ADMINISTRADOR'] = $rowUsuario['administrador'];
				$_SESSION['NOME'] = $rowUsuario['nome'];
				$_SESSION['LOGIN'] = $login;
				$_SESSION['ID'] = $rowUsuario['id'];
				$_SESSION['MENSAGEM'] = '';
				$_SESSION['ICONE'] = '';
				
				
				$sql_acesso = 'SELECT COUNT(id) AS contagem FROM s72_usuario_log WHERE nome = "'.$_SESSION['NOME'].'"';
				$res_acesso = mysql_query($sql_acesso);
				$row_acesso = mysql_fetch_array($res_acesso);
				$_SESSION['QTD_ACESSO'] = $row_acesso['contagem'];

				$sql_acesso = 'SELECT data FROM s72_usuario_log WHERE nome = "'.$_SESSION['NOME'].'" ORDER BY id DESC LIMIT 1';
				$res_acesso = mysql_query($sql_acesso);
				$row_acesso = mysql_fetch_array($res_acesso);
				$_SESSION['ULT_ACESSO'] = $row_acesso['data'];
				
				$sqlLog = 'INSERT INTO s72_usuario_log (nome, data) VALUES("'.$rowUsuario['nome'].'", CURRENT_TIMESTAMP())';
				$resLog = mysql_query($sqlLog);
		
				die(header('location: admin.php'));
			}else{
				$_SESSION['CONTROLE'] = '';
				$_SESSION['ADMINISTRADOR'] = '';
				$_SESSION['NOME'] = '';
				$_SESSION['LOGIN'] = '';
				$_SESSION['ID'] = 1;
				$_SESSION['MENSAGEM'] = 'Usu&aacute;rio ou senha incorretos!';
				$_SESSION['ICONE'] = 'alert';

				die(header('location: index.php'));				
			}
		}
		
		/*
		** método que verifica se o usuário está logado no sistema
		*/
		public function verificarLogin(){
			
			if(!isset($_SESSION['CONTROLE']) || $_SESSION['CONTROLE'] != 'CONTROLE'){
				session_unset();
				session_destroy();
				die(header('location: index.php'));
			}
			
			if($_SESSION['ADMINISTRADOR']){
				# coloca permissao total para o administrador.
				$sql = "SELECT id FROM s72_modulo WHERE ativo='S'";
				$res = mysql_query($sql);
				$rows = mysql_num_rows($res);
				
				if($rows > 0){
					while($row = mysql_fetch_array($res)){
						$array[] .= $row['id'];
					}
					$this->permissoes = implode(",",$array);
				}
				
				$sql = "SELECT id FROM s72_modulo WHERE ativo='S' AND id NOT IN (1,2,3,4,5)";
				$res = mysql_query($sql);
				$rows = mysql_num_rows($res);
				if($rows > 0){
					while ($row = mysql_fetch_array($res)){
						$acaoAdicionar .= $row['id'].'_1,';
						$acaoEditar .= $row['id'].'_2,';
						$acaoExcluir .= $row['id'].'_3,';
					}
					$permissaoUsuarioAcao = $acaoAdicionar.$acaoEditar.$acaoExcluir;
				}
				
			} else{
				# seta a permissao de acordo com as permissoes do s72_usuario selecionado.
				$sqlUsuario = 'SELECT permissoes FROM '.$this->tabela.' WHERE id = "'.$_SESSION['ID'].'"';
				$resUsuario = mysql_query($sqlUsuario);
				$usuario = mysql_fetch_array($resUsuario);
				$this->permissoes = '1,2,'.$usuario['permissoes'];

				# seta a permissao das ações setadas no usuario (Adicionar, Editar, Excluir)
				$sqlUsuarioAcao = 'SELECT * FROM s72_usuario_acao WHERE id_usuario = "'.$_SESSION['ID'].'"';
				$resUsuarioAcao = mysql_query($sqlUsuarioAcao);
				while($usuarioAcao = mysql_fetch_array($resUsuarioAcao)){
					$permissaoUsuarioAcao .= $usuarioAcao['id_modulo'].'_'.$usuarioAcao['id_acao'].',';
				}
			}
			$_SESSION['PERMISSOES-ACAO'] = substr($permissaoUsuarioAcao, 0, -1);
			$_SESSION['PERMISSOES'] = $this->permissoes;
		}
		
		/*
		** método que verifica se o usuário está logado no sistema
		*/
		public function verificarTemplate(){
			
			# coloca permissao total para o administrador.
			if (isset($_SESSION['ID'])){
				$idTemp = $_SESSION['ID'];
			} else {
				$idTemp = 1;
			}
			$sql = "SELECT template FROM ".$this->tabela." WHERE id = ".$idTemp;
			$res = mysql_query($sql);
			$row = mysql_fetch_array($res);
			$num_row = mysql_num_rows($res);
			
			$this->template = 'azul'; // default
			
			if ( ($num_row == 1) && (!empty($row['template'])) ){
				$this->template = $row['template'];
			}
		}
		
		/*
		** método que mostra os modulos
		*/
		public function mostrarModulo($modulo){
			
			$sql = 'SELECT * FROM s72_modulo WHERE modulo = "' . $modulo . '" AND id IN (' . $_SESSION['PERMISSOES'] . ')';			
			if($res = mysql_query($sql)){
				$acessoModulo = mysql_fetch_array($res);
				$this->moduloId = $acessoModulo['id'];
				$this->moduloDescricao = $acessoModulo['descricao'];
				
				$permissaoAcao = explode(',', $_SESSION['PERMISSOES-ACAO']);
				$this->acaoEditar = '<img src="img/ico-visualizar.png">';
				foreach($permissaoAcao as $acoes){
					
					if ($acoes == $acessoModulo['id'].'_1'){
						$this->acaoAdicionar = '<img src="img/ico-adicionar.png">';
						//$this->acaoEditarTrue = true;
					} elseif ($acoes == $acessoModulo['id'].'_2'){
						$this->acaoEditar = '<img src="img/ico-editar.png">';
						$this->acaoEditarTrue = '<a href="admin.php?modulo='.$acessoModulo['modulo'].'&acao=formulario&id=';
					} elseif ($acoes == $acessoModulo['id'].'_3'){
						$this->acaoExcluir = '<input title="Excluir '.ucfirst($acessoModulo['descricao']).'" onclick="show_alert()" style="float:right; cursor:pointer;" type="image" name="image" src="img/ico-excluir.png" />';
						$this->acaoExcluirInput = true;
					}
				}
				
			} else{
				$this->negarAcesso($modulo);
			}
		}
		
		public function negarAcesso($modulo){
			
			$_SESSION['MENSAGEM'] = 'Voc&ecirc; n&atilde;o tem acesso para a p&aacute;gina que tentou. Em caso de d&uacute;vida, contate o administrador do sistema.';
			$_SESSION['ICONE'] = 'alert';
			header("Location: admin.php");
		}
		
		/*
		** método que faz logout no sistema
		*/
		public function logout(){
			session_unset();
			session_destroy();
			die(header('Location: index.php'));
		}
		
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
			
			$query = "SELECT * FROM ".$this->tabela." WHERE administrador = 0 ".$likeBusca." ".$extra;
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
		**	método que lista todos Registro ou com filtro passando @busca
		*/
		public function listarIntra($busca='', $extra='') {
			
			if(!empty($busca)) {
				foreach($this->campo_busca as $campo){
					$likeBusca .= $campo." LIKE '%".$busca."%' OR ";
				}
				$likeBusca = 'AND ('.substr($likeBusca, 0, -4).')';
			} 
			
			$query = "SELECT * FROM ".$this->tabela." WHERE administrador = 0 AND id > 15 ".$likeBusca." ".$extra;
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
		public function listarTodos($extra='') {
			
			$query = "SELECT * FROM ".$this->tabela." WHERE id NOT IN (1) ".$extra;
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
			
			$query = "SELECT * FROM ".$this->tabela." WHERE administrador = 0 ".$likeBusca." ".$extra;
			$result = mysql_query($query);
			$num_rows = mysql_num_rows($result);
			
			return($num_rows);
		}

		/*
		** método que retorna os modulos selecionados
		*/
		public function getCheckboxModulos($name, $itens, $idUsuario, $usuarioConsulta, $class="inputCheckbox") {
			
			$arrayItens = explode(",", $itens);
			
			foreach ($arrayItens as $item) {
				$itemSelecionado[$item] = "checked='checked'";
			}
			
			$query = "SELECT * FROM s72_modulo WHERE ativo='S' AND id NOT IN (1,2,3,4,5) ORDER BY id_menu, descricao";
			$result = mysql_query($query);
			
			while($row = mysql_fetch_array($result)){
				
				$sqlMenuPrincipal = "SELECT * FROM s72_menu WHERE id = ".$row['id_menu'];
				$resultMenuPrincipal = mysql_query($sqlMenuPrincipal);
				$rowMenuPrincipal = mysql_fetch_array($resultMenuPrincipal);
				
				if($usuarioConsulta === true){
					if($queryAcao = "SELECT * FROM s72_usuario_acao WHERE id_modulo = ".$row['id']." AND id_acao = 1 AND id_usuario = ".$idUsuario){
						$resultAcao = mysql_query($queryAcao);
						$checked1 = '';
						if($rowAcao = mysql_fetch_array($resultAcao)){
							$checked1 = 'checked="checked"';
						}	
					}
					if($queryAcao2 = "SELECT * FROM s72_usuario_acao WHERE id_modulo = ".$row['id']." AND id_acao = 2 AND id_usuario = ".$idUsuario){
						$resultAcao2 = mysql_query($queryAcao2);
						$checked2 = '';
						if($rowAcao2 = mysql_fetch_array($resultAcao2)){
							$checked2 = 'checked="checked"';
						}	
					}
					if($queryAcao3 = "SELECT * FROM s72_usuario_acao WHERE id_modulo = ".$row['id']." AND id_acao = 3 AND id_usuario = ".$idUsuario){
						$resultAcao3 = mysql_query($queryAcao3);
						$checked3 = '';
						if($rowAcao3 = mysql_fetch_array($resultAcao3)){
							$checked3 = 'checked="checked"';
						}	
					}
				}
				
				$html  .= "
				<ul class='borda'>
					<li><input type='checkbox' class='".$class."' name='".$name."[]' id='".$name."_".$row['id']."' value='".$row['id']."' ".$itemSelecionado[$row['id']]." ><strong>".$rowMenuPrincipal['nome'].' &rarr; '.$row['descricao']."</strong></li>
					<li class='acao'><input type='checkbox' rel='".$row['id']."' class='marcar1_".$row['id']." marcaEdicao' ".$checked1." name='acaoUser[]' id='acaoUser_".$row['id']."' value='".$row['id']."_1'>&nbsp;Adicionar</li>
					<li class='acao'><input type='checkbox' rel='".$row['id']."' class='marcar2_".$row['id']." marcaModuloEditar' ".$checked2." name='acaoUser[]' id='acaoUser_".$row['id']."' value='".$row['id']."_2'>&nbsp;Editar</li>
					<li class='acao'><input type='checkbox' rel='".$row['id']."' class='marcar3_".$row['id']." marcaModuloExcluir' ".$checked3." name='acaoUser[]' id='acaoUser_".$row['id']."' value='".$row['id']."_3'>&nbsp;Excluir</li>
				</ul>
				";
			}

			return($html);
		}
		/*
		** método que retorna os modulos selecionados intranet bg
		*/
		public function getCheckboxModulosIntra($name, $itens, $idUsuario, $usuarioConsulta, $class="inputCheckbox") {
			
			$arrayItens = explode(",", $itens);
			
			foreach ($arrayItens as $item) {
				$itemSelecionado[$item] = "checked='checked'";
			}
			
			$query = "SELECT * FROM s72_modulo WHERE ativo='S' AND id NOT IN (1,2,3,4,5,6,7,8,9,12) ORDER BY id_menu, descricao";
			$result = mysql_query($query);
			
			while($row = mysql_fetch_array($result)){
				
				$sqlMenuPrincipal = "SELECT * FROM s72_menu WHERE id = ".$row['id_menu'];
				$resultMenuPrincipal = mysql_query($sqlMenuPrincipal);
				$rowMenuPrincipal = mysql_fetch_array($resultMenuPrincipal);
				
				if($usuarioConsulta === true){
					if($queryAcao = "SELECT * FROM s72_usuario_acao WHERE id_modulo = ".$row['id']." AND id_acao = 1 AND id_usuario = ".$idUsuario){
						$resultAcao = mysql_query($queryAcao);
						$checked1 = '';
						if($rowAcao = mysql_fetch_array($resultAcao)){
							$checked1 = 'checked="checked"';
						}	
					}
					if($queryAcao2 = "SELECT * FROM s72_usuario_acao WHERE id_modulo = ".$row['id']." AND id_acao = 2 AND id_usuario = ".$idUsuario){
						$resultAcao2 = mysql_query($queryAcao2);
						$checked2 = '';
						if($rowAcao2 = mysql_fetch_array($resultAcao2)){
							$checked2 = 'checked="checked"';
						}	
					}
					if($queryAcao3 = "SELECT * FROM s72_usuario_acao WHERE id_modulo = ".$row['id']." AND id_acao = 3 AND id_usuario = ".$idUsuario){
						$resultAcao3 = mysql_query($queryAcao3);
						$checked3 = '';
						if($rowAcao3 = mysql_fetch_array($resultAcao3)){
							$checked3 = 'checked="checked"';
						}	
					}
				}
				
				$html  .= "
				<ul class='borda'>
					<li><input type='checkbox' class='".$class."' name='".$name."[]' id='".$name."_".$row['id']."' value='".$row['id']."' ".$itemSelecionado[$row['id']]." ><strong>".$rowMenuPrincipal['nome'].' &rarr; '.$row['descricao']."</strong></li>
					<li class='acao'><input type='checkbox' rel='".$row['id']."' class='marcar1_".$row['id']." marcaEdicao' ".$checked1." name='acaoUser[]' id='acaoUser_".$row['id']."' value='".$row['id']."_1'>&nbsp;Adicionar</li>
					<li class='acao'><input type='checkbox' rel='".$row['id']."' class='marcar2_".$row['id']." marcaModuloEditar' ".$checked2." name='acaoUser[]' id='acaoUser_".$row['id']."' value='".$row['id']."_2'>&nbsp;Editar</li>
					<li class='acao'><input type='checkbox' rel='".$row['id']."' class='marcar3_".$row['id']." marcaModuloExcluir' ".$checked3." name='acaoUser[]' id='acaoUser_".$row['id']."' value='".$row['id']."_3'>&nbsp;Excluir</li>
				</ul>
				";
			}

			return($html);
		}

		/*
		**	método lista todos registros do modulo em questao
		*/
		public function listarEmail($extra='') {
			
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
		**	[INSERIR]
		*/
		/*
		**	método que insere Registro 
		*/
		public function inserir() {
			
			$dados  = "'',";
			$dados .= "'".$this->getNome()."',";
			$dados .= "'".$this->getLogin()."',";
			$dados .= "'".$this->getSenha()."',";
			$dados .= "'".$this->getPermissoes()."',";
			$dados .= "'0',";
			$dados .= "'".$this->getTemplate()."'";
			$sql = "INSERT INTO ".$this->tabela." VALUES (".$dados.")";
			if(mysql_query($sql)) {
				return(true);
			}
			
			return(false);
		}
		
		/*
		** método que insere a ações de cada usuario
		*/
		public function inserirUsuarioAcao($acaoUser, $idUsuario) {
			
			$query = "DELETE FROM s72_usuario_acao WHERE id_usuario = ".$idUsuario;
			$result = mysql_query($query);
			
			foreach($acaoUser as $acaoUser2) {
				$acaoUser2 = explode('_', $acaoUser2);
				$query = "INSERT INTO s72_usuario_acao (id_modulo, id_acao, id_usuario) VALUES ('".$acaoUser2[0]."', '".$acaoUser2[1]."', '".$idUsuario."')";
				$result = mysql_query($query);
			}
			return($result);

		}

		/*
		**	[EDITAR]
		*/
		/*
		** método que troca a senha
		*/
		public function trocarSenha() {
			$sql = "UPDATE ".$this->tabela." SET
					senha	= '".$this->getSenha()."'
			WHERE id='".$this->getId()."'";
			
			if(mysql_query($sql)) {
				return(true);
			} 
			return(false);
		}
		
		/*
		**	método que edita Registro 
		*/
		public function editar() {
			$sql = "UPDATE ".$this->tabela." SET
					nome		= '".$this->getNome()."',
					login		= '".$this->getLogin()."',
					permissoes	= '".$this->getPermissoes()."'
			WHERE id='".$this->getId()."'";
			
			if(mysql_query($sql)) {
				return(true);
			} 
			
			return(false);
		}
		
		/*
		** método que edita todos itens
		*/
		public function editarConta() {
			$sql = "UPDATE ".$this->tabela." SET
					nome		= '".$this->getNome()."',
					login		= '".$this->getLogin()."',
					template	= '".$this->getTemplate()."'
			WHERE id='".$this->getId()."'";
			
			if(mysql_query($sql)) {
				return(true);
			} 
			return(false);
		}
		
		/*
		** método que troca o template
		*/
		public function trocarTemplate() {
			$sql = "UPDATE ".$this->tabela." SET
					template = '".$this->getTemplate()."'
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
