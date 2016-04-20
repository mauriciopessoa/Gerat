<?PHP

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

session_start();
include('../classes/banco.inc');
//			header("Pragma: public");
//			header("Expires: 0");
//			header("Cache-Control: private");
//			header("Content-Type: text/plain; charset=utf-8");
$pacote  = $_REQUEST['nomePacote'];
$seq_imagem   = $_REQUEST['valor'];
$extensao = $_REQUEST['extensao'];
if( !file_exists($seq_imagem)){
	print 'arquivo '.$seq_imagem.' n�o encontrado';
	return;
}
if(!$extensao)
  $extensao='jpeg';

if( $pacote and strrpos($seq_imagem,'.') === false) {
	// $conn = OCILogon("SIFISC","SIFISCDES","DESENV");
	$conn = new Banco();
	$sql="begin :SAIDA:=".$pacote." (".$seq_imagem.",:IMG_LOB); end;";
	//$stmt=OCIParse($clientedb->link,$sql);
	//$stmt=OCIParse($conn,$sql);
	$stmt=OCIParse($conn->link,$sql);
	OCIBindByName($stmt, ':SAIDA',&$saida,150);
	$lob = ocinewdescriptor($conn->link, OCI_D_LOB);
//	$lob = ocinewdescriptor($conn, OCI_D_LOB);
	OCIBindByName($stmt, ':IMG_LOB', &$lob, -1, OCI_B_BLOB);
	@OCIExecute($stmt,OCI_DEFAULT);
	if($lob) {
		@$image = $lob->load();
		if($image) {
			header('Content-Type: image/'.$extensao);
			print $image;
		} else {
			print '<center>Imagem<br>n�o<br>cadastrada</center>';
		}
	}
} else {
	print '<table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%"><tr><td style="vertical-align:center;text-align:center;border:0px dashed silver;">';
	print '<img src="'.$seq_imagem.'" alt="imagem">';
	print '</td></tr></table>';

}
?>
