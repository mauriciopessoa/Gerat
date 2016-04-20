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
* classe raiz de todos os controles que podem ser inseridos em um TForm
* Possui as propriedades:
* type, name, value, height, width, top, left, fontColor e visible
*/
abstract class TControl extends TElement
{
    protected $fldType;
    private $error;
    private $enabled;
    private $helpFile;
    private $tooltip;
    private $readOnly;

    public function __construct( $tagType, $strName, $strValue = null )
    {
        parent::__construct( $tagType );
        $this->setClass( 'fwField' );
        $this->setFieldType( 'edit' );
        $this->setName( $strName );
        $this->setValue( $strValue );
        $this->setEnabled( true );
    }

    public function show( $print = true )
    {

        // se tiver top ou left a posicao sera absoluta
        if ( (string)$this->getTop() != "" || (string)$this->getLeft() != "" )
        { $this->setCss( 'position', 'absolute' ); }
        else
        { $this->setCss( 'position', 'relative' ); }

        // colocar o tipo do campo na propriedade
        $this->setProperty( 'fieldtype', $this->getFieldType() );

        // propriedades que o campo oculto nao precisa
        if ( $this->getFieldType() == 'hidden' )
        {
            $this->setProperty( 'size', null );
            $this->setProperty( 'maxlength', null );
            $this->clearCss();
        }

		if($this->getReadOnly())
		{
			$this->setProperty('readonly' ,'true');
			if( $this->getClass() == 'fwField' || $this->getClass() == ''  )
			{
				$this->setClass('fwField fwFieldReadonly'.($this->getClass()=='fwField'?'':' '.$this->getClass()),false);
			}
		}
        if ( !$this->getEnabled() )
        { $this->setProperty( 'disabled', 'true' ); }

        // como os campos desabilitados, n�o s�o postados,
        // criar os campos ocultos para nao perder os valores quando o form for postado
        $disableHtml=null;

        if ( $this->getEnabled() == false )
        {
            if ( $this->getTagType() == 'img' )
            {
            // ainda n�o tenho o que fazer com uma imagem desabilitada
            }
            else
            {

    		    /*
    		    if ( !$this->getCss( 'color' ) )
    		    {
           	    	$this->setcss( 'color', '#52A100' );
           	    }
                if( $this->getFieldType() != 'link' &&  $this->getFieldType() != 'tag' )
                {
    		        if( ! $this->getcss( 'background-color') )
    		        {
    		        	$this->setcss( 'background-color', '#F3F3F3' );
					}
    		        if( ! $this->getcss( 'border') )
    		        {
                		$this->setcss( 'border', '1px solid silver' );
					}
				}
				*/
				$this->setClass($this->getClass().' fwFieldDisabled',false);
                $this->setEvent( null );
                $value=$this->getValue();

                // campo memo � uma tag textarea ent�o n�o pode ter um campo oculto relacionado a ele, basta colocar readonly
                if ( $this->getFieldType() == 'memo' )
                {
                    $this->setProperty( 'disabled', null );
                    $this->setProperty( 'readonly', 'true' );
                    $this->setEnabled( true );
                }
                else if( $this->getFieldType() === "select" )
                {
                    $h=new THidden( $this->getName() );
                    if( $this->getRequired() )
                    {
			   			$h->setProperty('needed','true');
					}
					// se o campo estiver em um gride ele � um array ent�o fazer a jogada com o neme e id conforma abaixo
                    $h->setId( $this->getId() );
                    $this->setName( $this->getId() );
                    $h->clearCss();

                    if ( isset( $value ) )
                    { $h->setValue( $value ); }

                    //$this->add($h);
                    $disableHtml=$h->show( false );
                }
                else if( $this->getFieldType() === 'multiselect' )
                {
                    forEach( $value as $k => $v )
                    {
                        $h = new THidden( $this->getId().'[]' );
                        $h->clearCss();
                        $h->setValue( $v );
	                    if( $this->getRequired() )
    	                {
				   			$h->setProperty('needed','true');
						}
			   			//$h->setProperty('required',($this->getRequired()?'true':'false'));
                        $disableHtml .= $h->show( false );
                    //$this->add($h);
                    }
                }
                else if( !is_array( $this->getValue() ) )
                {
                    $h=new THidden( $this->getName() );
                    // se o campo estiver em um gride ele � um array ent�o fazer a jogada com o neme e id conforma abaixo
                    $h->setId( $this->getId() );
                    $this->setName( $this->getId() );

                    $h->clearCss();
                    $h->setValue( $this->getValue() );
                    if( $this->getRequired() )
                    {
			   			$h->setProperty('needed','true');
					}
                    //$this->add($h);
                    $disableHtml=$h->show( false );
                }

                // acrecentar disabled ao id para diferenciar do campo oculto criado automaticamente para os campos desabilitados
                if ( strpos( $this->getId(), '_disabled' ) === false && !$this->getEnabled() )
                { $this->setId( $this->getId().'_disabled' ); }
            }
        }

       	// se o campo tiver erro, ajustar a cor da borda para vermelha
		if($this->getError())
		{
			$this->setCss('border','1px solid #ff0000');
		}
        return parent::show( $print ).$disableHtml.$this->getHelpOnLine();
    }

