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


// Date & time configuration
$GLOBALS['date_format'] = "%Y年%m月%d日";
$GLOBALS['month_format'] = "%Y年%m月";
$GLOBALS['day_format'] = "%m月%d日";
$GLOBALS['week_format'] = "%Y年%W週";
$GLOBALS['weekiso_format'] = "%G年%V週";

// Formats used by PEAR Spreadsheet_Excel_Writer packate

/* ------------------------------------------------------- */
/* Translations                                          */
/* ------------------------------------------------------- */

$GLOBALS['strHome'] = "ホーム";
$GLOBALS['strHelp'] = "ヘルプ";
$GLOBALS['strStartOver'] = "やり直し";
$GLOBALS['strShortcuts'] = "ショートカット";
$GLOBALS['strActions'] = "アクション";
$GLOBALS['strAdminstration'] = "インベントリ";
$GLOBALS['strMaintenance'] = "メンテナンス";
$GLOBALS['strProbability'] = "配信ウェイト";
$GLOBALS['strInvocationcode'] = "広告表示コードの生成";
$GLOBALS['strBasicInformation'] = "基本情報";
$GLOBALS['strAppendTrackerCode'] = "トラッカーコード追加";
$GLOBALS['strOverview'] = "概要";
$GLOBALS['strSearch'] = "検索(<u>S</u>)";
$GLOBALS['strDetails'] = "詳細";
$GLOBALS['strCheckForUpdates'] = "更新のチェック";
$GLOBALS['strCompact'] = "コンパクト形式";
$GLOBALS['strUser'] = "ユーザ";
$GLOBALS['strDuplicate'] = "複製する";
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
$GLOBALS['strAverage'] = "平均";
$GLOBALS['strOverall'] = "全般";
$GLOBALS['strTotal'] = "合計";
$GLOBALS['strFrom'] = "開始";
$GLOBALS['strTo'] = "終了";
$GLOBALS['strAdd'] = "追加";
$GLOBALS['strLinkedTo'] = "リンク先";
$GLOBALS['strDaysLeft'] = "残日数";
$GLOBALS['strCheckAllNone'] = "すべてチェックする/しない";
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
// Dashboard Errors
$GLOBALS['strDashboardErrorCode'] = "エラーコード";
$GLOBALS['strDashboardSystemMessage'] = "システムメッセージ";
$GLOBALS['strDashboardErrorHelp'] = "このエラーが繰り返し発生する場合、問題の詳細を<a href='http://forum.openx.org/'>OpenXフォーラム</a>に投稿してください。";

// Priority
$GLOBALS['strPriority'] = "優先度";
$GLOBALS['strPriorityLevel'] = "優先度レベル";
$GLOBALS['strHighAds'] = "高優先広告";
$GLOBALS['strLowAds'] = "低優先広告";
$GLOBALS['strLimitations'] = "制限";
$GLOBALS['strNoLimitations'] = "配信制限が定義されていません";
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
$GLOBALS['strComments'] = "コメント";

// User access
$GLOBALS['strWorkingAs'] = "以下の通り動作します";
$GLOBALS['strWorkingAs'] = "以下の通り動作します";
$GLOBALS['strSwitchTo'] = "動作モード変更";
$GLOBALS['strWorkingFor'] = "%s とは...";
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
$GLOBALS['strCTR'] = "CTR";
$GLOBALS['strTotalClicks'] = "総クリック数";
$GLOBALS['strTotalConversions'] = "総コンバージョン数";
$GLOBALS['strDateTime'] = "日時";
$GLOBALS['strTrackerID'] = "トラッカーID";
$GLOBALS['strTrackerName'] = "トラッカー名";
$GLOBALS['strTrackerImageTag'] = "イメージタグ";
$GLOBALS['strTrackerJsTag'] = "JavaScriptタグ";
$GLOBALS['strBanners'] = "バナー";
$GLOBALS['strCampaigns'] = "キャンペーン";
$GLOBALS['strCampaignID'] = "キャンペーンID";
$GLOBALS['strCampaignName'] = "キャンペーン名";
$GLOBALS['strCountry'] = "国";
$GLOBALS['strStatsAction'] = "アクション";
$GLOBALS['strWindowDelay'] = "遅延ウィンドウ";
$GLOBALS['strStatsVariables'] = "変数";

// Finance
$GLOBALS['strFinanceMT'] = "月間賃借料";

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

