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
$GLOBALS['phpAds_hlp_dbhost'] = '
	Spécifiez ici l\'adresse de votre serveur de données '.$phpAds_dbmsname.' auquel '.$phpAds_productname.' doit se connecter (Ex: sql.monsite.fr).
';

$GLOBALS['phpAds_hlp_dbport'] = '
        Spécifiez le numéro du port de la base de données '.$phpAds_dbmsname.' à laquelle '.$phpAds_productname.' doit se connecter. Le port par défaut
        pour une base de données ".$phpAds_dbmsname." est <i>'.
		($phpAds_productname == 'phpAdsNew' ? '3306' : '5432').'</i>.
';

$GLOBALS['phpAds_hlp_dbuser'] = '
	Spécifiez le nom d\'utilisateur avec lequel '.$phpAds_productname.' peut se connecter à la base '.$phpAds_dbmsname.'.
';
		
$GLOBALS['phpAds_hlp_dbpassword'] = '
	Spécifiez le mot de passe avec lequel '.$phpAds_productname.' peut se connecter à la base '.$phpAds_dbmsname.'.
';

$GLOBALS['phpAds_hlp_dbname'] = '
	Spécifiez le nom de la base de données dans laquelle '.$phpAds_productname.' doit stocker ses données.
	Attention: la base doit déjà exister sur le serveur de données. '.$phpAds_productname.' ne créeras <b>pas</b> la base si elle n\'existe pas.
';

$GLOBALS['phpAds_hlp_persistent_connections'] = '
	L\'utilisation de connections persistantes peut accélérer considérablement '.$phpAds_productname.', et peut même diminuer la charge du serveur.
	Néanmoins, en cas de fortes charges du serveur Web, la charge du serveur SQL sera plus importe avec cette option. Le choix de cette option dépend du nombre de
	visiteurs, et du matériel que vous utilisez. Si '.$phpAds_productname.' utilise trop de ressources, vous devriez regarder d\'abord cette option. Par défaut
	cette option est désactivée, car elle peut-être incompatible avec certains systèmes.
';

$GLOBALS['phpAds_hlp_insert_delayed'] = '
	'.$phpAds_dbmsname.' bloque la table lorsque l\'on insère des données. Si vous avez beaucoup de visiteurs, il est possible
	que '.$phpAds_productname.' soit obligé d\'attendre avant d\'insérer une nouvelle ligne, la table étant déjà
	bloquée. Quand vous utilisez les insertions retardées, vous n\'avez pas à attendre, et la ligne sera insérée
	plus tard, lorsque la table ne sera plus utilisée.
';

$GLOBALS['phpAds_hlp_compatibility_mode'] = '
	Si vous avez des problèmes d\'intégration de '.$phpAds_productname.' avec d\'autres produits, cela peut aider d\'activer
	le mode de compatibilité de la base de données. Si vous utilisez le mode d\'invocation local, et que cette
	option est activée, '.$phpAds_productname.' laisserat la connexion avec la base de données exactement comme
	il l\'avait trouvé. Cette option ralentit un peu '.$phpAds_productname.' (seulement un peu), c\'est pourquoi elle est désactivée
	par défaut.
';

$GLOBALS['phpAds_hlp_table_prefix'] = '
	Si la base de données que '.$phpAds_productname.' utilise est partagée par plusieurs produits, il est intéressant d\'ajouter
	un préfixe aux noms des tables de '.$phpAds_productname.'. Si vous utilisez plusieurs '.$phpAds_productname.' avec la même base
	de données, vous devez choisir un préfixe différent pour chacune des installation.
';

$GLOBALS['phpAds_hlp_table_type'] = '
	'.$phpAds_dbmsname.' supporte plusieurs types de table. Chacun de ces types a des propriétés particulières, et certains
	peuvent accélérer '.$phpAds_productname.' considérablement. MyISAM est le type par défaut, et est présent dans
	toutes les installations '.$phpAds_dbmsname.'. Certains autres types de tables peuvent ne pas être présents sur votre serveur SQL.
';

$GLOBALS['phpAds_hlp_url_prefix'] = '
	'.$phpAds_productname.' a besoin de connaitre l\'adresse où il réside. Vous devez donc préciser l\'url publique à laquelle se trouve '.$phpAds_productname.'.
	Par exemple : <i>http://www.monsite.fr/'.$phpAds_productname.'</i>
