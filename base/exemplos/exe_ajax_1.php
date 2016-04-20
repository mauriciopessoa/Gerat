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
* Primeiro exemplo.
* Adicionar bot�o ajax em um form no padr�o normal com submit
*/

// fazer o include das fun��es ajax quando receber uma requisi��o ajax;
if( isset($_REQUEST['ajax'] ) && $_REQUEST['ajax'] == 1 )
{
	require_once($this->getBase().'includes/formDin4Ajax.php');
}

$frm = new TForm('Formul�rio Ajax - Exemplo N� 1 - M�dulo: exe_ajax_1.php ',400,600);
$frm->addHtmlField('html','<br><center><b>Exemplo de transforma��o de um formul�rio no formato padr�o ( submit ) para ajax.</b></center><br>Os bot�es abaixo foram trasnformados para o padr�o ajax, alterando a linha:<br>$frm->setActions("Gravar,Excluir"); <br>para:<br>$frm->addButtonAjax("Gravar");<br>$frm->addButtonAjax("Excluir");<br<br>');

$frm->addTextField('nome','Nome:',100,true,50);
$frm->addDateField('nasc','Nascimento:',true);
$frm->addNumberField('salario','Sal�rio',10,false,2);
$frm->addButton('Normal',null,'btnTeste',null,null,true,false);
$frm->addButtonAjax('Normal',null,null,null,null,null,null,null,null,'btnAjax',null,true,false);
$frm->addButtonAjax('Entrar',null,'fwValidateFields()','resultado','login','Validando informa��es','text',false);

if( $acao =='login') {
    sleep(1);
    echo 'Passo 1 ok';die();
    if( $frm->get('login')=='admin' && $frm->get('senha')=='admin'){
        $_SESSION[APLICATIVO]['conectado']=true;
        prepareReturnAjax(1);
    }else {
        prepareReturnAjax(0);
    }
}

$_POST['formDinAcao'] = isset($_POST['formDinAcao']) ? $_POST['formDinAcao'] : '';
switch($_POST['formDinAcao'])
{
	case 'testar_callback':
		$res['NUM_CPF'][0]= '45427380191';
		$res['NUM_CPF'][1]= '12345678909';
		$frm->setReturnAjaxData($res);
		// retornar
		//$frm->addReturnAjaxData(array('cod_uf'=>53));
		//$frm->setReturnAjaxData(array('cod_uf'=>53));
		$frm->setMessage('Registro OK!');
		// prepareReturnAjax(1,array('cod_uf'=>53),'Registro Ok');
	break;
	case 'Gravar':
		/*
		$res['DAT_ITEM'][0] = '01/01/2012';
		$res['NOM_ITEM'][0] = "CORA��O";
		prepareReturnAjax(1,$res);
		prepareReturnAjax(1,"'CORA��O'");
		*/
		sleep(1); // temporizador de 1 segundo para retornar
		if( $frm->validate() )
		{
			$frm->setMessage('A��o salvar executada com SUCESSO!!!');
		}
	break;
	//---------------------------------------------------------------------------------
	case 'Excluir':
		//sleep(1); // temporizador de 1 segundo para retornar
		if( $frm->validate() )
		{
			$frm->setMessage('A��o Excluir executada com SUCESSO!!!');
		}
	break;
	//---------------------------------------------------------------------------------
}

// antes
//$frm->setAction('Salvar,Excuir');

// depois
// bot�o ajax
$frm->addButtonAjax('Gravar',null,null,null,null,'Gravando. Aguarde...','json');
// bot�o ajax
$frm->addButtonAjax('Excluir',null,null,null,null,'Excluindo Registro...');
// chamada ajax manual
$frm->addButtonAjax('Meu Callback',null,'meuBeforeSend','meuCallBack','testar_callback'
			,'Testando Ajax!!!'
			,'json');
$frm->addButton('Teste Ajax',null,'btnTeste','teste()');

$frm->setAction('Refresh');
$frm->addButton('Confirmar',null,'btnConfirmar','confirmacao()');

$frm->show();
?>
<script>
function meuCallBack(res)
{
    //alert( res );
    alert( res.message );
    alert( res.data);
    alert( res.data.NUM_CPF );

    //alert( res.message);
    //alert( res.data.NUM_CPF[0]);
   	//data = jQuery.parseJSON( res.data );
	alert( 'res.message='+res.message+
		   '\nres.data.NUM_CPF[0]='+res.data.NUM_CPF[0]+
		   '\nres.data.NUM_CPF='+res.data.NUM_CPF);
    //utilizar a funcao fwUpdateFieldsJson para atualizar os campos
    //ex: fwUpdateFieldsJson(res);
}
function meuBeforeSend()
{
	//alert('N�o vai passar');
	if( confirm('Fun��o beforeSend foi chamada. Deseja continuar ?'))
		return true;
	return false;
}
function teste()
{


    //fwBlockScreen('red','40',pastaBase+'imagens/processando_red.gif','Aguarde');
     //alert( 'Documento:'+jQuery(document).scrollTop()+'\nbody:'+document.body.scrollTop );

     //return;
    //return;
    //fwBlockScreen( maskColor, opacity, imgWait, txtWait, imgWidth, imgHeight,txtColor)

	/*if( ! fwValidateForm() )
	{
		return false;
	}
	*/
	fwAjaxRequest(
            {'action':'Gravar'
            ,'dataType':'json'
            ,'async':false
            ,'msgLoad':'Gravando. Aguarde...'
            //,'containerId':'html'
            ,'callback':function(res)
            {
            	alert( res );
            	try{ alert( '1 '+res.data );}catch(e){}
            	/*
            	try{ alert( '1 '+res.data );}catch(e){}
            	try{ alert( '2 '+res.data.DAT_ITEM );}catch(e){}
            	try{ alert( '3 '+res.data.NOM_ITEM );}catch(e){}
            	*/
            	var o = jQuery.parseJSON(res.data);
            	try{ alert( '8 '+o.DAT_ITEM );}catch(e){alert('erro')}

            	var o  = fwParseJSON( res.data );
            	try{ alert( '9 '+o.DAT_ITEM );}catch(e){}
            }
            });
}
function confirmacao(status)
{
    status = status||null;
	if( !status)
	{
		fwConfirm('Tem certeza que testou esta mensagem?', confirmacao, confirmacao, 'Sim', 'N�o', 'Salvar arquivo');
	}
    else
    {
        alert('Resultado:'+status);
    }

}
function resultado( res)
{
	alert( res);
}
</script>
