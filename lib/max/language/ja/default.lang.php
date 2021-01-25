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

// Set text direction and characterset
$GLOBALS['phpAds_TextDirection'] = "ltr";
$GLOBALS['phpAds_TextAlignRight'] = "right";
$GLOBALS['phpAds_TextAlignLeft'] = "left";
$GLOBALS['phpAds_CharSet'] = "UTF-8";

$GLOBALS['phpAds_DecimalPoint'] = ".";
$GLOBALS['phpAds_ThousandsSeperator'] = ",";

// Date & time configuration
$GLOBALS['date_format'] = "%Y年%m月%d日";
$GLOBALS['time_format'] = "%H:%M:%S";
$GLOBALS['minute_format'] = "%H:%M";
$GLOBALS['month_format'] = "%Y年%m月";
$GLOBALS['day_format'] = "%m月%d日";
$GLOBALS['week_format'] = "%Y年%W週";
$GLOBALS['weekiso_format'] = "%G年%V週";

// Formats used by PEAR Spreadsheet_Excel_Writer packate
$GLOBALS['excel_integer_formatting'] = "#,##0;-#,##0;-";
$GLOBALS['excel_decimal_formatting'] = "#,##0.000;-#,##0.000;-";

/* ------------------------------------------------------- */
/* Translations                                          */
/* ------------------------------------------------------- */

$GLOBALS['strHome'] = "ホーム";
$GLOBALS['strHelp'] = "ヘルプ";
$GLOBALS['strStartOver'] = "やり直し";
$GLOBALS['strShortcuts'] = "ショートカット";
$GLOBALS['strActions'] = "アクション";
$GLOBALS['strAndXMore'] = "and %s more";
$GLOBALS['strAdminstration'] = "インベントリ";
$GLOBALS['strMaintenance'] = "メンテナンス";
$GLOBALS['strProbability'] = "配信ウェイト";
$GLOBALS['strInvocationcode'] = "広告表示コードの生成";
$GLOBALS['strBasicInformation'] = "基本情報";
$GLOBALS['strAppendTrackerCode'] = "トラッカーコード追加";
$GLOBALS['strOverview'] = "概要";
$GLOBALS['strSearch'] = "検索(<u>S</u>)";
$GLOBALS['strDetails'] = "詳細";
$GLOBALS['strUpdateSettings'] = "Update Settings";
$GLOBALS['strCheckForUpdates'] = "更新のチェック";
$GLOBALS['strWhenCheckingForUpdates'] = "When checking for updates";
$GLOBALS['strCompact'] = "コンパクト形式";
$GLOBALS['strUser'] = "ユーザ";
$GLOBALS['strDuplicate'] = "複製する";
$GLOBALS['strCopyOf'] = "Copy of";
$GLOBALS['strMoveTo'] = "移動する";
$GLOBALS['strDelete'] = "削除";
$GLOBALS['strActivate'] = "アクティブにする";
$GLOBALS['strConvert'] = "変換する";
$GLOBALS['strRefresh'] = "リフレッシュする";
$GLOBALS['strSaveChanges'] = "変更の保存";
$GLOBALS['strUp'] = "上へ";
$GLOBALS['strDown'] = "下へ";
$GLOBALS['strSave'] = "保存";
$GLOBALS['strCancel'] = "取消";
$GLOBALS['strBack'] = "戻る";
$GLOBALS['strPrevious'] = "前へ";
$GLOBALS['strNext'] = "次へ";
$GLOBALS['strYes'] = "はい";
$GLOBALS['strNo'] = "いいえ";
$GLOBALS['strNone'] = "なし";
$GLOBALS['strCustom'] = "カスタム";
$GLOBALS['strDefault'] = "デフォルト";
$GLOBALS['strUnknown'] = "不明";
$GLOBALS['strUnlimited'] = "無制限";
$GLOBALS['strUntitled'] = "名称未設定";
$GLOBALS['strAll'] = "all";
$GLOBALS['strAverage'] = "平均";
$GLOBALS['strOverall'] = "全般";
$GLOBALS['strTotal'] = "合計";
$GLOBALS['strFrom'] = "開始";
$GLOBALS['strTo'] = "終了";
$GLOBALS['strAdd'] = "追加";
$GLOBALS['strLinkedTo'] = "リンク先";
$GLOBALS['strDaysLeft'] = "残日数";
$GLOBALS['strCheckAllNone'] = "すべてチェックする/しない";
$GLOBALS['strKiloByte'] = "KB";
$GLOBALS['strExpandAll'] = "すべて展開 (<u>E</u>)";
$GLOBALS['strCollapseAll'] = "すべて閉じる(<u>C</u>)";
$GLOBALS['strShowAll'] = "すべて表示";
$GLOBALS['strNoAdminInterface'] = "メンテナンスのため、管理画面機能が無効になっています。広告の配信には何ら影響はありません。";
$GLOBALS['strFieldStartDateBeforeEnd'] = "\\'開始日'は、'終了日'以前の日付である必要があります";
$GLOBALS['strFieldContainsErrors'] = "エラー項目は次のとおりです:";
$GLOBALS['strFieldFixBeforeContinue1'] = "継続するには、表示されている";
$GLOBALS['strFieldFixBeforeContinue2'] = "エラー項目を訂正してください。";
$GLOBALS['strMiscellaneous'] = "その他";
$GLOBALS['strCollectedAllStats'] = "すべての統計";
$GLOBALS['strCollectedToday'] = "本日の統計";
$GLOBALS['strCollectedYesterday'] = "昨日の統計";
$GLOBALS['strCollectedThisWeek'] = "今週の統計";
$GLOBALS['strCollectedLastWeek'] = "先週の統計";
$GLOBALS['strCollectedThisMonth'] = "今月の統計";
$GLOBALS['strCollectedLastMonth'] = "先月の統計";
$GLOBALS['strCollectedLast7Days'] = "過去７日間の統計";
$GLOBALS['strCollectedSpecificDates'] = "範囲指定";
$GLOBALS['strValue'] = "数値";
$GLOBALS['strWarning'] = "警告";
$GLOBALS['strNotice'] = "お知らせ";

// Dashboard
$GLOBALS['strDashboardCantBeDisplayed'] = "The dashboard can not be displayed";
$GLOBALS['strNoCheckForUpdates'] = "The dashboard cannot be displayed unless the<br />check for updates setting is enabled.";
$GLOBALS['strEnableCheckForUpdates'] = "Please enable the <a href='account-settings-update.php' target='_top'>check for updates</a> setting on the<br/><a href='account-settings-update.php' target='_top'>update settings</a> page.";
// Dashboard Errors
$GLOBALS['strDashboardErrorCode'] = "エラーコード";
$GLOBALS['strDashboardSystemMessage'] = "システムメッセージ";
$GLOBALS['strDashboardErrorHelp'] = "このエラーが繰り返し発生する場合、問題の詳細を<a href='http://forum.openx.org/'>OpenXフォーラム</a>に投稿してください。";

// Priority
$GLOBALS['strPriority'] = "優先度";
$GLOBALS['strPriorityLevel'] = "優先度レベル";
$GLOBALS['strOverrideAds'] = "Override Campaign Advertisements";
$GLOBALS['strHighAds'] = "高優先広告";
$GLOBALS['strECPMAds'] = "eCPM Campaign Advertisements";
$GLOBALS['strLowAds'] = "低優先広告";
$GLOBALS['strLimitations'] = "Delivery rules";
$GLOBALS['strNoLimitations'] = "No delivery rules";
$GLOBALS['strCapping'] = "制限";

// Properties
$GLOBALS['strName'] = "名称";
$GLOBALS['strSize'] = "サイズ";
$GLOBALS['strWidth'] = "幅";
$GLOBALS['strHeight'] = "高さ";
$GLOBALS['strTarget'] = "ターゲット（空欄可/_top/_blank）";
$GLOBALS['strLanguage'] = "言語";
$GLOBALS['strDescription'] = "記事";
$GLOBALS['strVariables'] = "変数";
$GLOBALS['strID'] = "ID";
$GLOBALS['strComments'] = "コメント";

// User access
$GLOBALS['strWorkingAs'] = "以下の通り動作します";
$GLOBALS['strWorkingAs_Key'] = "<u>W</u>orking as";
$GLOBALS['strWorkingAs'] = "以下の通り動作します";
$GLOBALS['strSwitchTo'] = "動作モード変更";
$GLOBALS['strUseSearchBoxToFindMoreAccounts'] = "Use the switcher's search box to find more accounts";
$GLOBALS['strWorkingFor'] = "%s とは...";
$GLOBALS['strNoAccountWithXInNameFound'] = "No accounts with \"%s\" in name found";
$GLOBALS['strRecentlyUsed'] = "Recently used";
$GLOBALS['strLinkUser'] = "ユーザを追加";
$GLOBALS['strLinkUser_Key'] = "ユーザを追加する(<u>u</u>)";
$GLOBALS['strUsernameToLink'] = "追加するユーザの氏名";
$GLOBALS['strNewUserWillBeCreated'] = "新しいユーザを作成します";
$GLOBALS['strToLinkProvideEmail'] = "ユーザを追加するには、メールアドレスを入力してください。";
$GLOBALS['strToLinkProvideUsername'] = "ユーザを追加するには、ユーザ名を入力してください";
$GLOBALS['strUserLinkedToAccount'] = "ユーザがアカウントに追加されました。";
$GLOBALS['strUserAccountUpdated'] = "更新したユーザアカウント";
$GLOBALS['strUserUnlinkedFromAccount'] = "ユーザがアカウントから削除されました。";
$GLOBALS['strUserWasDeleted'] = "ユーザが削除されました。";
$GLOBALS['strUserNotLinkedWithAccount'] = "そのユーザはアカウントに関連づいていません";
$GLOBALS['strCantDeleteOneAdminUser'] = "ユーザを削除できません。少なくとも一人が管理者である必要があります。";
$GLOBALS['strLinkUserHelp'] = "To add an <b>existing user</b>, type the %1\$s and click %2\$s <br />To add a <b>new user</b>, type the desired %1\$s and click %2\$s";
$GLOBALS['strLinkUserHelpUser'] = "ユーザ名";
$GLOBALS['strLinkUserHelpEmail'] = "Eメールアドレス";
$GLOBALS['strLastLoggedIn'] = "最終ログイン";
$GLOBALS['strDateLinked'] = "リンクされた日付";

