<?php
$body = <<< EOF
<table class="wide">
        <tr>
            <td><h3>Bug Report from {$this->options['siteName']}</h3></td>
        </tr>
        <tr>
            <td><strong>{$this->options['fromRealName']}</strong> has submitted the following bug report from {$this->options['siteName']}:</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><strong>Name</strong>: {$this->options['fromRealName']}</td>
        </tr>
        <tr>
            <td><strong>Email</strong>: {$this->options['fromEmail']}</td>
        </tr>
        <tr>
            <td><strong>Report</strong>: <pre>{$this->options['body']}</pre></td>
        </tr>
</table>
EOF;
?>