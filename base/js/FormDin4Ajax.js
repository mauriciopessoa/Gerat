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
var ajaxRequestCount=0;
var semaphore = [];
var xhr;
/**
 * Fun��o responsavel por envio de uma requisi��o AJAX.
 * Esta fun��o ir� enviar todos os dados do formul�rio para o modulo especificado
 * e ser� retornado para fun��o de callback o resultado no formato texto ou json
 * conforme o parametro dataType
 * EX:
 * fwAjaxRequest(
			{'callback': f_resultado
    		,'beforeSend': f_validar
    		,'action':'salvar'
            ,'async':false
            ,'dataType':'json'
            ,'msgLoading':'Processando. Aguarde!'
            ,'containerId':''
            ,'module':''}
        	);
 */
function fwAjaxRequest(config)
{
    function showDivLoading(msgLoading)
	{
		var div = jQuery("#fwDivMsgLoading").get(0);
	 	if( !div)
    	{
	        jQuery('body').append('<div id="fwDivMsgLoading">'+msgLoading+'<br><img src="'+pastaBase+'/imagens/fwProcessing.gif"></div>');
			div = jQuery("#fwDivMsgLoading").get(0);
	    	fwSetPosition('fwDivMsgLoading','cc');
    	}
    	else
    	{
    		jQuery(div).html(msgLoading + '<br><img src="'+pastaBase+'/imagens/fwProcessing.gif">');
    	}

        jQuery(div).show();
		jQuery(jQuery.browser.msie)
		{
   			jQuery(div).css({"visibility":"visible"});
		}
	 }
    // Iniciando a requisi��o em AJAX
    if( ! config.module  )
    {
    	config.module = jQuery("#modulo").val();
	}
    if(!config.module) return alert('Atributo "modulo" n�o foi informado!');
    if( config.acao != null )
    {
		config.action = config.acao;
	}
    if( config.formdinAcao != null )
    {
		config.action = config.formDinAcao;
	}
    if( config.action != null )
    {
    	jQuery('#formDinAcao').val(config.action);
	}
	var tp =  typeof config.beforeSend;
	if( tp == 'boolean'	)
	{
		if(!config.beforeSend )
		{
			return false;
		}
	}
	else if( tp=='string')
	{
        try
        {
        	if( config.beforeSend.indexOf('(')==-1)
        	{
				config.beforeSend+='()';
        	}
     	    tp = eval(config.beforeSend);
            if( !tp )
            {
                return false;
            }
        }
        catch(e)
        {
        	fwAlert( e.message );
        	return false;
        }
 	}
	else if( tp=='function')
	{
	 	if( !config.beforeSend.call())
	 	{
	 		return false;
	 	}
	}

	//Verifica Semaforo
	if (config.semaphore && !fwSemaphoreIsOpen(config.semaphore))
	{
		return false;
	}
	config.semaphoreTimeout = config.semaphoreTimeout || null;

	/*
    if( config.beforeSend  && !config.beforeSend.call() )
    {
		return false;
    }
    */
    // configura e seta o tipo de retorno
    var v_dataType = 'json';
    if(config.dataType) v_dataType = config.dataType;

    var v_containerId='';
    if( config.containerId ) v_containerId = config.containerId;

    // configura chamada em paralelo ou n�o
    var v_async = true;
    if( typeof config.async != 'undefined' ) v_async = config.async;

    // se a chamada for assyncrona, verificar se foi solicitado o bloqueio da tela
    var v_blockScreen = false;
    config.blockScreen = config.blockScreen || false;
    if( v_async == true )
    {
		v_blockScreen = config.blockScreen;
    }

    // configura e seta a fun��o de retorno
    var v_callback = function(res)
    {
    	var session_expired=false;
		if( typeof res != 'object')
		{
			res = jQuery.trim(res);
			res = res.replace('<br>','\n');
			if( res == 'fwSession_expired')
			{
				session_expired = true;
			}
		}
		else
		{
			try
			{
				if( res.message )
				{
					if( res.message == 'fwSession_expired')
					{
 						session_expired = true;
					}
					res.message = res.message.replace('<br>','\n');
				}
			}catch(e){}
		}
		ajaxRequestCount--;
		if( !ajaxRequestCount || ajaxRequestCount < 1 )
		{
			jQuery("#fwDivMsgLoading").hide();
        	//fwUnBlockScreen();
        	ajaxRequestCount = 0 ;
		}

		if( session_expired )
		{
			alert('Sess�o expirada.\n\nClique Ok para reiniciar!');
 			fwApplicationRestart();
 			return;
		}
        // tratar queda de se��o
        if( config.dataType == 'json')
        {
        	var message = res.message;
        }
        else
        {
        	var message = res;
        }

        // cancelar o semaforo se houver
        if ( config.semaphore )
	    {
	    	// se o semaphoro estiver aberto � porque atingiu o tempo limite de execu��o, ent�o cancelar a requisi��o ajax
            if( fwSemaphoreIsOpen( config.semaphore ) )
            {
            	if( v_containerId )
				{
					jQuery("#"+v_containerId).html('');
				}
            	return;
            }
            else
            {
	    		fwCancelSemaphore( config.semaphore, v_containerId );
			}
	    }

        // chamar a fun��o callback definida pelo usu�rio
        if( config.callback )
        {
        	try
	        {
	        	if( typeof config.callback == 'string')
	        	{
	        		fwExecutarFuncao( config.callback, res );
	        	}
	        	else
	        	{
	        		if( typeof config.callback !='function')
	        		{
						fwAlert( config.callback+' n�o � uma fun��o!',{'title':'Aten��o'});
	        		}
	        		else
	        		{
	        			config.callback(res);
	        		}
				}
			}
        	catch (err){}
        	return;
	    }
        if( ! res )
        {
			return;
        }
		if( v_containerId )
		{
			var data=null;
			jQuery("#"+v_containerId).html('');
		    if(v_dataType == 'json' && res.data )
	        {
	        	data = jQuery.parseJSON(res.data);
			}
			if( !data && res.message )
			{
				data = res.message;
			}
			if( !data && res )
			{
				data=res;
			}
			jQuery("#"+v_containerId).html(data);
			return;
		}
    	if( res )
        {
	        if(v_dataType == 'text')
	        {
	        	fwAlert( res,{'title':'Mensagem'} );
			}
			else if( v_dataType=='xml')
			{

			}
			else
			{
				var params = {"title":"Mensagem"};
		        if( res.status == 1 )
		        {
		        	var msg;
		            if(res.data &&  res.data != 'null' &&  res.data != ""  )
		            {
		            	msg = res.data;
					}
		            if( res.message && res.message != 'null' && res.message != '' )
		            {
	                	nsg= res.message;
					}
					var aMsg = res.message.split('\\n');
					var i;
					msg='';
					for(i=0;i<aMsg.length;i++)
					{
						msg += aMsg[i]+'\n';
					}
		        }
		        else
		        {
		        	var params = {"title":"Erro"};
	            	var msg = 'Ocorreu um erro!\n';
	            	if( res.data && res.data != 'null' && res.data != 'null' )
	            	{
	        			msg += res.data;
					}
					if( res.message && res.message != 'null' && res.message != '' )
					{
						msg += res.message;
					}
					var aMsg = res.message.split('\\n');
					var i;
					msg='';
					for(i=0;i<aMsg.length;i++)
					{
						msg += aMsg[i]+'\n';
					}
		        }
				if( msg )
				{
					fwAlert( msg,params );
				}
			}
		}
    };

    // configura e seta a mensagem de loading
    var v_msgLoading = 'Executando. Aguarde...';
    if(config.msgLoading) v_msgLoading = config.msgLoading;

    if( ! v_async || v_blockScreen )
    {
	    // inicia anima��o de loading
		if( v_containerId )
		{
			jQuery("#"+v_containerId).html(v_msgLoading);
			if( ajaxRequestCount < 1 )
			{
				//fwBlockScreen(null,null,null,'');
				ajaxRequestCount=0;
			}
		}
		else
		{
			if( ajaxRequestCount < 1 )
			{

				//fwBlockScreen(null,null,null,v_msgLoading);
				showDivLoading(v_msgLoading)
				ajaxRequestCount=0;
			}
		}
	}
	else
	{
		if( v_containerId )
		{
			jQuery("#"+v_containerId).html(v_msgLoading);
		}
	}

    // transformar os campos do formulario no formato para transmiss�o via ajax
    var dados =  {};
    dados['ajax'] = 1;
    if( !config.data )
    {
		var formData = jQuery("#formdin").serializeArray();
        for(key in formData)
        {
			try{
				if( formData[key].name.indexOf('[]') != -1 )
				{
					var field =formData[key].name.replace('[]','');
					if( !dados[ field ])
					{
						dados[ field ]=Array();
					}
					dados[ field ].push(formData[key].value);
				}
				else
				{
					dados[ formData[key].name ]=formData[key].value;
				}
			} catch(e){}
        }
     	// ler os campos desabilitados
   		jQuery('*').filter(':input:disabled').each(function()
   			{
     			dados[this.id]=jQuery(this).val();
	   		});
	}
	else
	{
		if( typeof config.data == 'object')
		{
			for( key in config.data )
			{
				if( !config.data[key] )
				{
					try{config.data[key] = jQuery("#"+key).val();}catch(e){}
				}
				dados[ key ] = config.data[ key ];
			}
		}
		else
		{
			var formData = String( config.data ).split('&');
			for( var i=0;i<formData.length;i++)
			{
				var v = String( formData[i]).split('=');
				dados[v[0]]=decodeURIComponent(v[1] );
			}
		}
	}
	// adicionar a a��o no final
	if( config.action != null )
	{
    	//dados +='&formDinAcao='+config.action;
    	dados['formDinAcao']=config.action;
	}
    // adicionar dados extra para o index.php processar como ajax
    //dados += '&dataType='+v_dataType+'&modulo='+config.module;
    dados['dataType']	= v_dataType;
    dados['modulo']		= config.module;

    if( !app_url ) app_url='';
    if( !app_index_file ) app_index_file = 'index.php';

    //Uso de Semaforo na requisicao ajax (semaforo fica "travado" at� finalizar a requisicao)
    if (config.semaphore)
    {
    	fwSetSemaphore(config.semaphore,config.semaphoreTimeout,v_containerId);
    }

    // inicia a requisi��o ajax
	ajaxRequestCount++;
    jQuery.ajax({
		url: app_url+app_index_file,
		type: "POST",
		async: v_async,
		data: dados,
		dataType: v_dataType,
		containerId:v_containerId,
		timeout:config.semaphoreTimeout,
		success: v_callback,
		//error: function( res ){alert('Erro!\n\n'+res );fwUnBlockScreen();}
		error: function(XMLHttpRequest, textStatus, errorThrown)
		{
			//desfazendo semaforo
			if (config.semaphore)
			{
		    	fwCancelSemaphore(config.semaphore, v_containerId);
			}
			else
			{
				ajaxRequestCount--;
			}

			if( ajaxRequestCount < 1 )
			{
				if( ! config.async || config.blockScreen )
				{
					jQuery("#fwDivMsgLoading").hide();
				}
			}
			if( textStatus !="abort" && textStatus != "timeout" )
			{
				alert('jQuery.ajax erro:'+XMLHttpRequest.responseText+ '\nstatus:'+textStatus+'\n'+errorThrown);
			}
		}
	});
}
//------------------------------------------------------------------------------
/**
 * Fun��o para tornar campos obrigat�rio via js
 * ex:
 * fwSetRequired('des_nivel') => tornar des_nivel obrigat�rio
 * fwSetRequired('des_nivel,des_obs') => tornar des_nivel e des_obs obrigat�rio
 */