if (!isset($GLOBALS['strDayShortCuts'])) {
    $GLOBALS['strDayShortCuts'] = array();
}

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
$GLOBALS['strClientHistory'] = "広告主の状況";
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
$GLOBALS['strAllowCreateAccounts'] = "このユーザによる新規契約の追加を許可する";
$GLOBALS['strAdvertiserLimitation'] = "この広告主のバナーだけをウェブページに表示する";
$GLOBALS['strAllowAuditTrailAccess'] = "このユーザに監査証跡の閲覧権限を与える";

// Campaign
$GLOBALS['strCampaign'] = "キャンペーン";
$GLOBALS['strCampaigns'] = "キャンペーン";
$GLOBALS['strAddCampaign'] = "キャンペーンの追加";
$GLOBALS['strAddCampaign_Key'] = "キャンペーンの追加 (<u>n</u>)";
$GLOBALS['strLinkedCampaigns'] = "リンク済キャンペーン";
$GLOBALS['strCampaignProperties'] = "キャンペーン詳細";
$GLOBALS['strCampaignOverview'] = "キャンペーン概要";
$GLOBALS['strCampaignHistory'] = "キャンペーン状況";
$GLOBALS['strNoCampaigns'] = "キャンペーンが定義されていません";
$GLOBALS['strConfirmDeleteCampaign'] = "このキャンペーンを本当に削除しますか？";
$GLOBALS['strConfirmDeleteCampaigns'] = "このキャンペーンを本当に削除しますか？";
$GLOBALS['strShowParentAdvertisers'] = "親キャンペーンの表示";
$GLOBALS['strHideParentAdvertisers'] = "親キャンペーンの非表示";
$GLOBALS['strHideInactiveCampaigns'] = "非アクティブなキャンペーンを隠す";
$GLOBALS['strInactiveCampaignsHidden'] = "件の非アクティブなキャンペーンを隠しています。";
$GLOBALS['strPriorityInformation'] = "他のキャンペーンに対する優先度";
$GLOBALS['strHiddenCampaign'] = "キャンペーン";
$GLOBALS['strHiddenAd'] = "広告";
$GLOBALS['strHiddenAdvertiser'] = "広告主";
$GLOBALS['strHiddenTracker'] = "トラッカー";
$GLOBALS['strHiddenWebsite'] = "Webサイト";
$GLOBALS['strHiddenZone'] = "ゾーン";
$GLOBALS['strCampaignDelivery'] = "キャンペーンの配信";
$GLOBALS['strCompanionPositioning'] = "キャンペーンランキング";
$GLOBALS['strSelectUnselectAll'] = "すべて選択する/解除する";

// Campaign-zone linking page


// Campaign properties
$GLOBALS['strDontExpire'] = "このキャンペーンの終了日を指定しない";
$GLOBALS['strActivateNow'] = "このキャンペーンを今すぐアクティブにする";
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
$GLOBALS['strContract'] = "担当者名";
$GLOBALS['strStandardContract'] = "担当者名";

// Tracker
$GLOBALS['strTracker'] = "トラッカー";
$GLOBALS['strTrackers'] = "トラッカー";
$GLOBALS['strTrackerPreferences'] = "トラッカープリファレンス";
$GLOBALS['strAddTracker'] = "トラッカーの追加";
$GLOBALS['strNoTrackers'] = "トラッカーは1件も定義されていません";
$GLOBALS['strConfirmDeleteTrackers'] = "このトラッカーを本当に削除しますか？";
$GLOBALS['strConfirmDeleteTracker'] = "このトラッカーを本当に削除しますか？";
$GLOBALS['strTrackerProperties'] = "トラッカーの詳細";
$GLOBALS['strDefaultStatus'] = "デフォルトステータス";
$GLOBALS['strStatus'] = "ステータス";
$GLOBALS['strLinkedTrackers'] = "リンク済トラッカー";
$GLOBALS['strConversionWindow'] = "コンバージョン ウィンドウ";
$GLOBALS['strUniqueWindow'] = "ユニーク ウィンドウ";
$GLOBALS['strClick'] = "クリック";
$GLOBALS['strView'] = "ビュー";
$GLOBALS['strConversionType'] = "コンバージョンタイプ";
$GLOBALS['strLinkCampaignsByDefault'] = "デフォルトで新規キャンペーンにリンクする";

// Banners (General)
$GLOBALS['strBanner'] = "バナー";
$GLOBALS['strBanners'] = "バナー";
$GLOBALS['strAddBanner'] = "バナーの追加";
$GLOBALS['strAddBanner_Key'] = "バナーの追加 (<u>n</u>)";
$GLOBALS['strBannerToCampaign'] = "対象キャンペーン";
$GLOBALS['strShowBanner'] = "バナーの表示";
$GLOBALS['strBannerProperties'] = "バナーの詳細";
$GLOBALS['strBannerHistory'] = "バナーの状況";
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
$GLOBALS['strBannerWeight'] = "バナーウェイト";
$GLOBALS['strAdserverTypeGeneric'] = "汎用HTMLバナー";
$GLOBALS['strGenericOutputAdServer'] = "汎用Adserver";
$GLOBALS['strSwfTransparency'] = "背景の透過を許可する";

