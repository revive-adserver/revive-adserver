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
$GLOBALS['phpAds_hlp_dbhost'] = "
        �]�w".$phpAds_dbmsname."��Ʈw���D��W.
		";
		
$GLOBALS['phpAds_hlp_dbuser'] = "
        ".$phpAds_productname."�ݭn�z���ѥΤ�W�Ӧs��".$phpAds_dbmsname."��Ʈw��A��.
		";
		
$GLOBALS['phpAds_hlp_dbpassword'] = "
        ".$phpAds_productname."�ݭn�z���ѱK�X�Ӧs��".$phpAds_dbmsname."��Ʈw��A��.
		";
		
$GLOBALS['phpAds_hlp_dbname'] = "
        ".$phpAds_productname."�ݭn�z���Ѹ�Ʈw�W�Ӧs��".$phpAds_dbmsname."��Ʈw��A��.
		";
		
$GLOBALS['phpAds_hlp_persistent_connections'] = "
        �ä[�s�����ϥΥi�H�ܤj������".$phpAds_productname."���t�שM��p��A�����t��C 
		��O���@�ӯ��I�A�p�G�O�@�Ӥj�X�ݶq�����I�A�����A�����t��|��ϥδ��q�s���n�W�[���֡A�|�ܧֹF��ܭ����t��C
		�ϥδ��q�s���٬O�ä[�s���n�ھڧA�����I���X�ݶq�M�w����ӨM�w�C
		�p�G".$phpAds_productname."�ϥΤF�Ӧh���귽�A�z3�ӥ�d�ݳo�ӳ]�w�C
		";
		
$GLOBALS['phpAds_hlp_compatibility_mode'] = "
        �p�G�A�b��X".$phpAds_productname."�P��L�ĤT�貣�~���ɭԦ����D�A���ﶵ�i��0�U�A���}��Ʈw���ݮe�Ҧ��C
		�p�G�A���b�ϥΥ��a�եμҦ��åB��Ʈw���ݮe�Ҧ��w�g���}�A 
		".$phpAds_productname."3�ӫO���Ʈw�s�����A�M".$phpAds_productname."�B��e�@�P�C 
		���ﶵ���@�ǺC�]�ܤp�^�ҥH�w�]���A�O����C
		";
		
$GLOBALS['phpAds_hlp_table_prefix'] = "
        �p�G".$phpAds_productname."�ϥΪ���Ʈw�O�P��L�h�ӳn��@��,����Ʈw�[�@�ӫe��O�@�Ӥ��n����ܡC
		�p�G�A�b�P�@�Ӹ�Ʈw���ϥ�".$phpAds_productname."���h�Ӧw�˪����A�A�n�O�ҳo�ӫe��b�Ҧ����w�˪����̬O�ߤ@���C
		";
		
$GLOBALS['phpAds_hlp_tabletype'] = "
        ".$phpAds_dbmsname."���h�ؼƾڪ������C�C�ظ�Ʈw�����W�����S�x�ӥB�������ܤj����".$phpAds_productname."���B��t�סC
		MyISAM�O�w�]���ƾڪ������åB�i�H�b".$phpAds_dbmsname."���Ҧ��w�˪����W�ϥΡC��L�������ƾڪ�i�ण��b�A����A���W�ϥΡC
		";
		