// Login & Permissions
$GLOBALS['strUserAccess'] = "ユーザアクセス";
$GLOBALS['strAdminAccess'] = "管理者アクセス";
$GLOBALS['strUserProperties'] = "ユーザプリファレンス";
$GLOBALS['strPermissions'] = "ユーザ権限";
$GLOBALS['strAuthentification'] = "ユーザ認証";
$GLOBALS['strWelcomeTo'] = "ようこそ！";
$GLOBALS['strEnterUsername'] = "ユーザー名とパスワードを入力してログインしてください。";
$GLOBALS['strEnterBoth'] = "ユーザー名とパスワードの両方を入力してください";
$GLOBALS['strEnableCookies'] = "You need to enable cookies before you can use {$PRODUCT_NAME}";
$GLOBALS['strSessionIDNotMatch'] = "セッションエラーが発生しましｓた。再度ログインしてください";
$GLOBALS['strLogin'] = "ログイン";
$GLOBALS['strLogout'] = "ログアウト";
$GLOBALS['strUsername'] = "ユーザー名";
$GLOBALS['strPassword'] = "パスワード";
$GLOBALS['strPasswordRepeat'] = "パスワードの再確認";
$GLOBALS['strAccessDenied'] = "アクセスが拒否されました。";
$GLOBALS['strUsernameOrPasswordWrong'] = "ユーザ名かパスワードが間違っています。再入力してください。";
$GLOBALS['strPasswordWrong'] = "パスワードが正しくありません。";
$GLOBALS['strNotAdmin'] = "この操作を行う権限がありません。適切な権限を有するユーザ名で再度ログインしてください。ログアウトは、<a href='logout.php'>こちら</a>。";
$GLOBALS['strDuplicateClientName'] = "入力されたユーザー名は既に存在します。異なるユーザー名を使用してください。";
$GLOBALS['strInvalidPassword'] = "新しいパスワードは無効です。異なるパスワードを使用してください。";
$GLOBALS['strInvalidEmail'] = "入力されたメールアドレスは、正しい形式ではありません。正しい形式で再度入力してください。";
$GLOBALS['strNotSamePasswords'] = "入力された２つのパスワードは同じではありません。";
$GLOBALS['strRepeatPassword'] = "パスワード(再度)";
$GLOBALS['strDeadLink'] = "不正なリンクです。";
$GLOBALS['strNoPlacement'] = "指定されたキャンペーンは存在しません。<a href='{link}'>こちらのリンク</a>を代わりに使って下さい。";
$GLOBALS['strNoAdvertiser'] = "指定された広告主は存在しません。<a href='{link}'>こちらのリンク</a>を代わりに使って下さい。";

// General advertising
$GLOBALS['strRequests'] = "リクエスト数";
$GLOBALS['strImpressions'] = "インプレッション数";
$GLOBALS['strClicks'] = "クリック数";
$GLOBALS['strConversions'] = "コンバージョン数";
$GLOBALS['strCTRShort'] = "CTR";
$GLOBALS['strCNVRShort'] = "SR";
$GLOBALS['strCTR'] = "CTR";
$GLOBALS['strTotalClicks'] = "総クリック数";
$GLOBALS['strTotalConversions'] = "総コンバージョン数";
$GLOBALS['strDateTime'] = "日時";
$GLOBALS['strTrackerID'] = "トラッカーID";
$GLOBALS['strTrackerName'] = "トラッカー名";
$GLOBALS['strTrackerImageTag'] = "イメージタグ";
$GLOBALS['strTrackerJsTag'] = "JavaScriptタグ";
$GLOBALS['strTrackerAlwaysAppend'] = "Always display appended code, even if no conversion is recorded by the tracker?";
$GLOBALS['strBanners'] = "バナー";
$GLOBALS['strCampaigns'] = "キャンペーン";
$GLOBALS['strCampaignID'] = "キャンペーンID";
$GLOBALS['strCampaignName'] = "キャンペーン名";
$GLOBALS['strCountry'] = "国";
$GLOBALS['strStatsAction'] = "アクション";
$GLOBALS['strWindowDelay'] = "遅延ウィンドウ";
$GLOBALS['strStatsVariables'] = "変数";

// Finance
$GLOBALS['strFinanceCPM'] = "CPM";
$GLOBALS['strFinanceCPC'] = "CPC";
$GLOBALS['strFinanceCPA'] = "CPA";
$GLOBALS['strFinanceMT'] = "月間賃借料";
$GLOBALS['strFinanceCTR'] = "CTR";
$GLOBALS['strFinanceCR'] = "CR";

// Time and date related
$GLOBALS['strDate'] = "日付";
$GLOBALS['strDay'] = "日";
$GLOBALS['strDays'] = "日間";
$GLOBALS['strWeek'] = "週";
$GLOBALS['strWeeks'] = "週";
$GLOBALS['strSingleMonth'] = "月";
$GLOBALS['strMonths'] = "月";
$GLOBALS['strDayOfWeek'] = "曜日";


if (!isset($GLOBALS['strDayFullNames'])) {
    $GLOBALS['strDayFullNames'] = array();
}
$GLOBALS['strDayFullNames'][0] = 'Sunday';
$GLOBALS['strDayFullNames'][1] = 'Monday';
$GLOBALS['strDayFullNames'][2] = 'Tuesday';
$GLOBALS['strDayFullNames'][3] = 'Wednesday';
$GLOBALS['strDayFullNames'][4] = 'Thursday';
$GLOBALS['strDayFullNames'][5] = 'Friday';
$GLOBALS['strDayFullNames'][6] = 'Saturday';

if (!isset($GLOBALS['strDayShortCuts'])) {
    $GLOBALS['strDayShortCuts'] = array();
}
$GLOBALS['strDayShortCuts'][0] = 'Su';
$GLOBALS['strDayShortCuts'][1] = 'Mo';
$GLOBALS['strDayShortCuts'][2] = 'Tu';
$GLOBALS['strDayShortCuts'][3] = 'We';
$GLOBALS['strDayShortCuts'][4] = 'Th';
$GLOBALS['strDayShortCuts'][5] = 'Fr';
$GLOBALS['strDayShortCuts'][6] = 'Sa';

$GLOBALS['strHour'] = "時";
$GLOBALS['strSeconds'] = "秒間";
$GLOBALS['strMinutes'] = "分間";
$GLOBALS['strHours'] = "時間";

// Advertiser
$GLOBALS['strClient'] = "広告主";
$GLOBALS['strClients'] = "広告主";
$GLOBALS['strClientsAndCampaigns'] = "広告主＆キャンペーン";
$GLOBALS['strAddClient'] = "広告主の追加";
$GLOBALS['strClientProperties'] = "広告主の詳細";
$GLOBALS['strClientHistory'] = "Advertiser Statistics";
$GLOBALS['strNoClients'] = "広告主が存在しません。キャンペーンを作成するためには、先に<a href='advertiser-edit.php'>広告主の作成</a>をして下さい。";
$GLOBALS['strConfirmDeleteClient'] = "この広告主を本当に削除しますか？";
$GLOBALS['strConfirmDeleteClients'] = "この広告主を本当に削除しますか？";
$GLOBALS['strHideInactive'] = "非アクティブなものを隠す";
$GLOBALS['strInactiveAdvertisersHidden'] = "件の非アクティブな広告主を隠しています";
$GLOBALS['strAdvertiserSignup'] = "広告主サインアップ";
$GLOBALS['strAdvertiserCampaigns'] = "広告主＆キャンペーン";

// Advertisers properties
$GLOBALS['strContact'] = "担当者名";
$GLOBALS['strContactName'] = "コンタクト名";
$GLOBALS['strEMail'] = "メールアドレス";
$GLOBALS['strSendAdvertisingReport'] = "キャンペーン配信結果を電子メールで送信する";
$GLOBALS['strNoDaysBetweenReports'] = "レポートの送信間隔（日）";
$GLOBALS['strSendDeactivationWarning'] = "キャンペーンがアクティブでなくなった時に警告メールを送信する";
$GLOBALS['strAllowClientModifyBanner'] = "このユーザによるバナー修正を許可する";
$GLOBALS['strAllowClientDisableBanner'] = "このユーザによるバナーの非アクティブ化を許可する";
$GLOBALS['strAllowClientActivateBanner'] = "このユーザによるバナーのアクティブ化を許可する";
$GLOBALS['strAllowCreateAccounts'] = "Allow this user to manage this account's users";
$GLOBALS['strAdvertiserLimitation'] = "この広告主のバナーだけをウェブページに表示する";
$GLOBALS['strAllowAuditTrailAccess'] = "このユーザに監査証跡の閲覧権限を与える";
$GLOBALS['strAllowDeleteItems'] = "Allow this user to delete items";

// Campaign
$GLOBALS['strCampaign'] = "キャンペーン";
$GLOBALS['strCampaigns'] = "キャンペーン";
$GLOBALS['strAddCampaign'] = "キャンペーンの追加";
$GLOBALS['strAddCampaign_Key'] = "キャンペーンの追加 (<u>n</u>)";
$GLOBALS['strCampaignForAdvertiser'] = "for advertiser";
$GLOBALS['strLinkedCampaigns'] = "リンク済キャンペーン";
$GLOBALS['strCampaignProperties'] = "キャンペーン詳細";
$GLOBALS['strCampaignOverview'] = "キャンペーン概要";
$GLOBALS['strCampaignHistory'] = "Campaign Statistics";
$GLOBALS['strNoCampaigns'] = "キャンペーンが定義されていません";
$GLOBALS['strNoCampaignsAddAdvertiser'] = "There are currently no campaigns defined, because there are no advertisers. To create a campaign, <a href='advertiser-edit.php'>add a new advertiser</a> first.";
$GLOBALS['strConfirmDeleteCampaign'] = "このキャンペーンを本当に削除しますか？";
$GLOBALS['strConfirmDeleteCampaigns'] = "このキャンペーンを本当に削除しますか？";
$GLOBALS['strShowParentAdvertisers'] = "親キャンペーンの表示";
$GLOBALS['strHideParentAdvertisers'] = "親キャンペーンの非表示";
$GLOBALS['strHideInactiveCampaigns'] = "非アクティブなキャンペーンを隠す";
$GLOBALS['strInactiveCampaignsHidden'] = "件の非アクティブなキャンペーンを隠しています。";
$GLOBALS['strPriorityInformation'] = "他のキャンペーンに対する優先度";
$GLOBALS['strECPMInformation'] = "eCPM prioritization";
$GLOBALS['strRemnantEcpmDescription'] = "eCPM is automatically calculated based on this campaign's performance.<br />It will be used to prioritise Remnant campaigns relative to each other.";
$GLOBALS['strEcpmMinImpsDescription'] = "Set this to your desired minium basis on which to calculate this campaign's eCPM.";
$GLOBALS['strHiddenCampaign'] = "キャンペーン";
$GLOBALS['strHiddenAd'] = "広告";
$GLOBALS['strHiddenAdvertiser'] = "広告主";
$GLOBALS['strHiddenTracker'] = "トラッカー";
$GLOBALS['strHiddenWebsite'] = "Webサイト";
$GLOBALS['strHiddenZone'] = "ゾーン";
$GLOBALS['strCampaignDelivery'] = "キャンペーンの配信";
$GLOBALS['strCompanionPositioning'] = "キャンペーンランキング";
$GLOBALS['strSelectUnselectAll'] = "すべて選択する/解除する";
$GLOBALS['strCampaignsOfAdvertiser'] = "of"; //this is added between page name and advertiser name eg. 'Campaigns of Advertiser 1'
$GLOBALS['strShowCappedNoCookie'] = "Show capped ads if cookies are disabled";

