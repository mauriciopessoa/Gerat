<?php
class Banco_agenciaVO
{
	private $codigo = null;
	private $banco = null;
	private $numero = null;
	private $endereco = null;
	private $cidade = null;
	private $uf = null;
	private $situacao = null;
	public function Banco_agenciaVO( $codigo=null, $banco=null, $numero=null, $endereco=null, $cidade=null, $uf=null, $situacao=null )
	{
		$this->setCodigo( $codigo );
		$this->setBanco( $banco );
		$this->setNumero( $numero );
		$this->setEndereco( $endereco );
		$this->setCidade( $cidade );
		$this->setUf( $uf );
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
	function setBanco( $strNewValue = null )
	{
		$this->banco = $strNewValue;
	}
	function getBanco()
	{
		return $this->banco;
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
	function setEndereco( $strNewValue = null )
	{
		$this->endereco = $strNewValue;
	}
	function getEndereco()
	{
		return $this->endereco;
	}
	//--------------------------------------------------------------------------------
	function setCidade( $strNewValue = null )
	{
		$this->cidade = $strNewValue;
	}
	function getCidade()
	{
		return $this->cidade;
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