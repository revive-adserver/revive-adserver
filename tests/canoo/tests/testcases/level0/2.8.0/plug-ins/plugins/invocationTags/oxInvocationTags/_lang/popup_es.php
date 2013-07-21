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

$words =  array(
    'Comment' => '
  * Esta etiqueta ha sido generada para usarse en una página sin SSL. Si este tag
  * ha de colocarse en una página SSL, cambie
  *   \'http:///...\'
  * por
  *   \'https:///...\'
  *',
    'Third Party Comment' => '
  -- No se olvide de reemplazar el texto \'Insert_Clicktrack_URL_Here\' con
  -- la URL de rastreo de clics si este anuncio se va a entregar vía   -- adserver de terceros
 (no-Max).
  --
  -- No se olvide de reemplazar el texto \'Insert_Random_Number_Here\' con
  -- un número aleatorio para eliminación de cache cada vez que se entregue la etiqueta  -- a través de un adserver de terceros (non-Max).
  --',
    'Popup Tag' => 'Etiqueta Pop-up',
    'Allow Popup Tags' => 'Permitir etiquetas Pop-up',
);

?>
