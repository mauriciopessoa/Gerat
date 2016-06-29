<?php
class UfVO
{
	private $codigo = null;
	private $sigla = null;
	private $descricao = null;
	public function UfVO( $codigo=null, $sigla=null, $descricao=null )
	{
		$this->setCodigo( $codigo );
		$this->setSigla( $sigla );
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
	function setSigla( $strNewValue = null )
	{
		$this->sigla = $strNewValue;
	}
	function getSigla()
	{
		return $this->sigla;
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