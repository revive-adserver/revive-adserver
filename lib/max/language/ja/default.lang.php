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
$GLOBALS['strAdminstration']            		= "広告在庫";
$GLOBALS['strMaintenance']              		= "メンテナンス";
$GLOBALS['strProbability']              		= "配信ウェイト";
$GLOBALS['strInvocationcode']           		= "呼出コード生成";
$GLOBALS['strTrackerVariables']         		= "トラッカー変数";
$GLOBALS['strBasicInformation']         		= "基本情報";
$GLOBALS['strContractInformation']      		= "契約情報";
$GLOBALS['strLoginInformation']         		= "ログイン情報";
$GLOBALS['strLogoutURL']                		= 'ログアウト時のリダイレクト先URL<br />デフォルト：空欄';
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
$GLOBALS['strDelete']                   		= "削除する";
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
$GLOBALS['strNoAdminInteface']            		= "ただいまメンテナンス中のため、管理画面は利用できません。なお、キャンペーンの配信にまったく影響ありません。";
$GLOBALS['strFilterBySource']            		= "ソースパラメータによるフィルタ";
$GLOBALS['strFieldStartDateBeforeEnd']  		= "\'開始日\'は、\'終了日\'以前の日付である必要があります";
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
$GLOBALS['strValue']                    		= '値';
$GLOBALS['strAdmin']                    		= "管理者";
$GLOBALS['strWarning']                  		= '警告';
$GLOBALS['strNotice']                   		= '注意';

// Dashboard
$GLOBALS['strDashboardCommunity']       		= 'コミュニティ';
$GLOBALS['strDashboardDashboard']       		= 'ダッシュボード';
$GLOBALS['strDashboardForum']           		= 'OpenX フォーラム';
$GLOBALS['strDashboardDocs']            		= 'OpenX ドキュメント';

