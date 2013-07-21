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

$conf = $GLOBALS['_MAX']['CONF'];
$name = (!($GLOBALS['_MAX']['PREF']['name'])) ? $GLOBALS['_MAX']['PREF']['name'] : MAX_PRODUCT_NAME;
$varprefix = $conf['var']['prefix'];

$words =  array(
    'Single page call' => 'Llamada única a página',
    'SPC Header script comment' => 'de su página * * Nota: Lea la documentación para usos avanzados"',
    'SPC codeblock comment' => '      * Cada uno de los bloques de código siguientes refiere a una zona de anuncios individual,
      * para mostrar el anuncio, simplemente ponga la etiqueta en su página HTML
      * en la posición donde quiera que se muestre el anuncio',
    'SPC Header script instrct' => 'de su site"',
    'SPC codeblock instrct' => '      Cada uno de los bloques de código siguientes se refiere a una zona
        indivudual, para mostrar el anuncio, simplemente ponga la etiqueta en su
        página HTML en la posición donde quiera que se muestre el anuncio',
    'Option - noscript' => 'Incluir etiquetas <noscript>',
    'Option - SSL' => 'Generar código para ser usado en páginas SSL',
);
?>
