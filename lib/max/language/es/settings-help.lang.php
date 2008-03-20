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
$GLOBALS['phpAds_hlp_dbhost'] = "
        Especifique el nombre del host donde se encuentra la base de datos de ".$phpAds_dbmsname.".
		";
		
$GLOBALS['phpAds_hlp_dbuser'] = "
        Especifique el nombre de usuario con el cual ".$phpAds_productname." accederá a la base de datos ".$phpAds_dbmsname.".
		";
		
$GLOBALS['phpAds_hlp_dbpassword'] = "
        Especifique el password que usará ".$phpAds_productname." para acceder a la base de datos ".$phpAds_dbmsname.".
		";
		
$GLOBALS['phpAds_hlp_dbname'] = "
        Especifique el nombre de la base de datos donde ".$phpAds_productname." debe ingresar los datos.
		";
		
$GLOBALS['phpAds_hlp_persistent_connections'] = "
	El uso de conexiones persistentes puede acelerar el uso de ".$phpAds_productname." considerablemente
	y posiblemente decremente la carga en el server. Sin embargo hay un inconveniente\; en sitios en los cuales
	hay gran cantidad de visitantes, la carga en el servidor puede incrementar usando conexiones normales.
	Ud. deberá decidir que tipo de conexión usar dependiendo de la cantidad de visitanes y el hardware que Ud. use.
	Si ".$phpAds_productname." está usando demasiados recursos, deberá revisar esta configuración primero.
		";
		
$GLOBALS['phpAds_hlp_compatibility_mode'] = "
        Si está teniendo dificultades integrando ".$phpAds_productname." con otro producto de un tercero, tal vez le ayude habilitar
		el modo de compatibilidad de base de datos. Si está usando el modo de invocación local y la compatibilidad de base de datos
		se encuentra activada en ".$phpAds_productname." debe dejar el estado de conexión de la base de datos exactamente como se
		encontraba antes de correr ".$phpAds_productname.".
		Esta opción es un tanto mas lenta y por lo tanto deshabilitada por default.
		";
		
$GLOBALS['phpAds_hlp_table_prefix'] = "
        Si la base de datos ".$phpAds_productname." es usada o compartida por multiples softwares, es aconsejable agregar un prefijo al nombre de las tablas.
		Si está usando multiples instalaciones de ".$phpAds_productname."
		en la misma base de datos, deberá asegurarse que este prefijo sea único para todas las instalaciones.
		";
		
$GLOBALS['phpAds_hlp_tabletype'] = "
        ".$phpAds_dbmsname." soporta multiples tipos de tablas. Cada tipo de tabla tiene una propiedades únicas y algunas pueden acelerar ".$phpAds_productname."
		considerablemente. MyISAM es el tipo predeterminado y se encuentra disponible en todas las instalaciones de ".$phpAds_dbmsname.". 
		Otro tipo de tablas tal vez no se encuentren disponibles en su servidor.
		";
		
$GLOBALS['phpAds_hlp_url_prefix'] = "
        ".$phpAds_productname." necesita saber donde se encuentra ubicado en el web server para 
        funcionar correctamente. Debe especificar la URL hacia el directorio donde ".$phpAds_productname."
        se encuentra instalado, por ejemplo: http://www.su-sitio.com/".$phpAds_productname.".
		";
		
$GLOBALS['phpAds_hlp_my_header'] =
$GLOBALS['phpAds_hlp_my_footer'] = "
        Aquí debe ingresar la dirección hacia el archivo de encabeazdo (ej.: /home/login/www/encabezado.htm)
        para usar un encabezado y/o pie de página en cada página de la interface de administración.
        Puede usar texto o código HTML en estos archivos (si va a utilizar HTML en uno o en ambos
        archivos no use los tags <body> o <html>).
		";
		