// Banner (advanced)

// Banner (swf)
$GLOBALS['strCheckSWF'] = "Flashファイル内でハードコーデッドリンクを使うにはチェックしてください";
$GLOBALS['strConvertSWFLinks'] = "Flashリンクに変換";
$GLOBALS['strHardcodedLinks'] = "ハードコーデッドリンク";
$GLOBALS['strCompressSWF'] = "ダウンロード時間を短くするため、Flashファイルを圧縮する(Flash6プレーヤー以降が必要)";
$GLOBALS['strOverwriteSource'] = "ソースパラメータを上書きする";

// Display limitations
$GLOBALS['strModifyBannerAcl'] = "配信オプション";
$GLOBALS['strACL'] = "広告配信";
$GLOBALS['strACLAdd'] = "配信制限の追加";
$GLOBALS['strNoLimitations'] = "配信制限が定義されていません";
$GLOBALS['strApplyLimitationsTo'] = "配信制限を適用する";
$GLOBALS['strRemoveAllLimitations'] = "すべての配信制限を削除";
$GLOBALS['strEqualTo'] = "一致する";
$GLOBALS['strDifferentFrom'] = "一致しない";
$GLOBALS['strGreaterThan'] = "以下よりも大きい";
$GLOBALS['strLessThan'] = "以下よりも少ない";
$GLOBALS['strAND'] = "かつ";                          // logical operator
$GLOBALS['strOR'] = "または";                         // logical operator
$GLOBALS['strOnlyDisplayWhen'] = "バナー表示日時:";
$GLOBALS['strWeekDays'] = "平日";
$GLOBALS['strSource'] = "ソースパラメータ";
$GLOBALS['strDeliveryLimitations'] = "配信先";

$GLOBALS['strDeliveryCappingReset'] = "カウンタリセット条件：";
$GLOBALS['strDeliveryCappingTotal'] = "総配信数";
$GLOBALS['strDeliveryCappingSession'] = "／セッション";

if (!isset($GLOBALS['strCappingBanner'])) {
    $GLOBALS['strCappingBanner'] = array();
}
$GLOBALS['strCappingBanner']['limit'] = "バナービュー上限数";

if (!isset($GLOBALS['strCappingCampaign'])) {
    $GLOBALS['strCappingCampaign'] = array();
}
$GLOBALS['strCappingCampaign']['limit'] = "キャンペーンビュー上限数";

if (!isset($GLOBALS['strCappingZone'])) {
    $GLOBALS['strCappingZone'] = array();
}
$GLOBALS['strCappingZone']['limit'] = "ゾーンビュー上限数";

// Website
$GLOBALS['strAffiliate'] = "Webサイト";
$GLOBALS['strAffiliates'] = "Webサイト";
$GLOBALS['strAffiliatesAndZones'] = "Webサイト＆ゾーン";
$GLOBALS['strAddNewAffiliate'] = "Webサイトの追加";
$GLOBALS['strAffiliateProperties'] = "Webサイトの詳細";
$GLOBALS['strAffiliateHistory'] = "Webサイトの状況";
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
$GLOBALS['strZonesOfWebsite'] = '内の'; //this is added between page name and website name eg. 'Zones in www.example.com'


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
$GLOBALS['strConnectionType'] = "タイプ";
$GLOBALS['strStatusPending'] = "保留";
$GLOBALS['strStatusDuplicate'] = "複製する";
$GLOBALS['strConnectionType'] = "タイプ";
$GLOBALS['strShortcutEditStatuses'] = "ステータスを変更する";
$GLOBALS['strShortcutShowStatuses'] = "ステータスを見る";

// Statistics
$GLOBALS['strStats'] = "統計";
$GLOBALS['strNoStats'] = "利用可能な統計データはありません。";
$GLOBALS['strNoStatsForPeriod'] = "%s から %s の期間に利用可能な統計データはありません。";
$GLOBALS['strGlobalHistory'] = "活動概況";
$GLOBALS['strDailyHistory'] = "日別状況";
$GLOBALS['strDailyStats'] = "日別統計";
$GLOBALS['strWeeklyHistory'] = "週間状況";
$GLOBALS['strMonthlyHistory'] = "月間状況";
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
$GLOBALS['strPeriod'] = "期限";
$GLOBALS['strLimitations'] = "制限";

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


