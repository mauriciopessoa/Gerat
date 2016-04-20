<?php
class PerfilVO
{
	private $id_perfil = null;
	private $perfil = null;
	private $cancelado = null;
	public function PerfilVO( $id_perfil=null, $perfil=null, $cancelado=null )
	{
		$this->setId_perfil( $id_perfil );
		$this->setPerfil( $perfil );
		$this->setCancelado( $cancelado );
	}
	//--------------------------------------------------------------------------------
	function setId_perfil( $strNewValue = null )
	{
		$this->id_perfil = $strNewValue;
	}
	function getId_perfil()
	{
		return $this->id_perfil;
	}
	//--------------------------------------------------------------------------------
	function setPerfil( $strNewValue = null )
	{
		$this->perfil = $strNewValue;
	}
	function getPerfil()
	{
		return $this->perfil;
	}
	//--------------------------------------------------------------------------------
	function setCancelado( $strNewValue = null )
	{
		$this->cancelado = $strNewValue;
	}
	function getCancelado()
	{
		return $this->cancelado;
	}

}
?>