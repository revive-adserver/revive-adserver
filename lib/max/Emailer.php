<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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

require_once 'Mail.php';
require_once 'Mail/mime.php';

/**
 * Wrapper class for PEAR::Mail. Taken from Seagull, with permission.
 *
 * @author  Demian Turner <demian@phpkitchen.com>
 */
class MAX_Emailer
{
    var $headerTemplate = '';
    var $footerTemplate = '';
    var $html           = '';
    var $headers        = array();
    var $options        = array(
        'toEmail'       => '',
        'toRealName'    => '',
        'fromEmail'     => '',
        'fromRealName'  => '',
        'replyTo'       => '',
        'subject'       => '',
        'body'          => '',
        'template'      => '',
        'type'          => '',
        'username'      => '',
        'password'      => '',
        'siteUrl'       => '',
        'siteName'      => '',
        'crlf'          => ''
    );

    function MAX_Emailer($options = array())
    {
        $this->pageTitle = 'Emailer';
        $conf = $GLOBALS['_MAX']['CONF'];

        $this->headerTemplate
            = "<html><head><title>{$options['siteName']}</title></head></html><body>";
        $this->footerTemplate
            = "<table><tr><td>&nbsp;</td></tr></table></body>";
        foreach ($options as $k => $v) {
            $this->options[$k] = $v;
        }
        $this->options['crlf'] = ($options['crlf']) ? $options['crlf'] : "\n";
    }

    function prepare()
    {
        $includePath = $this->options['template'];
        if (is_readable($includePath)) {
            include_once $includePath;
        } else {
            MAX::debug('Could not open email template', $file, $line);
        }
        $this->html = $this->headerTemplate . $body . $this->footerTemplate;
        $this->headers['From'] = $this->options['fromEmail'];
        $this->headers['Subject'] = $this->options['subject'];
    }

    function send()
    {
        $mime = new Mail_mime($this->options['crlf']);
        $mime->setHTMLBody($this->html);
        $body = $mime->get();
        $hdrs = $mime->headers($this->headers);
        $mail = & Mail::factory('mail');
        return $mail->send($this->options['toEmail'], $hdrs, $body);
    }
}

?>
