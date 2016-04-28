<?php
class Cid_10VO
{
	private $cod_cid = null;
	private $descricao = null;
	public function Cid_10VO( $cod_cid=null, $descricao=null )
	{
		$this->setCod_cid( $cod_cid );
		$this->setDescricao( $descricao );
	}
	//--------------------------------------------------------------------------------
	function setCod_cid( $strNewValue = null )
	{
		$this->cod_cid = $strNewValue;
	}
	function getCod_cid()
	{
		return $this->cod_cid;
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
}
?>