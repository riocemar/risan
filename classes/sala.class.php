<?php
	//require_once("base.class.php");
	
	require_once(dirname(__FILE__)."/autoload.php");
	protegeArquivo(basename(__FILE__));
	
	
	class sala extends base{
		public function __construct($campos=array()){
			parent::__construct();
			$this->tabela = "sala";
			if (!isset($campos)):
				
				$this->campos_valores = array(
					"nome" => NULL,
					"numero" => NULL,
					"capacidade" => NULL,
					"ramal" => NULL,
					"localizacao" => NULL,
					"observacao" => NULL
				);
			else:
				$this->campos_valores = $campos;
			endif;
			$this->campospk = "id";
				
		}// construct
		
		
		public function existeRegistro($campo=NULL, $valor=NULL){
			if ($campo != NULL && $valor != NULL):
				is_numeric($valor)? $valor = $valor: $valor = "'".$valor."'";
				$this->extras_select = " WHERE $campo = $valor";
				$this->selecionaTudo($this);
				if ($this->linhasafetadas > 0):
					return TRUE;
				else:
					return FALSE;
				endif;
			else:
				$this->trataerro(__FILE__, __FUNCTION__, NULL, 'Faltam parâmetros para a função', TRUE);
				
			endif;
			
		}
	}
?>















