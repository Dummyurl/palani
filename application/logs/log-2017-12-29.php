<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2017-12-29 16:15:13 --> Query error: Table 'school-guru.one_signal_device_details' doesn't exist - Invalid query: SELECT *
FROM `one_signal_device_details`
WHERE `user_id` = '16'
AND `status` = 1
ERROR - 2017-12-29 16:15:43 --> Query error: Table 'school-guru.one_signal_device_details' doesn't exist - Invalid query: SELECT *
FROM `one_signal_device_details`
WHERE `user_id` = '16'
AND `status` = 1
ERROR - 2017-12-29 16:15:56 --> Query error: Table 'school-guru.one_signal_device_details' doesn't exist - Invalid query: SELECT *
FROM `one_signal_device_details`
WHERE `user_id` = '1'
AND `status` = 1
ERROR - 2017-12-29 17:08:47 --> Query error: Column 'recieved_id' cannot be null - Invalid query: INSERT INTO `chat` (`recieved_id`, `sent_id`, `time_zone`, `chatdate`, `msg`) VALUES (NULL, '1', 'Asia/Kolkata', '2017-12-29 17:08:47', 'you are daniel ?')
ERROR - 2017-12-29 17:09:40 --> Query error: Column 'recieved_id' cannot be null - Invalid query: INSERT INTO `chat` (`recieved_id`, `sent_id`, `time_zone`, `chatdate`, `msg`) VALUES (NULL, '1', 'Asia/Kolkata', '2017-12-29 17:09:40', 'Hello vic')
ERROR - 2017-12-29 17:35:33 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND msg.sent_id = 20) or  (msg.recieved_id = 20 AND msg.sent_id =  ))   ORDER BY' at line 6 - Invalid query: SELECT DISTINCT CONCAT(sender.first_name,' ',sender.last_name) as senderName, sender.profile_img as senderImage, sender.id as sender_id,msg.msg, msg.chatdate,social.picture_url as socialImage,msg.id,msg.type,msg.file_name,msg.file_path,time_zone,msg.id
    from chat msg  
    LEFT  join applicants sender on msg.sent_id = sender.id
    LEFT  join social_applicant_user social on social.reference_id = msg.sent_id
    left join chat_deleted_details cd on cd.chat_id  = msg.id
    where cd.can_view = 20 AND ((msg.recieved_id =  AND msg.sent_id = 20) or  (msg.recieved_id = 20 AND msg.sent_id =  ))   ORDER BY msg.id ASC LIMIT 5,5  