// Priority
$GLOBALS['strPriority']                 		= "優先度";
$GLOBALS['strPriorityLevel']            		= "優先度レベル";
$GLOBALS['strPriorityTargeting']        		= "配信方法";
$GLOBALS['strPriorityOptimisation']     		= "その他";
$GLOBALS['strExclusiveAds']             		= "独占広告";
$GLOBALS['strHighAds']                  		= "高優先広告";
$GLOBALS['strLowAds']                   		= "低優先広告";
$GLOBALS['strLimitations']              		= "制限";
$GLOBALS['strNoLimitations']            		= "非制限";
$GLOBALS['strCapping']                  		= '上限設定';
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
$GLOBALS['strWorkingAs']                		= '役割：';
$GLOBALS['strWorkingFor']               		= '%s ...';
$GLOBALS['strLinkUser']                 		= "ユーザリンクの作成";
$GLOBALS['strLinkUser_Key']             		= "ユーザリンクの作成(<u>u</u>)";
$GLOBALS['strUsernameToLink']           		= "ユーザ名";
$GLOBALS['strEmailToLink']              		= "メールアドレス";
$GLOBALS['strNewUserWillBeCreated']     		= "新しいユーザを作成します";
$GLOBALS['strToLinkProvideEmail']       		= "リンク先のメールアドレスを入力してください";
$GLOBALS['strToLinkProvideUsername']    		= "リンク先のユーザ名を入力してください";
$GLOBALS['strErrorWhileCreatingUser']   		= "ユーザ作成エラー： %s";
$GLOBALS['strUserLinkedToAccount']      		= 'この契約アカウントにリンクするユーザを作成しました';
$GLOBALS['strUserAccountUpdated']       		= 'ユーザ情報を更新しました';
$GLOBALS['strUserUnlinkedFromAccount']  		= 'この契約アカウントにリンクするユーザを削除しました';
$GLOBALS['strUserWasDeleted']           		= '指定したユーザを削除しました';
$GLOBALS['strUserNotLinkedWithAccount'] 		= 'この契約アカウントにリンクするユーザは存在しません';
$GLOBALS['strCantDeleteOneAdminUser']   		= 'このユーザを削除できません。管理者権限を有するユーザが最低でも一人必要です。';
$GLOBALS['strLinkUserHelp']             		= '<b>既存ユーザ</b>にリンクするには、%sを入力して、"' . $GLOBALS['strLinkUser'] . '"をクリックしてください。<br /><b>新規ユーザ</b>にリンクするには、希望する新規%sを入力して、"' . $GLOBALS['strLinkUser'] . '"をクリックしてください。';
$GLOBALS['strLinkUserHelpUser']         		= 'ユーザ名';
$GLOBALS['strLinkUserHelpEmail']        		= 'メールアドレス';

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
$GLOBALS['strEnableCookies']					= MAX_PRODUCT_NAME."を使用するには、クッキーが有効になっている必要があります。";
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
$GLOBALS['strRequests']                 		= 'ページリクエスト数';
$GLOBALS['strImpressions']              		= "インプレッション数";
$GLOBALS['strClicks']                   		= "クリック数";
$GLOBALS['strConversions']              		= "コンバージョン数";
$GLOBALS['strCTRShort']                 		= "CTR";
$GLOBALS['strCTRShortHigh']             		= "CTRを高く";
$GLOBALS['strCTRShortLow']              		= "CTRを低く";
$GLOBALS['strCNVRShort']                		= "SR";
$GLOBALS['strCTR']                      		= "クリック率";
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
$GLOBALS['strFinanceMT']                		= '月額固定制';

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
$GLOBALS['strMonth'] 							= array("1月","2月","3月","4月","5月","6月","7月", "8月", "9月", "10月", "11月", "12月");
$GLOBALS['strDayFullNames']             		= array('日曜日', '月曜日', '火曜日', '水曜日', '木曜日', '金曜日', '土曜日');
$GLOBALS['strDayShortCuts'] 					= array("日","月","火","水","木","金","土");
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
$GLOBALS['strNoClients']						= "広告主が定義されていません";
$GLOBALS['strConfirmDeleteClient'] 				= "この広告主を本当に削除しますか？";
$GLOBALS['strConfirmResetClientStats']			= "この広告主に関する統計データを本当に削除しますか?";
$GLOBALS['strSite']                         	= 'サイト';
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
$GLOBALS['strAllowAuditTrailAccess']            = "このユーザによる追跡記録へのアクセスを許可する";


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
$GLOBALS['strPriorityInformation']         		= "フィルタ条件";
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
$GLOBALS['strHiddenWebsite']              		= "ウェブサイト";
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
$GLOBALS['strRevenueInfo']              		= '収益情報';
$GLOBALS['strImpressionsRemaining']     		= "残インプレッション数";
$GLOBALS['strClicksRemaining']             		= "残クリック数";
$GLOBALS['strConversionsRemaining']     		= "残コンバージョン数";
$GLOBALS['strImpressionsBooked']         		= "インプレッション数";
$GLOBALS['strClicksBooked']             		= "クリック数";
$GLOBALS['strConversionsBooked']         		= "コンバージョン数";
$GLOBALS['strCampaignWeight']            		= "未設定 - キャンペーンウェイトの設定：";
$GLOBALS['strTargetLimitAdImpressions'] 		= "インプレッション上限数";
$GLOBALS['strOptimise']                    		= "このキャンペーン配信を最適化する";
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
$GLOBALS['strCampaignStatusApproval']      		= "承認待ち »";
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
$GLOBALS['strWarningMissing']              		= '警告, タグが間違っています ';
$GLOBALS['strWarningMissingClosing']       		= ' タグの終了 ">"';
$GLOBALS['strWarningMissingOpening']       		= ' タグの開始 "<"';
$GLOBALS['strSubmitAnyway']       		   		= 'とにかく実行';

