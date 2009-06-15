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
$Id: xmlrpc_es.php 33995 2009-03-18 23:04:15Z chris.nutting $
*/

$words =  array(
    'XML-RPC Tag' => 'Código XML-RPC',
    'Allow XML-RPC Tags' => 'Permitir código XML-RPC',
    'PHP Comment' => '
  * Ya que el siguiente script intenta crear cookies, se debe llamar
  * antes de enviar cualquier otro input al navegador del usuario. Una vez el script
  * haya terminado, el código HTML necesario para mostrar el banner se
  * guarda en el array \$adArray (para que se pueda obtener múltiples anuncios 
  * usando múltiples etiquetas). Una vez todos los anuncios se han obtenido, y todas
  * las cookies se han enviado, entonces puede enviar datos al navegador del usuario, y
  * mostrar el contenido de \$adArray cuando lo necesite.
  *
  * El código de ejemplo para imprimir el contenido de \$adArray está al final de la etiqueta -
  * necesitará borrar esto antes de usar la etiqueta en entorno de producción.
  * Acuérdese de asegurarse de que el paquete PEAR::XML-RPC está instalado
  * y disponible para este script, y de sobreescribir el archivo
  * lib/xmlrpc/php/openads-xmlrpc.inc.php. Puede que necesite
  * alterar el valor del \'include_path\' a continuación.
  */',
);

?>
