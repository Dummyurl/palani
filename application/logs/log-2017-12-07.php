<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2017-12-07 13:00:20 --> Query error: Invalid utf8 character string: '\x8Af\xA0z' - Invalid query: SELECT applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,applicants.role,country_list.country_name,country_list.code,mentor_details.*,s.picture_url FROM `applicants` 
                                    LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
                                    LEFT JOIN social_applicant_user s ON s.reference_id = applicants.id
                                    LEFT JOIN country_list ON country_list.country_id = mentor_details.country
                                    WHERE applicants.id =  Šf z
ERROR - 2017-12-07 13:00:25 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 5 - Invalid query:  SELECT applicants.first_name,applicants.last_name ,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,applicants.role,country_list.country_name,country_list.code,applicants_profile.*,s.picture_url FROM  applicants
LEFT JOIN `applicants_profile` ON applicants.id = applicants_profile.applicant_id
LEFT JOIN social_applicant_user s ON s.reference_id = applicants.id
 LEFT JOIN country_list ON country_list.country_id = applicants_profile.country
  WHERE applicants.id = 
ERROR - 2017-12-07 13:00:40 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 5 - Invalid query:  SELECT applicants.first_name,applicants.last_name ,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,applicants.role,country_list.country_name,country_list.code,applicants_profile.*,s.picture_url FROM  applicants
LEFT JOIN `applicants_profile` ON applicants.id = applicants_profile.applicant_id
LEFT JOIN social_applicant_user s ON s.reference_id = applicants.id
 LEFT JOIN country_list ON country_list.country_id = applicants_profile.country
  WHERE applicants.id = 
ERROR - 2017-12-07 13:00:58 --> Query error: Invalid utf8 character string: '\x8Af\xA0z' - Invalid query:  SELECT applicants.first_name,applicants.last_name ,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,applicants.role,country_list.country_name,country_list.code,applicants_profile.*,s.picture_url FROM  applicants
LEFT JOIN `applicants_profile` ON applicants.id = applicants_profile.applicant_id
LEFT JOIN social_applicant_user s ON s.reference_id = applicants.id
 LEFT JOIN country_list ON country_list.country_id = applicants_profile.country
  WHERE applicants.id = Šf z
ERROR - 2017-12-07 07:34:31 --> Severity: Parsing Error --> syntax error, unexpected end of file /home/dreamguysnew/public_html/application/controllers/User.php 46
ERROR - 2017-12-07 13:04:37 --> Query error: Invalid utf8 character string: '\x8Af\xA0z' - Invalid query: SELECT applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,applicants.role,country_list.country_name,country_list.code,mentor_details.*,s.picture_url FROM `applicants` 
                                    LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
                                    LEFT JOIN social_applicant_user s ON s.reference_id = applicants.id
                                    LEFT JOIN country_list ON country_list.country_id = mentor_details.country
                                    WHERE applicants.id =  Šf z
ERROR - 2017-12-07 13:04:43 --> Query error: Invalid utf8 character string: '\x8Af\xA0z' - Invalid query:  SELECT applicants.first_name,applicants.last_name ,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,applicants.role,country_list.country_name,country_list.code,applicants_profile.*,s.picture_url FROM  applicants
LEFT JOIN `applicants_profile` ON applicants.id = applicants_profile.applicant_id
LEFT JOIN social_applicant_user s ON s.reference_id = applicants.id
 LEFT JOIN country_list ON country_list.country_id = applicants_profile.country
  WHERE applicants.id = Šf z
ERROR - 2017-12-07 13:05:08 --> Query error: Invalid utf8 character string: '\x8Af\xA0z' - Invalid query: SELECT applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,applicants.role,country_list.country_name,country_list.code,mentor_details.*,s.picture_url FROM `applicants` 
                                    LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
                                    LEFT JOIN social_applicant_user s ON s.reference_id = applicants.id
                                    LEFT JOIN country_list ON country_list.country_id = mentor_details.country
                                    WHERE applicants.id =  Šf z
ERROR - 2017-12-07 15:48:30 --> Severity: error --> Exception: DateTimeZone::__construct(): Unknown or bad timezone () /home/dreamguysnew/public_html/application/views/home/applicant/dashboard_activity_search_list.php 9