function fwSetRequired(fields)
{
    if (fields)
    {
        try
        {
            var aFields = fields.split(',');
            if (aFields.length > 0)
            {
                for (var p in aFields)
                {
                    var e = jQuery('#' + aFields[p]);
                    if( e.length == 0 )
                    {
                    	jQuery('#' + aFields[p] + '_label_area').attr('needed', 'true');
                    	jQuery('*[name="'+aFields[p]+'"]').each(
                    		function()
                    		{
							jQuery(this).attr('needed', 'true');
							}
                    	);
                    }
                    else
                    {
	                    e.attr('needed', 'true');
					}
                    if (REQUIRED_FIELD_MARK)
                    {
                        jQuery('#' + aFields[p] + '_label_required').html(REQUIRED_FIELD_MARK);
                    }
                    else
                    {
                        //e.addClass("fwField fwFieldRequired");
                        jQuery('#' + aFields[p] + '_label_area').addClass("fwField fwFieldRequired");
                    }
                }
            }
            /*else
            {
                var e = jQuery('#' + aFields[0]);
                e.attr('needed', 'true');
                if (e.type == 'radio')
                {
                    jQuery('#' + aFields[0] + '_label_area').attr('needed', 'true');
                }
                if (REQUIRED_FIELD_MARK)
                {
                    jQuery('#' + aFields[0] + '_label_required').html(REQUIRED_FIELD_MARK);
                }
                else
                {
                    //e.addClass("fwField fwFieldRequired");
                    jQuery('#' + aFields[0] + '_label_area').addClass("fwField fwFieldRequired");
                }
            }
            */
        }
        catch (e) {
        }
    }
}

