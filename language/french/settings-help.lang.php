<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2002 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Settings help translation strings
$GLOBALS['phpAds_hlp_dbhost'] = "
	Spécifiez l'adresse du serveur de données MySQL (Ex: sql.monsite.fr).
";
		
$GLOBALS['phpAds_hlp_dbuser'] = "
	Spécifiez le nom d'utilisateur avec lequel phpAdsNew peut se connecter à la base MySQL.
";
		
$GLOBALS['phpAds_hlp_dbpassword'] = "
	Spécifiez le mot de passe avec lequel phpAdsNew peut se connecter à la base MySQL.
";
		
$GLOBALS['phpAds_hlp_dbname'] = "
	Spécifiez le nom de la base dans laquelle phpAdsNew doit stocker ses données.
";

$GLOBALS['phpAds_hlp_persistent_connections'] = "
	L'utilisation de connections persistantes peut accélérer considérablement phpAdsNew, et peut même diminuer
	la charge du serveur. Néanmoins, il y a un point négatif: sur des sites avec un grand nombre de visiteurs,
	la charge du serveur peut augmenter, et être supérieur à celle sans l'utilisation des connections
	persistantes. Utiliser ou ne pas utiliser cette option dépend du nombre de visiteurs, et du matériel
	que vous utilisez. Si phpAdsNew utilise trop de ressources, vous devriez regarder d'abord cette option.
";

$GLOBALS['phpAds_hlp_insert_delayed'] = "
	MySQL bloque la table lorsque l'on insère des données. Si vous avez beaucoup de visiteurs, il est possible
	que phpAdsNew soit obligé d'attendre avant d'insérer une nouvelle ligne, parce que la table est déjà
	bloquée. Quand vous utilisez les insertions retardées, vous n'avez pas à attendre, et la ligne sera insérée
	plus tard, lorsque la table ne sera plus utilisée.
";

$GLOBALS['phpAds_hlp_compatibility_mode'] = "
        If you are having problem integrating phpAdsNew with another thirth-party product it 
	might help to turn on the database compatibility mode. If you are using local mode 
	invocation and the database compatibility is turned on phpAdsNew should leave 
	the state of the database connection exectly the same as it was before phpAdsNew ran. 
	This option is a bit slower (only slightly) and therefore turned off by default.
";

$GLOBALS['phpAds_hlp_table_prefix'] = "
	Si la base de données que phpAdsNew utilise est partagée par plusieurs produits, il est intéressant d'ajouter
	un préfixe aux noms des tables de phpAdsNew. Si vous utilisez plusieurs phpAdsNew avec la même base
	de données, vous devez choisir un préfixe qui est unique à chaque installation de phpAdsNew.
";

$GLOBALS['phpAds_hlp_tabletype'] = "
	MySQL supporte plusieurs types de table. Chacun de ces types a des propriétés particulières, et certains
	peuvent accélérer phpAdsNew considérablement. MyISAM est le type par défaut, et est présent dans
	toutes les installations MySQL. Les autres types de tables peuvent ne pas être présents sur votre serveur.
";

$GLOBALS['phpAds_hlp_url_prefix'] = "
	phpAdsNew a besoin de savoir où il est situé sur le serveur, afin de fonctionner correctement.
	Vous devez spécifier l'Url du répertoire dans lequel phpAdsNew est installé, par exemple:
	http://www.monsite.fr/phpAdsNew
";

