<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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
$Id$
*/

// Settings help translation strings
$GLOBALS['phpAds_hlp_dbhost'] = "\n        Especifique el nombre del host donde se encuentra la base de datos de ".$phpAds_dbmsname.".\n		";
		
$GLOBALS['phpAds_hlp_dbuser'] = "\n        Especifique el nombre de usuario con el cual ".$phpAds_productname." accederá a la base de datos ".$phpAds_dbmsname.".\n		";
		
$GLOBALS['phpAds_hlp_dbpassword'] = "\n        Especifique el password que usará ".$phpAds_productname." para acceder a la base de datos ".$phpAds_dbmsname.".\n		";
		
$GLOBALS['phpAds_hlp_dbname'] = "\n        Especifique el nombre de la base de datos donde ".$phpAds_productname." debe ingresar los datos.\n		";
		
$GLOBALS['phpAds_hlp_persistent_connections'] = "\n	El uso de conexiones persistentes puede acelerar el uso de ".$phpAds_productname." considerablemente\n	y posiblemente decremente la carga en el server. Sin embargo hay un inconveniente\; en sitios en los cuales\n	hay gran cantidad de visitantes, la carga en el servidor puede incrementar usando conexiones normales.\n	Ud. deberá decidir que tipo de conexión usar dependiendo de la cantidad de visitanes y el hardware que Ud. use.\n	Si ".$phpAds_productname." está usando demasiados recursos, deberá revisar esta configuración primero.\n		";
		
$GLOBALS['phpAds_hlp_compatibility_mode'] = "\n        Si está teniendo dificultades integrando ".$phpAds_productname." con otro producto de un tercero, tal vez le ayude habilitar\n		el modo de compatibilidad de base de datos. Si está usando el modo de invocación local y la compatibilidad de base de datos\n		se encuentra activada en ".$phpAds_productname." debe dejar el estado de conexión de la base de datos exactamente como se\n		encontraba antes de correr ".$phpAds_productname.".\n		Esta opción es un tanto mas lenta y por lo tanto deshabilitada por default.\n		";
		
$GLOBALS['phpAds_hlp_table_prefix'] = "\n        Si la base de datos ".$phpAds_productname." es usada o compartida por multiples softwares, es aconsejable agregar un prefijo al nombre de las tablas.\n		Si está usando multiples instalaciones de ".$phpAds_productname."\n		en la misma base de datos, deberá asegurarse que este prefijo sea único para todas las instalaciones.\n		";
		
$GLOBALS['phpAds_hlp_tabletype'] = "\n        ".$phpAds_dbmsname." soporta multiples tipos de tablas. Cada tipo de tabla tiene una propiedades únicas y algunas pueden acelerar ".$phpAds_productname."\n		considerablemente. MyISAM es el tipo predeterminado y se encuentra disponible en todas las instalaciones de ".$phpAds_dbmsname.". \n		Otro tipo de tablas tal vez no se encuentren disponibles en su servidor.\n		";
		
$GLOBALS['phpAds_hlp_url_prefix'] = "\n        ".$phpAds_productname." necesita saber donde se encuentra ubicado en el web server para \n        funcionar correctamente. Debe especificar la URL hacia el directorio donde ".$phpAds_productname."\n        se encuentra instalado, por ejemplo: http://www.su-sitio.com/".$phpAds_productname.".\n		";
		
$GLOBALS['phpAds_hlp_my_header'] =
$GLOBALS['phpAds_hlp_my_footer'] = "\n        Aquí debe ingresar la dirección hacia el archivo de encabeazdo (ej.: /home/login/www/encabezado.htm)\n        para usar un encabezado y/o pie de página en cada página de la interface de administración.\n        Puede usar texto o código HTML en estos archivos (si va a utilizar HTML en uno o en ambos\n        archivos no use los tags <body> o <html>).\n		";
		