/**
 * Fun��o para tornar campos obrigat�rio via js
 * ex:
 * fwSetNotRequired('des_nivel') => tornar des_nivel obrigat�rio
 * fwSetNotRequired('des_nivel,des_obs') => tornar des_nivel e des_obs
 * obrigat�rio
 */
function fwSetNotRequired(fields)
{
    if (fields)
    {
        try
        {
            var aFields = fields.split(',');
            if (aFields.length > 0)
            {
                for (var p in aFields)
                {
	                fwSetBordaCampo(jQuery('#' + aFields[0]), false);
                    var e = jQuery('#' + aFields[p]);
                    if( e.length == 0 )
                    {
                        jQuery('#' + aFields[p] + '_label_area').attr('needed', 'false');
                    	jQuery('*[name="'+aFields[p]+'"]').each(
                    		function()
                    		{
							jQuery(this).attr('needed', 'false');
							}
                    	);
					}
					else
					{
                    	e.attr('needed', 'false');
					}
                    if (REQUIRED_FIELD_MARK)
                    {
                        jQuery('#' + aFields[p] + '_label_required').html('');
                    }
                    else
                    {
                        jQuery('#' + aFields[p] + '_label_area').removeClass("fwFieldRequired");
                    }
                }
            }
            /*else
            {
                fwSetBordaCampo(jQuery('#' + aFields[0]), false);
                var e = jQuery('#' + aFields[0]);
                e.attr('needed', 'false');
                if (e.type == 'radio')
                {
                    jQuery('#' + aFields[0] + '_label_area').attr('needed', 'false');
                }
                if (REQUIRED_FIELD_MARK)
                {
                    jQuery('#' + aFields[0] + '_label_required').html('');
                }
                else
                {
					//jQuery('#'+aFields[0]).removeClass("fwFieldRequired");
                    jQuery('#' + aFields[0] + '_label_area').removeClass("fwFieldRequired");
                }
            }
            */
        }
        catch (e) {
        }
    }
}

