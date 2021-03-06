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

require_once('Mail.php'); 
require_once('Mail/mime.php'); 

Function enviarEmail( $email_remetente
							,$nome_remetente
							,$email_destinatario
							,$nome_destinatario
							,$assunto
							,$mensagem
							,$anexos
) {
   	    
//Tratando a acentua��o do campo Nome Remetente($nome_remetente).
if ( utf8_encode($nome_remetente) != $nome_remetente )
    $nome_remetente = "=?iso8859-1?B?".base64_encode($nome_remetente)."?="; 
//Tratando a acentua��o do campo Nome Destinat�rio.
 if ( utf8_encode($nome_destinatario) != $nome_destinatario )
    $nome_destinatario = "=?iso8859-1?B?".base64_encode($nome_destinatario)."?=";     
  
//$assunto = "Agendamento On-Line -  Acompanhamento da Solicita��o"; 				
//Tratando a acentua��o do campo assunto(Subject) da Mala Direta.  	 
if ( utf8_encode($assunto) != $assunto )
	$assunto = "=?iso8859-1?B?".base64_encode($assunto)."?="; 
       	    			        
//$mensagem = "   Voc� est� recebendo este e-mail para o acompanhamento de sua solicita��o.";
	
//Montando o cabe��rio da mensagem. 
$headers['From']    = $nome_remetente.'<'.$email_remetente.'>';
$headers['To']      = $nome_destinatario.'<'.$email_destinatario.'>';
$headers['Subject'] = $assunto;
$headers['MIME-Version'] = '1.0';						
$headers['Content-Type'] = 'TEXT/HTML; charset=ISO-8859-1';
$headers['Content-Transfer-Encoding'] = '8BIT';
//		Criando uma nova instancia da classe mime
$mime = new Mail_Mime(); 

	    	
// Se vc precisar anexar algum arquivo � aqui que vc faz. Basta colocar a pasta em que o arquivo est�. 
//$mime->addAttachment("../index.php"); 
if ($anexos){
	$mensagem.="\nAnexos:$anexos";
	$anexos = explode(',',$anexos);
	foreach ($anexos as $k=>$v) {
		if (file_exists($v)){
	 		$mime->addAttachment($v); 
		} else {
			$mensagem.="\nArquivo:$v n�o encontrado para anexar";
		}
	}
}
 
// Setar aqui a mensagem de texto, que aparecer� nos webmails que n�o suportarem msg em formato HTML.
$mime->setTxtBody($mensagem); 
     
//$mime->setHTMLBody(); 
//$mime->setHTMLBody('<html><body><img src="cab_email.jpg"/><br><br><strong>Kleber Ferreira Gomes</strong></body></html>'); 

//Aqui vc adiciona a imagem, pode ser um logo, ao cabe�alho do email.
//$mime->addHTMLImage($logotipo); 

//Recuperando as informa��es do email
$corpo_msg = $mime->get(); 

//Montando o cabe��rio. 
$hdrs = $mime->headers($headers); 
  
//Enviando a mensagem
$mail_object =& Mail::factory('smtp');
$mail_object->send($email_destinatario, $hdrs, $corpo_msg); 
if(send)
 {	
 	return null;
 }
 else 
 {
 	return 'Mensagem N�O foi enviada para '.$email_destinatario;
 }
}
/*
enviarEmail('alexandre.vidal@ibama.gov.br'
,'N�cleo de internet - Agendamento On-Line'
,'Luis Eugenio'
,'luis.barbosa@ibama.gov.br'
,'Assunto do eugenio'
,'veja ai se esta mensagem chegou');
*/
?>