// Campaign-zone linking page
$GLOBALS['strCalculatedForAllCampaigns'] = "Calculated for all campaigns";
$GLOBALS['strCalculatedForThisCampaign'] = "Calculated for this campaign";
$GLOBALS['strLinkingZonesProblem'] = "Problem occurred when linking zones";
$GLOBALS['strUnlinkingZonesProblem'] = "Problem occurred when unlinking zones";
$GLOBALS['strZonesLinked'] = "zone(s) linked";
$GLOBALS['strZonesUnlinked'] = "zone(s) unlinked";
$GLOBALS['strZonesSearch'] = "Search";
$GLOBALS['strZonesSearchTitle'] = "Search zones and websites by name";
$GLOBALS['strNoWebsitesAndZones'] = "No websites and zones";
$GLOBALS['strNoWebsitesAndZonesText'] = "with \"%s\" in name";
$GLOBALS['strToLink'] = "to link";
$GLOBALS['strToUnlink'] = "to unlink";
$GLOBALS['strLinked'] = "Linked";
$GLOBALS['strAvailable'] = "Available";
$GLOBALS['strShowing'] = "Showing";
$GLOBALS['strEditZone'] = "Edit zone";
$GLOBALS['strEditWebsite'] = "Edit website";


// Campaign properties
$GLOBALS['strDontExpire'] = "このキャンペーンの終了日を指定しない";
$GLOBALS['strActivateNow'] = "このキャンペーンを今すぐアクティブにする";
$GLOBALS['strSetSpecificDate'] = "Set specific date";
$GLOBALS['strLow'] = "低";
$GLOBALS['strHigh'] = "高";
$GLOBALS['strExpirationDate'] = "終了日";
$GLOBALS['strExpirationDateComment'] = "キャンペーンはこの指定日に終了します。";
$GLOBALS['strActivationDate'] = "開始日";
$GLOBALS['strActivationDateComment'] = "キャンペーンはこの指定日に開始します。";
$GLOBALS['strImpressionsRemaining'] = "残インプレッション数";
$GLOBALS['strClicksRemaining'] = "残クリック数";
$GLOBALS['strConversionsRemaining'] = "残コンバージョン数";
$GLOBALS['strImpressionsBooked'] = "インプレッション数";
$GLOBALS['strClicksBooked'] = "クリック数";
$GLOBALS['strConversionsBooked'] = "コンバージョン数";
$GLOBALS['strCampaignWeight'] = "キャンペーンウェイトの設定：";
$GLOBALS['strAnonymous'] = "このキャンペーンに関連する広告主とWebサイトを隠す。";
$GLOBALS['strTargetPerDay'] = "／日";
$GLOBALS['strCampaignWarningRemnantNoWeight'] = "The type of this campaign has been set to Remnant,
but the weight is set to zero or it has not been
specified. This will cause the campaign to be
deactivated and its banners won't be delivered
until the weight has been set to a valid number.

Are you sure you want to continue?";
$GLOBALS['strCampaignWarningEcpmNoRevenue'] = "This campaign uses eCPM optimisation
but the 'revenue' is set to zero or it has not been specified.
This will cause the campaign to be deactivated
and its banners won't be delivered until the
revenue has been set to a valid number.

Are you sure you want to continue?";
$GLOBALS['strCampaignWarningOverrideNoWeight'] = "The type of this campaign has been set to Override,
but the weight is set to zero or it has not been
specified. This will cause the campaign to be
deactivated and its banners won't be delivered
until the weight has been set to a valid number.

Are you sure you want to continue?";
$GLOBALS['strCampaignWarningNoTarget'] = "The type of this campaign has been set to Contract,
but Limit per day is not specified.
This will cause the campaign to be deactivated and
its banners won't be delivered until a valid Limit per day has been set.

Are you sure you want to continue?";
$GLOBALS['strCampaignStatusPending'] = "保留";
$GLOBALS['strCampaignStatusInactive'] = "アクティブ";
$GLOBALS['strCampaignStatusRunning'] = "配信中";
$GLOBALS['strCampaignStatusPaused'] = "中断中";
$GLOBALS['strCampaignStatusAwaiting'] = "待機中";
$GLOBALS['strCampaignStatusExpired'] = "終了";
$GLOBALS['strCampaignStatusApproval'] = "承認待ち &raquo;";
$GLOBALS['strCampaignStatusRejected'] = "拒否";
$GLOBALS['strCampaignStatusAdded'] = "追加済";
$GLOBALS['strCampaignStatusStarted'] = "開始済";
$GLOBALS['strCampaignStatusRestarted'] = "再開済";
$GLOBALS['strCampaignStatusDeleted'] = "削除";
$GLOBALS['strCampaignType'] = "キャンペーン名";
$GLOBALS['strType'] = "Type";
$GLOBALS['strContract'] = "担当者名";
$GLOBALS['strOverride'] = "Override";
$GLOBALS['strOverrideInfo'] = "Override campaigns are a special campaign type specifically to
    override (i.e. take priority over) Remnant and Contract campaigns. Override campaigns are generally used with
    specific targeting and/or capping rules to ensure that the campaign banners are always displayed in certain
    locations, to certain users, and perhaps a certain number of times, as part of a specific promotion. (This campaign
    type was previously known as 'Contract (Exclusive)'.)";
$GLOBALS['strStandardContract'] = "担当者名";
$GLOBALS['strStandardContractInfo'] = "Contract campaigns are for smoothly delivering the impressions
    required to achieve a specified time-critical performance requirement. That is, Contract campaigns are for when
    an advertiser has paid specifically to have a given number of impressions, clicks and/or conversions to be
    achieved either between two dates, or per day.";
$GLOBALS['strRemnant'] = "Remnant";
$GLOBALS['strRemnantInfo'] = "The default campaign type. Remnant campaigns have lots of different
    delivery options, and you should ideally always have at least one Remnant campaign linked to every zone, to ensure
    that there is always something to show. Use Remnant campaigns to display house banners, ad-network banners, or even
    direct advertising that has been sold, but where there is not a time-critical performance requirement for the
    campaign to adhere to.";
$GLOBALS['strECPMInfo'] = "This is a standard campaign which can be constrained with either an end date or a specific limit. Based on current settings it will be prioritised using eCPM.";
$GLOBALS['strPricing'] = "Pricing";
$GLOBALS['strPricingModel'] = "Pricing model";
$GLOBALS['strSelectPricingModel'] = "-- select model --";
$GLOBALS['strRatePrice'] = "Rate / Price";
$GLOBALS['strMinimumImpressions'] = "Minimum daily impressions";
$GLOBALS['strLimit'] = "Limit";
$GLOBALS['strLowExclusiveDisabled'] = "You cannot change this campaign to Remnant or Exclusive, since both an end date and either of impressions/clicks/conversions limit are set. <br>In order to change type, you need to set no expiry date or remove limits.";
$GLOBALS['strCannotSetBothDateAndLimit'] = "You cannot set both an end date and limit for a Remnant or Exclusive campaign.<br>If you need to set both an end date and limit impressions/clicks/conversions please use a non-exclusive Contract campaign.";
$GLOBALS['strWhyDisabled'] = "why is it disabled?";
$GLOBALS['strBackToCampaigns'] = "Back to campaigns";
$GLOBALS['strCampaignBanners'] = "Campaign's banners";
$GLOBALS['strCookies'] = "Cookies";

// Tracker
$GLOBALS['strTracker'] = "トラッカー";
$GLOBALS['strTrackers'] = "トラッカー";
$GLOBALS['strTrackerPreferences'] = "トラッカープリファレンス";
$GLOBALS['strAddTracker'] = "トラッカーの追加";
$GLOBALS['strTrackerForAdvertiser'] = "for advertiser";
$GLOBALS['strNoTrackers'] = "トラッカーは1件も定義されていません";
$GLOBALS['strConfirmDeleteTrackers'] = "このトラッカーを本当に削除しますか？";
$GLOBALS['strConfirmDeleteTracker'] = "このトラッカーを本当に削除しますか？";
$GLOBALS['strTrackerProperties'] = "トラッカーの詳細";
$GLOBALS['strDefaultStatus'] = "デフォルトステータス";
$GLOBALS['strStatus'] = "ステータス";
$GLOBALS['strLinkedTrackers'] = "リンク済トラッカー";
$GLOBALS['strTrackerInformation'] = "Tracker Information";
$GLOBALS['strConversionWindow'] = "コンバージョン ウィンドウ";
$GLOBALS['strUniqueWindow'] = "ユニーク ウィンドウ";
$GLOBALS['strClick'] = "クリック";
$GLOBALS['strView'] = "ビュー";
$GLOBALS['strArrival'] = "Arrival";
$GLOBALS['strManual'] = "Manual";
$GLOBALS['strImpression'] = "Impression";
$GLOBALS['strConversionType'] = "コンバージョンタイプ";
$GLOBALS['strLinkCampaignsByDefault'] = "デフォルトで新規キャンペーンにリンクする";
$GLOBALS['strBackToTrackers'] = "Back to trackers";
$GLOBALS['strIPAddress'] = "IP Address";

// Banners (General)
$GLOBALS['strBanner'] = "バナー";
$GLOBALS['strBanners'] = "バナー";
$GLOBALS['strAddBanner'] = "バナーの追加";
$GLOBALS['strAddBanner_Key'] = "バナーの追加 (<u>n</u>)";
$GLOBALS['strBannerToCampaign'] = "対象キャンペーン";
$GLOBALS['strShowBanner'] = "バナーの表示";
$GLOBALS['strBannerProperties'] = "バナーの詳細";
$GLOBALS['strBannerHistory'] = "Banner Statistics";
$GLOBALS['strNoBanners'] = "バナーは1件も定義されていません";
$GLOBALS['strNoBannersAddCampaign'] = "Webサイトが存在しません。広告枠を作成する前に、先に<a href='affiliate-edit.php'>Webサイトを作成</a>して下さい。";
$GLOBALS['strNoBannersAddAdvertiser'] = "Webサイトが存在しません。広告枠を作成する前に、先に<a href='affiliate-edit.php'>Webサイトを作成</a>して下さい。";
$GLOBALS['strConfirmDeleteBanner'] = "このバナーを本当に削除しますか?";
$GLOBALS['strConfirmDeleteBanners'] = "このバナーを本当に削除しますか?";
$GLOBALS['strShowParentCampaigns'] = "親キャンペーンを表示";
$GLOBALS['strHideParentCampaigns'] = "親キャンペーンを隠す";
$GLOBALS['strHideInactiveBanners'] = "非アクティブなバナーを隠す";
$GLOBALS['strInactiveBannersHidden'] = "件の非アクティブなバナーを隠しています";
$GLOBALS['strWarningMissing'] = "警告:";
$GLOBALS['strWarningMissingClosing'] = "閉じタグ \\\">\\\"がありません";
$GLOBALS['strWarningMissingOpening'] = "開始タグ \\\"<\\\"がありません";
$GLOBALS['strSubmitAnyway'] = "送信する";
$GLOBALS['strBannersOfCampaign'] = "内の"; //this is added between page name and campaign name eg. 'Banners in coca cola campaign'

