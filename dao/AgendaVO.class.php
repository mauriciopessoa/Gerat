<?php
class AgendaVO
{
	private $codigo_recurso = null;
	private $dia = null;
	private $hora = null;
	public function AgendaVO( $codigo_recurso=null, $dia=null, $hora=null )
	{
		$this->setCodigo_recurso( $codigo_recurso );
		$this->setDia( $dia );
		$this->setHora( $hora );
	}
	//--------------------------------------------------------------------------------
	function setCodigo_recurso( $strNewValue = null )
	{
		$this->codigo_recurso = $strNewValue;
	}
	function getCodigo_recurso()
	{
		return $this->codigo_recurso;
	}
	//--------------------------------------------------------------------------------
	function setDia( $strNewValue = null )
	{
		$this->dia = $strNewValue;
	}
	function getDia()
	{
		return $this->dia;
	}
	//--------------------------------------------------------------------------------
	function setHora( $strNewValue = null )
	{
		$this->hora = $strNewValue;
	}
	function getHora()
	{
		return $this->hora;
	}
	//--------------------------------------------------------------------------------
}
?>