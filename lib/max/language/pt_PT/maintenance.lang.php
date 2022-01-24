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

$GLOBALS['strAutoMantenaceEnabledAndHasntRun'] = "A Manutenção automática esta habilitada, mas não foi disparada. Ela é disparada somente quando o {$PRODUCT_NAME} entrega anúncios. Para uma melhor performance, você deve configurar <a href='http://{$PRODUCT_DOCSURL}/maintenance' target='_blank'>a manutenção agendada</a>";

$GLOBALS['strAutoMantenaceDisabledAndHasntRun'] = "A manutenção automática esta desabilitada, portanto quando o  {$PRODUCT_NAME} entregar banners, a manutenção automática não será disparada. Para a melhor performance você deve configurar a <a href='http://{$PRODUCT_DOCSURL}/maintenance' target='_blank'>manutenção agendada</a>. Porém, se você não for configurar a <a href='http://{$PRODUCT_DOCSURL}/maintenance' target='_blank'>manutenção agendada</a>, então você <i>deve</i> <a href='account-settings-maintenance.php'>habilitar a manutenção automática</a> para garantir que o {$PRODUCT_NAME} funcione corretamente.";

$GLOBALS['strAutoMantenaceEnabledAndRunning'] = "A Manutenção automática esta habilitada, mas não foi disparada. Ela é disparada somente quando o {$PRODUCT_NAME} entrega anúncios. Para uma melhor performance, você deve configurar <a href='http://{$PRODUCT_DOCSURL}/maintenance' target='_blank'>a manutenção agendada</a>";

$GLOBALS['strAutoMantenaceDisabledAndRunning'] = "Porém a manutenção automática foi desabilitada recentemente. Para garantir que o {$PRODUCT_NAME} funcione corretamente, você deve ou configurar <a href='http://{$PRODUCT_DOCSURL}/maintenance' target='_blank'>a manutenção agendada</a> ou <a href='account-settings-maintenance.php'>re-habilitar a manutenção automática</a>.<br><br>Para a melhor performance, você deve configurar <a href='http://{$PRODUCT_DOCSURL}/maintenance' target='_blank'>a manutenção agendada</a>.";

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
$GLOBALS['strBannerCacheExplaination'] = "O cache de banners é usado para agilizar a entrega de banners durante a visualização<br />
Este cache necessita ser atualiza quando:
<ul>
 <li>Você atualizar sua versão do OpenX</li>
 <li>Você mover sua instalação para um novo servidor</li>
</ul>";

// Cache
$GLOBALS['strCache'] = "Cache de entrega";
$GLOBALS['strDeliveryCacheSharedMem'] = "Memória compartilhada está actualmente a ser usada para cache.";
$GLOBALS['strDeliveryCacheDatabase'] = "A base de dados esta atualmente sendo usada como cache";
$GLOBALS['strDeliveryCacheFiles'] = "O cache de entrega esta atualmente sendo armazenado em arquivos múltiplos de seu servidor";

// Storage
$GLOBALS['strStorage'] = "Armazenamento";
$GLOBALS['strMoveToDirectory'] = "Mover imagens armazenadas dentro da base de dados em um diretório";
$GLOBALS['strStorageExplaination'] = "As imagens usadas por banners locais estão armazenadas na base de dados ou em um diretório local. Se você armazena-las dentro de um diretório a carga sobre a base de dados será menor e haverá uma melhora na velocidade.";

// Security

// Encoding
$GLOBALS['strEncoding'] = "Codificação";
$GLOBALS['strEncodingExplaination'] = "Agora o {$PRODUCT_NAME} grava todos os dados no banco no formato UTF-8.<br />Sempre que possível seus dados serão automaticamente convertidos para esta codificação.<br />Caso após uma atualização você encontre caracteres corrompidos, e conheça a codificação usada, pode utilizar esta ferramenta para converter os dados para o formato UTF-8";
$GLOBALS['strEncodingConvertFrom'] = "Converter desta codificação:";
$GLOBALS['strEncodingConvertTest'] = "Testar conversão";
$GLOBALS['strConvertThese'] = "Os seguintes dados serão alterados caso você siga em frente";

// Product Updates
$GLOBALS['strSearchingUpdates'] = "Procurando atualizações. Por favor aguarde ...";
$GLOBALS['strAvailableUpdates'] = "Atualizações disponíveis";
$GLOBALS['strDownloadZip'] = "Fazer Download (.zip)";
$GLOBALS['strDownloadGZip'] = "Fazer Download (.tar.gz)";

$GLOBALS['strUpdateAlert'] = "Uma nova versão do {$PRODUCT_NAME} está disponível.

Deseja obter mais informações?";
$GLOBALS['strUpdateAlertSecurity'] = "Uma nova versão do {$PRODUCT_NAME} está disponível.

É altamente recomendado que o upgrade
seja feito o mais rápido possível, pois esta
versão contêm correções de segurança.";

$GLOBALS['strUpdateServerDown'] = "Devido a um motivo desconhecido é impossível resgatar <br /> informações sobre possíveis atualizações. Tente novamente mais tarde.";

$GLOBALS['strNoNewVersionAvailable'] = "	Sua versão de {$PRODUCT_NAME} esta atualizada. Nenhuma atualização disponível.";



$GLOBALS['strNewVersionAvailable'] = "<b>Uma nova versão de {$PRODUCT_NAME} está disponível.</b><br /> É recomendado que esta atualização seja instalada,
pois ela corrige problemas existentes e adiciona novas funcionalidades. Para obter mais informações sobre atualização
leia a documentação que esta inclusa nos arquivos abaixo.";

$GLOBALS['strSecurityUpdate'] = "	<b>É altamente recomendado que esta atualização seja instalada pois ela corrige vários problemas de segurança.</b> A versão atual do {$PRODUCT_NAME} que você esta utilizando pode estar vulnerável a alguns ataques e pode não ser segura. Para obter mais informações sobre como atualizar este produto, leia a documentação inclusa nos arquivos abaixo.";

$GLOBALS['strNotAbleToCheck'] = "	<b>A extensão XML não esta disponível em seu servidor, {$PRODUCT_NAME} não consegue verificar se uma nova versão esta disponível.</b>";

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



// Users
