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

// Settings help translation strings
$GLOBALS['phpAds_hlp_dbhost'] = "        Especifique el nombre del host donde se encuentra la base de datos de {$phpAds_dbmsname}.
		";

$GLOBALS['phpAds_hlp_dbuser'] = "        Especifique el nombre de usuario con el cual {$PRODUCT_NAME} accederá a la base de datos {$phpAds_dbmsname}.
		";

$GLOBALS['phpAds_hlp_dbpassword'] = "        Especifique el password que usará {$PRODUCT_NAME} para acceder a la base de datos {$phpAds_dbmsname}.
		";

$GLOBALS['phpAds_hlp_dbname'] = "        Especifique el nombre de la base de datos donde {$PRODUCT_NAME} debe ingresar los datos.
		";

$GLOBALS['phpAds_hlp_persistent_connections'] = "	El uso de conexiones persistentes puede acelerar el uso de {$PRODUCT_NAME} considerablemente
	y posiblemente decremente la carga en el server. Sin embargo hay un inconveniente\; en sitios en los cuales
	hay gran cantidad de visitantes, la carga en el servidor puede incrementar usando conexiones normales.
	Ud. deberá decidir que tipo de conexión usar dependiendo de la cantidad de visitanes y el hardware que Ud. use.
	Si {$PRODUCT_NAME} está usando demasiados recursos, deberá revisar esta configuración primero.
		";

$GLOBALS['phpAds_hlp_compatibility_mode'] = "        Si está teniendo dificultades integrando {$PRODUCT_NAME} con otro producto de un tercero, tal vez le ayude habilitar
		el modo de compatibilidad de base de datos. Si está usando el modo de invocación local y la compatibilidad de base de datos
		se encuentra activada en {$PRODUCT_NAME} debe dejar el estado de conexión de la base de datos exactamente como se
		encontraba antes de correr {$PRODUCT_NAME}.
		Esta opción es un tanto mas lenta y por lo tanto deshabilitada por default.
		";

$GLOBALS['phpAds_hlp_table_prefix'] = "        Si la base de datos {$PRODUCT_NAME} es usada o compartida por multiples softwares, es aconsejable agregar un prefijo al nombre de las tablas.
		Si está usando multiples instalaciones de {$PRODUCT_NAME}
		en la misma base de datos, deberá asegurarse que este prefijo sea único para todas las instalaciones.
		";

$GLOBALS['phpAds_hlp_tabletype'] = "        {$phpAds_dbmsname} soporta multiples tipos de tablas. Cada tipo de tabla tiene una propiedades únicas y algunas pueden acelerar {$PRODUCT_NAME}
		considerablemente. MyISAM es el tipo predeterminado y se encuentra disponible en todas las instalaciones de {$phpAds_dbmsname}.
		Otro tipo de tablas tal vez no se encuentren disponibles en su servidor.
		";

$GLOBALS['phpAds_hlp_url_prefix'] = "        {$PRODUCT_NAME} necesita saber donde se encuentra ubicado en el web server para
        funcionar correctamente. Debe especificar la URL hacia el directorio donde {$PRODUCT_NAME}
        se encuentra instalado, por ejemplo: http://www.su-sitio.com/{$PRODUCT_NAME}.
		";

$GLOBALS['phpAds_hlp_my_header'] =
$GLOBALS['phpAds_hlp_my_footer'] = "        Aquí debe ingresar la dirección hacia el archivo de encabeazdo (ej.: /home/login/www/encabezado.htm)
        para usar un encabezado y/o pie de página en cada página de la interface de administración.
        Puede usar texto o código HTML en estos archivos (si va a utilizar HTML en uno o en ambos
        archivos no use los tags <body> o <html>).
		";

$GLOBALS['phpAds_hlp_content_gzip_compression'] = "		Habilitando la compresión de contenido GZIP obtendrá un gran decrecimiento en el envío de datos
		al navegador cada vez que abra una página de la interfaz de administración.
		Para habilitar esta característica debe tener al menos PHP 4.0.5 con la extensión GZIP instalada.
		";

$GLOBALS['phpAds_hlp_language'] = "        Especifique el idioma predeterminado para {$PRODUCT_NAME}. Este idioma será
        usado com predeterminado para la interfaz de administración y de anunciantes. Note que
        puede asignar un idioma diferente para cada anunciante en la interfaz de administración
        y puede permitir que ellos mismos cambien su idioma.
		";

$GLOBALS['phpAds_hlp_name'] = "        Especifique el nombre que desea usar para esta aplicación. El nombre se mostrará
        en todas las páginas en la interface de administración y del anunciante. Si deja esta opción
        incompleta, aparecerá un logo de {$PRODUCT_NAME} en su lugar.
		";

