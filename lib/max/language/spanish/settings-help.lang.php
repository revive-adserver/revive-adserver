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
        Especifique el nombre de usuario con el cual ".$phpAds_productname." acceder&aacute; a la base de datos ".$phpAds_dbmsname.".
		";
		
$GLOBALS['phpAds_hlp_dbpassword'] = "
        Especifique el password que usar&aacute; ".$phpAds_productname." para acceder a la base de datos ".$phpAds_dbmsname.".
		";
		
$GLOBALS['phpAds_hlp_dbname'] = "
        Especifique el nombre de la base de datos donde ".$phpAds_productname." debe ingresar los datos.
		";
		
$GLOBALS['phpAds_hlp_persistent_connections'] = "
	El uso de conexiones persistentes puede acelerar el uso de ".$phpAds_productname." considerablemente
	y posiblemente decremente la carga en el server. Sin embargo hay un inconveniente\; en sitios en los cuales
	hay gran cantidad de visitantes, la carga en el servidor puede incrementar usando conexiones normales.
	Ud. deber&aacute; decidir que tipo de conexi&oacute;n usar dependiendo de la cantidad de visitanes y el hardware que Ud. use.
	Si ".$phpAds_productname." est&aacute; usando demasiados recursos, deber&aacute; revisar esta configuraci&oacute;n primero.
		";
		
$GLOBALS['phpAds_hlp_compatibility_mode'] = "
        Si est&aacute; teniendo dificultades integrando ".$phpAds_productname." con otro producto de un tercero, tal vez le ayude habilitar
		el modo de compatibilidad de base de datos. Si est&aacute; usando el modo de invocaci&oacute;n local y la compatibilidad de base de datos
		se encuentra activada en ".$phpAds_productname." debe dejar el estado de conexi&oacute;n de la base de datos exactamente como se
		encontraba antes de correr ".$phpAds_productname.".
		Esta opci&oacute;n es un tanto mas lenta y por lo tanto deshabilitada por default.
		";
		
$GLOBALS['phpAds_hlp_table_prefix'] = "
        Si la base de datos ".$phpAds_productname." es usada o compartida por multiples softwares, es aconsejable agregar un prefijo al nombre de las tablas.
		Si est&aacute; usando multiples instalaciones de ".$phpAds_productname."
		en la misma base de datos, deber&aacute; asegurarse que este prefijo sea &uacute;nico para todas las instalaciones.
		";
		
$GLOBALS['phpAds_hlp_tabletype'] = "
        ".$phpAds_dbmsname." soporta multiples tipos de tablas. Cada tipo de tabla tiene una propiedades &uacute;nicas y algunas pueden acelerar ".$phpAds_productname."
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
        Aqu&iacute; debe ingresar la direcci&oacute;n hacia el archivo de encabeazdo (ej.: /home/login/www/encabezado.htm)
        para usar un encabezado y/o pie de p&aacute;gina en cada p&aacute;gina de la interface de administraci&oacute;n.
        Puede usar texto o c&oacute;digo HTML en estos archivos (si va a utilizar HTML en uno o en ambos
        archivos no use los tags &lt;body> o &lt;html>).
		";
		
$GLOBALS['phpAds_hlp_content_gzip_compression'] = "
		Habilitando la compresi&oacute;n de contenido GZIP obtendr&aacute; un gran decrecimiento en el env&iacute;o de datos
		al navegador cada vez que abra una p&aacute;gina de la interfaz de administraci&oacute;n.
		Para habilitar esta caracter&iacute;stica debe tener al menos PHP 4.0.5 con la extensi&oacute;n GZIP instalada.
		";
		
$GLOBALS['phpAds_hlp_language'] = "
        Especifique el idioma predeterminado para ".$phpAds_productname.". Este idioma ser&aacute;
        usado com predeterminado para la interfaz de administraci&oacute;n y de anunciantes. Note que
        puede asignar un idioma diferente para cada anunciante en la interfaz de administraci&oacute;n
        y puede permitir que ellos mismos cambien su idioma.
		";
		
$GLOBALS['phpAds_hlp_name'] = "
        Especifique el nombre que desea usar para esta aplicaci&oacute;n. El nombre se mostrar&aacute;
        en todas las p&aacute;ginas en la interface de administraci&oacute;n y del anunciante. Si deja esta opci&oacute;n
        incompleta, aparecer&aacute; un logo de ".$phpAds_productname." en su lugar.
		";
		
