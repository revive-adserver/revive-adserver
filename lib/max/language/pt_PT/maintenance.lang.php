<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
$GLOBALS['strDeliveryLimitations'] = "Limitações de entrega";
$GLOBALS['strChooseSection'] = "Escolher seção";
$GLOBALS['strRecalculatePriority'] = "Recalcular prioridade";
$GLOBALS['strCheckBannerCache'] = "Verificar cache de banners ";
$GLOBALS['strBannerCacheErrorsFound'] = "A verificação de cache da base de dados encontrou erros. Estes banners não funcionarão até que sejam corrigidos manualmente.";
$GLOBALS['strBannerCacheOK'] = "Nenhum erro detectado. Seu cache de banners esta atualizado";
$GLOBALS['strBannerCacheDifferencesFound'] = "A verificação do cache de banners detectou que seu cache não esta atualizado e necessita ser regenerado. Clique aqui para atualizar seu cache automaticamente.";
$GLOBALS['strBannerCacheRebuildButton'] = "Gerar novamente";
$GLOBALS['strRebuildDeliveryCache'] = "Regenerar base de cache de banners";
$GLOBALS['strBannerCacheExplaination'] = "O cache de banners é usado para agilizar a entrega de banners durante a visualização<br />\nEste cache necessita ser atualiza quando:\n<ul>\n <li>Você atualizar sua versão do OpenX</li>\n <li>Você mover sua instalação para um novo servidor</li>\n</ul>";
$GLOBALS['strCache'] = "Cache de entrega";
$GLOBALS['strAge'] = "Idade";
$GLOBALS['strDeliveryCacheSharedMem'] = "Memória compartilhada esta sendo usada para cache atualmente.";
$GLOBALS['strDeliveryCacheDatabase'] = "A base de dados esta atualmente sendo usada como cache";
$GLOBALS['strDeliveryCacheFiles'] = "O cache de entrega esta atualmente sendo armazenado em arquivos múltiplos de seu servidor";
$GLOBALS['strStorage'] = "Armazenamento";
$GLOBALS['strMoveToDirectory'] = "Mover imagens armazenadas dentro da base de dados em um diretório";
$GLOBALS['strStorageExplaination'] = "As imagens usadas por banners locais estão armazenadas na base de dados ou em um diretório local. Se você armazena-las dentro de um diretório a carga sobre a base de dados será menor e haverá uma melhora na velocidade.";
$GLOBALS['strSearchingUpdates'] = "Procurando atualizações. Por favor aguarde ...";
$GLOBALS['strAvailableUpdates'] = "Atualizações disponíveis";
$GLOBALS['strDownloadZip'] = "Fazer Download (.zip)";
$GLOBALS['strDownloadGZip'] = "Fazer Download (.tar.gz)";
$GLOBALS['strUpdateAlert'] = "Uma nova versão do ". MAX_PRODUCT_NAME ." está disponível.                 \n\nDeseja obter mais informações?";
$GLOBALS['strUpdateAlertSecurity'] = "Uma nova versão do ". MAX_PRODUCT_NAME ." está disponível.                 \n\nÉ altamente recomendado que o upgrade \nseja feito o mais rápido possível, pois esta \nversão contêm correções de segurança.";
$GLOBALS['strUpdateServerDown'] = "Devido a um motivo desconhecido é impossível resgatar <br /> informações sobre possíveis atualizações. Tente novamente mais tarde.";
$GLOBALS['strNoNewVersionAvailable'] = "\n	Sua versão de ". MAX_PRODUCT_NAME ." esta atualizada. Nenhuma atualização disponível.\n";
$GLOBALS['strNewVersionAvailable'] = "<b>Uma nova versão de ". MAX_PRODUCT_NAME ." está disponível.</b><br /> É recomendado que esta atualização seja instalada, \npois ela corrige problemas existentes e adiciona novas funcionalidades. Para obter mais informações sobre atualização \nleia a documentação que esta inclusa nos arquivos abaixo.\n";
$GLOBALS['strSecurityUpdate'] = "\n	<b>É altamente recomendado que esta atualização seja instalada pois ela corrige vários problemas de segurança.</b> A versão atual do ". MAX_PRODUCT_NAME ." que você esta utilizando pode estar vulnerável a alguns ataques e pode não ser segura. Para obter mais informações sobre como atualizar este produto, leia a documentação inclusa nos arquivos abaixo.";
$GLOBALS['strNotAbleToCheck'] = "\n	<b>A extensão XML não esta disponível em seu servidor, ". MAX_PRODUCT_NAME ." não consegue verificar se uma nova versão esta disponível.</b>\n";
$GLOBALS['strForUpdatesLookOnWebsite'] = "\n	Se deseja saber se uma nova versão esta disponível, visite nosso site.\n";
$GLOBALS['strClickToVisitWebsite'] = "Clique aqui para visitar nosso site";
$GLOBALS['strCurrentlyUsing'] = "Você esta atualmente usando";
$GLOBALS['strRunningOn'] = "rodando em um";
$GLOBALS['strAndPlain'] = "e";
$GLOBALS['strStatisticsExplaination'] = "Você habilitou as <i>estatísticas compactas</i>, mas suas estatísticas antigas estão em formato extenso. Você deseja converter estas estatísticas para o novo formato compacto?";
$GLOBALS['strBannerCacheFixed'] = "A re-geração do cache em banco de dados foi concluída com sucesso. Seu cache esta atualizado.";
$GLOBALS['strEncoding'] = "Codificação";
$GLOBALS['strEncodingExplaination'] = "Agora o ". MAX_PRODUCT_NAME ." grava todos os dados no banco no formato UTF-8.<br />Sempre que possível seus dados serão automaticamente convertidos para esta codificação.<br />Caso após uma atualização você encontre caracteres corrompidos, e conheça a codificação usada, pode utilizar esta ferramenta para converter os dados para o formato UTF-8";
$GLOBALS['strEncodingConvertFrom'] = "Converter desta codificação:";
$GLOBALS['strEncodingConvert'] = "Converter";
$GLOBALS['strEncodingConvertTest'] = "Testar conversão";
$GLOBALS['strConvertThese'] = "Os seguintes dados serão alterados caso você siga em frente";
$GLOBALS['strAppendCodes'] = "Anexar códigos";
$GLOBALS['strScheduledMaintenanceHasntRun'] = "<b>A manutenção agendada não foi executada na última hora. Isto pode significar que a configuração não foi feita de forma correta</b>";
$GLOBALS['strAutoMantenaceEnabledAndHasntRun'] = "A Manutenção automática esta habilitada, mas não foi disparada. Ela é disparada somente quando o ". MAX_PRODUCT_NAME ." entrega anúncios. Para uma melhor performance, você deve configurar <a href='http://". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>a manutenção agendada</a>";
$GLOBALS['strAutoMantenaceDisabledAndHasntRun'] = "A manutenção automática esta desabilitada, portanto quando o  ". MAX_PRODUCT_NAME ." entregar banners, a manutenção automática não será disparada. Para a melhor performance você deve configurar a <a href='http://". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>manutenção agendada</a>. Porém, se você não for configurar a <a href='http://". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>manutenção agendada</a>, então você <i>deve</i> <a href='account-settings-maintenance.php'>habilitar a manutenção automática</a> para garantir que o ". MAX_PRODUCT_NAME ." funcione corretamente.";
$GLOBALS['strAutoMantenaceEnabledAndRunning'] = "A Manutenção automática esta habilitada, mas não foi disparada. Ela é disparada somente quando o ". MAX_PRODUCT_NAME ." entrega anúncios. Para uma melhor performance, você deve configurar <a href='http://". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>a manutenção agendada</a>";
$GLOBALS['strAutoMantenaceDisabledAndRunning'] = "Porém a manutenção automática foi desabilitada recentemente. Para garantir que o ". MAX_PRODUCT_NAME ." funcione corretamente, você deve ou configurar <a href='http://". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>a manutenção agendada</a> ou <a href='account-settings-maintenance.php'>re-habilitar a manutenção automática</a>.<br><br>Para a melhor performance, você deve configurar <a href='http://". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>a manutenção agendada</a>.";
$GLOBALS['strScheduledMantenaceRunning'] = "<b>A manutenção agendada esta sendo executada corretamente</b>";
$GLOBALS['strAutomaticMaintenanceHasRun'] = "<b>A Manutenção automática esta sendo executada corretamente</b>";
$GLOBALS['strAutoMantenaceEnabled'] = "Porém, a manutenção automática ainda esta habilitada. Para o melhor funcionamento, você deve <a href='account-settings-maintenance.php'>desabilitar ela</a>.";
$GLOBALS['strAutoMaintenanceDisabled'] = "A manutenção automática esta desabilitada.";
$GLOBALS['strAutoMaintenanceEnabled'] = "A manutenção automática esta habilitada. Para o melhor funcionamento, é recomendado que você <a href='account-settings-maintenance.php'>desabilite ela</a>.";
$GLOBALS['strCheckACLs'] = "Verificar ACLs (Camadas de controle de acesso)";
$GLOBALS['strScheduledMaintenance'] = "A manutenção agendada aparenta estar sendo executada corretamente.";
$GLOBALS['strAutoMaintenanceEnabledNotTriggered'] = "A manutenção automática esta habilitada, mas não foi disparada ainda. Note que a manutenção automática ó é disparada quando o ". MAX_PRODUCT_NAME ." entrega algum banner";
$GLOBALS['strAutoMaintenanceBestPerformance'] = "Para o melhor funcionamento é recomendado que se use <a href='http://". OX_PRODUCT_DOCSURL ."/maintenance.html' target='_blank'>manutenção agendada</a>.";
$GLOBALS['strAutoMaintenanceEnabledWilltTrigger'] = "A manutenção agendada esta habilitada e irá disparar a manutenção a cada hora.";
$GLOBALS['strAutoMaintenanceDisabledMaintenanceRan'] = "A manutenção automática também esta desabilitada, mas uma tarefa de manutenção foi executada recentemente. Para garantir que o ". MAX_PRODUCT_NAME ." funcione corretamente você deve ou configurar a <a href='http://". OX_PRODUCT_DOCSURL ."/maintenance.html' target='_blank'>manutenção agendada</a> ou <a href='settings-admin.php'>habilitar a manutenção automática</a>.";
$GLOBALS['strAutoMaintenanceDisabledNotTriggered'] = "Também, a manutenção automática esta desablitada, portanto, quando o ". MAX_PRODUCT_NAME ." entregar banners, a manutenção não é disparada. Cao não planeje executar <a href='http://". OX_PRODUCT_DOCSURL ."/maintenance.html' target='_blank'>a manutenção agendada</a>, você deve <a href='settings-admin.php'>habilitar a manutenção automática</a> para garantir que o ". MAX_PRODUCT_NAME ." funcione corretamente.";
$GLOBALS['strAllBannerChannelCompiled'] = "Todos valores de limiteções de banners/canais foram re-compilados";
$GLOBALS['strBannerChannelResult'] = "Este são os resultados da validação da compilação de limites de banners/canais";
$GLOBALS['strChannelCompiledLimitationsValid'] = "Todos limites compilados para os canais são válidos";
$GLOBALS['strBannerCompiledLimitationsValid'] = "Todos limites compilados para os banners são válidos";
$GLOBALS['strErrorsFound'] = "Erros foram encontrados";
$GLOBALS['strRepairCompiledLimitations'] = "Inconsistências foram encontradas acima, você pode corrigir estas usando o botão abaixo, isso irá recompilar as limitações de todos os banners/canais do sistema<br />";
$GLOBALS['strRecompile'] = "Re-compilar";
$GLOBALS['strAppendCodesDesc'] = "Em algumas situações o núcleo de entrega pode discordar com o código de rastreamento armazenado, use o link a seguir para validar os códigos na base de dados";
$GLOBALS['strCheckAppendCodes'] = "Verificar códigos anexados";
$GLOBALS['strAppendCodesRecompiled'] = "Todos códigos anexados foram re-compilados";
$GLOBALS['strAppendCodesResult'] = "Estes são os resultados da validação da compilação de códigos anexados";
$GLOBALS['strAppendCodesValid'] = "Todos códigos compilados para os rastreadores são válidos";
$GLOBALS['strRepairAppenedCodes'] = "Algumas inconsistências foram encontradas acima, você pode reparar estas utilizando botão abaixo, isso irá recompilar todos os códigos de todos rastreadores no sistema";
$GLOBALS['strScheduledMaintenanceNotRun'] = "A manutenção agendada não foi executada na última hora. Isto pode significar que ela nõ foi corretamente configurada.";
$GLOBALS['strDeliveryEngineDisagreeNotice'] = "Em algumas situações o núcleo de entrega pode discordar com o ACL armazenado, use o link a seguir para validar os ACLsna base de dados";
?>