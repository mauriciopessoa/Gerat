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
class TCaptcha extends TButton
{
    private $input;
	public function __construct($strName,$strHint=null,$intCaracters=null)
	{
        $intCaracters = is_null($intCaracters) ? 6 : $intCaracters;
        $intCaracters = $intCaracters > 10 ? 10 : $intCaracters;
        $url = $this->getBase().'classes/captcha/CaptchaSecurityImages.class.php?field='.$this->removeIllegalChars($strName).( is_null( $intCaracters ) ? '' : '&characters='.$intCaracters);
        parent::__construct($strName.'_img',$strValue,null,"javascript:this.src='".$url."&'+ Math.random()",null,null,null,'C�digo de Seguran�a - Digite no campo ao lado os caracteres que est�o impressos nesta imagem!');
        //parent::__construct($strName.'_img',$strValue,null,"javascript:document.getElementById('".$strName."_img').src = '".$url."&'+ Math.random()",null,null,null,'Clique aqui para atualizar a imagem!');
		$this->setFieldType('captcha');
        $this->setImage($url);
        $this->input = new TEdit($strName,null,6,true,6);
        $this->input->setHeight(25);
        $this->input->setCss('font-size','14px');
        $this->input->setCss('font-weight','bold');
        $this->input->setProperty('autocomplete','off');
        //$this->input->setValue('');
        if(!is_null($strHint) )
        {
            $this->setHint($strHint);
        }
        $this->add($this->input);
	}
    public function getInput()
    {
        return $this->input;
    }
    public function validate()
    {
		if( strtolower($this->removeIllegalChars($this->getInput()->getValue())) != strtolower($this->removeIllegalChars($_SESSION[$this->getInput()->getId().'_code'])) )
		{
			$this->setError(strtolower($this->removeIllegalChars($this->getInput()->getValue())) .' e '.
			strtolower($this->removeIllegalChars($_SESSION[$this->getInput()->getId().'_code'])) );
			//'C�digos de seguran�a n�o foi digitado corretamente!');
		}
		return ( (string)$this->getError()==="" );
    }
}
/*$f = new TCaptcha('des_captcha',null,6,true);
$f->show();
*/
?>