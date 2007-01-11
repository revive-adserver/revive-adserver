<?php // $Revision$
/****************************************************************************/
/* Openads 2.0                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2007 by the Openads developers                    */
/* For more information visit: http://www.openads.org                   */
/*                                                                          */
/*Translated to Brazilian_portuguese by: Luiz Alberto de Moraes - purasorte */
/*For any comments/suggestions: purasorte@yahoo.com.br                      */
/*http://wwww.ojogodobicho.com                                              */
/*                                                                          */
/* This program is free software. You can redistribute it and/or modify     */
/* it under the terms of the GNU General Public License as published by     */
/* the Free Software Foundation; either version 2 of the License.           */
/****************************************************************************/


// Main strings
$GLOBALS['strChooseSection']			= "Escolha se&ccedil;&atilde;o";


// Priority
$GLOBALS['strRecalculatePriority']		= "Recalcular prioridade";
$GLOBALS['strHighPriorityCampaigns']	= "Campanhas de alta prioridade";
$GLOBALS['strAdViewsAssigned']			= "Visualiza&ccedil;oes definidas";
$GLOBALS['strLowPriorityCampaigns']		= "Campanhas de baixa prioridade";
$GLOBALS['strPredictedAdViews']			= "Visualiza&ccedil;oes previstas";
$GLOBALS['strPriorityDaysRunning']		= "Existem atualmente {days} dias com estat&iacute;sticas disponiveis a partir dos quais o ".$phpAds_productname." pode basear as suas previs&otilde;es di&aacute;rias. ";
$GLOBALS['strPriorityBasedLastWeek']	= "A previs&atilde;o &eacute; baseada em dados desta semana e da anterior. ";
$GLOBALS['strPriorityBasedLastDays']	= "A previs&atilde;o &eacute; baseada em dados dos &uacute;ltimos dias. ";
$GLOBALS['strPriorityBasedYesterday']	= "A previs&atilde;o &eacute; baseada em dados de ontem. ";
$GLOBALS['strPriorityNoData']			= "N&atilde;o existem dados disponiveis para efetuar um previs&atilde;o cred&iacute;vel sobre o n&uacute;mero de impress&otilde;es que este servidor gerar&aacute; hoje. Distribui&ccedil;oes priorit&aacute;rias ser&atilde;o baseadas somente em dados estat&iacute;sticos em tempo real. ";
$GLOBALS['strPriorityEnoughAdViews']	= "Devem existir visualiza&ccedil;&otilde;es para satisfazer todas as campanhas priorit&aacute;rias. ";
$GLOBALS['strPriorityNotEnoughAdViews']	= "N&atilde;o &eacute;; claro se existirem suficientes Visualiza&ccedil;oes para satisfazer todas as campanhas priorit&aacute;rias. ";


// Banner cache
$GLOBALS['strRebuildBannerCache']		= "Reconstruir a <i>cache</i> de an&uacute;ncios";
$GLOBALS['strBannerCacheExplaination']	= "
    A <i>cache</i> cont&eacute;m uma c&oacute;pia do c&oacute;digo HTML que &eacute; usado por este an&uacute;ncio. Ao usar a <i>cache</i> &eacute; poss&iacute;vel acelerar
    a entrega de an&uacute;ncios porque o c&oacute;digo HTML n&atilde;o tem de ser re-escrito todas as vezes que o an&uacute;ncio &eacute; visualizado. Porque a <i>cache</i>
	cont&eacute;m URLs definidas para a localiza&ccedil;&atilde;o de ".$phpAds_productname." e dos seus an&uacute;ncios, a <i>cache</i> precisa ser atualizada
	todas as vezes que ".$phpAds_productname." seja movido para outro local no seu servidor.
";


