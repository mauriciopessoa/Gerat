<?php
class Banco_contaVO
{
	private $codigo = null;
	private $agencia = null;
	private $numero = null;
	private $saldo = null;
	public function Banco_contaVO( $codigo=null, $agencia=null, $numero=null, $saldo=null )
	{
		$this->setCodigo( $codigo );
		$this->setAgencia( $agencia );
		$this->setNumero( $numero );
		$this->setSaldo( $saldo );
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
	function setAgencia( $strNewValue = null )
	{
		$this->agencia = $strNewValue;
	}
	function getAgencia()
	{
		return $this->agencia;
	}
	//--------------------------------------------------------------------------------
	function setNumero( $strNewValue = null )
	{
		$this->numero = $strNewValue;
	}
	function getNumero()
	{
		return $this->numero;
	}
	//--------------------------------------------------------------------------------
	function setSaldo( $strNewValue = null )
	{
		$this->saldo = $strNewValue;
	}
	function getSaldo()
	{
		return $this->saldo;
	}
	//--------------------------------------------------------------------------------
}
?>