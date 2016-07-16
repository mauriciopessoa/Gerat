<?php
class ConselhoVO
{
	private $codigo = null;
	private $sigla = null;
	private $descricao_conselho = null;
	public function ConselhoVO( $codigo=null, $sigla=null, $descricao_conselho=null )
	{
		$this->setCodigo( $codigo );
		$this->setSigla( $sigla );
		$this->setDescricao_conselho( $descricao_conselho );
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
	function setDescricao_conselho( $strNewValue = null )
	{
		$this->descricao_conselho = $strNewValue;
	}
	function getDescricao_conselho()
	{
		return $this->descricao_conselho;
	}
	//--------------------------------------------------------------------------------
}
?>