// Zone cache
$GLOBALS['strZoneCache']			    = "<i>Cache</i> de Zonas";
$GLOBALS['strAge']				        = "Idade";
$GLOBALS['strRebuildZoneCache']			= "Reconstruir a <i>cache</i> de zonas";
$GLOBALS['strZoneCacheExplaination']	= "
    A <i>cache</i> de Zonas &eacute; usada para acelerar a entrega de an&uacute;ncios que estejam ligados a Zonas. Essa <i>cache</i> cont&eacute;m uma c&oacute;pia
    de todos os an&uacute;ncios ligados &agrave; zona, o que elimina um grande n&uacute;mero de pesquisas &agrave; base de dados quando os mesmos s&atilde;o realmente
    mostrados ao usu&aacute;rio. A <i>cache</i> &eacute; normalmente reconstruida quando &eacute; efetuada uma altera&ccedil;&atilde;o &agrave; Zona ou a um dos seus an&uacute;ncios, o
    que poder&aacute; causar alguma desatualiza&ccedil;&atilde;o da <i>cache</i>. Por esse motivo a <i>cache</i> &eacute; usualmente reconstruida autom&aacute;ticamente
    cada {seconds} segundos, mas tamb&eacute;m &eacute; poss&iacute;vel a sua atualiza&ccedil;&atilde;o manual.";

$GLOBALS['strDeliveryCacheSharedMem']		= "
 A memória compartilhada está sendo usada atualmente armazenando o cache de entrega.
";
$GLOBALS['strDeliveryCacheDatabase']		= "
 A base de dados está sendo usada atualmente armazenando o cache de entrega.
";
$GLOBALS['strDeliveryCacheFiles']		= "
 O cache de entrega está sendo armazenado em diversos arquivos em seu servidor
";

// Storage
$GLOBALS['strStorage']				    = "Armazenamento";
$GLOBALS['strMoveToDirectory']			= "Mover as imagens guardadas na base de dados para um diretorio";
$GLOBALS['strStorageExplaination']		= "
    As imagens usadas em an&uacute;ncios locais s&atilde;o armazenadas dentro da base de dados ou guardadas num diretorio. Se guardar as
    imagens em um diretorio, a carga sobre a base de dados ser&aacute; reduzida e isto induzir&aacute; um aumento de performance.";
$GLOBALS['strStatisticsExplaination']	= "
	Voc&ecirc; definiu as <i>estat&iacute;sticas compactas</i>, mas as suas antigas estat&iacute;sticas ainda se encontram no velho formato detalhado.
	Quer converter as suas estat&iacute;sticas para o novo formato compacto?
";


// Product Updates
$GLOBALS['strSearchingUpdates']			= "Procurando atualiza&ccedil;&otilde;es. Aguarde por favor...";
$GLOBALS['strAvailableUpdates']			= "Atualiza&ccedil;&otilde;es dispon&iacute;veis";
$GLOBALS['strDownloadZip']			    = "Baixar (.zip)";
$GLOBALS['strDownloadGZip']			    = "Baixar (.tar.gz)";

$GLOBALS['strUpdateAlert']			    = "Uma nova vers&atilde;o de ".$phpAds_productname." est&aacute; dispon&iacute;vel.                 \\n\\nQuer obter mais informa&ccedil;&atilde;o \\nsobre desta atualiza&ccedil;&atilde;o?";
$GLOBALS['strUpdateAlertSecurity']		= "Uma nova vers&atilde;o de ".$phpAds_productname." est&aacute; dispon&iacute;vel.                 \\n\\n&Eacute; altamente recomendado que efetue a atualiza&ccedil;&atilde;o \\nt&atilde;o r&aacute;pido quanto poss&iacute;vel, porque esta \\nvers&atilde;o cont&eacute;m um ou mais problemas de seguran&ccedil;a resolvidos.";

$GLOBALS['strUpdateServerDown']			= "
    Devido a uma raz&atilde;o desconhecida n&atilde;o &eacute; poss&iacute;vel obter<br>
    informa&ccedil;&atilde;o sobre poss&iacute;veis atualiza&ccedil;&otilde;es. Tente novamente mais tarde.
";

$GLOBALS['strNoNewVersionAvailable']	= "
	A sua vers&atilde;o do ".$phpAds_productname." est&aacute; atualizada. N&atilde;o existem atualiza&ccedil;&otilde;es dispon&iacute;veis.
";