';

$GLOBALS['phpAds_hlp_my_header'] =
$GLOBALS['phpAds_hlp_my_footer'] = '
	Cette option vous permet de spécifier des fichiers d\'entête et de pied de page, qui seront affiché en haut et en bas de chaque page.
	Il doit s\'agir d\'une adresse relative (exemple : ../site/header.html), ou absolue (exemple : /home/login/www/header.html). Ces deux fichiers peuvent contenir
	de l\'HTML, mais notez bien qu\'il seront inclus après la balise &lt;body&gt; pour l\'entête, et avant la balise &lt;/body&gt; pour le pied de page.
	Ils ne doivent donc en aucun cas contenir des balises telles que &lt;body&gt;, &lt;html&gt; ou &lt;head&gt;.
';

$GLOBALS['phpAds_hlp_content_gzip_compression'] = '
	L\'option GZip permet au serveur Web, et à la machine des clients de compresser les données qu\'ils s\'échangent. Cette option augmenté légerement le temps
	d\'éxécution des pages, mais diminue notablement le temps de chargement des pages, ainsi que la quantité de données envoyées par le serveur.
	Pour activer cette option, vous devez avoir PHP 4.0.5 (ou plus), avec l\'option GZip installée.<br>
	Cette option peut vous intéresser si votre hébergeur vous facture la quantité dedonnées envoyées.
';
		
$GLOBALS['phpAds_hlp_language'] = '
	La langue choisie ici sera celle par défaut pour l\'interfaçe d\'administration. Notez que vous pouvez spécifié une langue différente pour chaque utilisateur.
';

$GLOBALS['phpAds_hlp_name'] = '
	Le nom de l\'application apparaîtrat sur toutes les pages de l\'administration,et de la gestion des publicité.
	Si vous laissez ce champ vide (par défaut), un logo '.$phpAds_productname.' sera affiché à la place.
';

$GLOBALS['phpAds_hlp_company_name'] = '
	Ce nom est utilisé dans les emails envoyés par '.$phpAds_productname.'.
';

$GLOBALS['phpAds_hlp_override_gd_imageformat'] = '
	Normalement, '.$phpAds_productname.' détecte automatiquement la présence, et les formats supportés par la librairie GD. Néanmoins, il se peut que la détection
	soit érronée. Si '.$phpAds_productname.' ne parvient pas à trouver les bon paramètres, vous pouvez spécifier directement le bon format. Les valeurs autorisées sont:
	none, png, jpeg, gif.
';

$GLOBALS['phpAds_hlp_p3p_policies'] = '
	Si vous souhaitez activer la politique de respect de la vie privée P3P de '.$phpAds_productname.', vous devez utiliser
	cette option. 
';

$GLOBALS['phpAds_hlp_p3p_compact_policy'] = '
	La politique compacte est envoyée avec les cookies. Ce réglage par défaut autorise Internet Explorer 6 à
	accepter les cookies de '.$phpAds_productname.'. Si vous voulez, vous pouvez modifier ce paramètre afin qu\'il corresponde
	à votre propre politique de respect de la vie privée.
';

$GLOBALS['phpAds_hlp_p3p_policy_location'] = '
	Si vous utilisez une politique complète de respect de la vie privée, vous pouvez indiquer l\'emplacement de
	votre chartre.
';

$GLOBALS['phpAds_hlp_log_beacon'] = '
	Les balises sont de petites images invisibles qui sont placées sur la page où la bannière est affichée.
	Si vous activez cette fonctionnalité, '.$phpAds_productname.' utilisera cette image-balise pour compter le nombre
	d\'affichages que la bannière a fait. Si vous désactivez cette fonctionnalité, les affichages seront comptés
	à la distribution, mais ce n\'est pas entièrement fiable, puisque une bannière distribuée n\'est pas toujours
	affichée à l\'écran du visiteur (manque de temps, page trop longue, ...).
';
		
