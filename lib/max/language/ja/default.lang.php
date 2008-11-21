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

// Set text direction and characterset
$GLOBALS['phpAds_TextDirection']				= "ltr";
$GLOBALS['phpAds_TextAlignRight']       		= "right";
$GLOBALS['phpAds_TextAlignLeft']        		= "left";
$GLOBALS['phpAds_CharSet']              		= "UTF-8";

$GLOBALS['phpAds_DecimalPoint']         		= '.';
$GLOBALS['phpAds_ThousandsSeperator']   		= ',';

// Date & time configuration
$GLOBALS['date_format']                 		= "%Y年%m月%d日";
$GLOBALS['time_format']                 		= "%H:%M:%S";
$GLOBALS['minute_format']               		= "%H:%M";
$GLOBALS['month_format']                		= "%Y年%m月";
$GLOBALS['day_format']                  		= "%m月%d日";
$GLOBALS['week_format']                 		= "%Y年%W週";
$GLOBALS['weekiso_format']              		= "%G年%V週";

// Formats used by PEAR Spreadsheet_Excel_Writer packate
$GLOBALS['excel_integer_formatting']    		= '#,##0;-#,##0;-';
$GLOBALS['excel_decimal_formatting']    		= '#,##0.000;-#,##0.000;-';

/*-------------------------------------------------------*/
/* Translations                                          */
/*-------------------------------------------------------*/

$GLOBALS['strHome']                     		= "ホーム";
$GLOBALS['strHelp']                     		= "ヘルプ";
$GLOBALS['strStartOver']                		= "やり直し";
$GLOBALS['strNavigation']               		= "ナビゲーション";
$GLOBALS['strShortcuts']                		= "ショートカット";
$GLOBALS['strAdminstration']            		= "インベントリ";
$GLOBALS['strMaintenance']              		= "メンテナンス";
$GLOBALS['strProbability']              		= "配信ウェイト";
$GLOBALS['strInvocationcode']           		= "広告表示コードの生成";
$GLOBALS['strTrackerVariables']         		= "トラッカー変数";
$GLOBALS['strBasicInformation']         		= "基本情報";
$GLOBALS['strContractInformation']      		= "契約情報";
$GLOBALS['strLoginInformation']         		= "ログイン情報";
$GLOBALS['strLogoutURL']                		= 'ログアウト後の飛び先URL<br />空白の場合、デフォルトとなります。';
$GLOBALS['strAppendTrackerCode']        		= "トラッカーコード追加";
$GLOBALS['strOverview']                 		= "概要";
$GLOBALS['strSearch']                   		= "検索(<u>S</u>)";
$GLOBALS['strHistory']                  		= "状況";
$GLOBALS['strDetails']                  		= "詳細";
$GLOBALS['strSyncSettings']             		= "ソフトウェア更新設定";
$GLOBALS['strCompact']                  		= "コンパクト形式";
$GLOBALS['strVerbose']                  		= "冗長形式";
$GLOBALS['strUser']                     		= "ユーザ";
$GLOBALS['strEdit']                     		= "編集する";
$GLOBALS['strCreate']                   		= "作成する";
$GLOBALS['strDuplicate']                		= "複製する";
$GLOBALS['strMoveTo']                   		= "移動する";
$GLOBALS['strDelete']                   		= "削除";
$GLOBALS['strActivate']                 		= "アクティブにする";
$GLOBALS['strDeActivate']               		= "非アクティブにする";
$GLOBALS['strConvert']                  		= "変換する";
$GLOBALS['strRefresh']                  		= "リフレッシュする";
$GLOBALS['strSaveChanges']              		= "変更の保存";
$GLOBALS['strUp']                       		= "上へ";
$GLOBALS['strDown']                     		= "下へ";
$GLOBALS['strSave']                     		= "保存";
$GLOBALS['strCancel']                   		= "取消";
$GLOBALS['strBack']                     		= "戻る";
$GLOBALS['strPrevious']                 		= "前へ";
$GLOBALS['strPrevious_Key']             		= "前へ(<u>P</u>)";
$GLOBALS['strNext']                     		= "次へ";
$GLOBALS['strNext_Key']                 		= "次へ(<u>N</u>)";
$GLOBALS['strYes']                      		= "はい";
$GLOBALS['strNo']                       		= "いいえ";
$GLOBALS['strNone']                     		= "なし";
$GLOBALS['strCustom']                   		= "カスタム";
$GLOBALS['strDefault']                  		= "デフォルト";
$GLOBALS['strOther']                    		= "その他";
$GLOBALS['strUnknown']                  		= "不明";
$GLOBALS['strUnlimited']                		= "無制限";
$GLOBALS['strUntitled']                 		= "名称未設定";
$GLOBALS['strAll']                      		= "すべて";
$GLOBALS['strAvg']                      		= "平均";
$GLOBALS['strAverage']                  		= "平均";
$GLOBALS['strOverall']                  		= "全般";
$GLOBALS['strTotal']                    		= "合計";
$GLOBALS['strUnfilteredTotal']          		= "合計(フィルタ前)";
$GLOBALS['strFilteredTotal']            		= "合計(フィルタ後)";
$GLOBALS['strActive']                   		= "アクティブ";
$GLOBALS['strFrom']                     		= "開始";
$GLOBALS['strTo']                       		= "終了";
$GLOBALS['strLinkedTo']                 		= "リンク先";
$GLOBALS['strDaysLeft']                 		= "残日数";
$GLOBALS['strCheckAllNone']             		= "すべてチェックする/しない";
$GLOBALS['strKiloByte']                 		= "KB";
$GLOBALS['strExpandAll']                		= "すべて展開 (<u>E</u>)";
$GLOBALS['strCollapseAll']              		= "すべて閉じる(<u>C</u>)";
$GLOBALS['strShowAll']                    		= "すべて表示";
$GLOBALS['strNoAdminInteface']            		= "メンテナンスのため、管理画面機能が無効になっています。広告の配信には何ら影響はありません。";
$GLOBALS['strFilterBySource']            		= "ソースパラメータによるフィルタ";
$GLOBALS['strFieldStartDateBeforeEnd']  		= "\'開始日'は、'終了日'以前の日付である必要があります";
$GLOBALS['strFieldContainsErrors']        		= "エラー項目は次のとおりです:";
$GLOBALS['strFieldFixBeforeContinue1']    		= "継続するには、表示されている";
$GLOBALS['strFieldFixBeforeContinue2']    		= "エラー項目を訂正してください。";
$GLOBALS['strDelimiter']                		= "デリミタ";
$GLOBALS['strMiscellaneous']            		= "その他";
$GLOBALS['strCollectedAllStats']        		= "すべての統計";
$GLOBALS['strCollectedToday']					= "本日の統計";
$GLOBALS['strCollectedYesterday']				= "昨日の統計";
$GLOBALS['strCollectedThisWeek']        		= "今週の統計";
$GLOBALS['strCollectedLastWeek']        		= "先週の統計";
$GLOBALS['strCollectedThisMonth']				= "今月の統計";
$GLOBALS['strCollectedLastMonth']				= "先月の統計";
$GLOBALS['strCollectedLast7Days']				= "過去７日間の統計";
$GLOBALS['strCollectedSpecificDates']			= "範囲指定";
$GLOBALS['strDifference']               		= '変動(%)';
$GLOBALS['strPercentageOfTotal']        		= '合計(%)';
$GLOBALS['strValue']                    		= '数値';
$GLOBALS['strAdmin']                    		= "管理者";
$GLOBALS['strWarning']                  		= '警告';
$GLOBALS['strNotice']                   		= 'お知らせ';

// Dashboard
$GLOBALS['strDashboardCommunity']       		= 'コミュニティ';
$GLOBALS['strDashboardDashboard']       		= 'ダッシュボード';
$GLOBALS['strDashboardForum']           		= 'OpenXフォーラム';
$GLOBALS['strDashboardDocs']            		= 'OpenX Docs';

// Priority
$GLOBALS['strPriority']                 		= "優先度";
$GLOBALS['strPriorityLevel']            		= "優先度レベル";
$GLOBALS['strPriorityTargeting']        		= "配信方法";
$GLOBALS['strPriorityOptimisation']     		= "その他";
$GLOBALS['strExclusiveAds']             		= "独占広告";
$GLOBALS['strHighAds']                  		= "高優先広告";
$GLOBALS['strLowAds']                   		= "低優先広告";
$GLOBALS['strLimitations']              		= "制限";
$GLOBALS['strNoLimitations']            		= "配信制限が定義されていません";
$GLOBALS['strCapping']                  		= '制限';
$GLOBALS['strCapped']                   		= '上限設定済';
$GLOBALS['strNoCapping']                		= '非上限設定';

// Properties
$GLOBALS['strName']								= "名称";
$GLOBALS['strSize']								= "サイズ";
$GLOBALS['strWidth'] 							= "幅";
$GLOBALS['strHeight'] 							= "高さ";
$GLOBALS['strURL2']								= "URL";
$GLOBALS['strTarget']							= "ターゲット（空欄可/_top/_blank）";
$GLOBALS['strLanguage'] 						= "言語";
$GLOBALS['strDescription'] 						= "記事";
$GLOBALS['strVariables']                		= "変数";
$GLOBALS['strID']                       		= "ID";
$GLOBALS['strComments']                 		= "コメント";

// User access
$GLOBALS['strWorkingAs']                		= '以下の通り動作します';
$GLOBALS['strWorkingFor']               		= '%s とは...';
$GLOBALS['strLinkUser']                 		= "ユーザを追加";
$GLOBALS['strLinkUser_Key']             		= "ユーザを追加する(<u>u</u>)";
$GLOBALS['strUsernameToLink']           		= "追加するユーザの氏名";
$GLOBALS['strEmailToLink']              		= "追加するユーザのメールアドレス";
$GLOBALS['strNewUserWillBeCreated']     		= "新しいユーザを作成します";
$GLOBALS['strToLinkProvideEmail']       		= "ユーザを追加するには、メールアドレスを入力してください。";
$GLOBALS['strToLinkProvideUsername']    		= "ユーザを追加するには、ユーザ名を入力してください";
$GLOBALS['strErrorWhileCreatingUser']   		= "ユーザ作成エラー： %s";
$GLOBALS['strUserLinkedToAccount']      		= 'ユーザがアカウントに追加されました。';
$GLOBALS['strUserAccountUpdated']       		= '更新したユーザアカウント';
$GLOBALS['strUserUnlinkedFromAccount']  		= 'ユーザがアカウントから削除されました。';
$GLOBALS['strUserWasDeleted']           		= 'ユーザが削除されました。';
$GLOBALS['strUserNotLinkedWithAccount'] 		= 'そのユーザはアカウントに関連づいていません';
$GLOBALS['strCantDeleteOneAdminUser']   		= 'ユーザを削除できません。少なくとも一人が管理者である必要があります。';
$GLOBALS['strLinkUserHelp']             		= '<b>既に存在するユーザ</b>を追加する場合、%s と入力して、{$GLOBALS[\'strLinkUser\']} をクリックしてください。<br /> <b>新規ユーザ</b>を追加するが場合は、好きな%sを入力して、{$GLOBALS[\'strLinkUser\']}をクリックしてください。';
$GLOBALS['strLinkUserHelpUser']         		= 'ユーザ名';
$GLOBALS['strLinkUserHelpEmail']        		= 'Eメールアドレス';

// Login & Permissions
$GLOBALS['strUserAccess']               		= "ユーザアクセス";
$GLOBALS['strAdminAccess']              		= "管理者アクセス";
$GLOBALS['strUserProperties']           		= "ユーザプリファレンス";
$GLOBALS['strLinkNewUser']              		= "ユーザリンクの作成";
$GLOBALS['strPermissions']              		= "ユーザ権限";
$GLOBALS['strAuthentification'] 				= "ユーザ認証";
$GLOBALS['strWelcomeTo']						= "ようこそ！";
$GLOBALS['strEnterUsername']					= "ユーザー名とパスワードを入力してログインしてください。";
$GLOBALS['strEnterBoth']						= "ユーザー名とパスワードの両方を入力してください";
$GLOBALS['strEnableCookies']					= "". MAX_PRODUCT_NAME ."を使うには、クッキーを有効にして下さい。";
$GLOBALS['strSessionIDNotMatch']        		= "セッションエラーが発生しましｓた。再度ログインしてください";
$GLOBALS['strLogin'] 							= "ログイン";
$GLOBALS['strLogout'] 							= "ログアウト";
$GLOBALS['strUsername'] 						= "ユーザー名";
$GLOBALS['strPassword']							= "パスワード";
$GLOBALS['strPasswordRepaet']           		= "パスワード（再入力）";
$GLOBALS['strAccessDenied']						= "アクセスが拒否されました。";
$GLOBALS['strUsernameOrPasswordWrong']  		= "ユーザ名かパスワードが間違っています。再入力してください。";
$GLOBALS['strPasswordWrong']					= "パスワードが正しくありません。";
$GLOBALS['strParametersWrong']          		= "入力した値に間違いがあります。";
$GLOBALS['strNotAdmin']							= "この操作を行う権限がありません。適切な権限を有するユーザ名で再度ログインしてください。ログアウトは、<a href='logout.php'>こちら</a>。";
$GLOBALS['strDuplicateClientName']				= "入力されたユーザー名は既に存在します。異なるユーザー名を使用してください。";
$GLOBALS['strDuplicateAgencyName']      		= "入力されたユーザー名は既に存在します。異なるユーザー名を使用してください。";
$GLOBALS['strInvalidPassword']					= "新しいパスワードは無効です。異なるパスワードを使用してください。";
$GLOBALS['strInvalidEmail']             		= "入力されたメールアドレスは、正しい形式ではありません。正しい形式で再度入力してください。";
$GLOBALS['strNotSamePasswords']					= "入力された２つのパスワードは同じではありません。";
$GLOBALS['strRepeatPassword']					= "パスワード(再度)";
$GLOBALS['strOldPassword']						= "旧パスワード";
$GLOBALS['strNewPassword']						= "新パスワード";
$GLOBALS['strNoBannerId']               		= "バナーIDがありません";

