<?php
class Modalidade_dicomDAO extends TPDOConnection
{
	public function modalidade_dicomDAO()
	{
	}
	//--------------------------------------------------------------------------------
	public static function insert( Modalidade_dicomVO $objVo )
	{
		if( $objVo->getCodigo_aparelho() )
		{
			return self::update($objVo);
		}
		$values = array(  $objVo->getCodigo_modalidade_dicom() 
						, $objVo->getSigla() 
						, $objVo->getDescricao() 
						);
		return self::executeSql('insert into modalidade_dicom(
								 codigo_modalidade_dicom
								,sigla
								,descricao
								) values (?,?,?)', $values );
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id )
	{
		$values = array($id);
		return self::executeSql('delete from modalidade_dicom where codigo_aparelho = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function select( $id )
	{
		$values = array($id);
		return self::executeSql('select
								 codigo_modalidade_dicom
								,sigla
								,descricao
								from modalidade_dicom where codigo_aparelho = ?', $values );
	}
	//--------------------------------------------------------------------------------
	public static function selectAll( $orderBy=null, $where=null )
	{
		return self::executeSql('select
								 codigo_modalidade_dicom
								,sigla
								,descricao
								from modalidade_dicom'.
		( ($where)? ' where '.$where:'').
		( ($orderBy) ? ' order by '.$orderBy:''));
	}
	//--------------------------------------------------------------------------------
	public static function update ( Modalidade_dicomVO $objVo )
	{
		$values = array( $objVo->getCodigo_modalidade_dicom()
						,$objVo->getSigla()
						,$objVo->getDescricao()
						,$objVo->getCodigo_aparelho() );
		return self::executeSql('update modalidade_dicom set 
								 codigo_modalidade_dicom = ?
								,sigla = ?
								,descricao = ?
								where codigo_aparelho = ?',$values);
	}
	//--------------------------------------------------------------------------------
}
?>