// Banner Preferences
$GLOBALS['strBannerPreferences'] = "バナー設定";
$GLOBALS['strCampaignPreferences'] = "Campaign Preferences";
$GLOBALS['strDefaultBanners'] = "デフォルトバナー";
$GLOBALS['strDefaultBannerUrl'] = "デフォルト画像URL";
$GLOBALS['strDefaultBannerDestination'] = "デフォルト転送先URL";
$GLOBALS['strAllowedBannerTypes'] = "許可されたバナータイプ";
$GLOBALS['strTypeSqlAllow'] = "バナーをデータベースに保存する";
$GLOBALS['strTypeWebAllow'] = "バナーをサーバに保存する";
$GLOBALS['strTypeUrlAllow'] = "外部バナーを許可する";
$GLOBALS['strTypeHtmlAllow'] = "HTMLバナーを許可する";
$GLOBALS['strTypeTxtAllow'] = "テキストバナーを許可する";

// Banner (Properties)
$GLOBALS['strChooseBanner'] = "バナー種別を選択してください";
$GLOBALS['strMySQLBanner'] = "ローカルバナー (SQL)";
$GLOBALS['strWebBanner'] = "ローカルバナー (ウェブサーバー)";
$GLOBALS['strURLBanner'] = "外部バナー";
$GLOBALS['strHTMLBanner'] = "HTMLバナー";
$GLOBALS['strTextBanner'] = "テキスト広告";
$GLOBALS['strAlterHTML'] = "Alter HTML to enable click tracking for:";
$GLOBALS['strIframeFriendly'] = "This banner can be safely displayed inside an iframe (e.g. is not expandable)";
$GLOBALS['strUploadOrKeep'] = "既存の画像を活用しますか？<br />別な画像をアップロードしますか？";
$GLOBALS['strNewBannerFile'] = "このバナーに割り当てたい<br />画像を選択してください。<br />リッチメディア画像は選択できませｎ。<br /><br />";
$GLOBALS['strNewBannerFileAlt'] = "このバナーに割り当てたい<br />画像を選択してください。<br />リッチメディア画像は選択できませｎ。<br /><br />";
$GLOBALS['strNewBannerURL'] = "画像URL (http://を含む)";
$GLOBALS['strURL'] = "ターゲットURL (http://を含む)";
$GLOBALS['strKeyword'] = "キーワード";
$GLOBALS['strTextBelow'] = "バナー直下のテキスト表示";
$GLOBALS['strWeight'] = "ウェイト";
$GLOBALS['strAlt'] = "代替テキスト(マウスオーバ時)";
$GLOBALS['strStatusText'] = "ブラウザステータス表示（マウスオーバ時）";
$GLOBALS['strCampaignsWeight'] = "Campaign's Weight";
$GLOBALS['strBannerWeight'] = "バナーウェイト";
$GLOBALS['strBannersWeight'] = "Banner's Weight";
$GLOBALS['strAdserverTypeGeneric'] = "汎用HTMLバナー";
$GLOBALS['strDoNotAlterHtml'] = "Do not alter HTML";
$GLOBALS['strGenericOutputAdServer'] = "汎用Adserver";
$GLOBALS['strBackToBanners'] = "Back to banners";
$GLOBALS['strUseWyswygHtmlEditor'] = "Use WYSIWYG HTML Editor";
$GLOBALS['strChangeDefault'] = "Change default";

// Banner (advanced)
$GLOBALS['strBannerPrependHTML'] = "Always prepend the following HTML code to this banner";
$GLOBALS['strBannerAppendHTML'] = "Always append the following HTML code to this banner";

// Display Delviery Rules
$GLOBALS['strModifyBannerAcl'] = "配信オプション";
$GLOBALS['strACL'] = "配信オプション";
$GLOBALS['strACLAdd'] = "Add delivery rule";
$GLOBALS['strApplyLimitationsTo'] = "Apply delivery rules to";
$GLOBALS['strAllBannersInCampaign'] = "All banners in this campaign";
$GLOBALS['strRemoveAllLimitations'] = "Remove all delivery rules";
$GLOBALS['strEqualTo'] = "一致する";
$GLOBALS['strDifferentFrom'] = "一致しない";
$GLOBALS['strLaterThan'] = "is later than";
$GLOBALS['strLaterThanOrEqual'] = "is later than or equal to";
$GLOBALS['strEarlierThan'] = "is earlier than";
$GLOBALS['strEarlierThanOrEqual'] = "is earlier than or equal to";
$GLOBALS['strContains'] = "contains";
$GLOBALS['strNotContains'] = "doesn't contain";
$GLOBALS['strGreaterThan'] = "以下よりも大きい";
$GLOBALS['strLessThan'] = "以下よりも少ない";
$GLOBALS['strGreaterOrEqualTo'] = "is greater or equal to";
$GLOBALS['strLessOrEqualTo'] = "is less or equal to";
$GLOBALS['strAND'] = "かつ";                          // logical operator
$GLOBALS['strOR'] = "または";                         // logical operator
$GLOBALS['strOnlyDisplayWhen'] = "バナー表示日時:";
$GLOBALS['strWeekDays'] = "平日";
$GLOBALS['strTime'] = "Time";
$GLOBALS['strDomain'] = "Domain";
$GLOBALS['strSource'] = "ソースパラメータ";
$GLOBALS['strBrowser'] = "Browser";
$GLOBALS['strOS'] = "OS";
$GLOBALS['strDeliveryLimitations'] = "Delivery Rules";

$GLOBALS['strDeliveryCappingReset'] = "カウンタリセット条件：";
$GLOBALS['strDeliveryCappingTotal'] = "総配信数";
$GLOBALS['strDeliveryCappingSession'] = "／セッション";

if (!isset($GLOBALS['strCappingBanner'])) {
    $GLOBALS['strCappingBanner'] = array();
}
$GLOBALS['strCappingBanner']['title'] = "Delivery capping per visitor";
$GLOBALS['strCappingBanner']['limit'] = "バナービュー上限数";

if (!isset($GLOBALS['strCappingCampaign'])) {
    $GLOBALS['strCappingCampaign'] = array();
}
$GLOBALS['strCappingCampaign']['title'] = "Delivery capping per visitor";
$GLOBALS['strCappingCampaign']['limit'] = "キャンペーンビュー上限数";

if (!isset($GLOBALS['strCappingZone'])) {
    $GLOBALS['strCappingZone'] = array();
}
$GLOBALS['strCappingZone']['title'] = "Delivery capping per visitor";
$GLOBALS['strCappingZone']['limit'] = "ゾーンビュー上限数";

// Website
$GLOBALS['strAffiliate'] = "Webサイト";
$GLOBALS['strAffiliates'] = "Webサイト";
$GLOBALS['strAffiliatesAndZones'] = "Webサイト＆ゾーン";
$GLOBALS['strAddNewAffiliate'] = "Webサイトの追加";
$GLOBALS['strAffiliateProperties'] = "Webサイトの詳細";
$GLOBALS['strAffiliateHistory'] = "Website Statistics";
$GLOBALS['strNoAffiliates'] = "Webサイトが存在しません。広告枠を作成する前に、先に<a href='affiliate-edit.php'>Webサイトを作成</a>して下さい。";
$GLOBALS['strConfirmDeleteAffiliate'] = "このWebサイトを本当に削除しますか?";
$GLOBALS['strConfirmDeleteAffiliates'] = "このWebサイトを本当に削除しますか?";
$GLOBALS['strInactiveAffiliatesHidden'] = "件の非アクティブなWebサイトを隠す";
$GLOBALS['strShowParentAffiliates'] = "親のWebサイトを表示する";
$GLOBALS['strHideParentAffiliates'] = "親のWebサイトを隠す";

// Website (properties)
$GLOBALS['strWebsite'] = "Webサイト";
$GLOBALS['strWebsiteURL'] = "WebサイトのURL";
$GLOBALS['strAllowAffiliateModifyZones'] = "このユーザによるゾーン修正を許可する";
$GLOBALS['strAllowAffiliateLinkBanners'] = "このユーザによるゾーンのバナーリンクを許可する";
$GLOBALS['strAllowAffiliateAddZone'] = "このユーザによる新規ゾーン定義を許可する";
$GLOBALS['strAllowAffiliateDeleteZone'] = "このユーザによるゾーン情報の削除を許可する";
$GLOBALS['strAllowAffiliateGenerateCode'] = "このユーザによる呼出コードの生成を許可する";

// Website (properties - payment information)
$GLOBALS['strPostcode'] = "郵便番号";
$GLOBALS['strCountry'] = "国";

// Website (properties - other information)
$GLOBALS['strWebsiteZones'] = "Webサイト＆ゾーン";

// Zone
$GLOBALS['strZone'] = "ゾーン";
$GLOBALS['strZones'] = "ゾーン";
$GLOBALS['strAddNewZone'] = "ゾーンの追加";
$GLOBALS['strAddNewZone_Key'] = "ゾーンの追加 (<u>n</u>)";
$GLOBALS['strZoneToWebsite'] = "すべてのWebサイト";
$GLOBALS['strLinkedZones'] = "リンク済ゾーン";
$GLOBALS['strAvailableZones'] = "Available Zones";
$GLOBALS['strLinkingNotSuccess'] = "Linking not successful, please try again";
$GLOBALS['strZoneProperties'] = "ゾーンの詳細";
$GLOBALS['strZoneHistory'] = "ゾーンの状況";
$GLOBALS['strNoZones'] = "ゾーンが定義されていません";
$GLOBALS['strNoZonesAddWebsite'] = "Webサイトが存在しません。広告枠を作成する前に、先に<a href='affiliate-edit.php'>Webサイトを作成</a>して下さい。";
$GLOBALS['strConfirmDeleteZone'] = "このゾーンを本当に削除しますか?";
$GLOBALS['strConfirmDeleteZones'] = "このゾーンを本当に削除しますか?";
$GLOBALS['strConfirmDeleteZoneLinkActive'] = "このゾーンにリンクされたキャンペーンの未払分があります。 このゾーンを削除するとキャンペーンが中断し、支払も行われません。";
$GLOBALS['strZoneType'] = "ゾーンタイプ";
$GLOBALS['strBannerButtonRectangle'] = "バナー・ボタン・レクタングル広告";
$GLOBALS['strInterstitial'] = "インタスティシャル／フローティングDHTML広告";
$GLOBALS['strPopup'] = "ポップアップ広告";
$GLOBALS['strTextAdZone'] = "テキスト広告";
$GLOBALS['strEmailAdZone'] = "メール/ニュースレターゾーン";
$GLOBALS['strZoneVideoInstream'] = "Inline Video ad";
$GLOBALS['strZoneVideoOverlay'] = "Overlay Video ad";
$GLOBALS['strShowMatchingBanners'] = "一致するバナーを表示";
$GLOBALS['strHideMatchingBanners'] = "一致するバナーを隠す";
$GLOBALS['strBannerLinkedAds'] = "ゾーンにリンク済のバナー";
$GLOBALS['strCampaignLinkedAds'] = "ゾーンにリンク済のキャンペーン";
$GLOBALS['strInactiveZonesHidden'] = "非アクティブなゾーンを隠す";
$GLOBALS['strWarnChangeZoneType'] = "ゾーンタイプの制限により、テキストもしくはEメールへとタイプを変更する場合、広告への全てのリンクが非表示となる可能性があります。
<ul>
<li>テキストタイプのゾーンはテキスト広告のみ表示可能です。</li>
<li>また、Eメールタイプのゾーンは有効なバナーを1つしか持てません。</li>
</ul>";
$GLOBALS['strWarnChangeZoneSize'] = 'ゾーンのサイズを変更することにより、新しいサイズに適合しないバナーは全て外されます。またリンク済みとなっているキャンペーンにおいて、新しいサイズに適合する広告がある場合、それらが表示されるようになります。';
$GLOBALS['strWarnChangeBannerSize'] = 'バナーサイズを変更すると、新しいサイズに適合しないバナーは解除されます。またバナーが属するキャンペーンが新しいサイズに適合していると、そのバナーが自動的に関連付けされます。';
$GLOBALS['strWarnBannerReadonly'] = 'This banner is read-only because an extension has been disabled. Contact your system administrator for more information.';
$GLOBALS['strZonesOfWebsite'] = '内の'; //this is added between page name and website name eg. 'Zones in www.example.com'
$GLOBALS['strBackToZones'] = "Back to zones";

