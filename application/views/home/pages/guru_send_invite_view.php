<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Invitation From Mentori</title>
</head>

<body>

<table width="600" cellpadding="0" cellspacing="0" align="center">
	<tr>
    	<td style="padding:50px 50px 50px 50px; border:1px solid #bfc0cd; border-radius:20px;">
        	<table width="100%" cellpadding="0" cellspacing="0" align="center">
                <tr>
                    <td>
                        <p style="margin:0; padding:0;"><a href="<?php echo base_url(); ?>" target="_blank"><img src="<?php echo base_url(); ?>assets/images/mentori-logo-emailtemplate.png" /></a></p>
                        <h1 style="font-family:Arial, Helvetica, sans-serif; font-size:36px; color:#000; font-weight:bold; margin:50px 0 10px 0; padding:0;">Hi, <?php echo $result['first_name'].' '.$result['last_name']; ?></h1>
                        <h2 style="font-family:Arial, Helvetica, sans-serif; font-size:24px; color:#808080; font-weight:normal; margin:0 0 30px 0; padding:0;">Mentor invited you from <span style="font-weight:bold; color:#78bd34;">Mentori</span></h2>
                        <p style="font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#808080; font-weight:normal; margin:0; padding:0;">
                            "<?php echo  $message; ?>"
                        </p>
                        <p style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#ffffff; font-weight:normal; margin:30px 0 0 0; padding:0;"><a href="<?php echo base_url(); ?>welcome/mentor_detail/<?php echo $username; ?>" style="color:#ffffff; padding:12px 25px 12px 25px; background:#78bd34; display:inline-block; text-decoration:none; border-radius:8px;">View Profile</a></p>
                    </td>
                </tr>
            </table>	
        </td>
    </tr>
    <tr>
    	<td align="center">
        	<p style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#808080; font-weight:normal; line-height:24px; margin:40px 0 40px 0; padding:0;">&copy; 2018 All rights reserved by <a href="<?php echo base_url(); ?>" target="_blank" style="color:#808080; text-decoration:none;">mentori.ng</a><br />
			<a href="#" target="_blank" style="color:#808080; text-decoration:none;">Privacy Policy</a> and <a href="#" target="_blank" style="color:#808080; text-decoration:none;">Terms & Conditions</a></p>
        </td>
    </tr>
</table>

</body>
</html>
