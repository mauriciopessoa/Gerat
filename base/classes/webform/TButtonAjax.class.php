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

class TButtonAjax extends TButton
{
	private $callback;
	private $returnDataType;
	private $beforeSend;
	private $asyn;
	private $containerId;
	private $url;
	private $messageLoading;
	private $data;

	public function __construct( $strName = null, $strValue = null, $strAction = null, $jsCallback = null, $strReturnDataType = null, $jsBeforeSend = null, $boolAsyn = null, $strMessageLoading = null,$strUrl = null, $strContainerId = null, $strConfirmMessage = null, $strImageEnabled = null, $strImageDisabled = null, $strHint = null,$mixData=null )
	{
		parent::__construct( $strName, $strValue, $strAction, null, $strConfirmMessage, $strImageEnabled, $strImageDisabled, $strHint, null );
		$this->setCallback( $jsCallback );
		$this->setReturnDataType( $strReturnDataType );
		$this->setBeforeSend( $jsBeforeSend );
		$this->setAsync( $boolAsyn );
		$this->setContainerId( $strContainerId );
		$this->setUrl( $strUrl );
		$this->setMessageLoading( $strMessageLoading );
		$this->data = $mixData;
	}

	public function show( $print = true )
	{
		if ( $this->getAction() )
		{
			$data='';
			if( $this->getData())
			{
				$data = $this->getData();
				if( is_array($data))
				{
					foreach($data as $k=>$v)
					{
						// se n�o tiver valor, ler do campo do formul�rio
						$data[ utf8_encode($k) ] = utf8_encode($v);
					}
					$data = ',"data":'.json_encode($data);
				}
			}

			$strOnClick = 'fwAjaxRequest( {'.( $this->getCallback() ? '"callback":"' . $this->getCallback().'",' : '' ).( $this->getBeforeSend() ? '"beforeSend":"' . $this->getBeforeSend().'",' : '' ).'"action":"' . $this->getAction() . '","async":' . $this->getAsync() . ',"dataType":"' . $this->getReturnDataType() . '","msgLoad":"' . $this->getMessageLoading() . '","containerId":"' . $this->getContainerId() . '","module":"' . $this->getUrl() . '"'.$data.'});';
			$this->setOnClick( $strOnClick );
			$this->setAction(null);
		}
		return parent::show($print);
	}
	/**
	* Define a fun��o ou handle da fun��o javascript que ser� chamada ao terminar
	* a requisi��o ajax.
	*
	* @param string $jsCallback
	*/
	public function setCallback( $jsCallback = null )
	{
		$this->callback = $jsCallback;
	}
	/**
	* Retorna a fun��o ou handle da fun��o javascript que ser� chamada ao terminar
	* a requisi��o ajax.
	*
	*/
	public function getCallback()
	{
		return $this->callback;
	}
	/**
	* Define o tipo de retorno da chamada ajax. Podendo ser text ou json.
	* O padr�o ser� text
	* @param string $strReturnDataType
	*/
	public function setReturnDataType( $strReturnDataType = null )
	{
		$this->returnDataType = $strReturnDataType;
	}
	/**
	* Retorna o tipo de dados retornado pela requisi��o ajax, sendo, text ou json
	* text � o padr�o.
	*
	*/
	public function getReturnDataType()
	{
		return strtolower( $this->returnDataType ) === 'json' ? 'json' : 'text';
	}
	/**
	* Define o nome de uma fun��o js ou handle de uma fun��o javascript que
	* ser� executa antes de fazer a requisi��o ajax.
	* Se a fun��o retornar false a chamada ser� cancelada.
	*
	* @param string $jsBeforeSend
	*/
	public function setBeforeSend( $jsBeforeSend = null )
	{
		$this->beforeSend = $jsBeforeSend;
	}
	/**
	* Retorna o nome da fun��o que ser� executada antes da requisi��o ajax
	* Se a fun��o retornar false a chamada ser� cancelada.
	*/
	public function getBeforeSend()
	{
		return $this->beforeSend;
	}
	/**
	* Define se a chamada ser� assincrona ou sincrona
	*
	* @param boolean $boolAsyn
	*/
	public function setAsync( $boolAsyn = null )
	{
		$this->asyn = $boolAsyn;
	}
	/**
	* Retorna true ou false, se a chamada ser� assincrona
	*
	* @param boolean $boolAsyn
	*/
	public function getAsync()
	{
		return ( $this->asyn === false ) ? 'false' : 'true';
	}
	/**
	* Define o id do elemento html onde ser� inserido o resultado da consulta ajax
	*
	* @param string $strContainerId
	*/
	public function setContainerId( $strContainerId = null )
	{
		$this->containerId = $strContainerId;
	}
	/**
	* Retorna o id do elemento html onde ser� inserido o resultado da consulta ajax
	*
	*/
	public function getContainerId()
	{
		return $this->containerId;
	}

	/**
	* Define a url destino da requisi��o.
	* O padr�o ser� o valor do campo oculto modulo do formul�rio.
	*
	* @param string $strUrl
	*/
	public function setUrl( $strUrl = null )
	{
		$this->url = $strUrl;
	}
	/**
	* Retorna a url destino da requisi��o.
	* O padr�o ser� o valor do campo oculto modulo do formul�rio.
	*
	 */

	public function getUrl()
	{
		return $this->url;
	}
	/**
	* Define a mensagem que ser� exibida durante a requisi��o sincrona.
	*
	* @param mixed $strMessage
	*/
	public function setMessageLoading( $strMessage = null )
	{
		$this->messageLoading = $strMessage;
	}
	/**
	* Retorna a mensagem que ser� exibida durante a requisi��o sincrona.
	*
	* @param mixed $strMessage
	*/
	public function getMessageLoading()
	{
		return $this->messageLoading;
	}

	public function getData()
	{
		return $this->data;
	}
}
?>