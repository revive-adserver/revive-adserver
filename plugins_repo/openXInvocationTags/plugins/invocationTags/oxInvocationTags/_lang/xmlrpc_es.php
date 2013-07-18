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
