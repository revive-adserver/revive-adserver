<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2002 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* Portuguese translation Lopo Lencastre de Almeida  www.humaneasy.com  */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/


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
    A <i>cache</i> cont&eacute;m uma c&oacute;pia do código HTML que é usado por este anúncio. Ao usar a <i>cache</i> é possível acelerar
    a entrega de anúncios porque o código HTML não tem de ser re-escrito todas as vezes que o anúncio é visualizado. Porque a <i>cache</i>
	contém URLs definidas para a localização de ".$phpAds_productname." e dos seus anúncios, a <i>cache</i> necessita de ser actualizada
	de todas as vezes que ".$phpAds_productname." seja movido para outra localização no seu servidor.
";


// Zone cache
$GLOBALS['strZoneCache']			    = "<i>Cache</i> de Zonas";
$GLOBALS['strAge']				        = "Idade";
$GLOBALS['strRebuildZoneCache']			= "Reconstruir a <i>cache</i> de zonas";
$GLOBALS['strZoneCacheExplaination']	= "
    A <i>cache</i> de Zonas é usada para acelerar a entrega de anúncios que estejam ligados a Zonas. Essa <i>cache</i> contém uma cópia
    de todos os anúncios ligados à zona, o que elimina um grande número de inquéritos à base de dados quando os mesmos são realmente
    mostrados ao utilizador. A <i>cache</i> é normalmente reconstruida que é efectuada uma alteração à Zona ou a um dos seus anúncios, o
    que poderá causar alguma desactualização da <i>cache</i>. Por esse motivo a <i>cache</i> é usualmente reconstruida automáticamente
    cada {seconds} segundos, mas também é possível a sua actualização manual.
";


// Storage
$GLOBALS['strStorage']				    = "Armazenamento";
$GLOBALS['strMoveToDirectory']			= "Mover as imagens guardadas na base de dados para uma directoria";
$GLOBALS['strStorageExplaination']		= "
    As imagens usadas em anúncios locais são armazenadas dentro da base de dados ou guardadas numa directoria. Se guardar as
    imagens dentro de uma directoria, a carga sobre a base de dados será reduzida e isto induzirá um aumento de performance.
";


// Storage
$GLOBALS['strStatisticsExplaination']	= "
	Você definiu as <i>estatísticas compactas</i>, mas as suas antigas estatísticas ainda se encontram no velho formato detalhado.
	Quer converter as suas estatísticas para o novo formato compacto?
";


// Product Updates
$GLOBALS['strSearchingUpdates']			= "Procurando actualizações. Aguarde por favor...";
$GLOBALS['strAvailableUpdates']			= "Actualizações disponíveis";
$GLOBALS['strDownloadZip']			    = "Descarregar (.zip)";
$GLOBALS['strDownloadGZip']			    = "Descarregar (.tar.gz)";

$GLOBALS['strUpdateAlert']			    = "Uma nova versão de ".$phpAds_productname." está disponível.                 \\n\\nQuer obter mais informação \\nacerca desta actualização?";
$GLOBALS['strUpdateAlertSecurity']		= "Uma nova versão de ".$phpAds_productname." está disponível.                 \\n\\nÉ altamente recomendado que efectue uma actualização \\ntão rápido quanto possível, porque esta \\nversão contém um ou mais problemas de segurança resolvidos.";

$GLOBALS['strUpdateServerDown']			= "
    Devido a uma razão desconhecida não é possível recolher<br>
    informação acerca de possíveis actualizações. Tente novamente mais tarde.
";

$GLOBALS['strNoNewVersionAvailable']	= "
	A sua versão de ".$phpAds_productname." está actualizada. Não existem actualizações disponíveis.
";

$GLOBALS['strNewVersionAvailable']		= "
	<b>Uma nova versão de ".$phpAds_productname." está disponível.</b><br> É recomendável que instale a actualização,
	porque pode resolver algum problema existente e irá adicionar novas opções. Para mais informação acerca de como
	actualizar leia, por favor, a documentação incluída nos ficheiros abaixo.
";

$GLOBALS['strSecurityUpdate']			= "
    <b>É altamente recomendado que instale esta actualização assim que possível, porque contém várias resoluções
    de problemas de segurança.</b> A versão de ".$phpAds_productname." que está a utilizar actualmente pode estar
	vulnerável a certos ataques e é provávelmente insegura. Para mais informação acerca da actualização leia, por
	favor, a documentação incluída nos ficheiros abaixo.
";


// Stats conversion
$GLOBALS['strConverting']			    = "Convertendo";
$GLOBALS['strConvertingStats']			= "Convertendo estatísticas...";
$GLOBALS['strConvertStats']			    = "Converter estatísticas";
$GLOBALS['strConvertAdViews']			= "Visualizações convertidas,";
$GLOBALS['strConvertAdClicks']			= "Cliques convertidas...";
$GLOBALS['strConvertNothing']			= "Nada para converter...";
$GLOBALS['strConvertFinished']			= "Concluído...";

$GLOBALS['strConvertExplaination']		= "
    Você esta a usar o formato compacto para guardar as suas estatísticas, mas existem <br>
    ainda algumas estatísticas no formato antigo. Enquanto esses dados estiverem no antigo <br>
    formato sem serem convertidos para o formato compacto não serão visiveis nestas páginas. <br>
    Antes de converter as suas estatísticas efectue uma cópia de segurança da base de dados.! <br>
    Quer converter as estatísticas do formato antigo para o novo formato compacto? <br>
";

$GLOBALS['strConvertingExplaination']	= "
    Todas as estatísticas que ainda estavam no formato antigo estão agora a ser convertidas
    para o formato compacto. <br>
    Dependendo do número de impressões/visualizações que se encontrarem guardadas no antigo
    formato esta operação pode demorar alguns minutos.<br>
    Por favor aguarde até que a conversão esteja concluída antes de visitar outras <br>
    páginas. Abaixo poderá vêr o registo de todas as modificações efectuadas na base de dados. <br>
";

$GLOBALS['strConvertFinishedExplaination']  	= "
    A conversão das estatísticas que permaneciam no velho formato foi bem sucedida <br>
    e os dados estão utilizáveis novamente. Abaixo poderá vêr o registo de todas as modificações <br>
    efectuadas na base de dados. <br>
";


?>