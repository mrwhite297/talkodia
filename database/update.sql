-- ------------------
-- BR_RV-3.0.0_HOT_FIX
-- ------------------

ALTER TABLE `tbl_zoom_users` ADD `zmusr_zoom_type` INT NOT NULL AFTER `zmusr_zoom_id`;
UPDATE `tbl_zoom_users` SET `zmusr_zoom_type` = '1';
INSERT INTO `tbl_email_templates` (`etpl_code`, `etpl_lang_id`, `etpl_name`, `etpl_subject`, `etpl_body`, `etpl_vars`, `etpl_status`, `etpl_quick_send`) VALUES 
('license_alert', '1', '{meeting_tool} License Alert', '{meeting_tool} license alert {website_name}', '<table width=\"600\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">    \r\n	<tbody>        \r\n		<tr>            \r\n			<td style=\"background:#fff;padding:0 40px; text-align:center; color:#999;vertical-align:top; border-bottom:1px solid #eee;\"><span style=\"font-size: 30px; font-weight: bold;\">License Alert</span></td>        \r\n		</tr>        \r\n		<tr>            \r\n			<td style=\"background:#fff;padding:0 40px; text-align:center; color:#999;vertical-align:top; border-bottom:1px solid #eee; \">                \r\n				<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" align=\"center\">                    \r\n					<tbody>                        \r\n						<tr>                            \r\n							<td style=\"padding:40px 0 60px;\">                                \r\n								<h3 style=\"margin: 0 0 10px;font-size: 24px; font-weight: 500; padding: 0;color: #333;text-align:center;\">Dear Admin</h3>                                \r\n								<p style=\"line-height: 20px;\"><span style=\"color: rgb(103, 103, 103); font-size: 14px;\">This is an update regarding sessions on the platform. Meeting tool licenses available on the platform are less than the classes scheduled simultaneously. Please find details of the classes below:</span></p>\r\n								<table style=\"border:1px solid #ddd; border-collapse:collapse; width:100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\r\n									<tbody>\r\n										<tr>\r\n											<td style=\"padding:10px;font-size:13px;border:1px solid #ddd; color:#333; font-weight:bold;\" width=\"40%\">Start Time</td>\r\n											<td style=\"padding:10px;font-size:13px; color:#333;border:1px solid #ddd;\" width=\"60%\">{start_time}</td>\r\n										</tr>                                      \r\n										<tr>\r\n											<td style=\"padding:10px;font-size:13px;border:1px solid #ddd; color:#333; font-weight:bold;\" width=\"40%\">End Time</td>\r\n											<td style=\"padding:10px;font-size:13px; color:#333;border:1px solid #ddd;\" width=\"60%\">{end_time}</td>\r\n										</tr>                                      \r\n										<tr>\r\n											<td style=\"padding:10px;font-size:13px;border:1px solid #ddd; color:#333; font-weight:bold;\" width=\"40%\">Scheduled Sessions&nbsp;</td>\r\n											<td style=\"padding:10px;font-size:13px; color:#333;border:1px solid #ddd;\" width=\"60%\">{session_count}</td>\r\n										</tr>  \r\n									</tbody>\r\n								</table></td>\r\n						</tr>\r\n					</tbody>\r\n				</table>            </td>        \r\n		</tr>    \r\n	</tbody>\r\n</table>', '{start_time} class Start Time <br>{end_time} class End Time <br>{session_count} Total Scheduled Sessions count', '1', '0'),
('license_alert', '2', '{meeting_tool} License Alert', '{meeting_tool} license alert {website_name}', '<table width=\"600\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">    \r\n	<tbody>        \r\n		<tr>            \r\n			<td style=\"background:#fff;padding:0 40px; text-align:center; color:#999;vertical-align:top; border-bottom:1px solid #eee;\"><span style=\"font-size: 30px; font-weight: bold;\">License Alert</span></td>        \r\n		</tr>        \r\n		<tr>            \r\n			<td style=\"background:#fff;padding:0 40px; text-align:center; color:#999;vertical-align:top; border-bottom:1px solid #eee; \">                \r\n				<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" align=\"center\">                    \r\n					<tbody>                        \r\n						<tr>                            \r\n							<td style=\"padding:40px 0 60px;\">                                \r\n								<h3 style=\"margin: 0 0 10px;font-size: 24px; font-weight: 500; padding: 0;color: #333;text-align:center;\">Dear Admin</h3>                                \r\n								<p style=\"line-height: 20px;\"><span style=\"color: rgb(103, 103, 103); font-size: 14px;\">This is an update regarding sessions on the platform. Meeting tool licenses available on the platform are less than the classes scheduled simultaneously. Please find details of the classes below:</span></p>\r\n								<table style=\"border:1px solid #ddd; border-collapse:collapse; width:100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\r\n									<tbody>\r\n										<tr>\r\n											<td style=\"padding:10px;font-size:13px;border:1px solid #ddd; color:#333; font-weight:bold;\" width=\"40%\">Start Time</td>\r\n											<td style=\"padding:10px;font-size:13px; color:#333;border:1px solid #ddd;\" width=\"60%\">{start_time}</td>\r\n										</tr>                                      \r\n										<tr>\r\n											<td style=\"padding:10px;font-size:13px;border:1px solid #ddd; color:#333; font-weight:bold;\" width=\"40%\">End Time</td>\r\n											<td style=\"padding:10px;font-size:13px; color:#333;border:1px solid #ddd;\" width=\"60%\">{end_time}</td>\r\n										</tr>                                      \r\n										<tr>\r\n											<td style=\"padding:10px;font-size:13px;border:1px solid #ddd; color:#333; font-weight:bold;\" width=\"40%\">Scheduled Sessions&nbsp;</td>\r\n											<td style=\"padding:10px;font-size:13px; color:#333;border:1px solid #ddd;\" width=\"60%\">{session_count}</td>\r\n										</tr>  \r\n									</tbody>\r\n								</table></td>\r\n						</tr>\r\n					</tbody>\r\n				</table>            </td>        \r\n		</tr>    \r\n	</tbody>\r\n</table>', '{start_time} class Start Time <br>{end_time} class End Time <br>{session_count} Total Scheduled Sessions count', '1', '0');
INSERT INTO `tbl_configurations` (`conf_name`, `conf_val`, `conf_common`) VALUES ('CONF_ZOOM_FREE_MEETING_DURATION', '45', '');
INSERT INTO `tbl_cron_schedules` (`cron_id`, `cron_name`, `cron_command`, `cron_duration`, `cron_active`) VALUES (NULL, 'shuffle/revoke Zoom License', 'shuffleZoomLicense', '1', '1');