$GLOBALS['phpAds_hlp_url_prefix'] = "
        ".$phpAds_productname."�ݭn���D���ۤv�b���A������m�~�ॿ�`�u�@�C�A��������".$phpAds_productname."�w�˥ؿ�URL�a�}�A 
        �Ҧp�R  http://www.your-url.com/".$phpAds_productname.".
		";
		
$GLOBALS['phpAds_hlp_my_header'] =
$GLOBALS['phpAds_hlp_my_footer'] = "
        ��J��������M����󪺸�|(e.g.: /home/login/www/header.htm)�i�H�b�޲z��ɭ����C�ӭ����W�K�[���M�����C 
        �A�i�H��奻�Ϊ�html���(�p�G�A�ϥΦb��󤤨ϥ�html�N�X�A�Ф��n�ϥζH &lt;body> or &lt;html>���аO)�C
		";
		
$GLOBALS['phpAds_hlp_content_gzip_compression'] = "
		�ҥ�GZIP���e#�Y�A�|���j����p�C���޲z�����}�ɵo�e���s��ƾڡC 
		PHP�������_4.0.5�æw�ˤFGZIP���[�Ҷ�~��ҥΦ��\��C
		";
		
$GLOBALS['phpAds_hlp_language'] = "
        ���".$phpAds_productname."�ϥΪ��w�]�y���C�o�ӻy���N�Q�Χ@�޲z��M�Ȥ�ɭ����w�]�y���C 
        �Ъ`�N�R�A�i�H���q�޲z��ɭ����C�@�ӫȤ�]�w���P���y���M�O�_���\�Ȥ�ק�L�̦ۤv���y���]�w�C
		";
		
$GLOBALS['phpAds_hlp_name'] = "
        �z��w���{�Ǫ��W�r. ���r�Ŧ�N�b�޲z��M�Ȥ�ɭ����Ҧ������W���. 
		�p�G����(�w�]),�N��ܤ@��".$phpAds_productname."���ϼ�.
		";
		
$GLOBALS['phpAds_hlp_company_name'] = "
        �o�ӦW�r�O".$phpAds_productname."�o�e�q�l���l�󪺮ɭԨϥΪ��C
		";
		
$GLOBALS['phpAds_hlp_override_gd_imageformat'] = "
        ".$phpAds_productname."�q�`�n�˴�GD�w�O�_�w�˩M�����عϤ�榡. ��O�˴�i�ण�ǽT�Ϊ̿�~,
		�@�Ǫ�����PHP�����\�˴���Ϥ�榡. �p�G".$phpAds_productname."�۰��˴�Ϥ�榡����,
		�A�i�H��w���T���Ϥ�榡. �i�઺��:none, png, jpeg, gif.
		";
		
$GLOBALS['phpAds_hlp_p3p_policies'] = "
        �p�G�A�Q�ҥ�".$phpAds_productname."'P3P��p����',�A�������}���ﶵ. 
		";
		
$GLOBALS['phpAds_hlp_p3p_compact_policy'] = "
        �Y�������O�Mcookie�@�_�o�e��. �w�]���]�w�O:'CUR ADM OUR NOR STA NID', 
		���\Internet Explorer 6 ����".$phpAds_productname."�ϥΪ�cookie.
		�z�i�H��惡�]�w�H�ŦX�z�ۤv����p�n��.
		";
		
$GLOBALS['phpAds_hlp_p3p_policy_location'] = "
        �p�G�z�Q�ϥΧ�����p����,�z�i�H��w��������m.
		";
		
$GLOBALS['phpAds_hlp_compact_stats'] = "
        �ǲΤW,".$phpAds_productname."�ϥΤF�۷�s�x���O��,�D�`�ԲӦ�O���Ʈw��A���n�D�ܰ�.
		���@�ӳX�ݪ̫ܦh�����I,�o�O�@�ӫܤj�����D. ���F�ѨM�o�Ӱ��D,".$phpAds_productname."�]���@�طs���έp�覡:
		²��έp�Ҧ�,���Ʈw��A���n�D�p�@��,��O���O�ܸԲ�.²���έp�Ҧ��έp�C�p�ɪ��X�ݼƩM�I;��,
		�p�G�z�ݭn��ԲӪ��H��,�z�ݭn��²��έp�Ҧ�.
		";
		