$GLOBALS['phpAds_hlp_company_name'] = "
        Este nombre ser&aacute; usado en los mails enviados por ".$phpAds_productname.".
		";
		
$GLOBALS['phpAds_hlp_override_gd_imageformat'] = "
        ".$phpAds_productname." detecta normalmente si la librer&iacute;a GS se encuentra instalada y que
        formato de imagenes soporta la versi&oacute;n instalada. Tambi&eacute;n es posible
        que la detecci&oacute;n autom&aacute;tica falle, ya que algunas versiones de PHP no soportan
        la autodetecci&oacute;n. Si ".$phpAds_productname." falla, puede ingresar lso formatos de imagenes soportados
        manualmente. Los valroes posibles son: none, png, jpeg, gif.
		";
		
$GLOBALS['phpAds_hlp_p3p_policies'] = "
        Si desea habilitar las Pol&iacute;ticas de Privacidad P3P de ".$phpAds_productname."'
        debe habilitar esta opci&oacute;n.
		";
		
$GLOBALS['phpAds_hlp_p3p_compact_policy'] = "
        Pol&iacute;ticas compactas enviadas junto a las cookies. La configuraci&oacute;n predeterminada
        es: 'CUR ADM OUR NOR STA NID', que permitir&aacute; al Internet Explorer 6 aceptar
        las cookies usadas por ".$phpAds_productname.". Puede alterar esta configuraci&oacute;n si lo desea.
        ";
		
$GLOBALS['phpAds_hlp_p3p_policy_location'] = "
        Si desea usar las Pol&iacute;ticas de Privacidad completas, puede especificar la
        ubicaci&oacute;n ed las mismas.
		";
		
$GLOBALS['phpAds_hlp_compact_stats'] = "
        Tradicionalmente ".$phpAds_productname." usaba el m&eacute;todo de logueo extendido, el cual
        era muy detallado, pero era muy demandante para el servidor de bases de datos. Esto puede
        ser un gran problema en sitios con una gran cantidad de visitantes.
        Para resolver este problema	".$phpAds_productname." soporta una nueva clase de estad&iacute;sticas.
        Las estad&iacute;sticas compactas, son menos demandantes aunque tambi&eacute;n menos detalladas. Si necesita un
        detalle por hora deber&aacute; deshabilitar la opci&oacute;n de estad&iacute;sticas compactas.
		";
		
$GLOBALS['phpAds_hlp_log_adviews'] = "
        Normalmente todas las impresiones son logueadas. Si no desea obtener estad&iacute;sticas de
        las impresiones puede deshabilitar esta opci&oacute;n.
		";
		
$GLOBALS['phpAds_hlp_block_adviews'] = "
		Si un visitante actualiza la p&aacute;gina una Impresi&oacute;n es logueada por ".$phpAds_productname." cada vez.
		Esta opci&oacute;n es utilizada para asegurarse de que se loguear&aacute; &uacute;nicamente una Impresi&oacute;n por visitante
		por una cantidad de segundos especificados. Por ejemplo: si en esta opci&oacute;n indica 60 segundos,
        por mas que un mismo usuario actualize la misma p&aacute;gina 5 veces en 60 segundos solo se loguear&aacute; una impresi&oacute;n.
        Esta opci&oacute;n solo funcionar&aacute; si est&aacute; habilitada la opci&oacute;n <i>USar beacons para loguear Impresiones</i> y
        si el navegador acepta cookies.
		";
		
$GLOBALS['phpAds_hlp_log_adclicks'] = "
        Normalmente todos los Clicks son logueados. Si no desea obtener estad&iacute;sticas de
        Clicks puede deshabilitar esta opci&oacute;n.
		";
		
$GLOBALS['phpAds_hlp_block_adclicks'] = "
		Si un visitante clickea multiples veces un banner, un Click es logueada por ".$phpAds_productname." cada vez.
		Esta opci&oacute;n es utilizada para asegurarse de que se loguear&aacute; &uacute;nicamente un Banner por visitante
		por una cantidad de segundos especificados. Por ejemplo: si en esta opci&oacute;n indica 60 segundos,
        por mas que un mismo usuario clickee multiples veces en un banner en 60 segundos solo se loguear&aacute; un Click.
        Esta opci&oacute;n solo funcionar&aacute; si el navegador acepta cookies.
		";
		
