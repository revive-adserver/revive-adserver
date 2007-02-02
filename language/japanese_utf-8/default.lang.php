<?php // $Revision$

/************************************************************************/
/* Openads 2.0                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2007 by the Openads developers                    */
/* For more information visit: http://www.openads.org                   */
/*                                                                      */
/*                                                                      */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

//  Translator: Tadashi Jokagi <elf2000@users.sourceforge.net>
//  EN-Revision: 2.5.2.23

// Set text direction and characterset
$GLOBALS['phpAds_TextDirection']  		= "ltr";
$GLOBALS['phpAds_TextAlignRight'] 		= "right";
$GLOBALS['phpAds_TextAlignLeft']  		= "left";
$GLOBALS['phpAds_CharSet'] = "utf-8";
$GLOBALS['phpAds_DecimalPoint']			= ',';
$GLOBALS['phpAds_ThousandsSeperator']	= '.';


// Date & time configuration
$GLOBALS['date_format']				= "%Y 年 %m 月 %d 日";
$GLOBALS['time_format']				= "%H:%M:%S";
$GLOBALS['minute_format']			= "%H:%M";
$GLOBALS['month_format']			= "%Y 年 %m 月";
$GLOBALS['day_format']				= "%m 月 %d 日";
$GLOBALS['week_format']				= "%Y 年 %W 週";
$GLOBALS['weekiso_format']			= "%G 年 %V 週";



/*********************************************************/
/* Translations                                          */
/*********************************************************/

$GLOBALS['strHome'] 				= "ホーム";
$GLOBALS['strHelp']				= "ヘルプ";
$GLOBALS['strNavigation'] 			= "ナビゲーション";
$GLOBALS['strShortcuts'] 			= "ショートカット";
$GLOBALS['strAdminstration'] 			= "Inventory";
$GLOBALS['strMaintenance']			= "メンテナンス";
$GLOBALS['strProbability']			= "確率";
$GLOBALS['strInvocationcode']			= "Invocationcode";
$GLOBALS['strBasicInformation'] 		= "基本情報";
$GLOBALS['strContractInformation'] 		= "連絡情報";
$GLOBALS['strLoginInformation'] 		= "ログイン情報";
$GLOBALS['strOverview']				= "概要";
$GLOBALS['strSearch']				= "検索 (<u>S</u>)";
$GLOBALS['strHistory']				= "履歴";
$GLOBALS['strPreferences'] 			= "プリファレンス";
$GLOBALS['strDetails']				= "詳細";
$GLOBALS['strCompact']				= "コンパクト";
$GLOBALS['strVerbose']				= "Verbose";
$GLOBALS['strUser']				= "ユーザー";
$GLOBALS['strEdit']				= "編集する";
$GLOBALS['strCreate']				= "作成する";
$GLOBALS['strDuplicate']			= "複製する";
$GLOBALS['strMoveTo']				= "Move to";
$GLOBALS['strDelete'] 				= "削除する";
$GLOBALS['strActivate']				= "アクティブ";
$GLOBALS['strDeActivate'] 			= "非アクティブ";
$GLOBALS['strConvert']				= "変換する";
$GLOBALS['strRefresh']				= "再描画する";
$GLOBALS['strSaveChanges']		 	= "変更を保存する";
$GLOBALS['strUp'] 				= "上へ";
$GLOBALS['strDown'] 				= "下へ";
$GLOBALS['strSave'] 				= "保存する";
$GLOBALS['strCancel']				= "取り消し";
$GLOBALS['strPrevious'] 			= "前へ";
$GLOBALS['strPrevious_Key'] 			= "前へ (<u>P</u>)";
$GLOBALS['strNext'] 				= "次へ";
$GLOBALS['strNext_Key'] 				= "次へ (<u>N</u>)";
$GLOBALS['strYes']				= "はい";
$GLOBALS['strNo']				= "いいえ";
$GLOBALS['strNone'] 				= "なし";
$GLOBALS['strCustom']				= "カスタム";
$GLOBALS['strDefault'] 				= "デフォルト";
$GLOBALS['strOther']				= "その他";
$GLOBALS['strUnknown']				= "不明";
$GLOBALS['strUnlimited'] 			= "制限なし";
$GLOBALS['strUntitled']				= "名称未設定";
$GLOBALS['strAll'] 				= "すべて";
$GLOBALS['strAvg'] 				= "平均";
$GLOBALS['strAverage']				= "平均";
$GLOBALS['strOverall'] 				= "全般";
$GLOBALS['strTotal'] 				= "合計";
$GLOBALS['strActive'] 				= "アクティブ";
$GLOBALS['strFrom']				= "From";
$GLOBALS['strTo']				= "to";
$GLOBALS['strLinkedTo'] 			= "linked to";
$GLOBALS['strDaysLeft'] 			= "Days left";
$GLOBALS['strCheckAllNone']			= "すべてチェック / なし";
$GLOBALS['strKiloByte']				= "KB";
$GLOBALS['strExpandAll']			= "すべて展開する (<u>E</u>)";
$GLOBALS['strCollapseAll']			= "すべて閉じる (<u>C</u>)";
$GLOBALS['strShowAll']				= "すべて表示する";
$GLOBALS['strNoAdminInteface']			= "サービスは利用できません...";
$GLOBALS['strFilterBySource']			= "ソースでフィルター";
$GLOBALS['strFieldContainsErrors']		= "次の項目はエラーを含んでいます:";
$GLOBALS['strFieldFixBeforeContinue1']		= "Before you can continue you need";
$GLOBALS['strFieldFixBeforeContinue2']		= "to correct these errors.";
$GLOBALS['strDelimiter']			= "デリミター";
$GLOBALS['strMiscellaneous']		= "その他";
$GLOBALS['strUseQuotes']			= "引用を使用する";