$GLOBALS['phpAds_hlp_content_gzip_compression'] = "
		Habilitando la compresión de contenido GZIP obtendrá un gran decrecimiento en el envío de datos
		al navegador cada vez que abra una página de la interfaz de administración.
		Para habilitar esta característica debe tener al menos PHP 4.0.5 con la extensión GZIP instalada.
		";
		
$GLOBALS['phpAds_hlp_language'] = "
        Especifique el idioma predeterminado para ".$phpAds_productname.". Este idioma será
        usado com predeterminado para la interfaz de administración y de anunciantes. Note que
        puede asignar un idioma diferente para cada anunciante en la interfaz de administración
        y puede permitir que ellos mismos cambien su idioma.
		";
		
$GLOBALS['phpAds_hlp_name'] = "
        Especifique el nombre que desea usar para esta aplicación. El nombre se mostrará
        en todas las páginas en la interface de administración y del anunciante. Si deja esta opción
        incompleta, aparecerá un logo de ".$phpAds_productname." en su lugar.
		";
		
$GLOBALS['phpAds_hlp_company_name'] = "
        Este nombre será usado en los mails enviados por ".$phpAds_productname.".
		";
		
$GLOBALS['phpAds_hlp_override_gd_imageformat'] = "
        ".$phpAds_productname." detecta normalmente si la librería GS se encuentra instalada y que
        formato de imagenes soporta la versión instalada. También es posible
        que la detección automática falle, ya que algunas versiones de PHP no soportan
        la autodetección. Si ".$phpAds_productname." falla, puede ingresar lso formatos de imagenes soportados
        manualmente. Los valroes posibles son: none, png, jpeg, gif.
		";
		
$GLOBALS['phpAds_hlp_p3p_policies'] = "
        Si desea habilitar las Políticas de Privacidad P3P de ".$phpAds_productname."'
        debe habilitar esta opción.
		";
		
$GLOBALS['phpAds_hlp_p3p_compact_policy'] = "
        Políticas compactas enviadas junto a las cookies. La configuración predeterminada
        es: 'CUR ADM OUR NOR STA NID', que permitirá al Internet Explorer 6 aceptar
        las cookies usadas por ".$phpAds_productname.". Puede alterar esta configuración si lo desea.
        ";
		
$GLOBALS['phpAds_hlp_p3p_policy_location'] = "
        Si desea usar las Políticas de Privacidad completas, puede especificar la
        ubicación ed las mismas.
		";
		
$GLOBALS['phpAds_hlp_compact_stats'] = "
        Tradicionalmente ".$phpAds_productname." usaba el método de logueo extendido, el cual
        era muy detallado, pero era muy demandante para el servidor de bases de datos. Esto puede
        ser un gran problema en sitios con una gran cantidad de visitantes.
        Para resolver este problema	".$phpAds_productname." soporta una nueva clase de estadísticas.
        Las estadísticas compactas, son menos demandantes aunque también menos detalladas. Si necesita un
        detalle por hora deberá deshabilitar la opción de estadísticas compactas.
		";
		
$GLOBALS['phpAds_hlp_log_adviews'] = "
        Normalmente todas las impresiones son logueadas. Si no desea obtener estadísticas de
        las impresiones puede deshabilitar esta opción.
		";
		
$GLOBALS['phpAds_hlp_block_adviews'] = "
		Si un visitante actualiza la página una Impresión es logueada por ".$phpAds_productname." cada vez.
		Esta opción es utilizada para asegurarse de que se logueará únicamente una Impresión por visitante
		por una cantidad de segundos especificados. Por ejemplo: si en esta opción indica 60 segundos,
        por mas que un mismo usuario actualize la misma página 5 veces en 60 segundos solo se logueará una impresión.
        Esta opción solo funcionará si está habilitada la opción <i>USar beacons para loguear Impresiones</i> y
        si el navegador acepta cookies.
		";
		
$GLOBALS['phpAds_hlp_log_adclicks'] = "
        Normalmente todos los Clicks son logueados. Si no desea obtener estadísticas de
        Clicks puede deshabilitar esta opción.
		";
		