$GLOBALS['phpAds_hlp_reverse_lookup'] = "
        ".$phpAds_productname." loguea la IP de cada visitante. Si desea que
        ".$phpAds_productname." loguee los nombres de dominios, habilite esta opci&oacute;n. Reverse lookup
        toma alg&uacute;n tiempo, por lo tanto har&aacute; el sistema m&aacute;s lento.
		";
		
$GLOBALS['phpAds_hlp_proxy_lookup'] = "
		Algunos usuarios usan un servidor proxy para conectarse a internet. En este caso
		".$phpAds_productname." loguear&aacute; la IP o el nombre de host del servidor proxy
		en lugar del del usuario. Si habilita esta opci&oacute;n ".$phpAds_productname." intentar&aacute;
		hallar la IP o el host del usuario detr&aacute;s del servidor proxy.
		De no ser posible hallar la IP o el host exacto del usuario, se loguear&aacute; la del servidor proxy
		en su lugar. habilitar esta opci&oacute;n har&aacute; mas lento elproceso de logueo.
		";
		
$GLOBALS['phpAds_hlp_ignore_hosts'] = "
        Si no desea contar los Clicks o Impresiones de determinados dominios o IPs
        puede agregarlos a esta lista. Si tiene habilitado <i>Reverse Lookup</i>
        puede agregar nombres de dominios o IPs, o bien solamente IPs.
        Puede usar comodines (por ejemplo: '*.altavista.com' or '192.168.*').
		";
		
$GLOBALS['phpAds_hlp_begin_of_week'] = "
        Para la mayor&iacute;a de las personas la semana empieza el Lunes, pero si desea especificar que la semana
        comience los Domingos, puede hacerlo.
		";
		
$GLOBALS['phpAds_hlp_percentage_decimals'] = "
        Especifica cuantos decimales usar en las p&aacute;ginas de estad&iacute;sticas.
		";
		
$GLOBALS['phpAds_hlp_warn_admin'] = "
        ".$phpAds_productname." puede enviarle un e-mail si una campa&ntilde;a tiene solo un n&uacute;mero limitado
        de Clicks o Impresiones disponibles. Esta opci&oacute;n se encuentra habilitada por defecto.
		";
		
$GLOBALS['phpAds_hlp_warn_client'] = "
        ".$phpAds_productname." puede enviarle un e-mail a un anunciante si una campa&ntilde;a tiene solo un n&uacute;mero limitado
        de Clicks o Impresiones disponibles. Esta opci&oacute;n se encuentra habilitada por defecto.
        ";
		
$GLOBALS['phpAds_hlp_qmail_patch'] = "
		Algunas versiones de qmail se ven afectadas por un bug que dejan ver los encabezados
        del e-mail en el cuerpo del mensaje.
        Si habilita esta opci&oacute;n, ".$phpAds_productname." enviar&aacute; los e-mails en formato compatible para
		qmail.
		";
		
$GLOBALS['phpAds_hlp_warn_limit'] = "
        El l&iacute;mite en el cual ".$phpAds_productname." comienza a enviar e-mails de advertencia.
        El valor predeterminado es 100.
		";
		
$GLOBALS['phpAds_hlp_allow_invocation_plain'] = 
$GLOBALS['phpAds_hlp_allow_invocation_js'] = 
$GLOBALS['phpAds_hlp_allow_invocation_frame'] = 
$GLOBALS['phpAds_hlp_allow_invocation_xmlrpc'] = 
$GLOBALS['phpAds_hlp_allow_invocation_local'] = 
$GLOBALS['phpAds_hlp_allow_invocation_interstitial'] = 
$GLOBALS['phpAds_hlp_allow_invocation_popup'] = "
		Estas opciones le permiten controlas que tipos de invocaci&oacute;n est&aacute;n permitidos.
		Si uno de estos tipos es deshabilitado, no se encontrar&aacute; disponible
		en el Generador de C&oacute;digos de Banners. Importante: Los m&eacute;todos de invocaci&oacute;n
		seugir&aacute;n funcionando aunque se deshabilite alguna opci&oacute;n, pero no estar&aacute; disponible en el Generador.
		";
		
$GLOBALS['phpAds_hlp_con_key'] = "
        ".$phpAds_productname." incluye un poderoso sistema de recuperaci&oacute;n de palabras claves usando
        selecci&oacute;n directa. para mayor informaci&oacute;n, por favor lea la Guia de Usuarios. Con esta opci&oacute;n, puede
		activar palabras claves condicionales. Esta opci&oacute;n est&aacute; habilitada por defecto.
		";
		
