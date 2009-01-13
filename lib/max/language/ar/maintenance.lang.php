<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
$Id: translation.php 28570 2008-11-06 16:21:37Z chris.nutting $
*/



// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strDeliveryLimitations'] = "حدود التوصيل";
$GLOBALS['strChooseSection'] = "إختيار قسم";
$GLOBALS['strRecalculatePriority'] = "إعادة حساب الأهمية";
$GLOBALS['strCheckBannerCache'] = "فحص كاش البنرات";
$GLOBALS['strBannerCacheErrorsFound'] = "وجد الفحص بعض الأخطاء.لن تعمل البنرات إلا بعد إصلاحهم بشكل يدوي.";
$GLOBALS['strBannerCacheOK'] = "لم يجد الفحص أي أخطاء. الكاش الموجود محدّث حتى اللحظة.";
$GLOBALS['strBannerCacheDifferencesFound'] = "أثناء فحص الكاش للبنرات وجد النظام أنها ليست محدثة لأحدث نسخة. إضغط هنا للقيام بتحديث الكاش تلقائياً.";
$GLOBALS['strBannerCacheRebuildButton'] = "إعادة البناء";
$GLOBALS['strRebuildDeliveryCache'] = "إعادة بناء كاش البنرات في قاعدة البيانات";
$GLOBALS['strBannerCacheExplaination'] = "\nكاش قاعدة بيانات البنرات يستخد لزيادة سرعة تسليم البنرات<br />\nهذا الكاش يحتاج إلى تحديث :\n<ul>\n<li>عندما تقوم بترقية نسختك من OpendX</li>\n<li>عندماتقوم بنقل OpenX إلى خادم آخر</li>\n</ul>\n";
$GLOBALS['strAge'] = "العمر";
$GLOBALS['strDeliveryCacheSharedMem'] = "\n	حالياً يتم استخدام الذاكرة المشتركة لتخزين كاش التسليم.\n";
$GLOBALS['strDeliveryCacheDatabase'] = "\n	حالياً يتم استخدام قاعدة البيانات لتخزين كاش التسليم.\n";
$GLOBALS['strDeliveryCacheFiles'] = "\n	حالياً يتم تخزين كاش التسليم في ملفات متعددة على الخادم.\n";
$GLOBALS['strStorage'] = "تخزين";
$GLOBALS['strMoveToDirectory'] = "نقل الصورالمخزنة في قاعدة البيانات إلى مجلد";
$GLOBALS['strStorageExplaination'] = "\n	صور البنرات المستخدمة داخلياً مخزنة في قاعدة البيانات أو أحد المجلدات. إن كنت تستخدم تخزين الصور داخل\n	المجلدات سيقل الضغط على قواعد البيانات و سيؤدي ذلك إلى زيادة في سرعة عرض الإعلانات.\n";
$GLOBALS['strSearchingUpdates'] = "يتم البحث عن تحديثات، الرجاء الإنتظار...";
$GLOBALS['strAvailableUpdates'] = "التحديثات المتوافرة";
$GLOBALS['strDownloadZip'] = "تحميل (ملف مضغوط .zip)";
$GLOBALS['strDownloadGZip'] = "تحميل (ملف مضغوط .tar.gz)";
$GLOBALS['strUpdateAlert'] = "نسخة جديدة متوافرة من ". MAX_PRODUCT_NAME ."\n\n هل تريد الحصول على معلومات أكثر \n حول هذا التحديث؟";
$GLOBALS['strUpdateAlertSecurity'] = "نسخة جديدة متوافر من ". MAX_PRODUCT_NAME ."\n\n ينصح بشدة أن تتم الترقية \n بأقرب فرصة، هذه النسخة \n تحتوي على تحديث أمني أو أكثر.";
$GLOBALS['strUpdateServerDown'] = "لسبب غير معروف لم نتمكن من<br> إسترجاع أي معلومة حول التحديثات المتوقعة. نرجو الرجو في وقت لاحق.";
$GLOBALS['strNoNewVersionAvailable'] = "\n	 نسختكم من ". MAX_PRODUCT_NAME ." هي آخر نسخة متوافرة. لا يوجد أي تحديث حالياً.\n";
$GLOBALS['strNewVersionAvailable'] = "\n	<b>نسخة جديدة متوفرة من ". MAX_PRODUCT_NAME ."</b><br /> It is ننصح بالتحديث إلى هذه النسخة،\n	قد تحتوي النسخة على تحديثات لإصلاح بعض المشاكل الحالية، أو قد تكون بعض الإضافات الجديدة إضيفت لهذه النسخة، لمزيد من المعلومات\n	حول التحديث نرجو مراجعة المعلومات الموجودة بالملفات بالأسفل.\n";
$GLOBALS['strSecurityUpdate'] = "\n	<b>ينصح بشدة أن تقوم بتركيب التحديثات بأقرب فرصة ممكنة، هذه التحديثات تحتوي على عدد\n	من التحديثات الأمنية.</b> نسخة ". MAX_PRODUCT_NAME ." التي تستخدمها حالياً قد تحتوي على\n	بعض الثغرات الأمنية و قد تكون غير آمنة. للمزيد من المعلومات\n	حول عملية الترقية، الرجاء قراءة التعليمات الموجودة ضمن الملف بالأسفل.\n";
$GLOBALS['strNotAbleToCheck'] = "\n	<b>بسبب عدم تفعيل خاصية XML أو عدم وجودها على السيرفر ". MAX_PRODUCT_NAME ." لم يتمكن\nمن التحقق من وجود نسخ جديدة.</b>\n";
$GLOBALS['strForUpdatesLookOnWebsite'] = "\n	إن كنت تريد التحقق من وجود نسخ جديدة، الرجاء زيارة موقعنا.\n";
$GLOBALS['strClickToVisitWebsite'] = "إضغط هنا لزيارة موقعنا";
$GLOBALS['strCurrentlyUsing'] = "تستخدم الآن";
$GLOBALS['strRunningOn'] = "تعمل على";
$GLOBALS['strAndPlain'] = "و";
$GLOBALS['strEncodingConvert'] = "تحويل";
?>