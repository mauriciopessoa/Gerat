<?php
class Subclasse_financeiraVO
{
	private $codigo = null;
	private $descricao = null;
	private $classe = null;
	private $situacao = null;
	public function Subclasse_financeiraVO( $codigo=null, $descricao=null, $classe=null, $situacao=null )
	{
		$this->setCodigo( $codigo );
		$this->setDescricao( $descricao );
		$this->setClasse( $classe );
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
	function setClasse( $strNewValue = null )
	{
		$this->classe = $strNewValue;
	}
	function getClasse()
	{
		return $this->classe;
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