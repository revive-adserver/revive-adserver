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
$GLOBALS['strChooseSection']			= "Escolher seção";

// Priority
$GLOBALS['strRecalculatePriority']		= "Recalcular prioridade";
$GLOBALS['strHighPriorityCampaigns']	= "Campanhas de alta prioridade";
$GLOBALS['strAdViewsAssigned']			= "Visualizações definidas";
$GLOBALS['strLowPriorityCampaigns']		= "Campanhas de baixa prioridade";
$GLOBALS['strPredictedAdViews']			= "Visualizações previstas";
$GLOBALS['strPriorityDaysRunning']		= "Existem actualmente {days} dias com estatísticas disponíes a partir dos quais ".$phpAds_productname." pode basear as suas prediçães diárias. ";
$GLOBALS['strPriorityBasedLastWeek']	= "A predição é baseada em dados desta semana e da anterior. ";
$GLOBALS['strPriorityBasedLastDays']	= "A predição é baseada em dados dos últimos dias. ";
$GLOBALS['strPriorityBasedYesterday']	= "A predição é baseada em dados de ontem. ";
$GLOBALS['strPriorityNoData']			= "Não existem dados disponíveis para efectuar um predição credível acerca do número de impressões que este servidor gerará hoje. Distribuições prioritárias serão baseadas somente em dados estatísticos em tempo real. ";
$GLOBALS['strPriorityEnoughAdViews']	= "Devem existir Visualizações para satisfazer todas as campanhas prioritárias. ";
$GLOBALS['strPriorityNotEnoughAdViews']	= "Não é claro se existirão suficientes Visualizações para satisfazer todas as campanhas prioritárias. ";

// Banner cache
$GLOBALS['strRebuildBannerCache']		= "Reconstruir a <i>cache</i> de anúncios";
$GLOBALS['strBannerCacheExplaination']	= "O cache de banners é usado para agilizar a entrega de banners durante a visualização<br />
Este cache necessita ser atualiza quando:
<ul>
 <li>Você atualizar sua versão do " . MAX_PRODUCT_NAME . "</li>
 <li>Você mover sua instalação para um novo servidor</li>
</ul>";

// Zone cache
$GLOBALS['strZoneCache']			    = "<i>Cache</i> de Zonas";
$GLOBALS['strAge']				        = "Idade";
$GLOBALS['strRebuildZoneCache']			= "Reconstruir a <i>cache</i> de zonas";
$GLOBALS['strZoneCacheExplaination']	= "
    A <i>cache</i> de Zonas ï¿œ usada para acelerar a entrega de anï¿œncios que estejam ligados a Zonas. Essa <i>cache</i> contï¿œm uma cï¿œpia
    de todos os anï¿œncios ligados ï¿œ zona, o que elimina um grande nï¿œmero de inquï¿œritos ï¿œ base de dados quando os mesmos sï¿œo realmente
    mostrados ao utilizador. A <i>cache</i> ï¿œ normalmente reconstruida que ï¿œ efectuada uma alteraï¿œï¿œo ï¿œ Zona ou a um dos seus anï¿œncios, o
    que poderï¿œ causar alguma desactualizaï¿œï¿œo da <i>cache</i>. Por esse motivo a <i>cache</i> ï¿œ usualmente reconstruida automï¿œticamente
    cada {seconds} segundos, mas tambï¿œm ï¿œ possï¿œvel a sua actualizaï¿œï¿œo manual.
";

// Storage
$GLOBALS['strStorage']				    = "Armazenamento";
$GLOBALS['strMoveToDirectory']			= "Mover imagens armazenadas dentro da base de dados em um diretório";
$GLOBALS['strStorageExplaination']		= "As imagens usadas por banners locais estão armazenadas na base de dados ou em um diretório local. Se você armazena-las dentro de um diretório a carga sobre a base de dados será menor e haverá uma melhora na velocidade.";

// Storage
$GLOBALS['strStatisticsExplaination']	= "Você habilitou as <i>estatísticas compactas</i>, mas suas estatísticas antigas estão em formato extenso. Você deseja converter estas estatísticas para o novo formato compacto?";

// Product Updates
$GLOBALS['strSearchingUpdates']			= "Procurando atualizações. Por favor aguarde ...";
$GLOBALS['strAvailableUpdates']			= "Atualizações disponíveis";
$GLOBALS['strDownloadZip']			    = "Fazer Download (.zip)";
$GLOBALS['strDownloadGZip']			    = "Fazer Download (.tar.gz)";

$GLOBALS['strUpdateAlert']			    = "Uma nova versão do ".MAX_PRODUCT_NAME." está disponível.

Deseja obter mais informações?";
$GLOBALS['strUpdateAlertSecurity']		= "Uma nova versão do ".MAX_PRODUCT_NAME." está disponível.

É altamente recomendado que o upgrade
seja feito o mais rápido possível, pois esta
versão contêm correções de segurança.";

$GLOBALS['strUpdateServerDown']			= "Devido a um motivo desconhecido é impossível resgatar <br /> informações sobre possíveis atualizações. Tente novamente mais tarde.";

$GLOBALS['strNoNewVersionAvailable']	= "Sua versão de f ".MAX_PRODUCT_NAME." esta atualizada. Nenhuma atualização disponível.";