$GLOBALS['phpAds_hlp_mult_key'] = "
        Si usa selecci&oacute;n directa para mostrar banners, puede especificar una o mas palabras claves
		para cada banner. Esta opci&oacute;n debe estar habilitada si desea utiliazr mas de una palabra clave.
        Esta opci&oacute;n se encuentra habilitada por defecto.
		";
		
$GLOBALS['phpAds_hlp_acl'] = "
        Si no est&aacute; usando limitaciones de env&iacute;o puede deshabilitar esta opci&oacute;n con este par&aacute;metro.
        Esto acelerar&aacute; un poco mas a ".$phpAds_productname.".
		";
		
$GLOBALS['phpAds_hlp_default_banner_url'] = 
$GLOBALS['phpAds_hlp_default_banner_target'] = "
        Si ".$phpAds_productname." no puede conectarse con el servidor de bases de datos, o no puede encontrar
        ningun banner, (por ejemplo cuando la base de datos colisiona o es borrada)
        no se mostrar&aacute; nada. Algunos usuarios querr&aacute;n usar un banner por defecto en estos casos.
        El banner predeterminado no ser&aacute; logueado y no ser&aacute; usado si hay otros banners para mostrar
        en la base de datos. Esta opci&oacute;n se encuentra deshabilitada por defecto.
		";
		
$GLOBALS['phpAds_hlp_zone_cache'] = "
        Si est&aacute; usando zonas, esta opci&oacute;n le perimte a ".$phpAds_productname." almacenar la informaci&oacute;n de
        los banners en un cache que ser&aacute; usado mas tarde. Esto incrementar&aacute; la velocidad de ".$phpAds_productname.",
         ya que en lugar de consultar la informaci&oacute;n de la zona cada vez que se debe enviar un banner,
         ".$phpAds_productname." solo necesita utilizar el cache almacenado. Esta opci&oacute;n se encuentra habilitada
        por defecto.
		";
		
$GLOBALS['phpAds_hlp_zone_cache_limit'] = "
        Si utiliza Cache de Zonas, la informaci&oacute;n del cache puede desactualizarse.
         De vez en cuando ".$phpAds_productname." debe reconstruir el cache, para que sean
        agregados los nuevos banners al cache. Esta opci&oacute;n le permite decidir cada cuanto
        deben reconstruirse los caches de zonas especificando en cuanto tiempo vence el cache
		";
		
$GLOBALS['phpAds_hlp_type_sql_allow'] = 
$GLOBALS['phpAds_hlp_type_web_allow'] = 
$GLOBALS['phpAds_hlp_type_url_allow'] = 
$GLOBALS['phpAds_hlp_type_html_allow'] = 
$GLOBALS['phpAds_hlp_type_txt_allow'] = "
        ".$phpAds_productname." puede utilizar diferentes tipos de banners y almacenarlos de
        diferentes maneras. Las primeras dos opciones se utilizan para el almacenamiento local de banners.
        Puede utilizar la interface de administrador para subir un banner y ".$phpAds_productname." lo alacenar&aacute;
        en la base de datos SQL o en el servidor web. Tambi&eacute;n puede utilizar un banner almacenado en un servidor web
        o usar HTML para generar un banner.
		";
		
$GLOBALS['phpAds_hlp_type_web_mode'] = "
        Si desea usar banners almacenados en el servidor web, debe establecer
        esta opci&oacute;n. Si desea almacenar lso banners en un directorio local establezca esta opci&oacute;n como
        <i>Directorio Local</i>. Si desea almacenar el banner en un servidor FTP externo
        establezca esta opci&oacute;n como <i>Servidor FTP Externo</i>.
		";
		
$GLOBALS['phpAds_hlp_type_web_dir'] = "
        Especifique el directorio donde ".$phpAds_productname." debe copiar los banners subidos.
         Este directorio debe tener permisos de escritura para PHP. El directorio especificado
        debe estar disponible para el servidor web. No ingrese una barra invertida (/) al final. Debe configurar
        esta opci&oacute;n solamente si ha especificado el m&eacute;todo de almacenamiento como <i>Directorio Local</i>.
		";
		