$GLOBALS['phpAds_hlp_log_adviews'] = "
        �q�`�Ҧ����X�ݼƳ��Q�O��,�p�G�z���Q�����X�ݼƪ��ƾ�,�i�H����ﶵ.
		";
		
$GLOBALS['phpAds_hlp_block_adviews'] = "
		�p�G�@�ӳX�ݪ̨�s����,�C��".$phpAds_productname."���|�O��X�ݼ�. 
		���ﶵ�ΨӫO�Ҧb�z��w���ɶ����j����@�Ӽs�i���h���X�ݶȰO��@���X�ݼ�.
		�p:�p�G�z�]�w���Ȭ�300��,".$phpAds_productname."�ȷ�5���d����s�i�惡�X�ݪ̨S����ܹL�~�O��ӳX�ݼ�.
		���ﶵ�ȷ�<i>�ϥΫH���O�O��X�ݼ�</i>�ҥΩM�s���cookies���ɭԤ~�_�@��.
		";
		
$GLOBALS['phpAds_hlp_log_adclicks'] = "
        �q�`�Ҧ����I;�Ƴ��Q�O��,�p�G�z���Q�����I;�ƪ��ƾ�,�i�H����ﶵ.
		";
		
$GLOBALS['phpAds_hlp_block_adclicks'] = "
		�p�G�@�ӳX�ݪ��I;�@�Ӽs�i�F�h��,�C��".$phpAds_productname."���|�O���I;��.
		���ﶵ�ΨӫO�Ҧb�z��w���ɶ����j����@�Ӽs�i���h���I;�ȰO��@���I;��. 
		�p:�p�G�z�]�w���Ȭ�300��,".$phpAds_productname."�ȷ�5���d����X�ݪ̨S���I;�L���s�i�~�O����I;��.
		���ﶵ�ȷ��s���cookies���ɭԤ~�_�@��.
		";
		
$GLOBALS['phpAds_hlp_reverse_lookup'] = "
        ".$phpAds_productname."�w�]�N�O��C�ӳX�ݪ̪�IP�a�}. �p�G�z�Q��".$phpAds_productname.
		"�O���W,�z�ݭn���}���ﶵ.�ϦV��W�d�ߥi��ݭn�@�w���ɶ�;�i���C�Ҧ��B�J���t��.
		";
		
$GLOBALS['phpAds_hlp_proxy_lookup'] = "
		�@�ǥΤ�ϥΥN�z��A���ӳX�ݤ��p��.�b�����p�U,".$phpAds_productname."�N�O��N�z��A����IP�a�}�Ϊ̥D��W,
		�Ӥ��O�Τ᪺. �p�G�z�ҥΦ��ﶵ,".$phpAds_productname."�N�d��q�L�N�z��A���W��Τ᪺�u��IP�a�}�M�D��W. 
		�p�G������Τ᪺�u��a�},�N�ϥΥN�z��A�����a�}. ���ﶵ�w�]�èS���ҥ�,�]���i���C�t��.
		";
		
$GLOBALS['phpAds_hlp_ignore_hosts'] = "
        �p�G�z���Q�O��S�w�p���X�ݼƩM�I;��,�z�i�H��L�̥[�J���C��. �p�G�z�ҥΤF�ϦV��W�d��,
		�z�i�H�K�[��W�MIP�a�},�_�h�z�u��ϥ�IP�a�}. �z�]�i�H�ϥγq�t��(�]�N�O'*.altavista.com'�Ϊ�'192.168.*').
		";
		
$GLOBALS['phpAds_hlp_begin_of_week'] = "
        ��ܦh�H�ӻ��P�d@�O�@�P���}�l,��O�z�i�H�]�w�P�dѧ@���@�P���}�l.
		";
		
$GLOBALS['phpAds_hlp_percentage_decimals'] = "
        ��w��ܲέp�ƾڪ��������ƾں�T��p���I����X��.
		";
		
$GLOBALS['phpAds_hlp_warn_admin'] = "
        �p�G�@�Ӷ��إu�ѤU�������X�ݼƩM�I;�Ʀs�q,".$phpAds_productname." ���o�q�l�l��Ӵ���z.���ﶵ�w�]�O���}��.
		";
		
