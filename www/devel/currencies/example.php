<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | PHP version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2003 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at                              |
// | http://www.php.net/license/2_02.txt.                                 |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Author: Marshall Roch <marshall@exclupen.com>                        |
// +----------------------------------------------------------------------+
//
// $Id$

/**
 * Example using Services_ExchangeRates to create a form-based currency converter
 *
 * @package Services_ExchangeRates
 */
require_once '../../../init.php';
require_once '../lib/pear.inc.php';
define('MAX_DEV', MAX_PATH.'/www/devel');

/**
 * Requires Services_ExchangeRates to function
 */
require_once 'Services/ExchangeRates.php';

/**
 * Creates new instance of currency converter
 *
 * @param string Choose where the exchange rates are coming from. In this case,
 *               it's the European Central Bank.
 * @param string Choose where the currency rates are coming from. In this case,
 *               it's the United Nations.
 */
$conv = new Services_ExchangeRates('ECB', 'UN');
?>

<html>
<head>
<title>PEAR Currency Converter - PEAR::Services_ExchangeRates Example</title>
</head>
<body>

<h1>Currency Converter</h1>

<?php

if (!empty($_POST['amount'])) {

    echo "<h1>";
    echo $conv->format($_POST['amount']) . ' ' . $_POST['from'];
    echo " = ";
    echo $conv->convert($_POST['from'], $_POST['to'], $_POST['amount']) . ' ' . $_POST['to'];
    echo "</h1>";
    echo "<h5>";
    echo 'retrieved from '.$conv->ratesSource.'<br />';
    echo 'updated on '.$conv->ratesUpdated.'<br />';
    echo 'base currency '.$conv->baseCurr.'<br />';
    echo 'base rate '.$conv->baseRate.'<br />';
    echo 'rounded to '.$conv->_roundToDecimal.' decimal places'.'<br />';
    echo "</h5>";


} else {
    echo "<h1>Enter how much you want to convert!</h1>";
}
$options = array();
foreach ($conv->validCurrencies as $code => $label)
{
    if ($_POST['from'] != $code)
    {
        $optionsFrom .= '<option value="' . $code . '">' . $label . '</option>';
    }
    else
    {
        $optionsFrom .= '<option value="' . $code . '" selected>' . $label . '</option>';
    }
    if ($_POST['to'] != $code)
    {
        $optionsTo .= '<option value="' . $code . '">' . $label . '</option>';
    }
    else
    {
        $optionsTo .= '<option value="' . $code . '" selected>' . $label . '</option>';
    }
}
?>

<h2>I want to convert...</h2>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <table style="border-collapse: separate; border-spacing: 1em;">
        <tr style="text-align: center;">
            <td>
                <label for="amount">this amount</label><br />
                <input type="text" name="amount" id="amount" value="1" />
            </td>
            <td>
                <label for="from">of this type of currency</label><br />
                <select name="from" id="from">
                <?php echo $optionsFrom; ?>
                </select>
            </td>
            <td>
                <label for="to">to this type of currency</label><br />
                <select name="to" id="to">
                <?php echo $optionsTo; ?>
                </select>
            </td>
        </tr>
        <tr style="text-align: center;">
            <td colspan="3">
                <input type="submit" value="Convert my money!" />
            </td>
        </tr>
    </table>
</form>

</body>
</html>