$GLOBALS['phpAds_hlp_content_gzip_compression'] = "\n		Habilitando la compresión de contenido GZIP obtendrá un gran decrecimiento en el envío de datos\n		al navegador cada vez que abra una página de la interfaz de administración.\n		Para habilitar esta característica debe tener al menos PHP 4.0.5 con la extensión GZIP instalada.\n		";
		
$GLOBALS['phpAds_hlp_language'] = "\n        Especifique el idioma predeterminado para ".$phpAds_productname.". Este idioma será\n        usado com predeterminado para la interfaz de administración y de anunciantes. Note que\n        puede asignar un idioma diferente para cada anunciante en la interfaz de administración\n        y puede permitir que ellos mismos cambien su idioma.\n		";
		
$GLOBALS['phpAds_hlp_name'] = "\n        Especifique el nombre que desea usar para esta aplicación. El nombre se mostrará\n        en todas las páginas en la interface de administración y del anunciante. Si deja esta opción\n        incompleta, aparecerá un logo de ".$phpAds_productname." en su lugar.\n		";
		
$GLOBALS['phpAds_hlp_company_name'] = "Este nombre se usa en el e-mail enviado por ". MAX_PRODUCT_NAME .".";
		
$GLOBALS['phpAds_hlp_override_gd_imageformat'] = "\n        ".$phpAds_productname." detecta normalmente si la librería GS se encuentra instalada y que\n        formato de imagenes soporta la versión instalada. También es posible\n        que la detección automática falle, ya que algunas versiones de PHP no soportan\n        la autodetección. Si ".$phpAds_productname." falla, puede ingresar lso formatos de imagenes soportados\n        manualmente. Los valroes posibles son: none, png, jpeg, gif.\n		";
		
$GLOBALS['phpAds_hlp_p3p_policies'] = "\n        Si desea habilitar las Políticas de Privacidad P3P de ".$phpAds_productname."'\n        debe habilitar esta opción.\n		";
		
$GLOBALS['phpAds_hlp_p3p_compact_policy'] = "\n        Políticas compactas enviadas junto a las cookies. La configuración predeterminada\n        es: 'CUR ADM OUR NOR STA NID', que permitirá al Internet Explorer 6 aceptar\n        las cookies usadas por ".$phpAds_productname.". Puede alterar esta configuración si lo desea.\n        ";
		
$GLOBALS['phpAds_hlp_p3p_policy_location'] = "\n        Si desea usar las Políticas de Privacidad completas, puede especificar la\n        ubicación ed las mismas.\n		";
		
$GLOBALS['phpAds_hlp_compact_stats'] = "\n        Tradicionalmente ".$phpAds_productname." usaba el método de logueo extendido, el cual\n        era muy detallado, pero era muy demandante para el servidor de bases de datos. Esto puede\n        ser un gran problema en sitios con una gran cantidad de visitantes.\n        Para resolver este problema	".$phpAds_productname." soporta una nueva clase de estadísticas.\n        Las estadísticas compactas, son menos demandantes aunque también menos detalladas. Si necesita un\n        detalle por hora deberá deshabilitar la opción de estadísticas compactas.\n		";
		
$GLOBALS['phpAds_hlp_log_adviews'] = "\n        Normalmente todas las impresiones son logueadas. Si no desea obtener estadísticas de\n        las impresiones puede deshabilitar esta opción.\n		";
		
$GLOBALS['phpAds_hlp_block_adviews'] = "\n		Si un visitante actualiza la página una Impresión es logueada por ".$phpAds_productname." cada vez.\n		Esta opción es utilizada para asegurarse de que se logueará únicamente una Impresión por visitante\n		por una cantidad de segundos especificados. Por ejemplo: si en esta opción indica 60 segundos,\n        por mas que un mismo usuario actualize la misma página 5 veces en 60 segundos solo se logueará una impresión.\n        Esta opción solo funcionará si está habilitada la opción <i>USar beacons para loguear Impresiones</i> y\n        si el navegador acepta cookies.\n		";
		
$GLOBALS['phpAds_hlp_log_adclicks'] = "\n        Normalmente todos los Clicks son logueados. Si no desea obtener estadísticas de\n        Clicks puede deshabilitar esta opción.\n		";
		