ERROR - 2017-12-29 12:15:31 --> Query error: Table 'school-guru.country_list' doesn't exist - Invalid query: SELECT *
FROM `country_list`
ERROR - 2017-12-29 12:15:31 --> Query error: Table 'school-guru.country_list' doesn't exist - Invalid query: SELECT *
FROM `country_list`
ERROR - 2017-12-29 12:15:33 --> Query error: Table 'school-guru.country_list' doesn't exist - Invalid query: SELECT *
FROM `country_list`
ERROR - 2017-12-29 12:15:33 --> Query error: Table 'school-guru.country_list' doesn't exist - Invalid query: SELECT *
FROM `country_list`
ERROR - 2017-12-29 12:15:34 --> Query error: Table 'school-guru.country_list' doesn't exist - Invalid query: SELECT *
FROM `country_list`
ERROR - 2017-12-29 12:15:34 --> Query error: Table 'school-guru.country_list' doesn't exist - Invalid query: SELECT *
FROM `country_list`
ERROR - 2017-12-29 12:15:35 --> Query error: Table 'school-guru.country_list' doesn't exist - Invalid query: SELECT *
FROM `country_list`
ERROR - 2017-12-29 12:15:36 --> Query error: Table 'school-guru.country_list' doesn't exist - Invalid query: SELECT *
FROM `country_list`
ERROR - 2017-12-29 12:15:38 --> Query error: Table 'school-guru.country_list' doesn't exist - Invalid query: SELECT *
FROM `country_list`
ERROR - 2017-12-29 12:15:38 --> Query error: Table 'school-guru.country_list' doesn't exist - Invalid query: SELECT *
FROM `country_list`
ERROR - 2017-12-29 12:15:40 --> Query error: Table 'school-guru.country_list' doesn't exist - Invalid query: SELECT *
FROM `country_list`
ERROR - 2017-12-29 12:15:40 --> Query error: Table 'school-guru.country_list' doesn't exist - Invalid query: SELECT *
FROM `country_list`
ERROR - 2017-12-29 12:15:41 --> Query error: Table 'school-guru.country_list' doesn't exist - Invalid query: SELECT *
FROM `country_list`
ERROR - 2017-12-29 12:15:41 --> Query error: Table 'school-guru.country_list' doesn't exist - Invalid query: SELECT *
FROM `country_list`
ERROR - 2017-12-29 12:15:43 --> Query error: Table 'school-guru.country_list' doesn't exist - Invalid query: SELECT *
FROM `country_list`
ERROR - 2017-12-29 12:15:43 --> Query error: Table 'school-guru.country_list' doesn't exist - Invalid query: SELECT *
FROM `country_list`
ERROR - 2017-12-29 12:15:44 --> Query error: Table 'school-guru.country_list' doesn't exist - Invalid query: SELECT *
FROM `country_list`
ERROR - 2017-12-29 12:15:45 --> Query error: Table 'school-guru.country_list' doesn't exist - Invalid query: SELECT *
FROM `country_list`
ERROR - 2017-12-29 12:15:45 --> Query error: Table 'school-guru.country_list' doesn't exist - Invalid query: SELECT *
FROM `country_list`
ERROR - 2017-12-29 12:15:46 --> Query error: Table 'school-guru.country_list' doesn't exist - Invalid query: SELECT *
FROM `country_list`
ERROR - 2017-12-29 12:15:48 --> Query error: Table 'school-guru.country_list' doesn't exist - Invalid query: SELECT *
FROM `country_list`
ERROR - 2017-12-29 12:15:48 --> Query error: Table 'school-guru.country_list' doesn't exist - Invalid query: SELECT *
FROM `country_list`
ERROR - 2017-12-29 12:15:50 --> Query error: Table 'school-guru.country_list' doesn't exist - Invalid query: SELECT *
FROM `country_list`
ERROR - 2017-12-29 12:15:50 --> Query error: Table 'school-guru.country_list' doesn't exist - Invalid query: SELECT *
FROM `country_list`
ERROR - 2017-12-29 12:15:51 --> Query error: Table 'school-guru.country_list' doesn't exist - Invalid query: SELECT *
FROM `country_list`
ERROR - 2017-12-29 12:15:51 --> Query error: Table 'school-guru.country_list' doesn't exist - Invalid query: SELECT *
FROM `country_list`
ERROR - 2017-12-29 12:15:53 --> Query error: Table 'school-guru.country_list' doesn't exist - Invalid query: SELECT *
FROM `country_list`
ERROR - 2017-12-29 12:15:53 --> Query error: Table 'school-guru.country_list' doesn't exist - Invalid query: SELECT *
FROM `country_list`
ERROR - 2017-12-29 12:15:54 --> Query error: Table 'school-guru.country_list' doesn't exist - Invalid query: SELECT *
FROM `country_list`
ERROR - 2017-12-29 12:15:55 --> Query error: Table 'school-guru.country_list' doesn't exist - Invalid query: SELECT *
FROM `country_list`
ERROR - 2017-12-29 12:15:55 --> Query error: Table 'school-guru.country_list' doesn't exist - Invalid query: SELECT *
FROM `country_list`
ERROR - 2017-12-29 12:15:56 --> Query error: Table 'school-guru.country_list' doesn't exist - Invalid query: SELECT *
FROM `country_list`
ERROR - 2017-12-29 12:15:58 --> Query error: Table 'school-guru.country_list' doesn't exist - Invalid query: SELECT *
FROM `country_list`
ERROR - 2017-12-29 12:15:58 --> Query error: Table 'school-guru.country_list' doesn't exist - Invalid query: SELECT *
FROM `country_list`
