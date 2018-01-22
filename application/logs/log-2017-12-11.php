<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2017-12-11 09:59:42 --> Query error: Invalid utf8 character string: '\x8Af\xA0z' - Invalid query:  SELECT applicants.first_name,applicants.last_name ,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,applicants.role,country_list.country_name,country_list.code,applicants_profile.*,s.picture_url FROM  applicants
LEFT JOIN `applicants_profile` ON applicants.id = applicants_profile.applicant_id
LEFT JOIN social_applicant_user s ON s.reference_id = applicants.id
 LEFT JOIN country_list ON country_list.country_id = applicants_profile.country
  WHERE applicants.id = Šf z
ERROR - 2017-12-11 09:59:50 --> Query error: Invalid utf8 character string: '\x8Af\xA0z' - Invalid query: SELECT applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,applicants.role,country_list.country_name,country_list.code,mentor_details.*,s.picture_url FROM `applicants` 
                                    LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
                                    LEFT JOIN social_applicant_user s ON s.reference_id = applicants.id
                                    LEFT JOIN country_list ON country_list.country_id = mentor_details.country
                                    WHERE applicants.id =  Šf z
ERROR - 2017-12-11 10:00:12 --> Query error: Invalid utf8 character string: '\x8Af\xA0z' - Invalid query:  SELECT applicants.first_name,applicants.last_name ,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,applicants.role,country_list.country_name,country_list.code,applicants_profile.*,s.picture_url FROM  applicants
LEFT JOIN `applicants_profile` ON applicants.id = applicants_profile.applicant_id
LEFT JOIN social_applicant_user s ON s.reference_id = applicants.id
 LEFT JOIN country_list ON country_list.country_id = applicants_profile.country
  WHERE applicants.id = Šf z
ERROR - 2017-12-11 10:02:16 --> Query error: Invalid utf8 character string: '\x8Af\xA0z' - Invalid query: SELECT applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,applicants.role,country_list.country_name,country_list.code,mentor_details.*,s.picture_url FROM `applicants` 
                                    LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
                                    LEFT JOIN social_applicant_user s ON s.reference_id = applicants.id
                                    LEFT JOIN country_list ON country_list.country_id = mentor_details.country
                                    WHERE applicants.id =  Šf z
ERROR - 2017-12-11 10:02:25 --> Query error: Invalid utf8 character string: '\x8Af\xA0z' - Invalid query:  SELECT applicants.first_name,applicants.last_name ,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,applicants.role,country_list.country_name,country_list.code,applicants_profile.*,s.picture_url FROM  applicants
LEFT JOIN `applicants_profile` ON applicants.id = applicants_profile.applicant_id
LEFT JOIN social_applicant_user s ON s.reference_id = applicants.id
 LEFT JOIN country_list ON country_list.country_id = applicants_profile.country
  WHERE applicants.id = Šf z
ERROR - 2017-12-11 10:03:04 --> Query error: Invalid utf8 character string: '\x8Af\xA0z' - Invalid query: SELECT applicants.first_name,applicants.last_name,applicants.username,applicants.email,applicants.profile_img,applicants.is_verified,applicants.role,country_list.country_name,country_list.code,mentor_details.*,s.picture_url FROM `applicants` 
                                    LEFT JOIN mentor_details ON mentor_details.mentor_id = applicants.id
                                    LEFT JOIN social_applicant_user s ON s.reference_id = applicants.id
                                    LEFT JOIN country_list ON country_list.country_id = mentor_details.country
                                    WHERE applicants.id =  Šf z
