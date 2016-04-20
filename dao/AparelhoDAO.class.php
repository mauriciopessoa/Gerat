<?php
class AparelhoDAO extends TPDOConnection
{
	public function aparelhoDAO()
	{
	}
	//--------------------------------------------------------------------------------
	public static function insert( AparelhoVO $objVo )
	{
		if( $objVo->getCodigo_aparelho() )
		{
			return self::update($objVo);
		}
		$values = array(  $objVo->getDescricao() 
						, $objVo->getModalidade_dicom() 
						, $objVo->getPeso_maximo_paciente() 
						, $objVo->getAltura_maxima_paciente() 
						);
		return self::executeSql('insert into aparelho(
								 descricao
								,modalidade_dicom
								,peso_maximo_paciente
								,altura_maxima_paciente
								) values (?,?,?,?)', $values );
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id )
	{
		$values = array($id);
		return self::executeSql('delete from aparelho where codigo_aparelho = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function select( $id )
	{
		$values = array($id);
		return self::executeSql('select
								 codigo_aparelho
								,descricao
								,modalidade_dicom
								,peso_maximo_paciente
								,altura_maxima_paciente
								from aparelho where codigo_aparelho = ?', $values );
	}
	//--------------------------------------------------------------------------------
	public static function selectAll( $orderBy=null, $where=null )
	{
		return self::executeSql('select
								 codigo_aparelho
								,descricao
								,modalidade_dicom
								,peso_maximo_paciente
								,altura_maxima_paciente
								from aparelho'.
		( ($where)? ' where '.$where:'').
		( ($orderBy) ? ' order by '.$orderBy:''));
	}
	//--------------------------------------------------------------------------------
	public static function update ( AparelhoVO $objVo )
	{
		$values = array( $objVo->getDescricao()
						,$objVo->getModalidade_dicom()
						,$objVo->getPeso_maximo_paciente()
						,$objVo->getAltura_maxima_paciente()
						,$objVo->getCodigo_aparelho() );
		return self::executeSql('update aparelho set 
								 descricao = ?
								,modalidade_dicom = ?
								,peso_maximo_paciente = ?
								,altura_maxima_paciente = ?
								where codigo_aparelho = ?',$values);
	}
	//--------------------------------------------------------------------------------
}
?>