$GLOBALS['strIab']['IAB_FullBanner(468x60)'] = "IAB Full Banner (468 x 60)";
$GLOBALS['strIab']['IAB_Skyscraper(120x600)'] = "IAB Skyscraper (120 x 600)";
$GLOBALS['strIab']['IAB_Leaderboard(728x90)'] = "IAB Leaderboard (728 x 90)";
$GLOBALS['strIab']['IAB_Button1(120x90)'] = "IAB Button 1 (120 x 90)";
$GLOBALS['strIab']['IAB_Button2(120x60)'] = "IAB Button 2 (120 x 60)";
$GLOBALS['strIab']['IAB_HalfBanner(234x60)'] = "IAB Half Banner (234 x 60)";
$GLOBALS['strIab']['IAB_MicroBar(88x31)'] = "IAB Micro Bar (88 x 31)";
$GLOBALS['strIab']['IAB_SquareButton(125x125)'] = "IAB Square Button (125 x 125)";
$GLOBALS['strIab']['IAB_Rectangle(180x150)*'] = "IAB Rectangle (180 x 150)";
$GLOBALS['strIab']['IAB_SquarePop-up(250x250)'] = "IAB Square Pop-up (250 x 250)";
$GLOBALS['strIab']['IAB_VerticalBanner(120x240)'] = "IAB Vertical Banner (120 x 240)";
$GLOBALS['strIab']['IAB_MediumRectangle(300x250)*'] = "IAB Medium Rectangle (300 x 250)";
$GLOBALS['strIab']['IAB_LargeRectangle(336x280)'] = "IAB Large Rectangle (336 x 280)";
$GLOBALS['strIab']['IAB_VerticalRectangle(240x400)'] = "IAB Vertical Rectangle (240 x 400)";
$GLOBALS['strIab']['IAB_WideSkyscraper(160x600)*'] = "IAB Wide Skyscraper (160 x 600)";
$GLOBALS['strIab']['IAB_Pop-Under(720x300)'] = "IAB Pop-Under (720 x 300)";
$GLOBALS['strIab']['IAB_3:1Rectangle(300x100)'] = "IAB 3:1 Rectangle (300 x 100)";

// Advanced zone settings
$GLOBALS['strAdvanced'] = "アドバンス";
$GLOBALS['strChainSettings'] = "代替バナーの設定";
$GLOBALS['strZoneNoDelivery'] = "配信対象バナーが存在しない場合";
$GLOBALS['strZoneStopDelivery'] = "バナー配信を停止する";
$GLOBALS['strZoneOtherZone'] = "別ゾーンのバナーを表示する";
$GLOBALS['strZoneAppend'] = "HTMLバナーを追加する";
$GLOBALS['strAppendSettings'] = "プリペンド設定／追加設定";
$GLOBALS['strZonePrependHTML'] = "テキスト広告に次のHTMLコードを挿入する";
$GLOBALS['strZoneAppendNoBanner'] = "バナー非配信中でも追加する";
$GLOBALS['strZoneAppendHTMLCode'] = "HTMLコード";
$GLOBALS['strZoneAppendZoneSelection'] = "ポップアップ広告／インタスティシャル広告";

// Zone probability
$GLOBALS['strZoneProbListChain'] = "対象ゾーンにリンク済のアクティブなバナーがありません。<br>代わりに配信するバナーは次のとおりです:";
$GLOBALS['strZoneProbNullPri'] = "対象ゾーンにリンク済のアクティブなバナーがありません。";
$GLOBALS['strZoneProbListChainLoop'] = "代替バナーがループになっています。このゾーンへの配信は、中断されます。";

// Linked banners/campaigns/trackers
$GLOBALS['strSelectZoneType'] = "リンク済のバナーの表示方法を選択してください";
$GLOBALS['strLinkedBanners'] = "各々のバナーをリンクする";
$GLOBALS['strCampaignDefaults'] = "親キャンペーンでバナーをリンクする";
$GLOBALS['strLinkedCategories'] = "カテゴリでバナーをリンクする";
$GLOBALS['strWithXBanners'] = "%d バナー";
$GLOBALS['strRawQueryString'] = "キーワード";
$GLOBALS['strIncludedBanners'] = "リンク済バナー";
$GLOBALS['strMatchingBanners'] = "{count}個のバナーが一致";
$GLOBALS['strNoCampaignsToLink'] = "このバナーがリンク可能なキャンペーンがありません。";
$GLOBALS['strNoTrackersToLink'] = "このキャンペーンにリンク可能なトラッカーはありません。";
$GLOBALS['strNoZonesToLinkToCampaign'] = "このキャンペーンがリンク可能なゾーンがありません。";
$GLOBALS['strSelectBannerToLink'] = "このゾーンにリンクしたいバナーを選択してください:";
$GLOBALS['strSelectCampaignToLink'] = "このゾーンにリンクしたいキャンペーンを選択してください:";
$GLOBALS['strSelectAdvertiser'] = "広告主を選択してください";
$GLOBALS['strSelectPlacement'] = "キャンペーンを選択してください";
$GLOBALS['strSelectAd'] = "バナーを選択してください";
$GLOBALS['strSelectPublisher'] = "Webサイトを選択してください";
$GLOBALS['strSelectZone'] = "ゾーンを選択してください";
$GLOBALS['strStatusPending'] = "保留";
$GLOBALS['strStatusApproved'] = "Approved";
$GLOBALS['strStatusDisapproved'] = "Disapproved";
$GLOBALS['strStatusDuplicate'] = "複製する";
$GLOBALS['strStatusOnHold'] = "On Hold";
$GLOBALS['strStatusIgnore'] = "Ignore";
$GLOBALS['strConnectionType'] = "Type";
$GLOBALS['strConnTypeSale'] = "Sale";
$GLOBALS['strConnTypeLead'] = "Lead";
$GLOBALS['strConnTypeSignUp'] = "Signup";
$GLOBALS['strShortcutEditStatuses'] = "ステータスを変更する";
$GLOBALS['strShortcutShowStatuses'] = "ステータスを見る";

// Statistics
$GLOBALS['strStats'] = "統計";
$GLOBALS['strNoStats'] = "利用可能な統計データはありません。";
$GLOBALS['strNoStatsForPeriod'] = "%s から %s の期間に利用可能な統計データはありません。";
$GLOBALS['strGlobalHistory'] = "Global Statistics";
$GLOBALS['strDailyHistory'] = "Daily Statistics";
$GLOBALS['strDailyStats'] = "Daily Statistics";
$GLOBALS['strWeeklyHistory'] = "Weekly Statistics";
$GLOBALS['strMonthlyHistory'] = "Monthly Statistics";
$GLOBALS['strTotalThisPeriod'] = "期間合計";
$GLOBALS['strPublisherDistribution'] = "Webサイト別配信";
$GLOBALS['strCampaignDistribution'] = "キャンペーン別配信";
$GLOBALS['strViewBreakdown'] = "明細確認";
$GLOBALS['strBreakdownByDay'] = "日";
$GLOBALS['strBreakdownByWeek'] = "週";
$GLOBALS['strBreakdownByMonth'] = "月";
$GLOBALS['strBreakdownByDow'] = "曜日";
$GLOBALS['strBreakdownByHour'] = "時";
$GLOBALS['strItemsPerPage'] = "１ページあたりのアイテム数";
$GLOBALS['strDistributionHistoryCampaign'] = "Distribution Statistics (Campaign)";
$GLOBALS['strDistributionHistoryBanner'] = "Distribution Statistics (Banner)";
$GLOBALS['strDistributionHistoryWebsite'] = "Distribution Statistics (Website)";
$GLOBALS['strDistributionHistoryZone'] = "Distribution Statistics (Zone)";
$GLOBALS['strShowGraphOfStatistics'] = "グラフ表示(<u>G</u>)";
$GLOBALS['strExportStatisticsToExcel'] = "Excel出力(<u>E</u>)";
$GLOBALS['strGDnotEnabled'] = "グラフ表示を行うにはPHPでGDを利用可能にしてください。<br />詳細は、<a href='http://www.php.net/gd' target='_blank'>http://www.php.net/gd</a>を確認してください。サーバへのGDのインストール方法が掲載されています。";
$GLOBALS['strStatsArea'] = "エリア";

// Expiration
$GLOBALS['strNoExpiration'] = "終了日が未設定です";
$GLOBALS['strEstimated'] = "終了日を設定しました";
$GLOBALS['strNoExpirationEstimation'] = "期限日は未定です";
$GLOBALS['strDaysAgo'] = "日前";
$GLOBALS['strCampaignStop'] = "キャンペーン中断";

// Reports
$GLOBALS['strAdvancedReports'] = "Advanced Reports";
$GLOBALS['strStartDate'] = "Start Date";
$GLOBALS['strEndDate'] = "End Date";
$GLOBALS['strPeriod'] = "期限";
$GLOBALS['strLimitations'] = "Delivery Rules";
$GLOBALS['strWorksheets'] = "Worksheets";

// Admin_UI_Fields
$GLOBALS['strAllAdvertisers'] = "すべての広告主";
$GLOBALS['strAnonAdvertisers'] = "任意の広告主";
$GLOBALS['strAllPublishers'] = "すべてのWebサイト";
$GLOBALS['strAnonPublishers'] = "任意のWebサイト";
$GLOBALS['strAllAvailZones'] = "利用可能なすべてのゾーン";