// Properties
$GLOBALS['strName']				= "名前";
$GLOBALS['strSize']				= "サイズ";
$GLOBALS['strWidth'] 				= "幅";
$GLOBALS['strHeight'] 				= "高さ";
$GLOBALS['strURL2']				= "URL";
$GLOBALS['strTarget']				= "ターゲット";
$GLOBALS['strLanguage'] 			= "言語";
$GLOBALS['strDescription'] 			= "説明";
$GLOBALS['strID']				= "ID";


// Login & Permissions
$GLOBALS['strAuthentification'] 		= "認証";
$GLOBALS['strWelcomeTo']			= "ようこそ";
$GLOBALS['strEnterUsername']			= "ログインするユーザー名とパスワードを入力してください。";
$GLOBALS['strEnterBoth']			= "ユーザー名とパスワードを両方入力してください";
$GLOBALS['strEnableCookies']			= $phpAds_productname."を使用する前に Cookie が有効になっている必要があります。";
$GLOBALS['strLogin'] 				= "ログイン";
$GLOBALS['strLogout'] 				= "ログアウト";
$GLOBALS['strUsername'] 			= "ユーザー名";
$GLOBALS['strPassword']				= "パスワード";
$GLOBALS['strAccessDenied']			= "アクセス拒否です";
$GLOBALS['strPasswordWrong']			= "パスワードが正確ではありません。";
$GLOBALS['strNotAdmin']				= "十分な権限を持っていません。";
$GLOBALS['strDuplicateClientName']		= "提供されたユーザー名は既に存在します。異なるユーザー名を使用してください。";
$GLOBALS['strInvalidPassword']			= "新しいパスワードは無効です。異なるパスワードを使用してください。";
$GLOBALS['strNotSamePasswords']			= "提供された 2 つのパスワードは同じではありません。";
$GLOBALS['strRepeatPassword']			= "パスワード(再度)";
$GLOBALS['strOldPassword']			= "古いパスワード";
$GLOBALS['strNewPassword']			= "新しいパスワード";



// General advertising
$GLOBALS['strViews'] 				= "AdViews";
$GLOBALS['strClicks']				= "AdClicks";
$GLOBALS['strCTRShort'] 			= "CTR";
$GLOBALS['strCTR'] 				= "Click-Through Ratio";
$GLOBALS['strTotalViews'] 			= "総 AdViews";
$GLOBALS['strTotalClicks'] 			= "総 AdClicks";
$GLOBALS['strViewCredits'] 			= "AdView クレジット";
$GLOBALS['strClickCredits'] 			= "AdClick クレジット";


// Time and date related
$GLOBALS['strDate'] 				= "日付";
$GLOBALS['strToday'] 				= "今日";
$GLOBALS['strDay']				= "Day";
$GLOBALS['strDays']				= "Days";
$GLOBALS['strLast7Days']			= "最後の 7 日";
$GLOBALS['strWeek'] 				= "週";
$GLOBALS['strWeeks']				= "週";
$GLOBALS['strMonths']				= "月";
$GLOBALS['strThisMonth'] 			= "今月";
$GLOBALS['strMonth'] 				= array("1 月","2 月","3 月","4 月","5 月","6 月","7 月", "8 月", "9 月", "10 月", "11 月", "12 月");
$GLOBALS['strDayShortCuts'] 			= array("日","月","火","水","木","金","土");
$GLOBALS['strHour']				= "時間";
$GLOBALS['strSeconds']				= "秒";
$GLOBALS['strMinutes']				= "分";
$GLOBALS['strHours']				= "時";
$GLOBALS['strTimes']				= "times";


// Advertiser
$GLOBALS['strClient']				= "広告主";
$GLOBALS['strClients'] 				= "広告主";
$GLOBALS['strClientsAndCampaigns']		= "広告主とキャンペーン";
$GLOBALS['strAddClient'] 			= "広告主を追加する";
$GLOBALS['strAddClient_Key'] 		= "広告主を追加する (<u>n</u>)";
$GLOBALS['strTotalClients'] 			= "総広告主数";
$GLOBALS['strClientProperties']			= "広告主のプロパティ";
$GLOBALS['strClientHistory']			= "広告主の履歴";
$GLOBALS['strNoClients']			= "現在広告主は定義されていません";
$GLOBALS['strConfirmDeleteClient'] 		= "本当にこの広告主を削除しますか?";
$GLOBALS['strConfirmResetClientStats']		= "本当にこの広告主の存在するすべての統計を削除しますか?";
$GLOBALS['strHideInactiveAdvertisers']		= "非アクティブな広告主を隠す";
$GLOBALS['strInactiveAdvertisersHidden']	= "人の非アクティブな広告主を隠しています";