// General advertising
$GLOBALS['strRequests']                 		= 'リクエスト数';
$GLOBALS['strImpressions']              		= "インプレッション数";
$GLOBALS['strClicks']                   		= "クリック数";
$GLOBALS['strConversions']              		= "コンバージョン数";
$GLOBALS['strCTRShort']                 		= "CTR";
$GLOBALS['strCTRShortHigh']             		= "CTRを高く";
$GLOBALS['strCTRShortLow']              		= "CTRを低く";
$GLOBALS['strCNVRShort']                		= "SR";
$GLOBALS['strCTR']                      		= "CTR";
$GLOBALS['strCNVR']                     		= "コンバージョン率";
$GLOBALS['strCPC']                      		= "クリック単価";
$GLOBALS['strCPCo']                     		= "コンバージョン単価";
$GLOBALS['strCPCoShort']                		= "CPCo";
$GLOBALS['strCPCShort']                 		= "CPC";
$GLOBALS['strTotalCost']                		= "総費用";
$GLOBALS['strTotalViews']               		= "総インプレッション数";
$GLOBALS['strTotalClicks']              		= "総クリック数";
$GLOBALS['strTotalConversions']         		= "総コンバージョン数";
$GLOBALS['strViewCredits']              		= "インプレッション保証数";
$GLOBALS['strClickCredits']             		= "クリック保証数";
$GLOBALS['strConversionCredits']        		= "コンバージョン保証数";
$GLOBALS['strImportStats']              		= "インポート統計";
$GLOBALS['strDateTime']                 		= "日時";
$GLOBALS['strTrackerID']                		= "トラッカーID";
$GLOBALS['strTrackerName']              		= "トラッカー名";
$GLOBALS['strCampaignID']               		= "キャンペーンID";
$GLOBALS['strCampaignName']             		= "キャンペーン名";
$GLOBALS['strCountry']                  		= "国";
$GLOBALS['strStatsAction']              		= "アクション";
$GLOBALS['strWindowDelay']              		= "遅延ウィンドウ";
$GLOBALS['strStatsVariables']           		= "変数";

// Finance
$GLOBALS['strFinanceCPM']               		= 'CPM';
$GLOBALS['strFinanceCPC']               		= 'CPC';
$GLOBALS['strFinanceCPA']               		= 'CPA';
$GLOBALS['strFinanceMT']                		= '月間賃借料';

// Time and date related
$GLOBALS['strDate'] 							= "日付";
$GLOBALS['strToday'] 							= "今日";
$GLOBALS['strDay']								= "日";
$GLOBALS['strDays']								= "日間";
$GLOBALS['strLast7Days']						= "直近７日";
$GLOBALS['strWeek'] 							= "週";
$GLOBALS['strWeeks']							= "週";
$GLOBALS['strSingleMonth']              		= "月";
$GLOBALS['strMonths']							= "月";
$GLOBALS['strDayOfWeek']                		= "曜日";
$GLOBALS['strThisMonth'] 						= "今月";
$GLOBALS['strMonth'][0] = "1月";
$GLOBALS['strMonth'][1] = "2月";
$GLOBALS['strMonth'][2] = "3月";
$GLOBALS['strMonth'][3] = "4月";
$GLOBALS['strMonth'][4] = "5月";
$GLOBALS['strMonth'][5] = "6月";
$GLOBALS['strMonth'][6] = "7月";
$GLOBALS['strMonth'][7] = "8月";
$GLOBALS['strMonth'][8] = "9月";
$GLOBALS['strMonth'][9] = "10月";
$GLOBALS['strMonth'][10] = "11月";
$GLOBALS['strMonth'][11] = "12月";

$GLOBALS['strDayFullNames'][0] = "日曜日";
$GLOBALS['strDayFullNames'][1] = "月曜日";
$GLOBALS['strDayFullNames'][2] = "火曜日";
$GLOBALS['strDayFullNames'][3] = "水曜日";
$GLOBALS['strDayFullNames'][4] = "木曜日";
$GLOBALS['strDayFullNames'][5] = "金曜日";
$GLOBALS['strDayFullNames'][6] = "土曜日";

$GLOBALS['strDayShortCuts'][0] = "日";
$GLOBALS['strDayShortCuts'][1] = "月";
$GLOBALS['strDayShortCuts'][2] = "火";
$GLOBALS['strDayShortCuts'][3] = "水";
$GLOBALS['strDayShortCuts'][4] = "木";
$GLOBALS['strDayShortCuts'][5] = "金";
$GLOBALS['strDayShortCuts'][6] = "土";

$GLOBALS['strHour']								= "時";
$GLOBALS['strHourFilter']               		= "時間指定";
$GLOBALS['strSeconds']							= "秒間";
$GLOBALS['strMinutes']							= "分間";
$GLOBALS['strHours']							= "時間";
$GLOBALS['strTimes']							= "回";

// Advertiser
$GLOBALS['strClient']							= "広告主";
$GLOBALS['strClients'] 							= "広告主";
$GLOBALS['strClientsAndCampaigns']				= "広告主＆キャンペーン";
$GLOBALS['strAddClient'] 						= "広告主の追加";
$GLOBALS['strAddClient_Key'] 					= "広告主の追加 (<u>n</u>)";
$GLOBALS['strTotalClients'] 					= "総広告主数";
$GLOBALS['strClientProperties']					= "広告主の詳細";
$GLOBALS['strClientHistory']					= "広告主の状況";
$GLOBALS['strNoClients']						= "広告主が存在しません。キャンペーンを作成するためには、先に<a href='advertiser-edit.php'>広告主の作成</a>をして下さい。";
$GLOBALS['strConfirmDeleteClient'] 				= "この広告主を本当に削除しますか？";
$GLOBALS['strConfirmResetClientStats']			= "この広告主に関する統計データを本当に削除しますか?";
$GLOBALS['strSite']                         	= 'サイズ';
$GLOBALS['strHideInactive']                 	= "非アクティブなものを隠す";
$GLOBALS['strHideInactiveAdvertisers']			= "非アクティブな広告主を隠す";
$GLOBALS['strInactiveAdvertisersHidden']		= "件の非アクティブな広告主を隠しています";


// Advertisers properties
$GLOBALS['strContact'] 							= "担当者名";
$GLOBALS['strEMail'] 							= "メールアドレス";
$GLOBALS['strChars']                         	= "文字数";
$GLOBALS['strSendAdvertisingReport']			= "キャンペーン配信結果を電子メールで送信する";
$GLOBALS['strNoDaysBetweenReports']				= "レポートの送信間隔（日）";
$GLOBALS['strSendDeactivationWarning']  		= "キャンペーンがアクティブでなくなった時に警告メールを送信する";
$GLOBALS['strAllowClientModifyInfo'] 			= "このユーザの設定内容の修正を許可する";
$GLOBALS['strAllowClientModifyBanner'] 			= "このユーザによるバナー修正を許可する";
$GLOBALS['strAllowClientAddBanner'] 			= "このユーザによるバナー追加を許可する";
$GLOBALS['strAllowClientDisableBanner'] 		= "このユーザによるバナーの非アクティブ化を許可する";
$GLOBALS['strAllowClientActivateBanner'] 		= "このユーザによるバナーのアクティブ化を許可する";
$GLOBALS['strAllowClientViewTargetingStats']	= "このユーザによるWebサイト統計の参照を許可する";
$GLOBALS['strAllowCreateAccounts']              = "このユーザによる新規契約の追加を許可する";
$GLOBALS['strCsvImportConversions']             = "このユーザによるオフラインコンバージョンのインポートを許可する";
$GLOBALS['strAdvertiserLimitation']             = "この広告主のバナーだけをウェブページに表示する";
$GLOBALS['strAllowAuditTrailAccess']            = "このユーザに監査証跡の閲覧権限を与える";


// Campaign
$GLOBALS['strCampaign']							= "キャンペーン";
$GLOBALS['strCampaigns']						= "キャンペーン";
$GLOBALS['strTotalCampaigns'] 					= "総キャンペーン数";
$GLOBALS['strActiveCampaigns'] 					= "アクティブキャンペーン";
$GLOBALS['strAddCampaign'] 						= "キャンペーンの追加";
$GLOBALS['strAddCampaign_Key'] 					= "キャンペーンの追加 (<u>n</u>)";
$GLOBALS['strCreateNewCampaign']				= "キャンペーンの作成";
$GLOBALS['strModifyCampaign']					= "キャンペーンの修正";
$GLOBALS['strMoveToNewCampaign']				= "新キャンペーンに移動";
$GLOBALS['strBannersWithoutCampaign']			= "キャンペーン未適用バナー";
$GLOBALS['strDeleteAllCampaigns']				= "すべてのキャンペーンを削除";
$GLOBALS['strLinkedCampaigns']              	= "リンク済キャンペーン";
$GLOBALS['strCampaignStats']					= "キャンペーン統計";
$GLOBALS['strCampaignProperties']				= "キャンペーン詳細";
$GLOBALS['strCampaignOverview']					= "キャンペーン概要";
$GLOBALS['strCampaignHistory']					= "キャンペーン状況";
$GLOBALS['strNoCampaigns']						= "キャンペーンが定義されていません";
$GLOBALS['strConfirmDeleteAllCampaigns']		= "この広告主に関連するすべてのキャンペーンを本当に削除しますか？";
$GLOBALS['strConfirmDeleteCampaign']			= "このキャンペーンを本当に削除しますか？";
$GLOBALS['strConfirmResetCampaignStats']		= "このキャンペーンに関連する統計データを削除しますか？";
$GLOBALS['strShowParentAdvertisers']       		= "親キャンペーンの表示";
$GLOBALS['strHideInactiveCampaigns']			= "非アクティブなキャンペーンを隠す";
$GLOBALS['strInactiveCampaignsHidden']			= "件の非アクティブなキャンペーンを隠しています。";
$GLOBALS['strContractDetails']             		= "契約の詳細";
$GLOBALS['strInventoryDetails']            		= "広告在庫の詳細";
$GLOBALS['strPriorityInformation']         		= "他のキャンペーンに対する優先度";
$GLOBALS['strPriorityExclusive']           		= "- 他のリンク済キャンペーンを無効にする";
$GLOBALS['strPriorityHigh']                		= "- 支払済キャンペーン";
$GLOBALS['strPriorityLow']                 		= "- 無料・未払いキャンペーン";
$GLOBALS['strPriorityHighShort']           		= "高";
$GLOBALS['strPriorityLowShort']             	= "低";
$GLOBALS['strHiddenCampaign']               	= "キャンペーン";
$GLOBALS['strHiddenAd']                     	= "広告";
$GLOBALS['strHiddenAdvertiser']             	= "広告主";
$GLOBALS['strHiddenTracker']                	= "トラッカー";
$GLOBALS['strHiddenPublisher']              	= "Webサイト";
$GLOBALS['strHiddenWebsite']              		= "Webサイト";
$GLOBALS['strHiddenZone']                   	= "ゾーン";
$GLOBALS['strUnderdeliveringCampaigns']    		= "配信中のキャンペーン";
$GLOBALS['strCampaignDelivery']             	= "キャンペーンの配信";
$GLOBALS['strBookedMetric']                 	= "予約済件数";
$GLOBALS['strValueBooked']                  	= "予約数";
$GLOBALS['strRemaining']                    	= "残数";
$GLOBALS['strCompanionPositioning']         	= "キャンペーンランキング";
$GLOBALS['strSelectUnselectAll']            	= "すべて選択する/解除する";
$GLOBALS['strConfirmOverwrite']             	= "この変更を保存すると、すべてのリンクされたゾーンを上書きします。本当に保存しますか？";

// Campaign properties
$GLOBALS['strDontExpire']						= "このキャンペーンの終了日を指定しない";
$GLOBALS['strActivateNow'] 						= "このキャンペーンを今すぐアクティブにする";
$GLOBALS['strLow']								= "低";
$GLOBALS['strHigh']								= "高";
$GLOBALS['strExclusive']                		= "独占";
$GLOBALS['strExpirationDate']					= "終了日";
$GLOBALS['strExpirationDateComment']    		= "キャンペーンはこの指定日に終了します。";
$GLOBALS['strActivationDate']					= "開始日";
$GLOBALS['strActivationDateComment']    		= "キャンペーンはこの指定日に開始します。";
$GLOBALS['strRevenueInfo']              		= '利益情報';
$GLOBALS['strImpressionsRemaining']     		= "残インプレッション数";
$GLOBALS['strClicksRemaining']             		= "残クリック数";
$GLOBALS['strConversionsRemaining']     		= "残コンバージョン数";
$GLOBALS['strImpressionsBooked']         		= "インプレッション数";
$GLOBALS['strClicksBooked']             		= "クリック数";
$GLOBALS['strConversionsBooked']         		= "コンバージョン数";
$GLOBALS['strCampaignWeight']            		= "キャンペーンウェイトの設定：";
$GLOBALS['strTargetLimitAdImpressions'] 		= "インプレッション上限数";
$GLOBALS['strOptimise']                    		= "最適化";
$GLOBALS['strAnonymous']                		= "このキャンペーンに関連する広告主とWebサイトを隠す。";
$GLOBALS['strHighPriority']						= "高優先<br />高優先に割り当てられた時間帯にビューリクエスト数を均等に割り当てます。";
$GLOBALS['strLowPriority']						= "低優先<br />高優先に割り当てられていない時間帯にビューリクエスト数を均等に割り当てます。";
$GLOBALS['strTargetPerDay']						= "／日";
$GLOBALS['strPriorityAutoTargeting']			= "均等割当<br />毎日のビューリクエスト目標数をキャンペーン日数で均等に割り当てます。";
$GLOBALS['strCampaignWarningNoWeight'] 			= "優先度が'低'に設定されていますが、\nウェイトがゼロか未設定です。\nこのため、ウェイトが設定されるまでキャンペーンは無効で、\nバナーは配信されません。\n\n本当に継続しますか？";
$GLOBALS['strCampaignWarningNoTarget'] 			= "優先度が'高'に設定されていますが、\n目標ビュー数が未設定です。\nこのため、目標ビュー数が設定されるまでキャンペーンは無効で、\nバナーは配信されません。\n\n本当に継続しますか？";
$GLOBALS['strCampaignStatusRunning']       		= "配信中";
$GLOBALS['strCampaignStatusPaused']        		= "中断中";
$GLOBALS['strCampaignStatusAwaiting']      		= "待機中";
$GLOBALS['strCampaignStatusExpired']       		= "終了";
$GLOBALS['strCampaignStatusApproval']      		= "承認待ち &raquo;";
$GLOBALS['strCampaignStatusRejected']      		= "拒否";
$GLOBALS['strCampaignStatusAdded']         		= "追加済";
$GLOBALS['strCampaignStatusStarted']       		= "開始済";
$GLOBALS['strCampaignStatusRestarted']     		= "再開済";
$GLOBALS['strCampaignApprove']             		= "承認";
$GLOBALS['strCampaignApproveDescription']  		= "このキャンペーンを承認します";
$GLOBALS['strCampaignReject']              		= "拒否";
$GLOBALS['strCampaignRejectDescription']   		= "このキャンペーンを拒否します";
$GLOBALS['strCampaignPause']               		= "中断";
$GLOBALS['strCampaignPauseDescription']    		= "このキャンペーンを一時的に中断します";
$GLOBALS['strCampaignRestart']             		= "再開";
$GLOBALS['strCampaignRestartDescription']  		= "このキャンペーンを再開します";
$GLOBALS['strCampaignStatus']              		= "キャンペーン状況";
$GLOBALS['strReasonForRejection']          		= "拒否理由";
$GLOBALS['strReasonSiteNotLive']           		= "無効Webサイト";
$GLOBALS['strReasonBadCreative']           		= "無効広告クリエイティブ";
$GLOBALS['strReasonBadUrl']                		= "無効URL";
$GLOBALS['strReasonBreakTerms']            		= "規約外Webサイト";

