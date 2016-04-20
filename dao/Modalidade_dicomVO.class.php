<?php
class Modalidade_dicomVO
{
	private $codigo_modalidade_dicom = null;
	private $sigla = null;
	private $descricao = null;
	public function Modalidade_dicomVO( $codigo_modalidade_dicom=null, $sigla=null, $descricao=null )
	{
		$this->setCodigo_modalidade_dicom( $codigo_modalidade_dicom );
		$this->setSigla( $sigla );
		$this->setDescricao( $descricao );
	}
	//--------------------------------------------------------------------------------
	function setCodigo_modalidade_dicom( $strNewValue = null )
	{
		$this->codigo_modalidade_dicom = $strNewValue;
	}
	function getCodigo_modalidade_dicom()
	{
		return $this->codigo_modalidade_dicom;
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