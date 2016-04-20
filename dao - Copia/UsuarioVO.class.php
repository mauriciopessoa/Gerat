<?php
class UsuarioVO
{
	private $id = null;
	private $id_perfil = null;
	private $nome = null;
	private $login = null;
	private $senha = null;
	public function UsuarioVO( $id=null, $id_perfil=null, $nome=null, $login=null, $senha=null )
	{
		$this->setId( $id );
		$this->setId_perfil( $id_perfil );
		$this->setNome( $nome );
		$this->setLogin( $login );
		$this->setSenha( $senha );
	}
	//--------------------------------------------------------------------------------
	function setId( $strNewValue = null )
	{
		$this->id = $strNewValue;
	}
	function getId()
	{
		return $this->id;
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
	function setNome( $strNewValue = null )
	{
		$this->nome = $strNewValue;
	}
	function getNome()
	{
		return $this->nome;
	}
	//--------------------------------------------------------------------------------
	function setLogin( $strNewValue = null )
	{
		$this->login = $strNewValue;
	}
	function getLogin()
	{
		return $this->login;
	}
	//--------------------------------------------------------------------------------
	function setSenha( $strNewValue = null )
	{
		$this->senha = $strNewValue;
	}
	function getSenha()
	{
		return md5(trim($this->senha));
	}
	//--------------------------------------------------------------------------------
}
?>