$GLOBALS['phpAds_hlp_block_adclicks'] = "
		Si un visitante clickea multiples veces un banner, un Click es logueada por ".$phpAds_productname." cada vez.
		Esta opción es utilizada para asegurarse de que se logueará únicamente un Banner por visitante
		por una cantidad de segundos especificados. Por ejemplo: si en esta opción indica 60 segundos,
        por mas que un mismo usuario clickee multiples veces en un banner en 60 segundos solo se logueará un Click.
        Esta opción solo funcionará si el navegador acepta cookies.
		";
		
$GLOBALS['phpAds_hlp_reverse_lookup'] = "
        ".$phpAds_productname." loguea la IP de cada visitante. Si desea que
        ".$phpAds_productname." loguee los nombres de dominios, habilite esta opción. Reverse lookup
        toma algún tiempo, por lo tanto hará el sistema más lento.
		";
		
$GLOBALS['phpAds_hlp_proxy_lookup'] = "
		Algunos usuarios usan un servidor proxy para conectarse a internet. En este caso
		".$phpAds_productname." logueará la IP o el nombre de host del servidor proxy
		en lugar del del usuario. Si habilita esta opción ".$phpAds_productname." intentará
		hallar la IP o el host del usuario detrás del servidor proxy.
		De no ser posible hallar la IP o el host exacto del usuario, se logueará la del servidor proxy
		en su lugar. habilitar esta opción hará mas lento elproceso de logueo.
		";
		
$GLOBALS['phpAds_hlp_ignore_hosts'] = "
        Si no desea contar los Clicks o Impresiones de determinados dominios o IPs
        puede agregarlos a esta lista. Si tiene habilitado <i>Reverse Lookup</i>
        puede agregar nombres de dominios o IPs, o bien solamente IPs.
        Puede usar comodines (por ejemplo: '*.altavista.com' or '192.168.*').
		";
		
$GLOBALS['phpAds_hlp_begin_of_week'] = "
        Para la mayoría de las personas la semana empieza el Lunes, pero si desea especificar que la semana
        comience los Domingos, puede hacerlo.
		";
		
$GLOBALS['phpAds_hlp_percentage_decimals'] = "
        Especifica cuantos decimales usar en las páginas de estadísticas.
		";
		
$GLOBALS['phpAds_hlp_warn_admin'] = "
        ".$phpAds_productname." puede enviarle un e-mail si una campaña tiene solo un número limitado
        de Clicks o Impresiones disponibles. Esta opción se encuentra habilitada por defecto.
		";
		
$GLOBALS['phpAds_hlp_warn_client'] = "
        ".$phpAds_productname." puede enviarle un e-mail a un anunciante si una campaña tiene solo un número limitado
        de Clicks o Impresiones disponibles. Esta opción se encuentra habilitada por defecto.
        ";
		
$GLOBALS['phpAds_hlp_qmail_patch'] = "
		Algunas versiones de qmail se ven afectadas por un bug que dejan ver los encabezados
        del e-mail en el cuerpo del mensaje.
        Si habilita esta opción, ".$phpAds_productname." enviará los e-mails en formato compatible para
		qmail.
		";
		
$GLOBALS['phpAds_hlp_warn_limit'] = "
        El límite en el cual ".$phpAds_productname." comienza a enviar e-mails de advertencia.
        El valor predeterminado es 100.
		";
		
$GLOBALS['phpAds_hlp_allow_invocation_plain'] = 
$GLOBALS['phpAds_hlp_allow_invocation_js'] = 
$GLOBALS['phpAds_hlp_allow_invocation_frame'] = 
$GLOBALS['phpAds_hlp_allow_invocation_xmlrpc'] = 
$GLOBALS['phpAds_hlp_allow_invocation_local'] = 
$GLOBALS['phpAds_hlp_allow_invocation_interstitial'] = 
$GLOBALS['phpAds_hlp_allow_invocation_popup'] = "
		Estas opciones le permiten controlas que tipos de invocación están permitidos.
		Si uno de estos tipos es deshabilitado, no se encontrará disponible
		en el Generador de Códigos de Banners. Importante: Los métodos de invocación
		seugirán funcionando aunque se deshabilite alguna opción, pero no estará disponible en el Generador.
		";
		