$GLOBALS['phpAds_hlp_compact_stats'] = '
	Traditionnellement, '.$phpAds_productname.' utilise une journalisation assez intensive, extrêmement détaillée, mais très gourmande en espace disque SQL.
	Pour s\'affranchir de ce problème, '.$phpAds_productname.' a introiduit un nouveau type de statistiques, les  statistiques résumées, qui consomme énormément
	mois de place, mais qui est moins détaillé. Les statistiques compactes ne journalisent non pas chaque clients, mais plutôt le nombre de client à chaque heure.
	Si vous avez beaucoup de visiteurs, ou que votre base de données sature, essayer de passer en mode \'Résumé\'.
';

$GLOBALS['phpAds_hlp_log_adviews'] = '
	Normalement, tous les affichages sont journalisés. Si vous ne voulez pas de statistiques concernant les affichages, désactivez cette option.
';

$GLOBALS['phpAds_hlp_block_adviews'] = '
	Si un visiteur recharge une page, à chaque fois un affichage sera compté. Cette fonctionnalité est utilisée pour s\'assurer que un seul affichage est décompté pour
	la même bannière, et pour le temps spécifié (en secondes). Par exemple, si vous mettez cette valeur à 300 secondes, '.$phpAds_productname.' ne comptera l\'affichage
	d\'une bannière que si elle n\'a pas été montrée à ce visiteur dans les 5 dernières minutes. Cette fonction n\'est active que si le navigateur du visiteur
	accepte les cookies.
';
		
$GLOBALS['phpAds_hlp_log_adclicks'] = '
	Normalement, tous les clics sont journalisés. Si vous ne voulez pas de statistiques concernant les clics, désactivez cette option.
';

$GLOBALS['phpAds_hlp_block_adclicks'] = '
	Si un visiteur clique plusieurs fois sur une bannière, un clic sera compté par '.$phpAds_productname.' chaque fois.
	Cette fonctionnalité est utilisée pour s\'assurer que seul un clic est compté pour une bannière unique,
	pour un même visiteur, pendant le temps spécifié (en secondes). Par exemple, si vous mettez cette valeur à
	300 secondes, '.$phpAds_productname.' ne comptera le clic d\'un visiteur que si celui ci n\'a pas déjà cliqué sur cette
	bannière dans les 5 dernières minutes. Cette option ne marche que si le navigateur du visiteur accepte les
	cookies.
';

$GLOBALS['phpAds_hlp_log_source'] = '
	Si vous utilisez le paramètre &quot;source&quot; dans votre conde d\'invocation des bannières, '.$phpAds_productname.' peut le journaliser
	de telle sorte que vous serez capable de voir les statistiques d\'affichages des différentes sources.
	Si vous n\'utilisez pas le paramètre &quot;source&quot;, ou si vous ne souhaitez pas journaliser cette information, vous pouvez
	désactiver sans crainte cette option.
';
		
$GLOBALS['phpAds_hlp_geotracking_stats'] = '
	Si vous utilisez une base de géolocalisation, vous pouvez journaliser les informations d\'emplacement dans la base de données.
	Si vous avez activé cette option, vous pourrez visualiser les statistiques de positionnement géographique de vos visiteurs, et savoir dans quels
	pays chaque bannière est la plus vue. Cette option n\'est disponible que si vous utilisez les statistiques détaillées.
';
		
$GLOBALS['phpAds_hlp_log_hostname'] = '
	Il est possible de journaliser le nom d\'hôte ou l\'adresse IP de chaque visiteur. Activer cette option vous permettra de voir quelle machine
	affiche le plus de bannières. Cette option n\'est disponible que si vous utilisez les statistiques détaillées.
';
		
$GLOBALS['phpAds_hlp_log_iponly'] = '
	La journalisation du nom d\'hôte de vos visiteurs prends énormément de place dans la base de données. Si vous activez cette option,
	'.$phpAds_productname.' continuera de journaliser les informations concernant l\'hôte, mais en utilisant l\'adresse IP, beaucoup plus petite.
	Cette option n\'est pas disponible si le nom d\'hôte n\'est pas fourni par le serveur ou par '.$phpAds_productname.', car dans ce cas ce sera
	toujours l\'adresse IP qui sera journalisée.
';	