$GLOBALS['phpAds_hlp_warn_client'] = "
        �p�G�@�ӫȤ᪺�Y�Ӷ��إu�ѤU�������X�ݼƩM�I;�Ʀs�q".$phpAds_productname."���o�q�l�l��Ӵ���Ȥ�.���ﶵ�w�]�O���}��.
		";
		
$GLOBALS['phpAds_hlp_qmail_patch'] = "
		qmail���@�Ǫ����]�����@��bug���v�T,�y��".$phpAds_productname."�o�e���q�l�l��b�l�󪺤��e�̭���ܶl���Y.
		�p�G�z�ҥΦ��ﶵ,".$phpAds_productname."�N�ϥ�qmail�ݮe�榡�ӵo�e�q�l�l��.
		";
		
$GLOBALS['phpAds_hlp_warn_limit'] = "
        ".$phpAds_productname."�}�l�o�eĵ�i�q�l�l�󪺻֭�,�w�]�O100.
		";
		
$GLOBALS['phpAds_hlp_allow_invocation_plain'] = 
$GLOBALS['phpAds_hlp_allow_invocation_js'] = 
$GLOBALS['phpAds_hlp_allow_invocation_frame'] = 
$GLOBALS['phpAds_hlp_allow_invocation_xmlrpc'] = 
$GLOBALS['phpAds_hlp_allow_invocation_local'] = 
$GLOBALS['phpAds_hlp_allow_invocation_interstitial'] = 
$GLOBALS['phpAds_hlp_allow_invocation_popup'] = "
		�o�ǳ]�w�B��z����\�ϥΪ��եΤ覡.�p�G�Y�ӽեΤ覡����,�N���A�X�{�b�եΥN�X/�s�i�N�X���ͭ���.
		���n:�եΤ覡�p�G���Ϋ�N�~��u�@,�N�O���즳���N�X�٬O�i�H�~��ϥ�,
		�u�O�b���ͽեΥN�X���ɭԤ���ϥ�.
		";
		
$GLOBALS['phpAds_hlp_con_key'] = "
        ".$phpAds_productname."�]�t�@�ӨϥΪ������覡���j�j���s�i��ܨt��.
		��h�ԲӪ��H���аѦҥΤ��U. �q�L���ﶵ,�z�i�H�ҥα������r.�o�ӿﶵ�w�]�O���}��.
		";
		
$GLOBALS['phpAds_hlp_mult_key'] = "
        �p�G�z���b�ϥΪ������覡����ܼs�i,�z�i�H���C�Ӽs�i��w�@�өΦh������r.
		���qz�Q��w�h������r,�����ҥΦ��ﶵ.�o�ӿﶵ�w�]�O���}��.
		";
		
$GLOBALS['phpAds_hlp_acl'] = "
        �p�G�z�S���ϥεo�e����ﶵ,�z�i�H����ﶵ,�o�N��".$phpAds_productname."�t�׵y�L�[��.
		";
		
$GLOBALS['phpAds_hlp_default_banner_url'] = 
$GLOBALS['phpAds_hlp_default_banner_target'] = "
        �p�G".$phpAds_productname."����s�����Ʈw��A��,�Ϊ̤�����ŦX���s�i,�p��Ʈw�Y��Ϊ̳Q�R��,
		�N����ܥ��F��.�@�ǥΤ�i��Q�b�o�ر��p�U����ܤ@�ӫ�w���w�]�s�i.����w���w�]�s�i�N���Q�O��,
		�p�G��Ʈw�����¦��ҥΪ��s�i,����w���w�]�s�i�]�N���Q�ϥ�.�o�ӿﶵ�w�]�O���.
		";
		
$GLOBALS['phpAds_hlp_zone_cache'] = "
        �p�G�z���b�ϥΪ���,���]�w���\ ".$phpAds_productname."�b�w�s�Ϥ��s��s�i�H��,�w�s�ϱN�b�H��ϥ�.
		�o�N��".$phpAds_productname."�t�׵y�L�֤@��, �]�����A�ݭn����M�s�i���H���M��ܥ��T���s�i, 
        ".$phpAds_productname." �Ȼݭn�[��w�s��,�o�ӿﶵ�w�]�O���}��.
		";
		
