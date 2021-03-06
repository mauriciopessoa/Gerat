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


define("APLICATIVO","TEST");
define("TITULO_SISTEMA","SistemaS de TesteS");
define("COR_TITULO","black");
define("FORMDINCSS","css/FormDin.css");
define('PASTA_BASE','base/');
define("DEBUG",1);
define("BANCO_TNS","desenv");
define('TIPO_ACESSO','E'); // 'I'= banco_interno ; 'E' = banco_externo

// as seguintes linhas apenas para conxão com usuário fixo. (TIPO_ACESSO='E')
define('AUTENTICAR_EXTERNO','MCP.PK_AUTENTICAR.AUTENTICAR'); // função usada para autenticar usuário externo
define('SESSAO_TEMPO_MAX',0); // Tempo máximo que usuário pode ficar logado em segundos. 0=sem limite
define("BANCO_USUARIO","12345678909");
define("BANCO_SENHA","teste");

define("CACHE_REFRESH",86400);	// Tempo que a descricao dos cabeçalhos do pacotes ficam em cache
								//segundos !! 1 hora=3600 1 dia=86400
?>