// Banner Preferences
$GLOBALS['strBannerPreferences']                = 'バナープリファレンス';
$GLOBALS['strDefaultBanners']                   = 'デフォルトバナー';
$GLOBALS['strDefaultBannerUrl']                 = 'デフォルトイメージURL';
$GLOBALS['strDefaultBannerDestination']         = 'デフォルト配信先URL';
$GLOBALS['strAllowedBannerTypes']               = '許容バナータイプ';
$GLOBALS['strTypeSqlAllow']                     = 'SQLローカルバナー';
$GLOBALS['strTypeWebAllow']                     = 'サイト内ローカルバナー';
$GLOBALS['strTypeUrlAllow']                     = '外部バナー';
$GLOBALS['strTypeHtmlAllow']                    = 'HTMLバナー';
$GLOBALS['strTypeTxtAllow']                     = 'テキスト広告';
$GLOBALS['strTypeHtmlSettings']                 = 'HTMLバナーオプション';
$GLOBALS['strTypeHtmlAuto']                     = 'クリック追跡を行う場合、HTMLバナーに自動変更する';
$GLOBALS['strTypeHtmlPhp']						= 'HTMLバナー内のPHPコード実行する';

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
$GLOBALS['strAdserverTypeMax']      			= "リッチメディア - m3 Max Media Manager";
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
$GLOBALS['strConvertSWF']						= "<br />アップロードされたFlashファイルにはハードコデッドURLが含まれています。".MAX_PRODUCT_NAME." は、ハードコデッドURLを変換するまで、クリック数をカウントできません。Flashファイル内のハードコーデッドURL一覧は以下のとおりです。ハードコーデッドURLを変換するには、<b>変換する</b>をクリックしてください。変換しない場合、<b>キャンセル</b>をクリックしてください。<br /><br />以下のことに留意してください: <b>変換する</b>をクリックすると、アップロードしたFlashファイルは別なファイルに変換されます。<br />オリジナルファイルをバックアップしておいてください。オリジナルバナーのバージョンにかかわらず、変換後のFlashファイルを正しく表示するには、Flash4プレーヤー(以降)が必要です。<br /><br />";
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
$GLOBALS['strGreaterThan']                		= '超';
$GLOBALS['strLessThan']                   		= '未満';
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
$GLOBALS['strCity']								= "都市名(英字)";
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

$GLOBALS['strDeliveryCapping']					= "配信数制限";
$GLOBALS['strDeliveryCappingReset']       		= "カウンタリセット条件：";
$GLOBALS['strDeliveryCappingTotal']       		= "総配信数";
$GLOBALS['strDeliveryCappingSession']     		= "／セッション";

$GLOBALS['strCappingBanner'] 					= array();
$GLOBALS['strCappingBanner']['title'] 			= $GLOBALS['strDeliveryCapping'];
$GLOBALS['strCappingBanner']['limit'] 			= 'バナービュー上限数';

$GLOBALS['strCappingCampaign'] 					= array();
$GLOBALS['strCappingCampaign']['title'] 		= $GLOBALS['strDeliveryCapping'];
$GLOBALS['strCappingCampaign']['limit'] 		= 'キャンペーンビュー上限数';

$GLOBALS['strCappingZone'] 						= array();
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
$GLOBALS['strNoAffiliates']						= "Webサイトが定義されていません";
$GLOBALS['strConfirmDeleteAffiliate']			= "このWebサイトを本当に削除しますか?";
$GLOBALS['strMakePublisherPublic']				= "このWebサイトが所有するゾーンを利用可能にする";
$GLOBALS['strAffiliateInvocation']      		= '呼出用コード';
$GLOBALS['strAdvertiserSetup']          		= '広告主のサインアップ';
$GLOBALS['strTotalAffiliates']          		= '総Webサイト数';
$GLOBALS['strInactiveAffiliatesHidden'] 		= "件の非アクティブなWebサイトを隠す";
$GLOBALS['strShowParentAffiliates']     		= "親のWebサイトを表示する";
$GLOBALS['strHideParentAffiliates']     		= "親のWebサイトを隠す";