$GLOBALS['phpAds_hlp_zone_cache_limit'] = "
        �p�G�z���b�ϥνw�s������,�w�s�Ϥ����H���i��L��,�ҥH".$phpAds_productname."�����ݭn���ؽw�s��, 
		���ﶵ�i�H��A��w�@�ӽw�s�Ϫ��̪�ͩR�g��,�ӨM�w����ɭԽw�s��3�ӭ��s�[��. �p:�p�G�z�]�w������600,
		�w�s�ϹةR�p�G�W�L10����(600��),�w�s�ϱN�Q����.
		";
		
$GLOBALS['phpAds_hlp_type_sql_allow'] = 
$GLOBALS['phpAds_hlp_type_web_allow'] = 
$GLOBALS['phpAds_hlp_type_url_allow'] = 
$GLOBALS['phpAds_hlp_type_html_allow'] = 
$GLOBALS['phpAds_hlp_type_txt_allow'] = "
        ".$phpAds_productname."�i�H�ϥΤ��P�������s�i,�Τ��P���覡�s��s�i.�Y��ӿﶵ�ΨӦb���a�s��s�i.
		�z�i�H�ϥκ޲z��ɭ��ӤW�Ǽs�i,".$phpAds_productname."�N�bSQL��Ʈw�Ϊ̺��A���W�s��s�i.
		�A�]�i�H��s�i�s��b�~�����A��,�Ϊ̨ϥ�HTML��²���r�ӥͦ��s�i.
		";
		
$GLOBALS['phpAds_hlp_type_web_mode'] = "
        �p�G�z�Q�ϥΦs��b���A���W���s�i,�z�ݭn�t�m���]�w.�p�G�z�Q�b���a�ؿ�s��s�i,�⦹�ﶵ�]�w��<i>���a�ؿ�</i>.
		�p�G�z�Q��s�i�s���~��FTP��A���W,�⦹�ﶵ�]�w��<i>�~��FTP��A��</i>.
		�b�@�ǯS�w�����A���W,�z�i��ƦܷQ�b���a�����A���W�ϥ�FTP�ﶵ.
		";
		
$GLOBALS['phpAds_hlp_type_web_dir'] = "
        ��w�@�ӥؿ�,".$phpAds_productname."�ݭn��W�Ǫ��s�i�ƻs�즹�ؿ�.���ؿ�PHP�������g�v��,
		�N�O���z�i��ݭn�ק惡�ؿ�UNIX�v��(chmod).��w���ؿ�b���A����'���ɮڥؿ�'�U,
		���A�������i�H�����o�G�����.���n��w���*��׽u(/).�z�Ȧb��s��覡�]�w��<i>���a�ؿ�</i>�ɤ~�ݭn�t�m���ﶵ.
		";
		
$GLOBALS['phpAds_hlp_type_web_ftp_host'] = "
		�p�G�z�]�w�s��覡��<i>�~��FTP��A��</i>,�z�ݭn��wFTP��A����IP�a�}�Ϊ̰�W,�H��".$phpAds_productname."
		����W�Ǫ��s�i�ƻs�즹��A���W.
		";
      
$GLOBALS['phpAds_hlp_type_web_ftp_path'] = "
		�p�G�z�]�w�s��覡��<i>�~��FTP��A��</i>,�z�ݭn��w�~��FTP��A�����ؿ�,�H��".$phpAds_productname."
		����W�Ǫ��s�i�ƻs�즹�ؿ�.
		";
      
$GLOBALS['phpAds_hlp_type_web_ftp_user'] = "
		�p�G�z�]�w�s��覡��<i>�~��FTP��A��</i>,�z�ݭn��w�~��FTP��A�����Τ�W,�H��".$phpAds_productname."
		���s����~��FTP��A��.
		";
      