// Tracker
$GLOBALS['strTracker']                    		= "トラッカー";
$GLOBALS['strTrackerOverview']            		= "トラッカーの概要";
$GLOBALS['strTrackerPreferences']            	= "トラッカープリファレンス";
$GLOBALS['strAddTracker']                 		= "トラッカーの追加";
$GLOBALS['strAddTracker_Key']             		= "トラッカーの追加(<u>n</u>)";
$GLOBALS['strNoTrackers']                		= "トラッカーは1件も定義されていません";
$GLOBALS['strConfirmDeleteAllTrackers']    		= "この広告主に関連するすべてのトラッカーを本当に削除しますか？";
$GLOBALS['strConfirmDeleteTracker']        		= "このトラッカーを本当に削除しますか？";
$GLOBALS['strDeleteAllTrackers']        		= "すべてのトラッカーの削除";
$GLOBALS['strTrackerProperties']        		= "トラッカーの詳細";
$GLOBALS['strTrackerOverview']            		= "トラッカーの概要";
$GLOBALS['strModifyTracker']            		= "トラッカーの修正";
$GLOBALS['strLog']                        		= "ロギングする";
$GLOBALS['strDefaultStatus']              		= "デフォルトステータス";
$GLOBALS['strStatus']                    		= "ステータス";
$GLOBALS['strLinkedTrackers']            		= "リンク済トラッカー";
$GLOBALS['strDefaultConversionRules']    		= "デフォルト コンバージョンルール";
$GLOBALS['strConversionWindow']            		= "コンバージョン ウィンドウ";
$GLOBALS['strClickWindow']                		= "クリック ウィンドウ";
$GLOBALS['strViewWindow']                		= "ビュー ウィンドウ";
$GLOBALS['strUniqueWindow']                		= "ユニーク ウィンドウ";
$GLOBALS['strClick']                    		= "クリック";
$GLOBALS['strView']                        		= "ビュー";
$GLOBALS['strArrival']                        	= "到達";
$GLOBALS['strManual']                        	= "マニュアル";
$GLOBALS['strConversionClickWindow']    		= "指定秒数以内に発生するクリックをコンバージョンにカウントする";
$GLOBALS['strConversionViewWindow']        		= "指定秒数以内に発生するビューをコンバージョンにカウントする";
$GLOBALS['strTotalTrackerImpressions']    		= "総インプレッション数";
$GLOBALS['strTotalTrackerConnections']    		= "総コネクション数";
$GLOBALS['strTotalTrackerConversions']    		= "総コンバージョン数";
$GLOBALS['strTrackerImpressions']        		= "インプレッション数";
$GLOBALS['strTrackerImprConnections']   		= "インプレッションコネクション数";
$GLOBALS['strTrackerClickConnections']  		= "クリックコネクション数";
$GLOBALS['strTrackerImprConversions']   		= "インプレッションコンバージョン数";
$GLOBALS['strTrackerClickConversions']  		= "クリックコンバージョン数";
$GLOBALS['strLinkCampaignsByDefault']   		= "デフォルトで新規キャンペーンにリンクする";

// Banners (General)
$GLOBALS['strBanner'] 							= "バナー";
$GLOBALS['strBanners'] 							= "バナー";
$GLOBALS['strBannerFilter']                  	= "バナーのフィルタ";
$GLOBALS['strAddBanner'] 						= "バナーの追加";
$GLOBALS['strAddBanner_Key'] 					= "バナーの追加 (<u>n</u>)";
$GLOBALS['strModifyBanner'] 					= "バナーの修正";
$GLOBALS['strActiveBanners'] 					= "アクティブバナー";
$GLOBALS['strTotalBanners'] 					= "総バナー数";
$GLOBALS['strShowBanner']						= "バナーの表示";
$GLOBALS['strShowAllBanners']	 				= "すべてのバナーの表示";
$GLOBALS['strShowBannersNoAdViews']				= "ビュー実績ゼロのバナーを表示";
$GLOBALS['strShowBannersNoAdClicks']			= "クリック実績ゼロのバナーを表示";
$GLOBALS['strShowBannersNoAdConversions'] 		= "コンバージョン実績ゼロのバナーを表示";
$GLOBALS['strDeleteAllBanners']	 				= "すべてのバナーを削除";
$GLOBALS['strActivateAllBanners']				= "すべてのバナーをアクティブに";
$GLOBALS['strDeactivateAllBanners']				= "すべてのバナーを非アクティブに";
$GLOBALS['strBannerOverview']					= "バナーの概要";
$GLOBALS['strBannerProperties']					= "バナーの詳細";
$GLOBALS['strBannerHistory']					= "バナーの状況";
$GLOBALS['strBannerNoStats'] 					= "このバナーの統計データはありません。";
$GLOBALS['strNoBanners']						= "バナーは1件も定義されていません";
$GLOBALS['strConfirmDeleteBanner']				= "このバナーを本当に削除しますか?";
$GLOBALS['strConfirmDeleteAllBanners']			= "このキャンペーンが所有するすべてのバナーを本当に削除しますか？";
$GLOBALS['strConfirmResetBannerStats']			= "このバナーの統計データを本当に削除しますか？";
$GLOBALS['strShowParentCampaigns']				= "親キャンペーンを表示";
$GLOBALS['strHideParentCampaigns']				= "親キャンペーンを隠す";
$GLOBALS['strHideInactiveBanners']				= "非アクティブなバナーを隠す";
$GLOBALS['strInactiveBannersHidden']			= "件の非アクティブなバナーを隠しています";
$GLOBALS['strAppendOthers']						= "その他の追加";
$GLOBALS['strAppendTextAdNotPossible']			= "テキスト広告にバナーは追加できません。";
$GLOBALS['strHiddenBanner']               		= "バナーを隠す";
$GLOBALS['strWarningTag1']                  	= '警告, タグ ';
$GLOBALS['strWarningTag2']                  	= ' が終了/開始していません ';
$GLOBALS['strWarningMissing']              		= '警告:';
$GLOBALS['strWarningMissingClosing']       		= '閉じタグ \">\"がありません';
$GLOBALS['strWarningMissingOpening']       		= '開始タグ \"<\"がありません';
$GLOBALS['strSubmitAnyway']       		   		= '送信する';

// Banner Preferences
$GLOBALS['strBannerPreferences']                = 'バナー設定';
$GLOBALS['strDefaultBanners']                   = 'デフォルトバナー';
$GLOBALS['strDefaultBannerUrl']                 = 'デフォルト画像URL';
$GLOBALS['strDefaultBannerDestination']         = 'デフォルト転送先URL';
$GLOBALS['strAllowedBannerTypes']               = '許可されたバナータイプ';
$GLOBALS['strTypeSqlAllow']                     = 'バナーをデータベースに保存する';
$GLOBALS['strTypeWebAllow']                     = 'バナーをサーバに保存する';
$GLOBALS['strTypeUrlAllow']                     = '外部バナーを許可する';
$GLOBALS['strTypeHtmlAllow']                    = 'HTMLバナーを許可する';
$GLOBALS['strTypeTxtAllow']                     = 'テキストバナーを許可する';
$GLOBALS['strTypeHtmlSettings']                 = 'HTMLバナーのオプション';
$GLOBALS['strTypeHtmlAuto']                     = 'HTMLバナーに、広告を追跡できるタグを自動で追加する';
$GLOBALS['strTypeHtmlPhp']						= 'HTMLバナーで、PHPタグを許可する';

// Banner (Properties)
$GLOBALS['strChooseBanner'] 					= "バナー種別を選択してください";
$GLOBALS['strMySQLBanner'] 						= "ローカルバナー (SQL)";
$GLOBALS['strWebBanner'] 						= "ローカルバナー (ウェブサーバー)";
$GLOBALS['strURLBanner'] 						= "外部バナー";
$GLOBALS['strHTMLBanner'] 						= "HTMLバナー";
$GLOBALS['strTextBanner'] 						= "テキスト広告";
$GLOBALS['strAutoChangeHTML']					= "クリック追跡用にHTMLを変更する";
$GLOBALS['strUploadOrKeep']						= "既存の画像を活用しますか？<br />別な画像をアップロードしますか？";
$GLOBALS['strUploadOrKeepAlt']        			= "既存のバックアップ画像を活用しますか？<br />別な画像をアップロードしますか？";
$GLOBALS['strNewBannerFile'] 					= "このバナーに割り当てたい<br />画像を選択してください。<br />リッチメディア画像は選択できませｎ。<br /><br />";
$GLOBALS['strNewBannerFileAlt']     			= "このバナーに割り当てたい<br />画像を選択してください。<br />リッチメディア画像は選択できませｎ。<br /><br />";
$GLOBALS['strNewBannerURL'] 					= "画像URL (http://を含む)";
$GLOBALS['strURL'] 								= "ターゲットURL (http://を含む)";
$GLOBALS['strHTML'] 							= "HTML";
$GLOBALS['strKeyword']              			= "キーワード";
$GLOBALS['strTextBelow'] 						= "バナー直下のテキスト表示";
$GLOBALS['strWeight'] 							= "ウェイト";
$GLOBALS['strAlt'] 								= "代替テキスト(マウスオーバ時)";
$GLOBALS['strStatusText']						= "ブラウザステータス表示（マウスオーバ時）";
$GLOBALS['strBannerWeight']						= "バナーウェイト";
$GLOBALS['strBannerType']           			= "バナータイプ";
$GLOBALS['strAdserverTypeGeneric']  			= "汎用HTMLバナー";
$GLOBALS['strAdserverTypeMax']      			= "リッチメディア - OpenX";
$GLOBALS['strAdserverTypeAtlas']    			= "リッチメディア - Atlas";
$GLOBALS['strAdserverTypeBluestreak']   		= "リッチメディア - Bluestreak";
$GLOBALS['strAdserverTypeDoubleclick']  		= "リッチメディア - DoubleClick";
$GLOBALS['strAdserverTypeEyeblaster']   		= "リッチメディア - Eyeblaster";
$GLOBALS['strAdserverTypeFalk']         		= "リッチメディア - Falk";
$GLOBALS['strAdserverTypeMediaplex']    		= "リッチメディア - Mediaplex";
$GLOBALS['strAdserverTypeTangozebra']   		= "リッチメディア - Tango Zebra";
$GLOBALS['strGenericOutputAdServer'] 			= "汎用Adserver";
$GLOBALS['strSwfTransparency']					= "背景の透過を許可する";

// Banner (swf)
$GLOBALS['strCheckSWF']							= "Flashファイル内でハードコーデッドリンクを使うにはチェックしてください";
$GLOBALS['strConvertSWFLinks']					= "Flashリンクに変換";
$GLOBALS['strHardcodedLinks']					= "ハードコーデッドリンク";
$GLOBALS['strConvertSWF']						= "<br />アップロードされたFlashファイルにはハードコデッドURLが含まれています。". MAX_PRODUCT_NAME ." は、ハードコデッドURLを変換するまで、クリック数をカウントできません。Flashファイル内のハードコーデッドURL一覧は以下のとおりです。ハードコーデッドURLを変換するには、<b>変換する</b>をクリックしてください。変換しない場合、<b>キャンセル</b>をクリックしてください。<br /><br />以下のことに留意してください: <b>変換する</b>をクリックすると、アップロードしたFlashファイルは別なファイルに変換されます。<br />オリジナルファイルをバックアップしておいてください。オリジナルバナーのバージョンにかかわらず、変換後のFlashファイルを正しく表示するには、Flash4プレーヤー(以降)が必要です。<br /><br />";
$GLOBALS['strCompressSWF']						= "ダウンロード時間を短くするため、Flashファイルを圧縮する(Flash6プレーヤー以降が必要)";
$GLOBALS['strOverwriteSource']					= "ソースパラメータを上書きする";
$GLOBALS['strLinkToShort']            			= "警告：ハードコーデッドURLを検出しましたが、そのURLは自動修正するには短すぎます。";

// Banner (network)
$GLOBALS['strBannerNetwork']					= "HTMLテンプレート";
$GLOBALS['strChooseNetwork']					= "使用したいテンプレートを選択する";
$GLOBALS['strMoreInformation']					= "詳しい情報...";
$GLOBALS['strRichMedia']						= "リッチメディア";
$GLOBALS['strTrackAdClicks']					= "クリック追跡を有効にする";

// Banner (AdSense)
$GLOBALS['strAdSenseAccounts']            		= "AdSenseアカウント";
$GLOBALS['strLinkAdSenseAccount']         		= "AdSenseアカウントにリンクする";
$GLOBALS['strCreateAdSenseAccount']       		= "AdSenseアカウントを作成する";
$GLOBALS['strEditAdSenseAccount']         		= "AdSenseアカウントを編集する";

