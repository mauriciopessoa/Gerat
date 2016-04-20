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
function osPesquisar()
{
	var btnPesquisar = fwGetObj('btnPesquisar');
	var obj = fwGetObj('gdsearch');

	if (obj)
	{
		obj.innerHTML = '';
	}

	try
	{
		jQuery("#html_msg").hide();
		jQuery("#btnCadastrar").hide();
	}
	catch (e)
	{
	}
	obj = fwGetObj('formsearch_area');

	var html = jQuery('#html_gride');
	html.width(html.width() - 5);
	html.html('<center><span style="font-size:18px;color:blue;padding-top:50px;">Pesquisando...<\/span><br><img src=' + pastaBase + '/imagens/processando.gif><center>');
	btnPesquisar.disabled = true;
	btnPesquisar.value = 'Aguarde...';
	btnPesquisar.style.color = '#ff0000';
	// colocar um timer para carregar a imagem de processando.gif on moizilla
	window.setTimeout("fwFazerAcao('pesquisar');", 500);
}

/**
* Seleciona o valor, atualiza os campos, do formul�rio chamou a consulta din�mica ,
* executa a fun��o de callback e fecha a janela da consulta din�mica
*
* @param strFields
* @param strValues
* @param strFunction
* @param timeOut
* @param strFocusField
*/
function osSelecionar(strFields, strValues, strFunction, timeOut, strFocusField)
{
	var parentWin 	= getParentWin();
	var winId 		= jQuery('#prototypeParentWin').val();
	var dialogId 	= jQuery('#dialogId').val();
	if( parentWin )
	{
		if( strFunction )
		{
			var form = jQuery('form');
			var params = { 'fields':form.serialize(), 'form':form.get(0) };
		}
    	if( typeof top.app_getObj == 'function' && ! winId && !dialogId )
       	{
			if (strFocusField)
			{
				try
				{
					top.app_getObj(strFocusField).focus();
				}
				catch (e)
				{
				}

			}
			top.app_atualizarCampos(strFields, strValues);
			if (strFunction)
			{
				try
				{
					top.app_executarFuncao(strFunction,params);
				}
				catch (e)
				{
					alert(e.message);
				}
			}
		}
		else
		{
			if (strFocusField)
			{
				try
				{
					parentWin.fwGetObj(strFocusField).focus();
				}
				catch (e){}
			}
			parentWin.fwUpdateFields(strFields, strValues);
			if (strFunction)
			{
				try
				{
					parentWin.fwExecutarFuncao(strFunction,params);
				}
				catch (e)
				{
					alert(e.message);
				}
			}
		}
		timeOut = timeOut | 300;
		setTimeout('fechar();', timeOut);
	}
}
//------------------------------------------------
function osStart(fieldLocal, fieldParent, autoStart, filterFields)
{
	// com iframe
	var aDbFields = filterFields.split(',');
	var aFormFields = fieldLocal.split(',');

	if (typeof top.app_getObj == 'function')
	{
		try
		{
			if (fieldParent && fieldLocal)
			{
				//                              alert( fieldLocal+'\n'+fieldParent+'\n'+filterFields);
				var f;
				var aParts;
				var from;
				var to;

				for (i = 0; i < aDbFields.length; i++)
				{
					aParts = aDbFields[i].split('|');
					from = aFormFields[i].toLowerCase();
					to = aParts[0];
					//                                      alert( 'de: '+ from +' para: ' + to );

					if (top.app_prototype)
					{
						var parentWin = top.Windows.getWindow(fwGetObj('prototypeParentWin').value);
						f = parentWin.getContent().contentWindow.fwGetObj(from);
					}

					else
					{
						f = top.app_getObj(from);
					}

					if (f && f.value)
					{
						fwGetObj(to).value = f.value;
					}
				}

			/*if( top.app_prototype )
					{
							var parentWin = top.Windows.getWindow(fwGetObj('prototypeParentWin').value );
							f = parentWin.getContent().contentWindow.fwGetObj(fieldParent);

					}
					else
					{
							f = top.app_getObj(fieldParent);
					}
					if( f && f.value)
					{
							fwGetObj(fieldLocal).value = f.value;
					}
					*/
			}
		}
		catch (e)
		{
		}
	}

	else
	{
		try
		{
			if (fieldParent && fieldLocal)
			{
				var f;
				var aParts;
				var from;
				var to;

				for (i = 0; i < aDbFields.length; i++)
				{
					aParts = aDbFields[i].split('|');
					from = aFormFields[i].toLowerCase();
					to = aParts[0];
					//                                      alert( 'de: '+ from +' para: ' + to );

					if (top.app_prototype)
					{
						var parentWin = top.Windows.getWindow(fwGetObj('prototypeParentWin').value);
						f = parentWin.getContent().contentWindow.fwGetObj(from);
					}

					else
					{
						f = top.fwGetObj(from);
					}

					if (f && f.value)
					{
						fwGetObj(to).value = f.value;
					}
				}
			/*
					var f;
					if( top.app_prototype )
					{
							var parentWin = top.Windows.getWindow(fwGetObj('prototypeParentWin').value );
							f = parentWin.getContent().contentWindow.fwGetObj(fieldParent);

					}
					else
					{
							f = top.fwGetObj(fieldParent);
					}
					if( f && f.value)
					{
							fwGetObj(fieldLocal).value = f.value;
					}
					*/
			}
		}
		catch (e)
		{
		}
	}

	if (autoStart)
	{
		// so disparar a consulta se tiver algum campo preenchido
		if (filterFields)
		{
			var aTemp = filterFields.split(',');
			var aField;
			var ok = false;

			for (i = 0; i < aTemp.length; i++)
			{
				aField = aTemp[i].split('|');

				if (fwGetObj(aField[0]).value)
				{
					ok = true;
					break;
				}
			}
		}

		else
		{
			ok = true;
		}

		if (ok)
		{
			osPesquisar();
		}
	}
}