$GLOBALS['phpAds_hlp_type_web_ftp_password'] = "
		�p�G�z�]�w�s��覡��<i>�~��FTP��A��</i>,�z�ݭn��w�~��FTP��A�����K�X,�H��".$phpAds_productname."
		���s����~��FTP��A��.
		";
      
$GLOBALS['phpAds_hlp_type_web_url'] = "
        �p�G�z�b���A���W�s��s�i,".$phpAds_productname."�ݭn���D�U���z��w���ؿ�}���X�ݦa�}.
		���n��w���*��׽u(/).
		";
		
$GLOBALS['phpAds_hlp_type_html_auto'] = "
        �p�G���}���ﶵ,".$phpAds_productname."�N�۰ʭק�HTML�s�i�N�X�H�O���I;��.
		��O�Y�Ϧ��ﶵ���},���M�i�H��C�Ӽs�i���Φ��\��. 
		";
		
$GLOBALS['phpAds_hlp_type_html_php'] = "
        �i�H��".$phpAds_productname."�bHTML�s�i�N�X�����PHP�N�X,���ﶵ�w�]�O���.
		";
		
$GLOBALS['phpAds_hlp_admin'] = "
        �п�J�޲z��Τ�W. �q�L���Τ�W�z�i�H�n���޲z��ɭ�.
		";
		
$GLOBALS['phpAds_hlp_admin_pw'] =
$GLOBALS['phpAds_hlp_admin_pw2'] = "
        �п�J�޲z��K�X. �q�L���Τ�W�z�i�H�n���޲z��ɭ�.�z�ݭn��J�⦸�H�K��J��~.
		";
		
$GLOBALS['phpAds_hlp_pwold'] = 
$GLOBALS['phpAds_hlp_pw'] = 
$GLOBALS['phpAds_hlp_pw2'] = "
        �ק��±K�X,�z�ݭn�b�W����J�±K�X. �A�]�ݭn��J�s�K�X�⦸,�H�קK��J��~.
		";
		
$GLOBALS['phpAds_hlp_admin_fullname'] = "
        ��w�޲z����W,�Ψӳq�L�q�l�l��o�e�έp���.
		";
		
$GLOBALS['phpAds_hlp_admin_email'] = "
        �޲z��q�l�l��a�},�Ψӧ@���o�H�H�a�}�q�L�q�l�l��o�e�έp���.
		";
		
$GLOBALS['phpAds_hlp_admin_email_headers'] = "
        �z�i�H�ק�".$phpAds_productname."�o�e�q�l�l�󪺶l���Y.
		";
		
$GLOBALS['phpAds_hlp_admin_novice'] = "
        �p�G�z�Q�b�R���Ȥ�,����,�s�i,�o�G�̩M���쪺�ɭԱo��@��ĵ�i�H��,�]�w���ﶵ��true.
		";
		
$GLOBALS['phpAds_hlp_client_welcome'] = "
		�p�G���}���ﶵ,�C�ӫȤ�n��᪺�����N��ܤ@���w��H��.�z�i�H�q�L�ק�admin/templates�ؿ�U��
		welcome.html���ӭק惡�H��.�z�i��Q�n�]�A���H���p:�z���q���W�r,�pô�H��,�z���q���ϼ�,�@�Ӽs�i��歶���챵��.
		";

$GLOBALS['phpAds_hlp_client_welcome_msg'] = "
		�N�=s��welcome.html���,�z�i�H�b�o�̫�w�@�Ǥ�r.�p�G�z�b�o�̿�J�F��r,welcome.html���N�Q����.
		�o�̤��\��Jhtml�аO.
		";
		
$GLOBALS['phpAds_hlp_updates_frequency'] = "
		�p�G�z�Q�d��".$phpAds_productname."������,�z�i�H�ҥΦ��ﶵ.�i�H��w".$phpAds_productname."�s��ɯŦ�A��
		�i��ɯŪ��ɶ����j.�p�G���s����,�N�u�X�]�t�����ɯūH�����@�ӹ�ܮ� 
		";
		