$GLOBALS['phpAds_hlp_con_key'] = "
        ".$phpAds_productname." incluye un poderoso sistema de recuperación de palabras claves usando
        selección directa. para mayor información, por favor lea la Guia de Usuarios. Con esta opción, puede
		activar palabras claves condicionales. Esta opción está habilitada por defecto.
		";
		
$GLOBALS['phpAds_hlp_mult_key'] = "
        Si usa selección directa para mostrar banners, puede especificar una o mas palabras claves
		para cada banner. Esta opción debe estar habilitada si desea utiliazr mas de una palabra clave.
        Esta opción se encuentra habilitada por defecto.
		";
		
$GLOBALS['phpAds_hlp_acl'] = "
        Si no está usando limitaciones de envío puede deshabilitar esta opción con este parámetro.
        Esto acelerará un poco mas a ".$phpAds_productname.".
		";
		
$GLOBALS['phpAds_hlp_default_banner_url'] = 
$GLOBALS['phpAds_hlp_default_banner_target'] = "
        Si ".$phpAds_productname." no puede conectarse con el servidor de bases de datos, o no puede encontrar
        ningun banner, (por ejemplo cuando la base de datos colisiona o es borrada)
        no se mostrará nada. Algunos usuarios querrán usar un banner por defecto en estos casos.
        El banner predeterminado no será logueado y no será usado si hay otros banners para mostrar
        en la base de datos. Esta opción se encuentra deshabilitada por defecto.
		";
		
$GLOBALS['phpAds_hlp_zone_cache'] = "
        Si está usando zonas, esta opción le perimte a ".$phpAds_productname." almacenar la información de
        los banners en un cache que será usado mas tarde. Esto incrementará la velocidad de ".$phpAds_productname.",
         ya que en lugar de consultar la información de la zona cada vez que se debe enviar un banner,
         ".$phpAds_productname." solo necesita utilizar el cache almacenado. Esta opción se encuentra habilitada
        por defecto.
		";
		
$GLOBALS['phpAds_hlp_zone_cache_limit'] = "
        Si utiliza Cache de Zonas, la información del cache puede desactualizarse.
         De vez en cuando ".$phpAds_productname." debe reconstruir el cache, para que sean
        agregados los nuevos banners al cache. Esta opción le permite decidir cada cuanto
        deben reconstruirse los caches de zonas especificando en cuanto tiempo vence el cache
		";
		
$GLOBALS['phpAds_hlp_type_sql_allow'] = 
$GLOBALS['phpAds_hlp_type_web_allow'] = 
$GLOBALS['phpAds_hlp_type_url_allow'] = 
$GLOBALS['phpAds_hlp_type_html_allow'] = 
$GLOBALS['phpAds_hlp_type_txt_allow'] = "
        ".$phpAds_productname." puede utilizar diferentes tipos de banners y almacenarlos de
        diferentes maneras. Las primeras dos opciones se utilizan para el almacenamiento local de banners.
        Puede utilizar la interface de administrador para subir un banner y ".$phpAds_productname." lo alacenará
        en la base de datos SQL o en el servidor web. También puede utilizar un banner almacenado en un servidor web
        o usar HTML para generar un banner.
		";
		
$GLOBALS['phpAds_hlp_type_web_mode'] = "
        Si desea usar banners almacenados en el servidor web, debe establecer
        esta opción. Si desea almacenar lso banners en un directorio local establezca esta opción como
        <i>Directorio Local</i>. Si desea almacenar el banner en un servidor FTP externo
        establezca esta opción como <i>Servidor FTP Externo</i>.
		";
		