$GLOBALS['phpAds_hlp_reverse_lookup'] = '
	Le nom d\'hôte est habituellement déterminé par le serveur Web, mais dans certains cas, cela est désactivé.
	Si vous souhaitez utiliser le nom d\'hôte dans les limitations de distributions et/ou en garder des statistiques, et que le
	serveur ne fournit pas le nom d\'hôte, vous devrez activer cette option.
	Attention néanmoins: la détermination du nom d\'hôte est une opération longue, et cela ralentiras la distribution des bannières.
';
		
$GLOBALS['phpAds_hlp_proxy_lookup'] = '
	Certains visiteurs utilisent un serveur proxy pour accéder à Internet. Dans ce cas, c\'est le nom d\'hôte (ou l\'adresse IP) du serveur proxy
	qui sera journalisé à la place de celui du visiteur. Si vous activez cette option, '.$phpAds_productname.' essaiera de déterminer le nom d\'hôte ou
	l\'adresse IP du visiteur placé derrière le serveur proxy. Si il n\'est pas possible de déterminer ces informations, celles du serveur proxy seront
	utilisées à la place. Cette option est désactivée par défaut, car elle ralentit considérablement la distribution des bannières.
';

$GLOBALS['phpAds_hlp_auto_clean_tables'] = 
$GLOBALS['phpAds_hlp_auto_clean_tables_interval'] = '
	Si vous activez cette option, les informations récupérées seront automatiquement supprimées après le nombre de semaines
	spécifié juste en dessous dans la case. Par exemple, si vous réglez la période à 5 semaines, toutes les statistiques plus vieilles que 5 semaines
	seront automatiquement supprimées.
';
		
$GLOBALS['phpAds_hlp_auto_clean_userlog'] = 
$GLOBALS['phpAds_hlp_auto_clean_userlog_interval'] = '
	Cette fonctionnalité supprimera automatiquement les entrées du journal utilisateur plus vieilles que le nombre de semaines spécifié.
';
		
$GLOBALS['phpAds_hlp_geotracking_type'] = '
	La géolocalisation permet à '.$phpAds_productname.' de transformer l\'adresse IP du visiteur en une information de positionnement géographique.
	Grâce à cette information, vous pouvez régler une limitation de distribution, ou vous pouvez journaliser cette information pour
	voir quel pays génère le plus d\'affichages ou de clics. Si vous voulez activer la géolocalisation, vous devez indiquer quel type de base vous avez.
	'.$phpAds_productname.' supporte actuellement les bases <a href="http://hop.clickbank.net/?phpadsnew/ip2country" target="_blank">IP2Country</a>
	et <a href="http://www.maxmind.com/?rId=phpadsnew" target="_blank">GeoIP</a>.
';
		
$GLOBALS['phpAds_hlp_geotracking_location'] = '
	A moins que vous n\'utilisiez le module Apache GeoIP, vous devez indiquer à '.$phpAds_productname.' l\'emplacement
	de votre base de géolocalisation. Il est vivement recommandé de placer la base à l\'extérieur de la racine Web, afin d\'éviter
	que n\'importe qui ne puisse la télécharger.
';
		
$GLOBALS['phpAds_hlp_geotracking_cookie'] = '
	La conversion de l\'adresse IP en informations géographiques prends du temps. Afin d\'éviter à '.$phpAds_productname.' d\'avoir à faire cela
	à chaque bannière, le résultat de la conversion peut être stocké dans un cookie. Si le cookie est présent, '.$phpAds_productname.' utilisera
	ce cookie plutôt que de retransformer l\'adresse IP.
';

