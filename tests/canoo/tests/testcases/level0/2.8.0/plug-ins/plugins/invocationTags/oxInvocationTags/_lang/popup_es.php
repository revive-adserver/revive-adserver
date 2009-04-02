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
$Id: popup_es.php 33995 2009-03-18 23:04:15Z chris.nutting $
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
