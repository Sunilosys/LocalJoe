<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
<p>Dear <?php echo $first_name; ?>,<br/></p>
<p>This e-mail was sent in response to your request to change your registered email to <?php echo $new_email; ?>.</p>
<p>The link below will allow you to change your registered email.</p>
<p>Please click on the link or paste it into your browser and follow the instructions:</p>
<p><a href='<?php echo $change_email_url; ?>'><?php echo $change_email_url; ?></a></p>
<p>If you received this email in error then please notify support by sending email to admin@localjoe.com.  We will investigate to determine why this email was sent.</p>
<br/>
<p>Thank you for using LocalJoe!</p>
<p><a href='www.LocalJoe.com'>www.LocalJoe.com</a></p>

    </body>
</html>