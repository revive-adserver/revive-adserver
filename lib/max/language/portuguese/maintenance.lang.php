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
$Id$
*/

// Main strings
$GLOBALS['strChooseSection']			= "Escolha sec&ccedil;&atilde;o";

// Priority
$GLOBALS['strRecalculatePriority']		= "Recalcular prioridade";
$GLOBALS['strHighPriorityCampaigns']	= "Campanhas de alta prioridade";
$GLOBALS['strAdViewsAssigned']			= "Visualiza&ccedil;&otilde;es definidas";
$GLOBALS['strLowPriorityCampaigns']		= "Campanhas de baixa prioridade";
$GLOBALS['strPredictedAdViews']			= "Visualiza&ccedil;&otilde;es previstas";
$GLOBALS['strPriorityDaysRunning']		= "Existem actualmente {days} dias com estat&iacute;sticas dispon&iacute;es a partir dos quais ".$phpAds_productname." pode basear as suas predi&ccedil;&atilde;es di&aacute;rias. ";
$GLOBALS['strPriorityBasedLastWeek']	= "A predi&ccedil;&atilde;o &eacute; baseada em dados desta semana e da anterior. ";
$GLOBALS['strPriorityBasedLastDays']	= "A predi&ccedil;&atilde;o &eacute; baseada em dados dos &uacute;ltimos dias. ";
$GLOBALS['strPriorityBasedYesterday']	= "A predi&ccedil;&atilde;o &eacute; baseada em dados de ontem. ";
$GLOBALS['strPriorityNoData']			= "N&atilde;o existem dados dispon&iacute;veis para efectuar um predi&ccedil;&atilde;o cred&iacute;vel acerca do n&uacte;mero de impress&otilde;es que este servidor gerar&aacute; hoje. Distribui&ccedil;&otilde;es priorit&aacute;rias ser&atilde;o baseadas somente em dados estat&iacute;sticos em tempo real. ";
$GLOBALS['strPriorityEnoughAdViews']	= "Devem existir Visualiza&ccedil;&otilde;es para satisfazer todas as campanhas priorit&aacute;rias. ";
$GLOBALS['strPriorityNotEnoughAdViews']	= "N&atilde;o &eacute; claro se existir&atilde;o suficientes Visualiza&ccedil;&otilde;es para satisfazer todas as campanhas priorit&aacute;rias. ";

// Banner cache
$GLOBALS['strRebuildBannerCache']		= "Reconstruir a <i>cache</i> de an&uacute;ncios";
$GLOBALS['strBannerCacheExplaination']	= "
    A <i>cache</i> cont&eacute;m uma c&oacute;pia do c�digo HTML que � usado por este an�ncio. Ao usar a <i>cache</i> � poss�vel acelerar
    a entrega de an�ncios porque o c�digo HTML n�o tem de ser re-escrito todas as vezes que o an�ncio � visualizado. Porque a <i>cache</i>
	cont�m URLs definidas para a localiza��o de ".$phpAds_productname." e dos seus an�ncios, a <i>cache</i> necessita de ser actualizada
	de todas as vezes que ".$phpAds_productname." seja movido para outra localiza��o no seu servidor.
";

// Zone cache
$GLOBALS['strZoneCache']			    = "<i>Cache</i> de Zonas";
$GLOBALS['strAge']				        = "Idade";
$GLOBALS['strRebuildZoneCache']			= "Reconstruir a <i>cache</i> de zonas";
$GLOBALS['strZoneCacheExplaination']	= "
    A <i>cache</i> de Zonas � usada para acelerar a entrega de an�ncios que estejam ligados a Zonas. Essa <i>cache</i> cont�m uma c�pia
    de todos os an�ncios ligados � zona, o que elimina um grande n�mero de inqu�ritos � base de dados quando os mesmos s�o realmente
    mostrados ao utilizador. A <i>cache</i> � normalmente reconstruida que � efectuada uma altera��o � Zona ou a um dos seus an�ncios, o
    que poder� causar alguma desactualiza��o da <i>cache</i>. Por esse motivo a <i>cache</i> � usualmente reconstruida autom�ticamente
    cada {seconds} segundos, mas tamb�m � poss�vel a sua actualiza��o manual.
";

// Storage
$GLOBALS['strStorage']				    = "Armazenamento";
$GLOBALS['strMoveToDirectory']			= "Mover as imagens guardadas na base de dados para uma directoria";
$GLOBALS['strStorageExplaination']		= "
    As imagens usadas em an�ncios locais s�o armazenadas dentro da base de dados ou guardadas numa directoria. Se guardar as
    imagens dentro de uma directoria, a carga sobre a base de dados ser� reduzida e isto induzir� um aumento de performance.