// Website (properties)
$GLOBALS['strWebsite']							= "ウェブサイト";
$GLOBALS['strMnemonic']                     	= "ニーモニック";
$GLOBALS['strAllowAffiliateModifyInfo'] 		= "このユーザによるWebサイトの情報修正を許可する";
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
$GLOBALS['strTaxID']                        	= "TAX-ID";
$GLOBALS['strModeOfPayment']                	= "振込方法";
$GLOBALS['strPaymentChequeByPost']          	= "Cheque by post";
$GLOBALS['strCurrency']                     	= "Currency";
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
$GLOBALS['strTotalZones']                   	= '総ゾーン数';
$GLOBALS['strCostInfo']                     	= 'コスト情報';
$GLOBALS['strTechnologyCost']               	= 'テクノロジーコスト';
$GLOBALS['strInactiveZonesHidden']          	= "非アクティブなゾーンを隠す";
$GLOBALS['strWarnChangeZoneType']           	= 'ゾーンタイプをテキストもしくはメールに変更すると、各ゾーンの制限によって全てのバナーとキャンペーンのリンクが対象外になります。
                                                <ul>
                                                    <li>テキストゾーンは、テキスト広告しかリンクできない</li>
                                                    <li>メールゾーンは、一度に１つのアクティブバナーしか持てない</li>
                                                </ul>';
$GLOBALS['strWarnChangeZoneSize']           	= 'ゾーンサイズを変更すると、変更後のゾーンサイズに適合しないバナーのリンクが除外され、新しいサイズに適合するバナーがリンクされます。';
$GLOBALS['strWarnChangeBannerSize']         	= 'バナーサイズを変更すると、変更後のバナーサイズに適合しないゾーンとのリンクを削除するとともに、バナーが属性強のゾーンにリンクされるようになっている場合、このバナーは自動的に属性強のゾーンに結合されます。';

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
$GLOBALS['strTrackerCodeSubject']          		= 'トラッカーコードの追加';
$GLOBALS['strAppendTrackerNotPossible']    		= 'そのトラッカーは追加できません。';
$GLOBALS['strStatusPending']            		= '保留中';
$GLOBALS['strStatusApproved']           		= '承認済';
$GLOBALS['strStatusDisapproved']        		= '承認済';
$GLOBALS['strStatusDuplicate']          		= '繰り返し';
$GLOBALS['strStatusOnHold']             		= '待機中';
$GLOBALS['strStatusIgnore']             		= '放置';
$GLOBALS['strConnectionType']           		= 'コネクションタイプ';
$GLOBALS['strConnTypeSale']             		= '購入';
$GLOBALS['strConnTypeLead']             		= '資料請求';
$GLOBALS['strConnTypeSignUp']           		= 'サインアップ';
$GLOBALS['strShortcutEditStatuses'] 			= 'ステータスの編集';
$GLOBALS['strShortcutShowStatuses'] 			= 'ステータスの表示';