$GLOBALS['phpAds_hlp_type_web_ftp_host'] = "
		Si establece el m&eacute;todo de almacenamiento como <i>Servidor FTP Externo</i> debe
		especificar la IP o nombre de dominio del servidor FTP donde ".$phpAds_productname." copiar&aacute;
		los banners.
		";
      
$GLOBALS['phpAds_hlp_type_web_ftp_path'] = "
        Si establece el m&eacute;todo de almacenamiento como <i>Servidor FTP Externo</i> debe
		especificar el directorio en el servidor FTP donde ".$phpAds_productname." copiar&aacute;
		los banners.
		";

$GLOBALS['phpAds_hlp_type_web_ftp_user'] = "
        Si establece el m&eacute;todo de almacenamiento como <i>Servidor FTP Externo</i> debe
		especificar el nombre de usuario que ".$phpAds_productname." utilizar&aacute; para conectarse al servidor FTP
		";

$GLOBALS['phpAds_hlp_type_web_ftp_password'] = "
        Si establece el m&eacute;todo de almacenamiento como <i>Servidor FTP Externo</i> debe
		especificar el password que ".$phpAds_productname." utilizar&aacute; para conectarse al servidor FTP
		";

$GLOBALS['phpAds_hlp_type_web_url'] = "
        Si almacena los banners en un servidor web, ".$phpads_productname." necesita conocer la
        URL p&uacute;blica correspondiente con el directorio especificado anteriormente.
        No ingrese una barra invertida (/) al final.
		";
		
$GLOBALS['phpAds_hlp_type_html_auto'] = "
        Si esta opci&oacute;n est&aacute; habilitada, ".$phpAds_productname." alterar&aacute; autom&aacute;ticamente los banners
        HTML para permitir el logueo de clicks. Sin embargo, aunque esta opci&oacute;n est&eacute; habilitada
        puede ser posible deshabilitarla en una BASE POR BANNER.
		";
		
$GLOBALS['phpAds_hlp_type_html_php'] = "
        Es posible permitir a ".$phpAds_productname." ejecutar c&oacute;digo PHP insertado en banners HTML. Esta
        opci&oacute;n se encuentra deshabilitada por defecto.
		";
		
$GLOBALS['phpAds_hlp_admin'] = "
        Nombre de usuario del Administrador. Puede especificar el nombre de usuario del Administrador
        para loguearse en lainterface de administraci&oacute;n.
		";
		
$GLOBALS['phpAds_hlp_pwold'] = 
$GLOBALS['phpAds_hlp_pw'] = 
$GLOBALS['phpAds_hlp_pw2'] = "
        Para cambiar el password del administrador, deber&aacute; ingresar el password anterior. Y luego
        ingresar el nuevo password dos veces para prevenir errores de tipeo.
		";
		
$GLOBALS['phpAds_hlp_admin_fullname'] = "
        Ingrese el nombre completo del Administrador. Es usado para el env&iacute;o de estad&iacute;sticas
        via email.
		";
		
$GLOBALS['phpAds_hlp_admin_email'] = "
        E-Mail del Administrador. Es usado como direcci&oacute;n de remitente para el env&iacute;o
        de estad&iacute;sticas via email.
		";
		
$GLOBALS['phpAds_hlp_admin_email_headers'] = "
        Puede alterar los encabezados de los e-mails enviados por ".$phpAds_productname.".
		";
		
$GLOBALS['phpAds_hlp_admin_novice'] = "
        Si desea recibir una advertencia antes de borrar anunciantes, campa&ntilde;as o banners,
        marque esta opci&oacute;n.
		";
		
$GLOBALS['phpAds_hlp_client_welcome'] = 
$GLOBALS['phpAds_hlp_client_welcome_msg'] = "
       Si activa esta opci&oacute;n se mostrar&aacute; un mensaje de bienvenida en la
        primera p&aacute;gina que ver&aacute; el anunciante luego de loguearse. Puede personalizar este mensaje
        editando el archivo 'welcome.html' ubicado en el directorio 'admin/templates'. Quiz&aacute;s quiera
        incluir datos como : Nombre de la Compa&ntilde;&iacute;a, Informaci&oacute;n de Contacto, Logo de la Compa&ntilde;&iacute;a, etc..
		";
		
$GLOBALS['phpAds_hlp_updates_frequency'] = "
        Si desea buscar nuevas versiones de ".$phpAds_productname." puede habilitar esta opci&oacute;n.
        Es posible especificar el intervalo en que ".$phpAds_productname." se conecta al server de
        actualizaciones. Si se encuentra una nueva versi&oacute;n, aparecer&aacute; un cuadro de di&aacute;logo con la
        informaci&oacute;n de la actualizaci&oacute;n.
		";
		
