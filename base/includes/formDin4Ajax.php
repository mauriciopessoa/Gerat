<?php

/*
 * Formdin Framework
 * Copyright (C) 2012 Minist�rio do Planejamento
 * ----------------------------------------------------------------------------
 * This file is part of Formdin Framework.
 *
 * Formdin Framework is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public License version 3
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License version 3
 * along with this program; if not,  see <http://www.gnu.org/licenses/>
 * or write to the Free Software Foundation, Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA  02110-1301, USA.
 * ----------------------------------------------------------------------------
 * Este arquivo � parte do Framework Formdin.
 *
 * O Framework Formdin � um software livre; voc� pode redistribu�-lo e/ou
 * modific�-lo dentro dos termos da GNU LGPL vers�o 3 como publicada pela Funda��o
 * do Software Livre (FSF).
 *
 * Este programa � distribu�do na esperan�a que possa ser �til, mas SEM NENHUMA
 * GARANTIA; sem uma garantia impl�cita de ADEQUA��O a qualquer MERCADO ou
 * APLICA��O EM PARTICULAR. Veja a Licen�a P�blica Geral GNU/LGPL em portugu�s
 * para maiores detalhes.
 *
 * Voc� deve ter recebido uma c�pia da GNU LGPL vers�o 3, sob o t�tulo
 * "LICENCA.txt", junto com esse programa. Se n�o, acesse <http://www.gnu.org/licenses/>
 * ou escreva para a Funda��o do Software Livre (FSF) Inc.,
 * 51 Franklin St, Fifth Floor, Boston, MA 02111-1301, USA.
 */

/**
 * Fun��o para ajustar o retorno da chamada ajax para ser devolvido para a
 * fun��o callback
 *
 * @param integer $pStatus
 * @param mixed $pData
 * @return mixed
 */
