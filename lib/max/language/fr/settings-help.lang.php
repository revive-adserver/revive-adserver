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
$GLOBALS['phpAds_hlp_dbhost'] = '
	Spécifiez ici l\'adresse du serveur de données '.$phpAds_dbmsname.' (Ex: sql.monsite.fr).
';

$GLOBALS['phpAds_hlp_dbuser'] = '
	Spécifiez le nom d\'utilisateur avec lequel '.$phpAds_productname.' peut se connecter à la base '.$phpAds_dbmsname.'.
';

$GLOBALS['phpAds_hlp_dbpassword'] = '
	Spécifiez le mot de passe avec lequel '.$phpAds_productname.' peut se connecter à la base '.$phpAds_dbmsname.'.
';

$GLOBALS['phpAds_hlp_dbname'] = '
	Spécifiez le nom de la base dans laquelle '.$phpAds_productname.' doit stocker ses données.
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
	de données, vous devez choisir un préfixe unique pour chaque installation de '.$phpAds_productname.'.
';

$GLOBALS['phpAds_hlp_tabletype'] = '
	'.$phpAds_dbmsname.' supporte plusieurs types de table. Chacun de ces types a des propriétés particulières, et certains
	peuvent accélérer '.$phpAds_productname.' considérablement. MyISAM est le type par défaut, et est présent dans
	toutes les installations '.$phpAds_dbmsname.'. Certains autres types de tables peuvent ne pas être présents sur votre serveur SQL.
';

$GLOBALS['phpAds_hlp_url_prefix'] = '
	'.$phpAds_productname.' a besoin de connaitre l\'adresse où il réside. Vous devez donc préciser l\'url publique à laquelle se trouve '.$phpAds_productname.'.
	Par exemple : http://www.monsite.fr/'.$phpAds_productname.'
';

$GLOBALS['phpAds_hlp_my_header'] =
$GLOBALS['phpAds_hlp_my_footer'] = '
	Cette option vous permet de spécifier des fichiers d\'entête et de pied de page, qui seront affiché en haut et en bas de chaque page.
	Il doit s\'agir d\'une adresse relative (exemple : ../site/header.html), ou absolue (exemple : /home/login/www/header.html). Ces deux fichiers peuvent contenir
	de l\'HTML, mais notez bien qu\'il seront inclus après la balise <body> pour l\'entête, et avant la balise </body> pour le pied de page.
	Ils ne doivent donc en aucun cas contenir des balises telles que <body>, <html> ou <head>.
';

$GLOBALS['phpAds_hlp_content_gzip_compression'] = 'En permettant la compression de contenu GZIP vous obtiendrez une diminution du volume de données envoyées au navigateur chaque fois que qu\'un écran administrateur est affiché. Pour autoriser cette fonctionnalité vous devez avoir l\'extension GZIP installée.';

$GLOBALS['phpAds_hlp_language'] = '
	La langue choisie ici sera celle par défaut pour l\'interfaçe d\'administration. Notez que vous pouvez spécifié une langue différente pour chaque utilisateur.
';

$GLOBALS['phpAds_hlp_name'] = '
	Le nom de l\'application apparaîtrat sur toutes les pages de l\'administration,et de la gestion des publicité.
	Si vous laissez ce champ vide (par défaut), un logo '.$phpAds_productname.' sera affiché à la place.
';

$GLOBALS['phpAds_hlp_company_name'] = 'Ce nom est déjà utilisé dans l\'e-mail envoyé par \". '.MAX_PRODUCT_NAME.' .\". ';

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
	d\'une bannière que si elle n\'a pas été montrée à ce visiteur dans les 5 dernières minutes. Cette option n\'est valable que lorsque <i>Utiliser des balises invisibles
	pour compter les affichages</i> est activé, et si le navigateur du visiteur accepte les cookies.
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

$GLOBALS['phpAds_hlp_reverse_lookup'] = '
	Par défaut, '.$phpAds_productname.' journalise l\'adresse IP de chaque visiteur. Si vous préférez que '.$phpAds_productname.' journalise le nom de la machine, activez
	cette option. La résolution inversée  des noms de domaine prend du temps; cela ralentira '.$phpAds_productname.'.
';

$GLOBALS['phpAds_hlp_proxy_lookup'] = '
	Certains utilisateurs utilisent des Proxy pour accéder à l\'internet. Dans ce cas, '.$phpAds_productname.' va journaliser
	le nom d\'hôte du Proxy, plutôt que celui de l\'utilisateur. Si vous activez cette option, '.$phpAds_productname.' essayera
	de trouver l\'adresse IP, ou le nom d\'hôte de l\'utilisateur derrière ce proxy. Si ce n\'est pas possible
	de récupérer l\'adresse exacte de l\'utilisateur, l\'adresse du Proxy sera utilisée à la place. Cette option
	est désactivée par défaut, car elle ralentit la journalisation.
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

