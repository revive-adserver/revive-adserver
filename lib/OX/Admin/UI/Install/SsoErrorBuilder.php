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
$Id$
*/

/**
 * @package OX_Admin_UI
 * @subpackage Install
 * @author Bernard Lange <bernard@openx.org> 
 */
class OX_Admin_UI_Install_SsoErrorBuilder
{
    private $publisherSupportEmail;
    
    /**
     * @param string $publisherSupportEmail email address that should be used in 
     * error messages pointing to publisher support.
     */
    public function __construct($publisherSupportEmail)
    {
        $this->publisherSupportEmail = $publisherSupportEmail;
    }
    
    
    /**
     * Checks for the market client exception code and builds more user friendly
     * error message.
     *
     * @param Exception $exc
     * @return string
     */
    public function getErrorMessage($exc)
    {
        $errorCode = $exc->getCode();
        $message  = $exc->getMessage();
        
        $aMessages = $this->getMessageTemplates();
        
        $publisherSupportEmail = $this->publisherSupportEmail;

        if (isset($aMessages[$errorCode])) {
            $message = $aMessages[$errorCode];
            $aXmlRpcPearErrors = $this->getXmlRpcPearErrorsCodes();
            if ($errorCode == 0) {
                $message = vsprintf($message, array($message, $publisherSupportEmail));
            }
            elseif (in_array($errorCode, $aXmlRpcPearErrors)) {
                $message = vsprintf($message, array($errorCode, $message, $publisherSupportEmail));
            }
        }
        else {
            $message = vsprintf($aMessages['unknown'],
                array($errorCode, $publisherSupportEmail));
        }

        return $message;
    }

    
    protected function getMessageTemplates()
    {
        $aMessages = array(
            '701' => '<div>Invalid user name or password.</div>
                      <ul>
                        <li>Please check that the OpenX User name and password are correct.</li>
                        <li>If you have recently signed up for a new OpenX.org account, 
                        make sure you have gone into your email and activated your OpenX.org account.</li>
                      </ul>',
            '702' => '<div>Invalid user name or password.</div>
                      <ul>
                        <li>Please check that the OpenX User name and password are correct.</li>
                        <li>If you have recently signed up for a new OpenX.org account, 
                        make sure you have gone into your email and activated your OpenX.org account.</li>
                      </ul>',
        
            '703' => 'There is already an OpenX.org account registered with the given email address. 
                      To create a new OpenX.org account please use a different email address.',
        
            '802' => 'Enter the word as it is shown in the image',
        
            '901' => 'This Ad Server is already associated with OpenX Market through a different OpenX.org account (Code 901).
                     <br>Please contact <a href="mailto:%s">OpenX publisher support</a> if you need further assistance.',
        
            '902' => 'This OpenX.org account is already associated with OpenX Market through a different OpenX Ad Server (Code 902). 
                      <br>Please contact <a href="mailto:%s">OpenX publisher support</a> if you need further assistance.',
        
            '912' => 'An error occured while creating your OpenX.org account (Code 912). 
                      <br>Please try again in couple of minutes. If the problem persists, 
                      please contact <a href="mailto:%s">OpenX publisher support</a> for assistance.',
        
            '0'   =>  'A generic error occurred while associating your OpenX.org account (Code 0: %s)
                      <br>The problem may be caused by an improper configuration of your OpenX Ad Server
                      or your web server or by the lack of a required PHP extension.
                      <br>If the problem persists, please contact 
                      <a href="mailto:%s">OpenX publisher support</a> for assistance.',
        
            'unknown' => 'An error occured while associating your OpenX.org account (Code %s).         
                      <br>Please try again in couple of minutes. If the problem persists, 
                      please contact <a href="mailto:%s">OpenX publisher support</a> for assistance.',
        );
        
        // PEAR XML-RPC errors
        $aXmlRpcPearErrors = $this->getXmlRpcPearErrorsCodes();
        foreach ($aXmlRpcPearErrors as $errnum) {
            $aMessages[$errnum] = 'An error occurred while associating your OpenX.org account (Code %s: %s)
            <br>The problem may be caused by an improper configuration of your OpenX Ad Server
            or your web server or by the lack of a required PHP extension.
            <br>If the problem persists, please contact 
            <a href="mailto:%s">OpenX publisher support</a> for assistance.';
        }
        
        
        return $aMessages;
    }
    
    
    /**
     * Returns codes used and returned by PEAR XML_RPC_Client
     *
     * Codes 1-7 errors caused by invalid response
     * 101-106 errors caused by invalid call (e.g. wrong url)
     *
     * @return array
     */
    protected function getXmlRpcPearErrorsCodes()
    {
        return array( '1', '2', '3', '4', '5', '6', '7',
                      '101', '102', '103', '104', '105', '106');
    }    
}

?>