$GLOBALS['phpAds_hlp_block_adclicks'] = "\n		Si un visitante clickea multiples veces un banner, un Click es logueada por ".$phpAds_productname." cada vez.\n		Esta opción es utilizada para asegurarse de que se logueará únicamente un Banner por visitante\n		por una cantidad de segundos especificados. Por ejemplo: si en esta opción indica 60 segundos,\n        por mas que un mismo usuario clickee multiples veces en un banner en 60 segundos solo se logueará un Click.\n        Esta opción solo funcionará si el navegador acepta cookies.\n		";
		
$GLOBALS['phpAds_hlp_reverse_lookup'] = "\n        ".$phpAds_productname." loguea la IP de cada visitante. Si desea que\n        ".$phpAds_productname." loguee los nombres de dominios, habilite esta opción. Reverse lookup\n        toma algún tiempo, por lo tanto hará el sistema más lento.\n		";
		
$GLOBALS['phpAds_hlp_proxy_lookup'] = "\n		Algunos usuarios usan un servidor proxy para conectarse a internet. En este caso\n		".$phpAds_productname." logueará la IP o el nombre de host del servidor proxy\n		en lugar del del usuario. Si habilita esta opción ".$phpAds_productname." intentará\n		hallar la IP o el host del usuario detrás del servidor proxy.\n		De no ser posible hallar la IP o el host exacto del usuario, se logueará la del servidor proxy\n		en su lugar. habilitar esta opción hará mas lento elproceso de logueo.\n		";
		
$GLOBALS['phpAds_hlp_ignore_hosts'] = "\n        Si no desea contar los Clicks o Impresiones de determinados dominios o IPs\n        puede agregarlos a esta lista. Si tiene habilitado <i>Reverse Lookup</i>\n        puede agregar nombres de dominios o IPs, o bien solamente IPs.\n        Puede usar comodines (por ejemplo: '*.altavista.com' or '192.168.*').\n		";
		
$GLOBALS['phpAds_hlp_begin_of_week'] = "\n        Para la mayoría de las personas la semana empieza el Lunes, pero si desea especificar que la semana\n        comience los Domingos, puede hacerlo.\n		";
		
$GLOBALS['phpAds_hlp_percentage_decimals'] = "\n        Especifica cuantos decimales usar en las páginas de estadísticas.\n		";
		
$GLOBALS['phpAds_hlp_warn_admin'] = "\n        ".$phpAds_productname." puede enviarle un e-mail si una campaña tiene solo un número limitado\n        de Clicks o Impresiones disponibles. Esta opción se encuentra habilitada por defecto.\n		";
		
$GLOBALS['phpAds_hlp_warn_client'] = "". MAX_PRODUCT_NAME ." puede enviar un e-mail a un anunciante si una de sus campañas tiene sólo un ";
		
$GLOBALS['phpAds_hlp_qmail_patch'] = "Algunas versiones de qmail están afectadas por un bug, que hace que los e-mails enviados por ". MAX_PRODUCT_NAME ." muestren las cabeceras dentro del cuerpo del mensaje. Si activa esta opción, ". MAX_PRODUCT_NAME ."  enviará los e-mails en un formato compatible con qmail.";
		
$GLOBALS['phpAds_hlp_warn_limit'] = "El límite en el cual ". MAX_PRODUCT_NAME ." empieza a enviar e-mails de alerta. Dicho límite es 100";
		
$GLOBALS['phpAds_hlp_allow_invocation_plain'] = 
$GLOBALS['phpAds_hlp_allow_invocation_js'] = 
$GLOBALS['phpAds_hlp_allow_invocation_frame'] = 
$GLOBALS['phpAds_hlp_allow_invocation_xmlrpc'] = 
$GLOBALS['phpAds_hlp_allow_invocation_local'] = 
$GLOBALS['phpAds_hlp_allow_invocation_interstitial'] = 
$GLOBALS['phpAds_hlp_allow_invocation_popup'] = "\n		Estas opciones le permiten controlas que tipos de invocación están permitidos.\n		Si uno de estos tipos es deshabilitado, no se encontrará disponible\n		en el Generador de Códigos de Banners. Importante: Los métodos de invocación\n		seugirán funcionando aunque se deshabilite alguna opción, pero no estará disponible en el Generador.\n		";
		