// Errors
$GLOBALS['strErrorCantConnectToDatabase'] = "重大なエラーが発生しました。{$PRODUCT_NAME}はデータベースに接続できません。このため、管理者インタフェースにアクセスできません。バナー配信に影響があるかもしれません。想定される理由は次のとおりです:<ul><li>データベースサーバが一時的に利用できない状態になっている</li><li>データベースサーバのホスト名やIPアドレスが変更された</li><li>データベース接続用ユーザ名とパスワードが間違っている</li><li>PHPがMySQL拡張プラグインをロードしていない</li></ul>";
$GLOBALS['strNoMatchesFound'] = "一致するものは見つかりません";
$GLOBALS['strErrorOccurred'] = "エラーが発生しました";
$GLOBALS['strErrorDBPlain'] = "データベースにアクセス中にエラーが発生しました。";
$GLOBALS['strErrorDBSerious'] = "データベースに致命的な問題を検出しました。";
$GLOBALS['strErrorDBCorrupt'] = "データベーステーブルがおそらく破損しており、修復する必要があります。破損したテーブルの詳しい修復方法は、<i>管理者ガイド</i>の<i>トラブルシューティング</i>を読んでください。";
$GLOBALS['strErrorDBContact'] = "このサーバのシステム管理者に連絡して、問題を報告してください。";
$GLOBALS['strErrorLinkingBanner'] = "バナーとゾーンをリンク中にエラーが発生しました:";
$GLOBALS['strUnableToLinkBanner'] = "リンクできません：";
$GLOBALS['strErrorEditingCampaignRevenue'] = "利益情報のフィールドに無効な数値が入力されています。";
$GLOBALS['strErrorEditingZone'] = "更新したゾーンにエラーが発生：";
$GLOBALS['strUnableToChangeZone'] = "以下の理由により、この変更を適用できませんでした：";
$GLOBALS['strDatesConflict'] = "日間、競合中：";
$GLOBALS['strWarningInaccurateStats'] = "統計データが非UTCタイムゾーンで記録されているため、正しいタイムゾーンで表示されない恐れがあります。";
$GLOBALS['strWarningInaccurateReadMore'] = "詳細は、こちら";
$GLOBALS['strWarningInaccurateReport'] = "統計データが非UTCタイムゾーンで記録されているため、正しいタイムゾーンで表示されない恐れがあります。";

//Validation

// Email
$GLOBALS['strSirMadam'] = "様";
$GLOBALS['strMailSubject'] = "レポートの送信";
$GLOBALS['strMailBannerStats'] = "{clientname}に関するバナー統計は次のとおりです:";
$GLOBALS['strMailBannerActivatedSubject'] = "キャンペーン開始";
$GLOBALS['strMailBannerDeactivatedSubject'] = "キャンペーン停止";
$GLOBALS['strMailBannerDeactivated'] = "以下のキャンペーンが停止しました。";
$GLOBALS['strClientDeactivated'] = "次のキャンペーンは、アクティブではありません。";
$GLOBALS['strBeforeActivate'] = "開始前キャンペーン　　　　：";
$GLOBALS['strAfterExpire'] = "終了済キャンペーン　　　　：";
$GLOBALS['strNoMoreImpressions'] = "残インプレッション数＝ゼロ：";
$GLOBALS['strNoMoreClicks'] = "残クリック数＝ゼロ　　　　：";
$GLOBALS['strNoMoreConversions'] = "残コンバージョン数＝ゼロ　：";
$GLOBALS['strWeightIsNull'] = "ウェイト設定＝ゼロ　　　　：";
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
$GLOBALS['strECPM'] = "ECPM";
$GLOBALS['strPendingConversions'] = "保留されているコンバージョン数";
$GLOBALS['strImpressionSR'] = "インプレッションSR";
$GLOBALS['strClickSR'] = "クリックSR";

// Short names
$GLOBALS['strRevenue_short'] = "収益";
$GLOBALS['strBasketValue_short'] = "バスケット値";
$GLOBALS['strNumberOfItems_short'] = "アイテム数";
$GLOBALS['strRevenueCPC_short'] = "収益CPC";
$GLOBALS['strRequests_short'] = "収益";
$GLOBALS['strClicks_short'] = "クリック数";
$GLOBALS['strConversions_short'] = "コンバージョン数";
$GLOBALS['strPendingConversions_short'] = "保留コンバージョン数";
$GLOBALS['strClickSR_short'] = "クリックSR";

