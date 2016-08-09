<?php
class Subgrupo_financeiroVO
{
	private $codigo = null;
	private $descricao = null;
	private $grupo = null;
	private $situacao = null;
	public function Subgrupo_financeiroVO( $codigo=null, $descricao=null, $grupo=null, $situacao=null )
	{
		$this->setCodigo( $codigo );
		$this->setDescricao( $descricao );
		$this->setGrupo( $grupo );
		$this->setSituacao( $situacao );
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
	function setGrupo( $strNewValue = null )
	{
		$this->grupo = $strNewValue;
	}
	function getGrupo()
	{
		return $this->grupo;
	}
	//--------------------------------------------------------------------------------
	function setSituacao( $strNewValue = null )
	{
		$this->situacao = $strNewValue;
	}
	function getSituacao()
	{
		return $this->situacao;
	}
	//--------------------------------------------------------------------------------
}
?>