$GLOBALS['phpAds_hlp_company_name'] = "Este nombre se usa en el e-mail enviado por {$PRODUCT_NAME}.";

$GLOBALS['phpAds_hlp_override_gd_imageformat'] = "        {$PRODUCT_NAME} detecta normalmente si la librería GS se encuentra instalada y que
        formato de imagenes soporta la versión instalada. También es posible
        que la detección automática falle, ya que algunas versiones de PHP no soportan
        la autodetección. Si {$PRODUCT_NAME} falla, puede ingresar lso formatos de imagenes soportados
        manualmente. Los valroes posibles son: none, png, jpeg, gif.
		";

$GLOBALS['phpAds_hlp_p3p_policies'] = "        Si desea habilitar las Políticas de Privacidad P3P de {$PRODUCT_NAME}'        debe habilitar esta opción.
		";

$GLOBALS['phpAds_hlp_p3p_compact_policy'] = "        Políticas compactas enviadas junto a las cookies. La configuración predeterminada
        es: 'CUR ADM OUR NOR STA NID', que permitirá al Internet Explorer 6 aceptar
        las cookies usadas por {$PRODUCT_NAME}. Puede alterar esta configuración si lo desea.
        ";

$GLOBALS['phpAds_hlp_p3p_policy_location'] = "        Si desea usar las Políticas de Privacidad completas, puede especificar la
        ubicación ed las mismas.
		";

$GLOBALS['phpAds_hlp_compact_stats'] = "        Tradicionalmente {$PRODUCT_NAME} usaba el método de logueo extendido, el cual
        era muy detallado, pero era muy demandante para el servidor de bases de datos. Esto puede
        ser un gran problema en sitios con una gran cantidad de visitantes.
        Para resolver este problema	{$PRODUCT_NAME} soporta una nueva clase de estadísticas.
        Las estadísticas compactas, son menos demandantes aunque también menos detalladas. Si necesita un
        detalle por hora deberá deshabilitar la opción de estadísticas compactas.
		";

$GLOBALS['phpAds_hlp_log_adviews'] = "        Normalmente todas las impresiones son logueadas. Si no desea obtener estadísticas de
        las impresiones puede deshabilitar esta opción.
		";

$GLOBALS['phpAds_hlp_block_adviews'] = "		Si un visitante actualiza la página una Impresión es logueada por {$PRODUCT_NAME} cada vez.
		Esta opción es utilizada para asegurarse de que se logueará únicamente una Impresión por visitante
		por una cantidad de segundos especificados. Por ejemplo: si en esta opción indica 60 segundos,
        por mas que un mismo usuario actualize la misma página 5 veces en 60 segundos solo se logueará una impresión.
        Esta opción solo funcionará si está habilitada la opción <i>USar beacons para loguear Impresiones</i> y
        si el navegador acepta cookies.
		";

$GLOBALS['phpAds_hlp_log_adclicks'] = "        Normalmente todos los Clicks son logueados. Si no desea obtener estadísticas de
        Clicks puede deshabilitar esta opción.
		";

$GLOBALS['phpAds_hlp_block_adclicks'] = "		Si un visitante clickea multiples veces un banner, un Click es logueada por {$PRODUCT_NAME} cada vez.
		Esta opción es utilizada para asegurarse de que se logueará únicamente un Banner por visitante
		por una cantidad de segundos especificados. Por ejemplo: si en esta opción indica 60 segundos,
        por mas que un mismo usuario clickee multiples veces en un banner en 60 segundos solo se logueará un Click.
        Esta opción solo funcionará si el navegador acepta cookies.
		";

$GLOBALS['phpAds_hlp_reverse_lookup'] = "        {$PRODUCT_NAME} loguea la IP de cada visitante. Si desea que
        {$PRODUCT_NAME} loguee los nombres de dominios, habilite esta opción. Reverse lookup
        toma algún tiempo, por lo tanto hará el sistema más lento.
		";

$GLOBALS['phpAds_hlp_proxy_lookup'] = "		Algunos usuarios usan un servidor proxy para conectarse a internet. En este caso
		{$PRODUCT_NAME} logueará la IP o el nombre de host del servidor proxy
		en lugar del del usuario. Si habilita esta opción {$PRODUCT_NAME} intentará
		hallar la IP o el host del usuario detrás del servidor proxy.
		De no ser posible hallar la IP o el host exacto del usuario, se logueará la del servidor proxy
		en su lugar. habilitar esta opción hará mas lento elproceso de logueo.
		";