// Advertisers properties
$GLOBALS['strContact'] 				= "連絡";
$GLOBALS['strEMail'] 				= "電子メール";
$GLOBALS['strSendAdvertisingReport']		= "電子メールで広告の報告書を送信する";
$GLOBALS['strNoDaysBetweenReports']		= "Number of days between reports";
$GLOBALS['strSendDeactivationWarning']  	= "キャンペーンがアクティブでなくなった時に警告を送信する";
$GLOBALS['strAllowClientModifyInfo'] 		= "このユーザーが自分の設定を修正することを許可する";
$GLOBALS['strAllowClientModifyBanner'] 		= "このユーザーが自分のバナーを修正することを許可する";
$GLOBALS['strAllowClientAddBanner'] 		= "このユーザーが自分のバナーを追加することを許可する";
$GLOBALS['strAllowClientDisableBanner'] 	= "このユーザーが自分のバナーを非アクティブにすることを許可する";
$GLOBALS['strAllowClientActivateBanner'] 	= "このユーザーが自分のバナーをアクティブにすることを許可する";


// Campaign
$GLOBALS['strCampaign']				= "キャンペーン";
$GLOBALS['strCampaigns']			= "キャンペーン";
$GLOBALS['strTotalCampaigns'] 			= "総キャンペーン数";
$GLOBALS['strActiveCampaigns'] 			= "アクティブキャンペーン";
$GLOBALS['strAddCampaign'] 			= "新規キャンペーンを作成する";
$GLOBALS['strAddCampaign_Key'] 		= "新規キャンペーンを作成する (<u>n</u>)";
$GLOBALS['strCreateNewCampaign']		= "新規キャンペーンを作成する";
$GLOBALS['strModifyCampaign']			= "キャンペーンを修正する";
$GLOBALS['strMoveToNewCampaign']		= "新規キャンペーンに移動する";
$GLOBALS['strBannersWithoutCampaign']		= "キャンペーンと無関係のバナー";
$GLOBALS['strDeleteAllCampaigns']		= "すべてのキャンペーンを削除する";
$GLOBALS['strCampaignStats']			= "キャンペーンの統計";
$GLOBALS['strCampaignProperties']		= "キャンペーンのプロパティ";
$GLOBALS['strCampaignOverview']			= "キャンペーンの概要";
$GLOBALS['strCampaignHistory']			= "キャンペーンの履歴";
$GLOBALS['strNoCampaigns']			= "現在定義済のキャンペーンはありません。";
$GLOBALS['strConfirmDeleteAllCampaigns']	= "本当にこの広告主が所有するすべてのキャンペーンを削除しますか?";
$GLOBALS['strConfirmDeleteCampaign']		= "本当にこのキャンペーンを削除しますか?";
$GLOBALS['strConfirmResetCampaignStats']		= "このキャンペーンの存在するすべての統計を削除しますか?";
$GLOBALS['strHideInactiveCampaigns']		= "非アクティブなキャンペーンを隠す";
$GLOBALS['strInactiveCampaignsHidden']		= "個の非アクティブなキャンペーンを隠しています。";


// Campaign properties
$GLOBALS['strDontExpire']			= "特別な日のこのキャンペーンを終了しない";
$GLOBALS['strActivateNow'] 			= "このキャンペーンを直接アクティブにする";
$GLOBALS['strLow']				= "低い";
$GLOBALS['strHigh']				= "高い";
$GLOBALS['strExpirationDate']			= "期限日";
$GLOBALS['strActivationDate']			= "実行期日";
$GLOBALS['strViewsPurchased'] 			= "残り AdViews";
$GLOBALS['strClicksPurchased'] 			= "残り AdClicks";
$GLOBALS['strCampaignWeight']			= "キャンペーンの重み";
$GLOBALS['strHighPriority']			= "Show banners in this campaign with high priority.<br>If you use this option ".$phpAds_productname." will try to distribute the number of AdViews evenly over the course of the day.";
$GLOBALS['strLowPriority']			= "Show banner in this campaign with low priority.<br> This campaign is used to show the left over AdViews which aren't used by high priority campaigns.";
$GLOBALS['strTargetLimitAdviews']		= "Limit the number of AdViews to";
$GLOBALS['strTargetPerDay']			= "per day.";
$GLOBALS['strPriorityAutoTargeting']		= "Distribute the remaining AdViews evenly over the remaining number of days. The target number of AdViews will be set accordingly every day.";
$GLOBALS['strCampaignWarningNoWeight'] = "The priority of this campaign has been set to low, \nbut the weight is set to zero or it has not been \nspecified. This will cause the campaign to be \ndeactivated and it's banners won't be delivered \nuntil the weight has been set to a valid number. \n\nAre you sure you want to continue?";
$GLOBALS['strCampaignWarningNoTarget'] = "The priority of this campaign has been set to high, \nbut the target number of AdViews are not specified. \nThis will cause the campaign to be deactivated and \nit's banners won't be delivered until a valid target \nnumber of AdViews has been set. \n\n本当に継続しますか?";