UPDATE tbl_extra_pages_lang SET epage_content = REPLACE(epage_content, "https://teach.yo-coach.com/images/55x55_1.png", "images/55x55_1.png");
UPDATE tbl_extra_pages_lang SET epage_content = REPLACE(epage_content, "https://teach.yo-coach.com/images/55x55_2.png", "images/55x55_2.png");
UPDATE tbl_extra_pages_lang SET epage_content = REPLACE(epage_content, "https://teach.yo-coach.com/images/55x55_3.png", "images/55x55_3.png");
UPDATE tbl_extra_pages_lang SET epage_content = REPLACE(epage_content, "https://teach.yo-coach.com/images/55x55_4.png", "images/55x55_4.png");
UPDATE tbl_extra_pages_lang SET epage_content = REPLACE(epage_content, "https://teach.yo-coach.com/images/55x55_5.png", "images/55x55_5.png");
UPDATE tbl_extra_pages_lang SET epage_content = REPLACE(epage_content, "https://teach.yo-coach.com/images/55x55_6.png", "images/55x55_6.png");
UPDATE tbl_extra_pages_lang SET epage_content = REPLACE(epage_content, "https://teach.yo-coach.com/images/120x120_3.png", "images/120x120_3.png");
UPDATE tbl_extra_pages_lang SET epage_content = REPLACE(epage_content, "https://teach.yo-coach.com/images/120x120_4.png", "images/120x120_4.png");
UPDATE tbl_content_pages_block_lang SET cpblocklang_text = REPLACE(cpblocklang_text, "https://yocoach3.bestech.4qcteam.com/image/editor-image/1650025272-mission.png", "image/editor-image/1650025272-mission.png");
UPDATE tbl_content_pages_block_lang SET cpblocklang_text = REPLACE(cpblocklang_text, "https://yocoach3.bestech.4qcteam.com/image/editor-image/1650025364-vision.png", "image/editor-image/1650025364-vision.png");
UPDATE tbl_content_pages_block_lang SET cpblocklang_text = REPLACE(cpblocklang_text, "https://yocoach3.bestech.4qcteam.com/image/editor-image/1650349417-ceo364x364.png", "image/editor-image/1650349417-ceo364x364.png");
UPDATE tbl_content_pages_block_lang SET cpblocklang_text = REPLACE(cpblocklang_text, "https://yocoach3.bestech.4qcteam.com/image/editor-image/1650349567-marketinghead364x3641.png", "image/editor-image/1650349567-marketinghead364x3641.png");
UPDATE tbl_content_pages_block_lang SET cpblocklang_text = REPLACE(cpblocklang_text, "https://yocoach3.bestech.4qcteam.com/image/editor-image/1650349739-creativedirector364x3642.png", "image/editor-image/1650349739-creativedirector364x3642.png");
UPDATE tbl_content_pages_block_lang SET cpblocklang_text = REPLACE(cpblocklang_text, "https://yocoach3.bestech.4qcteam.com/image/editor-image/1650349751-techlead364x3643.png", "image/editor-image/1650349751-techlead364x3643.png");
UPDATE tbl_content_pages_block_lang SET cpblocklang_text = REPLACE(cpblocklang_text, "https://yocoach3.bestech.4qcteam.com/image/editor-image/1650349756-saleshead364x3644.png", "image/editor-image/1650349756-saleshead364x3644.png");
UPDATE tbl_content_pages_block_lang SET cpblocklang_text = REPLACE(cpblocklang_text, "https://yocoach3.bestech.4qcteam.com/image/editor-image/1650349761-creativedirector2364x3645.png", "image/editor-image/1650349761-creativedirector2364x3645.png");
UPDATE tbl_content_pages_block_lang SET cpblocklang_text = REPLACE(cpblocklang_text, "https://yocoach3.bestech.4qcteam.com/image/editor-image/1650021362-search.png", "image/editor-image/1650021362-search.png");
UPDATE tbl_content_pages_block_lang SET cpblocklang_text = REPLACE(cpblocklang_text, "https://yocoach3.bestech.4qcteam.com/image/editor-image/1650021522-Book.png", "image/editor-image/1650021522-Book.png");
UPDATE tbl_content_pages_block_lang SET cpblocklang_text = REPLACE(cpblocklang_text, "https://yocoach3.bestech.4qcteam.com/image/editor-image/1650021648-learn.png", "image/editor-image/1650021648-learn.png");
UPDATE tbl_content_pages_block_lang SET cpblocklang_text = REPLACE(cpblocklang_text, "https://yocoach3.bestech.4qcteam.com/image/editor-image/1650351210-translater.png", "image/editor-image/1650351210-translater.png");
UPDATE tbl_content_pages_block_lang SET cpblocklang_text = REPLACE(cpblocklang_text, "https://yocoach3.bestech.4qcteam.com/image/editor-image/1650351215-teacher.png", "image/editor-image/1650351215-teacher.png");
UPDATE tbl_content_pages_block_lang SET cpblocklang_text = REPLACE(cpblocklang_text, "https://yocoach3.bestech.4qcteam.com/image/editor-image/1650351220-learner.png", "image/editor-image/1650351220-learner.png");
UPDATE tbl_content_pages_block_lang SET cpblocklang_text = REPLACE(cpblocklang_text, "https://yocoach3.bestech.4qcteam.com/admin/content-pages", "/teachers");