$GLOBALS['phpAds_hlp_con_key'] = "\n        ".$phpAds_productname." incluye un poderoso sistema de recuperación de palabras claves usando\n        selección directa. para mayor información, por favor lea la Guia de Usuarios. Con esta opción, puede\n		activar palabras claves condicionales. Esta opción está habilitada por defecto.\n		";
		
$GLOBALS['phpAds_hlp_mult_key'] = "\n        Si usa selección directa para mostrar banners, puede especificar una o mas palabras claves\n		para cada banner. Esta opción debe estar habilitada si desea utiliazr mas de una palabra clave.\n        Esta opción se encuentra habilitada por defecto.\n		";
		
$GLOBALS['phpAds_hlp_acl'] = "\n        Si no está usando limitaciones de envío puede deshabilitar esta opción con este parámetro.\n        Esto acelerará un poco mas a ".$phpAds_productname.".\n		";
		
$GLOBALS['phpAds_hlp_default_banner_url'] = 
$GLOBALS['phpAds_hlp_default_banner_target'] = "\n        Si ".$phpAds_productname." no puede conectarse con el servidor de bases de datos, o no puede encontrar\n        ningun banner, (por ejemplo cuando la base de datos colisiona o es borrada)\n        no se mostrará nada. Algunos usuarios querrán usar un banner por defecto en estos casos.\n        El banner predeterminado no será logueado y no será usado si hay otros banners para mostrar\n        en la base de datos. Esta opción se encuentra deshabilitada por defecto.\n		";
		
$GLOBALS['phpAds_hlp_zone_cache'] = "\n        Si está usando zonas, esta opción le perimte a ".$phpAds_productname." almacenar la información de\n        los banners en un cache que será usado mas tarde. Esto incrementará la velocidad de ".$phpAds_productname.",\n         ya que en lugar de consultar la información de la zona cada vez que se debe enviar un banner,\n         ".$phpAds_productname." solo necesita utilizar el cache almacenado. Esta opción se encuentra habilitada\n        por defecto.\n		";
		
$GLOBALS['phpAds_hlp_zone_cache_limit'] = "\n        Si utiliza Cache de Zonas, la información del cache puede desactualizarse.\n         De vez en cuando ".$phpAds_productname." debe reconstruir el cache, para que sean\n        agregados los nuevos banners al cache. Esta opción le permite decidir cada cuanto\n        deben reconstruirse los caches de zonas especificando en cuanto tiempo vence el cache\n		";
		
$GLOBALS['phpAds_hlp_type_sql_allow'] = 
$GLOBALS['phpAds_hlp_type_web_allow'] = 
$GLOBALS['phpAds_hlp_type_url_allow'] = 
$GLOBALS['phpAds_hlp_type_html_allow'] = 
$GLOBALS['phpAds_hlp_type_txt_allow'] = "\n        ".$phpAds_productname." puede utilizar diferentes tipos de banners y almacenarlos de\n        diferentes maneras. Las primeras dos opciones se utilizan para el almacenamiento local de banners.\n        Puede utilizar la interface de administrador para subir un banner y ".$phpAds_productname." lo alacenará\n        en la base de datos SQL o en el servidor web. También puede utilizar un banner almacenado en un servidor web\n        o usar HTML para generar un banner.\n		";
		
$GLOBALS['phpAds_hlp_type_web_mode'] = "\n        Si desea usar banners almacenados en el servidor web, debe establecer\n        esta opción. Si desea almacenar lso banners en un directorio local establezca esta opción como\n        <i>Directorio Local</i>. Si desea almacenar el banner en un servidor FTP externo\n        establezca esta opción como <i>Servidor FTP Externo</i>.\n		";
		