$GLOBALS['strNewVersionAvailable']		= "<b>Uma nova versão de ".MAX_PRODUCT_NAME." está disponível.</b><br /> É recomendado que esta atualização seja instalada,
pois ela corrige problemas existentes e adiciona novas funcionalidades. Para obter mais informações sobre atualização
leia a documentação que esta inclusa nos arquivos abaixo.
";

$GLOBALS['strSecurityUpdate']			= "<b>É altamente recomendado que esta atualização seja instalada pois ela corrige vários problemas de segurança.</b> A versão atual do ".MAX_PRODUCT_NAME." que você esta utilizando pode estar vulnerável a alguns ataques e pode não ser segura. Para obter mais informações sobre como atualizar este produto, leia a documentação inclusa nos arquivos abaixo.";

// Stats conversion
$GLOBALS['strConverting']			    = "Convertendo";
$GLOBALS['strConvertingStats']			= "Convertendo estatï¿œsticas...";
$GLOBALS['strConvertStats']			    = "Converter estatï¿œsticas";
$GLOBALS['strConvertAdViews']			= "Visualizaï¿œï¿œes convertidas,";
$GLOBALS['strConvertAdClicks']			= "Cliques convertidas...";
$GLOBALS['strConvertNothing']			= "Nada para converter...";
$GLOBALS['strConvertFinished']			= "Concluï¿œdo...";

$GLOBALS['strConvertExplaination']		= "
    Vocï¿œ esta a usar o formato compacto para guardar as suas estatï¿œsticas, mas existem <br />
    ainda algumas estatï¿œsticas no formato antigo. Enquanto esses dados estiverem no antigo <br />
    formato sem serem convertidos para o formato compacto nï¿œo serï¿œo visiveis nestas pï¿œginas. <br />
    Antes de converter as suas estatï¿œsticas efectue uma cï¿œpia de seguranï¿œa da base de dados.! <br />
    Quer converter as estatï¿œsticas do formato antigo para o novo formato compacto? <br />
";

$GLOBALS['strConvertingExplaination']	= "
    Todas as estatï¿œsticas que ainda estavam no formato antigo estï¿œo agora a ser convertidas
    para o formato compacto. <br />
    Dependendo do nï¿œmero de impressï¿œes/visualizaï¿œï¿œes que se encontrarem guardadas no antigo
    formato esta operaï¿œï¿œo pode demorar alguns minutos.<br />
    Por favor aguarde atï¿œ que a conversï¿œo esteja concluï¿œda antes de visitar outras <br />
    pï¿œginas. Abaixo poderï¿œ vï¿œr o registo de todas as modificaï¿œï¿œes efectuadas na base de dados. <br />
";

$GLOBALS['strConvertFinishedExplaination']  	= "
    A conversï¿œo das estatï¿œsticas que permaneciam no velho formato foi bem sucedida <br />
    e os dados estï¿œo utilizï¿œveis novamente. Abaixo poderï¿œ vï¿œr o registo de todas as modificaï¿œï¿œes <br />
    efectuadas na base de dados. <br />
";



// Note: new translatiosn not found in original lang files but found in CSV
$GLOBALS['strCheckBannerCache'] = "Verificar cache do banner";
$GLOBALS['strBannerCacheErrorsFound'] = "A verificação do cache em banco de dados dos banners encontrou alguns erros. Estes banners não irão funcionar até que sejam corrigidos manualmente";
$GLOBALS['strBannerCacheOK'] = "Nenhum erro foi encontrado. Seu cache em banco de dados esta atualizado";
$GLOBALS['strBannerCacheDifferencesFound'] = "A verificação do cache em banco de dados dos banners identificou que seu cache não esta atualizado e precisa ser re-gerado. Clique aqui para atualizá-lo automaticamente.";
$GLOBALS['strBannerCacheRebuildButton'] = "Re-gerar";
$GLOBALS['strRebuildDeliveryCache'] = "Regenerar base de cache de banners";
$GLOBALS['strCache'] = "Cache de entrega";
$GLOBALS['strDeliveryCacheSharedMem'] = "Memória compartilhada esta sendo usada para cache atualmente.";
$GLOBALS['strDeliveryCacheDatabase'] = "A base de dados esta atualmente sendo usada como cache";
$GLOBALS['strDeliveryCacheFiles'] = "O cache de entrega esta atualmente sendo armazenado em arquivos múltiplos de seu servidor";
$GLOBALS['strNotAbleToCheck'] = "<b>A extensão XML não esta disponível em seu servidor, ".MAX_PRODUCT_NAME." não consegue verificar se uma nova versão esta disponível.</b>";
$GLOBALS['strForUpdatesLookOnWebsite'] = "Se deseja saber se uma nova versão esta disponível, visite nosso site.";
$GLOBALS['strClickToVisitWebsite'] = "Clique aqui para visitar nosso site";
$GLOBALS['strCurrentlyUsing'] = "Você esta atualmente usando";
$GLOBALS['strRunningOn'] = "rodando em um";
$GLOBALS['strAndPlain'] = "e";
$GLOBALS['strBannerCacheFixed'] = "A re-geração do cache em banco de dados foi concluída com sucesso. Seu cache esta atualizado.";
?>