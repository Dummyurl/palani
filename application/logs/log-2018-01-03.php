<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2018-01-03 12:19:52 --> Severity: error --> Exception: DateTimeZone::__construct(): Unknown or bad timezone () /home/dreamguysnew/public_html/application/controllers/User.php 1227
ERROR - 2018-01-03 06:50:41 --> Severity: Parsing Error --> syntax error, unexpected '=', expecting ')' /home/dreamguysnew/public_html/application/controllers/User.php 2646
ERROR - 2018-01-03 06:50:41 --> Severity: Parsing Error --> syntax error, unexpected '=', expecting ')' /home/dreamguysnew/public_html/application/controllers/User.php 2646
ERROR - 2018-01-03 12:26:10 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND msg.sent_id = 20) or  (msg.recieved_id = 20 AND msg.sent_id =  ))' at line 6 - Invalid query: SELECT DISTINCT CONCAT(sender.first_name,' ',sender.last_name) as senderName, sender.profile_img as senderImage, sender.id as sender_id,msg.msg, msg.chatdate,social.picture_url as socialImage,msg.id,msg.type,msg.file_name,msg.file_path,time_zone,msg.id
    from chat msg  
    LEFT  join applicants sender on msg.sent_id = sender.id
    LEFT  join social_applicant_user social on social.reference_id = msg.sent_id
    left join chat_deleted_details cd on cd.chat_id  = msg.id
    where cd.can_view = 20 AND ((msg.recieved_id =  AND msg.sent_id = 20) or  (msg.recieved_id = 20 AND msg.sent_id =  ))
ERROR - 2018-01-03 12:26:22 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND msg.sent_id = 20) or  (msg.recieved_id = 20 AND msg.sent_id =  ))' at line 6 - Invalid query: SELECT DISTINCT CONCAT(sender.first_name,' ',sender.last_name) as senderName, sender.profile_img as senderImage, sender.id as sender_id,msg.msg, msg.chatdate,social.picture_url as socialImage,msg.id,msg.type,msg.file_name,msg.file_path,time_zone,msg.id
    from chat msg  
    LEFT  join applicants sender on msg.sent_id = sender.id
    LEFT  join social_applicant_user social on social.reference_id = msg.sent_id
    left join chat_deleted_details cd on cd.chat_id  = msg.id
    where cd.can_view = 20 AND ((msg.recieved_id =  AND msg.sent_id = 20) or  (msg.recieved_id = 20 AND msg.sent_id =  ))
ERROR - 2018-01-03 16:02:53 --> Query error: Unknown column 'logged_by' in 'field list' - Invalid query: UPDATE `applicants` SET `logged_in` = 1, `logged_by` = 'web'
WHERE `id` = '20'
ERROR - 2018-01-03 16:03:07 --> Query error: Unknown column 'logged_by' in 'field list' - Invalid query: UPDATE `applicants` SET `logged_in` = 1, `logged_by` = 'web'
WHERE `id` = '1'
ERROR - 2018-01-03 13:35:52 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3 - Invalid query: SELECT app.profile_img,social.picture_url
    from  applicants app 
    LEFT join social_applicant_user social on social.reference_id = app.id where app.id = 
ERROR - 2018-01-03 13:35:52 --> Severity: Error --> Call to a member function row_array() on boolean /home/dreamguysnew/public_html/application/controllers/Api.php 667
ERROR - 2018-01-03 13:36:16 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3 - Invalid query: SELECT app.profile_img,social.picture_url
    from  applicants app 
    LEFT join social_applicant_user social on social.reference_id = app.id where app.id = 
ERROR - 2018-01-03 13:36:16 --> Severity: Error --> Call to a member function row_array() on boolean /home/dreamguysnew/public_html/application/controllers/Api.php 667
ERROR - 2018-01-03 13:36:22 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3 - Invalid query: SELECT app.profile_img,social.picture_url
    from  applicants app 
    LEFT join social_applicant_user social on social.reference_id = app.id where app.id = 
