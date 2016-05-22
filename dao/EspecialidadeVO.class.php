<?php
class EspecialidadeVO
{
	private $codigo = null;
	private $descricao = null;
	public function EspecialidadeVO( $codigo=null, $descricao=null )
	{
		$this->setCodigo( $codigo );
		$this->setDescricao( $descricao );
	}
	//--------------------------------------------------------------------------------
	function setCodigo( $strNewValue = null )
	{
		$this->codigo = $strNewValue;
	}
	function getCodigo()
	{
		return $this->codigo;
	}
	//--------------------------------------------------------------------------------
	function setDescricao( $strNewValue = null )
	{
		$this->descricao = $strNewValue;
	}
	function getDescricao()
	{
		return $this->descricao;
	}
	//--------------------------------------------------------------------------------
}
?>