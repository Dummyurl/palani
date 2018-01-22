<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2017-12-27 16:15:07 --> Query error: Unknown column 'p.invite_id' in 'on clause' - Invalid query: SELECT p.payment_date,p.mentor_id,p.payment_id,p.payment_status,SUM(payment_gross) as earned,COUNT(p.payment_id)as calls,a.delete_sts, a.username as applicant_user_name,a.profile_img as applicant_profile_img,CONCAT(a.first_name,' ',a.last_name) AS applicant_name,s.picture_url as applicant_picture,i.approved,i.invite_date,i.invite_time,i.invite_end_time,i.time_zone
         FROM applicants a 
        LEFT JOIN payments p ON a.id = p.mentor_id 
        LEFT JOIN invite i ON i.invite_id = p.invite_id  
        LEFT JOIN social_applicant_user s ON s.reference_id = p.mentor_id WHERE a.role = '1' AND p.user_id = '16'  GROUP BY p.payment_date  LIMIT 0,10
ERROR - 2017-12-27 16:16:06 --> Query error: Unknown column 'p.invite_id' in 'on clause' - Invalid query: SELECT p.payment_date,p.mentor_id,p.payment_id,p.payment_status,SUM(payment_gross) as earned,COUNT(p.payment_id)as calls,a.delete_sts, a.username as applicant_user_name,a.profile_img as applicant_profile_img,CONCAT(a.first_name,' ',a.last_name) AS applicant_name,s.picture_url as applicant_picture,i.approved,i.invite_date,i.invite_time,i.invite_end_time,i.time_zone
         FROM applicants a 
        LEFT JOIN payments p ON a.id = p.mentor_id 
        LEFT JOIN invite i ON i.invite_id = p.invite_id  
        LEFT JOIN social_applicant_user s ON s.reference_id = p.mentor_id WHERE a.role = '1' AND p.user_id = '16'  GROUP BY p.payment_date  LIMIT 0,10
ERROR - 2017-12-27 16:18:29 --> Query error: Unknown column 'p.invite_id' in 'on clause' - Invalid query: SELECT p.payment_date,p.mentor_id,p.payment_id,p.payment_status,SUM(payment_gross) as earned,COUNT(p.payment_id)as calls,a.delete_sts, a.username as applicant_user_name,a.profile_img as applicant_profile_img,CONCAT(a.first_name,' ',a.last_name) AS applicant_name,s.picture_url as applicant_picture,i.approved,i.invite_date,i.invite_time,i.invite_end_time,i.time_zone
         FROM applicants a 
        LEFT JOIN payments p ON a.id = p.mentor_id 
        LEFT JOIN invite i ON i.invite_id = p.invite_id  
        LEFT JOIN social_applicant_user s ON s.reference_id = p.mentor_id WHERE a.role = '1' AND p.user_id = '16'  GROUP BY p.payment_date  LIMIT 0,10
ERROR - 2017-12-27 12:16:06 --> Severity: error --> Exception: /home/dreamguysnew/public_html/application/models/Dashboard_model.php exists, but doesn't declare class Dashboard_model /home/dreamguysnew/public_html/system/core/Loader.php 336
ERROR - 2017-12-27 12:54:01 --> Severity: Parsing Error --> syntax error, unexpected ''</span>' (T_ENCAPSED_AND_WHITESPACE) /home/dreamguysnew/public_html/application/controllers/User.php 2150
ERROR - 2017-12-27 12:54:01 --> Severity: Parsing Error --> syntax error, unexpected ''</span>' (T_ENCAPSED_AND_WHITESPACE) /home/dreamguysnew/public_html/application/controllers/User.php 2150
ERROR - 2017-12-27 12:54:02 --> Severity: Parsing Error --> syntax error, unexpected '=' /home/dreamguysnew/public_html/application/controllers/User.php 3873