ERROR - 2018-01-03 13:36:22 --> Severity: Error --> Call to a member function row_array() on boolean /home/dreamguysnew/public_html/application/controllers/Api.php 667
ERROR - 2018-01-03 13:36:28 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3 - Invalid query: SELECT app.profile_img,social.picture_url
    from  applicants app 
    LEFT join social_applicant_user social on social.reference_id = app.id where app.id = 
ERROR - 2018-01-03 13:36:28 --> Severity: Error --> Call to a member function row_array() on boolean /home/dreamguysnew/public_html/application/controllers/Api.php 667
ERROR - 2018-01-03 13:37:44 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 3 - Invalid query: SELECT app.profile_img,social.picture_url
    from  applicants app 
    LEFT join social_applicant_user social on social.reference_id = app.id where app.id = 
ERROR - 2018-01-03 13:37:44 --> Severity: Error --> Call to a member function row_array() on boolean /home/dreamguysnew/public_html/application/controllers/Api.php 667
ERROR - 2018-01-03 20:23:13 --> Query error: Unknown column 'logged_by' in 'field list' - Invalid query: UPDATE `applicants` SET `logged_in` = 1, `logged_by` = 'web'
WHERE `id` = '1'
ERROR - 2018-01-03 20:28:13 --> Query error: Unknown column 'logged_by' in 'field list' - Invalid query: UPDATE `applicants` SET `logged_in` = 0, `logged_by` = 'mobile'
WHERE `id` = '20'
ERROR - 2018-01-03 10:12:46 --> Query error: Unknown column 'logged_by' in 'field list' - Invalid query: UPDATE `applicants` SET `logged_in` = 1, `logged_by` = 'web'
WHERE `id` = '20'
ERROR - 2018-01-03 10:12:49 --> Query error: Table 'school-guru.notifications' doesn't exist - Invalid query: SELECT *
FROM `notifications`
WHERE `user_id` = '20'
AND `read` =0
ERROR - 2018-01-03 10:12:50 --> Query error: Table 'school-guru.notifications' doesn't exist - Invalid query: SELECT *
FROM `notifications`
WHERE `user_id` = '20'
AND `read` =0
ORDER BY `notify_id` DESC
 LIMIT 6
ERROR - 2018-01-03 10:12:50 --> Query error: Unknown column 'logged_by' in 'field list' - Invalid query: UPDATE `applicants` SET `logged_in` = 0, `logged_by` = 'mobile'
WHERE `id` = '20'
ERROR - 2018-01-03 10:13:03 --> Query error: Unknown column 'logged_by' in 'field list' - Invalid query: UPDATE `applicants` SET `logged_in` = 1, `logged_by` = 'web'
WHERE `id` = '1'
ERROR - 2018-01-03 10:13:06 --> Query error: Table 'school-guru.notifications' doesn't exist - Invalid query: SELECT *
FROM `notifications`
WHERE `user_id` = '1'
AND `read` =0
ORDER BY `notify_id` DESC
 LIMIT 6
ERROR - 2018-01-03 10:13:06 --> Query error: Table 'school-guru.notifications' doesn't exist - Invalid query: SELECT *
FROM `notifications`
WHERE `user_id` = '1'
AND `read` =0
ERROR - 2018-01-03 10:13:09 --> Query error: Table 'school-guru.notifications' doesn't exist - Invalid query: SELECT *
FROM `notifications`
WHERE `user_id` = '1'
AND `read` =0
ERROR - 2018-01-03 10:13:09 --> Query error: Table 'school-guru.notifications' doesn't exist - Invalid query: SELECT *
FROM `notifications`
WHERE `user_id` = '1'
AND `read` =0
ORDER BY `notify_id` DESC
 LIMIT 6
ERROR - 2018-01-03 10:13:14 --> Query error: Table 'school-guru.notifications' doesn't exist - Invalid query: SELECT *
FROM `notifications`
WHERE `user_id` = '1'
AND `read` =0
