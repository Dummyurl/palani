<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2017-12-22 05:11:20 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND ((msg.recieved_id = 20 AND msg.sent_id = ) or  (msg.recieved_id =  AND msg.s' at line 3 - Invalid query: SELECT msg.id  from chat msg     
     left join chat_deleted_details cd on cd.chat_id  = msg.id
    where  cd.can_view =  AND ((msg.recieved_id = 20 AND msg.sent_id = ) or  (msg.recieved_id =  AND msg.sent_id =  20))   ORDER BY msg.id DESC 
ERROR - 2017-12-22 05:11:20 --> Severity: Error --> Call to a member function num_rows() on boolean /home/dreamguysnew/public_html/application/models/Api_model.php 62
ERROR - 2017-12-22 05:11:26 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND ((msg.recieved_id = 20 AND msg.sent_id = ) or  (msg.recieved_id =  AND msg.s' at line 3 - Invalid query: SELECT msg.id  from chat msg     
     left join chat_deleted_details cd on cd.chat_id  = msg.id
    where  cd.can_view =  AND ((msg.recieved_id = 20 AND msg.sent_id = ) or  (msg.recieved_id =  AND msg.sent_id =  20))   ORDER BY msg.id DESC 
ERROR - 2017-12-22 05:11:26 --> Severity: Error --> Call to a member function num_rows() on boolean /home/dreamguysnew/public_html/application/models/Api_model.php 62
ERROR - 2017-12-22 05:12:21 --> Query error: Column 'sent_id' cannot be null - Invalid query: INSERT INTO `chat` (`sent_id`, `recieved_id`, `time_zone`, `chatdate`, `msg`) VALUES (NULL, '20', 'Asia/Kolkata', '2017-12-21 13:21:00', 'New Message')
ERROR - 2017-12-22 05:15:27 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND ((msg.recieved_id = 20 AND msg.sent_id = ) or  (msg.recieved_id =  AND msg.s' at line 3 - Invalid query: SELECT msg.id  from chat msg     
     left join chat_deleted_details cd on cd.chat_id  = msg.id
    where  cd.can_view =  AND ((msg.recieved_id = 20 AND msg.sent_id = ) or  (msg.recieved_id =  AND msg.sent_id =  20))   ORDER BY msg.id DESC 
ERROR - 2017-12-22 05:15:27 --> Severity: Error --> Call to a member function num_rows() on boolean /home/dreamguysnew/public_html/application/models/Api_model.php 62
ERROR - 2017-12-22 06:18:33 --> Severity: Parsing Error --> syntax error, unexpected ')' /home/dreamguysnew/public_html/application/controllers/Api.php 656
ERROR - 2017-12-22 06:18:35 --> Severity: Parsing Error --> syntax error, unexpected ')' /home/dreamguysnew/public_html/application/controllers/Api.php 656
ERROR - 2017-12-22 06:18:38 --> Severity: Parsing Error --> syntax error, unexpected ')' /home/dreamguysnew/public_html/application/controllers/Api.php 656
