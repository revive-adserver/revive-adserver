<?php
/*******************************************************************************
    $Id: user_agent.inc,v 1.15 2003/07/02 23:28:35 epsilon7 Exp $
    
    user_agent.inc: an array containing browser HTTP_USER_AGENT values for testing
    Copyright (C) 2001 Roger Raymond ~ epsilon7@users.sourceforge.net

    This library is free software; you can redistribute it and/or
    modify it under the terms of the GNU Lesser General Public
    License as published by the Free Software Foundation; either
    version 2.1 of the License, or (at your option) any later version.

    This library is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
    Lesser General Public License for more details.

    You should have received a copy of the GNU Lesser General Public
    License along with this library; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*******************************************************************************/
$user_agent = array(
'',
'===[ Gecko Based ]============================================================',
'Mozilla/5.0 Galeon/1.2.5 (X11; Linux i686; U;) Gecko/0',
'Mozilla/5.0 (Macintosh; U; PPC Mac OS X Mach-O; en-US; rv:1.0.1) Gecko/20021220 Chimera/0.6+',
'Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.3a) Gecko/20021207 Phoenix/0.5',
'mozilla/5.0 (macintosh; u; ppc mac os x mach-o; en-us; rv:1.0.1) gecko/20030306 camino/0.7',
'mozilla/5.0 (x11; u; linux i686; en-us; rv:1.4b) gecko/20030527 firebird/0.6',
'',
'===[ Microsoft Internet Explorer ]============================================',
'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)',
'Mozilla/4.0 (compatible; MSIE 5.22; Mac_PowerPC)',
'Mozilla/4.0 (compatible; MSIE 5.16, Mac_PowerPC)',
'Mozilla/4.0 (compatible; MSIE 4.01; Windows 98)',
'Mozilla/4.0 (compatible; MSIE 6.0b; Windows NT 5.0)',
'mozilla/4.0 (compatible; msie 6.0; windows nt 5.1; q312461)',
'mozilla/4.0 (compatible; msie 5.5; windows 98; win 9x 4.90)',
'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)',
'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; Q312461)',
'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; MyIE2; HotBar 4.1.8.0; .NET CLR 1.0.3705)',
'',
'===[ Netscape ]===============================================================',
'mozilla/4.51 [ru] (Win98; u)',
'Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en-US; rv:1.0.1) Gecko/20020823 Netscape/7.0',
'Mozilla/4.78 [en] (Win98; U)',
'Mozilla/4.5 [en] (Win95; U)',
'Mozilla/4.5 (Macintosh; U; PPC)',
'Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; m18) Gecko/20010131 Netscape6/6.01',
'Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; m18) Gecko/20010131 Netscape/7.00',
'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.0.1) Gecko/20020823 Netscape/7.0',
'',
'===[ Mozilla ]================================================================',
'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:0.9.6+)',
'mozilla/5.0 (x11; u; linux i686; en-us; rv:1.0.0) gecko/20020623 debian/1.0.0-0.woody.1',
'Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en-US; rv:1.2.1) Gecko/20021130',
'Mozilla/5.0 (Windows; U; Win98; en-US; rv:1.2.1) Gecko/20021130',
'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.2.1) Gecko/20021130',
'Mozilla/5.0 (X11; U; Linux i686; de-AT; rv:1.1) Gecko/20020826',
'Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en-US; rv:1.0.0) Gecko/20020529',
'Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:0.9+) Gecko/20010509',
'mozilla/5.0 (macintosh; u; darwin power macintosh; rv:0.9.9+) gecko/20020223',
'Mozilla/5.0 (X11; Linux i686; en-US; rv:1.0rc5; OBJR) gecko/20020223',
'',
'===[ Opera ]==================================================================',
'Opera/6.05 (Windows XP; U) [en]',
'Opera/5.11 (Windows 2000; U)  [en]',
'Mozilla/5.0 (Windows XP; U) Opera 6.05 [en]',
'Mozilla/3.0 (compatible; Opera/3.0; Windows 95/NT4)',
'Mozilla/4.0 (compatible; MSIE 5.0; Windows XP) Opera 6.05  [en]',
'Mozilla/4.0 (compatible; MSIE 5.0; Windows 2000) Opera 5.11  [en]',
'mozilla/4.0 (compatible; msie 5.0; linux 2.4.16 i686) opera 5.0  [en]',
'',
'===[ Konqueror ]==============================================================',
'Mozilla/5.0 (compatible; Konqueror/3.1-13; Linux)',
'Mozilla/5.0 (compatible; Konqueror/3.0.0-10; Linux)',
'mozilla/5.0 (compatible; konqueror/2.2.1; linux)',
'Mozilla/5.0 (compatible; Konqueror/3; Linux)',
'',
'===[ Safari ]=================================================================',
'Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en-us) AppleWebKit/48 (like Gecko) Safari/48',
'Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en-us) AppleWebKit/51 (like Gecko) Safari/51 ',
'',
'===[ Text Based ]=============================================================',
'Lynx/2.7 libwww-FM/2.14',
'Lynx/2.8.4rel.1 libwww-FM/2.14 SSL-MM/1.4.1 OpenSSL/0.9.6g',
'Links (2.1pre3; Linux 2.4.20 i686; 80x24)',
'',
'===[ Amiga ]=============================+++++================================',
'Mozilla/5.0 (AmigaOS MorphOS; en-US; rv 1.0) Gecko/20020616',
'Mozilla/3.01 (compatible; AmigaVoyager/2.95; AmigaOS/MC680x0)',
'Mozilla/6.0; (Spoofed by Amiga-AWeb/3.4APL)',
'IBrowse/1.12 (AmigaOS 3.1)',
'IBrowse/2.2 (AmigaOS 3.1)',
'IBrowse/2.3 (AmigaOS 3.5)',
'IBrowse/2.3 (AmigaOS 3.9)',
'IBrowse/2.2 (AmigaOS V45)',
'AmigaVoyager/3.2 (AmigaOS/MC680x0)',
'AmigaVoyager/3.3.122 (AmigaOS/MC680x0)',
'AmigaVoyager/3.3.122 (AmigaOS/PPC)',
'Amiga-AWeb/3.3',
'Amiga-AWeb/3.4',
'Amiga-AWeb/3.4APL',
'',
'===[ Other ]==================================================================',
'Mozilla/4.0 (compatible; MSIE 5.5; Mac_PowerPC; OmniWeb/4.0)',
'NCSA Mosaic/2.6b1 (X11;UNIX_SV 4.2MP R4000) libwww/2.12 modified',
'amaya/V4.3.2 libwww/5.3.1',
'mozilla/4.61 [en] (x11; u; ) - browsex (2.0.0 windows)'
);
?>