<?php
class BancoVO
{
	private $codigo = null;
	private $nome = null;
	private $codigo_bacen = null;
	private $situacao = null;
	public function BancoVO( $codigo=null, $nome=null, $codigo_bacen=null, $situacao=null )
	{
		$this->setCodigo( $codigo );
		$this->setNome( $nome );
		$this->setCodigo_bacen( $codigo_bacen );
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
	function setNome( $strNewValue = null )
	{
		$this->nome = $strNewValue;
	}
	function getNome()
	{
		return $this->nome;
	}
	//--------------------------------------------------------------------------------
	function setCodigo_bacen( $strNewValue = null )
	{
		$this->codigo_bacen = $strNewValue;
	}
	function getCodigo_bacen()
	{
		return $this->codigo_bacen;
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