$GLOBALS['phpAds_hlp_type_web_dir'] = "\n        Especifique el directorio donde ".$phpAds_productname." debe copiar los banners subidos.\n         Este directorio debe tener permisos de escritura para PHP. El directorio especificado\n        debe estar disponible para el servidor web. No ingrese una barra invertida (/) al final. Debe configurar\n        esta opción solamente si ha especificado el método de almacenamiento como <i>Directorio Local</i>.\n		";
		
$GLOBALS['phpAds_hlp_type_web_ftp_host'] = "\n		Si establece el método de almacenamiento como <i>Servidor FTP Externo</i> debe\n		especificar la IP o nombre de dominio del servidor FTP donde ".$phpAds_productname." copiará\n		los banners.\n		";
      
$GLOBALS['phpAds_hlp_type_web_ftp_path'] = "\n        Si establece el método de almacenamiento como <i>Servidor FTP Externo</i> debe\n		especificar el directorio en el servidor FTP donde ".$phpAds_productname." copiará\n		los banners.\n		";

$GLOBALS['phpAds_hlp_type_web_ftp_user'] = "\n        Si establece el método de almacenamiento como <i>Servidor FTP Externo</i> debe\n		especificar el nombre de usuario que ".$phpAds_productname." utilizará para conectarse al servidor FTP\n		";

$GLOBALS['phpAds_hlp_type_web_ftp_password'] = "\n        Si establece el método de almacenamiento como <i>Servidor FTP Externo</i> debe\n		especificar el password que ".$phpAds_productname." utilizará para conectarse al servidor FTP\n		";

$GLOBALS['phpAds_hlp_type_web_url'] = "\n        Si almacena los banners en un servidor web, ".$phpads_productname." necesita conocer la\n        URL pública correspondiente con el directorio especificado anteriormente.\n        No ingrese una barra invertida (/) al final.\n		";
		
$GLOBALS['phpAds_hlp_type_html_auto'] = "\n        Si esta opción está habilitada, ".$phpAds_productname." alterará automáticamente los banners\n        HTML para permitir el logueo de clicks. Sin embargo, aunque esta opción esté habilitada\n        puede ser posible deshabilitarla en una BASE POR BANNER.\n		";
		
$GLOBALS['phpAds_hlp_type_html_php'] = "\n        Es posible permitir a ".$phpAds_productname." ejecutar código PHP insertado en banners HTML. Esta\n        opción se encuentra deshabilitada por defecto.\n		";
		
$GLOBALS['phpAds_hlp_admin'] = "\n        Nombre de usuario del Administrador. Puede especificar el nombre de usuario del Administrador\n        para loguearse en lainterface de administración.\n		";
		
$GLOBALS['phpAds_hlp_pwold'] = 
$GLOBALS['phpAds_hlp_pw'] = 
$GLOBALS['phpAds_hlp_pw2'] = "\n        Para cambiar el password del administrador, deberá ingresar el password anterior. Y luego\n        ingresar el nuevo password dos veces para prevenir errores de tipeo.\n		";
		
$GLOBALS['phpAds_hlp_admin_fullname'] = "\n        Ingrese el nombre completo del Administrador. Es usado para el envío de estadísticas\n        via email.\n		";
		
$GLOBALS['phpAds_hlp_admin_email'] = "El e-mail del administrador. Se usa como remitente cuando";
		
$GLOBALS['phpAds_hlp_admin_email_headers'] = "\n        Puede alterar los encabezados de los e-mails enviados por ".$phpAds_productname.".\n		";
		
$GLOBALS['phpAds_hlp_admin_novice'] = "Para ver campañas que hayan empezado o terminado en el espacio de tiempos eleccionado, Audit Trail debe estar activado";
		
