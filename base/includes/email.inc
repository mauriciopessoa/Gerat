<?php

/*
 * Formdin Framework
 * Copyright (C) 2012 Ministério do Planejamento
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
 * Este arquivo é parte do Framework Formdin.
 * 
 * O Framework Formdin é um software livre; você pode redistribuí-lo e/ou
 * modificá-lo dentro dos termos da GNU LGPL versão 3 como publicada pela Fundação
 * do Software Livre (FSF).
 * 
 * Este programa é distribuído na esperança que possa ser útil, mas SEM NENHUMA
 * GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer MERCADO ou
 * APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/LGPL em português
 * para maiores detalhes.
 * 
 * Você deve ter recebido uma cópia da GNU LGPL versão 3, sob o título
 * "LICENCA.txt", junto com esse programa. Se não, acesse <http://www.gnu.org/licenses/>
 * ou escreva para a Fundação do Software Livre (FSF) Inc.,
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
   	    
//Tratando a acentuação do campo Nome Remetente($nome_remetente).
if ( utf8_encode($nome_remetente) != $nome_remetente )
    $nome_remetente = "=?iso8859-1?B?".base64_encode($nome_remetente)."?="; 
//Tratando a acentuação do campo Nome Destinatário.
 if ( utf8_encode($nome_destinatario) != $nome_destinatario )
    $nome_destinatario = "=?iso8859-1?B?".base64_encode($nome_destinatario)."?=";     
  
//$assunto = "Agendamento On-Line -  Acompanhamento da Solicitação"; 				
//Tratando a acentuação do campo assunto(Subject) da Mala Direta.  	 
if ( utf8_encode($assunto) != $assunto )
	$assunto = "=?iso8859-1?B?".base64_encode($assunto)."?="; 
       	    			        
//$mensagem = "   Você está recebendo este e-mail para o acompanhamento de sua solicitação.";
	
//Montando o cabeçário da mensagem. 
$headers['From']    = $nome_remetente.'<'.$email_remetente.'>';
$headers['To']      = $nome_destinatario.'<'.$email_destinatario.'>';
$headers['Subject'] = $assunto;
$headers['MIME-Version'] = '1.0';						
$headers['Content-Type'] = 'TEXT/HTML; charset=ISO-8859-1';
$headers['Content-Transfer-Encoding'] = '8BIT';
//		Criando uma nova instancia da classe mime
$mime = new Mail_Mime(); 

	    	
// Se vc precisar anexar algum arquivo é aqui que vc faz. Basta colocar a pasta em que o arquivo está. 
//$mime->addAttachment("../index.php"); 
if ($anexos){
	$mensagem.="\nAnexos:$anexos";
	$anexos = explode(',',$anexos);
	foreach ($anexos as $k=>$v) {
		if (file_exists($v)){
	 		$mime->addAttachment($v); 
		} else {
			$mensagem.="\nArquivo:$v não encontrado para anexar";
		}
	}
}
 
// Setar aqui a mensagem de texto, que aparecerá nos webmails que não suportarem msg em formato HTML.
$mime->setTxtBody($mensagem); 
     
//$mime->setHTMLBody(); 
//$mime->setHTMLBody('<html><body><img src="cab_email.jpg"/><br><br><strong>Kleber Ferreira Gomes</strong></body></html>'); 

//Aqui vc adiciona a imagem, pode ser um logo, ao cabeçalho do email.
//$mime->addHTMLImage($logotipo); 

//Recuperando as informações do email
$corpo_msg = $mime->get(); 

//Montando o cabeçário. 
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
 	return 'Mensagem NÃO foi enviada para '.$email_destinatario;
 }
}
/*
enviarEmail('alexandre.vidal@ibama.gov.br'
,'Núcleo de internet - Agendamento On-Line'
,'Luis Eugenio'
,'luis.barbosa@ibama.gov.br'
,'Assunto do eugenio'
,'veja ai se esta mensagem chegou');
*/
?>

