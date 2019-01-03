        <div class="main-wrapper">
        	<?php $this->load->view('nav_bar'); ?>            
        	<div class="page-wrapper">
        		<div class="content container-fluid">
        			<div class="row">
        				<div class="col-md-8 col-md-offset-2">
        					<form method="post" id="localization_form">
        						<h3 class="page-title"><?php lang('basic_settings'); ?></h3>
        						<div class="row">
        							<div class="col-sm-6">
        								<div class="form-group">
        									<label><?php lang('default_country'); ?></label>
        									<select class="form-control select2-option" name="country_id" id="country">
        										<option value="">Select Country</option>
        									</select>
        								</div>
        							</div>
        							<div class="col-sm-6">
        								<div class="form-group">
        									<label><?php lang('date_format'); ?></label>
        									<select class="form-control" name="date_format" id="date_format" >
        										<option value="">Select Date Format</option>
        										<option value="d/m/Y">15/05/2018</option>
        										<option value="d.m.Y">15.05.2018</option>
        										<option value="d-m-Y">15-05-2018</option>
        										<option value="m/d/Y">05/15/2018</option>
        										<option value="Y/m/d">2016/05/18</option>
        										<option value="Y-m-d">2016-05-18</option>
        										<option value="M d Y">May 15 2018</option>
        										<option value="d M Y">15 May 2018</option>
        									</select>
        								</div>
        							</div>
        							<div class="col-sm-6">
        								<div class="form-group">
        									<label><?php lang('time_zone') ?></label>
        									<select class="form-control select2-option" name="time_zone" id="time_zone" >
        										<option value="Pacific/Midway">Midway Island, Samoa (GMT-11:00)</option>
        										<option value="America/Adak">Hawaii-Aleutian (GMT-10:00)</option>
        										<option value="Etc/GMT+10">Hawaii (GMT-10:00)</option>
        										<option value="Pacific/Marquesas">Marquesas Islands (GMT-09:30)</option>
        										<option value="Pacific/Gambier">Gambier Islands (GMT-09:00)</option>
        										<option value="America/Anchorage">Alaska (GMT-09:00)</option>
        										<option value="America/Ensenada">Tijuana, Baja California (GMT-08:00)</option>
        										<option value="Etc/GMT+8">Pitcairn Islands (GMT-08:00)</option>
        										<option value="America/Los_Angeles">Pacific Time (US & Canada) (GMT-08:00)</option>
        										<option value="America/Denver">Mountain Time (US & Canada) (GMT-07:00)</option>
        										<option value="America/Chihuahua">Chihuahua, La Paz, Mazatlan (GMT-07:00)</option>
        										<option value="America/Dawson_Creek">Arizona (GMT-07:00)</option>
        										<option value="America/Belize">Saskatchewan, Central America (GMT-06:00)</option>
        										<option value="America/Cancun">Guadalajara, Mexico City, Monterrey (GMT-06:00)</option>
        										<option value="Chile/EasterIsland">Easter Island (GMT-06:00)</option>
        										<option value="America/Chicago">Central Time (US & Canada) (GMT-06:00)</option>
        										<option value="America/New_York">Eastern Time (US & Canada) (GMT-05:00)</option>
        										<option value="America/Havana">Cuba (GMT-05:00)</option>
        										<option value="America/Bogota">Bogota, Lima, Quito, Rio Branco (GMT-05:00)</option>
        										<option value="America/Caracas">Caracas (GMT-04:30)</option>
        										<option value="America/Santiago">Santiago (GMT-04:00)</option>
        										<option value="America/La_Paz">La Paz (GMT-04:00)</option>
        										<option value="Atlantic/Stanley">Faukland Islands (GMT-04:00)</option>
        										<option value="America/Campo_Grande">Brazil (GMT-04:00)</option>
        										<option value="America/Goose_Bay">Atlantic Time (Goose Bay) (GMT-04:00)</option>
        										<option value="America/Glace_Bay">Atlantic Time (Canada) (GMT-04:00)</option>
        										<option value="America/St_Johns">Newfoundland (GMT-03:30)</option>
        										<option value="America/Araguaina">UTC-3 (GMT-03:00)</option>
        										<option value="America/Montevideo">Montevideo (GMT-03:00)</option>
        										<option value="America/Miquelon">Miquelon, St. Pierre (GMT-03:00)</option>
        										<option value="America/Godthab">Greenland (GMT-03:00)</option>
        										<option value="America/Argentina/Buenos_Aires0) Buenos Aires ">(GMT-03:</option>
        										<option value="America/Sao_Paulo">Brasilia (GMT-03:00)</option>
        										<option value="America/Noronha">Mid-Atlantic (GMT-02:00)</option>
        										<option value="Atlantic/Cape_Verde">Cape Verde Is. (GMT-01:00)</option>
        										<option value="Atlantic/Azores">Azores (GMT-01:00)</option>
        										<option value="Europe/Belfast">Greenwich Mean Time : Belfast (GMT)</option>
        										<option value="Europe/Dublin">Greenwich Mean Time : Dublin (GMT)</option>
        										<option value="Europe/Lisbon">Greenwich Mean Time : Lisbon (GMT)</option>
        										<option value="Europe/London">Greenwich Mean Time : London (GMT)</option>
        										<option value="Africa/Abidjan">Monrovia, Reykjavik (GMT)</option>
        										<option value="Europe/Amsterdam">Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna (GMT+01:00)</option>
        										<option value="Europe/Belgrade">Belgrade, Bratislava, Budapest, Ljubljana, Prague (GMT+01:00)</option>
        										<option value="Europe/Brussels">Brussels, Copenhagen, Madrid, Paris (GMT+01:00)</option>
        										<option value="Africa/Algiers">West Central Africa (GMT+01:00)</option>
        										<option value="Africa/Windhoek">Windhoek (GMT+01:00)</option>
        										<option value="Asia/Beirut">Beirut (GMT+02:00)</option>
        										<option value="Africa/Cairo">Cairo (GMT+02:00)</option>
        										<option value="Asia/Gaza">Gaza (GMT+02:00)</option>
        										<option value="Africa/Blantyre">Harare, Pretoria (GMT+02:00)</option>
        										<option value="Asia/Jerusalem">Jerusalem (GMT+02:00)</option>
        										<option value="Europe/Minsk">Minsk (GMT+02:00)</option>
        										<option value="Asia/Damascus">Syria (GMT+02:00)</option>
        										<option value="Europe/Moscow">Moscow, St. Petersburg, Volgograd (GMT+03:00)</option>
        										<option value="Africa/Addis_Ababa">Nairobi (GMT+03:00)</option>
        										<option value="Asia/Tehran">Tehran (GMT+03:30)</option>
        										<option value="Asia/Dubai">Abu Dhabi, Muscat (GMT+04:00)</option>
        										<option value="Asia/Yerevan">Yerevan (GMT+04:00)</option>
        										<option value="Asia/Kabul">Kabul (GMT+04:30)</option>
        										<option value="Asia/Yekaterinburg">Ekaterinburg (GMT+05:00)</option>
        										<option value="Asia/Tashkent">Tashkent (GMT+05:00)</option>
        										<option value="Asia/Kolkata">Chennai, Kolkata, Mumbai, New Delhi (GMT+05:30)</option>
        										<option value="Asia/Katmandu">Kathmandu (GMT+05:45)</option>
        										<option value="Asia/Dhaka">Astana, Dhaka (GMT+06:00)</option>
        										<option value="Asia/Novosibirsk">Novosibirsk (GMT+06:00)</option>
        										<option value="Asia/Rangoon">Yangon (Rangoon) (GMT+06:30)</option>
        										<option value="Asia/Bangkok">Bangkok, Hanoi, Jakarta (GMT+07:00)</option>
        										<option value="Asia/Krasnoyarsk">Krasnoyarsk (GMT+07:00)</option>
        										<option value="Asia/Hong_Kong">Beijing, Chongqing, Hong Kong, Urumqi (GMT+08:00)</option>
        										<option value="Asia/Irkutsk">Irkutsk, Ulaan Bataar (GMT+08:00)</option>
        										<option value="Australia/Perth">Perth (GMT+08:00)</option>
        										<option value="Australia/Eucla">Eucla (GMT+08:45)</option>
        										<option value="Asia/Tokyo">Osaka, Sapporo, Tokyo (GMT+09:00)</option>
        										<option value="Asia/Seoul">Seoul (GMT+09:00)</option>
        										<option value="Asia/Yakutsk">Yakutsk (GMT+09:00)</option>
        										<option value="Australia/Adelaide">Adelaide (GMT+09:30)</option>
        										<option value="Australia/Darwin">Darwin (GMT+09:30)</option>
        										<option value="Australia/Brisbane">Brisbane (GMT+10:00)</option>
        										<option value="Australia/Hobart">Hobart (GMT+10:00)</option>
        										<option value="Asia/Vladivostok">Vladivostok (GMT+10:00)</option>
        										<option value="Australia/Lord_Howe">Lord Howe Island (GMT+10:30) </option>
        										<option value="Etc/GMT-11">Solomon Is., New Caledonia (GMT+11:00)</option>
        										<option value="Asia/Magadan">Magadan (GMT+11:00)</option>
        										<option value="Pacific/Norfolk">Norfolk Island (GMT+11:30)</option>
        										<option value="Asia/Anadyr">Anadyr, Kamchatka (GMT+12:00)</option>
        										<option value="Pacific/Auckland">(GMT+12:00) Auckland, Wellington</option>
        										<option value="Etc/GMT-12">Fiji, Kamchatka, Marshall Is. (GMT+12:00)</option>
        										<option value="Pacific/Chatham">Chatham Islands (GMT+12:45)</option>
        										<option value="Pacific/Tongatapu">Nuku'alofa (GMT+13:00)</option>
        										<option value="Pacific/Kiritimati">Kiritimati (GMT+14:00)</option>
        									</select>
        								</div>
        							</div>
        							<div class="col-sm-6">
        								<div class="form-group">
        									<label><?php lang('default_language') ?></label>
        									<select class="form-control" name="default_language" id="default_language">
        										<option value="">Select Language</option>
        										<option selected="selected">English</option>
        									</select>
        								</div>
        							</div>
									<!-- <div class="col-sm-6">
										<div class="form-group">
											<label><?php lang('currency_code') ?></label>
											<select class="select">
												<option selected="selected">USD</option>
												<option>Pound</option>
												<option>EURO</option>
												<option>Ringgit</option>
											</select>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label><?php lang('currency_symbol') ?></label>
											<input class="form-control" readonly value="$" type="text">
										</div>
									</div> -->
									<div class="row">
										<div class="col-sm-12 text-center m-t-20">
											<button type="submit" class="btn btn-primary"><?php lang('save_update') ?></button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<!-- Notifications -->
				<?php $this->load->view('notifications'); ?>
				<!-- Notifications -->
			</div>
		</div>
		