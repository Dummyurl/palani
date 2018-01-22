<?php 


$this->load->library('mpdf');

                    $mpdf = new mPDF('P',  // mode - default ''
                         'A4',    // format - A4, for example, default ''
                         0,     // font size - default 0
                         '',    // default font family
                         10,    // margin_left
                         10,    // margin right
                         16,     // margin top
                         16,    // margin bottom
                         9,     // margin header
                         9,     // margin footer
                         'L');  //

                    $profile_img = '';
                    if(isset($payments['profile_img'])&&!empty($payments['profile_img'])){
                      $profile_img = $payments['profile_img'];
                    }  
                    $social_profile_img = '';
                    if(isset($payments['picture_url'])&&!empty($payments['picture_url'])){
                      $social_profile_img = $payments['picture_url'];
                    }  
                    $img1 = '';
                    if($social_profile_img != ''){
                      $img1 = $social_profile_img;
                    }
                    if($profile_img != ''){
                      $file_to_check = FCPATH . '/assets/images/' . $profile_img;
                      if (file_exists($file_to_check)) {
                        $img1 = base_url() . 'assets/images/'.$profile_img;
                      }
                    }

                    $img = ($img1 != '') ? $img1 : base_url() . 'assets/images/default-avatar.png';
                    $invoice_no = 'I000'.$payments['payment_id'];
                    $payment_date = date('d-m-Y',strtotime($payments['payment_date']));
                    $payment_time = date('h:i A',strtotime($payments['payment_date']));
                    $total = $payments['earned'];
                    $total-- ;


                    if($payments['calls']==1){
                      $hours=$payments['calls'].' hour'; 
                    }else{
                      $hours=$payments['calls'].' hours'; 
                    }





                    $html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                    <html xmlns="http://www.w3.org/1999/xhtml">
                    <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    <title>Invoice</title>
                    <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">
                    <style type="text/css">
                    @font-face {
                      font-family: "lato";
                      src: url("http://school-guru.com/assets/fonts/lato-regular-webfont.woff2") format("woff2"),
                      url("http://school-guru.com/assets/fonts/lato-regular-webfont.woff") format("woff");
                      font-weight: 400;
                      font-style: normal;
                    }
                    @font-face {
                      font-family:"lato";
                      src: url("http://school-guru.com/assets/fonts/lato-semibold-webfont.woff2") format("woff2"),
                      url("http://school-guru.com/assets/fonts/lato-semibold-webfont.woff") format("woff");
                      font-weight: 600;
                      font-style: normal;
                    }

                    .contentarea td{ padding:15px;}
                    table {width:100%;}

                    </style>
                    </head>
                    <body>
                    <div class="maincontainer" style="margin:10px auto; border:1px solid #bfc0cd; border-radius:10px; padding:18px 47px 35px; width:900px; font-family:"lato", sans-serif; font-size:16px; color:#808080; line-height:18px;">
                    <div class="header">         
                    <table style=" border-collapse: collapse;">
                    <tr>
                    <td><table  class="invoice" style="float:left;">
                    <tr>
                    <td><h2 style="font-family:lato;font-size:36px; color:#b5b5b5; line-height:36px; margin:0 0 5px; padding:0; font-weight:600;">INVOICE</h2></td>
                    </tr>
                    <tr>
                    <td><h2 style="font-family:lato;font-size:24px; color:#4f4f4f; line-height:24px; margin:0 0 10px; padding:0; font-weight:400;">#'.$invoice_no.'</h2></td>
                    </tr>
                    <tr>
                    <td><h3 style="font-family:lato;font-size:13px; color:#808080; line-height:13px; margin:0 0 5px; padding:0; font-weight:400;">Date: 17-11-2017</h3></td>
                    </tr>
                    </table>
                    </td>
                    <td style="padding:70px;"></td>
                    <td style="padding:70px;"></td>
                    <td style="padding:70px;"></td>        
                    <td style="padding:40px;"></td>        
                    <td><img src="https://www.dreamguys.co.in/display/schoolguruhtml/images/schoolguru-logo-emailtemplate.png" style=" float:right;"></td>
                    </tr>
                    </table>           

                    </div>
                    <div class="contentarea" style="padding:40px 0px 0px 0px">
                    <table style="font-family:lato;border-spacing: 0px;">
                    <tr style="background:#5c65be;">
                    <td style="color:white;border-right:none;"><b>Applicant Name</b></td>
                    <td style="color:white;border-right:none;"><b>Date</b></td>
                    <td style="color:white;border-right:none;"><b>Time</b></td>
                    <td style="color:white;border-right:none;"><b>Duration</b></td>
                    <td style="color:white;border-right:none;"><b>Amount</b></td>
                    </tr>
                    <tr>
                    <td valign="middle" style="border-bottom:1px solid #bfc0cd;color:#808080;"><img src="'.$img.'" style="width:40px; height:40px; border-radius: 50%; position:relative; vertical-align:middle;"/> '.$payments['user_name'].'</td>
                    <td valign="middle" style="border-bottom:1px solid #bfc0cd;color:#808080;!important">'.$payment_date.'</td>
                    <td valign="middle" style="border-bottom:1px solid #bfc0cd;color:#808080;!important">'.$payment_time.'</td>
                    <td valign="middle" style="border-bottom:1px solid #bfc0cd;color:#808080;!important">'.$hours.'</td>
                    <td valign="middle" style="border-bottom:1px solid #bfc0cd;color:#808080;!important">$ '.$payments['earned'].'</td>
                    </tr>
                    <tr >
                    <td colspan="4" align="right" style="padding:10px 15px;color:#808080;">Sub Total:</td>
                    <td align="right" style="padding:10px 15px;color:#808080;">$ '.$payments['earned'].'</td>
                    </tr>
                    <tr>
                    <td colspan="4" align="right" style="padding:10px 15px;color:#808080;">Portal Commision (10%):</td>
                    <td align="right" style="padding:10px 15px;color:#808080;">$ 1.00</td>
                    </tr>
                    <tr>
                    <td colspan="4" align="right" style="padding:10px 15px;color:#808080;" >Total Tax:</td>
                    <td align="right" style="padding:10px 15px;color:#808080;" >$ 0.00</td>
                    </tr>
                    <tr>
                    <td colspan="3">&nbsp;</td>
                    <td align="right" class="greybg" style="background:#4f4f4f; color:#fff; font-size:20px;">Total:</td>
                    <td align="right" class="greybg" style="background:#4f4f4f; color:#fff; font-size:20px;">$ '.$total.'.00</td>
                    </tr>
                    </table>
                    </div>
                    <div class="footer" style="text-align:center; padding:22px; clear:both;width:100%; overflow:hidden;color:#808080;">Thank you for using SchoolGuru</div>
                    </div>
                    </body>
                    </html>
                    ';


                 // echo $html;   
                    $pdf = 'invoice_'.$invoice_no.'.pdf';

                    $mpdf->writeHTML($html);  
                    $mpdf->Output($pdf, 'D'); 