// Banners (General)
$GLOBALS['strBanner'] 				= "バナー";
$GLOBALS['strBanners'] 				= "バナー";
$GLOBALS['strAddBanner'] 			= "新規バナーを追加する";
$GLOBALS['strAddBanner_Key'] 			= "新規バナー (<u>n</u>)";
$GLOBALS['strModifyBanner'] 			= "バナーを修正する";
$GLOBALS['strActiveBanners'] 			= "アクティブバナー";
$GLOBALS['strTotalBanners'] 			= "総バナー数";
$GLOBALS['strShowBanner']			= "バナーを表示する";
$GLOBALS['strShowAllBanners']	 		= "すべてのバナーを表示する";
$GLOBALS['strShowBannersNoAdClicks']		= "AdClicks と無関係のバナーを表示する";
$GLOBALS['strShowBannersNoAdViews']		= "AdViews と無関係のバナーを表示する";
$GLOBALS['strDeleteAllBanners']	 		= "すべてのバナーを削除する";
$GLOBALS['strActivateAllBanners']		= "すべてのバナーを活動化する";
$GLOBALS['strDeactivateAllBanners']		= "すべてのバナーを非活動化する";
$GLOBALS['strBannerOverview']			= "バナーの概要";
$GLOBALS['strBannerProperties']			= "バナーのプロパティ";
$GLOBALS['strBannerHistory']			= "バナーの履歴";
$GLOBALS['strBannerNoStats'] 			= "このバナーの利用可能な統計はありません。";
$GLOBALS['strNoBanners']			= "現在定義済のバナーはありません。";
$GLOBALS['strConfirmDeleteBanner']		= "このバナーを本当に削除しますか?";
$GLOBALS['strConfirmDeleteAllBanners']		= "Do you really want to delete all banners which are owned by this campaign?";
$GLOBALS['strConfirmResetBannerStats']		= "Do you really want to delete all existing statistics for this banner?";
$GLOBALS['strShowParentCampaigns']		= "親キャンペーンを表示する";
$GLOBALS['strHideParentCampaigns']		= "親キャンペーンを隠す";
$GLOBALS['strHideInactiveBanners']		= "非アクティブなバナーを隠す";
$GLOBALS['strInactiveBannersHidden']		= "個の非アクティブなバナーを隠しています";
$GLOBALS['strAppendOthers']				= "その他の追加";
$GLOBALS['strAppendTextAdNotPossible']	= "It is not possible to append other banners to text ads.";



// Banner (Properties)
$GLOBALS['strChooseBanner'] 			= "バナーの種類を選択してください";
$GLOBALS['strMySQLBanner'] 			= "ローカルバナー (SQL)";
$GLOBALS['strWebBanner'] 			= "ローカルバナー (ウェブサーバー)";
$GLOBALS['strURLBanner'] 			= "外部バナー";
$GLOBALS['strHTMLBanner'] 			= "HTML バナー";
$GLOBALS['strTextBanner'] 			= "テキスト広告";
$GLOBALS['strAutoChangeHTML']			= "AdClicks の追跡を有効にするために HTML を変更する";
$GLOBALS['strUploadOrKeep']			= "Do you wish to keep your <br>existing image, or do you <br>want to upload another?";
$GLOBALS['strNewBannerFile'] 			= "このバナーで使用したい<br>画像を選択する<br><br>";
$GLOBALS['strNewBannerURL'] 			= "画像 URL (「http://」を含む)";
$GLOBALS['strURL'] 				= "Destination URL (「http://」を含む)";
$GLOBALS['strHTML'] 				= "HTML";
$GLOBALS['strTextBelow'] 			= "画像のしたのテキスト";
$GLOBALS['strKeyword'] 				= "キーワード";
$GLOBALS['strWeight'] 				= "重み";
$GLOBALS['strAlt'] 				= "Alt text";
$GLOBALS['strStatusText']			= "状態テキスト";
$GLOBALS['strBannerWeight']			= "Banner weight";
$GLOBALS['strSwfTransparency']		= "透過背景 (Flash のみ)";


// Banner (swf)
$GLOBALS['strCheckSWF']				= "Check for hard-coded links inside the Flash file";
$GLOBALS['strConvertSWFLinks']			= "Convert Flash links";
$GLOBALS['strHardcodedLinks']			= "Hard-coded links";
$GLOBALS['strConvertSWF']			= "<br>The Flash file you just uploaded contains hard-coded urls. ".$phpAds_productname." won't be able to track the number of AdClicks for this banner unless you convert these hard-coded urls. Below you will find a list of all urls inside the Flash file. If you want to convert the urls, simply click <b>Convert</b>, otherwise click <b>Cancel</b>.<br><br>Please note: if you click <b>Convert</b> the Flash file you just uploaded will be physically altered. <br>Please keep a backup of the original file. Regardless of in which version this banner was created, the resulting file will need the Flash 4 player (or higher) to display correctly.<br><br>";
$GLOBALS['strCompressSWF']			= "Compress SWF file for faster downloading (Flash 6 player required)";
$GLOBALS['strOverwriteSource']		= "Overwrite source parameter";


// Banner (network)
$GLOBALS['strBannerNetwork']			= "HTML テンプレート";
$GLOBALS['strChooseNetwork']			= "使用したいテンプレートを選択する";
$GLOBALS['strMoreInformation']			= "さらに情報...";
$GLOBALS['strRichMedia']			= "リッチメディア";
$GLOBALS['strTrackAdClicks']			= "AdClicks 追跡";


