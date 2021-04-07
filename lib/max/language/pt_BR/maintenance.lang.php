<?php

/*
  +---------------------------------------------------------------------------+
  | Revive Adserver                                                           |
  | http://www.revive-adserver.com                                            |
  |                                                                           |
  | Copyright: See the COPYRIGHT.txt file.                                    |
  | License: GPLv2 or later, see the LICENSE.txt file.                        |
  +---------------------------------------------------------------------------+
 */

// Main strings
$GLOBALS['strChooseSection'] = "Escolher seção";
$GLOBALS['strAppendCodes'] = "Anexar códigos";

// Maintenance
$GLOBALS['strScheduledMaintenanceHasntRun'] = "<b>A manutenção agendada não foi executada na última hora. Isto pode significar que a configuração não foi feita de forma correta</b>";





$GLOBALS['strScheduledMantenaceRunning'] = "<b>A manutenção agendada esta sendo executada corretamente</b>";

$GLOBALS['strAutomaticMaintenanceHasRun'] = "<b>A Manutenção automática esta sendo executada corretamente</b>";

$GLOBALS['strAutoMantenaceEnabled'] = "Porém, a manutenção automática ainda esta habilitada. Para o melhor funcionamento, você deve <a href='account-settings-maintenance.php'>desabilitar ela</a>.";

// Priority
$GLOBALS['strRecalculatePriority'] = "Recalcular prioridade";

// Banner cache
$GLOBALS['strCheckBannerCache'] = "Verificar cache de banners ";
$GLOBALS['strBannerCacheErrorsFound'] = "A verificação de cache da base de dados encontrou erros. Estes banners não funcionarão até que sejam corrigidos manualmente.";
$GLOBALS['strBannerCacheOK'] = "Nenhum erro detectado. Seu cache de banners esta atualizado";
$GLOBALS['strBannerCacheDifferencesFound'] = "A verificação do cache de banners detectou que seu cache não esta atualizado e necessita ser regenerado. Clique aqui para atualizar seu cache automaticamente.";
$GLOBALS['strBannerCacheRebuildButton'] = "Gerar novamente";
$GLOBALS['strRebuildDeliveryCache'] = "Regenerar base de cache de banners";

// Cache
$GLOBALS['strCache'] = "Cache de entrega";
$GLOBALS['strDeliveryCacheSharedMem'] = "Memória compartilhada esta sendo usada para cache atualmente.";
$GLOBALS['strDeliveryCacheDatabase'] = "A base de dados esta atualmente sendo usada como cache";
$GLOBALS['strDeliveryCacheFiles'] = "O cache de entrega esta atualmente sendo armazenado em arquivos múltiplos de seu servidor";

// Storage
$GLOBALS['strStorage'] = "Armazenamento";
$GLOBALS['strMoveToDirectory'] = "Mover imagens armazenadas dentro da base de dados em um diretório";
$GLOBALS['strStorageExplaination'] = "As imagens usadas por banners locais estão armazenadas na base de dados ou em um diretório local. Se você armazena-las dentro de um diretório a carga sobre a base de dados será menor e haverá uma melhora na velocidade.";

// Encoding
$GLOBALS['strEncoding'] = "Codificação";
$GLOBALS['strEncodingConvertFrom'] = "Converter desta codificação:";
$GLOBALS['strEncodingConvertTest'] = "Testar conversão";
$GLOBALS['strConvertThese'] = "Os seguintes dados serão alterados caso você siga em frente";

// Product Updates
$GLOBALS['strSearchingUpdates'] = "Procurando atualizações. Por favor aguarde ...";
$GLOBALS['strAvailableUpdates'] = "Atualizações disponíveis";
$GLOBALS['strDownloadZip'] = "Fazer Download (.zip)";
$GLOBALS['strDownloadGZip'] = "Fazer Download (.tar.gz)";


$GLOBALS['strUpdateServerDown'] = "Devido a um motivo desconhecido é impossível resgatar <br /> informações sobre possíveis atualizações. Tente novamente mais tarde.";







$GLOBALS['strForUpdatesLookOnWebsite'] = "	Se deseja saber se uma nova versão esta disponível, visite nosso site.";

$GLOBALS['strClickToVisitWebsite'] = "Clique aqui para visitar nosso site";
$GLOBALS['strCurrentlyUsing'] = "Você esta atualmente usando";
$GLOBALS['strRunningOn'] = "rodando em um";
$GLOBALS['strAndPlain'] = "e";

//  Deliver Limitations
$GLOBALS['strErrorsFound'] = "Erros foram encontrados";
$GLOBALS['strRepairCompiledLimitations'] = "Inconsistências foram encontradas acima, você pode corrigir estas usando o botão abaixo, isso irá recompilar as limitações de todos os banners/canais do sistema<br />";
$GLOBALS['strRecompile'] = "Re-compilar";

//  Append codes
$GLOBALS['strAppendCodesDesc'] = "Em algumas situações o núcleo de entrega pode discordar com o código de rastreamento armazenado, use o link a seguir para validar os códigos na base de dados";
$GLOBALS['strCheckAppendCodes'] = "Verificar códigos anexados";
$GLOBALS['strAppendCodesRecompiled'] = "Todos códigos anexados foram re-compilados";
$GLOBALS['strAppendCodesResult'] = "Estes são os resultados da validação da compilação de códigos anexados";
$GLOBALS['strAppendCodesValid'] = "Todos códigos compilados para os rastreadores são válidos";
$GLOBALS['strRepairAppenedCodes'] = "Algumas inconsistências foram encontradas acima, você pode reparar estas utilizando botão abaixo, isso irá recompilar todos os códigos de todos rastreadores no sistema";


