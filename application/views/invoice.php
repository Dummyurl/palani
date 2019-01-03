<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Invoice</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">
    <style type="text/css">
    @font-face {
        font-family: 'lato';
        src: url('http://school-guru.com/assets/fonts/lato-regular-webfont.woff2') format('woff2'),
        url('http://school-guru.com/assets/fonts/lato-regular-webfont.woff') format('woff');
        font-weight: 400;
        font-style: normal;
    }
    @font-face {
        font-family: 'lato';
        src: url('http://school-guru.com/assets/fonts/lato-semibold-webfont.woff2') format('woff2'),
        url('http://school-guru.com/assets/fonts/lato-semibold-webfont.woff') format('woff');
        font-weight: 600;
        font-style: normal;
    }
    .maincontainer{ margin:10px auto; border:1px solid #bfc0cd; border-radius:10px; padding:40px 40px 30px; width:900px; font-family:'lato', sans-serif; 
    .header, .contentarea, .footer{ clear:both; width:100%; overflow:hidden;}
    .header .invoice{ float:left;}
    .header .invoice h1{ font-size:36px; color:#b5b5b5; line-height:36px; margin:0 0 5px; padding:0; font-weight:600;}
    .header .invoice h2{ font-size:24px; color:#4f4f4f; line-height:24px; margin:0 0 10px; padding:0; font-weight:400;}
    .header .invoice h3{ font-size:13px; color:#808080; line-height:13px; margin:0 0 5px; padding:0; font-weight:400;}
    .header .logo{ float:right;}
    .contentarea{ margin:50px 0;}
    .contentarea table{ width:100%;}
    .contentarea td{ padding:15px;}
    .contentarea tr.tablehead{ background:#5c65be; color:#fff; font-size:18px;}
    .contentarea tr.tableborder td{ border-bottom:1px solid #bfc0cd;}
    .contentarea tr.tableborder td img{ width:40px; height:40px; border-radius:50%; position:relative; vertical-align:middle;}
    .contentarea tr.subtotal td{ padding:10px 15px;}
    .contentarea tr.subtotal td{ padding:10px 15px;}
    .contentarea tr td.greybg{ background:#4f4f4f; color:#fff; font-size:20px;}
    .footer{ text-align:center; padding:2px 0;}
</style>
</head>
<body>
    <div class="maincontainer">
        <div class="header">
            <div class="invoice">
                <h1>INVOICE</h1>
                <h2>#000009</h2>
                <h3>Date: 17-11-2017</h3>
            </div>
            <div class="logo"><img src="https://www.dreamguys.co.in/display/schoolguruhtml/images/schoolguru-logo-emailtemplate.png"></div>
        </div>
        
        <div class="contentarea">
            <table cellpadding="0" cellspacing="0" border="0">
                <tr class="tablehead">
                    <td>Mentor Name</td>
                    <td>Date</td>
                    <td>Time</td>
                    <td>Duration</td>
                    <td>Amount</td>
                </tr>
                <tr class="tableborder">
                    <td valign="middle"><img src="http://school-guru.com/assets/images/20170824023336.png" /> Olivia Chole</td>
                    <td valign="middle">12-07-2017</td>
                    <td valign="middle">11:00 AM</td>
                    <td valign="middle">1 hour</td>
                    <td valign="middle">$ 10.00</td>
                </tr>
                <tr class="subtotal">
                    <td colspan="4" align="right">Sub Total:</td>
                    <td align="right">$ 10.00</td>
                </tr>
                <tr class="subtotal">
                    <td colspan="4" align="right">Portal Commision (10%):</td>
                    <td align="right">$ 1.00</td>
                </tr>
                <tr class="subtotal">
                    <td colspan="4" align="right">Total Tax:</td>
                    <td align="right">$ 0.00</td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                    <td align="right" class="greybg">Total:</td>
                    <td align="right" class="greybg">$ 9.00</td>
                </tr>
            </table>
        </div>
        
        <div class="footer">Thank you for using Mentori</div>
        
    </div>
</body>
</html>