// Statistics
$GLOBALS['strStats'] 							= "広告統計";
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
$GLOBALS['strBreakdownByDay']       			= "本日の統計";
$GLOBALS['strBreakdownByWeek']      			= "今週の統計";
$GLOBALS['strBreakdownByMonth']     			= "今月の統計";
$GLOBALS['strBreakdownByDow']       			= "曜日別統計";
$GLOBALS['strBreakdownByHour']      			= "時間別統計";
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
$GLOBALS['strErrorDBNoDataPlain']				= "データベースに関連する問題のため、".MAX_PRODUCT_NAME." はデータの検索と保存ができません。";
$GLOBALS['strErrorDBNoDataSerious']				= "データベースに関連する致命的な問題のため、".MAX_PRODUCT_NAME." データの検索ができません。";
$GLOBALS['strErrorDBCorrupt']					= "データベーステーブルがおそらく破損しており、修復する必要があります。破損したテーブルの詳しい修復方法は、<i>管理者ガイド</i>の<i>トラブルシューティング</i>を読んでください。";
$GLOBALS['strErrorDBContact']					= "このサーバのシステム管理者に連絡して、問題を報告してください。";
$GLOBALS['strErrorDBSubmitBug']					= "この問題が何度も繰り返し発生する場合、".MAX_PRODUCT_NAME." のバグであると思われます。以下の情報を".MAX_PRODUCT_NAME." の開発者に報告してください。その際、できるだけ明確にエラー直前の動作を記述してください。";
$GLOBALS['strMaintenanceNotActive']				= "24時間以内にメンテナンススクリプトが実行されていません。\\n正確な動作のために".MAX_PRODUCT_NAME." は1時間毎の動作が必要です。\\n\\nメンテナンススクリプトの設定方法については、\\n管理者ガイドを読んでください。";
$GLOBALS['strErrorBadUserType']         		= "システムは、あなたのユーザタイプを決定できませんでした！";
$GLOBALS['strErrorLinkingBanner']       		= "バナーとゾーンをリンク中にエラーが発生しました:";
$GLOBALS['strUnableToLinkBanner']       		= "リンクできません：";
$GLOBALS['strErrorEditingCampaign']     		= "キャンペーン更新中にエラーが発生しました：";
$GLOBALS['strUnableToChangeCampaign']   		= "以下のの理由により、この変更をを適用できませんでした：";
$GLOBALS['strDatesConflict']            		= "日間、競合中：";
$GLOBALS['strEmailNoDates']             		= 'メールゾーンキャンペーンには、必ず開始日と終了日が必要です。';
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
$GLOBALS['strUserInterfacePreferences']         = '画面表示プリファレンス';
$GLOBALS['strInvocationPreferences']            = '呼出プリファレンス';
$GLOBALS['strUserPreferences']                  = "ユーザ－プリファレンス";
$GLOBALS['strChangePassword']                   = "パスワードの変更";
$GLOBALS['strChangeEmail']                      = "メールアドレスの変更";
$GLOBALS['strCurrentPassword']                  = "旧パスワード";
$GLOBALS['strChooseNewPassword']                = "新パスワード";
$GLOBALS['strReenterNewPassword']               = "新パスワード（再入力）";
$GLOBALS['strNameLanguage']                     = "ユーザ情報＆言語";



// Global Settings
$GLOBALS['strGlobalSettings'] 					= "全体設定";
$GLOBALS['strGeneralSettings']					= "全般設定";
$GLOBALS['strMainSettings']						= "メイン設定";
$GLOBALS['strAdminSettings']					= "管理者設定";

// Product Updates
$GLOBALS['strProductUpdates']					= "プロダクト更新";
$GLOBALS['strCheckForUpdates']        			= "アップデート確認のため、クリックしてください。";
$GLOBALS['strViewPastUpdates']        			= "過去のアップデート状況を参照する。";

// Agency
$GLOBALS['strAgencyManagement']              	= "代理店管理";
$GLOBALS['strAgency']                      		= "代理店";
$GLOBALS['strAgencies']                   		= "代理店";
$GLOBALS['strAddAgency']                   		= "代理店の追加";
$GLOBALS['strAddAgency_Key']               		= "代理店の追加(<u>n</u>)";
$GLOBALS['strTotalAgencies']               		= "総代理店数";
$GLOBALS['strAgencyProperties']              	= "代理店の詳細";
$GLOBALS['strNoAgencies']                 		= "代理店が定義されていません";
$GLOBALS['strConfirmDeleteAgency']          	= "この代理店を本当に削除しますか？";
$GLOBALS['strHideInactiveAgencies']         	= "非アクティブな代理店を隠す";
$GLOBALS['strInactiveAgenciesHidden']     		= "件の非アクティブな代理店を隠しています";
$GLOBALS['strAllowAgencyEditConversions'] 		= "このユーザがコンバージョンを編集することを許可する";
$GLOBALS['strAllowMoreReports']           		= "'明細レポート'ボタンを許可する";

// Channels
$GLOBALS['strChannel']                    		= "チャネル";
$GLOBALS['strChannels']                   		= "チャネル";
$GLOBALS['strChannelOverview']              	= "チャネルの概要";
$GLOBALS['strChannelManagement']          		= "チャネル管理";
$GLOBALS['strAddNewChannel']              		= "チャネルの追加";
$GLOBALS['strAddNewChannel_Key']          		= "チャネルの追加(<u>n</u>)";
$GLOBALS['strNoChannels']                 		= "チャネルが定義されていません";
$GLOBALS['strEditChannelLimitations']     		= "チャネル制限の編集";
$GLOBALS['strChannelProperties']          		= "チャネルの詳細";
$GLOBALS['strChannelLimitations']         		= "配信オプション";
$GLOBALS['strConfirmDeleteChannel']       		= "このチャネルを本当に削除しますか？";
$GLOBALS['strModifychannel']              		= "チャネルの編集";

