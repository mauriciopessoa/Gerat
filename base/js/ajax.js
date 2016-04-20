
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

var contadorRequisicoesAjax=0;
var ajax;
function Ajax() {
  this.req = null;
  this.url = null;
  this.status = null;
  this.statusText = '';
  this.method = 'GET';
  this.async = true;
  this.dataPayload = null;
  this.readyState = null;
  this.responseText = null;
  this.responseXML = null;
  this.handleResp = null;
  this.responseFormat = 'text'; // 'text', 'xml', 'object';
  this.mimeType = null;
  this.headers = [];
  this.campoMensagem = null;
  this.messageWait = null;
  this.idUpdate = null;
  this.init = function() {
    var i = 0;
    var reqTry = [
      function() { return new XMLHttpRequest(); },
      function() { return new ActiveXObject('Msxml2.XMLHTTP') },
      function() { return new ActiveXObject('Microsoft.XMLHTTP' )} ];
    while (!this.req && (i < reqTry.length)) {
      try {
        this.req = reqTry[i++]();
      }
      catch(e) {}
    }
    return true;
  };
  this.doGet = function(url, hand, format,campoMensagem,messageWait,idUpdate) {
    this.url = url;
    this.handleResp = hand;
    this.responseFormat = format || 'text';
    this.campoMensagem = document.getElementById('div_mensagem_ajax');
    this.idUpdate       = idUpdate;
    this.messageWait    = null;
    this.campoMensagem     = null;
    if( campoMensagem )
    {
		this.campoMensagem = document.getElementById(campoMensagem);
		if( messageWait )
		{
	 	    this.messageWait = messageWait;
		    try {
	   		    if( this.campoMensagem.type=='text')
	   		    {
	   	    		this.campoMensagem.value=messageWait;
	   		    }
	   		    else
	   		    {
		    			this.campoMensagem.innerHTML='<center><b>'+messageWait+'</b></center>';
	   		    }
		    }
		    catch(e){}
		}
	 };
    this.doReq();
  };
  this.doPost = function(url, dataPayload, hand, format, campoMensagem, messageWait,idUpdate) {
    this.url = url;
    this.dataPayload = dataPayload;
    this.handleResp = hand;
    this.responseFormat = format || 'text';
    this.method = 'POST';
    this.campoMensagem = document.getElementById('div_mensagem_ajax');
    this.idUpdate = idUpdate;
    if( campoMensagem )
    {
		this.campoMensagem = document.getElementById(campoMensagem);
		if( messageWait )
		{
	 	    this.messageWait = messageWait;
		    try {
	   		    if( this.campoMensagem.type=='text')
	   		    {
	   	    		this.campoMensagem.value=messageWait;
	   		    }
	   		    else
	   		    {
		    			this.campoMensagem.innerHTML=messageWait;
	   		    }
		    }
		    catch(e){}
		}
	 };
    this.doReq();
  };
  this.doReq = function() {
    var self = null;
    var req = null;
    var headArr = [];
    if (!this.init()) {
      alert('N�o foi poss�vel criar o ojeto XMLHttpRequest.');
      return;
    }
    req = this.req;
    contadorRequisicoesAjax++;
    req.open(this.method, this.url, this.async);
    if (this.method == "POST") {
      this.req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    }
    if (this.method == 'POST') {
      req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    }
    self = this;
    req.onreadystatechange = function() {
      var resp = null;
      self.readyState = req.readyState;
      if (req.readyState == 4) {
	   contadorRequisicoesAjax--;
	      if(self.campoMensagem)
    	  {
    	  	if (self.campoMensagem.type=='text')
    	  	{
	     		self.campoMensagem.value='';
    	  	}
    	  	else
    	  	{
	     		self.campoMensagem.innerHTML='';
    	  	}
    	  };
        self.status = req.status;
        self.statusText = req.statusText;
        self.responseText = req.responseText;
        self.responseXML = req.responseXML;
        switch(self.responseFormat) {
          case 'text':
            resp = self.responseText;
            break;
          case 'xml':
            resp = self.responseXML;
            break;
          case 'object':
            resp = req;
            break;
        }
        if (self.status > 199 && self.status < 300) {
          if (!self.handleResp)
          {
          	if(!self.idUpdate)
          	{
               alert('Nenhuma fun��o de retorno definida');
          	}
          	else
          	{
          		var obj = document.getElementById(self.idUpdate);
          		if( obj )
          		{
          			if(obj.type=='text')
          			{
          				obj.value=resp;
          			}
          			else
          			{
	          			obj.innerHTML=resp;
          			}
          		}
          		else
          		{
          			alert( 'Ojeto '+self.idUpdate+' n�o existe no formul�rio');
          		}

          		/*
          		var obj;
          		var aResp = resp.split('|');
          		var aCampo = self.idUpdate.split('|');
          		var msg='';
       		   for(i=0;i<aCampo.length;i++)
       		   {
	      			obj = document.getElementById(aCampo[i]);
          			if( obj )
          			{
          				if(obj.type=='text')
          				{
          					obj.value=aResp[i];
          				}
          				else
          				{
	          				obj.innerHTML=aResp[i];
          				}
          			}
          			else
          			{
          				msg += "\n"+'Objeto '+aCampo[i]+' n�o encontrado!'
          			}
					}
					if( msg!='')
					{
						alert(msg);
					}
					*/
          	}
            return;
          }
          else
          {
            self.handleResp(resp);
          }
        }
        else
        {
          self.handleErr(resp);
        }
      }
    };
    req.send(this.dataPayload);
  };
  this.abort = function() {
    if (this.req) {
      this.req.onreadystatechange = function() { };
      this.req.abort();
      this.req = null;
    }
  };
  this.handleErr = function() {
    var errorWin;
    // Create new window and display error
    try {
      errorWin = window.open('', 'errorWin');
      errorWin.document.body.innerHTML = this.responseText;
    }
    // If pop-up gets blocked, inform user
    catch(e) {
      alert('Ocorreu um erro mas a mensagem n�o pode ser exibida. Provavelmente seu browser est� com pop-up bloqueado.\nC�digo status:'+this.req.status+'\nDescri��o:'+this.req.statusText);
    }
  };
  this.setMimeType = function(mimeType) {
    this.mimeType = mimeType;
  };
  this.setHandlerResp = function(funcRef) {
    this.handleResp = funcRef;
  };
  this.setHandlerErr = function(funcRef) {
    this.handleErr = funcRef;
  };
  this.setHandlerBoth = function(funcRef) {
    this.handleResp = funcRef;
    this.handleErr = funcRef;
  };
  this.setRequestHeader = function(headerName, headerValue) {
    this.headers.push(headerName + ': ' + headerValue);
  };
}
//---------------------------------------------------------------------
/*
	doAjax()
	- modulo = nome do m�dulo/url que ser� chamado
	- acao  = nome da a��o que ser� processada no m�dulo (opcional)
	- campoAtualizar = campos que ser�o atualizados no formulario de origem separados por |
	- mensagem = mensagem que ser� exibida na tela durante o processamento (opcional)
	- campoMensagem = campo do formul�rio onde ser� exibida a mensagem (opcional)
	- funcaoRetorno = fun��o callBack (opcional)
	- objForm = formulario (opcional
	- metodo = get/post    (opcional)
	- parametros = parametros que ser�o passados para a url (opcional) se for deixado em branco ser�o passados todos so campos do formul�rio
	ex: 	doAjax("../includes/testeAjax.php","Gravar",'nom_cliente|num_idade|tel_cliente','<h1><center>Gravando...</center></h1>','campo_mensagem');
*/
function doAjax(modulo,acao,campoAtualizar,mensagem,campoMensagem,funcaoRetorno,objForm,metodo,parametros)
{
	if (ajax==null)
	{
		ajax = new Ajax();
	}
	if(acao!='')
	{
		try {document.getElementById('formDinAcao').value=acao} catch(e){};
	}
	if( objForm==null)
	{
		objForm = document.forms[0];
	}
	if(!parametros && objForm)
	{
	   parametros = formData2QueryString(objForm);
	}
	if(mensagem==null)
	{
		mensagem='Carregando <img src="base/imagens/carregando.gif">';
	}
	if(!metodo || metodo.toUpperCase()=='POST')
	{
		ajax.doPost(modulo,parametros ,funcaoRetorno ,'text',campoMensagem      , mensagem,campoAtualizar);
	}
	else
	{
		ajax.doGet(modulo+'?'+parametros,funcaoRetorno,'text',campoMensagem, mensagem,campoAtualizar);
	}
}
