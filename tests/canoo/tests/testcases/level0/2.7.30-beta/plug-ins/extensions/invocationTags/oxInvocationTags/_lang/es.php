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
    'SSL Delivery Comment' => '
  * Esta etiqueta ha sido generada para usarse en una página sin SSL. Si este tag
  * ha de colocarse en una página SSL, cambie
  *   \'http:///...\'
  * por
  *   \'https:///...\'
  *',
    'Cache Buster Comment' => '
  * Reemplazar todos los {random} con
  * un número generado aleatoriamente (o un timestamp).
  *',
    'SSL Backup Comment' => '
  * La sección de imagen de seguridad de esta etiqueta ha sido generada para usarse en una página sin SSL. Si este tag
  * ha de colocarse en una página SSL, cambie
  *   \'http:///...\'
  * por
  *   \'https:///...\'
  *',
    'Please choose the type of banner invocation' => 'Izquierda',
    'Copy to clipboard' => 'Copiar al portapapeles',
    'copy' => 'copiar',
    'px' => 'px',
    'sec' => 'seg',
    'Banner selection' => 'Selección de banner',
    'Target frame' => 'Marco objetivo',
    'Source' => 'Origen',
    'Show text below banner' => 'Mostrar texto bajo el banner',
    'Don\'t show the banner again on the same page' => 'No mostrar el banner de nuevo en la misma página',
    'Don\'t show a banner from the same campaign again on the same page' => 'No mostrar un banner de la misma campaña de nuevo en la misma página',
    'Store the banner inside a variable so it can be used in a template' => 'Guardar el banner en una variable para que pueda ser usado en un template',
    'Banner ID' => 'Banner ID',
    'No Zones Available!' => 'No hay zonas disponibles!',
    'Include comments' => 'Incluir comentarios',
    'Style' => 'Estilo',
    'Alignment' => 'Alineación',
    'Horizontal alignment' => 'Alineación horizontal',
    'Left' => 'Izquierda',
    'Center' => 'Centro',
    'Right' => 'Derecha',
    'Vertical alignment' => 'Alineación vertical',
    'Top' => 'Arriba',
    'Middle' => 'Medio',
    'Bottom' => 'Abajo',
    'Automatically collapse after' => 'Cerrar automáticamente después de',
    'Close text' => 'Texto de cerrar',
    '[Close]' => '[Cerrar]',
    'Banner padding' => 'Padding del banner',
    'Horizontal shift' => 'Desvío horizontal',
    'Vertical shift' => 'Desvío vertical',
    'Show close button' => 'Mostrar botón de cerrar',
    'Background color' => 'Color de fondo',
    'Border color' => 'Color del borde',
    'Direction' => 'Dirección',
    'Left to right' => 'Izquierda a derecha',
    'Right to left' => 'Derecha a izquierda',
    'Looping' => 'Bucle',
    'Always active' => 'Siempre activo',
    'Speed' => 'Velocidad',
    'Pause' => 'Pausa',
    'Limited' => 'Limitado',
    'Left margin' => 'Margen izquierdo',
    'Right margin' => 'Margen derecho',
    'Transparent background' => 'Fondo transparente',
    'Smooth movement' => 'Movimiento suave',
    'Hide the banner when the cursor is not moving' => 'Esconder el banner si el cursor no se mueve',
    'Delay before banner is hidden' => 'Retardo antes de ocultar el banner',
    'Transparancy of the hidden banner' => 'Transparencia del banner oculto',
    'Support 3rd Party Server Clicktracking' => 'Permitir rastreo de clics de terceros',
    'Refresh after' => 'Refrescar después de',
    'Resize iframe to banner dimensions' => 'Redimensionar el iframe a las dimensiones del banner',
    'Make the iframe transparent' => 'Hacer el iframe transparente',
    'Include Netscape 4 compatible ilayer' => 'Incluir una capa compatible con Netscape 4',
    'Pop-up type' => 'Tipo pop-up',
    'Pop-up' => 'Pop-up',
    'Pop-under' => 'Pop-under',
    'Instance when the pop-up is created' => 'Definir cuándo se crea el pop-up',
    'Immediately' => 'Inmediatamente',
    'When the page is closed' => 'Cuando se cierra la página',
    'After' => 'Después',
    'Automatically close after' => 'Cerrar automáticamente después de',
    'Initial position (top)' => 'Posición inicial (arriba)',
    'Initial position (left)' => 'Posición inicial (izda)',
    'Window options' => 'Opciones de ventana',
    'Toolbars' => 'Barra de herramientas',
    'Location' => 'Barra de dirección',
    'Menubar' => 'Barra de menú',
    'Status' => 'Barra de estado',
    'Resizable' => 'Redimensionable',
    'Scrollbars' => 'Barras de scroll',
    'Host Language' => 'Lenguaje del host',
    'Use HTTPS to contact XML-RPC Server' => 'Usar HTTPS para contactar al servidor XML-RPC',
    'XML-RPC Timeout (Seconds)' => 'Timeout del XML-RPC (segundos)',
);

?>