// Display limitations
$GLOBALS['strModifyBannerAcl'] 			= "配送オプション";
$GLOBALS['strACL'] 						= "配送";
$GLOBALS['strACLAdd'] 					= "新規制限を追加する";
$GLOBALS['strACLAdd_Key'] 				= "新規制限を追加する (<u>n</u>)";
$GLOBALS['strNoLimitations']			= "制限はありません";
$GLOBALS['strApplyLimitationsTo']		= "Apply limitations to";
$GLOBALS['strRemoveAllLimitations']		= "すべての制限を削除する";
$GLOBALS['strEqualTo']					= "is equal to";
$GLOBALS['strDifferentFrom']			= "is different from";
$GLOBALS['strLaterThan']				= "is later than";
$GLOBALS['strLaterThanOrEqual']			= "is later than or equal to";
$GLOBALS['strEarlierThan']				= "is earlier than";
$GLOBALS['strEarlierThanOrEqual']		= "is earlier than or equal to";
$GLOBALS['strContains']					= "含む";
$GLOBALS['strNotContains']				= "含まない";
$GLOBALS['strAND']						= "AND";  						// logical operator
$GLOBALS['strOR']						= "OR"; 						// logical operator
$GLOBALS['strOnlyDisplayWhen']			= "Only display this banner when:";
$GLOBALS['strWeekDay'] 					= "平日";
$GLOBALS['strTime'] 					= "時間";
$GLOBALS['strUserAgent'] 				= "ユーザーエージェント";
$GLOBALS['strDomain'] 					= "ドメイン";
$GLOBALS['strClientIP'] 				= "クライアント IP";
$GLOBALS['strSource'] 					= "Source";
$GLOBALS['strBrowser'] 					= "ブラウザー";
$GLOBALS['strOS'] 						= "OS";
$GLOBALS['strCountry'] 					= "国";
$GLOBALS['strContinent'] 				= "Continent";
$GLOBALS['strUSCAState']				= "US/CA 地域";
$GLOBALS['strFIPSRegion']				= "Region (%s)";
$GLOBALS['strCity']						= "都市";
$GLOBALS['strPostalCode']				= "郵便番号";
$GLOBALS['strDMACode']					= "DMA コード";
$GLOBALS['strAreaCode']					= "エリアコード";
$GLOBALS['strOrgISP']					= "Organization/ISP";
$GLOBALS['strNetSpeed']					= "ネットワーク速度";
$GLOBALS['strReferer'] 					= "Referring page";
$GLOBALS['strDeliveryLimitations']		= "配送制限";
$GLOBALS['strDeliveryCapping']			= "Delivery capping";
$GLOBALS['strTimeCapping']				= "Once this banner has been delivered once, don't show this banner again to the same user for:";
$GLOBALS['strImpressionCapping']		= "Do not show this banner to the same user more than:";
$GLOBALS['strLimitationDropped']		= "At least one delivery limitation was dropped because currently not applicable";
$GLOBALS['strShowCountry']				= "表示する";
$GLOBALS['strShowAllCountries']			= "すべての国";


// Publisher
$GLOBALS['strAffiliate']			= "パブリッシャー";
$GLOBALS['strAffiliates']			= "パブリッシャー";
$GLOBALS['strAffiliatesAndZones']		= "パブリッシャーとゾーン";
$GLOBALS['strAddNewAffiliate']			= "新規パブリッシャーを追加する";
$GLOBALS['strAddNewAffiliate_Key']			= "新規パブリッシャーを追加する (<u>n</u>)";
$GLOBALS['strAddAffiliate']			= "パブリッシャーを作成する";
$GLOBALS['strAffiliateProperties']		= "パブリッシャーのプロパティ";
$GLOBALS['strAffiliateOverview']		= "パブリッシャーの概要";
$GLOBALS['strAffiliateHistory']			= "パブリッシャーの履歴";
$GLOBALS['strZonesWithoutAffiliate']		= "パブリッシャーと無関係のゾーン";
$GLOBALS['strMoveToNewAffiliate']		= "新規パブリッシャーに移動する";
$GLOBALS['strNoAffiliates']			= "現在パブリッシャーは定義されていません。";
$GLOBALS['strConfirmDeleteAffiliate']		= "本当にこのパブリッシャーを削除しますか?";
$GLOBALS['strMakePublisherPublic']		= "Make the zones owned by this publisher publicly available";


// Publisher (properties)
$GLOBALS['strWebsite']				= "ウェブサイト";
$GLOBALS['strAllowAffiliateModifyInfo'] 	= "このユーザが自分の設定を修正することを許可する";
$GLOBALS['strAllowAffiliateModifyZones'] 	= "このユーザーが自分のゾーンを修正することを許可する";
$GLOBALS['strAllowAffiliateLinkBanners'] 	= "このユーザーが自分のゾーンへのバナーリンクを許可する";
$GLOBALS['strAllowAffiliateAddZone'] 		= "このユーザーが新規ゾーンを定義することを許可する";
$GLOBALS['strAllowAffiliateDeleteZone'] 	= "このユーザーが既存のゾーンを削除することを許可する";


