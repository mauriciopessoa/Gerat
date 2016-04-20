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

class TZip extends ZipArchive
{
	private $files=null;
    private $tempFile;
	private $base;
	public function __construct()
	{
		// limpar arquivos tempor�rios
		$e = new TElement();
		$this->base = $e->getBase();
		// limpa diret�rio tempor�rio
		$t=time();
		$h=opendir($this->base."tmp");
		while($file=readdir($h)) {
    		if(substr($file,0,3)=='tmp')
			{
        		$path=$this->base.'tmp/'.$file;
        		if($t-filemtime($path)>300)
				{
					@unlink($path);
				}
    		}
		}
		closedir($h);
		// apagar arquivos tempor�rios do diretorio tmp/ da aplica��o
		$tempDir = './tmp/';
		if( file_exists('./tmp/'))
		{
			$h=opendir($tempDir);
			while($file=readdir($h)) {
    			if(substr($file,0,3)=='tmp')
				{
        			$path=$tempDir.$file;
        			if($t-filemtime($path)>300)
					{
						@unlink($path);
					}
    			}
			}
			closedir($h);
		}
	}
	public function zip($dir,$outFileName=null,$localDir=null)
	{
		if( !is_null($dir))
		{
			$this->files = $this->getFiles($dir);
		}
		if( ! is_array($this->files) || count($this->files)== 0 )
		{
			return null;
		}
		if( is_null( $outFileName ) )
		{

			if( !is_dir( $dir ))
			{
				$aFileParts = pathinfo($dir);
				$baseName = $aFileParts['basename'];
				$fileName = $aFileParts['filename'];
				$this->tempFile = $aFileParts['dirname'].'/tmp'.date('dmYhis').'.zip';
   				$outFileName = $this->tempFile;
			}
			else
			{
				$this->tempFile = preg_replace('/\/\//','/',$dir.'/tmp'.date('dmYhis').'.zip');
   				$outFileName = $this->tempFile;
			}
		}

		if( file_exists( $outFileName))
		{
			@unlik($outFileName);
		}
		$this->open( $outFileName,ZIPARCHIVE::CREATE);
		{
			/*
			if( $x == ZipArchive::ER_MEMORY)
			{
				die('Est� utilizando a memoria');
			}
			else
			{
				echo $x;
			}
			die();
			 *
			 */

			$i = 1;
			foreach($this->files as $file)
			{
				if( $i++==100)
				{
					$i=1;
					$this->close();
					$this->open( $outFileName,ZIPARCHIVE::CREATE);

				}
				$this->addFile( str_replace('//','/'
					,$file)
					,( is_null($localDir) ? $file: str_replace($localDir,'', str_replace('//','/',$file ) ) ) ) ;
			}
			$this->close();
		}
		if( file_exists( $outFileName ))
		{
			if( !is_null($this->tempFile) )
			{
				return $outFileName;
			}
			return true;
		}
		return false;

	}
	protected function getFiles($dir)
	{
		$dir = preg_replace('/\/\//','/',$dir);
		if( ! is_dir($dir)  )
		{
			if( !file_exists( $dir ))
			{
				return null;
			}
			else
			{
				$this->files[] = $dir;
				return $this->files;
			}
		}
		$aDir = scandir( $dir );
		foreach($aDir as $d)
		{
			if( $d !='.' && $d !='..'  )
			{
				if( is_dir( $dir.'/'.$d ) )
				{
					$this->getFiles($dir.'/'.$d);
				}
				else
				{
					$this->files[] = str_replace('//','/',$dir.'/'.$d);
				}
			}
		}
		return $this->files;
	}
}
?>