$GLOBALS['phpAds_hlp_my_header'] =
$GLOBALS['phpAds_hlp_my_footer'] = "
	Vous pouvez mettre ici le chemin vers les fichiers d'en-tête (ou de pied de page) (Par exemple:
	/home/login/www/header.htm) afin d'avoir des en-têtes ou des pieds de page sur chaque page de l'interface
	d'administration. Vous pouvez mettre ou bien du texte ou bien de l'html (si vous souhaitez utilisez de
	l'html dans un ou dans ces deux fichiers, veuillez a ne pas mettre de tags comme &lt;body&gt; ou &lt;html&gt;). [NDT:
	les fichiers d'en-tête et de pied de page seront inclus juste après la balise &lt;body&gt; de la page].
";

$GLOBALS['phpAds_hlp_content_gzip_compression'] = "
	By enabling GZIP content compression you will get a big decrease of the data which 
	is sent to the browser each time a page of the administrator interface is opened. 
	To enable this feature you need to have at least PHP 4.0.5 with the GZIP extention installed.
";
		
$GLOBALS['phpAds_hlp_language'] = "
	Spécifiez la langue que vous souhaitez utiliser. Cette langue sera utilisée par défaut pour l'interface
	d'administration, et celle de gestion des publicités. Veuillez noter que vous pourrez toujours choisir
	une langue différente pour chaque annonceur, ou que vous pourrez autoriser certains d'entres eux à la changer
	par eux-mêmes.
";

$GLOBALS['phpAds_hlp_name'] = "
	Spécifiez le nom que vous voulez utiliser pour cette application. Ce nom sera affiché sur toutes les pages
	des interfaces d'administration et de gestion des publicités. Si vous laissez ce champ vide (par défaut), un
	logo phpAdsNew sera affiché à la place.
";

$GLOBALS['phpAds_hlp_company_name'] = "
	Ce nom est utilisé dans les emails envoyés par phpAdsNew.
";

$GLOBALS['phpAds_hlp_override_gd_imageformat'] = "
	Normalement, phpAdsNew détecte automatiquement si la librairie GD est installée, et quels formats elle
	supporte. Toutefois, il est possible que la détection ne se fasse pas ou soit faussée, car certaines versions
	de PHP n'autorisent pas la détection des types d'images supportés. Si phpAdsNew ne parvient pas à détecter
	automatiquement ces formats, vous pouvez spécifier directement le bon format. Les valeurs autorisées sont:
	none, png, jpeg, gif.
";

$GLOBALS['phpAds_hlp_p3p_policies'] = "
	Si vous souhaitez activer la politique de respect de la vie privée P3P de phpAdsNew, vous devez utiliser
	cette option. 
";

$GLOBALS['phpAds_hlp_p3p_compact_policy'] = "
	La politique compacte est envoyée avec les cookies. Ce réglage par défaut autorise Internet Explorer 6 à
	accepter les cookies de phpAdsNew. Si vous voulez, vous pouvez modifier ce paramètre afin qu'il corresponde
	à votre propre politique de respect de la vie privée.
";

$GLOBALS['phpAds_hlp_p3p_policy_location'] = "
	Si vous utilisez une politique complète de respect de la vie privée, vous pouvez indiquer l'emplacement de
	votre chartre.
";

$GLOBALS['phpAds_hlp_log_beacon'] = "
	Beacons are small invisible images which are placed on the page where the banner 
	also is displayed. If you turn this feature on phpAdsNew will use this beacon image 
	to count the number of impressions the banner has recieved. If you turn this feature 
	off the impression will be counted during delivery, but this is not entirely accurate, 
	because a delivered banner doesn’t always have to be displayed on the screen. 
";
		
$GLOBALS['phpAds_hlp_compact_stats'] = "
	Traditionnellement, phpAdsNew utilise une journalisation assez intensive, qui est extrêmement détaillée,
	mais qui aussi demande beaucoup au niveau serveur SQL. Cela peut se révéler un gros problème sur des sites
	avec un grand nombre de visiteurs. Pour s'affranchir de ce problème, phpAdsNew supporte aussi un nouveau type
	de statistiques, les statistiques compactes, qui sont beaucoup moins demandantes question serveur SQL, mais qui
	aussi sont moins détaillées. Les statistiques compactes ne journalisent que les statistiques quotidiennes.
	Si vous avez besoin des statistiques heure par heure, désactivez cette option.
";

$GLOBALS['phpAds_hlp_log_adviews'] = "
	Normalement, tous les affichages sont journalisés. Si vous ne voulez pas de statistiques concernant les
	affichages, désactivez cette option.
";

$GLOBALS['phpAds_hlp_block_adviews'] = "
	If a visitor reloads a page an AdView will be logged by phpAdsNew every time. 
	This feature is used to make sure that only one AdView is logged for each unique 
	banner for the number of seconds you specify. For example: if you set this value 
	to 300 seconds, phpAdsNew will only log AdViews if the same banner isn’t already 
	shown to the same visitor in the last 5 minutes. This feature only works when <i>Use 
	beacons to log AdViews</i> is enabled and if the browser accepts cookies.
";
		
$GLOBALS['phpAds_hlp_log_adclicks'] = "
	Normalement, tous les clics sont journalisés. Si vous ne voulez pas de statistiques concernant les
	clics, désactivez cette option.
";

$GLOBALS['phpAds_hlp_block_adclicks'] = "
	If a visitor clicks multiple times on a banner an AdClick will be logged by phpAdsNew 
	every time. This feature is used to make sure that only one AdClick is logged for each 
	unique banner for the number of seconds you specify. For example: if you set this value 
	to 300 seconds, phpAdsNew will only log AdClicks if the visitor didn’t click on the same 
	banner in the last 5 minutes. This feature only works when the browser accepts cookies.
";
		
$GLOBALS['phpAds_hlp_reverse_lookup'] = "
	Par défaut, phpAdsNew journalise l'adresse IP de chaque visiteur. Si vous préférez que phpAdsNew journalise
	plutôt le nom d'hôte, choisissez cette option. La résolution inversée prend du temps; cela ralentira
	phpAdsNew.
";

$GLOBALS['phpAds_hlp_proxy_lookup'] = "
	Some users are using a proxy server to access the internet. In that case 
	phpAdsNew will log the IP address or the hostname of the proxy server 
	instead of the user. If you enable this feature phpAdsNew will try to 
	find the ip address or hostname of the user behind the proxy server. 
	If it is not possible to find the exact address of the user it will use 
	the address of the proxy server instead. This option is not enable by default, 
	because it will slow logging down.
";
		
$GLOBALS['phpAds_hlp_ignore_hosts'] = "
	Si vous ne voulez pas compter les clics et les affichages de certaines machines, vous pouvez les entrer
	ci-contre. Si vous avez activé la requête DNS inversée, vous pouvez entrer des adresses IP et des noms de
	domaines, autrement vous ne pouvez entrer que des adresses IP. Vous pouvez aussi utiliser des jokers
	(Ex: '*.altavista.fr' ou '192.168.*').
";

$GLOBALS['phpAds_hlp_begin_of_week'] = "
	Pour la plupart des gens, la semaine commence le Lundi, mais si vous souhaitez commencer chaque semaine un
	Dimanche, vous pouvez.
";

$GLOBALS['phpAds_hlp_percentage_decimals'] = "
	Spécifiez combien les pages de statistiques devront afficher de décimales dans leurs pourcentages.
";

$GLOBALS['phpAds_hlp_warn_admin'] = "
	phpAdsNew peut vous envoyer un email si une campagne n'a plus qu'un nombre limité de clics ou d'affichages
	restants. Cette option est activée par défaut.
";

$GLOBALS['phpAds_hlp_warn_client'] = "
	phpAdsNew peut envoyer à l'annonceur un email si une de ses campagnes n'a plus qu'un nombre limité de clics
	ou d'affichages restants. Cette option est activée par défaut.
";

$GLOBALS['phpAds_hlp_qmail_patch'] = "
	Some versions of qmail are affected by a bug, which causes e-mail sent by 
	phpAdsNew to show the headers inside the body of the e-mail. If you enable 
	this setting, phpAdsNew will send e-mail in a qmail compatible format.
";
		
$GLOBALS['phpAds_hlp_warn_limit'] = "
	La limite en dessous de laquelle phpAdsNew commence à envoyer les messages d'avertissement. La valeur est
	de 100 par défaut.
";

$GLOBALS['phpAds_hlp_allow_invocation_plain'] = 
$GLOBALS['phpAds_hlp_allow_invocation_js'] = 
$GLOBALS['phpAds_hlp_allow_invocation_frame'] = 
$GLOBALS['phpAds_hlp_allow_invocation_xmlrpc'] = 
$GLOBALS['phpAds_hlp_allow_invocation_local'] = 
$GLOBALS['phpAds_hlp_allow_invocation_interstitial'] = 
$GLOBALS['phpAds_hlp_allow_invocation_popup'] = "
	These settings allows you to control which invocation types are allowed.
	If one of these invocation types are disabled they will not be available
	in the invocationcode / bannercode generator. Important: the invocation methods
	will still work if disabled, but they are not available for generation.
";

$GLOBALS['phpAds_hlp_con_key'] = "
	phpAdsNew inclut une puissante méthode de sélection des bannières. Pour plus d'informations, reportez vous
	à la documentation. Avec cette option, vous pouvez activer les mots clés conditionnels. Cette option
	est activée par défaut.
";

$GLOBALS['phpAds_hlp_mult_key'] = "
	Pour chaque bannière, vous pouvez spécifier un ou plusieurs mots clés. Cette option est nécessaire si vous
	souhaitez spécifier plus d'un mot clé. Cette option est activée par défaut.
";

$GLOBALS['phpAds_hlp_acl'] = "
	Si vous n'utilisez pas les limites d'affichages des bannières, vous pouvez désactiver le contrôle de ces limites
	à chaque affichage, cela accélérera phpAdsNew.
";

$GLOBALS['phpAds_hlp_default_banner_url'] = 
$GLOBALS['phpAds_hlp_default_banner_target'] = "
	Si phpAdsNew ne peut pas se connecter au serveur de données, ou ne peut pas trouver une bannière correspondant
	à la requête, par exemple si la base de données a planté, ou si elle a été supprimé, cela n'affichera rien.
	Certains utilisateurs préfèrent spécifier une bannière par défaut, qui sera affichée dans ces situations.
	La bannière par défaut spécifiée ici ne sera pas comptée, et ne sera pas utilisée tant qu'il restera des
	bannières actives. Cette option est désactivée par défaut.
";

$GLOBALS['phpAds_hlp_zone_cache'] = "
	Si vous utilisez des zones, ce paramètre permet à phpAdsNew de stocker les informations sur les bannières
	dans un cache, qui sera ensuite réutilisé. Cela accélère un peu phpAdsNew, car plutôt que de récupérer toutes
	les informations de la zone, de récupérer les bannières, et de sélectionner la bonne, phpAdsNew a juste
	besoin de lire le cache. Cette option est activée par défaut.
";

$GLOBALS['phpAds_hlp_zone_cache_limit'] = "
	Si vous utilisez le cachage des zones, les informations présentes dans le cache peuvent se périmer.
	De temps en temps, phpAdsNew a besoin de reconstruire le cache, afin que les nouvelles bannières soient incluses.
	Ce paramètre vous laisse décider quand un cache doit être reconstruit, en spécifiant son âge maximum.
	Par exemple, si vous mettez ici 600, le cache sera reconstruit à chaque fois qu'il aura plus de 10 minutes
	(600 secondes).
";

$GLOBALS['phpAds_hlp_type_sql_allow'] = 
$GLOBALS['phpAds_hlp_type_web_allow'] = 
$GLOBALS['phpAds_hlp_type_url_allow'] = 
$GLOBALS['phpAds_hlp_type_html_allow'] = "
	phpAdsNew peut utiliser différents types de bannières et les stocker de différentes façons.
	Les deux premières options sont utilisées pour le stockage local des bannières.
	Vous pouvez utilisez l'interface d'administration pour uploader une bannière, et phpAdsNew
	la stockera dans une base SQL (Option 1), ou sur un serveur Web (Option 2).
	Vous pouvez aussi utiliser des bannières stockées sur des serveurs Web externes (Option 3),
	ou utiliser du HTML pour générer une bannière (Option 4). Vous pouvez désactiver n'importe laquelle
	de ces méthodes de stockage, en modifiant ces paramètres. Par défaut, tous les types de bannières
	sont autorisés.
	Si vous désactivez un certain type de bannière alors qu'il en existe encore de ce type, phpAdsNew les
	utilisera toujours, mais ne permettra plus leur création.
";

$GLOBALS['phpAds_hlp_type_web_mode'] = "
	Si vous souhaitez utiliser des bannières stockées sur un serveur Web, vous devez configurer
	ce paramètre. Pour stocker les bannières sur un répertoire local accessible par PHP, choisissez
	'répertoire local', et pour les stocker plutôt sur un serveur FTP externe, choisissez 'serveur
	FTP externe'. Sur certains serveurs vous pouvez préférer l'utilisation de l'option FTP, même si celui ci
	est situé sur le serveur local.
";

$GLOBALS['phpAds_hlp_type_web_dir'] = "
	Spécifiez le répertoire où phpAdsNew a besoin de copier les bannières uploadées.
	Ce répertoire DOIT être inscriptible par PHP, cela peut signifier que vous soyez obligé
	de changer les permissions UNIX de ce répertoire (chmod). Le répertoire que vous spécifiez ici DOIT
	être situé sous la racine du serveur Web, ce qui veut dire qu le serveur Web doit servir les fichiers
	de ce répertoire librement. N'ajoutez pas un slash (/) final au chemin du répertoire.
	Vous n'avez besoin de configurer cette option que si vous avez activé le stockage en mode local.
";

$GLOBALS['phpAds_hlp_type_web_ftp_host'] = "
	If you set the storing method to <i>External FTP server</i> you need to
        specify the IP address or domain name of the FTP server where phpAdsNew needs 
	to copy the uploaded banners to.
";
      
$GLOBALS['phpAds_hlp_type_web_ftp_path'] = "
	If you set the storing method to <i>External FTP server</i> you need to
        specify the directory on the external FTP server where phpAdsNew needs 
	to copy the uploaded banners to.
";
      
$GLOBALS['phpAds_hlp_type_web_ftp_user'] = "
	If you set the storing method to <i>External FTP server</i> you need to
        specify the username which phpAdsNew must use in order to connect to the
	external FTP server.
";
      
$GLOBALS['phpAds_hlp_type_web_ftp_password'] = "
	If you set the storing method to <i>External FTP server</i> you need to
        specify the password which phpAdsNew must use in order to connect to the
	external FTP server.
";
      
$GLOBALS['phpAds_hlp_type_web_url'] = "
	Si vous stockez les bannière sur un serveur Web (local ou FTP), phpAdsNew doit connaitre
	l'Url publique associée avec le répertoire que vous avez spécifié précédemment.
	N'ajoutez pas un slash (/) final au chemin du répertoire.
";

$GLOBALS['phpAds_hlp_type_html_auto'] = "
	Si cette option est activée, phpAdsNew modifiera automatiquement les bannières HTML, afin
	de permettre le comptage des clics. Néanmoins, même si cette option est activée, il sera possible
	de la désactiver pour certaines bannières.
";

$GLOBALS['phpAds_hlp_type_html_php'] = "
	Il est possible de laisser phpAdsNew exécuter du code PHP inclus dans des bannières HTML.
	Cette option est désactivée par défaut.
";

$GLOBALS['phpAds_hlp_admin'] = "
	Le nom d'utilisateur de l'administrateur: vous pouvez spécifier ici le nom d'utilisateur que
	vous devez utiliser pour entrer dans l'interface d'administration.";

$GLOBALS['phpAds_hlp_pwold'] = 
$GLOBALS['phpAds_hlp_pw'] = 
$GLOBALS['phpAds_hlp_pw2'] = "
        To change the administrator password, you can need to specify the old
	password above. Also you need to specify the old password twice, to
	prevent typing errors.
";

$GLOBALS['phpAds_hlp_admin_fullname'] = "
	Spécifiez ici le nom complet de l'administrateur. Ce paramètre est utilisé pour signer les
	statistiques envoyées par email.
";

$GLOBALS['phpAds_hlp_admin_email'] = "
	L'adresse email de l'administrateur. Ce paramètre est utilisé comme 'from-address'
	dans les emails de statistiques.
";

$GLOBALS['phpAds_hlp_admin_email_headers'] = "
	Vous pouvez ajouter des en-têtes email que phpAdsNew ajoutera à tout mail sortant.
";

$GLOBALS['phpAds_hlp_admin_novice'] = "
	Si vous souhaitez recevoir un avertissement lors de l'effacement d'annonceurs, de campagnes, ou
	de bannières. Il est très vivement conseillé de laisser cette option activée.
";

$GLOBALS['phpAds_hlp_client_welcome'] = 
$GLOBALS['phpAds_hlp_client_welcome_msg'] = "
	Si vous activez cette option, un message de bienvenue sera affiché sur la première page qu'un annonceur
	voit après s'être connecté. Vous pouvez le personnaliser, en éditant le fichier 'admin/templates/welcome.html'.
	Choses que vous pourriez vouloir écrire par exemple: le nom de votre entrepris, les informations concernant
	les contacts, le logo de votre entreprise, un lien vers les tarifs des publicités, etc...
";

$GLOBALS['phpAds_hlp_updates_frequency'] = "
		If you want to check for new versions of phpAdsNew you can enable this feature. 
		It is possible the specify the interval in which phpAdsNew makes a connection to 
		the update server. If a new version is found a dialog box will pop up with additional 
		information about the update.
";
		
$GLOBALS['phpAds_hlp_userlog_email'] = "
		If you want to keep a copy of all outgoing e-mail messages send by phpAdsNew you 
		can enable this feature. The e-mail messages are stored in the userlog.
";
		
$GLOBALS['phpAds_hlp_userlog_priority'] = "
		To ensure the priority calculation ran correct, you can save a report about 
		the hourly calculation. This report includes the predicted profile and how much 
		priority is assigned to all banners. This information might be useful if you 
		want to submit a bugreport about the priority calculations. The reports are 
		stored inside the userlog.
";
		
$GLOBALS['phpAds_hlp_default_banner_weight'] = "
		If you want to use a higher default banner weight you can specify the desired weight here. 
		This settings is 1 by default.
";
		
$GLOBALS['phpAds_hlp_default_campaign_weight'] = "
		If you want to use a higher default campaign weight you can specify the desired weight here. 
		This settings is 1 by default.
";
		
$GLOBALS['phpAds_hlp_gui_show_campaign_info'] = "
		If this option is enabled extra information about each campain will be shown on the 
		<i>Campaign overview</i> page. The extra information includes the number of AdViews remaining, 
		the number of AdClicks remaining, activation date, expiration date and the priority settings.
";
		
$GLOBALS['phpAds_hlp_gui_show_banner_info'] = "
		If this option is enabled extra information about each banner will be shown on the 
		<i>Banner overview</i> page. The extra information includes the destination URL, keywords, 
		size and the banner weight.
";
		
$GLOBALS['phpAds_hlp_gui_show_campaign_preview'] = "
		If this option is enabled a preview of all banners will be shown on the <i>Banner overview</i> 
		page. If this option is disabled it is still possible to show a preview of each banner by click 
		on the triangle next to each banner on the <i>Banner overview</i> page.
";
		
$GLOBALS['phpAds_hlp_gui_show_banner_html'] = "
		If this option is enabled the actual HTML banner will be shown instead of the HTML code. This 
		option is disabled by default, because the HTML banners might conflict with the user interface. 
		If this option is still possible to view the actual HTML banner, by clicking on the <i>Show banner</i>
		button next to the HTML code.
";
		
$GLOBALS['phpAds_hlp_gui_show_banner_preview'] = "
		If this option is enabled a preview will be shown at the top of the <i>Banner properties</i>, 
		<i>Delivery option</i> and <i>Linked zones</i> pages. If this option is disabled it is still 
		possible to view the banner, by clicking on the <i>Show banner</i> button at the top of the pages.
";
		
$GLOBALS['phpAds_hlp_gui_hide_inactive'] = "
		If this option is enabled all inactive banners, campaigns and advertisers will be hidden from the
		<i>Advertisers & Campaigns</i> and <i>Campaign overview</i> pages. If this option is enabled it is
		still possible to view the hidden items, by clicking on the <i>Show all</i> button on the bottom
		of the page.
";

?>