$GLOBALS['phpAds_hlp_type_web_dir'] = "
        Especifique el directorio donde ".$phpAds_productname." debe copiar los banners subidos.
         Este directorio debe tener permisos de escritura para PHP. El directorio especificado
        debe estar disponible para el servidor web. No ingrese una barra invertida (/) al final. Debe configurar
        esta opción solamente si ha especificado el método de almacenamiento como <i>Directorio Local</i>.
		";
		
$GLOBALS['phpAds_hlp_type_web_ftp_host'] = "
		Si establece el método de almacenamiento como <i>Servidor FTP Externo</i> debe
		especificar la IP o nombre de dominio del servidor FTP donde ".$phpAds_productname." copiará
		los banners.
		";
      
$GLOBALS['phpAds_hlp_type_web_ftp_path'] = "
        Si establece el método de almacenamiento como <i>Servidor FTP Externo</i> debe
		especificar el directorio en el servidor FTP donde ".$phpAds_productname." copiará
		los banners.
		";

$GLOBALS['phpAds_hlp_type_web_ftp_user'] = "
        Si establece el método de almacenamiento como <i>Servidor FTP Externo</i> debe
		especificar el nombre de usuario que ".$phpAds_productname." utilizará para conectarse al servidor FTP
		";

$GLOBALS['phpAds_hlp_type_web_ftp_password'] = "
        Si establece el método de almacenamiento como <i>Servidor FTP Externo</i> debe
		especificar el password que ".$phpAds_productname." utilizará para conectarse al servidor FTP
		";

$GLOBALS['phpAds_hlp_type_web_url'] = "
        Si almacena los banners en un servidor web, ".$phpads_productname." necesita conocer la
        URL pública correspondiente con el directorio especificado anteriormente.
        No ingrese una barra invertida (/) al final.
		";
		
$GLOBALS['phpAds_hlp_type_html_auto'] = "
        Si esta opción está habilitada, ".$phpAds_productname." alterará automáticamente los banners
        HTML para permitir el logueo de clicks. Sin embargo, aunque esta opción esté habilitada
        puede ser posible deshabilitarla en una BASE POR BANNER.
		";
		
$GLOBALS['phpAds_hlp_type_html_php'] = "
        Es posible permitir a ".$phpAds_productname." ejecutar código PHP insertado en banners HTML. Esta
        opción se encuentra deshabilitada por defecto.
		";
		
$GLOBALS['phpAds_hlp_admin'] = "
        Nombre de usuario del Administrador. Puede especificar el nombre de usuario del Administrador
        para loguearse en lainterface de administración.
		";
		
$GLOBALS['phpAds_hlp_pwold'] = 
$GLOBALS['phpAds_hlp_pw'] = 
$GLOBALS['phpAds_hlp_pw2'] = "
        Para cambiar el password del administrador, deberá ingresar el password anterior. Y luego
        ingresar el nuevo password dos veces para prevenir errores de tipeo.
		";
		
$GLOBALS['phpAds_hlp_admin_fullname'] = "
        Ingrese el nombre completo del Administrador. Es usado para el envío de estadísticas
        via email.
		";
		
$GLOBALS['phpAds_hlp_admin_email'] = "
        E-Mail del Administrador. Es usado como dirección de remitente para el envío
        de estadísticas via email.
		";
		
$GLOBALS['phpAds_hlp_admin_email_headers'] = "
        Puede alterar los encabezados de los e-mails enviados por ".$phpAds_productname.".
		";
		
$GLOBALS['phpAds_hlp_admin_novice'] = "
        Si desea recibir una advertencia antes de borrar anunciantes, campañas o banners,
        marque esta opción.
		";
		
$GLOBALS['phpAds_hlp_client_welcome'] = 
$GLOBALS['phpAds_hlp_client_welcome_msg'] = "
       Si activa esta opción se mostrará un mensaje de bienvenida en la
        primera página que verá el anunciante luego de loguearse. Puede personalizar este mensaje
        editando el archivo 'welcome.html' ubicado en el directorio 'admin/templates'. Quizás quiera
        incluir datos como : Nombre de la Compañía, Información de Contacto, Logo de la Compañía, etc..
		";
		