// Userlog
$GLOBALS['strUserLog'] = "ユーザーログ";
$GLOBALS['strUserLogDetails'] = "ユーザーログの詳細";
$GLOBALS['strDeleteLog'] = "ログを削除する";
$GLOBALS['strAction'] = "アクション";
$GLOBALS['strNoActionsLogged'] = "アクションは記録されていません。";

// Code generation
$GLOBALS['strGenerateBannercode'] = "ダイレクト選択";
$GLOBALS['strChooseInvocationType'] = "バナーの呼出方法を選択してください";
$GLOBALS['strGenerate'] = "生成する";
$GLOBALS['strParameters'] = "パラメータ";
$GLOBALS['strFrameSize'] = "フレームサイズ";
$GLOBALS['strBannercode'] = "バナーコード";
$GLOBALS['strTrackercode'] = "トラッカーコード";
$GLOBALS['strBackToTheList'] = "レポート一覧に戻る";
$GLOBALS['strCharset'] = "キャラクターセット";
$GLOBALS['strAutoDetect'] = "自動検出";
$GLOBALS['strCacheBusterComment'] = "  * Replace all instances of {random} with
  * a generated random number (or timestamp).
  *";
$GLOBALS['strSSLBackupComment'] = "
  * The backup image section of this tag has been generated for use on a
  * non-SSL page. If this tag is to be placed on an SSL page, change the
  *   'http://%s/...'
  * to
  *   'https://%s/...'
  *";
$GLOBALS['strSSLDeliveryComment'] = "
  * This tag has been generated for use on a non-SSL page. If this tag
  * is to be placed on an SSL page, change the
  *   'http://%s/...'
  * to
  *   'https://%s/...'
  *";

// Errors
$GLOBALS['strErrorDatabaseConnection'] = "Database connection error.";
$GLOBALS['strErrorCantConnectToDatabase'] = "A fatal error occurred %1\$s can't connect to the database. Because
                                                   of this it isn't possible to use the administrator interface. The delivery
                                                   of banners might also be affected. Possible reasons for the problem are:
                                                   <ul>
                                                     <li>The database server isn't functioning at the moment</li>
                                                     <li>The location of the database server has changed</li>
                                                     <li>The username or password used to contact the database server are not correct</li>
                                                     <li>PHP has not loaded the <i>%2\$s</i> extension</li>
                                                   </ul>";
$GLOBALS['strNoMatchesFound'] = "一致するものは見つかりません";
$GLOBALS['strErrorOccurred'] = "エラーが発生しました";
$GLOBALS['strErrorDBPlain'] = "データベースにアクセス中にエラーが発生しました。";
$GLOBALS['strErrorDBSerious'] = "データベースに致命的な問題を検出しました。";
$GLOBALS['strErrorDBNoDataPlain'] = "Due to a problem with the database {$PRODUCT_NAME} couldn't retrieve or store data. ";
$GLOBALS['strErrorDBNoDataSerious'] = "Due to a serious problem with the database, {$PRODUCT_NAME} couldn't retrieve data";
$GLOBALS['strErrorDBCorrupt'] = "データベーステーブルがおそらく破損しており、修復する必要があります。破損したテーブルの詳しい修復方法は、<i>管理者ガイド</i>の<i>トラブルシューティング</i>を読んでください。";
$GLOBALS['strErrorDBContact'] = "このサーバのシステム管理者に連絡して、問題を報告してください。";
$GLOBALS['strErrorDBSubmitBug'] = "If this problem is reproducable it might be caused by a bug in {$PRODUCT_NAME}. Please report the following information to the creators of {$PRODUCT_NAME}. Also try to describe the actions that led to this error as clearly as possible.";
$GLOBALS['strMaintenanceNotActive'] = "The maintenance script has not been run in the last 24 hours.
In order for the application to function correctly it needs to run
every hour.

Please read the Administrator guide for more information
about configuring the maintenance script.";
$GLOBALS['strErrorLinkingBanner'] = "バナーとゾーンをリンク中にエラーが発生しました:";
$GLOBALS['strUnableToLinkBanner'] = "リンクできません：";
$GLOBALS['strErrorEditingCampaignRevenue'] = "利益情報のフィールドに無効な数値が入力されています。";
$GLOBALS['strErrorEditingCampaignECPM'] = "incorrect number format in ECPM Information field";
$GLOBALS['strErrorEditingZone'] = "更新したゾーンにエラーが発生：";
$GLOBALS['strUnableToChangeZone'] = "以下の理由により、この変更を適用できませんでした：";
$GLOBALS['strDatesConflict'] = "日間、競合中：";
$GLOBALS['strEmailNoDates'] = "Campaigns linked to Email Zones must have a start and end date set. {$PRODUCT_NAME} ensures that on a given date, only one active banner is linked to an Email Zone. Please ensure that the campaigns already linked to the zone do not have overlapping dates with the campaign you are trying to link.";
$GLOBALS['strWarningInaccurateStats'] = "統計データが非UTCタイムゾーンで記録されているため、正しいタイムゾーンで表示されない恐れがあります。";
$GLOBALS['strWarningInaccurateReadMore'] = "詳細は、こちら";
$GLOBALS['strWarningInaccurateReport'] = "統計データが非UTCタイムゾーンで記録されているため、正しいタイムゾーンで表示されない恐れがあります。";

//Validation
$GLOBALS['strRequiredFieldLegend'] = "denotes required field";
$GLOBALS['strFormContainsErrors'] = "Form contains errors, please correct the marked fields below.";
$GLOBALS['strXRequiredField'] = "%s is required";
$GLOBALS['strEmailField'] = "Please enter a valid email";
$GLOBALS['strNumericField'] = "Please enter a number (only digits allowed)";
$GLOBALS['strGreaterThanZeroField'] = "Must be greater than 0";
$GLOBALS['strXGreaterThanZeroField'] = "%s must be greater than 0";
$GLOBALS['strXPositiveWholeNumberField'] = "%s must be a positive whole number";
$GLOBALS['strInvalidWebsiteURL'] = "Invalid Website URL";

// Email
$GLOBALS['strSirMadam'] = "様";
$GLOBALS['strMailSubject'] = "レポートの送信";
$GLOBALS['strMailHeader'] = "Dear {contact},";
$GLOBALS['strMailBannerStats'] = "{clientname}に関するバナー統計は次のとおりです:";
$GLOBALS['strMailBannerActivatedSubject'] = "キャンペーン開始";
$GLOBALS['strMailBannerDeactivatedSubject'] = "キャンペーン停止";
$GLOBALS['strMailBannerActivated'] = "Your campaign shown below has been activated because
the campaign activation date has been reached.";
$GLOBALS['strMailBannerDeactivated'] = "以下のキャンペーンが停止しました。";
$GLOBALS['strMailFooter'] = "Regards,
   {adminfullname}";
$GLOBALS['strClientDeactivated'] = "次のキャンペーンは、アクティブではありません。";
$GLOBALS['strBeforeActivate'] = "開始前キャンペーン　　　　：";
$GLOBALS['strAfterExpire'] = "終了済キャンペーン　　　　：";
$GLOBALS['strNoMoreImpressions'] = "残インプレッション数＝ゼロ：";
$GLOBALS['strNoMoreClicks'] = "残クリック数＝ゼロ　　　　：";
$GLOBALS['strNoMoreConversions'] = "残コンバージョン数＝ゼロ　：";
$GLOBALS['strWeightIsNull'] = "ウェイト設定＝ゼロ　　　　：";
$GLOBALS['strRevenueIsNull'] = "its revenue is set to zero";
$GLOBALS['strTargetIsNull'] = "ターゲット設定＝ゼロ　　　：";
$GLOBALS['strNoViewLoggedInInterval'] = "インプレッション数＝ゼロ　：";
$GLOBALS['strNoClickLoggedInInterval'] = "クリック数＝ゼロ　　　　　：";
$GLOBALS['strNoConversionLoggedInInterval'] = "コンバージョン数＝ゼロ　　：";
$GLOBALS['strMailReportPeriod'] = "レポートの統計期間は次のとおりです。開始日：{startdate} －終了日：{enddate}";
$GLOBALS['strMailReportPeriodAll'] = "レポートの全期間統計は次のとおりです。終了日： {enddate}.";
$GLOBALS['strNoStatsForCampaign'] = "このキャンペーンに有効な統計はありません。";
$GLOBALS['strImpendingCampaignExpiry'] = "キャンペーン終了直前";
$GLOBALS['strYourCampaign'] = "対象キャンペーン";
$GLOBALS['strTheCampiaignBelongingTo'] = "キャンペーンリンク先";
$GLOBALS['strImpendingCampaignExpiryDateBody'] = "以下の{clientname}は、{date}に終了しました。";
$GLOBALS['strImpendingCampaignExpiryImpsBody'] = "以下の{clientname}の 残りインプレッションは、{limit}です。";
$GLOBALS['strImpendingCampaignExpiryBody'] = "As a result, the campaign will soon be automatically disabled, and the
following banners in the campaign will also be disabled:";

// Priority
$GLOBALS['strPriority'] = "優先度";
$GLOBALS['strSourceEdit'] = "ソースパラメータの編集";

// Preferences
$GLOBALS['strPreferences'] = "プリファレンス";
$GLOBALS['strUserPreferences'] = "ユーザ－プリファレンス";
$GLOBALS['strChangePassword'] = "パスワードの変更";
$GLOBALS['strChangeEmail'] = "メールアドレスの変更";
$GLOBALS['strCurrentPassword'] = "旧パスワード";
$GLOBALS['strChooseNewPassword'] = "新パスワード";
$GLOBALS['strReenterNewPassword'] = "新パスワード（再入力）";
$GLOBALS['strNameLanguage'] = "ユーザ情報＆言語";
$GLOBALS['strAccountPreferences'] = "アカウントプリファレンス";
$GLOBALS['strCampaignEmailReportsPreferences'] = "メール送信プリファレンス";
$GLOBALS['strTimezonePreferences'] = "Timezone Preferences";
$GLOBALS['strAdminEmailWarnings'] = "管理者メール警告";
$GLOBALS['strAgencyEmailWarnings'] = "代理店メール警告";
$GLOBALS['strAdveEmailWarnings'] = "広告主メール警告";
$GLOBALS['strFullName'] = "フルネーム";
$GLOBALS['strEmailAddress'] = "メールアドレス";
$GLOBALS['strUserDetails'] = "ユーザ情報";
$GLOBALS['strUserInterfacePreferences'] = "ユーザインターフェース設定";
$GLOBALS['strPluginPreferences'] = "メインプリファレンス";
$GLOBALS['strColumnName'] = "カラム名";
$GLOBALS['strShowColumn'] = "カラムを表示";
$GLOBALS['strCustomColumnName'] = "カスタムカラム名";
$GLOBALS['strColumnRank'] = "カラムランク";