$GLOBALS['phpAds_hlp_ignore_hosts'] = "        Si no desea contar los Clicks o Impresiones de determinados dominios o IPs
        puede agregarlos a esta lista. Si tiene habilitado <i>Reverse Lookup</i>
        puede agregar nombres de dominios o IPs, o bien solamente IPs.
        Puede usar comodines (por ejemplo: '*.altavista.com' or '192.168.*').
		";

$GLOBALS['phpAds_hlp_begin_of_week'] = "        Para la mayoría de las personas la semana empieza el Lunes, pero si desea especificar que la semana
        comience los Domingos, puede hacerlo.
		";

$GLOBALS['phpAds_hlp_percentage_decimals'] = "        Especifica cuantos decimales usar en las páginas de estadísticas.
		";

$GLOBALS['phpAds_hlp_warn_admin'] = "        {$PRODUCT_NAME} puede enviarle un e-mail si una campaña tiene solo un número limitado
        de Clicks o Impresiones disponibles. Esta opción se encuentra habilitada por defecto.
		";

$GLOBALS['phpAds_hlp_warn_client'] = "{$PRODUCT_NAME} puede enviar un e-mail a un anunciante si una de sus campañas tiene sólo un ";

$GLOBALS['phpAds_hlp_qmail_patch'] = "Algunas versiones de qmail están afectadas por un bug, que hace que los e-mails enviados por {$PRODUCT_NAME} muestren las cabeceras dentro del cuerpo del mensaje. Si activa esta opción, {$PRODUCT_NAME}  enviará los e-mails en un formato compatible con qmail.";

$GLOBALS['phpAds_hlp_warn_limit'] = "El límite en el cual {$PRODUCT_NAME} empieza a enviar e-mails de alerta. Dicho límite es 100";

$GLOBALS['phpAds_hlp_allow_invocation_plain'] =
$GLOBALS['phpAds_hlp_allow_invocation_js'] =
$GLOBALS['phpAds_hlp_allow_invocation_frame'] =
$GLOBALS['phpAds_hlp_allow_invocation_xmlrpc'] =
$GLOBALS['phpAds_hlp_allow_invocation_local'] =
$GLOBALS['phpAds_hlp_allow_invocation_interstitial'] =
$GLOBALS['phpAds_hlp_allow_invocation_popup'] = "		Estas opciones le permiten controlas que tipos de invocación están permitidos.
		Si uno de estos tipos es deshabilitado, no se encontrará disponible
		en el Generador de Códigos de Banners. Importante: Los métodos de invocación
		seugirán funcionando aunque se deshabilite alguna opción, pero no estará disponible en el Generador.
		";

$GLOBALS['phpAds_hlp_con_key'] = "        {$PRODUCT_NAME} incluye un poderoso sistema de recuperación de palabras claves usando
        selección directa. para mayor información, por favor lea la Guia de Usuarios. Con esta opción, puede
		activar palabras claves condicionales. Esta opción está habilitada por defecto.
		";

$GLOBALS['phpAds_hlp_mult_key'] = "        Si usa selección directa para mostrar banners, puede especificar una o mas palabras claves
		para cada banner. Esta opción debe estar habilitada si desea utiliazr mas de una palabra clave.
        Esta opción se encuentra habilitada por defecto.
		";

$GLOBALS['phpAds_hlp_acl'] = "        Si no está usando limitaciones de envío puede deshabilitar esta opción con este parámetro.
        Esto acelerará un poco mas a {$PRODUCT_NAME}.
		";

$GLOBALS['phpAds_hlp_default_banner_url'] =
$GLOBALS['phpAds_hlp_default_banner_target'] = "        Si {$PRODUCT_NAME} no puede conectarse con el servidor de bases de datos, o no puede encontrar
        ningun banner, (por ejemplo cuando la base de datos colisiona o es borrada)
        no se mostrará nada. Algunos usuarios querrán usar un banner por defecto en estos casos.
        El banner predeterminado no será logueado y no será usado si hay otros banners para mostrar
        en la base de datos. Esta opción se encuentra deshabilitada por defecto.
		";

$GLOBALS['phpAds_hlp_zone_cache'] = "        Si está usando zonas, esta opción le perimte a {$PRODUCT_NAME} almacenar la información de
        los banners en un cache que será usado mas tarde. Esto incrementará la velocidad de {$PRODUCT_NAME},
         ya que en lugar de consultar la información de la zona cada vez que se debe enviar un banner,
         {$PRODUCT_NAME} solo necesita utilizar el cache almacenado. Esta opción se encuentra habilitada
        por defecto.
		";

