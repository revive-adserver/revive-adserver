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
	Si vous avez des problèmes d'intégration de phpAdsNew avec d'autres produits, cela peut aider d'activer
	le mode de compatibilité de la base de données. Si vous utilisez le mode d'invocation local, et que cette
	option est activée, phpAdsNew devrait laisser l'état de connexion avec la base de données exactement comme
	il l'avait trouvé. Cette option ralentit un peu phpAdsNew (seulement un peu), c'est pourquoi elle est désactivée
	par défaut.
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
	En activant la compression GZip du contenu, vous devriez avoir une baisse dans la quantité de données
	échangées entre le serveur et le navigateur, chaque fois que l'on utilise l'interface d'administration.
	Pour activer cette option, vous devez avoir au minimum PHP 4.0.5, avec l'extension GZip installée.
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
	Les balises sont de petites images invisibles qui sont placées sur la page où la bannière est affichée.
	Si vous activez cette fonctionnalité, phpAdsNew utilisera cette image-balise pour compter le nombre
	d'affichages que la bannière a fait. Si vous désactivez cette fonctionnalité, les affichages seront comptés
	à la distribution, mais ce n'est pas entièrement fiable, puisque une bannière distribuée n'est pas toujours
	affichée à l'écran du visiteur (manque de temps, page trop longue, ...).
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
	Si un visiteur recharge une page, à chaque fois un affichage sera compté. Cette fonctionnalité est utilisée
	pour s'assurer que un seul affichage est décompté pour la même bannière, et pour le temps spécifié (en
	secondes). Par exemple, si vous mettez cette valeur à 300 secondes, phpAdsNew ne comptera l'affichage d'une
	bannière que si elle n'a pas été montrée à ce visiteur dans les 5 dernières minutes. Cette option n'est
	valable que lorsque <i>Utiliser des balises invisibles pour compter les affichages</i> est activé,
	et si le navigateur du visiteur accepte les cookies.
";
		
$GLOBALS['phpAds_hlp_log_adclicks'] = "
	Normalement, tous les clics sont journalisés. Si vous ne voulez pas de statistiques concernant les
	clics, désactivez cette option.
";

$GLOBALS['phpAds_hlp_block_adclicks'] = "
	Si un visiteur clique plusieurs fois sur une bannière, un clic sera compté par phpAdsNew chaque fois.
	Cette fonctionnalité est utilisée pour s'assurer que seul un clic est compté pour une bannière unique,
	pour un même visiteur, pendant le temps spécifié (en secondes). Par exemple, si vous mettez cette valeur à
	300 secondes, phpAdsNew ne comptera le clic d'un visiteur que si celui ci n'a pas déjà cliqué sur cette
	bannière dans les 5 dernières minutes. Cette option ne marche que si le navigateur du visiteur accepte les
	cookies.
";
		
$GLOBALS['phpAds_hlp_reverse_lookup'] = "
	Par défaut, phpAdsNew journalise l'adresse IP de chaque visiteur. Si vous préférez que phpAdsNew journalise
	plutôt le nom d'hôte, choisissez cette option. La résolution inversée prend du temps; cela ralentira
	phpAdsNew.
";

$GLOBALS['phpAds_hlp_proxy_lookup'] = "
	Certains utilisateurs utilisent des Proxy pour accéder à l'internet. Dans ce cas, phpAdsNew va journaliser
	le nom d'hôte du Proxy, plutôt que celui de l'utilisateur. Si vous activez cette option, phpAdsNew essayera
	de trouver l'adresse IP, ou le nom d'hôte de l'utilisateur derrière ce proxy. Si ce n'est pas possible
	de récupérer l'adresse exacte de l'utilisateur, l'adresse du Proxy sera utilisée à la place. Cette option
	est désactivée par défaut, car elle ralentit la journalisation.
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
	Ces réglages permettent de contrôler quels sont les types d'invocations autorisés. Si un de ces types
	est désactivé, il ne sera pas disponible sur la page de génération du code d'invocation. Important: une
	méthode d'invocation marche même si elle est désactivée, par contre elle n'est plus disponible sur la
	page de génération.
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
	Si vous avez choisi comme méthode de stockage <i>Serveur FTP externe</i>, vous devez spécifier ici
	l'adresse IP ou le nom d'hôte du serveur sur lequel phpAdsNew copiera les bannières.
";
      
$GLOBALS['phpAds_hlp_type_web_ftp_path'] = "
	Si vous avez choisi comme méthode de stockage <i>Serveur FTP externe</i>, vous devez spécifier ici
	le chemin, sur le serveur FTP externe, du répertoire dans lequel phpAdsNew copiera les bannières.
";
      
$GLOBALS['phpAds_hlp_type_web_ftp_user'] = "
	Si vous avez choisi comme méthode de stockage <i>Serveur FTP externe</i>, vous devez spécifier ici
	le nom d'utilisateur avec lequel phpAdsNew se connectera au serveur FTP externe sur lequel phpAdsNew
	copiera les bannières.