$GLOBALS['phpAds_hlp_warn_client'] = '\". '.MAX_PRODUCT_NAME.' .\" peut envoyer un e-mail à l\'annonceur si l\'une de ses campagnes a seulement un';

$GLOBALS['phpAds_hlp_qmail_patch'] = 'Certaines versions de qmail sont affectées par un bug faisant que les e-mails envoyés par 
". '.MAX_PRODUCT_NAME.' ." affichent les en-têtes dans le corps des e-mails. Si vous activez 
ce paramètre, ". '.MAX_PRODUCT_NAME.' ." enverra les e-mails dans un format compatible avec qmail.';

$GLOBALS['phpAds_hlp_warn_limit'] = 'La limite à partir de laquelle \". '.MAX_PRODUCT_NAME.' .\" commence à envoyer des e-mails d\'alerte. Il s\'agit de 100';

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

$GLOBALS['phpAds_hlp_zone_cache'] = '
	Si vous utilisez des zones, ce paramètre permet à '.$phpAds_productname.' de stocker les informations sur les bannières
	dans un cache, qui sera ensuite réutilisé. Cela accélère un peu '.$phpAds_productname.', car plutôt que de récupérer toutes
	les informations de la zone, de récupérer les bannières, et de sélectionner la bonne, '.$phpAds_productname.' a juste
	besoin de lire le cache. Cette option est activée par défaut.
';

$GLOBALS['phpAds_hlp_zone_cache_limit'] = '
	Si vous utilisez le cachage des zones, les informations présentes dans le cache peuvent se périmer.
	De temps en temps, '.$phpAds_productname.' a besoin de reconstruire le cache, afin que les nouvelles bannières soient incluses.
	Ce paramètre vous laisse décider quand un cache doit être reconstruit, en spécifiant son âge maximum.
	Par exemple, si vous mettez ici 600, le cache sera reconstruit à chaque fois qu\'il aura plus de 10 minutes
	(600 secondes).
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

$GLOBALS['phpAds_hlp_admin_email'] = 'L\'adresse e-mail de l\'administrateur. Elle est utilisée en tant qu\'adresse d\'expédition quand';

$GLOBALS['phpAds_hlp_admin_email_headers'] = '
	Vous pouvez ajouter des en-têtes email que '.$phpAds_productname.' ajoutera à tout mail sortant.
';

$GLOBALS['phpAds_hlp_admin_novice'] = 'Si vous voulez recevoir une alerte avant la suppression des annonceurs, campagnes, bannières, sites web et zones, cette option doit être vraie.';

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

$GLOBALS['phpAds_hlp_default_banner_weight'] = '
	Si vous souhaitez assigner un poids par défaut des bannières supérieur à 1 (valeur par défaut), vous pouvez
	spécifier ici le poids désiré.
';

$GLOBALS['phpAds_hlp_default_campaign_weight'] = '
	Si vous souhaitez assigner un poids par défaut des campagnes supérieur à 1 (valeur par défaut), vous pouvez
	spécifier ici le poids désiré.
';

$GLOBALS['phpAds_hlp_gui_show_campaign_info'] = 'Si cette option est activée, des informations supplémentaires sur chaque campagne seront affichées sur la page <i>Campagnes</i>. Les informations supplémentaires comprennent le nombre d\'affichages restants, le nombre de clics restants, le nombre de conversions restantes, la date d\'activation, la date d\'expiration et les paramètres de priorité.';

$GLOBALS['phpAds_hlp_gui_show_banner_info'] = 'Si cette option est activée, des informations supplémentaires sur chaque bannière seront affichées sur la page <i>Bannières</i>. Les informations supplémentaires comprennent l\'URL de destination, les mots-clés, la taille et le poids de la bannière.';

$GLOBALS['phpAds_hlp_gui_show_campaign_preview'] = 'Si cette option est activée, un aperçu de toutes les bannières sera affiché sur la page <i>Bannières</i>. Si cette option est désactivée, il est tout de même possible d\'afficher un aperçu de chaque bannière en cliquant sur le triangle à côté de chacune d\'elles sur la page <i>Bannières</i>.';

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

$GLOBALS['phpAds_hlp_gui_hide_inactive'] = 'Si cette option est activée, toutes les bannières, campagnes et annonceurs seront masqués des pages <i>Annonceurs & Campagnes</i> et <i>Campagnes</i>. Si cette option est activée, il est tout de même possible d\'afficher les objets masqués en cliquant sur le bouton <i>Afficher tout</i> au bas de la page.';

?>