ALTER TABLE `tbl_coupons`  DROP `coupon_deleted`;

INSERT INTO `tbl_cron_schedules` (`cron_id`, `cron_name`, `cron_command`, `cron_duration`, `cron_active`) VALUES
(null, 'Send Wallet Balance maintain Reminder for subscription before one day ', 'sendWalletBalanceReminder/2', 1, 1),
(null, 'Send Wallet Balance maintain Reminder for subscription before 3 day', 'sendWalletBalanceReminder/3', 1, 1),
(null, 'Send Wallet Balance maintain Reminder for subscription before 7 day', 'sendWalletBalanceReminder/4', 1, 1);
ALTER TABLE `tbl_email_archives` ADD `earch_attempted` DATETIME NULL AFTER `earch_attachemnts`;

DELETE FROM `tbl_language_labels` WHERE `label_key` LIKE 'NOTIFI_DESC_TYPE_REDEEM_GIFTCARD';
INSERT INTO `tbl_language_labels` (`label_lang_id`, `label_key`, `label_caption`) VALUES
(1, 'NOTIFI_DESC_TYPE_REDEEM_GIFTCARD', 'Receiver have redeemed gift card.'),
(2, 'NOTIFI_DESC_TYPE_REDEEM_GIFTCARD', 'قام المستلم باسترداد بطاقة الهدايا.');

-- -----------------------
-- After 15 September 2022
-- -----------------------
UPDATE `tbl_navigation_links` SET `nlink_url` = '{siteroot}blog/contribution-form' WHERE `tbl_navigation_links`.`nlink_id` = 76;
DELETE FROM `tbl_language_labels` WHERE `label_key` LIKE 'MSG_LEARNER_FAILURE_ORDER_{CONTACTURL}';
INSERT INTO `tbl_language_labels` (`label_lang_id`, `label_key`, `label_caption`) VALUES
(1, 'LBL_TEACHER_PRICING', 'Pricing'),(2, 'LBL_TEACHER_PRICING', 'التسعير');

-- -----------------------
-- 30 September 2022
-- -----------------------
UPDATE tbl_email_templates SET etpl_vars = "{user_full_name} Full Name of the email receiver" WHERE etpl_code = "forgot_password";
-- -----------------------
-- 10 October 2022
-- -----------------------
DELETE FROM `tbl_attached_files` WHERE `file_type` IN (39,40,41);