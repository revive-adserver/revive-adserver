<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id: translation.php 28570 2008-11-06 16:21:37Z chris.nutting $
*/



// Note: New translations not found in original lang files but found in CSV
$GLOBALS['phpAds_hlp_company_name'] = "Este nome é usado em e-mails enviados pelo ". MAX_PRODUCT_NAME .".";
$GLOBALS['phpAds_hlp_warn_client'] = "". MAX_PRODUCT_NAME ." pode enviar e-mail ao anunciante apenas se uma de suas campanhas possui um";
$GLOBALS['phpAds_hlp_qmail_patch'] = "Algumas versões do qmail possuem um bug, que causa e-mails enviados pelo \n                ". MAX_PRODUCT_NAME ." a mostrar cabeçalhos dentro do corpo do e-mail. Se você habilitar \n                esta configuração, ". MAX_PRODUCT_NAME ." irá enviar e-mails com um formato compatível com o qmail.";
$GLOBALS['phpAds_hlp_warn_limit'] = "O limite no qual ". MAX_PRODUCT_NAME ." inicia o envio de e-mails. Atualmente 100";
$GLOBALS['phpAds_hlp_admin_email'] = "E-mail do administrador. Utilizado como o endereço de remetente quando";
$GLOBALS['phpAds_hlp_admin_novice'] = "Se deseja receber um alerta antes de reover anunciantes, campanhas, banners, sites e zonas; selecione esta opção";
$GLOBALS['phpAds_hlp_gui_show_campaign_info'] = "Se esta opção estiver habilitada informações extras sobre cada campanha será apresentada na página de <i>Campanhas</i>. A informação extra inclui o numero de Visualizações do anúncio restantes, o numero de cliques restantes, o numero de conversões restantes, a data de ativação, a de vencimento e as configurações de prioridade.";
$GLOBALS['phpAds_hlp_gui_show_banner_info'] = "Se esta opção estiver habilitada informações extras de banners serão apresentadas na página de <i>Banners</i>. Esta informação inclui a URL de destino, palavras-chaves, dimensões e tamanho do banner.";
$GLOBALS['phpAds_hlp_gui_show_campaign_preview'] = "Se esta opção estiver habilitada uma pré-visualização de cada banner será apresentada na página de <i>Banners</i>. Se ele estiver desabilitada ainda é possível mostrar estra visualização de cada banner clicando no triangulo ao lado de cada banner na página de <i>Banners</i>.";
$GLOBALS['phpAds_hlp_gui_hide_inactive'] = "Se esta opção estiver habilitada todos banners, campanhas e anunciantes inativos ficarão ocultos nas páginas de <i>Anunciantes e Campanhas</i> e <i>Campanhas</i>. Se esta opção estiver desabilitada, ainda é possível ver os itens escondidos clicando no botão <i>Mostrar todos</i> ao final da página.";
?>