// Display limitations
$GLOBALS['strModifyBannerAcl'] 					= "配信オプション";
$GLOBALS['strACL'] 								= "広告配信";
$GLOBALS['strACLAdd'] 							= "配信制限の追加";
$GLOBALS['strACLAdd_Key'] 						= "配信制限の追加 (<u>n</u>)";
$GLOBALS['strNoLimitations']					= "配信制限が定義されていません";
$GLOBALS['strApplyLimitationsTo']				= "配信制限を適用する";
$GLOBALS['strRemoveAllLimitations']				= "すべての配信制限を削除";
$GLOBALS['strEqualTo']							= "一致する";
$GLOBALS['strDifferentFrom']					= "一致しない";
$GLOBALS['strLaterThan']						= "以降";
$GLOBALS['strLaterThanOrEqual']					= "以降(含む)";
$GLOBALS['strEarlierThan']						= "以前";
$GLOBALS['strEarlierThanOrEqual']				= "以前(含む)";
$GLOBALS['strContains']							= "含む";
$GLOBALS['strNotContains']						= "含まない";
$GLOBALS['strGreaterThan']                		= '以下よりも大きい';
$GLOBALS['strLessThan']                   		= '以下よりも少ない';
$GLOBALS['strAND']								= "かつ";  						// logical operator
$GLOBALS['strOR']								= "または"; 						// logical operator
$GLOBALS['strOnlyDisplayWhen']					= "バナー表示日時:";
$GLOBALS['strWeekDay'] 							= "曜日";
$GLOBALS['strWeekDays']                      	= "平日";
$GLOBALS['strTime'] 							= "時間";
$GLOBALS['strUserAgent'] 						= "ユーザエージェント";
$GLOBALS['strDomain'] 							= "ドメイン";
$GLOBALS['strClientIP'] 						= "クライアント IP";
$GLOBALS['strSource'] 							= "ソースパラメータ";
$GLOBALS['strSourceFilter']                		= "ソースフィルタ";
$GLOBALS['strBrowser'] 							= "ブラウザ";
$GLOBALS['strOS'] 								= "OS";
$GLOBALS['strCountryCode']                 		= "国コード(ISO 3166)";
$GLOBALS['strCountryName']                 		= "国名";
$GLOBALS['strRegion']							= "地域コード(ISO-3166-2/FIPS 10-4)";
$GLOBALS['strCity']								= "都道府県・市";
$GLOBALS['strPostalCode']						= "郵便番号(US/Canada)";
$GLOBALS['strLatitude']                    		= "緯度";
$GLOBALS['strLongitude']                		= "経度";
$GLOBALS['strDMA']								= "DMAコード(US)";
$GLOBALS['strArea']								= "Areaコード(US Telephone)";
$GLOBALS['strOrg']                         		= "組織名(英字)";
$GLOBALS['strIsp']                         		= "ISP名(英字)";
$GLOBALS['strNetSpeed']							= "ネットワーク速度";
$GLOBALS['strReferer'] 							= "リファラページ";
$GLOBALS['strDeliveryLimitations']				= "配信先";

$GLOBALS['strDeliveryCapping']					= "ユーザ毎に対する配信制限";
$GLOBALS['strDeliveryCappingReset']       		= "カウンタリセット条件：";
$GLOBALS['strDeliveryCappingTotal']       		= "総配信数";
$GLOBALS['strDeliveryCappingSession']     		= "／セッション";

$GLOBALS['strCappingBanner'] = array();
$GLOBALS['strCappingBanner']['title'] 			= $GLOBALS['strDeliveryCapping'];
$GLOBALS['strCappingBanner']['limit'] 			= 'バナービュー上限数';

$GLOBALS['strCappingCampaign'] = array();
$GLOBALS['strCappingCampaign']['title'] 		= $GLOBALS['strDeliveryCapping'];
$GLOBALS['strCappingCampaign']['limit'] 		= 'キャンペーンビュー上限数';

$GLOBALS['strCappingZone'] = array();
$GLOBALS['strCappingZone']['title'] 			= $GLOBALS['strDeliveryCapping'];
$GLOBALS['strCappingZone']['limit'] 			= 'ゾーンビュー上限数';

// Website
$GLOBALS['strAffiliate']						= "Webサイト";
$GLOBALS['strAffiliates']						= "Webサイト";
$GLOBALS['strAffiliatesAndZones']				= "Webサイト＆ゾーン";
$GLOBALS['strAddNewAffiliate']					= "Webサイトの追加";
$GLOBALS['strAddNewAffiliate_Key']				= "Webサイトの追加 (<u>n</u>)";
$GLOBALS['strAddAffiliate']						= "Webサイトを作成する";
$GLOBALS['strAffiliateProperties']				= "Webサイトの詳細";
$GLOBALS['strAffiliateOverview']				= "Webサイトの概要";
$GLOBALS['strAffiliateHistory']					= "Webサイトの状況";
$GLOBALS['strZonesWithoutAffiliate']			= "Webサイト未割当ゾーン";
$GLOBALS['strMoveToNewAffiliate']				= "新規Webサイトに移動";
$GLOBALS['strNoAffiliates']						= "Webサイトが存在しません。広告枠を作成する前に、先に<a href='affiliate-edit.php'>Webサイトを作成</a>して下さい。";
$GLOBALS['strConfirmDeleteAffiliate']			= "このWebサイトを本当に削除しますか?";
$GLOBALS['strMakePublisherPublic']				= "このWebサイトが所有するゾーンを利用可能にする";
$GLOBALS['strAffiliateInvocation']      		= '広告表示コードの生成';
$GLOBALS['strAdvertiserSetup']          		= '広告主サインアップ';
$GLOBALS['strTotalAffiliates']          		= 'Webサイト合計数';
$GLOBALS['strInactiveAffiliatesHidden'] 		= "件の非アクティブなWebサイトを隠す";
$GLOBALS['strShowParentAffiliates']     		= "親のWebサイトを表示する";
$GLOBALS['strHideParentAffiliates']     		= "親のWebサイトを隠す";

// Website (properties)
$GLOBALS['strWebsite']							= "Webサイト";
$GLOBALS['strMnemonic']                     	= "簡略コード";
$GLOBALS['strAllowAffiliateModifyInfo'] 		= "このユーザの設定内容の修正を許可する";
$GLOBALS['strAllowAffiliateModifyZones']		= "このユーザによるゾーン修正を許可する";
$GLOBALS['strAllowAffiliateLinkBanners']		= "このユーザによるゾーンのバナーリンクを許可する";
$GLOBALS['strAllowAffiliateAddZone'] 			= "このユーザによる新規ゾーン定義を許可する";
$GLOBALS['strAllowAffiliateDeleteZone'] 		= "このユーザによるゾーン情報の削除を許可する";
$GLOBALS['strAllowAffiliateGenerateCode']  		= "このユーザによる呼出コードの生成を許可する";
$GLOBALS['strAllowAffiliateZoneStats']     		= "このユーザによるゾーン統計の閲覧を許可する";
$GLOBALS['strAllowAffiliateApprPendConv']  		= "このユーザによる承認／保留中のコンバージョン参照を許可する";

// Website (properties - payment information)
$GLOBALS['strPaymentInformation']           	= "支払情報";
$GLOBALS['strAddress']                      	= "住所(町村名以下)";
$GLOBALS['strPostcode']                     	= "郵便番号";
$GLOBALS['strCity']                         	= "都道府県・市";
$GLOBALS['strCountry']                      	= "国";
$GLOBALS['strPhone']                        	= "電話番号";
$GLOBALS['strFax']                          	= "FAX";
$GLOBALS['strAccountContact']               	= "窓口担当者";
$GLOBALS['strPayeeName']                    	= "受取人名義";
$GLOBALS['strTaxID']                        	= "税金ID";
$GLOBALS['strModeOfPayment']                	= "振込方法";
$GLOBALS['strPaymentChequeByPost']          	= "受取総額";
$GLOBALS['strCurrency']                     	= "通貨";
$GLOBALS['strCurrencyGBP']                  	= "GBP";

// Website (properties - other information)
$GLOBALS['strOtherInformation']             	= "その他の情報";
$GLOBALS['strUniqueUsersMonth']             	= "ユニークユーザ数／月";
$GLOBALS['strUniqueViewsMonth']             	= "ユニークビュー数／月";
$GLOBALS['strPageRank']                     	= "ページランク";
$GLOBALS['strCategory']                     	= "カテゴリ";
$GLOBALS['strHelpFile']                     	= "ヘルプファイル";
$GLOBALS['strApprovedTandC']                	= "契約条件を承認済み";

// Zone
$GLOBALS['strChooseZone']                   	= "ゾーンの選択";
$GLOBALS['strZone']								= "ゾーン";
$GLOBALS['strZones']							= "ゾーン";
$GLOBALS['strAddNewZone']						= "ゾーンの追加";
$GLOBALS['strAddNewZone_Key']					= "ゾーンの追加 (<u>n</u>)";
$GLOBALS['strAddZone']							= "ゾーンを作成する";
$GLOBALS['strModifyZone']						= "ゾーンの修正";
$GLOBALS['strLinkedZones']						= "リンク済ゾーン";
$GLOBALS['strZoneOverview']						= "ゾーンの概要";
$GLOBALS['strZoneProperties']					= "ゾーンの詳細";
$GLOBALS['strZoneHistory']						= "ゾーンの状況";
$GLOBALS['strNoZones']							= "ゾーンが定義されていません";
$GLOBALS['strConfirmDeleteZone']				= "このゾーンを本当に削除しますか?";
$GLOBALS['strConfirmDeleteZoneLinkActive']  	= "このゾーンにリンクされたキャンペーンの未払分があります。 このゾーンを削除するとキャンペーンが中断し、支払も行われません。";
$GLOBALS['strZoneType']							= "ゾーンタイプ";
$GLOBALS['strBannerButtonRectangle']			= "バナー・ボタン・レクタングル広告";
$GLOBALS['strInterstitial']						= "インタスティシャル／フローティングDHTML広告";
$GLOBALS['strPopup']							= "ポップアップ広告";
$GLOBALS['strTextAdZone']						= "テキスト広告";
$GLOBALS['strEmailAdZone']                  	= "メール/ニュースレターゾーン";
$GLOBALS['strZoneClick']                    	= "クリック追跡ゾーン";
$GLOBALS['strShowMatchingBanners']				= "一致するバナーを表示";
$GLOBALS['strHideMatchingBanners']				= "一致するバナーを隠す";
$GLOBALS['strBannerLinkedAds']              	= "ゾーンにリンク済のバナー";
$GLOBALS['strCampaignLinkedAds']            	= "ゾーンにリンク済のキャンペーン";
$GLOBALS['strTotalZones']                   	= '合計ゾーン数';
$GLOBALS['strCostInfo']                     	= '広告費';
$GLOBALS['strTechnologyCost']               	= 'テクノロジーコスト';
$GLOBALS['strInactiveZonesHidden']          	= "非アクティブなゾーンを隠す";
$GLOBALS['strWarnChangeZoneType']           	= 'ゾーンタイプの制限により、テキストもしくはEメールへとタイプを変更する場合、広告への全てのリンクが非表示となる可能性があります。
<ul>
<li>テキストタイプのゾーンはテキスト広告のみ表示可能です。</li>
<li>また、Eメールタイプのゾーンは有効なバナーを1つしか持てません。</li>
</ul>';
$GLOBALS['strWarnChangeZoneSize']           	= 'ゾーンのサイズを変更することにより、新しいサイズに適合しないバナーは全て外されます。またリンク済みとなっているキャンペーンにおいて、新しいサイズに適合する広告がある場合、それらが表示されるようになります。';
$GLOBALS['strWarnChangeBannerSize']         	= 'バナーサイズを変更すると、新しいサイズに適合しないバナーは解除されます。またバナーが属するキャンペーンが新しいサイズに適合していると、そのバナーが自動的に関連付けされます。';

// Advanced zone settings
$GLOBALS['strAdvanced']							= "アドバンス";
$GLOBALS['strChains']							= "代替バナー";
$GLOBALS['strChainSettings']					= "代替バナーの設定";
$GLOBALS['strZoneNoDelivery']					= "配信対象バナーが存在しない場合";
$GLOBALS['strZoneStopDelivery']					= "バナー配信を停止する";
$GLOBALS['strZoneOtherZone']					= "別ゾーンのバナーを表示する";
$GLOBALS['strZoneUseKeywords']					= "以下のキーワードで配信バナーを決定";
$GLOBALS['strZoneAppend']						= "HTMLバナーを追加する";
$GLOBALS['strAppendSettings']					= "プリペンド設定／追加設定";
$GLOBALS['strZoneForecasting']            		= "ゾーン予測設定";
$GLOBALS['strZonePrependHTML']					= "テキスト広告に次のHTMLコードを挿入する";
$GLOBALS['strZoneAppendHTML']					= "テキスト広告に次のHTMLコードを追加する";
$GLOBALS['strZoneAppendNoBanner']        		= "バナー非配信中でも追加する";
$GLOBALS['strZoneAppendType']            		= "追加タイプ";
$GLOBALS['strZoneAppendHTMLCode']        		= "HTMLコード";
$GLOBALS['strZoneAppendZoneSelection']    		= "ポップアップ広告／インタスティシャル広告";
$GLOBALS['strZoneAppendSelectZone']				= "常にポップアップ広告やインタスティシャル広告をこのゾーンに追加する";

// Zone probability
$GLOBALS['strZoneProbListChain']				= "対象ゾーンにリンク済のアクティブなバナーがありません。<br>代わりに配信するバナーは次のとおりです:";
$GLOBALS['strZoneProbNullPri']					= "対象ゾーンにリンク済のアクティブなバナーがありません。";
$GLOBALS['strZoneProbListChainLoop']			= "代替バナーがループになっています。このゾーンへの配信は、中断されます。";

// Linked banners/campaigns/trackers
$GLOBALS['strSelectZoneType']					= "リンク済のバナーの表示方法を選択してください";
$GLOBALS['strLinkedBanners']            		= "各々のバナーをリンクする";
$GLOBALS['strCampaignDefaults']            		= "親キャンペーンでバナーをリンクする";
$GLOBALS['strLinkedCategories']         		= "カテゴリでバナーをリンクする";
$GLOBALS['strInteractive']						= "インタラクティブ";
$GLOBALS['strRawQueryString']					= "キーワード";
$GLOBALS['strIncludedBanners']					= "リンク済バナー";
$GLOBALS['strLinkedBannersOverview']			= "リンク済バナーの概要";
$GLOBALS['strLinkedBannerHistory']				= "リンク済バナーの状況";
$GLOBALS['strNoZonesToLink']					= "このバナーがリンク可能なゾーンはありません。";
$GLOBALS['strNoBannersToLink']					= "このゾーンにリンク可能なバナーはありません。";
$GLOBALS['strNoLinkedBanners']					= "このゾーンにリンクされたバナーに有効なものがありません。";
$GLOBALS['strMatchingBanners']					= "{count}個のバナーが一致";
$GLOBALS['strNoCampaignsToLink']				= "このバナーがリンク可能なキャンペーンがありません。";
$GLOBALS['strNoTrackersToLink']            		= "このキャンペーンにリンク可能なトラッカーはありません。";
$GLOBALS['strNoZonesToLinkToCampaign']  		= "このキャンペーンがリンク可能なゾーンがありません。";
$GLOBALS['strSelectBannerToLink']				= "このゾーンにリンクしたいバナーを選択してください:";
$GLOBALS['strSelectCampaignToLink']				= "このゾーンにリンクしたいキャンペーンを選択してください:";
$GLOBALS['strSelectAdvertiser']         		= '広告主を選択してください';
$GLOBALS['strSelectPlacement']          		= 'キャンペーンを選択してください';
$GLOBALS['strSelectAd']                 		= 'バナーを選択してください';
$GLOBALS['strSelectPublisher']          		= "Webサイトを選択してください";
$GLOBALS['strSelectZone']               		= "ゾーンを選択してください";
$GLOBALS['strTrackerCode']              		= '以下のJavascriptコードを各々のトラッカー用インプレッションチェックポイントに追加してください。';
$GLOBALS['strTrackerCodeSubject']          		= 'トラッカーコード追加';
$GLOBALS['strAppendTrackerNotPossible']    		= 'そのトラッカーは追加できません。';
$GLOBALS['strStatusPending']            		= '保留';
$GLOBALS['strStatusApproved']           		= '承認済み';
$GLOBALS['strStatusDisapproved']        		= '不可';
$GLOBALS['strStatusDuplicate']          		= '複製する';
$GLOBALS['strStatusOnHold']             		= '未承認';
$GLOBALS['strStatusIgnore']             		= '放置';
$GLOBALS['strConnectionType']           		= 'タイプ';
$GLOBALS['strConnTypeSale']             		= 'セール';
$GLOBALS['strConnTypeLead']             		= 'リード';
$GLOBALS['strConnTypeSignUp']           		= 'サインアップ';
$GLOBALS['strShortcutEditStatuses'] 			= 'ステータスを変更する';
$GLOBALS['strShortcutShowStatuses'] 			= 'ステータスを見る';