// Long names
$GLOBALS['strRevenue'] = "収入";
$GLOBALS['strNumberOfItems'] = "アイテム番号";
$GLOBALS['strRevenueCPC'] = "CPC収入";
$GLOBALS['strERPM'] = "ERPM";
$GLOBALS['strERPC'] = "ERPC";
$GLOBALS['strERPS'] = "ERPS";
$GLOBALS['strEIPM'] = "EIPM";
$GLOBALS['strEIPC'] = "EIPC";
$GLOBALS['strEIPS'] = "EIPS";
$GLOBALS['strECPM'] = "ECPM";
$GLOBALS['strECPC'] = "ECPC";
$GLOBALS['strECPS'] = "ECPS";
$GLOBALS['strPendingConversions'] = "保留されているコンバージョン数";
$GLOBALS['strImpressionSR'] = "インプレッションSR";
$GLOBALS['strClickSR'] = "クリックSR";

// Short names
$GLOBALS['strRevenue_short'] = "収益";
$GLOBALS['strBasketValue_short'] = "バスケット値";
$GLOBALS['strNumberOfItems_short'] = "アイテム数";
$GLOBALS['strRevenueCPC_short'] = "収益CPC";
$GLOBALS['strERPM_short'] = "ERPM";
$GLOBALS['strERPC_short'] = "ERPC";
$GLOBALS['strERPS_short'] = "ERPS";
$GLOBALS['strEIPM_short'] = "EIPM";
$GLOBALS['strEIPC_short'] = "EIPC";
$GLOBALS['strEIPS_short'] = "EIPS";
$GLOBALS['strECPM_short'] = "ECPM";
$GLOBALS['strECPC_short'] = "ECPC";
$GLOBALS['strECPS_short'] = "ECPS";
$GLOBALS['strID_short'] = "ID";
$GLOBALS['strRequests_short'] = "収益";
$GLOBALS['strImpressions_short'] = "Impr.";
$GLOBALS['strClicks_short'] = "クリック数";
$GLOBALS['strCTR_short'] = "CTR";
$GLOBALS['strConversions_short'] = "コンバージョン数";
$GLOBALS['strPendingConversions_short'] = "保留コンバージョン数";
$GLOBALS['strImpressionSR_short'] = "Impr. SR";
$GLOBALS['strClickSR_short'] = "クリックSR";

// Global Settings
$GLOBALS['strConfiguration'] = "Configuration";
$GLOBALS['strGlobalSettings'] = "全般設定";
$GLOBALS['strGeneralSettings'] = "全般設定";
$GLOBALS['strMainSettings'] = "メイン設定";
$GLOBALS['strPlugins'] = "Plugins";
$GLOBALS['strChooseSection'] = 'Choose Section';

// Product Updates
$GLOBALS['strProductUpdates'] = "プロダクト更新";
$GLOBALS['strViewPastUpdates'] = "過去のアップデート状況を参照する。";
$GLOBALS['strFromVersion'] = "このバージョンから";
$GLOBALS['strToVersion'] = "このバージョンまで";
$GLOBALS['strToggleDataBackupDetails'] = "データのバックアップの詳細を切り替える";
$GLOBALS['strClickViewBackupDetails'] = "クリックしてバックアップの詳細を見る";
$GLOBALS['strClickHideBackupDetails'] = "クリックしてバックアップの詳細を隠す";
$GLOBALS['strShowBackupDetails'] = "バックアップの詳細を表示する";
$GLOBALS['strHideBackupDetails'] = "バックアップの詳細を隠す";
$GLOBALS['strBackupDeleteConfirm'] = "本当にすべてのバックアップを消去しますか？";
$GLOBALS['strDeleteArtifacts'] = "誤差を削除しますか？";
$GLOBALS['strArtifacts'] = "誤差";
$GLOBALS['strBackupDbTables'] = "データベースをバックアップする";
$GLOBALS['strLogFiles'] = "ログファイル";
$GLOBALS['strConfigBackups'] = "バックアップの設定";
$GLOBALS['strUpdatedDbVersionStamp'] = "データベースのバージョン日時を更新する";
$GLOBALS['aProductStatus']['UPGRADE_COMPLETE'] = "アップグレードが完了しました";
$GLOBALS['aProductStatus']['UPGRADE_FAILED'] = "アップグレードが失敗しました";

// Agency
$GLOBALS['strAgencyManagement'] = "アカウント管理";
$GLOBALS['strAgency'] = "アカウント";
$GLOBALS['strAddAgency'] = "アカウントを追加";
$GLOBALS['strAddAgency_Key'] = "ゾーンの追加 (<u>n</u>)";
$GLOBALS['strTotalAgencies'] = "すべてのアカウント";
$GLOBALS['strAgencyProperties'] = "アカウント設定";
$GLOBALS['strNoAgencies'] = "アカウントが存在しません。";
$GLOBALS['strConfirmDeleteAgency'] = "このアカウントを本当に削除しますか?";
$GLOBALS['strHideInactiveAgencies'] = "無効なアカウントを非表示にする";
$GLOBALS['strInactiveAgenciesHidden'] = "非表示のアカウントを無効にする";
$GLOBALS['strSwitchAccount'] = "アカウントの変更";
$GLOBALS['strAgencyStatusRunning'] = "Active";
$GLOBALS['strAgencyStatusInactive'] = "アクティブ";
$GLOBALS['strAgencyStatusPaused'] = "Suspended";

// Channels
$GLOBALS['strChannel'] = "Delivery Rule Set";
$GLOBALS['strChannels'] = "Delivery Rule Sets";
$GLOBALS['strChannelManagement'] = "Delivery Rule Set Management";
$GLOBALS['strAddNewChannel'] = "Add new Delivery Rule Set";
$GLOBALS['strAddNewChannel_Key'] = "Add <u>n</u>ew Delivery Rule Set";
$GLOBALS['strChannelToWebsite'] = "すべてのWebサイト";
$GLOBALS['strNoChannels'] = "There are currently no delivery rule sets defined";
$GLOBALS['strNoChannelsAddWebsite'] = "There are currently no delivery rule sets defined, because there are no websites. To create a delivery rule set, <a href='affiliate-edit.php'>add a new website</a> first.";
$GLOBALS['strEditChannelLimitations'] = "Edit delivery rules for the delivery rule set";
$GLOBALS['strChannelProperties'] = "Delivery Rule Set Properties";
$GLOBALS['strChannelLimitations'] = "配信オプション";
$GLOBALS['strConfirmDeleteChannel'] = "Do you really want to delete this delivery rule set?";
$GLOBALS['strConfirmDeleteChannels'] = "Do you really want to delete the selected delivery rule sets?";
$GLOBALS['strChannelsOfWebsite'] = '内の'; //this is added between page name and website name eg. 'delivery rule sets in www.example.com'

// Tracker Variables
$GLOBALS['strVariableName'] = "トラッカー変数名";
$GLOBALS['strVariableDescription'] = "記事";
$GLOBALS['strVariableDataType'] = "データタイプ";
$GLOBALS['strVariablePurpose'] = "用途";
$GLOBALS['strGeneric'] = "汎用Adserver";
$GLOBALS['strBasketValue'] = "バスケット値";
$GLOBALS['strNumItems'] = "アイテム番号";
$GLOBALS['strVariableIsUnique'] = "コンバージョンを停止";
$GLOBALS['strNumber'] = "番号";
$GLOBALS['strString'] = "文字列";
$GLOBALS['strTrackFollowingVars'] = "次のトラッカー変数を追跡する";
$GLOBALS['strAddVariable'] = "トラッカー変数の追加";
$GLOBALS['strNoVarsToTrack'] = "トラッカー変数が定義されていません";
$GLOBALS['strVariableRejectEmpty'] = "トラッカーがヌルの場合、拒否する？";
$GLOBALS['strTrackingSettings'] = "トラッカーの設定";
$GLOBALS['strTrackerType'] = "トラッカータイプ";
$GLOBALS['strTrackerTypeJS'] = "トラッカー用JavaScript変数";
$GLOBALS['strTrackerTypeDefault'] = "トラッカー用JavaScript変数(後方互換、エスケーピング処理)";
$GLOBALS['strTrackerTypeDOM'] = "トラッカー用DOM版HTMLエレメント";
$GLOBALS['strTrackerTypeCustom'] = "トラッカー用カスタムJavascriptコード";
$GLOBALS['strVariableCode'] = "トラッカー用Javascriptコード";

// Password recovery
$GLOBALS['strForgotPassword'] = "パスワードを忘れた？";
$GLOBALS['strPasswordRecovery'] = "Password reset";
$GLOBALS['strEmailRequired'] = "メールアドレスは必須です。";
$GLOBALS['strPwdRecWrongId'] = "メールアドレスが間違っています。";
$GLOBALS['strPwdRecEnterEmail'] = "メールアドレスを入力してください";
$GLOBALS['strPwdRecEnterPassword'] = "新しいパスワードを入力してください";
$GLOBALS['strProceed'] = "続ける &gt;";
$GLOBALS['strNotifyPageMessage'] = "An e-mail has been sent to you, which includes a link that will allow you
                                         to reset your password and log in.<br />Please allow a few minutes for the e-mail to arrive.<br />
                                         If you do not receive the e-mail, please check your spam folder.<br />
                                         <a href=\"index.php\">Return to the main login page.</a>";

$GLOBALS['strPwdRecEmailPwdRecovery'] = "Reset Your %s Password";
$GLOBALS['strPwdRecEmailBody'] = "Dear {name},

You, or someone pretending to be you, recently requested that your {$PRODUCT_NAME} password be reset.

If this request was made by you, then you can reset the password for your username '{username}' by
clicking on the following link:

{reset_link}

If you submitted the password reset request by mistake, or if you didn't make a request at all, simply
ignore this email. No changes have been made to your password and the password reset link will expire
automatically.

If you continue to receive these password reset mails, then it may indicate that someone is attempting
to gain access to your username. In that case, please contact the support team or system administrator
for your {$PRODUCT_NAME} system, and notify them of the situation.

{admin_signature}";
$GLOBALS['strPwdRecEmailSincerely'] = "Sincerely,";

// Audit
$GLOBALS['strAdditionalItems'] = "追加内容";
$GLOBALS['strFor'] = "for";
$GLOBALS['strHas'] = "\\=";
$GLOBALS['strBinaryData'] = "バイナリデータ";
$GLOBALS['strAuditTrailDisabled'] = "管理者によって追跡記録が無効となりました。現在ログは取得されていません。また追跡記録のリストも表示されません。";

// Widget - Audit
$GLOBALS['strAuditNoData'] = "指定期間内のユーザ活動記録はありません。";
$GLOBALS['strAuditTrail'] = "追跡記録";
$GLOBALS['strAuditTrailSetup'] = "本日の追跡記録を設定する";
$GLOBALS['strAuditTrailGoTo'] = "追跡記録ページに移動する";
$GLOBALS['strAuditTrailNotEnabled'] = "<li>Audit Trail allows you to see who did what and when. Or to put it another way, it keeps track of system changes within {$PRODUCT_NAME}</li>
        <li>You are seeing this message, because you have not activated the Audit Trail</li>
        <li>Interested in learning more? Read the <a href='{$PRODUCT_DOCSURL}/admin/settings/auditTrail' class='site-link' target='help' >Audit Trail documentation</a></li>";