// Tracker Variables
$GLOBALS['strVariableName']             		= "トラッカー変数名";
$GLOBALS['strVariableDescription']     			= "記事";
$GLOBALS['strVariableDataType']         		= "データタイプ";
$GLOBALS['strVariablePurpose']       			= "用途";
$GLOBALS['strGeneric']               			= "汎用";
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
$GLOBALS['strYouHaveNoCampaigns']   			= '広告主にはキャンペーンがありません！';
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
$GLOBALS['strNotifyPageMessage']      			= "パスワードリセットと再ログインのためのメール送信しました。<br />
メールが届くまでしばらくお待ちください。<br />
万が一メールが届かない場合、念のため迷惑メールフォルダをチェックしてください。<br />
<a href=\"index.php\">ログインページはこちら</a>";

// Audit
$GLOBALS['strAdditionalItems']        			= 'アイテムの追加';
$GLOBALS['strFor']                    			= '配信元';
$GLOBALS['strHas']                    			= '所有者';
$GLOBALS['strAdZoneAsscociation']     			= '広告ゾーンとの関係';
$GLOBALS['strBinaryData']             			= 'バイナリーデータ';
$GLOBALS['strAuditTrailDisabled']     			= '追跡記録は管理者によって非表示に設定されています。追跡記録リストに表示可能なイベント情報はありません。';


// Widget - Audit
$GLOBALS['strAuditNoData']            			= "指定期間内のユーザ活動記録はありません。";
$GLOBALS['strAuditTrail']             			= "追跡記録";
$GLOBALS['strAuditTrailSetup']          		= "本日の追跡記録を設定する";
$GLOBALS['strAuditTrailGoTo']           		= "追跡記録ページに移動する";
$GLOBALS['strAuditTrailNotEnabled']     		= "<li>追跡記録によって、あらゆる広告配信情報（いつ、誰が、何を）を入手できます。また、特別な手法によって、" . MAX_PRODUCT_NAME ."のシステム変更状況も追跡できます。</li>
        <li>このメッセージが表示される場合、追跡記録は非アクティブです。</li>
        <li>より詳しい情報は、<a href='http://".OX_PRODUCT_DOCSURL."/settings/auditTrail' class='site-link' target='help' >Audit Trail documentation</a>を参照してください。</li>";

// Widget - Campaign
$GLOBALS['strCampaignGoTo']             		= 'キャンペーンページに移動する';
$GLOBALS['strCampaignSetUp']            		= '本日のキャンペーンを設定する';
$GLOBALS['strCampaignNoRecords']        		= '<li>キャンペーンによって、特定の広告条件に一致するバナーなどのグルーピングできます。</li>
        <li>１つのキャンペーンで多くのバナーをグルーピングすることによって時間が節約でき、配信先に応じて設定を個別に定義することはもはや不要となります。</li>
        <li>より詳しい情報は、<a class="site-link" target="help" href="http://'.OX_PRODUCT_DOCSURL.'/inventory/advertisersAndCampaigns/campaigns">Campaign documentation</a>を参照してください。</li>
';
$GLOBALS['strCampaignNoRecordsAdmin']   		= '<li>表示可能なキャンペーン活動記録はありません。</li>';

$GLOBALS['strCampaignNoDataTimeSpan']    		= '指定期間内に開始もしくは終了したキャンペーンはありません。';
$GLOBALS['strCampaignAuditNotActivated'] 		= '<li>指定期間内に開始もしくは終了したキャンペーンを参照するには、追跡記録をアクティブにしてください。</li>
        <li>このメッセージが表示される場合、追跡記録は非アクティブです。</li>
';
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

?>