";

// Storage
$GLOBALS['strStatisticsExplaination']	= "
	Voc� definiu as <i>estat�sticas compactas</i>, mas as suas antigas estat�sticas ainda se encontram no velho formato detalhado.
	Quer converter as suas estat�sticas para o novo formato compacto?
";

// Product Updates
$GLOBALS['strSearchingUpdates']			= "Procurando actualiza��es. Aguarde por favor...";
$GLOBALS['strAvailableUpdates']			= "Actualiza��es dispon�veis";
$GLOBALS['strDownloadZip']			    = "Descarregar (.zip)";
$GLOBALS['strDownloadGZip']			    = "Descarregar (.tar.gz)";

$GLOBALS['strUpdateAlert']			    = "Uma nova vers�o de ".$phpAds_productname." est� dispon�vel.                 \\n\\nQuer obter mais informa��o \\nacerca desta actualiza��o?";
$GLOBALS['strUpdateAlertSecurity']		= "Uma nova vers�o de ".$phpAds_productname." est� dispon�vel.                 \\n\\n� altamente recomendado que efectue uma actualiza��o \\nt�o r�pido quanto poss�vel, porque esta \\nvers�o cont�m um ou mais problemas de seguran�a resolvidos.";

$GLOBALS['strUpdateServerDown']			= "
    Devido a uma raz�o desconhecida n�o � poss�vel recolher<br />
    informa��o acerca de poss�veis actualiza��es. Tente novamente mais tarde.
";

$GLOBALS['strNoNewVersionAvailable']	= "
	A sua vers�o de ".$phpAds_productname." est� actualizada. N�o existem actualiza��es dispon�veis.
";

$GLOBALS['strNewVersionAvailable']		= "
	<b>Uma nova vers�o de ".$phpAds_productname." est� dispon�vel.</b><br /> � recomend�vel que instale a actualiza��o,
	porque pode resolver algum problema existente e ir� adicionar novas op��es. Para mais informa��o acerca de como
	actualizar leia, por favor, a documenta��o inclu�da nos ficheiros abaixo.
";

$GLOBALS['strSecurityUpdate']			= "
    <b>� altamente recomendado que instale esta actualiza��o assim que poss�vel, porque cont�m v�rias resolu��es
    de problemas de seguran�a.</b> A vers�o de ".$phpAds_productname." que est� a utilizar actualmente pode estar
	vulner�vel a certos ataques e � prov�velmente insegura. Para mais informa��o acerca da actualiza��o leia, por
	favor, a documenta��o inclu�da nos ficheiros abaixo.
";

// Stats conversion
$GLOBALS['strConverting']			    = "Convertendo";
$GLOBALS['strConvertingStats']			= "Convertendo estat�sticas...";
$GLOBALS['strConvertStats']			    = "Converter estat�sticas";
$GLOBALS['strConvertAdViews']			= "Visualiza��es convertidas,";
$GLOBALS['strConvertAdClicks']			= "Cliques convertidas...";
$GLOBALS['strConvertNothing']			= "Nada para converter...";
$GLOBALS['strConvertFinished']			= "Conclu�do...";

$GLOBALS['strConvertExplaination']		= "
    Voc� esta a usar o formato compacto para guardar as suas estat�sticas, mas existem <br />
    ainda algumas estat�sticas no formato antigo. Enquanto esses dados estiverem no antigo <br />
    formato sem serem convertidos para o formato compacto n�o ser�o visiveis nestas p�ginas. <br />
    Antes de converter as suas estat�sticas efectue uma c�pia de seguran�a da base de dados.! <br />
    Quer converter as estat�sticas do formato antigo para o novo formato compacto? <br />
";

$GLOBALS['strConvertingExplaination']	= "
    Todas as estat�sticas que ainda estavam no formato antigo est�o agora a ser convertidas
    para o formato compacto. <br />
    Dependendo do n�mero de impress�es/visualiza��es que se encontrarem guardadas no antigo
    formato esta opera��o pode demorar alguns minutos.<br />
    Por favor aguarde at� que a convers�o esteja conclu�da antes de visitar outras <br />
    p�ginas. Abaixo poder� v�r o registo de todas as modifica��es efectuadas na base de dados. <br />
";

$GLOBALS['strConvertFinishedExplaination']  	= "
    A convers�o das estat�sticas que permaneciam no velho formato foi bem sucedida <br />
    e os dados est�o utiliz�veis novamente. Abaixo poder� v�r o registo de todas as modifica��es <br />
    efectuadas na base de dados. <br />
";

?>