$GLOBALS['phpAds_hlp_zone_cache_limit'] = "        Si utiliza Cache de Zonas, la información del cache puede desactualizarse.
         De vez en cuando {$PRODUCT_NAME} debe reconstruir el cache, para que sean
        agregados los nuevos banners al cache. Esta opción le permite decidir cada cuanto
        deben reconstruirse los caches de zonas especificando en cuanto tiempo vence el cache
		";

$GLOBALS['phpAds_hlp_type_sql_allow'] =
$GLOBALS['phpAds_hlp_type_web_allow'] =
$GLOBALS['phpAds_hlp_type_url_allow'] =
$GLOBALS['phpAds_hlp_type_html_allow'] =
$GLOBALS['phpAds_hlp_type_txt_allow'] = "        {$PRODUCT_NAME} puede utilizar diferentes tipos de banners y almacenarlos de
        diferentes maneras. Las primeras dos opciones se utilizan para el almacenamiento local de banners.
        Puede utilizar la interface de administrador para subir un banner y {$PRODUCT_NAME} lo alacenará
        en la base de datos SQL o en el servidor web. También puede utilizar un banner almacenado en un servidor web
        o usar HTML para generar un banner.
		";

$GLOBALS['phpAds_hlp_type_web_mode'] = "        Si desea usar banners almacenados en el servidor web, debe establecer
        esta opción. Si desea almacenar lso banners en un directorio local establezca esta opción como
        <i>Directorio Local</i>. Si desea almacenar el banner en un servidor FTP externo
        establezca esta opción como <i>Servidor FTP Externo</i>.
		";

$GLOBALS['phpAds_hlp_type_web_dir'] = "        Especifique el directorio donde {$PRODUCT_NAME} debe copiar los banners subidos.
         Este directorio debe tener permisos de escritura para PHP. El directorio especificado
        debe estar disponible para el servidor web. No ingrese una barra invertida (/) al final. Debe configurar
        esta opción solamente si ha especificado el método de almacenamiento como <i>Directorio Local</i>.
		";

$GLOBALS['phpAds_hlp_type_web_ftp_host'] = "		Si establece el método de almacenamiento como <i>Servidor FTP Externo</i> debe
		especificar la IP o nombre de dominio del servidor FTP donde {$PRODUCT_NAME} copiará
		los banners.
		";

$GLOBALS['phpAds_hlp_type_web_ftp_path'] = "        Si establece el método de almacenamiento como <i>Servidor FTP Externo</i> debe
		especificar el directorio en el servidor FTP donde {$PRODUCT_NAME} copiará
		los banners.
		";

$GLOBALS['phpAds_hlp_type_web_ftp_user'] = "        Si establece el método de almacenamiento como <i>Servidor FTP Externo</i> debe
		especificar el nombre de usuario que {$PRODUCT_NAME} utilizará para conectarse al servidor FTP
		";

$GLOBALS['phpAds_hlp_type_web_ftp_password'] = "        Si establece el método de almacenamiento como <i>Servidor FTP Externo</i> debe
		especificar el password que {$PRODUCT_NAME} utilizará para conectarse al servidor FTP
		";

$GLOBALS['phpAds_hlp_type_web_url'] = "        Si almacena los banners en un servidor web, {$PRODUCT_NAME} necesita conocer la
        URL pública correspondiente con el directorio especificado anteriormente.
        No ingrese una barra invertida (/) al final.
		";

$GLOBALS['phpAds_hlp_type_html_auto'] = "        Si esta opción está habilitada, {$PRODUCT_NAME} alterará automáticamente los banners
        HTML para permitir el logueo de clicks. Sin embargo, aunque esta opción esté habilitada
        puede ser posible deshabilitarla en una BASE POR BANNER.
		";

$GLOBALS['phpAds_hlp_type_html_php'] = "        Es posible permitir a {$PRODUCT_NAME} ejecutar código PHP insertado en banners HTML. Esta
        opción se encuentra deshabilitada por defecto.
		";

$GLOBALS['phpAds_hlp_admin'] = "        Nombre de usuario del Administrador. Puede especificar el nombre de usuario del Administrador
        para loguearse en lainterface de administración.
		";

$GLOBALS['phpAds_hlp_pwold'] =
$GLOBALS['phpAds_hlp_pw'] =
$GLOBALS['phpAds_hlp_pw2'] = "        Para cambiar el password del administrador, deberá ingresar el password anterior. Y luego
        ingresar el nuevo password dos veces para prevenir errores de tipeo.
		";