$GLOBALS['strNewVersionAvailable']		= "
	<b>Uma nova vers&atilde;o do ".$phpAds_productname." est&aacute; dispon&iacute;vel.</b><br> &Eacute; recomend&aacute;vel que instale a atualiza&ccedil;&atilde;o,
	porque pode resolver algum problema existente e ir&aacute; adicionar novas op&ccedil;&otilde;es. Para mais informa&ccedil;&atilde;o sobre como
	atualizar leia, por favor, a documenta&ccedil;&atilde;o inclu&iacute;da nos arquivos abaixo.
";

$GLOBALS['strSecurityUpdate']			= "
    <b>&Eacute; altamente recomendado que instale esta atualiza&ccedil;&atilde;o assim que poss&iacute;vel, porque cont&eacute;m v&aacute;rias resolu&ccedil;&otilde;es
    de problemas de seguran&ccedil;a.</b> A vers&atilde;o do ".$phpAds_productname." que est&aacute; utilizando atualmente pode estar
	vulner&aacute;vel a certos ataques e &eacute; prov&aacute;velmente insegura. Para mais informa&ccedil;&atilde;o sobre a atualiza&ccedil;&atilde;o leia, por
	favor, a documenta&ccedil;&atilde;o inclu&iacute;da nos arquivos abaixo.
";
$GLOBALS['strNotAbleToCheck']			= "
	<b>Porque a extensão XML não está disponível em seu servidor, ".$phpAds_productname." Não é possivel verificar se há uma nova versão disponível</b>
";

$GLOBALS['strForUpdatesLookOnWebsite']	= "
 Se você quiser saber se há uma nova versão disponível, de uma olhada em nosso site
";

$GLOBALS['strClickToVisitWebsite']		= "Clique aqui para visitar nosso site";
$GLOBALS['strCurrentlyUsing'] 			= "Você está usando atualmente";
$GLOBALS['strRunningOn']				= "rodando em";
$GLOBALS['strAndPlain']					= "e";


// Stats conversion
$GLOBALS['strConverting']			    = "Convertendo";
$GLOBALS['strConvertingStats']			= "Convertendo estat&iacute;sticas...";
$GLOBALS['strConvertStats']			    = "Converter estat&iacute;sticas";
$GLOBALS['strConvertAdViews']			= "Visualiza&ccedil;&otilde;es convertidas,";
$GLOBALS['strConvertAdClicks']			= "Cliques convertidas...";
$GLOBALS['strConvertNothing']			= "Nada a converter...";
$GLOBALS['strConvertFinished']			= "Conclu&iacute;do...";

$GLOBALS['strConvertExplaination']		= "
    Voc&ecirc; esta usando o formato compacto para guardar as suas estat&iacute;sticas, mas existem <br>
    ainda algumas estat&iacute;sticas no formato antigo. Enquanto esses dados estiverem no antigo <br>
    formato sem serem convertidos para o formato compacto n&atilde;o ser&atilde;o visiveis nestas p&aacute;ginas. <br>
    Antes de converter as suas estat&iacute;sticas fa&ccedil;a uma c&oacute;pia de seguran&ccedil;a da base de dados.! <br>
    Deseja converter as estat&iacute;sticas do formato antigo para o novo formato compacto? <br>
";

$GLOBALS['strConvertingExplaination']	= "
    Todas as estat&iacute;sticas que ainda estavam no formato antigo est&atilde;o agora sendo convertidas
    para o formato compacto. <br>
    Dependendo do n&uacute;mero de impress&otilde;es/visualiza&ccedil;&otilde;es que se encontrarem guardadas no antigo
    formato esta opera&ccedil;&atilde;o pode demorar alguns minutos.<br>
    Por favor aguarde at&eacute; que a convers&atilde;o esteja conclu&iacute;da antes de visitar outras <br>
    p&aacute;ginas. Abaixo poder&aacute; v&ecirc;r o registro de todas as modifica&ccedil;&otilde;es efetuadas na base de dados. <br>
";

$GLOBALS['strConvertFinishedExplaination']  	= "
    A convers&atilde;o das estat&iacute;sticas que permaneciam no velho formato foi bem sucedida <br>
    e os dados est&atilde;o utiliz&aacute;veis novamente. Abaixo poder&aacute; v&ecirc;r o registro de todas as modifica&ccedil;&otilde;es <br>
    efetuadas na base de dados. <br>
";


?>