<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package _glad
 */

 function generate_alert_email( $sender, $message, $title = '' ) {

   $user_id = $sender;
   $user = get_userdata( $user_id );
   $email = $user->data->user_email;
   $name = get_user_meta($user_id, 'first_name', true) . ' ' . get_user_meta($user_id, 'last_name', true);
   $company = get_user_meta($user_id, 'mepr_company', true);
   $phone = get_user_meta($user_id, 'mepr_phone_number', true);

   if( in_array('administrator', (array) $user->roles ) ) {
     $email = 'admin@glada.aero';
     $company = get_bloginfo( 'name' );
     $phone = get_theme_mod('phone_number');
   }

   ob_start();

   include( get_stylesheet_directory() . '/inc/email_parts/head.php'); ?>

   <body style="height: 100%;margin: 0;padding: 0;width: 100%;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
     <center>
       <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;height: 100%;margin: 0;padding: 0;width: 100%;">
         <tr>
           <td align="center" valign="top" id="bodyCell" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;height: 100%;margin: 0;padding: 0;width: 100%;">
             <!-- BEGIN TEMPLATE // -->
             <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
               <tr>
                 <td align="center" valign="top" id="templateHeader" data-template-container style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #fbfbfb;background-image: none;background-repeat: no-repeat;background-position: center;background-size: cover;border-top: 0;border-bottom: 0;padding-top: 0px;padding-bottom: 0px;">
                   <!--[if (gte mso 9)|(IE)]>
                   <table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
                   <tr>
                   <td align="center" valign="top" width="600" style="width:600px;">
                   <![endif]-->
                   <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;max-width: 600px !important;">
                     <tr>
                       <td valign="top" class="headerContainer" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #transparent;background-image: none;background-repeat: no-repeat;background-position: center;background-size: cover;border-top: 0;border-bottom: 0;padding-top: 0;padding-bottom: 0;"></td>
                     </tr>
                   </table>
                   <!--[if (gte mso 9)|(IE)]>
                 </td>
               </tr>
             </table>
             <![endif]-->
           </td>
         </tr>
         <tr>
           <td align="center" valign="top" id="templateBody" data-template-container style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #fbfbfb;background-image: none;background-repeat: no-repeat;background-position: center;background-size: cover;border-top: 0;border-bottom: 0;padding-top: 0px;padding-bottom: 0px;">
             <!--[if (gte mso 9)|(IE)]>
             <table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
             <tr>
             <td align="center" valign="top" width="600" style="width:600px;">
             <![endif]-->
             <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;max-width: 600px !important;">
               <tr>
                 <td valign="top" class="bodyContainer" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #transparent;background-image: none;background-repeat: no-repeat;background-position: center;background-size: cover;border-top: 0;border-bottom: 0;padding-top: 0;padding-bottom: 0;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnCodeBlock" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                   <tbody class="mcnTextBlockOuter">
                     <tr>
                       <td valign="top" class="mcnTextBlockInner" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                         <table align="center" width="600" height="26" border="0" cellspacing="0" cellpadding="0" style="width: 600px;max-width: 600px;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                           <tbody>
                             <tr width="600">
                               <td width="600" height="26" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><a href="https://www.glada.aero/" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><img src="https://glada.aero/assets/emails/email_top.jpg" width="600" style="display: block;width: 600px;max-width: 600px;height: 26px;border: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;"></a></td>
                             </tr>
                           </tbody>
                         </table>
                       </td>
                     </tr>
                   </tbody>
                 </table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnCodeBlock" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                     <tbody class="mcnTextBlockOuter">
                         <tr>
                             <td valign="top" class="mcnTextBlockInner" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                 <table align="center" width="600" border="0" cellspacing="0" cellpadding="0" style="width: 600px;max-width: 600px;table-layout: fixed;background: #ffffff;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                   <tbody>
                     <tr width="600">
                       <td colspan="12" width="600" height="40" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">&nbsp;</td>
                     </tr>
                     <tr width="600">
                       <td colspan="12" width="600" height="40" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                         <img src="https://glada.aero/assets/emails/Alerts_upperbubble.jpg" width="600" style="display: block;width: 600px;max-width: 600px;height: 40px;border: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;">
                       </td>
                     </tr>
                     <tr width="600">
                       <td colspan="1" width="50" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"></td>
                       <td colspan="1" width="500" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                         <table width="500" border="0" cellspacing="0" cellpadding="0" style="background: #ebe0b4;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                           <tbody>
                             <tr>
                               <td style="padding-left: 50px;padding-right: 50px;padding-top: 20px;padding-bottom: 20px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                 <p style="margin: 10px 0;font-family: roboto, helvetica, sans-serif;font-size: 1.2em;line-height: 1.4em;padding: 0;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                   <?php
                                     if( $title ) {
                                       echo $title . '<br><br>';
                                     }
                                     echo nl2br( $message );
                                   ?>
                                 </p>
                               </td>
                             </tr>
                           </tbody>
                         </table>
                       </td>
                       <td colspan="1" width="50" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"></td>
                     </tr>
                     <tr width="600">
                       <td colspan="12" width="600" height="60" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                         <img src="https://glada.aero/assets/emails/Alerts_lowerbubble.jpg" width="600" style="display: block;width: 600px;max-width: 600px;height: 60px;border: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;">
                       </td>
                     </tr>
                     <tr width="600">
                       <td colspan="12" width="600" style="padding-left: 50px;padding-right: 50px;padding-bottom: 20px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                         <p style="margin: 10px 0;text-align: right;padding: 0;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                         <span style="font-family: roboto, helvetica, sans-serif; font-size: 1.4em; font-stretch: extra-condensed; text-transform:uppercase; letter-spacing:.15em; font-weight:bold; color: #444444; line-height:1.5em;">
                           <?php echo $name; ?>
                         </span>
                         <br>
                         <span style="font-family: roboto, helvetica, sans-serif; font-size: 1.4em; font-stretch: extra-condensed; text-transform:uppercase; letter-spacing:.15em; font-weight:bold; color: #decc82; line-height:1.5em;">
                           <?php echo $company; ?>
                         </span>
                         <br>
                         <span style="font-family: georgia, serif; font-style:italic; text-align:right; line-height:1;">
                         <a style="color: #444444;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" href="mailto:<?php echo $email; ?>?subject=Re:%20GLADA%20Alert">
                           <?php echo $email; ?>
                         <img src="https://glada.aero/assets/emails/Alerts_mail.jpg" style="height: 30px;width: 26px;display: inline-block;vertical-align: middle;border: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;"></a>
                         </span>
                         <br>
                         <span style="font-family: georgia, serif; font-style:italic; text-align:right; line-height:1;">
                         <a style="color: #444444;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" href="tel:+<?php echo $phone; ?>">
                           <?php echo formatPhoneNumber( $phone ); ?>
                         <img src="https://glada.aero/assets/emails/Alerts_phone.jpg" style="height: 30px;width: 26px;display: inline-block;vertical-align: middle;border: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;"></a>
                         </span>
                         </p>
                       </td>
                     </tr>
                   </tbody>
                 </table>
                             </td>
                         </tr>
                     </tbody>
                 </table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnCodeBlock" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                   <tbody class="mcnTextBlockOuter">
                     <tr>
                       <td valign="top" class="mcnTextBlockInner" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                         <table align="center" width="600" height="530" border="0" cellspacing="0" cellpadding="0" style="width: 600px;max-width: 600px;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                           <tbody>
                             <tr width="600">
                               <td width="600" height="530" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><a href="https://www.glada.aero/sms/" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><img src="https://glada.aero/assets/emails/Alerts_lower1.jpg" width="600" style="display: block;width: 600px;max-width: 600px;height: 530px;border: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;"></a></td>
                             </tr>
                           </tbody>
                         </table>
                       </td>
                     </tr>
                   </tbody>
                 </table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnCodeBlock" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                   <tbody class="mcnTextBlockOuter">
                     <tr>
                       <td valign="top" class="mcnTextBlockInner" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                         <table align="center" width="600" height="142" border="0" cellspacing="0" cellpadding="0" style="width: 600px;max-width: 600px;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                           <tbody>
                             <tr width="600">
                               <td width="600" height="142" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><a href="https://www.glada.aero/" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><img src="https://glada.aero/assets/emails/Alerts_lower2.jpg" width="600" style="display: block;width: 600px;max-width: 600px;height: 142px;border: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;"></a></td>
                             </tr>
                           </tbody>
                         </table>
                       </td>
                     </tr>
                   </tbody>
                 </table></td>
               </tr>
             </table>
             <!--[if (gte mso 9)|(IE)]>
           </td>
         </tr>
       </table>
       <![endif]-->
     </td>
   </tr>
   <tr>
     <td align="center" valign="top" id="templateFooter" data-template-container style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #fbfbfb;background-image: none;background-repeat: no-repeat;background-position: center;background-size: cover;border-top: 0;border-bottom: 0;padding-top: 45px;padding-bottom: 63px;">
       <!--[if (gte mso 9)|(IE)]>
       <table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
       <tr>
       <td align="center" valign="top" width="600" style="width:600px;">
       <![endif]-->
       <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;max-width: 600px !important;">
         <tr>
           <td valign="top" class="footerContainer" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #transparent;background-image: none;background-repeat: no-repeat;background-position: center;background-size: cover;border-top: 0;border-bottom: 0;padding-top: 0;padding-bottom: 0;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
             <tbody class="mcnTextBlockOuter">
               <tr>
                 <td valign="top" class="mcnTextBlockInner" style="padding-top: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                   <!--[if mso]>
                   <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
                   <tr>
                   <![endif]-->

                   <!--[if mso]>
                   <td valign="top" width="600" style="width:600px;">
                   <![endif]-->
                   <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width: 100%;min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" width="100%" class="mcnTextContentContainer">
                     <tbody><tr>
                       <td valign="top" class="mcnTextContent" style="padding-top: 0;padding-right: 18px;padding-bottom: 9px;padding-left: 18px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;word-break: break-word;color: #000000;font-family: 'Helvetica Neue', Helvetica, Arial, Verdana, sans-serif;font-size: 12px;line-height: 150%;text-align: center;">
                         <a href="https://glada.aero/assets/emails/GLADA%20Alerts.vcf">Click Here to Download the GLADA Alerts Vcard</a>
                         <br><br>
                         <em>Copyright &copy; <?php echo date('Y') . ' ' . get_bloginfo( 'name' ); ?>, All rights reserved.</em><br>
                         <br>
                         <strong>Our mailing address is:</strong><br>
                         <?php echo get_theme_mod('address_line1') . ', ' . get_theme_mod('address_line2') . '<br>' . get_theme_mod('city-st') . ', ' . get_theme_mod('zipcode'); ?><br>
                         <br>
                         You have received this email because you are subscribed as a Member or Team Member of a GLADA Dealer Member. If you wish to unsubscribe, please <a href="https://glada.aero/contact" target="_blank" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #a9a9a9;font-weight: normal;text-decoration: underline;">contact support.</a>
                       </td>
                     </tr>
                   </tbody></table>
                   <!--[if mso]>
                 </td>
                 <![endif]-->

                 <!--[if mso]>
               </tr>
             </table>
             <![endif]-->
           </td>
         </tr>
       </tbody>
     </table></td>
   </tr>
 </table>
 <!--[if (gte mso 9)|(IE)]>
  </td>
  </tr>
  </table>
  <![endif]-->
  </td>
  </tr>
  </table>
  <!-- // END TEMPLATE -->
  </td>
  </tr>
  </table>
  </center>
  </body>
  </html>

  <?php

  $content = ob_get_contents();
  ob_end_clean();

  $data = array(
    'name'    => $name,
    'email'   => $email,
    'content' => $content,
  );

  return $data;

 }


 function generate_bounce_email( $message, $sorry = '_sorry' ) {

   ob_start();
   include( get_stylesheet_directory() . '/inc/email_parts/head.php'); ?>

   <!-- sstuff -->
   <body style="height: 100%;margin: 0;padding: 0;width: 100%;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" data-new-gr-c-s-check-loaded="14.1008.0" data-gr-ext-installed="">
     <center>
       <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;height: 100%;margin: 0;padding: 0;width: 100%;">
         <tbody><tr>
           <td align="center" valign="top" id="bodyCell" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;height: 100%;margin: 0;padding: 0;width: 100%;">
             <!-- BEGIN TEMPLATE // -->
             <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
               <tbody><tr>
                 <td align="center" valign="top" id="templateHeader" data-template-container="" style="background:#fbfbfb none no-repeat center/cover;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #fbfbfb;background-image: none;background-repeat: no-repeat;background-position: center;background-size: cover;border-top: 0;border-bottom: 0;padding-top: 0px;padding-bottom: 0px;">
                   <!--[if (gte mso 9)|(IE)]>
                   <table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
                   <tr>
                   <td align="center" valign="top" width="600" style="width:600px;">
                   <![endif]-->
                   <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;max-width: 600px !important;">
                     <tbody><tr>
                       <td valign="top" class="headerContainer" style="background:#transparent none no-repeat center/cover;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #transparent;background-image: none;background-repeat: no-repeat;background-position: center;background-size: cover;border-top: 0;border-bottom: 0;padding-top: 0;padding-bottom: 0;"></td>
                     </tr>
                   </tbody></table>
                   <!--[if (gte mso 9)|(IE)]>
                 </td>
               </tr>
             </table>
             <![endif]-->
           </td>
         </tr>
         <tr>
           <td align="center" valign="top" id="templateBody" data-template-container="" style="background:#fbfbfb none no-repeat center/cover;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #fbfbfb;background-image: none;background-repeat: no-repeat;background-position: center;background-size: cover;border-top: 0;border-bottom: 0;padding-top: 0px;padding-bottom: 0px;">
             <!--[if (gte mso 9)|(IE)]>
             <table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
             <tr>
             <td align="center" valign="top" width="600" style="width:600px;">
             <![endif]-->
             <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;max-width: 600px !important;">
               <tbody><tr>
                 <td valign="top" class="bodyContainer" style="background:#transparent none no-repeat center/cover;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #transparent;background-image: none;background-repeat: no-repeat;background-position: center;background-size: cover;border-top: 0;border-bottom: 0;padding-top: 0;padding-bottom: 0;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnCodeBlock" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                   <tbody class="mcnTextBlockOuter">
                     <tr>
                       <td valign="top" class="mcnTextBlockInner" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                         <table align="center" width="600" height="225" border="0" cellspacing="0" cellpadding="0" style="width: 600px;max-width: 600px;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                           <tbody>
                             <tr width="600">
                               <td width="600" height="225" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><a href="https://www.glada.aero/" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><img src="https://glada.aero/assets/emails/error<?php echo $sorry; ?>.jpg" width="600" style="display: block;width: 600px;max-width: 600px;height: 225px;border: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;"></a></td>
                             </tr>
                           </tbody>
                         </table>
                       </td>
                     </tr>
                   </tbody>
                 </table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnCodeBlock" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                   <tbody class="mcnTextBlockOuter">
                     <tr>
                       <td valign="top" class="mcnTextBlockInner" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                         <table align="center" width="600" border="0" cellspacing="0" cellpadding="0" style="width: 600px;max-width: 600px;table-layout: fixed;background: #ffffff;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                           <tbody>
                             <tr width="600">
                               <td colspan="1" width="50" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"></td>
                               <td colspan="10" width="500" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                 <table width="500" border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                   <tbody>
                                     <tr>
                                       <td style="padding-left: 50px;padding-right: 50px;padding-top: 20px;padding-bottom: 20px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                         <p style="margin: 10px 0;font-family: 'matrix-ii', 'PT Serif', georgia, serif;font-size: 1em;font-style: italic;line-height: 1.4em;padding: 0;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">

                                           <?php echo $message; ?>

                                         </p>
                                       </td>
                                     </tr>
                                   </tbody>
                                 </table>
                               </td>
                               <td colspan="1" width="50" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"></td>
                             </tr>
                             <tr width="600">
                               <td colspan="12" width="600" height="40" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">&nbsp;</td>
                             </tr>
                           </tbody>
                         </table>
                       </td>
                     </tr>
                   </tbody>
                 </table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnCodeBlock" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                   <tbody class="mcnTextBlockOuter">
                     <tr>
                       <td valign="top" class="mcnTextBlockInner" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                         <table align="center" width="600" height="315" border="0" cellspacing="0" cellpadding="0" style="width: 600px;max-width: 600px;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                           <tbody>
                             <tr width="600">
                               <td width="600" height="315" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><a href="mailto:admin@glada.aero?subject=Alerts%20Error" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><img src="https://glada.aero/assets/emails/error_lower.jpg" width="600" style="display: block;width: 600px;max-width: 600px;height: 315px;border: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;"></a></td>
                             </tr>
                           </tbody>
                         </table>
                       </td>
                     </tr>
                   </tbody>
                 </table></td>
               </tr>
             </tbody></table>
             <!--[if (gte mso 9)|(IE)]>
           </td>
         </tr>
       </table>
       <![endif]-->
     </td>
   </tr>
   <tr>
     <td align="center" valign="top" id="templateFooter" data-template-container style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #fbfbfb;background-image: none;background-repeat: no-repeat;background-position: center;background-size: cover;border-top: 0;border-bottom: 0;padding-top: 45px;padding-bottom: 63px;">
       <!--[if (gte mso 9)|(IE)]>
       <table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
       <tr>
       <td align="center" valign="top" width="600" style="width:600px;">
       <![endif]-->
       <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;max-width: 600px !important;">
         <tr>
           <td valign="top" class="footerContainer" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #transparent;background-image: none;background-repeat: no-repeat;background-position: center;background-size: cover;border-top: 0;border-bottom: 0;padding-top: 0;padding-bottom: 0;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
             <tbody class="mcnTextBlockOuter">
               <tr>
                 <td valign="top" class="mcnTextBlockInner" style="padding-top: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                   <!--[if mso]>
                   <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
                   <tr>
                   <![endif]-->

                   <!--[if mso]>
                   <td valign="top" width="600" style="width:600px;">
                   <![endif]-->
                   <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width: 100%;min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" width="100%" class="mcnTextContentContainer">
                     <tbody><tr>
                       <td valign="top" class="mcnTextContent" style="padding-top: 0;padding-right: 18px;padding-bottom: 9px;padding-left: 18px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;word-break: break-word;color: #000000;font-family: 'Helvetica Neue', Helvetica, Arial, Verdana, sans-serif;font-size: 12px;line-height: 150%;text-align: center;">
                         <br>
                         <em>Copyright &copy; <?php echo date('Y') . ' ' . get_bloginfo( 'name' ); ?>, All rights reserved.</em><br>
                         <br>
                         <strong>Our mailing address is:</strong><br>
                         <?php echo get_theme_mod('address_line1') . ', ' . get_theme_mod('address_line2') . '<br>' . get_theme_mod('city-st') . ', ' . get_theme_mod('zipcode'); ?><br>
                       </td>
                     </tr>
                   </tbody></table>
                   <!--[if mso]>
                 </td>
                 <![endif]-->

                 <!--[if mso]>
               </tr>
             </table>
             <![endif]-->
           </td>
         </tr>
       </tbody>
     </table></td>
   </tr>
   </table>
   <!--[if (gte mso 9)|(IE)]>
  </td>
  </tr>
  </table>
  <![endif]-->
  </td>
  </tr>

  </tbody>
  </table>
  <!-- // END TEMPLATE -->
  </td>
  </tr>
  </tbody>
  </table>
  </center>

  <!-- more stuff -->
  </body>
  </html>
  <?php

  $content = ob_get_contents();
  ob_end_clean();

  return $content;

}