// Statistics
$GLOBALS['strStats'] 							= "統計";
$GLOBALS['strNoStats']							= "利用可能な統計データはありません。";
$GLOBALS['strNoTargetingStats']          		= "利用可能なターゲットの統計はありません。";
$GLOBALS['strNoStatsForPeriod']        			= "%s から %s の期間に利用可能な統計データはありません。";
$GLOBALS['strNoTargetingStatsForPeriod'] 		= "%s から %s の期間に利用可能なターゲットの統計はありません。";
$GLOBALS['strConfirmResetStats']				= "すべての統計データを本当に消去しますか?";
$GLOBALS['strGlobalHistory']					= "活動概況";
$GLOBALS['strDailyHistory']						= "日別状況";
$GLOBALS['strDailyStats'] 						= "日別統計";
$GLOBALS['strWeeklyHistory']					= "週間状況";
$GLOBALS['strMonthlyHistory']					= "月間状況";
$GLOBALS['strCreditStats'] 						= "保証統計";
$GLOBALS['strDetailStats'] 						= "明細統計";
$GLOBALS['strTotalThisPeriod']					= "期間合計";
$GLOBALS['strAverageThisPeriod']				= "期間平均";
$GLOBALS['strPublisherDistribution'] 			= "Webサイト別配信";
$GLOBALS['strCampaignDistribution']      		= "キャンペーン別配信";
$GLOBALS['strDistributionBy']        			= "配信数：";
$GLOBALS['strOptimise']                  		= "最適化";
$GLOBALS['strKeywordStatistics']         		= "キーワード統計";
$GLOBALS['strResetStats']                		= "リセット統計";
$GLOBALS['strSourceStats']               		= "ソースパラメータ統計";
$GLOBALS['strSources']                   		= "ソースパラメータ";
$GLOBALS['strAvailableSources']          		= "利用可能なソースパラメータ";
$GLOBALS['strSelectSource']              		= "閲覧したいソースパラメータを選択してください:";
$GLOBALS['strSizeDistribution']          		= "サイズ別";
$GLOBALS['strCountryDistribution']       		= "国別";
$GLOBALS['strEffectivity']               		= "有効数";
$GLOBALS['strTargetStats']               		= "ターゲット別統計";
$GLOBALS['strCampaignTarget']            		= "ターゲット";
$GLOBALS['strTargetRatio']						= "ターゲット率";
$GLOBALS['strTargetModifiedDay']				= "ターゲットが過去１日でに変更されているので、ターゲット統計は正確でありません。";
$GLOBALS['strTargetModifiedWeek']				= "ターゲットが過去１週間で変更されているので、ターゲット統計は正確でありません。";
$GLOBALS['strTargetModifiedMonth']				= "ターゲットが過去一ヶ月間で変更されているので、ターゲット統計は正確でありません。";
$GLOBALS['strNoTargetStats']					= "ターゲットに関する有効な統計はありません。";
$GLOBALS['strOVerall']                			= "すべての統計";
$GLOBALS['strByZone']                			= "ゾーン別";
$GLOBALS['strImpressionsRequestsRatio']   		= "ビュー要求率(%)";
$GLOBALS['strViewBreakdown']        			= "明細確認";
$GLOBALS['strBreakdownByDay']       			= "日";
$GLOBALS['strBreakdownByWeek']      			= "週";
$GLOBALS['strBreakdownByMonth']     			= "月";
$GLOBALS['strBreakdownByDow']       			= "曜日";
$GLOBALS['strBreakdownByHour']      			= "時";
$GLOBALS['strItemsPerPage']         			= "１ページあたりのアイテム数";
$GLOBALS['strDistributionHistory']  			= "配信状況";
$GLOBALS['strShowGraphOfStatistics']  			= "グラフ表示(<u>G</u>)";
$GLOBALS['strExportStatisticsToExcel']  		= "Excel出力(<u>E</u>)";
$GLOBALS['strGDnotEnabled']         			= "グラフ表示を行うにはPHPでGDを利用可能にしてください。<br />詳細は、<a href='http://www.php.net/gd' target='_blank'>http://www.php.net/gd</a>を確認してください。サーバへのGDのインストール方法が掲載されています。";
$GLOBALS['strTTFnotEnabled']         			= "PHPでGDは利用可能ですが、FreeTypeのサポートに関して問題があります。<br />Freetypeは、グラフ表示のために必要です。<br />サーバコンフィグをチェックしてください。";

// Hosts
$GLOBALS['strHosts']							= "ホスト";
$GLOBALS['strTopHosts'] 						= "上位ホスト";
$GLOBALS['strTopCountries'] 					= "上位国";
$GLOBALS['strRecentHosts'] 						= "直近上位ホスト";

// Expiration
$GLOBALS['strExpired']							= "キャンペーンは終了しました";
$GLOBALS['strExpiration'] 						= "キャンペーン終了";
$GLOBALS['strNoExpiration'] 					= "終了日が未設定です";
$GLOBALS['strEstimated'] 						= "終了日を設定しました";

// Reports
$GLOBALS['strReports']							= "レポート";
$GLOBALS['strAdminReports']         			= "管理者用レポート";
$GLOBALS['strAdvertiserReports']    			= "広告主用レポート";
$GLOBALS['strAgencyReports']        			= "代理店用レポート";
$GLOBALS['strPublisherReports']     			= "サイトオーナー用レポート";
$GLOBALS['strSelectReport']						= "レポートを選択してください";
$GLOBALS['strStartDate']            			= "開始日";
$GLOBALS['strEndDate']                			= "終了日";
$GLOBALS['strNoData']                			= "この期間中、有効な統計データはありません。";

// Admin_UI_Fields
$GLOBALS['strAllAdvertisers']            		= "すべての広告主";
$GLOBALS['strAnonAdvertisers']           		= "任意の広告主";
$GLOBALS['strAllPublishers']             		= "すべてのWebサイト";
$GLOBALS['strAnonPublishers']            		= "任意のWebサイト";
$GLOBALS['strAllAvailZones']             		= "利用可能なすべてのゾーン";

// Userlog
$GLOBALS['strUserLog']							= "ユーザーログ";
$GLOBALS['strUserLogDetails']					= "ユーザーログの詳細";
$GLOBALS['strDeleteLog']						= "ログを削除する";
$GLOBALS['strAction']							= "アクション";
$GLOBALS['strNoActionsLogged']					= "アクションは記録されていません。";

// Code generation
$GLOBALS['strGenerateBannercode']				= "ダイレクト選択";
$GLOBALS['strChooseInvocationType']				= "バナーの呼出方法を選択してください";
$GLOBALS['strGenerate']							= "生成する";
$GLOBALS['strParameters']						= "パラメータ";
$GLOBALS['strFrameSize']						= "フレームサイズ";
$GLOBALS['strBannercode']						= "バナーコード";
$GLOBALS['strTrackercode']                		= "トラッカーコード";
$GLOBALS['strOptional']							= "オプション";
$GLOBALS['strBackToTheList']            		= "レポート一覧に戻る";
$GLOBALS['strGoToReportBuilder']        		= "選択したレポートを確認する";
$GLOBALS['strCharset']                  		= "キャラクターセット";
$GLOBALS['strAutoDetect']                   	= "自動検出";

// Errors
$GLOBALS['strMySQLError'] 						= "SQLエラー:";
$GLOBALS['strLogErrorClients'] 					= "[phpAds]データベースから広告主を取得しようとしたときにエラーが発生しました。";
$GLOBALS['strLogErrorBanners'] 					= "[phpAds]データベースからバナーを取得しようとしたときにエラーが発生しました。";
$GLOBALS['strLogErrorViews'] 					= "[phpAds]データベースからビュー数を取得しようとしたときにエラーが発生しました。";
$GLOBALS['strLogErrorClicks'] 					= "[phpAds]データベースからクリック数を取得しようとしたときにエラーが発生しました。";
$GLOBALS['strLogErrorConversions']         		= "[phpAds]データベースからコンバージョン数を取得しようとしたときにエラーが発生しました。";
$GLOBALS['strErrorViews'] 						= "上限ビュー数を入力するか、無制限をチェックしてください！";
$GLOBALS['strErrorNegViews'] 					= "マイナスのビュー数は許可されていません";
$GLOBALS['strErrorClicks'] 						= "上限クリック数を入力するか、無制限をチェックしてください！";
$GLOBALS['strErrorNegClicks'] 					= "マイナスのクリック数は許可されていません";
$GLOBALS['strErrorConversions']         		= "コンバージョン数を入力するか、無制限をチェックしてください！";
$GLOBALS['strErrorNegConversions']         		= "マイナスのコンバーション数は許可されていません";
$GLOBALS['strNoMatchesFound']					= "一致するものは見つかりません";
$GLOBALS['strErrorOccurred']					= "エラーが発生しました";
$GLOBALS['strErrorUploadSecurity']				= "セキュリティの問題の可能性を検知したのでアップロードを停止します!";
$GLOBALS['strErrorUploadBasedir']				= "アップロードファイルにアクセスできませんでした。おそらくセーフモードかopen_basedir制限が原因です。";
$GLOBALS['strErrorUploadUnknown']				= "アップロードファイルにアクセスできませんでした。理由は不明です。PHPの環境をチェックしてください。";
$GLOBALS['strErrorStoreLocal']					= "ローカルディレクトリにバナーを保存する際、エラーが発生しました。おそらくローカルディレクトリのパス設定ミスがその原因です。";
$GLOBALS['strErrorStoreFTP']					= "FTPサーバにバナーをアップロードする際、エラーが発生しました。サーバが動作中でないか、FTPサーバの設定ミスが原因です。";
$GLOBALS['strErrorDBPlain']						= "データベースにアクセス中にエラーが発生しました。";
$GLOBALS['strErrorDBSerious']					= "データベースに致命的な問題を検出しました。";
$GLOBALS['strErrorDBNoDataPlain']				= "データベースに関連する問題のため、". MAX_PRODUCT_NAME ." はデータの検索と保存ができません。";
$GLOBALS['strErrorDBNoDataSerious']				= "データベースに関連する致命的な問題のため、". MAX_PRODUCT_NAME ." データの検索ができません。";
$GLOBALS['strErrorDBCorrupt']					= "データベーステーブルがおそらく破損しており、修復する必要があります。破損したテーブルの詳しい修復方法は、<i>管理者ガイド</i>の<i>トラブルシューティング</i>を読んでください。";
$GLOBALS['strErrorDBContact']					= "このサーバのシステム管理者に連絡して、問題を報告してください。";
$GLOBALS['strErrorDBSubmitBug']					= "この問題が何度も繰り返し発生する場合、". MAX_PRODUCT_NAME ." のバグであると思われます。以下の情報を". MAX_PRODUCT_NAME ." の開発者に報告してください。その際、できるだけ明確にエラー直前の動作を記述してください。";
$GLOBALS['strMaintenanceNotActive']				= "24時間以内にメンテナンススクリプトが実行されていません。\n正確な動作のために". MAX_PRODUCT_NAME ." は1時間毎の動作が必要です。\n\nメンテナンススクリプトの設定方法については、\n管理者ガイドを読んでください。";
$GLOBALS['strErrorBadUserType']         		= "システムは、あなたのユーザタイプを決定できませんでした！";
$GLOBALS['strErrorLinkingBanner']       		= "バナーとゾーンをリンク中にエラーが発生しました:";
$GLOBALS['strUnableToLinkBanner']       		= "リンクできません：";
$GLOBALS['strErrorEditingCampaign']     		= "キャンペーン更新中にエラーが発生しました：";
$GLOBALS['strUnableToChangeCampaign']   		= "以下のの理由により、この変更をを適用できませんでした：";
$GLOBALS['strDatesConflict']            		= "日間、競合中：";
$GLOBALS['strEmailNoDates']             		= 'Eメールタイプのゾーンには、開始日と終了日が必須です。';
$GLOBALS['strWarningInaccurateStats']           = "統計データが非UTCタイムゾーンで記録されているため、正しいタイムゾーンで表示されない恐れがあります。";
$GLOBALS['strWarningInaccurateReadMore']        = "詳細は、こちら";
$GLOBALS['strWarningInaccurateReport']          = "統計データが非UTCタイムゾーンで記録されているため、正しいタイムゾーンで表示されない恐れがあります。";