$GLOBALS['phpAds_hlp_userlog_email'] = "
        Si desea mantener una copia de todos los e-mails enviados por ".$phpAds_productname." puede
        activar esta opci&oacute;n. Los mensajes de e-mail ser&aacute;n almacenados en el userlog.
		";
		
$GLOBALS['phpAds_hlp_userlog_priority'] = "
        Para asegurarse que el c&aacute;lculo de prioridades funcione correctamente, puede guardar
        un reporte de los calulos de cada hora.
		";
		
$GLOBALS['phpAds_hlp_default_banner_weight'] = "
        Si desea utilizar un n&uacute;mero de peso de banner mayor por defecto, insertelo aqu&iacute;.
        Esta opci&oacute;n es 1 por defecto..
		";
		
$GLOBALS['phpAds_hlp_default_campaign_weight'] = "
        Si desea utilizar un n&uacute;mero de peso de campa&ntilde;a mayor por defecto, insertelo aqu&iacute;.
        Esta opci&oacute;n es 1 por defecto..
		";
		
$GLOBALS['phpAds_hlp_gui_show_campaign_info'] = "
        Si esta opci&oacute;n se encuentra habilitada, se mostrar&aacute; informaci&oacute;n extra sobre cada campa&ntilde;a en
        la p&aacute;gina <i>Resumen de Capa&ntilde;a</i>. La informaci&oacute;n extra incluye el n&uacute;mero de Impresiones restantes,
        el n&uacute;mero de Clicks restantes, la fecha de activaci&oacute;n, la fecha de expiraci&oacute;n y la configuraci&oacute;n de
        prioridades.
		";
		
$GLOBALS['phpAds_hlp_gui_show_banner_info'] = "
        Si esta opci&oacute;n se encuentra habilitada, se mostrar&aacute; informaci&oacute;n extra sobre cada banner en
        la p&aacute;gina <i>Resumen de Banner</i>. La informaci&oacute;n extra incluye la URL de destino, palabras claves y
        tama&ntilde;o y peso del banner.
		";
		
$GLOBALS['phpAds_hlp_gui_show_campaign_preview'] = "
        Si esta opci&oacute;n se encuentra habilitada, se mostrar&aacute; una vista previa del banner en la p&aacute;gina
        <i>Resumen de Banner</i>. Si esta opci&oacute;n se encuentra deshabilitada a&uacute;n es posible obtener una vista previa
        de cada banner clickeando en el tri&aacute;ngulo contiguo a cada banner en la p&aacute;gina <i>Resumen de Banner</i>.
		";
		
$GLOBALS['phpAds_hlp_gui_show_banner_html'] = "
        Si esta opci&oacute;n se encuentra habilitada se ver&aacute; el banner HTML en lugar del c&oacute;digo HTML.
        Esta opci&oacute;n se encuentra habilitada por defecto.
        Si esta opci&oacute;n se encuentra deshabilitada a&uacute;n es posible obtener una vista previa
        de cada banner clickeando en el bot&oacute;n <i>Mostrar Banner</i>.
		";
		
$GLOBALS['phpAds_hlp_gui_show_banner_preview'] = "
        Si esta opci&oacute;n se encuentra habilitada, se mostrar&aacute; una vista previa al principio de las
        p&aacute;ginas <i>Propiedades de Banner</i>, <i>Opciones de Entrega</i> y <i>Zonas Relacionadas</i>.
        Si esta opci&oacute;n se encuentra deshabilitada a&uacute;n es posible obtener una vista previa
        de cada banner clickeando en el bot&oacute;n <i>Mostrar Banner</i>.
		";
		
$GLOBALS['phpAds_hlp_gui_hide_inactive'] = "
        Si esta opci&oacute;n se encuentra habilitada, todos los banners inactivos, campa&ntilde;as y anunciantes ser&aacute;n ocultados
        en las p&aacute;ginas <i>Anunciantes & Campa&ntilde;as</i> y <i>Resumen de Campa&ntilde;a</i>. Si esta opci&oacute;n se encuentra
        habilitada a&uacute;n es posible ver los items ocultos clickeando en el bot&oacute;n <i>Ver todo</i> al final de la p&aacute;gina.
		";
		
?>