    //-------------------------------------------------------------------------
    public function setFieldType( $newFieldType )
    {
        $this->fldType=$newFieldType;
        return $this;
    }

    public function getFieldType()
    { return strtolower( $this->fldType ); }
    /*public function setValue($newValue)
    {
        $this->value=$newValue;
    }
    //------------------------------------------------------------------------
    public function getValue()
    {
        return $this->value;
    }
    */
    public function setTop( $newTop = null )
    { $this->setCss( 'top', $newTop ); return $this;}

    public function getTop()
    { return $this->getCss( 'top' ); }

    public function setLeft( $newLeft = null )
    { $this->setCss( 'left', $newLeft ); return $this;}

    public function getLeft()
    { return (string)$this->getCss( 'left' ); }

    //-------------------------------------------------------------------------
    public function setFontColor( $newFontColor = null )
    { $this->setCss( 'color', $newFontColor ); return $this;}

    public function getFontColor()
    { return (string)$this->getCss( 'color' ); }

    //-------------------------------------------------------------------------
    public function setWidth( $newWidth = null )
    { $this->setCss( 'width', $newWidth ); return $this; }

    public function getWidth( $strMinWidth = null )
    {
        if ( (string)$this->getCss( 'width' ) == "" )
        { return $strMinWidth; }

        return (string)$this->getCss( 'width' );
    }

    //-------------------------------------------------------------------------
    public function setHeight( $newHeight = null )
    { $this->setCss( 'height', $newHeight ); return $this;}

    public function getHeight( $strMinHeight = null )
    {
        if ( (string)$this->getCss( 'height' ) == "" )
        { return $strMinHeight; }

        return (string)$this->getCss( 'height' );
    }

    //-------------------------------------------------------------------------
    public function setVisible( $boolNewValue = true )
    {
        if ( (bool)$boolNewValue === true )
        { $this->setCss( 'display', 'inline' ); }
        else
        { $this->setCss( 'display', 'none' ); }
        return $this;
    }

    //-------------------------------------------------------------------------
    public function getVisible()
    { return ($this->getCss( 'display' ) != 'none'); }

    //-------------------------------------------------------------------------
    /**
    * Metodo adicionado apenas para n�o dar conflito com a fun��o de valida��o do TForm
    *
    */
    public function getRequired()
    { return false; }
    /**
    * Define o erro encontrado no controle
    *
    * @param mixed $strNewError
    */
    public function setError( $strNewError = null )
    {
        $this->error=$strNewError;
        return $this;
    }
    /**
    * Acrescenta o erro no final da string error com quebra de linha
    *
    * @param mixed $strNewError
    */
    public function addError( $strNewError = null )
    {
        if ( is_array( $strNewError ) )
        { $strNewError = implode( '\n', $strNewError ); }

        if ( !is_null( $strNewError ) && $strNewError != "" )
        {
            $this->error .= isset( $this->error ) ? '\n' : "";
            $this->error .= $strNewError;
            return true;
        }

        return false;
    }

    public function getError()
    { return $this->error; }

