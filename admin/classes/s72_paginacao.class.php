<?php
	class paginacao{
		var $pagina;
		var $rows_por_pag;
		var $n_por_pag;
		var $com;
		var $max_pag;
		
		function paginacao($rowPorPag, $nPorPag){
			if(isset($_GET['pagina'])){
				$this->pagina = ($_GET['pagina'] < 1)?1:$_GET['pagina'];
			}else{
				$this->pagina = 1;
			}
			$this->rows_por_pag = $rowPorPag;
			$this->n_por_pag = $nPorPag;
		
			$this->com = ($this->pagina - 1) * $this->rows_por_pag;
		}
		
		function paginar($busca_pag){
			
			$res_rows = mysql_query("SELECT FOUND_ROWS() AS rows");
			$row_rows = mysql_fetch_array($res_rows);
			
			$num_max_db = $row_rows['rows'];
			$this->max_pag = ceil($num_max_db / $this->rows_por_pag);
			
			if($this->pagina > $this->max_pag){
				$this->pagina = $this->max_pag + 1;
				$nao_pag = 1;
			}
			
			$paginacao = '<table width="100%" cellspacing="0" cellpadding="0" class="paginacao">';
			$paginacao .= '  <tr>';
			if($this->max_pag > 1){
				// anterior
				$pagina_ant = $this->pagina - $this->n_por_pag;
				if($pagina_ant < 1){
					$pagina_ant = 1;
				}
				// posterior
				$n_pos = $this->pagina + $this->n_por_pag;
				if($n_pos > $this->max_pag){
					$n_pos = $this->max_pag;
				}
				$pagina_pos = $this->pagina + 1;
				
				//paginacao
				$paginacao .= '   <td width="44%">';
				
				if($this->pagina > 1){
					$paginacao .= '<a href="?'.$busca_pag.'pagina='.($this->pagina - 1).'"><span class="texto1">&#8249;</span> Página anterior</a>';
				}
				$paginacao .= '   </td>';
				$paginacao .= '   <td width="26%" align="left"><ul class="bloco-paginacao">';
				
				while($pagina_ant < $this->pagina){
					$paginacao .= '<li><a href="?'.$busca_pag.'pagina='.$pagina_ant.'">'.$pagina_ant.'</a></li>';
					$pagina_ant++;
				}
				
				$paginacao .= '<li><a class="texto1" href="?'.$busca_pag.'pagina='.$this->pagina.'">'.$this->pagina.'</a></li>';
				
				while($pagina_pos <= $n_pos){
					$paginacao .= '<li><a href="?'.$busca_pag.'pagina='.$pagina_pos.'">'.$pagina_pos.'</a></li>';
					$pagina_pos++;
				}
				
				$paginacao .= '   </ul></td>';
				$paginacao .= '   <td width="26%" align="right">';
				
				if($this->max_pag > $this->pagina){
					$paginacao .= '<a href="?'.$busca_pag.'pagina='.($this->pagina + 1).'">Próxima pagina <span class="texto1">&#8250;</span></a></div>';
				}
				$paginacao .= '   </td>';
			}else{
				if(empty($num_max_db)){
					$paginacao .= '<td class="erropag">Nenhum registro encontrado.</td>';
				}elseif(isset($nao_pag)){
					$paginacao .= '<td class="erropag">P&aacute;gina n&atilde;o existente.</td>';
				}else{
					$paginacao .= '<td>&nbsp;</td>';
				}	
			}
			$paginacao .= '  </tr>';
			$paginacao .= '</table>';
			return $paginacao;
		}
	}
?>