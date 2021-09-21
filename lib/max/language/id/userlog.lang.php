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

// Set translation strings
$GLOBALS['strDeliveryEngine'] = "Mesin Penyampaian";
$GLOBALS['strMaintenance'] = "Pemeliharaan";
$GLOBALS['strAdministrator'] = "Administrator";

// Audit
$GLOBALS['strDeleted'] = "Hapus";
$GLOBALS['strInserted'] = "dimasukkan";
$GLOBALS['strUpdated'] = "diperbarui";
$GLOBALS['strDelete'] = "Hapus";
$GLOBALS['strHas'] = "telah";
$GLOBALS['strFilters'] = "Filter";
$GLOBALS['strAdvertiser'] = "Pemasang Iklan";
$GLOBALS['strPublisher'] = "Penerbit";
$GLOBALS['strCampaign'] = "Kampanye";
$GLOBALS['strZone'] = "Zona";
$GLOBALS['strType'] = "Jenis";
$GLOBALS['strAction'] = "Aksi";
$GLOBALS['strParameter'] = "Parameter";
$GLOBALS['strValue'] = "Nilai";
$GLOBALS['strReturnAuditTrail'] = "Kembali ke Audit Trail";
$GLOBALS['strAuditTrail'] = "Jejak audit";
$GLOBALS['strMaintenanceLog'] = "Log pemeliharaan";
$GLOBALS['strAuditResultsNotFound'] = "Tidak ada acara yang sesuai dengan kriteria yang dipilih";
$GLOBALS['strCollectedAllEvents'] = "Semua acara";
$GLOBALS['strClear'] = "Bersih";

if (!isset($GLOBALS['strUserlog'])) {
    $GLOBALS['strUserlog'] = [];
}
$GLOBALS['strUserlog'][phpAds_actionAdvertiserReportMailed] = "Laporkan pengiklan {id} kirim melalui email";
$GLOBALS['strUserlog'][phpAds_actionActiveCampaign] = "Campaign {id} diaktifkan";
$GLOBALS['strUserlog'][phpAds_actionAutoClean] = "Otomatis bersih dari database";
$GLOBALS['strUserlog'][phpAds_actionBatchStatistics] = "Statistik disusun";
$GLOBALS['strUserlog'][phpAds_actionDeactivationMailed] = "Pemberitahuan Deaktivasi untuk kampanye {id} dikirim melalui email";
$GLOBALS['strUserlog'][phpAds_actionDeactiveCampaign] = "Kampanye {id} dinonaktifkan";
$GLOBALS['strUserlog'][phpAds_actionPriorityCalculation] = "Prioritas dihitung ulang";
$GLOBALS['strUserlog'][phpAds_actionPublisherReportMailed] = "Laporan untuk situs web {id} dikirim melalui email";
$GLOBALS['strUserlog'][phpAds_actionWarningMailed] = "Peringatan Deaktivasi untuk kampanye {id} dikirim melalui email";
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Pembersihan database secara otomatis.";