$GLOBALS['phpAds_hlp_userlog_email'] = "
		�p�G�z�Q�O�s".$phpAds_productname."�o�e���Ҧ��q�l�l��H�����@�Ӱƥ�,�z�i�H�ҥΦ��ﶵ.�q�l�l��H���N�O�s�b�Τ�O���.
		";
		
$GLOBALS['phpAds_hlp_userlog_priority'] = "
		���F�O���u���v�p�⪺���T,�z�i�H���C�Ӥp�ɪ��p��O�s�@����. �o�ӳ��]�A�w����p�M�C�Ӽs�i�0t���u���v.
		�o�ӫH���b�z�Q����@��bug��i���ɭԤ���. �o�ӳ��s��b�Τ�O���.
		";
		
$GLOBALS['phpAds_hlp_default_banner_weight'] = "
		�p�G�z�Q�ϥΤ@�ӹw�]�󰪪��s�i�v��,�z�i�H�b�o�̫�w�z�q檺�v��.�o�ӿﶵ�w�]�]�w��1.
		";
		
$GLOBALS['phpAds_hlp_default_campaign_weight'] = "
		�p�G�z�Q�ϥΤ@�ӹw�]�󰪪������v��,�z�i�H�b�o�̫�w�z�q檺�v��.�o�ӿﶵ�w�]�]�w��1.
		";
		
$GLOBALS['phpAds_hlp_gui_show_campaign_info'] = "
		�p�G���}���ﶵ,�C�Ӷ��ت��B�~���H���N�b<i>�����`��</i>�����W���. �B�~�H���]�A�X�ݼƪ��s�q,�I;�ƪ��s�q,
		�ҥΤ��,���Ĥ�iM�v�ȳ]�w.
		";
		
$GLOBALS['phpAds_hlp_gui_show_banner_info'] = "
		�p�G���}���ﶵ,�C�Ӽs�i���B�~���H���N�b<i>�s�i�`��</i>�����W���. �B�~�H���]�A�ؼ�URL,����r,�ؤo�M�v��.
		";
		
$GLOBALS['phpAds_hlp_gui_show_campaign_preview'] = "
		�p�G���}���ﶵ,<i>�s�i�`��</i>�����N��ܩҦ��s�i���w��.�p�G����ﶵ,�b<i>�s�i�`��</i>�����I;
		�C�Ӽs�i�᭱���T���ϼ�,�]�i�H��ܨC�Ӽs�i���w��.
		";
		
$GLOBALS['phpAds_hlp_gui_show_banner_html'] = "
		�N��ܹ�ڪ�HTML�s�i,�Ӥ��OHTML�N�X.���ﶵ�w�]�O���,�]��HTML�s�i�i��P�Τ᪺�ɭ��Ĭ�.
		�p�G����ﶵ,�I;HTML�N�X�᭱��<i>��ܼs�i</i>��s,�]�i�H��ܹ�ڪ�HTML�s�i.
		";
		
$GLOBALS['phpAds_hlp_gui_show_banner_preview'] = "
		�p�G���}���ﶵ,�b<i>�s�i�ݩ�</i>,<i>�o�e�ﶵ</i>�M<i>�s���s�i</i>����,�N��ܼs�i���w��.
		�p�G����ﶵ,�I;����������<i>��ܼs�i</i>��s,�]�i�H�ݨ�s�i���w��.
		";
		
$GLOBALS['phpAds_hlp_gui_hide_inactive'] = "
		�p�G�ҥΦ��ﶵ,�Ҧ����Ϊ��s�i,����,�Ȥ�N�b<i>�Ȥ�&����</i>�M<i>�����`��</i>�����Q����. 
		��ҥΦ��ﶵ,�z���¥i�H�I;����������<i>��ܩҦ�</i>��s�Ӭd�����ê����.
		";
		
?>