// Zone
$GLOBALS['strZone']				= "ゾーン";
$GLOBALS['strZones']				= "ゾーン";
$GLOBALS['strAddNewZone']			= "新規ゾーンを追加する";
$GLOBALS['strAddNewZone_Key']			= "新規ゾーンを追加する (<u>n</u>)";
$GLOBALS['strAddZone']				= "ゾーンを作成する";
$GLOBALS['strModifyZone']			= "ゾーンを修正する";
$GLOBALS['strLinkedZones']			= "リンク済ゾーン";
$GLOBALS['strZoneOverview']			= "ゾーンの概要";
$GLOBALS['strZoneProperties']			= "ゾーンのプロパティ";
$GLOBALS['strZoneHistory']			= "ゾーンの履歴";
$GLOBALS['strNoZones']				= "現在定義されているゾーンはありません。";
$GLOBALS['strConfirmDeleteZone']		= "本当にこのゾーンを削除しますか?";
$GLOBALS['strZoneType']				= "ゾーンの種類";
$GLOBALS['strBannerButtonRectangle']		= "Banner, Button or Rectangle";
$GLOBALS['strInterstitial']			= "Interstitial or Floating DHTML";
$GLOBALS['strPopup']				= "ポップアップ";
$GLOBALS['strTextAdZone']			= "テキスト広告";
$GLOBALS['strShowMatchingBanners']		= "一致したバナーを表示する";
$GLOBALS['strHideMatchingBanners']		= "一致したバナーを隠す";


// Advanced zone settings
$GLOBALS['strAdvanced']				= "高度";
$GLOBALS['strChains']				= "チェイン";
$GLOBALS['strChainSettings']			= "チェイン設定";
$GLOBALS['strZoneNoDelivery']			= "If no banners from this zone <br>can be delivered, try to...";
$GLOBALS['strZoneStopDelivery']			= "Stop delivery and don't show a banner";
$GLOBALS['strZoneOtherZone']			= "Display the selected zone instead";
$GLOBALS['strZoneUseKeywords']			= "Select a banner using the keywords entered below";
$GLOBALS['strZoneAppend']			= "Always append the following HTML code to banners displayed by this zone";
$GLOBALS['strAppendSettings']			= "Append and prepend settings";
$GLOBALS['strZonePrependHTML']			= "Always prepend the HTML code to text ads displayed by this zone";
$GLOBALS['strZoneAppendHTML']			= "Always append the HTML code to text ads displayed by this zone";
$GLOBALS['strZoneAppendSelectZone']		= "Always append the following popup or intersitial to banners displayed by this zone";


// Zone probability
$GLOBALS['strZoneProbListChain']		= "All the banners linked to the selected zone are currently not active. <br>This is the zone chain that will be followed:";
$GLOBALS['strZoneProbNullPri']			= "All banners linked to this zone are currently not active.";
$GLOBALS['strZoneProbListChainLoop']	= "Following the zone chain would cause a circular loop. Delivery for this zone is halted.";


// Linked banners/campaigns
$GLOBALS['strSelectZoneType']			= "リンク済バナーの種類を選択してください";
$GLOBALS['strBannerSelection']			= "バナー選択";
$GLOBALS['strCampaignSelection']		= "キャンペーン選択";
$GLOBALS['strInteractive']			= "インタラクティブ";
$GLOBALS['strRawQueryString']			= "キーワード";
$GLOBALS['strIncludedBanners']			= "リンク済バナー";
$GLOBALS['strLinkedBannersOverview']		= "リンク済バナーの概要";
$GLOBALS['strLinkedBannerHistory']		= "リンク済バナーの履歴";
$GLOBALS['strNoZonesToLink']			= "There are no zones available to which this banner can be linked";
$GLOBALS['strNoBannersToLink']			= "There are currently no banners available which can be linked to this zone";
$GLOBALS['strNoLinkedBanners']			= "There are no banners available which are linked to this zone";
$GLOBALS['strMatchingBanners']			= "{count} matching banners";
$GLOBALS['strNoCampaignsToLink']		= "There are currently no campaigns available which can be linked to this zone";
$GLOBALS['strNoZonesToLinkToCampaign']  	= "There are no zones available to which this campaign can be linked";
$GLOBALS['strSelectBannerToLink']		= "Select the banner you would like to link to this zone:";
$GLOBALS['strSelectCampaignToLink']		= "Select the campaign you would like to link to this zone:";


// Append
$GLOBALS['strAppendType']				= "種類の追加";
$GLOBALS['strAppendHTMLCode']			= "HTML コード";
$GLOBALS['strAppendWhat']				= "何を追加したいですか?";
$GLOBALS['strAppendZone']				= "1 つの指定ゾーンを追加する";
$GLOBALS['strAppendErrorZone']			= "You need to select a zone before you \\ncan continue. Otherwise no banners will \\nbe appended.";
$GLOBALS['strAppendBanner']				= "Append one or more individual banners";
$GLOBALS['strAppendErrorBanner']		= "You need to select one or more banners \\nbefore you can continue. Otherwise no \\nbanners will be appended.";
$GLOBALS['strAppendKeyword']			= "キーワードを使用してゾーンを追加する";
$GLOBALS['strAppendErrorKeyword']		= "You need to specify one or more keywords \\nbefore you can continue. Otherwise no \\nbanners will be appended.";


