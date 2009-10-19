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
$Id: spc_es.php 33995 2009-03-18 23:04:15Z chris.nutting $
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