    public function setEnabled( $newBoolValue = null )
    {
        //print $this->getFieldType();
        if ( !strpos( '(hidden,html)', $this->getFieldType() ) )
        {
        //print ' desabilitei<br>';
        $this->enabled = $newBoolValue === null ? true : (bool)$newBoolValue; }
        return $this;
    }

    public function getEnabled()
    { return $this->enabled; }

    public function clear()
    { $this->setValue( null ); }

    public function setHint( $strNewHint = null )
    { $this->setProperty( 'title', $strNewHint ); return $this;}

    public function getHint()
    { return $this->getProperty( 'title' ); }

    //-----------------------------------------------------------------------------
    /**
    * M�todo para criar ajuda on-line em um campo
    * O parametro $strHelpFile recebe o nome de um arquivo com conteudo html para ser exibido
    * se n�o for informado assume o id do campo.
    * O arquivo dever� estar no diret�rio ajuda/ na raiz da aplica��o.
    * Poder ser informada tambem o endere�o (url) da pagina de help
    * Exemplo: $nom->setHelpFile('nom_pessoa','Nome da Pessoa',200,500);
    * Exemplo: $nom->setHelpFile('http://localhost/sistema/texto_ajuda.html','Exemplo de help on-line',200,500);
    * @param mixed $strWindowHeader
    * @param mixed $intShowHeight
    * @param mixed $intShowWidth
    * @param mixed $strHelpFile
    * @param mixed $strButtonImage
    */
    /*public function setHelpFile($strWindowHeader=null,$intShowHeight=null,$intShowWidth=null,$strHelpFile=null,$strButtonImage=null)
    {
        $strHelpFile = is_null($strHelpFile) ? $this->getId() : $strHelpFile;
        $this->helpFile[0] = $strHelpFile;
        if( $strHelpFile)
        {
            $this->helpFile[1] = is_null( $strWindowHeader ) 	? "Ajuda on-line" 	: $strWindowHeader;
            $this->helpFile[2] = is_null( $intShowHeight )		? 250 		: $intShowHeight;
            $this->helpFile[3] = is_null( $intShowWidth ) 		? 500 		: $intShowWidth;
            $this->helpFile[4] = is_null( $strButtonImage ) 	? $this->getBase().'imagens/fwajuda.gif' : $strButtonImage;
        }
    }
    //-----------------------------------------------------------------------------
    public function getHelpFile()
    {
        return $this->helpFile;
    }
    //-----------------------------------------------------------------------------
    public function getLinkHelpFile()
    {
        if($this->getHelpFile())
        {
            $helpFile = $this->getHelpFile();
            //return "<a id=\"".$this->getId()."_help_file_a\" href=\"#\" title=\"{$helpFile[1]}\" onClick=\"fwModalBox('Ajuda','{$helpFile[0]}',{$helpFile[2]},{$helpFile[3]})\"><img style=\"vertical-align:middle;border:none;cursor:pointer;width:16px;height:16px;\" src=\"{$helpFile[4]}\"></a>";
            //return "<a id=\"".$this->getId()."_help_file_a\" href=\"#\" title=\"{$helpFile[1]}\" onClick=\"top.app_modalBox('{$helpFile[1]}','{$helpFile[0]}',{$helpFile[2]},{$helpFile[3]})\"><img style=\"vertical-align:middle;border:none;cursor:pointer;width:16px;height:16px;\" src=\"{$helpFile[4]}\"></a>";
            return "<a id=\"".$this->getId()."_help_file_a\" href=\"#\" title=\"{$helpFile[1]}\" onClick=\"top.app_modalBox('{$helpFile[1]}','".$this->getBase()."callbacks/helpOnLineLoad.php?file={$helpFile[0]}',{$helpFile[2]},{$helpFile[3]})\"><img style=\"vertical-align:middle;border:none;cursor:pointer;width:16px;height:16px;\" src=\"{$helpFile[4]}\"></a>";
        }
        return null;
    }
    */
    /**
    * M�todo para criar ajuda on-line em um campo
    * O parametro $strHelpFile recebe o nome de um arquivo com conteudo html para ser exibido
    * se n�o for informado assume o id do campo.
    * O arquivo dever� estar no diret�rio ajuda/ na raiz da aplica��o.
    * Poder ser informada tambem o endere�o (url) da pagina de help
    * Exemplo: $nom->setHelpFile('nom_pessoa','Nome da Pessoa',200,500);
    * Exemplo: $nom->setHelpFile('http://localhost/sistema/texto_ajuda.html','Exemplo de help on-line',200,500);
    * @param mixed $strWindowHeader
    * @param mixed $intShowHeight
    * @param mixed $intShowWidth
    * @param mixed $strHelpFile
    * @param mixed $strButtonImage
    * @param boolean $boolReadOnly
    */
    public function setHelpOnLine( $strWindowHeader = null, $intShowHeight = null, $intShowWidth = null, $strHelpFile = null, $strButtonImage = null, $boolReadOnly = null )
    {
        $strHelpFile      =is_null( $strHelpFile ) ? $this->getId() : $strHelpFile;
        $this->helpFile[0]=$strHelpFile;

        if ( $strHelpFile )
        {
            $this->helpFile[1]=is_null( $strWindowHeader ) ? "Ajuda on-line" : $strWindowHeader;
            $this->helpFile[2]=is_null( $intShowHeight ) ? 600 : $intShowHeight;
            $this->helpFile[3]=is_null( $intShowWidth ) ? 800 : $intShowWidth;
            $this->helpFile[4]=is_null( $strButtonImage ) ? $this->getBase().'imagens/icon_help-16x16.png' : $strButtonImage;
            $this->helpFile[5]=is_null( $boolReadOnly ) ? false : $boolReadOnly;
           	$this->helpFile[6]='';
            if( preg_match('/\.\.\//',$this->getBase()) > 0 )
            {
            	$this->helpFile[6]=APLICATIVO;
			}
            if ( strpos( $this->helpFile[4], '/' ) === false )
            { $this->helpFile[4] = $this->getBase().'imagens/'.$this->helpFile[4]; }
        }
        return $this;
    }