$GLOBALS['phpAds_hlp_updates_frequency'] = "
        Si desea buscar nuevas versiones de ".$phpAds_productname." puede habilitar esta opción.
        Es posible especificar el intervalo en que ".$phpAds_productname." se conecta al server de
        actualizaciones. Si se encuentra una nueva versión, aparecerá un cuadro de diálogo con la
        información de la actualización.
		";
		
$GLOBALS['phpAds_hlp_userlog_email'] = "
        Si desea mantener una copia de todos los e-mails enviados por ".$phpAds_productname." puede
        activar esta opción. Los mensajes de e-mail serán almacenados en el userlog.
		";
		
$GLOBALS['phpAds_hlp_userlog_priority'] = "
        Para asegurarse que el cálculo de prioridades funcione correctamente, puede guardar
        un reporte de los calulos de cada hora.
		";
		
$GLOBALS['phpAds_hlp_default_banner_weight'] = "
        Si desea utilizar un número de peso de banner mayor por defecto, insertelo aquí.
        Esta opción es 1 por defecto..
		";
		
$GLOBALS['phpAds_hlp_default_campaign_weight'] = "
        Si desea utilizar un número de peso de campaña mayor por defecto, insertelo aquí.
        Esta opción es 1 por defecto..
		";
		
$GLOBALS['phpAds_hlp_gui_show_campaign_info'] = "
        Si esta opción se encuentra habilitada, se mostrará información extra sobre cada campaña en
        la página <i>Resumen de Capaña</i>. La información extra incluye el número de Impresiones restantes,
        el número de Clicks restantes, la fecha de activación, la fecha de expiración y la configuración de
        prioridades.
		";
		
$GLOBALS['phpAds_hlp_gui_show_banner_info'] = "
        Si esta opción se encuentra habilitada, se mostrará información extra sobre cada banner en
        la página <i>Resumen de Banner</i>. La información extra incluye la URL de destino, palabras claves y
        tamaño y peso del banner.
		";
		
$GLOBALS['phpAds_hlp_gui_show_campaign_preview'] = "
        Si esta opción se encuentra habilitada, se mostrará una vista previa del banner en la página
        <i>Resumen de Banner</i>. Si esta opción se encuentra deshabilitada aún es posible obtener una vista previa
        de cada banner clickeando en el triángulo contiguo a cada banner en la página <i>Resumen de Banner</i>.
		";
		
$GLOBALS['phpAds_hlp_gui_show_banner_html'] = "
        Si esta opción se encuentra habilitada se verá el banner HTML en lugar del código HTML.
        Esta opción se encuentra habilitada por defecto.
        Si esta opción se encuentra deshabilitada aún es posible obtener una vista previa
        de cada banner clickeando en el botón <i>Mostrar Banner</i>.
		";
		
$GLOBALS['phpAds_hlp_gui_show_banner_preview'] = "
        Si esta opción se encuentra habilitada, se mostrará una vista previa al principio de las
        páginas <i>Propiedades de Banner</i>, <i>Opciones de Entrega</i> y <i>Zonas Relacionadas</i>.
        Si esta opción se encuentra deshabilitada aún es posible obtener una vista previa
        de cada banner clickeando en el botón <i>Mostrar Banner</i>.
		";
		
$GLOBALS['phpAds_hlp_gui_hide_inactive'] = "
        Si esta opción se encuentra habilitada, todos los banners inactivos, campañas y anunciantes serán ocultados
        en las páginas <i>Anunciantes & Campañas</i> y <i>Resumen de Campaña</i>. Si esta opción se encuentra
        habilitada aún es posible ver los items ocultos clickeando en el botón <i>Ver todo</i> al final de la página.
		";
		
?>