/**
* Preencher os campos locais com os valores valores dos campos do formul�rio que executou a consulta din�mica,
* para compor a condi��o da consulta sql
*
* @param formFields
*/
function osGetTopValues(formFields)
{
	if (! formFields )
	{
		return;
	}
	var aTemp = formFields.split(',');
	var aField;
	var eTop;
	var eLocal
	var parentWin 	= getParentWin();
	var winId 		= jQuery('#prototypeParentWin').val();
	var dialogId 	= jQuery('#dialogId').val();
	var value;
	var localField 	= null;
	for (i = 0; i < aTemp.length; i++)
	{
		aField = aTemp[i].split('|');
		aField[1] = aField[1] ? aField[1] : aField[0];
		localField = fwGetObj(aField[1] );
		if (parentWin && localField && localField.value == '' )
		{
			if ( typeof parentWin.app_getObj == 'function' )
			{
				eTop = parentWin.app_getObj( aField[0] );
			}
			else
			{
				eTop = parentWin.fwGetObj(aField[0] );
			}
			if (eTop )
			{
				if (eTop.value)
				{
					if (eLocal = fwGetObj(aField[1]))
					{
						eLocal.value = eTop.value;
					}
				}
			}
		}
	}
}

/**
	 * fechar
	 *
	 *
	 * @return
	 *
	 * @see
	 */
function fechar()
{
	try
	{
		fwClose_modal_window(); // formdin4
	}
	catch (e)
	{
		try
		{
			top.GB_hide(); // formdin3
		}
		catch (e)
		{
		}
	}
}

/**
* retorna a janela que abriu a consulta din�mica
*
*/
function getParentWin()
{
	var winId 		= jQuery('#prototypeParentWin').val();
	var dialogId 	= jQuery('#dialogId').val();
	var parentWin	= top;
	var parentDialog;

	if( winId )
	{
		// janelas prototype
		parentWin = top.Windows.getWindow(winId);
		parentWin = parentWin.getContent().contentWindow;
	}
	else if( dialogId )
	{
		// Dialog jquery UI
		parentWin = top.fwGetParentDialog( dialogId );
		if( parentWin != top )
		{
			parentWin = parentWin.get(0).contentWindow;
		}
		closeFunction = "fechar()";
	}
	return parentWin;
}