// Widget - Campaign
$GLOBALS['strCampaignGoTo'] = "キャンペーンのページに飛ぶ";
$GLOBALS['strCampaignSetUp'] = "本日のキャンペーンを設定する";
$GLOBALS['strCampaignNoRecords'] = "<li>Campaigns let you group together any number of banner ads, of any size, that share common advertising requirements</li>
        <li>Save time by grouping banners within a campaign and no longer define delivery settings for each ad separately</li>
        <li>Check out the <a class='site-link' target='help' href='{$PRODUCT_DOCSURL}/user/inventory/advertisersAndCampaigns/campaigns'>Campaign documentation</a>!</li>";
$GLOBALS['strCampaignNoRecordsAdmin'] = "<li>このキャンペーンには活動記録がありません</li>";

$GLOBALS['strCampaignNoDataTimeSpan'] = "選択した期間内において、開始されるキャンペーンもしくは終了するキャンペーンはありません。";
$GLOBALS['strCampaignAuditNotActivated'] = "<li>In order to view campaigns which have started or finished during the timeframe you have selected, the Audit Trail must be activated</li>
        <li>You are seeing this message because you didn't activate the Audit Trail</li>";
$GLOBALS['strCampaignAuditTrailSetup'] = "キャンペーンの活動状況を確認するため、追跡記録をアクティブにする";

$GLOBALS['strUnsavedChanges'] = "変更が保存されていません。\"保存する\"ボタンを押してください。";
$GLOBALS['strDeliveryLimitationsDisagree'] = "WARNING: The cached delivery rules <strong>DO NOT AGREE</strong> with the delivery rules shown below<br />Please hit save changes to update the cached delivery rules";
$GLOBALS['strDeliveryRulesDbError'] = "WARNING: When saving the delivery rules, a database error occured. Please check the delivery rules below carefully, and update, if required.";
$GLOBALS['strDeliveryRulesTruncation'] = "WARNING: When saving the delivery rules, MySQL truncated the data, so the original values were restored. Please reduce your rule size, and try again.";
$GLOBALS['strDeliveryLimitationsInputErrors'] = "Some delivery rules report incorrect values:";

//confirmation messages
$GLOBALS['strYouAreNowWorkingAsX'] = "You are now working as <b>%s</b>";
$GLOBALS['strYouDontHaveAccess'] = "You don't have access to that page. You have been re-directed.";

$GLOBALS['strAdvertiserHasBeenAdded'] = "Advertiser <a href='%s'>%s</a> has been added, <a href='%s'>add a campaign</a>";
$GLOBALS['strAdvertiserHasBeenUpdated'] = "Advertiser <a href='%s'>%s</a> has been updated";
$GLOBALS['strAdvertiserHasBeenDeleted'] = "Advertiser <b>%s</b> has been deleted";
$GLOBALS['strAdvertisersHaveBeenDeleted'] = "All selected advertisers have been deleted";

$GLOBALS['strTrackerHasBeenAdded'] = "Tracker <a href='%s'>%s</a> has been added";
$GLOBALS['strTrackerHasBeenUpdated'] = "Tracker <a href='%s'>%s</a> has been updated";
$GLOBALS['strTrackerVarsHaveBeenUpdated'] = "Variables of tracker <a href='%s'>%s</a> have been updated";
$GLOBALS['strTrackerCampaignsHaveBeenUpdated'] = "Linked campaigns of tracker <a href='%s'>%s</a> have been updated";
$GLOBALS['strTrackerAppendHasBeenUpdated'] = "Append tracker code of tracker <a href='%s'>%s</a> has been updated";
$GLOBALS['strTrackerHasBeenDeleted'] = "Tracker <b>%s</b> has been deleted";
$GLOBALS['strTrackersHaveBeenDeleted'] = "All selected trackers have been deleted";
$GLOBALS['strTrackerHasBeenDuplicated'] = "Tracker <a href='%s'>%s</a> has been copied to <a href='%s'>%s</a>";
$GLOBALS['strTrackerHasBeenMoved'] = "Tracker <b>%s</b> has been moved to advertiser <b>%s</b>";

$GLOBALS['strCampaignHasBeenAdded'] = "Campaign <a href='%s'>%s</a> has been added, <a href='%s'>add a banner</a>";
$GLOBALS['strCampaignHasBeenUpdated'] = "Campaign <a href='%s'>%s</a> has been updated";
$GLOBALS['strCampaignTrackersHaveBeenUpdated'] = "Linked trackers of campaign <a href='%s'>%s</a> have been updated";
$GLOBALS['strCampaignHasBeenDeleted'] = "Campaign <b>%s</b> has been deleted";
$GLOBALS['strCampaignsHaveBeenDeleted'] = "All selected campaigns have been deleted";
$GLOBALS['strCampaignHasBeenDuplicated'] = "Campaign <a href='%s'>%s</a> has been copied to <a href='%s'>%s</a>";
$GLOBALS['strCampaignHasBeenMoved'] = "Campaign <b>%s</b> has been moved to advertiser <b>%s</b>";

$GLOBALS['strBannerHasBeenAdded'] = "Banner <a href='%s'>%s</a> has been added";
$GLOBALS['strBannerHasBeenUpdated'] = "Banner <a href='%s'>%s</a> has been updated";
$GLOBALS['strBannerAdvancedHasBeenUpdated'] = "Advanced settings for banner <a href='%s'>%s</a> have been updated";
$GLOBALS['strBannerAclHasBeenUpdated'] = "Delivery options for banner <a href='%s'>%s</a> have been updated";
$GLOBALS['strBannerAclHasBeenAppliedTo'] = "Delivery options for banner <a href='%s'>%s</a> have been applied to %d banners";
$GLOBALS['strBannerHasBeenDeleted'] = "Banner <b>%s</b> has been deleted";
$GLOBALS['strBannersHaveBeenDeleted'] = "All selected banners have been deleted";
$GLOBALS['strBannerHasBeenDuplicated'] = "Banner <a href='%s'>%s</a> has been copied to <a href='%s'>%s</a>";
$GLOBALS['strBannerHasBeenMoved'] = "Banner <b>%s</b> has been moved to campaign <b>%s</b>";
$GLOBALS['strBannerHasBeenActivated'] = "Banner <a href='%s'>%s</a> has been activated";
$GLOBALS['strBannerHasBeenDeactivated'] = "Banner <a href='%s'>%s</a> has been deactivated";

$GLOBALS['strXZonesLinked'] = "<b>%s</b> zone(s) linked";
$GLOBALS['strXZonesUnlinked'] = "<b>%s</b> zone(s) unlinked";

$GLOBALS['strWebsiteHasBeenAdded'] = "Website <a href='%s'>%s</a> has been added, <a href='%s'>add a zone</a>";
$GLOBALS['strWebsiteHasBeenUpdated'] = "Website <a href='%s'>%s</a> has been updated";
$GLOBALS['strWebsiteHasBeenDeleted'] = "Website <b>%s</b> has been deleted";
$GLOBALS['strWebsitesHaveBeenDeleted'] = "All selected website have been deleted";
$GLOBALS['strWebsiteHasBeenDuplicated'] = "Website <a href='%s'>%s</a> has been copied to <a href='%s'>%s</a>";

$GLOBALS['strZoneHasBeenAdded'] = "Zone <a href='%s'>%s</a> has been added";
$GLOBALS['strZoneHasBeenUpdated'] = "Zone <a href='%s'>%s</a> has been updated";
$GLOBALS['strZoneAdvancedHasBeenUpdated'] = "Advanced settings for zone <a href='%s'>%s</a> have been updated";
$GLOBALS['strZoneHasBeenDeleted'] = "Zone <b>%s</b> has been deleted";
$GLOBALS['strZonesHaveBeenDeleted'] = "All selected zone have been deleted";
$GLOBALS['strZoneHasBeenDuplicated'] = "Zone <a href='%s'>%s</a> has been copied to <a href='%s'>%s</a>";
$GLOBALS['strZoneHasBeenMoved'] = "Zone <b>%s</b> has been moved to website <b>%s</b>";
$GLOBALS['strZoneLinkedBanner'] = "Banner has been linked to zone <a href='%s'>%s</a>";
$GLOBALS['strZoneLinkedCampaign'] = "Campaign has been linked to zone <a href='%s'>%s</a>";
$GLOBALS['strZoneRemovedBanner'] = "Banner has been unlinked from zone <a href='%s'>%s</a>";
$GLOBALS['strZoneRemovedCampaign'] = "Campaign has been unlinked from zone <a href='%s'>%s</a>";

$GLOBALS['strChannelHasBeenAdded'] = "Delivery rule set <a href='%s'>%s</a> has been added. <a href='%s'>Set the delivery rules.</a>";
$GLOBALS['strChannelHasBeenUpdated'] = "Delivery rule set <a href='%s'>%s</a> has been updated";
$GLOBALS['strChannelAclHasBeenUpdated'] = "Delivery options for the delivery rule set <a href='%s'>%s</a> have been updated";
$GLOBALS['strChannelHasBeenDeleted'] = "Delivery rule set <b>%s</b> has been deleted";
$GLOBALS['strChannelsHaveBeenDeleted'] = "All selected delivery rule sets have been deleted";
$GLOBALS['strChannelHasBeenDuplicated'] = "Delivery rule set <a href='%s'>%s</a> has been copied to <a href='%s'>%s</a>";

$GLOBALS['strUserPreferencesUpdated'] = "Your <b>%s</b> preferences has been updated";
$GLOBALS['strEmailChanged'] = "Your E-mail has been changed";
$GLOBALS['strPasswordChanged'] = "Your password has been changed";
$GLOBALS['strXPreferencesHaveBeenUpdated'] = "<b>%s</b> have been updated";
$GLOBALS['strXSettingsHaveBeenUpdated'] = "<b>%s</b> have been updated";
$GLOBALS['strTZPreferencesWarning'] = "However, campaign activation and expiry were not updated, nor time-based banner delivery rules.<br />You will need to update them manually if you wish them to use the new timezone";

// Report error messages
$GLOBALS['strReportErrorMissingSheets'] = "No worksheet was selected for report";
$GLOBALS['strReportErrorUnknownCode'] = "Unknown error code #";

/* ------------------------------------------------------- */
/* Keyboard shortcut assignments                           */
/* ------------------------------------------------------- */

// Reserved keys
// Do not change these unless absolutely needed
$GLOBALS['keyHome'] = "h";
$GLOBALS['keyUp'] = "u";
$GLOBALS['keyNextItem'] = ".";
$GLOBALS['keyPreviousItem'] = ",";
$GLOBALS['keyList'] = "l";

// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
$GLOBALS['keySearch'] = "s";
$GLOBALS['keyCollapseAll'] = "c";
$GLOBALS['keyExpandAll'] = "e";
$GLOBALS['keyAddNew'] = "n";
$GLOBALS['keyNext'] = "n";
$GLOBALS['keyPrevious'] = "p";
$GLOBALS['keyLinkUser'] = "u";
$GLOBALS['keyWorkingAs'] = "w";
