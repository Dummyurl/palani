<?php 



// echo '<pre>';
// print_r($payments);
// exit;


$mentee = $this->db->join('applicants a','m.mentor_id = a.id','LEFT')
               ->get_where('mentor_details m',array('m.mentor_id'=>$payments['invite_from']))
               ->row_array();

               $mentor = $this->db->join('applicants a','m.mentor_id = a.id','LEFT')
               ->get_where('mentor_details m',array('m.mentor_id'=>$payments['invite_to']))
               ->row_array();

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
                    $invoice_no = $payments['invoice_no'];
                    $payment_date = date('d-m-Y',strtotime($payments['payment_date']));
                    $payment_time = date('h:i A',strtotime($payments['payment_date']));
                    $total = number_format($payments['earned'],2);                  

                    $html = '
                    <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">
                    <style type="text/css">
                      @font-face {
                        font-family: "lato";
                        src: url("'.base_url().'/assets/fonts/lato-regular-webfont.woff2") format("woff2"),
                        url("'.base_url().'/assets/fonts/lato-regular-webfont.woff") format("woff");
                        font-weight: 400;
                        font-style: normal;
                      }
                      @font-face {
                        font-family:"lato";
                        src: url("'.base_url().'/assets/fonts/lato-semibold-webfont.woff2") format("woff2"),
                        url("'.base_url().'/assets/fonts/lato-semibold-webfont.woff") format("woff");
                        font-weight: 600;
                        font-style: normal;
                      }    
                      .table-bg{width:100%;}
                      .bg{
                        background:url("'.base_url().'assets/images/invoice-bg.png");
                        width:100%;
                        background-size: auto 100%;
                        background-repeat: no-repeat;
                        background-position: left top;
                        height:250px;
                        position:relative;
                      }
                    </style>
                          <div style="border:1px solid #ececec;">
                          <table cellspacing="0" cellpadding="0" width="100%" class="bg" align="center">
                            <tr>                    
                              <td width="40%"> 
                                <img src="'.base_url().'assets/images/mentori-logo-emailtemplate.png" style="padding-left:10px;">
                              </td>
                              <td width="60%">
                                  <table>
                                    <tbody>
                                        <tr align="left">
                                          <td width="50%" style="color:#fff;" align="left">
                                          <b style="font-size:19px;">To : </b><br><br>
                                            <p class="break" colspan="2" style="line-height:25px;clear:both;padding-top:25px;margin-bottom:5px;display:block;">'.$mentee['first_name'].' '.$mentee['last_name'].'</p>                                      
                                             
                                            <p style="line-height:25px;clear:both;padding-top:25px;margin-bottom:5px;display:block;">'.$mentee['country'].'</p>
                                          </td>  
                                          <td></td>
                                          <td width="50%" style="color:#fff;vertical-align: top;" align="right"><b style="font-size:19px;">From : </b><br><br>
                                           <p colspan="2" style="margin-bottom:5px;">'.$mentor['first_name'].' '.$mentor['last_name'].'</p>
                                           <p style="margin-bottom:5px;"> '.$mentor['country'].'</p> 
                                          </td>  
                                          <td></td>
                                          </tr>       
                                    </tbody>
                                  </table>
                              </td>                    
                            </tr>

                          </table>
                          <table class="table-bg" cellpadding="20" width="100%" style="width:100%;border-collapse: collapse;" >
                              <tr>
                                <td width="50%" align="left"> 
                                  <b>Supplier For GST Purpose :</b><br><br>                                   
                                   <p> Dreamguys Technologies <br> United Kingdom</p>
                                </td>
                                <td width="50%" align="right" style="vertical-align: top"> 
                                  <p> Date : '.date('d-m-Y').'</p>
                                  <p> Invoice : #'.$invoice_no.' </p>                                  
                                </td>
                              </tr>               
                          </table>
                          <div style="padding:20px">
                          <table class="table-bg" style="border:1px solid #ececec;font-family:lato;border-spacing: 0px;" cellpadding="20" width="100%" cellspacing="20">
                              <tr style="background:#78bd34;">
                                <td style="color:white;border-right:none;"><b>Mentor Name</b></td>
                                <td style="color:white;border-right:none;"><b>Date</b></td>
                                <td style="color:white;border-right:none;"><b>Time</b></td>                    
                                <td style="color:white;border-right:none;"><b>Amount</b></td>
                              </tr>
                              <tr>
                                <td valign="middle" style="border-bottom:1px solid #bfc0cd;color:#808080;"><img src="'.$img.'" style="width:40px; height:40px; border-radius: 50%; position:relative; vertical-align:middle;"/> '.$payments['guru_name'].'</td>
                                <td valign="middle" style="border-bottom:1px solid #bfc0cd;color:#808080;!important">'.$payment_date.'</td>
                                <td valign="middle" style="border-bottom:1px solid #bfc0cd;color:#808080;!important">'.$payment_time.'</td>
                                
                                <td align="right" style="border-bottom:1px solid #bfc0cd;color:#808080;!important">$ '.number_format($payments['per_hour_charge'],2).'</td>
                             </tr>

                             <tr>
                              <td colspan="3" align="right" style="padding:10px 15px;color:#808080;">Tax Percentage('.$payments['tax_percentage'].'%):</td>
                              <td align="right" style="padding:10px 15px;color:#808080;">$ '.number_format($payments['tax_amount'],2).'</td>
                            </tr>                                     
                            <tr>
                              <td colspan="2">&nbsp;</td>
                              <td align="right" class="greybg" style="background:#4f4f4f; color:#fff; font-size:20px;">Total:</td>
                              <td align="right" class="greybg" style="background:#4f4f4f; color:#fff; font-size:20px;">$ '.$total.'</td>
                            </tr>
                             <tr>
                                <td colspan="3">&nbsp;</td>
                                <td align="right" cellspacing="10">Paid via Stripe</td>
                             </tr> 
                          </table>
                            </div>
                          </div>
                    <div class="footer" style="text-align:center; padding-top:22px; clear:both;width:100%; overflow:hidden;color:#808080;">Thank you for using Mentori</div>
                    </div>
                     <div class="footer" style="font-size:15px;text-align:center; padding:0px; clear:both;width:100%; overflow:hidden;color:#808080;"><p style="font-size:12px;"><b>* VAT 18% is charged, invoiced and collected by Dreamguys Technologies Pvt Ltd </b></p></div>
                    </div>
                    </body>
                    </html>
                    ';


                 // echo $html;   
                    $pdf = 'invoice_'.$invoice_no.'.pdf';


                        /* Uncomment to generate HTML */
                           // echo $html;
                    

                    /* Uncomment to generate PDF */

                       $mpdf->writeHTML($html);  
                       $mpdf->Output($pdf, 'D'); 