    //-----------------------------------------------------------------------------
    public function getHelpOnLine()
    {
        if ( is_array( $this->helpFile ) )
        {
   	        //style="float:right;width:28px; height:15px;vertical-align:top;margin-right:2px;" title="Fechar"
        	//return "<a id=\"".$this->getId()."_help_file_a\" href=\"#\" title=\"{$this->helpFile[1]}\" onClick=\"top.app_modalBox('{$this->helpFile[1]}','".$this->getBase()."callbacks/helpOnLineLoad.php?file={$this->helpFile[0]}&readonly={$this->helpFile[5]}&aplicativo={$this->helpFile[6]}',{$this->helpFile[2]},{$this->helpFile[3]})\"><img style=\"vertical-align:middle;border:none;cursor:pointer;width:16px;height:16px;\" title=\"Ajuda\" src=\"{$this->helpFile[4]}\"></a>";
        	//return "<a id=\"".$this->getId()."_help_file_a\" href=\"#\" title=\"{$this->helpFile[1]}\" onClick=\"fwOpenHelpFile('".$this->helpFile[0]."')\"><img style=\"vertical-align:middle;border:none;cursor:pointer;width:16px;height:16px;\" title=\"Ajuda\" src=\"{$this->helpFile[4]}\"></a>";
        	return "<a id=\"".$this->getId()."_help_file_a\" href=\"#\" title=\"{$this->helpFile[1]}\" onClick=\"fwFaceBox('".$this->helpFile[0]."')\"><img style=\"vertical-align:middle;border:none;cursor:pointer;width:16px;height:16px;\" title=\"Ajuda\" src=\"{$this->helpFile[4]}\"></a>";
        }
	}
	//------------------------------------------------------------------------------
	public function setTooltip($strTitle=null,$strText=null,$strImagem=null)
	{
		$strText = str_replace(chr(10),'<br/>',$strText);
		$strTittle = str_replace(chr(10),'',$strText);
		$this->tooltip = new TTooltip($strTitle,$strText,$strImagem);
		return $this;
	}
	//------------------------------------------------------------------------------
	public function getTooltip()
	{
		return $this->tooltip;
	}
	public function setReadOnly($boolNewValue=null)
	{
		$this->readOnly = $boolNewValue;
        return $this;
	}
	public function getReadOnly()
	{
		return ( $this->readOnly === true) ? true : false;
	}
}
?>