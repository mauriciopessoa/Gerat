<?php
class ImpostoVO
{
	private $codigo = null;
	private $nome = null;
	private $situacao = null;
	public function ImpostoVO( $codigo=null, $nome=null, $situacao=null )
	{
		$this->setCodigo( $codigo );
		$this->setNome( $nome );
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