// Statistics
$GLOBALS['strStats'] 				= "統計";
$GLOBALS['strNoStats']				= "現在利用可能な統計はありません。";
$GLOBALS['strConfirmResetStats']		= "本当に既に存在するすべての統計を削除しますか?";
$GLOBALS['strGlobalHistory']			= "全体履歴";
$GLOBALS['strDailyHistory']			= "日間履歴";
$GLOBALS['strDailyStats'] 			= "日間統計";
$GLOBALS['strWeeklyHistory']			= "週間履歴";
$GLOBALS['strMonthlyHistory']			= "月間履歴";
$GLOBALS['strCreditStats'] 			= "クレジット統計";
$GLOBALS['strDetailStats'] 			= "詳細統計";
$GLOBALS['strTotalThisPeriod']			= "この期間の合計";
$GLOBALS['strAverageThisPeriod']		= "この期間の平均";
$GLOBALS['strDistribution']			= "配送";
$GLOBALS['strResetStats'] 			= "統計をリセットする";
$GLOBALS['strSourceStats']			= "ソース統計";
$GLOBALS['strSelectSource']			= "表示したいソースの選択:";
$GLOBALS['strSizeDistribution']		= "サイズで配送";
$GLOBALS['strCountryDistribution']	= "国で配送";
$GLOBALS['strEffectivity']			= "Effectivity";
$GLOBALS['strTargetStats']			= "ターゲット統計";
$GLOBALS['strCampaignTarget']		= "ターゲット";
$GLOBALS['strTargetRatio']			= "ターゲット率";
$GLOBALS['strTargetModifiedDay']	= "Targets were modified during the day, targeting could be not accurate";
$GLOBALS['strTargetModifiedWeek']	= "Targets were modified during the week, targeting could be not accurate";
$GLOBALS['strTargetModifiedMonth']	= "Targets were modified during the month, targeting could be not accurate";
$GLOBALS['strNoTargetStats']		= "There are currently no statistics about targeting available";
$GLOBALS['strCollectedAll']			= "All collected statistics";
$GLOBALS['strCollectedToday']		= "今日のみの統計";
$GLOBALS['strCollected7Days']		= "最終 7 日のみの統計";
$GLOBALS['strCollectedMonth']		= "今月のみの統計";
$GLOBALS['strCollectedLastMonth']	= "先月のみの統計";
$GLOBALS['strCollectedYear']		= "今年のみの統計";
$GLOBALS['strCollectedLastYear']	= "昨年のみの統計";
$GLOBALS['strCollectedYesterday']	= "昨日のみの統計";
$GLOBALS['strCollectedRange']		= "日付の範囲を選択する";


// Hosts
$GLOBALS['strHosts']				= "Hosts";
$GLOBALS['strTopHosts'] 			= "Top requesting hosts";
$GLOBALS['strTopCountries'] 		= "Top requesting countries";
$GLOBALS['strRecentHosts'] 			= "Most recent requesting hosts";


// Expiration
$GLOBALS['strExpired']				= "Expired";
$GLOBALS['strExpiration'] 			= "Expiration";
$GLOBALS['strNoExpiration'] 			= "No expiration date set";
$GLOBALS['strEstimated'] 			= "Estimated expiration";


// Reports
$GLOBALS['strReports']				= "報告書";
$GLOBALS['strSelectReport']			= "生成したい報告書の選択";


// Userlog
$GLOBALS['strUserLog']				= "ユーザーログ";
$GLOBALS['strUserLogDetails']			= "ユーザーログの詳細";
$GLOBALS['strDeleteLog']			= "ログを削除する";
$GLOBALS['strAction']				= "操作";
$GLOBALS['strNoActionsLogged']			= "操作は記録されていません。";


// Code generation
$GLOBALS['strGenerateBannercode']		= "Direct selection";
$GLOBALS['strChooseInvocationType']		= "Please choose the type of banner invocation";
$GLOBALS['strGenerate']				= "生成する";
$GLOBALS['strParameters']			= "パラメーター";
$GLOBALS['strFrameSize']			= "フレームサイズ";
$GLOBALS['strBannercode']			= "バナーコード";
$GLOBALS['strOptional']				= "optional";