$GLOBALS['phpAds_hlp_client_welcome'] = 
$GLOBALS['phpAds_hlp_client_welcome_msg'] = "\n       Si activa esta opción se mostrará un mensaje de bienvenida en la\n        primera página que verá el anunciante luego de loguearse. Puede personalizar este mensaje\n        editando el archivo 'welcome.html' ubicado en el directorio 'admin/templates'. Quizás quiera\n        incluir datos como : Nombre de la Compañía, Información de Contacto, Logo de la Compañía, etc..\n		";
		
$GLOBALS['phpAds_hlp_updates_frequency'] = "\n        Si desea buscar nuevas versiones de ".$phpAds_productname." puede habilitar esta opción.\n        Es posible especificar el intervalo en que ".$phpAds_productname." se conecta al server de\n        actualizaciones. Si se encuentra una nueva versión, aparecerá un cuadro de diálogo con la\n        información de la actualización.\n		";
		
$GLOBALS['phpAds_hlp_userlog_email'] = "\n        Si desea mantener una copia de todos los e-mails enviados por ".$phpAds_productname." puede\n        activar esta opción. Los mensajes de e-mail serán almacenados en el userlog.\n		";
		
$GLOBALS['phpAds_hlp_userlog_priority'] = "\n        Para asegurarse que el cálculo de prioridades funcione correctamente, puede guardar\n        un reporte de los calulos de cada hora.\n		";
		
$GLOBALS['phpAds_hlp_default_banner_weight'] = "\n        Si desea utilizar un número de peso de banner mayor por defecto, insertelo aquí.\n        Esta opción es 1 por defecto..\n		";
		
$GLOBALS['phpAds_hlp_default_campaign_weight'] = "\n        Si desea utilizar un número de peso de campaña mayor por defecto, insertelo aquí.\n        Esta opción es 1 por defecto..\n		";
		
$GLOBALS['phpAds_hlp_gui_show_campaign_info'] = "Si esta opción es activada, la información extra acerca de cada campaña será mostrada en la página de <i>Campañas</i>. La información extra incluye número de vistas del anuncio que quedan pendientes, el número de clics al anuncio que quedan pendientes, fecha de activación, fecha de finalización y configuraciones de prioridad.";
		
$GLOBALS['phpAds_hlp_gui_show_banner_info'] = "Si esta opción es activada, la información extra acerca de cada banner será mostrada en la página de <i>Banners</i>. La información extra incluye el URL de destino, palabras clave, tamaño y peso del banner.";
		
$GLOBALS['phpAds_hlp_gui_show_campaign_preview'] = "Si esta opción es activada, una vista previa de todos los banners será mostrada en la página de <i>Banners</i>. Si esta opción es desactivada, todavía es posible ver una vista previa de cada banner haciendo clic en el triángulo al lado de cada banner en la página de <i>Banners</i>.";
		
$GLOBALS['phpAds_hlp_gui_show_banner_html'] = "\n        Si esta opción se encuentra habilitada se verá el banner HTML en lugar del código HTML.\n        Esta opción se encuentra habilitada por defecto.\n        Si esta opción se encuentra deshabilitada aún es posible obtener una vista previa\n        de cada banner clickeando en el botón <i>Mostrar Banner</i>.\n		";
		
$GLOBALS['phpAds_hlp_gui_show_banner_preview'] = "\n        Si esta opción se encuentra habilitada, se mostrará una vista previa al principio de las\n        páginas <i>Propiedades de Banner</i>, <i>Opciones de Entrega</i> y <i>Zonas Relacionadas</i>.\n        Si esta opción se encuentra deshabilitada aún es posible obtener una vista previa\n        de cada banner clickeando en el botón <i>Mostrar Banner</i>.\n		";
		
$GLOBALS['phpAds_hlp_gui_hide_inactive'] = "Si esta opción es activada, todos los banners, campañas y anunciantes inactivos pueden ser escondidos de las páginas de <i>Anunciantes & Campañas</i> y <i>Campañas</i>. Si esta opción está desactivada, todavía es posible ver los ítems escondidos haciendo clic en el botón de <i>Mostrar Todo</i> al final de la página.";
		
?>
