<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2017-12-16 10:00:02 --> Severity: error --> Exception: DateTimeZone::__construct(): Unknown or bad timezone () /home/dreamguysnew/public_html/application/controllers/User.php 1202
ERROR - 2017-12-16 10:01:08 --> Severity: error --> Exception: DateTimeZone::__construct(): Unknown or bad timezone () /home/dreamguysnew/public_html/application/controllers/User.php 1202
ERROR - 2017-12-16 10:01:32 --> Severity: error --> Exception: DateTimeZone::__construct(): Unknown or bad timezone () /home/dreamguysnew/public_html/application/controllers/User.php 1202
ERROR - 2017-12-16 10:01:45 --> Severity: error --> Exception: DateTimeZone::__construct(): Unknown or bad timezone () /home/dreamguysnew/public_html/application/controllers/User.php 1202
ERROR - 2017-12-16 07:30:12 --> Severity: Warning --> filesize(): stat failed for /tmp/ci_sessionv2gb1hdbusm9ifc67r595dvmrlt92105 /home/dreamguysnew/public_html/system/libraries/Session/drivers/Session_files_driver.php 208
ERROR - 2017-12-16 09:46:02 --> Severity: Error --> Call to undefined method Applicant_modal::get_datatables() /home/dreamguysnew/public_html/application/controllers/Applicant.php 23
ERROR - 2017-12-16 09:47:01 --> Severity: Error --> Call to undefined method Applicant_modal::get_datatables() /home/dreamguysnew/public_html/application/controllers/Applicant.php 23
ERROR - 2017-12-16 10:03:18 --> Severity: Error --> Call to undefined method Applicant_modal::get_datatables() /home/dreamguysnew/public_html/application/controllers/Applicant.php 23
ERROR - 2017-12-16 10:48:44 --> Severity: Error --> Call to undefined method Applicant_modal::get_datatables() /home/dreamguysnew/public_html/application/controllers/Applicant.php 23
ERROR - 2017-12-16 11:19:02 --> Severity: Error --> Call to undefined method Applicant_modal::get_datatables() /home/dreamguysnew/public_html/application/controllers/Applicant.php 23
ERROR - 2017-12-16 16:49:10 --> Severity: error --> Exception: DateTimeZone::__construct(): Unknown or bad timezone () /home/dreamguysnew/public_html/application/controllers/User.php 1202
ERROR - 2017-12-16 11:19:49 --> Severity: Error --> Call to undefined method Applicant_modal::get_datatables() /home/dreamguysnew/public_html/application/controllers/Applicant.php 23
ERROR - 2017-12-16 11:19:54 --> Severity: Error --> Call to undefined method Applicant_modal::get_datatables() /home/dreamguysnew/public_html/application/controllers/Applicant.php 23
ERROR - 2017-12-16 11:20:02 --> Severity: Error --> Call to undefined method Applicant_modal::get_datatables() /home/dreamguysnew/public_html/application/controllers/Applicant.php 23
ERROR - 2017-12-16 18:10:50 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and msg.read_status=0 and msg.delete_sts=0' at line 3 - Invalid query: select DISTINCT CONCAT(sender.first_name,' ',sender.last_name) as senderName, sender.profile_img as senderImage, sender.id as sender_id, CONCAT(receiver.first_name,' ',receiver.last_name) as receiverName, receiver.profile_img as receiverImage, receiver.id as receiver_id, receiver.username,msg.msg, msg.chatdate
      from chat msg inner join applicants sender on msg.sent_id = sender.id
      inner join applicants receiver on msg.recieved_id = receiver.id WHERE msg.recieved_id=66 and msg.sent_id= and msg.read_status=0 and msg.delete_sts=0 
