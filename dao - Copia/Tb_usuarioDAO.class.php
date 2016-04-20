<?php
class Tb_usuarioDAO extends TPDOConnection
{
	public function tb_usuarioDAO()
	{
	}
	//--------------------------------------------------------------------------------
	public function insert( Tb_usuarioVO $objVo )
	{
		if( $objVo->getId() )
		{
			return self::update($objVo);
		}
		$values = array(  $objVo->getNome()
						, $objVo->getLogin()
						, $objVo->getSenha()
						);
		return self::executeSql('insert into tb_usuario(
								 nome
								,login
								,senha
								) values (?,?,?)', $values );
	}
	//--------------------------------------------------------------------------------
	public function delete( $id )
	{
		$values = array($id);
		return self::executeSql('delete from tb_usuario where id = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public function select( $id )
	{
		$values = array($id);
		return self::executeSql('select
								 id
								,nome
								,login
								,senha
								from tb_usuario where id = ?', $values );
	}
	//--------------------------------------------------------------------------------
	public function selectAll( $orderBy=null, $where=null )
	{
		return self::executeSql('select
								 id
								,nome
								,login
								,senha
								from tb_usuario'.
		( ($where)? ' where '.$where:'').
		( ($orderBy) ? ' order by '.$orderBy:''));
	}
	//--------------------------------------------------------------------------------
	public function update ( Tb_usuarioVO $objVo )
	{
		$values = array( $objVo->getNome()
						,$objVo->getLogin()
						,$objVo->getSenha()
						,$objVo->getId() );
		return self::executeSql('update tb_usuario set
								 nome = ?
								,login = ?
								,senha = ?
								where id = ?',$values);
	}
	//--------------------------------------------------------------------------------
	function validar($login=null,$senha=null)
	
	{
		// verificar se a tabela está vazia
		$sql = "select count(*) as qtd from tb_usuario";
		$dados = self::executeSql($sql);
		if( $dados['QTD'][0] == 0 )
		{
                  $vo = new Tb_usuarioVO();
                  $vo->setNome('Maurício');
                  $vo->setLogin('mauricio');
                  $vo->setSenha('amper');
                  self::insert($vo);
		}
		// validar. Como a senha deve ser encriptada com md5, vou utilizar a o objeto VO da tabela que fará esta tarefa;
		$vo = new Tb_usuarioVO();
		$vo->setLogin($login);
		$vo->setSenha($senha);
		$parametros = array($vo->getLogin(),$vo->getSenha());
		$res = self::executeSql("select * from tb_usuario where login=? and senha=?",$parametros);
		return $res;
	
          
          
          
        }
        
        

}
?>