// Errors
$GLOBALS['strMySQLError'] 			= "SQL エラー:";
$GLOBALS['strLogErrorClients'] 			= "[phpAds] データベースから広告主を取得しようとしたときにエラーが発生しました。";
$GLOBALS['strLogErrorBanners'] 			= "[phpAds] データベースからバナーを取得しようとしたときにエラーが発生しました。";
$GLOBALS['strLogErrorViews'] 			= "[phpAds] データベースから adviews を取得しようとしたときにエラーが発生しました。";
$GLOBALS['strLogErrorClicks'] 			= "[phpAds] データベースから adclicks を取得しようとしたときにエラーが発生しました。";
$GLOBALS['strErrorViews'] 			= "You must enter the number of views or select the unlimited box !";
$GLOBALS['strErrorNegViews'] 			= "ネガティブビューは許可されていません";
$GLOBALS['strErrorClicks'] 			= "You must enter the number of clicks or select the unlimited box !";
$GLOBALS['strErrorNegClicks'] 			= "ネガティブクリックは許可されていません";
$GLOBALS['strNoMatchesFound']			= "一致するものは見つかりません";
$GLOBALS['strErrorOccurred']			= "エラーが発生しました";
$GLOBALS['strErrorUploadSecurity']		= "セキュリティの問題の可能性を検知したのでアップロードを停止します!";
$GLOBALS['strErrorUploadBasedir']		= "Could not access uploaded file, probably due to safemode or open_basedir restrictions";
$GLOBALS['strErrorUploadUnknown']		= "Could not access uploaded file, due to an unknown reason. Please check your PHP configuration";
$GLOBALS['strErrorStoreLocal']			= "An error occcured while trying to save the banner in the local directory. This is probably the result of a misconfiguration of the local directory path settings";
$GLOBALS['strErrorStoreFTP']			= "An error occcured while trying to upload the banner to the FTP server. This could be because the server is not available, or because of a misconfiguration of the FTP server settings";
$GLOBALS['strErrorDBPlain']				= "データベースにアクセス中にエラーが発生しました。";
$GLOBALS['strErrorDBSerious']			= "A serious problem with the database has been detected";
$GLOBALS['strErrorDBNoDataPlain']		= "Due to a problem with the database ".$phpAds_productname." couldn't retrieve or store data. ";
$GLOBALS['strErrorDBNoDataSerious']		= "Due to a serious problem with the database, ".$phpAds_productname." couldn't retrieve data";
$GLOBALS['strErrorDBCorrupt']			= "The database table is probably corrupt and needs to be repaired. For more information about repairing corrupted tables please read the chapter <i>Troubleshooting</i> of the <i>Administrator guide</i>.";
$GLOBALS['strErrorDBContact']			= "Please contact the administrator of this server and notify him or her of the problem.";
$GLOBALS['strErrorDBSubmitBug']			= "If this problem is reproducable it might be caused by a bug in ".$phpAds_productname.". Please report the following information to the creators of ".$phpAds_productname.". Also try to describe the actions that led to this error as clearly as possible.";
$GLOBALS['strMaintenanceNotActive']		= "The maintenance script has not been run in the last 24 hours. \\nIn order for ".$phpAds_productname." to function correctly it needs to run \\nevery hour. \\n\\nPlease read the Administrator guide for more information \\nabout configuring the maintenance script.";

// E-mail
$GLOBALS['strMailSubject'] 			= "広告主の報告";
$GLOBALS['strAdReportSent']			= "広告主の報告を送信しました";
$GLOBALS['strMailSubjectDeleted'] 		= "Deactivated banners";
$GLOBALS['strMailHeader'] 			= "{contact} さん\n";
$GLOBALS['strMailBannerStats'] 			= "Below you will find the banner statistics for {clientname}:";
$GLOBALS['strMailFooter'] 			= "Regards,\n   {adminfullname}";
$GLOBALS['strMailClientDeactivated'] 		= "The following banners have been disabled because";
$GLOBALS['strMailNothingLeft'] 			= "If you would like to continue advertising on our website, please feel free to contact us.\nWe'd be glad to hear from you.";
$GLOBALS['strClientDeactivated']		= "This campaign is currently not active because";
$GLOBALS['strBeforeActivate']			= "the activation date has not yet been reached";
$GLOBALS['strAfterExpire']			= "the expiration date has been reached";
$GLOBALS['strNoMoreClicks']			= "there are no AdClicks remaining";
$GLOBALS['strNoMoreViews']			= "there are no AdViews remaining";
$GLOBALS['strWeightIsNull']			= "its weight is set to zero";
$GLOBALS['strWarnClientTxt']			= "The AdClicks or AdViews left for your banners are getting below {limit}. \nYour banners will be disabled when there are no AdClicks or AdViews left. ";
$GLOBALS['strViewsClicksLow']			= "AdViews/AdClicks are low";
$GLOBALS['strNoViewLoggedInInterval']   	= "No AdViews were logged during the span of this report";
$GLOBALS['strNoClickLoggedInInterval']  	= "No AdClicks were logged during the span of this report";
$GLOBALS['strMailReportPeriod']			= "This report includes statistics from {startdate} up to {enddate}.";
$GLOBALS['strMailReportPeriodAll']		= "This report includes all statistics up to {enddate}.";
$GLOBALS['strNoStatsForCampaign'] 		= "There are no statistics available for this campaign";


// Priority
$GLOBALS['strPriority']				= "重要度";


// Settings
$GLOBALS['strSettings'] 			= "設定";
$GLOBALS['strGeneralSettings']			= "一般設定";
$GLOBALS['strMainSettings']			= "メイン設定";
$GLOBALS['strAdminSettings']			= "管理設定";


// Product Updates
$GLOBALS['strProductUpdates']			= "プロダクトを更新する";




/*********************************************************/
/* Keyboard shortcut assignments                         */
/*********************************************************/


// Reserved keys
// Do not change these unless absolutely needed
$GLOBALS['keyHome']			= 'h';
$GLOBALS['keyUp']			= 'u';
$GLOBALS['keyNextItem']		= '.';
$GLOBALS['keyPreviousItem']	= ',';
$GLOBALS['keyList']			= 'l';


// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
$GLOBALS['keySearch']		= 's';
$GLOBALS['keyCollapseAll']	= 'c';
$GLOBALS['keyExpandAll']	= 'e';
$GLOBALS['keyAddNew']		= 'n';
$GLOBALS['keyNext']			= 'n';
$GLOBALS['keyPrevious']		= 'p';

?>