//----------------------------------------------------------------------
function fwUpdateFieldsJson(res)
{
	if( res.data )
	{
		if( typeof res.data == 'string' )
		{
			res = jQuery.parseJSON(res.data);
		}
		else
		{
			res = res.data;
		}

	}
	else
	{
		if( typeof res == 'string')
		{
			res = jQuery.parseJSON(res);
		}
	}
	for(key in res)
	{
		var id = '#'+key.toLowerCase();
		jQuery('#'+key+',#'+key+'_disabled,'+key+'_temp,'+ id +','+id+ '_disabled'+','+id+ '_temp').val(res[key]);
	}
}
/**
* Retorna a quantidade de chamadas ajax pendentes que foram feitas
* utilizando a funcao fwAjaxRequest()
* @returns {Boolean}
*/
function fwChkRequestAjax()
{
	ajaxRequestCount = ajaxRequestCount || 0 ;
	if( ajaxRequestCount > 0  )
	{
		var msg;
		if( ajaxRequestCount > 1 )
		{
		   msg = 'Existem '+ajaxRequestCount+' requisi��es ajax pendentes!';
		}
		else
		{
		   msg = 'Existe '+ajaxRequestCount+' requisi��o ajax pendente!';
		}
		fwAlert(msg);
		return false;
	}
	return true;
}

/**
 * Cria (fecha) um semaforo. Utilizado para concorr�ncia.
 * @param idSemaphore idenficador do sem�foro
 * @param timeout (opcional) tempo em milisegundos para expirar o semaforo. Default: 20000 = 20 segundos.
 * @param idContainer ( opcional ) id do elemento que est� exibindo alguma mensagem de processamento enquando aguarda o retorno da requisi��o ajax
 * @returns TRUE, se o sem�foro foi criado; FALSE, caso contr�rio; NULL, caso o identificador n�o seja passado
 */
function fwSetSemaphore(idSemaphore, timeout, idContainer ) {
	if(!idSemaphore)
		return null;

	if ( ! fwSemaphoreIsOpen( idSemaphore ) )
		return false;

	if ( ! timeout )
		timeout = 20000;
	semaphore[ idSemaphore ] = setTimeout('fwCancelSemaphore("'+idSemaphore+'","'+idContainer+'");', timeout );
	return true;
}

/**
 * Cancela (abre) um sem�foro. Utilizado para concorr�ncia.
 * @param idSemaphore identificado do sem�foro
 * @param idContainer ( opcional ) id do elemento que est� exibindo alguma mensagem de processamento enquando aguarda o retorno da requisi��o ajax
*/
function fwCancelSemaphore(idSemaphore,idContainer) {
	if (!semaphore[idSemaphore])
		return;
	clearTimeout(semaphore[idSemaphore]);
	semaphore[idSemaphore] = null;
	ajaxRequestCount--;
	if( idContainer )
	{
		jQuery("#"+idContainer).html('');
	}
	//xhr.abort();
}

/**
 * Verifica se um sem�foro est� aberto ou fechado
 * @param idSemaphore identificador do sem�foro
 * @returns TRUE, caso o sem�foro esteja aberto; FALSE, caso esteja fechado; NULL, caso o identificador n�o seja passado.
 */
function fwSemaphoreIsOpen(idSemaphore)
{
	if (!idSemaphore)
		return true;
	return ( semaphore[ idSemaphore ] == null );
}