function prepareReturnAjax($pStatus, $pData=null, $pMessage=null,$boolBancoUtf8=null)
{
    if( ! isset( $_REQUEST['ajax' ] ) ) // n�o usar esta fun��o quando n�o for uma requisi��o ajax
    {
		return;
    }
    if( !defined('BANCO_UTF8') )
    {
    	define('BANCO_UTF8',1);
    }

	$buffer = ob_get_contents();
	$buffer = trim( $buffer );

	ob_clean();
   	$boolAplicarUtf8  = false;
	$boolBancoUtf8 = is_null($boolBancoUtf8) ? BANCO_UTF8 : $boolBancoUtf8;
	$pMessage .= $buffer;
	// tratamento para as requisi��es de pagina��o da classe TGrid.
	if( isset($_REQUEST['page']) && $_REQUEST['page']>0)
	{
		echo $pData.$pMessage;
		die();
	}


    if( isset($_REQUEST['containerId']) && !is_null( $_REQUEST['containerId'] ) && trim($_REQUEST['containerId'] ) != ''  )
    {
    	if( !$pData )
    	{
    		if( $_REQUEST['dataType']=='json')
    		{
    			$pData=utf8_encode($pMessage);
			}
			else
			{
    			$pData=$pMessage;
			}
    	}
		$pMessage=null;
    }

   	if( $pData )
    {
	    if( is_array( $pData ) )
		{
		    $vData='';
		    foreach( $pData as $k => $v)
		    {
		        if($_REQUEST['dataType']=='json')
		        {
        	    	$boolAplicarUtf8=true;
		        	if( !is_array( $v ) )
		        	{
		        		if( $boolBancoUtf8 )
		        		{
		       				$pData[$k]=utf8_encode($v) ;
						}
						else
						{
							$pData[$k]=$v ;
						}
					}
					else
					{
					    $pData[ $k ] = utf8_encode_array($v);
					   /*foreach($v as $k1=>$v1)
						{
			        		if( $boolBancoUtf8 )
			        		{
			       				$v[$k1] = utf8_encode($v1);
			       			}
			       			else
			       			{
			       				$v[$k1] = $v1;
			       			}
						}
						$pData[$k]=$v;
						*/
					}
				}
				else
	       		{
    		        $vData .= print_r($v,true)."\n";
				}
		    }
		    if($_REQUEST['dataType']=='text')
		    {
		        $pData = $vData;
			}

		}
		if($_REQUEST['dataType']=='text')
		{
			echo $pData;
		}
		else
		{
			$pData = ($boolAplicarUtf8) ? $pData : utf8_encode($pData);
		}
	}
	if( $pMessage )
    {
        if( is_array( $pMessage ) )
        {
            $vData=null;
            foreach($pMessage as $k => $v )
            {
   		        $vData .= $v."\n";
			}
       		$pMessage = $vData;
        }
		$pMessage = str_replace('\n',"\n",$pMessage);
		if(isset($_REQUEST['dataType'] ) && $_REQUEST['dataType'] == 'text' )
        {
			echo $pMessage;

		}
		else
		{
			$pMessage = utf8_encode($pMessage);
		}
	}
    if(	isset($_REQUEST['dataType']) && $_REQUEST['dataType'] == 'json'	)
	{
		ob_clean();
		$resAjax=null;
		$resAjax['status']	= $pStatus;
		$resAjax['data']	= $pData;
		$resAjax['message']	= $pMessage;
		$resAjax['dataType']= $_REQUEST['dataType'];
		if(	isset($_REQUEST['containerId'] ) )
		{
			$resAjax['containerId']= $_REQUEST['containerId'];
		}
		if( isset($_REQUEST['TGrid']) && isset($_REQUEST['page'] ) )
		{
			echo trim($pMessage);
		}
		else
		{
			echo json_encode($resAjax);
		}
	}
	die;
}
/**
 * Cria um array com as vari�veis e seus respectivos valores oriundo do POST para
 * ser enviado para o banco
 * @param string $pFields ex: 'seq_pessoa,nom_pessoa, ...'
 * @return array Array com os dados
 *
 * @todo criar op��o de colocar um valor de campo diferente em um id ex: num_pessoa|num_cliente
 * @todo add no arquivo de fun��es ajax
 */
/**
 * Cria um array com as vari�veis e seus respectivos valores oriundo
 + do POST para
 * ser enviado para o banco
 * @param string $pFields ex: 'seq_pessoa,nom_pessoa, ...'
 * @return array Array com os dados
 *
 * @see ex: fwCreateBvarsAjax('nom_pessoa,des_obs|observacao, ...')
 */
function createBvarsAjax($pFields) {
    $aFields = explode(',', $pFields);
    $bvar;
    foreach ($aFields as $k => $v) {
        $v = trim($v);
        if (strpos($v, '|')) {
            $v = explode('|', $v);
            if (isset($_POST[strtolower($v[1])]) && $_POST[strtolower($v[1])] || trim($_POST[strtolower($v[1])]) == '0') {
                //$bvar[strtoupper($v[0])] = utf8_decode($_POST[strtolower($v[1])]);
                $bvar[strtoupper($v[0])] = str_replace(array('"'),array('�'),stripslashes(utf8_decode($_POST[strtolower($v[1])])) );
            } else {
                $bvar[strtoupper($v[0])] = '';
            }
        } else {
            if (isset($_POST[strtolower($v)]) && $_POST[strtolower($v)] || trim($_POST[strtolower($v)]) == '0') {
                $bvar[strtoupper($v)] = str_replace(array('"'),array('�'),stripslashes(utf8_decode($_POST[strtolower($v)])));
            } else {
                $bvar[strtoupper($v)] = '';
            }
        }
    }
    return $bvar;
}

function utf8_encode_array($res)
{
	foreach($res as $k=>$v)
	{
		if( is_array( $v ) )
			{
				$res[$k] = utf8_encode_array($v);
			}
			else
			{
				$res[$k] = utf8_encode($v);
			}
	}
	return $res;
}
?>