// Email
$GLOBALS['strSirMadam']                         = "様";
$GLOBALS['strMailSubject'] 						= "レポートの送信";
$GLOBALS['strAdReportSent']						= "広告主にレポートを送信しました";
$GLOBALS['strMailHeader'] 						= "{contact} 様\n";
$GLOBALS['strMailBannerStats'] 					= "{clientname}に関するバナー統計は次のとおりです:";
$GLOBALS['strMailBannerActivatedSubject']       = "キャンペーン開始";
$GLOBALS['strMailBannerDeactivatedSubject']     = "キャンペーン停止";
$GLOBALS['strMailBannerActivated']              = "以下のキャンペーンが有効になりました。";
$GLOBALS['strMailBannerDeactivated']            = "以下のキャンペーンが停止しました。";
$GLOBALS['strMailFooter'] 						= "どうぞ、よろしくお願いいたします。\n   報告者：{adminfullname}";
$GLOBALS['strMailClientDeactivated']			= "次のバナーは無効でした：";
$GLOBALS['strMailNothingLeft'] 					= "今後の広告出稿にご不明な点があれば、どうぞお気軽にお問い合わせください。\nご連絡をお待ちしています。";
$GLOBALS['strClientDeactivated']				= "次のキャンペーンは、アクティブではありません。";
$GLOBALS['strBeforeActivate']					= "開始前キャンペーン　　　　：";
$GLOBALS['strAfterExpire']						= "終了済キャンペーン　　　　：";
$GLOBALS['strNoMoreImpressions']            	= "残インプレッション数＝ゼロ：";
$GLOBALS['strNoMoreClicks']						= "残クリック数＝ゼロ　　　　：";
$GLOBALS['strNoMoreConversions']            	= "残コンバージョン数＝ゼロ　：";
$GLOBALS['strWeightIsNull']						= "ウェイト設定＝ゼロ　　　　：";
$GLOBALS['strTargetIsNull']                     = "ターゲット設定＝ゼロ　　　：";
$GLOBALS['strWarnClientTxt']					= "残数が{limit}以下のインプレッション、クリック、コンバージョン：\n各々の残数が、ゼロになるとバナーは表示されません。";
$GLOBALS['strImpressionsClicksConversionsLow']  = "インプレッション、クリック、コンバージョンが残り少ないもの";
$GLOBALS['strNoViewLoggedInInterval']   		= "インプレッション数＝ゼロ　：";
$GLOBALS['strNoClickLoggedInInterval']  		= "クリック数＝ゼロ　　　　　：";
$GLOBALS['strNoConversionLoggedInInterval']		= "コンバージョン数＝ゼロ　　：";
$GLOBALS['strMailReportPeriod']					= "レポートの統計期間は次のとおりです。開始日：{startdate} －終了日：{enddate}";
$GLOBALS['strMailReportPeriodAll']				= "レポートの全期間統計は次のとおりです。終了日： {enddate}.";
$GLOBALS['strNoStatsForCampaign'] 				= "このキャンペーンに有効な統計はありません。";
$GLOBALS['strImpendingCampaignExpiry']          = "キャンペーン終了直前";
$GLOBALS['strYourCampaign']                     = "対象キャンペーン";
$GLOBALS['strTheCampiaignBelongingTo']          = "キャンペーンリンク先";
$GLOBALS['strImpendingCampaignExpiryDateBody']  = "以下の{clientname}は、{date}に終了しました。";
$GLOBALS['strImpendingCampaignExpiryImpsBody']  = "以下の{clientname}の 残りインプレッションは、{limit}です。";
$GLOBALS['strImpendingCampaignExpiryBody']      = "このキャンペーンはまもなく終了します。\nまた、次のバナーも同様に失効します。";

// Priority
$GLOBALS['strPriority']							= "優先度";
$GLOBALS['strSourceEdit']            			= "ソースパラメータの編集";




// Preferences
$GLOBALS['strPreferences']                      = "プリファレンス";
$GLOBALS['strMyAccount']                        = "マイアカウント";
$GLOBALS['strMainPreferences']                  = "メインプリファレンス";
$GLOBALS['strAccountPreferences']               = "アカウントプリファレンス";
$GLOBALS['strCampaignEmailReportsPreferences']  = "メール送信プリファレンス";
$GLOBALS['strAdminEmailWarnings']               = "管理者メール警告";
$GLOBALS['strAgencyEmailWarnings']              = "代理店メール警告";
$GLOBALS['strAdveEmailWarnings']                = "広告主メール警告";
$GLOBALS['strFullName']                         = "フルネーム";
$GLOBALS['strEmailAddress']                     = "メールアドレス";
$GLOBALS['strUserDetails']                      = "ユーザ情報";
$GLOBALS['strLanguageTimezone']                 = "言語＆タイムゾーン";
$GLOBALS['strUserInterfacePreferences']         = 'ユーザインターフェース設定';
$GLOBALS['strInvocationPreferences']            = '広告生成設定';
$GLOBALS['strUserPreferences']                  = "ユーザ－プリファレンス";
$GLOBALS['strChangePassword']                   = "パスワードの変更";
$GLOBALS['strChangeEmail']                      = "メールアドレスの変更";
$GLOBALS['strCurrentPassword']                  = "旧パスワード";
$GLOBALS['strChooseNewPassword']                = "新パスワード";
$GLOBALS['strReenterNewPassword']               = "新パスワード（再入力）";
$GLOBALS['strNameLanguage']                     = "ユーザ情報＆言語";



// Global Settings
$GLOBALS['strGlobalSettings'] 					= "全般設定";
$GLOBALS['strGeneralSettings']					= "全般設定";
$GLOBALS['strMainSettings']						= "メイン設定";
$GLOBALS['strAdminSettings']					= "管理者設定";

// Product Updates
$GLOBALS['strProductUpdates']					= "プロダクト更新";
$GLOBALS['strCheckForUpdates']        			= "更新のチェック";
$GLOBALS['strViewPastUpdates']        			= "過去のアップデート状況を参照する。";

// Agency
$GLOBALS['strAgencyManagement']              	= "アカウント管理";
$GLOBALS['strAgency']                      		= "アカウント";
$GLOBALS['strAgencies']                   		= "アカウント";
$GLOBALS['strAddAgency']                   		= "アカウントを追加";
$GLOBALS['strAddAgency_Key']               		= "ゾーンの追加 (<u>n</u>)";
$GLOBALS['strTotalAgencies']               		= "すべてのアカウント";
$GLOBALS['strAgencyProperties']              	= "アカウント設定";
$GLOBALS['strNoAgencies']                 		= "アカウントが存在しません。";
$GLOBALS['strConfirmDeleteAgency']          	= "このアカウントを本当に削除しますか?";
$GLOBALS['strHideInactiveAgencies']         	= "無効なアカウントを非表示にする";
$GLOBALS['strInactiveAgenciesHidden']     		= "非表示のアカウントを無効にする";
$GLOBALS['strAllowAgencyEditConversions'] 		= "このユーザがコンバージョンを編集することを許可する";
$GLOBALS['strAllowMoreReports']           		= "\'明細レポート'ボタンを許可する";

// Channels
$GLOBALS['strChannel']                    		= "ターゲットチャンネル";
$GLOBALS['strChannels']                   		= "ターゲットチャンネル";
$GLOBALS['strChannelOverview']              	= "ターゲットチャンネル概要";
$GLOBALS['strChannelManagement']          		= "ターゲットチャンネル管理";
$GLOBALS['strAddNewChannel']              		= "ターゲットチャンネルを追加";
$GLOBALS['strAddNewChannel_Key']          		= "新しいターゲットチャンネルを追加する(<u>n</u>)";
$GLOBALS['strNoChannels']                 		= "チャンネルが存在しません";
$GLOBALS['strEditChannelLimitations']     		= "ターゲットチャンネルの制限を変更する";
$GLOBALS['strChannelProperties']          		= "ターゲットチャンネルの設定";
$GLOBALS['strChannelLimitations']         		= "配信オプション";
$GLOBALS['strConfirmDeleteChannel']       		= "このチャンネルを本当に削除しますか？";
$GLOBALS['strModifychannel']              		= "ターゲットチャンネルを変更する";

// Tracker Variables
$GLOBALS['strVariableName']             		= "トラッカー変数名";
$GLOBALS['strVariableDescription']     			= "記事";
$GLOBALS['strVariableDataType']         		= "データタイプ";
$GLOBALS['strVariablePurpose']       			= "用途";
$GLOBALS['strGeneric']               			= "汎用Adserver";
$GLOBALS['strBasketValue']           			= "バスケット値";
$GLOBALS['strNumItems']              			= "アイテム番号";
$GLOBALS['strVariableIsUnique']      			= "コンバージョンを停止";
$GLOBALS['strJavascript']             			= "Javascript";
$GLOBALS['strRefererQuerystring']     			= "リファラ・クエリーストリング";
$GLOBALS['strQuerystring']             			= "クエリーストリング";
$GLOBALS['strInteger']                 			= "整数";
$GLOBALS['strNumber']                 			= "番号";
$GLOBALS['strString']                 			= "文字列";
$GLOBALS['strTrackFollowingVars']     			= "次のトラッカー変数を追跡する";
$GLOBALS['strAddVariable']             			= "トラッカー変数の追加";
$GLOBALS['strNoVarsToTrack']         			= "トラッカー変数が定義されていません";
$GLOBALS['strVariableHidden']       			= "Webサイトに変数を隠す？";
$GLOBALS['strVariableRejectEmpty']  			= "トラッカーがヌルの場合、拒否する？";
$GLOBALS['strTrackingSettings']     			= "トラッカーの設定";
$GLOBALS['strTrackerType']          			= "トラッカータイプ";
$GLOBALS['strTrackerTypeJS']        			= "トラッカー用JavaScript変数";
$GLOBALS['strTrackerTypeDefault']   			= "トラッカー用JavaScript変数(後方互換、エスケーピング処理)";
$GLOBALS['strTrackerTypeDOM']       			= "トラッカー用DOM版HTMLエレメント";
$GLOBALS['strTrackerTypeCustom']    			= "トラッカー用カスタムJavascriptコード";
$GLOBALS['strVariableCode']         			= "トラッカー用Javascriptコード";


// Upload conversions
$GLOBALS['strRecordLengthTooBig']   			= 'レコード長が大きすぎます';
$GLOBALS['strRecordNonInt']         			= '値が整数ではありません';
$GLOBALS['strRecordWasNotInserted'] 			= 'レコードを追加できませんでした';
$GLOBALS['strWrongColumnPart1']     			= '<br />CSVファイルにエラーがあります！カラム <b>';
$GLOBALS['strWrongColumnPart2']     			= '</b> は、このトラッカーでは許可されていません。';
$GLOBALS['strMissingColumnPart1']   			= '<br />CSVファイルにエラーがあります！カラム <b>';
$GLOBALS['strMissingColumnPart2']   			= '</b> は、正しくありません。';
$GLOBALS['strYouHaveNoTrackers']    			= '広告主にはトラッカーがありません！';
$GLOBALS['strYouHaveNoCampaigns']   			= '広告主＆キャンペーン';
$GLOBALS['strYouHaveNoBanners']     			= 'キャンペーンにはバナーがありません！';
$GLOBALS['strYouHaveNoZones']       			= 'バナーにはリンクされたゾーンがありません！';
$GLOBALS['strNoBannersDropdown']    			= '--バナーが見つかりません--';
$GLOBALS['strNoZonesDropdown']      			= '--ゾーンが見つかりません--';
$GLOBALS['strInsertErrorPart1']     			= '<br /><br /><center><b> エラー, ';
$GLOBALS['strInsertErrorPart2']     			= 'レコードを追加しませんでした！</b></center>';
$GLOBALS['strDuplicatedValue']      			= '値が重複しています！';
$GLOBALS['strInsertCorrect']        			= '<br /><br /><center><b> ファイルをアップロードしました！ </b></center>';
$GLOBALS['strReuploadCsvFile']      			= 'CSVファイルの再アップロード';
$GLOBALS['strConfirmUpload']        			= 'アップロードの確認';
$GLOBALS['strLoadedRecords']        			= '件のアップロードレコード';
$GLOBALS['strBrokenRecords']        			= 'レコード内に破損したフィールドがありました。';
$GLOBALS['strWrongDateFormat']      			= '日付フォーマットが間違っています';


// Password recovery
$GLOBALS['strForgotPassword']         			= "パスワードを忘れた？";
$GLOBALS['strPasswordRecovery']       			= "パスワードのリカバリ";
$GLOBALS['strEmailRequired']          			= "メールアドレスは必須です。";
$GLOBALS['strPwdRecEmailNotFound']    			= "指定したメールアドレスは見つかりませんでした。";
$GLOBALS['strPwdRecPasswordSaved']    			= "新しいパスワードを保存しました。継続するには、<a href='index.php'><b>ログイン</b></a>してください。";
$GLOBALS['strPwdRecWrongId']          			= "メールアドレスが間違っています。";
$GLOBALS['strPwdRecEnterEmail']       			= "メールアドレスを入力してください";
$GLOBALS['strPwdRecEnterPassword']    			= "新しいパスワードを入力してください";
$GLOBALS['strPwdRecReset']            			= "パスワードリセット";
$GLOBALS['strPwdRecResetLink']        			= "パスワードをリセットするには、次のURLをクリックしてください。";
$GLOBALS['strPwdRecResetPwdThisUser'] 			= "このユーザのパスワードをリセット";
$GLOBALS['strPwdRecEmailPwdRecovery'] 			= "%s ログインパスワードのリカバリ";
$GLOBALS['strProceed']                			= "続ける &gt;";
$GLOBALS['strNotifyPageMessage']      			= "パスワードをリセットするためのメールが送信されました。<br />もし届いてない場合は迷惑メールと見なされているか、Eメールの設定を見直して下さい。<br /><a href='index.php'>トップに戻る</a>";

// Audit
$GLOBALS['strAdditionalItems']        			= '追加内容';
$GLOBALS['strFor']                    			= 'for';
$GLOBALS['strHas']                    			= '\=';
$GLOBALS['strAdZoneAsscociation']     			= 'Ad ゾーンアソシエーション';
$GLOBALS['strBinaryData']             			= 'バイナリデータ';
$GLOBALS['strAuditTrailDisabled']     			= '管理者によって追跡記録が無効となりました。現在ログは取得されていません。また追跡記録のリストも表示されません。';


// Widget - Audit
$GLOBALS['strAuditNoData']            			= "指定期間内のユーザ活動記録はありません。";
$GLOBALS['strAuditTrail']             			= "追跡記録";
$GLOBALS['strAuditTrailSetup']          		= "本日の追跡記録を設定する";
$GLOBALS['strAuditTrailGoTo']           		= "追跡記録ページに移動する";
$GLOBALS['strAuditTrailNotEnabled']     		= "<li>追跡記録機能は、誰がいつ何をしたかを記録するものです。</li><li>興味がある場合は、 <a href='". OX_PRODUCT_DOCSURL ."/settings/auditTrail' class='site-link' target='help' >追跡記録機能について documentation</a>を参照してください</li>";

// Widget - Campaign
$GLOBALS['strCampaignGoTo']             		= 'キャンペーンのページに飛ぶ';
$GLOBALS['strCampaignSetUp']            		= '本日のキャンペーンを設定する';
$GLOBALS['strCampaignNoRecords']        		= '<li>キャンペーンは複数のバナーを一括して管理することができる機能です。</li><li>使い方に関しては、<a class=\'site-link\' target=\'help\' href=\'\". '.OX_PRODUCT_DOCSURL.' .\"/inventory/advertisersAndCampaigns/campaigns\'>キャンペーンについて</a>を参照してください</li>';
$GLOBALS['strCampaignNoRecordsAdmin']   		= '<li>このキャンペーンには活動記録がありません</li>';

$GLOBALS['strCampaignNoDataTimeSpan']    		= '選択した期間内において、開始されるキャンペーンもしくは終了するキャンペーンはありません。';
$GLOBALS['strCampaignAuditNotActivated'] 		= '<li>選択した期間内に開始または終了するキャンペーンを見たい場合は、追跡記録機能を有効にして下さい</li>';
$GLOBALS['strCampaignAuditTrailSetup']   		= "キャンペーンの活動状況を確認するため、追跡記録をアクティブにする";