";
      
$GLOBALS['phpAds_hlp_type_web_ftp_password'] = "
	Si vous avez choisi comme méthode de stockage <i>Serveur FTP externe</i>, vous devez spécifier ici
	le mot de passe avec lequel phpAdsNew se connectera au serveur FTP externe sur lequel phpAdsNew
	copiera les bannières.
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
	Pour changer le mot de passe de l'administrateur, vous devez spécifier l'ancien mot de passe,
	ainsi que le nouveau mot de passe deux fois, afin de prévenir à toute faute de frappe.
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
	Si vous souhaitez que phpAdsNew vérifie si il existe des mises à jour, vous pouvez activer cette fonction.
	Il est possible de spécifier l'intervalle entre chaque vérification. Cette vérification s'effectue par
	une connexion au serveur de mise à jour. Si une nouvelle version est trouvée, une boite de dialogue
	apparaîtra, avec d'avantages d'informations concernant la mise à jour.
";
		
$GLOBALS['phpAds_hlp_userlog_email'] = "
	Si vous souhaitez garder une copie de tous les emails sortant envoyés par phpAdsNew, vous pouvez activer
	cette fonctionnalité. Les emails sortants sont stockés dans le journal utilisateur.
";
		
$GLOBALS['phpAds_hlp_userlog_priority'] = "
	Pour s'assurer que le calcul des priorités a été correctement effectué, vous pouvez activer l'enregistrement
	des rapports des calculs de priorités (chaque heure) dans le journal utilisateur. Ces rapports incluent
	les prévisions, ainsi que la priorité assignée à chaque bannière. Ces informations peuvent être utiles si
	vous souhaitez soumettre un rapport de bug à propos de ces calculs de priorité.
";
		
$GLOBALS['phpAds_hlp_default_banner_weight'] = "
	Si vous souhaitez assigner un poids par défaut des bannières supérieur à 1 (valeur par défaut), vous pouvez
	spécifier ici le poids désiré.
";
		
$GLOBALS['phpAds_hlp_default_campaign_weight'] = "
	Si vous souhaitez assigner un poids par défaut des campagnes supérieur à 1 (valeur par défaut), vous pouvez
	spécifier ici le poids désiré.
";
		
$GLOBALS['phpAds_hlp_gui_show_campaign_info'] = "
	Si cette option est activée, des informations supplémentaires à propos de chaque campagne seront
	montrées sur la page <i>Aperçu de la campagne</i>. Les informations supplémentaires incluent le nombre
	d'affichages restants, de nombre de clics restants, la date d'activation, la date d'expiration, et
	les paramètres de priorité.
";
		
$GLOBALS['phpAds_hlp_gui_show_banner_info'] = "
	Si cette option est activée, des informations supplémentaires à propos de chaque bannière seront
	montrées sur la page <i>Aperçu de la bannière</i>.Les informations supplémentaires incluent l'Url
	de destination, les mots clés, la taille, et le poids de la bannière.
";
		
$GLOBALS['phpAds_hlp_gui_show_campaign_preview'] = "
	Si cette option est activée, un aperçu de toutes les bannières sera montré sur la page <i>Aperçu des
	bannières</i>. Si cette option est désactivée, il est toujours possible de voir un aperçu de chaque bannière
	en cliquant sur le triangle proche de chaque bannière sur la page <i>Aperçu des bannières</i>.
";
		
$GLOBALS['phpAds_hlp_gui_show_banner_html'] = "
	Si cette option est activée, la bannière HTML actuelle sera montrée, à la place du code HTML brut.
	Cette option est désactivée par défaut, car les bannières HTML peuvent rentrer en conflit avec
	l'interface utilisateur. Si cette option est désactivée, il est toujours possible de voir la bannière
	HTML actuelle, en cliquant sur <i>Montrer la bannière</i>, a coté du code HTML brut.
";
		
$GLOBALS['phpAds_hlp_gui_show_banner_preview'] = "
	Si cette option est activée, un aperçu sera montré en haut des pages <i>Propriétés de la bannière</i>,
	<i>Options de limitation</i>, et <i>Zones liées</i>. Si cette option est désactivée, il sera toujours
	possible de voir la bannière, en cliquant sur le <i>Montrer la bannière</i>, en haut de ces pages.
";
		
$GLOBALS['phpAds_hlp_gui_hide_inactive'] = "
	Si cette option est activée, tous les annonceurs, bannières, et campagnes inactifs seront cachés des pages
	<i>Annonceurs et Campagnes</i>, et <i>Aperçu de la campagne</i>. Si cette option est activée, il est toujours
	possible de voir les éléments cachés, en cliquant sur <i>Montrer tout</i> en bas de ces pages.
";

?>