// Global Settings
$GLOBALS['strGlobalSettings'] = "全般設定";
$GLOBALS['strGeneralSettings'] = "全般設定";
$GLOBALS['strMainSettings'] = "メイン設定";

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

// Channels
$GLOBALS['strChannel'] = "ターゲットチャンネル";
$GLOBALS['strChannels'] = "ターゲットチャンネル";
$GLOBALS['strChannelManagement'] = "ターゲットチャンネル管理";
$GLOBALS['strAddNewChannel'] = "ターゲットチャンネルを追加";
$GLOBALS['strAddNewChannel_Key'] = "新しいターゲットチャンネルを追加する(<u>n</u>)";
$GLOBALS['strChannelToWebsite'] = "すべてのWebサイト";
$GLOBALS['strNoChannels'] = "チャンネルが存在しません";
$GLOBALS['strNoChannelsAddWebsite'] = "Webサイトが存在しません。広告枠を作成する前に、先に<a href='affiliate-edit.php'>Webサイトを作成</a>して下さい。";
$GLOBALS['strEditChannelLimitations'] = "ターゲットチャンネルの制限を変更する";
$GLOBALS['strChannelProperties'] = "ターゲットチャンネルの設定";
$GLOBALS['strChannelLimitations'] = "配信オプション";
$GLOBALS['strConfirmDeleteChannel'] = "このチャンネルを本当に削除しますか？";
$GLOBALS['strConfirmDeleteChannels'] = "このチャンネルを本当に削除しますか？";
$GLOBALS['strChannelsOfWebsite'] = '内の'; //this is added between page name and website name eg. 'Targeting channels in www.example.com'

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
$GLOBALS['strPasswordRecovery'] = "パスワードのリカバリ";
$GLOBALS['strEmailRequired'] = "メールアドレスは必須です。";
$GLOBALS['strPwdRecEmailNotFound'] = "指定したメールアドレスは見つかりませんでした。";
$GLOBALS['strPwdRecWrongId'] = "メールアドレスが間違っています。";
$GLOBALS['strPwdRecEnterEmail'] = "メールアドレスを入力してください";
$GLOBALS['strPwdRecEnterPassword'] = "新しいパスワードを入力してください";
$GLOBALS['strPwdRecResetLink'] = "パスワードをリセットするには、次のURLをクリックしてください。";
$GLOBALS['strPwdRecEmailPwdRecovery'] = "%s ログインパスワードのリカバリ";
$GLOBALS['strProceed'] = "続ける &gt;";
$GLOBALS['strNotifyPageMessage'] = "パスワードをリセットするためのメールが送信されました。<br />もし届いてない場合は迷惑メールと見なされているか、Eメールの設定を見直して下さい。<br /><a href='index.php'>トップに戻る</a>";

// Audit
$GLOBALS['strAdditionalItems'] = "追加内容";
$GLOBALS['strHas'] = "\\=";
$GLOBALS['strBinaryData'] = "バイナリデータ";
$GLOBALS['strAuditTrailDisabled'] = "管理者によって追跡記録が無効となりました。現在ログは取得されていません。また追跡記録のリストも表示されません。";

// Widget - Audit
$GLOBALS['strAuditNoData'] = "指定期間内のユーザ活動記録はありません。";
$GLOBALS['strAuditTrail'] = "追跡記録";
$GLOBALS['strAuditTrailSetup'] = "本日の追跡記録を設定する";
$GLOBALS['strAuditTrailGoTo'] = "追跡記録ページに移動する";

// Widget - Campaign
$GLOBALS['strCampaignGoTo'] = "キャンペーンのページに飛ぶ";
$GLOBALS['strCampaignSetUp'] = "本日のキャンペーンを設定する";
$GLOBALS['strCampaignNoRecordsAdmin'] = "<li>このキャンペーンには活動記録がありません</li>";

$GLOBALS['strCampaignNoDataTimeSpan'] = "選択した期間内において、開始されるキャンペーンもしくは終了するキャンペーンはありません。";
$GLOBALS['strCampaignAuditTrailSetup'] = "キャンペーンの活動状況を確認するため、追跡記録をアクティブにする";

$GLOBALS['strUnsavedChanges'] = "変更が保存されていません。\"保存する\"ボタンを押してください。";
$GLOBALS['strDeliveryLimitationsDisagree'] = "注意：配信エンジン制限です。<strong>絶対に</strong>以下の制限を承認しないでください<br />配信エンジンのルールを保存してください。";

//confirmation messages










// Report error messages

/* ------------------------------------------------------- */
/* Keyboard shortcut assignments                           */
/* ------------------------------------------------------- */

// Reserved keys
// Do not change these unless absolutely needed

// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
