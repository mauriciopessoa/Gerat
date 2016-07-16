<?php
class Conselho_ufVO
{
	private $codigo = null;
	private $conselho = null;
	private $uf = null;
	public function Conselho_ufVO( $codigo=null, $conselho=null, $uf=null )
	{
		$this->setCodigo( $codigo );
		$this->setConselho( $conselho );
		$this->setUf( $uf );
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
	function setConselho( $strNewValue = null )
	{
		$this->conselho = $strNewValue;
	}
	function getConselho()
	{
		return $this->conselho;
	}
	//--------------------------------------------------------------------------------
	function setUf( $strNewValue = null )
	{
		$this->uf = $strNewValue;
	}
	function getUf()
	{
		return $this->uf;
	}
	//--------------------------------------------------------------------------------
}
?>