$GLOBALS['phpAds_hlp_ignore_hosts'] = '
	Si vous ne voulez pas compter les clics et les affichages de certaines machines, vous pouvez les entrer
	ci-contre. Si vous avez activé la requête DNS inversée, vous pouvez entrer des adresses IP et des noms de
	domaines, autrement vous ne pouvez entrer que des adresses IP. Vous pouvez aussi utiliser des jokers
	(Ex: \'*.altavista.fr\' ou \'192.168.*\').
';

$GLOBALS['phpAds_hlp_begin_of_week'] = '
	Pour la plupart des gens, la semaine commence le Lundi, mais si vous souhaitez commencer chaque semaine un
	Dimanche, vous pouvez.
';

$GLOBALS['phpAds_hlp_percentage_decimals'] = '
	Spécifiez combien les pages de statistiques devront afficher de décimales dans leurs pourcentages.
';

$GLOBALS['phpAds_hlp_warn_admin'] = '
	'.$phpAds_productname.' peut vous envoyer un email si une campagne n\'a plus qu\'un nombre limité de clics ou d\'affichages
	restants. Cette option est activée par défaut.
';

$GLOBALS['phpAds_hlp_warn_client'] = '
	'.$phpAds_productname.' peut envoyer à l\'annonceur un email si une de ses campagnes n\'a plus qu\'un nombre limité de clics
	ou d\'affichages restants. Cette option est activée par défaut.
';

$GLOBALS['phpAds_hlp_qmail_patch'] = '
	Certaines versions de qmail sont affectées par un bogue, qui affiche les entêtes du mail dans le corps des messages que '.$phpAds_productname.'envoie.
	Activez cette option si votre version de qmail est bogué.
';
		
$GLOBALS['phpAds_hlp_warn_limit'] = '
	La limite en dessous de laquelle '.$phpAds_productname.' envoyedes messages d\'avertissement (à l\'administrateur et/ou à l\'annonceur). La valeur est de 100 par défaut.
';

$GLOBALS['phpAds_hlp_allow_invocation_plain'] = 
$GLOBALS['phpAds_hlp_allow_invocation_js'] = 
$GLOBALS['phpAds_hlp_allow_invocation_frame'] = 
$GLOBALS['phpAds_hlp_allow_invocation_xmlrpc'] = 
$GLOBALS['phpAds_hlp_allow_invocation_local'] = 
$GLOBALS['phpAds_hlp_allow_invocation_interstitial'] = 
$GLOBALS['phpAds_hlp_allow_invocation_popup'] = '
	Vous pouvez choisir les codes d\'invocation autorisés. Ces réglages n\'influent que sur la page de géneration du code, c\'est à dire que les autres modes
	d\'invocation continueront de marcher, à condition que leur code d\'invocation ait été généré avant.
';

$GLOBALS['phpAds_hlp_con_key'] = '
	'.$phpAds_productname.' inclut une puissante méthode de sélection des bannières. Pour plus d\'informations, reportez vous
	à la documentation. Avec cette option, vous pouvez activer les mots clés conditionnels. Cette option
	est activée par défaut.
';

$GLOBALS['phpAds_hlp_mult_key'] = '
	Pour chaque bannière, vous pouvez spécifier un ou plusieurs mots clés. Cette option est nécessaire si vous
	souhaitez spécifier plus d\'un mot clé. Cette option est activée par défaut.
';

$GLOBALS['phpAds_hlp_acl'] = '
	Si vous n\'utilisez pas les limitations d\'affichages des bannières, vous pouvez désactiver le contrôle de ces limites à chaque affichage, cela accélérera '.$phpAds_productname.'.
';

$GLOBALS['phpAds_hlp_default_banner_url'] = 
$GLOBALS['phpAds_hlp_default_banner_target'] = '
	Si '.$phpAds_productname.' n\'arrive pas à se connecter au serveur SQL, ou bien qu\'il ne trouve aucune bannière à afficher, il se tournera vers ces réglages.
	Cette option est désactivée par défaut.
';
$GLOBALS['phpAds_hlp_delivery_caching'] = '
	Afin d\'accélérer la distribution, '.$phpAds_productname.' utilise un cache qui contient les informations nécessitées pour la distribution
	d\'une bannière à un visiteur de votre site. Le cache de distribution est stocké par défaut dans votre base de données, mais pour accélérer encore plus,
	il est possible de stocker le cache dans un fichier, ou en mémoire partagée. La mémoire partagée est la plus rapide, mais les fichiers sont rapides aussi.
	Il n\'est pas recommandé de désactiver le cache de distribution, car cela affecterait fortement les performances.
';

$GLOBALS['phpAds_hlp_type_sql_allow'] = 
$GLOBALS['phpAds_hlp_type_web_allow'] = 
$GLOBALS['phpAds_hlp_type_url_allow'] = 
$GLOBALS['phpAds_hlp_type_html_allow'] = '
	'.$phpAds_productname.' peut utiliser différents types de bannières et les stocker de différentes façons.
	Les deux premières options sont utilisées pour le stockage local des bannières.
	Vous pouvez utilisez l\'interface d\'administration pour envoyer une bannière, et '.$phpAds_productname.'
	la stockera dans une base SQL (Option 1), ou sur un serveur Web/FTP (Option 2).
	Vous pouvez aussi utiliser des bannières stockées sur des serveurs Web externes (Option 3),
	ou utiliser du HTML pour générer une bannière (Option 4). Vous pouvez désactiver n\'importe laquelle
	de ces méthodes de stockage, en modifiant ces paramètres. Par défaut, tous les types de bannières
	sont autorisés.
	Si vous désactivez un certain type de bannière alors qu\'il en existe encore de ce type, '.$phpAds_productname.' les
	utilisera toujours, mais ne permettra plus leur création.
';

$GLOBALS['phpAds_hlp_type_web_mode'] = '
	Si vous souhaitez utiliser des bannières stockées sur un serveur Web, vous devez configurer
	ce paramètre. Pour stocker les bannières sur un répertoire local accessible par PHP, choisissez
	\'répertoire local\', et pour les stocker plutôt sur un serveur FTP externe, choisissez \'serveur
	FTP externe\'. Sur certains serveurs vous pouvez préférer l\'utilisation de l\'option FTP, même si celui ci
	est situé sur le serveur local.
';

$GLOBALS['phpAds_hlp_type_web_dir'] = '
	Spécifiez le répertoire où '.$phpAds_productname.' a besoin de copier les bannières uploadées.
	Ce répertoire DOIT être inscriptible par PHP, cela peut signifier que vous soyez obligé
	de changer les permissions UNIX de ce répertoire (chmod). Le répertoire que vous spécifiez ici DOIT
	être situé sous la racine du serveur Web, ce qui veut dire qu le serveur Web doit servir les fichiers
	de ce répertoire librement. N\'ajoutez pas un slash (/) final au chemin du répertoire.
	Vous n\'avez besoin de configurer cette option que si vous avez activé le stockage en mode local.
';

$GLOBALS['phpAds_hlp_type_web_ftp_host'] = '
	Si vous avez choisi comme méthode de stockage <i>Serveur FTP externe</i>, vous devez spécifier ici
	l\'adresse IP ou le nom d\'hôte du serveur sur lequel '.$phpAds_productname.' copiera les bannières.
';
      
$GLOBALS['phpAds_hlp_type_web_ftp_path'] = '
	Si vous avez choisi comme méthode de stockage <i>Serveur FTP externe</i>, vous devez spécifier ici
	le chemin, sur le serveur FTP externe, du répertoire dans lequel '.$phpAds_productname.' copiera les bannières.
';
      
$GLOBALS['phpAds_hlp_type_web_ftp_user'] = '
	Si vous avez choisi comme méthode de stockage <i>Serveur FTP externe</i>, vous devez spécifier ici
	le nom d\'utilisateur avec lequel '.$phpAds_productname.' se connectera au serveur FTP externe sur lequel '.$phpAds_productname.'
	copiera les bannières.
';
      
$GLOBALS['phpAds_hlp_type_web_ftp_password'] = '
	Si vous avez choisi comme méthode de stockage <i>Serveur FTP externe</i>, vous devez spécifier ici
	le mot de passe avec lequel '.$phpAds_productname.' se connectera au serveur FTP externe sur lequel '.$phpAds_productname.'
	copiera les bannières.
';
      
$GLOBALS['phpAds_hlp_type_web_url'] = '
	Si vous stockez les bannière sur un serveur Web (local ou FTP), '.$phpAds_productname.' doit connaitre
	l\'Url publique associée avec le répertoire que vous avez spécifié précédemment.
	N\'ajoutez pas un slash (/) final au chemin du répertoire.
';

$GLOBALS['phpAds_hlp_type_html_auto'] = '
	Si cette option est activée, '.$phpAds_productname.' modifiera automatiquement les bannières HTML, afin
	de permettre le comptage des clics. Néanmoins, même si cette option est activée, il sera possible
	de la désactiver pour certaines bannières.
';

$GLOBALS['phpAds_hlp_type_html_php'] = '
	Il est possible de laisser '.$phpAds_productname.' exécuter du code PHP inclus dans des bannières HTML.
	Cette option est désactivée par défaut.
';

$GLOBALS['phpAds_hlp_admin'] = '
	Le nom d\'utilisateur de l\'administrateur: vous pouvez spécifier ici le nom d\'utilisateur que
	vous devez utiliser pour entrer dans l\'interface d\'administration.';

$GLOBALS['phpAds_hlp_admin_pw'] =
$GLOBALS['phpAds_hlp_admin_pw2'] = '
	Veuillez entrer le mot de passe que vous souhaitez utiliser pour vous connecter à l\'interfaçe d\'administration.
	Vous devez le taper deux fois afin d\'éviter les fautes de frappe.
';
		
$GLOBALS['phpAds_hlp_pwold'] = 
$GLOBALS['phpAds_hlp_pw'] = 
$GLOBALS['phpAds_hlp_pw2'] = '
	Pour changer le mot de passe de l\'administrateur, vous devez spécifier l\'ancient mot de passe ci-dessus.
	Vous devez aussi taper le nouveau mot de passe deux fois, afin de prévenir à tout risque d\'erreur.
';

$GLOBALS['phpAds_hlp_admin_fullname'] = '
	Spécifiez ici le nom complet de l\'administrateur. Ce paramètre est utilisé pour signer les
	statistiques envoyées par email.
';

$GLOBALS['phpAds_hlp_admin_email'] = '
	L\'adresse email de l\'administrateur. Ce paramètre est utilisé comme \'from-address\'
	dans les emails de statistiques.
';

$GLOBALS['phpAds_hlp_admin_email_headers'] = '
	Vous pouvez ajouter des en-têtes email que '.$phpAds_productname.' ajoutera à tout mail sortant.
';

$GLOBALS['phpAds_hlp_admin_novice'] = '
	Si vous souhaitez recevoir un avertissement lors de l\'effacement d\'annonceurs, de campagnes, ou
	de bannières. Il est très vivement conseillé de laisser cette option activée.
';

$GLOBALS['phpAds_hlp_client_welcome'] = 
$GLOBALS['phpAds_hlp_client_welcome_msg'] = '
	Si vous activez cette option, un message de bienvenue sera affiché sur la première page qu\'un annonceur
	voit après s\'être connecté. Vous pouvez le personnaliser, en éditant le fichier \'admin/templates/welcome.html\'.
	Choses que vous pourriez vouloir écrire par exemple: le nom de votre entrepris, les informations concernant
	les contacts, le logo de votre entreprise, un lien vers les tarifs des publicités, etc...
';

$GLOBALS['phpAds_hlp_updates_frequency'] = '
	Si vous souhaitez que '.$phpAds_productname.' vérifie si il existe des mises à jour, vous pouvez activer cette fonction.
	Il est possible de spécifier l\'intervalle entre chaque vérification. Cette vérification s\'effectue par
	une connexion au serveur de mise à jour. Si une nouvelle version est trouvée, une boite de dialogue
	apparaîtra, avec d\'avantages d\'informations concernant la mise à jour.
';
		
$GLOBALS['phpAds_hlp_userlog_email'] = '
	Si vous souhaitez garder une copie de tous les emails sortant envoyés par '.$phpAds_productname.', vous pouvez activer
	cette fonctionnalité. Les emails sortants sont stockés dans le journal utilisateur.
';
		
$GLOBALS['phpAds_hlp_userlog_priority'] = '
	Pour s\'assurer que le calcul des priorités a été correctement effectué, vous pouvez activer l\'enregistrement
	des rapports des calculs de priorités (chaque heure) dans le journal utilisateur. Ces rapports incluent
	les prévisions, ainsi que la priorité assignée à chaque bannière. Ces informations peuvent être utiles si
	vous souhaitez soumettre un rapport de bug à propos de ces calculs de priorité.
';

$GLOBALS['phpAds_hlp_userlog_autoclean'] = '
	Afin de pouvoir vous assurer que la base de données a été nettoyée correctement, vous pouvez sauver un rapport qui décrira
	ce qui s\'est exactement passé durant le nettoyage. Ce rapport sera stocké dans le journal utilisateur.
';

$GLOBALS['phpAds_hlp_default_banner_weight'] = '
	Si vous souhaitez assigner un poids par défaut des bannières supérieur à 1 (valeur par défaut), vous pouvez
	spécifier ici le poids désiré.
';
		
$GLOBALS['phpAds_hlp_default_campaign_weight'] = '
	Si vous souhaitez assigner un poids par défaut des campagnes supérieur à 1 (valeur par défaut), vous pouvez
	spécifier ici le poids désiré.
';
		
$GLOBALS['phpAds_hlp_gui_show_campaign_info'] = '
	Si cette option est activée, des informations supplémentaires à propos de chaque campagne seront
	montrées sur la page <i>Aperçu de la campagne</i>. Les informations supplémentaires incluent le nombre
	d\'affichages restants, de nombre de clics restants, la date d\'activation, la date d\'expiration, et
	les paramètres de priorité.
';
		
$GLOBALS['phpAds_hlp_gui_show_banner_info'] = '
	Si cette option est activée, des informations supplémentaires à propos de chaque bannière seront
	montrées sur la page <i>Aperçu de la bannière</i>.Les informations supplémentaires incluent l\'Url
	de destination, les mots clés, la taille, et le poids de la bannière.
';
		
$GLOBALS['phpAds_hlp_gui_show_campaign_preview'] = '
	Si cette option est activée, un aperçu de toutes les bannières sera montré sur la page <i>Aperçu des
	bannières</i>. Si cette option est désactivée, il est toujours possible de voir un aperçu de chaque bannière
	en cliquant sur le triangle proche de chaque bannière sur la page <i>Aperçu des bannières</i>.
';
		
$GLOBALS['phpAds_hlp_gui_show_banner_html'] = '
	Si cette option est activée, la bannière HTML actuelle sera montrée, à la place du code HTML brut.
	Cette option est désactivée par défaut, car les bannières HTML peuvent rentrer en conflit avec
	l\'interface utilisateur. Si cette option est désactivée, il est toujours possible de voir la bannière
	HTML actuelle, en cliquant sur <i>Montrer la bannière</i>, a coté du code HTML brut.
';
		
$GLOBALS['phpAds_hlp_gui_show_banner_preview'] = '
	Si cette option est activée, un aperçu sera montré en haut des pages <i>Propriétés de la bannière</i>,
	<i>Options de limitation</i>, et <i>Zones liées</i>. Si cette option est désactivée, il sera toujours
	possible de voir la bannière, en cliquant sur le <i>Montrer la bannière</i>, en haut de ces pages.
';
		
$GLOBALS['phpAds_hlp_gui_hide_inactive'] = '
	Si cette option est activée, tous les annonceurs, bannières, et campagnes inactifs seront cachés des pages
	<i>Annonceurs et Campagnes</i>, et <i>Aperçu de la campagne</i>. Si cette option est activée, il est toujours
	possible de voir les éléments cachés, en cliquant sur <i>Montrer tout</i> en bas de ces pages.
';

$GLOBALS['phpAds_hlp_gui_show_matching'] = '
	Si cette option est activée, les bannières correspondantes seront montrée dans la page <i>Bannières liées</i>,
	si la méthode <i>Sélection par campagnes</i> est choisie. Cela vous permettra de voir exactement quelles bannières
	serait susceptibles d\'être distribuées si la campagne était liée. Il sera aussi possible de voir un aperçu des
	bannières correspondantes.
';
		
$GLOBALS['phpAds_hlp_gui_show_parents'] = '
	Si cette option est activée, les campagnes parentes des bannières seront montrées sur la page <i>Bannières liées</i>,
	si la méthode <i>Sélection par bannières</i> est choisie. Cela vous permettra de voir exactement à quelles campagnes
	appartiennent les bannières que vous vous apprêtez à lier. Cela signifie aussi que les bannières seront groupées par
	campagnes parentes, et non plus triées alphabétiquement.
';
		
$GLOBALS['phpAds_hlp_gui_link_compact_limit'] = '
	Par défaut toutes les bannières disponibles sont affichées sur la page <i>Bannières liées</i>.
	Cette page pourrait ainsi devenir très longue si le nombre de bannières est important.
	En activant cette option, vous pourrez régler un nombre maximal d\'éléments qui seront affichées sur la page.
	Si il y a plus d\'éléments, ou plusieurs manières de lier, les bannières seront montrées ce qui prendra moins de place.
';
?>