/*-------------------------------------------------------*/
/* Keyboard shortcut assignments                         */
/*-------------------------------------------------------*/

// Reserved keys
// Do not change these unless absolutely needed
$GLOBALS['keyHome']            			= 'h';
$GLOBALS['keyUp']            			= 'u';
$GLOBALS['keyNextItem']        			= '.';
$GLOBALS['keyPreviousItem']    			= ',';
$GLOBALS['keyList']            			= 'l';

// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
$GLOBALS['keySearch']        			= 's';
$GLOBALS['keyCollapseAll']    			= 'c';
$GLOBALS['keyExpandAll']    			= 'e';
$GLOBALS['keyAddNew']        			= 'n';
$GLOBALS['keyNext']            			= 'n';
$GLOBALS['keyPrevious']        			= 'p';
$GLOBALS['keyLinkUser']        			= 'u';



// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strHideParentAdvertisers'] = "親キャンペーンの非表示";
$GLOBALS['strCampaignWarningRemnantNoWeight'] = "優先度が'低'に設定されていますが、\nウェイトがゼロか未設定です。\nこのため、ウェイトが設定されるまでキャンペーンは無効で、\nバナーは配信されません。\n\n本当に継続しますか？";
$GLOBALS['strCampaignWarningExclusiveNoWeight'] = "優先度が'低'に設定されていますが、\nウェイトがゼロか未設定です。\nこのため、ウェイトが設定されるまでキャンペーンは無効で、\nバナーは配信されません。\n\n本当に継続しますか？";
$GLOBALS['strConversionType'] = "コンバージョンタイプ";
$GLOBALS['strAdvertiserSignup'] = "広告主サインアップ";
$GLOBALS['strContactName'] = "コンタクト名";
$GLOBALS['strNoAdminInterface'] = "メンテナンスのため、管理画面機能が無効になっています。広告の配信には何ら影響はありません。";
$GLOBALS['strOverallAdvertisers'] = "広告主";
$GLOBALS['strAdvertiserSignupDesc'] = "広告主のセルフサービスと課金サービスにサインアップする";
$GLOBALS['strOverallCampaigns'] = "キャンペーン";
$GLOBALS['strTotalRevenue'] = "利益合計";
$GLOBALS['strChangeStatus'] = "ステータスの変更";
$GLOBALS['strImpression'] = "インプレッション数";
$GLOBALS['strOverallBanners'] = "バナー";
$GLOBALS['strTrackerImageTag'] = "イメージタグ";
$GLOBALS['strTrackerJsTag'] = "JavaScriptタグ";
$GLOBALS['strPeriod'] = "期限";
$GLOBALS['strWorksheets'] = "ワークシート";
$GLOBALS['strSwitchAccount'] = "アカウントの変更";
$GLOBALS['strPasswordRepeat'] = "パスワードの再確認";
$GLOBALS['strAdd'] = "追加";
$GLOBALS['strRequiredField'] = "必須項目";
$GLOBALS['strNoSslSupport'] = "SSLをサポートしていません。";
$GLOBALS['strSslAccessCentralSys'] = "トップページにアクセスするには、SSLを組み込んでアクセスする必要があります。";
$GLOBALS['strInstallSslExtension'] = "PHPを拡張させ、SSLに対応させる必要があります。";
$GLOBALS['strChoosenDisableHomePage'] = "トップページを無効にしました。";
$GLOBALS['strAccessHomePage'] = "トップページにいく";
$GLOBALS['strEditSyncSettings'] = "同期設定を変更する";
$GLOBALS['strLastLoggedIn'] = "最終ログイン";
$GLOBALS['strDateLinked'] = "リンクされた日付";
$GLOBALS['strUnlink'] = "削除";
$GLOBALS['strUnlinkingFromLastEntity'] = "エンティティから削除する";
$GLOBALS['strUnlinkingFromLastEntityBody'] = "エンティティからユーザを削除するということは、ユーザのアカウント自体を削除するということになります。本当に削除しますか？";
$GLOBALS['strUnlinkAndDelete'] = "ユーザアカウントを削除する";
$GLOBALS['strUnlinkUser'] = "ユーザを削除";
$GLOBALS['strUnlinkUserConfirmBody'] = "本当にこのユーザを削除しますか？";
$GLOBALS['strDeadLink'] = "不正なリンクです。";
$GLOBALS['strNoPlacement'] = "指定されたキャンペーンは存在しません。<a href='{link}'>こちらのリンク</a>を代わりに使って下さい。";
$GLOBALS['strNoAdvertiser'] = "指定された広告主は存在しません。<a href='{link}'>こちらのリンク</a>を代わりに使って下さい。";
$GLOBALS['strPercentRevenueSplit'] = "% 利益分割";
$GLOBALS['strPercentBasketValue'] = "% バスケット値";
$GLOBALS['strAmountPerItem'] = "アイテム毎の金額";
$GLOBALS['strPercentCustomVariable'] = "% カスタマイズされた値";
$GLOBALS['strPercentSumVariables'] = "% 合計した値";
$GLOBALS['strAdvertiserSignupLink'] = "広告主サインアップのリンク";
$GLOBALS['strAdvertiserSignupLinkDesc'] = "広告主がサインアップするリンクを追加するには、以下のHTMLタグをコピーして下さい：";
$GLOBALS['strAdvertiserSignupOption'] = "広告主サインアップのオプション";
$GLOBALS['strAdvertiserSignunOptionDesc'] = "広告主サインアップのオプションを変更するには以下をたどって下さい。";
$GLOBALS['strCampaignStatusPending'] = "保留";
$GLOBALS['strCampaignStatusDeleted'] = "削除";
$GLOBALS['strTrackers'] = "トラッカー";
$GLOBALS['strWebsiteURL'] = "WebサイトのURL";
$GLOBALS['strInventoryForecasting'] = "在庫の見通し";
$GLOBALS['strPerSingleImpression'] = "/１インプレッション";
$GLOBALS['strWithXBanners'] = "%d バナー";
$GLOBALS['strStatsArea'] = "エリア";
$GLOBALS['strNoExpirationEstimation'] = "期限日は未定です";
$GLOBALS['strDaysAgo'] = "日前";
$GLOBALS['strCampaignStop'] = "キャンペーン中断";
$GLOBALS['strErrorEditingCampaignRevenue'] = "利益情報のフィールドに無効な数値が入力されています。";
$GLOBALS['strErrorEditingZone'] = "更新したゾーンにエラーが発生：";
$GLOBALS['strUnableToChangeZone'] = "以下の理由により、この変更を適用できませんでした：";
$GLOBALS['strErrorEditingZoneTechnologyCost'] = "メディアコストのフィールドに無効な数値が入力されています。";
$GLOBALS['strErrorEditingZoneCost'] = "テクノロジーコストのフィールドに無効な数値が入力されています。";
$GLOBALS['strLanguageTimezonePreferences'] = "言語とタイムゾーンの設定";
$GLOBALS['strColumnName'] = "カラム名";
$GLOBALS['strShowColumn'] = "カラムを表示";
$GLOBALS['strCustomColumnName'] = "カスタムカラム名";
$GLOBALS['strColumnRank'] = "カラムランク";
$GLOBALS['strCost'] = "コスト";
$GLOBALS['strNumberOfItems'] = "アイテム番号";
$GLOBALS['strRevenueCPC'] = "CPC収入";
$GLOBALS['strCostCPC'] = "CPCコスト";
$GLOBALS['strIncome'] = "収入";
$GLOBALS['strIncomeMargin'] = "収入マージン";
$GLOBALS['strProfit'] = "利益";
$GLOBALS['strMargin'] = "マージン";
$GLOBALS['strERPM'] = "ERPM";
$GLOBALS['strERPC'] = "ERPC";
$GLOBALS['strERPS'] = "ERPS";
$GLOBALS['strEIPM'] = "EIPM";
$GLOBALS['strEIPC'] = "EIPC";
$GLOBALS['strEIPS'] = "EIPS";
$GLOBALS['strECPM'] = "ECPM";
$GLOBALS['strECPC'] = "ECPC";
$GLOBALS['strECPS'] = "ECPS";
$GLOBALS['strEPPM'] = "EPPM";
$GLOBALS['strEPPC'] = "EPPC";
$GLOBALS['strEPPS'] = "EPPS";
$GLOBALS['strFromVersion'] = "このバージョンから";
$GLOBALS['strToVersion'] = "このバージョンまで";
$GLOBALS['strToggleDataBackupDetails'] = "データのバックアップの詳細を切り替える";
$GLOBALS['strClickViewBackupDetails'] = "クリックしてバックアップの詳細を見る";
$GLOBALS['strClickHideBackupDetails'] = "クリックしてバックアップの詳細を隠す";
$GLOBALS['strShowBackupDetails'] = "バックアップの詳細を表示する";
$GLOBALS['strHideBackupDetails'] = "バックアップの詳細を隠す";
$GLOBALS['strInstallation'] = "インストール";
$GLOBALS['strBackupDeleteConfirm'] = "本当にすべてのバックアップを消去しますか？";
$GLOBALS['strDeleteArtifacts'] = "誤差を削除しますか？";
$GLOBALS['strArtifacts'] = "誤差";
$GLOBALS['strBackupDbTables'] = "データベースをバックアップする";
$GLOBALS['strLogFiles'] = "ログファイル";
$GLOBALS['strConfigBackups'] = "バックアップの設定";
$GLOBALS['strUpdatedDbVersionStamp'] = "データベースのバージョン日時を更新する";
$GLOBALS['strPwdRecEmailSent'] = "送信されたEメールを復元する";
$GLOBALS['strAccount'] = "アカウント";
$GLOBALS['strAccountUserAssociation'] = "ユーザアカウント関連";
$GLOBALS['strImage'] = "画像";
$GLOBALS['strCampaignZoneAssociation'] = "キャンペーン・ゾーン関連";
$GLOBALS['strAccountPreferenceAssociation'] = "アカウント設定関連";
$GLOBALS['strUnsavedChanges'] = "変更が保存されていません。\"保存する\"ボタンを押してください。";
$GLOBALS['strDeliveryLimitationsDisagree'] = "注意：配信エンジン制限です。<strong>絶対に</strong>以下の制限を承認しないでください<br />配信エンジンのルールを保存してください。";
$GLOBALS['strPendingConversions'] = "保留されているコンバージョン数";
$GLOBALS['strImpressionSR'] = "インプレッションSR";
$GLOBALS['strClickSR'] = "クリックSR";
$GLOBALS['str_cs'] = "チェコ語";
$GLOBALS['str_de'] = "ドイツ語";
$GLOBALS['str_en'] = "英語";
$GLOBALS['str_es'] = "スペイン語";
$GLOBALS['str_fa'] = "ペルシア語";
$GLOBALS['str_fr'] = "フランス語";
$GLOBALS['str_he'] = "ヘブライ語";
$GLOBALS['str_hu'] = "ハンガリー語";
$GLOBALS['str_id'] = "インドネシア語";
$GLOBALS['str_it'] = "イタリア語";
$GLOBALS['str_ja'] = "日本語";
$GLOBALS['str_ko'] = "朝鮮語";
$GLOBALS['str_nl'] = "オランダ語";
$GLOBALS['str_pl'] = "ポーランド語";
$GLOBALS['str_ro'] = "ルーマニア語";
$GLOBALS['str_ru'] = "ロシア語";
$GLOBALS['str_sl'] = "スロベニア語";
$GLOBALS['str_tr'] = "トルコ語";
$GLOBALS['strSwitchTo'] = "動作モード変更";
$GLOBALS['strRevenue'] = "収入";
$GLOBALS['str_ar'] = "アラビア語";
$GLOBALS['str_bg'] = "ブルガリア語";
$GLOBALS['str_cy'] = "ウェールズ語";
$GLOBALS['str_da'] = "デンマーク語";
$GLOBALS['str_el'] = "ギリシャ語";
$GLOBALS['str_hr'] = "クロアチア語";
$GLOBALS['str_lt'] = "リトアニア語";
$GLOBALS['str_ms'] = "マレー語";
$GLOBALS['str_nb'] = "ブークモール・ノルウェー語";
$GLOBALS['str_sk'] = "スロバキア語";
$GLOBALS['str_sv'] = "スウェーデン語";
$GLOBALS['str_uk'] = "ウクライナ語";
$GLOBALS['strDashboardErrorCode'] = "エラーコード";
$GLOBALS['strDashboardGenericError'] = "一般エラー";
$GLOBALS['strDashboardSystemMessage'] = "システムメッセージ";
$GLOBALS['strDashboardErrorHelp'] = "このエラーが繰り返し発生する場合、問題の詳細を<a href='http://forum.openx.org/'>OpenXフォーラム</a>に投稿してください。";
$GLOBALS['strDashboardErrorMsg800'] = "XML-RPC接続エラー";
$GLOBALS['strDashboardErrorMsg801'] = "認証エラー";
$GLOBALS['strDashboardErrorMsg802'] = "画像キャプチャ不一致エラー";
$GLOBALS['strDashboardErrorMsg803'] = "パラメータ不正エラー";
$GLOBALS['strDashboardErrorMsg804'] = "ユーザ名不一致エラー";
$GLOBALS['strDashboardErrorMsg805'] = "プラットホームアクセスエラー";
$GLOBALS['strDashboardErrorMsg806'] = "サーバーエラー";
$GLOBALS['strDashboardErrorMsg807'] = "権限エラー";
$GLOBALS['strDashboardErrorMsg808'] = "XML-RPCバージョン不一致エラー";
$GLOBALS['strDashboardErrorMsg900'] = "コネクションエラー";
$GLOBALS['strDashboardErrorMsg821'] = "M2M認証エラー - アカウントタイプが許可されていません";
$GLOBALS['strDashboardErrorMsg822'] = "M2M認証エラー - パスワードはすでに生成されています";
$GLOBALS['strDashboardErrorMsg823'] = "M2M認証エラー - パスワードが合致しません";
$GLOBALS['strDashboardErrorMsg824'] = "M2M認証エラー - パスワードは失効しました";
$GLOBALS['strDashboardErrorMsg825'] = "M2M認証エラー - 接続エラー";
$GLOBALS['strDashboardErrorMsg826'] = "M2M認証エラー - 再接続エラー";
$GLOBALS['strDashboardErrorDsc800'] = "ダッシュボードはOpenXセントラルサーバからウィジェットに情報をプルします。このことに影響を与えるいくつかのことがあります。<br/>                                           　　サーバはCurlエクステンションが有効になっていないかもしれませんが、Curlエクステンションをインストールするか有効にしてください。詳しくは、<a href='http://php.net/curl'>ここ</a>を参照してください。<br/>                                           　　また、その際ファイアウォールがアウトバウンド接続をブロックしていないかチェックしてください。";
$GLOBALS['strDashboardErrorDsc803'] = "サーバへの不正パラメータリクエストによりエラーが発生しました。データを修正して再度送信してください。";
$GLOBALS['strDashboardErrorDsc805'] = "OpenXのインストール中にXML-RPC接続が許可されなかったので、OpenXセントラルサーバはOpenXの正常インストールを認識していません。<br />                                           　　OpenXセントラルサーバに接続し登録するには、管理者アカウントのマイアカウント -> 製品アップデートに進んでください。";
$GLOBALS['strActions'] = "アクション";
$GLOBALS['strFinanceCTR'] = "CTR";
$GLOBALS['strNoClientsForBanners'] = "広告主が存在しません。キャンペーンを作成するためには、先に<a href='advertiser-edit.php'>広告主の作成</a>をして下さい。";
$GLOBALS['strAdvertiserCampaigns'] = "広告主＆キャンペーン";
$GLOBALS['strCampaignStatusInactive'] = "アクティブ";
$GLOBALS['strCampaignType'] = "キャンペーン名";
$GLOBALS['strContract'] = "担当者名";
$GLOBALS['strStandardContract'] = "担当者名";
$GLOBALS['strBannerToCampaign'] = "対象キャンペーン";
$GLOBALS['strBannersOfCampaign'] = "内の";
$GLOBALS['strWebsiteZones'] = "Webサイト＆ゾーン";
$GLOBALS['strZoneToWebsite'] = "すべてのWebサイト";
$GLOBALS['strNoZonesAddWebsite'] = "Webサイトが存在しません。広告枠を作成する前に、先に<a href='affiliate-edit.php'>Webサイトを作成</a>して下さい。";
$GLOBALS['strZonesOfWebsite'] = "内の";
$GLOBALS['strPluginPreferences'] = "メインプリファレンス";
$GLOBALS['strRevenue_short'] = "収益";
$GLOBALS['strCost_short'] = "コスト";
$GLOBALS['strBasketValue_short'] = "バスケット値";
$GLOBALS['strNumberOfItems_short'] = "アイテム数";
$GLOBALS['strRevenueCPC_short'] = "収益CPC";
$GLOBALS['strCostCPC_short'] = "CPCコスト";
$GLOBALS['strTechnologyCost_short'] = "テク費用";
$GLOBALS['strIncome_short'] = "収入";
$GLOBALS['strIncomeMargin_short'] = "収入マージン";
$GLOBALS['strProfit_short'] = "利益";
$GLOBALS['strMargin_short'] = "マージン";
$GLOBALS['strERPM_short'] = "ERPM";
$GLOBALS['strERPC_short'] = "ERPC";
$GLOBALS['strERPS_short'] = "ERPS";
$GLOBALS['strEIPM_short'] = "EIPM";
$GLOBALS['strEIPC_short'] = "EIPC";
$GLOBALS['strEIPS_short'] = "EIPS";
$GLOBALS['strECPM_short'] = "ECPM";
$GLOBALS['strECPC_short'] = "ECPC";
$GLOBALS['strECPS_short'] = "ECPS";
$GLOBALS['strEPPM_short'] = "EPPM";
$GLOBALS['strEPPC_short'] = "EPPC";
$GLOBALS['strEPPS_short'] = "EPPS";
$GLOBALS['strChannelToWebsite'] = "すべてのWebサイト";
$GLOBALS['strChannelsOfWebsite'] = "内の";
$GLOBALS['strConfirmDeleteClients'] = "この広告主を本当に削除しますか？";
$GLOBALS['strConfirmDeleteCampaigns'] = "このキャンペーンを本当に削除しますか？";
$GLOBALS['strConfirmDeleteTrackers'] = "このトラッカーを本当に削除しますか？";
$GLOBALS['strNoBannersAddCampaign'] = "Webサイトが存在しません。広告枠を作成する前に、先に<a href='affiliate-edit.php'>Webサイトを作成</a>して下さい。";
$GLOBALS['strNoBannersAddAdvertiser'] = "Webサイトが存在しません。広告枠を作成する前に、先に<a href='affiliate-edit.php'>Webサイトを作成</a>して下さい。";
$GLOBALS['strConfirmDeleteBanners'] = "このバナーを本当に削除しますか?";
$GLOBALS['strConfirmDeleteAffiliates'] = "このWebサイトを本当に削除しますか?";
$GLOBALS['strConfirmDeleteZones'] = "このゾーンを本当に削除しますか?";
$GLOBALS['strErrorCantConnectToDatabase'] = "重大なエラーが発生しました。".MAX_PRODUCT_NAME."はデータベースに接続できません。このため、管理者インタフェースにアクセスできません。バナー配信に影響があるかもしれません。想定される理由は次のとおりです:<ul><li>データベースサーバが一時的に利用できない状態になっている</li><li>データベースサーバのホスト名やIPアドレスが変更された</li><li>データベース接続用ユーザ名とパスワードが間違っている</li><li>PHPがMySQL拡張プラグインをロードしていない</li></ul>";
$GLOBALS['strActualImpressions'] = "インプレッション数";
$GLOBALS['strID_short'] = "ID";
$GLOBALS['strRequests_short'] = "収益";
$GLOBALS['strClicks_short'] = "クリック数";
$GLOBALS['strCTR_short'] = "CTR";
$GLOBALS['strConversions_short'] = "コンバージョン数";
$GLOBALS['strPendingConversions_short'] = "保留コンバージョン数";
$GLOBALS['strClickSR_short'] = "クリックSR";
$GLOBALS['strNoChannelsAddWebsite'] = "Webサイトが存在しません。広告枠を作成する前に、先に<a href='affiliate-edit.php'>Webサイトを作成</a>して下さい。";
$GLOBALS['strConfirmDeleteChannels'] = "このチャンネルを本当に削除しますか？";
$GLOBALS['strHideInactiveOverview'] = "非アクティブなものを隠す";
$GLOBALS['strAppendNewTag'] = "新しくタグを追加する";
$GLOBALS['strMoveUp'] = "上へ";
$GLOBALS['strMoveDown'] = "下へ";
$GLOBALS['strRestart'] = "再開済";
$GLOBALS['strRegexMatch'] = "正規表現で合致";
$GLOBALS['strRegexNotMatch'] = "正規表現で合致しない";
$GLOBALS['strIsAnyOf'] = "いずれか";
$GLOBALS['strIsNotAnyOf'] = "いずれも含まない";
$GLOBALS['strCappingBanner']['title'] = "{$GLOBALS['strDeliveryCapping']}";
$GLOBALS['strCappingCampaign']['title'] = "{$GLOBALS['strDeliveryCapping']}";
$GLOBALS['strCappingZone']['title'] = "{$GLOBALS['strDeliveryCapping']}";
$GLOBALS['strPickCategory'] = "\- カテゴリを選択してください -";
$GLOBALS['strPickCountry'] = "\- 国を選択してください -";
$GLOBALS['strPickLanguage'] = "\- 言語を選択してください -";
$GLOBALS['strSettings'] = "設定";
$GLOBALS['strNoWebsites'] = "すべてのWebサイト";
$GLOBALS['strSomeWebsites'] = "すべてのWebサイト";
$GLOBALS['strVariableHiddenTo'] = "トラッカー変数を";
$GLOBALS['strHide'] = "隠す:";
$GLOBALS['strShow'] = "表示する:";
$GLOBALS['strAdminNovice'] = "管理者が削除する際に確認画面を表示する";
$GLOBALS['strTimezoneInformation'] = "タイムゾーン（変更すると、統計情報に影響が出ます）";
$GLOBALS['strBannerSettings'] = "".MAX_PRODUCT_NAME." バナー設定";
$GLOBALS['strDebugSettings'] = "ログを検査する";
$GLOBALS['strCacheFiles'] = "ファイル";
$GLOBALS['strDeliveryBanner'] = "共通バナー配信設定";
$GLOBALS['strInterfaceDefaults'] = "デフォルトのインタフェース";
$GLOBALS['strInvocationAndDelivery'] = "バナー生成の設定";
$GLOBALS['strIncovationDefaults'] = "バナー生成のデフォルト";
$GLOBALS['strStatisticsSettings'] = "統計とメンテナンスの設定";
$GLOBALS['strStatisticsLogging'] = "共通の統計ログ設定";
$GLOBALS['strMaintenaceSettings'] = "共通のメンテナンス設定";
$GLOBALS['strMaintenanceAdServerInstalled'] = "アドサーバーのモジュールの統計を取る";
$GLOBALS['strMaintenanceTrackerInstalled'] = "追跡モジュールの統計を取る";
$GLOBALS['strEmailWarnings'] = "警告Eメール";
$GLOBALS['strIn'] = "内の";
$GLOBALS['strEventDetails'] = "イベント詳細";
$GLOBALS['strEventHistory'] = "イベント履歴";
$GLOBALS['strLinkNewUser_Key'] = "ユーザをリンクする(<u>u</u>)";
$GLOBALS['strOpenadsImpressionsRemaining'] = "OpenXインプレッション残数";
$GLOBALS['strOpenadsImpressionsRemainingHelp'] = "キャンペーンで指定したインプレッション数に、広告主が希望するインプレッション数よりも小さい値が入っています。";
$GLOBALS['strOpenadsClicksRemaining'] = "OpenX クリック残数";
$GLOBALS['strOpenadsConversionsRemaining'] = "OpenX　コンバージョン残数";
$GLOBALS['strNoDataToDisplay'] = "表示可能なデータがありません。";
$GLOBALS['strDisagreeACL_BannersExplaination'] = "何らかの状況下において、配信エンジンがトラックコードを拒否しました。以下のリンクをたどって修正をして下さい。";
$GLOBALS['strHomePageDisabled'] = "トップページが非表示になっています";
$GLOBALS['strIab']['IAB_FullBanner(468x60)'] = "IAB Full Banner (468 x 60)";
$GLOBALS['strIab']['IAB_Skyscraper(120x600)'] = "IAB Skyscraper (120 x 600)";
$GLOBALS['strIab']['IAB_Leaderboard(728x90)'] = "IAB Leaderboard (728 x 90)";
$GLOBALS['strIab']['IAB_Button1(120x90)'] = "IAB Button 1 (120 x 90)";
$GLOBALS['strIab']['IAB_Button2(120x60)'] = "IAB Button 2 (120 x 60)";
$GLOBALS['strIab']['IAB_HalfBanner(234x60)'] = "IAB Half Banner (234 x 60)";
$GLOBALS['strIab']['IAB_LeaderBoard(728x90)*'] = "IAB Leader Board (728 x 90) *";
$GLOBALS['strIab']['IAB_MicroBar(88x31)'] = "IAB Micro Bar (88 x 31)";
$GLOBALS['strIab']['IAB_SquareButton(125x125)'] = "IAB Square Button (125 x 125)";
$GLOBALS['strIab']['IAB_Rectangle(180x150)*'] = "IAB Rectangle (180 x 150)";
$GLOBALS['strIab']['IAB_SquarePop-up(250x250)'] = "IAB Square Pop-up (250 x 250)";
$GLOBALS['strIab']['IAB_VerticalBanner(120x240)'] = "IAB Vertical Banner (120 x 240)";
$GLOBALS['strIab']['IAB_MediumRectangle(300x250)*'] = "IAB Medium Rectangle (300 x 250)";
$GLOBALS['strIab']['IAB_LargeRectangle(336x280)'] = "IAB Large Rectangle (336 x 280)";
$GLOBALS['strIab']['IAB_VerticalRectangle(240x400)'] = "IAB Vertical Rectangle (240 x 400)";
$GLOBALS['strIab']['IAB_WideSkyscraper(160x600)*'] = "IAB Wide Skyscraper (160 x 600)";
$GLOBALS['strRevenueShort'] = "収益";
$GLOBALS['strCostShort'] = "コスト";
$GLOBALS['strBasketValueShort'] = "バスケット値";
$GLOBALS['strNumberOfItemsShort'] = "アイテム数";
$GLOBALS['strRevenueCPCShort'] = "収益CPC";
$GLOBALS['strCostCPCShort'] = "CPCコスト";
$GLOBALS['strTechnologyCostShort'] = "テク費用";
$GLOBALS['strIncomeShort'] = "収入";
$GLOBALS['strIncomeMarginShort'] = "収入マージン";
$GLOBALS['strProfitShort'] = "利益";
$GLOBALS['strMarginShort'] = "マージン";
$GLOBALS['aProductStatus']['UPGRADE_COMPLETE'] = "アップグレードが完了しました";
$GLOBALS['aProductStatus']['UPGRADE_FAILED'] = "アップグレードが失敗しました";
$GLOBALS['strConversionsShort'] = "コンバージョン数";
$GLOBALS['strPendingConversionsShort'] = "保留コンバージョン数";
$GLOBALS['strClickSRShort'] = "クリックSR";
$GLOBALS['phpAds_hlp_my_header'] = "ヘッダ・フッタファイルへのパスをここに入力して下さい。(例: /home/login/www/header.htm)それらファイルには、HTMLタグ、テキストの両方を書くことが出来ます。中として、HTMLタグを含める場合は、<body>と<html>タグは入力しないでください。";
$GLOBALS['strReportBug'] = "バグを報告する";
$GLOBALS['strSameWindow'] = "同一ウィンドウ";
$GLOBALS['strNewWindow'] = "ビュー ウィンドウ";
$GLOBALS['strClick-ThroughRatio'] = "クリック率";
$GLOBALS['strImpressionSRShort'] = "インプレッションSR";
$GLOBALS['strRequestsShort'] = "収益";
$GLOBALS['strClicksShort'] = "クリック数";
$GLOBALS['strImpressionsShort'] = "インプレッション数";
$GLOBALS['strCampaignTracker'] = "キャンペーントラッカー";
$GLOBALS['strVariable'] = "変数";
$GLOBALS['strAffiliateExtra'] = "ウェブサイト拡張情報";
$GLOBALS['strPreference'] = "プリファレンス";
$GLOBALS['strAccountUserPermissionAssociation'] = "アカウントとユーザ権限の関連づけ";
$GLOBALS['strDeliveryLimitation'] = "配信先";
$GLOBALS['strSaveAnyway'] = "今すぐ保存";
$GLOBALS['str_ID'] = "ID";
$GLOBALS['str_Requests'] = "リクエスト数";
$GLOBALS['str_Impressions'] = "インプレッション数";
$GLOBALS['str_Clicks'] = "クリック数";
$GLOBALS['str_CTR'] = "CTR";
$GLOBALS['str_BasketValue'] = "バスケット値";
$GLOBALS['str_TechnologyCost'] = "テクノロジーコスト";
?>