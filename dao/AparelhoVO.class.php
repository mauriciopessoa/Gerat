<?php
class AparelhoVO
{
	private $codigo_aparelho = null;
	private $descricao = null;
	private $modalidade_dicom = null;
	private $peso_maximo_paciente = null;
	private $altura_maxima_paciente = null;
	public function AparelhoVO( $codigo_aparelho=null, $descricao=null, $modalidade_dicom=null, $peso_maximo_paciente=null, $altura_maxima_paciente=null )
	{
		$this->setCodigo_aparelho( $codigo_aparelho );
		$this->setDescricao( $descricao );
		$this->setModalidade_dicom( $modalidade_dicom );
		$this->setPeso_maximo_paciente( $peso_maximo_paciente );
		$this->setAltura_maxima_paciente( $altura_maxima_paciente );
	}
	//--------------------------------------------------------------------------------
	function setCodigo_aparelho( $strNewValue = null )
	{
		$this->codigo_aparelho = $strNewValue;
	}
	function getCodigo_aparelho()
	{
		return $this->codigo_aparelho;
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
	function setModalidade_dicom( $strNewValue = null )
	{
		$this->modalidade_dicom = $strNewValue;
	}
	function getModalidade_dicom()
	{
		return $this->modalidade_dicom;
	}
	//--------------------------------------------------------------------------------
	function setPeso_maximo_paciente( $strNewValue = null )
	{
		$this->peso_maximo_paciente = $strNewValue;
	}
	function getPeso_maximo_paciente()
	{
		return $this->peso_maximo_paciente;
	}
	//--------------------------------------------------------------------------------
	function setAltura_maxima_paciente( $strNewValue = null )
	{
		$this->altura_maxima_paciente = $strNewValue;
	}
	function getAltura_maxima_paciente()
	{
		return $this->altura_maxima_paciente;
	}
	//--------------------------------------------------------------------------------
}
?>