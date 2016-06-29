<?php
class CartaoVO
{
	private $codigo = null;
	private $nome = null;
	private $prazo_pagto = null;
	private $banco_conta = null;
	private $situacao = null;
	public function CartaoVO( $codigo=null, $nome=null, $prazo_pagto=null, $banco_conta=null, $situacao=null )
	{
		$this->setCodigo( $codigo );
		$this->setNome( $nome );
		$this->setPrazo_pagto( $prazo_pagto );
		$this->setBanco_conta( $banco_conta );
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
	function setPrazo_pagto( $strNewValue = null )
	{
		$this->prazo_pagto = $strNewValue;
	}
	function getPrazo_pagto()
	{
		return $this->prazo_pagto;
	}
	//--------------------------------------------------------------------------------
	function setBanco_conta( $strNewValue = null )
	{
		$this->banco_conta = $strNewValue;
	}
	function getBanco_conta()
	{
		return $this->banco_conta;
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