$GLOBALS['phpAds_hlp_admin_fullname'] = "        Ingrese el nombre completo del Administrador. Es usado para el envío de estadísticas
        via email.
		";

$GLOBALS['phpAds_hlp_admin_email'] = "El e-mail del administrador. Se usa como remitente cuando";

$GLOBALS['phpAds_hlp_admin_email_headers'] = "        Puede alterar los encabezados de los e-mails enviados por {$PRODUCT_NAME}.
		";

$GLOBALS['phpAds_hlp_admin_novice'] = "Para ver campañas que hayan empezado o terminado en el espacio de tiempos eleccionado, Audit Trail debe estar activado";

$GLOBALS['phpAds_hlp_client_welcome'] =
$GLOBALS['phpAds_hlp_client_welcome_msg'] = "       Si activa esta opción se mostrará un mensaje de bienvenida en la
        primera página que verá el anunciante luego de loguearse. Puede personalizar este mensaje
        editando el archivo 'welcome.html' ubicado en el directorio 'admin/templates'. Quizás quiera
        incluir datos como : Nombre de la Compañía, Información de Contacto, Logo de la Compañía, etc..
		";

$GLOBALS['phpAds_hlp_updates_frequency'] = "        Si desea buscar nuevas versiones de {$PRODUCT_NAME} puede habilitar esta opción.
        Es posible especificar el intervalo en que {$PRODUCT_NAME} se conecta al server de
        actualizaciones. Si se encuentra una nueva versión, aparecerá un cuadro de diálogo con la
        información de la actualización.
		";

$GLOBALS['phpAds_hlp_userlog_email'] = "        Si desea mantener una copia de todos los e-mails enviados por {$PRODUCT_NAME} puede
        activar esta opción. Los mensajes de e-mail serán almacenados en el userlog.
		";

$GLOBALS['phpAds_hlp_userlog_priority'] = "        Para asegurarse que el cálculo de prioridades funcione correctamente, puede guardar
        un reporte de los calulos de cada hora.
		";

$GLOBALS['phpAds_hlp_default_banner_weight'] = "        Si desea utilizar un número de peso de banner mayor por defecto, insertelo aquí.
        Esta opción es 1 por defecto..
		";

$GLOBALS['phpAds_hlp_default_campaign_weight'] = "        Si desea utilizar un número de peso de campaña mayor por defecto, insertelo aquí.
        Esta opción es 1 por defecto..
		";

$GLOBALS['phpAds_hlp_gui_show_campaign_info'] = "Si esta opción es activada, la información extra acerca de cada campaña será mostrada en la página de <i>Campañas</i>. La información extra incluye número de vistas del anuncio que quedan pendientes, el número de clics al anuncio que quedan pendientes, fecha de activación, fecha de finalización y configuraciones de prioridad.";

$GLOBALS['phpAds_hlp_gui_show_banner_info'] = "Si esta opción es activada, la información extra acerca de cada banner será mostrada en la página de <i>Banners</i>. La información extra incluye el URL de destino, palabras clave, tamaño y peso del banner.";

$GLOBALS['phpAds_hlp_gui_show_campaign_preview'] = "Si esta opción es activada, una vista previa de todos los banners será mostrada en la página de <i>Banners</i>. Si esta opción es desactivada, todavía es posible ver una vista previa de cada banner haciendo clic en el triángulo al lado de cada banner en la página de <i>Banners</i>.";

$GLOBALS['phpAds_hlp_gui_show_banner_html'] = "        Si esta opción se encuentra habilitada se verá el banner HTML en lugar del código HTML.
        Esta opción se encuentra habilitada por defecto.
        Si esta opción se encuentra deshabilitada aún es posible obtener una vista previa
        de cada banner clickeando en el botón <i>Mostrar Banner</i>.
		";

$GLOBALS['phpAds_hlp_gui_show_banner_preview'] = "        Si esta opción se encuentra habilitada, se mostrará una vista previa al principio de las
        páginas <i>Propiedades de Banner</i>, <i>Opciones de Entrega</i> y <i>Zonas Relacionadas</i>.
        Si esta opción se encuentra deshabilitada aún es posible obtener una vista previa
        de cada banner clickeando en el botón <i>Mostrar Banner</i>.
		";

$GLOBALS['phpAds_hlp_gui_hide_inactive'] = "Si esta opción es activada, todos los banners, campañas y anunciantes inactivos pueden ser escondidos de las páginas de <i>Anunciantes & Campañas</i> y <i>Campañas</i>. Si esta opción está desactivada, todavía es posible ver los ítems escondidos haciendo clic en el botón de <i>Mostrar Todo</i> al final de la página.";

?>
