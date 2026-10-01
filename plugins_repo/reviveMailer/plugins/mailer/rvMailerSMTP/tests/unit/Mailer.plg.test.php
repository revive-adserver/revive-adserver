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

require_once MAX_PATH . '/lib/OX/Plugin/Component.php';
require_once LIB_PATH . '/RV/Extension/Mailer/AbstractMailer.php';
require_once dirname(dirname(dirname(__FILE__))) . '/Mailer.class.php';

class Plugins_TestOfPlugins_Mailer_rvMailerSMTP_Mailer extends UnitTestCase
{
    public function testDsnPreservesCredentialsContainingReservedCharacters()
    {
        $user = 'alice@example.test';
        $password = 'p@ss:/?+#&=';
        $GLOBALS['_MAX']['CONF']['rvMailerSMTP'] = [
            'tls' => false,
            'user' => $user,
            'password' => $password,
            'hostname' => 'smtp.example.test',
            'port' => 587,
        ];

        $mailer = new class extends Plugins_Mailer_rvMailerSMTP_Mailer {
            public function createTransport(): \Symfony\Component\Mailer\Transport\TransportInterface
            {
                return $this->getTransport();
            }
        };
        $mailer->group = 'rvMailerSMTP';

        $transport = $mailer->createTransport();

        $this->assertEqual($user, $transport->getUsername());
        $this->assertEqual($password, $transport->getPassword());
    }
}
