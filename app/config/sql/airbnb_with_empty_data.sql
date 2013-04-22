-- phpMyAdmin SQL Dump
-- version 2.11.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 11, 2012 at 11:42 AM
-- Server version: 5.0.51
-- PHP Version: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `airbnb`
--

-- --------------------------------------------------------

--
-- Table structure for table `adaptive_ipn_logs`
--

DROP TABLE IF EXISTS `adaptive_ipn_logs`;
CREATE TABLE IF NOT EXISTS `adaptive_ipn_logs` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `ip` varchar(50) collate utf8_unicode_ci default NULL,
  `post_variable` text collate utf8_unicode_ci,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `adaptive_ipn_logs`
--


-- --------------------------------------------------------

--
-- Table structure for table `adaptive_transaction_logs`
--

DROP TABLE IF EXISTS `adaptive_transaction_logs`;
CREATE TABLE IF NOT EXISTS `adaptive_transaction_logs` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `class` varchar(50) collate utf8_unicode_ci default NULL,
  `foreign_id` bigint(20) NOT NULL,
  `transaction_id` varchar(50) collate utf8_unicode_ci default NULL,
  `amount` float(10,2) NOT NULL,
  `email` varchar(100) collate utf8_unicode_ci default NULL,
  `primary` varchar(20) collate utf8_unicode_ci default NULL,
  `invoice_id` varchar(100) collate utf8_unicode_ci default NULL,
  `refunded_amount` double(10,2) default NULL,
  `pending_refund` varchar(20) collate utf8_unicode_ci default NULL,
  `sender_transaction_id` varchar(100) collate utf8_unicode_ci default NULL,
  `sender_transaction_status` varchar(50) collate utf8_unicode_ci default NULL,
  `timestamp` varchar(100) collate utf8_unicode_ci default NULL,
  `ack` varchar(100) collate utf8_unicode_ci default NULL,
  `correlation_id` varchar(100) collate utf8_unicode_ci default NULL,
  `build` varchar(50) collate utf8_unicode_ci default NULL,
  `currency_code` varchar(10) collate utf8_unicode_ci default NULL,
  `sender_email` varchar(100) collate utf8_unicode_ci default NULL,
  `status` varchar(100) collate utf8_unicode_ci default NULL,
  `tracking_id` varchar(100) collate utf8_unicode_ci default NULL,
  `pay_key` varchar(50) collate utf8_unicode_ci default NULL,
  `action_type` varchar(50) collate utf8_unicode_ci default NULL,
  `fees_payer` varchar(100) collate utf8_unicode_ci default NULL,
  `memo` text collate utf8_unicode_ci,
  `reverse_all_parallel_payments_on_error` varchar(50) collate utf8_unicode_ci default NULL,
  `refund_status` varchar(100) collate utf8_unicode_ci default NULL,
  `refund_net_amount` double(10,2) default NULL,
  `refund_fee_amount` double(10,2) default NULL,
  `refund_gross_amount` double(10,2) default NULL,
  `total_of_alll_refunds` double(10,2) default NULL,
  `refund_has_become_full` varchar(100) collate utf8_unicode_ci default NULL,
  `encrypted_refund_transaction_id` varchar(100) collate utf8_unicode_ci default NULL,
  `refund_transaction_status` varchar(100) collate utf8_unicode_ci default NULL,
  `paypal_post_vars` text collate utf8_unicode_ci,
  PRIMARY KEY  (`id`),
  KEY `transaction_id` (`transaction_id`),
  KEY `class` (`class`),
  KEY `foreign_id` (`foreign_id`),
  KEY `invoice_id` (`invoice_id`),
  KEY `sender_transaction_id` (`sender_transaction_id`),
  KEY `correlation_id` (`correlation_id`),
  KEY `tracking_id` (`tracking_id`),
  KEY `encrypted_refund_transaction_id` (`encrypted_refund_transaction_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `adaptive_transaction_logs`
--


-- --------------------------------------------------------

--
-- Table structure for table `affiliates`
--

DROP TABLE IF EXISTS `affiliates`;
CREATE TABLE IF NOT EXISTS `affiliates` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `class` varchar(255) collate utf8_unicode_ci default NULL,
  `foreign_id` bigint(20) unsigned NOT NULL,
  `affiliate_type_id` bigint(20) unsigned NOT NULL,
  `affliate_user_id` bigint(20) NOT NULL,
  `affiliate_status_id` bigint(20) NOT NULL,
  `commission_amount` double(10,2) NOT NULL,
  `commission_holding_start_date` date default NULL,
  PRIMARY KEY  (`id`),
  KEY `affiliate_type_id` (`affiliate_type_id`),
  KEY `affliate_user_id` (`affliate_user_id`),
  KEY `affiliate_status_id` (`affiliate_status_id`),
  KEY `class` (`class`),
  KEY `foreign_id` (`foreign_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='affiliate detailes';

--
-- Dumping data for table `affiliates`
--


-- --------------------------------------------------------

--
-- Table structure for table `affiliate_cash_withdrawals`
--

DROP TABLE IF EXISTS `affiliate_cash_withdrawals`;
CREATE TABLE IF NOT EXISTS `affiliate_cash_withdrawals` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `affiliate_cash_withdrawal_status_id` bigint(20) NOT NULL,
  `amount` double(10,2) NOT NULL,
  `commission_amount` double(10,2) default '0.00',
  `payment_gateway_id` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `affiliate_cash_withdrawal_status_id` (`affiliate_cash_withdrawal_status_id`),
  KEY `payment_gateway_id` (`payment_gateway_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `affiliate_cash_withdrawals`
--


-- --------------------------------------------------------

--
-- Table structure for table `affiliate_cash_withdrawal_statuses`
--

DROP TABLE IF EXISTS `affiliate_cash_withdrawal_statuses`;
CREATE TABLE IF NOT EXISTS `affiliate_cash_withdrawal_statuses` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `affiliate_cash_withdrawal_statuses`
--

INSERT INTO `affiliate_cash_withdrawal_statuses` (`id`, `created`, `modified`, `name`) VALUES
(1, '0000-00-00 00:00:00', '2011-02-15 05:23:16', 'Pending'),
(2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Under Process'),
(3, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Rejected'),
(4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Payment Failure'),
(5, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Paid');

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_commission_types`
--

DROP TABLE IF EXISTS `affiliate_commission_types`;
CREATE TABLE IF NOT EXISTS `affiliate_commission_types` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` varchar(255) collate utf8_unicode_ci default NULL,
  `description` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `affiliate_commission_types`
--

INSERT INTO `affiliate_commission_types` (`id`, `name`, `description`) VALUES
(1, '%', 'Percentage'),
(2, '$', 'Amount');

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_requests`
--

DROP TABLE IF EXISTS `affiliate_requests`;
CREATE TABLE IF NOT EXISTS `affiliate_requests` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `site_name` varchar(255) collate utf8_unicode_ci default NULL,
  `site_description` text collate utf8_unicode_ci,
  `site_url` varchar(255) collate utf8_unicode_ci default NULL,
  `site_category_id` bigint(20) default NULL,
  `why_do_you_want_affiliate` text collate utf8_unicode_ci,
  `is_web_site_marketing` tinyint(1) default '0',
  `is_search_engine_marketing` tinyint(1) default '0',
  `is_email_marketing` tinyint(1) default '0',
  `special_promotional_method` varchar(255) collate utf8_unicode_ci default NULL,
  `special_promotional_description` text collate utf8_unicode_ci,
  `is_approved` tinyint(2) default '0',
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `site_category_id` (`site_category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `affiliate_requests`
--


-- --------------------------------------------------------

--
-- Table structure for table `affiliate_statuses`
--

DROP TABLE IF EXISTS `affiliate_statuses`;
CREATE TABLE IF NOT EXISTS `affiliate_statuses` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` date NOT NULL,
  `modified` date NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='affliate status details';

--
-- Dumping data for table `affiliate_statuses`
--

INSERT INTO `affiliate_statuses` (`id`, `created`, `modified`, `name`) VALUES
(1, '2011-02-08', '2011-02-08', 'Pending'),
(2, '2011-02-08', '2011-02-08', 'Canceled '),
(3, '2011-02-08', '2011-02-08', 'Pipeline'),
(4, '0000-00-00', '0000-00-00', 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_types`
--

DROP TABLE IF EXISTS `affiliate_types`;
CREATE TABLE IF NOT EXISTS `affiliate_types` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci default NULL,
  `model_name` varchar(255) collate utf8_unicode_ci default NULL,
  `commission` double(10,2) default '0.00',
  `affiliate_commission_type_id` bigint(20) NOT NULL,
  `is_active` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `affiliate_commission_type_id` (`affiliate_commission_type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='affiliate types';

--
-- Dumping data for table `affiliate_types`
--

INSERT INTO `affiliate_types` (`id`, `created`, `modified`, `name`, `model_name`, `commission`, `affiliate_commission_type_id`, `is_active`) VALUES
(1, '2011-02-08 00:00:00', '2011-02-08 00:00:00', 'Sign Up', 'User', 0.00, 2, 1),
(2, '2011-02-08 00:00:00', '2011-02-08 00:00:00', 'Booking', 'PropertyUser', 10.00, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `amenities`
--

DROP TABLE IF EXISTS `amenities`;
CREATE TABLE IF NOT EXISTS `amenities` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `name` varchar(255) collate utf8_unicode_ci default NULL,
  `slug` varchar(265) collate utf8_unicode_ci default NULL,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `slug` (`slug`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Amenities details';

--
-- Dumping data for table `amenities`
--

INSERT INTO `amenities` (`id`, `created`, `modified`, `name`, `slug`, `is_active`) VALUES
(1, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'Smoking Allowed', 'smoking-allowed', 1),
(2, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'Pets Allowed', 'pets-allowed', 1),
(3, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'TV', 'tv', 1),
(4, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'Cable TV', 'cable-tv', 1),
(5, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'Internet', 'internet', 1),
(6, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'Wireless Internet', 'wireless-internet', 1),
(7, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'Air Conditioning', 'air-conditioning', 1),
(8, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'Heating', 'heating', 1),
(9, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'Elevator in Building', 'elevator-in-building', 1),
(10, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'Handicap Accessible', 'handicap-accessible', 1),
(11, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'Pool ', 'pool ', 1),
(12, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'Kitchen', 'kitchen', 1),
(13, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'Parking Included', 'parking-included', 1),
(14, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'Washer / Dryer', 'washer-dryer', 1),
(15, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'Doorman', 'doorman', 1),
(16, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'Gym', 'gym', 1),
(17, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'Hot Tub', 'hot-tub', 1),
(18, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'Indoor Fireplace', 'indoor-fireplace', 1),
(19, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'Buzzer/Wireless Intercom', 'buzzer-wireless-intercom', 1),
(20, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'Breakfast ', 'breakfast ', 1),
(21, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'Family/Kid Friendly', 'family-kid-friendly', 1),
(22, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'Suitable for Events ', 'suitable-for-events ', 1);

-- --------------------------------------------------------

--
-- Table structure for table `amenities_properties`
--

DROP TABLE IF EXISTS `amenities_properties`;
CREATE TABLE IF NOT EXISTS `amenities_properties` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `amenity_id` int(5) NOT NULL,
  `property_id` int(5) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `amenity_id` (`amenity_id`),
  KEY `property_id` (`property_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `amenities_properties`
--


-- --------------------------------------------------------

--
-- Table structure for table `amenities_requests`
--

DROP TABLE IF EXISTS `amenities_requests`;
CREATE TABLE IF NOT EXISTS `amenities_requests` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `amenity_id` int(5) NOT NULL,
  `request_id` int(5) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `amenity_id` (`amenity_id`),
  KEY `request_id` (`request_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `amenities_requests`
--


-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

DROP TABLE IF EXISTS `attachments`;
CREATE TABLE IF NOT EXISTS `attachments` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `class` varchar(100) collate utf8_unicode_ci default NULL,
  `foreign_id` bigint(20) unsigned NOT NULL,
  `filename` varchar(255) collate utf8_unicode_ci default NULL,
  `dir` varchar(100) collate utf8_unicode_ci default NULL,
  `mimetype` varchar(100) collate utf8_unicode_ci default NULL,
  `filesize` bigint(20) default NULL,
  `height` bigint(20) default NULL,
  `width` bigint(20) default NULL,
  `thumb` tinyint(1) default NULL,
  `description` text collate utf8_unicode_ci,
  PRIMARY KEY  (`id`),
  KEY `foreign_id` (`foreign_id`),
  KEY `class` (`class`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Attachment Details';

--
-- Dumping data for table `attachments`
--

INSERT INTO `attachments` (`id`, `created`, `modified`, `class`, `foreign_id`, `filename`, `dir`, `mimetype`, `filesize`, `height`, `width`, `thumb`, `description`) VALUES
(1, '2009-05-11 20:15:24', '2009-05-11 20:15:24', 'UserAvatar', 0, 'default_avatar.jpg', 'UserAvatar/0', 'image/jpeg', 1087, 50, 50, NULL, ''),
(2, '2009-05-11 20:16:34', '2009-05-11 20:16:34', 'PhotoAlbum', 0, 'default_album.png', 'PhotoAlbum/0', 'image/png', 40493, 360, 360, NULL, ''),
(3, '2009-05-11 20:16:34', '2009-05-11 20:16:34', 'Property', 0, 'property_default.jpg', 'Property/0', 'image/jpg', 60799, 512, 512, NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `authorizenet_docapture_logs`
--

DROP TABLE IF EXISTS `authorizenet_docapture_logs`;
CREATE TABLE IF NOT EXISTS `authorizenet_docapture_logs` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `property_user_id` bigint(20) default NULL,
  `property_id` bigint(20) default NULL,
  `user_id` bigint(20) default NULL,
  `transactionid` varchar(255) collate utf8_unicode_ci default NULL,
  `payment_status` varchar(50) collate utf8_unicode_ci default NULL,
  `authorize_amt` double(10,2) default NULL,
  `authorize_gateway_feeamt` double(10,2) default NULL,
  `authorize_taxamt` double(10,2) default NULL,
  `authorize_cvv2match` varchar(20) collate utf8_unicode_ci NOT NULL,
  `authorize_avscode` varchar(10) collate utf8_unicode_ci NOT NULL,
  `authorize_authorization_code` varchar(20) collate utf8_unicode_ci NOT NULL,
  `authorize_response_text` varchar(255) collate utf8_unicode_ci NOT NULL,
  `authorize_response` text collate utf8_unicode_ci NOT NULL,
  `currency_id` bigint(20) default NULL,
  `converted_currency_id` bigint(20) default NULL,
  `orginal_amount` double(10,2) default '0.00',
  `rate` double(10,2) default '0.00',
  PRIMARY KEY  (`id`),
  KEY `property_id` (`property_id`),
  KEY `property_user_id` (`property_user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `authorizenet_docapture_logs`
--


-- --------------------------------------------------------

--
-- Table structure for table `banned_ips`
--

DROP TABLE IF EXISTS `banned_ips`;
CREATE TABLE IF NOT EXISTS `banned_ips` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `address` varchar(255) collate utf8_unicode_ci default NULL,
  `range` varchar(255) collate utf8_unicode_ci default NULL,
  `referer_url` varchar(255) collate utf8_unicode_ci default NULL,
  `reason` varchar(255) collate utf8_unicode_ci default NULL,
  `redirect` varchar(255) collate utf8_unicode_ci default NULL,
  `thetime` int(15) NOT NULL,
  `timespan` int(15) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `address` (`address`),
  KEY `range` (`range`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Banned IPs Details';

--
-- Dumping data for table `banned_ips`
--


-- --------------------------------------------------------

--
-- Table structure for table `bed_types`
--

DROP TABLE IF EXISTS `bed_types`;
CREATE TABLE IF NOT EXISTS `bed_types` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `name` varchar(255) collate utf8_unicode_ci default NULL,
  `slug` varchar(265) collate utf8_unicode_ci default NULL,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `slug` (`slug`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Bed Types';

--
-- Dumping data for table `bed_types`
--

INSERT INTO `bed_types` (`id`, `created`, `modified`, `name`, `slug`, `is_active`) VALUES
(1, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'Airbed', 'airbed', 1),
(2, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'Futon', 'futon', 1),
(3, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'Pull-out sofa', 'pull-out-sofa', 1),
(4, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'Couch', 'couch', 1),
(5, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'Real bed', 'real-bed', 1);

-- --------------------------------------------------------

--
-- Table structure for table `blocked_users`
--

DROP TABLE IF EXISTS `blocked_users`;
CREATE TABLE IF NOT EXISTS `blocked_users` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `blocked_user_id` bigint(20) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `blocked_user_id` (`blocked_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Blocked User Details';

--
-- Dumping data for table `blocked_users`
--


-- --------------------------------------------------------

--
-- Table structure for table `cake_sessions`
--

DROP TABLE IF EXISTS `cake_sessions`;
CREATE TABLE IF NOT EXISTS `cake_sessions` (
  `id` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `user_id` bigint(20) NOT NULL default '0',
  `data` text collate utf8_unicode_ci,
  `expires` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='User Session Details';

--
-- Dumping data for table `cake_sessions`
--


-- --------------------------------------------------------

--
-- Table structure for table `cancellation_policies`
--

DROP TABLE IF EXISTS `cancellation_policies`;
CREATE TABLE IF NOT EXISTS `cancellation_policies` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `name` varchar(255) collate utf8_unicode_ci default NULL,
  `days` int(11) NOT NULL,
  `percentage` double(10,2) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `property_count` bigint(20) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Cancelation policies ';

--
-- Dumping data for table `cancellation_policies`
--

INSERT INTO `cancellation_policies` (`id`, `created`, `modified`, `name`, `days`, `percentage`, `is_active`, `property_count`) VALUES
(1, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'Flexible', 1, 100.00, 1, 0),
(2, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'Moderate', 5, 100.00, 1, 0),
(3, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'Strict', 7, 50.00, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

DROP TABLE IF EXISTS `cities`;
CREATE TABLE IF NOT EXISTS `cities` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `country_id` bigint(20) unsigned NOT NULL,
  `state_id` bigint(20) unsigned default '0',
  `name` varchar(45) collate utf8_unicode_ci default NULL,
  `slug` varchar(45) collate utf8_unicode_ci default NULL,
  `latitude` float default NULL,
  `longitude` float default NULL,
  `timezone` varchar(10) collate utf8_unicode_ci default NULL,
  `dma_id` int(11) default NULL,
  `county` varchar(25) collate utf8_unicode_ci default NULL,
  `code` varchar(4) collate utf8_unicode_ci default NULL,
  `is_approved` tinyint(1) NOT NULL default '0',
  `property_count` bigint(20) NOT NULL,
  `request_count` bigint(20) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `country_id` (`country_id`),
  KEY `state_id` (`state_id`),
  KEY `slug` (`slug`),
  KEY `dma_id` (`dma_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `created`, `modified`, `country_id`, `state_id`, `name`, `slug`, `latitude`, `longitude`, `timezone`, `dma_id`, `county`, `code`, `is_approved`, `property_count`, `request_count`) VALUES
(4, '2009-08-31 14:30:17', '2009-08-31 09:01:14', 254, 124, 'Gray\r\nMountain', 'gray-mountain', 35.8756, -111.412, '-07:00', 753, 'GMOU', NULL, 1, 0, 0),
(1, '2009-08-31 14:30:17', '2009-08-31 09:01:25', 14, 3, 'Cunnamulla', 'cunnamulla', -28.067, 145.683, '+10:00', 0, 'CUNN', NULL, 1, 0, 0),
(3, '2009-08-31 14:30:17', '2009-08-31 09:01:36', 254, 165, 'Chandler', 'chandler', 32.2481, -95.545, '-06:00', 623, 'CHAD', NULL, 1, 0, 0),
(2, '2009-08-31 14:30:17', '2009-08-31 09:16:20', 109, 2191, 'Chennai', 'chennai', 13.083, 80.283, '+05:50', 0, 'CHEN', NULL, 1, 0, 0),
(6, '2011-05-03 06:20:24', '2011-05-03 06:20:24', 0, 0, 'madurai', 'madurai', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0),
(7, '2011-05-03 06:25:10', '2011-05-03 06:25:10', 0, 0, 'kanchipuram', 'kanchipuram', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0),
(8, '2011-06-14 08:58:08', '2011-06-14 08:58:08', 0, 0, 'Johannesburg', 'johannesburg', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0),
(9, '2011-06-17 09:12:42', '2011-06-17 09:12:42', 0, 0, 'Los Altos', 'los-altos', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0),
(10, '2011-06-29 10:43:48', '2011-06-29 10:43:48', 0, 0, 'Dirdal', 'dirdal', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0),
(11, '2011-06-29 10:53:53', '2011-06-29 10:53:53', 0, 0, 'Zaragoza', 'zaragoza', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0),
(12, '2011-06-29 11:22:43', '2011-06-29 11:22:43', 0, 0, 'Mumbai', 'mumbai', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0),
(13, '2011-06-29 11:28:36', '2011-06-29 11:28:36', 0, 0, 'Domzale', 'domzale', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0),
(14, '2011-06-29 12:14:36', '2011-06-29 12:14:36', 0, 0, 'Melbourne', 'melbourne', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0),
(15, '2011-06-29 14:28:56', '2011-06-29 14:28:56', 0, 0, 'Antwerp', 'antwerp', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0),
(16, '2011-06-29 15:50:33', '2011-06-29 15:50:33', 0, 0, 'Willemstad', 'willemstad', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0),
(17, '2011-06-29 16:03:23', '2011-06-29 16:03:23', 0, 0, 'Singapore', 'singapore', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0),
(18, '2011-06-29 16:26:03', '2011-06-29 16:26:03', 0, 0, 'Cerro Maggiore', 'cerro-maggiore', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0),
(19, '2011-06-29 17:48:47', '2011-06-29 17:48:47', 0, 0, 'Chicago', 'chicago', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0),
(20, '2011-06-29 18:40:24', '2011-06-29 18:40:24', 0, 0, 'Raleigh', 'raleigh', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0),
(21, '2011-06-29 18:46:08', '2011-06-29 18:46:08', 0, 0, 'Moscow', 'moscow', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0),
(22, '2011-06-29 19:25:41', '2011-06-29 19:25:41', 0, 0, 'London', 'london', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0),
(23, '2011-06-29 19:58:01', '2011-06-29 19:58:01', 0, 0, 'Woodstock', 'woodstock', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0),
(24, '2011-06-29 23:17:41', '2011-06-29 23:17:41', 0, 0, 'Chipping Norton', 'chipping-norton', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0),
(25, '2011-06-30 00:20:38', '2011-06-30 00:20:38', 0, 0, 'Mountain View', 'mountain-view', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0),
(26, '2011-06-30 00:46:27', '2011-06-30 00:46:27', 0, 0, 'Bellevue', 'bellevue', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0),
(27, '2011-06-30 00:55:54', '2011-06-30 00:55:54', 0, 0, 'Porto Alegre', 'porto-alegre', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0),
(28, '2011-06-30 04:58:44', '2011-06-30 04:58:44', 0, 0, 'Bragança Paulista', 'bragança-paulista', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0),
(29, '2011-06-30 06:05:04', '2011-06-30 06:05:04', 0, 0, 'Taipei', 'taipei', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0),
(30, '2011-06-30 06:05:59', '2011-06-30 06:05:59', 0, 0, 'Motupe', 'motupe', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0),
(31, '2011-06-30 06:49:48', '2011-06-30 06:49:48', 0, 0, 'San Francisco', 'san-francisco', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0),
(32, '2011-06-30 12:13:59', '2011-06-30 12:13:59', 0, 0, 'Vadodara', 'vadodara', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0),
(33, '2011-06-30 13:30:16', '2011-06-30 13:30:16', 0, 0, 'Rio De Janeiro', 'rio-de-janeiro', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0),
(34, '2011-06-30 15:59:29', '2011-06-30 15:59:29', 0, 0, 'Medellín', 'medellín', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0),
(35, '2011-06-30 16:55:46', '2011-06-30 16:55:46', 0, 0, 'Baulkham Hills', 'baulkham-hills', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0),
(36, '2011-06-30 16:58:29', '2011-06-30 16:58:29', 0, 0, 'Sydney', 'sydney', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0),
(37, '2011-06-30 18:48:56', '2011-06-30 18:48:56', 0, 0, 'San Jose', 'san-jose', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0),
(38, '2011-06-30 19:06:55', '2011-06-30 19:06:55', 0, 0, 'Pietrasanta', 'pietrasanta', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0),
(39, '2011-06-30 21:46:41', '2011-06-30 21:46:41', 0, 0, 'Charlotte', 'charlotte', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0),
(40, '2011-06-30 23:17:29', '2011-06-30 23:17:29', 0, 0, 'Jacksonville', 'jacksonville', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0),
(41, '2011-06-30 23:29:22', '2011-06-30 23:29:22', 0, 0, 'Wellington', 'wellington', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0),
(42, '2011-07-01 02:10:39', '2011-07-01 02:10:39', 0, 0, 'Ryde', 'ryde', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0),
(43, '2011-07-01 03:42:16', '2011-07-01 03:42:16', 0, 0, 'Glendale', 'glendale', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `collections`
--

DROP TABLE IF EXISTS `collections`;
CREATE TABLE IF NOT EXISTS `collections` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) collate utf8_unicode_ci default NULL,
  `slug` varchar(265) collate utf8_unicode_ci default NULL,
  `description` text collate utf8_unicode_ci,
  `property_count` bigint(20) NOT NULL default '0',
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `slug` (`slug`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Collections details ';

--
-- Dumping data for table `collections`
--


-- --------------------------------------------------------

--
-- Table structure for table `collections_properties`
--

DROP TABLE IF EXISTS `collections_properties`;
CREATE TABLE IF NOT EXISTS `collections_properties` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `collection_id` bigint(20) unsigned default NULL,
  `property_id` bigint(20) unsigned NOT NULL,
  `display_order` bigint(20) default NULL,
  PRIMARY KEY  (`id`),
  KEY `property_id` (`property_id`),
  KEY `collection_id` (`collection_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Collections and properties merge table';

--
-- Dumping data for table `collections_properties`
--


-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) unsigned default NULL,
  `ip_id` bigint(20) NOT NULL,
  `first_name` varchar(100) collate utf8_unicode_ci default NULL,
  `last_name` varchar(100) collate utf8_unicode_ci default NULL,
  `email` varchar(255) collate utf8_unicode_ci default NULL,
  `subject` varchar(255) collate utf8_unicode_ci default NULL,
  `message` text collate utf8_unicode_ci,
  `telephone` varchar(20) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `ip_id` (`ip_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `contacts`
--


-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE IF NOT EXISTS `countries` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `name` varchar(50) collate utf8_unicode_ci default NULL,
  `fips104` varchar(2) collate utf8_unicode_ci default NULL,
  `iso2` varchar(2) collate utf8_unicode_ci default NULL,
  `iso3` varchar(3) collate utf8_unicode_ci default NULL,
  `ison` varchar(4) collate utf8_unicode_ci default NULL,
  `internet` varchar(2) collate utf8_unicode_ci default NULL,
  `capital` varchar(25) collate utf8_unicode_ci default NULL,
  `map_reference` varchar(50) collate utf8_unicode_ci default NULL,
  `nationality_singular` varchar(35) collate utf8_unicode_ci default NULL,
  `nationality_plural` varchar(35) collate utf8_unicode_ci default NULL,
  `currency` varchar(30) collate utf8_unicode_ci default NULL,
  `currency_code` varchar(3) collate utf8_unicode_ci default NULL,
  `population` bigint(20) default NULL,
  `title` varchar(50) collate utf8_unicode_ci default NULL,
  `comment` text collate utf8_unicode_ci,
  `slug` varchar(50) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`),
  KEY `slug` (`slug`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `fips104`, `iso2`, `iso3`, `ison`, `internet`, `capital`, `map_reference`, `nationality_singular`, `nationality_plural`, `currency`, `currency_code`, `population`, `title`, `comment`, `slug`) VALUES
(1, 'Afghanistan (افغانستان)', 'AF', 'AF', 'AFG', '4', 'AF', 'Kabul ', 'Asia ', 'Afghan', 'Afghans', 'Afghani ', 'AFA', 26813057, 'Afghanistan', '', 'afghanistan'),
(2, 'Albania (Shqipëria)', 'AL', 'AL', 'ALB', '8', 'AL', 'Tirana ', 'Europe ', 'Albanian', 'Albanians', 'Lek ', 'ALL', 3510484, 'Albania', '', 'albania-shqip-ria'),
(3, 'Algeria (الجزائر)', 'AG', 'DZ', 'DZA', '12', 'DZ', 'Algiers ', 'Africa ', 'Algerian', 'Algerians', 'Algerian Dinar ', 'DZD', 31736053, 'Algeria', '', 'algeria'),
(4, 'American Samoa', 'AQ', 'AS', 'ASM', '16', 'AS', 'Pago Pago ', 'Oceania ', 'American Samoan', 'American Samoans', 'US Dollar', 'USD', 67084, 'American Samoa', '', 'american-samoa'),
(5, 'Andorra', 'AN', 'AD', 'AND', '20', 'AD', 'Andorra la Vella ', 'Europe ', 'Andorran', 'Andorrans', 'Euro', 'EUR', 67627, 'Andorra', '', 'andorra'),
(6, 'Angola', 'AO', 'AO', 'AGO', '24', 'AO', 'Luanda ', 'Africa ', 'Angolan', 'Angolans', 'Kwanza ', 'AOA', 10366031, 'Angola', '', 'angola'),
(7, 'Anguilla', 'AV', 'AI', 'AIA', '660', 'AI', 'The Valley ', 'Central America and the Caribbean ', 'Anguillan', 'Anguillans', 'East Caribbean Dollar ', 'XCD', 12132, 'Anguilla', '', 'anguilla'),
(8, 'Antarctica', 'AY', 'AQ', 'ATA', '10', 'AQ', '', 'Antarctic Region ', '', '', '', '', 0, 'Antarctica', 'ISO defines as the territory south of 60 degrees south latitude', 'antarctica'),
(9, 'Antigua and Barbuda', 'AC', 'AG', 'ATG', '28', 'AG', 'Saint John''s ', 'Central America and the Caribbean ', 'Antiguan and Barbudan', 'Antiguans and Barbudans', 'East Caribbean Dollar ', 'XCD', 66970, 'Antigua and Barbuda', '', 'antigua-and-barbuda'),
(10, 'Argentina', 'AR', 'AR', 'ARG', '32', 'AR', 'Buenos Aires ', 'South America ', 'Argentine', 'Argentines', 'Argentine Peso ', 'ARS', 37384816, 'Argentina', '', 'argentina'),
(11, 'Armenia (Հայաստան)', 'AM', 'AM', 'ARM', '51', 'AM', 'Yerevan ', 'Commonwealth of Independent States ', 'Armenian', 'Armenians', 'Armenian Dram ', 'AMD', 3336100, 'Armenia', '', 'armenia'),
(12, 'Aruba', 'AA', 'AW', 'ABW', '533', 'AW', 'Oranjestad ', 'Central America and the Caribbean ', 'Aruban', 'Arubans', 'Aruban Guilder', 'AWG', 70007, 'Aruba', '', 'aruba'),
(13, 'Ashmore and Cartier', 'AT', '--', '-- ', '--', '--', '', 'Southeast Asia ', '', '', '', '', 0, 'Ashmore and Cartier', 'ISO includes with Australia', 'ashmore-and-cartier'),
(14, 'Australia', 'AS', 'AU', 'AUS', '36', 'AU', 'Canberra ', 'Oceania ', 'Australian', 'Australians', 'Australian dollar ', 'AUD', 19357594, 'Australia', 'ISO includes Ashmore and Cartier Islands,Coral Sea Islands', 'australia'),
(15, 'Austria (Österreich)', 'AU', 'AT', 'AUT', '40', 'AT', 'Vienna ', 'Europe ', 'Austrian', 'Austrians', 'Euro', 'EUR', 8150835, 'Austria', '', 'austria-sterreich'),
(16, 'Azerbaijan (Azərbaycan)', 'AJ', 'AZ', 'AZE', '31', 'AZ', 'Baku (Baki) ', 'Commonwealth of Independent States ', 'Azerbaijani', 'Azerbaijanis', 'Azerbaijani Manat ', 'AZM', 7771092, 'Azerbaijan', '', 'azerbaijan-az-rbaycan'),
(17, 'Bahamas', 'BF', 'BS', 'BHS', '44', 'BS', 'Nassau ', 'Central America and the Caribbean ', 'Bahamian', 'Bahamians', 'Bahamian Dollar ', 'BSD', 297852, 'The Bahamas', '', 'bahamas'),
(18, 'Bahrain (البحرين)', 'BA', 'BH', 'BHR', '48', 'BH', 'Manama ', 'Middle East ', 'Bahraini', 'Bahrainis', 'Bahraini Dinar ', 'BHD', 645361, 'Bahrain', '', 'bahrain'),
(19, 'Baker Island', 'FQ', '--', '-- ', '--', '--', '', 'Oceania ', '', '', '', '', 0, 'Baker Island', 'ISO includes with the US Minor Outlying Islands', 'baker-island'),
(20, 'Bangladesh (বাংলাদেশ)', 'BG', 'BD', 'BGD', '50', 'BD', 'Dhaka ', 'Asia ', 'Bangladeshi', 'Bangladeshis', 'Taka ', 'BDT', 131269860, 'Bangladesh', '', 'bangladesh'),
(21, 'Barbados', 'BB', 'BB', 'BRB', '52', 'BB', 'Bridgetown ', 'Central America and the Caribbean ', 'Barbadian', 'Barbadians', 'Barbados Dollar', 'BBD', 275330, 'Barbados', '', 'barbados'),
(22, 'Bassas da India', 'BS', '--', '-- ', '--', '--', '', 'Africa ', '', '', '', '', 0, 'Bassas da India', 'ISO includes with the Miscellaneous (French) Indian Ocean Islands', 'bassas-da-india'),
(23, 'Belarus (Белару́сь)', 'BO', 'BY', 'BLR', '112', 'BY', 'Minsk ', 'Commonwealth of Independent States ', 'Belarusian', 'Belarusians', 'Belarussian Ruble', 'BYR', 10350194, 'Belarus', '', 'belarus'),
(24, 'Belgium (België)', 'BE', 'BE', 'BEL', '56', 'BE', 'Brussels ', 'Europe ', 'Belgian', 'Belgians', 'Euro', 'EUR', 10258762, 'Belgium', '', 'belgium-belgi'),
(25, 'Belize', 'BH', 'BZ', 'BLZ', '84', 'BZ', 'Belmopan ', 'Central America and the Caribbean ', 'Belizean', 'Belizeans', 'Belize Dollar', 'BZD', 256062, 'Belize', '', 'belize'),
(26, 'Benin (Bénin)', 'BN', 'BJ', 'BEN', '204', 'BJ', 'Porto-Novo  ', 'Africa ', 'Beninese', 'Beninese', 'CFA Franc BCEAO', 'XOF', 6590782, 'Benin', '', 'benin-b-nin'),
(27, 'Bermuda', 'BD', 'BM', 'BMU', '60', 'BM', 'Hamilton ', 'North America ', 'Bermudian', 'Bermudians', 'Bermudian Dollar ', 'BMD', 63503, 'Bermuda', '', 'bermuda'),
(28, 'Bhutan (འབྲུག་ཡུལ)', 'BT', 'BT', 'BTN', '64', 'BT', 'Thimphu ', 'Asia ', 'Bhutanese', 'Bhutanese', 'Ngultrum', 'BTN', 2049412, 'Bhutan', '', 'bhutan'),
(29, 'Bolivia', 'BL', 'BO', 'BOL', '68', 'BO', 'La Paz /Sucre ', 'South America ', 'Bolivian', 'Bolivians', 'Boliviano ', 'BOB', 8300463, 'Bolivia', '', 'bolivia'),
(30, 'Bosnia and Herzegovina (Bosna i Hercegovina)', 'BK', 'BA', 'BIH', '70', 'BA', 'Sarajevo ', 'Bosnia and Herzegovina, Europe ', 'Bosnian and Herzegovinian', 'Bosnians and Herzegovinians', 'Convertible Marka', 'BAM', 3922205, 'Bosnia and Herzegovina', '', 'bosnia-and-herzegovina-bosna-i-hercegovina'),
(31, 'Botswana', 'BC', 'BW', 'BWA', '72', 'BW', 'Gaborone ', 'Africa ', 'Motswana', 'Batswana', 'Pula ', 'BWP', 1586119, 'Botswana', '', 'botswana'),
(32, 'Bouvet Island', 'BV', 'BV', 'BVT', '74', 'BV', '', 'Antarctic Region ', '', '', 'Norwegian Krone ', 'NOK', 0, 'Bouvet Island', '', 'bouvet-island'),
(33, 'Brazil (Brasil)', 'BR', 'BR', 'BRA', '76', 'BR', 'Brasilia ', 'South America ', 'Brazilian', 'Brazilians', 'Brazilian Real ', 'BRL', 174468575, 'Brazil', '', 'brazil-brasil'),
(34, 'British Indian Ocean Territory', 'IO', 'IO', 'IOT', '86', 'IO', '', 'World ', '', '', 'US Dollar', 'USD', 0, 'The British Indian Ocean Territory', '', 'british-indian-ocean-territory'),
(35, 'Brunei (Brunei Darussalam)', 'BX', 'BN', 'BRN', '96', 'BN', '', '', '', '', 'Brunei Dollar', 'BND', 372361, 'Brunei', '', 'brunei-brunei-darussalam'),
(36, 'Bulgaria (България)', 'BU', 'BG', 'BGR', '100', 'BG', 'Sofia ', 'Europe ', 'Bulgarian', 'Bulgarians', 'Lev ', 'BGN', 7707495, 'Bulgaria', '', 'bulgaria'),
(37, 'Burkina Faso', 'UV', 'BF', 'BFA', '854', 'BF', 'Ouagadougou ', 'Africa ', 'Burkinabe', 'Burkinabe', 'CFA Franc BCEAO', 'XOF', 12272289, 'Burkina Faso', '', 'burkina-faso'),
(38, 'Burundi (Uburundi)', 'BY', 'BI', 'BDI', '108', 'BI', 'Bujumbura ', 'Africa ', 'Burundi', 'Burundians', 'Burundi Franc ', 'BIF', 6223897, 'Burundi', '', 'burundi-uburundi'),
(39, 'Cambodia (Kampuchea)', 'CB', 'KH', 'KHM', '116', 'KH', 'Phnom Penh ', 'Southeast Asia ', 'Cambodian', 'Cambodians', 'Riel ', 'KHR', 12491501, 'Cambodia', '', 'cambodia-kampuchea'),
(40, 'Cameroon (Cameroun)', 'CM', 'CM', 'CMR', '120', 'CM', 'Yaounde ', 'Africa ', 'Cameroonian', 'Cameroonians', 'CFA Franc BEAC', 'XAF', 15803220, 'Cameroon', '', 'cameroon-cameroun'),
(41, 'Canada', 'CA', 'CA', 'CAN', '124', 'CA', 'Ottawa ', 'North America ', 'Canadian', 'Canadians', 'Canadian Dollar ', 'CAD', 31592805, 'Canada', '', 'canada'),
(42, 'Cape Verde (Cabo Verde)', 'CV', 'CV', 'CPV', '132', 'CV', 'Praia ', 'World ', 'Cape Verdean', 'Cape Verdeans', 'Cape Verdean Escudo ', 'CVE', 405163, 'Cape Verde', '', 'cape-verde-cabo-verde'),
(43, 'Cayman Islands', 'CJ', 'KY', 'CYM', '136', 'KY', 'George Town ', 'Central America and the Caribbean ', 'Caymanian', 'Caymanians', 'Cayman Islands Dollar', 'KYD', 35527, 'The Cayman Islands', '', 'cayman-islands'),
(44, 'Central African Republic (République Centrafricain', 'CT', 'CF', 'CAF', '140', 'CF', 'Bangui ', 'Africa ', 'Central African', 'Central Africans', 'CFA Franc BEAC', 'XAF', 3576884, 'The Central African Republic', '', 'central-african-republic-r-publique-centrafricain'),
(45, 'Chad (Tchad)', 'CD', 'TD', 'TCD', '148', 'TD', 'N''Djamena ', 'Africa ', 'Chadian', 'Chadians', 'CFA Franc BEAC', 'XAF', 8707078, 'Chad', '', 'chad-tchad'),
(46, 'Chile', 'CI', 'CL', 'CHL', '152', 'CL', 'Santiago ', 'South America ', 'Chilean', 'Chileans', 'Chilean Peso ', 'CLP', 15328467, 'Chile', '', 'chile'),
(47, 'China (中国)', 'CH', 'CN', 'CHN', '156', 'CN', 'Beijing ', 'Asia ', 'Chinese', 'Chinese', 'Yuan Renminbi', 'CNY', 1273111290, 'China', 'see also Taiwan', 'china'),
(48, 'Christmas Island', 'KT', 'CX', 'CXR', '162', 'CX', 'The Settlement ', 'Southeast Asia ', 'Christmas Island', 'Christmas Islanders', 'Australian Dollar ', 'AUD', 2771, 'Christmas Island', '', 'christmas-island'),
(49, 'Clipperton Island', 'IP', '--', '-- ', '--', '--', '', 'World ', '', '', '', '', 0, 'Clipperton Island', 'ISO includes with French Polynesia', 'clipperton-island'),
(50, 'Cocos Islands', 'CK', 'CC', 'CCK', '166', 'CC', 'West Island ', 'Southeast Asia ', 'Cocos Islander', 'Cocos Islanders', 'Australian Dollar ', 'AUD', 633, 'The Cocos Islands', '', 'cocos-islands'),
(51, 'Colombia', 'CO', 'CO', 'COL', '170', 'CO', 'Bogota ', 'South America, Central America and the Caribbean ', 'Colombian', 'Colombians', 'Colombian Peso ', 'COP', 40349388, 'Colombia', '', 'colombia'),
(52, 'Comoros (Comores)', 'CN', 'KM', 'COM', '174', 'KM', 'Moroni ', 'Africa ', 'Comoran', 'Comorans', 'Comoro Franc', 'KMF', 596202, 'Comoros', '', 'comoros-comores'),
(53, 'Congo', 'CF', 'CG', 'COG', '178', 'CG', 'Brazzaville ', 'Africa ', 'Congolese', 'Congolese', 'CFA Franc BEAC', 'XAF', 2894336, 'Republic of the Congo', '', 'congo-1'),
(54, 'Congo, Democratic Republic of the', 'CG', 'CD', 'COD', '180', 'CD', 'Kinshasa ', 'Africa ', 'Congolese', 'Congolese', 'Franc Congolais', 'CDF', 53624718, 'Democratic Republic of the Congo', 'formerly Zaire', 'congo-democratic-republic-of-the'),
(55, 'Cook Islands', 'CW', 'CK', 'COK', '184', 'CK', 'Avarua ', 'Oceania ', 'Cook Islander', 'Cook Islanders', 'New Zealand Dollar ', 'NZD', 20611, 'The Cook Islands', '', 'cook-islands'),
(56, 'Coral Sea Islands', 'CR', '--', '-- ', '--', '--', '', 'Oceania ', '', '', '', '', 0, 'The Coral Sea Islands', 'ISO includes with Australia', 'coral-sea-islands'),
(57, 'Costa Rica', 'CS', 'CR', 'CRI', '188', 'CR', 'San Jose ', 'Central America and the Caribbean ', 'Costa Rican', 'Costa Ricans', 'Costa Rican Colon', 'CRC', 3773057, 'Costa Rica', '', 'costa-rica'),
(58, 'Côte d&#39;Ivoire', 'IV', 'CI', 'CIV', '384', 'CI', 'Yamoussoukro', 'Africa ', 'Ivorian', 'Ivorians', 'CFA Franc BCEAO', 'XOF', 16393221, 'Cote d''Ivoire', '', 'c-te-d-39-ivoire'),
(59, 'Croatia (Hrvatska)', 'HR', 'HR', 'HRV', '191', 'HR', 'Zagreb ', 'Europe ', 'Croatian', 'Croats', 'Kuna', 'HRK', 4334142, 'Croatia', '', 'croatia-hrvatska'),
(60, 'Cuba', 'CU', 'CU', 'CUB', '192', 'CU', 'Havana ', 'Central America and the Caribbean ', 'Cuban', 'Cubans', 'Cuban Peso', 'CUP', 11184023, 'Cuba', '', 'cuba'),
(61, 'Cyprus (Κυπρος)', 'CY', 'CY', 'CYP', '196', 'CY', 'Nicosia ', 'Middle East ', 'Cypriot', 'Cypriots', 'Cyprus Pound', 'CYP', 762887, 'Cyprus', '', 'cyprus'),
(62, 'Czech Republic (Česko)', 'EZ', 'CZ', 'CZE', '203', 'CZ', 'Prague ', 'Europe ', 'Czech', 'Czechs', 'Czech Koruna', 'CZK', 10264212, 'The Czech Republic', '', 'czech-republic-esko'),
(63, 'Denmark (Danmark)', 'DA', 'DK', 'DNK', '208', 'DK', 'Copenhagen ', 'Europe ', 'Danish', 'Danes', 'Danish Krone', 'DKK', 5352815, 'Denmark', '', 'denmark-danmark'),
(64, 'Djibouti', 'DJ', 'DJ', 'DJI', '262', 'DJ', 'Djibouti ', 'Africa ', 'Djiboutian', 'Djiboutians', 'Djibouti Franc', 'DJF', 460700, 'Djibouti', '', 'djibouti'),
(65, 'Dominica', 'DO', 'DM', 'DMA', '212', 'DM', 'Roseau ', 'Central America and the Caribbean ', 'Dominican', 'Dominicans', 'East Caribbean Dollar', 'XCD', 70786, 'Dominica', '', 'dominica'),
(66, 'Dominican Republic', 'DR', 'DO', 'DOM', '214', 'DO', 'Santo Domingo ', 'Central America and the Caribbean ', 'Dominican', 'Dominicans', 'Dominican Peso', 'DOP', 8581477, 'The Dominican Republic', '', 'dominican-republic'),
(67, 'Ecuador', 'EC', 'EC', 'ECU', '218', 'EC', 'Quito ', 'South America ', 'Ecuadorian', 'Ecuadorians', 'US Dollar', 'USD', 13183978, 'Ecuador', '', 'ecuador'),
(68, 'Egypt (مصر)', 'EG', 'EG', 'EGY', '818', 'EG', 'Cairo ', 'Africa ', 'Egyptian', 'Egyptians', 'Egyptian Pound ', 'EGP', 69536644, 'Egypt', '', 'egypt'),
(69, 'El Salvador', 'ES', 'SV', 'SLV', '222', 'SV', 'San Salvador ', 'Central America and the Caribbean ', 'Salvadoran', 'Salvadorans', 'El Salvador Colon', 'SVC', 6237662, 'El Salvador', '', 'el-salvador'),
(70, 'Equatorial Guinea (Guinea Ecuatorial)', 'EK', 'GQ', 'GNQ', '226', 'GQ', 'Malabo ', 'Africa ', 'Equatorial Guinean', 'Equatorial Guineans', 'CFA Franc BEAC', 'XAF', 486060, 'Equatorial Guinea', '', 'equatorial-guinea-guinea-ecuatorial'),
(71, 'Eritrea (Ertra)', 'ER', 'ER', 'ERI', '232', 'ER', 'Asmara ', 'Africa ', 'Eritrean', 'Eritreans', 'Nakfa', 'ERN', 4298269, 'Eritrea', '', 'eritrea-ertra'),
(72, 'Estonia (Eesti)', 'EN', 'EE', 'EST', '233', 'EE', 'Tallinn ', 'Europe ', 'Estonian', 'Estonians', 'Kroon', 'EEK', 1423316, 'Estonia', '', 'estonia-eesti'),
(73, 'Ethiopia (Ityop&#39;iya)', 'ET', 'ET', 'ETH', '231', 'ET', 'Addis Ababa ', 'Africa ', 'Ethiopian', 'Ethiopians', 'Ethiopian Birr', 'ETB', 65891874, 'Ethiopia', '', 'ethiopia-ityop-39-iya'),
(74, 'Europa Island', 'EU', '--', '-- ', '--', '--', '', 'Africa ', '', '', '', '', 0, 'Europa Island', 'ISO includes with the Miscellaneous (French) Indian Ocean Islands', 'europa-island'),
(75, 'Falkland Islands', 'FK', 'FK', 'FLK', '238', 'FK', 'Stanley', 'South America', 'Falkland Island', 'Falkland Islanders', 'Falkland Islands Pound', 'FKP', 2895, 'The Falkland Islands ', '', 'falkland-islands'),
(76, 'Faroe Islands', 'FO', 'FO', 'FRO', '234', 'FO', 'Torshavn ', 'Europe ', 'Faroese', 'Faroese', 'Danish Krone ', 'DKK', 45661, 'The Faroe Islands', '', 'faroe-islands'),
(77, 'Fiji', 'FJ', 'FJ', 'FJI', '242', 'FJ', 'Suva ', 'Oceania ', 'Fijian', 'Fijians', 'Fijian Dollar ', 'FJD', 844330, 'Fiji', '', 'fiji'),
(78, 'Finland (Suomi)', 'FI', 'FI', 'FIN', '246', 'FI', 'Helsinki ', 'Europe ', 'Finnish', 'Finns', 'Euro', 'EUR', 5175783, 'Finland', '', 'finland-suomi'),
(79, 'France', 'FR', 'FR', 'FRA', '250', 'FR', 'Paris ', 'Europe ', 'Frenchman', 'Frenchmen', 'Euro', 'EUR', 59551227, 'France', '', 'france'),
(80, 'France, Metropolitan', '--', '--', '-- ', '--', 'FX', '', '', '', '', 'Euro', 'EUR', 0, 'Metropolitan France', 'ISO limits to the European part of France, excluding French Guiana, French Polynesia, French Southern and Antarctic Lands, Guadeloupe, Martinique, Mayotte, New Caledonia, Reunion, Saint Pierre and Miquelon, Wallis and Futuna', 'france-metropolitan'),
(81, 'French Guiana', 'FG', 'GF', 'GUF', '254', 'GF', 'Cayenne ', 'South America ', 'French Guianese', 'French Guianese', 'Euro', 'EUR', 177562, 'French Guiana', '', 'french-guiana'),
(82, 'French Polynesia', 'FP', 'PF', 'PYF', '258', 'PF', 'Papeete ', 'Oceania ', 'French Polynesian', 'French Polynesians', 'CFP Franc', 'XPF', 253506, 'French Polynesia', 'ISO includes Clipperton Island', 'french-polynesia'),
(83, 'French Southern Territories', 'FS', 'TF', 'ATF', '260', 'TF', '', 'Antarctic Region ', '', '', 'Euro', 'EUR', 0, 'The French Southern and Antarctic Lands', 'FIPS 10-4 does not include the French-claimed portion of Antarctica (Terre Adelie)', 'french-southern-territories'),
(84, 'Gabon', 'GB', 'GA', 'GAB', '266', 'GA', 'Libreville ', 'Africa ', 'Gabonese', 'Gabonese', 'CFA Franc BEAC', 'XAF', 1221175, 'Gabon', '', 'gabon'),
(85, 'Gambia', 'GA', 'GM', 'GMB', '270', 'GM', 'Banjul ', 'Africa ', 'Gambian', 'Gambians', 'Dalasi', 'GMD', 1411205, 'The Gambia', '', 'gambia'),
(86, 'Gaza Strip', 'GZ', '--', '-- ', '--', '--', '', 'Middle East ', '', '', 'New Israeli Shekel ', 'ILS', 1178119, 'The Gaza Strip', '', 'gaza-strip'),
(87, 'Georgia (საქართველო)', 'GG', 'GE', 'GEO', '268', 'GE', 'T''bilisi ', 'Commonwealth of Independent States ', 'Georgian', 'Georgians', 'Lari', 'GEL', 4989285, 'Georgia', '', 'georgia'),
(88, 'Germany (Deutschland)', 'GM', 'DE', 'DEU', '276', 'DE', 'Berlin ', 'Europe ', 'German', 'Germans', 'Euro', 'EUR', 83029536, 'Deutschland', '', 'germany-deutschland'),
(89, 'Ghana', 'GH', 'GH', 'GHA', '288', 'GH', 'Accra ', 'Africa ', 'Ghanaian', 'Ghanaians', 'Cedi', 'GHC', 19894014, 'Ghana', '', 'ghana'),
(90, 'Gibraltar', 'GI', 'GI', 'GIB', '292', 'GI', 'Gibraltar ', 'Europe ', 'Gibraltar', 'Gibraltarians', 'Gibraltar Pound', 'GIP', 27649, 'Gibraltar', '', 'gibraltar'),
(91, 'Glorioso Islands', 'GO', '--', '-- ', '--', '--', '', 'Africa ', '', '', '', '', 0, 'The Glorioso Islands', 'ISO includes with the Miscellaneous (French) Indian Ocean Islands', 'glorioso-islands'),
(92, 'Greece (Ελλάς)', 'GR', 'GR', 'GRC', '300', 'GR', 'Athens ', 'Europe ', 'Greek', 'Greeks', 'Euro', 'EUR', 10623835, 'Greece', '', 'greece'),
(93, 'Greenland', 'GL', 'GL', 'GRL', '304', 'GL', 'Nuuk ', 'Arctic Region ', 'Greenlandic', 'Greenlanders', 'Danish Krone', 'DKK', 56352, 'Greenland', '', 'greenland'),
(94, 'Grenada', 'GJ', 'GD', 'GRD', '308', 'GD', 'Saint George''s ', 'Central America and the Caribbean ', 'Grenadian', 'Grenadians', 'East Caribbean Dollar', 'XCD', 89227, 'Grenada', '', 'grenada'),
(95, 'Guadeloupe', 'GP', 'GP', 'GLP', '312', 'GP', 'Basse-Terre ', 'Central America and the Caribbean ', 'Guadeloupe', 'Guadeloupians', 'Euro', 'EUR', 431170, 'Guadeloupe', '', 'guadeloupe'),
(96, 'Guam', 'GQ', 'GU', 'GUM', '316', 'GU', 'Hagatna', 'Oceania ', 'Guamanian', 'Guamanians', 'US Dollar', 'USD', 157557, 'Guam', '', 'guam'),
(97, 'Guatemala', 'GT', 'GT', 'GTM', '320', 'GT', 'Guatemala ', 'Central America and the Caribbean ', 'Guatemalan', 'Guatemalans', 'Quetzal', 'GTQ', 12974361, 'Guatemala', '', 'guatemala'),
(98, 'Guernsey', 'GK', '--', '-- ', '--', 'GG', 'Saint Peter Port ', 'Europe ', 'Channel Islander', 'Channel Islanders', 'Pound Sterling', 'GBP', 64342, 'Guernsey', 'ISO includes with the United Kingdom', 'guernsey'),
(99, 'Guinea (Guinée)', 'GV', 'GN', 'GIN', '324', 'GN', 'Conakry ', 'Africa ', 'Guinean', 'Guineans', 'Guinean Franc ', 'GNF', 7613870, 'Guinea', '', 'guinea-guin-e'),
(100, 'Guinea-Bissau (Guiné-Bissau)', 'PU', 'GW', 'GNB', '624', 'GW', 'Bissau ', 'Africa ', 'Guinean', 'Guineans', 'CFA Franc BCEAO', 'XOF', 1315822, 'Guinea-Bissau', '', 'guinea-bissau-guin-bissau'),
(101, 'Guyana', 'GY', 'GY', 'GUY', '328', 'GY', 'Georgetown ', 'South America ', 'Guyanese', 'Guyanese', 'Guyana Dollar', 'GYD', 697181, 'Guyana', '', 'guyana'),
(102, 'Haiti (Haïti)', 'HA', 'HT', 'HTI', '332', 'HT', 'Port-au-Prince ', 'Central America and the Caribbean ', 'Haitian', 'Haitians', 'Gourde', 'HTG', 6964549, 'Haiti', '', 'haiti-ha-ti'),
(103, 'Heard Island and McDonald Islands', 'HM', 'HM', 'HMD', '334', 'HM', '', 'Antarctic Region ', '', '', 'Australian Dollar', 'AUD', 0, 'The Heard Island and McDonald Islands', '', 'heard-island-and-mcdonald-islands'),
(104, 'Honduras', 'HO', 'HN', 'HND', '340', 'HN', 'Tegucigalpa ', 'Central America and the Caribbean ', 'Honduran', 'Hondurans', 'Lempira', 'HNL', 6406052, 'Honduras', '', 'honduras'),
(105, 'Hong Kong', 'HK', 'HK', 'HKG', '344', 'HK', '', 'Southeast Asia ', '', '', 'Hong Kong Dollar ', 'HKD', 0, 'Xianggang ', '', 'hong-kong'),
(106, 'Howland Island', 'HQ', '--', '-- ', '--', '--', '', 'Oceania ', '', '', '', '', 7210505, 'Howland Island', 'ISO includes with the US Minor Outlying Islands', 'howland-island'),
(107, 'Hungary (Magyarország)', 'HU', 'HU', 'HUN', '348', 'HU', 'Budapest ', 'Europe ', 'Hungarian', 'Hungarians', 'Forint', 'HUF', 10106017, 'Hungary', '', 'hungary-magyarorsz-g'),
(108, 'Iceland (Ísland)', 'IC', 'IS', 'ISL', '352', 'IS', 'Reykjavik ', 'Arctic Region ', 'Icelandic', 'Icelanders', 'Iceland Krona', 'ISK', 277906, 'Iceland', '', 'iceland-sland'),
(109, 'India', 'IN', 'IN', 'IND', '356', 'IN', 'New Delhi ', 'Asia ', 'Indian', 'Indians', 'Indian Rupee ', 'INR', 1029991145, 'India', '', 'india'),
(110, 'Indonesia', 'ID', 'ID', 'IDN', '360', 'ID', 'Jakarta ', 'Southeast Asia ', 'Indonesian', 'Indonesians', 'Rupiah', 'IDR', 228437870, 'Indonesia', '', 'indonesia'),
(111, 'Iran (ایران)', 'IR', 'IR', 'IRN', '364', 'IR', 'Tehran ', 'Middle East ', 'Iranian', 'Iranians', 'Iranian Rial', 'IRR', 66128965, 'Iran', '', 'iran'),
(112, 'Iraq (العراق)', 'IZ', 'IQ', 'IRQ', '368', 'IQ', 'Baghdad ', 'Middle East ', 'Iraqi', 'Iraqis', 'Iraqi Dinar', 'IQD', 23331985, 'Iraq', '', 'iraq'),
(113, 'Ireland', 'EI', 'IE', 'IRL', '372', 'IE', 'Dublin ', 'Europe ', 'Irish', 'Irishmen', 'Euro', 'EUR', 3840838, 'Ireland', '', 'ireland'),
(114, 'Israel (ישראל)', 'IS', 'IL', 'ISR', '376', 'IL', 'Jerusalem', 'Middle East ', 'Israeli', 'Israelis', 'New Israeli Sheqel', 'ILS', 5938093, 'Israel', '', 'israel'),
(115, 'Italy (Italia)', 'IT', 'IT', 'ITA', '380', 'IT', 'Rome ', 'Europe ', 'Italian', 'Italians', 'Euro', 'EUR', 57679825, 'Italia ', '', 'italy-italia'),
(116, 'Jamaica', 'JM', 'JM', 'JAM', '388', 'JM', 'Kingston ', 'Central America and the Caribbean ', 'Jamaican', 'Jamaicans', 'Jamaican dollar ', 'JMD', 2665636, 'Jamaica', '', 'jamaica'),
(117, 'Jan Mayen', 'JN', '--', '-- ', '--', '--', '', 'Arctic Region ', '', '', 'Norway Kroner', 'NOK', 0, 'Jan Mayen', 'ISO includes with Svalbard', 'jan-mayen'),
(118, 'Japan (日本)', 'JA', 'JP', 'JPN', '392', 'JP', 'Tokyo ', 'Asia ', 'Japanese', 'Japanese', 'Yen ', 'JPY', 126771662, 'Japan', '', 'japan'),
(119, 'Jarvis Island', 'DQ', '--', '-- ', '--', '--', '', 'Oceania ', '', '', '', '', 0, 'Jarvis Island', 'ISO includes with the US Minor Outlying Islands', 'jarvis-island'),
(120, 'Jersey', 'JE', '--', '-- ', '--', 'JE', 'Saint Helier ', 'Europe ', 'Channel Islander', 'Channel Islanders', 'Pound Sterling', 'GBP', 89361, 'Jersey', 'ISO includes with the United Kingdom', 'jersey'),
(121, 'Johnston Atoll', 'JQ', '--', '-- ', '--', '--', '', 'Oceania ', '', '', '', '', 0, 'Johnston Atoll', 'ISO includes with the US Minor Outlying Islands', 'johnston-atoll'),
(122, 'Jordan (الاردن)', 'JO', 'JO', 'JOR', '400', 'JO', 'Amman ', 'Middle East ', 'Jordanian', 'Jordanians', 'Jordanian Dinar', 'JOD', 5153378, 'Jordan', '', 'jordan'),
(123, 'Juan de Nova Island', 'JU', '--', '-- ', '--', '--', '', 'Africa ', '', '', '', '', 0, 'Juan de Nova Island', 'ISO includes with the Miscellaneous (French) Indian Ocean Islands', 'juan-de-nova-island'),
(124, 'Kazakhstan (Қазақстан)', 'KZ', 'KZ', 'KAZ', '398', 'KZ', 'Astana ', 'Commonwealth of Independent States ', 'Kazakhstani', 'Kazakhstanis', 'Tenge', 'KZT', 16731303, 'Kazakhstan', '', 'kazakhstan'),
(125, 'Kenya', 'KE', 'KE', 'KEN', '404', 'KE', 'Nairobi ', 'Africa ', 'Kenyan', 'Kenyans', 'Kenyan shilling ', 'KES', 30765916, 'Kenya', '', 'kenya'),
(126, 'Kingman Reef', 'KQ', '--', '-- ', '--', '--', '', 'Oceania ', '', '', '', '', 0, 'Kingman Reef', 'ISO includes with the US Minor Outlying Islands', 'kingman-reef'),
(127, 'Kiribati', 'KR', 'KI', 'KIR', '296', 'KI', 'Tarawa ', 'Oceania ', 'I-Kiribati', 'I-Kiribati', 'Australian dollar ', 'AUD', 94149, 'Kiribati', '', 'kiribati'),
(128, 'Kuwait (الكويت)', 'KU', 'KW', 'KWT', '414', 'KW', 'Kuwait ', 'Middle East ', 'Kuwaiti', 'Kuwaitis', 'Kuwaiti Dinar', 'KWD', 2041961, 'Al Kuwayt', '', 'kuwait'),
(129, 'Kyrgyzstan (Кыргызстан)', 'KG', 'KG', 'KGZ', '417', 'KG', 'Bishkek ', 'Commonwealth of Independent States ', 'Kyrgyzstani', 'Kyrgyzstanis', 'Som', 'KGS', 4753003, 'Kyrgyzstan', '', 'kyrgyzstan'),
(130, 'Laos (ນລາວ)', 'LA', 'LA', 'LAO', '418', 'LA', 'Vientiane ', 'Southeast Asia ', 'Lao', 'Laos', 'Kip', 'LAK', 5635967, 'Laos', '', 'laos'),
(131, 'Latvia (Latvija)', 'LG', 'LV', 'LVA', '428', 'LV', 'Riga ', 'Europe ', 'Latvian', 'Latvians', 'Latvian Lats', 'LVL', 2385231, 'Latvia', '', 'latvia-latvija'),
(132, 'Lebanon (لبنان)', 'LE', 'LB', 'LBN', '422', 'LB', 'Beirut ', 'Middle East ', 'Lebanese', 'Lebanese', 'Lebanese Pound', 'LBP', 3627774, 'Lebanon', '', 'lebanon'),
(133, 'Lesotho', 'LT', 'LS', 'LSO', '426', 'LS', 'Maseru ', 'Africa ', 'Basotho', 'Mosotho', 'Loti', 'LSL', 2177062, 'Lesotho', '', 'lesotho'),
(134, 'Liberia', 'LI', 'LR', 'LBR', '430', 'LR', 'Monrovia ', 'Africa ', 'Liberian', 'Liberians', 'Liberian Dollar', 'LRD', 3225837, 'Liberia', '', 'liberia'),
(135, 'Libya (ليبيا)', 'LY', 'LY', 'LBY', '434', 'LY', 'Tripoli ', 'Africa ', 'Libyan', 'Libyans', 'Libyan Dinar', 'LYD', 5240599, 'Libya', '', 'libya'),
(136, 'Liechtenstein', 'LS', 'LI', 'LIE', '438', 'LI', 'Vaduz ', 'Europe ', 'Liechtenstein', 'Liechtensteiners', 'Swiss Franc', 'CHF', 32528, 'Liechtenstein', '', 'liechtenstein'),
(137, 'Lithuania (Lietuva)', 'LH', 'LT', 'LTU', '440', 'LT', 'Vilnius ', 'Europe ', 'Lithuanian', 'Lithuanians', 'Lithuanian Litas', 'LTL', 3610535, 'Lithuania', '', 'lithuania-lietuva'),
(138, 'Luxembourg (Lëtzebuerg)', 'LU', 'LU', 'LUX', '442', 'LU', 'Luxembourg ', 'Europe ', 'Luxembourg', 'Luxembourgers', 'Euro', 'EUR', 442972, 'Luxembourg', '', 'luxembourg-l-tzebuerg'),
(139, 'Macao', 'MC', 'MO', 'MAC', '446', 'MO', '', 'Southeast Asia ', 'Chinese', 'Chinese', 'Pataca', 'MOP', 453733, 'Macao', '', 'macao'),
(140, 'Macedonia (Македонија)', 'MK', 'MK', 'MKD', '807', 'MK', 'Skopje ', 'Europe ', 'Macedonian', 'Macedonians', 'Denar', 'MKD', 2046209, 'Makedonija', '', 'macedonia'),
(141, 'Madagascar (Madagasikara)', 'MA', 'MG', 'MDG', '450', 'MG', 'Antananarivo ', 'Africa ', 'Malagasy', 'Malagasy', 'Malagasy Franc', 'MGF', 15982563, 'Madagascar', '', 'madagascar-madagasikara'),
(142, 'Malawi', 'MI', 'MW', 'MWI', '454', 'MW', 'Lilongwe ', 'Africa ', 'Malawian', 'Malawians', 'Kwacha', 'MWK', 10548250, 'Malawi', '', 'malawi'),
(143, 'Malaysia', 'MY', 'MY', 'MYS', '458', 'MY', 'Kuala Lumpur ', 'Southeast Asia ', 'Malaysian', 'Malaysians', 'Malaysian Ringgit', 'MYR', 22229040, 'Malaysia', '', 'malaysia'),
(144, 'Maldives (ގުޖޭއްރާ ޔާއްރިހޫމްޖ)', 'MV', 'MV', 'MDV', '462', 'MV', 'Male ', 'Asia ', 'Maldivian', 'Maldivians', 'Rufiyaa', 'MVR', 310764, 'Maldives', '', 'maldives'),
(145, 'Mali', 'ML', 'ML', 'MLI', '466', 'ML', 'Bamako ', 'Africa ', 'Malian', 'Malians', 'CFA Franc BCEAO', 'XOF', 11008518, 'Mali', '', 'mali'),
(146, 'Malta', 'MT', 'MT', 'MLT', '470', 'MT', 'Valletta ', 'Europe ', 'Maltese', 'Maltese', 'Maltese Lira', 'MTL', 394583, 'Malta', '', 'malta'),
(147, 'Man, Isle of', 'IM', '--', '-- ', '--', 'IM', 'Douglas ', 'Europe ', 'Manxman', 'Manxmen', 'Pound Sterling', 'GBP', 73489, 'The Isle of Man', 'ISO includes with the United Kingdom', 'man-isle-of'),
(148, 'Marshall Islands', 'RM', 'MH', 'MHL', '584', 'MH', 'Majuro ', 'Oceania ', 'Marshallese', 'Marshallese', 'US Dollar', 'USD', 70822, 'The Marshall Islands', '', 'marshall-islands'),
(149, 'Martinique', 'MB', 'MQ', 'MTQ', '474', 'MQ', 'Fort-de-France ', 'Central America and the Caribbean ', 'Martiniquais', 'Martiniquais', 'Euro', 'EUR', 418454, 'Martinique', '', 'martinique'),
(150, 'Mauritania (موريتانيا)', 'MR', 'MR', 'MRT', '478', 'MR', 'Nouakchott ', 'Africa ', 'Mauritanian', 'Mauritanians', 'Ouguiya', 'MRO', 2747312, 'Mauritania', '', 'mauritania'),
(151, 'Mauritius', 'MP', 'MU', 'MUS', '480', 'MU', 'Port Louis ', 'World ', 'Mauritian', 'Mauritians', 'Mauritius Rupee', 'MUR', 1189825, 'Mauritius', '', 'mauritius'),
(152, 'Mayotte', 'MF', 'YT', 'MYT', '175', 'YT', 'Mamoutzou ', 'Africa ', 'Mahorais', 'Mahorais', 'Euro', 'EUR', 163366, 'Mayotte', '', 'mayotte'),
(153, 'Mexico (México)', 'MX', 'MX', 'MEX', '484', 'MX', 'Mexico ', 'North America ', 'Mexican', 'Mexicans', 'Mexican Peso', 'MXN', 101879171, 'Mexico', '', 'mexico-m-xico'),
(154, 'Micronesia', 'FM', 'FM', 'FSM', '583', 'FM', 'Palikir ', 'Oceania ', 'Micronesian', 'Micronesians', 'US Dollar', 'USD', 134597, 'The Federated States of Micronesia', '', 'micronesia'),
(155, 'Midway Islands', 'MQ', '--', '-- ', '--', '--', '', 'Oceania ', '', '', 'United States Dollars', 'USD', 0, 'The Midway Islands', 'ISO includes with the US Minor Outlying Islands', 'midway-islands'),
(156, 'Miscellaneous (French)', '--', '--', '-- ', '--', '--', '', '', '', '', '', '', 0, 'Miscellaneous (French)', 'ISO includes Bassas da India, Europa Island, Glorioso Islands, Juan de Nova Island, Tromelin Island', 'miscellaneous-french'),
(157, 'Moldova', 'MD', 'MD', 'MDA', '498', 'MD', 'Chisinau ', 'Commonwealth of Independent States ', 'Moldovan', 'Moldovans', 'Moldovan Leu', 'MDL', 4431570, 'Moldova', '', 'moldova'),
(158, 'Monaco', 'MN', 'MC', 'MCO', '492', 'MC', 'Monaco ', 'Europe ', 'Monegasque', 'Monegasques', 'Euro', 'EUR', 31842, 'Monaco', '', 'monaco'),
(159, 'Mongolia (Монгол Улс)', 'MG', 'MN', 'MNG', '496', 'MN', 'Ulaanbaatar ', 'Asia ', 'Mongolian', 'Mongolians', 'Tugrik', 'MNT', 2654999, 'Mongolia', '', 'mongolia'),
(160, 'Montenegro', '--', '--', '-- ', '--', '--', '', '', '', '', '', '', 0, 'Montenegro', 'now included as region within Yugoslavia', 'montenegro'),
(161, 'Montserrat', 'MH', 'MS', 'MSR', '500', 'MS', 'Plymouth', 'Central America and the Caribbean ', 'Montserratian', 'Montserratians', 'East Caribbean Dollar', 'XCD', 7574, 'Montserrat', '', 'montserrat'),
(162, 'Morocco (المغرب)', 'MO', 'MA', 'MAR', '504', 'MA', 'Rabat ', 'Africa ', 'Moroccan', 'Moroccans', 'Moroccan Dirham', 'MAD', 30645305, 'Morocco', '', 'morocco'),
(163, 'Mozambique (Moçambique)', 'MZ', 'MZ', 'MOZ', '508', 'MZ', 'Maputo ', 'Africa ', 'Mozambican', 'Mozambicans', 'Metical', 'MZM', 19371057, 'Mozambique', '', 'mozambique-mo-ambique'),
(164, 'Myanmar', '--', '--', '-- ', '--', '--', '', '', '', '', 'Kyat', 'MMK', 0, 'Myanmar', 'see Burma', 'myanmar-1'),
(165, 'Myanmar (Burma)', 'BM', 'MM', 'MMR', '104', 'MM', 'Rangoon ', 'Southeast Asia ', 'Burmese', 'Burmese', 'kyat ', 'MMK', 41994678, 'Burma', 'ISO uses the name Myanmar', 'myanmar-burma'),
(166, 'Namibia', 'WA', 'NA', 'NAM', '516', 'NA', 'Windhoek ', 'Africa ', 'Namibian', 'Namibians', 'Namibian Dollar ', 'NAD', 1797677, 'Namibia', '', 'namibia'),
(167, 'Nauru (Naoero)', 'NR', 'NR', 'NRU', '520', 'NR', '', 'Oceania ', 'Nauruan', 'Nauruans', 'Australian Dollar', 'AUD', 12088, 'Nauru', '', 'nauru-naoero'),
(168, 'Navassa Island', 'BQ', '--', '-- ', '--', '--', '', 'Central America and the Caribbean ', '', '', '', '', 0, 'Navassa Island', '', 'navassa-island'),
(169, 'Nepal (नेपाल)', 'NP', 'NP', 'NPL', '524', 'NP', 'Kathmandu ', 'Asia ', 'Nepalese', 'Nepalese', 'Nepalese Rupee', 'NPR', 25284463, 'Nepal', '', 'nepal'),
(170, 'Netherlands (Nederland)', 'NL', 'NL', 'NLD', '528', 'NL', 'Amsterdam ', 'Europe ', 'Dutchman', 'Dutchmen', 'Euro', 'EUR', 15981472, 'The Netherlands', '', 'netherlands-nederland'),
(171, 'Netherlands Antilles', 'NT', 'AN', 'ANT', '530', 'AN', 'Willemstad ', 'Central America and the Caribbean ', 'Dutch Antillean', 'Dutch Antilleans', 'Netherlands Antillean guilder ', 'ANG', 212226, 'The Netherlands Antilles', '', 'netherlands-antilles'),
(172, 'New Caledonia', 'NC', 'NC', 'NCL', '540', 'NC', 'Noumea ', 'Oceania ', 'New Caledonian', 'New Caledonians', 'CFP Franc', 'XPF', 204863, 'New Caledonia', '', 'new-caledonia'),
(173, 'New Zealand', 'NZ', 'NZ', 'NZL', '554', 'NZ', 'Wellington ', 'Oceania ', 'New Zealand', 'New Zealanders', 'New Zealand Dollar', 'NZD', 3864129, 'New Zealand', '', 'new-zealand'),
(174, 'Nicaragua', 'NU', 'NI', 'NIC', '558', 'NI', 'Managua ', 'Central America and the Caribbean ', 'Nicaraguan', 'Nicaraguans', 'Cordoba Oro', 'NIO', 4918393, 'Nicaragua', '', 'nicaragua'),
(175, 'Niger', 'NG', 'NE', 'NER', '562', 'NE', 'Niamey ', 'Africa ', 'Nigerien', 'Nigeriens', 'CFA Franc BCEAO', 'XOF', 10355156, 'Niger', '', 'niger'),
(176, 'Nigeria', 'NI', 'NG', 'NGA', '566', 'NG', 'Abuja', 'Africa ', 'Nigerian', 'Nigerians', 'Naira', 'NGN', 126635626, 'Nigeria', '', 'nigeria'),
(177, 'Niue', 'NE', 'NU', 'NIU', '570', 'NU', 'Alofi ', 'Oceania ', 'Niuean', 'Niueans', 'New Zealand Dollar', 'NZD', 2124, 'Niue', '', 'niue'),
(178, 'Norfolk Island', 'NF', 'NF', 'NFK', '574', 'NF', 'Kingston ', 'Oceania ', 'Norfolk Islander', 'Norfolk Islanders', 'Australian Dollar', 'AUD', 1879, 'Norfolk Island', '', 'norfolk-island'),
(179, 'North Korea (조선)', 'KN', 'KP', 'PRK', '408', 'KP', 'P''yongyang ', 'Asia ', 'Korean', 'Koreans', 'North Korean Won', 'KPW', 21968228, 'North Korea', '', 'north-korea'),
(180, 'Northern Mariana Islands', 'CQ', 'MP', 'MNP', '580', 'MP', 'Saipan ', 'Oceania ', '', '', 'US Dollar', 'USD', 74612, 'The Northern Mariana Islands', '', 'northern-mariana-islands'),
(181, 'Norway (Norge)', 'NO', 'NO', 'NOR', '578', 'NO', 'Oslo ', 'Europe ', 'Norwegian', 'Norwegians', 'Norwegian Krone', 'NOK', 4503440, 'Norway', '', 'norway-norge'),
(182, 'Oman (عمان)', 'MU', 'OM', 'OMN', '512', 'OM', 'Muscat ', 'Middle East ', 'Omani', 'Omanis', 'Rial Omani', 'OMR', 2622198, 'Oman', '', 'oman'),
(183, 'Pakistan (پاکستان)', 'PK', 'PK', 'PAK', '586', 'PK', 'Islamabad ', 'Asia ', 'Pakistani', 'Pakistanis', 'Pakistan Rupee', 'PKR', 144616639, 'Pakistan', '', 'pakistan'),
(184, 'Palau (Belau)', 'PS', 'PW', 'PLW', '585', 'PW', 'Koror ', 'Oceania ', 'Palauan', 'Palauans', 'US Dollar', 'USD', 19092, 'Palau', '', 'palau-belau'),
(185, 'Palestinian Territories', '--', 'PS', 'PSE', '275', 'PS', '', '', '', '', '', '', 0, 'Palestine', 'NULL', 'palestinian-territories'),
(186, 'Palmyra Atoll', 'LQ', '--', '-- ', '--', '--', '', 'Oceania ', '', '', '', '', 0, 'Palmyra Atoll', 'ISO includes with the US Minor Outlying Islands', 'palmyra-atoll'),
(187, 'Panama (Panamá)', 'PM', 'PA', 'PAN', '591', 'PA', 'Panama ', 'Central America and the Caribbean ', 'Panamanian', 'Panamanians', 'balboa ', 'PAB', 2845647, 'Panama', '', 'panama-panam'),
(188, 'Papua New Guinea', 'PP', 'PG', 'PNG', '598', 'PG', 'Port Moresby ', 'Oceania ', 'Papua New Guinean', 'Papua New Guineans', 'Kina', 'PGK', 5049055, 'Papua New Guinea', '', 'papua-new-guinea'),
(189, 'Paracel Islands', 'PF', '--', '-- ', '--', '--', '', 'Southeast Asia ', '', '', '', '', 0, 'The Paracel Islands', '', 'paracel-islands'),
(190, 'Paraguay', 'PA', 'PY', 'PRY', '600', 'PY', 'Asuncion ', 'South America ', 'Paraguayan', 'Paraguayans', 'Guarani', 'PYG', 5734139, 'Paraguay', '', 'paraguay'),
(191, 'Peru (Perú)', 'PE', 'PE', 'PER', '604', 'PE', 'Lima ', 'South America ', 'Peruvian', 'Peruvians', 'Nuevo Sol', 'PEN', 27483864, 'Peru', '', 'peru-per'),
(192, 'Philippines (Pilipinas)', 'RP', 'PH', 'PHL', '608', 'PH', 'Manila ', 'Southeast Asia ', 'Philippine', 'Filipinos', 'Philippine Peso', 'PHP', 82841518, 'The Philippines', '', 'philippines-pilipinas'),
(193, 'Pitcairn', 'PC', 'PN', 'PCN', '612', 'PN', 'Adamstown ', 'Oceania ', 'Pitcairn Islander', 'Pitcairn Islanders', 'New Zealand Dollar', 'NZD', 47, 'The Pitcairn Islands', '', 'pitcairn'),
(194, 'Poland (Polska)', 'PL', 'PL', 'POL', '616', 'PL', 'Warsaw ', 'Europe ', 'Polish', 'Poles', 'Zloty', 'PLN', 38633912, 'Poland', '', 'poland-polska'),
(195, 'Portugal', 'PO', 'PT', 'PRT', '620', 'PT', 'Lisbon ', 'Europe ', 'Portuguese', 'Portuguese', 'Euro', 'EUR', 10066253, 'Portugal', '', 'portugal'),
(196, 'Puerto Rico', 'RQ', 'PR', 'PRI', '630', 'PR', 'San Juan ', 'Central America and the Caribbean ', 'Puerto Rican', 'Puerto Ricans', 'US Dollar', 'USD', 3937316, 'Puerto Rico', '', 'puerto-rico'),
(197, 'Qatar (قطر)', 'QA', 'QA', 'QAT', '634', 'QA', 'Doha ', 'Middle East ', 'Qatari', 'Qataris', 'Qatari Rial', 'QAR', 769152, 'Qatar', '', 'qatar'),
(198, 'Reunion', 'RE', 'RE', 'REU', '638', 'RE', 'Saint-Denis', 'World', 'Reunionese', 'Reunionese', 'Euro', 'EUR', 732570, 'Réunion', '', 'reunion'),
(199, 'Romania (România)', 'RO', 'RO', 'ROU', '642', 'RO', 'Bucharest ', 'Europe ', 'Romanian', 'Romanians', 'Leu', 'ROL', 22364022, 'Romania', '', 'romania-rom-nia'),
(200, 'Russia (Россия)', 'RS', 'RU', 'RUS', '643', 'RU', 'Moscow ', 'Asia ', 'Russian', 'Russians', 'Russian Ruble', 'RUB', 145470197, 'Russia', '', 'russia'),
(201, 'Rwanda', 'RW', 'RW', 'RWA', '646', 'RW', 'Kigali ', 'Africa ', 'Rwandan', 'Rwandans', 'Rwanda Franc', 'RWF', 7312756, 'Rwanda', '', 'rwanda'),
(202, 'Saint Helena', 'SH', 'SH', 'SHN', '654', 'SH', 'Jamestown ', 'Africa ', 'Saint Helenian', 'Saint Helenians', 'Saint Helenian Pound ', 'SHP', 7266, 'Saint Helena', '', 'saint-helena'),
(203, 'Saint Kitts and Nevis', 'SC', 'KN', 'KNA', '659', 'KN', 'Basseterre ', 'Central America and the Caribbean ', 'Kittitian and Nevisian', 'Kittitians and Nevisians', 'East Caribbean Dollar ', 'XCD', 38756, 'Saint Kitts and Nevis', '', 'saint-kitts-and-nevis'),
(204, 'Saint Lucia', 'ST', 'LC', 'LCA', '662', 'LC', 'Castries ', 'Central America and the Caribbean ', 'Saint Lucian', 'Saint Lucians', 'East Caribbean Dollar ', 'XCD', 158178, 'Saint Lucia', '', 'saint-lucia'),
(205, 'Saint Pierre and Miquelon', 'SB', 'PM', 'SPM', '666', 'PM', 'Saint-Pierre ', 'North America ', 'Frenchman', 'Frenchmen', 'Euro', 'EUR', 6928, 'Saint Pierre and Miquelon', '', 'saint-pierre-and-miquelon'),
(206, 'Saint Vincent and the Grenadines', 'VC', 'VC', 'VCT', '670', 'VC', 'Kingstown ', 'Central America and the Caribbean ', 'Saint Vincentian', 'Saint Vincentians', 'East Caribbean Dollar ', 'XCD', 115942, 'Saint Vincent and the Grenadines', '', 'saint-vincent-and-the-grenadines'),
(207, 'Samoa', 'WS', 'WS', 'WSM', '882', 'WS', 'Apia ', 'Oceania ', 'Samoan', 'Samoans', 'Tala', 'WST', 179058, 'Samoa', 'NULL', 'samoa'),
(208, 'San Marino', 'SM', 'SM', 'SMR', '674', 'SM', 'San Marino ', 'Europe ', 'Sammarinese', 'Sammarinese', 'Euro', 'EUR', 27336, 'San Marino', '', 'san-marino'),
(209, 'São Tomé and Príncipe', 'TP', 'ST', 'STP', '678', 'ST', 'Sao Tome', 'Africa', 'Sao Tomean', 'Sao Tomeans', 'Dobra', 'STD', 165034, 'São Tomé and Príncipe', '', 's-o-tom-and-pr-ncipe'),
(210, 'Saudi Arabia (المملكة العربية السعودية)', 'SA', 'SA', 'SAU', '682', 'SA', 'Riyadh ', 'Middle East ', 'Saudi Arabian ', 'Saudis', 'Saudi Riyal', 'SAR', 22757092, 'Saudi Arabia', '', 'saudi-arabia'),
(211, 'Senegal (Sénégal)', 'SG', 'SN', 'SEN', '686', 'SN', 'Dakar ', 'Africa ', 'Senegalese', 'Senegalese', 'CFA Franc BCEAO', 'XOF', 10284929, 'Senegal', '', 'senegal-s-n-gal'),
(212, 'Serbia', '--', '--', '-- ', '--', '--', '', '', '', '', '', '', 0, 'Serbia', 'now included as region within Yugoslavia', 'serbia'),
(213, 'Serbia and Montenegro', '--', '--', '-- ', '--', '--', '', '', '', '', '', '', 0, 'Serbia and Montenegro', 'See Yugoslavia', 'serbia-and-montenegro'),
(214, 'Seychelles', 'SE', 'SC', 'SYC', '690', 'SC', 'Victoria ', 'Africa ', 'Seychellois', 'Seychellois', 'Seychelles Rupee', 'SCR', 79715, 'Seychelles', '', 'seychelles'),
(215, 'Sierra Leone', 'SL', 'SL', 'SLE', '694', 'SL', 'Freetown ', 'Africa ', 'Sierra Leonean', 'Sierra Leoneans', 'Leone', 'SLL', 5426618, 'Sierra Leone', '', 'sierra-leone'),
(216, 'Singapore (Singapura)', 'SN', 'SG', 'SGP', '702', 'SG', 'Singapore ', 'Southeast Asia ', 'Singaporeian', 'Singaporeans', 'Singapore Dollar', 'SGD', 4300419, 'Singapore', '', 'singapore-singapura'),
(217, 'Slovakia (Slovensko)', 'LO', 'SK', 'SVK', '703', 'SK', 'Bratislava ', 'Europe ', 'Slovakian', 'Slovaks', 'Slovak Koruna', 'SKK', 5414937, 'Slovakia', '', 'slovakia-slovensko'),
(218, 'Slovenia (Slovenija)', 'SI', 'SI', 'SVN', '705', 'SI', 'Ljubljana ', 'Europe ', 'Slovenian', 'Slovenes', 'Euro', 'EUR', 1930132, 'Slovenia', '', 'slovenia-slovenija'),
(219, 'Solomon Islands', 'BP', 'SB', 'SLB', '90', 'SB', 'Honiara ', 'Oceania ', 'Solomon Islander', 'Solomon Islanders', 'Solomon Islands Dollar', 'SBD', 480442, 'The Solomon Islands', '', 'solomon-islands'),
(220, 'Somalia (Soomaaliya)', 'SO', 'SO', 'SOM', '706', 'SO', 'Mogadishu ', 'Africa ', 'Somali', 'Somalis', 'Somali Shilling', 'SOS', 7488773, 'Somalia', '', 'somalia-soomaaliya'),
(221, 'South Africa', 'SF', 'ZA', 'ZAF', '710', 'ZA', 'Pretoria', 'Africa ', 'South African', 'South Africans', 'Rand', 'ZAR', 43586097, 'South Africa', '', 'south-africa'),
(222, 'South Georgia and the South Sandwich Islands', 'SX', 'GS', 'SGS', '239', 'GS', '', 'Antarctic Region ', '', '', 'Pound Sterling', 'GBP', 0, 'The South Georgia and the South Sandwich Islands', '', 'south-georgia-and-the-south-sandwich-islands'),
(223, 'South Korea (한국)', 'KS', 'KR', 'KOR', '410', 'KR', 'Seoul ', 'Asia ', 'Korean', 'Koreans', 'Won', 'KRW', 47904370, 'South Korea', '', 'south-korea'),
(224, 'Spain (España)', 'SP', 'ES', 'ESP', '724', 'ES', 'Madrid ', 'Europe ', 'Spanish', 'Spaniards', 'Euro', 'EUR', 40037995, 'Spain', '', 'spain-espa-a'),
(225, 'Spratly Islands', 'PG', '--', '-- ', '--', '--', '', 'Southeast Asia ', '', '', '', '', 0, 'The Spratly Islands', '', 'spratly-islands'),
(226, 'Sri Lanka', 'CE', 'LK', 'LKA', '144', 'LK', 'Colombo', 'Asia ', 'Sri Lankan', 'Sri Lankans', 'Sri Lanka Rupee', 'LKR', 19408635, 'Sri Lanka', '', 'sri-lanka'),
(227, 'Sudan (السودان)', 'SU', 'SD', 'SDN', '736', 'SD', 'Khartoum ', 'Africa ', 'Sudanese', 'Sudanese', 'Sudanese Dinar', 'SDD', 36080373, 'Sudan', '', 'sudan'),
(228, 'Suriname', 'NS', 'SR', 'SUR', '740', 'SR', 'Paramaribo ', 'South America ', 'Surinamese', 'Surinamers', 'Suriname Guilder', 'SRG', 433998, 'Suriname', '', 'suriname'),
(229, 'Svalbard and Jan Mayen', 'SV', 'SJ', 'SJM', '744', 'SJ', 'Longyearbyen ', 'Arctic Region ', '', '', 'Norwegian Krone', 'NOK', 2332, 'Svalbard', 'ISO includes Jan Mayen', 'svalbard-and-jan-mayen'),
(230, 'Swaziland', 'WZ', 'SZ', 'SWZ', '748', 'SZ', 'Mbabane ', 'Africa ', 'Swazi', 'Swazis', 'Lilangeni', 'SZL', 1104343, 'Swaziland', '', 'swaziland'),
(231, 'Sweden (Sverige)', 'SW', 'SE', 'SWE', '752', 'SE', 'Stockholm ', 'Europe ', 'Swedish', 'Swedes', 'Swedish Krona', 'SEK', 8875053, 'Sweden', '', 'sweden-sverige'),
(232, 'Switzerland (Schweiz)', 'SZ', 'CH', 'CHE', '756', 'CH', 'Bern ', 'Europe ', 'Swiss', 'Swiss', 'Swiss Franc', 'CHF', 7283274, 'Switzerland', '', 'switzerland-schweiz'),
(233, 'Syria (سوريا)', 'SY', 'SY', 'SYR', '760', 'SY', 'Damascus ', 'Middle East ', 'Syrian', 'Syrians', 'Syrian Pound', 'SYP', 16728808, 'Syria', '', 'syria'),
(234, 'Taiwan (台灣)', 'TW', 'TW', 'TWN', '158', 'TW', 'Taipei ', 'Southeast Asia ', 'Taiwanese', 'Taiwanese', 'New Taiwan Dollar', 'TWD', 22370461, 'Taiwan', '', 'taiwan'),
(235, 'Tajikistan (Тоҷикистон)', 'TI', 'TJ', 'TJK', '762', 'TJ', 'Dushanbe ', 'Commonwealth of Independent States ', 'Tajikistani', 'Tajikistanis', 'Somoni', 'TJS', 6578681, 'Tajikistan', '', 'tajikistan'),
(236, 'Tanzania', 'TZ', 'TZ', 'TZA', '834', 'TZ', 'Dar es Salaam', 'Africa ', 'Tanzanian', 'Tanzanians', 'Tanzanian Shilling', 'TZS', 36232074, 'Tanzania', '', 'tanzania'),
(237, 'Thailand (ราชอาณาจักรไทย)', 'TH', 'TH', 'THA', '764', 'TH', 'Bangkok ', 'Southeast Asia ', 'Thai', 'Thai', 'Baht', 'THB', 61797751, 'Thailand', '', 'thailand'),
(238, 'Timor-Leste', 'TT', 'TL', 'TLS', '626', 'TP', '', '', '', '', 'Timor Escudo', 'TPE', 1040880, 'East Timor', 'NULL', 'timor-leste'),
(239, 'Togo', 'TO', 'TG', 'TGO', '768', 'TG', 'Lome ', 'Africa ', 'Togolese', 'Togolese', 'CFA Franc BCEAO', 'XOF', 5153088, 'Togo', '', 'togo'),
(240, 'Tokelau', 'TL', 'TK', 'TKL', '772', 'TK', '', 'Oceania ', 'Tokelauan', 'Tokelauans', 'New Zealand Dollar', 'NZD', 1445, 'Tokelau', '', 'tokelau'),
(241, 'Tonga', 'TN', 'TO', 'TON', '776', 'TO', 'Nuku''alofa ', 'Oceania ', 'Tongan', 'Tongans', 'Pa''anga', 'TOP', 104227, 'Tonga', '', 'tonga'),
(242, 'Trinidad and Tobago', 'TD', 'TT', 'TTO', '780', 'TT', 'Port-of-Spain ', 'Central America and the Caribbean ', 'Trinidadian and Tobagonian', 'Trinidadians and Tobagonians', 'Trinidad and Tobago Dollar', 'TTD', 1169682, 'Trinidad and Tobago', '', 'trinidad-and-tobago'),
(243, 'Tromelin Island', 'TE', '--', '-- ', '--', '--', '', 'Africa ', '', '', '', '', 0, 'Tromelin Island', 'ISO includes with the Miscellaneous (French) Indian Ocean Islands', 'tromelin-island'),
(244, 'Tunisia (تونس)', 'TS', 'TN', 'TUN', '788', 'TN', 'Tunis ', 'Africa ', 'Tunisian', 'Tunisians', 'Tunisian Dinar', 'TND', 9705102, 'Tunisia', '', 'tunisia'),
(245, 'Turkey (Türkiye)', 'TU', 'TR', 'TUR', '792', 'TR', 'Ankara ', 'Middle East ', 'Turkish', 'Turks', 'Turkish Lira', 'TRL', 66493970, 'Turkey', '', 'turkey-t-rkiye'),
(246, 'Turkmenistan (Türkmenistan)', 'TX', 'TM', 'TKM', '795', 'TM', 'Ashgabat ', 'Commonwealth of Independent States ', 'Turkmen', 'Turkmens', 'Manat', 'TMM', 4603244, 'Turkmenistan', '', 'turkmenistan-t-rkmenistan'),
(247, 'Turks and Caicos Islands', 'TK', 'TC', 'TCA', '796', 'TC', 'Cockburn Town ', 'Central America and the Caribbean ', '', '', 'US Dollar', 'USD', 18122, 'The Turks and Caicos Islands', '', 'turks-and-caicos-islands'),
(248, 'Tuvalu', 'TV', 'TV', 'TUV', '798', 'TV', 'Funafuti ', 'Oceania ', 'Tuvaluan', 'Tuvaluans', 'Australian Dollar', 'AUD', 10991, 'Tuvalu', '', 'tuvalu'),
(249, 'Uganda', 'UG', 'UG', 'UGA', '800', 'UG', 'Kampala ', 'Africa ', 'Ugandan', 'Ugandans', 'Uganda Shilling', 'UGX', 23985712, 'Uganda', '', 'uganda'),
(250, 'Ukraine (Україна)', 'UP', 'UA', 'UKR', '804', 'UA', 'Kiev ', 'Commonwealth of Independent States ', 'Ukrainian', 'Ukrainians', 'Hryvnia', 'UAH', 48760474, 'The Ukraine', '', 'ukraine'),
(251, 'United Arab Emirates (الإمارات العربيّة المتّحدة)', 'AE', 'AE', 'ARE', '784', 'AE', 'Abu Dhabi ', 'Middle East ', 'Emirati', 'Emiratis', 'UAE Dirham', 'AED', 2407460, 'The United Arab Emirates', '', 'united-arab-emirates'),
(252, 'United Kingdom', 'UK', 'GB', 'GBR', '826', 'UK', 'London ', 'Europe ', 'British', 'Britons', 'Pound Sterling', 'GBP', 59647790, 'The United Kingdom', 'ISO includes Guernsey, Isle of Man, Jersey', 'united-kingdom'),
(253, 'United States', 'US', 'US', 'USA', '840', 'US', 'Washington, DC ', 'North America ', 'American', 'Americans', 'US Dollar', 'USD', 278058881, 'The United States', '', 'united-states'),
(254, 'United States minor outlying islands', '--', 'UM', 'UMI', '581', 'UM', '', '', '', '', 'US Dollar', 'USD', 0, 'The United States Minor Outlying Islands', 'ISO includes Baker Island, Howland Island, Jarvis Island, Johnston Atoll, Kingman Reef, Midway Islands, Palmyra Atoll, Wake Island', 'united-states-minor-outlying-islands'),
(255, 'Uruguay', 'UY', 'UY', 'URY', '858', 'UY', 'Montevideo ', 'South America ', 'Uruguayan', 'Uruguayans', 'Peso Uruguayo', 'UYU', 3360105, 'Uruguay', '', 'uruguay'),
(256, 'Uzbekistan (O&#39;zbekiston)', 'UZ', 'UZ', 'UZB', '860', 'UZ', 'Tashkent', 'Commonwealth of Independent States ', 'Uzbekistani', 'Uzbekistanis', 'Uzbekistan Sum', 'UZS', 25155064, 'Uzbekistan', '', 'uzbekistan-o-39-zbekiston'),
(257, 'Vanuatu', 'NH', 'VU', 'VUT', '548', 'VU', 'Port-Vila ', 'Oceania ', 'Ni-Vanuatu', 'Ni-Vanuatu', 'Vatu', 'VUV', 192910, 'Vanuatu', '', 'vanuatu'),
(258, 'Vatican City (Città del Vaticano)', 'VT', 'VA', 'VAT', '336', 'VA', 'Vatican City ', 'Europe ', '', '', 'Euro', 'EUR', 890, 'The Vatican City', '', 'vatican-city-citt-del-vaticano'),
(259, 'Venezuela', 'VE', 'VE', 'VEN', '862', 'VE', 'Caracas ', 'South America, Central America and the Caribbean ', 'Venezuelan', 'Venezuelans', 'Bolivar', 'VEB', 23916810, 'Venezuela', '', 'venezuela'),
(260, 'Vietnam (Việt Nam)', 'VM', 'VN', 'VNM', '704', 'VN', 'Hanoi ', 'Southeast Asia ', 'Vietnamese', 'Vietnamese', 'Dong', 'VND', 79939014, 'Vietnam', '', 'vietnam-vi-t-nam'),
(261, 'Virgin Islands (UK)', '--', '--', '-- ', '--', '--', '', '', '', '', 'US Dollar', 'USD', 0, 'Virgin Islands (UK)', 'see British Virgin Islands', 'virgin-islands-uk'),
(262, 'Virgin Islands (US)', '--', '--', '-- ', '--', '--', '', '', '', '', 'US Dollar', 'USD', 0, 'Virgin Islands (US)', 'see Virgin Islands', 'virgin-islands-us'),
(263, 'Virgin Islands, British', 'VI', 'VG', 'VGB', '92', 'VG', 'Road Town ', 'Central America and the Caribbean ', 'British Virgin Islander', 'British Virgin Islanders', 'US Dollar', 'USD', 20812, 'The British Virgin Islands', '', 'virgin-islands-british'),
(264, 'Virgin Islands, U.S.', 'VQ', 'VI', 'VIR', '850', 'VI', 'Charlotte Amalie ', 'Central America and the Caribbean ', 'Virgin Islander', 'Virgin Islanders', 'US Dollar', 'USD', 122211, 'The Virgin Islands', '', 'virgin-islands-u-s'),
(265, 'Wake Island', 'WQ', '--', '-- ', '--', '--', '', 'Oceania ', '', '', 'US Dollar', 'USD', 0, 'Wake Island', 'ISO includes with the US Minor Outlying Islands', 'wake-island'),
(266, 'Wallis and Futuna', 'WF', 'WF', 'WLF', '876', 'WF', 'Mata-Utu', 'Oceania ', 'Wallis and Futuna Islander', 'Wallis and Futuna Islanders', 'CFP Franc', 'XPF', 15435, 'Wallis and Futuna', '', 'wallis-and-futuna'),
(267, 'West Bank', 'WE', '--', '-- ', '--', '--', '', 'Middle East ', '', '', 'New Israeli Shekel ', 'ILS', 2090713, 'The West Bank', '', 'west-bank'),
(268, 'Western Sahara (الصحراء الغربية)', 'WI', 'EH', 'ESH', '732', 'EH', '', 'Africa ', 'Sahrawian', 'Sahrawis', 'Moroccan Dirham', 'MAD', 250559, 'Western Sahara', '', 'western-sahara'),
(269, 'Western Samoa', '--', '--', '-- ', '--', '--', '', '', '', '', 'Tala', 'WST', 0, 'Western Samoa', 'see Samoa', 'western-samoa'),
(270, 'World', '--', '--', '-- ', '--', '--', '', 'World, Time Zones ', '', '', '', '', 1862433264, 'The World', 'NULL', 'world'),
(271, 'Yemen (اليمن)', 'YM', 'YE', 'YEM', '887', 'YE', 'Sanaa ', 'Middle East ', 'Yemeni', 'Yemenis', 'Yemeni Rial', 'YER', 18078035, 'Yemen', '', 'yemen'),
(272, 'Yugoslavia', 'YI', 'YU', 'YUG', '891', 'YU', 'Belgrade ', 'Europe ', 'Serbian', 'Serbs', 'Yugoslavian Dinar ', 'YUM', 10677290, 'Yugoslavia', 'NULL', 'yugoslavia'),
(273, 'Zaire', '--', '--', '-- ', '--', '--', '', '', '', '', '', '', 0, 'Zaire', 'see Democratic Republic of the Congo', 'zaire'),
(274, 'Zambia', 'ZA', 'ZM', 'ZWB', '894', 'ZM', 'Lusaka ', 'Africa ', 'Zambian', 'Zambians', 'Kwacha', 'ZMK', 9770199, 'Zambia', '', 'zambia'),
(275, 'Zimbabwe', 'ZI', 'ZW', 'ZWE', '716', 'ZW', 'Harare ', 'Africa ', 'Zimbabwean', 'Zimbabweans', 'Zimbabwe Dollar', 'ZWD', 11365366, 'Zimbabwe', '', 'zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `craigslist_categories`
--

DROP TABLE IF EXISTS `craigslist_categories`;
CREATE TABLE IF NOT EXISTS `craigslist_categories` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `code` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `craigslist_categories`
--

INSERT INTO `craigslist_categories` (`id`, `created`, `modified`, `name`, `code`) VALUES
(1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Rooms & Shares', 18),
(2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Sublets & temporary', 39),
(3, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Vacation rentals', 99);

-- --------------------------------------------------------

--
-- Table structure for table `craigslist_markets`
--

DROP TABLE IF EXISTS `craigslist_markets`;
CREATE TABLE IF NOT EXISTS `craigslist_markets` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `code` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `craigslist_markets`
--

INSERT INTO `craigslist_markets` (`id`, `created`, `modified`, `name`, `code`) VALUES
(1, '2011-08-12 16:47:28', '2011-08-12 16:47:28', 'aberdeen', 318),
(2, '2011-08-12 16:47:28', '2011-08-12 16:47:28', 'abilene', 364),
(3, '2011-08-12 16:47:28', '2011-08-12 16:47:28', 'acapulco', 512),
(4, '2011-08-12 16:47:28', '2011-08-12 16:47:28', 'adelaide', 68),
(5, '2011-08-12 16:47:28', '2011-08-12 16:47:28', 'ahmedabad', 450),
(6, '2011-08-12 16:47:28', '2011-08-12 16:47:28', 'akron / canton', 251),
(7, '2011-08-12 16:47:28', '2011-08-12 16:47:28', 'albany', 59),
(8, '2011-08-12 16:47:28', '2011-08-12 16:47:28', 'albany, GA', 637),
(9, '2011-08-12 16:47:28', '2011-08-12 16:47:28', 'albuquerque', 50),
(10, '2011-08-12 16:47:28', '2011-08-12 16:47:28', 'alicante', 533),
(11, '2011-08-12 16:47:28', '2011-08-12 16:47:28', 'altoona', 355),
(12, '2011-08-12 16:47:28', '2011-08-12 16:47:28', 'amarillo', 269),
(13, '2011-08-12 16:47:28', '2011-08-12 16:47:28', 'ames, IA', 445),
(14, '2011-08-12 16:47:28', '2011-08-12 16:47:28', 'amsterdam / randstad', 82),
(15, '2011-08-12 16:47:28', '2011-08-12 16:47:28', 'anchorage / mat', 51),
(16, '2011-08-12 16:47:28', '2011-08-12 16:47:28', 'ann arbor', 172),
(17, '2011-08-12 16:47:28', '2011-08-12 16:47:28', 'annapolis', 460),
(18, '2011-08-12 16:47:28', '2011-08-12 16:47:28', 'appleton', 243),
(19, '2011-08-12 16:47:28', '2011-08-12 16:47:28', 'asheville', 171),
(20, '2011-08-12 16:47:28', '2011-08-12 16:47:28', 'ashtabula', 700),
(21, '2011-08-12 16:47:28', '2011-08-12 16:47:28', 'athens, GA', 258),
(22, '2011-08-12 16:47:28', '2011-08-12 16:47:28', 'athens, OH', 438),
(23, '2011-08-12 16:47:28', '2011-08-12 16:47:28', 'atlanta', 14),
(24, '2011-08-12 16:47:28', '2011-08-12 16:47:28', 'auburn', 372),
(25, '2011-08-12 16:47:28', '2011-08-12 16:47:28', 'auckland, NZ', 69),
(26, '2011-08-12 16:47:28', '2011-08-12 16:47:28', 'augusta', 256),
(27, '2011-08-12 16:47:28', '2011-08-12 16:47:28', 'austin', 15),
(28, '2011-08-12 16:47:28', '2011-08-12 16:47:28', 'bacolod', 606),
(29, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'baja california sur', 406),
(30, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'bakersfield', 63),
(31, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'baleares', 534),
(32, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'baltimore', 34),
(33, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'bangalore', 84),
(34, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'bangladesh', 295),
(35, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'barcelona', 83),
(36, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'barrie', 389),
(37, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'basel', 528),
(38, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'bath', 494),
(39, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'baton rouge', 199),
(40, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'battle creek', 628),
(41, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'beaumont / port arthur', 264),
(42, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'beijing', 154),
(43, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'beirut, lebanon', 296),
(44, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'belfast', 115),
(45, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'belgium', 109),
(46, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'belleville, ON', 483),
(47, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'bellingham', 217),
(48, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'belo horizonte', 513),
(49, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'bemidji', 663),
(50, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'bend', 233),
(51, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'berlin', 108),
(52, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'bern', 529),
(53, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'bhubaneswar', 612),
(54, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'bicol region', 609),
(55, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'bilbao', 535),
(56, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'billings', 657),
(57, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'binghamton', 248),
(58, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'birmingham / west mids', 72),
(59, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'birmingham, AL', 127),
(60, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'bismarck', 666),
(61, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'bloomington, IN', 229),
(62, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'bloomington', 344),
(63, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'boise', 52),
(64, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'bolivia', 578),
(65, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'bologna', 396),
(66, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'boone', 446),
(67, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'bordeaux', 412),
(68, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'boston', 4),
(69, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'boulder', 319),
(70, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'bowling green', 342),
(71, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'bozeman', 658),
(72, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'brainerd', 664),
(73, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'brantford', 626),
(74, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'brasilia', 514),
(75, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'bremen', 522),
(76, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'brighton', 398),
(77, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'brisbane', 66),
(78, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'bristol', 117),
(79, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'brittany', 526),
(80, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'brownsville', 266),
(81, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'brunswick, GA', 570),
(82, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'budapest', 153),
(83, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'buenos aires', 114),
(84, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'buffalo', 40),
(85, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'bulgaria', 584),
(86, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'butte', 661),
(87, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'cadiz', 536),
(88, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'cagayan de oro', 604),
(89, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'cairns', 592),
(90, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'calgary', 77),
(91, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'cambridge, UK', 312),
(92, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'canarias', 537),
(93, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'canberra', 489),
(94, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'cape cod / islands', 239),
(95, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'cape town', 136),
(96, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'cardiff / wales', 116),
(97, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'caribbean islands', 299),
(98, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'cariboo', 621),
(99, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'catskills', 451),
(100, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'cebu', 548),
(101, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'cedar rapids', 340),
(102, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'central louisiana', 644),
(103, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'central michigan', 434),
(104, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'central NJ', 349),
(105, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'champaign urbana', 190),
(106, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'chandigarh', 610),
(107, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'charleston, SC', 128),
(108, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'charleston, WV', 439),
(109, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'charlotte', 41),
(110, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'charlottesville', 290),
(111, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'chatham', 484),
(112, '2011-08-12 16:47:29', '2011-08-12 16:47:29', 'chattanooga', 220),
(113, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'chautauqua', 452),
(114, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'chengdu', 602),
(115, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'chennai (madras)', 182),
(116, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'chicago', 11),
(117, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'chico', 187),
(118, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'chihuahua', 505),
(119, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'chile', 158),
(120, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'chillicothe', 701),
(121, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'chongqing', 601),
(122, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'christchurch', 301),
(123, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'cincinnati, OH', 35),
(124, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'ciudad juarez', 511),
(125, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'clarksville, TN', 465),
(126, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'cleveland', 27),
(127, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'clovis / portales', 653),
(128, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'college station', 326),
(129, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'cologne', 313),
(130, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'colombia', 393),
(131, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'colorado springs', 210),
(132, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'columbia / jeff city', 222),
(133, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'columbia, SC', 101),
(134, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'columbus', 42),
(135, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'columbus, GA', 343),
(136, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'comox valley', 473),
(137, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'cookeville', 670),
(138, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'copenhagen', 107),
(139, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'cornwall, ON', 481),
(140, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'corpus christi', 265),
(141, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'corvallis/albany', 350),
(142, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'costa rica', 179),
(143, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'coventry', 495),
(144, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'croatia', 546),
(145, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'cumberland valley', 705),
(146, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'curitiba', 517),
(147, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'dalian', 600),
(148, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'dallas / fort worth', 21),
(149, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'danville', 367),
(150, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'darwin', 491),
(151, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'davao city', 547),
(152, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'dayton / springfield', 131),
(153, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'daytona beach', 238),
(154, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'decatur, IL', 569),
(155, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'deep east texas', 645),
(156, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'del rio / eagle pass', 647),
(157, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'delaware', 193),
(158, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'delhi', 86),
(159, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'denver', 13),
(160, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'derby', 496),
(161, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'des moines', 98),
(162, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'detroit metro', 22),
(163, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'devon', 399),
(164, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'dominican republic', 617),
(165, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'dothan, AL', 467),
(166, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'dresden', 521),
(167, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'dublin', 74),
(168, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'dubuque', 362),
(169, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'duluth / superior', 255),
(170, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'dundee', 498),
(171, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'dunedin', 594),
(172, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'durban', 303),
(173, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'dusseldorf', 418),
(174, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'east anglia', 402),
(175, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'east idaho', 424),
(176, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'east midlands', 400),
(177, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'east oregon', 322),
(178, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'eastern CO', 713),
(179, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'eastern CT', 281),
(180, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'eastern kentucky', 674),
(181, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'eastern NC', 335),
(182, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'eastern panhandle', 444),
(183, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'eastern shore', 328),
(184, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'eau claire', 242),
(185, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'ecuador', 545),
(186, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'edinburgh', 75),
(187, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'edmonton', 78),
(188, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'egypt', 162),
(189, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'el paso', 132),
(190, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'el salvador', 587),
(191, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'elko', 652),
(192, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'elmira', 453),
(193, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'erie, PA', 275),
(194, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'essen / ruhr', 523),
(195, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'essex', 497),
(196, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'ethiopia', 576),
(197, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'eugene', 94),
(198, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'evansville', 227),
(199, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'fairbanks', 677),
(200, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'fargo / moorhead', 435),
(201, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'farmington, NM', 568),
(202, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'faro / algarve', 542),
(203, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'fayetteville', 273),
(204, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'fayetteville, AR', 293),
(205, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'finger lakes', 685),
(206, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'finland', 145),
(207, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'flagstaff / sedona', 244),
(208, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'flint', 259),
(209, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'florence / muscle shoals', 560),
(210, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'florence / tuscany', 152),
(211, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'florence, SC', 464),
(212, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'florida keys', 330),
(213, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'fort collins / north CO', 287),
(214, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'fort dodge', 693),
(215, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'fort smith, AR', 358),
(216, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'fort wayne', 226),
(217, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'fortaleza', 518),
(218, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'frankfurt', 141),
(219, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'fraser valley', 471),
(220, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'frederick', 633),
(221, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'fredericksburg', 457),
(222, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'fresno / madera', 43),
(223, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'ft mcmurray', 477),
(224, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'ft myers / SW florida', 125),
(225, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'fukuoka', 503),
(226, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'gadsden', 559),
(227, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'gainesville', 219),
(228, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'galveston', 470),
(229, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'geneva', 146),
(230, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'genoa', 531),
(231, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'ghana', 575),
(232, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'glasgow', 73),
(233, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'glens falls', 686),
(234, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'goa', 430),
(235, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'gold coast', 590),
(236, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'gold country', 373),
(237, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'granada', 538),
(238, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'grand forks', 667),
(239, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'grand island', 432),
(240, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'grand rapids', 129),
(241, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'great falls', 660),
(242, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'greece', 144),
(243, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'green bay', 241),
(244, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'greensboro', 61),
(245, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'greenville / upstate', 253),
(246, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'grenoble', 525),
(247, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'guadalajara', 404),
(248, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'guam', 245),
(249, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'guanajuato', 431),
(250, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'guangzhou', 409),
(251, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'guatemala', 585),
(252, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'guelph', 482),
(253, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'gulfport / biloxi', 230),
(254, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'haifa', 391),
(255, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'halifax', 174),
(256, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'hamburg', 140),
(257, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'hamilton', 213),
(258, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'hampshire', 403),
(259, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'hampton roads', 48),
(260, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'hanford', 709),
(261, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'hangzhou', 500),
(262, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'hannover', 417),
(263, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'harrisburg', 166),
(264, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'harrisonburg', 447),
(265, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'hartford', 44),
(266, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'hattiesburg', 374),
(267, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'hawaii', 28),
(268, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'heartland florida', 639),
(269, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'heidelberg', 519),
(270, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'helena', 659),
(271, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'hermosillo', 506),
(272, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'hickory / lenoir', 462),
(273, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'high rockies', 288),
(274, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'hilton head', 353),
(275, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'hiroshima', 504),
(276, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'holland', 630),
(277, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'hong kong', 87),
(278, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'houma', 643),
(279, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'houston', 23),
(280, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'hudson valley', 249),
(281, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'humboldt county', 189),
(282, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'huntington', 442),
(283, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'huntsville / decatur', 231),
(284, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'hyderabad', 183),
(285, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'iloilo', 605),
(286, '2011-08-12 16:47:30', '2011-08-12 16:47:30', 'imperial county', 455),
(287, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'indianapolis', 45),
(288, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'indonesia', 157),
(289, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'indore', 549),
(290, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'inland empire', 104),
(291, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'iowa city', 339),
(292, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'iran', 589),
(293, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'iraq', 588),
(294, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'ithaca', 201),
(295, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'jackson, MI', 426),
(296, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'jackson, MS', 134),
(297, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'jackson, TN', 558),
(298, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'jacksonville', 80),
(299, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'jacksonville, NC', 634),
(300, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'jaipur', 550),
(301, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'janesville', 553),
(302, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'jersey shore', 561),
(303, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'jerusalem', 161),
(304, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'johannesburg', 185),
(305, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'jonesboro', 425),
(306, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'joplin', 423),
(307, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'kaiserslautern', 618),
(308, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'kalamazoo', 261),
(309, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'kalispell', 662),
(310, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'kamloops', 381),
(311, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'kansas city, MO', 30),
(312, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'kelowna / okanagan', 380),
(313, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'kenai peninsula', 678),
(314, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'kennewick', 324),
(315, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'kenosha', 552),
(316, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'kent', 493),
(317, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'kenya', 582),
(318, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'kerala', 410),
(319, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'killeen / temple / ft hood', 327),
(320, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'kingston, ON', 385),
(321, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'kirksville', 696),
(322, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'kitchener', 214),
(323, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'klamath falls', 675),
(324, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'knoxville', 202),
(325, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'kokomo', 672),
(326, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'kolkata (calcutta)', 184),
(327, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'kootenays', 474),
(328, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'kuwait', 577),
(329, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'la crosse', 363),
(330, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'la salle co', 698),
(331, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'lafayette', 283),
(332, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'lafayette / west lafayette', 360),
(333, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'lake charles', 284),
(334, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'lake of the ozarks', 695),
(335, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'lakeland', 376),
(336, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'lancaster, PA', 279),
(337, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'lansing', 212),
(338, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'laredo', 271),
(339, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'las cruces', 334),
(340, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'las vegas', 26),
(341, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'lausanne', 615),
(342, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'lawrence', 347),
(343, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'lawton', 422),
(344, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'leeds', 123),
(345, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'lehigh valley', 167),
(346, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'leipzig', 520),
(347, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'lethbridge', 476),
(348, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'lewiston / clarkston', 654),
(349, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'lexington, KY', 133),
(350, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'lille', 413),
(351, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'lima / findlay', 437),
(352, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'lincoln', 282),
(353, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'lisbon', 540),
(354, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'little rock', 100),
(355, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'liverpool', 118),
(356, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'logan', 448),
(357, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'loire valley', 415),
(358, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'london', 24),
(359, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'london, ON', 234),
(360, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'long island', 250),
(361, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'los angeles', 7),
(362, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'louisville', 58),
(363, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'lubbock', 267),
(364, '2011-08-12 16:47:31', '2011-08-12 16:47:31', 'lucknow', 611),
(365, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'luxembourg', 544),
(366, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'lynchburg', 366),
(367, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'lyon', 150),
(368, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'macon / warner robins', 257),
(369, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'madison', 165),
(370, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'madrid', 110),
(371, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'maine', 169),
(372, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'malaga', 539),
(373, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'malaysia', 297),
(374, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'manchester', 71),
(375, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'manhattan, KS', 428),
(376, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'manila', 90),
(377, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'mankato', 421),
(378, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'mansfield', 436),
(379, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'marseille', 149),
(380, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'mason city', 692),
(381, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'mattoon', 699),
(382, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'mazatlan', 509),
(383, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'mcallen / edinburg', 263),
(384, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'meadville', 706),
(385, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'medford', 216),
(386, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'medicine hat', 619),
(387, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'melbourne', 65),
(388, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'memphis, TN', 46),
(389, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'mendocino county', 454),
(390, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'merced', 285),
(391, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'meridian', 641),
(392, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'mexico city', 91),
(393, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'milan', 111),
(394, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'milwaukee', 47),
(395, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'minneapolis / st paul', 19),
(396, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'missoula', 656),
(397, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'mobile', 200),
(398, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'modesto', 96),
(399, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'mohave county', 565),
(400, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'monroe', 629),
(401, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'monroe, LA', 563),
(402, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'montana (old)', 192),
(403, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'monterey bay', 102),
(404, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'monterrey', 408),
(405, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'montevideo', 543),
(406, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'montgomery', 207),
(407, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'montpellier', 524),
(408, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'montreal', 49),
(409, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'morgantown', 440),
(410, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'morocco', 580),
(411, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'moscow', 137),
(412, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'moses lake', 655),
(413, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'mumbai', 85),
(414, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'muncie / anderson', 361),
(415, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'munich', 142),
(416, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'muskegon', 554),
(417, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'myrtle beach', 254),
(418, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'nagoya', 501),
(419, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'nanaimo', 382),
(420, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'nanjing', 599),
(421, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'napoli / campania', 151),
(422, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'nashville', 32),
(423, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'new brunswick', 379),
(424, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'new hampshire', 198),
(425, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'new haven', 168),
(426, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'new orleans', 31),
(427, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'new river valley', 291),
(428, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'new york city', 3),
(429, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'newcastle / NE england', 163),
(430, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'newcastle, NSW', 591),
(431, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'niagara region', 386),
(432, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'nicaragua', 586),
(433, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'nice / cote d''azur', 306),
(434, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'normandy', 527),
(435, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'north central FL', 638),
(436, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'north dakota', 196),
(437, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'north jersey', 170),
(438, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'north mississippi', 375),
(439, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'north platte', 668),
(440, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'northeast SD', 682),
(441, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'northern michigan', 309),
(442, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'northern panhandle', 443),
(443, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'northern WI', 631),
(444, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'northwest CT', 354),
(445, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'northwest GA', 636),
(446, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'northwest KS', 688),
(447, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'northwest OK', 650),
(448, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'norway', 105),
(449, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'nottingham', 492),
(450, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'nuremberg', 614),
(451, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'oaxaca', 510),
(452, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'ocala', 333),
(453, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'odessa / midland', 268),
(454, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'ogden', 351),
(455, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'okaloosa / walton', 640),
(456, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'okinawa', 429),
(457, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'oklahoma city', 54),
(458, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'olympic peninsula', 466),
(459, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'omaha / council bluffs', 55),
(460, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'oneonta', 684),
(461, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'orange county', 103),
(462, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'oregon coast', 321),
(463, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'orlando', 39),
(464, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'osaka', 120),
(465, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'ottawa', 76),
(466, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'outer banks', 336),
(467, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'owen sound', 487),
(468, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'owensboro', 673),
(469, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'oxford', 211),
(470, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'pakistan', 294),
(471, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'palm springs, CA', 209),
(472, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'pampanga', 608),
(473, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'panama', 298),
(474, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'panama city, FL', 562),
(475, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'paris', 81),
(476, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'parkersburg', 441),
(477, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'peace river country', 620),
(478, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'pensacola', 203),
(479, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'peoria', 224),
(480, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'perth', 67),
(481, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'peru', 159),
(482, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'perugia', 530),
(483, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'peterborough', 388),
(484, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'philadelphia', 17),
(485, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'phoenix', 18),
(486, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'pierre / central SD', 681),
(487, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'pittsburgh', 33),
(488, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'plattsburgh', 338),
(489, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'poconos', 356),
(490, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'poland', 147),
(491, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'port huron', 555),
(492, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'portland, OR', 9),
(493, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'porto', 541),
(494, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'porto alegre', 515),
(495, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'potsdam', 683),
(496, '2011-08-12 16:47:32', '2011-08-12 16:47:32', 'prague', 138),
(497, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'prescott', 419),
(498, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'pretoria', 595),
(499, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'prince edward island', 304),
(500, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'prince george', 383),
(501, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'provo / orem', 292),
(502, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'puebla', 508),
(503, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'pueblo', 315),
(504, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'puerto rico', 180),
(505, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'puerto vallarta', 407),
(506, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'pullman / moscow', 368),
(507, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'pune', 317),
(508, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'quad cities, IA/IL', 307),
(509, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'quebec city', 175),
(510, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'raleigh / durham / CH', 36),
(511, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'rapid city / west SD', 680),
(512, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'reading', 278),
(513, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'recife', 516),
(514, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'red deer', 475),
(515, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'redding', 188),
(516, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'regina', 478),
(517, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'reno / tahoe', 92),
(518, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'reykjavik', 579),
(519, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'rhode island', 38),
(520, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'richmond', 60),
(521, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'richmond, IN', 671),
(522, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'rio de janeiro', 139),
(523, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'roanoke', 289),
(524, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'rochester, MN', 316),
(525, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'rochester, NY', 126),
(526, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'rockford', 223),
(527, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'romania', 574),
(528, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'rome', 121),
(529, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'roseburg', 459),
(530, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'roswell / carlsbad', 420),
(531, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'sacramento', 12),
(532, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'saginaw', 260),
(533, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'saguenay', 480),
(534, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'salem, OR', 232),
(535, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'salina', 690),
(536, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'salt lake city', 56),
(537, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'salvador, bahia', 392),
(538, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'san angelo', 646),
(539, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'san antonio', 53),
(540, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'san diego', 8),
(541, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'san luis obispo', 191),
(542, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'san marcos', 449),
(543, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'sandusky', 573),
(544, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'santa barbara', 62),
(545, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'santa fe / taos', 218),
(546, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'santa maria', 710),
(547, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'sao paulo', 113),
(548, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'sapporo', 502),
(549, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'sarasota', 237),
(550, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'sardinia', 532),
(551, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'sarnia', 486),
(552, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'saskatoon', 176),
(553, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'sault ste marie, ON', 485),
(554, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'savannah / hinesville', 205),
(555, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'scottsbluff / panhandle', 669),
(556, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'scranton / wilkes', 276),
(557, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'seattle', 2),
(558, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'sendai', 596),
(559, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'seoul', 119),
(560, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'sevilla', 395),
(561, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'shanghai', 135),
(562, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'sheboygan, WI', 571),
(563, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'sheffield', 401),
(564, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'shenyang', 598),
(565, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'shenzhen', 499),
(566, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'sherbrooke', 390),
(567, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'show low', 651),
(568, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'shreveport', 206),
(569, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'sicilia', 311),
(570, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'sierra vista', 468),
(571, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'singapore', 89),
(572, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'sioux city, IA', 341),
(573, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'sioux falls / SE SD', 679),
(574, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'siskiyou county', 708),
(575, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'skagit / island / SJI', 461),
(576, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'skeena', 623),
(577, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'south bend / michiana', 228),
(578, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'south coast', 378),
(579, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'south dakota', 195),
(580, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'south florida', 20),
(581, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'south jersey', 286),
(582, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'southeast alaska', 676),
(583, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'southeast IA', 691),
(584, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'southeast KS', 689),
(585, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'southeast missouri', 566),
(586, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'southern illinois', 345),
(587, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'southern maryland', 556),
(588, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'southern WV', 632),
(589, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'southwest KS', 687),
(590, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'southwest michigan', 572),
(591, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'southwest MN', 665),
(592, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'southwest MS', 642),
(593, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'southwest TX', 648),
(594, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'southwest VA', 712),
(595, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'space coast', 331),
(596, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'spokane / coeur d''alene', 95),
(597, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'springfield, IL', 225),
(598, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'springfield, MO', 221),
(599, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'st augustine', 557),
(600, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'st cloud', 369),
(601, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'st george', 352),
(602, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'st john''s, NL', 305),
(603, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'st joseph', 694),
(604, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'st louis, MO', 29),
(605, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'st petersburg, RU', 143),
(606, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'state college', 277),
(607, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'statesboro', 635),
(608, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'stillwater', 433),
(609, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'stockton', 97),
(610, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'strasbourg', 414),
(611, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'stuttgart', 416),
(612, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'sudbury', 384),
(613, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'sunshine coast', 622),
(614, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'surat surat', 613),
(615, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'susanville', 707),
(616, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'sweden', 106),
(617, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'sydney', 64),
(618, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'syracuse', 130),
(619, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'taiwan', 155),
(620, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'tallahassee', 186),
(621, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'tampa bay area', 37),
(622, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'tasmania', 490),
(623, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'tel aviv', 160),
(624, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'terre haute', 348),
(625, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'territories', 488),
(626, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'texarkana', 359),
(627, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'texoma', 649),
(628, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'thailand', 156),
(629, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'the thumb', 627),
(630, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'thunder bay', 387),
(631, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'tijuana', 181),
(632, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'tokyo', 88),
(633, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'toledo', 204),
(634, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'topeka', 280),
(635, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'torino', 397),
(636, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'toronto', 25),
(637, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'toulouse', 411),
(638, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'treasure coast', 332),
(639, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'tri', 323),
(640, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'trois', 479),
(641, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'tucson', 57),
(642, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'tulsa', 70),
(643, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'tunisia', 581),
(644, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'turkey', 148),
(645, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'tuscaloosa', 371),
(646, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'tuscarawas co', 703),
(647, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'twin falls', 469),
(648, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'twin tiers NY/PA', 704),
(649, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'tyler / east TX', 308),
(650, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'ukraine', 583),
(651, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'united arab emirates', 215),
(652, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'upper peninsula', 262),
(653, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'utica', 247),
(654, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'valdosta', 427),
(655, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'valencia', 394),
(656, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'vancouver, BC', 16),
(657, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'venezuela', 178),
(658, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'venice / veneto', 310),
(659, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'ventura county', 208),
(660, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'veracruz', 507),
(661, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'vermont', 93),
(662, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'victoria', 177),
(663, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'victoria, TX', 564),
(664, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'vienna', 122),
(665, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'vietnam', 314),
(666, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'virgin islands', 616),
(667, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'visalia', 346),
(668, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'waco', 270),
(669, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'washington, DC', 10),
(670, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'waterloo / cedar falls', 567),
(671, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'watertown', 337),
(672, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'wausau', 458),
(673, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'wellington', 302),
(674, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'wenatchee', 325),
(675, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'west bank', 551),
(676, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'west virginia (old)', 194),
(677, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'western IL', 697),
(678, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'western KY', 377),
(679, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'western maryland', 329),
(680, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'western massachusetts', 173),
(681, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'western slope', 320),
(682, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'whistler, BC', 472),
(683, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'whitehorse', 625),
(684, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'wichita', 99),
(685, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'wichita falls', 365),
(686, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'williamsport', 463),
(687, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'wilmington, NC', 274),
(688, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'winchester', 711),
(689, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'windsor', 235),
(690, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'winnipeg', 79),
(691, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'winston', 272),
(692, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'wollongong', 593),
(693, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'worcester / central MA', 240),
(694, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'wuhan', 597),
(695, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'wyoming', 197),
(696, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'xi''an', 603),
(697, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'yakima', 246),
(698, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'yellowknife', 624),
(699, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'york, PA', 357),
(700, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'youngstown', 252),
(701, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'yuba', 456),
(702, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'yucatan', 405),
(703, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'yuma', 370),
(704, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'zamboanga', 607),
(705, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'zanesville / cambridge', 702),
(706, '2011-08-12 16:47:33', '2011-08-12 16:47:33', 'zurich', 112);

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

DROP TABLE IF EXISTS `currencies`;
CREATE TABLE IF NOT EXISTS `currencies` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `code` varchar(10) collate utf8_unicode_ci NOT NULL,
  `symbol` varchar(255) collate utf8_unicode_ci NOT NULL,
  `is_enabled` tinyint(1) NOT NULL,
  `prefix` varchar(10) collate utf8_unicode_ci default NULL,
  `is_prefix_display_on_left` tinyint(1) NOT NULL default '1',
  `suffix` varchar(10) collate utf8_unicode_ci default NULL,
  `decimals` int(10) default '2',
  `dec_point` varchar(2) collate utf8_unicode_ci default '.',
  `thousands_sep` varchar(2) collate utf8_unicode_ci default ',',
  `locale` varchar(10) collate utf8_unicode_ci default NULL,
  `format_string` varchar(10) collate utf8_unicode_ci default NULL,
  `grouping_algorithm_callback` varchar(255) collate utf8_unicode_ci default NULL,
  `is_use_graphic_symbol` tinyint(1) default NULL,
  PRIMARY KEY  (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `created`, `modified`, `name`, `code`, `symbol`, `is_enabled`, `prefix`, `is_prefix_display_on_left`, `suffix`, `decimals`, `dec_point`, `thousands_sep`, `locale`, `format_string`, `grouping_algorithm_callback`, `is_use_graphic_symbol`) VALUES
(2, '2010-08-07 00:00:00', '2010-09-14 02:29:05', 'Euros', 'EUR', '€', 1, '€', 1, 'EUR', 2, '.', ',', NULL, NULL, NULL, NULL),
(1, '2010-08-07 00:00:00', '2011-05-04 07:49:32', 'U.S. Dollars', 'USD', '$', 1, '$', 1, 'USD', 2, '.', ',', '', '', '', 0),
(4, '2010-08-07 00:50:27', '2010-09-14 02:28:39', 'Australian Dollars', 'AUD', '$', 1, '$', 1, 'AUD', 2, '.', ',', NULL, NULL, NULL, NULL),
(5, '2010-08-07 00:50:51', '2010-09-14 02:28:12', 'British Pounds', 'GBP', '£', 1, '£', 1, 'GBP', 2, '.', ',', NULL, NULL, NULL, NULL),
(6, '2010-08-07 00:51:11', '2010-09-14 02:27:53', 'Canadian Dollars', 'CAD', '$', 1, '$', 1, 'CAD', 2, '.', ',', NULL, NULL, NULL, NULL),
(7, '2010-08-07 00:51:29', '2010-09-14 02:27:28', 'Czech Koruny', 'CZK', 'Kč', 1, 'Kč', 1, 'CZK', 2, '.', ',', NULL, NULL, NULL, NULL),
(8, '2010-08-07 00:51:47', '2010-09-14 02:27:10', 'Danish Kroner', 'DKK', 'kr', 1, 'kr', 1, 'DKK', 2, '.', ',', NULL, NULL, NULL, NULL),
(9, '2010-08-07 00:52:05', '2010-09-14 02:26:46', 'Hong Kong Dollars', 'HKD', 'HK$', 1, 'HK$', 1, 'HKD', 2, '.', ',', NULL, NULL, NULL, NULL),
(10, '2010-08-07 00:52:24', '2010-09-14 02:26:28', 'Hungarian Forints', 'HUF', 'Ft', 1, 'Ft', 1, 'HUF', 2, '.', ',', NULL, NULL, NULL, NULL),
(11, '2010-08-07 00:52:41', '2010-09-14 02:26:08', 'Israeli New Shekels', 'ILS', '₪', 1, '₪', 1, 'ILS', 2, '.', ',', NULL, NULL, NULL, NULL),
(12, '2010-08-07 00:53:01', '2010-09-14 02:25:45', 'Japanese Yen', 'JPY', '¥', 1, '¥', 1, 'JPY', 2, '.', ',', NULL, NULL, NULL, NULL),
(13, '2010-08-07 00:53:16', '2010-09-14 02:25:11', 'Mexican Pesos', 'MXN', '$', 1, '$', 1, 'MXN', 2, '.', ',', NULL, NULL, NULL, NULL),
(14, '2010-08-07 00:53:37', '2010-09-14 02:24:52', 'New Zealand Dollars', 'NZD', '$', 1, '$', 1, 'NZD', 2, '.', ',', NULL, NULL, NULL, NULL),
(15, '2010-08-07 00:53:53', '2010-09-14 02:24:34', 'Norwegian Kroner', 'NOK', 'kr', 1, 'kr', 1, 'NOK', 2, '.', ',', NULL, NULL, NULL, NULL),
(16, '2010-08-07 00:54:12', '2010-09-14 02:24:16', 'Philippine Pesos', 'PHP', 'Php', 1, 'Php', 1, 'PHP', 2, '.', ',', NULL, NULL, NULL, NULL),
(17, '2010-08-07 00:54:30', '2010-09-14 02:23:56', 'Polish Zlotych', 'PLN', 'zł', 1, 'zł', 1, 'PLN', 2, '.', ',', NULL, NULL, NULL, NULL),
(18, '2010-08-07 00:54:49', '2010-09-14 02:23:36', 'Singapore Dollars', 'SGD', '$', 1, '$', 1, 'SGD', 2, '.', ',', NULL, NULL, NULL, NULL),
(19, '2010-08-07 00:55:04', '2010-09-14 02:22:37', 'Swedish Kronor', 'SEK', 'kr', 1, 'kr', 1, 'SEK', 2, '.', ',', NULL, NULL, NULL, NULL),
(20, '2010-08-07 00:55:25', '2010-09-14 02:22:16', 'Swiss Francs', 'CHF', 'CHF', 1, 'CHF', 1, 'CHF', 2, '.', ',', NULL, NULL, NULL, NULL),
(22, '2010-08-07 00:55:54', '2011-05-04 06:16:11', 'Thai Baht', 'THB', '฿', 1, '฿', 1, 'THB', 2, '.', ',', '', '', '', 0),
(23, '2010-08-07 00:55:54', '2011-05-11 08:08:09', 'Indian Rupee', 'INR', 'र', 1, 'र', 1, 'INR', 2, '.', ',', '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `currency_conversions`
--

DROP TABLE IF EXISTS `currency_conversions`;
CREATE TABLE IF NOT EXISTS `currency_conversions` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `currency_id` bigint(20) NOT NULL,
  `converted_currency_id` bigint(20) NOT NULL,
  `rate` float(10,6) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `currency_id` (`currency_id`),
  KEY `converted_currency_id` (`converted_currency_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `currency_conversions`
--


-- --------------------------------------------------------

--
-- Table structure for table `currency_conversion_histories`
--

DROP TABLE IF EXISTS `currency_conversion_histories`;
CREATE TABLE IF NOT EXISTS `currency_conversion_histories` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `currency_conversion_id` bigint(20) NOT NULL,
  `rate_before_change` float(10,6) default '0.000000',
  `rate` float(10,6) default '0.000000',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `currency_conversion_histories`
--


-- --------------------------------------------------------

--
-- Table structure for table `custom_price_per_months`
--

DROP TABLE IF EXISTS `custom_price_per_months`;
CREATE TABLE IF NOT EXISTS `custom_price_per_months` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `property_id` bigint(20) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `price` double(10,2) NOT NULL,
  `is_available` tinyint(1) default '0',
  PRIMARY KEY  (`id`),
  KEY `property_id` (`property_id`),
  KEY `end_date` (`end_date`),
  KEY `start_date` (`start_date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Monthly Prices ';

--
-- Dumping data for table `custom_price_per_months`
--


-- --------------------------------------------------------

--
-- Table structure for table `custom_price_per_nights`
--

DROP TABLE IF EXISTS `custom_price_per_nights`;
CREATE TABLE IF NOT EXISTS `custom_price_per_nights` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `property_id` bigint(20) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `price` double(10,2) NOT NULL,
  `is_available` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `property_id` (`property_id`),
  KEY `end_date` (`end_date`),
  KEY `start_date` (`start_date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Daily Prices ';

--
-- Dumping data for table `custom_price_per_nights`
--


-- --------------------------------------------------------

--
-- Table structure for table `custom_price_per_weeks`
--

DROP TABLE IF EXISTS `custom_price_per_weeks`;
CREATE TABLE IF NOT EXISTS `custom_price_per_weeks` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `property_id` bigint(20) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `price` double(10,2) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `property_id` (`property_id`),
  KEY `end_date` (`end_date`),
  KEY `start_date` (`start_date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Weekly Prices ';

--
-- Dumping data for table `custom_price_per_weeks`
--


-- --------------------------------------------------------

--
-- Table structure for table `dispute_closed_types`
--

DROP TABLE IF EXISTS `dispute_closed_types`;
CREATE TABLE IF NOT EXISTS `dispute_closed_types` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` varchar(255) collate utf8_unicode_ci default NULL,
  `dispute_type_id` bigint(20) default NULL,
  `is_traveler` tinyint(1) default NULL,
  `reason` varchar(255) collate utf8_unicode_ci default NULL,
  `resolve_type` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dispute_closed_types`
--

INSERT INTO `dispute_closed_types` (`id`, `name`, `dispute_type_id`, `is_traveler`, `reason`, `resolve_type`) VALUES
(1, 'Favor Traveler', 1, 1, 'Property doesn''t match with the one\r\nmentioned in property specification', 'refunded'),
(2, 'Favor host', 1, 0, 'Property matches with the mentioned\r\nproperty specification', 'resolve without any change'),
(5, 'Favor Traveler', 3, 1, 'Property doesn''t matches the quality and requirement/specification', 'resolve without any change'),
(6, 'Favor host', 3, 0, 'Property matches the quality and\r\nrequirement/specification, so host rating changed to positive', 'Update host rating'),
(7, 'Favor Traveler', 1, 1, 'Failure to respond in time limit', 'refunded'),
(9, 'Favor host', 3, 0, 'Failure to respond in time limit', 'Update\r\nhost rating'),
(10, 'Favor Traveler', 4, 1, 'Claiming reason doesn''t match with existing conversation', 'Deposit amount refunded'),
(11, 'Favor Host', 4, 0, 'Claiming reason matches with existing conversation', 'Deposit amount to host'),
(12, 'Favor host', 4, 0, 'Failure to respond in time limit', 'Deposit amount to host');

-- --------------------------------------------------------

--
-- Table structure for table `dispute_statuses`
--

DROP TABLE IF EXISTS `dispute_statuses`;
CREATE TABLE IF NOT EXISTS `dispute_statuses` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `name` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dispute_statuses`
--

INSERT INTO `dispute_statuses` (`id`, `created`, `modified`, `name`) VALUES
(1, '2010-12-22 10:46:41', '2010-12-22 10:46:41', 'Open'),
(2, '2010-12-22 10:46:41', '2010-12-22 10:46:41', 'Under Discussion'),
(3, '2010-12-22 10:46:41', '2010-12-22 10:46:41', 'Waiting Administrator Decision'),
(4, '2010-12-22 10:46:41', '2010-12-22 10:46:41', 'Closed');

-- --------------------------------------------------------

--
-- Table structure for table `dispute_types`
--

DROP TABLE IF EXISTS `dispute_types`;
CREATE TABLE IF NOT EXISTS `dispute_types` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `name` varchar(255) collate utf8_unicode_ci default NULL,
  `is_traveler` bigint(20) default NULL,
  `is_active` tinyint(1) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dispute_types`
--

INSERT INTO `dispute_types` (`id`, `created`, `modified`, `name`, `is_traveler`, `is_active`) VALUES
(1, '2010-12-22 10:46:41', '2010-12-22 10:46:41', 'Doesn''t match the\r\nspecification as mentioned by the property owner', 1, 1),
(3, '2010-12-22 10:46:41', '2010-12-22 10:46:41', 'Traveler given\r\npoor feedback', 0, 1),
(4, NULL, NULL, 'Claim the security damage from traveler', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

DROP TABLE IF EXISTS `email_templates`;
CREATE TABLE IF NOT EXISTS `email_templates` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `from` varchar(500) collate utf8_unicode_ci default NULL,
  `reply_to` varchar(500) collate utf8_unicode_ci default NULL,
  `name` varchar(150) collate utf8_unicode_ci default NULL,
  `description` text collate utf8_unicode_ci,
  `subject` varchar(255) collate utf8_unicode_ci default NULL,
  `email_content` text collate utf8_unicode_ci,
  `email_variables` varchar(1000) collate utf8_unicode_ci default NULL,
  `is_html` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Site Email Templates';

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`id`, `created`, `modified`, `from`, `reply_to`, `name`, `description`, `subject`, `email_content`, `email_variables`, `is_html`) VALUES
(1, '2009-02-20 10:24:49', '2011-06-03 13:21:35', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Forgot Password', 'we will send this mail, when user submit the forgot password form.', 'Forgot password', '<div style="padding: 10px; width: 720px; margin: auto;">\r\n<table width="720px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; text-align: center; font-size: 10px; color:#333333; margin: 3px;">\r\n        Be sure to add\r\n        <a href="mailto:##FROM_EMAIL##" style="color:#ff0084;" title="Add ##FROM_EMAIL## to your whitelist" target="_blank">##FROM_EMAIL##</a>\r\n        to your address book or safe sender list so our emails get to your inbox.      </p>\r\n    </td>\r\n  </tr>\r\n</tbody></table>\r\n<div style="width: 670px; margin: 5px 0pt; padding: 15px; background-repeat: no-repeat; border: 3px solid #0063dc; background-color: #eef6ff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255); margin-bottom:5px; border-bottom:3px solid #0063dc;">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;">\r\n    <h1 style="color:#333333; margin: 0pt 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n          <a target="_blank" title="##SITE_NAME##" style="color: #ff0084;" href="##SITE_LINK##">\r\n          <img style="border:none;" src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]" width="186px"/></a>\r\n        </h1></td>\r\n  </tr>\r\n</table>\r\n <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;"> <h2 style="color:#333333; border-bottom:1px solid #dddddd; padding:0 0 5px 0; margin: 0 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n		Hi \r\n        ##USERNAME##,\r\n        </h2></td>\r\n  </tr>\r\n</table>\r\n\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody>\r\n    <tr>\r\n      <td style="padding:0 20px 0 20px;">\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">A password reset request has been made for your user account at ##SITE_NAME##.</p>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">If you made this request, please click on the following link:\r\n##RESET_URL##</p>\r\n\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; border-top: 1px solid #d5d5d5; color:#333333; margin: 15px 0 0 0; line-height:20px; font-size: 12px; text-align: left; padding: 10px 0px;">If you did not request this action and feel this is in error, please contact us at ##CONTACT_MAIL##.</p>\r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid #d5d5d5; padding: 15px 30px 25px; margin: 0pt 20px;">\r\n          <h4 style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 20px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#ff0084;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: verdana,Helvetica,Arial,sans-serif; color: #333333; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_LINK##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #ff96cc;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: #fff; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#fff;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="720px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 10px; color: #333333; margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'USERNAME,RESET_URL,SITE_NAME', 1),
(2, '2009-02-20 10:15:57', '2011-06-11 09:36:01', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Activation Request', 'we will send this mail, when user registering an account he/she will get an activation request.', 'Please activate your ##SITE_NAME## account', '<div style="padding: 10px; width: 720px; margin: auto;">\r\n<table width="720px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; text-align: center; font-size: 10px; color:#333333; margin: 3px;">\r\n        Be sure to add\r\n        <a href="mailto:##FROM_EMAIL##" style="color:#ff0084;" title="Add ##FROM_EMAIL## to your whitelist" target="_blank">##FROM_EMAIL##</a>\r\n        to your address book or safe sender list so our emails get to your inbox.      </p>\r\n    </td>\r\n  </tr>\r\n</tbody></table>\r\n<div style="width: 670px; margin: 5px 0pt; padding: 15px; background-repeat: no-repeat; border: 3px solid #0063dc; background-color: #eef6ff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255); margin-bottom:5px; border-bottom:3px solid #0063dc;">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;">\r\n    <h1 style="color:#333333; margin: 0pt 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n          <a target="_blank" title="##SITE_NAME##" style="color: #ff0084;" href="##SITE_LINK##">\r\n          <img style="border:none;" src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]" width="186px"/></a>\r\n        </h1></td>\r\n  </tr>\r\n</table>\r\n <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;"> <h2 style="color:#333333; border-bottom:1px solid #dddddd; padding:0 0 5px 0; margin: 0 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n		Hi \r\n        ##USERNAME##,\r\n        </h2></td>\r\n  </tr>\r\n</table>\r\n\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody>\r\n    <tr>\r\n      <td style="padding:0 20px 0 20px;">\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">Your account has been created. Please visit the following URL to activate your account.\r\n##ACTIVATION_URL##</p>\r\n       \r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid #d5d5d5; padding: 15px 30px 25px; margin: 0pt 20px;">\r\n          <h4 style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 20px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#ff0084;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: verdana,Helvetica,Arial,sans-serif; color: #333333; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_LINK##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #ff96cc;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: #fff; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#fff;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="720px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 10px; color: #333333; margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'SITE_NAME,USERNAME,ACTIVATION_URL', 1),
(3, '2009-02-20 10:15:19', '2011-06-03 13:22:07', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'New User Join', 'we will send this mail to admin, when a new user registered in the site. For this you have to enable "admin mail after register" in the settings page.', 'New user joined in ##SITE_NAME## account', '<div style="padding: 10px; width: 720px; margin: auto;">\r\n<table width="720px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; text-align: center; font-size: 10px; color:#333333; margin: 3px;">\r\n        Be sure to add\r\n        <a href="mailto:##FROM_EMAIL##" style="color:#ff0084;" title="Add ##FROM_EMAIL## to your whitelist" target="_blank">##FROM_EMAIL##</a>\r\n        to your address book or safe sender list so our emails get to your inbox.      </p>\r\n    </td>\r\n  </tr>\r\n</tbody></table>\r\n<div style="width: 670px; margin: 5px 0pt; padding: 15px; background-repeat: no-repeat; border: 3px solid #0063dc; background-color: #eef6ff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255); margin-bottom:5px; border-bottom:3px solid #0063dc;">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;">\r\n    <h1 style="color:#333333; margin: 0pt 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n          <a target="_blank" title="##SITE_NAME##" style="color: #ff0084;" href="##SITE_LINK##">\r\n          <img style="border:none;" src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]" width="186px"/></a>\r\n        </h1></td>\r\n  </tr>\r\n</table>\r\n <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;"> <h2 style="color:#333333; border-bottom:1px solid #dddddd; padding:0 0 5px 0; margin: 0 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n		Hi ,\r\n        </h2></td>\r\n  </tr>\r\n</table>\r\n\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody>\r\n    <tr>\r\n      <td style="padding:0 20px 0 20px;">\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">A new user named "##USERNAME##" has joined in ##SITE_NAME## account.</p>\r\n       \r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid #d5d5d5; padding: 15px 30px 25px; margin: 0pt 20px;">\r\n          <h4 style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 20px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#ff0084;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: verdana,Helvetica,Arial,sans-serif; color: #333333; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_LINK##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #ff96cc;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: #fff; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#fff;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="720px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 10px; color: #333333; margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'SITE_NAME,USERNAME', 1),
(4, '2009-03-02 00:00:00', '2011-06-03 13:22:27', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Admin User Add', 'we will send this mail to user, when a admin add a new user.', 'Welcome to ##SITE_NAME##', '<div style="padding: 10px; width: 720px; margin: auto;">\r\n<table width="720px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; text-align: center; font-size: 10px; color:#333333; margin: 3px;">\r\n        Be sure to add\r\n        <a href="mailto:##FROM_EMAIL##" style="color:#ff0084;" title="Add ##FROM_EMAIL## to your whitelist" target="_blank">##FROM_EMAIL##</a>\r\n        to your address book or safe sender list so our emails get to your inbox.      </p>\r\n    </td>\r\n  </tr>\r\n</tbody></table>\r\n<div style="width: 670px; margin: 5px 0pt; padding: 15px; background-repeat: no-repeat; border: 3px solid #0063dc; background-color: #eef6ff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255); margin-bottom:5px; border-bottom:3px solid #0063dc;">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;">\r\n    <h1 style="color:#333333; margin: 0pt 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n          <a target="_blank" title="##SITE_NAME##" style="color: #ff0084;" href="##SITE_LINK##">\r\n          <img style="border:none;" src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]" width="186px"/></a>\r\n        </h1></td>\r\n  </tr>\r\n</table>\r\n <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;"> <h2 style="color:#333333; border-bottom:1px solid #dddddd; padding:0 0 5px 0; margin: 0 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n		Hi \r\n        ##USERNAME##,\r\n        </h2></td>\r\n  </tr>\r\n</table>\r\n\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody>\r\n    <tr>\r\n      <td style="padding:0 20px 0 20px;">\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">##SITE_NAME## team added you as a user in ##SITE_NAME##.</p>\r\n                <h3 style="font-family: verdana,Helvetica,Arial,sans-serif; margin:0; padding:5px 0;">Your account details.</h3>\r\n                <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">\r\n##LOGINLABEL##:##USEDTOLOGIN##\r\nPassword:##PASSWORD##</p>\r\n       \r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid #d5d5d5; padding: 15px 30px 25px; margin: 0pt 20px;">\r\n          <h4 style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 20px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#ff0084;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: verdana,Helvetica,Arial,sans-serif; color: #333333; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_LINK##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #ff96cc;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: #fff; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#fff;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="720px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 10px; color: #333333; margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'SITE_NAME,USERNAME,PASSWORD, LOGINLABEL, USEDTOLOGIN', 1),
(5, '2009-05-22 16:51:14', '2011-06-11 09:36:56', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Welcome Email', 'we will send this mail, when user register in this site and get activate.', 'Welcome to ##SITE_NAME##', '<div style="padding: 10px; width: 720px; margin: auto;">\r\n<table width="720px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; text-align: center; font-size: 10px; color:#333333; margin: 3px;">\r\n        Be sure to add\r\n        <a href="mailto:##FROM_EMAIL##" style="color:#ff0084;" title="Add ##FROM_EMAIL## to your whitelist" target="_blank">##FROM_EMAIL##</a>\r\n        to your address book or safe sender list so our emails get to your inbox.      </p>\r\n    </td>\r\n  </tr>\r\n</tbody></table>\r\n<div style="width: 670px; margin: 5px 0pt; padding: 15px; background-repeat: no-repeat; border: 3px solid #0063dc; background-color: #eef6ff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255); margin-bottom:5px; border-bottom:3px solid #0063dc;">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;">\r\n    <h1 style="color:#333333; margin: 0pt 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n          <a target="_blank" title="##SITE_NAME##" style="color: #ff0084;" href="##SITE_LINK##">\r\n          <img style="border:none;" src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]" width="186px"/></a>\r\n        </h1></td>\r\n  </tr>\r\n</table>\r\n <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;"> <h2 style="color:#333333; border-bottom:1px solid #dddddd; padding:0 0 5px 0; margin: 0 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n		Hi \r\n        ##USERNAME##,\r\n        </h2></td>\r\n  </tr>\r\n</table>\r\n\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody>\r\n    <tr>\r\n      <td style="padding:0 20px 0 20px;">\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">We wish to say a quick hello and thanks for registering at ##SITE_NAME##.</p>\r\n    <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">If you did not request this account and feel this is an error, please contact us at ##CONTACT_MAIL##</p>   \r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid #d5d5d5; padding: 15px 30px 25px; margin: 0pt 20px;">\r\n          <h4 style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 20px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#ff0084;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: verdana,Helvetica,Arial,sans-serif; color: #333333; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_LINK##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #ff96cc;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: #fff; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#fff;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="720px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 10px; color: #333333; margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'SITE_NAME, USERNAME, SUPPORT_EMAIL', 1),
(6, '2009-05-22 16:45:38', '2011-06-03 13:23:07', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Admin User Active ', 'We will send this mail to user, when user active by administrator.', 'Your ##SITE_NAME## account has been activated', '<div style="padding: 10px; width: 720px; margin: auto;">\r\n<table width="720px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; text-align: center; font-size: 10px; color:#333333; margin: 3px;">\r\n        Be sure to add\r\n        <a href="mailto:##FROM_EMAIL##" style="color:#ff0084;" title="Add ##FROM_EMAIL## to your whitelist" target="_blank">##FROM_EMAIL##</a>\r\n        to your address book or safe sender list so our emails get to your inbox.      </p>\r\n    </td>\r\n  </tr>\r\n</tbody></table>\r\n<div style="width: 670px; margin: 5px 0pt; padding: 15px; background-repeat: no-repeat; border: 3px solid #0063dc; background-color: #eef6ff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255); margin-bottom:5px; border-bottom:3px solid #0063dc;">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;">\r\n    <h1 style="color:#333333; margin: 0pt 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n          <a target="_blank" title="##SITE_NAME##" style="color: #ff0084;" href="##SITE_LINK##">\r\n          <img style="border:none;" src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]" width="186px"/></a>\r\n        </h1></td>\r\n  </tr>\r\n</table>\r\n <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;"> <h2 style="color:#333333; border-bottom:1px solid #dddddd; padding:0 0 5px 0; margin: 0 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n		Hi \r\n        ##USERNAME##,\r\n        </h2></td>\r\n  </tr>\r\n</table>\r\n\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody>\r\n    <tr>\r\n      <td style="padding:0 20px 0 20px;">\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">Your account has been activated.</p>\r\n       \r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid #d5d5d5; padding: 15px 30px 25px; margin: 0pt 20px;">\r\n          <h4 style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 20px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#ff0084;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: verdana,Helvetica,Arial,sans-serif; color: #333333; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_LINK##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #ff96cc;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: #fff; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#fff;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="720px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 10px; color: #333333; margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'SITE_NAME,USERNAME', 1),
(7, '2009-05-22 16:48:38', '2011-06-03 13:23:21', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Admin User Deactivate', 'We will send this mail to user, when user deactivate by administrator.', 'Your ##SITE_NAME## account has been deactivated', '<div style="padding: 10px; width: 720px; margin: auto;">\r\n<table width="720px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; text-align: center; font-size: 10px; color:#333333; margin: 3px;">\r\n        Be sure to add\r\n        <a href="mailto:##FROM_EMAIL##" style="color:#ff0084;" title="Add ##FROM_EMAIL## to your whitelist" target="_blank">##FROM_EMAIL##</a>\r\n        to your address book or safe sender list so our emails get to your inbox.      </p>\r\n    </td>\r\n  </tr>\r\n</tbody></table>\r\n<div style="width: 670px; margin: 5px 0pt; padding: 15px; background-repeat: no-repeat; border: 3px solid #0063dc; background-color: #eef6ff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255); margin-bottom:5px; border-bottom:3px solid #0063dc;">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;">\r\n    <h1 style="color:#333333; margin: 0pt 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n          <a target="_blank" title="##SITE_NAME##" style="color: #ff0084;" href="##SITE_LINK##">\r\n          <img style="border:none;" src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]" width="186px"/></a>\r\n        </h1></td>\r\n  </tr>\r\n</table>\r\n <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;"> <h2 style="color:#333333; border-bottom:1px solid #dddddd; padding:0 0 5px 0; margin: 0 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n		Hi \r\n        ##USERNAME##,\r\n        </h2></td>\r\n  </tr>\r\n</table>\r\n\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody>\r\n    <tr>\r\n      <td style="padding:0 20px 0 20px;"><p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">Your ##SITE_NAME## account has been deactivated.</p>\r\n       \r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid #d5d5d5; padding: 15px 30px 25px; margin: 0pt 20px;">\r\n          <h4 style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 20px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#ff0084;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: verdana,Helvetica,Arial,sans-serif; color: #333333; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_LINK##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #ff96cc;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: #fff; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#fff;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="720px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 10px; color: #333333; margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'SITE_NAME,USERNAME', 1),
(8, '2009-05-22 16:50:25', '2011-06-03 13:23:43', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Admin User Delete', 'We will send this mail to user, when user delete by administrator.', 'Your ##SITE_NAME## account has been removed', '<div style="padding: 10px; width: 720px; margin: auto;">\r\n<table width="720px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; text-align: center; font-size: 10px; color:#333333; margin: 3px;">\r\n        Be sure to add\r\n        <a href="mailto:##FROM_EMAIL##" style="color:#ff0084;" title="Add ##FROM_EMAIL## to your whitelist" target="_blank">##FROM_EMAIL##</a>\r\n        to your address book or safe sender list so our emails get to your inbox.      </p>\r\n    </td>\r\n  </tr>\r\n</tbody></table>\r\n<div style="width: 670px; margin: 5px 0pt; padding: 15px; background-repeat: no-repeat; border: 3px solid #0063dc; background-color: #eef6ff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255); margin-bottom:5px; border-bottom:3px solid #0063dc;">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;">\r\n    <h1 style="color:#333333; margin: 0pt 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n          <a target="_blank" title="##SITE_NAME##" style="color: #ff0084;" href="##SITE_LINK##">\r\n          <img style="border:none;" src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]" width="186px"/></a>\r\n        </h1></td>\r\n  </tr>\r\n</table>\r\n <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;"> <h2 style="color:#333333; border-bottom:1px solid #dddddd; padding:0 0 5px 0; margin: 0 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n		Hi \r\n        ##USERNAME##,\r\n        </h2></td>\r\n  </tr>\r\n</table>\r\n\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody>\r\n    <tr>\r\n      <td style="padding:0 20px 0 20px;"><p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">Your ##SITE_NAME## account has been removed.</p>\r\n       \r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid #d5d5d5; padding: 15px 30px 25px; margin: 0pt 20px;">\r\n          <h4 style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 20px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#ff0084;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: verdana,Helvetica,Arial,sans-serif; color: #333333; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_LINK##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #ff96cc;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: #fff; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#fff;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="720px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 10px; color: #333333; margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'SITE_NAME,USERNAME', 1),
(9, '2009-07-07 15:47:09', '2011-06-03 13:24:02', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Admin Change Password', 'we will send this mail to user, when admin change user''s password.', 'Password changed', '<div style="padding: 10px; width: 720px; margin: auto;">\r\n<table width="720px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; text-align: center; font-size: 10px; color:#333333; margin: 3px;">\r\n        Be sure to add\r\n        <a href="mailto:##FROM_EMAIL##" style="color:#ff0084;" title="Add ##FROM_EMAIL## to your whitelist" target="_blank">##FROM_EMAIL##</a>\r\n        to your address book or safe sender list so our emails get to your inbox.      </p>\r\n    </td>\r\n  </tr>\r\n</tbody></table>\r\n<div style="width: 670px; margin: 5px 0pt; padding: 15px; background-repeat: no-repeat; border: 3px solid #0063dc; background-color: #eef6ff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255); margin-bottom:5px; border-bottom:3px solid #0063dc;">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;">\r\n    <h1 style="color:#333333; margin: 0pt 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n          <a target="_blank" title="##SITE_NAME##" style="color: #ff0084;" href="##SITE_LINK##">\r\n          <img style="border:none;" src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]" width="186px"/></a>\r\n        </h1></td>\r\n  </tr>\r\n</table>\r\n <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;"> <h2 style="color:#333333; border-bottom:1px solid #dddddd; padding:0 0 5px 0; margin: 0 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n		Hi \r\n        ##USERNAME##,\r\n        </h2></td>\r\n  </tr>\r\n</table>\r\n\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody>\r\n    <tr>\r\n      <td style="padding:0 20px 0 20px;">\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">Admin reset your password for your ##SITE_NAME## account.</p>\r\n         <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">Your new password:\r\n##PASSWORD##</p>\r\n       \r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid #d5d5d5; padding: 15px 30px 25px; margin: 0pt 20px;">\r\n          <h4 style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 20px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#ff0084;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: verdana,Helvetica,Arial,sans-serif; color: #333333; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_LINK##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #ff96cc;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: #fff; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#fff;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="720px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 10px; color: #333333; margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'SITE_NAME,PASSWORD,USERNAME', 1),
(10, '2009-10-14 18:31:14', '2011-06-03 13:24:31', '##FIRST_NAME####LAST_NAME## <##FROM_EMAIL##>', '##REPLY_TO_EMAIL##', 'Contact Us ', 'We will send this mail to admin, when user submit any contact form.', '[##SITE_NAME##] ##SUBJECT##', '<div style="padding: 10px; width: 720px; margin: auto;">\r\n<table width="720px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; text-align: center; font-size: 10px; color:#333333; margin: 3px;">\r\n        Be sure to add\r\n        <a href="mailto:##FROM_EMAIL##" style="color:#ff0084;" title="Add ##FROM_EMAIL## to your whitelist" target="_blank">##FROM_EMAIL##</a>\r\n        to your address book or safe sender list so our emails get to your inbox.      </p>\r\n    </td>\r\n  </tr>\r\n</tbody></table>\r\n<div style="width: 670px; margin: 5px 0pt; padding: 15px; background-repeat: no-repeat; border: 3px solid #0063dc; background-color: #eef6ff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255); margin-bottom:5px; border-bottom:3px solid #0063dc;">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;">\r\n    <h1 style="color:#333333; margin: 0pt 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n          <a target="_blank" title="##SITE_NAME##" style="color: #ff0084;" href="##SITE_LINK##">\r\n          <img style="border:none;" src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]" width="186px"/></a>\r\n        </h1></td>\r\n  </tr>\r\n</table>\r\n <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;"> <h2 style="color:#333333; border-bottom:1px solid #dddddd; padding:0 0 5px 0; margin: 0 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n	##MESSAGE##\r\n        </h2></td>\r\n  </tr>\r\n</table>\r\n\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody>\r\n    <tr>\r\n      <td style="padding:0 20px 0 20px;">\r\n<table width="100%" border="0">\r\n          <tr>\r\n            <td width="32%"> <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">Telephone</p>\r\n              </td>\r\n            <td width="8%"> <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">:</p>\r\n              </td>\r\n            <td width="60%"> <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;"> ##TELEPHONE##</p>\r\n              </td>\r\n             <tr>\r\n            <td> <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">IP</p>\r\n              </td>\r\n            <td> <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">:</p>\r\n              </td>\r\n            <td> <p style="font-family: Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">##IP##, ##SITE_ADDR##</p>\r\n              </td>\r\n          <tr>\r\n            <td> <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">Whois</p>\r\n              </td>\r\n            <td> <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">:</p>\r\n              </td>\r\n            <td> <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">http://whois.sc/##IP##</p>\r\n              </td>\r\n          <tr>\r\n         <tr>\r\n            <td> <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">URL</p>\r\n              </td>\r\n            <td> <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">:</p>\r\n              </td>\r\n            <td> <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;">##FROM_URL##</p>\r\n              </td>\r\n          <tr>  \r\n        </table>  \r\n       \r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid #d5d5d5; padding: 15px 30px 25px; margin: 0pt 20px;">\r\n          <h4 style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 20px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#ff0084;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: verdana,Helvetica,Arial,sans-serif; color: #333333; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_LINK##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #ff96cc;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: #fff; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#fff;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="720px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 10px; color: #333333; margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'FROM_URL, IP, TELEPHONE, MESSAGE, SITE_NAME, SUBJECT, FROM_EMAIL, LAST_NAME, FIRST_NAME', 1);
INSERT INTO `email_templates` (`id`, `created`, `modified`, `from`, `reply_to`, `name`, `description`, `subject`, `email_content`, `email_variables`, `is_html`) VALUES
(11, '2009-10-14 19:20:59', '2011-06-03 13:24:58', '"##SITE_NAME## (auto response)" <##FROM_EMAIL##>', '##REPLY_TO_EMAIL##', 'Contact Us Auto Reply', 'we will send this mail to user, when user submit the contact us form.', '[##SITE_NAME##] RE: ##SUBJECT##', '<div style="padding: 10px; width: 720px; margin: auto;">\r\n<table width="720px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; text-align: center; font-size: 10px; color:#333333; margin: 3px;">\r\n        Be sure to add\r\n        <a href="mailto:##FROM_EMAIL##" style="color:#ff0084;" title="Add ##FROM_EMAIL## to your whitelist" target="_blank">##FROM_EMAIL##</a>\r\n        to your address book or safe sender list so our emails get to your inbox.      </p>\r\n    </td>\r\n  </tr>\r\n</tbody></table>\r\n<div style="width: 670px; margin: 5px 0pt; padding: 15px; background-repeat: no-repeat; border: 3px solid #0063dc; background-color: #eef6ff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255); margin-bottom:5px; border-bottom:3px solid #0063dc;">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;">\r\n    <h1 style="color:#333333; margin: 0pt 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n          <a target="_blank" title="##SITE_NAME##" style="color: #ff0084;" href="##SITE_LINK##">\r\n          <img style="border:none;" src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]" width="186px"/></a>\r\n        </h1></td>\r\n  </tr>\r\n</table>\r\n <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;"> <h2 style="color:#333333; border-bottom:1px solid #dddddd; padding:0 0 5px 0; margin: 0 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\nHi ##FIRST_NAME####LAST_NAME##,</td>\r\n  </tr>\r\n</table>\r\n\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody>\r\n    <tr>\r\n      <td style="padding:0 20px 0 20px;">\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">Thanks for contacting us. We''ll get back to you shortly.</p>\r\n                <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">Please do not reply to this automated response. If you have not contacted us and if you feel this is an error, please contact us through our site\r\n##CONTACT_URL##</p>\r\n   <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;">------ On ##POST_DATE## you wrote from ##IP## --------</p>\r\n   <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: rgb(84, 84, 84); margin: 0pt 20px; font-size: 16px; text-align: left; padding: 15px 0px;">##MESSAGE##\r\n</p>\r\n       \r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid #d5d5d5; padding: 15px 30px 25px; margin: 0pt 20px;">\r\n          <h4 style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 20px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#ff0084;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: verdana,Helvetica,Arial,sans-serif; color: #333333; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_LINK##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #ff96cc;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: #fff; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#fff;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="720px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 10px; color: #333333; margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'MESSAGE, POST_DATE, SITE_NAME, CONTACT_URL, FIRST_NAME, LAST_NAME,\r\nSUBJECT, SITE_LINK', 1),
(12, '0000-00-00 00:00:00', '2011-06-03 13:21:03', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'New booking Traveler notification', 'Internal mail sent to the traveler when he makes a new booking.', 'Your booking has been made.', '<div style="padding: 10px; width: 720px; margin: auto;">\r\n<div style="width: 610px; margin: 5px 0pt; padding: 15px; background-repeat: no-repeat; border: 3px solid #0063dc; background-color: #eef6ff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255); margin-bottom:5px; border-bottom:3px solid #0063dc;">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;">\r\n    <h1 style="color:#333333; margin: 0pt 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n          <a target="_blank" title="##SITE_NAME##" style="color: #ff0084;" href="##SITE_LINK##">\r\n          <img style="border:none;" src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]" width="186px"/></a>\r\n        </h1></td>\r\n  </tr>\r\n</table>\r\n <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;"> <h2 style="color:#333333; border-bottom:1px solid #dddddd; padding:0 0 5px 0; margin: 0 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n		Dear ##USERNAME##,\r\n        </h2></td>\r\n  </tr>\r\n</table>\r\n\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody>\r\n    <tr>\r\n      <td style="padding:0 20px 0 20px;">\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">##SITE_NAME##: Thank you. Please read this information about your booking from ##HOST_NAME##</p>\r\n           <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">Your booking has been sent to the host and is now waiting for their approval. We will notify you when that happens. Please keep this mail until your booking is complete.</p>\r\n            <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><b>Booked property:</b> ##PROPERTY_NAME##.</p>\r\n            <p style="border:1px dashed #333; border-width:1px 0 1px 0;font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0 0 10px 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><b>Information about your booking</b></p>\r\n                  <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0 0 10px 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><b>Booking</b> ###ORDER_NO##\r\n##PROPERTY_FULL_NAME##</p>\r\n    <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0 0 10px 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><b>Description:</b>\r\n##PROPERTY_DESCRIPTION##</p>\r\n <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0 0 10px 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><b>Checking In:</b> ##CHECK_IN_DATE##</p>\r\n <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0 0 10px 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><b>Checking Out:</b> ##CHECK_OUT_DATE##</p>\r\n <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0 0 10px 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><b>Host:</b> ##HOST_NAME## (##HOST_RATING##) ##HOST_CONTACT_LINK##</p> \r\n       <p style="border:1px dashed #333; border-width:1px 0 1px 0;font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0 0 10px 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><b>What to do if the host is not responding?</b></p>\r\n       <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0 0 10px 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">If you feel that the host is taking too long to respond, you can ##CANCEL_URL## and get your funds back to your Account. We recommend allowing host at least ##PROPERTY_AUTO_EXPIRE_DATE## hours to respond.</p> \r\n       \r\n              <p style="border:1px dashed #333; border-width:1px 0 1px 0;font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0 0 10px 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><b>What if the host rejects my booking?</b></p>\r\n       <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0 0 10px 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">Host may sometimes choose to give up on an booking. This may be due to their inability to perform their work based on the information you provided\r\nor they are simply too busy or currently unavailable.</p> \r\n  <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0 0 10px 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">If a host rejects your booking, your funds are returned to your ##SITE_NAME## account.</p>\r\n  \r\n  \r\n  \r\n                <p style="border:1px dashed #333; border-width:1px 0 1px 0;font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0 0 10px 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><b>##SITE_NAME## Customer Service</b></p>\r\n       <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0 0 10px 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">The ##SITE_NAME## Customer service are here to help you. If you need any assistance with an booking, Please contact us here:\r\n##CONTACT_LINK##</p> \r\n         </td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid #d5d5d5; padding: 15px 30px 25px; margin: 0pt 20px;">\r\n          <h4 style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 20px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#ff0084;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: verdana,Helvetica,Arial,sans-serif; color: #333333; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_LINK##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #ff96cc;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: #fff; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#fff;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="720px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 10px; color: #333333; margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'SITE_NAME, HOST_NAME, USERNAME, PROPERTY_FULL_NAME, PROPERTY_DESCRIPTION, PROPERTY_ORDER_COMPLETION_DATE, SELLER_RATING, SELLER_CONTACT_LINK, REJECT_URL, BALANCE_LINK, PROPERTY_AUTO_EXPIRE_DATE, CONTACT_LINK', 1),
(13, '0000-00-00 00:00:00', '2011-06-03 13:25:38', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'New booking notification', 'When new booking was made, an internal\r\nmessage will be sent to the owner of the property notify new booking.', 'You have a new booking', '<div style="padding: 10px; width: 650px; margin: auto;">\r\n<div style="width: 610px; margin: 5px 0pt; padding: 15px; background-repeat: no-repeat; border: 3px solid #0063dc; background-color: #eef6ff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255); margin-bottom:5px; border-bottom:3px solid #0063dc;">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;">\r\n    <h1 style="color:#333333; margin: 0pt 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n          <a target="_blank" title="##SITE_NAME##" style="color: #ff0084;" href="##SITE_LINK##">\r\n          <img style="border:none;" src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]" width="186px"/></a>\r\n        </h1></td>\r\n  </tr>\r\n</table>\r\n <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;"> <h2 style="color:#333333; border-bottom:1px solid #dddddd; padding:0 0 5px 0; margin: 0 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\nDear ##USERNAME##\r\n        </h2></td>\r\n  </tr>\r\n</table>\r\n\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody>\r\n    <tr>\r\n      <td style="padding:0 20px 0 20px;">\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">You have a new booking from ##TRAVELER_USERNAME##.</p>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"> <b>Booked property:</b> ##PROPERTY_NAME##.</p>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">Please click the following link to accept the booking \r\n##ACCEPT_URL##</p>\r\n                        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">Please click the following link to reject the booking \r\n##REJECT_URL##</p>\r\n       \r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid #d5d5d5; padding: 15px 30px 25px; margin: 0pt 20px;">\r\n          <h4 style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 20px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#ff0084;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: verdana,Helvetica,Arial,sans-serif; color: #333333; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_LINK##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #ff96cc;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: #fff; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#fff;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="650px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 10px; color: #333333; margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'USERNAME,TRAVERLLER_USERNAME,PROPERTY_NAME,ACCEPT_URL,REJECT_URL', 1),
(14, '0000-00-00 00:00:00', '2011-06-03 13:25:50', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Canceled booking notification', 'Internal message will be sent to the host, when the booked property was canceled by the Traveler.', 'Your booking has been canceled', '<div style="padding: 10px; width: 650px; margin: auto;">\r\n<div style="width: 610px; margin: 5px 0pt; padding: 15px; background-repeat: no-repeat; border: 3px solid #0063dc; background-color: #eef6ff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255); margin-bottom:5px; border-bottom:3px solid #0063dc;">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;">\r\n    <h1 style="color:#333333; margin: 0pt 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n          <a target="_blank" title="##SITE_NAME##" style="color: #ff0084;" href="##SITE_LINK##">\r\n          <img style="border:none;" src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]" width="186px"/></a>\r\n        </h1></td>\r\n  </tr>\r\n</table>\r\n <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;"> <h2 style="color:#333333; border-bottom:1px solid #dddddd; padding:0 0 5px 0; margin: 0 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n		Dear \r\n        ##USERNAME##,\r\n        </h2></td>\r\n  </tr>\r\n</table>\r\n\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody>\r\n    <tr>\r\n      <td style="padding:0 20px 0 20px;">\r\n       <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><b>##MESSAGE##</b></p>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">Your booking has been canceled.</p>\r\n                <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><b>Booked property:</b> ##PROPERTY_NAME##.</p>\r\n       \r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid #d5d5d5; padding: 15px 30px 25px; margin: 0pt 20px;">\r\n          <h4 style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 20px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#ff0084;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: verdana,Helvetica,Arial,sans-serif; color: #333333; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_LINK##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #ff96cc;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: #fff; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#fff;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="650px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 10px; color: #333333; margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'USERNAME, PROPERTY_NAME', 1),
(15, '0000-00-00 00:00:00', '2011-06-03 13:26:21', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Accepted booking notification', 'Internal message will be sent to the Traveler, when the booked property was accepted by the host.', 'Your booking has been accepted', '<div style="padding: 10px; width: 650px; margin: auto;">\r\n<div style="width: 610px; margin: 5px 0pt; padding: 15px; background-repeat: no-repeat; border: 3px solid #0063dc; background-color: #eef6ff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255); margin-bottom:5px; border-bottom:3px solid #0063dc;">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;">\r\n    <h1 style="color:#333333; margin: 0pt 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n          <a target="_blank" title="##SITE_NAME##" style="color: #ff0084;" href="##SITE_LINK##">\r\n          <img style="border:none;" src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]" width="186px"/></a>\r\n        </h1></td>\r\n  </tr>\r\n</table>\r\n <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;"> <h2 style="color:#333333; border-bottom:1px solid #dddddd; padding:0 0 5px 0; margin: 0 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n	Dear ##USERNAME##,\r\n        </h2></td>\r\n  </tr>\r\n</table>\r\n\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody>\r\n    <tr>\r\n      <td style="padding:0 20px 0 20px;">\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">Your booking has been accepted. Looking forward for your visit:)</p>\r\n                <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><b>Booked Property:</b> ##PROPERTY_NAME##</p>\r\n                                <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">##HOST_CONTACT##</p>\r\n                                        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">##PRINT##</p>\r\n       \r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid #d5d5d5; padding: 15px 30px 25px; margin: 0pt 20px;">\r\n          <h4 style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 20px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#ff0084;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: verdana,Helvetica,Arial,sans-serif; color: #333333; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_LINK##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #ff96cc;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: #fff; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#fff;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="650px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 10px; color: #333333; margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'USERNAME, PROPERTY_NAME', 1),
(16, '0000-00-00 00:00:00', '2011-06-03 13:26:47', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Rejected booking notification', 'Internal message will be sent to the Traveler, when the booked property was rejected by the host.', 'Your booking has been rejected', '<div style="padding: 10px; width: 650px; margin: auto;">\r\n<div style="width: 610px; margin: 5px 0pt; padding: 15px; background-repeat: no-repeat; border: 3px solid #0063dc; background-color: #eef6ff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255); margin-bottom:5px; border-bottom:3px solid #0063dc;">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;">\r\n    <h1 style="color:#333333; margin: 0pt 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n          <a target="_blank" title="##SITE_NAME##" style="color: #ff0084;" href="##SITE_LINK##">\r\n          <img style="border:none;" src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]" width="186px"/></a>\r\n        </h1></td>\r\n  </tr>\r\n</table>\r\n <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;"> <h2 style="color:#333333; border-bottom:1px solid #dddddd; padding:0 0 5px 0; margin: 0 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n	Dear ##USERNAME##,\r\n        </h2></td>\r\n  </tr>\r\n</table>\r\n\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody>\r\n    <tr>\r\n      <td style="padding:0 20px 0 20px;">\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">Your booking has been rejected. </p>\r\n                <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">We apologize for the inconvenience :(</p>\r\n                   <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><b>Booked property:</b> ##PROPERTY_NAME##.</p>\r\n       \r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid #d5d5d5; padding: 15px 30px 25px; margin: 0pt 20px;">\r\n          <h4 style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 20px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#ff0084;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: verdana,Helvetica,Arial,sans-serif; color: #333333; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_LINK##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #ff96cc;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: #fff; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#fff;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="650px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 10px; color: #333333; margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'USERNAME, PROPERTY_NAME', 1),
(17, '0000-00-00 00:00:00', '2011-06-03 13:27:34', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Traveler review notification', 'Internal message will be sent to the Traveler, when the booked property was completed by the host and waiting for the Traveler to make the review.', 'Your booking has been completed', '<div style="padding: 10px; width: 650px; margin: auto;">\r\n<div style="width: 610px; margin: 5px 0pt; padding: 15px; background-repeat: no-repeat; border: 3px solid #0063dc; background-color: #eef6ff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255); margin-bottom:5px; border-bottom:3px solid #0063dc;">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;">\r\n    <h1 style="color:#333333; margin: 0pt 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n          <a target="_blank" title="##SITE_NAME##" style="color: #ff0084;" href="##SITE_LINK##">\r\n          <img style="border:none;" src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]" width="186px"/></a>\r\n        </h1></td>\r\n  </tr>\r\n</table>\r\n <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;"> <h2 style="color:#333333; border-bottom:1px solid #dddddd; padding:0 0 5px 0; margin: 0 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\nDear ##USERNAME##,\r\n        </h2></td>\r\n  </tr>\r\n</table>\r\n\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody>\r\n    <tr>\r\n      <td style="padding:0 20px 0 20px;">\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><b>Thank you for visiting ##PROPERTY_NAME##.</b></p>\r\n\r\n\r\n\r\n<p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">Our goal is to exceed our guests expectations at every opportunity. In that regard, I would personally appreciate hearing your comments about your stay.</p>   \r\n<p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">For your convenience we have included this ##REVIEW_URL##. Please take just a moment to rate your stay.</p>   \r\n<p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">Your comments are very important to us.</p> \r\n<p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><small>Thank you again for visiting, Hope you have enjoyed the stay.</small></p> \r\n\r\n       \r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid #d5d5d5; padding: 15px 30px 25px; margin: 0pt 20px;">\r\n          <h4 style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 20px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#ff0084;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: verdana,Helvetica,Arial,sans-serif; color: #333333; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_LINK##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #ff96cc;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: #fff; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#fff;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="650px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 10px; color: #333333; margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'USERNAME, PROPERTY_NAME,REVIEW_URL', 1),
(18, '0000-00-00 00:00:00', '2011-06-03 13:27:52', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Completed booking notification', 'Internal message will be sent to the host, when the Traveler makes the review and the booking gets completed after that process.', 'Your booking has been verified', '<div style="padding: 10px; width: 650px; margin: auto;">\r\n<div style="width: 610px; margin: 5px 0pt; padding: 15px; background-repeat: no-repeat; border: 3px solid #0063dc; background-color: #eef6ff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255); margin-bottom:5px; border-bottom:3px solid #0063dc;">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;">\r\n    <h1 style="color:#333333; margin: 0pt 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n          <a target="_blank" title="##SITE_NAME##" style="color: #ff0084;" href="##SITE_LINK##">\r\n          <img style="border:none;" src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]" width="186px"/></a>\r\n        </h1></td>\r\n  </tr>\r\n</table>\r\n <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;"> <h2 style="color:#333333; border-bottom:1px solid #dddddd; padding:0 0 5px 0; margin: 0 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n	Dear ##USERNAME##,\r\n        </h2></td>\r\n  </tr>\r\n</table>\r\n\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody>\r\n    <tr>\r\n      <td style="padding:0 20px 0 20px;">\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">##BUYER_USERNAME## has verified your work completion on booking ###ORDERNO##, of ##PROPERTY_NAME##.</p>\r\n       \r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid #d5d5d5; padding: 15px 30px 25px; margin: 0pt 20px;">\r\n          <h4 style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 20px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#ff0084;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: verdana,Helvetica,Arial,sans-serif; color: #333333; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_LINK##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #ff96cc;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: #fff; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#fff;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="650px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 10px; color: #333333; margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'USERNAME, ORDERNO, BUYER_USERNAME, PROPERTY_NAME', 1),
(19, '0000-00-00 00:00:00', '2011-06-03 13:28:06', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Auto expired notification', 'Internal message will be sent to the\r\nTraveler and host mentioning the booking was expired, when the booked property was not accepted by the host within the auto expire limit.', 'Your booking has been expired', '<div style="padding: 10px; width: 650px; margin: auto;">\r\n<div style="width: 610px; margin: 5px 0pt; padding: 15px; background-repeat: no-repeat; border: 3px solid #0063dc; background-color: #eef6ff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255); margin-bottom:5px; border-bottom:3px solid #0063dc;">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;">\r\n    <h1 style="color:#333333; margin: 0pt 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n          <a target="_blank" title="##SITE_NAME##" style="color: #ff0084;" href="##SITE_LINK##">\r\n          <img style="border:none;" src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]" width="186px"/></a>\r\n        </h1></td>\r\n  </tr>\r\n</table>\r\n <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;"> <h2 style="color:#333333; border-bottom:1px solid #dddddd; padding:0 0 5px 0; margin: 0 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\nDear ##USERNAME##,\r\n        </h2></td>\r\n  </tr>\r\n</table>\r\n\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody>\r\n    <tr>\r\n      <td style="padding:0 20px 0 20px;">\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">Property ##PROPERTY_NAME## has been expired and amount refunded to traveler due to non-acceptance by the host within ##EXPIRE_DATE##</p>\r\n        \r\n           <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><b>Booked property:</b> ##PROPERTY_NAME##</p>\r\n           \r\n             <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><b>Booking no:</b> ###ORDERNO##</p>\r\n       \r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid #d5d5d5; padding: 15px 30px 25px; margin: 0pt 20px;">\r\n          <h4 style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 20px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#ff0084;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: verdana,Helvetica,Arial,sans-serif; color: #333333; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_LINK##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #ff96cc;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: #fff; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#fff;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="650px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 10px; color: #333333; margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'USERNAME, PROPERTY_NAME, ORDERNO, EXPIRE_DATE', 1),
(20, '0000-00-00 00:00:00', '2011-06-03 13:18:03', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Alert Mail', 'This is an external alert mail sent to the\r\nusers when they receive any message into their internal messages related to\r\ncontacting users.', '##SITE_NAME##: You have a new message from ##FROM_USER##', '<div style="padding: 10px; width: 720px; margin: auto;">\r\n<table width="720px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; text-align: center; font-size: 10px; color:#333333; margin: 3px;">\r\n        Be sure to add\r\n        <a href="mailto:##FROM_EMAIL##" style="color:#ff0084;" title="Add ##FROM_EMAIL## to your whitelist" target="_blank">##FROM_EMAIL##</a>\r\n        to your address book or safe sender list so our emails get to your inbox.      </p>\r\n    </td>\r\n  </tr>\r\n</tbody></table>\r\n<div style="width: 670px; margin: 5px 0pt; padding: 15px; background-repeat: no-repeat; border: 3px solid #0063dc; background-color: #eef6ff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255); margin-bottom:5px; border-bottom:3px solid #0063dc;">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;">\r\n    <h1 style="color:#333333; margin: 0pt 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n          <a target="_blank" title="##SITE_NAME##" style="color: #ff0084;" href="##SITE_LINK##">\r\n          <img style="border:none;" src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]" width="186px"/></a>\r\n        </h1></td>\r\n  </tr>\r\n</table>\r\n <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;"> <h2 style="color:#333333; border-bottom:1px solid #dddddd; padding:0 0 5px 0; margin: 0 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\nHi ##TO_USER##,\r\n        </h2></td>\r\n  </tr>\r\n</table>\r\n\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody>\r\n    <tr>\r\n      <td style="padding:0 20px 0 20px;">\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">A new message from ##FROM_USER## is waiting for you in your inbox</p>\r\n        \r\n           <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">To reply to this message click here: ##REPLY_LINK## </p>\r\n           \r\n                      <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">To view the full message and attachments (if any) click on the following link: \r\n##VIEW_LINK##</p>\r\n\r\n    <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">This is an automatically generated message by ##SITE_NAME## Replies are not monitored or answered.</p>\r\n       \r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid #d5d5d5; padding: 15px 30px 25px; margin: 0pt 20px;">\r\n          <h4 style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 20px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#ff0084;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: verdana,Helvetica,Arial,sans-serif; color: #333333; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_LINK##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #ff96cc;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: #fff; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#fff;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="720px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 10px; color: #333333; margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'SITE_NAME, FROM_USER, TO_USER, SUBJECT, MESSAGE, REPLY_LINK, VIEW_LINK, SITE_LINK', 1);
INSERT INTO `email_templates` (`id`, `created`, `modified`, `from`, `reply_to`, `name`, `description`, `subject`, `email_content`, `email_variables`, `is_html`) VALUES
(23, '0000-00-00 00:00:00', '2010-06-29 11:20:50', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Booking Alert Mail', 'This is an external alert mail sent to\r\nthe user when they receive any message into their internal messages related to bookings.', '##SITE_NAME##: ##TO_USER## - ##SUBJECT##', '<div style="padding: 10px; width: 720px; margin: auto;">\r\n<table width="720px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; text-align: center; font-size: 10px; color:#333333; margin: 3px;">\r\n        Be sure to add\r\n        <a href="mailto:##FROM_EMAIL##" style="color:#ff0084;" title="Add ##FROM_EMAIL## to your whitelist" target="_blank">##FROM_EMAIL##</a>\r\n        to your address book or safe sender list so our emails get to your inbox.      </p>\r\n    </td>\r\n  </tr>\r\n</tbody></table>\r\n<div style="width: 670px; margin: 5px 0pt; padding: 15px; background-repeat: no-repeat; border: 3px solid #0063dc; background-color: #eef6ff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255); margin-bottom:5px; border-bottom:3px solid #0063dc;">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;">\r\n    <h1 style="color:#333333; margin: 0pt 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n          <a target="_blank" title="##SITE_NAME##" style="color: #ff0084;" href="##SITE_LINK##">\r\n          <img style="border:none;" src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]" width="186px"/></a>\r\n        </h1></td>\r\n  </tr>\r\n</table>\r\n <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;"> <h2 style="color:#333333; border-bottom:1px solid #dddddd; padding:0 0 5px 0; margin: 0 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\nHi ##TO_USER##, \r\n        </h2></td>\r\n  </tr>\r\n</table>\r\n\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody>\r\n    <tr>\r\n      <td style="padding:0 20px 0 20px;">\r\n       <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><b>##MESSAGE##</b></p>\r\n        \r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">To view the full message and attachments (if any) click on the following\r\nlink:##VIEW_LINK## </p>\r\n       \r\n               <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">This is an automatically generated message by ##SITE_NAME## </p>\r\n               \r\n                 <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">Replies are not monitored or answered.</p>\r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid #d5d5d5; padding: 15px 30px 25px; margin: 0pt 20px;">\r\n          <h4 style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 20px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#ff0084;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: verdana,Helvetica,Arial,sans-serif; color: #333333; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_LINK##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #ff96cc;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: #fff; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#fff;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="720px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 10px; color: #333333; margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'TO_USER,SITE_NAME,FROM_USER,SUBJECT,MESSAGE,VIEW_LINK,SITE_LINK,REFER_LINK', 1),
(24, '0000-00-00 00:00:00', '2010-06-07 13:53:05', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Invite User', 'This external mail will be sent, when users sends an invitation to other users.', '##USERNAME## would like to add you as a contact at ##SITE_NAME##', '<div style="padding: 10px; width: 720px; margin: auto;">\r\n<table width="720px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; text-align: center; font-size: 10px; color:#333333; margin: 3px;">\r\n        Be sure to add\r\n        <a href="mailto:##FROM_EMAIL##" style="color:#ff0084;" title="Add ##FROM_EMAIL## to your whitelist" target="_blank">##FROM_EMAIL##</a>\r\n        to your address book or safe sender list so our emails get to your inbox.      </p>\r\n    </td>\r\n  </tr>\r\n</tbody></table>\r\n<div style="width: 670px; margin: 5px 0pt; padding: 15px; background-repeat: no-repeat; border: 3px solid #0063dc; background-color: #eef6ff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255); margin-bottom:5px; border-bottom:3px solid #0063dc;">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;">\r\n    <h1 style="color:#333333; margin: 0pt 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n          <a target="_blank" title="##SITE_NAME##" style="color: #ff0084;" href="##SITE_LINK##">\r\n          <img style="border:none;" src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]" width="186px"/></a>\r\n        </h1></td>\r\n  </tr>\r\n</table>\r\n <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;"> <h2 style="color:#333333; border-bottom:1px solid #dddddd; padding:0 0 5px 0; margin: 0 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n		Hi \r\n        ##USERNAME##,\r\n        </h2></td>\r\n  </tr>\r\n</table>\r\n\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody>\r\n    <tr>\r\n      <td style="padding:0 20px 0 20px;">\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">requested you to join his/her ##SITE_NAME## network.</p>\r\n        \r\n          <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">I have joined the ##SITE_NAME## network. I wish to invite you to ##SITE_NAME## as well.</p>\r\n          \r\n                <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">Click below to register in the site\r\n##REFER_LINK##</p>\r\n       \r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><b>Join fast!</b>\r\n##USERNAME##</p>\r\n\r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid #d5d5d5; padding: 15px 30px 25px; margin: 0pt 20px;">\r\n          <h4 style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 20px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#ff0084;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: verdana,Helvetica,Arial,sans-serif; color: #333333; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_LINK##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #ff96cc;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: #fff; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#fff;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="720px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 10px; color: #333333; margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'FROM_EMAIL, REPLY_TO_EMAIL, SITE_LINK, SITE_NAME, USERNAME, REFER_LINK', 1),
(26, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'New booking Traveler Mail', 'External mail to the Traveler when he makes an new booking.', 'Your booking has been placed', '<div style="padding: 10px; width: 720px; margin: auto;">\r\n<table width="720px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; text-align: center; font-size: 10px; color:#333333; margin: 3px;">\r\n        Be sure to add\r\n        <a href="mailto:##FROM_EMAIL##" style="color:#ff0084;" title="Add ##FROM_EMAIL## to your whitelist" target="_blank">##FROM_EMAIL##</a>\r\n        to your address book or safe sender list so our emails get to your inbox.      </p>\r\n    </td>\r\n  </tr>\r\n</tbody></table>\r\n<div style="width: 670px; margin: 5px 0pt; padding: 15px; background-repeat: no-repeat; border: 3px solid #0063dc; background-color: #eef6ff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255); margin-bottom:5px; border-bottom:3px solid #0063dc;">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;">\r\n    <h1 style="color:#333333; margin: 0pt 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n          <a target="_blank" title="##SITE_NAME##" style="color: #ff0084;" href="##SITE_LINK##">\r\n          <img style="border:none;" src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]" width="186px"/></a>\r\n        </h1></td>\r\n  </tr>\r\n</table>\r\n <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;"> <h2 style="color:#333333; border-bottom:1px solid #dddddd; padding:0 0 5px 0; margin: 0 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\nDear ##USERNAME##\r\n        </h2></td>\r\n  </tr>\r\n</table>\r\n\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody>\r\n    <tr>\r\n      <td style="padding:0 20px 0 20px;">\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">your booking has been sent to the host and is now waiting for their approval.</p>\r\n        \r\n         <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">You will be notified once that happens.</p>\r\n         \r\n          <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">This is an automatically generated message by ##SITE_NAME##</p>\r\n          \r\n           <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">Replies are not monitored or answered.</p>\r\n       \r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid #d5d5d5; padding: 15px 30px 25px; margin: 0pt 20px;">\r\n          <h4 style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 20px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#ff0084;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: verdana,Helvetica,Arial,sans-serif; color: #333333; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_LINK##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #ff96cc;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: #fff; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#fff;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="720px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 10px; color: #333333; margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'USERNAME, SITE_NAME, SITE_LINK', 1),
(27, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Accept booking host notification', 'Internal message sent back to host after the booking has been accepted.', 'You have accepted the booking', '<div style="padding: 10px; width: 650px; margin: auto;">\r\n<div style="width: 610px; margin: 5px 0pt; padding: 15px; background-repeat: no-repeat; border: 3px solid #0063dc; background-color: #eef6ff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255); margin-bottom:5px; border-bottom:3px solid #0063dc;">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;">\r\n    <h1 style="color:#333333; margin: 0pt 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n          <a target="_blank" title="##SITE_NAME##" style="color: #ff0084;" href="##SITE_LINK##">\r\n          <img style="border:none;" src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]" width="186px"/></a>\r\n        </h1></td>\r\n  </tr>\r\n</table>\r\n <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;"> <h2 style="color:#333333; border-bottom:1px solid #dddddd; padding:0 0 5px 0; margin: 0 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n		Hi \r\n        ##USERNAME##,\r\n        </h2></td>\r\n  </tr>\r\n</table>\r\n\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody>\r\n    <tr>\r\n      <td style="padding:0 20px 0 20px;">\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">You have accepted the booking.</p>\r\n        \r\n          <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><b>Booked Property:</b> ##PROPERTY_NAME##.</p>\r\n          \r\n            <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><b>Booking No#:</b>##ORDERNO##</p>\r\n            \r\n            <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">##GUEST_CONTACT##</p>\r\n       \r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid #d5d5d5; padding: 15px 30px 25px; margin: 0pt 20px;">\r\n          <h4 style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 20px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#ff0084;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: verdana,Helvetica,Arial,sans-serif; color: #333333; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_LINK##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #ff96cc;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: #fff; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#fff;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="650px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 10px; color: #333333; margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'USERNAME, ORDERNO, PROPERTY_NAME', 1),
(28, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Rejected booking host notification', 'Internal message sent back to host after the booking has been rejected.', 'You have rejected the booking', '<div style="padding: 10px; width: 650px; margin: auto;">\r\n<div style="width: 610px; margin: 5px 0pt; padding: 15px; background-repeat: no-repeat; border: 3px solid #0063dc; background-color: #eef6ff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255); margin-bottom:5px; border-bottom:3px solid #0063dc;">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;">\r\n    <h1 style="color:#333333; margin: 0pt 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n          <a target="_blank" title="##SITE_NAME##" style="color: #ff0084;" href="##SITE_LINK##">\r\n          <img style="border:none;" src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]" width="186px"/></a>\r\n        </h1></td>\r\n  </tr>\r\n</table>\r\n <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;"> <h2 style="color:#333333; border-bottom:1px solid #dddddd; padding:0 0 5px 0; margin: 0 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n		Dear \r\n        ##USERNAME##,\r\n        </h2></td>\r\n  </tr>\r\n</table>\r\n\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody>\r\n    <tr>\r\n      <td style="padding:0 20px 0 20px;">\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">You have rejected the booking:<br />\r\n          </p>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><b>Booked property:</b> ##PROPERTY_NAME##.<br />\r\n        </p>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><strong>Booking No#:</strong> ##ORDERNO##</p></td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid #d5d5d5; padding: 15px 30px 25px; margin: 0pt 20px;">\r\n          <h4 style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 20px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#ff0084;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: verdana,Helvetica,Arial,sans-serif; color: #333333; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_LINK##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #ff96cc;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: #fff; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#fff;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="650px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 10px; color: #333333; margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'USERNAME, ORDERNO, PROPERTY_NAME', 1),
(29, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Canceled booking Traveler notification', 'Internal message sent back to Traveler after the booking has been canceled.', 'You have canceled the booking', '<div style="padding: 10px; width: 650px; margin: auto;">\r\n<div style="width: 610px; margin: 5px 0pt; padding: 15px; background-repeat: no-repeat; border: 3px solid #0063dc; background-color: #eef6ff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255); margin-bottom:5px; border-bottom:3px solid #0063dc;">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;">\r\n    <h1 style="color:#333333; margin: 0pt 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n          <a target="_blank" title="##SITE_NAME##" style="color: #ff0084;" href="##SITE_LINK##">\r\n          <img style="border:none;" src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]" width="186px"/></a>\r\n        </h1></td>\r\n  </tr>\r\n</table>\r\n <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;"> <h2 style="color:#333333; border-bottom:1px solid #dddddd; padding:0 0 5px 0; margin: 0 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n		Dear \r\n        ##USERNAME##,\r\n        </h2></td>\r\n  </tr>\r\n</table>\r\n\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody>\r\n    <tr>\r\n      <td style="padding:0 20px 0 20px;">\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">You have canceled the booking: ##MESSAGE##</p>\r\n        \r\n            <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><b>Booked property:</b> ##PROPERTY_NAME##</p>\r\n            <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><strong>Booking No#:</strong> ##ORDERNO##</p></td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid #d5d5d5; padding: 15px 30px 25px; margin: 0pt 20px;">\r\n          <h4 style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 20px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#ff0084;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: verdana,Helvetica,Arial,sans-serif; color: #333333; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_LINK##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #ff96cc;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: #fff; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#fff;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="650px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 10px; color: #333333; margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'USERNAME, ORDERNO, PROPERTY_NAME', 1),
(30, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Traveler review host notification', 'Internal message sent back to host after the booking has been completed and delivered.', 'You have delivered your work', '<div style="padding: 10px; width: 650px; margin: auto;">\r\n<div style="width: 610px; margin: 5px 0pt; padding: 15px; background-repeat: no-repeat; border: 3px solid #0063dc; background-color: #eef6ff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255); margin-bottom:5px; border-bottom:3px solid #0063dc;">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;">\r\n    <h1 style="color:#333333; margin: 0pt 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n          <a target="_blank" title="##SITE_NAME##" style="color: #ff0084;" href="##SITE_LINK##">\r\n          <img style="border:none;" src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]" width="186px"/></a>\r\n        </h1></td>\r\n  </tr>\r\n</table>\r\n <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;"> <h2 style="color:#333333; border-bottom:1px solid #dddddd; padding:0 0 5px 0; margin: 0 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n		Dear \r\n        ##USERNAME##,\r\n        </h2></td>\r\n  </tr>\r\n</table>\r\n\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody>\r\n    <tr>\r\n      <td style="padding:0 20px 0 20px;">\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">You have delivered the booking and is now waiting for the Traveler review.</p>\r\n        \r\n            <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">You will be notified once that happens.</p>\r\n            \r\n                <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><b>Booked property:</b> ##PROPERTY_NAME##</p>\r\n          <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><b>Booking No#: </b>##ORDERNO##</p></td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid #d5d5d5; padding: 15px 30px 25px; margin: 0pt 20px;">\r\n          <h4 style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 20px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#ff0084;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: verdana,Helvetica,Arial,sans-serif; color: #333333; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_LINK##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #ff96cc;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: #fff; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#fff;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="650px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 10px; color: #333333; margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'USERNAME, ORDERNO, PROPERTY_NAME', 1),
(31, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Completed booking Traveler notification', 'Internal message sent back to Traveler after the booking has been reviewed and\r\ncompleted.', 'Your booking has completed.', '<div style="padding: 10px; width: 650px; margin: auto;">\r\n<div style="width: 610px; margin: 5px 0pt; padding: 15px; background-repeat: no-repeat; border: 3px solid #0063dc; background-color: #eef6ff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255); margin-bottom:5px; border-bottom:3px solid #0063dc;">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;">\r\n    <h1 style="color:#333333; margin: 0pt 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n          <a target="_blank" title="##SITE_NAME##" style="color: #ff0084;" href="##SITE_LINK##">\r\n          <img style="border:none;" src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]" width="186px"/></a>\r\n        </h1></td>\r\n  </tr>\r\n</table>\r\n <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;"> <h2 style="color:#333333; border-bottom:1px solid #dddddd; padding:0 0 5px 0; margin: 0 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n		Dear \r\n        ##USERNAME##,\r\n        </h2></td>\r\n  </tr>\r\n</table>\r\n\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody>\r\n    <tr>\r\n      <td style="padding:0 20px 0 20px;">\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">Thanks for your review. The booking has been completed.</p>\r\n        \r\n          <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><b>Booked property:</b> ##PROPERTY_NAME##</p>\r\n          <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><strong>Booking No#:</strong> ##ORDERNO##</p></td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid #d5d5d5; padding: 15px 30px 25px; margin: 0pt 20px;">\r\n          <h4 style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 20px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#ff0084;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: verdana,Helvetica,Arial,sans-serif; color: #333333; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_LINK##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #ff96cc;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: #fff; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#fff;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="650px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 10px; color: #333333; margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'USERNAME, ORDERNO, PROPERTY_NAME', 1),
(32, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Cleared amount notification', 'Internal message sent to the host when the amount for the booking has been cleared.', 'Your amount has been cleared', '<div style="padding: 10px; width:650px; margin: auto;">\r\n<div style="width: 610px; margin: 5px 0pt; padding: 15px; background-repeat: no-repeat; border: 3px solid #0063dc; background-color: #eef6ff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255); margin-bottom:5px; border-bottom:3px solid #0063dc;">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;">\r\n    <h1 style="color:#333333; margin: 0pt 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n          <a target="_blank" title="##SITE_NAME##" style="color: #ff0084;" href="##SITE_LINK##">\r\n          <img style="border:none;" src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]" width="186px"/></a>\r\n        </h1></td>\r\n  </tr>\r\n</table>\r\n <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;"> <h2 style="color:#333333; border-bottom:1px solid #dddddd; padding:0 0 5px 0; margin: 0 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n		Dear \r\n        ##USERNAME##,\r\n        </h2></td>\r\n  </tr>\r\n</table>\r\n\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody>\r\n    <tr>\r\n      <td style="padding:0 20px 0 20px;">\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">Your amount for the booking has been cleared for withdrawal.</p>\r\n        \r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><b>Booked property:</b> ##PROPERTY_NAME##</p>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><strong>Booking No#:</strong> ##ORDERNO##</p></td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid #d5d5d5; padding: 15px 30px 25px; margin: 0pt 20px;">\r\n          <h4 style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 20px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#ff0084;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: verdana,Helvetica,Arial,sans-serif; color: #333333; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_LINK##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #ff96cc;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: #fff; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#fff;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="650px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 10px; color: #333333; margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'USERNAME, ORDERNO, PROPERTY_NAME', 1),
(33, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Admin rejected booking notification', 'Internal message sent when booking has rejected by admin. This happens when an property has been suspend by administrator', 'Your booking has been canceled by Administrator', '<div style="padding: 10px; width: 650px; margin: auto;">\r\n<div style="width: 610px; margin: 5px 0pt; padding: 15px; background-repeat: no-repeat; border: 3px solid #0063dc; background-color: #eef6ff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255); margin-bottom:5px; border-bottom:3px solid #0063dc;">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;">\r\n    <h1 style="color:#333333; margin: 0pt 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n          <a target="_blank" title="##SITE_NAME##" style="color: #ff0084;" href="##SITE_LINK##">\r\n          <img style="border:none;" src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]" width="186px"/></a>\r\n        </h1></td>\r\n  </tr>\r\n</table>\r\n <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;"> <h2 style="color:#333333; border-bottom:1px solid #dddddd; padding:0 0 5px 0; margin: 0 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n		Dear \r\n        ##USERNAME##,\r\n        </h2></td>\r\n  </tr>\r\n</table>\r\n\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody>\r\n    <tr>\r\n      <td style="padding:0 20px 0 20px;">\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">Your booking has been canceled by administrator.</p>\r\n  <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><b>Booked Property:</b> ##PROPERTY_NAME##</p>\r\n  <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><b>Booking No#:</b> ##ORDERNO##</p>\r\n       \r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid #d5d5d5; padding: 15px 30px 25px; margin: 0pt 20px;">\r\n          <h4 style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 20px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#ff0084;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: verdana,Helvetica,Arial,sans-serif; color: #333333; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_LINK##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #ff96cc;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: #fff; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#fff;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="650px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 10px; color: #333333; margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'USERNAME, ORDERNO, PROPERTY_NAME', 1),
(34, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Admin rejected booking host notification', 'Internal message sent back to the host when booking has been canceled by\r\nadministrator. This happen when administrator suspends the host property.', 'Your booking has been canceled by Administrator', '<div style="padding: 10px; width: 650px; margin: auto;">\r\n<div style="width: 610px; margin: 5px 0pt; padding: 15px; background-repeat: no-repeat; border: 3px solid #0063dc; background-color: #eef6ff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255); margin-bottom:5px; border-bottom:3px solid #0063dc;">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;">\r\n    <h1 style="color:#333333; margin: 0pt 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n          <a target="_blank" title="##SITE_NAME##" style="color: #ff0084;" href="##SITE_LINK##">\r\n          <img style="border:none;" src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]" width="186px"/></a>\r\n        </h1></td>\r\n  </tr>\r\n</table>\r\n <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;"> <h2 style="color:#333333; border-bottom:1px solid #dddddd; padding:0 0 5px 0; margin: 0 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n		Dear ##USERNAME##,\r\n        </h2></td>\r\n  </tr>\r\n</table>\r\n\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody>\r\n    <tr>\r\n      <td style="padding:0 20px 0 20px;">\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">Your booking has been canceled by administrator:\r\n##MESSAGE##</p>\r\n\r\n  <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><b>Booked Property:</b> ##PROPERTY_NAME##</p>\r\n  <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><b>Booking No#:</b> ##ORDERNO##</p>\r\n       \r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid #d5d5d5; padding: 15px 30px 25px; margin: 0pt 20px;">\r\n          <h4 style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 20px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#ff0084;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: verdana,Helvetica,Arial,sans-serif; color: #333333; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_LINK##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #ff96cc;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: #fff; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#fff;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="650px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 10px; color: #333333; margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'USERNAME, ORDERNO, PROPERTY_NAME', 1);
INSERT INTO `email_templates` (`id`, `created`, `modified`, `from`, `reply_to`, `name`, `description`, `subject`, `email_content`, `email_variables`, `is_html`) VALUES
(35, '2010-12-04 10:14:29', '2011-06-10 15:03:25', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Requested Property Notification', 'we will send this mail, when\r\nthe property related for the user request', 'Property posted for your request', '<div style="padding: 10px; width: 650px; margin: auto;">\r\n<div style="width: 610px; margin: 5px 0pt; padding: 15px; background-repeat: no-repeat; border: 3px solid #0063dc; background-color: #eef6ff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255); margin-bottom:5px; border-bottom:3px solid #0063dc;">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;">\r\n    <h1 style="color:#333333; margin: 0pt 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n          <a target="_blank" title="##SITE_NAME##" style="color: #ff0084;" href="##SITE_LINK##">\r\n          <img style="border:none;" src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]" width="186px"/></a>\r\n        </h1></td>\r\n  </tr>\r\n</table>\r\n <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;"> <h2 style="color:#333333; border-bottom:1px solid #dddddd; padding:0 0 5px 0; margin: 0 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n		Hi \r\n        ##USERNAME##,\r\n        </h2></td>\r\n  </tr>\r\n</table>\r\n\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody>\r\n    <tr>\r\n      <td style="padding:0 20px 0 20px;">\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">A property related to your request ##REQUEST_URL## has been posted in ##SITE_NAME##</p>\r\n        \r\n             <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">Please visit the following URL to view the property ##PROPERTY_URL##</p>\r\n       \r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid #d5d5d5; padding: 15px 30px 25px; margin: 0pt 20px;">\r\n          <h4 style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 20px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#ff0084;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: verdana,Helvetica,Arial,sans-serif; color: #333333; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_LINK##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #ff96cc;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: #fff; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#fff;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="650px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 10px; color: #333333; margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'SITE_NAME, USERNAME, PROPERTY_URL,\r\nSITE_LINK, REQUEST_URL', 1),
(38, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Dispute Open Notification', 'Notification mail when dispute is opened.', '##USER_TYPE## has opened a dispute for this booking', '<div style="padding: 10px; width: 650px; margin: auto;">\r\n<div style="width: 610px; margin: 5px 0pt; padding: 15px; background-repeat: no-repeat; border: 3px solid #0063dc; background-color: #eef6ff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255); margin-bottom:5px; border-bottom:3px solid #0063dc;">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;">\r\n    <h1 style="color:#333333; margin: 0pt 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n          <a target="_blank" title="##SITE_NAME##" style="color: #ff0084;" href="##SITE_LINK##">\r\n          <img style="border:none;" src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]" width="186px"/></a>\r\n        </h1></td>\r\n  </tr>\r\n</table>\r\n <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;"> <h2 style="color:#333333; border-bottom:1px solid #dddddd; padding:0 0 5px 0; margin: 0 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n		Hi \r\n        ##USERNAME##,\r\n        </h2></td>\r\n  </tr>\r\n</table>\r\n\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody>\r\n    <tr>\r\n      <td style="padding:0 20px 0 20px;">\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">##OTHER_USER## has made a dispute on your booking#:##ORDERNO## and sent the following dispute message</p>\r\n        \r\n             <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">##MESSAGE##</p>\r\n             \r\n                  <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">You need to reply within ##REPLY_DAYS## to avoid making decision in favor of ##USER_TYPE##.</p>\r\n                  \r\n                       <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">Please click the following link toreply:\r\n##REPLY_LINK##</p>\r\n                       \r\n                            <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><b>Booked property:</b> ##PROPERTY_NAME##</p>\r\n          <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><b>Booking No#: </b>##ORDERNO##</p></td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid #d5d5d5; padding: 15px 30px 25px; margin: 0pt 20px;">\r\n          <h4 style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 20px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#ff0084;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: verdana,Helvetica,Arial,sans-serif; color: #333333; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_LINK##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #ff96cc;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: #fff; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#fff;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="650px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 10px; color: #333333; margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'USERNAME, ORDERNO, PROPERTY_NAME, USER_TYPE, REPLY_DAYS', 1),
(39, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Dispute Conversation Notification', 'Notification mail sent during dispute conversation', '##OTHER_USER## sent the following dispute conversation', '<div style="padding: 10px; width: 650px; margin: auto;">\r\n<div style="width: 610px; margin: 5px 0pt; padding: 15px; background-repeat: no-repeat; border: 3px solid #0063dc; background-color: #eef6ff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255); margin-bottom:5px; border-bottom:3px solid #0063dc;">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;">\r\n    <h1 style="color:#333333; margin: 0pt 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n          <a target="_blank" title="##SITE_NAME##" style="color: #ff0084;" href="##SITE_LINK##">\r\n          <img style="border:none;" src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]" width="186px"/></a>\r\n        </h1></td>\r\n  </tr>\r\n</table>\r\n <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;"> <h2 style="color:#333333; border-bottom:1px solid #dddddd; padding:0 0 5px 0; margin: 0 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n		Hi ,\r\n        </h2></td>\r\n  </tr>\r\n</table>\r\n\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody>\r\n    <tr>\r\n      <td style="padding:0 20px 0 20px;">\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">##OTHER_USER## sent the following dispute conversation:</p>\r\n                \r\n                <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">##MESSAGE##</p>\r\n       \r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid #d5d5d5; padding: 15px 30px 25px; margin: 0pt 20px;">\r\n          <h4 style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 20px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#ff0084;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: verdana,Helvetica,Arial,sans-serif; color: #333333; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_LINK##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #ff96cc;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: #fff; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#fff;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="650px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 10px; color: #333333; margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'USERNAME, ORDERNO, PROPERTY_NAME', 1),
(40, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Discussion Threshold for Admin Decision', 'Admin will take decision, after no of conversation to Traveler and host.', 'Admin will take decision shortly for this dispute.', '<div style="padding: 10px; width: 650px; margin: auto;">\r\n<div style="width: 610px; margin: 5px 0pt; padding: 15px; background-repeat: no-repeat; border: 3px solid #0063dc; background-color: #eef6ff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255); margin-bottom:5px; border-bottom:3px solid #0063dc;">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;">\r\n    <h1 style="color:#333333; margin: 0pt 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n          <a target="_blank" title="##SITE_NAME##" style="color: #ff0084;" href="##SITE_LINK##">\r\n          <img style="border:none;" src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]" width="186px"/></a>\r\n        </h1></td>\r\n  </tr>\r\n</table>\r\n <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;"> <h2 style="color:#333333; border-bottom:1px solid #dddddd; padding:0 0 5px 0; margin: 0 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n		Hi ,\r\n        </h2></td>\r\n  </tr>\r\n</table>\r\n\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody>\r\n    <tr>\r\n      <td style="padding:0 20px 0 20px;">\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">Admin will take decision shortly for this dispute.</p>\r\n       \r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid #d5d5d5; padding: 15px 30px 25px; margin: 0pt 20px;">\r\n          <h4 style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 20px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#ff0084;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: verdana,Helvetica,Arial,sans-serif; color: #333333; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_LINK##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #ff96cc;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: #fff; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#fff;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="650px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 10px; color: #333333; margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'FROM_EMAIL,', 1),
(41, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Dispute Resolved Notification', 'Notification mail to be sent on closing dispute', 'Dispute has been closed in favor of ##FAVOUR_USER##', '<div style="padding: 10px; width: 650px; margin: auto;">\r\n<div style="width: 610px; margin: 5px 0pt; padding: 15px; background-repeat: no-repeat; border: 3px solid #0063dc; background-color: #eef6ff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255); margin-bottom:5px; border-bottom:3px solid #0063dc;">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;">\r\n    <h1 style="color:#333333; margin: 0pt 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n          <a target="_blank" title="##SITE_NAME##" style="color: #ff0084;" href="##SITE_LINK##">\r\n          <img style="border:none;" src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]" width="186px"/></a>\r\n        </h1></td>\r\n  </tr>\r\n</table>\r\n <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;"> <h2 style="color:#333333; border-bottom:1px solid #dddddd; padding:0 0 5px 0; margin: 0 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n		Hi \r\n        ##USERNAME##,\r\n        </h2></td>\r\n  </tr>\r\n</table>\r\n\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody>\r\n    <tr>\r\n      <td style="padding:0 20px 0 20px;">\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">Your booking dispute has been closed in favor of ##FAVOUR_USER##.</p>\r\n        \r\n                <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><strong>Reason for closed:</strong> ##REASON_FOR_CLOSING##</p>\r\n                \r\n            <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><strong>Resolved by:</strong> ##RESOLVED_BY##</p>\r\n                        \r\n            <p style="font-family: verdana,Helvetica,Arial,sans-serif; border-bottom:1px dashed #333; color:#333333; margin:0; padding: 0 0 5px 0; line-height:20px; font-size: 15px; text-align: left; padding: 10px 0px;"><b><big>Dispute Information:</big></b></p>\r\n                                 \r\n            <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><b>Dispute ID#:</b> ##DISPUTE_ID##</p>\r\n                                 \r\n                                    <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><b>Booking ID#:</b> ##ORDER_ID##</p>\r\n                                    \r\n                                    <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><b>Disputer:</b> ##DISPUTER##</p>\r\n                                    \r\n                                    <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">##DISPUTER_USER_TYPE## </p>\r\n                                    \r\n                                    <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><b>Reason for dispute:</b> ##REASON##</p>\r\n       \r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid #d5d5d5; padding: 15px 30px 25px; margin: 0pt 20px;">\r\n          <h4 style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 20px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#ff0084;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: verdana,Helvetica,Arial,sans-serif; color: #333333; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_LINK##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #ff96cc;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: #fff; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#fff;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="650px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 10px; color: #333333; margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'USERNAME, FAVOUR_USER, REASON_FOR_CLOSING, RESOLVED_BY, DISPUTE_ID, ORDER_ID, DISPUTER, DISPUTER_USER_TYPE, REASON', 1),
(43, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Checkin welcome mail', 'Notification for Traveler, when the\r\ncheckin date occurs.', 'Welcome to ##PROPERTY_NAME##', '<div style="padding: 10px; width: 650px; margin: auto;">\r\n<div style="width: 610px; margin: 5px 0pt; padding: 15px; background-repeat: no-repeat; border: 3px solid #0063dc; background-color: #eef6ff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255); margin-bottom:5px; border-bottom:3px solid #0063dc;">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;">\r\n    <h1 style="color:#333333; margin: 0pt 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n          <a target="_blank" title="##SITE_NAME##" style="color: #ff0084;" href="##SITE_LINK##">\r\n          <img style="border:none;" src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]" width="186px"/></a>\r\n        </h1></td>\r\n  </tr>\r\n</table>\r\n <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;"> <h2 style="color:#333333; border-bottom:1px solid #dddddd; padding:0 0 5px 0; margin: 0 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n		Dear ##USERNAME##,\r\n        </h2></td>\r\n  </tr>\r\n</table>\r\n\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody>\r\n    <tr>\r\n      <td style="padding:0 20px 0 20px;">\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">It is our pleasure to welcome you to the ##PROPERTY##.<br />\r\nWhether you are traveling for business or pleasure, we know you have a variety of hotels to choose from,and we are honored that you have selected our ##PROPERTY##. \r\nOur professional and friendly staff is committed to ensuring that your stay is both enjoyable and comfortable.</p>\r\n       \r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid #d5d5d5; padding: 15px 30px 25px; margin: 0pt 20px;">\r\n          <h4 style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 20px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#ff0084;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: verdana,Helvetica,Arial,sans-serif; color: #333333; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_LINK##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #ff96cc;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: #fff; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#fff;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="650px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 10px; color: #333333; margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'USERNAME', 1),
(44, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Checkin host notification mail', 'Notification mail for host, when Traveler checks in.', 'Your guest has arrived.', '<div style="padding: 10px; width: 650px; margin: auto;">\r\n<div style="width: 610px; margin: 5px 0pt; padding: 15px; background-repeat: no-repeat; border: 3px solid #0063dc; background-color: #eef6ff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255); margin-bottom:5px; border-bottom:3px solid #0063dc;">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;">\r\n    <h1 style="color:#333333; margin: 0pt 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n          <a target="_blank" title="##SITE_NAME##" style="color: #ff0084;" href="##SITE_LINK##">\r\n          <img style="border:none;" src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]" width="186px"/></a>\r\n        </h1></td>\r\n  </tr>\r\n</table>\r\n <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;"> <h2 style="color:#333333; border-bottom:1px solid #dddddd; padding:0 0 5px 0; margin: 0 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n		Dear \r\n        ##USERNAME##,\r\n        </h2></td>\r\n  </tr>\r\n</table>\r\n\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody>\r\n    <tr>\r\n      <td style="padding:0 20px 0 20px;">\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">You''re guest ##TRAVELER## has arrived.</p>\r\n       \r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid #d5d5d5; padding: 15px 30px 25px; margin: 0pt 20px;">\r\n          <h4 style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 20px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#ff0084;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: verdana,Helvetica,Arial,sans-serif; color: #333333; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_LINK##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #ff96cc;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: #fff; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#fff;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="650px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 10px; color: #333333; margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'USERNAME', 1),
(45, '2010-12-14 17:50:54', '2010-12-27 13:28:01', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'New Property Activated', 'Your new property has been approved and activated now', 'New Property Activated - ##PROPERTY_NAME##', '<div style="padding: 10px; width: 720px; margin: auto;">\r\n<table width="720px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; text-align: center; font-size: 10px; color:#333333; margin: 3px;">\r\n        Be sure to add\r\n        <a href="mailto:##FROM_EMAIL##" style="color:#ff0084;" title="Add ##FROM_EMAIL## to your whitelist" target="_blank">##FROM_EMAIL##</a>\r\n        to your address book or safe sender list so our emails get to your inbox.      </p>\r\n    </td>\r\n  </tr>\r\n</tbody></table>\r\n<div style="width: 670px; margin: 5px 0pt; padding: 15px; background-repeat: no-repeat; border: 3px solid #0063dc; background-color: #eef6ff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255); margin-bottom:5px; border-bottom:3px solid #0063dc;">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;">\r\n    <h1 style="color:#333333; margin: 0pt 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n          <a target="_blank" title="##SITE_NAME##" style="color: #ff0084;" href="##SITE_LINK##">\r\n          <img style="border:none;" src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]" width="186px"/></a>\r\n        </h1></td>\r\n  </tr>\r\n</table>\r\n <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;"> <h2 style="color:#333333; border-bottom:1px solid #dddddd; padding:0 0 5px 0; margin: 0 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n		Hi \r\n        ,\r\n        </h2></td>\r\n  </tr>\r\n</table>\r\n\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody>\r\n    <tr>\r\n      <td style="padding:0 20px 0 20px;">\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">Your new property has been activated. </p>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><strong>Property Name:</strong> ##PROPERTY_NAME## </p>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><strong>URL:</strong> ##PROPERTY_URL##</p></td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid #d5d5d5; padding: 15px 30px 25px; margin: 0pt 20px;">\r\n          <h4 style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 20px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#ff0084;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: verdana,Helvetica,Arial,sans-serif; color: #333333; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_LINK##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #ff96cc;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: #fff; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#fff;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="720px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 10px; color: #333333; margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'PROPERTY_NAME,USERNAME,PROPERTY_URL,SITE_NAME,SITE_LINK', 1),
(46, '2009-03-02 00:00:00', '2011-04-13 11:24:41', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Two Way New Friend', 'we will send this mail, when a user get new friend request', '##USERNAME## added you as a friend on ##SITE_NAME##', '<div style="padding: 10px; width: 720px; margin: auto;">\r\n<table width="720px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; text-align: center; font-size: 10px; color:#333333; margin: 3px;">\r\n        Be sure to add\r\n        <a href="mailto:##FROM_EMAIL##" style="color:#ff0084;" title="Add ##FROM_EMAIL## to your whitelist" target="_blank">##FROM_EMAIL##</a>\r\n        to your address book or safe sender list so our emails get to your inbox.      </p>\r\n    </td>\r\n  </tr>\r\n</tbody></table>\r\n<div style="width: 670px; margin: 5px 0pt; padding: 15px; background-repeat: no-repeat; border: 3px solid #0063dc; background-color: #eef6ff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255); margin-bottom:5px; border-bottom:3px solid #0063dc;">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;">\r\n    <h1 style="color:#333333; margin: 0pt 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n          <a target="_blank" title="##SITE_NAME##" style="color: #ff0084;" href="##SITE_LINK##">\r\n          <img style="border:none;" src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]" width="186px"/></a>\r\n        </h1></td>\r\n  </tr>\r\n</table>\r\n <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;"> <h2 style="color:#333333; border-bottom:1px solid #dddddd; padding:0 0 5px 0; margin: 0 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n		Hi \r\n        ,\r\n        </h2></td>\r\n  </tr>\r\n</table>\r\n\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody>\r\n    <tr>\r\n      <td style="padding:0 20px 0 20px;">\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">##USERNAME## added you as a friend on ##SITE_NAME##.</p>\r\n        \r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">To view ##USERNAME## profile, follow this link.\r\n##PROFILE_LINK##</p>\r\n       \r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid #d5d5d5; padding: 15px 30px 25px; margin: 0pt 20px;">\r\n          <h4 style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 20px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#ff0084;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: verdana,Helvetica,Arial,sans-serif; color: #333333; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_LINK##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #ff96cc;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: #fff; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#fff;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="720px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 10px; color: #333333; margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'USERNAME,SITE_NAME,PROFILE_LINK', 1),
(47, '2009-03-02 00:00:00', '2011-04-13 11:24:34', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'One Way New Friend', 'we will send this mail, when a user get new friend request', '##USERNAME## added you as a friend on ##SITE_NAME##', '<div style="padding: 10px; width: 720px; margin: auto;">\r\n<table width="720px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; text-align: center; font-size: 10px; color:#333333; margin: 3px;">\r\n        Be sure to add\r\n        <a href="mailto:##FROM_EMAIL##" style="color:#ff0084;" title="Add ##FROM_EMAIL## to your whitelist" target="_blank">##FROM_EMAIL##</a>\r\n        to your address book or safe sender list so our emails get to your inbox.      </p>\r\n    </td>\r\n  </tr>\r\n</tbody></table>\r\n<div style="width: 670px; margin: 5px 0pt; padding: 15px; background-repeat: no-repeat; border: 3px solid #0063dc; background-color: #eef6ff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255); margin-bottom:5px; border-bottom:3px solid #0063dc;">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;">\r\n    <h1 style="color:#333333; margin: 0pt 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n          <a target="_blank" title="##SITE_NAME##" style="color: #ff0084;" href="##SITE_LINK##">\r\n          <img style="border:none;" src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]" width="186px"/></a>\r\n        </h1></td>\r\n  </tr>\r\n</table>\r\n <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;"> <h2 style="color:#333333; border-bottom:1px solid #dddddd; padding:0 0 5px 0; margin: 0 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n		Hi \r\n        ,\r\n        </h2></td>\r\n  </tr>\r\n</table>\r\n\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody>\r\n    <tr>\r\n      <td style="padding:0 20px 0 20px;">\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">##USERNAME## requested you as a friend on ##SITE_NAME##.</p>\r\n        \r\n           <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">To view ##USERNAME## profile, follow this link.\r\n##PROFILE_LINK##</p>\r\n           \r\n              <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">To accept this request, follow this link\r\n##FRIEND_LINK##</p>\r\n       \r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid #d5d5d5; padding: 15px 30px 25px; margin: 0pt 20px;">\r\n          <h4 style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 20px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#ff0084;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: verdana,Helvetica,Arial,sans-serif; color: #333333; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_LINK##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #ff96cc;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: #fff; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#fff;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="720px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 10px; color: #333333; margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'USERNAME,SITE_NAME,PROFILE_LINK,FRIEND_LINK', 1),
(48, '0000-00-00 00:00:00', '2011-06-03 13:28:06', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Auto refund notification', 'Internal message will be sent to the Traveler mentioning the security deposit was refunded, when the booked property checkout without any due within the auto refund limit.', 'Your security deposit has refunded', '<div style="padding: 10px; width: 650px; margin: auto;">\r\n<div style="width: 610px; margin: 5px 0pt; padding: 15px; background-repeat: no-repeat; border: 3px solid #0063dc; background-color: #eef6ff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255); margin-bottom:5px; border-bottom:3px solid #0063dc;">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;">\r\n    <h1 style="color:#333333; margin: 0pt 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n          <a target="_blank" title="##SITE_NAME##" style="color: #ff0084;" href="##SITE_LINK##">\r\n          <img style="border:none;" src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]" width="186px"/></a>\r\n        </h1></td>\r\n  </tr>\r\n</table>\r\n <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;"> <h2 style="color:#333333; border-bottom:1px solid #dddddd; padding:0 0 5px 0; margin: 0 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n		Dear \r\n        ##USERNAME##,\r\n        </h2></td>\r\n  </tr>\r\n</table>\r\n\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody>\r\n    <tr>\r\n      <td style="padding:0 20px 0 20px;">\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">Property ##PROPERTY_NAME## security deposit amount ##AMOUNT## has been refunded.</p>\r\n        \r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><b>Booked property:</b> ##PROPERTY_NAME##</p>\r\n        \r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;"><b>Booking no:</b> ###ORDERNO##</p>\r\n       \r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid #d5d5d5; padding: 15px 30px 25px; margin: 0pt 20px;">\r\n          <h4 style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 20px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#ff0084;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: verdana,Helvetica,Arial,sans-serif; color: #333333; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_LINK##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #ff96cc;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: #fff; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#fff;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="650px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 10px; color: #333333; margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'USERNAME, PROPERTY_NAME, ORDERNO, AMOUNT', 1);
INSERT INTO `email_templates` (`id`, `created`, `modified`, `from`, `reply_to`, `name`, `description`, `subject`, `email_content`, `email_variables`, `is_html`) VALUES
(49, '2010-12-14 17:50:54', '2010-12-27 13:28:01', '##FROM_EMAIL##', '##REPLY_TO_EMAIL##', 'Membership Fee', 'Pay Membership Fee', '[##SITE_NAME##] - Pay Membership Fee', '<div style="padding: 10px; width: 720px; margin: auto;">\r\n<table width="720px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; text-align: center; font-size: 10px; color:#333333; margin: 3px;">\r\n        Be sure to add\r\n        <a href="mailto:##FROM_EMAIL##" style="color:#ff0084;" title="Add ##FROM_EMAIL## to your whitelist" target="_blank">##FROM_EMAIL##</a>\r\n        to your address book or safe sender list so our emails get to your inbox.      </p>\r\n    </td>\r\n  </tr>\r\n</tbody></table>\r\n<div style="width: 670px; margin: 5px 0pt; padding: 15px; background-repeat: no-repeat; border: 3px solid #0063dc; background-color: #eef6ff;">\r\n  <table width="100%" style="background-color: rgb(255, 255, 255); margin-bottom:5px; border-bottom:3px solid #0063dc;">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;">\r\n    <h1 style="color:#333333; margin: 0pt 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n          <a target="_blank" title="##SITE_NAME##" style="color: #ff0084;" href="##SITE_LINK##">\r\n          <img style="border:none;" src="##SITE_LOGO##" alt="[Image: ##SITE_NAME##]" width="186px"/></a>\r\n        </h1></td>\r\n  </tr>\r\n</table>\r\n <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n  <tr>\r\n    <td style="padding: 20px 20px 5px;"> <h2 style="color:#333333; margin: 0pt 0 5px; font-family: verdana,Helvetica,Arial,sans-serif; font-size: 15px;">\r\n          Dear\r\n          ##USERNAME##,\r\n        </h2></td>\r\n  </tr>\r\n</table>\r\n\r\n  <table width="100%" style="background-color: rgb(255, 255, 255);">\r\n    <tbody>\r\n    <tr>\r\n      <td style="padding:0 20px 0 20px;">\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color:#333333; margin: 0pt 0; line-height:20px; font-size: 14px; text-align: left; padding: 10px 0px;">You have successfully registered with our site ##SITE_NAME##. Please pay your membership fee for activate your account.</p>\r\n        <a href="##MEMBERSHIP_URL##" style="color:#ff0084; font-size:14px;" title="##MEMBERSHIP_URL##" target="_blank">##MEMBERSHIP_URL##.</a>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; border-top: 1px solid #d5d5d5; color:#333333; margin: 15px 0 0 0; line-height:20px; font-size: 12px; text-align: left; padding: 10px 0px;">Note: If you paid membership fee then please ignore this email. Thanks for signup with us.</p>\r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td>\r\n        <div style="border-top: 1px solid #d5d5d5; padding: 15px 30px 25px; margin: 0pt 20px;">\r\n          <h4 style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 20px; font-weight: 700; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color:#ff0084;">\r\n            Thanks,          </h4>\r\n          <h5 style="font-family: verdana,Helvetica,Arial,sans-serif; color: #333333; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;">\r\n            ##SITE_NAME## -\r\n            <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_LINK##</a>          </h5>\r\n        </div>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n  <table width="100%" style="margin-top: 2px; background-color: #ff96cc;">\r\n    <tbody><tr>\r\n      <td>\r\n        <p style="font-family: verdana,Helvetica,Arial,sans-serif; color: #fff; font-weight: 700; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;">\r\n          Need help? Have feedback? Feel free to\r\n          <a href="##CONTACT_URL##" title="Contact ##SITE_NAME##" target="_blank" style="color:#fff;">Contact Us</a>        </p>\r\n      </td>\r\n    </tr>\r\n  </tbody></table>\r\n</div>\r\n<table width="720px" cellspacing="0" cellpadding="0">\r\n  <tbody><tr>\r\n    <td align="center">\r\n      <p style="font-family: verdana,Helvetica,Arial,sans-serif; font-size: 10px; color: #333333; margin: 3px; padding-top: 10px;">\r\n        Delivered by\r\n        <a href="##SITE_LINK##" style="color:#ff0084;" title="##SITE_NAME##" target="_blank">##SITE_NAME##</a></p>\r\n    </td>\r\n  </tr>\r\n</tbody>\r\n</table>\r\n  </div>', 'USERNAME,MEMBERSHIP_URL,SITE_NAME,SITE_LINK', 1);

-- --------------------------------------------------------

--
-- Table structure for table `genders`
--

DROP TABLE IF EXISTS `genders`;
CREATE TABLE IF NOT EXISTS `genders` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `name` varchar(100) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Gender details';

--
-- Dumping data for table `genders`
--

INSERT INTO `genders` (`id`, `created`, `modified`, `name`) VALUES
(1, '2009-02-12 09:41:37', '2009-02-12 09:41:37', 'Male'),
(2, '2009-02-12 09:41:37', '2009-02-12 09:41:37', 'Female');

-- --------------------------------------------------------

--
-- Table structure for table `habits`
--

DROP TABLE IF EXISTS `habits`;
CREATE TABLE IF NOT EXISTS `habits` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `name` varchar(100) collate utf8_unicode_ci default NULL,
  `is_active` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='habits details';

--
-- Dumping data for table `habits`
--

INSERT INTO `habits` (`id`, `created`, `modified`, `name`, `is_active`) VALUES
(1, '2011-04-01 12:53:27', '2011-04-01 12:53:27', 'Swiming', 1),
(2, '2011-04-01 12:53:49', '2011-04-01 12:53:49', 'Painting', 1),
(3, '2011-04-01 12:54:11', '2011-04-01 12:54:11', 'Music', 1),
(4, '2011-04-01 12:54:39', '2011-04-01 12:54:39', 'Driving', 1),
(5, '2011-04-01 12:55:15', '2011-04-01 12:55:15', 'Cricket', 1),
(6, '2011-04-01 12:55:39', '2011-04-01 12:55:39', 'Story writing', 1),
(7, '2011-04-01 12:55:55', '2011-04-01 12:55:55', 'Singing', 1),
(8, '2011-04-01 12:56:15', '2011-04-01 12:56:15', 'Games', 1),
(9, '2011-04-01 12:56:43', '2011-04-01 12:56:43', 'Gardening', 1);

-- --------------------------------------------------------

--
-- Table structure for table `habits_user_profiles`
--

DROP TABLE IF EXISTS `habits_user_profiles`;
CREATE TABLE IF NOT EXISTS `habits_user_profiles` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `habit_id` int(5) NOT NULL,
  `user_profile_id` int(5) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `habit_id` (`habit_id`),
  KEY `user_profile_id` (`user_profile_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `habits_user_profiles`
--


-- --------------------------------------------------------

--
-- Table structure for table `holiday_types`
--

DROP TABLE IF EXISTS `holiday_types`;
CREATE TABLE IF NOT EXISTS `holiday_types` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `name` varchar(255) collate utf8_unicode_ci default NULL,
  `slug` varchar(265) collate utf8_unicode_ci default NULL,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `slug` (`slug`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Holiday type of rooms details';

--
-- Dumping data for table `holiday_types`
--

INSERT INTO `holiday_types` (`id`, `created`, `modified`, `name`, `slug`, `is_active`) VALUES
(1, '2011-03-25 08:36:25', '2011-03-25 08:36:25', 'Adventure', 'adventure', 1),
(2, '2011-03-25 08:36:45', '2011-03-25 08:36:45', 'Beach', 'beach', 1),
(3, '2011-03-25 08:38:46', '2011-03-25 08:38:46', 'Party', 'party', 1),
(4, '2011-03-25 10:02:47', '2011-03-25 10:02:47', 'Luxury', 'luxury', 1),
(5, '2011-03-25 10:02:56', '2011-03-25 10:02:56', 'Foodie', 'foodie', 1),
(6, '2011-03-25 10:03:03', '2011-03-25 10:03:03', 'Romantic', 'romantic', 1),
(7, '2011-03-25 10:03:13', '2011-03-25 10:03:13', 'Retreat', 'retreat', 1),
(8, '2011-03-25 10:03:22', '2011-03-25 10:03:22', 'Cultural', 'cultural', 1);

-- --------------------------------------------------------

--
-- Table structure for table `holiday_type_properties`
--

DROP TABLE IF EXISTS `holiday_type_properties`;
CREATE TABLE IF NOT EXISTS `holiday_type_properties` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `holiday_type_id` int(5) NOT NULL,
  `property_id` int(5) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `holiday_type_id` (`holiday_type_id`),
  KEY `property_id` (`property_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `holiday_type_properties`
--


-- --------------------------------------------------------

--
-- Table structure for table `holiday_type_requests`
--

DROP TABLE IF EXISTS `holiday_type_requests`;
CREATE TABLE IF NOT EXISTS `holiday_type_requests` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `holiday_type_id` int(5) NOT NULL,
  `request_id` int(5) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `holiday_type_id` (`holiday_type_id`),
  KEY `request_id` (`request_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `holiday_type_requests`
--


-- --------------------------------------------------------

--
-- Table structure for table `ips`
--

DROP TABLE IF EXISTS `ips`;
CREATE TABLE IF NOT EXISTS `ips` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `ip` varchar(255) collate utf8_unicode_ci default NULL,
  `host` varchar(255) collate utf8_unicode_ci NOT NULL,
  `city_id` bigint(20) NOT NULL,
  `state_id` bigint(20) NOT NULL,
  `country_id` bigint(20) NOT NULL,
  `timezone_id` bigint(20) NOT NULL,
  `latitude` float(10,6) NOT NULL,
  `longitude` float(10,6) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `city_id` (`city_id`),
  KEY `state_id` (`state_id`),
  KEY `country_id` (`country_id`),
  KEY `timezone_id` (`timezone_id`),
  KEY `timezone_id_2` (`timezone_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='Ips Details';

--
-- Dumping data for table `ips`
--


-- --------------------------------------------------------

--
-- Table structure for table `labels`
--

DROP TABLE IF EXISTS `labels`;
CREATE TABLE IF NOT EXISTS `labels` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `name` varchar(255) collate utf8_unicode_ci default NULL,
  `slug` varchar(265) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`),
  KEY `slug` (`slug`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Messages labels name';

--
-- Dumping data for table `labels`
--


-- --------------------------------------------------------

--
-- Table structure for table `labels_messages`
--

DROP TABLE IF EXISTS `labels_messages`;
CREATE TABLE IF NOT EXISTS `labels_messages` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `label_id` bigint(20) default NULL,
  `message_id` bigint(20) default NULL,
  PRIMARY KEY  (`id`),
  KEY `label_id` (`label_id`),
  KEY `message_id` (`message_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Map table for labels and messages';

--
-- Dumping data for table `labels_messages`
--


-- --------------------------------------------------------

--
-- Table structure for table `labels_users`
--

DROP TABLE IF EXISTS `labels_users`;
CREATE TABLE IF NOT EXISTS `labels_users` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `label_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `label_id` (`label_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Map table for labels and users';

--
-- Dumping data for table `labels_users`
--


-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
CREATE TABLE IF NOT EXISTS `languages` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci default NULL,
  `iso2` varchar(5) collate utf8_unicode_ci default NULL,
  `iso3` varchar(5) collate utf8_unicode_ci default NULL,
  `is_active` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Language List ';

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `created`, `modified`, `name`, `iso2`, `iso3`, `is_active`) VALUES
(1, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Abkhazian', 'ab', 'abk', 1),
(2, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Afar', 'aa', 'aar', 1),
(3, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Afrikaans', 'af', 'afr', 1),
(4, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Akan', 'ak', 'aka', 1),
(5, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Albanian', 'sq', 'sqi', 1),
(6, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Amharic', 'am', 'amh', 1),
(7, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Arabic', 'ar', 'ara', 1),
(8, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Aragonese', 'an', 'arg', 1),
(9, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Armenian', 'hy', 'hye', 1),
(10, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Assamese', 'as', 'asm', 1),
(11, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Avaric', 'av', 'ava', 1),
(12, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Avestan', 'ae', 'ave', 1),
(13, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Aymara', 'ay', 'aym', 1),
(14, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Azerbaijani', 'az', 'aze', 1),
(15, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Bambara', 'bm', 'bam', 1),
(16, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Bashkir', 'ba', 'bak', 1),
(17, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Basque', 'eu', 'eus', 1),
(18, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Belarusian', 'be', 'bel', 1),
(19, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Bengali', 'bn', 'ben', 1),
(20, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Bihari', 'bh', 'bih', 1),
(21, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Bislama', 'bi', 'bis', 1),
(22, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Bosnian', 'bs', 'bos', 1),
(23, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Breton', 'br', 'bre', 1),
(24, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Bulgarian', 'bg', 'bul', 1),
(25, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Burmese', 'my', 'mya', 1),
(26, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Catalan', 'ca', 'cat', 1),
(27, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Chamorro', 'ch', 'cha', 1),
(28, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Chechen', 'ce', 'che', 1),
(29, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Chichewa', 'ny', 'nya', 1),
(30, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Chinese', 'zh', 'zho', 1),
(31, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Church Slavic', 'cu', 'chu', 1),
(32, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Chuvash', 'cv', 'chv', 1),
(33, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Cornish', 'kw', 'cor', 1),
(34, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Corsican', 'co', 'cos', 1),
(35, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Cree', 'cr', 'cre', 1),
(36, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Croatian', 'hr', 'hrv', 1),
(37, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Czech', 'cs', 'ces', 1),
(38, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Danish', 'da', 'dan', 1),
(39, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Divehi', 'dv', 'div', 1),
(40, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Dutch', 'nl', 'nld', 1),
(41, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Dzongkha', 'dz', 'dzo', 1),
(42, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'English', 'en', 'eng', 1),
(43, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Esperanto', 'eo', 'epo', 1),
(44, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Estonian', 'et', 'est', 1),
(45, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Ewe', 'ee', 'ewe', 1),
(46, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Faroese', 'fo', 'fao', 1),
(47, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Fijian', 'fj', 'fij', 1),
(48, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Finnish', 'fi', 'fin', 1),
(49, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'French', 'fr', 'fra', 1),
(50, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Fulah', 'ff', 'ful', 1),
(51, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Galician', 'gl', 'glg', 1),
(52, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Ganda', 'lg', 'lug', 1),
(53, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Georgian', 'ka', 'kat', 1),
(54, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'German', 'de', 'deu', 1),
(55, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Greek', 'el', 'ell', 1),
(56, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Guaraní', 'gn', 'grn', 1),
(57, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Gujarati', 'gu', 'guj', 1),
(58, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Haitian', 'ht', 'hat', 1),
(59, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Hausa', 'ha', 'hau', 1),
(60, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Hebrew', 'he', 'heb', 1),
(61, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Herero', 'hz', 'her', 1),
(62, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Hindi', 'hi', 'hin', 1),
(63, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Hiri Motu', 'ho', 'hmo', 1),
(64, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Hungarian', 'hu', 'hun', 1),
(65, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Icelandic', 'is', 'isl', 1),
(66, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Ido', 'io', 'ido', 1),
(67, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Igbo', 'ig', 'ibo', 1),
(68, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Indonesian', 'id', 'ind', 1),
(69, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Interlingua (International Auxiliary Language Association)', 'ia', 'ina', 1),
(70, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Interlingue', 'ie', 'ile', 1),
(71, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Inuktitut', 'iu', 'iku', 1),
(72, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Inupiaq', 'ik', 'ipk', 1),
(73, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Irish', 'ga', 'gle', 1),
(74, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Italian', 'it', 'ita', 1),
(75, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Japanese', 'ja', 'jpn', 1),
(76, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Javanese', 'jv', 'jav', 1),
(77, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Kalaallisut', 'kl', 'kal', 1),
(78, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Kannada', 'kn', 'kan', 1),
(79, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Kanuri', 'kr', 'kau', 1),
(80, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Kashmiri', 'ks', 'kas', 1),
(81, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Kazakh', 'kk', 'kaz', 1),
(82, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Khmer', 'km', 'khm', 1),
(83, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Kikuyu', 'ki', 'kik', 1),
(84, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Kinyarwanda', 'rw', 'kin', 1),
(85, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Kirghiz', 'ky', 'kir', 1),
(86, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Kirundi', 'rn', 'run', 1),
(87, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Komi', 'kv', 'kom', 1),
(88, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Kongo', 'kg', 'kon', 1),
(89, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Korean', 'ko', 'kor', 1),
(90, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Kurdish', 'ku', 'kur', 1),
(91, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Kwanyama', 'kj', 'kua', 1),
(92, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Lao', 'lo', 'lao', 1),
(93, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Latin', 'la', 'lat', 1),
(94, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Latvian', 'lv', 'lav', 1),
(95, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Limburgish', 'li', 'lim', 1),
(96, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Lingala', 'ln', 'lin', 1),
(97, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Lithuanian', 'lt', 'lit', 1),
(98, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Luba-Katanga', 'lu', 'lub', 1),
(99, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Luxembourgish', 'lb', 'ltz', 1),
(100, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Macedonian', 'mk', 'mkd', 1),
(101, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Malagasy', 'mg', 'mlg', 1),
(102, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Malay', 'ms', 'msa', 1),
(103, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Malayalam', 'ml', 'mal', 1),
(104, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Maltese', 'mt', 'mlt', 1),
(105, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Manx', 'gv', 'glv', 1),
(106, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Māori', 'mi', 'mri', 1),
(107, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Marathi', 'mr', 'mar', 1),
(108, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Marshallese', 'mh', 'mah', 1),
(109, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Mongolian', 'mn', 'mon', 1),
(110, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Nauru', 'na', 'nau', 1),
(111, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Navajo', 'nv', 'nav', 1),
(112, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Ndonga', 'ng', 'ndo', 1),
(113, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Nepali', 'ne', 'nep', 1),
(114, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'North Ndebele', 'nd', 'nde', 1),
(115, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Northern Sami', 'se', 'sme', 1),
(116, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Norwegian', 'no', 'nor', 1),
(117, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Norwegian Bokmål', 'nb', 'nob', 1),
(118, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Norwegian Nynorsk', 'nn', 'nno', 1),
(119, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Occitan', 'oc', 'oci', 1),
(120, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Ojibwa', 'oj', 'oji', 1),
(121, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Oriya', 'or', 'ori', 1),
(122, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Oromo', 'om', 'orm', 1),
(123, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Ossetian', 'os', 'oss', 1),
(124, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Pāli', 'pi', 'pli', 1),
(125, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Panjabi', 'pa', 'pan', 1),
(126, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Pashto', 'ps', 'pus', 1),
(127, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Persian', 'fa', 'fas', 1),
(128, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Polish', 'pl', 'pol', 1),
(129, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Portuguese', 'pt', 'por', 1),
(130, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Quechua', 'qu', 'que', 1),
(131, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Raeto-Romance', 'rm', 'roh', 1),
(132, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Romanian', 'ro', 'ron', 1),
(133, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Russian', 'ru', 'rus', 1),
(134, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Samoan', 'sm', 'smo', 1),
(135, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Sango', 'sg', 'sag', 1),
(136, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Sanskrit', 'sa', 'san', 1),
(137, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Sardinian', 'sc', 'srd', 1),
(138, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Scottish Gaelic', 'gd', 'gla', 1),
(139, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Serbian', 'sr', 'srp', 1),
(140, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Shona', 'sn', 'sna', 1),
(141, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Sichuan Yi', 'ii', 'iii', 1),
(142, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Sindhi', 'sd', 'snd', 1),
(143, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Sinhala', 'si', 'sin', 1),
(144, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Slovak', 'sk', 'slk', 1),
(145, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Slovenian', 'sl', 'slv', 1),
(146, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Somali', 'so', 'som', 1),
(147, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'South Ndebele', 'nr', 'nbl', 1),
(148, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Southern Sotho', 'st', 'sot', 1),
(149, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Spanish', 'es', 'spa', 1),
(150, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Sundanese', 'su', 'sun', 1),
(151, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Swahili', 'sw', 'swa', 1),
(152, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Swati', 'ss', 'ssw', 1),
(153, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Swedish', 'sv', 'swe', 1),
(154, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Tagalog', 'tl', 'tgl', 1),
(155, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Tahitian', 'ty', 'tah', 1),
(156, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Tajik', 'tg', 'tgk', 1),
(157, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Tamil', 'ta', 'tam', 1),
(158, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Tatar', 'tt', 'tat', 1),
(159, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Telugu', 'te', 'tel', 1),
(160, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Thai', 'th', 'tha', 1),
(161, '2009-07-01 13:52:24', '2009-07-01 13:52:24', 'Tibetan', 'bo', 'bod', 1),
(162, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Tigrinya', 'ti', 'tir', 1),
(163, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Tonga', 'to', 'ton', 1),
(164, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Traditional Chinese', 'zh-TW', 'zh-TW', 1),
(165, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Tsonga', 'ts', 'tso', 1),
(166, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Tswana', 'tn', 'tsn', 1),
(167, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Turkish', 'tr', 'tur', 1),
(168, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Turkmen', 'tk', 'tuk', 1),
(169, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Twi', 'tw', 'twi', 1),
(170, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Uighur', 'ug', 'uig', 1),
(171, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Ukrainian', 'uk', 'ukr', 1),
(172, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Urdu', 'ur', 'urd', 1),
(173, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Uzbek', 'uz', 'uzb', 1),
(174, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Venda', 've', 'ven', 1),
(175, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Vietnamese', 'vi', 'vie', 1),
(176, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Volapük', 'vo', 'vol', 1),
(177, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Walloon', 'wa', 'wln', 1),
(178, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Welsh', 'cy', 'cym', 1),
(179, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Western Frisian', 'fy', 'fry', 1),
(180, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Wolof', 'wo', 'wol', 1),
(181, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Xhosa', 'xh', 'xho', 1),
(182, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Yiddish', 'yi', 'yid', 1),
(183, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Yoruba', 'yo', 'yor', 1),
(184, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Zhuang', 'za', 'zha', 1),
(185, '2009-07-01 13:52:25', '2009-07-01 13:52:25', 'Zulu', 'zu', 'zul', 1);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `user_id` bigint(20) default NULL,
  `other_user_id` bigint(20) default NULL,
  `parent_message_id` bigint(20) default NULL,
  `message_content_id` bigint(20) NOT NULL,
  `message_folder_id` bigint(20) NOT NULL,
  `property_id` bigint(20) NOT NULL,
  `property_user_id` bigint(20) NOT NULL,
  `is_sender` tinyint(1) NOT NULL,
  `is_starred` tinyint(1) default NULL,
  `is_read` tinyint(1) default '0',
  `is_deleted` tinyint(1) default '0',
  `is_archived` tinyint(1) NOT NULL default '0',
  `is_review` tinyint(1) NOT NULL,
  `is_communication` tinyint(1) NOT NULL,
  `hash` text collate utf8_unicode_ci,
  `size` bigint(20) NOT NULL,
  `property_user_status_id` bigint(20) NOT NULL,
  `property_user_dispute_id` bigint(20) default '0',
  `request_id` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `other_user_id` (`other_user_id`),
  KEY `parent_message_id` (`parent_message_id`),
  KEY `message_content_id` (`message_content_id`),
  KEY `message_folder_id` (`message_folder_id`),
  KEY `property_id` (`property_id`),
  KEY `property_user_id` (`property_user_id`),
  KEY `property_user_status_id` (`property_user_status_id`),
  KEY `request_id` (`request_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='User messages';

--
-- Dumping data for table `messages`
--


-- --------------------------------------------------------

--
-- Table structure for table `message_contents`
--

DROP TABLE IF EXISTS `message_contents`;
CREATE TABLE IF NOT EXISTS `message_contents` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `subject` text collate utf8_unicode_ci,
  `message` text collate utf8_unicode_ci,
  `admin_suspend` tinyint(1) NOT NULL default '0',
  `is_system_flagged` tinyint(1) NOT NULL default '0',
  `detected_suspicious_words` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `message_contents`
--


-- --------------------------------------------------------

--
-- Table structure for table `message_filters`
--

DROP TABLE IF EXISTS `message_filters`;
CREATE TABLE IF NOT EXISTS `message_filters` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `user_id` bigint(20) default NULL,
  `from_user_id` bigint(20) default '0',
  `to_user_id` bigint(20) default NULL,
  `subject` varchar(255) collate utf8_unicode_ci default NULL,
  `has_words` varchar(255) collate utf8_unicode_ci default NULL,
  `does_not_has_words` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `to_user_id` (`to_user_id`),
  KEY `subject` (`subject`),
  KEY `from_user_id` (`from_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Message Filter Details';

--
-- Dumping data for table `message_filters`
--


-- --------------------------------------------------------

--
-- Table structure for table `message_folders`
--

DROP TABLE IF EXISTS `message_folders`;
CREATE TABLE IF NOT EXISTS `message_folders` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `name` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Messages folder';

--
-- Dumping data for table `message_folders`
--


-- --------------------------------------------------------

--
-- Table structure for table `money_transfer_accounts`
--

DROP TABLE IF EXISTS `money_transfer_accounts`;
CREATE TABLE IF NOT EXISTS `money_transfer_accounts` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `payment_gateway_id` int(11) NOT NULL,
  `account` varchar(100) collate utf8_unicode_ci NOT NULL,
  `is_default` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`,`payment_gateway_id`),
  KEY `is_default` (`is_default`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `money_transfer_accounts`
--


-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `parent_id` bigint(20) unsigned default NULL,
  `title` varchar(255) collate utf8_unicode_ci default NULL,
  `content` text collate utf8_unicode_ci,
  `template` varchar(255) collate utf8_unicode_ci default NULL,
  `draft` tinyint(1) NOT NULL default '0',
  `lft` bigint(20) default NULL,
  `rght` bigint(20) default NULL,
  `level` int(3) NOT NULL default '0',
  `meta_keywords` varchar(255) collate utf8_unicode_ci default NULL,
  `meta_description` text collate utf8_unicode_ci NOT NULL,
  `url` text collate utf8_unicode_ci,
  `slug` varchar(255) collate utf8_unicode_ci default NULL,
  `is_default` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `title` (`title`),
  KEY `parent_id` (`parent_id`),
  KEY `slug` (`slug`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Page Details';

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `created`, `modified`, `parent_id`, `title`, `content`, `template`, `draft`, `lft`, `rght`, `level`, `meta_keywords`, `meta_description`, `url`, `slug`, `is_default`) VALUES
(1, '2009-07-11 11:16:29', '2009-07-21 15:52:58', NULL, 'home', '<p>Coming soon</p>', 'home.ctp', 0, NULL, NULL, 0, NULL, '', NULL, 'home', 1),
(2, '2009-07-11 11:16:54', '2009-07-21 15:53:27', NULL, 'about', '<p>Coming soon</p>', 'about.ctp', 0, NULL, NULL, 0, NULL, '', NULL, 'about', 0),
(3, '2009-07-11 11:17:27', '2009-07-21 15:54:02', NULL, 'Contact Us', '<p>contact us page comming soon</p>', '', 0, NULL, NULL, 0, NULL, '', NULL, 'contact-us', 0),
(6, '2009-07-17 07:55:38', '2009-07-21 15:54:33', NULL, 'FAQ', '<p>Coming soon</p>', '', 0, NULL, NULL, 0, NULL, '', NULL, 'faq', 0),
(7, '2009-07-21 15:56:45', '2009-07-21 15:56:45', NULL, 'Term and conditions', 'Lorem Ipsum is a dummy text that is mainly used by the printing and design industry. It is intended to show how the type will look before the end product is available.\r\n\r\nLorem Ipsum has been the industry''s standard dummy text ever since the 1500:s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.\r\n\r\nLorem Ipsum dummy texts was available for many years on adhesive sheets in different sizes and typefaces from a company called Letraset.\r\n\r\nWhen computers came along, Aldus included lorem ipsum in its PageMaker publishing software, and you now see it wherever designers, content designers, art directors, user interface developers and web designer are at work.\r\n\r\nThey use it daily when using programs such as Adobe Photoshop, Paint Shop Pro, Dreamweaver, FrontPage, PageMaker, FrameMaker, Illustrator, Flash, Indesign etc.', '', 0, NULL, NULL, 0, NULL, '', NULL, 'term-and-conditions', 0),
(8, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 'Booking complete', '<div class="static-block">\r\n<h2>Thank you for your booking!</h2>\r\n<p>\r\nDuis adipiscing elit eu tortor feugiat elementum in at diam. Nulla tincidunt accumsan libero eu mattis. Proin nisl est, consectetur eget semper eu, aliquet vel urna. Vivamus at dolor sollicitudin nulla commodo venenatis quis sed mauris. Mauris et elit eu orci blandit pharetra. Donec laoreet cursus eleifend. Integer aliquet est vel turpis pulvinar pulvinar. Quisque at augue nunc, in sagittis lectus. Pellentesque tincidunt vestibulum sem, eget pulvinar ipsum interdum eu. Donec fringilla pellentesque nunc pretium malesuada. Nunc cursus, risus a vulputate dignissim, est ipsum egestas nisl, eu dignissim urna nunc mollis nibh.\r\n</p>\r\n<p>\r\nMaecenas dapibus commodo nibh, sed congue magna pharetra ut. Nullam sed lorem non mi ullamcorper porttitor. Nullam volutpat arcu quis libero molestie sagittis. Integer sagittis, neque porttitor consequat volutpat, erat ipsum blandit metus, sit amet malesuada velit risus et velit. Quisque vel urna non lectus euismod venenatis non a libero. Morbi sollicitudin lacus in lacus commodo mollis.\r\n</p>\r\n', NULL, 0, NULL, NULL, 0, NULL, '', NULL, 'order-purchase-completed', 0),
(9, '2011-02-24 13:14:17', '2011-02-24 13:17:07', NULL, 'Affiliate', '<p>In posuere molestie augue, eget tincidunt libero pellentesque nec.   Aliquam erat volutpat. Aliquam a ligula nulla, at suscipit odio. Nullam   in nibh nibh, eu bibendum ligula. Morbi eu nibh dui. Vivamus  scelerisque  fermentum lacus et tristique. Sed vulputate euismod metus  porta  feugiat. Nulla varius venenatis mauris, nec ornare nisl bibendum  id. Aenean id orci nisl, in scelerisque nibh. Sed quam sapien,  tempus quis  vestibulum eu, sagittis varius sapien. Aliquam erat  volutpat. Nulla  facilisi. In egestas faucibus nunc, et venenatis purus  aliquet quis.  Nulla eget arcu turpis. Nunc pellentesque eros quis neque  sodales  hendrerit. Donec eget nibh sit amet ipsum elementum vehicula.   Pellentesque molestie diam vitae erat suscipit consequat. Pellentesque   vel arcu sit amet metus mattis congue vitae eu quam.</p>\r\n<p>&nbsp;</p>\r\n<p>Nam dapibus vestibulum est, id blandit erat scelerisque id. Morbi   vestibulum dignissim sapien, vitae laoreet est vehicula et. Ut pulvinar   quam vel est cursus mollis. Nullam imperdiet faucibus odio, sed   imperdiet quam elementum id. Fusce varius, odio in porta rutrum,  urna  dolor porttitor sem, tempus lacinia mi tortor et libero.  Suspendisse et  ultricies urna. Nam luctus felis non turpis pretium  aliquam. Mauris non  felis sit amet nibh malesuada luctus ut sit amet  risus. Praesent ante  tellus, aliquet eget feugiat nec, viverra in elit.  Nulla dictum eros et  risus consequat mollis.</p>\r\n<p>&nbsp;</p>\r\n<p>Duis id lectus  eros. Class aptent taciti sociosqu ad litora torquent per  conubia  nostra, per inceptos himenaeos. Fusce eleifend eros quis ligula  porta  rutrum mattis non risus. Donec eget neque a turpis elementum  egestas  nec a enim. Ut ut quam lorem, eget dapibus dolor. Vestibulum nec  turpis  erat, eget luctus magna. Phasellus ac tincidunt arcu. Etiam et   augue massa. Donec eget justo enim. Quisque eget orci eu orci malesuada   vestibulum non at magna. Fusce malesuada malesuada faucibus. Nulla   ultrices nibh in tellus pellentesque mollis commodo velit placerat.   Fusce eget velit velit, vitae adipiscing justo.</p>', NULL, 0, NULL, NULL, 0, '', '', NULL, 'affiliates', 0),
(4, '2009-07-21 15:56:45', '2009-07-21 15:56:45', NULL, 'Term and Policies', 'Lorem Ipsum is a dummy text that is mainly used by the printing and design industry. It is intended to show how the type will look before the end product is available.\r\n\r\nLorem Ipsum has been the industry''s standard dummy text ever since the 1500:s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.\r\n\r\nLorem Ipsum dummy texts was available for many years on adhesive sheets in different sizes and typefaces from a company called Letraset.\r\n\r\nWhen computers came along, Aldus included lorem ipsum in its PageMaker publishing software, and you now see it wherever designers, content designers, art directors, user interface developers and web designer are at work.\r\n\r\nThey use it daily when using programs such as Adobe Photoshop, Paint Shop Pro, Dreamweaver, FrontPage, PageMaker, FrameMaker, Illustrator, Flash, Indesign etc.', '', 0, NULL, NULL, 0, NULL, '', NULL, 'term-and-policies', 0),
(10, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 'Privacy Policy', '<p>Coming soon</p>', NULL, 0, NULL, NULL, 0, NULL, '', NULL, 'privacy_policy', 1),
(11, '2011-02-15 06:11:49', '2011-02-15 06:19:28', NULL, 'Acceptable Use Policy', '<div class="aup"><p>You are independently responsible for complying with all applicable  laws in all of your actions related to your use of PayPal&rsquo;s services,  regardless of the purpose of the use. In addition, you must adhere to  the terms of this Acceptable Use Policy.</p>\r\n<p><strong>Prohibited Activities</strong></p>\r\n<p>You may not use the PayPal service for activities that:</p>\r\n<ol>\r\n<li> violate any law, statute, ordinance or regulation </li>\r\n<li> relate to sales of (a) narcotics, steroids, certain  controlled substances or other products that present a risk to consumer  safety, (b) drug paraphernalia, (c) items that encourage, promote,  facilitate or instruct others to engage in illegal activity, (d) items  that promote hate, violence, racial intolerance, or the financial  exploitation of a crime, (e) items that are considered obscene, (f)  items that infringe or violate any copyright, trademark, right of  publicity or privacy or any other proprietary right under the laws of  any jurisdiction, (g) certain sexually oriented materials or services,  (h) ammunition, firearms, or certain firearm parts or accessories, or  (i) certain weapons or knives regulated under applicable law </li>\r\n<li> relate to transactions that (a) show the personal information  of third parties in violation of applicable law, (b) support pyramid or  ponzi schemes, matrix programs, other &ldquo;get rich quick&rdquo; schemes or  certain multi-level marketing programs, (c) are associated with  purchases of real property, annuities or lottery contracts, lay-away  systems, off-shore banking or transactions to finance or refinance debts  funded by a credit card, (d) are for the sale of certain items before  the seller has control or possession of the item, (e) are by payment  processors to collect payments on behalf of merchants, (f) are  associated with the following Money Service Business Activities: the  sale of traveler&rsquo;s cheques or money orders, currency exchanges or cheque  cashing, or (g) provide certain credit repair or debt settlement  services </li>\r\n<li> involve the sales of products or services identified by government agencies to have a high likelihood of being fraudulent </li>\r\n<li>violate applicable laws or industry regulations regarding the  sale of (a) tobacco products, or (b) prescription drugs and devices</li>\r\n<li> involve gambling, gaming and/or any other activity with an  entry fee and a prize, including, but not limited to casino games,  sports betting, horse or greyhound racing, lottery tickets, other  ventures that facilitate gambling, games of skill (whether or not it is  legally defined as a lottery) and sweepstakes unless the operator has  obtained prior approval from PayPal and the operator and customers are  located exclusively in jurisdictions where such activities are permitted  by law. </li>\r\n</ol></div>', NULL, 0, NULL, NULL, 0, '', '', NULL, 'aup', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pagseguro_transaction_logs`
--

DROP TABLE IF EXISTS `pagseguro_transaction_logs`;
CREATE TABLE IF NOT EXISTS `pagseguro_transaction_logs` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `email` varchar(255) collate utf8_unicode_ci NOT NULL,
  `address` varchar(255) collate utf8_unicode_ci NOT NULL,
  `number` bigint(20) default '0',
  `quarter` varchar(255) collate utf8_unicode_ci NOT NULL,
  `city` varchar(255) collate utf8_unicode_ci NOT NULL,
  `state` varchar(50) collate utf8_unicode_ci NOT NULL,
  `zip` varchar(255) collate utf8_unicode_ci NOT NULL,
  `phone` varchar(20) collate utf8_unicode_ci NOT NULL,
  `property_id` bigint(20) NOT NULL,
  `property_user_id` bigint(20) default NULL,
  `user_id` bigint(20) default NULL,
  `transaction_id` varbinary(100) default NULL,
  `transaction_date` datetime NOT NULL,
  `amount` double NOT NULL,
  `transaction_fee` double(10,3) NOT NULL default '0.000',
  `currency` varchar(25) collate utf8_unicode_ci NOT NULL,
  `remark` varchar(255) collate utf8_unicode_ci NOT NULL,
  `quantity` bigint(20) default NULL,
  `payment_gateway_id` bigint(20) NOT NULL,
  `payment_type` varchar(255) collate utf8_unicode_ci NOT NULL,
  `payment_status` varchar(255) collate utf8_unicode_ci NOT NULL,
  `buyer_email` varchar(255) collate utf8_unicode_ci default NULL,
  `ip` varchar(255) collate utf8_unicode_ci NOT NULL,
  `serialized_post_array` longtext collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `property_user_id` (`property_user_id`),
  KEY `property_id` (`property_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `pagseguro_transaction_logs`
--


-- --------------------------------------------------------

--
-- Table structure for table `payment_gateways`
--

DROP TABLE IF EXISTS `payment_gateways`;
CREATE TABLE IF NOT EXISTS `payment_gateways` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `name` varchar(255) collate utf8_unicode_ci default NULL,
  `display_name` varchar(255) collate utf8_unicode_ci default NULL,
  `description` text collate utf8_unicode_ci,
  `gateway_fees` double(10,2) default NULL,
  `transaction_count` bigint(20) unsigned default '0',
  `payment_gateway_setting_count` bigint(20) unsigned default '0',
  `is_mass_pay_enabled` tinyint(1) NOT NULL,
  `is_test_mode` tinyint(1) NOT NULL default '0',
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `payment_gateways`
--

INSERT INTO `payment_gateways` (`id`, `created`, `modified`, `name`, `display_name`, `description`, `gateway_fees`, `transaction_count`, `payment_gateway_setting_count`, `is_mass_pay_enabled`, `is_test_mode`, `is_active`) VALUES
(1, '2010-05-10 10:43:02', '2010-07-22 13:56:49', 'PayPal', 'PayPal', 'PayPal is an electronic money service which allows you to make payment to anyone online. ', 0.00, NULL, 1, 1, 1, 1),
(2, '2010-05-10 10:43:02', '2010-05-10 10:43:02', 'Wallet', 'Wallet', 'Wallet option', NULL, 0, 0, 0, 1, 1),
(3, '2010-09-24 09:26:59', '2010-09-24 09:26:59', 'AuthorizeNet', 'Credit Card', 'Book via credit card using Authorize.net CIM', NULL, 0, 0, 0, 1, 1),
(4, '2010-10-25 15:09:48', '2011-06-30 09:05:26', 'PagSeguro', 'PagSeguro', 'We use PagSeguro because it is secure, secure and secure (and easy). ', NULL, 0, 0, 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `payment_gateway_settings`
--

DROP TABLE IF EXISTS `payment_gateway_settings`;
CREATE TABLE IF NOT EXISTS `payment_gateway_settings` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `payment_gateway_id` bigint(20) unsigned NOT NULL,
  `key` varchar(256) collate utf8_unicode_ci default NULL,
  `type` varchar(8) collate utf8_unicode_ci default NULL,
  `options` text collate utf8_unicode_ci,
  `test_mode_value` text collate utf8_unicode_ci,
  `live_mode_value` text collate utf8_unicode_ci,
  `description` text collate utf8_unicode_ci,
  PRIMARY KEY  (`id`),
  KEY `payment_gateway_id` (`payment_gateway_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `payment_gateway_settings`
--

INSERT INTO `payment_gateway_settings` (`id`, `created`, `modified`, `payment_gateway_id`, `key`, `type`, `options`, `test_mode_value`, `live_mode_value`, `description`) VALUES
(1, '2010-05-10 11:01:23', '2010-05-14 13:05:28', 1, 'payee_account', 'text', '', 'fivult_1286256894_biz@gmail.com', '', 'PayPal merchant account email'),
(6, '2010-07-15 12:21:33', '2010-07-15 12:21:33', 1, 'adaptive_API_AppID', 'text', '', 'APP-80W284485P519543T', '', ''),
(7, '2010-07-15 12:20:23', '2010-07-15 12:20:23', 1, 'adaptive_API_Signature', 'text', '', 'ANgb92k0vEv.ipPykPk1BD8jS5GtAdHsMnvLNeBMEAZDtFHmfCMV4fMA', '', ''),
(8, '2010-07-15 12:21:33', '2010-07-15 12:21:33', 1, 'adaptive_API_Password', 'text', '', 'CENY57NXUHHXD2PB', '', ''),
(9, '2010-07-15 12:21:33', '2010-07-15 12:21:33', 1, 'adaptive_API_UserName', 'text', '', 'fivult_1286256894_biz_api1.gmail.com', '', ''),
(10, '2010-10-18 18:52:07', '2010-10-18 18:52:09', 1, 'MRB_ID', 'text', '', 'M264XXWYC7T7N', '', 'Merchant Referral Bonus ID'),
(11, '2010-07-16 16:29:35', '2010-07-16 16:29:38', 1, 'receiver_emails', 'text', '', 'group._1275387295_biz@agriya.in', '', 'Comma separated for setting multiple receiver emails.'),
(12, '2010-07-15 12:15:27', '2010-07-15 12:15:27', 1, 'masspay_API_UserName', 'text', '', 'group._1275387295_biz_api1.agriya.in', '', ''),
(13, '2010-07-15 12:15:27', '2010-07-15 12:15:27', 1, 'masspay_API_Password', 'text', '', '1275387304', '', ''),
(14, '2010-07-15 12:20:23', '2010-07-15 12:20:23', 1, 'masspay_API_Signature', 'text', '', 'A2D-o.ABr1BhSY94P3USn3LNzZHIA.j34dhfDHi77OE5YiM93TixlOZK', '', ''),
(15, '2010-07-15 12:21:33', '2010-07-15 12:21:33', 1, 'is_enable_for_property_listing_fee', 'checkbox', '', '1', '1', 'Enable/Disable the current payment option for listing fee.'),
(16, '2010-07-15 12:21:33', '2010-07-15 12:21:33', 2, 'is_enable_for_property_listing_fee', 'checkbox', '', '1', '1', 'Enable/Disable the current payment option for listing fee.'),
(17, '2010-07-15 12:21:33', '2010-07-15 12:21:33', 3, 'is_enable_for_property_listing_fee', 'checkbox', '', '1', '1', 'Enable/Disable the current payment option for listing fee.'),
(18, '2010-07-15 12:21:33', '2010-07-15 12:21:33', 4, 'is_enable_for_property_listing_fee', 'checkbox', '', '1', '', 'Enable/Disable the current payment option for listing fee.'),
(19, '2010-07-15 12:21:33', '2010-07-15 12:21:33', 1, 'is_enable_for_property_verified_fee', 'checkbox', '', '1', '1', 'Enable/Disable the current payment option for verification fee.'),
(20, '2010-07-15 12:21:33', '2010-07-15 12:21:33', 2, 'is_enable_for_property_verified_fee', 'checkbox', '', '1', '1', 'Enable/Disable the current payment option for verification fee.'),
(21, '2010-07-15 12:21:33', '2010-07-15 12:21:33', 3, 'is_enable_for_property_verified_fee', 'checkbox', '', '1', '1', 'Enable/Disable the current payment option for verification fee.'),
(22, '2010-07-15 12:21:33', '2010-07-15 12:21:33', 4, 'is_enable_for_property_verified_fee', 'checkbox', '', '1', '', 'Enable/Disable the current payment option for verification fee.'),
(23, '2010-07-15 12:21:33', '2010-07-15 12:21:33', 1, 'is_enable_for_add_to_wallet', 'checkbox', '', '1', '1', 'Enable/Disable the current payment option for wallet add.'),
(24, '2010-07-15 12:21:33', '2010-07-15 12:21:33', 3, 'is_enable_for_add_to_wallet', 'checkbox', '', '1', '1', 'Enable/Disable the current payment option for wallet add.'),
(25, '2010-07-15 12:21:33', '2010-07-15 12:21:33', 4, 'is_enable_for_add_to_wallet', 'checkbox', '', '1', '', 'Enable/Disable the current payment option for wallet add'),
(26, '2010-07-15 12:21:33', '2010-07-15 12:21:33', 1, 'is_enable_for_book_a_property', 'checkbox', '', '1', '1', 'Enable/Disable the current payment option for book property.'),
(27, '2010-07-15 12:21:33', '2010-07-15 12:21:33', 2, 'is_enable_for_book_a_property', 'checkbox', '', '1', '1', 'Enable/Disable the current payment option for book property.'),
(28, '2010-07-15 12:21:33', '2010-07-15 12:21:33', 3, 'is_enable_for_book_a_property', 'checkbox', '', '1', '1', 'Enable/Disable the current payment option for book property.'),
(29, '2010-07-15 12:21:33', '2010-07-15 12:21:33', 4, 'is_enable_for_book_a_property', 'checkbox', '', '1', '', 'Enable/Disable the current payment option for book property'),
(30, '2010-07-15 12:21:33', '2010-07-15 12:21:33', 3, 'authorize_net_api_key', 'text', '', '3TtvK87KY', '', ''),
(31, '2010-07-15 12:21:33', '2010-07-15 12:21:33', 3, 'authorize_net_trans_key', 'text', '', '4a56xhH3h7x9RQ94', '', ''),
(32, '2010-10-25 15:14:13', '2010-10-25 15:14:15', 4, 'pagseguro_payee_account', 'text', '', 'subin.george@agriya.in', '', 'PagSeguro merchant account email'),
(33, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 4, 'pagseguro_token', 'text', '', '', '', ''),
(34, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'is_enable_for_signup_fee', 'checkbox', NULL, '1', NULL, 'Enable/disable the current payment options for membership fee'),
(35, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 3, 'is_enable_for_signup_fee', 'checkbox', NULL, '1', NULL, 'Enable/disable the current payment options for membership fee'),
(36, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 4, 'is_enable_for_signup_fee', 'checkbox', NULL, '1', NULL, 'Enable/disable the current payment options for membership fee');

-- --------------------------------------------------------

--
-- Table structure for table `paypal_accounts`
--

DROP TABLE IF EXISTS `paypal_accounts`;
CREATE TABLE IF NOT EXISTS `paypal_accounts` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `user_id` bigint(20) default NULL,
  `payment_types` varchar(8) collate utf8_unicode_ci default NULL,
  `first_name` varchar(255) collate utf8_unicode_ci default NULL,
  `last_name` varchar(255) collate utf8_unicode_ci default NULL,
  `dob` date default NULL,
  `address1` varchar(255) collate utf8_unicode_ci default NULL,
  `address2` varchar(255) collate utf8_unicode_ci default NULL,
  `city` varchar(255) collate utf8_unicode_ci default NULL,
  `state` varchar(255) collate utf8_unicode_ci default NULL,
  `paypal_country_id` bigint(20) default NULL,
  `zip` varchar(255) collate utf8_unicode_ci default NULL,
  `paypal_citizenship_country_id` bigint(20) default NULL,
  `currency_code` varchar(20) collate utf8_unicode_ci default NULL,
  `phone` int(20) default NULL,
  `email` varchar(255) collate utf8_unicode_ci default NULL,
  `create_account_key` varchar(100) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `paypal_country_id` (`paypal_country_id`),
  KEY `paypal_citizenship_country_id` (`paypal_citizenship_country_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `paypal_accounts`
--


-- --------------------------------------------------------

--
-- Table structure for table `paypal_citizenship_countries`
--

DROP TABLE IF EXISTS `paypal_citizenship_countries`;
CREATE TABLE IF NOT EXISTS `paypal_citizenship_countries` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `code` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `code` (`code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `paypal_citizenship_countries`
--

INSERT INTO `paypal_citizenship_countries` (`id`, `name`, `code`) VALUES
(1, 'AFGHANISTAN', 'AF'),
(2, 'ÃƒÆ’Ã¢â‚¬Â¦LAND ISLANDS', 'AX'),
(3, 'ALBANIA', 'AL'),
(4, 'ALGERIA', 'DZ'),
(5, 'AMERICAN SAMOA', 'AS'),
(6, 'ANDORRA', 'AD'),
(7, 'ANGOLA', 'AO'),
(8, 'ANGUILLA', 'AI'),
(9, 'ANTARCTICA', 'AQ'),
(10, 'ANTIGUA AND BARBUDA', 'AG'),
(11, 'ARGENTINA', 'AR'),
(12, 'ARMENIA', 'AM'),
(13, 'ARUBA', 'AW'),
(14, 'AUSTRALIA', 'AU'),
(15, 'AUSTRIA', 'AT'),
(16, 'AZERBAIJAN', 'AZ'),
(17, 'BAHAMAS', 'BS'),
(18, 'BAHRAIN', 'BH'),
(19, 'BANGLADESH', 'BD'),
(20, 'BARBADOS', 'BB'),
(21, 'BELARUS', 'BY'),
(22, 'BELGIUM', 'BE'),
(23, 'BELIZE', 'BZ'),
(24, 'BENIN', 'BJ'),
(25, 'BERMUDA', 'BM'),
(26, 'BHUTAN', 'BT'),
(27, 'BOLIVIA', 'BO'),
(28, 'BOSNIA AND HERZEGOVINA', 'BA'),
(29, 'BOTSWANA', 'BW'),
(30, 'BOUVET ISLAND', 'BV'),
(31, 'BRAZIL', 'BR'),
(32, 'BRITISH INDIAN OCEAN TERRITORY', 'IO'),
(33, 'BRUNEI DARUSSALAM', 'BN'),
(34, 'BULGARIA', 'BG'),
(35, 'BURKINA FASO', 'BF'),
(36, 'BURUNDI', 'BI'),
(37, 'CAMBODIA', 'KH'),
(38, 'CAMEROON', 'CM'),
(39, 'CANADA', 'CA'),
(40, 'CAPE VERDE', 'CV'),
(41, 'CAYMAN ISLANDS', 'KY'),
(42, 'CENTRAL AFRICAN REPUBLIC', 'CF'),
(43, 'CHAD', 'TD'),
(44, 'CHILE', 'CL'),
(45, 'CHINA', 'CN'),
(46, 'CHRISTMAS ISLAND', 'CX'),
(47, 'COCOS (KEELING) ISLANDS', 'CC'),
(48, 'COLOMBIA', 'CO'),
(49, 'COMOROS', 'KM'),
(50, 'CONGO', 'CG'),
(51, 'CONGO,THE DEMOCRATIC REPUBLIC OF', 'CD'),
(52, 'COOK ISLANDS', 'CK'),
(53, 'COSTA RICA', 'CR'),
(54, 'COTE D''IVOIRE', 'CI'),
(55, 'CROATIA', 'HR'),
(56, 'CUBA', 'CU'),
(57, 'CYPRUS', 'CY'),
(58, 'CZECH REPUBLIC', 'CZ'),
(59, 'DENMARK', 'DK'),
(60, 'DJIBOUTI', 'DJ'),
(61, 'DOMINICA', 'DM'),
(62, 'DOMINICAN REPUBLIC', 'DO'),
(63, 'ECUADOR', 'EC'),
(64, 'EGYPT', 'EG'),
(65, 'EL SALVADOR', 'SV'),
(66, 'EQUATORIAL GUINEA', 'GQ'),
(67, 'ERITREA', 'ER'),
(68, 'ESTONIA', 'EE'),
(69, 'ETHIOPIA', 'ET'),
(70, 'FALKLAND ISLANDS (MALVINAS)', 'FK'),
(71, 'FAROE ISLANDS', 'FO'),
(72, 'FIJI', 'FJ'),
(73, 'FINLAND', 'FI'),
(74, 'FRANCE', 'FR'),
(75, 'FRENCH GUIANA', 'GF'),
(76, 'FRENCH POLYNESIA', 'PF'),
(77, 'FRENCH SOUTHERN TERRITORIES', 'TF'),
(78, 'GABON', 'GA'),
(79, 'GAMBIA', 'GM'),
(80, 'GEORGIA', 'GE'),
(81, 'GERMANY', 'DE'),
(82, 'GHANA', 'GH'),
(83, 'GIBRALTAR', 'GI'),
(84, 'GREECE', 'GR'),
(85, 'GREENLAND', 'GL'),
(86, 'GRENADA', 'GD'),
(87, 'GUADELOUPE', 'GP'),
(88, 'GUAM', 'GU'),
(89, 'GUATEMALA', 'GT'),
(90, 'GUERNSEY', 'GG'),
(91, 'GUINEA', 'GN'),
(92, 'GUINEA-BISSAU', 'GW'),
(93, 'GUYANA', 'GY'),
(94, 'HAITI', 'HT'),
(95, 'HEARD ISLAND AND MCDONALD ISLANDS', 'HM'),
(96, 'HOLY SEE (VATICAN CITY STATE)', 'VA'),
(97, 'HONDURAS', 'HN'),
(98, 'HONG KONG', 'HK'),
(99, 'HUNGARY', 'HU'),
(100, 'ICELAND', 'IS'),
(101, 'INDIA', 'IN'),
(102, 'INDONESIA', 'ID'),
(103, 'IRAN,ISLAMIC REPUBLIC OF', 'IR'),
(104, 'IRAQ', 'IQ'),
(105, 'IRELAND', 'IE'),
(106, 'ISLE OF MAN', 'IM'),
(107, 'ISRAEL', 'IL'),
(108, 'ITALY', 'IT'),
(109, 'JAMAICA', 'JM'),
(110, 'JAPAN', 'JP'),
(111, 'JERSEY', 'JE'),
(112, 'JORDAN', 'JO'),
(113, 'KAZAKHSTAN', 'KZ'),
(114, 'KENYA', 'KE'),
(115, 'KIRIBATI', 'KI'),
(116, 'KOREA,DEMOCRATIC PEOPLE''S REPUBLIC OF', 'KP'),
(117, 'KOREA,REPUBLIC OF', 'KR'),
(118, 'KUWAIT', 'KW'),
(119, 'KYRGYZSTAN', 'KG'),
(120, 'LAO PEOPLE''S DEMOCRATIC REPUBLIC', 'LA'),
(121, 'LATVIA', 'LV'),
(122, 'LEBANON', 'LB'),
(123, 'LESOTHO', 'LS'),
(124, 'LIBERIA', 'LR'),
(125, 'LIBYAN ARAB JAMAHIRIYA', 'LY'),
(126, 'LIECHTENSTEIN', 'LI'),
(127, 'LITHUANIA', 'LT'),
(128, 'LUXEMBOURG', 'LU'),
(129, 'MACAO', 'MO'),
(130, 'MACEDONIA,THE FORMER YUGOSLAV REPUBLIC OF', 'MK'),
(131, 'MADAGASCAR', 'MG'),
(132, 'MALAWI', 'MW'),
(133, 'MALAYSIA', 'MY'),
(134, 'MALDIVES', 'MV'),
(135, 'MALI', 'ML'),
(136, 'MALTA', 'MT'),
(137, 'MARSHALL ISLANDS', 'MH'),
(138, 'MARTINIQUE', 'MQ'),
(139, 'MAURITANIA', 'MR'),
(140, 'MAURITIUS', 'MU'),
(141, 'MAYOTTE', 'YT'),
(142, 'MEXICO', 'MX'),
(143, 'MICRONESIA,FEDERATED STATES OF', 'FM'),
(144, 'MOLDOVA,REPUBLIC OF', 'MD'),
(145, 'MONACO', 'MC'),
(146, 'MONGOLIA', 'MN'),
(147, 'MONTSERRAT', 'MS'),
(148, 'MOROCCO', 'MA'),
(149, 'MOZAMBIQUE', 'MZ'),
(150, 'MYANMAR', 'MM'),
(151, 'NAMIBIA', 'NA'),
(152, 'NAURU', 'NR'),
(153, 'NEPAL', 'NP'),
(154, 'NETHERLANDS', 'NL'),
(155, 'NETHERLANDS ANTILLES', 'AN'),
(156, 'NEW CALEDONIA', 'NC'),
(157, 'NEW ZEALAND', 'NZ'),
(158, 'NICARAGUA', 'NI'),
(159, 'NIGER', 'NE'),
(160, 'NIGERIA', 'NG'),
(161, 'NIUE', 'NU'),
(162, 'NORFOLK ISLAND', 'NF'),
(163, 'NORTHERN MARIANA ISLANDS', 'MP'),
(164, 'NORWAY', 'NO'),
(165, 'OMAN', 'OM'),
(166, 'PAKISTAN', 'PK'),
(167, 'PALAU', 'PW'),
(168, 'PALESTINIAN TERRITORY,OCCUPIED', 'PS'),
(169, 'PANAMA', 'PA'),
(170, 'PAPUA NEW GUINEA', 'PG'),
(171, 'PARAGUAY', 'PY'),
(172, 'PERU', 'PE'),
(173, 'PHILIPPINES', 'PH'),
(174, 'PITCAIRN', 'PN'),
(175, 'POLAND', 'PL'),
(176, 'PORTUGAL', 'PT'),
(177, 'PUERTO RICO', 'PR'),
(178, 'QATAR', 'QA'),
(179, 'REUNION', 'RE'),
(180, 'ROMANIA', 'RO'),
(181, 'RUSSIAN FEDERATION', 'RU'),
(182, 'RWANDA', 'RW'),
(183, 'SAINT HELENA', 'SH'),
(184, 'SAINT KITTS AND NEVIS', 'KN'),
(185, 'SAINT LUCIA', 'LC'),
(186, 'SAINT PIERRE AND MIQUELON', 'PM'),
(187, 'SAINT VINCENT AND THE GRENADINES', 'VC'),
(188, 'SAMOA', 'WS'),
(189, 'SAN MARINO', 'SM'),
(190, 'SAO TOME AND PRINCIPE', 'ST'),
(191, 'SAUDI ARABIA', 'SA'),
(192, 'SENEGAL', 'SN'),
(193, 'SERBIA AND MONTENEGRO', 'CS'),
(194, 'SEYCHELLES', 'SC'),
(195, 'SIERRA LEONE', 'SL'),
(196, 'SINGAPORE', 'SG'),
(197, 'SLOVAKIA', 'SK'),
(198, 'SLOVENIA', 'SI'),
(199, 'SOLOMON ISLANDS', 'SB'),
(200, 'SOMALIA', 'SO'),
(201, 'SOUTH AFRICA', 'ZA'),
(202, 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', 'GS'),
(203, 'SPAIN', 'ES'),
(204, 'SRI LANKA', 'LK'),
(205, 'SUDAN', 'SD'),
(206, 'SURINAME', 'SR'),
(207, 'SVALBARD AND JAN MAYEN', 'SJ'),
(208, 'SWAZILAND', 'SZ'),
(209, 'SWEDEN', 'SE'),
(210, 'SWITZERLAND', 'CH'),
(211, 'SYRIAN ARAB REPUBLIC', 'SY'),
(212, 'TAIWAN,PROVINCE OF CHINA', 'TW'),
(213, 'TAJIKISTAN', 'TJ'),
(214, 'TANZANIA,UNITED REPUBLIC OF', 'TZ'),
(215, 'THAILAND', 'TH'),
(216, 'TIMOR-LESTE', 'TL'),
(217, 'TOGO', 'TG'),
(218, 'TOKELAU', 'TK'),
(219, 'TONGA', 'TO'),
(220, 'TRINIDAD AND TOBAGO', 'TT'),
(221, 'TUNISIA', 'TN'),
(222, 'TURKEY', 'TR'),
(223, 'TURKMENISTAN', 'TM'),
(224, 'TURKS AND CAICOS ISLANDS', 'TC'),
(225, 'TUVALU', 'TV'),
(226, 'UGANDA', 'UG'),
(227, 'UKRAINE', 'UA'),
(228, 'UNITED ARAB EMIRATES', 'AE'),
(229, 'UNITED KINGDOM', 'GB'),
(230, 'UNITED STATES', 'US'),
(231, 'UNITED STATES MINOR OUTLYING ISLANDS', 'UM'),
(232, 'URUGUAY', 'UY'),
(233, 'UZBEKISTAN', 'UZ'),
(234, 'VANUATU', 'VU'),
(235, 'VENEZUELA', 'VE'),
(236, 'VIET NAM', 'VN'),
(237, 'VIRGIN ISLANDS, BRITISH', 'VG'),
(238, 'VIRGIN ISLANDS, U.S.', 'VI'),
(239, 'WALLIS AND FUTUNA', 'WF'),
(240, 'WESTERN SAHARA', 'EH'),
(241, 'YEMEN', 'YE'),
(242, 'ZAMBIA', 'ZM'),
(243, 'ZIMBABWE', 'ZW');

-- --------------------------------------------------------

--
-- Table structure for table `paypal_countries`
--

DROP TABLE IF EXISTS `paypal_countries`;
CREATE TABLE IF NOT EXISTS `paypal_countries` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` varchar(255) collate utf8_unicode_ci default NULL,
  `code` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`),
  KEY `code` (`code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `paypal_countries`
--

INSERT INTO `paypal_countries` (`id`, `name`, `code`) VALUES
(1, 'Australia', 'AU'),
(2, 'Canada', 'CA'),
(3, 'Czech Republic', 'CZ'),
(4, 'France', 'FR'),
(5, 'Germany', 'DE'),
(6, 'Greece', 'GR'),
(7, 'Israel', 'IL'),
(8, 'Italy', 'IT'),
(9, 'Japan', 'JP'),
(10, 'Netherlands', 'NL'),
(11, 'Poland', 'PL'),
(12, 'Russian Federation', 'RU'),
(13, 'Spain', 'ES'),
(14, 'United Kingdom', 'GB'),
(15, 'United States', 'US');

-- --------------------------------------------------------

--
-- Table structure for table `paypal_docapture_logs`
--

DROP TABLE IF EXISTS `paypal_docapture_logs`;
CREATE TABLE IF NOT EXISTS `paypal_docapture_logs` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `deal_user_id` bigint(20) default NULL,
  `gift_user_id` bigint(20) NOT NULL,
  `wallet_user_id` bigint(20) NOT NULL,
  `authorizationid` varchar(255) collate utf8_unicode_ci default NULL,
  `currencycode` varchar(10) collate utf8_unicode_ci default NULL,
  `dodirectpayment_correlationid` varchar(255) collate utf8_unicode_ci default NULL,
  `dodirectpayment_ack` varchar(255) collate utf8_unicode_ci default NULL,
  `dodirectpayment_build` varchar(255) collate utf8_unicode_ci default NULL,
  `dodirectpayment_amt` double(10,2) default NULL,
  `dodirectpayment_avscode` varchar(255) collate utf8_unicode_ci default NULL,
  `dodirectpayment_cvv2match` varchar(255) collate utf8_unicode_ci default NULL,
  `dodirectpayment_response` text collate utf8_unicode_ci,
  `version` double(10,2) default NULL,
  `dodirectpayment_timestamp` varchar(255) collate utf8_unicode_ci default NULL,
  `docapture_timestamp` varchar(255) collate utf8_unicode_ci default NULL,
  `docapture_correlationid` varchar(255) collate utf8_unicode_ci default NULL,
  `docapture_ack` varchar(50) collate utf8_unicode_ci default NULL,
  `docapture_build` varchar(255) collate utf8_unicode_ci default NULL,
  `docapture_transactionid` varchar(255) collate utf8_unicode_ci default NULL,
  `docapture_parenttransactionid` varchar(255) collate utf8_unicode_ci default NULL,
  `docapture_receiptid` varchar(255) collate utf8_unicode_ci default NULL,
  `docapture_transactiontype` varchar(255) collate utf8_unicode_ci default NULL,
  `docapture_paymenttype` varchar(255) collate utf8_unicode_ci default NULL,
  `docapture_ordertime` varchar(255) collate utf8_unicode_ci default NULL,
  `docapture_amt` double(10,2) default NULL,
  `docapture_feeamt` double(10,2) default NULL,
  `docapture_taxamt` double(10,2) default NULL,
  `docapture_paymentstatus` varchar(255) collate utf8_unicode_ci default NULL,
  `docapture_pendingreason` varchar(255) collate utf8_unicode_ci default NULL,
  `docapture_reasoncode` varchar(255) collate utf8_unicode_ci default NULL,
  `docapture_protectioneligibility` varchar(255) collate utf8_unicode_ci default NULL,
  `docapture_response` text collate utf8_unicode_ci,
  `dovoid_timestamp` varchar(255) collate utf8_unicode_ci default NULL,
  `dovoid_correlationid` varchar(255) collate utf8_unicode_ci default NULL,
  `dovoid_ack` varchar(50) collate utf8_unicode_ci default NULL,
  `dovoid_build` varchar(50) collate utf8_unicode_ci default NULL,
  `dovoid_response` text collate utf8_unicode_ci,
  PRIMARY KEY  (`id`),
  KEY `deal_user_id` (`deal_user_id`),
  KEY `gift_user_id` (`gift_user_id`),
  KEY `wallet_user_id` (`wallet_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `paypal_docapture_logs`
--


-- --------------------------------------------------------

--
-- Table structure for table `paypal_transaction_logs`
--

DROP TABLE IF EXISTS `paypal_transaction_logs`;
CREATE TABLE IF NOT EXISTS `paypal_transaction_logs` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `date_added` datetime NOT NULL default '0000-00-00 00:00:00',
  `user_id` bigint(20) default '0',
  `transaction_id` bigint(20) default '0',
  `ip` varchar(15) collate utf8_unicode_ci default NULL,
  `host` varchar(50) collate utf8_unicode_ci default NULL,
  `currency_type` varchar(50) collate utf8_unicode_ci default NULL,
  `txn_id` varchar(50) collate utf8_unicode_ci default NULL,
  `payer_email` varchar(150) collate utf8_unicode_ci default NULL,
  `payment_date` varchar(30) collate utf8_unicode_ci default NULL,
  `email` varchar(150) collate utf8_unicode_ci default NULL,
  `to_digicurrency` varchar(50) collate utf8_unicode_ci default NULL,
  `to_account_no` varchar(100) collate utf8_unicode_ci default NULL,
  `to_account_name` varchar(150) collate utf8_unicode_ci default NULL,
  `fees_paid_by` varchar(50) collate utf8_unicode_ci default NULL,
  `mc_gross` double(50,5) default NULL,
  `mc_fee` double(50,5) default NULL,
  `mc_currency` varchar(12) collate utf8_unicode_ci default NULL,
  `payment_status` varchar(20) collate utf8_unicode_ci default NULL,
  `pending_reason` varchar(20) collate utf8_unicode_ci default NULL,
  `receiver_email` varchar(100) collate utf8_unicode_ci default NULL,
  `paypal_response` varchar(20) collate utf8_unicode_ci default NULL,
  `error_no` tinyint(4) default '0',
  `error_message` text collate utf8_unicode_ci,
  `memo` text collate utf8_unicode_ci,
  `paypal_post_vars` text collate utf8_unicode_ci,
  `is_mass_pay` tinyint(1) default '0',
  `mass_pay_status` varchar(20) collate utf8_unicode_ci default NULL,
  `masspay_response` text collate utf8_unicode_ci,
  `user_cash_withdrawal_id` bigint(20) default NULL,
  `affiliate_cash_withdrawal_id` bigint(20) default NULL,
  PRIMARY KEY  (`id`),
  KEY `txn_id` (`txn_id`),
  KEY `user_id` (`user_id`),
  KEY `transaction_id` (`transaction_id`),
  KEY `user_cash_withdrawal_id` (`user_cash_withdrawal_id`),
  KEY `affiliate_cash_withdrawal_id` (`affiliate_cash_withdrawal_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `paypal_transaction_logs`
--


-- --------------------------------------------------------

--
-- Table structure for table `privacies`
--

DROP TABLE IF EXISTS `privacies`;
CREATE TABLE IF NOT EXISTS `privacies` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `name` varchar(255) collate utf8_unicode_ci default NULL,
  `slug` varchar(265) collate utf8_unicode_ci default NULL,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `slug` (`slug`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Privacies details ';

--
-- Dumping data for table `privacies`
--

INSERT INTO `privacies` (`id`, `created`, `modified`, `name`, `slug`, `is_active`) VALUES
(7, '2011-03-25 08:38:41', '2011-03-25 08:38:41', 'Entire room', 'entire-room', 1),
(5, '2011-03-25 08:37:35', '2011-03-25 08:37:35', 'Private room', 'private-room', 1),
(6, '2011-03-25 08:38:00', '2011-03-25 08:38:00', 'Shared room', 'shared-room', 1);

-- --------------------------------------------------------

--
-- Table structure for table `private_addresses`
--

DROP TABLE IF EXISTS `private_addresses`;
CREATE TABLE IF NOT EXISTS `private_addresses` (
  `address_prefix` varchar(11) collate utf8_unicode_ci NOT NULL default '',
  PRIMARY KEY  (`address_prefix`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `private_addresses`
--


-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

DROP TABLE IF EXISTS `properties`;
CREATE TABLE IF NOT EXISTS `properties` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `user_id` bigint(20) NOT NULL,
  `cancellation_policy_id` bigint(20) NOT NULL,
  `property_type_id` bigint(20) NOT NULL,
  `room_type_id` bigint(20) NOT NULL,
  `bed_type_id` bigint(20) NOT NULL,
  `privacy_id` bigint(20) NOT NULL,
  `city_id` bigint(20) NOT NULL,
  `state_id` bigint(20) NOT NULL,
  `country_id` bigint(20) NOT NULL,
  `title` varchar(255) collate utf8_unicode_ci default NULL,
  `slug` varchar(265) collate utf8_unicode_ci default NULL,
  `description` text collate utf8_unicode_ci,
  `street_view` int(10) NOT NULL,
  `accommodates` bigint(20) NOT NULL,
  `address` varchar(300) collate utf8_unicode_ci default NULL,
  `unit` varchar(256) collate utf8_unicode_ci default NULL,
  `phone` varchar(255) collate utf8_unicode_ci default NULL,
  `ip_id` bigint(20) default NULL,
  `commission_amount` double(10,2) NOT NULL,
  `security_deposit` double(10,2) default '0.00',
  `property_flag_count` bigint(20) NOT NULL,
  `price_per_night` double(10,2) NOT NULL default '0.00',
  `price_per_week` double(10,2) default NULL,
  `price_per_month` double(10,2) default NULL,
  `additional_guest` int(10) default '0',
  `additional_guest_price` double(10,2) default '0.00',
  `backup_phone` varchar(255) collate utf8_unicode_ci default NULL,
  `house_rules` text collate utf8_unicode_ci,
  `house_manual` text collate utf8_unicode_ci,
  `size` int(10) default NULL,
  `measurement` varchar(256) collate utf8_unicode_ci default NULL,
  `minimum_nights` int(10) NOT NULL,
  `maximum_nights` int(10) NOT NULL default '0',
  `checkin` time default NULL,
  `checkout` time default NULL,
  `verified_date` datetime default NULL,
  `latitude` float(10,6) default NULL,
  `longitude` float(10,6) default NULL,
  `zoom_level` int(11) NOT NULL,
  `rate` double default NULL,
  `bed_rooms` int(10) NOT NULL,
  `beds` int(10) NOT NULL,
  `bath_rooms` double(10,2) default NULL,
  `property_size` bigint(20) default NULL,
  `actual_rating` bigint(20) NOT NULL,
  `mean_rating` bigint(20) NOT NULL,
  `detected_suspicious_words` varchar(255) collate utf8_unicode_ci default NULL,
  `price_currency` double(10,2) default NULL,
  `custom_price_per_week_count` bigint(20) NOT NULL,
  `custom_price_per_night_count` bigint(20) NOT NULL,
  `custom_price_per_month_count` bigint(20) NOT NULL,
  `property_user_count` bigint(20) NOT NULL,
  `sales_cleared_amount` double(10,2) default NULL,
  `sales_cleared_count` bigint(20) default NULL,
  `sales_pending_count` bigint(20) default NULL,
  `sales_pipeline_amount` double(10,2) default NULL,
  `sales_pipeline_count` bigint(20) default NULL,
  `sales_completed_count` bigint(20) default NULL,
  `sales_rejected_count` bigint(20) default NULL,
  `sales_canceled_count` bigint(20) default NULL,
  `sales_expired_count` bigint(20) default NULL,
  `sales_lost_count` bigint(20) default NULL,
  `sales_lost_amount` double(10,2) default NULL,
  `property_view_count` bigint(20) NOT NULL,
  `request_count` bigint(20) NOT NULL,
  `revenue` double(10,2) NOT NULL default '0.00',
  `property_favorite_count` bigint(20) NOT NULL,
  `positive_feedback_count` bigint(20) NOT NULL,
  `property_feedback_count` bigint(20) NOT NULL,
  `property_user_failure_count` bigint(20) NOT NULL,
  `property_user_success_count` bigint(20) NOT NULL,
  `referred_booking_count` bigint(20) NOT NULL default '0',
  `negotiation_count` bigint(20) NOT NULL default '0',
  `in_collection_count` bigint(20) NOT NULL default '0',
  `admin_suspend` tinyint(1) NOT NULL,
  `is_pets` tinyint(1) NOT NULL,
  `is_negotiable` tinyint(1) NOT NULL,
  `is_system_flagged` tinyint(1) NOT NULL,
  `is_featured` tinyint(1) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `is_approved` tinyint(1) NOT NULL default '0',
  `is_verified` tinyint(4) default NULL,
  `is_show_in_home_page` tinyint(1) NOT NULL default '0',
  `pay_key` varchar(255) collate utf8_unicode_ci default NULL,
  `is_paid` tinyint(1) NOT NULL default '0',
  `video_url` varchar(255) collate utf8_unicode_ci default NULL,
  `location_manual` text collate utf8_unicode_ci,
  `amenities_set` set('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22') collate utf8_unicode_ci default NULL,
  `holiday_types_set` set('1','2','3','4','5','6','7','8') collate utf8_unicode_ci default NULL,
  `is_imported_from_airbnb` tinyint(1) default '0',
  `airbnb_property_id` bigint(20) default '0',
  PRIMARY KEY  (`id`),
  KEY `slug` (`slug`),
  KEY `modified` (`modified`,`property_type_id`,`room_type_id`,`bed_type_id`,`title`),
  KEY `country_id` (`is_pets`,`is_active`),
  KEY `daily_price` (`price_per_night`,`price_per_week`,`price_per_month`),
  KEY `city_id` (`city_id`,`country_id`,`accommodates`),
  KEY `user_id` (`user_id`),
  KEY `cancellation_policy_id` (`cancellation_policy_id`),
  KEY `property_type_id` (`property_type_id`),
  KEY `room_type_id` (`room_type_id`),
  KEY `bed_type_id` (`bed_type_id`),
  KEY `privacy_id` (`privacy_id`),
  KEY `state_id` (`state_id`),
  KEY `country_id_2` (`country_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Properties list';

--
-- Dumping data for table `properties`
--


-- --------------------------------------------------------

--
-- Table structure for table `properties_requests`
--

DROP TABLE IF EXISTS `properties_requests`;
CREATE TABLE IF NOT EXISTS `properties_requests` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `property_id` bigint(20) NOT NULL,
  `request_id` bigint(20) NOT NULL,
  `order_id` bigint(20) default NULL,
  `is_active` tinyint(1) default '1',
  PRIMARY KEY  (`id`),
  KEY `user_id` (`property_id`),
  KEY `property_id` (`request_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `properties_requests`
--


-- --------------------------------------------------------

--
-- Table structure for table `property_favorites`
--

DROP TABLE IF EXISTS `property_favorites`;
CREATE TABLE IF NOT EXISTS `property_favorites` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `property_id` bigint(20) NOT NULL,
  `ip_id` bigint(20) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `property_id` (`property_id`),
  KEY `ip_id` (`ip_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Property Favorites ';

--
-- Dumping data for table `property_favorites`
--


-- --------------------------------------------------------

--
-- Table structure for table `property_feedbacks`
--

DROP TABLE IF EXISTS `property_feedbacks`;
CREATE TABLE IF NOT EXISTS `property_feedbacks` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `property_id` bigint(20) NOT NULL,
  `property_user_id` bigint(20) default NULL,
  `feedback` text collate utf8_unicode_ci,
  `admin_comments` text collate utf8_unicode_ci,
  `ip_id` bigint(20) default NULL,
  `is_satisfied` tinyint(1) NOT NULL default '1',
  `is_auto_review` tinyint(1) default '0',
  `video_url` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`property_user_id`),
  KEY `property_id` (`property_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='Property feedbacks';

--
-- Dumping data for table `property_feedbacks`
--


-- --------------------------------------------------------

--
-- Table structure for table `property_flags`
--

DROP TABLE IF EXISTS `property_flags`;
CREATE TABLE IF NOT EXISTS `property_flags` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `property_id` bigint(20) unsigned NOT NULL,
  `property_flag_category_id` bigint(20) unsigned NOT NULL,
  `message` text collate utf8_unicode_ci,
  `ip_id` bigint(20) default NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `property_flag_category_id` (`property_flag_category_id`),
  KEY `property_id` (`property_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `property_flags`
--


-- --------------------------------------------------------

--
-- Table structure for table `property_flag_categories`
--

DROP TABLE IF EXISTS `property_flag_categories`;
CREATE TABLE IF NOT EXISTS `property_flag_categories` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` date NOT NULL,
  `modified` date NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `name` varchar(250) collate utf8_unicode_ci default NULL,
  `property_flag_count` bigint(20) unsigned NOT NULL,
  `is_active` tinyint(1) unsigned NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `name` (`name`),
  KEY `user_id` (`user_id`),
  KEY `property_flag_count` (`property_flag_count`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `property_flag_categories`
--

INSERT INTO `property_flag_categories` (`id`, `created`, `modified`, `user_id`, `name`, `property_flag_count`, `is_active`) VALUES
(1, '2010-05-14', '2010-05-14', 0, 'Sexual Content', 4, 1),
(2, '2010-05-14', '2010-05-14', 0, 'Violent or Repulsive Content', 0, 1),
(3, '2010-05-14', '2010-05-14', 0, 'Hatful or Abusive Content', 0, 1),
(4, '2010-05-14', '2010-05-14', 0, 'Ham Dangerous Acts', 0, 1),
(5, '2010-05-14', '2010-05-14', 0, 'Spam', 0, 1),
(6, '2010-05-14', '2010-05-14', 0, 'Infrings My Rights', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `property_ratings`
--

DROP TABLE IF EXISTS `property_ratings`;
CREATE TABLE IF NOT EXISTS `property_ratings` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `property_id` bigint(20) NOT NULL,
  `rating` double(5,2) NOT NULL default '0.00',
  `ip_id` bigint(20) default NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `project_id` (`property_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `property_ratings`
--


-- --------------------------------------------------------

--
-- Table structure for table `property_types`
--

DROP TABLE IF EXISTS `property_types`;
CREATE TABLE IF NOT EXISTS `property_types` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `name` varchar(255) collate utf8_unicode_ci default NULL,
  `slug` varchar(265) collate utf8_unicode_ci default NULL,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `slug` (`slug`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Property Types ';

--
-- Dumping data for table `property_types`
--

INSERT INTO `property_types` (`id`, `created`, `modified`, `name`, `slug`, `is_active`) VALUES
(1, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'Apartment', 'apartment', 1),
(2, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'House', 'house', 1),
(3, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'Bed & Breakfast', 'bed-breakfast', 1),
(4, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'Cabin', 'cabin', 1),
(5, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'Villa', 'villa', 1),
(6, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'Castle', 'castle', 1),
(7, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'Dorm', 'dorm', 1),
(8, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'Treehouse', 'treehouse', 1),
(9, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'Boat', 'boat', 1),
(10, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'Automobile', 'automobile', 1),
(11, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'lgloo', 'igloo', 1),
(12, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'Lighthouse', 'lighthouse', 1);

-- --------------------------------------------------------

--
-- Table structure for table `property_users`
--

DROP TABLE IF EXISTS `property_users`;
CREATE TABLE IF NOT EXISTS `property_users` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `property_id` bigint(20) unsigned NOT NULL,
  `property_user_status_id` bigint(20) NOT NULL,
  `user_paypal_connection_id` bigint(20) NOT NULL,
  `owner_user_id` bigint(20) NOT NULL,
  `guests` int(11) unsigned NOT NULL,
  `price` double(10,2) NOT NULL,
  `original_price` double(10,2) NOT NULL,
  `affiliate_commission_amount` double(10,2) NOT NULL,
  `traveler_service_amount` double(10,2) NOT NULL,
  `host_service_amount` double(10,2) NOT NULL,
  `security_deposit` double(10,2) default '0.00',
  `security_deposit_status` tinyint(2) default '0',
  `original_search_address` varchar(300) collate utf8_unicode_ci default NULL,
  `payment_gateway_id` bigint(20) default '1',
  `is_delayed_chained_payment` tinyint(1) NOT NULL default '0',
  `checkin` date NOT NULL,
  `checkout` date NOT NULL,
  `actual_checkin_date` datetime NOT NULL,
  `actual_checkout_date` datetime NOT NULL,
  `referred_by_user_id` bigint(20) NOT NULL default '0',
  `is_auto_checkin` tinyint(1) default '0',
  `auto_checkin_date` datetime default NULL,
  `is_host_checkin` varchar(1) collate utf8_unicode_ci default '0',
  `host_checkin_date` datetime default NULL,
  `is_traveler_checkin` tinyint(1) default '0',
  `traveler_checkin_date` datetime default NULL,
  `is_auto_checkout` tinyint(1) default '0',
  `auto_checkout_date` datetime default NULL,
  `is_host_checkout` varchar(1) collate utf8_unicode_ci default '0',
  `is_host_reviewed` tinyint(1) NOT NULL default '0',
  `host_checkout_date` datetime default NULL,
  `is_traveler_checkout` tinyint(1) default '0',
  `traveler_checkout_date` datetime default NULL,
  `pay_key` varchar(250) collate utf8_unicode_ci default NULL,
  `accepted_date` date NOT NULL,
  `top_code` varchar(255) collate utf8_unicode_ci NOT NULL,
  `bottum_code` varchar(255) collate utf8_unicode_ci NOT NULL,
  `payment_profile_id` bigint(20) default NULL,
  `cim_approval_code` varchar(255) collate utf8_unicode_ci default NULL,
  `cim_transaction_id` varchar(255) collate utf8_unicode_ci default NULL,
  `is_payment_cleared` tinyint(1) default '0',
  `is_negotiation_requested` tinyint(1) NOT NULL,
  `message` text collate utf8_unicode_ci,
  `negotiation_discount` double(10,2) default NULL,
  `negotiate_amount` double(10,2) NOT NULL default '0.00',
  `is_negotiated` tinyint(1) NOT NULL default '0',
  `is_under_dispute` tinyint(1) default '0',
  `message_count` bigint(20) default '0',
  `host_private_note` text collate utf8_unicode_ci NOT NULL,
  `traveler_private_note` text collate utf8_unicode_ci NOT NULL,
  `checkin_via_ticket` tinyint(1) NOT NULL default '0',
  `checkout_via_ticket` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `property_id` (`property_id`),
  KEY `payment_gateway_id` (`payment_gateway_id`),
  KEY `property_user_status_id` (`property_user_status_id`),
  KEY `user_paypal_connection_id` (`user_paypal_connection_id`),
  KEY `owner_user_id` (`owner_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='User Property Info';

--
-- Dumping data for table `property_users`
--


-- --------------------------------------------------------

--
-- Table structure for table `property_user_disputes`
--

DROP TABLE IF EXISTS `property_user_disputes`;
CREATE TABLE IF NOT EXISTS `property_user_disputes` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `user_id` bigint(20) default NULL,
  `property_id` bigint(20) default NULL,
  `property_user_id` bigint(20) default NULL,
  `is_traveler` tinyint(1) default NULL,
  `dispute_type_id` bigint(20) default NULL,
  `reason` text collate utf8_unicode_ci,
  `dispute_status_id` bigint(20) default NULL,
  `resolved_date` datetime default NULL,
  `is_favor_traveler` tinyint(1) default NULL,
  `last_replied_user_id` bigint(20) default NULL,
  `last_replied_date` datetime default NULL,
  `dispute_closed_type_id` bigint(20) default NULL,
  `dispute_converstation_count` bigint(20) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `property_user_disputes`
--


-- --------------------------------------------------------

--
-- Table structure for table `property_user_feedbacks`
--

DROP TABLE IF EXISTS `property_user_feedbacks`;
CREATE TABLE IF NOT EXISTS `property_user_feedbacks` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `host_user_id` bigint(20) NOT NULL,
  `traveler_user_id` bigint(20) NOT NULL,
  `property_user_id` bigint(20) default NULL,
  `property_id` bigint(20) NOT NULL,
  `feedback` text collate utf8_unicode_ci,
  `admin_comments` text collate utf8_unicode_ci,
  `ip_id` bigint(20) default NULL,
  `is_satisfied` tinyint(1) NOT NULL default '1',
  `is_auto_review` tinyint(1) default '0',
  `video_url` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`property_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `property_user_feedbacks`
--


-- --------------------------------------------------------

--
-- Table structure for table `property_user_statuses`
--

DROP TABLE IF EXISTS `property_user_statuses`;
CREATE TABLE IF NOT EXISTS `property_user_statuses` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci default NULL,
  `property_user_count` bigint(20) NOT NULL,
  `slug` varchar(265) collate utf8_unicode_ci default NULL,
  `description` text collate utf8_unicode_ci,
  PRIMARY KEY  (`id`),
  KEY `slug` (`slug`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `property_user_statuses`
--

INSERT INTO `property_user_statuses` (`id`, `created`, `modified`, `name`, `property_user_count`, `slug`, `description`) VALUES
(1, '2011-04-28 18:06:17', '2011-04-28 18:06:19', 'Waiting For Acceptance', 0, 'waiting-for-acceptance', 'Your payment for this booking was successfully collected by ##SITE_NAME##. Host will be paid after ##TRAVELER## checkin. Booking was made by the ##TRAVELER## on ##CREATED_DATE##. Waiting for Host ##HOSTER## to accept the order.'),
(2, '2011-04-28 18:06:17', '2011-04-28 18:06:19', 'Confirmed', 0, 'confirmed', 'Booking was accepted by ##HOSTER## on ##ACCEPTED_DATE##.'),
(3, '2011-04-28 18:06:17', '2011-04-28 18:06:19', 'Rejected', 0, 'rejected', 'Booking was rejected by the ##HOSTER##. Booking amount has been refunded.'),
(4, '2011-04-28 18:06:17', '2011-04-28 18:06:19', 'Canceled', 0, 'canceled', 'Booking was canceled by ##TRAVELER##. Booking amount has been refunded based on cancellation policies.'),
(5, '2011-04-28 18:06:17', '2011-04-28 18:06:19', 'Arrived', 0, 'arrived', '##TRAVELER## has arrived.'),
(6, '2011-04-28 18:06:17', '2011-04-28 18:06:19', 'Waiting for Review', 0, 'waiting-for-review', '##TRAVELER## has checked out.'),
(7, '2011-04-28 18:06:17', '2011-04-28 18:06:19', 'Payment Cleared', 0, 'payment-cleared', '##HOSTER## amount has been released'),
(8, '2011-04-28 18:06:17', '2011-04-28 18:06:19', 'Past', 0, 'completed', 'Order completed.'),
(9, '2011-04-28 18:06:17', '2011-04-28 18:06:19', 'Expired', 0, 'expired', 'Booking was expired due to non acceptance by the host ##HOSTER##. Booking amount has been refunded.'),
(10, '2011-04-28 18:06:17', '2011-04-28 18:06:19', 'Canceled By Admin', 0, 'canceled-by-admin', 'Booking was canceled by Administrator. Booking amount has been refunded based on cancellation policies.'),
(12, '2011-05-12 18:17:20', '2011-05-12 18:17:20', 'PaymentPending', 0, 'payment-pending', 'Booking is in payment pending status.');

-- --------------------------------------------------------

--
-- Table structure for table `property_views`
--

DROP TABLE IF EXISTS `property_views`;
CREATE TABLE IF NOT EXISTS `property_views` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) unsigned default NULL,
  `property_id` bigint(20) unsigned NOT NULL,
  `ip_id` bigint(20) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `photo_id` (`property_id`),
  KEY `ip_id` (`ip_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Property view details';

--
-- Dumping data for table `property_views`
--


-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

DROP TABLE IF EXISTS `requests`;
CREATE TABLE IF NOT EXISTS `requests` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `city_id` bigint(20) NOT NULL,
  `state_id` bigint(20) NOT NULL,
  `country_id` bigint(20) NOT NULL,
  `currency_id` bigint(20) NOT NULL,
  `property_type_id` bigint(20) default '0',
  `bed_type_id` bigint(20) default '0',
  `room_type_id` bigint(20) default '0',
  `title` varchar(255) collate utf8_unicode_ci default NULL,
  `slug` varchar(255) collate utf8_unicode_ci default NULL,
  `description` text collate utf8_unicode_ci,
  `address` varchar(255) collate utf8_unicode_ci NOT NULL,
  `accommodates` bigint(20) default NULL,
  `latitude` float(10,6) default NULL,
  `longitude` float(10,6) default NULL,
  `zoom_level` int(11) default '5',
  `postal_code` int(15) default NULL,
  `preference` varchar(255) collate utf8_unicode_ci default NULL,
  `checkin` date default NULL,
  `checkout` date default NULL,
  `price_per_night` double(10,2) NOT NULL,
  `is_active` tinyint(1) default '1',
  `is_alert` tinyint(1) NOT NULL,
  `is_system_flagged` bigint(20) default '0',
  `admin_suspend` tinyint(1) NOT NULL,
  `detected_suspicious_words` varchar(255) collate utf8_unicode_ci default NULL,
  `property_count` int(11) unsigned default '0',
  `request_flag_count` bigint(20) NOT NULL,
  `request_view_count` bigint(20) unsigned NOT NULL,
  `request_favorite_count` bigint(20) default '0',
  `is_approved` tinyint(1) NOT NULL default '0',
  `amenities_set` set('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22') collate utf8_unicode_ci default NULL,
  `holiday_types_set` set('1','2','3','4','5','6','7','8') collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `city_id` (`city_id`),
  KEY `state_id` (`state_id`),
  KEY `country_id` (`country_id`),
  KEY `currency_id` (`currency_id`),
  KEY `property_type_id` (`property_type_id`),
  KEY `bed_type_id` (`bed_type_id`),
  KEY `room_type_id` (`room_type_id`),
  KEY `slug` (`slug`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `requests`
--


-- --------------------------------------------------------

--
-- Table structure for table `request_favorites`
--

DROP TABLE IF EXISTS `request_favorites`;
CREATE TABLE IF NOT EXISTS `request_favorites` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `request_id` bigint(20) NOT NULL,
  `ip_id` bigint(20) default NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `request_id` (`request_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='User job favorites';

--
-- Dumping data for table `request_favorites`
--


-- --------------------------------------------------------

--
-- Table structure for table `request_flags`
--

DROP TABLE IF EXISTS `request_flags`;
CREATE TABLE IF NOT EXISTS `request_flags` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `request_id` bigint(20) unsigned NOT NULL,
  `request_flag_category_id` bigint(20) unsigned NOT NULL,
  `message` text collate utf8_unicode_ci,
  `ip_id` bigint(20) default NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `request_flag_category_id` (`request_flag_category_id`),
  KEY `request_id` (`request_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='job Flag Details';

--
-- Dumping data for table `request_flags`
--


-- --------------------------------------------------------

--
-- Table structure for table `request_flag_categories`
--

DROP TABLE IF EXISTS `request_flag_categories`;
CREATE TABLE IF NOT EXISTS `request_flag_categories` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` date NOT NULL,
  `modified` date NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `name` varchar(250) collate utf8_unicode_ci default NULL,
  `request_flag_count` bigint(20) unsigned NOT NULL,
  `is_active` tinyint(1) unsigned NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `name` (`name`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='job Flag Category Details';

--
-- Dumping data for table `request_flag_categories`
--

INSERT INTO `request_flag_categories` (`id`, `created`, `modified`, `user_id`, `name`, `request_flag_count`, `is_active`) VALUES
(1, '2010-05-14', '2010-05-14', 0, 'Sexual Content', 1, 1),
(2, '2010-05-14', '2010-05-14', 0, 'Violent or Repulsive Content', 3, 1),
(3, '2010-05-14', '2010-05-14', 0, 'Hatful or Abusive Content', 0, 1),
(4, '2010-05-14', '2010-05-14', 0, 'Ham Dangerous Acts', 0, 1),
(5, '2010-05-14', '2010-05-14', 0, 'Spam', 1, 1),
(6, '2010-05-14', '2011-04-28', 1, 'Infrings My Rights', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `request_views`
--

DROP TABLE IF EXISTS `request_views`;
CREATE TABLE IF NOT EXISTS `request_views` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `request_id` bigint(20) NOT NULL,
  `user_id` bigint(20) default NULL,
  `ip_id` bigint(20) default NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `request_id` (`request_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='Request views details';

--
-- Dumping data for table `request_views`
--


-- --------------------------------------------------------

--
-- Table structure for table `revisions`
--

DROP TABLE IF EXISTS `revisions`;
CREATE TABLE IF NOT EXISTS `revisions` (
  `id` bigint(20) NOT NULL auto_increment,
  `type` varchar(15) collate utf8_unicode_ci default NULL,
  `node_id` bigint(20) NOT NULL,
  `content` text collate utf8_unicode_ci,
  `revision_number` bigint(20) NOT NULL,
  `user_id` bigint(20) default NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `type` (`type`,`node_id`),
  KEY `node_id` (`node_id`),
  KEY `revision_number` (`revision_number`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Revision Details';

--
-- Dumping data for table `revisions`
--


-- --------------------------------------------------------

--
-- Table structure for table `room_types`
--

DROP TABLE IF EXISTS `room_types`;
CREATE TABLE IF NOT EXISTS `room_types` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `name` varchar(255) collate utf8_unicode_ci default NULL,
  `slug` varchar(265) collate utf8_unicode_ci default NULL,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `slug` (`slug`),
  KEY `is_active` (`is_active`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Room Types ';

--
-- Dumping data for table `room_types`
--

INSERT INTO `room_types` (`id`, `created`, `modified`, `name`, `slug`, `is_active`) VALUES
(1, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'Private room', 'private-room', 1),
(2, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'Shared room', 'shared-room', 1),
(3, '2011-03-11 20:15:24', '2011-03-11 20:15:24', 'Entire home', 'entire-home', 1);

-- --------------------------------------------------------

--
-- Table structure for table `search_keywords`
--

DROP TABLE IF EXISTS `search_keywords`;
CREATE TABLE IF NOT EXISTS `search_keywords` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `keyword` text collate utf8_unicode_ci,
  `search_log_count` bigint(20) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `search_keywords`
--


-- --------------------------------------------------------

--
-- Table structure for table `search_logs`
--

DROP TABLE IF EXISTS `search_logs`;
CREATE TABLE IF NOT EXISTS `search_logs` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL default '0',
  `search_keyword_id` bigint(20) default NULL,
  `ip_id` bigint(20) NOT NULL,
  `type` int(11) default '6',
  PRIMARY KEY  (`id`),
  KEY `search_keyword_id` (`search_keyword_id`),
  KEY `ip_id` (`ip_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='Logging search with Ips';

--
-- Dumping data for table `search_logs`
--


-- --------------------------------------------------------

--
-- Table structure for table `send_moneys`
--

DROP TABLE IF EXISTS `send_moneys`;
CREATE TABLE IF NOT EXISTS `send_moneys` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `amount` double(10,2) NOT NULL,
  `pay_key` varchar(100) collate utf8_unicode_ci NOT NULL,
  `is_success` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `send_moneys`
--


-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL auto_increment,
  `setting_category_id` int(11) NOT NULL,
  `setting_category_parent_id` bigint(20) default '0',
  `name` varchar(255) collate utf8_unicode_ci default NULL,
  `value` text collate utf8_unicode_ci,
  `description` text collate utf8_unicode_ci,
  `type` varchar(8) collate utf8_unicode_ci default NULL,
  `options` text collate utf8_unicode_ci,
  `label` varchar(255) collate utf8_unicode_ci default NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `setting_category_id` (`setting_category_id`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Site Setting Details';

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `setting_category_id`, `setting_category_parent_id`, `name`, `value`, `description`, `type`, `options`, `label`, `order`) VALUES
(1, 21, 1, 'site.name', 'Burrow', 'This name will be used in all pages, emails.', 'text', NULL, 'Name', 1),
(2, 0, 65, 'site.version', 'v1.0b10', 'This is the current version of the site, which will be displayed in the footer.', 'text', NULL, 'Version', 2),
(3, 24, 3, 'meta.keywords', 'agriya, dev1', 'These are the keywords used for improving search engine results of our site. (Comma separated for multiple keywords.)', 'text', NULL, 'Keywords', 1),
(4, 24, 3, 'meta.description', 'dev1 framework', 'This is the short description of your site, used by search engines on search result pages to display preview snippets for a given page.', 'textarea', NULL, 'Description', 2),
(5, 22, 1, 'site.contact_email', '', 'This is the email address to which you will receive the mail from contact form.', 'text', NULL, 'Contact Email Address', 4),
(9, 28, 5, 'user.using_to_login', 'username', 'Users will be able to login with chosen login handle (username or email address) along with their password.', 'select', 'username,\nemail', 'Login Handle', 1),
(10, 25, 3, 'site.tracking_script', '<script type="text/javascript"> var _gaq = _gaq || []; _gaq.push([''_setAccount'', ''UA-4819298-1'']); _gaq.push([''_setDomainName'', ''.dev.agriya.com'']); _gaq.push([''_trackPageview'']); (function() { var ga = document.createElement(''script''); ga.type = ''text/javascript''; ga.async = true; ga.src = (''https:'' == document.location.protocol ? ''https://ssl'' : ''http://www'') + ''.google-analytics.com/ga.js''; var s = document.getElementsByTagName(''script'')[0]; s.parentNode.insertBefore(ga, s); })(); </script>', 'This is the site tracker script, used for track and analyze data about how people are getting to your website. e.g., Google Analytics. <a href="http://www.google.com/analytics/">http://www.google.com/analytics/</a>', 'textarea', NULL, 'Site Tracker Code', 13),
(20, 42, 11, 'messages.is_send_email_on_new_message', '1', 'On enabling this feature, user will receive email if anyone send message to him. (Replaced with user specific notification, if updated in user notifications)', 'checkbox', NULL, 'Enable Send Email on New Message', 5),
(265, 38, 8, 'property.listing_fee_payer', 'Host', 'Here you can set who will pay the gateway fee for property listing payment. This will apply only to PayPal adaptive payment.', 'radio', 'Host, Site', 'Who will pay PayPal gateway fee for property listing?', 1),
(264, 38, 8, 'property.verify_fee_payer', 'Host', 'Here you can set who will pay the gateway fee for property verification payment. This will apply only to PayPal adaptive payment.', 'radio', 'Host, Site', 'Who will pay PayPal gateway fee for property verification?', 1),
(249, 43, 12, 'friend.is_send_email_on_friend_request', '1', 'On enabling this feature, users will be notified by an email for every friend request.', 'checkbox', NULL, 'Enable Notify via Mail for Friend Request', 3),
(25, 0, 65, 'thumb_size.micro_thumb.width', '18', '', 'text', NULL, 'Micro\nthumb', 0),
(26, 0, 65, 'thumb_size.micro_thumb.height', '18', '', 'text', NULL, '', 0),
(27, 0, 65, 'thumb_size.small_thumb.width', '30', '', 'text', NULL, 'Small\nthumb', 0),
(28, 0, 65, 'thumb_size.small_thumb.height', '30', '', 'text', NULL, '', 0),
(29, 0, 65, 'thumb_size.medium_thumb.width', '50', '', 'text', NULL, 'Medium thumb', 0),
(30, 0, 65, 'thumb_size.medium_thumb.height', '50', '', 'text', NULL, '', 0),
(31, 0, 65, 'thumb_size.normal_thumb.width', '75', '', 'text', NULL, 'Normal thumb', 0),
(32, 0, 65, 'thumb_size.normal_thumb.height', '75', '', 'text', NULL, '', 0),
(33, 0, 65, 'thumb_size.big_thumb.width', '86', '', 'text', NULL, 'Big\nthumb', 0),
(34, 0, 65, 'thumb_size.big_thumb.height', '80', '', 'text', NULL, '', 0),
(35, 0, 65, 'thumb_size.small_big_thumb.width', '150', '', 'text', NULL, 'Small big thumb', 0),
(36, 0, 65, 'thumb_size.small_big_thumb.height', '150', '', 'text', NULL, '', 0),
(37, 0, 65, 'thumb_size.medium_big_thumb.width', '458', '', 'text', NULL, 'Medium big thumb', 0),
(38, 0, 65, 'thumb_size.medium_big_thumb.height', '303', '', 'text', NULL, '', 0),
(39, 0, 65, 'thumb_size.very_big_thumb.width', '600', '', 'text', NULL, 'Very big thumb', 0),
(40, 0, 65, 'thumb_size.very_big_thumb.height', '600', '', 'text', NULL, '', 0),
(41, 29, 5, 'user.is_admin_activate_after_register', '0', 'On enabling this feature, admin need to approve each user after registration (User cannot login until admin approves)', 'checkbox', NULL, 'Enable Administrator Approval After Registration', 3),
(42, 29, 5, 'user.is_email_verification_for_register', '1', 'On enabling this feature, user need to verify their email address provided during registration. (User cannot login until email address is verified)', 'checkbox', NULL, 'Enable Email Verification After Registration', 4),
(43, 29, 5, 'user.is_auto_login_after_register', '1', 'On enabling this feature, users will be automatically logged-in after registration. (Only when "Email Verification" & "Admin Approval" is disabled)', 'checkbox', NULL, 'Enable Auto Login After Registration', 5),
(44, 29, 5, 'user.is_admin_mail_after_register', '1', 'On enabling this feature, notification mail will be sent to administrator on each registration.', 'checkbox', NULL, 'Enable Notify Administrator on Each Registration', 0),
(45, 29, 5, 'user.is_welcome_mail_after_register', '1', 'On enabling this feature, users will receive a welcome mail after registration.', 'checkbox', NULL, 'Enable Sending Welcome Mail After Registration', 0),
(47, 29, 5, 'user.is_logout_after_change_password', '1', 'On enabling this feature, users will be asked to log-in again.', 'checkbox', NULL, 'Enable Auto-Logout After Password Change', 8),
(53, 28, 5, 'user.is_enable_openid', '1', 'On enabling this feature, users can authenticate their site account using OpenID.', 'checkbox', NULL, 'Enable OpenID registration', 9),
(56, 27, 4, 'site.date.format', '%b %d, %Y', 'This is the date format which is displayed in our site.', 'text', NULL, 'Date Format', 6),
(57, 27, 4, 'site.datetime.format', '%b %d, %Y %I:%M %p', 'This is the date-time format which is displayed in our site.', 'text', NULL, 'Date-Time Format', 10),
(58, 27, 4, 'site.time.format', '%I:%M %p', 'This is the time format which is displayed in our site.', 'text', NULL, 'Time Format', 8),
(59, 27, 4, 'site.date.tooltip', '%b %d, %Y %I:%M %p', 'This is the date tooltip format which is displayed in our site.', 'text', NULL, 'Date Tooltip Format', 7),
(60, 27, 4, 'site.time.tooltip', '%B %d, %Y (%A) %Z', 'This is the time tooltip format which is displayed in our site.', 'text', NULL, 'Time Tooltip Format', 9),
(61, 27, 4, 'site.datetime.tooltip', '%B %d, %Y %I:%M:%S %p (%A) %Z', 'This is the date-time tooltip format which is displayed in our site.', 'text', NULL, 'Date-Time Tooltip Format', 11),
(71, 23, 2, 'site.maintenance_mode', '0', 'On enabling this feature, only administrator can access the site (e.g., http://yourdomain.com/admin). Users will see a temporary page until you return to turn this off. (Turn this on, whenever you need to perform maintenance in the site.)', 'checkbox', NULL, 'Enable Maintenance Mode', 15),
(72, 26, 4, 'site.language', 'en', 'The selected language will be used as default language all over the site (also for emails)', 'select', NULL, 'Site Language', 3),
(73, 25, 3, 'site.robots', '', 'Content for robots.txt; (search engine) robots specific instructions. Refer,<a href="http://www.robotstxt.org/">http://www.robotstxt.org/</a> for syntax and usage.', 'textarea', NULL, 'robots.txt', 14),
(92, 57, 5, 'user.is_allow_user_to_switch_language', '1', 'On enabling this feature, users can change site language to their choice.', 'checkbox', '', 'Enable User to Switch Language', 14),
(248, 52, 15, 'friend.msn_secret', '', 'This is the configured MSN Application Secret Key.', 'text', NULL, 'Application Secret', 16),
(247, 52, 15, 'friend.msn_app_id', '', 'This is the configured MSN Application ID.', 'text', NULL, 'Application ID', 15),
(246, 43, 12, 'friend.is_accept', '0', 'On enabling this feature, the friend requested made will be automatically accepted.', 'checkbox', NULL, 'Enable Auto Accept', 4),
(229, 42, 11, 'messages.send_notification_mail_for_sender', '1', 'On enabling this feature, sender will receive same email sent by him for his future reference.', 'checkbox', NULL, 'Enable Notify Mail to Sender', 3),
(168, 30, 6, 'wallet.max_wallet_amount', '200', 'This is the maximum amount a user can add to his wallet. (If left empty, then, no maximum amount restrictions)', 'text', NULL, 'Maximum Wallet Funding Limit', 10),
(167, 30, 6, 'wallet.min_wallet_amount', '10', 'This is the minimum amount a user can add to his wallet.', 'text', NULL, 'Minimum Wallet Funding Limit', 11),
(166, 47, 14, 'affiliate.site_commission_type', 'amount', 'The selected option will be used as the default fee type during affiliate cash withdrawal.', 'select', 'percentage,amount', '', 8),
(165, 47, 14, 'affiliate.site_commission_amount', '1', 'This is the amount which will be taken during affiliate cash withdrawal. (If left empty, then, no fee will be taken)', 'text', NULL, 'Transaction Fee', 7),
(164, 45, 14, 'affiliate.referral_cookie_expire_time', '1', 'This is the maximum time after which the referral cookie will be expired or unusable.', 'text', NULL, 'Referral Cookie Expire Time', 2),
(163, 46, 14, 'affiliate.commission_on_every_property_booking', '1', 'On enabling this feature, affiliate user will earn commission amount on every referral booked. (Turn this off, if you want affiliate user to be payed only for his first referral)', 'checkbox', NULL, 'Enable Pay Commission On Every Property Booked', 3),
(162, 46, 14, 'affiliate.commission_holding_period', '0', 'This is the maximum number of days in which the commission amount is in holding state. During this state, amount cannot be requested for withdrawal.', 'text', NULL, 'Maximum Commission Holding Period', 4),
(160, 45, 14, 'affiliate.is_enabled', '1', 'On enabling this feature, users can make request to become a "Affiliate User" and related affiliate users setting will be enabled.', 'checkbox', NULL, 'Enable Affiliate', 1),
(161, 47, 14, 'affiliate.payment_threshold_for_threshold_limit_reach', '1', 'This is the minimum amount to get reached for a affiliate user can make a withdraw request.', 'text', NULL, 'Minimum Withdrawal Threshold Limit', 6),
(228, 42, 11, 'messages.is_send_email_on_new_message', '1', 'On enabling this feature, users will be notified by an email for every new message.', 'checkbox', '', 'Enable Notify via Mail on New Message', 2),
(227, 42, 11, 'messages.is_send_internal_message', '1', 'On disabling this feature, user cannot able to send message to other user in site.', 'checkbox', NULL, 'Enable Send Message Option', 1),
(159, 0, 65, 'site.datetimehighlight.tooltip', '%B %d, %Y %I:%M:%S %p (%A) %Z', 'This is the date-time highlight tooltip format which is displayed in our site.', 'text', NULL, 'Date-Time Highlight Tooltip', 12),
(169, 28, 5, 'facebook.is_enabled_facebook_connect', '1', 'On enabling this feature, users can authenticate their site account using Facebook.', 'checkbox', NULL, 'Enabled Facebook', 12),
(170, 48, 15, 'facebook.api_key', '', 'This is the Facebook app key used for authentication and other Facebook related plugins support', 'text', NULL, 'Application Key', 3),
(171, 48, 15, 'facebook.secrect_key', '', 'This is the Facebook secret key used for authentication and other Facebook related plugins support', 'text', NULL, 'Secret Key', 4),
(172, 49, 15, 'twitter.consumer_key', '', 'This is the consumer key used for authentication and posting on Twitter.', 'text', NULL, 'Consumer Key', 1),
(173, 49, 15, 'twitter.consumer_secret', '', 'This is the consumer secret key used for authentication and posting on Twitter.', 'text', NULL, 'Consumer Secret Key', 2),
(174, 49, 15, 'twitter.site_username', '', 'This is the Twitter username of the account has been created.', 'text', NULL, 'Twitter Username', 5),
(175, 49, 15, 'twitter.site_user_access_key', '', 'This will be automatically updated when on clicking "Update Twitter Credentials" link. (Required for posting in Twitter)', 'text', NULL, 'Access Key', 3),
(176, 49, 15, 'twitter.site_user_access_token', '', 'This will be automatically updated when on clicking "Update Twitter Credentials" link. (Required for posting in Twitter)', 'text', NULL, 'Access Token', 4),
(177, 13, 0, 'twitter.prompt_for_email_after_register', '1', 'Prompts\ntwitter user to enter email after twitter registration.', 'checkbox', NULL, 'Prompt for email after registration', 2),
(178, 48, 15, 'facebook.fb_access_token', '', 'This will be automatically updated when on clicking "Update Facebook Credentials" link. (Required for posting in Facebook)', 'text', NULL, 'Access Token', 5),
(179, 48, 15, 'facebook.fb_user_id', '', 'This will be automatically updated when on clicking "Update Facebook Credentials" link. (Required for posting in Facebook)', 'text', '', 'User ID', 6),
(180, 48, 15, 'facebook.page_id', '', 'This is the Facebook page ID, if specified, any new property added will be posted in this page wall, instead of the configured account.', 'text', NULL, 'Page ID', 2),
(181, 48, 15, 'facebook.app_id', '', 'This is the application ID used in login and post.', 'text', NULL, 'Application ID', 1),
(182, 28, 5, 'twitter.is_enabled_twitter_connect', '1', 'On enabling this feature, users can authenticate their site account using Twitter.', 'checkbox', NULL, 'Enable Twitter', 14),
(184, 40, 10, 'suspicious_detector.suspiciouswords', 'stupid\r\nfool\r\n\\w+([-+.]\\w+)*@\\w+([-.]\\w+)*\\.\\w+([-.]\\w+)*([,;]\\s*\\w+([-+.]\\w+)*@\\w+([-.]\\w+)*\\.\\w+([-.]\\w+)*)*\r\n0[234679]{1}[\\s]{0,1}[\\-]{0,1}[\\s]{0,1}[1-9]{1}[0-9]{6}$', 'The suspicious words given will be matched with user given message and will be auto flagged if such words are found. (Note: Suspicious detection will be checked during property, request creation & send message. Detection words should be newline separated.)', 'textarea', NULL, 'Suspicious Words', 2),
(190, 33, 7, 'property.days_after_amount_withdraw', '1', 'This is the maximum number of days after checkin in which the booking amount is in holding state. Traveler can raise dispute "Doesn''t match the specification as mentioned by the host" within given days. If dispute raised, then amount will be blocked.', 'text', NULL, 'Days after amount will be cleared to host', 23),
(191, 37, 8, 'property.booking_service_fee', '7', 'This is the traveler service fee percentage which will be calculate from booking amount when on booking the property.', 'text', NULL, 'Traveler Service Fee', 5),
(192, 33, 7, 'property.auto_expire', '1', 'This is the maximum number of days after in which unaccepted bookings are automatically expired and amount will be refunded to traveler.', 'text', NULL, 'Days after unaccepted booking auto expire', 20),
(193, 48, 15, 'property.post_property_on_facebook', '1', 'On enabling this feature, post new property in site Facebook wall', 'checkbox', NULL, 'Post New Property on Site Facebook Wall', 8),
(194, 49, 15, 'property.post_property_on_twitter', '1', 'On enabling this feature, post new property in site Twitter account', 'checkbox', NULL, 'Post New Property on Site Twitter Account', 7),
(196, 32, 7, 'property.maximum_title_length', '200', 'This is the maximum character allowed for property title.', 'text', NULL, 'Maximum Character for Property Title', 11),
(197, 32, 7, 'property.maximum_description_length', '450', 'This is the maximum character allowed for property description.', 'text', NULL, 'Maximum Character for Property Description', 13),
(198, 32, 7, 'property.minimum_title_length', '8', 'This is the minimum character allowed for property title', 'text', NULL, 'Minimum Character for Property Title', 12),
(244, 41, 10, 'request.auto_suspend_request_on_system_flag', '1', 'Auto suspended requests will not display in site.', 'checkbox', NULL, 'Enable Auto Suspend Request on System Flag', 26),
(312, 56, 4, 'site.is_currency_conversion_history_updation', '1', 'On enabling this feature, latest currency conversion rate, old rate are stored in currency conversion History.', 'checkbox', NULL, 'Enable Currency Conversion History Updation', 0),
(245, 41, 10, 'property.auto_suspend_message_on_system_flag', '1', 'Auto suspended messages will not display in site.', 'checkbox', NULL, 'Enable Auto Suspend Message on System Flag', 26),
(203, 41, 10, 'property.auto_suspend_property_on_system_flag', '1', 'Auto suspended properties will not display in site.', 'checkbox', NULL, 'Enable Auto Suspend Property on System Flag', 26),
(206, 37, 8, 'property.payment_gateway_fee_id', 'Host', 'Here you can set who will pay the gateway fee for booking. This will apply only to PayPal adaptive payment.', 'radio', 'Host, Site, Site and Host', 'Who will pay PayPal gateway fee for booking?', 1),
(207, 36, 8, 'property.is_paypal_connection_enabled', '1', 'On enabling this feature, users will connect their PayPal account with site for one year from connected date for maximum amount of $2000. Using this connected PayPal users can easily book the property without leaving to PayPal site.', 'checkbox', NULL, 'Enable Paypal Connection', 3),
(216, 22, 1, 'site.reply_to_email', '', '"Reply-To" email header for all emails. Leave it empty to receive replies as usual (to "From" email address).', 'text', NULL, 'Reply Email\naddress', 5),
(217, 22, 1, 'site.from_email', '', 'This is the email address that will appear in the "From" field of all emails sent from the site.', 'text', NULL, 'From Email address', 5),
(218, 56, 4, 'site.currency_code', 'USD', 'The selected currency will be used as site default transaction currency. (All payments, transaction will use this currency).', 'select', 'AUD,BRL,CAD,CZK,DKK,EUR,HKD,HUF,ILS,JPY,MXN,NOK,NZD,PHP,PLN,GBP,SGD,SEK,CHF,TWD,THB,USD\n', 'Default Transaction Currency', 5),
(220, 53, 15, 'flickr.api_key', '70a50b14e9e203eab939e4ce223515b9', 'This is the configured Flickr API Key.', 'text', NULL, 'API Key', 2),
(266, 34, 7, 'property.is_allow_property_flag', '1', 'On enabling this feature, user can report about property.', 'checkbox', NULL, 'Enable Property Flag', 12),
(223, 35, 7, 'barcode.is_barcode_enabled', '1', '', 'checkbox', NULL, 'Enable Barcode', 1),
(224, 35, 7, 'barcode.width', '120', 'This is the width of the barcode which is generated for ticket.', 'text', NULL, 'Barcode Width', 3),
(225, 35, 7, 'barcode.height', '120', 'This is the height of the barcode which is generated for coupons.', 'text', NULL, 'Barcode Height', 4),
(226, 37, 8, 'site.distance_limit', '100', 'Maximum distance covered for property search from the entered location', 'text', NULL, 'Property Search Limit', 15),
(230, 49, 15, 'twitter.site_twitter_url', '', 'This is the site Twitter URL used displayed in the footer.', 'text', NULL, 'Twitter Account URL', 6),
(231, 48, 15, 'facebook.site_facebook_url', '', 'This is the site Facebook URL used displayed in the footer.', 'text', NULL, 'Facebook Account URL', 7),
(232, 31, 6, 'user.minimum_withdraw_amount', '2', 'This is the minimum amount a user can withdraw from their wallet.', 'text', NULL, 'Minimum Wallet Withdrawal Amount', 2),
(233, 31, 6, 'user.maximum_withdraw_amount', '100', 'This is the maximum amount a user can withdraw from their wallet.', 'text', NULL, 'Maximum Wallet Withdrawal Amount', 3),
(234, 31, 6, 'user.is_user_can_with_draw_amount', '1', 'On enabling this feature, users can make a request to withdraw their wallet amount to their provided PayPal account. (Requires administrator approval for each request).', 'checkbox', NULL, 'Enable Cash Withdrawal', 1),
(235, 44, 13, 'dispute.discussion_threshold_for_admin_decision', '2', 'Admin will take decision, after given number of conversation between traveler and host.', 'text', NULL, 'Discussion Threshold for Admin Decision', 1),
(236, 44, 13, 'dispute.days_left_for_disputed_user_to_reply', '5', 'Maximum number of days to reply for a dispute raised in booking', 'text', NULL, 'Number of days to reply a dispute', 2),
(237, 44, 13, 'dispute.refund_amount_during_dispute_cancellation', '50', 'Given percentage will be deduct from booking amount and refund to traveler when traveler raised dispute if "Doesn''t match the specification as mentioned by the host" and admin decision favored to traveler.', 'text', NULL, 'Refund Percentage to Traveler for Property Specification Dispute', 3),
(238, 38, 8, 'property.listing_fee', '10', 'For free property listing, set it as "0".', 'text', NULL, 'Property Listing Fee', 25),
(313, 58, 15, 'google.translation_api_key', '', 'This is the configured Google Translate API key.', 'text', NULL, 'API Key', 0),
(314, 0, 65, 'thumb_size.normal_big_thumb.width', '161', '', 'text', NULL, 'Normal Big thumb', 0),
(315, 0, 65, 'thumb_size.normal_big_thumb.height', '119', '', 'text', NULL, '', 0),
(241, 32, 7, 'property.is_auto_approve', '1', 'On disabling this feature, admin need to approve each property after added (Property will not list in site until admin approves)', 'checkbox', NULL, 'Enable Auto Approval After Property Add', 25),
(242, 38, 8, 'property.verify_fee', '10', 'For free property verification, set it as "0".', 'text', NULL, 'Property Verification Fee', 25),
(252, 43, 12, 'friend.is_two_way', '1', 'On enabling this feature, on each friend request, the requested friend needs to accept the request to become friends. (Disable this, if other users don''t need to approve to become a friend.)', 'checkbox', NULL, 'Enable "Two Way" Friendship', 2),
(253, 43, 12, 'friend.is_enabled', '1', 'On enabling this feature, all friends related settings like adding friends, managing friends will be enabled.', 'checkbox', NULL, 'Enable Friends', 1),
(255, 50, 15, 'invite.yahoo_app_data', '', 'This is the data provided during Yahoo Invite. (our site name)', 'text', NULL, 'Application Data', 11),
(256, 50, 15, 'invite.yahoo_consumer_key', '', 'This is configured Yahoo consumer key.', 'text', NULL, 'Consumer Key', 12),
(257, 50, 15, 'invite.yahoo_secret_key', '', 'This is configured Yahoo consumer secret key.', 'text', NULL, 'Consumer Secret', 13),
(258, 51, 15, 'friend.gmail_contact_max_result_limit', '1000', 'This is the maximum number of contacts retrieved from Gmail during importing contact.', 'text', NULL, 'Maximum Contact Import Limit', 15),
(259, 56, 4, 'site.currency_symbol_place', 'right', 'The selected position will be used as default currency symbol position all over the site (also for emails)', 'select', 'right, left', 'Currency Symbol Position', 10),
(260, 37, 8, 'property.host_commission_amount', '7', 'This is the host service fee percentage which will be calculate from booking amount.', 'text', NULL, 'Host Service Fee', 5),
(261, 36, 8, 'property.minimum_nights', '8', 'This is the maximum value the user can select for "Minimum nights" in property add & edit page', 'text', NULL, 'Maximim value for minimum nights', 12),
(262, 36, 8, 'property.maximum_nights', '30', 'This is the maximum value the user can select for "Maximum nights"', 'text', NULL, 'Maximim value for maximum nights', 12),
(263, 50, 15, 'invite.yahoo_app_id', '', 'This is the configured Yahoo API ID.', 'text', NULL, 'Application ID', 10),
(267, 39, 9, 'request.is_allow_request_flag', '1', 'On enabling this feature, user can report about request.', 'checkbox', NULL, 'Enable Request Flag', 12),
(269, 39, 9, 'request.is_auto_approve', '1', 'On enabling this feature, admin need to approve each request after added (Request will not list in site until admin approves)', 'checkbox', NULL, 'Enable Administrator Approval After Request Add', 12),
(270, 28, 5, 'facebook.login_allow_friends_count', '10', 'For Security, user can register using his Twitter account with our site only if Twitter account has mentioned friends count. Set it to 0 for no restriction.', 'text', NULL, 'Restrict Facebook users registered using Facebook account friends count', 13),
(271, 37, 8, 'site.exact_distance_limit', '2', 'This is the maximum distance limit to mark the property as "Exact" in property search.', 'text', NULL, 'Distance limit to mark as "Exact"', 16),
(272, 33, 7, 'site.maximum_negotiation_allowed_discount', '50', 'This is the maximum negotiation discount percentage can given by host to traveler for a booking.', 'text', NULL, 'Maximum Negotiation Discount', 17),
(275, 48, 15, 'social_networking.post_property_on_user_facebook', '1', 'On enabling this feature, post new property in user''s Facebook wall', 'checkbox', NULL, 'Post New Property on User Facebook Wall', 10),
(276, 49, 15, 'social_networking.post_property_on_user_twitter', '1', 'On enabling this feature, post new property in user''s Twitter account', 'checkbox', NULL, 'Post New Property on User Twitter Account', 9),
(277, 48, 15, 'request.post_request_on_facebook', '1', 'On enabling this feature, post new request in site Facebook wall', 'checkbox', NULL, 'Post New Request on Site Facebook Wall', 9),
(278, 49, 15, 'request.post_request_on_twitter', '1', 'On enabling this feature, post new request in site Twitter account', 'checkbox', NULL, 'Post New Request on Site Twitter Account', 8),
(294, 49, 15, 'social_networking.post_request_on_user_twitter', '1', 'On enabling this feature, post new request in user''s Twitter account', 'checkbox', NULL, 'Post New Request on User Twitter Account', 10),
(281, 48, 15, 'social_networking.post_request_on_user_facebook', '1', 'On enabling this feature, post new request in user''s Facebook wall', 'checkbox', NULL, 'Post New Request on User Facebook Wall', 11),
(283, 0, 65, 'thumb_size.collection_thumb.width', '280', '', 'text', NULL, 'Collection thumb', 0),
(284, 0, 65, 'thumb_size.collection_thumb.height', '185', NULL, 'text', NULL, NULL, 0),
(285, 23, 2, 'site.look_up_url', 'http://whois.sc/', 'URL prefix for whois lookup service. Will be used in whois links found in ##USER_LOGIN## pages to resolve users'' IP to where they are from&mdash;often down to the city or neighborhood or country. This is a security feature.', 'text', '', 'Whois Lookup URL', 30),
(286, 55, 2, 'site.iphone_app_key', '', 'This is the security key used for iPhone App', 'text', '', 'Application Key', 15),
(287, 0, 65, 'thumb_size.iphone_big_thumb.width', '160', NULL, 'text', NULL, 'iPhone Big Thumb', 13),
(288, 0, 65, 'thumb_size.iphone_big_thumb.height', '102', NULL, 'text', NULL, '', 14),
(289, 0, 65, 'thumb_size.iphone_small_thumb.width', '100', NULL, 'text', NULL, 'iPhone Small Thumb', 15),
(290, 0, 65, 'thumb_size.iphone_small_thumb.height', '60', NULL, 'text', NULL, '', 16),
(291, 0, 65, 'thumb_size.collage_thumb.width', '120', '', 'text', NULL, 'Collage thumb', 0),
(292, 0, 65, 'thumb_size.collage_thumb.height', '76', NULL, 'text', NULL, NULL, 0),
(293, 36, 8, 'paypal.is_embedded_payment_enabled', '0', 'On enabling this feature, user pay via PayPal then PayPal site will open in a lightbox.', 'checkbox', '', 'Enable Embedded Payment', 0),
(295, 21, 1, 'site.slogan_text', 'Book your burrow', 'This text will be used as to display in home page.', 'text', NULL, 'Slogan', 1),
(296, 34, 7, 'property.force_paypal_credentials_in_property_add', '1', 'When enabled, payment will be handled through adaptive chained payment (amount will be transferred between PayPal accounts directly). Otherwise, amount will be moved to host wallet (here adaptive simple payment will be used when guest makes payment). You may also disable this option, when you don''t want to chained payment that will require manual PayPal audit.', 'checkbox', '', 'Force host to fill up PayPal email before posting a property', 2),
(297, 34, 7, 'property.is_property_verification_enabled', '0', 'On enabling this feature, host can request admin to check his property and set it as verified property.', 'checkbox', '', 'Enable Property Verification', 2),
(298, 28, 5, 'twitter.login_allow_follower_count', '10', 'For Security, user can register using his Twitter account with our site only if Twitter account has mentioned followers count. Set it to 0 for no restriction.', 'text', '', 'Restrict Twitter users registered using Twitter account follower count', 15),
(299, 28, 5, 'user.days_after_fetch_facebook_friends', '1', 'By default we are not getting the email address for twitter users, so only if the above setting is enabled we will force the twitter user to enter their email address while registration.', 'text', NULL, 'Prompt for email after Twitter registration', 0),
(300, 57, 5, 'user.is_allow_user_to_switch_currency', '1', 'On enabling this feature, users can change site currency to their choice.', 'checkbox', NULL, 'Enable User to Switch Currency', 15),
(301, 56, 4, 'site.currency_id', '1', 'The selected currency will be used in site to display as default currency in all pages. (Replaced with user selected currency)', 'select', NULL, 'Default Display Currency', 7),
(302, 56, 4, 'site.is_auto_currency_updation', '0', 'On enabling this feature, latest currency conversion values are automatically updated <a href="http://www.ecb.int/stats/eurofxref/eurofxref-daily.xml"> http://www.ecb.int/stats/eurofxref/eurofxref-daily.xml</a> via cron everyday. (Disable this, if you have manually updated certain currency values in ##MASTER_CURRENCY##)', 'checkbox', NULL, 'Enable Automatic Currency Conversion Updation', 9),
(303, 38, 8, 'user.signup_fee', '10', 'For free signup , set it as "0".', 'text', NULL, 'User Membership Fee', 16),
(304, 38, 8, 'user.signup_fee_payer', 'User', 'Here you can set who will pay the gateway fee for membership payment. This will apply only to PayPal adaptive payment.', 'radio', 'User, Site', 'Who will pay PayPal gateway fee for membership?', 1),
(305, 34, 7, 'property.is_enable_security_deposit', '1', 'On enabling this feature, host can set security deposit amount for his property. Traveler will pay booking amount with security deposit at the time of booking. It will automatically refund to traveler if no dispute was raised by host.', 'checkbox', NULL, 'Enable Security Deposit', 5),
(306, 33, 7, 'property.auto_refund_security_deposit', '1', 'This is the maximum number of days after checkout in which the security deposit amount is in holding state. Host can raise dispute "Claim the security damage from traveler" within given days. If dispute raised, then security deposit will be blocked.', 'checkbox', NULL, 'Days after secuity deposit will be refunded to traveler', 0),
(307, 28, 5, 'user.is_enable_normal_registration', '1', 'On disabling this feature, user will be registered via Facebook, Twitter & OpenID.', 'checkbox', NULL, 'Enable Normal Registration & Login', 16),
(308, 28, 5, 'twitter.login_allow_created_month', '1', 'For Security, user can register using his Twitter account with our site only if Twitter account should be created before given month. Set it to 0 for no restriction.', NULL, NULL, 'Restrict Twitter users registered using Twitter account created month', 3),
(309, 34, 7, 'property.is_enable_property_count', '1', 'This is to hide total available properties on the site. You may want to check this when your site is new and you have relatively less properties on the site.', 'checkbox', NULL, 'Hide properties count', 16),
(310, 23, 2, 'site.is_ssl_enabled', '0', 'On enabling this feature, users login, registration and payment page will be carried through more secure way. (Requires purchase of an SSL certificate if this option is in disabled state)', 'checkbox', NULL, 'Enable SSL (Secure Socket Layer)', 20),
(311, 32, 7, 'properties.max_upload_photo', '5', 'This is the maximum number of photos can upload by host per property.', 'text', NULL, 'Maximum Number of Photos Per Property', 0);

-- --------------------------------------------------------

--
-- Table structure for table `setting_categories`
--

DROP TABLE IF EXISTS `setting_categories`;
CREATE TABLE IF NOT EXISTS `setting_categories` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `parent_id` bigint(20) default '0',
  `name` varchar(200) collate utf8_unicode_ci NOT NULL,
  `description` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Site Setting Category Details';

--
-- Dumping data for table `setting_categories`
--

INSERT INTO `setting_categories` (`id`, `created`, `modified`, `parent_id`, `name`, `description`) VALUES
(1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'System', 'Manage site name, contact email, from email, reply to email.'),
(2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'Developments', 'Manage Maintenance mode.'),
(3, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'SEO', 'Manage content, meta data and other information relevant to browsers or search engines'),
(4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'Regional, Currency & Language', 'Manage site default language, currency, date-time format'),
(5, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'Account', 'Manage different type of login option such as Facebook, Twitter, Yahoo and Gmail'),
(6, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'Payment', 'Manage payment related settings such as wallet, cash withdrawal.<br>Manage different types payment gateway settings of the site. [Wallet, PayPal, Authorize.net, PagSeguro]. <a title="Update Payment Gateway Settings" class="paymentgateway-link" href="##PAYMENT_SETTINGS_URL##">Update Payment Gateway Settings</a>'),
(7, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'Property', 'Manage & configure settings related to property listing and booking options.'),
(8, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'Revenue', 'Manage & configure settings related to properties, listing fee, verification fee, commission and properties list options.'),
(9, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'Request', 'Manage & configure settings related to requests auto approve & enable and disable options for request flag.'),
(10, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'Suspicious Words Detector', 'Manage Suspicious word detector feature, Auto suspend property on system flag, Auto suspend request on system flag, Auto suspend message on system flag.'),
(11, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'Messages', 'Manage and configure settings such as email notification, send message option.'),
(12, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'Friends', 'Manage friends request, approve and send mail related settings.'),
(13, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'Dispute', 'Manage Dispute Conversation count, Number of days to reply dispute.'),
(14, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'Affiliate', 'Manage affiliate information,  commission and withdraw amount details.'),
(15, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'Third Party API', 'Manage third party settings such as Facebook, Twitter, Gmail, Yahoo, MSN for authentication, importing contacts and posting.'),
(16, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'Module Manager', 'Manage Affiliate and Friends module enable and disable options.'),
(21, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'Site Information', 'Here you can modify site related settings such as site name.'),
(22, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'E-mails', 'Here you can modify email related settings such as contact email, from email, reply-to email.'),
(23, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, 'Server', 'Here you can change server settings such as maintenance mode, SSL settings.'),
(24, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 3, 'Metadata', 'Here you can set metadata settings such as meta keyword and description.'),
(25, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 3, 'SEO', 'Here you can set SEO settings such as inserting tracker code and robots.'),
(26, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 4, 'Regional', 'Here you can change regional setting such as site language.'),
(27, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 4, 'Date and Time', 'Here you can modify date time settings such as timezone, date time format.'),
(28, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 5, 'Logins', 'Here you can modify user login settings such as enabling 3rd party logins and other login options.'),
(29, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 5, 'Account Settings', 'Here you can modify account settings such as admin approval, email verification, and other site account settings.'),
(30, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 6, 'Wallet', 'Here you can modify wallet related setting such as enabling groupon-like wallet, maximum and minimum funding limit settings.'),
(31, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 6, 'Cash Withdraw', 'Here you can modify cash withdraw settings for a user such as enabling withdrawal and setting withdraw limit'),
(32, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 7, 'List Configuration', 'Here you can modify property list related settings such as auto approve property, maximum photo upload per property'),
(33, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 7, 'Booking Configuration', 'Here you can modify property booking related settings such as maximum negotiation discount, auto expire booking'),
(34, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 7, 'Configuration', 'Here you can modify enable and disable delayed chained payment, secuirty deposit'),
(35, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 7, 'Barcode', 'Here you can modify barcode settings such as width, height settings. You can enable/disable barcode here. If you use barcode reader with computer, it will help to mark it as checkin/checkout easily.'),
(36, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 8, 'Configuration', 'Here you can modify enable and disable PayPal connection, PayPal embedded option'),
(37, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 8, 'Booking Commission', 'Here you can manage booking commission percentage from host and traveler'),
(38, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 8, 'Other Fee Options', 'Here you can manage property listing, verification and use membership fee'),
(39, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 9, 'Configuration', 'Here you can modify request related settings such as auto approve request'),
(40, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 10, 'Configuration', '<p>Here you can update the Suspicious Words Detector related settings.</p>\r\n<p>Here you can place various words, which accepts regular expressions also, to match with your terms and policies.  </p>\r\n<h4>Common Regular expressions</h4>\r\n<dl class="list clearfix">\r\n	<dt>Email</dt>\r\n<dd>\\w+([-+.]\\w+)*@\\w+([-.]\\w+)*\\.\\w+([-.]\\w+)*([,;]\\s*\\w+([-+.]\\w+)*@\\w+([-.]\\w+)*\\.\\w+([-.]\\w+)*)*</dd>\r\n	<dt>Phone Number</dt>\r\n<dd>\r\n^0[234679]{1}[\\s]{0,1}[\\-]{0,1}[\\s]{0,1}[1-9]{1}[0-9]{6}$</dt>\r\n	<dt>URL</dt>\r\n<dd>((https?|ftp|gopher|telnet|file|notes|ms-help):((//)|(\\\\\\\\))+[\\w\\d:#@%/;$()~_?\\+-=\\\\\\.&]*)</dd>\r\n\r\n</dl>'),
(41, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 10, 'Auto Suspend Module', 'Here you can modify auto suspend modules as projects, bids and messages. \r\n'),
(42, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 11, 'Configuration', 'Here you modify message settings such as send message options and other message related settings.'),
(43, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 12, 'Configuration', 'Here you can modify friend settings such as auto accept and other friendship related settings.'),
(44, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 13, 'Configuration', 'Here you can modify dispute related settings such as cancellation percentage from traveler.'),
(45, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 14, 'Configuration', 'Here you can modify affiliate related settings such as enabling affiliate and referral expire time.'),
(46, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 14, 'Commission', 'Here you can modify affiliate related commission settings such as commission holding period, commission pay type settings.'),
(47, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 14, 'Withdrawal', 'Here you can modify affiliate withdrawal settings such as threshold limit, transaction fee settings.'),
(48, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 15, 'Facebook', 'Facebook is used for login and posting message using its account details. For doing above, our site must be configured with existing Facebook account. <a href="http://dev1products.dev.agriya.com/doku.php?id=facebook-setup"> http://dev1products.dev.agriya.com/doku.php?id=facebook-setup </a>'),
(49, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 15, 'Twitter', 'Twitter is used for login and posting message using its account details. For doing above, our site must be configured with existing Twitter account. <a href="http://dev1products.dev.agriya.com/doku.php?id=twitter-setup"> http://dev1products.dev.agriya.com/doku.php?id=twitter-setup </a>'),
(50, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 15, 'Yahoo', 'We use this service for importing contacts from Yahoo for friends invite. For doing above, our site must be configured with existing Yahoo account. <a href="http://dev1products.dev.agriya.com/doku.php?id=yahoo-setup"> http://dev1products.dev.agriya.com/doku.php?id=yahoo-setup </a>'),
(51, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 15, 'Gmail', 'We use this service for importing contacts from Gmail for friends invite. For doing above, our site must be configured with existing Gmail account. <a href="http://dev1products.dev.agriya.com/doku.php?id=google_setup"> http://dev1products.dev.agriya.com/doku.php?id=google_setup </a>'),
(52, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 15, 'MSN', 'We use this service for importing contacts from MSN for friends invite. For doing above, our site must be configured with existing MSN account. <a href="http://dev1products.dev.agriya.com/doku.php?id=msn-setup"> http://dev1products.dev.agriya.com/doku.php?id=msn-setup </a>'),
(53, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 15, 'Flickr', 'We use this service to show photos near to city in property view page. For doing above, our site must be configured with existing Flickr account. <a href="http://dev1products.dev.agriya.com/doku.php?id=flickr-setup"> http://dev1products.dev.agriya.com/doku.php?id=flickr-setup </a>'),
(54, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 16, 'Module', 'Here you can modify module settings such as enabling/disabling master modules settings.'),
(55, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, 'Mobile Apps', 'All mobile apps will send secret key (hard coded in Mobile App) to fetch data from server. App''s key should be matched with this value.<br/>Warning: changing this value may break your mobile apps.'),
(56, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 4, 'Currency Settings', 'Here you can modify site currency settings such as currency position, default currency and conversion currency.'),
(57, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 5, 'Configuration', 'Here you can modify option to change language & currency for user.'),
(58, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 15, 'Google Translations', '<p>We use this service for quick translation to support new languages in ##TRANSLATIONADD##.</p> <p>Note that Google Translate API is now a <a href="http://code.google.com/apis/language/translate/v2/pricing.html" target="_blank">paid service</a>. Getting Api key, refer <a href="http://dev1products.dev.agriya.com/doku.php?id=google-translation-setup" target="_blank">http://dev1products.dev.agriya.com/doku.php?id=google-translation-setup</a>.</p>');

-- --------------------------------------------------------

--
-- Table structure for table `site_categories`
--

DROP TABLE IF EXISTS `site_categories`;
CREATE TABLE IF NOT EXISTS `site_categories` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci default NULL,
  `slug` varchar(265) collate utf8_unicode_ci default NULL,
  `is_active` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `slug` (`slug`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `site_categories`
--

INSERT INTO `site_categories` (`id`, `created`, `modified`, `name`, `slug`, `is_active`) VALUES
(1, '2011-03-05 15:05:03', '2011-03-05 15:05:03', 'Technology', 'technology', 1),
(2, '2011-03-05 15:05:03', '2011-03-05 15:05:03', 'Programming', 'programming', 1),
(3, '2011-03-05 15:05:03', '2011-03-05 15:05:03', 'Music & Audio', 'music-audio', 1),
(4, '2011-03-05 15:05:03', '2011-03-05 15:05:03', 'Business', 'business', 1),
(5, '2011-03-05 15:05:03', '2011-03-05 15:05:03', 'Silly Stuff', 'silly-stuff', 1),
(6, '2011-03-05 15:05:03', '2011-03-05 15:05:03', 'Other', 'other', 1),
(7, '2011-03-05 15:05:03', '2011-03-05 15:05:03', 'Graphics', 'graphics', 1),
(8, '2011-03-05 15:05:03', '2011-03-05 15:05:03', 'Writing', 'writing', 1),
(9, '2011-03-05 15:05:03', '2011-03-05 15:05:03', 'Fun &  Bizarre', 'fun-bizarre', 0);

-- --------------------------------------------------------

--
-- Table structure for table `spam_filters`
--

DROP TABLE IF EXISTS `spam_filters`;
CREATE TABLE IF NOT EXISTS `spam_filters` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `other_user_id` bigint(20) NOT NULL,
  `content` text collate utf8_unicode_ci,
  `subject` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `other_user_id` (`other_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `spam_filters`
--


-- --------------------------------------------------------

--
-- Table structure for table `states`
--

DROP TABLE IF EXISTS `states`;
CREATE TABLE IF NOT EXISTS `states` (
  `id` bigint(20) NOT NULL auto_increment,
  `country_id` bigint(20) default '0',
  `name` varchar(45) collate utf8_unicode_ci default NULL,
  `code` varchar(8) collate utf8_unicode_ci default NULL,
  `adm1code` varchar(4) collate utf8_unicode_ci default NULL,
  `is_approved` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `country_id` (`country_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `country_id`, `name`, `code`, `adm1code`, `is_approved`) VALUES
(1, 253, 'British Columbia', 'BC', '', 1),
(2, 253, 'Manitoba', 'MB', '', 1),
(3, 253, 'New Brunswick', 'NB', '', 1),
(4, 43, 'Newfoundland and Labrador', 'NL', '', 1),
(5, 253, 'Northwest Territories', 'NT', '', 1),
(6, 253, 'Nunavut', 'NU', '', 1),
(7, 253, 'Ontario', 'ON', '', 1),
(8, 253, 'Prince Edward Island', 'PE', '', 1),
(9, 253, 'Quebec', 'QC', '', 1),
(10, 253, 'Saskatchewan', 'SK', '', 1),
(11, 253, 'Yukon', 'YT', '', 1),
(12, 253, 'Alabama', 'AL', '', 1),
(13, 253, 'Alaska', 'AK', '', 1),
(14, 253, 'American Samoa', 'AS', '', 1),
(15, 253, 'Arizona', 'AZ', '', 1),
(16, 253, 'Arkansas', 'AR', '', 1),
(17, 253, 'California', 'CA', '', 1),
(18, 253, 'Colorado', 'CO', '', 1),
(19, 253, 'Connecticut', 'CT', '', 1),
(20, 253, 'Delaware', 'DE', '', 1),
(21, 253, 'District of Columbia', 'DC', '', 1),
(22, 253, 'Federated States of Micronesia', 'FM', '', 1),
(23, 253, 'Florida', 'FL', '', 1),
(24, 253, 'Georgia', 'GA', '', 1),
(25, 253, 'Guam', 'GU', '', 1),
(26, 253, 'Hawaii', 'HI', '', 1),
(27, 253, 'Illinois', 'IL', '', 1),
(28, 253, 'Indiana', 'IN', '', 1),
(29, 253, 'Iowa', 'IA', '', 1),
(30, 253, 'Kansas', 'KS', '', 1),
(31, 253, 'Kentucky', 'KY', '', 1),
(32, 253, 'Louisiana', 'LA', '', 1),
(33, 253, 'Maine', 'ME', '', 1),
(34, 253, 'Marshall Islands', 'MH', '', 1),
(35, 253, 'Maryland', 'MD', '', 1),
(36, 253, 'Massachusetts', 'MA', '', 1),
(37, 253, 'Michigan', 'MI', '', 1),
(38, 253, 'Minnesota', 'MN', '', 1),
(39, 253, 'Mississippi', 'MS', '', 1),
(40, 253, 'Missouri', 'MO', '', 1),
(41, 253, 'Montana', 'MT', '', 1),
(42, 253, 'Nebraska', 'NE', '', 1),
(43, 253, 'Nevada', 'NV', '', 1),
(44, 253, 'New Hampshire', 'NH', '', 1),
(45, 253, 'New Jersey', 'NJ', '', 1),
(46, 253, 'New Mexico', 'NM', '', 1),
(47, 253, 'New York', 'NY', '', 1),
(48, 253, 'North Carolina', 'NC', '', 1),
(49, 253, 'North Dakota', 'ND', '', 1),
(50, 253, 'Northern Mariana Islands', 'MP', '', 1),
(51, 253, 'Oklahoma', 'OK', '', 1),
(52, 253, 'Oregon', 'OR', '', 1),
(53, 253, 'Palau', 'PW', '', 1),
(54, 253, 'Pennsylvania', 'PA', '', 1),
(55, 253, 'Puerto Rico', 'PR', '', 1),
(56, 253, 'Rhode Island', 'RI', '', 1),
(57, 253, 'South Carolina', 'SC', '', 1),
(58, 253, 'South Dakota', 'SD', '', 1),
(59, 253, 'Texas', 'TX', '', 1),
(60, 253, 'Utah', 'UT', '', 1),
(61, 253, 'Vermont', 'VT', '', 1),
(62, 253, 'Virgin Islands', 'VI', '', 1),
(63, 253, 'Virginia', 'VA', '', 1),
(64, 253, 'Washington', 'WA', '', 1),
(65, 253, 'West Virginia', 'WV', '', 1),
(66, 253, 'Wisconsin', 'WI', '', 1),
(67, 253, 'Wyoming', 'WY', '', 1),
(68, 253, 'Armed Forces Americas', 'AA', '', 1),
(69, 253, 'Armed Forces', 'AE', '', 1),
(70, 253, 'Armed Forces Pacific', 'AP', '', 1),
(71, 0, 'Tamil Nadu', NULL, NULL, 0),
(72, 0, 'Rogaland', NULL, NULL, 0),
(73, 0, 'Aragon', NULL, NULL, 0),
(74, 0, 'Maharashtra', NULL, NULL, 0),
(75, 0, 'Bohinj', NULL, NULL, 0),
(76, 0, 'Victoria', NULL, NULL, 0),
(77, 0, 'Antwerpen', NULL, NULL, 0),
(78, 0, 'Lombardia', NULL, NULL, 0),
(79, 0, 'Moscow City', NULL, NULL, 0),
(80, 0, 'London, City of', NULL, NULL, 0),
(81, 0, 'New South Wales', NULL, NULL, 0),
(82, 0, 'Rio Grande do Sul', NULL, NULL, 0),
(83, 0, 'Sao Paulo', NULL, NULL, 0),
(84, 0, 'T''ai-pei', NULL, NULL, 0),
(85, 0, 'Lambayeque', NULL, NULL, 0),
(86, 0, 'Gujarat', NULL, NULL, 0),
(87, 0, 'Rio de Janeiro', NULL, NULL, 0),
(88, 0, 'Antioquia', NULL, NULL, 0),
(89, 0, 'Toscana', NULL, NULL, 0),
(90, 0, 'Wellington', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `temp_contacts`
--

DROP TABLE IF EXISTS `temp_contacts`;
CREATE TABLE IF NOT EXISTS `temp_contacts` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `contact_id` bigint(20) NOT NULL,
  `contact_name` varchar(100) collate utf8_unicode_ci default NULL,
  `contact_email` varchar(255) collate utf8_unicode_ci default NULL,
  `is_member` int(2) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `contact_id` (`contact_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Temporary Contact Details';

--
-- Dumping data for table `temp_contacts`
--


-- --------------------------------------------------------

--
-- Table structure for table `temp_payment_logs`
--

DROP TABLE IF EXISTS `temp_payment_logs`;
CREATE TABLE IF NOT EXISTS `temp_payment_logs` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `trans_id` bigint(20) NOT NULL,
  `payment_type` varchar(50) collate utf8_unicode_ci NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `property_user_id` bigint(20) default NULL,
  `property_id` bigint(20) default NULL,
  `quantity` int(5) default NULL,
  `payment_gateway_id` int(5) default NULL,
  `ip` varchar(100) collate utf8_unicode_ci NOT NULL,
  `amount_needed` double(10,2) NOT NULL,
  `currency_code` varchar(10) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `property_user_id` (`property_user_id`),
  KEY `property_id` (`property_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `temp_payment_logs`
--


-- --------------------------------------------------------

--
-- Table structure for table `timezones`
--

DROP TABLE IF EXISTS `timezones`;
CREATE TABLE IF NOT EXISTS `timezones` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `code` varchar(10) collate utf8_unicode_ci default NULL,
  `name` varchar(255) collate utf8_unicode_ci default NULL,
  `gmt_offset` varchar(10) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `timezones`
--

INSERT INTO `timezones` (`id`, `created`, `modified`, `code`, `name`, `gmt_offset`) VALUES
(1, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'Pacific/Ap', 'Apia', '-11:00'),
(2, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'Pacific/Mi', 'Midway', '-11:00'),
(3, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'Pacific/Ni', 'Niue', '-11:00'),
(4, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'Pacific/Pa', 'Pago Pago', '-11:00'),
(5, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'Pacific/Fa', 'Fakaofo', '-10:00'),
(6, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'Pacific/Ho', 'Hawaii Time', '-10:00'),
(7, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'Pacific/Jo', 'Johnston', '-10:00'),
(8, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'Pacific/Ra', 'Rarotonga', '-10:00'),
(9, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'Pacific/Ta', 'Tahiti', '-10:00'),
(10, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'Pacific/Ma', 'Marquesas', '-09:30'),
(11, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'America/An', 'Alaska Time', '-09:00'),
(12, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'Pacific/Ga', 'Gambier', '-09:00'),
(13, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'America/Lo', 'Pacific Time', '-08:00'),
(14, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'America/Ti', 'Pacific Time - Tijuana', '-08:00'),
(15, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'America/Va', 'Pacific Time - Vancouver', '-08:00'),
(16, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'America/Wh', 'Pacific Time - Whitehorse', '-08:00'),
(17, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'Pacific/Pi', 'Pitcairn', '-08:00'),
(18, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'America/Da', 'Mountain Time - Dawson Creek', '-07:00'),
(19, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'America/De', 'Mountain Time (America/Denver)', '-07:00'),
(20, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'America/Ed', 'Mountain Time - Edmonton', '-07:00'),
(21, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'America/He', 'Mountain Time - Hermosillo', '-07:00'),
(22, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'America/Ma', 'Mountain Time - Chihuahua, Mazatlan', '-07:00'),
(23, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'America/Ph', 'Mountain Time - Arizona', '-07:00'),
(24, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'America/Ye', 'Mountain Time - Yellowknife', '-07:00'),
(25, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'America/Be', 'Belize', '-06:00'),
(26, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'America/Ch', 'Central Time', '-06:00'),
(27, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'America/Co', 'Costa Rica', '-06:00'),
(28, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'America/El', 'El Salvador', '-06:00'),
(29, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'America/Gu', 'Guatemala', '-06:00'),
(30, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'America/Ma', 'Managua', '-06:00'),
(31, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'America/Me', 'Central Time - Mexico City', '-06:00'),
(32, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'America/Re', 'Central Time - Regina', '-06:00'),
(33, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'America/Te', 'Central Time (America/Tegucigalpa)', '-06:00'),
(34, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'America/Wi', 'Central Time - Winnipeg', '-06:00'),
(35, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'Pacific/Ea', 'Easter Island', '-06:00'),
(36, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'Pacific/Ga', 'Galapagos', '-06:00'),
(37, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'America/Bo', 'Bogota', '-05:00'),
(38, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'America/Ca', 'Cayman', '-05:00'),
(39, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'America/Gr', 'Grand Turk', '-05:00'),
(40, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'America/Gu', 'Guayaquil', '-05:00'),
(41, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'America/Ha', 'Havana', '-05:00'),
(42, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'America/Iq', 'Eastern Time - Iqaluit', '-05:00'),
(43, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'America/Ja', 'Jamaica', '-05:00'),
(44, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'America/Li', 'Lima', '-05:00'),
(45, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'America/Mo', 'Eastern Time - Montreal', '-05:00'),
(46, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'America/Na', 'Nassau', '-05:00'),
(47, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'America/Ne', 'Eastern Time', '-05:00'),
(48, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'America/Pa', 'Panama', '-05:00'),
(49, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'America/Po', 'Port-au-Prince', '-05:00'),
(50, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'America/To', 'Eastern Time - Toronto', '-05:00'),
(51, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'America/Ca', 'Caracas', '-04:30'),
(52, '2009-09-11 20:46:44', '2009-09-11 20:46:44', 'America/An', 'Anguilla', '-04:00'),
(53, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/An', 'Antigua', '-04:00'),
(54, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/Ar', 'Aruba', '-04:00'),
(55, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/As', 'Asuncion', '-04:00'),
(56, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/Ba', 'Barbados', '-04:00'),
(57, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/Bo', 'Boa Vista', '-04:00'),
(58, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/Ca', 'Campo Grande', '-04:00'),
(59, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/Cu', 'Cuiaba', '-04:00'),
(60, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/Cu', 'Curacao', '-04:00'),
(61, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/Do', 'Dominica', '-04:00'),
(62, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/Gr', 'Grenada', '-04:00'),
(63, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/Gu', 'Guadeloupe', '-04:00'),
(64, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/Gu', 'Guyana', '-04:00'),
(65, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/Ha', 'Atlantic Time - Halifax', '-04:00'),
(66, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/La', 'La Paz', '-04:00'),
(67, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/Ma', 'Manaus', '-04:00'),
(68, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/Ma', 'Martinique', '-04:00'),
(69, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/Mo', 'Montserrat', '-04:00'),
(70, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/Po', 'Port of Spain', '-04:00'),
(71, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/Po', 'Porto Velho', '-04:00'),
(72, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/Pu', 'Puerto Rico', '-04:00'),
(73, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/Ri', 'Rio Branco', '-04:00'),
(74, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/Sa', 'Santiago', '-04:00'),
(75, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/Sa', 'Santo Domingo', '-04:00'),
(76, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/St', 'St. Kitts', '-04:00'),
(77, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/St', 'St. Lucia', '-04:00'),
(78, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/St', 'St. Thomas', '-04:00'),
(79, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/St', 'St. Vincent', '-04:00'),
(80, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/Th', 'Thule', '-04:00'),
(81, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/To', 'Tortola', '-04:00'),
(82, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Antarctica', 'Palmer', '-04:00'),
(83, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Atlantic/B', 'Bermuda', '-04:00'),
(84, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Atlantic/S', 'Stanley', '-04:00'),
(85, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/St', 'Newfoundland Time - St. Johns', '-03:30'),
(86, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/Ar', 'Araguaina', '-03:00'),
(87, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/Ar', 'Buenos Aires', '-03:00'),
(88, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/Ba', 'Salvador', '-03:00'),
(89, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/Be', 'Belem', '-03:00'),
(90, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/Ca', 'Cayenne', '-03:00'),
(91, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/Fo', 'Fortaleza', '-03:00'),
(92, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/Go', 'Godthab', '-03:00'),
(93, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/Ma', 'Maceio', '-03:00'),
(94, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/Mi', 'Miquelon', '-03:00'),
(95, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/Mo', 'Montevideo', '-03:00'),
(96, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/Pa', 'Paramaribo', '-03:00'),
(97, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/Re', 'Recife', '-03:00'),
(98, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/Sa', 'Sao Paulo', '-03:00'),
(99, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Antarctica', 'Rothera', '-03:00'),
(100, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/No', 'Noronha', '-02:00'),
(101, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Atlantic/S', 'South Georgia', '-02:00'),
(102, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/Sc', 'Scoresbysund', '-01:00'),
(103, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Atlantic/A', 'Azores', '-01:00'),
(104, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Atlantic/C', 'Cape Verde', '-01:00'),
(105, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Africa/Abi', 'Abidjan', '+00:00'),
(106, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Africa/Acc', 'Accra', '+00:00'),
(107, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Africa/Bam', 'Bamako', '+00:00'),
(108, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Africa/Ban', 'Banjul', '+00:00'),
(109, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Africa/Bis', 'Bissau', '+00:00'),
(110, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Africa/Cas', 'Casablanca', '+00:00'),
(111, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Africa/Con', 'Conakry', '+00:00'),
(112, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Africa/Dak', 'Dakar', '+00:00'),
(113, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Africa/El_', 'El Aaiun', '+00:00'),
(114, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Africa/Fre', 'Freetown', '+00:00'),
(115, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Africa/Lom', 'Lome', '+00:00'),
(116, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Africa/Mon', 'Monrovia', '+00:00'),
(117, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Africa/Nou', 'Nouakchott', '+00:00'),
(118, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Africa/Oua', 'Ouagadougou', '+00:00'),
(119, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Africa/Sao', 'Sao Tome', '+00:00'),
(120, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'America/Da', 'Danmarkshavn', '+00:00'),
(121, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Atlantic/C', 'Canary Islands', '+00:00'),
(122, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Atlantic/F', 'Faeroe', '+00:00'),
(123, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Atlantic/R', 'Reykjavik', '+00:00'),
(124, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Atlantic/S', 'St Helena', '+00:00'),
(125, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Etc/GMT', 'GMT (no daylight saving)', '+00:00'),
(126, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Europe/Dub', 'Dublin', '+00:00'),
(127, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Europe/Lis', 'Lisbon', '+00:00'),
(128, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Europe/Lon', 'London', '+00:00'),
(129, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Africa/Alg', 'Algiers', '+01:00'),
(130, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Africa/Ban', 'Bangui', '+01:00'),
(131, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Africa/Bra', 'Brazzaville', '+01:00'),
(132, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Africa/Ceu', 'Ceuta', '+01:00'),
(133, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Africa/Dou', 'Douala', '+01:00'),
(134, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Africa/Kin', 'Kinshasa', '+01:00'),
(135, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Africa/Lag', 'Lagos', '+01:00'),
(136, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Africa/Lib', 'Libreville', '+01:00'),
(137, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Africa/Lua', 'Luanda', '+01:00'),
(138, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Africa/Mal', 'Malabo', '+01:00'),
(139, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Africa/Ndj', 'Ndjamena', '+01:00'),
(140, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Africa/Nia', 'Niamey', '+01:00'),
(141, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Africa/Por', 'Porto-Novo', '+01:00'),
(142, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Africa/Tun', 'Tunis', '+01:00'),
(143, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Africa/Win', 'Windhoek', '+01:00'),
(144, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Europe/Ams', 'Amsterdam', '+01:00'),
(145, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Europe/And', 'Andorra', '+01:00'),
(146, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Europe/Bel', 'Central European Time (Europe/Belgrade)', '+01:00'),
(147, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Europe/Ber', 'Berlin', '+01:00'),
(148, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Europe/Bru', 'Brussels', '+01:00'),
(149, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Europe/Bud', 'Budapest', '+01:00'),
(150, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Europe/Cop', 'Copenhagen', '+01:00'),
(151, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Europe/Gib', 'Gibraltar', '+01:00'),
(152, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Europe/Lux', 'Luxembourg', '+01:00'),
(153, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Europe/Mad', 'Madrid', '+01:00'),
(154, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Europe/Mal', 'Malta', '+01:00'),
(155, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Europe/Mon', 'Monaco', '+01:00'),
(156, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Europe/Osl', 'Oslo', '+01:00'),
(157, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Europe/Par', 'Paris', '+01:00'),
(158, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Europe/Pra', 'Central European Time (Europe/Prague)', '+01:00'),
(159, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Europe/Rom', 'Rome', '+01:00'),
(160, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Europe/Sto', 'Stockholm', '+01:00'),
(161, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Europe/Tir', 'Tirane', '+01:00'),
(162, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Europe/Vad', 'Vaduz', '+01:00'),
(163, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Europe/Vie', 'Vienna', '+01:00'),
(164, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Europe/War', 'Warsaw', '+01:00'),
(165, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Europe/Zur', 'Zurich', '+01:00'),
(166, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Africa/Bla', 'Blantyre', '+02:00'),
(167, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Africa/Buj', 'Bujumbura', '+02:00'),
(168, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Africa/Cai', 'Cairo', '+02:00'),
(169, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Africa/Gab', 'Gaborone', '+02:00'),
(170, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Africa/Har', 'Harare', '+02:00'),
(171, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Africa/Joh', 'Johannesburg', '+02:00'),
(172, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Africa/Kig', 'Kigali', '+02:00'),
(173, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Africa/Lub', 'Lubumbashi', '+02:00'),
(174, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Africa/Lus', 'Lusaka', '+02:00'),
(175, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Africa/Map', 'Maputo', '+02:00'),
(176, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Africa/Mas', 'Maseru', '+02:00'),
(177, '2009-09-11 20:46:45', '2009-09-11 20:46:45', 'Africa/Mba', 'Mbabane', '+02:00'),
(178, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Africa/Tri', 'Tripoli', '+02:00'),
(179, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Amman', 'Amman', '+02:00'),
(180, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Beiru', 'Beirut', '+02:00'),
(181, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Damas', 'Damascus', '+02:00'),
(182, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Gaza', 'Gaza', '+02:00'),
(183, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Jerus', 'Jerusalem', '+02:00'),
(184, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Nicos', 'Nicosia', '+02:00'),
(185, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Europe/Ath', 'Athens', '+02:00'),
(186, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Europe/Buc', 'Bucharest', '+02:00'),
(187, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Europe/Chi', 'Chisinau', '+02:00'),
(188, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Europe/Hel', 'Helsinki', '+02:00'),
(189, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Europe/Ist', 'Istanbul', '+02:00'),
(190, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Europe/Kal', 'Moscow-01 - Kaliningrad', '+02:00'),
(191, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Europe/Kie', 'Kiev', '+02:00'),
(192, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Europe/Min', 'Minsk', '+02:00'),
(193, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Europe/Rig', 'Riga', '+02:00'),
(194, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Europe/Sof', 'Sofia', '+02:00'),
(195, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Europe/Tal', 'Tallinn', '+02:00'),
(196, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Europe/Vil', 'Vilnius', '+02:00'),
(197, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Africa/Add', 'Addis Ababa', '+03:00'),
(198, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Africa/Asm', 'Asmera', '+03:00'),
(199, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Africa/Dar', 'Dar es Salaam', '+03:00'),
(200, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Africa/Dji', 'Djibouti', '+03:00'),
(201, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Africa/Kam', 'Kampala', '+03:00'),
(202, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Africa/Kha', 'Khartoum', '+03:00'),
(203, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Africa/Mog', 'Mogadishu', '+03:00'),
(204, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Africa/Nai', 'Nairobi', '+03:00'),
(205, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Antarctica', 'Syowa', '+03:00'),
(206, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Aden', 'Aden', '+03:00'),
(207, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Baghd', 'Baghdad', '+03:00'),
(208, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Bahra', 'Bahrain', '+03:00'),
(209, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Kuwai', 'Kuwait', '+03:00'),
(210, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Qatar', 'Qatar', '+03:00'),
(211, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Riyad', 'Riyadh', '+03:00'),
(212, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Europe/Mos', 'Moscow+00', '+03:00'),
(213, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Indian/Ant', 'Antananarivo', '+03:00'),
(214, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Indian/Com', 'Comoro', '+03:00'),
(215, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Indian/May', 'Mayotte', '+03:00'),
(216, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Tehra', 'Tehran', '+03:30'),
(217, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Baku', 'Baku', '+04:00'),
(218, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Dubai', 'Dubai', '+04:00'),
(219, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Musca', 'Muscat', '+04:00'),
(220, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Tbili', 'Tbilisi', '+04:00'),
(221, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Yerev', 'Yerevan', '+04:00'),
(222, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Europe/Sam', 'Moscow+01 - Samara', '+04:00'),
(223, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Indian/Mah', 'Mahe', '+04:00'),
(224, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Indian/Mau', 'Mauritius', '+04:00'),
(225, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Indian/Reu', 'Reunion', '+04:00'),
(226, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Kabul', 'Kabul', '+04:30'),
(227, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Aqtau', 'Aqtau', '+05:00'),
(228, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Aqtob', 'Aqtobe', '+05:00'),
(229, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Ashga', 'Ashgabat', '+05:00'),
(230, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Dusha', 'Dushanbe', '+05:00'),
(231, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Karac', 'Karachi', '+05:00'),
(232, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Tashk', 'Tashkent', '+05:00'),
(233, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Yekat', 'Moscow+02 - Yekaterinburg', '+05:00'),
(234, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Indian/Ker', 'Kerguelen', '+05:00'),
(235, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Indian/Mal', 'Maldives', '+05:00'),
(236, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Calcu', 'India Standard Time', '+05:30'),
(237, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Colom', 'Colombo', '+05:30'),
(238, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Katma', 'Katmandu', '+05:45'),
(239, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Antarctica', 'Mawson', '+06:00'),
(240, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Antarctica', 'Vostok', '+06:00'),
(241, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Almat', 'Almaty', '+06:00'),
(242, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Bishk', 'Bishkek', '+06:00'),
(243, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Dhaka', 'Dhaka', '+06:00'),
(244, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Omsk', 'Moscow+03 - Omsk, Novosibirsk', '+06:00'),
(245, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Thimp', 'Thimphu', '+06:00'),
(246, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Indian/Cha', 'Chagos', '+06:00'),
(247, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Rango', 'Rangoon', '+06:30'),
(248, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Indian/Coc', 'Cocos', '+06:30'),
(249, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Antarctica', 'Davis', '+07:00'),
(250, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Bangk', 'Bangkok', '+07:00'),
(251, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Hovd', 'Hovd', '+07:00'),
(252, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Jakar', 'Jakarta', '+07:00'),
(253, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Krasn', 'Moscow+04 - Krasnoyarsk', '+07:00'),
(254, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Phnom', 'Phnom Penh', '+07:00'),
(255, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Saigo', 'Hanoi', '+07:00'),
(256, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Vient', 'Vientiane', '+07:00'),
(257, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Indian/Chr', 'Christmas', '+07:00'),
(258, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Antarctica', 'Casey', '+08:00'),
(259, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Brune', 'Brunei', '+08:00'),
(260, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Choib', 'Choibalsan', '+08:00'),
(261, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Hong_', 'Hong Kong', '+08:00'),
(262, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Irkut', 'Moscow+05 - Irkutsk', '+08:00'),
(263, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Kuala', 'Kuala Lumpur', '+08:00'),
(264, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Macau', 'Macau', '+08:00'),
(265, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Makas', 'Makassar', '+08:00'),
(266, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Manil', 'Manila', '+08:00'),
(267, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Shang', 'China Time - Beijing', '+08:00'),
(268, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Singa', 'Singapore', '+08:00'),
(269, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Taipe', 'Taipei', '+08:00'),
(270, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Ulaan', 'Ulaanbaatar', '+08:00'),
(271, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Australia/', 'Western Time - Perth', '+08:00'),
(272, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Dili', 'Dili', '+09:00'),
(273, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Jayap', 'Jayapura', '+09:00'),
(274, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Pyong', 'Pyongyang', '+09:00'),
(275, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Seoul', 'Seoul', '+09:00'),
(276, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Tokyo', 'Tokyo', '+09:00'),
(277, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Yakut', 'Moscow+06 - Yakutsk', '+09:00'),
(278, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Pacific/Pa', 'Palau', '+09:00'),
(279, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Australia/', 'Central Time - Adelaide', '+09:30'),
(280, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Australia/', 'Central Time - Darwin', '+09:30'),
(281, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Antarctica', 'Dumont D''Urville', '+10:00'),
(282, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Vladi', 'Moscow+07 - Yuzhno-Sakhalinsk', '+10:00'),
(283, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Australia/', 'Eastern Time - Brisbane', '+10:00'),
(284, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Australia/', 'Eastern Time - Hobart', '+10:00'),
(285, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Australia/', 'Eastern Time - Melbourne, Sydney', '+10:00'),
(286, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Pacific/Gu', 'Guam', '+10:00'),
(287, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Pacific/Po', 'Port Moresby', '+10:00'),
(288, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Pacific/Sa', 'Saipan', '+10:00'),
(289, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Pacific/Tr', 'Truk', '+10:00'),
(290, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Magad', 'Moscow+08 - Magadan', '+11:00'),
(291, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Pacific/Ef', 'Efate', '+11:00'),
(292, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Pacific/Gu', 'Guadalcanal', '+11:00'),
(293, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Pacific/Ko', 'Kosrae', '+11:00'),
(294, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Pacific/No', 'Noumea', '+11:00'),
(295, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Pacific/Po', 'Ponape', '+11:00'),
(296, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Pacific/No', 'Norfolk', '+11:30'),
(297, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Asia/Kamch', 'Moscow+09 - Petropavlovsk-Kamchatskiy', '+12:00'),
(298, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Pacific/Au', 'Auckland', '+12:00'),
(299, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Pacific/Fi', 'Fiji', '+12:00'),
(300, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Pacific/Fu', 'Funafuti', '+12:00'),
(301, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Pacific/Kw', 'Kwajalein', '+12:00'),
(302, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Pacific/Ma', 'Majuro', '+12:00'),
(303, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Pacific/Na', 'Nauru', '+12:00'),
(304, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Pacific/Ta', 'Tarawa', '+12:00'),
(305, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Pacific/Wa', 'Wake', '+12:00'),
(306, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Pacific/Wa', 'Wallis', '+12:00'),
(307, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Pacific/En', 'Enderbury', '+13:00'),
(308, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Pacific/To', 'Tongatapu', '+13:00'),
(309, '2009-09-11 20:46:46', '2009-09-11 20:46:46', 'Pacific/Ki', 'Kiritimati', '+14:00');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `foreign_id` bigint(20) NOT NULL,
  `class` varchar(25) collate utf8_unicode_ci default NULL,
  `transaction_type_id` bigint(20) default NULL,
  `amount` double(10,2) NOT NULL,
  `description` text collate utf8_unicode_ci,
  `payment_gateway_id` bigint(20) default NULL,
  `gateway_fees` double(10,2) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `transaction_type_id` (`transaction_type_id`),
  KEY `payment_gateway_id` (`payment_gateway_id`),
  KEY `foreign_id` (`foreign_id`),
  KEY `class` (`class`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `transactions`
--


-- --------------------------------------------------------

--
-- Table structure for table `transaction_types`
--

DROP TABLE IF EXISTS `transaction_types`;
CREATE TABLE IF NOT EXISTS `transaction_types` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci default NULL,
  `is_credit` tinyint(1) default '0',
  `message` text collate utf8_unicode_ci,
  `message_for_admin` varchar(255) collate utf8_unicode_ci NOT NULL,
  `transaction_variables` text collate utf8_unicode_ci,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `transaction_types`
--

INSERT INTO `transaction_types` (`id`, `created`, `modified`, `name`, `is_credit`, `message`, `message_for_admin`, `transaction_variables`) VALUES
(1, '2010-03-04 10:17:05', '2010-03-04 10:17:05', 'Amount added to\r\nwallet ', 1, 'Amount added to wallet ', '##USER## added amount to his wallet.', NULL),
(2, '2010-03-04 10:17:14', '2010-09-09 07:15:41', 'Booked a new\r\nproperty', 0, '##TRAVELER## booking a property ##PROPERTY## for ##PROPERTY_AMOUNT## ##SECURITY_DEPOSIT##, booking# ##ORDER_NO##', '##USER## booked a property ##PROPERTY##, booking# ###ORDER_NO##', 'TRAVELER, PROPERTY, PROPERTY_AMOUNT, ORDER_NO, SECURITY_DEPOSIT'),
(4, '2010-03-04 10:17:14', '2010-03-04 10:17:16', 'Withdrawn amount from wallet', 0, 'Withdraw request has been made by user, ##USER##', '', 'USER '),
(5, '2010-03-04 10:19:09', '2010-03-04 10:19:14', 'Refund for rejected property', 1, 'Booking# ###ORDER_NO## rejected. Amount refunded to ##TRAVELER## for booking the property ##PROPERTY##', '', 'TRAVELER, PROPERTY, ORDER_NO'),
(6, '2010-03-04 10:19:34', '2010-03-04 10:19:37', 'Refund for canceled property', 1, 'Booking# ###ORDER_NO## canceled. Amount refunded to ##TRAVELER## for booking the property ##PROPERTY##', '', 'TRAVELER, PROPERTY_AMOUNT, PROPERTY, ORDER_NO, SECURITY_DEPOSIT'),
(7, '2010-03-04 10:20:11', '2010-03-04 10:20:14', 'Paid cash withdraw\r\nrequest amount to user', 0, 'Withdraw request has been succesfully made and paid to your money transfer account', 'Withdraw request for ##USER## was succesfully and paid to his money transfer account', 'USER'),
(8, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Amount transferred to host', 1, '##HOSTER## received amount ##PROPERTY_RECEIVED_AMOUNT## for the ##PROPERTY##, booking# ##ORDER_NO##', '', 'HOSTER, PROPERTY_RECIEVED_AMOUNT, PROPERTY,ORDER_NO'),
(9, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Host amount cleared', 1, '##HOSTER## amount gets cleared for the property ##PROPERTY##, booking# ##ORDER_NO##', '', 'HOSTER, PROPERTY, ORDER_NO'),
(10, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Host deducted for rejected property', 0, 'Booking# ###ORDER_NO## rejected. Amount refunded to traveler for the property ##PROPERTY##', '', 'ORDER_NO, HOSTER, PROPERTY'),
(11, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Host deducted for canceled property', 0, 'Booking# ###ORDER_NO## canceled. Amount deducted from ##HOSTER## for booking the property ##PROPERTY##', '', 'ORDER_NO, HOSTER, PROPERTY'),
(14, '2010-07-12 11:40:11', '2010-07-12 11:40:11', 'Canceled by admin and refunded to traveler', 1, 'Booking# ###ORDER_NO## canceled by admin. Amount refunded to ##TRAVELER## for booking the property ##PROPERTY##', '', 'TRAVELER, PROPERTY_AMOUNT, PROPERTY,\r\nORDER_NO'),
(15, '2010-07-12 11:39:17', '2010-07-12 11:39:20', 'Refund for expired property', 1, 'Booking# ###ORDER_NO## expired. Amount refunded to ##TRAVELER## for booking the property ##PROPERTY##', '', 'TRAVELER, PROPERTY, ORDER_NO'),
(16, '2010-07-12 11:40:11', '2010-07-12 11:40:13', 'Deducted for expired property', 0, 'Booking# ##ORDER_NO## expired. Amount deducted from ##HOSTER## for the property ##PROPERTY##.', '', 'HOSTER, PROPERTY, ORDER_NO'),
(17, '2010-07-12 11:40:11', '2010-07-12 11:40:11', 'Canceled by admin and deducted from host', 0, 'Booking# ##ORDER_NO## canceled by admin. Amount deducted from ##HOSTER## for the property ##PROPERTY##', '', 'ORDER_NO, HOSTER, PROPERTY'),
(18, '2010-08-17 14:31:48', '2010-08-17 14:31:48', 'user cash withdrawal request', 0, 'Cash withdrawal request made', 'Cash withdrawal request made by ##HOSTER##', 'HOSTER'),
(19, '2010-08-17 14:31:48', '2010-08-17 14:31:48', 'Admin approved withdrawal request', 0, 'You (administrator) have approved the withdrawal request for ##HOSTER##', '', 'HOSTER'),
(20, '2010-08-17 14:31:48', '2010-08-17 14:31:48', 'Admin rejected withdrawal request', 0, 'Withdrawal request rejected for ##HOSTER##', '', 'HOSTER'),
(21, '2010-08-17 14:31:48', '2010-08-17 14:31:48', 'Failed withdrawal request', 0, 'Withdrawal request failed. Your requested amount has been refunded to your wallet.', 'Withdrawal request has been failed. Amount refunded to ##HOSTER##', 'HOSTER'),
(24, '2010-08-17 14:31:48', '2010-08-17 14:31:48', 'Withdrawal request approved for user by admin', 0, 'Withdrawal request approved', 'Withdrawal request approved for ##HOSTER##', 'HOSTER'),
(23, '2010-08-17 14:31:48', '2010-08-17 14:31:48', 'Amount refunded for rejected withdrawal request', 1, 'Administrator have rejected the withdrawal request. Your requested amount has been refunded to your wallet.', 'Amount refunded to ##HOSTER## for rejected withdrawal request', 'HOSTER'),
(25, '2010-08-17 14:31:48', '2010-08-17 14:31:48', 'Failed withdrawal request and refunded to user', 1, 'Withdrawal request failed. Your requested amount has been refunded to your wallet.', 'Withdrawal request has been failed. Amount refunded to ##HOSTER##.', 'HOSTER'),
(26, '2010-09-23 18:48:00', '2010-09-23 18:47:58', 'Send Money to user', 1, 'Admin send money to your account.', 'You (administrator) send money to ##USER## account', NULL),
(28, '2010-08-17 14:31:48', '2010-08-17 14:31:48', 'User affiliate commission withdrawal request', 0, 'Affiliate commission amount withdrawal\r\nrequest made by ##AFFILIATE_USER##', '', 'AFFILIATE_USER'),
(29, '2010-08-17 14:31:48', '2010-08-17 14:31:48', 'Admin approved affiliate withdrawal request', 0, 'Affiliate withdrawal request has been approved', 'Affiliate withdrawal request approved for ##AFFILIATE_USER##', 'AFFILIATE_USER'),
(30, '2010-08-17 14:31:48', '2010-08-17 14:31:48', 'Admin rejected affiliate withdrawal request', 0, 'Administrator have rejected the affiliate withdrawal request. Your requested amount has been refunded to your affiliate commission amount', 'You (administrator) have rejected the affiliate withdrawal request for ##AFFILIATE_USER##', 'AFFILIATE_USER'),
(31, '2010-08-17 14:31:48', '2010-08-17 14:31:48', 'Failed affiliate withdrawal request', 0, 'Affiliate withdrawal request failed. Your requested amount has been refunded to your affiliate commission amount.', 'Affiliate withdrawal request has been failed. Amount refunded to ##AFFILIATE_USER##', 'AFFILIATE_USER'),
(32, '2010-08-17 14:31:48', '2010-08-17 14:31:48', 'Admin approved affiliate withdrawal request', 0, 'Affiliate commission withdrawal request has been approved', 'Affiliate commission withdrawal request approved for ##AFFILIATE_USER##', 'AFFILIATE_USER'),
(33, '2010-08-17 14:31:48', '2010-08-17 14:31:48', 'Affiliate commission amount refunded for rejected withdrawal request', 1, 'Administrator have rejected the affiliate withdrawal request. Your requested amount has been refunded to your affiliate commission amount.', 'You (administrator) have rejected the affiliate withdrawal request for ##AFFILIATE_USER##', 'AFFILIATE_USER'),
(34, '2010-08-17 14:31:48', '2010-08-17 14:31:48', 'Failed withdrawal request and refunded to user', 1, 'Withdrawal request failed for user ##AFFILIATE_USER##', '', 'AFFILIATE_USER'),
(35, '2010-03-04 10:17:14', '2010-03-04 10:17:16', 'Withdrawn amount from Affiliate', 0, 'Cash affiliate withdrawal request made', 'Affiliate Withdraw request has been made by user ##AFFILIATE_USER##', 'AFFILIATE_USER'),
(36, '2010-03-04 10:20:11', '2010-03-04 10:20:14', 'Paid cash withdraw request amount to user', 0, 'Cash withdraw request made by user ##AFFILIATE_USER## has been accepted.', '', 'AFFILIATE_USER'),
(37, '2010-03-04 10:20:11', '2010-03-04 10:20:14', 'Property listing fee', 0, 'Listing fee paid for new property ##PROPERTY##', '##HOSTER## paid listing fee for new property ##PROPERTY##', 'PROPERTY'),
(38, '2010-03-04 10:20:11', '2010-03-04 10:20:14', 'Property verify fee', 0, 'Verification fee paid for property ##PROPERTY##', '##HOSTER## paid verification fee for property ##PROPERTY##', 'PROPERTY'),
(39, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Membership Fee', 0, 'Membership fee paid', 'Membership fee paid by ##HOSTER##', ''),
(40, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Deposit Amount Credited ', 1, 'Booking# ##ORDER_NO## dispute resolved favor to you. Security deposit amount credited to your account for property ##PROPERTY##.', 'Booking# ##ORDER_NO## dispute resolved favor to ##HOSTER##. Security deposit amount credited to ##HOSTER## account for property ##PROPERTY##.', 'PROPERTY, ORDER_NO'),
(41, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Deposit Amount Refunded', 1, 'Booking# ##ORDER_NO## dispute resolved favor to you. Security deposit amount refunded to your account for property ##PROPERTY##.', 'Booking# ##ORDER_NO## dispute resolved favor to ##TRAVELER##. Security deposit amount refunded to ##TRAVELER## account for property ##PROPERTY##.', 'PROPERTY, ORDER_NO'),
(42, '2010-07-12 11:40:11', '2010-07-12 11:40:11', 'Canceled by admin and refunded to traveler', 1, 'Booking# ##ORDER_NO## dispute canceled by admin. Amount refunded to your account after deduction of dispute cancellation percentage for property ##PROPERTY##.', 'Booking# ##ORDER_NO## dispute canceled by admin. Amount refunded to ##TRAVELER## account after deduction of dispute cancellation percentage for property ##PROPERTY##.', 'TRAVELER, PROPERTY_AMOUNT, PROPERTY,\r\nORDER_NO');

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

DROP TABLE IF EXISTS `translations`;
CREATE TABLE IF NOT EXISTS `translations` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `language_id` bigint(20) NOT NULL,
  `key` text character set utf8 collate utf8_unicode_ci NOT NULL,
  `lang_text` text character set utf8 collate utf8_unicode_ci NOT NULL,
  `is_translated` tinyint(1) NOT NULL,
  `is_google_translate` tinyint(1) NOT NULL,
  `is_verified` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `translations`
--

INSERT INTO `translations` (`id`, `created`, `modified`, `language_id`, `key`, `lang_text`, `is_translated`, `is_google_translate`, `is_verified`) VALUES
(1, '2012-01-11 17:04:21', '2012-01-11 17:04:21', 42, 'Are you sure you want to ', 'Are you sure you want to ', 0, 0, 0),
(2, '2012-01-11 17:04:21', '2012-01-11 17:04:21', 42, 'Please select atleast one record!', 'Please select atleast one record!', 0, 0, 0),
(3, '2012-01-11 17:04:21', '2012-01-11 17:04:21', 42, 'Are you sure you want to do this action?', 'Are you sure you want to do this action?', 0, 0, 0),
(4, '2012-01-11 17:04:21', '2012-01-11 17:04:21', 42, 'Please enter valid original price.', 'Please enter valid original price.', 0, 0, 0),
(5, '2012-01-11 17:04:21', '2012-01-11 17:04:21', 42, 'Discount percentage should be less than 100.', 'Discount percentage should be less than 100.', 0, 0, 0),
(6, '2012-01-11 17:04:21', '2012-01-11 17:04:21', 42, 'Discount amount should be less than original price.', 'Discount amount should be less than original price.', 0, 0, 0),
(7, '2012-01-11 17:04:21', '2012-01-11 17:04:21', 42, 'Are you sure do you want to change the status? Once the status is changed you cannot undo the status.', 'Are you sure do you want to change the status? Once the status is changed you cannot undo the status.', 0, 0, 0),
(8, '2012-01-11 17:04:21', '2012-01-11 17:04:21', 42, 'By clicking this button you are confirming your payment via wallet. Once you confirmed amount will be deducted from your wallet and you cannot undo this process. Are you sure you want to confirm this action?', 'By clicking this button you are confirming your payment via wallet. Once you confirmed amount will be deducted from your wallet and you cannot undo this process. Are you sure you want to confirm this action?', 0, 0, 0),
(9, '2012-01-11 17:04:21', '2012-01-11 17:04:21', 42, 'You don''t have sufficent amount in wallet to continue this process. So please select any other payment gateway.', 'You don''t have sufficent amount in wallet to continue this process. So please select any other payment gateway.', 0, 0, 0),
(10, '2012-01-11 17:04:21', '2012-01-11 17:04:21', 42, 'Google map could not find your location, please enter known location to google', 'Google map could not find your location, please enter known location to google', 0, 0, 0),
(11, '2012-01-11 17:04:21', '2012-01-11 17:04:21', 42, 'Invalid extension, Only csv, txt are allowed', 'Invalid extension, Only csv, txt are allowed', 0, 0, 0),
(12, '2012-01-11 17:04:21', '2012-01-11 17:04:21', 42, 'No Flickr Photos Available', 'No Flickr Photos Available', 0, 0, 0),
(13, '2012-01-11 17:04:21', '2012-01-11 17:04:21', 42, 'Current', 'Current', 0, 0, 0),
(14, '2012-01-11 17:04:21', '2012-01-11 17:04:21', 42, 'No Date Set', 'No Date Set', 0, 0, 0),
(15, '2012-01-11 17:04:21', '2012-01-11 17:04:21', 42, 'No Time Set', 'No Time Set', 0, 0, 0),
(16, '2012-01-11 17:04:21', '2012-01-11 17:04:21', 42, 'Select check-in date in calendar', 'Select check-in date in calendar', 0, 0, 0),
(17, '2012-01-11 17:04:21', '2012-01-11 17:04:21', 42, 'Select check-out date in calendar', 'Select check-out date in calendar', 0, 0, 0),
(18, '2012-01-11 17:04:21', '2012-01-11 17:04:21', 42, 'I am done reordering', 'I am done reordering', 0, 0, 0),
(19, '2012-01-11 17:04:21', '2012-01-11 17:04:21', 42, 'Reorder', 'Reorder', 0, 0, 0),
(20, '2012-01-11 17:04:21', '2012-01-11 17:04:21', 42, 'You can check \\"Availablity\\" in property page', 'You can check \\"Availablity\\" in property page', 0, 0, 0),
(21, '2012-01-11 17:04:21', '2012-01-11 17:04:21', 42, 'You can check \\"Facilities\\" in property page', 'You can check \\"Facilities\\" in property page', 0, 0, 0),
(22, '2012-01-11 17:04:21', '2012-01-11 17:04:21', 42, 'You can check \\"Pricing\\" details in property page, also you can do price discussion.', 'You can check \\"Pricing\\" details in property page, also you can do price discussion.', 0, 0, 0),
(23, '2012-01-11 17:04:21', '2012-01-11 17:04:21', 42, 'You can check \\"Pricing\\" details in property page, also price is fixed. Negotiation is not possible.', 'You can check \\"Pricing\\" details in property page, also price is fixed. Negotiation is not possible.', 0, 0, 0),
(24, '2012-01-11 17:04:21', '2012-01-11 17:04:21', 42, 'Are you sure you want to', 'Are you sure you want to', 0, 0, 0),
(25, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Are you sure you want to cancel this booking?', 'Are you sure you want to cancel this booking?', 0, 0, 0),
(26, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Are you sure confirm this action?', 'Are you sure confirm this action?', 0, 0, 0),
(27, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Are you sure you want to confirm this booking?', 'Are you sure you want to confirm this booking?', 0, 0, 0),
(28, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Are you sure you want to reject this booking?', 'Are you sure you want to reject this booking?', 0, 0, 0),
(29, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Sorry. We have disabled this action in demo mode', 'Sorry. We have disabled this action in demo mode', 0, 0, 0),
(30, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Invalid request', 'Invalid request', 0, 0, 0),
(31, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Maintenance Mode', 'Maintenance Mode', 0, 0, 0),
(32, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Authorisation Required', 'Authorisation Required', 0, 0, 0),
(33, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Sorry, login failed.  Either your %s or password are incorrect or admin deactivated your account.', 'Sorry, login failed.  Either your %s or password are incorrect or admin deactivated your account.', 0, 0, 0),
(34, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'with security deposit amount', 'with security deposit amount', 0, 0, 0),
(35, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Show in home page deactivated successfully', 'Show in home page deactivated successfully', 0, 0, 0),
(36, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Show in home page activated successfully', 'Show in home page activated successfully', 0, 0, 0),
(37, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Featured deactivated successfully', 'Featured deactivated successfully', 0, 0, 0),
(38, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Featured activated successfully', 'Featured activated successfully', 0, 0, 0),
(39, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'User blocked successfully', 'User blocked successfully', 0, 0, 0),
(40, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'User activated successfully', 'User activated successfully', 0, 0, 0),
(41, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'suspended successfully', 'suspended successfully', 0, 0, 0),
(42, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'unsuspended successfully', 'unsuspended successfully', 0, 0, 0),
(43, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'flagged successfully', 'flagged successfully', 0, 0, 0),
(44, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'flag cleared successfully', 'flag cleared successfully', 0, 0, 0),
(45, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'verified successfully', 'verified successfully', 0, 0, 0),
(46, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'unverified successfully', 'unverified successfully', 0, 0, 0),
(47, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'disapproved successfully', 'disapproved successfully', 0, 0, 0),
(48, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Your property has been activated', 'Your property has been activated', 0, 0, 0),
(49, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'approved successfully', 'approved successfully', 0, 0, 0),
(50, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Message flagged successfully', 'Message flagged successfully', 0, 0, 0),
(51, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Message flag cleared successfully', 'Message flag cleared successfully', 0, 0, 0),
(52, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Checked records has been disabled', 'Checked records has been disabled', 0, 0, 0),
(53, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Checked records has been enabled', 'Checked records has been enabled', 0, 0, 0),
(54, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Checked records has been disapproved', 'Checked records has been disapproved', 0, 0, 0),
(55, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Checked records has been approved', 'Checked records has been approved', 0, 0, 0),
(56, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Checked records has been Suspended', 'Checked records has been Suspended', 0, 0, 0),
(57, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Checked records has been changed to Unsuspended', 'Checked records has been changed to Unsuspended', 0, 0, 0),
(58, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Checked records has been changed to Unflagged', 'Checked records has been changed to Unflagged', 0, 0, 0),
(59, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Checked records has been changed to flagged', 'Checked records has been changed to flagged', 0, 0, 0),
(60, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Checked records has been deleted. Some records are not deleted due to properties was assigned to the cancellation policy.', 'Checked records has been deleted. Some records are not deleted due to properties was assigned to the cancellation policy.', 0, 0, 0),
(61, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'No records deleted. Some properties was assigned to the cancellation policy.', 'No records deleted. Some properties was assigned to the cancellation policy.', 0, 0, 0),
(62, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Checked records has been deleted', 'Checked records has been deleted', 0, 0, 0),
(63, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, ' has been disabled', ' has been disabled', 0, 0, 0),
(64, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, ' has been enabled', ' has been enabled', 0, 0, 0),
(65, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, ' has been sent for verified', ' has been sent for verified', 0, 0, 0),
(66, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, ' has been deleted', ' has been deleted', 0, 0, 0),
(67, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Booking status updated', 'Booking status updated', 0, 0, 0),
(68, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Unknown Application', 'Unknown Application', 0, 0, 0),
(69, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Invalid App key', 'Invalid App key', 0, 0, 0),
(70, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Sorry, login failed.  Your %s or password are incorrect', 'Sorry, login failed.  Your %s or password are incorrect', 0, 0, 0),
(71, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Not Rated Yet', 'Not Rated Yet', 0, 0, 0),
(72, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Positive', 'Positive', 0, 0, 0),
(73, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Negative', 'Negative', 0, 0, 0),
(74, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Adaptive Ipn Logs', 'Adaptive Ipn Logs', 0, 0, 0),
(75, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Adaptive Transaction Logs', 'Adaptive Transaction Logs', 0, 0, 0),
(76, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Adaptive Transaction Log', 'Adaptive Transaction Log', 0, 0, 0),
(77, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Mark as paid/manual', 'Mark as paid/manual', 0, 0, 0),
(78, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Affiliate Fund Withdrawal Request', 'Affiliate Fund Withdrawal Request', 0, 0, 0),
(79, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, ' - Pending', ' - Pending', 0, 0, 0),
(80, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, ' - Accepted', ' - Accepted', 0, 0, 0),
(81, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, ' - Rejected', ' - Rejected', 0, 0, 0),
(82, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, ' - Payment Failure', ' - Payment Failure', 0, 0, 0),
(83, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, ' - Paid', ' - Paid', 0, 0, 0),
(84, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, ' -  today', ' -  today', 0, 0, 0),
(85, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, ' -  in this week', ' -  in this week', 0, 0, 0),
(86, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, ' -  in this month', ' -  in this month', 0, 0, 0),
(87, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Add Affiliate Cash Withdrawal', 'Add Affiliate Cash Withdrawal', 0, 0, 0),
(88, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Withdraw Fund Requests - from Affiliates', 'Withdraw Fund Requests - from Affiliates', 0, 0, 0),
(89, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, ' - Requested today', ' - Requested today', 0, 0, 0),
(90, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, ' - Requested in this week', ' - Requested in this week', 0, 0, 0),
(91, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, ' - Requested in this month', ' - Requested in this month', 0, 0, 0),
(92, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, ' - Under Process', ' - Under Process', 0, 0, 0),
(93, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, ' - Failed', ' - Failed', 0, 0, 0),
(94, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, ' - Success', ' - Success', 0, 0, 0),
(95, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Affiliate Cash Withdrawal deleted', 'Affiliate Cash Withdrawal deleted', 0, 0, 0),
(96, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Checked requests have been moved to pending status', 'Checked requests have been moved to pending status', 0, 0, 0),
(97, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Checked requests have been moved to rejected status, Amount sent back tot the users.', 'Checked requests have been moved to rejected status, Amount sent back tot the users.', 0, 0, 0),
(98, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Pay via ', 'Pay via ', 0, 0, 0),
(99, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'API', 'API', 0, 0, 0),
(100, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Withdraw Fund Requests - Approved', 'Withdraw Fund Requests - Approved', 0, 0, 0),
(101, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Manual payment process has been completed.', 'Manual payment process has been completed.', 0, 0, 0),
(102, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Mass payment request is submitted in', 'Mass payment request is submitted in', 0, 0, 0),
(103, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'User will be paid once process completed.', 'User will be paid once process completed.', 0, 0, 0),
(104, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Withdrawal has beed successfully moved to ', 'Withdrawal has beed successfully moved to ', 0, 0, 0),
(105, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Affiliate Requests', 'Affiliate Requests', 0, 0, 0),
(106, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Request Affiliate', 'Request Affiliate', 0, 0, 0),
(107, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Your request added successfully', 'Your request added successfully', 0, 0, 0),
(108, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Affiliate request could not be added. Please, try again.', 'Affiliate request could not be added. Please, try again.', 0, 0, 0),
(109, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, ' - Search - %s', ' - Search - %s', 0, 0, 0),
(110, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Add Affiliate Request', 'Add Affiliate Request', 0, 0, 0),
(111, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Affiliate request has been added', 'Affiliate request has been added', 0, 0, 0),
(112, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Edit Affiliate Request', 'Edit Affiliate Request', 0, 0, 0),
(113, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Affiliate Request has been updated', 'Affiliate Request has been updated', 0, 0, 0),
(114, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Affiliate Request could not be updated. Please, try again.', 'Affiliate Request could not be updated. Please, try again.', 0, 0, 0),
(115, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Affiliate Request deleted', 'Affiliate Request deleted', 0, 0, 0),
(116, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Checked requests has been disapproved', 'Checked requests has been disapproved', 0, 0, 0),
(117, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Checked requests has been approved', 'Checked requests has been approved', 0, 0, 0),
(118, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Checked requests has been deleted', 'Checked requests has been deleted', 0, 0, 0),
(119, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Affiliate Types', 'Affiliate Types', 0, 0, 0),
(120, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Edit Affiliate Type', 'Edit Affiliate Type', 0, 0, 0),
(121, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Affiliate Type has been updated', 'Affiliate Type has been updated', 0, 0, 0),
(122, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, ' Affiliate Type could not be updated. Please, try again.', ' Affiliate Type could not be updated. Please, try again.', 0, 0, 0),
(123, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Affiliate', 'Affiliate', 0, 0, 0),
(124, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, ' - Pipeline', ' - Pipeline', 0, 0, 0),
(125, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, ' - Completed', ' - Completed', 0, 0, 0),
(126, '2012-01-11 17:04:22', '2012-01-11 17:04:22', 42, 'Stats', 'Stats', 0, 0, 0),
(127, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Today', 'Today', 0, 0, 0),
(128, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'This week', 'This week', 0, 0, 0),
(129, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'This month', 'This month', 0, 0, 0),
(130, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Total', 'Total', 0, 0, 0),
(131, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'PipeLine', 'PipeLine', 0, 0, 0),
(132, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Completed', 'Completed', 0, 0, 0),
(133, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Affiliate Withdaw Request', 'Affiliate Withdaw Request', 0, 0, 0),
(134, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Pending', 'Pending', 0, 0, 0),
(135, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Approved', 'Approved', 0, 0, 0),
(136, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Reject', 'Reject', 0, 0, 0),
(137, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Success', 'Success', 0, 0, 0),
(138, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Fail', 'Fail', 0, 0, 0),
(139, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Affiliates', 'Affiliates', 0, 0, 0),
(140, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, ' - Referred today', ' - Referred today', 0, 0, 0),
(141, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, ' - Referred in this week', ' - Referred in this week', 0, 0, 0),
(142, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, ' - Referred in this month', ' - Referred in this month', 0, 0, 0),
(143, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, '- Pending', '- Pending', 0, 0, 0),
(144, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, '- Canceled', '- Canceled', 0, 0, 0),
(145, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, '- PipeLine', '- PipeLine', 0, 0, 0),
(146, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, '- Completed', '- Completed', 0, 0, 0),
(147, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Affiliate deleted', 'Affiliate deleted', 0, 0, 0),
(148, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Canceled', 'Canceled', 0, 0, 0),
(149, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Pipeline', 'Pipeline', 0, 0, 0),
(150, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Waiting for Approved', 'Waiting for Approved', 0, 0, 0),
(151, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Affiliate Withdaw Requests', 'Affiliate Withdaw Requests', 0, 0, 0),
(152, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Amenities', 'Amenities', 0, 0, 0),
(153, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, ' - Active', ' - Active', 0, 0, 0),
(154, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, ' - Inactive', ' - Inactive', 0, 0, 0),
(155, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Add Amenity', 'Add Amenity', 0, 0, 0),
(156, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Amenity has been added', 'Amenity has been added', 0, 0, 0),
(157, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Amenity could not be added. Please, try again.', 'Amenity could not be added. Please, try again.', 0, 0, 0),
(158, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Edit Amenity', 'Edit Amenity', 0, 0, 0),
(159, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Amenity has been updated', 'Amenity has been updated', 0, 0, 0),
(160, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Amenity could not be updated. Please, try again.', 'Amenity could not be updated. Please, try again.', 0, 0, 0),
(161, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Amenity deleted', 'Amenity deleted', 0, 0, 0),
(162, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Authorizenet Docapture Logs', 'Authorizenet Docapture Logs', 0, 0, 0),
(163, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Authorizenet Docapture Log', 'Authorizenet Docapture Log', 0, 0, 0),
(164, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Authorizenet Docapture Log deleted', 'Authorizenet Docapture Log deleted', 0, 0, 0),
(165, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Banned IPs', 'Banned IPs', 0, 0, 0),
(166, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Add Banned IP', 'Add Banned IP', 0, 0, 0),
(167, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Must be a valid URL', 'Must be a valid URL', 0, 0, 0),
(168, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Banned IP has been added', 'Banned IP has been added', 0, 0, 0),
(169, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Banned IP could not be added. Please, try again', 'Banned IP could not be added. Please, try again', 0, 0, 0),
(170, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'You cannot add your IP address. Please, try again', 'You cannot add your IP address. Please, try again', 0, 0, 0),
(171, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'You cannot add your own domain. Please, try again', 'You cannot add your own domain. Please, try again', 0, 0, 0),
(172, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Banned IP deleted', 'Banned IP deleted', 0, 0, 0),
(173, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Checked banned IPs has been deleted', 'Checked banned IPs has been deleted', 0, 0, 0),
(174, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Bed Types', 'Bed Types', 0, 0, 0),
(175, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Add Bed Type', 'Add Bed Type', 0, 0, 0),
(176, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, '\\"%s\\" Bed Type has been added', '\\"%s\\" Bed Type has been added', 0, 0, 0),
(177, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, '\\"%s\\" Bed Type could not be added. Please, try again.', '\\"%s\\" Bed Type could not be added. Please, try again.', 0, 0, 0),
(178, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Edit Bed Type', 'Edit Bed Type', 0, 0, 0),
(179, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, '\\"%s\\" Bed Type has been updated', '\\"%s\\" Bed Type has been updated', 0, 0, 0),
(180, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, '\\"%s\\" Bed Type could not be updated. Please, try again.', '\\"%s\\" Bed Type could not be updated. Please, try again.', 0, 0, 0),
(181, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Bed Type deleted', 'Bed Type deleted', 0, 0, 0),
(182, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Cancellation Policies', 'Cancellation Policies', 0, 0, 0),
(183, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Add Cancellation Policy', 'Add Cancellation Policy', 0, 0, 0),
(184, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Cancellation Policy has been added', 'Cancellation Policy has been added', 0, 0, 0),
(185, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Cancellation Policy could not be added. Please, try again.', 'Cancellation Policy could not be added. Please, try again.', 0, 0, 0),
(186, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Edit Cancellation Policy', 'Edit Cancellation Policy', 0, 0, 0),
(187, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Cancellation Policy has been updated', 'Cancellation Policy has been updated', 0, 0, 0),
(188, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Cancellation Policy could not be updated. Please, try again.', 'Cancellation Policy could not be updated. Please, try again.', 0, 0, 0),
(189, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Cancellation policy was assigned to some properties.', 'Cancellation policy was assigned to some properties.', 0, 0, 0),
(190, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Cancellation Policy deleted', 'Cancellation Policy deleted', 0, 0, 0),
(191, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Last 7 days', 'Last 7 days', 0, 0, 0),
(192, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Last 4 weeks', 'Last 4 weeks', 0, 0, 0),
(193, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Last 3 months', 'Last 3 months', 0, 0, 0),
(194, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Last 3 years', 'Last 3 years', 0, 0, 0),
(195, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Deposited', 'Deposited', 0, 0, 0),
(196, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Withdrawn Amount', 'Withdrawn Amount', 0, 0, 0),
(197, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Amount Paid to Host', 'Amount Paid to Host', 0, 0, 0),
(198, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Pending Withdraw Request', 'Pending Withdraw Request', 0, 0, 0),
(199, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Cleared', 'Cleared', 0, 0, 0),
(200, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Lost', 'Lost', 0, 0, 0),
(201, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Membership Fee', 'Membership Fee', 0, 0, 0),
(202, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Listing Fee', 'Listing Fee', 0, 0, 0),
(203, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Verification Fee', 'Verification Fee', 0, 0, 0),
(204, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Service Fee From Traveler', 'Service Fee From Traveler', 0, 0, 0),
(205, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Site Commission from Host', 'Site Commission from Host', 0, 0, 0),
(206, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Property View', 'Property View', 0, 0, 0),
(207, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Normal', 'Normal', 0, 0, 0),
(208, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Twitter', 'Twitter', 0, 0, 0),
(209, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Facebook', 'Facebook', 0, 0, 0),
(210, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'OpenID', 'OpenID', 0, 0, 0),
(211, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Gmail', 'Gmail', 0, 0, 0),
(212, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Yahoo', 'Yahoo', 0, 0, 0),
(213, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'All', 'All', 0, 0, 0),
(214, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Enabled', 'Enabled', 0, 0, 0),
(215, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Disabled', 'Disabled', 0, 0, 0),
(216, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Waiting for Approval', 'Waiting for Approval', 0, 0, 0),
(217, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Imported from AirBnB', 'Imported from AirBnB', 0, 0, 0),
(218, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Verified', 'Verified', 0, 0, 0),
(219, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Waiting for Verfication', 'Waiting for Verfication', 0, 0, 0),
(220, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Not Mentioned', 'Not Mentioned', 0, 0, 0),
(221, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, '18 - 34 Yrs', '18 - 34 Yrs', 0, 0, 0),
(222, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, '35 - 44 Yrs', '35 - 44 Yrs', 0, 0, 0),
(223, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, '45 - 54 Yrs', '45 - 54 Yrs', 0, 0, 0),
(224, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, '55+ Yrs', '55+ Yrs', 0, 0, 0),
(225, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Cities', 'Cities', 0, 0, 0),
(226, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, ' - Approved', ' - Approved', 0, 0, 0),
(227, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, ' - Disapproved', ' - Disapproved', 0, 0, 0),
(228, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Edit City', 'Edit City', 0, 0, 0),
(229, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'City has been updated', 'City has been updated', 0, 0, 0),
(230, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'City could not be updated. Please, try again.', 'City could not be updated. Please, try again.', 0, 0, 0),
(231, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, 'Add City', 'Add City', 0, 0, 0),
(232, '2012-01-11 17:04:23', '2012-01-11 17:04:23', 42, ' City has been added', ' City has been added', 0, 0, 0),
(233, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, ' City could not be added. Please, try again.', ' City could not be added. Please, try again.', 0, 0, 0),
(234, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Checked cities has been inactivated', 'Checked cities has been inactivated', 0, 0, 0),
(235, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Checked cities has been activated', 'Checked cities has been activated', 0, 0, 0),
(236, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Checked cities has been deleted', 'Checked cities has been deleted', 0, 0, 0),
(237, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'City deleted', 'City deleted', 0, 0, 0),
(238, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Collections', 'Collections', 0, 0, 0),
(239, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Add Collection', 'Add Collection', 0, 0, 0),
(240, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Collection has been added', 'Collection has been added', 0, 0, 0),
(241, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, ' Collection could not be added. Please, try again.', ' Collection could not be added. Please, try again.', 0, 0, 0),
(242, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Properties mapped with collections successfully', 'Properties mapped with collections successfully', 0, 0, 0),
(243, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Edit Collection', 'Edit Collection', 0, 0, 0),
(244, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Collection has been updated', 'Collection has been updated', 0, 0, 0),
(245, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Collection could not be updated. Please, try again.', 'Collection could not be updated. Please, try again.', 0, 0, 0),
(246, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Collection deleted', 'Collection deleted', 0, 0, 0),
(247, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Thank you, we received your message and will get back to you as soon as possible.', 'Thank you, we received your message and will get back to you as soon as possible.', 0, 0, 0),
(248, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Contact Us', 'Contact Us', 0, 0, 0),
(249, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Countries', 'Countries', 0, 0, 0),
(250, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Add Country', 'Add Country', 0, 0, 0),
(251, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Country has been added', 'Country has been added', 0, 0, 0),
(252, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Country could not be updated. Please, try again', 'Country could not be updated. Please, try again', 0, 0, 0),
(253, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Edit Country', 'Edit Country', 0, 0, 0),
(254, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Country has been updated', 'Country has been updated', 0, 0, 0),
(255, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Country could not be updated. Please, try again.', 'Country could not be updated. Please, try again.', 0, 0, 0),
(256, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Country deleted', 'Country deleted', 0, 0, 0),
(257, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Property status updated successfully', 'Property status updated successfully', 0, 0, 0),
(258, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Permanent cache files deleted successfully', 'Permanent cache files deleted successfully', 0, 0, 0),
(259, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'PNG images crushed successfully', 'PNG images crushed successfully', 0, 0, 0),
(260, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Currencies', 'Currencies', 0, 0, 0),
(261, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Add Currency', 'Add Currency', 0, 0, 0),
(262, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Currency has been added', 'Currency has been added', 0, 0, 0),
(263, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Currency could not be added. Please, try again.', 'Currency could not be added. Please, try again.', 0, 0, 0),
(264, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Edit Currency', 'Edit Currency', 0, 0, 0),
(265, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Currency has been updated', 'Currency has been updated', 0, 0, 0),
(266, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Currency could not be updated. Please, try again.', 'Currency could not be updated. Please, try again.', 0, 0, 0),
(267, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Currency deleted', 'Currency deleted', 0, 0, 0),
(268, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Currency Conversion / Exchange Rates', 'Currency Conversion / Exchange Rates', 0, 0, 0),
(269, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Required', 'Required', 0, 0, 0),
(270, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'History', 'History', 0, 0, 0),
(271, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Invalid currency conversion history', 'Invalid currency conversion history', 0, 0, 0),
(272, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Currency conversion history deleted', 'Currency conversion history deleted', 0, 0, 0),
(273, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Currency conversion history was not deleted', 'Currency conversion history was not deleted', 0, 0, 0),
(274, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Email Templates', 'Email Templates', 0, 0, 0),
(275, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Edit Email Template', 'Edit Email Template', 0, 0, 0),
(276, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Email Template has been updated', 'Email Template has been updated', 0, 0, 0),
(277, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Email Template could not be updated. Please, try again.', 'Email Template could not be updated. Please, try again.', 0, 0, 0),
(278, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Habits', 'Habits', 0, 0, 0),
(279, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Add Habit', 'Add Habit', 0, 0, 0),
(280, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, '\\"%s\\" Habit has been added', '\\"%s\\" Habit has been added', 0, 0, 0),
(281, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, '\\"%s\\" Habit could not be added. Please, try again.', '\\"%s\\" Habit could not be added. Please, try again.', 0, 0, 0),
(282, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Edit Habit', 'Edit Habit', 0, 0, 0),
(283, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, '\\"%s\\" Habit has been updated', '\\"%s\\" Habit has been updated', 0, 0, 0),
(284, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, '\\"%s\\" Habit could not be updated. Please, try again.', '\\"%s\\" Habit could not be updated. Please, try again.', 0, 0, 0),
(285, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Habit deleted', 'Habit deleted', 0, 0, 0),
(286, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Holiday Types', 'Holiday Types', 0, 0, 0),
(287, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Add Holiday Type', 'Add Holiday Type', 0, 0, 0),
(288, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Holiday Type has been added', 'Holiday Type has been added', 0, 0, 0),
(289, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Holiday Type could not be added. Please, try again.', 'Holiday Type could not be added. Please, try again.', 0, 0, 0),
(290, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Edit Holiday Type', 'Edit Holiday Type', 0, 0, 0),
(291, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Holiday Type has been updated', 'Holiday Type has been updated', 0, 0, 0),
(292, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Holiday Type could not be updated. Please, try again.', 'Holiday Type could not be updated. Please, try again.', 0, 0, 0),
(293, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Holiday Type deleted', 'Holiday Type deleted', 0, 0, 0),
(294, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'IPs', 'IPs', 0, 0, 0),
(295, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Ip deleted', 'Ip deleted', 0, 0, 0),
(296, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Labels', 'Labels', 0, 0, 0),
(297, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Add Label', 'Add Label', 0, 0, 0),
(298, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, ' Label has been added', ' Label has been added', 0, 0, 0),
(299, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, ' Labels already exist.', ' Labels already exist.', 0, 0, 0),
(300, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, ' Label could not be added. Please, try again', ' Label could not be added. Please, try again', 0, 0, 0),
(301, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Edit Labels User', 'Edit Labels User', 0, 0, 0),
(302, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, ' Labels User has been updated', ' Labels User has been updated', 0, 0, 0),
(303, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, ' Labels could not be updated. Please, try again.', ' Labels could not be updated. Please, try again.', 0, 0, 0),
(304, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, ' Label should not be empty', ' Label should not be empty', 0, 0, 0),
(305, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Label deleted', 'Label deleted', 0, 0, 0),
(306, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Labels Users', 'Labels Users', 0, 0, 0),
(307, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Add Labels User', 'Add Labels User', 0, 0, 0),
(308, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, '\\"%s\\" Labels User has been added', '\\"%s\\" Labels User has been added', 0, 0, 0),
(309, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, '\\"%s\\" Labels User could not be added. Please, try again.', '\\"%s\\" Labels User could not be added. Please, try again.', 0, 0, 0),
(310, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, ' Labels User could not be updated. Please, try again.', ' Labels User could not be updated. Please, try again.', 0, 0, 0),
(311, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Labels User deleted', 'Labels User deleted', 0, 0, 0),
(312, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Languages', 'Languages', 0, 0, 0),
(313, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, ' - Active ', ' - Active ', 0, 0, 0),
(314, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, ' - Inactive ', ' - Inactive ', 0, 0, 0),
(315, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Add Language', 'Add Language', 0, 0, 0),
(316, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Language has been added', 'Language has been added', 0, 0, 0),
(317, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Language could not be added. Please, try again.', 'Language could not be added. Please, try again.', 0, 0, 0),
(318, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Edit Language', 'Edit Language', 0, 0, 0),
(319, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Language  has been updated', 'Language  has been updated', 0, 0, 0),
(320, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Language  could not be updated. Please, try again.', 'Language  could not be updated. Please, try again.', 0, 0, 0),
(321, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Language deleted', 'Language deleted', 0, 0, 0),
(322, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Checked languages has been inactivated', 'Checked languages has been inactivated', 0, 0, 0),
(323, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Checked languages has been activated', 'Checked languages has been activated', 0, 0, 0),
(324, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Checked languages has been deleted', 'Checked languages has been deleted', 0, 0, 0),
(325, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Messages - Inbox', 'Messages - Inbox', 0, 0, 0),
(326, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Messages - Sent Mail', 'Messages - Sent Mail', 0, 0, 0),
(327, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Messages - Drafts', 'Messages - Drafts', 0, 0, 0),
(328, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Messages - Spam', 'Messages - Spam', 0, 0, 0),
(329, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Messages - Trash', 'Messages - Trash', 0, 0, 0),
(330, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Messages - All', 'Messages - All', 0, 0, 0),
(331, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Messages - %s', 'Messages - %s', 0, 0, 0),
(332, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Messages - Starred', 'Messages - Starred', 0, 0, 0),
(333, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Message', 'Message', 0, 0, 0),
(334, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'All mails', 'All mails', 0, 0, 0),
(335, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Message deleted', 'Message deleted', 0, 0, 0),
(336, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Messages - Compose', 'Messages - Compose', 0, 0, 0),
(337, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Messages - New Message', 'Messages - New Message', 0, 0, 0),
(338, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Message send is temporarily stopped. Please try again later.', 'Message send is temporarily stopped. Please try again later.', 0, 0, 0),
(339, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Message has been sent successfully', 'Message has been sent successfully', 0, 0, 0),
(340, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Message couldn''t be sent successfully. Try again', 'Message couldn''t be sent successfully. Try again', 0, 0, 0),
(341, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Please specify atleast one recipient.', 'Please specify atleast one recipient.', 0, 0, 0),
(342, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Message could not be sent.', 'Message could not be sent.', 0, 0, 0),
(343, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Re:', 'Re:', 0, 0, 0),
(344, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Fwd:', 'Fwd:', 0, 0, 0),
(345, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Availability', 'Availability', 0, 0, 0),
(346, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Facilities', 'Facilities', 0, 0, 0),
(347, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Pricing', 'Pricing', 0, 0, 0),
(348, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Other', 'Other', 0, 0, 0),
(349, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Messages', 'Messages', 0, 0, 0),
(350, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Compose message', 'Compose message', 0, 0, 0),
(351, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Problem in sending mail to the appropriate user', 'Problem in sending mail to the appropriate user', 0, 0, 0),
(352, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Search Results', 'Search Results', 0, 0, 0),
(353, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, '---- More actions ----', '---- More actions ----', 0, 0, 0),
(354, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Mark as read', 'Mark as read', 0, 0, 0),
(355, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Mark as unread', 'Mark as unread', 0, 0, 0),
(356, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Add star', 'Add star', 0, 0, 0),
(357, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Remove star', 'Remove star', 0, 0, 0),
(358, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, '----Apply label----', '----Apply label----', 0, 0, 0),
(359, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, '----Remove label----', '----Remove label----', 0, 0, 0),
(360, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Settings', 'Settings', 0, 0, 0),
(361, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Message Settings has been updated', 'Message Settings has been updated', 0, 0, 0),
(362, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Message Settings could not be updated', 'Message Settings could not be updated', 0, 0, 0),
(363, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, ' - Suspend ', ' - Suspend ', 0, 0, 0),
(364, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, ' - Flagged ', ' - Flagged ', 0, 0, 0),
(365, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, ' - Added today', ' - Added today', 0, 0, 0),
(366, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, ' - Added in this week', ' - Added in this week', 0, 0, 0),
(367, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, ' - Added in this month', ' - Added in this month', 0, 0, 0),
(368, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Message has been flagged', 'Message has been flagged', 0, 0, 0),
(369, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Message has been Unflagged', 'Message has been Unflagged', 0, 0, 0),
(370, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Message has been suspend', 'Message has been suspend', 0, 0, 0),
(371, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Message has been unsuspend', 'Message has been unsuspend', 0, 0, 0),
(372, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Checked messages has been deleted', 'Checked messages has been deleted', 0, 0, 0),
(373, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Checked messages has been Suspended', 'Checked messages has been Suspended', 0, 0, 0),
(374, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Checked messages has been Unsuspended', 'Checked messages has been Unsuspended', 0, 0, 0),
(375, '2012-01-11 17:04:24', '2012-01-11 17:04:24', 42, 'Checked messages has been Flagged', 'Checked messages has been Flagged', 0, 0, 0),
(376, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Checked messages has been Unflagged', 'Checked messages has been Unflagged', 0, 0, 0),
(377, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Activities', 'Activities', 0, 0, 0),
(378, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Private note updated.', 'Private note updated.', 0, 0, 0),
(379, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Negotiate conversation added.', 'Negotiate conversation added.', 0, 0, 0),
(380, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Conversation Updated.', 'Conversation Updated.', 0, 0, 0),
(381, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Money Transfer Accounts', 'Money Transfer Accounts', 0, 0, 0),
(382, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'money transfer account has been added', 'money transfer account has been added', 0, 0, 0),
(383, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'money transfer account could not be updated. Please, try again.', 'money transfer account could not be updated. Please, try again.', 0, 0, 0),
(384, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Transfer account deleted', 'Transfer account deleted', 0, 0, 0),
(385, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Primary money transfer account has been updated', 'Primary money transfer account has been updated', 0, 0, 0),
(386, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Page has been created', 'Page has been created', 0, 0, 0),
(387, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Page could not be added. Please, try again.', 'Page could not be added. Please, try again.', 0, 0, 0),
(388, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Edit Page', 'Edit Page', 0, 0, 0),
(389, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Page has been Updated', 'Page has been Updated', 0, 0, 0),
(390, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Page could not be Updated. Please, try again.', 'Page could not be Updated. Please, try again.', 0, 0, 0),
(391, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Pages', 'Pages', 0, 0, 0),
(392, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Page Deleted Successfully', 'Page Deleted Successfully', 0, 0, 0),
(393, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Acceptable Use Policy', 'Acceptable Use Policy', 0, 0, 0),
(394, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Pagseguro Transaction Logs', 'Pagseguro Transaction Logs', 0, 0, 0),
(395, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Pagseguro Transaction Log', 'Pagseguro Transaction Log', 0, 0, 0),
(396, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Add Payment Gateway Setting', 'Add Payment Gateway Setting', 0, 0, 0),
(397, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Payment Gateway Setting has been added', 'Payment Gateway Setting has been added', 0, 0, 0),
(398, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Payment Gateway Setting could not be added. Please, try again.', 'Payment Gateway Setting could not be added. Please, try again.', 0, 0, 0),
(399, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Edit Payment Gateway Setting', 'Edit Payment Gateway Setting', 0, 0, 0),
(400, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Payment gateway settings updated.', 'Payment gateway settings updated.', 0, 0, 0),
(401, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Payment Gateway Setting deleted', 'Payment Gateway Setting deleted', 0, 0, 0),
(402, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Payment Gateways', 'Payment Gateways', 0, 0, 0),
(403, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, ' - Test Mode ', ' - Test Mode ', 0, 0, 0);
INSERT INTO `translations` (`id`, `created`, `modified`, `language_id`, `key`, `lang_text`, `is_translated`, `is_google_translate`, `is_verified`) VALUES
(404, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, ' - Live Mode ', ' - Live Mode ', 0, 0, 0),
(405, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Add Payment Gateway', 'Add Payment Gateway', 0, 0, 0),
(406, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Payment Gateway has been added', 'Payment Gateway has been added', 0, 0, 0),
(407, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Payment Gateway could not be added. Please, try again.', 'Payment Gateway could not be added. Please, try again.', 0, 0, 0),
(408, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Edit Payment Gateway', 'Edit Payment Gateway', 0, 0, 0),
(409, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Payment Gateway has been updated', 'Payment Gateway has been updated', 0, 0, 0),
(410, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Payment Gateway could not be updated. Please, try again.', 'Payment Gateway could not be updated. Please, try again.', 0, 0, 0),
(411, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Payment Gateway deleted', 'Payment Gateway deleted', 0, 0, 0),
(412, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Your transaction has been completed.', 'Your transaction has been completed.', 0, 0, 0),
(413, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Pay Verification Fee - ', 'Pay Verification Fee - ', 0, 0, 0),
(414, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Please enter proper credit card details', 'Please enter proper credit card details', 0, 0, 0),
(415, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Gateway error: %s <br>Note: Due to security reasons, error message from gateway may not be verbose. Please double check your card number, security number and address details. Also, check if you have enough balance in your card.', 'Gateway error: %s <br>Note: Due to security reasons, error message from gateway may not be verbose. Please double check your card number, security number and address details. Also, check if you have enough balance in your card.', 0, 0, 0),
(416, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Property verification fee payment has done successfully and property successfully submitted for verification.', 'Property verification fee payment has done successfully and property successfully submitted for verification.', 0, 0, 0),
(417, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Your payment could not be completed', 'Your payment could not be completed', 0, 0, 0),
(418, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Your wallet has insufficient money', 'Your wallet has insufficient money', 0, 0, 0),
(419, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Payment could not be completed.', 'Payment could not be completed.', 0, 0, 0),
(420, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Property Verification Fee', 'Property Verification Fee', 0, 0, 0),
(421, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Your property has been successfully verified', 'Your property has been successfully verified', 0, 0, 0),
(422, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Visa', 'Visa', 0, 0, 0),
(423, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'MasterCard', 'MasterCard', 0, 0, 0),
(424, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Discover', 'Discover', 0, 0, 0),
(425, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Amex', 'Amex', 0, 0, 0),
(426, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Pay Now', 'Pay Now', 0, 0, 0),
(427, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Pay Listing Fee - ', 'Pay Listing Fee - ', 0, 0, 0),
(428, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Property listing fee payment has done and property has been listed successfully.', 'Property listing fee payment has done and property has been listed successfully.', 0, 0, 0),
(429, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Property listing fee payment has done and property will be listed after admin approve', 'Property listing fee payment has done and property will be listed after admin approve', 0, 0, 0),
(430, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Property Listing Fee', 'Property Listing Fee', 0, 0, 0),
(431, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Pay Membership Fee - ', 'Pay Membership Fee - ', 0, 0, 0),
(432, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'You have paid membership fee successfully, will be activated once administrator approved', 'You have paid membership fee successfully, will be activated once administrator approved', 0, 0, 0),
(433, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'You have paid membership fee successfully. Now you can login with your %s.', 'You have paid membership fee successfully. Now you can login with your %s.', 0, 0, 0),
(434, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'You have paid membership fee successfully. Now you can login with your %s after verified your email', 'You have paid membership fee successfully. Now you can login with your %s after verified your email', 0, 0, 0),
(435, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Your payment could not be completed.', 'Your payment could not be completed.', 0, 0, 0),
(436, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Signup Fee', 'Signup Fee', 0, 0, 0),
(437, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Property has been suspended, due to some bad words. Admin will unsuspend your property', 'Property has been suspended, due to some bad words. Admin will unsuspend your property', 0, 0, 0),
(438, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Property has been added but after admin approval it will list out in site', 'Property has been added but after admin approval it will list out in site', 0, 0, 0),
(439, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Payment has been successfully completed. Now your property has been listed.', 'Payment has been successfully completed. Now your property has been listed.', 0, 0, 0),
(440, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Payment Failed. Please, try again', 'Payment Failed. Please, try again', 0, 0, 0),
(441, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Property booked by some other user. Please, try for some other dates.', 'Property booked by some other user. Please, try for some other dates.', 0, 0, 0),
(442, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Oops, problems in registration, please try again or later', 'Oops, problems in registration, please try again or later', 0, 0, 0),
(443, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Your request has been sent', 'Your request has been sent', 0, 0, 0),
(444, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'You successfully confirmed the Traveler request', 'You successfully confirmed the Traveler request', 0, 0, 0),
(445, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'You request not processed successfully', 'You request not processed successfully', 0, 0, 0),
(446, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'accept', 'accept', 0, 0, 0),
(447, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Property Booking', 'Property Booking', 0, 0, 0),
(448, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Please agree the terms and conditions', 'Please agree the terms and conditions', 0, 0, 0),
(449, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Please agree the terms and conditions or please enter proper credit card details', 'Please agree the terms and conditions or please enter proper credit card details', 0, 0, 0),
(450, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Selected PayPal connection have insufficient money', 'Selected PayPal connection have insufficient money', 0, 0, 0),
(451, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Pricing Negotiation', 'Pricing Negotiation', 0, 0, 0),
(452, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Booking Request Confirm', 'Booking Request Confirm', 0, 0, 0),
(453, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Booking Cancel Process', 'Booking Cancel Process', 0, 0, 0),
(454, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, 'Book It', 'Book It', 0, 0, 0),
(455, '2012-01-11 17:04:25', '2012-01-11 17:04:25', 42, '. Your payment could not be completed', '. Your payment could not be completed', 0, 0, 0),
(456, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Payment Success', 'Payment Success', 0, 0, 0),
(457, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Your payment has been received', 'Your payment has been received', 0, 0, 0),
(458, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Payment Cancel', 'Payment Cancel', 0, 0, 0),
(459, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Your payment has been canceled', 'Your payment has been canceled', 0, 0, 0),
(460, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Gateway error:', 'Gateway error:', 0, 0, 0),
(461, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'You have connected with PayPal successfully', 'You have connected with PayPal successfully', 0, 0, 0),
(462, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Your connection has been canceled.', 'Your connection has been canceled.', 0, 0, 0),
(463, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Create Paypal Account', 'Create Paypal Account', 0, 0, 0),
(464, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'PayPal Account has been added', 'PayPal Account has been added', 0, 0, 0),
(465, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'PayPal Account could not be created. Please, try again.', 'PayPal Account could not be created. Please, try again.', 0, 0, 0),
(466, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Create Paypal Account Success', 'Create Paypal Account Success', 0, 0, 0),
(467, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Your paypal account has been created successfully', 'Your paypal account has been created successfully', 0, 0, 0),
(468, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Create Paypal Account Cancel', 'Create Paypal Account Cancel', 0, 0, 0),
(469, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Your paypal account creation has been canceled.', 'Your paypal account creation has been canceled.', 0, 0, 0),
(470, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Send Money', 'Send Money', 0, 0, 0),
(471, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Invalid user PayPal account.', 'Invalid user PayPal account.', 0, 0, 0),
(472, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Site', 'Site', 0, 0, 0),
(473, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Send Money Success', 'Send Money Success', 0, 0, 0),
(474, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'You have successfully sent the money to user', 'You have successfully sent the money to user', 0, 0, 0),
(475, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Send Money Cancel', 'Send Money Cancel', 0, 0, 0),
(476, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'You have canceled the money send to user.', 'You have canceled the money send to user.', 0, 0, 0),
(477, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Paypal Accounts', 'Paypal Accounts', 0, 0, 0),
(478, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Paypal Transaction Logs', 'Paypal Transaction Logs', 0, 0, 0),
(479, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Mass Paypal Transaction Logs', 'Mass Paypal Transaction Logs', 0, 0, 0),
(480, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Normal Paypal Transaction Logs', 'Normal Paypal Transaction Logs', 0, 0, 0),
(481, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Paypal Transaction Log', 'Paypal Transaction Log', 0, 0, 0),
(482, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Privacies', 'Privacies', 0, 0, 0),
(483, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Add Privacy', 'Add Privacy', 0, 0, 0),
(484, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, '\\"%s\\" Privacy has been added', '\\"%s\\" Privacy has been added', 0, 0, 0),
(485, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, '\\"%s\\" Privacy could not be added. Please, try again.', '\\"%s\\" Privacy could not be added. Please, try again.', 0, 0, 0),
(486, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Edit Privacy', 'Edit Privacy', 0, 0, 0),
(487, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, '\\"%s\\" Privacy has been updated', '\\"%s\\" Privacy has been updated', 0, 0, 0),
(488, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, '\\"%s\\" Privacy could not be updated. Please, try again.', '\\"%s\\" Privacy could not be updated. Please, try again.', 0, 0, 0),
(489, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Privacy deleted', 'Privacy deleted', 0, 0, 0),
(490, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Home', 'Home', 0, 0, 0),
(491, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Properties', 'Properties', 0, 0, 0),
(492, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'My Properties', 'My Properties', 0, 0, 0),
(493, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Checkin/checkout date is invalid', 'Checkin/checkout date is invalid', 0, 0, 0),
(494, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Liked Properties', 'Liked Properties', 0, 0, 0),
(495, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Make an offer', 'Make an offer', 0, 0, 0),
(496, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Property', 'Property', 0, 0, 0),
(497, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'List your property', 'List your property', 0, 0, 0),
(498, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Enter PayPal verification email and name associated with your PayPal', 'Enter PayPal verification email and name associated with your PayPal', 0, 0, 0),
(499, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Property could not be added. Please, try again', 'Property could not be added. Please, try again', 0, 0, 0),
(500, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Property has been added successfully and it will be list out after paying the listing fee', 'Property has been added successfully and it will be list out after paying the listing fee', 0, 0, 0),
(501, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Property has been listed.', 'Property has been listed.', 0, 0, 0),
(502, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'could not be added. Please, try again.', 'could not be added. Please, try again.', 0, 0, 0),
(503, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Property could not be added. Please, upload at least one property image.', 'Property could not be added. Please, upload at least one property image.', 0, 0, 0),
(504, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Property could not be added. Please, try again.', 'Property could not be added. Please, try again.', 0, 0, 0),
(505, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, '%s refund %s day(s) prior to arrival, except fees', '%s refund %s day(s) prior to arrival, except fees', 0, 0, 0),
(506, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'listed a new property \\"', 'listed a new property \\"', 0, 0, 0),
(507, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, '\\" in ', '\\" in ', 0, 0, 0),
(508, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'has been listed. But unable to post it on facebook.', 'has been listed. But unable to post it on facebook.', 0, 0, 0),
(509, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'has been listed.', 'has been listed.', 0, 0, 0),
(510, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Edit Property', 'Edit Property', 0, 0, 0),
(511, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Property has been updated', 'Property has been updated', 0, 0, 0),
(512, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Property could not be updated. Please, try again.', 'Property could not be updated. Please, try again.', 0, 0, 0),
(513, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Property could not be updated. Please, upload at least one property image.', 'Property could not be updated. Please, upload at least one property image.', 0, 0, 0),
(514, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Property deleted', 'Property deleted', 0, 0, 0),
(515, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Manage Collections', 'Manage Collections', 0, 0, 0),
(516, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, ' - today', ' - today', 0, 0, 0),
(517, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, ' - in this week', ' - in this week', 0, 0, 0),
(518, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, ' - in this month', ' - in this month', 0, 0, 0),
(519, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, ' - PropertyType - ', ' - PropertyType - ', 0, 0, 0),
(520, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, ' - Approved ', ' - Approved ', 0, 0, 0),
(521, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, ' - Waiting for Approval ', ' - Waiting for Approval ', 0, 0, 0),
(522, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, ' - Enabled ', ' - Enabled ', 0, 0, 0),
(523, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, ' - Disabled ', ' - Disabled ', 0, 0, 0),
(524, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, ' - Suspended ', ' - Suspended ', 0, 0, 0),
(525, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, ' - User Flagged ', ' - User Flagged ', 0, 0, 0),
(526, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, ' - Featured ', ' - Featured ', 0, 0, 0),
(527, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, ' - HomePage ', ' - HomePage ', 0, 0, 0),
(528, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, ' - Verified ', ' - Verified ', 0, 0, 0),
(529, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, ' - Waiting for Verification ', ' - Waiting for Verification ', 0, 0, 0),
(530, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, ' - Imported from AirBnB ', ' - Imported from AirBnB ', 0, 0, 0),
(531, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, ' - Listing fee ', ' - Listing fee ', 0, 0, 0),
(532, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Map', 'Map', 0, 0, 0),
(533, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Property mapped with request.', 'Property mapped with request.', 0, 0, 0),
(534, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Negotiation for request - ', 'Negotiation for request - ', 0, 0, 0),
(535, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, ' is giving negotiation for this request -  ', ' is giving negotiation for this request -  ', 0, 0, 0),
(536, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Selected property already mapped with this request.', 'Selected property already mapped with this request.', 0, 0, 0),
(537, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Couldn''t map to request', 'Couldn''t map to request', 0, 0, 0),
(538, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Checked Property has been inactivated', 'Checked Property has been inactivated', 0, 0, 0),
(539, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Checked Property has been activated', 'Checked Property has been activated', 0, 0, 0),
(540, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Checked Property has been deleted', 'Checked Property has been deleted', 0, 0, 0),
(541, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Import Properties', 'Import Properties', 0, 0, 0),
(542, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, '%s property not imported from AirBnB and other checked properties are imported successfully.', '%s property not imported from AirBnB and other checked properties are imported successfully.', 0, 0, 0),
(543, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, '%s property not imported from AirBnB.', '%s property not imported from AirBnB.', 0, 0, 0),
(544, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Checked property imported from AirBnB successfully.', 'Checked property imported from AirBnB successfully.', 0, 0, 0),
(545, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Please select any one property to import.', 'Please select any one property to import.', 0, 0, 0),
(546, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Property could not be imported. Please, try again', 'Property could not be imported. Please, try again', 0, 0, 0),
(547, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Post on Craigslist', 'Post on Craigslist', 0, 0, 0),
(548, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Recent review', 'Recent review', 0, 0, 0),
(549, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'total', 'total', 0, 0, 0),
(550, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'said', 'said', 0, 0, 0),
(551, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Interested? Got a question?', 'Interested? Got a question?', 0, 0, 0),
(552, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Contact me here', 'Contact me here', 0, 0, 0),
(553, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'per night', 'per night', 0, 0, 0),
(554, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Includes', 'Includes', 0, 0, 0),
(555, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Description', 'Description', 0, 0, 0),
(556, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Read full description', 'Read full description', 0, 0, 0),
(557, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Location', 'Location', 0, 0, 0),
(558, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Property could not be posted. Please, try again', 'Property could not be posted. Please, try again', 0, 0, 0),
(559, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, ' Property has been added to your Favorites', ' Property has been added to your Favorites', 0, 0, 0),
(560, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, ' Property Favorite could not be added. Please, try again.', ' Property Favorite could not be added. Please, try again.', 0, 0, 0),
(561, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, ' Property already added has Favorite', ' Property already added has Favorite', 0, 0, 0),
(562, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, ' Property removed from favorites', ' Property removed from favorites', 0, 0, 0),
(563, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Property Favorites', 'Property Favorites', 0, 0, 0),
(564, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Property favorite deleted successfully', 'Property favorite deleted successfully', 0, 0, 0),
(565, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Feedbacks', 'Feedbacks', 0, 0, 0),
(566, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Review', 'Review', 0, 0, 0),
(567, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Feedback could not be added. Please, try again.', 'Feedback could not be added. Please, try again.', 0, 0, 0),
(568, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Feedback To Host', 'Feedback To Host', 0, 0, 0),
(569, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Edit Feedback', 'Edit Feedback', 0, 0, 0),
(570, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Feedback has been updated.', 'Feedback has been updated.', 0, 0, 0),
(571, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Feedback could not be updated. Please, try again.', 'Feedback could not be updated. Please, try again.', 0, 0, 0),
(572, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Feedback deleted', 'Feedback deleted', 0, 0, 0),
(573, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Property Flag Categories', 'Property Flag Categories', 0, 0, 0),
(574, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Add', 'Add', 0, 0, 0),
(575, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Flag Category', 'Flag Category', 0, 0, 0),
(576, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Flag Category has been added', 'Flag Category has been added', 0, 0, 0),
(577, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Flag Category could not be added. Please, try again.', 'Flag Category could not be added. Please, try again.', 0, 0, 0),
(578, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Edit Flag Category', 'Edit Flag Category', 0, 0, 0),
(579, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Flag Category has been updated', 'Flag Category has been updated', 0, 0, 0),
(580, '2012-01-11 17:04:26', '2012-01-11 17:04:26', 42, 'Flag Category could not be updated. Please, try again.', 'Flag Category could not be updated. Please, try again.', 0, 0, 0),
(581, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Flag Category deleted', 'Flag Category deleted', 0, 0, 0),
(582, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Flag has been added', 'Flag has been added', 0, 0, 0),
(583, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Flag could not be added. Please, try again.', 'Flag could not be added. Please, try again.', 0, 0, 0),
(584, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Flags', 'Flags', 0, 0, 0),
(585, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, ' - Category - %s', ' - Category - %s', 0, 0, 0),
(586, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Flag has been cleared', 'Flag has been cleared', 0, 0, 0),
(587, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Property Types', 'Property Types', 0, 0, 0),
(588, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Add Property Type', 'Add Property Type', 0, 0, 0),
(589, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, '\\"%s\\" Property Type has been added', '\\"%s\\" Property Type has been added', 0, 0, 0),
(590, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, '\\"%s\\" Property Type could not be added. Please, try again.', '\\"%s\\" Property Type could not be added. Please, try again.', 0, 0, 0),
(591, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Edit Property Type', 'Edit Property Type', 0, 0, 0),
(592, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, '\\"%s\\" Property Type has been updated', '\\"%s\\" Property Type has been updated', 0, 0, 0),
(593, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, '\\"%s\\" Property Type could not be updated. Please, try again.', '\\"%s\\" Property Type could not be updated. Please, try again.', 0, 0, 0),
(594, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Property Type deleted', 'Property Type deleted', 0, 0, 0),
(595, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Add Booking Dispute', 'Add Booking Dispute', 0, 0, 0),
(596, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'days', 'days', 0, 0, 0),
(597, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Host', 'Host', 0, 0, 0),
(598, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Traveler', 'Traveler', 0, 0, 0),
(599, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Dispute Opened', 'Dispute Opened', 0, 0, 0),
(600, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Enter all required information.', 'Enter all required information.', 0, 0, 0),
(601, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Booking Disputes', 'Booking Disputes', 0, 0, 0),
(602, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, ' - Open', ' - Open', 0, 0, 0),
(603, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, ' - Under Discussion', ' - Under Discussion', 0, 0, 0),
(604, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, ' - Waiting For Administrator Decision', ' - Waiting For Administrator Decision', 0, 0, 0),
(605, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, ' - Closed', ' - Closed', 0, 0, 0),
(606, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, ' - Search', ' - Search', 0, 0, 0),
(607, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Dispute resolved successfully', 'Dispute resolved successfully', 0, 0, 0),
(608, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Booking Dispute deleted', 'Booking Dispute deleted', 0, 0, 0),
(609, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Feedback To Traveller', 'Feedback To Traveller', 0, 0, 0),
(610, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Property User Feedback deleted', 'Property User Feedback deleted', 0, 0, 0),
(611, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Property Users', 'Property Users', 0, 0, 0),
(612, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Current / Upcoming', 'Current / Upcoming', 0, 0, 0),
(613, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Waiting For Review', 'Waiting For Review', 0, 0, 0),
(614, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Past', 'Past', 0, 0, 0),
(615, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Waiting For Acceptance', 'Waiting For Acceptance', 0, 0, 0),
(616, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Rejected', 'Rejected', 0, 0, 0),
(617, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Expired', 'Expired', 0, 0, 0),
(618, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Negotiation', 'Negotiation', 0, 0, 0),
(619, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Arrived', 'Arrived', 0, 0, 0),
(620, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Payment Pending', 'Payment Pending', 0, 0, 0),
(621, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Trips', 'Trips', 0, 0, 0),
(622, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Confirmed', 'Confirmed', 0, 0, 0),
(623, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Payment Cleared', 'Payment Cleared', 0, 0, 0),
(624, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Calendar', 'Calendar', 0, 0, 0),
(625, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Property info updated successfully', 'Property info updated successfully', 0, 0, 0),
(626, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Ticket', 'Ticket', 0, 0, 0),
(627, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Add Property User', 'Add Property User', 0, 0, 0),
(628, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Property not available on the specified date. Please, try for some other dates.', 'Property not available on the specified date. Please, try for some other dates.', 0, 0, 0),
(629, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Number of nights exceeded the property maximum nights, so please choose within a limit', 'Number of nights exceeded the property maximum nights, so please choose within a limit', 0, 0, 0),
(630, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Number of nights should maximum of the property minimum nights, so please choose within a limit', 'Number of nights should maximum of the property minimum nights, so please choose within a limit', 0, 0, 0),
(631, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Property has been booked', 'Property has been booked', 0, 0, 0),
(632, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'contact', 'contact', 0, 0, 0),
(633, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Maximum guest allowed for this property is ', 'Maximum guest allowed for this property is ', 0, 0, 0),
(634, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Property  not available on the specified date . Please, try for some other dates.', 'Property  not available on the specified date . Please, try for some other dates.', 0, 0, 0),
(635, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Property Bookings', 'Property Bookings', 0, 0, 0),
(636, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, ' - booked today', ' - booked today', 0, 0, 0),
(637, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, ' - booked in this week', ' - booked in this week', 0, 0, 0),
(638, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, ' - booked in this month', ' - booked in this month', 0, 0, 0),
(639, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, ' - Payment Pending', ' - Payment Pending', 0, 0, 0),
(640, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, ' - Waiting for Acceptance', ' - Waiting for Acceptance', 0, 0, 0),
(641, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, ' - Confirmed', ' - Confirmed', 0, 0, 0),
(642, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, ' - Canceled', ' - Canceled', 0, 0, 0),
(643, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, ' - Arrived', ' - Arrived', 0, 0, 0),
(644, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, ' - Waiting for Review', ' - Waiting for Review', 0, 0, 0),
(645, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, ' - Expired', ' - Expired', 0, 0, 0),
(646, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, ' - Canceled by Admin', ' - Canceled by Admin', 0, 0, 0),
(647, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, ' - Payment Cleared', ' - Payment Cleared', 0, 0, 0),
(648, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Booking has been canceled and refunded.', 'Booking has been canceled and refunded.', 0, 0, 0),
(649, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Status of your booking No', 'Status of your booking No', 0, 0, 0),
(650, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Booking', 'Booking', 0, 0, 0),
(651, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Already an order was accepted within this check in and check out date. So please reject this order.', 'Already an order was accepted within this check in and check out date. So please reject this order.', 0, 0, 0),
(652, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'all', 'all', 0, 0, 0),
(653, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Status changed successfully', 'Status changed successfully', 0, 0, 0),
(654, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Selected check in date should be greater the booked check in date', 'Selected check in date should be greater the booked check in date', 0, 0, 0),
(655, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Selected check out date should be greater the booked check out date', 'Selected check out date should be greater the booked check out date', 0, 0, 0),
(656, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Property user ticket', 'Property user ticket', 0, 0, 0),
(657, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Invalid ticket', 'Invalid ticket', 0, 0, 0),
(658, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'You have no authorized to view this page', 'You have no authorized to view this page', 0, 0, 0),
(659, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Property Views', 'Property Views', 0, 0, 0),
(660, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, ' - %s', ' - %s', 0, 0, 0),
(661, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Property View deleted', 'Property View deleted', 0, 0, 0),
(662, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Add Request Favorite', 'Add Request Favorite', 0, 0, 0),
(663, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, '\\"%s\\" Request Favorite could not be added. Please, try again.', '\\"%s\\" Request Favorite could not be added. Please, try again.', 0, 0, 0),
(664, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, ' Request already added has Favorite', ' Request already added has Favorite', 0, 0, 0),
(665, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Request Favorite deleted', 'Request Favorite deleted', 0, 0, 0),
(666, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Request Favorites', 'Request Favorites', 0, 0, 0),
(667, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Request Flag Categories', 'Request Flag Categories', 0, 0, 0),
(668, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Add Request Flag Category', 'Add Request Flag Category', 0, 0, 0),
(669, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Request Flag Category has been added', 'Request Flag Category has been added', 0, 0, 0),
(670, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Request Flag Category could not be added. Please, try again.', 'Request Flag Category could not be added. Please, try again.', 0, 0, 0),
(671, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Edit Request Flag Category', 'Edit Request Flag Category', 0, 0, 0),
(672, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Request Flag Category has been updated', 'Request Flag Category has been updated', 0, 0, 0),
(673, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Request Flag Category could not be updated. Please, try again.', 'Request Flag Category could not be updated. Please, try again.', 0, 0, 0),
(674, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Request Flag Category deleted', 'Request Flag Category deleted', 0, 0, 0),
(675, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Request Views', 'Request Views', 0, 0, 0),
(676, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Request View deleted', 'Request View deleted', 0, 0, 0),
(677, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Requests', 'Requests', 0, 0, 0),
(678, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Liked Requests', 'Liked Requests', 0, 0, 0),
(679, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'My Requests', 'My Requests', 0, 0, 0),
(680, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Request', 'Request', 0, 0, 0),
(681, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Post a request', 'Post a request', 0, 0, 0),
(682, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Please select proper address', 'Please select proper address', 0, 0, 0),
(683, '2012-01-11 17:04:27', '2012-01-11 17:04:27', 42, 'Request could not be added. Please, try again', 'Request could not be added. Please, try again', 0, 0, 0),
(684, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Request has been listed.', 'Request has been listed.', 0, 0, 0),
(685, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Request has been added and it will be listed after admin approve.', 'Request has been added and it will be listed after admin approve.', 0, 0, 0),
(686, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Request could not be added. Please, try again.', 'Request could not be added. Please, try again.', 0, 0, 0),
(687, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'listed a new request \\"', 'listed a new request \\"', 0, 0, 0),
(688, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Request has been listed. But unable to post it on facebook.', 'Request has been listed. But unable to post it on facebook.', 0, 0, 0),
(689, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Edit Request', 'Edit Request', 0, 0, 0),
(690, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Request has been updated', 'Request has been updated', 0, 0, 0),
(691, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Request could not be updated. Please, try again.', 'Request could not be updated. Please, try again.', 0, 0, 0),
(692, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Request deleted', 'Request deleted', 0, 0, 0),
(693, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, ' - Disapproved ', ' - Disapproved ', 0, 0, 0),
(694, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, ' - User suspended ', ' - User suspended ', 0, 0, 0),
(695, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Checked request has been disabled', 'Checked request has been disabled', 0, 0, 0),
(696, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Checked request has been enabled', 'Checked request has been enabled', 0, 0, 0),
(697, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Checked request has been deleted', 'Checked request has been deleted', 0, 0, 0),
(698, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Room Types', 'Room Types', 0, 0, 0),
(699, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Add Room Type', 'Add Room Type', 0, 0, 0),
(700, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Room Type has been added', 'Room Type has been added', 0, 0, 0),
(701, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Room Type could not be added. Please, try again.', 'Room Type could not be added. Please, try again.', 0, 0, 0),
(702, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Edit Room Type', 'Edit Room Type', 0, 0, 0),
(703, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Room Type has been updated', 'Room Type has been updated', 0, 0, 0),
(704, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Room Type could not be updated. Please, try again.', 'Room Type could not be updated. Please, try again.', 0, 0, 0),
(705, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Room Type deleted', 'Room Type deleted', 0, 0, 0),
(706, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Search Logs', 'Search Logs', 0, 0, 0),
(707, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, ' - Registered today', ' - Registered today', 0, 0, 0),
(708, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, ' - Registered in this week', ' - Registered in this week', 0, 0, 0),
(709, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, ' - Registered in this month', ' - Registered in this month', 0, 0, 0),
(710, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Search Log deleted', 'Search Log deleted', 0, 0, 0),
(711, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'This is image base URL should not trailing slash', 'This is image base URL should not trailing slash', 0, 0, 0),
(712, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'This is css base URL should have trailing slash', 'This is css base URL should have trailing slash', 0, 0, 0),
(713, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'This is JS base URL should have trailing slash', 'This is JS base URL should have trailing slash', 0, 0, 0),
(714, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Settings updated successfully.', 'Settings updated successfully.', 0, 0, 0),
(715, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Sorry. You Cannot Update the Settings in Demo Mode', 'Sorry. You Cannot Update the Settings in Demo Mode', 0, 0, 0),
(716, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, ' Settings', ' Settings', 0, 0, 0),
(717, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Update Facebook', 'Update Facebook', 0, 0, 0),
(718, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Update Twitter', 'Update Twitter', 0, 0, 0),
(719, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Facebook credentials updated', 'Facebook credentials updated', 0, 0, 0),
(720, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Facebook credentials could not be updated. Please, try again.', 'Facebook credentials could not be updated. Please, try again.', 0, 0, 0),
(721, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Site Categories', 'Site Categories', 0, 0, 0),
(722, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Site Category', 'Site Category', 0, 0, 0),
(723, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Add Site Category', 'Add Site Category', 0, 0, 0),
(724, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Site Category has been added', 'Site Category has been added', 0, 0, 0),
(725, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Site Category could not be added. Please, try again.', 'Site Category could not be added. Please, try again.', 0, 0, 0),
(726, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Edit Site Category', 'Edit Site Category', 0, 0, 0),
(727, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Site Category has been updated', 'Site Category has been updated', 0, 0, 0),
(728, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Site Category could not be updated. Please, try again.', 'Site Category could not be updated. Please, try again.', 0, 0, 0),
(729, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Site Category deleted', 'Site Category deleted', 0, 0, 0),
(730, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'States', 'States', 0, 0, 0),
(731, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Add State', 'Add State', 0, 0, 0),
(732, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'State has been added', 'State has been added', 0, 0, 0),
(733, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'State could not be added. Please, try again.', 'State could not be added. Please, try again.', 0, 0, 0),
(734, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Edit State', 'Edit State', 0, 0, 0),
(735, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'State has been updated', 'State has been updated', 0, 0, 0),
(736, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'State could not be updated. Please, try again.', 'State could not be updated. Please, try again.', 0, 0, 0),
(737, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'State deleted', 'State deleted', 0, 0, 0),
(738, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Temp Contacts', 'Temp Contacts', 0, 0, 0),
(739, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'No Action', 'No Action', 0, 0, 0),
(740, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Invite', 'Invite', 0, 0, 0),
(741, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Add as friend', 'Add as friend', 0, 0, 0),
(742, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Remove', 'Remove', 0, 0, 0),
(743, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Transaction Types', 'Transaction Types', 0, 0, 0),
(744, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Edit Transaction Type', 'Edit Transaction Type', 0, 0, 0),
(745, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Transaction Type has been updated', 'Transaction Type has been updated', 0, 0, 0),
(746, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Transaction Type could not be updated. Please, try again.', 'Transaction Type could not be updated. Please, try again.', 0, 0, 0),
(747, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Transactions', 'Transactions', 0, 0, 0),
(748, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'From date should greater than To date. Please, try again.', 'From date should greater than To date. Please, try again.', 0, 0, 0),
(749, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, ' - Amount Earned today', ' - Amount Earned today', 0, 0, 0),
(750, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, ' - Amount Earned in this week', ' - Amount Earned in this week', 0, 0, 0),
(751, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, ' - Amount Earned in this month', ' - Amount Earned in this month', 0, 0, 0),
(752, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'This Week', 'This Week', 0, 0, 0),
(753, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'This Month', 'This Month', 0, 0, 0),
(754, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Custom', 'Custom', 0, 0, 0),
(755, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Transactions - Today', 'Transactions - Today', 0, 0, 0),
(756, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, '- Today', '- Today', 0, 0, 0),
(757, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Transactions - This Week', 'Transactions - This Week', 0, 0, 0),
(758, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, '- This Week', '- This Week', 0, 0, 0),
(759, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Transactions - This Month', 'Transactions - This Month', 0, 0, 0),
(760, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, '- This Month', '- This Month', 0, 0, 0),
(761, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Transactions - Total', 'Transactions - Total', 0, 0, 0),
(762, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, '- Total', '- Total', 0, 0, 0),
(763, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Transaction deleted', 'Transaction deleted', 0, 0, 0),
(764, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Translations', 'Translations', 0, 0, 0),
(765, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Translation deleted successfully', 'Translation deleted successfully', 0, 0, 0),
(766, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Translation', 'Translation', 0, 0, 0),
(767, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Add New Language Variable', 'Add New Language Variable', 0, 0, 0),
(768, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Language variables has been added', 'Language variables has been added', 0, 0, 0),
(769, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Language variables could not be added', 'Language variables could not be added', 0, 0, 0),
(770, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Add Translation', 'Add Translation', 0, 0, 0),
(771, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Default English variable is missing', 'Default English variable is missing', 0, 0, 0),
(772, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Translation could not be updated. Please, try again.', 'Translation could not be updated. Please, try again.', 0, 0, 0),
(773, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Translation could not be updated. Please check iso2 of this language and try again', 'Translation could not be updated. Please check iso2 of this language and try again', 0, 0, 0),
(774, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Translation has been added', 'Translation has been added', 0, 0, 0),
(775, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Edit Translation', 'Edit Translation', 0, 0, 0),
(776, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, '\\"%s\\" Translation has been updated', '\\"%s\\" Translation has been updated', 0, 0, 0),
(777, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, '\\"%s\\" Translation could not be updated. Please, try again.', '\\"%s\\" Translation could not be updated. Please, try again.', 0, 0, 0),
(778, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Translation deleted', 'Translation deleted', 0, 0, 0),
(779, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Edit Translations', 'Edit Translations', 0, 0, 0),
(780, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Translation updated successfully', 'Translation updated successfully', 0, 0, 0),
(781, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, ' - Unverified ', ' - Unverified ', 0, 0, 0),
(782, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'User Add Wallet Amounts', 'User Add Wallet Amounts', 0, 0, 0),
(783, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'User Add Wallet Amount deleted', 'User Add Wallet Amount deleted', 0, 0, 0),
(784, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Withdraw Fund Request', 'Withdraw Fund Request', 0, 0, 0),
(785, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Add Fund Withdraw', 'Add Fund Withdraw', 0, 0, 0),
(786, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Withdraw Fund Requests', 'Withdraw Fund Requests', 0, 0, 0),
(787, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Withdraw fund request deleted', 'Withdraw fund request deleted', 0, 0, 0),
(788, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Checked requests have been moved to rejected status, Refunded  Money to Wallet', 'Checked requests have been moved to rejected status, Refunded  Money to Wallet', 0, 0, 0),
(789, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Recommendations', 'Recommendations', 0, 0, 0);
INSERT INTO `translations` (`id`, `created`, `modified`, `language_id`, `key`, `lang_text`, `is_translated`, `is_google_translate`, `is_verified`) VALUES
(790, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Recommendation', 'Recommendation', 0, 0, 0),
(791, '2012-01-11 17:04:28', '2012-01-11 17:04:28', 42, 'Add Recommendation', 'Add Recommendation', 0, 0, 0),
(792, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Recommendation has been added', 'Recommendation has been added', 0, 0, 0),
(793, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Recommendation could not be added. Please, try again.', 'Recommendation could not be added. Please, try again.', 0, 0, 0),
(794, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Edit Recommendation', 'Edit Recommendation', 0, 0, 0),
(795, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Recommendation has been updated', 'Recommendation has been updated', 0, 0, 0),
(796, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Recommendation could not be updated. Please, try again.', 'Recommendation could not be updated. Please, try again.', 0, 0, 0),
(797, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Recommendation deleted', 'Recommendation deleted', 0, 0, 0),
(798, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Checked recommendations has been deleted', 'Checked recommendations has been deleted', 0, 0, 0),
(799, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Educations', 'Educations', 0, 0, 0),
(800, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Add Education', 'Add Education', 0, 0, 0),
(801, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Education has been added', 'Education has been added', 0, 0, 0),
(802, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Education could not be added. Please, try again.', 'Education could not be added. Please, try again.', 0, 0, 0),
(803, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Edit Education', 'Edit Education', 0, 0, 0),
(804, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Education has been updated', 'Education has been updated', 0, 0, 0),
(805, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Education could not be updated. Please, try again.', 'Education could not be updated. Please, try again.', 0, 0, 0),
(806, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Education deleted', 'Education deleted', 0, 0, 0),
(807, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Employments', 'Employments', 0, 0, 0),
(808, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Add Employment', 'Add Employment', 0, 0, 0),
(809, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Employment has been added', 'Employment has been added', 0, 0, 0),
(810, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Employment could not be added. Please, try again.', 'Employment could not be added. Please, try again.', 0, 0, 0),
(811, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Edit Employment', 'Edit Employment', 0, 0, 0),
(812, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Employment has been updated', 'Employment has been updated', 0, 0, 0),
(813, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Employment could not be updated. Please, try again.', 'Employment could not be updated. Please, try again.', 0, 0, 0),
(814, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Employment deleted', 'Employment deleted', 0, 0, 0),
(815, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Accepted', 'Accepted', 0, 0, 0),
(816, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'My Friends', 'My Friends', 0, 0, 0),
(817, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Friends', 'Friends', 0, 0, 0),
(818, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Add User Friend', 'Add User Friend', 0, 0, 0),
(819, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Friend has been added.', 'Friend has been added.', 0, 0, 0),
(820, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Already added in your friend''s list.', 'Already added in your friend''s list.', 0, 0, 0),
(821, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Edit User Friend', 'Edit User Friend', 0, 0, 0),
(822, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, '\\"%s\\" User Friend has been updated', '\\"%s\\" User Friend has been updated', 0, 0, 0),
(823, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, '\\"%s\\" User Friend could not be updated. Please, try again.', '\\"%s\\" User Friend could not be updated. Please, try again.', 0, 0, 0),
(824, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'User Friend deleted', 'User Friend deleted', 0, 0, 0),
(825, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Removed', 'Removed', 0, 0, 0),
(826, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'User Friends', 'User Friends', 0, 0, 0),
(827, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'User Friend', 'User Friend', 0, 0, 0),
(828, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, '\\"%s\\" User Friend has been added', '\\"%s\\" User Friend has been added', 0, 0, 0),
(829, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, '\\"%s\\" User Friend could not be added. Please, try again.', '\\"%s\\" User Friend could not be added. Please, try again.', 0, 0, 0),
(830, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Friends Import', 'Friends Import', 0, 0, 0),
(831, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Plesae select a valid CSV file', 'Plesae select a valid CSV file', 0, 0, 0),
(832, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Your friend has been invited.', 'Your friend has been invited.', 0, 0, 0),
(833, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Problem in inviting.', 'Problem in inviting.', 0, 0, 0),
(834, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Income Ranges', 'Income Ranges', 0, 0, 0),
(835, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Add Income Range', 'Add Income Range', 0, 0, 0),
(836, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Income Range has been added', 'Income Range has been added', 0, 0, 0),
(837, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Income Range could not be added. Please, try again.', 'Income Range could not be added. Please, try again.', 0, 0, 0),
(838, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Edit Income Range', 'Edit Income Range', 0, 0, 0),
(839, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Income Range has been updated', 'Income Range has been updated', 0, 0, 0),
(840, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Income Range could not be updated. Please, try again.', 'Income Range could not be updated. Please, try again.', 0, 0, 0),
(841, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Income Range deleted', 'Income Range deleted', 0, 0, 0),
(842, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'User Logins', 'User Logins', 0, 0, 0),
(843, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'User Login deleted', 'User Login deleted', 0, 0, 0),
(844, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Manage Email Settings', 'Manage Email Settings', 0, 0, 0),
(845, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'User Notification has been updated', 'User Notification has been updated', 0, 0, 0),
(846, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'User Notification could not be updated. Please try again.', 'User Notification could not be updated. Please try again.', 0, 0, 0),
(847, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'User Openids', 'User Openids', 0, 0, 0),
(848, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Add New Openid', 'Add New Openid', 0, 0, 0),
(849, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Authenticated failed or you may not have profile in your OpenID account', 'Authenticated failed or you may not have profile in your OpenID account', 0, 0, 0),
(850, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'User Openid has been added', 'User Openid has been added', 0, 0, 0),
(851, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'User Openid could not be added. Please, try again.', 'User Openid could not be added. Please, try again.', 0, 0, 0),
(852, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Invalid OpenID', 'Invalid OpenID', 0, 0, 0),
(853, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'User Openid deleted', 'User Openid deleted', 0, 0, 0),
(854, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Sorry, you registered through OpenID account. So you should have atleast one OpenID account for login', 'Sorry, you registered through OpenID account. So you should have atleast one OpenID account for login', 0, 0, 0),
(855, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Checked user OpenIDs has been deleted', 'Checked user OpenIDs has been deleted', 0, 0, 0),
(856, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Credit Cards', 'Credit Cards', 0, 0, 0),
(857, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Add New Credit Card', 'Add New Credit Card', 0, 0, 0),
(858, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Invalid expire date', 'Invalid expire date', 0, 0, 0),
(859, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Edit Credit Card', 'Edit Credit Card', 0, 0, 0),
(860, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Credit card has been updated.', 'Credit card has been updated.', 0, 0, 0),
(861, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Credit card deleted', 'Credit card deleted', 0, 0, 0),
(862, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Credit card could not be deleted. Please, try again.', 'Credit card could not be deleted. Please, try again.', 0, 0, 0),
(863, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Credit card set as default successfully', 'Credit card set as default successfully', 0, 0, 0),
(864, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'PayPal Connections', 'PayPal Connections', 0, 0, 0),
(865, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'PayPal Connection deleted', 'PayPal Connection deleted', 0, 0, 0),
(866, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, '. PayPal Connection could not be deleted', '. PayPal Connection could not be deleted', 0, 0, 0),
(867, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'PayPal connection set as default successfully', 'PayPal connection set as default successfully', 0, 0, 0),
(868, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Edit Profile', 'Edit Profile', 0, 0, 0),
(869, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Enter verified PayPal email and the name associated with it', 'Enter verified PayPal email and the name associated with it', 0, 0, 0),
(870, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'User Profile has been updated', 'User Profile has been updated', 0, 0, 0),
(871, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'The file uploaded is too big, only files less than %s permitted', 'The file uploaded is too big, only files less than %s permitted', 0, 0, 0),
(872, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'User Profile could not be updated. Please, try again.', 'User Profile could not be updated. Please, try again.', 0, 0, 0),
(873, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Relationships', 'Relationships', 0, 0, 0),
(874, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Add Relationship', 'Add Relationship', 0, 0, 0),
(875, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Relationship has been added', 'Relationship has been added', 0, 0, 0),
(876, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Relationship could not be added. Please, try again.', 'Relationship could not be added. Please, try again.', 0, 0, 0),
(877, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Edit  Relationship', 'Edit  Relationship', 0, 0, 0),
(878, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Relationship has been updated', 'Relationship has been updated', 0, 0, 0),
(879, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Relationship could not be updated. Please, try again.', 'Relationship could not be updated. Please, try again.', 0, 0, 0),
(880, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Relationship deleted', 'Relationship deleted', 0, 0, 0),
(881, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'User Views', 'User Views', 0, 0, 0),
(882, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'User View deleted', 'User View deleted', 0, 0, 0),
(883, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'User', 'User', 0, 0, 0),
(884, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'User Registration', 'User Registration', 0, 0, 0),
(885, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Your registration process is not completed. Please, try again.', 'Your registration process is not completed. Please, try again.', 0, 0, 0),
(886, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'You have successfully registered with our site.', 'You have successfully registered with our site.', 0, 0, 0),
(887, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, ' You have successfully registered with our site after paying only login to site.', ' You have successfully registered with our site after paying only login to site.', 0, 0, 0),
(888, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'You have successfully registered with our site and your activation mail has been sent to your mail inbox.', 'You have successfully registered with our site and your activation mail has been sent to your mail inbox.', 0, 0, 0),
(889, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'verification is completed successfully. But you have to fill the following required fields to complete our registration process.', 'verification is completed successfully. But you have to fill the following required fields to complete our registration process.', 0, 0, 0),
(890, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Invalid Facebook Connection.', 'Invalid Facebook Connection.', 0, 0, 0),
(891, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Dashboard', 'Dashboard', 0, 0, 0),
(892, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Arrived / Confirmed', 'Arrived / Confirmed', 0, 0, 0),
(893, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Pending Host Accept', 'Pending Host Accept', 0, 0, 0),
(894, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Waiting For Your Review', 'Waiting For Your Review', 0, 0, 0),
(895, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Host Rejected', 'Host Rejected', 0, 0, 0),
(896, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Waiting for Acceptance', 'Waiting for Acceptance', 0, 0, 0),
(897, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Waiting for Traveler Review', 'Waiting for Traveler Review', 0, 0, 0),
(898, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Activate your account', 'Activate your account', 0, 0, 0),
(899, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Invalid activation request, please register again', 'Invalid activation request, please register again', 0, 0, 0),
(900, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Invalid activation request', 'Invalid activation request', 0, 0, 0),
(901, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'You have successfully activated your account. But you can login after pay the membership fee.', 'You have successfully activated your account. But you can login after pay the membership fee.', 0, 0, 0),
(902, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'You have successfully activated your account. But you can login after admin activate your account.', 'You have successfully activated your account. But you can login after admin activate your account.', 0, 0, 0),
(903, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'You have successfully activated and logged in to your account.', 'You have successfully activated and logged in to your account.', 0, 0, 0),
(904, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'You have successfully activated your account. Now you can login with your %s.', 'You have successfully activated your account. Now you can login with your %s.', 0, 0, 0),
(905, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Activation mail has been resent.', 'Activation mail has been resent.', 0, 0, 0),
(906, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'A Mail for activating your account has been sent.', 'A Mail for activating your account has been sent.', 0, 0, 0),
(907, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Try some time later as mail could not be dispatched due to some error in the server', 'Try some time later as mail could not be dispatched due to some error in the server', 0, 0, 0),
(908, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Invalid resend activation request, please register again', 'Invalid resend activation request, please register again', 0, 0, 0),
(909, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Problem in Facebook connect. Please try again', 'Problem in Facebook connect. Please try again', 0, 0, 0),
(910, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, ' You have successfully registered with our site after paying membership fee only you can login to site.', ' You have successfully registered with our site after paying membership fee only you can login to site.', 0, 0, 0),
(911, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'You should have minimum ', 'You should have minimum ', 0, 0, 0),
(912, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Login', 'Login', 0, 0, 0),
(913, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Sorry, login failed. Your ', 'Sorry, login failed. Your ', 0, 0, 0),
(914, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, ' or password are incorrect', ' or password are incorrect', 0, 0, 0),
(915, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Invalid OpenID entered. Please enter valid OpenID', 'Invalid OpenID entered. Please enter valid OpenID', 0, 0, 0),
(916, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Problem in Twitter connect. Please try again', 'Problem in Twitter connect. Please try again', 0, 0, 0),
(917, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Your Twitter credentials are updated', 'Your Twitter credentials are updated', 0, 0, 0),
(918, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Twitter login/register allows only twitter user must have ', 'Twitter login/register allows only twitter user must have ', 0, 0, 0),
(919, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, ' followers count or account registered ', ' followers count or account registered ', 0, 0, 0),
(920, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, ' month ago', ' month ago', 0, 0, 0),
(921, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'You are now logged out of the site.', 'You are now logged out of the site.', 0, 0, 0),
(922, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'Forgot Password', 'Forgot Password', 0, 0, 0),
(923, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'An email has been sent with a link where you can change your password', 'An email has been sent with a link where you can change your password', 0, 0, 0),
(924, '2012-01-11 17:04:29', '2012-01-11 17:04:29', 42, 'There is no user registered with the email ', 'There is no user registered with the email ', 0, 0, 0),
(925, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'There is no user registered with the email %s or admin deactivated your account. If you spelled the address incorrectly or entered the wrong address, please try again.', 'There is no user registered with the email %s or admin deactivated your account. If you spelled the address incorrectly or entered the wrong address, please try again.', 0, 0, 0),
(926, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Reset Password', 'Reset Password', 0, 0, 0),
(927, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Your password has been changed successfully, Please login now', 'Your password has been changed successfully, Please login now', 0, 0, 0),
(928, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Invalid change password request', 'Invalid change password request', 0, 0, 0),
(929, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'User cannot be found in server or admin deactivated your account, please register again', 'User cannot be found in server or admin deactivated your account, please register again', 0, 0, 0),
(930, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Change Password', 'Change Password', 0, 0, 0),
(931, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Your password has been changed successfully. Please login now', 'Your password has been changed successfully. Please login now', 0, 0, 0),
(932, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Password has been changed successfully', 'Password has been changed successfully', 0, 0, 0),
(933, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Password could not be changed', 'Password could not be changed', 0, 0, 0),
(934, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Referrer username does not exist.', 'Referrer username does not exist.', 0, 0, 0),
(935, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Add Amount to Wallet', 'Add Amount to Wallet', 0, 0, 0),
(936, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Selected PayPal connection have insufficient money to book this property', 'Selected PayPal connection have insufficient money to book this property', 0, 0, 0),
(937, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Amount could not be added to wallet', 'Amount could not be added to wallet', 0, 0, 0),
(938, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'carteira', 'carteira', 0, 0, 0),
(939, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Amount added to wallet', 'Amount added to wallet', 0, 0, 0),
(940, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Social Networks', 'Social Networks', 0, 0, 0),
(941, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Social networks settings updated successfully.', 'Social networks settings updated successfully.', 0, 0, 0),
(942, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'You have successfully connected with Facebook.', 'You have successfully connected with Facebook.', 0, 0, 0),
(943, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Users', 'Users', 0, 0, 0),
(944, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, ' - Registered through OpenID ', ' - Registered through OpenID ', 0, 0, 0),
(945, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, ' - Registered through Gmail ', ' - Registered through Gmail ', 0, 0, 0),
(946, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, ' - Registered through Yahoo ', ' - Registered through Yahoo ', 0, 0, 0),
(947, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, ' - Registered through Twitter ', ' - Registered through Twitter ', 0, 0, 0),
(948, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, ' - Registered through Facebook ', ' - Registered through Facebook ', 0, 0, 0),
(949, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, ' - Notified Inactive Users ', ' - Notified Inactive Users ', 0, 0, 0),
(950, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Active', 'Active', 0, 0, 0),
(951, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Inactive', 'Inactive', 0, 0, 0),
(952, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Yes', 'Yes', 0, 0, 0),
(953, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'No', 'No', 0, 0, 0),
(954, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Add New User/Admin', 'Add New User/Admin', 0, 0, 0),
(955, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'User has been added', 'User has been added', 0, 0, 0),
(956, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'User could not be added. Please, try again.', 'User could not be added. Please, try again.', 0, 0, 0),
(957, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'User has been deleted', 'User has been deleted', 0, 0, 0),
(958, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Checked users has been inactivated', 'Checked users has been inactivated', 0, 0, 0),
(959, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Checked users has been activated', 'Checked users has been activated', 0, 0, 0),
(960, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Checked users has been deleted', 'Checked users has been deleted', 0, 0, 0),
(961, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Site Stats', 'Site Stats', 0, 0, 0),
(962, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Revenue from traveler commission', 'Revenue from traveler commission', 0, 0, 0),
(963, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Revenue from host commission', 'Revenue from host commission', 0, 0, 0),
(964, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Revenue from listing fee', 'Revenue from listing fee', 0, 0, 0),
(965, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Revenue from verify fee', 'Revenue from verify fee', 0, 0, 0),
(966, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Total Revenue', 'Total Revenue', 0, 0, 0),
(967, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Signups', 'Signups', 0, 0, 0),
(968, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Active Users', 'Active Users', 0, 0, 0),
(969, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Facebook Users', 'Facebook Users', 0, 0, 0),
(970, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Twitter Users', 'Twitter Users', 0, 0, 0),
(971, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'OpenID Users', 'OpenID Users', 0, 0, 0),
(972, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Gmail Users', 'Gmail Users', 0, 0, 0),
(973, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Yahoo Users', 'Yahoo Users', 0, 0, 0),
(974, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Logins', 'Logins', 0, 0, 0),
(975, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Normal Users', 'Normal Users', 0, 0, 0),
(976, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Waiting for approval', 'Waiting for approval', 0, 0, 0),
(977, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Waiting for verification review', 'Waiting for verification review', 0, 0, 0),
(978, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Waiting for confirm', 'Waiting for confirm', 0, 0, 0),
(979, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Waiting for review', 'Waiting for review', 0, 0, 0),
(980, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Views', 'Views', 0, 0, 0),
(981, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Favorites', 'Favorites', 0, 0, 0),
(982, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Property Booking Disputes', 'Property Booking Disputes', 0, 0, 0),
(983, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Email to users', 'Email to users', 0, 0, 0),
(984, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Email sent successfully', 'Email sent successfully', 0, 0, 0),
(985, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Email sent successfully. Some emails are not sent', 'Email sent successfully. Some emails are not sent', 0, 0, 0),
(986, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'No email send', 'No email send', 0, 0, 0),
(987, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Email couldn''t be sent! Enter all required fields', 'Email couldn''t be sent! Enter all required fields', 0, 0, 0),
(988, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Contact us - Reply', 'Contact us - Reply', 0, 0, 0),
(989, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Cache Files has been cleared', 'Cache Files has been cleared', 0, 0, 0),
(990, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Diagnostics', 'Diagnostics', 0, 0, 0),
(991, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'review link', 'review link', 0, 0, 0),
(992, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'day', 'day', 0, 0, 0),
(993, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Email recovery is not properly informed', 'Email recovery is not properly informed', 0, 0, 0),
(994, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Should be numeric', 'Should be numeric', 0, 0, 0),
(995, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Approved...', 'Approved...', 0, 0, 0),
(996, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Given amount is greater than your commission amount', 'Given amount is greater than your commission amount', 0, 0, 0),
(997, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Given amount is less than withdraw limit', 'Given amount is less than withdraw limit', 0, 0, 0),
(998, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'one the selected withdrawal has not configured the money transfer account. Please try again', 'one the selected withdrawal has not configured the money transfer account. Please try again', 0, 0, 0),
(999, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Enter valid URL', 'Enter valid URL', 0, 0, 0),
(1000, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Approve', 'Approve', 0, 0, 0),
(1001, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Disapprove', 'Disapprove', 0, 0, 0),
(1002, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Delete', 'Delete', 0, 0, 0),
(1003, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Enter number higher than 0', 'Enter number higher than 0', 0, 0, 0),
(1004, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'You cannot add your own domain in redirect URL', 'You cannot add your own domain in redirect URL', 0, 0, 0),
(1005, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Must be a valid URL, starting with http://', 'Must be a valid URL, starting with http://', 0, 0, 0),
(1006, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Single IP or hostname', 'Single IP or hostname', 0, 0, 0),
(1007, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'IP Range', 'IP Range', 0, 0, 0),
(1008, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Referer block', 'Referer block', 0, 0, 0),
(1009, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Permanent', 'Permanent', 0, 0, 0),
(1010, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Day(s)', 'Day(s)', 0, 0, 0),
(1011, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Week(s)', 'Week(s)', 0, 0, 0),
(1012, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Must be a number without decimal', 'Must be a number without decimal', 0, 0, 0),
(1013, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Should be a number less than or equal to 100', 'Should be a number less than or equal to 100', 0, 0, 0),
(1014, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Must be a numeric', 'Must be a numeric', 0, 0, 0),
(1015, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Unapproved', 'Unapproved', 0, 0, 0),
(1016, '2012-01-11 17:04:30', '2012-01-11 17:04:30', 42, 'Must be a valid email', 'Must be a valid email', 0, 0, 0),
(1017, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Please enter valid captcha', 'Please enter valid captcha', 0, 0, 0),
(1018, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Give numeric format', 'Give numeric format', 0, 0, 0),
(1019, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Labels already exist.', 'Labels already exist.', 0, 0, 0),
(1020, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Masspay not completed. Please try again', 'Masspay not completed. Please try again', 0, 0, 0),
(1021, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Exceeded the allowed discount amount, give less than ', 'Exceeded the allowed discount amount, give less than ', 0, 0, 0),
(1022, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, '%', '%', 0, 0, 0),
(1023, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Suspend', 'Suspend', 0, 0, 0),
(1024, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Unsuspend', 'Unsuspend', 0, 0, 0),
(1025, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Flag', 'Flag', 0, 0, 0),
(1026, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Clear flag', 'Clear flag', 0, 0, 0),
(1027, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Create Label', 'Create Label', 0, 0, 0),
(1028, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'You must agree to the terms and conditions', 'You must agree to the terms and conditions', 0, 0, 0),
(1029, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Accept your booking', 'Accept your booking', 0, 0, 0),
(1030, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'reject', 'reject', 0, 0, 0),
(1031, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Reject your booking', 'Reject your booking', 0, 0, 0),
(1032, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'cancel', 'cancel', 0, 0, 0),
(1033, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Cancel your booking', 'Cancel your booking', 0, 0, 0),
(1034, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'balance', 'balance', 0, 0, 0),
(1035, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'You have a new booking', 'You have a new booking', 0, 0, 0),
(1036, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Your booking has been placed', 'Your booking has been placed', 0, 0, 0),
(1037, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Test Mode', 'Test Mode', 0, 0, 0),
(1038, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Live Mode', 'Live Mode', 0, 0, 0),
(1039, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Auto Approved', 'Auto Approved', 0, 0, 0),
(1040, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Non Auto Approved', 'Non Auto Approved', 0, 0, 0),
(1041, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Must be between of %s to %s', 'Must be between of %s to %s', 0, 0, 0),
(1042, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Must be greater than zero', 'Must be greater than zero', 0, 0, 0),
(1043, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Enter valid format', 'Enter valid format', 0, 0, 0),
(1044, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Must be less than maximum number of guests', 'Must be less than maximum number of guests', 0, 0, 0),
(1045, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Must be greater than minimum nights', 'Must be greater than minimum nights', 0, 0, 0),
(1046, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Must be a valid video URL', 'Must be a valid video URL', 0, 0, 0),
(1047, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Hide street view', 'Hide street view', 0, 0, 0),
(1048, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Closest to my address', 'Closest to my address', 0, 0, 0),
(1049, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Nearby (within 2 blocks)', 'Nearby (within 2 blocks)', 0, 0, 0),
(1050, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Square Feet', 'Square Feet', 0, 0, 0),
(1051, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Square Meters', 'Square Meters', 0, 0, 0),
(1052, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Disable', 'Disable', 0, 0, 0),
(1053, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Enable', 'Enable', 0, 0, 0),
(1054, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Add in collection', 'Add in collection', 0, 0, 0),
(1055, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Oops, seems you given wrong date or greater than checkout date, please check it!', 'Oops, seems you given wrong date or greater than checkout date, please check it!', 0, 0, 0),
(1056, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Selected date not available, Please select some other date or check calendar!', 'Selected date not available, Please select some other date or check calendar!', 0, 0, 0),
(1057, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Oops, seems you given wrong date or less than checkin date, please check it!', 'Oops, seems you given wrong date or less than checkin date, please check it!', 0, 0, 0),
(1058, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Invalid Selection', 'Invalid Selection', 0, 0, 0),
(1059, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Your selection is exceeded the allowed guest limit', 'Your selection is exceeded the allowed guest limit', 0, 0, 0),
(1060, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Waiting for acceptance', 'Waiting for acceptance', 0, 0, 0),
(1061, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Waiting for traveler review', 'Waiting for traveler review', 0, 0, 0),
(1062, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Canceled by traveler', 'Canceled by traveler', 0, 0, 0),
(1063, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Canceled by admin', 'Canceled by admin', 0, 0, 0),
(1064, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'In progress', 'In progress', 0, 0, 0),
(1065, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Address:', 'Address:', 0, 0, 0),
(1066, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Phone:', 'Phone:', 0, 0, 0),
(1067, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Your booking has been accepted', 'Your booking has been accepted', 0, 0, 0),
(1068, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'You have accepted your booking', 'You have accepted your booking', 0, 0, 0),
(1069, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'You have successfully accepted the booking request', 'You have successfully accepted the booking request', 0, 0, 0),
(1070, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'You have successfully canceled your booked property.', 'You have successfully canceled your booked property.', 0, 0, 0),
(1071, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Your booking has been canceled', 'Your booking has been canceled', 0, 0, 0),
(1072, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'You have canceled your booking', 'You have canceled your booking', 0, 0, 0),
(1073, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'According to our Cancellation Policies, partially amount has been refunded to your account.', 'According to our Cancellation Policies, partially amount has been refunded to your account.', 0, 0, 0),
(1074, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'According to our Cancellation Policies, partially amount has been cleared for your withdrawal. Remaining has been refunded to traveler.', 'According to our Cancellation Policies, partially amount has been cleared for your withdrawal. Remaining has been refunded to traveler.', 0, 0, 0),
(1075, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'You have successfully canceled your booking.', 'You have successfully canceled your booking.', 0, 0, 0),
(1076, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'You cancellation process was failed', 'You cancellation process was failed', 0, 0, 0),
(1077, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'You cannot cancel this booking', 'You cannot cancel this booking', 0, 0, 0),
(1078, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'You have successfully entered your arrived status', 'You have successfully entered your arrived status', 0, 0, 0),
(1079, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Checkin date has arrived.', 'Checkin date has arrived.', 0, 0, 0),
(1080, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'You have rejected successfully', 'You have rejected successfully', 0, 0, 0),
(1081, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Your booking has been rejected', 'Your booking has been rejected', 0, 0, 0),
(1082, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'You have rejected your booking', 'You have rejected your booking', 0, 0, 0),
(1083, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Your booking has been canceled by admin', 'Your booking has been canceled by admin', 0, 0, 0),
(1084, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Your work has been delivered successfully!', 'Your work has been delivered successfully!', 0, 0, 0),
(1085, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Your booking has been completed', 'Your booking has been completed', 0, 0, 0),
(1086, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'You completed the booking, please give review and ratet the property!', 'You completed the booking, please give review and ratet the property!', 0, 0, 0),
(1087, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Booking couldn''t be processed at the moment. Try again', 'Booking couldn''t be processed at the moment. Try again', 0, 0, 0),
(1088, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'According to our \\"Cancellation policy\\", you wont be refund.', 'According to our \\"Cancellation policy\\", you wont be refund.', 0, 0, 0),
(1089, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'According to our \\"Cancellation policy\\", buyer wont be refund and your amount will be cleared for withdrawal.', 'According to our \\"Cancellation policy\\", buyer wont be refund and your amount will be cleared for withdrawal.', 0, 0, 0),
(1090, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Open', 'Open', 0, 0, 0),
(1091, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'UnderDiscussion', 'UnderDiscussion', 0, 0, 0),
(1092, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'WaitingForAdministratorDecision', 'WaitingForAdministratorDecision', 0, 0, 0),
(1093, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Closed', 'Closed', 0, 0, 0),
(1094, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Based on Dispute ID#', 'Based on Dispute ID#', 0, 0, 0),
(1095, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Feedback has been changed by site administrator', 'Feedback has been changed by site administrator', 0, 0, 0),
(1096, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Original Feedback:', 'Original Feedback:', 0, 0, 0),
(1097, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Disapproved', 'Disapproved', 0, 0, 0),
(1098, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Oops, seems you given wrong date or greater than checkout date or less than current date, please check it!', 'Oops, seems you given wrong date or greater than checkout date or less than current date, please check it!', 0, 0, 0),
(1099, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Should be valid date', 'Should be valid date', 0, 0, 0),
(1100, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Oops, seems you given wrong date or less than checkin date or less than current date, please check it!', 'Oops, seems you given wrong date or less than checkin date or less than current date, please check it!', 0, 0, 0),
(1101, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Should be greater than 0', 'Should be greater than 0', 0, 0, 0),
(1102, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Should be valid amount', 'Should be valid amount', 0, 0, 0),
(1103, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Must be between of 3 to 20 characters', 'Must be between of 3 to 20 characters', 0, 0, 0),
(1104, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Only use letters and numbers.', 'Only use letters and numbers.', 0, 0, 0),
(1105, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Username is already exist', 'Username is already exist', 0, 0, 0),
(1106, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Must be start with an alphabets', 'Must be start with an alphabets', 0, 0, 0),
(1107, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Email address is already exist', 'Email address is already exist', 0, 0, 0),
(1108, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Must be at least 6 characters', 'Must be at least 6 characters', 0, 0, 0),
(1109, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Your old password is incorrect, please try again', 'Your old password is incorrect, please try again', 0, 0, 0),
(1110, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'New and confirm password field must match, please try again', 'New and confirm password field must match, please try again', 0, 0, 0),
(1111, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Export', 'Export', 0, 0, 0),
(1112, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'All Users', 'All Users', 0, 0, 0),
(1113, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Inactive Users', 'Inactive Users', 0, 0, 0),
(1114, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Amount should be Numeric', 'Amount should be Numeric', 0, 0, 0),
(1115, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Amount should be greater than minimum amount', 'Amount should be greater than minimum amount', 0, 0, 0),
(1116, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Given amount should lies from  %s%s to %s%s', 'Given amount should lies from  %s%s to %s%s', 0, 0, 0),
(1117, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Given amount is greater than wallet amount', 'Given amount is greater than wallet amount', 0, 0, 0),
(1118, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Must be in numeric', 'Must be in numeric', 0, 0, 0),
(1119, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'OpenID already exist', 'OpenID already exist', 0, 0, 0),
(1120, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Enter valid OpenID', 'Enter valid OpenID', 0, 0, 0),
(1121, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Must be a valid date', 'Must be a valid date', 0, 0, 0),
(1122, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Added On', 'Added On', 0, 0, 0),
(1123, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'IP', 'IP', 0, 0, 0),
(1124, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Post Variable', 'Post Variable', 0, 0, 0),
(1125, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'No Adaptive Ipn Logs available', 'No Adaptive Ipn Logs available', 0, 0, 0),
(1126, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Actions', 'Actions', 0, 0, 0),
(1127, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Id', 'Id', 0, 0, 0),
(1128, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Created', 'Created', 0, 0, 0),
(1129, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Foreign', 'Foreign', 0, 0, 0),
(1130, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Class', 'Class', 0, 0, 0),
(1131, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Transaction', 'Transaction', 0, 0, 0),
(1132, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Amount', 'Amount', 0, 0, 0),
(1133, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Email', 'Email', 0, 0, 0),
(1134, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Primary', 'Primary', 0, 0, 0),
(1135, '2012-01-11 17:04:31', '2012-01-11 17:04:31', 42, 'Invoice', 'Invoice', 0, 0, 0),
(1136, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Refunded Amount', 'Refunded Amount', 0, 0, 0),
(1137, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Pending Refund', 'Pending Refund', 0, 0, 0),
(1138, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Sender Transaction', 'Sender Transaction', 0, 0, 0),
(1139, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Sender Transaction Status', 'Sender Transaction Status', 0, 0, 0),
(1140, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'TimeStamp', 'TimeStamp', 0, 0, 0),
(1141, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Acknowledgment', 'Acknowledgment', 0, 0, 0),
(1142, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Correlation', 'Correlation', 0, 0, 0),
(1143, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Build', 'Build', 0, 0, 0),
(1144, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Currency Code', 'Currency Code', 0, 0, 0),
(1145, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Sender Email', 'Sender Email', 0, 0, 0),
(1146, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Status', 'Status', 0, 0, 0),
(1147, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Tracking', 'Tracking', 0, 0, 0),
(1148, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Pay Key', 'Pay Key', 0, 0, 0),
(1149, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Action Type', 'Action Type', 0, 0, 0),
(1150, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Fees Payer', 'Fees Payer', 0, 0, 0),
(1151, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Memo', 'Memo', 0, 0, 0),
(1152, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Reverse All Parallel Payments On Error', 'Reverse All Parallel Payments On Error', 0, 0, 0),
(1153, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Refund Status', 'Refund Status', 0, 0, 0),
(1154, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Refund Net Amount', 'Refund Net Amount', 0, 0, 0),
(1155, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Refund Fee Amount', 'Refund Fee Amount', 0, 0, 0),
(1156, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Refund Gross Amount', 'Refund Gross Amount', 0, 0, 0),
(1157, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Total Of Alll Refunds', 'Total Of Alll Refunds', 0, 0, 0),
(1158, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Refund Has Become Full', 'Refund Has Become Full', 0, 0, 0),
(1159, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Encrypted Refund Transaction', 'Encrypted Refund Transaction', 0, 0, 0),
(1160, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Refund Transaction Status', 'Refund Transaction Status', 0, 0, 0),
(1161, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'View', 'View', 0, 0, 0),
(1162, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'No Adaptive Transaction Logs available', 'No Adaptive Transaction Logs available', 0, 0, 0),
(1163, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Modified', 'Modified', 0, 0, 0),
(1164, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Foreign Id', 'Foreign Id', 0, 0, 0),
(1165, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Transaction Id', 'Transaction Id', 0, 0, 0),
(1166, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Invoice Id', 'Invoice Id', 0, 0, 0),
(1167, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Sender Transaction Id', 'Sender Transaction Id', 0, 0, 0),
(1168, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Timestamp', 'Timestamp', 0, 0, 0),
(1169, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Ack', 'Ack', 0, 0, 0),
(1170, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Correlation Id', 'Correlation Id', 0, 0, 0),
(1171, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Tracking Id', 'Tracking Id', 0, 0, 0),
(1172, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Encrypted Refund Transaction Id', 'Encrypted Refund Transaction Id', 0, 0, 0),
(1173, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'PayPal Post Vars', 'PayPal Post Vars', 0, 0, 0),
(1174, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Generate Affiliate Widget', 'Generate Affiliate Widget', 0, 0, 0);
INSERT INTO `translations` (`id`, `created`, `modified`, `language_id`, `key`, `lang_text`, `is_translated`, `is_google_translate`, `is_verified`) VALUES
(1175, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'The requested amount will be deducted from your affiliate commission amount and the amount will be blocked until it get approved or rejected by the administrator. Once it''s approved, the requested amount will be sent to your paypal account. In case of failure, the amount will be refunded to your affiliate commission amount.', 'The requested amount will be deducted from your affiliate commission amount and the amount will be blocked until it get approved or rejected by the administrator. Once it''s approved, the requested amount will be sent to your paypal account. In case of failure, the amount will be refunded to your affiliate commission amount.', 0, 0, 0),
(1176, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Transaction Fee', 'Transaction Fee', 0, 0, 0),
(1177, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Minimum withdraw amount: %s <br/>  Commission amount: %s  %s', 'Minimum withdraw amount: %s <br/>  Commission amount: %s  %s', 0, 0, 0),
(1178, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Request Withdraw', 'Request Withdraw', 0, 0, 0),
(1179, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Affiliate module is currently enabled. You can disable or configure it from', 'Affiliate module is currently enabled. You can disable or configure it from', 0, 0, 0),
(1180, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, ' page', ' page', 0, 0, 0),
(1181, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Under Process', 'Under Process', 0, 0, 0),
(1182, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Failed', 'Failed', 0, 0, 0),
(1183, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Following withdrawal request has been submitted to payment geteway API, These are waiting for IPN from the payment geteway API. Eiether it will move to Success or Failed', 'Following withdrawal request has been submitted to payment geteway API, These are waiting for IPN from the payment geteway API. Eiether it will move to Success or Failed', 0, 0, 0),
(1184, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Withdrawal fund frequest which were unable to process will be returned as failed. The amount requested will be automatically refunded to the user.', 'Withdrawal fund frequest which were unable to process will be returned as failed. The amount requested will be automatically refunded to the user.', 0, 0, 0),
(1185, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Transfer Account: ', 'Transfer Account: ', 0, 0, 0),
(1186, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Action', 'Action', 0, 0, 0),
(1187, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Requested on', 'Requested on', 0, 0, 0),
(1188, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Paid on', 'Paid on', 0, 0, 0),
(1189, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Move to success', 'Move to success', 0, 0, 0),
(1190, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Move to failed', 'Move to failed', 0, 0, 0),
(1191, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, '[Image: %s]', '[Image: %s]', 0, 0, 0),
(1192, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'No records available', 'No records available', 0, 0, 0),
(1193, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Select:', 'Select:', 0, 0, 0),
(1194, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'None', 'None', 0, 0, 0),
(1195, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, '-- More actions --', '-- More actions --', 0, 0, 0),
(1196, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Gateway', 'Gateway', 0, 0, 0),
(1197, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Paid Amount', 'Paid Amount', 0, 0, 0),
(1198, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Proceed', 'Proceed', 0, 0, 0),
(1199, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Your money transfer account is empty, so click here to update your money transfer account.', 'Your money transfer account is empty, so click here to update your money transfer account.', 0, 0, 0),
(1200, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Edit money transfer accounts', 'Edit money transfer accounts', 0, 0, 0),
(1201, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Requested On', 'Requested On', 0, 0, 0),
(1202, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'No withdraw requests available', 'No withdraw requests available', 0, 0, 0),
(1203, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Your request will be confirmed after admin approval.', 'Your request will be confirmed after admin approval.', 0, 0, 0),
(1204, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Sorry, admin declined your request. If you want submit once again please', 'Sorry, admin declined your request. If you want submit once again please', 0, 0, 0),
(1205, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Click Here', 'Click Here', 0, 0, 0),
(1206, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'This request will be confirmed after admin approval.', 'This request will be confirmed after admin approval.', 0, 0, 0),
(1207, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Site Name', 'Site Name', 0, 0, 0),
(1208, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Site Description', 'Site Description', 0, 0, 0),
(1209, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Site URL', 'Site URL', 0, 0, 0),
(1210, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Why Do You Want An Affiliate?', 'Why Do You Want An Affiliate?', 0, 0, 0),
(1211, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Web Site Marketing?', 'Web Site Marketing?', 0, 0, 0),
(1212, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Search Engine Marketing?', 'Search Engine Marketing?', 0, 0, 0),
(1213, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Email Marketing?', 'Email Marketing?', 0, 0, 0),
(1214, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Special Promotional Method', 'Special Promotional Method', 0, 0, 0),
(1215, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Special Promotional Description', 'Special Promotional Description', 0, 0, 0),
(1216, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Why Do You Want Affiliate?', 'Why Do You Want Affiliate?', 0, 0, 0),
(1217, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Approved?', 'Approved?', 0, 0, 0),
(1218, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Update', 'Update', 0, 0, 0),
(1219, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Keyword', 'Keyword', 0, 0, 0),
(1220, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Search', 'Search', 0, 0, 0),
(1221, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Select', 'Select', 0, 0, 0),
(1222, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Why Do You Want Affiliate', 'Why Do You Want Affiliate', 0, 0, 0),
(1223, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Website Marketing?', 'Website Marketing?', 0, 0, 0),
(1224, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Email Marketing', 'Email Marketing', 0, 0, 0),
(1225, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Promotional Method', 'Promotional Method', 0, 0, 0),
(1226, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Edit', 'Edit', 0, 0, 0),
(1227, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'No Affiliate Requests available', 'No Affiliate Requests available', 0, 0, 0),
(1228, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Submit', 'Submit', 0, 0, 0),
(1229, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Commission Settings', 'Commission Settings', 0, 0, 0),
(1230, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Name', 'Name', 0, 0, 0),
(1231, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Commission', 'Commission', 0, 0, 0),
(1232, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Commission Type', 'Commission Type', 0, 0, 0),
(1233, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Active?', 'Active?', 0, 0, 0),
(1234, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'No Affiliate Types available', 'No Affiliate Types available', 0, 0, 0),
(1235, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Affiliate  Requests', 'Affiliate  Requests', 0, 0, 0),
(1236, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Affiliates  Requests', 'Affiliates  Requests', 0, 0, 0),
(1237, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Affiliate Cash Withdrawal Requests', 'Affiliate Cash Withdrawal Requests', 0, 0, 0),
(1238, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Commission History', 'Commission History', 0, 0, 0),
(1239, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Affiliate User', 'Affiliate User', 0, 0, 0),
(1240, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Type', 'Type', 0, 0, 0),
(1241, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Since', 'Since', 0, 0, 0),
(1242, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'No commission history available', 'No commission history available', 0, 0, 0),
(1243, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Click to View Details', 'Click to View Details', 0, 0, 0),
(1244, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Share your below unique link for referral purposes', 'Share your below unique link for referral purposes', 0, 0, 0),
(1245, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Share your below unique link by appending to end of site URL for referral', 'Share your below unique link by appending to end of site URL for referral', 0, 0, 0),
(1246, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'User/Property', 'User/Property', 0, 0, 0),
(1247, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Commission (', 'Commission (', 0, 0, 0),
(1248, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, ')', ')', 0, 0, 0),
(1249, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, ' Add', ' Add', 0, 0, 0),
(1250, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'No Amenities available', 'No Amenities available', 0, 0, 0),
(1251, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Authorize amt', 'Authorize amt', 0, 0, 0),
(1252, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Authorize avscode', 'Authorize avscode', 0, 0, 0),
(1253, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Authorize Authorization Code', 'Authorize Authorization Code', 0, 0, 0),
(1254, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Authorize Response Text', 'Authorize Response Text', 0, 0, 0),
(1255, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Authorize Response', 'Authorize Response', 0, 0, 0),
(1256, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'No Authorizenet Docapture Logs available', 'No Authorizenet Docapture Logs available', 0, 0, 0),
(1257, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Payment Status', 'Payment Status', 0, 0, 0),
(1258, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Authorize Amt', 'Authorize Amt', 0, 0, 0),
(1259, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Authorize Avscode', 'Authorize Avscode', 0, 0, 0),
(1260, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Your IP: ', 'Your IP: ', 0, 0, 0),
(1261, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Your Hostname: ', 'Your Hostname: ', 0, 0, 0),
(1262, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Select method', 'Select method', 0, 0, 0),
(1263, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Address/Range', 'Address/Range', 0, 0, 0),
(1264, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, '(IP address, domain or hostname)', '(IP address, domain or hostname)', 0, 0, 0),
(1265, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Possibilities:', 'Possibilities:', 0, 0, 0),
(1266, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, '- Single IP/Hostname: Fill in either a hostname or IP address in the first field.', '- Single IP/Hostname: Fill in either a hostname or IP address in the first field.', 0, 0, 0),
(1267, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, '- IP Range: Put the starting IP address in the left and the ending IP address in the right field.', '- IP Range: Put the starting IP address in the left and the ending IP address in the right field.', 0, 0, 0),
(1268, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, '- Referer block: To block google.com put google.com in the first field. To block google altogether.', '- Referer block: To block google.com put google.com in the first field. To block google altogether.', 0, 0, 0),
(1269, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, '(optional, shown to victim)', '(optional, shown to victim)', 0, 0, 0),
(1270, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, '(optional)', '(optional)', 0, 0, 0),
(1271, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'How long', 'How long', 0, 0, 0),
(1272, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Leave field empty when using permanent. Fill in a number higher than 0 when using another option!', 'Leave field empty when using permanent. Fill in a number higher than 0 when using another option!', 0, 0, 0),
(1273, '2012-01-11 17:04:32', '2012-01-11 17:04:32', 42, 'Hints and tips:', 'Hints and tips:', 0, 0, 0),
(1274, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, '- Banning hosts in the 10.x.x.x / 169.254.x.x / 172.16.x.x or 192.168.x.x range probably won''t work.', '- Banning hosts in the 10.x.x.x / 169.254.x.x / 172.16.x.x or 192.168.x.x range probably won''t work.', 0, 0, 0),
(1275, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, '- Banning by internet hostname might work unexpectedly and resulting in banning multiple people from the same ISP!', '- Banning by internet hostname might work unexpectedly and resulting in banning multiple people from the same ISP!', 0, 0, 0),
(1276, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, '- Wildcards on IP addresses are allowed. Block 84.234.*.* to block the whole 84.234.x.x range!', '- Wildcards on IP addresses are allowed. Block 84.234.*.* to block the whole 84.234.x.x range!', 0, 0, 0),
(1277, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, '- Setting a ban on a range of IP addresses might work unexpected and can result in false positives!', '- Setting a ban on a range of IP addresses might work unexpected and can result in false positives!', 0, 0, 0),
(1278, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, '- An IP address always contains 4 parts with numbers no higher than 254 separated by a dot!', '- An IP address always contains 4 parts with numbers no higher than 254 separated by a dot!', 0, 0, 0),
(1279, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, '- If a ban does not seem to work try to find out if the person you''re trying to ban doesn''t use <a href=\\"http://en.wikipedia.org/wiki/DHCP\\" target=\\"_blank\\">DHCP.</a>', '- If a ban does not seem to work try to find out if the person you''re trying to ban doesn''t use <a href=\\"http://en.wikipedia.org/wiki/DHCP\\" target=\\"_blank\\">DHCP.</a>', 0, 0, 0),
(1280, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, '- A temporary ban is automatically removed when it expires.', '- A temporary ban is automatically removed when it expires.', 0, 0, 0),
(1281, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, '- To block a domain you can use keywords. Just blocking \\"meandmymac\\" would work almost the same as blocking \\"meandmymac.net\\". However, when putting just ''meandmymac'', ALL extensions (.com .net .co.ck. co.uk etc.) are blocked!!', '- To block a domain you can use keywords. Just blocking \\"meandmymac\\" would work almost the same as blocking \\"meandmymac.net\\". However, when putting just ''meandmymac'', ALL extensions (.com .net .co.ck. co.uk etc.) are blocked!!', 0, 0, 0),
(1282, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, '- For more questions please seek help at my <a href=\\"http://forum.at.meandmymac.net/\\" target=\\"_blank\\">support pages.</a>', '- For more questions please seek help at my <a href=\\"http://forum.at.meandmymac.net/\\" target=\\"_blank\\">support pages.</a>', 0, 0, 0),
(1283, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Victims', 'Victims', 0, 0, 0),
(1284, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Reason', 'Reason', 0, 0, 0),
(1285, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Redirect to', 'Redirect to', 0, 0, 0),
(1286, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Date Set', 'Date Set', 0, 0, 0),
(1287, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Expiry Date', 'Expiry Date', 0, 0, 0),
(1288, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Never', 'Never', 0, 0, 0),
(1289, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'No Banned IPs available', 'No Banned IPs available', 0, 0, 0),
(1290, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'No Bed Types available', 'No Bed Types available', 0, 0, 0),
(1291, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Prior Days', 'Prior Days', 0, 0, 0),
(1292, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Traveler can get percentage of refund, if he canceled before the given no. of days before check-in date.', 'Traveler can get percentage of refund, if he canceled before the given no. of days before check-in date.', 0, 0, 0),
(1293, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Percentage', 'Percentage', 0, 0, 0),
(1294, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Percentage of amount will be refund to traveler', 'Percentage of amount will be refund to traveler', 0, 0, 0),
(1295, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Properties Count', 'Properties Count', 0, 0, 0),
(1296, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'No Cancellation Policies available', 'No Cancellation Policies available', 0, 0, 0),
(1297, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Overview', 'Overview', 0, 0, 0),
(1298, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Select Range', 'Select Range', 0, 0, 0),
(1299, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Value', 'Value', 0, 0, 0),
(1300, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Total Bookings', 'Total Bookings', 0, 0, 0),
(1301, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Revenue', 'Revenue', 0, 0, 0),
(1302, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Property Disputes', 'Property Disputes', 0, 0, 0),
(1303, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'User Login', 'User Login', 0, 0, 0),
(1304, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Registration', 'Registration', 0, 0, 0),
(1305, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Demographics', 'Demographics', 0, 0, 0),
(1306, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Please Select', 'Please Select', 0, 0, 0),
(1307, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Country', 'Country', 0, 0, 0),
(1308, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'State', 'State', 0, 0, 0),
(1309, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Latitude', 'Latitude', 0, 0, 0),
(1310, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Longitude', 'Longitude', 0, 0, 0),
(1311, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Timezone', 'Timezone', 0, 0, 0),
(1312, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'County', 'County', 0, 0, 0),
(1313, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Code', 'Code', 0, 0, 0),
(1314, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'No cities available', 'No cities available', 0, 0, 0),
(1315, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Title', 'Title', 0, 0, 0),
(1316, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Upload Photo', 'Upload Photo', 0, 0, 0),
(1317, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Manage Properties', 'Manage Properties', 0, 0, 0),
(1318, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Address', 'Address', 0, 0, 0),
(1319, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Admin Suspended', 'Admin Suspended', 0, 0, 0),
(1320, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Flagged', 'Flagged', 0, 0, 0),
(1321, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'System Flagged', 'System Flagged', 0, 0, 0),
(1322, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'User Suspended', 'User Suspended', 0, 0, 0),
(1323, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Featured', 'Featured', 0, 0, 0),
(1324, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Home Page', 'Home Page', 0, 0, 0),
(1325, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'No Properties available', 'No Properties available', 0, 0, 0),
(1326, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Property Count', 'Property Count', 0, 0, 0),
(1327, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'No Collections available', 'No Collections available', 0, 0, 0),
(1328, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'First Name', 'First Name', 0, 0, 0),
(1329, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Last Name', 'Last Name', 0, 0, 0),
(1330, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Telephone', 'Telephone', 0, 0, 0),
(1331, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Subject', 'Subject', 0, 0, 0),
(1332, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, '[Image: CAPTCHA image. You will need to recognize the text in it; audible CAPTCHA available too.]', '[Image: CAPTCHA image. You will need to recognize the text in it; audible CAPTCHA available too.]', 0, 0, 0),
(1333, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'CAPTCHA image', 'CAPTCHA image', 0, 0, 0),
(1334, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Reload CAPTCHA', 'Reload CAPTCHA', 0, 0, 0),
(1335, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Click to play', 'Click to play', 0, 0, 0),
(1336, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Security Code', 'Security Code', 0, 0, 0),
(1337, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Send', 'Send', 0, 0, 0),
(1338, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Fips104', 'Fips104', 0, 0, 0),
(1339, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'ISO2', 'ISO2', 0, 0, 0),
(1340, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'ISO3', 'ISO3', 0, 0, 0),
(1341, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'ISON', 'ISON', 0, 0, 0),
(1342, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Interner', 'Interner', 0, 0, 0),
(1343, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Capital', 'Capital', 0, 0, 0),
(1344, '2012-01-11 17:04:33', '2012-01-11 17:04:33', 42, 'Map Reference', 'Map Reference', 0, 0, 0),
(1345, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Nationality Singular', 'Nationality Singular', 0, 0, 0),
(1346, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Nationality Plural', 'Nationality Plural', 0, 0, 0),
(1347, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Currency', 'Currency', 0, 0, 0),
(1348, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Population', 'Population', 0, 0, 0),
(1349, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Comment', 'Comment', 0, 0, 0),
(1350, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Edit Country - ', 'Edit Country - ', 0, 0, 0),
(1351, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Filter', 'Filter', 0, 0, 0),
(1352, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Add New Country', 'Add New Country', 0, 0, 0),
(1353, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Internet', 'Internet', 0, 0, 0),
(1354, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Nationality', 'Nationality', 0, 0, 0),
(1355, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Singular', 'Singular', 0, 0, 0),
(1356, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Plural', 'Plural', 0, 0, 0),
(1357, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'No countries available', 'No countries available', 0, 0, 0),
(1358, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Symbol', 'Symbol', 0, 0, 0),
(1359, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Decimals', 'Decimals', 0, 0, 0),
(1360, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Decimal Point', 'Decimal Point', 0, 0, 0),
(1361, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Thousand Separate', 'Thousand Separate', 0, 0, 0),
(1362, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Enabled?', 'Enabled?', 0, 0, 0),
(1363, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Automatic Currency Conversion Updation is currently enabled. You can disable it from', 'Automatic Currency Conversion Updation is currently enabled. You can disable it from', 0, 0, 0),
(1364, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'page if you prefer to manually update the values here.', 'page if you prefer to manually update the values here.', 0, 0, 0),
(1365, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Automatic Currency Conversion Updation is currently disabled. You can enable it from', 'Automatic Currency Conversion Updation is currently disabled. You can enable it from', 0, 0, 0),
(1366, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'page. When you enabled automatic update, you don''t have to manually update the values here.', 'page. When you enabled automatic update, you don''t have to manually update the values here.', 0, 0, 0),
(1367, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Base Currency', 'Base Currency', 0, 0, 0),
(1368, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Conversion', 'Conversion', 0, 0, 0),
(1369, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Rate', 'Rate', 0, 0, 0),
(1370, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Add New Currency', 'Add New Currency', 0, 0, 0),
(1371, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Dec Point', 'Dec Point', 0, 0, 0),
(1372, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Thousands Sep', 'Thousands Sep', 0, 0, 0),
(1373, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'No Currencies available', 'No Currencies available', 0, 0, 0),
(1374, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Currency Conversion History Updation is currently enabled. You can disable it from', 'Currency Conversion History Updation is currently enabled. You can disable it from', 0, 0, 0),
(1375, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'No Currency Conversion Histories available', 'No Currency Conversion Histories available', 0, 0, 0),
(1376, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Cache folder Size: ', 'Cache folder Size: ', 0, 0, 0),
(1377, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Log folder Size: ', 'Log folder Size: ', 0, 0, 0),
(1378, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Write Permission Check', 'Write Permission Check', 0, 0, 0),
(1379, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Debug.log', 'Debug.log', 0, 0, 0),
(1380, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Stars', 'Stars', 0, 0, 0),
(1381, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, '1 star out of 5', '1 star out of 5', 0, 0, 0),
(1382, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, '2 star out of 5', '2 star out of 5', 0, 0, 0),
(1383, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, '3 star out of 5', '3 star out of 5', 0, 0, 0),
(1384, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, '4 star out of 5', '4 star out of 5', 0, 0, 0),
(1385, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, '5 star out of 5', '5 star out of 5', 0, 0, 0),
(1386, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Admin side links', 'Admin side links', 0, 0, 0),
(1387, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Snapshot', 'Snapshot', 0, 0, 0),
(1388, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Send Email to Users', 'Send Email to Users', 0, 0, 0),
(1389, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'User Messages', 'User Messages', 0, 0, 0),
(1390, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'PayPal Accounts', 'PayPal Accounts', 0, 0, 0),
(1391, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Add Property', 'Add Property', 0, 0, 0),
(1392, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Property Flags', 'Property Flags', 0, 0, 0),
(1393, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Bookings', 'Bookings', 0, 0, 0),
(1394, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Feedback To Traveler', 'Feedback To Traveler', 0, 0, 0),
(1395, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Disputes', 'Disputes', 0, 0, 0),
(1396, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Add Request', 'Add Request', 0, 0, 0),
(1397, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Request Flags', 'Request Flags', 0, 0, 0),
(1398, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Payments', 'Payments', 0, 0, 0),
(1399, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Setting Overview', 'Setting Overview', 0, 0, 0),
(1400, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'System', 'System', 0, 0, 0),
(1401, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Developments', 'Developments', 0, 0, 0),
(1402, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'SEO', 'SEO', 0, 0, 0),
(1403, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Regional, Currency & Language', 'Regional, Currency & Language', 0, 0, 0),
(1404, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Account ', 'Account ', 0, 0, 0),
(1405, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Account', 'Account', 0, 0, 0),
(1406, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Payment', 'Payment', 0, 0, 0),
(1407, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Suspicious Words Detector', 'Suspicious Words Detector', 0, 0, 0),
(1408, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Dispute', 'Dispute', 0, 0, 0),
(1409, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Third Party API', 'Third Party API', 0, 0, 0),
(1410, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Module Manager', 'Module Manager', 0, 0, 0),
(1411, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Masters', 'Masters', 0, 0, 0),
(1412, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Warning! Please edit with caution.', 'Warning! Please edit with caution.', 0, 0, 0),
(1413, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Regional', 'Regional', 0, 0, 0),
(1414, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Static Pages', 'Static Pages', 0, 0, 0),
(1415, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Manage Static Pages', 'Manage Static Pages', 0, 0, 0),
(1416, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Others', 'Others', 0, 0, 0),
(1417, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Transactions Types', 'Transactions Types', 0, 0, 0),
(1418, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Partners', 'Partners', 0, 0, 0),
(1419, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Common Settings', 'Common Settings', 0, 0, 0),
(1420, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Book a Property', 'Book a Property', 0, 0, 0),
(1421, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Accept', 'Accept', 0, 0, 0),
(1422, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Host Review', 'Host Review', 0, 0, 0),
(1423, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Traveler Dispute', 'Traveler Dispute', 0, 0, 0),
(1424, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Admin Decision', 'Admin Decision', 0, 0, 0),
(1425, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, ' Traveler Review', ' Traveler Review', 0, 0, 0),
(1426, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Host Dispute', 'Host Dispute', 0, 0, 0),
(1427, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Education', 'Education', 0, 0, 0),
(1428, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Relationship', 'Relationship', 0, 0, 0),
(1429, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Employment', 'Employment', 0, 0, 0),
(1430, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Income', 'Income', 0, 0, 0),
(1431, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Gender', 'Gender', 0, 0, 0),
(1432, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Age', 'Age', 0, 0, 0),
(1433, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Language', 'Language', 0, 0, 0),
(1434, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Popular Cities', 'Popular Cities', 0, 0, 0),
(1435, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Hosting', 'Hosting', 0, 0, 0),
(1436, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'My Hosting', 'My Hosting', 0, 0, 0),
(1437, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Manage your hosting', 'Manage your hosting', 0, 0, 0),
(1438, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Manage reservations & pricing', 'Manage reservations & pricing', 0, 0, 0),
(1439, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Find others'' requests', 'Find others'' requests', 0, 0, 0),
(1440, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Traveling', 'Traveling', 0, 0, 0),
(1441, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'My Traveling', 'My Traveling', 0, 0, 0),
(1442, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Your travel details', 'Your travel details', 0, 0, 0),
(1443, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Find others'' properties', 'Find others'' properties', 0, 0, 0),
(1444, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Inbox', 'Inbox', 0, 0, 0),
(1445, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Hi ', 'Hi ', 0, 0, 0),
(1446, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Guest', 'Guest', 0, 0, 0),
(1447, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Registered through OpenID', 'Registered through OpenID', 0, 0, 0),
(1448, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'User Profile', 'User Profile', 0, 0, 0),
(1449, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Add Amount to Wallet ', 'Add Amount to Wallet ', 0, 0, 0),
(1450, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Change your profile settings', 'Change your profile settings', 0, 0, 0),
(1451, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'My Account', 'My Account', 0, 0, 0),
(1452, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Email Settings', 'Email Settings', 0, 0, 0),
(1453, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Get referral commission', 'Get referral commission', 0, 0, 0),
(1454, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Affiliate Cash Withdrawals', 'Affiliate Cash Withdrawals', 0, 0, 0),
(1455, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Your account details', 'Your account details', 0, 0, 0),
(1456, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'My Transactions', 'My Transactions', 0, 0, 0),
(1457, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Your public profile', 'Your public profile', 0, 0, 0),
(1458, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Logout', 'Logout', 0, 0, 0),
(1459, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Register', 'Register', 0, 0, 0),
(1460, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Draft', 'Draft', 0, 0, 0),
(1461, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', 'Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', 0, 0, 0),
(1462, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Prev', 'Prev', 0, 0, 0),
(1463, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Next', 'Next', 0, 0, 0),
(1464, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Listing Fee ', 'Listing Fee ', 0, 0, 0),
(1465, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Pay Through PayPal', 'Pay Through PayPal', 0, 0, 0),
(1466, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Pending (Admin will approve your property)', 'Pending (Admin will approve your property)', 0, 0, 0),
(1467, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Listed', 'Listed', 0, 0, 0),
(1468, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Deliver Order', 'Deliver Order', 0, 0, 0),
(1469, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Want to Close', 'Want to Close', 0, 0, 0),
(1470, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Want to close', 'Want to close', 0, 0, 0),
(1471, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Request Improvement', 'Request Improvement', 0, 0, 0),
(1472, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Mutual Cancel', 'Mutual Cancel', 0, 0, 0),
(1473, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Where?', 'Where?', 0, 0, 0),
(1474, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Guests', 'Guests', 0, 0, 0),
(1475, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Include non-%s matches (recommended)', 'Include non-%s matches (recommended)', 0, 0, 0),
(1476, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'exact', 'exact', 0, 0, 0),
(1477, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Dropdown', 'Dropdown', 0, 0, 0),
(1478, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Check in', 'Check in', 0, 0, 0),
(1479, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Check out', 'Check out', 0, 0, 0),
(1480, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Admin', 'Admin', 0, 0, 0),
(1481, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Revision ', 'Revision ', 0, 0, 0),
(1482, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Revision', 'Revision', 0, 0, 0),
(1483, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'saved', 'saved', 0, 0, 0),
(1484, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'by', 'by', 0, 0, 0),
(1485, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Enter complete address to get better results', 'Enter complete address to get better results', 0, 0, 0),
(1486, '2012-01-11 17:04:34', '2012-01-11 17:04:34', 42, 'Edit profile', 'Edit profile', 0, 0, 0),
(1487, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Email settings', 'Email settings', 0, 0, 0),
(1488, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Change password', 'Change password', 0, 0, 0),
(1489, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'PayPal connections', 'PayPal connections', 0, 0, 0),
(1490, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Success Rate', 'Success Rate', 0, 0, 0),
(1491, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'No bookings available', 'No bookings available', 0, 0, 0),
(1492, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'n/a', 'n/a', 0, 0, 0),
(1493, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Per night', 'Per night', 0, 0, 0),
(1494, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Per Week', 'Per Week', 0, 0, 0),
(1495, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Per Month', 'Per Month', 0, 0, 0),
(1496, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Share this collection', 'Share this collection', 0, 0, 0),
(1497, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Tweet!', 'Tweet!', 0, 0, 0),
(1498, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'As Host', 'As Host', 0, 0, 0),
(1499, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Properties posted', 'Properties posted', 0, 0, 0),
(1500, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'As Traveler', 'As Traveler', 0, 0, 0),
(1501, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Requests Posted', 'Requests Posted', 0, 0, 0),
(1502, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Rated by host', 'Rated by host', 0, 0, 0),
(1503, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, '(eg. \\"displayname &lt;email address>\\")', '(eg. \\"displayname &lt;email address>\\")', 0, 0, 0),
(1504, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Email Type', 'Email Type', 0, 0, 0),
(1505, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Is Html', 'Is Html', 0, 0, 0),
(1506, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'No e-mail templates added yet.', 'No e-mail templates added yet.', 0, 0, 0),
(1507, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'No Property Types available', 'No Property Types available', 0, 0, 0),
(1508, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, '(Monthly Booking Price)', '(Monthly Booking Price)', 0, 0, 0),
(1509, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'prev', 'prev', 0, 0, 0),
(1510, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'next', 'next', 0, 0, 0),
(1511, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'No Holiday Types available', 'No Holiday Types available', 0, 0, 0),
(1512, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'No IPs available', 'No IPs available', 0, 0, 0),
(1513, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Mail', 'Mail', 0, 0, 0),
(1514, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'No Labels available', 'No Labels available', 0, 0, 0),
(1515, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Please enter a new label name:', 'Please enter a new label name:', 0, 0, 0),
(1516, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Manage labels', 'Manage labels', 0, 0, 0),
(1517, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Create new label', 'Create new label', 0, 0, 0),
(1518, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Edit Label', 'Edit Label', 0, 0, 0),
(1519, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Rename', 'Rename', 0, 0, 0),
(1520, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'No labels added yet.', 'No labels added yet.', 0, 0, 0),
(1521, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Iso2', 'Iso2', 0, 0, 0),
(1522, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Iso3', 'Iso3', 0, 0, 0),
(1523, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Cancel', 'Cancel', 0, 0, 0),
(1524, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Active Records', 'Active Records', 0, 0, 0),
(1525, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Approved Records', 'Approved Records', 0, 0, 0),
(1526, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Inactive Records', 'Inactive Records', 0, 0, 0),
(1527, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Disapproved Records', 'Disapproved Records', 0, 0, 0),
(1528, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Total Records', 'Total Records', 0, 0, 0),
(1529, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'No Languages available', 'No Languages available', 0, 0, 0),
(1530, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Admin - %s', 'Admin - %s', 0, 0, 0),
(1531, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'View Site', 'View Site', 0, 0, 0),
(1532, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Tools', 'Tools', 0, 0, 0),
(1533, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Welcome, ', 'Welcome, ', 0, 0, 0),
(1534, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Back to Settings', 'Back to Settings', 0, 0, 0),
(1535, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Affiliate module is currently disabled. You can enable it from ', 'Affiliate module is currently disabled. You can enable it from ', 0, 0, 0),
(1536, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Currency Conversion History Updation is currently disabled. You can enable it from ', 'Currency Conversion History Updation is currently disabled. You can enable it from ', 0, 0, 0),
(1537, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'All rights reserved', 'All rights reserved', 0, 0, 0),
(1538, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'You are logged in as Admin', 'You are logged in as Admin', 0, 0, 0),
(1539, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'About', 'About', 0, 0, 0),
(1540, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Terms & Conditions', 'Terms & Conditions', 0, 0, 0),
(1541, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Privacy & Policy', 'Privacy & Policy', 0, 0, 0),
(1542, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Privacy & Polic', 'Privacy & Polic', 0, 0, 0),
(1543, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Made On', 'Made On', 0, 0, 0),
(1544, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Completed?', 'Completed?', 0, 0, 0),
(1545, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Discount', 'Discount', 0, 0, 0),
(1546, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Gross Amount', 'Gross Amount', 0, 0, 0),
(1547, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Current Status', 'Current Status', 0, 0, 0),
(1548, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Canceled By Admin', 'Canceled By Admin', 0, 0, 0),
(1549, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Admin Dispute Conversation', 'Admin Dispute Conversation', 0, 0, 0),
(1550, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Admin Dispute Action', 'Admin Dispute Action', 0, 0, 0),
(1551, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Work Reviewed', 'Work Reviewed', 0, 0, 0),
(1552, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Work Delivered', 'Work Delivered', 0, 0, 0),
(1553, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Dispute closed temporarily', 'Dispute closed temporarily', 0, 0, 0),
(1554, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Dispute Closed', 'Dispute Closed', 0, 0, 0),
(1555, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Distpute Conversation', 'Distpute Conversation', 0, 0, 0),
(1556, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Sender Notification', 'Sender Notification', 0, 0, 0),
(1557, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Traveler name', 'Traveler name', 0, 0, 0),
(1558, '2012-01-11 17:04:35', '2012-01-11 17:04:35', 42, 'Contact Traveler', 'Contact Traveler', 0, 0, 0),
(1559, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Host name', 'Host name', 0, 0, 0),
(1560, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Contact Host', 'Contact Host', 0, 0, 0),
(1561, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Security Deposit', 'Security Deposit', 0, 0, 0),
(1562, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Ths deposit is for security purpose. When host raise any dispute on property damage, this amount may be used for compensation. So, total refund is limited to proper stay and booking cancellation/rejection/expiration. Note that site decision on this is final.', 'Ths deposit is for security purpose. When host raise any dispute on property damage, this amount may be used for compensation. So, total refund is limited to proper stay and booking cancellation/rejection/expiration. Note that site decision on this is final.', 0, 0, 0),
(1563, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Response and actions', 'Response and actions', 0, 0, 0),
(1564, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Confirm', 'Confirm', 0, 0, 0),
(1565, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Under dispute. Actions can be continued only after dispute gets closed.', 'Under dispute. Actions can be continued only after dispute gets closed.', 0, 0, 0),
(1566, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Private Note', 'Private Note', 0, 0, 0),
(1567, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'to me', 'to me', 0, 0, 0),
(1568, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Compose Message', 'Compose Message', 0, 0, 0),
(1569, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'OR', 'OR', 0, 0, 0),
(1570, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Suspended messages:', 'Suspended messages:', 0, 0, 0),
(1571, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Suspended messages', 'Suspended messages', 0, 0, 0),
(1572, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'System flagged  messages:', 'System flagged  messages:', 0, 0, 0),
(1573, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'System flagged  messages', 'System flagged  messages', 0, 0, 0),
(1574, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Total messages:', 'Total messages:', 0, 0, 0),
(1575, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Total messages', 'Total messages', 0, 0, 0),
(1576, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'From', 'From', 0, 0, 0),
(1577, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'To', 'To', 0, 0, 0),
(1578, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Date', 'Date', 0, 0, 0),
(1579, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Unsuspend Message', 'Unsuspend Message', 0, 0, 0),
(1580, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Suspend Message', 'Suspend Message', 0, 0, 0),
(1581, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'No messages available', 'No messages available', 0, 0, 0),
(1582, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Unflagged', 'Unflagged', 0, 0, 0),
(1583, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Suspended', 'Suspended', 0, 0, 0),
(1584, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Compose', 'Compose', 0, 0, 0),
(1585, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Sent items', 'Sent items', 0, 0, 0),
(1586, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Booking#', 'Booking#', 0, 0, 0),
(1587, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Message to buyer', 'Message to buyer', 0, 0, 0),
(1588, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Attachment', 'Attachment', 0, 0, 0),
(1589, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'See All', 'See All', 0, 0, 0),
(1590, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'You have', 'You have', 0, 0, 0),
(1591, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'messages', 'messages', 0, 0, 0),
(1592, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'My ', 'My ', 0, 0, 0),
(1593, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, ' Messages', ' Messages', 0, 0, 0),
(1594, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Archive', 'Archive', 0, 0, 0),
(1595, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Notspam', 'Notspam', 0, 0, 0),
(1596, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Spam', 'Spam', 0, 0, 0),
(1597, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Select: ', 'Select: ', 0, 0, 0),
(1598, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'All, ', 'All, ', 0, 0, 0),
(1599, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'None, ', 'None, ', 0, 0, 0),
(1600, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Read, ', 'Read, ', 0, 0, 0),
(1601, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Read', 'Read', 0, 0, 0),
(1602, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Unread, ', 'Unread, ', 0, 0, 0),
(1603, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Unread', 'Unread', 0, 0, 0),
(1604, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Starred, ', 'Starred, ', 0, 0, 0),
(1605, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Starred', 'Starred', 0, 0, 0),
(1606, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Unstarred', 'Unstarred', 0, 0, 0),
(1607, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Star', 'Star', 0, 0, 0);
INSERT INTO `translations` (`id`, `created`, `modified`, `language_id`, `key`, `lang_text`, `is_translated`, `is_google_translate`, `is_verified`) VALUES
(1608, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'To: ', 'To: ', 0, 0, 0),
(1609, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Me   : ', 'Me   : ', 0, 0, 0),
(1610, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'messages available', 'messages available', 0, 0, 0),
(1611, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Refresh', 'Refresh', 0, 0, 0),
(1612, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Sent Mail', 'Sent Mail', 0, 0, 0),
(1613, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'All Mail', 'All Mail', 0, 0, 0),
(1614, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Trash', 'Trash', 0, 0, 0),
(1615, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Message Settings', 'Message Settings', 0, 0, 0),
(1616, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Dispute - Opened', 'Dispute - Opened', 0, 0, 0),
(1617, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Dispute - Closed', 'Dispute - Closed', 0, 0, 0),
(1618, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Dispute - Under Discussion', 'Dispute - Under Discussion', 0, 0, 0),
(1619, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Dispute - Waiting for Administrator Decision', 'Dispute - Waiting for Administrator Decision', 0, 0, 0),
(1620, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Conversation', 'Conversation', 0, 0, 0),
(1621, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Rated Positive', 'Rated Positive', 0, 0, 0),
(1622, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Rated Negative', 'Rated Negative', 0, 0, 0),
(1623, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Attached', 'Attached', 0, 0, 0),
(1624, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Arrived - Auto', 'Arrived - Auto', 0, 0, 0),
(1625, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Arrived - Host', 'Arrived - Host', 0, 0, 0),
(1626, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Arrived - Traveler', 'Arrived - Traveler', 0, 0, 0),
(1627, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Status changed automatically to \\"Arrived\\". Changed at', 'Status changed automatically to \\"Arrived\\". Changed at', 0, 0, 0),
(1628, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Host changed the status to \\"Arrived\\". Changed at', 'Host changed the status to \\"Arrived\\". Changed at', 0, 0, 0),
(1629, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Traveler changed the status to \\"Arrived\\". Changed at', 'Traveler changed the status to \\"Arrived\\". Changed at', 0, 0, 0),
(1630, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Checked Out - Auto', 'Checked Out - Auto', 0, 0, 0),
(1631, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Checked Out - Host', 'Checked Out - Host', 0, 0, 0),
(1632, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Checked Out - Traveler', 'Checked Out - Traveler', 0, 0, 0),
(1633, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Status changed automatically to \\"Checked Out\\". Changed at', 'Status changed automatically to \\"Checked Out\\". Changed at', 0, 0, 0),
(1634, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Host changed the status to \\"Checked Out\\". Changed at', 'Host changed the status to \\"Checked Out\\". Changed at', 0, 0, 0),
(1635, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Traveler changed the status to \\"Checked Out\\"', 'Traveler changed the status to \\"Checked Out\\"', 0, 0, 0),
(1636, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Negotiation Conversation', 'Negotiation Conversation', 0, 0, 0),
(1637, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'From Traveler', 'From Traveler', 0, 0, 0),
(1638, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Mutual cancel request', 'Mutual cancel request', 0, 0, 0),
(1639, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Search results', 'Search results', 0, 0, 0),
(1640, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'All,', 'All,', 0, 0, 0),
(1641, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'None,', 'None,', 0, 0, 0),
(1642, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Read,', 'Read,', 0, 0, 0),
(1643, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Unread,', 'Unread,', 0, 0, 0),
(1644, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Starred,', 'Starred,', 0, 0, 0),
(1645, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Drafts', 'Drafts', 0, 0, 0),
(1646, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'me', 'me', 0, 0, 0),
(1647, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'No messages matched your search.', 'No messages matched your search.', 0, 0, 0),
(1648, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'General Settings', 'General Settings', 0, 0, 0),
(1649, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Message Page Size', 'Message Page Size', 0, 0, 0),
(1650, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Message Signature', 'Message Signature', 0, 0, 0),
(1651, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Buyer: ', 'Buyer: ', 0, 0, 0),
(1652, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Ordered Date: ', 'Ordered Date: ', 0, 0, 0),
(1653, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'On time Delivery: ', 'On time Delivery: ', 0, 0, 0),
(1654, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Tip: ', 'Tip: ', 0, 0, 0),
(1655, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'It is a good idea to provide proof of your completed work', 'It is a good idea to provide proof of your completed work', 0, 0, 0),
(1656, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Notify Buyer', 'Notify Buyer', 0, 0, 0),
(1657, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Your private note for your own reference.', 'Your private note for your own reference.', 0, 0, 0),
(1658, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Host commission will be calculated from original price; not from negotiated price.', 'Host commission will be calculated from original price; not from negotiated price.', 0, 0, 0),
(1659, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Note', 'Note', 0, 0, 0),
(1660, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Discount (in percentage)', 'Discount (in percentage)', 0, 0, 0),
(1661, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Maximum allowed discount is ', 'Maximum allowed discount is ', 0, 0, 0),
(1662, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Your Gross Amount', 'Your Gross Amount', 0, 0, 0),
(1663, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Back to Label', 'Back to Label', 0, 0, 0),
(1664, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Back to Starred', 'Back to Starred', 0, 0, 0),
(1665, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Back to', 'Back to', 0, 0, 0),
(1666, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Activity', 'Activity', 0, 0, 0),
(1667, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Reply', 'Reply', 0, 0, 0),
(1668, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'attachments', 'attachments', 0, 0, 0),
(1669, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Download', 'Download', 0, 0, 0),
(1670, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'System Flag Words: ', 'System Flag Words: ', 0, 0, 0),
(1671, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Deactivate sender', 'Deactivate sender', 0, 0, 0),
(1672, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Deactivate user', 'Deactivate user', 0, 0, 0),
(1673, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Activate sender', 'Activate sender', 0, 0, 0),
(1674, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Activate user', 'Activate user', 0, 0, 0),
(1675, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Date: ', 'Date: ', 0, 0, 0),
(1676, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'from', 'from', 0, 0, 0),
(1677, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'to', 'to', 0, 0, 0),
(1678, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'date', 'date', 0, 0, 0),
(1679, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'at', 'at', 0, 0, 0),
(1680, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Property: ', 'Property: ', 0, 0, 0),
(1681, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Click here to review your Booking', 'Click here to review your Booking', 0, 0, 0),
(1682, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Attachment from buyer', 'Attachment from buyer', 0, 0, 0),
(1683, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Click to download this file', 'Click to download this file', 0, 0, 0),
(1684, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Information from buyer', 'Information from buyer', 0, 0, 0),
(1685, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'In order to withdrawal cash/amount from your account balance in the site, You first need to create a ''Money tranfer account''. You can also add multiple transfer accounts with different gateways and mark any one of them as ''Primary''. The approved withdrawal amount from your account balance will be credited to the ''Primary'' marked transfer account.', 'In order to withdrawal cash/amount from your account balance in the site, You first need to create a ''Money tranfer account''. You can also add multiple transfer accounts with different gateways and mark any one of them as ''Primary''. The approved withdrawal amount from your account balance will be credited to the ''Primary'' marked transfer account.', 0, 0, 0),
(1686, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Payment Gateway', 'Payment Gateway', 0, 0, 0),
(1687, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Make as primary', 'Make as primary', 0, 0, 0),
(1688, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'No money transfer account available', 'No money transfer account available', 0, 0, 0),
(1689, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Preview', 'Preview', 0, 0, 0),
(1690, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Change', 'Change', 0, 0, 0),
(1691, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Page title', 'Page title', 0, 0, 0),
(1692, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Body', 'Body', 0, 0, 0),
(1693, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Available Variables: ##SITE_NAME##, ##SITE_URL##, ##ABOUT_US_URL##, ##CONTACT_US_URL##, ##FAQ_URL##', 'Available Variables: ##SITE_NAME##, ##SITE_URL##, ##ABOUT_US_URL##, ##CONTACT_US_URL##, ##FAQ_URL##', 0, 0, 0),
(1694, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Slug', 'Slug', 0, 0, 0),
(1695, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'When you create link for this page, url should be page/value of this field.', 'When you create link for this page, url should be page/value of this field.', 0, 0, 0),
(1696, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Meta Keywords', 'Meta Keywords', 0, 0, 0),
(1697, '2012-01-11 17:04:36', '2012-01-11 17:04:36', 42, 'Meta Description', 'Meta Description', 0, 0, 0),
(1698, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Available Variables: ##SITE_NAME##, ##SITE_URL##, ##ABOUT_US_URL##, ##CONTACT_US_URL##, ##FAQ_URL##, ##SITE_CONTACT_PHONE##, ##SITE_CONTACT_EMAIL##', 'Available Variables: ##SITE_NAME##, ##SITE_URL##, ##ABOUT_US_URL##, ##CONTACT_US_URL##, ##FAQ_URL##, ##SITE_CONTACT_PHONE##, ##SITE_CONTACT_EMAIL##', 0, 0, 0),
(1699, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Content', 'Content', 0, 0, 0),
(1700, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'No Pages available', 'No Pages available', 0, 0, 0),
(1701, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'When cron is not working, you may trigger it by clicking below link. For the processes that happen during a cron run, refer the ', 'When cron is not working, you may trigger it by clicking below link. For the processes that happen during a cron run, refer the ', 0, 0, 0),
(1702, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Manually trigger cron to update property and booking status', 'Manually trigger cron to update property and booking status', 0, 0, 0),
(1703, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'You can use this to update property and booking status. This will be used in the scenario where cron is not working.', 'You can use this to update property and booking status. This will be used in the scenario where cron is not working.', 0, 0, 0),
(1704, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Manually trigger cron to clear permanent cache', 'Manually trigger cron to clear permanent cache', 0, 0, 0),
(1705, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'You can use this to clear permanent cache files. This will be used in the scenario where cron is not working.', 'You can use this to clear permanent cache files. This will be used in the scenario where cron is not working.', 0, 0, 0),
(1706, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Manually trigger cron to update currency conversion rate', 'Manually trigger cron to update currency conversion rate', 0, 0, 0),
(1707, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'You can use this to update currency conversion rate. This will be used in the scenario where cron is not working', 'You can use this to update currency conversion rate. This will be used in the scenario where cron is not working', 0, 0, 0),
(1708, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Continue', 'Continue', 0, 0, 0),
(1709, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Transaction ID', 'Transaction ID', 0, 0, 0),
(1710, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Transaction Date', 'Transaction Date', 0, 0, 0),
(1711, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'City', 'City', 0, 0, 0),
(1712, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Zip', 'Zip', 0, 0, 0),
(1713, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Phone', 'Phone', 0, 0, 0),
(1714, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Payment Type', 'Payment Type', 0, 0, 0),
(1715, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Number', 'Number', 0, 0, 0),
(1716, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Quarter', 'Quarter', 0, 0, 0),
(1717, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Fee', 'Fee', 0, 0, 0),
(1718, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'No Pagseguro Transaction Logs available', 'No Pagseguro Transaction Logs available', 0, 0, 0),
(1719, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Remark', 'Remark', 0, 0, 0),
(1720, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Quantity', 'Quantity', 0, 0, 0),
(1721, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Ip', 'Ip', 0, 0, 0),
(1722, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Serialized Post Array', 'Serialized Post Array', 0, 0, 0),
(1723, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Add Payment Gateway Settings', 'Add Payment Gateway Settings', 0, 0, 0),
(1724, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Key', 'Key', 0, 0, 0),
(1725, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Payment Gateway Setting Update', 'Payment Gateway Setting Update', 0, 0, 0),
(1726, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Sorry no settings added.', 'Sorry no settings added.', 0, 0, 0),
(1727, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Payment Gateway Settings', 'Payment Gateway Settings', 0, 0, 0),
(1728, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'No Payment Gateway Settings available', 'No Payment Gateway Settings available', 0, 0, 0),
(1729, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Payment Gateway Setting', 'Payment Gateway Setting', 0, 0, 0),
(1730, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Payment Gateway Id', 'Payment Gateway Id', 0, 0, 0),
(1731, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Test Mode?', 'Test Mode?', 0, 0, 0),
(1732, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Mass Pay Enabled?', 'Mass Pay Enabled?', 0, 0, 0),
(1733, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Enable for property listing', 'Enable for property listing', 0, 0, 0),
(1734, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Enable for property verified', 'Enable for property verified', 0, 0, 0),
(1735, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Enable for add to wallet', 'Enable for add to wallet', 0, 0, 0),
(1736, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Enable for book property', 'Enable for book property', 0, 0, 0),
(1737, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Payee Details', 'Payee Details', 0, 0, 0),
(1738, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Adaptive Payment Details', 'Adaptive Payment Details', 0, 0, 0),
(1739, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Adaptive used to send money to host.', 'Adaptive used to send money to host.', 0, 0, 0),
(1740, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Create Adaptive API from PayPal profile. Refer', 'Create Adaptive API from PayPal profile. Refer', 0, 0, 0),
(1741, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Merchant Referral Bonus ID', 'Merchant Referral Bonus ID', 0, 0, 0),
(1742, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Copy your ID, which is at the end of the Referral Email URL: ', 'Copy your ID, which is at the end of the Referral Email URL: ', 0, 0, 0),
(1743, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Mass Payment Details', 'Mass Payment Details', 0, 0, 0),
(1744, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Masspay used to send money to user.', 'Masspay used to send money to user.', 0, 0, 0),
(1745, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Create masspay API from paypal profile. Refer', 'Create masspay API from paypal profile. Refer', 0, 0, 0),
(1746, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Mass Pay Enabled', 'Mass Pay Enabled', 0, 0, 0),
(1747, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'No Payment Gateways available', 'No Payment Gateways available', 0, 0, 0),
(1748, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Send money to', 'Send money to', 0, 0, 0),
(1749, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Positive Rating', 'Positive Rating', 0, 0, 0),
(1750, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Positive Rating:', 'Positive Rating:', 0, 0, 0),
(1751, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Negative Rating', 'Negative Rating', 0, 0, 0),
(1752, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'joined', 'joined', 0, 0, 0),
(1753, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'on', 'on', 0, 0, 0),
(1754, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Users PayPal account:', 'Users PayPal account:', 0, 0, 0),
(1755, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Who will pay the fee?', 'Who will pay the fee?', 0, 0, 0),
(1756, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'PayPal', 'PayPal', 0, 0, 0),
(1757, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Your', 'Your', 0, 0, 0),
(1758, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'balance is:', 'balance is:', 0, 0, 0),
(1759, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Create', 'Create', 0, 0, 0),
(1760, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Here you can create PayPal account quickly (through PayPal API).', 'Here you can create PayPal account quickly (through PayPal API).', 0, 0, 0),
(1761, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'You may also create a PayPal account from ', 'You may also create a PayPal account from ', 0, 0, 0),
(1762, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, ' site.', ' site.', 0, 0, 0),
(1763, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'DOB', 'DOB', 0, 0, 0),
(1764, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Address1', 'Address1', 0, 0, 0),
(1765, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Address2', 'Address2', 0, 0, 0),
(1766, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Citizenship Country', 'Citizenship Country', 0, 0, 0),
(1767, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Create PayPal Account', 'Create PayPal Account', 0, 0, 0),
(1768, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Redirecting you to ', 'Redirecting you to ', 0, 0, 0),
(1769, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'If your browser doesn''t redirect you pleaseclick here to continue.', 'If your browser doesn''t redirect you pleaseclick here to continue.', 0, 0, 0),
(1770, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Pay Membership Fee', 'Pay Membership Fee', 0, 0, 0),
(1771, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'This payment transacts in ', 'This payment transacts in ', 0, 0, 0),
(1772, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, '. Your total charge is ', '. Your total charge is ', 0, 0, 0),
(1773, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Select Payment Type', 'Select Payment Type', 0, 0, 0),
(1774, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Pay With PayPal', 'Pay With PayPal', 0, 0, 0),
(1775, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'This will take you to the paypal.com', 'This will take you to the paypal.com', 0, 0, 0),
(1776, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Pay with PayPal', 'Pay with PayPal', 0, 0, 0),
(1777, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Your available balance:', 'Your available balance:', 0, 0, 0),
(1778, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Pay by Wallet', 'Pay by Wallet', 0, 0, 0),
(1779, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Pay with this card(s)', 'Pay with this card(s)', 0, 0, 0),
(1780, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Add new card', 'Add new card', 0, 0, 0),
(1781, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Hide', 'Hide', 0, 0, 0),
(1782, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Billing Information', 'Billing Information', 0, 0, 0),
(1783, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Card Type', 'Card Type', 0, 0, 0),
(1784, '2012-01-11 17:04:37', '2012-01-11 17:04:37', 42, 'Card Number', 'Card Number', 0, 0, 0),
(1785, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Expiration Date', 'Expiration Date', 0, 0, 0),
(1786, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Card Verification Number:', 'Card Verification Number:', 0, 0, 0),
(1787, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Billing Address', 'Billing Address', 0, 0, 0),
(1788, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Zip code', 'Zip code', 0, 0, 0),
(1789, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'verified', 'verified', 0, 0, 0),
(1790, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'featured', 'featured', 0, 0, 0),
(1791, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Distance', 'Distance', 0, 0, 0),
(1792, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, '(km)', '(km)', 0, 0, 0),
(1793, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Book it!', 'Book it!', 0, 0, 0),
(1794, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Host may confirm booking with other guests while you %s negotiate. So, make your negotiation short and genuine to avoid disappointments.', 'Host may confirm booking with other guests while you %s negotiate. So, make your negotiation short and genuine to avoid disappointments.', 0, 0, 0),
(1795, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'You can give whatever discount, but admin commission will be calculated on your property cost!', 'You can give whatever discount, but admin commission will be calculated on your property cost!', 0, 0, 0),
(1796, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Username', 'Username', 0, 0, 0),
(1797, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Must start with an alphabet. <br/> Must be minimum of 3 characters and <br/> Maximum of 20 characters <br/> No special characters and spaces allowed', 'Must start with an alphabet. <br/> Must be minimum of 3 characters and <br/> Maximum of 20 characters <br/> No special characters and spaces allowed', 0, 0, 0),
(1798, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Password', 'Password', 0, 0, 0),
(1799, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Message to Host', 'Message to Host', 0, 0, 0),
(1800, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Cancellation', 'Cancellation', 0, 0, 0),
(1801, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Amount Paid', 'Amount Paid', 0, 0, 0),
(1802, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, '+ Security Deposit', '+ Security Deposit', 0, 0, 0),
(1803, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, '(Price + Service Fee %s)', '(Price + Service Fee %s)', 0, 0, 0),
(1804, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Service Fee', 'Service Fee', 0, 0, 0),
(1805, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Cancellation Fee', 'Cancellation Fee', 0, 0, 0),
(1806, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Refundable Amount', 'Refundable Amount', 0, 0, 0),
(1807, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Your order confirmation request will be expired automatically in ', 'Your order confirmation request will be expired automatically in ', 0, 0, 0),
(1808, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, ' hrs when host not yet respond.', ' hrs when host not yet respond.', 0, 0, 0),
(1809, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'House Rules', 'House Rules', 0, 0, 0),
(1810, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'I agree to the cancellation policy and house rules', 'I agree to the cancellation policy and house rules', 0, 0, 0),
(1811, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Pay With Connected PayPal', 'Pay With Connected PayPal', 0, 0, 0),
(1812, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Pay with connected PayPal', 'Pay with connected PayPal', 0, 0, 0),
(1813, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'No PayPal Connection Available.', 'No PayPal Connection Available.', 0, 0, 0),
(1814, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Connect Now', 'Connect Now', 0, 0, 0),
(1815, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'You can connect your PayPal account with %s. To connect your account, you''ll be taken to paypal.com and once connected, you can make orders without leaving to paypal.com again. Note: We don''t save your PayPal password and the connection is enabled through PayPal standard alone. Anytime, you can disable the connection.', 'You can connect your PayPal account with %s. To connect your account, you''ll be taken to paypal.com and once connected, you can make orders without leaving to paypal.com again. Note: We don''t save your PayPal password and the connection is enabled through PayPal standard alone. Anytime, you can disable the connection.', 0, 0, 0),
(1816, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Contact', 'Contact', 0, 0, 0),
(1817, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Membership fee needs to pay for registration. Please click the link for  ', 'Membership fee needs to pay for registration. Please click the link for  ', 0, 0, 0),
(1818, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'register', 'register', 0, 0, 0),
(1819, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, ' , your order will be placed automatically and you can continue the booking from trips manager after login.', ' , your order will be placed automatically and you can continue the booking from trips manager after login.', 0, 0, 0),
(1820, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Already Have An Account?', 'Already Have An Account?', 0, 0, 0),
(1821, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'If you have created account in %s before, you can sign in using your %s.', 'If you have created account in %s before, you can sign in using your %s.', 0, 0, 0),
(1822, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Trip Details', 'Trip Details', 0, 0, 0),
(1823, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Nights', 'Nights', 0, 0, 0),
(1824, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Additional Guests', 'Additional Guests', 0, 0, 0),
(1825, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Rate (per night)', 'Rate (per night)', 0, 0, 0),
(1826, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Price', 'Price', 0, 0, 0),
(1827, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Additional Guests Price (per night)', 'Additional Guests Price (per night)', 0, 0, 0),
(1828, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Subtotal', 'Subtotal', 0, 0, 0),
(1829, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Refundable', 'Refundable', 0, 0, 0),
(1830, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Pay Listing Fee', 'Pay Listing Fee', 0, 0, 0),
(1831, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, ' Pay Verification Fee', ' Pay Verification Fee', 0, 0, 0),
(1832, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Booking Details', 'Booking Details', 0, 0, 0),
(1833, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Payment process', 'Payment process', 0, 0, 0),
(1834, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'When you pay verification fee, %s staff visit your premise and verify the details provided. Once the staff is satisfied with the details, your property will get \\"Verified\\" status. By getting \\"Verified\\" status, guests will get more confidence and you''d get more bookings.', 'When you pay verification fee, %s staff visit your premise and verify the details provided. Once the staff is satisfied with the details, your property will get \\"Verified\\" status. By getting \\"Verified\\" status, guests will get more confidence and you''d get more bookings.', 0, 0, 0),
(1835, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Note: These accounts are created from ', 'Note: These accounts are created from ', 0, 0, 0),
(1836, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'this page', 'this page', 0, 0, 0),
(1837, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Created On', 'Created On', 0, 0, 0),
(1838, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Payment Types', 'Payment Types', 0, 0, 0),
(1839, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Create Account Key', 'Create Account Key', 0, 0, 0),
(1840, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'No Paypal Accounts available', 'No Paypal Accounts available', 0, 0, 0),
(1841, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'User email', 'User email', 0, 0, 0),
(1842, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Fees', 'Fees', 0, 0, 0),
(1843, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'PayPal Response', 'PayPal Response', 0, 0, 0),
(1844, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Error Code', 'Error Code', 0, 0, 0),
(1845, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'New User', 'New User', 0, 0, 0),
(1846, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'No Paypal Transaction Logs available', 'No Paypal Transaction Logs available', 0, 0, 0),
(1847, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Date Added', 'Date Added', 0, 0, 0),
(1848, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Currency Type', 'Currency Type', 0, 0, 0),
(1849, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Txn Id', 'Txn Id', 0, 0, 0),
(1850, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Payer Email', 'Payer Email', 0, 0, 0),
(1851, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Payment Date', 'Payment Date', 0, 0, 0),
(1852, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'To Digicurrency', 'To Digicurrency', 0, 0, 0),
(1853, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'To Account No', 'To Account No', 0, 0, 0),
(1854, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'To Account Name', 'To Account Name', 0, 0, 0),
(1855, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Fees Paid By', 'Fees Paid By', 0, 0, 0),
(1856, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Mc Gross', 'Mc Gross', 0, 0, 0),
(1857, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Mc Fee', 'Mc Fee', 0, 0, 0),
(1858, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Mc Currency', 'Mc Currency', 0, 0, 0),
(1859, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Pending Reason', 'Pending Reason', 0, 0, 0),
(1860, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Receiver Email', 'Receiver Email', 0, 0, 0),
(1861, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Paypal Response', 'Paypal Response', 0, 0, 0),
(1862, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Error No', 'Error No', 0, 0, 0),
(1863, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Error Message', 'Error Message', 0, 0, 0),
(1864, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Paypal Post Vars', 'Paypal Post Vars', 0, 0, 0),
(1865, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Mass Pay Status', 'Mass Pay Status', 0, 0, 0),
(1866, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Mass Pay Response', 'Mass Pay Response', 0, 0, 0),
(1867, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'No Privacies available', 'No Privacies available', 0, 0, 0),
(1868, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'General', 'General', 0, 0, 0),
(1869, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Price and terms', 'Price and terms', 0, 0, 0),
(1870, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Private Details', 'Private Details', 0, 0, 0),
(1871, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Photos & Videos', 'Photos & Videos', 0, 0, 0),
(1872, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Point Your Location', 'Point Your Location', 0, 0, 0),
(1873, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Point the exact location in map by dragging marker', 'Point the exact location in map by dragging marker', 0, 0, 0),
(1874, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Please select correct address value', 'Please select correct address value', 0, 0, 0),
(1875, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Process Flow', 'Process Flow', 0, 0, 0),
(1876, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'If you do not have PayPal account,', 'If you do not have PayPal account,', 0, 0, 0),
(1877, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'click here', 'click here', 0, 0, 0),
(1878, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'to create a PayPal account Instantly.', 'to create a PayPal account Instantly.', 0, 0, 0),
(1879, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'PayPal Email', 'PayPal Email', 0, 0, 0),
(1880, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'PayPal First Name', 'PayPal First Name', 0, 0, 0),
(1881, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'PayPal account first name for account verification', 'PayPal account first name for account verification', 0, 0, 0),
(1882, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'PayPal Last Name', 'PayPal Last Name', 0, 0, 0),
(1883, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'PayPal account last name for account verification', 'PayPal account last name for account verification', 0, 0, 0),
(1884, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'characters left', 'characters left', 0, 0, 0),
(1885, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Features', 'Features', 0, 0, 0),
(1886, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Property Type', 'Property Type', 0, 0, 0),
(1887, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Room Type', 'Room Type', 0, 0, 0),
(1888, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Bed Rooms', 'Bed Rooms', 0, 0, 0),
(1889, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Beds', 'Beds', 0, 0, 0),
(1890, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Bed Type', 'Bed Type', 0, 0, 0),
(1891, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Bath Rooms', 'Bath Rooms', 0, 0, 0),
(1892, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Max number of guests', 'Max number of guests', 0, 0, 0),
(1893, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Property Size', 'Property Size', 0, 0, 0),
(1894, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Pets live on this property', 'Pets live on this property', 0, 0, 0),
(1895, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Please mention your property price details in', 'Please mention your property price details in', 0, 0, 0),
(1896, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Price Per Night (', 'Price Per Night (', 0, 0, 0),
(1897, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Price Per Week (', 'Price Per Week (', 0, 0, 0),
(1898, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Price Per Month (', 'Price Per Month (', 0, 0, 0),
(1899, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Additional Guest Price', 'Additional Guest Price', 0, 0, 0),
(1900, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'per night for each additional guest after', 'per night for each additional guest after', 0, 0, 0),
(1901, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Negotiable pricing', 'Negotiable pricing', 0, 0, 0),
(1902, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'If you enable negotiable then Traveler will contact you for negotiation', 'If you enable negotiable then Traveler will contact you for negotiation', 0, 0, 0),
(1903, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'This deposit is for security purpose. When you raise any dispute with the guest, this amount may be used for compensation on any property damages. Note that site decision on this is final.', 'This deposit is for security purpose. When you raise any dispute with the guest, this amount may be used for compensation on any property damages. Note that site decision on this is final.', 0, 0, 0),
(1904, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Terms', 'Terms', 0, 0, 0),
(1905, '2012-01-11 17:04:38', '2012-01-11 17:04:38', 42, 'Cancellation Policy', 'Cancellation Policy', 0, 0, 0),
(1906, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Minimum Nights', 'Minimum Nights', 0, 0, 0),
(1907, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Maximum Nights', 'Maximum Nights', 0, 0, 0),
(1908, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'No Maximum', 'No Maximum', 0, 0, 0),
(1909, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Private details will be shown after booking request has been confirmed', 'Private details will be shown after booking request has been confirmed', 0, 0, 0),
(1910, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'House Manual', 'House Manual', 0, 0, 0),
(1911, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Private: Traveler will get this information after confirmed reservation. For example, Parking information, Internet access details.', 'Private: Traveler will get this information after confirmed reservation. For example, Parking information, Internet access details.', 0, 0, 0),
(1912, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Backup Phone', 'Backup Phone', 0, 0, 0),
(1913, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Location manual', 'Location manual', 0, 0, 0),
(1914, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, ' Enter complete location details like landmark, complete address, zip code, access details, etc', ' Enter complete location details like landmark, complete address, zip code, access details, etc', 0, 0, 0),
(1915, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Photos', 'Photos', 0, 0, 0),
(1916, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Photo caption allows only 255 characters.', 'Photo caption allows only 255 characters.', 0, 0, 0),
(1917, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Caption', 'Caption', 0, 0, 0),
(1918, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Video', 'Video', 0, 0, 0),
(1919, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Video URL', 'Video URL', 0, 0, 0),
(1920, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'You can post video URL from YouTube, Vimeo etc.', 'You can post video URL from YouTube, Vimeo etc.', 0, 0, 0),
(1921, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Admin Actions', 'Admin Actions', 0, 0, 0),
(1922, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Show in home page', 'Show in home page', 0, 0, 0),
(1923, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Finish', 'Finish', 0, 0, 0),
(1924, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Waiting For Approval', 'Waiting For Approval', 0, 0, 0),
(1925, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'System flagged', 'System flagged', 0, 0, 0),
(1926, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Waiting For Verification', 'Waiting For Verification', 0, 0, 0),
(1927, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Disappear property from user side', 'Disappear property from user side', 0, 0, 0),
(1928, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Deactivate User', 'Deactivate User', 0, 0, 0),
(1929, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Activate User', 'Activate User', 0, 0, 0),
(1930, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Not Featured', 'Not Featured', 0, 0, 0),
(1931, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Permanent Delete', 'Permanent Delete', 0, 0, 0),
(1932, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Waiting for verify', 'Waiting for verify', 0, 0, 0),
(1933, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Clear verify', 'Clear verify', 0, 0, 0),
(1934, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Hide in home page', 'Hide in home page', 0, 0, 0),
(1935, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Per Night', 'Per Night', 0, 0, 0),
(1936, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Additional Guest', 'Additional Guest', 0, 0, 0),
(1937, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'per night for each guest after', 'per night for each guest after', 0, 0, 0),
(1938, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Successful', 'Successful', 0, 0, 0),
(1939, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Reviews', 'Reviews', 0, 0, 0),
(1940, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Added 0n', 'Added 0n', 0, 0, 0),
(1941, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'whois', 'whois', 0, 0, 0),
(1942, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'User Deactivated', 'User Deactivated', 0, 0, 0),
(1943, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'HomePage', 'HomePage', 0, 0, 0),
(1944, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Selected Properties', 'Selected Properties', 0, 0, 0),
(1945, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Choose collections', 'Choose collections', 0, 0, 0),
(1946, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Map it', 'Map it', 0, 0, 0),
(1947, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'My Calendar', 'My Calendar', 0, 0, 0),
(1948, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Loading data...', 'Loading data...', 0, 0, 0),
(1949, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Sorry, could not load your data, please try again later', 'Sorry, could not load your data, please try again later', 0, 0, 0),
(1950, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Loading', 'Loading', 0, 0, 0),
(1951, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Loading...', 'Loading...', 0, 0, 0),
(1952, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Select Check in/Check out dates', 'Select Check in/Check out dates', 0, 0, 0),
(1953, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Import your properties from', 'Import your properties from', 0, 0, 0),
(1954, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'AirBnB', 'AirBnB', 0, 0, 0),
(1955, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'AirBnB Login', 'AirBnB Login', 0, 0, 0),
(1956, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Note: We will not store your AirBnB email and password.', 'Note: We will not store your AirBnB email and password.', 0, 0, 0),
(1957, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'AirBnB Email', 'AirBnB Email', 0, 0, 0),
(1958, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'AirBnB Password', 'AirBnB Password', 0, 0, 0),
(1959, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Imported', 'Imported', 0, 0, 0),
(1960, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'No properties available', 'No properties available', 0, 0, 0),
(1961, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Import', 'Import', 0, 0, 0),
(1962, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Bookmarked Properties', 'Bookmarked Properties', 0, 0, 0),
(1963, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Viewed', 'Viewed', 0, 0, 0),
(1964, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'level', 'level', 0, 0, 0),
(1965, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Narrow your search to street or at least city level to get better results.', 'Narrow your search to street or at least city level to get better results.', 0, 0, 0),
(1966, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Sort by: ', 'Sort by: ', 0, 0, 0),
(1967, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Price low to high', 'Price low to high', 0, 0, 0),
(1968, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Price high to low', 'Price high to low', 0, 0, 0),
(1969, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Recent', 'Recent', 0, 0, 0),
(1970, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'results', 'results', 0, 0, 0),
(1971, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Share Results', 'Share Results', 0, 0, 0),
(1972, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Close', 'Close', 0, 0, 0),
(1973, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Network Level', 'Network Level', 0, 0, 0),
(1974, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Network', 'Network', 0, 0, 0),
(1975, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Level', 'Level', 0, 0, 0),
(1976, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Connect with Facebook to find your friend level with host', 'Connect with Facebook to find your friend level with host', 0, 0, 0),
(1977, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Enable Facebook friends level display in social networks page', 'Enable Facebook friends level display in social networks page', 0, 0, 0),
(1978, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Host is not connected with Facebook', 'Host is not connected with Facebook', 0, 0, 0),
(1979, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Not available', 'Not available', 0, 0, 0),
(1980, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Unlike', 'Unlike', 0, 0, 0),
(1981, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Like', 'Like', 0, 0, 0),
(1982, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'No properties available. You may %s on this address for others to respond.', 'No properties available. You may %s on this address for others to respond.', 0, 0, 0),
(1983, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'create a request', 'create a request', 0, 0, 0),
(1984, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'No properties available.', 'No properties available.', 0, 0, 0),
(1985, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Refine', 'Refine', 0, 0, 0),
(1986, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Keywords', 'Keywords', 0, 0, 0),
(1987, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Price Range', 'Price Range', 0, 0, 0),
(1988, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Price range ', 'Price range ', 0, 0, 0),
(1989, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, ' to ', ' to ', 0, 0, 0),
(1990, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Deposit range ', 'Deposit range ', 0, 0, 0),
(1991, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Connect with Facebook', 'Connect with Facebook', 0, 0, 0),
(1992, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'to filter by Social Network level', 'to filter by Social Network level', 0, 0, 0),
(1993, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Size', 'Size', 0, 0, 0),
(1994, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Min Bedrooms', 'Min Bedrooms', 0, 0, 0),
(1995, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Min Bathrooms', 'Min Bathrooms', 0, 0, 0),
(1996, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Min Beds', 'Min Beds', 0, 0, 0),
(1997, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Languages Spoken', 'Languages Spoken', 0, 0, 0),
(1998, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Please enter your search criteria', 'Please enter your search criteria', 0, 0, 0),
(1999, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Save', 'Save', 0, 0, 0),
(2000, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Assign a property for', 'Assign a property for', 0, 0, 0),
(2001, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Assign', 'Assign', 0, 0, 0),
(2002, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'No Matched Properties available', 'No Matched Properties available', 0, 0, 0),
(2003, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Filter: ', 'Filter: ', 0, 0, 0),
(2004, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Waiting for verification', 'Waiting for verification', 0, 0, 0),
(2005, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Verification Rejected', 'Verification Rejected', 0, 0, 0),
(2006, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Booked', 'Booked', 0, 0, 0),
(2007, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Post to Craigslist', 'Post to Craigslist', 0, 0, 0),
(2008, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Get Verified', 'Get Verified', 0, 0, 0),
(2009, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, ' KM Away', ' KM Away', 0, 0, 0),
(2010, '2012-01-11 17:04:39', '2012-01-11 17:04:39', 42, 'Posting Title', 'Posting Title', 0, 0, 0),
(2011, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Category', 'Category', 0, 0, 0),
(2012, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Market', 'Market', 0, 0, 0),
(2013, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Guest Photos', 'Guest Photos', 0, 0, 0),
(2014, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Guest Videos', 'Guest Videos', 0, 0, 0),
(2015, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Videos', 'Videos', 0, 0, 0),
(2016, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Posted on', 'Posted on', 0, 0, 0),
(2017, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Host Panel', 'Host Panel', 0, 0, 0),
(2018, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'This is your property', 'This is your property', 0, 0, 0),
(2019, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Reservations', 'Reservations', 0, 0, 0);
INSERT INTO `translations` (`id`, `created`, `modified`, `language_id`, `key`, `lang_text`, `is_translated`, `is_google_translate`, `is_verified`) VALUES
(2020, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'All:', 'All:', 0, 0, 0),
(2021, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Waiting for acceptance:', 'Waiting for acceptance:', 0, 0, 0),
(2022, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Pipeline:', 'Pipeline:', 0, 0, 0),
(2023, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Enable Listing', 'Enable Listing', 0, 0, 0),
(2024, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Distance (km)', 'Distance (km)', 0, 0, 0),
(2025, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Posted on ', 'Posted on ', 0, 0, 0),
(2026, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Flag this property', 'Flag this property', 0, 0, 0),
(2027, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Street View', 'Street View', 0, 0, 0),
(2028, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Rate Details', 'Rate Details', 0, 0, 0),
(2029, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Additional Features', 'Additional Features', 0, 0, 0),
(2030, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Accommodates', 'Accommodates', 0, 0, 0),
(2031, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Bed rooms', 'Bed rooms', 0, 0, 0),
(2032, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Bath rooms', 'Bath rooms', 0, 0, 0),
(2033, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Pets allowed', 'Pets allowed', 0, 0, 0),
(2034, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Details', 'Details', 0, 0, 0),
(2035, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Price per night', 'Price per night', 0, 0, 0),
(2036, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Price per week', 'Price per week', 0, 0, 0),
(2037, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Price per month', 'Price per month', 0, 0, 0),
(2038, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Extra people', 'Extra people', 0, 0, 0),
(2039, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'per night after', 'per night after', 0, 0, 0),
(2040, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'guest', 'guest', 0, 0, 0),
(2041, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'No Additional Cost', 'No Additional Cost', 0, 0, 0),
(2042, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Minimum Stay', 'Minimum Stay', 0, 0, 0),
(2043, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'nights', 'nights', 0, 0, 0),
(2044, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Maximum Stay', 'Maximum Stay', 0, 0, 0),
(2045, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'No house rules available', 'No house rules available', 0, 0, 0),
(2046, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Nearby Properties', 'Nearby Properties', 0, 0, 0),
(2047, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Tweets Around ', 'Tweets Around ', 0, 0, 0),
(2048, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Tweets Arround', 'Tweets Arround', 0, 0, 0),
(2049, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Flickr', 'Flickr', 0, 0, 0),
(2050, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Weather', 'Weather', 0, 0, 0),
(2051, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Amenities Around', 'Amenities Around', 0, 0, 0),
(2052, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Amenity Map', 'Amenity Map', 0, 0, 0),
(2053, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Top comments', 'Top comments', 0, 0, 0),
(2054, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Other Property Reviews', 'Other Property Reviews', 0, 0, 0),
(2055, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'All users', 'All users', 0, 0, 0),
(2056, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Property Feedbacks', 'Property Feedbacks', 0, 0, 0),
(2057, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'per week', 'per week', 0, 0, 0),
(2058, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'per month', 'per month', 0, 0, 0),
(2059, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Check in/Check out dates are not in this month? Select both dates', 'Check in/Check out dates are not in this month? Select both dates', 0, 0, 0),
(2060, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Price Details', 'Price Details', 0, 0, 0),
(2061, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'No. of nights', 'No. of nights', 0, 0, 0),
(2062, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Additional Guest Prices ', 'Additional Guest Prices ', 0, 0, 0),
(2063, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Sub Total', 'Sub Total', 0, 0, 0),
(2064, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Service Tax', 'Service Tax', 0, 0, 0),
(2065, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'or', 'or', 0, 0, 0),
(2066, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'For pricing negotiation', 'For pricing negotiation', 0, 0, 0),
(2067, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Conditions', 'Conditions', 0, 0, 0),
(2068, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Min nights', 'Min nights', 0, 0, 0),
(2069, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Max nights', 'Max nights', 0, 0, 0),
(2070, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Max Guests', 'Max Guests', 0, 0, 0),
(2071, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Host Stats', 'Host Stats', 0, 0, 0),
(2072, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Contact Me', 'Contact Me', 0, 0, 0),
(2073, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'You and host are connected at %s%s level through Facebook', 'You and host are connected at %s%s level through Facebook', 0, 0, 0),
(2074, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Common friends connected through Facebook', 'Common friends connected through Facebook', 0, 0, 0),
(2075, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Property Title', 'Property Title', 0, 0, 0),
(2076, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'No Favorites available', 'No Favorites available', 0, 0, 0),
(2077, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Success Rate: ', 'Success Rate: ', 0, 0, 0),
(2078, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, ' Success Rate', ' Success Rate', 0, 0, 0),
(2079, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'On Time: ', 'On Time: ', 0, 0, 0),
(2080, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Still no booking', 'Still no booking', 0, 0, 0),
(2081, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Review this property and host', 'Review this property and host', 0, 0, 0),
(2082, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Are you satisfied in the trips?', 'Are you satisfied in the trips?', 0, 0, 0),
(2083, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Satisfied', 'Satisfied', 0, 0, 0),
(2084, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Please give your host a chance to improve his work before submitting a negative review. ', 'Please give your host a chance to improve his work before submitting a negative review. ', 0, 0, 0),
(2085, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Contact Your Seller', 'Contact Your Seller', 0, 0, 0),
(2086, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Optional: Upload the photos and videos you have taken in/about this property. This will help other future guests.', 'Optional: Upload the photos and videos you have taken in/about this property. This will help other future guests.', 0, 0, 0),
(2087, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Feedback', 'Feedback', 0, 0, 0),
(2088, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'No Feedbacks available', 'No Feedbacks available', 0, 0, 0),
(2089, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Reviewed on', 'Reviewed on', 0, 0, 0),
(2090, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'No Reviews available', 'No Reviews available', 0, 0, 0),
(2091, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'No guest photos available', 'No guest photos available', 0, 0, 0),
(2092, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'You are rating this work, Positive :)', 'You are rating this work, Positive :)', 0, 0, 0),
(2093, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'You are rating this work, Negative :( <p>If you are not satisfied with the work and need refund, you can open a \\"dispute\\".</p>', 'You are rating this work, Negative :( <p>If you are not satisfied with the work and need refund, you can open a \\"dispute\\".</p>', 0, 0, 0),
(2094, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'You are rating this work, Negative :( <p>You can also, request for rework, by selecting \\"Request Improvement\\" tab</p><p>Or, if you are not satisfied with the work and need refund, you can open a \\"dispute\\".</p>', 'You are rating this work, Negative :( <p>You can also, request for rework, by selecting \\"Request Improvement\\" tab</p><p>Or, if you are not satisfied with the work and need refund, you can open a \\"dispute\\".</p>', 0, 0, 0),
(2095, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'No guest videos available', 'No guest videos available', 0, 0, 0),
(2096, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, ' Category', ' Category', 0, 0, 0),
(2097, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Edit Property Flag Category', 'Edit Property Flag Category', 0, 0, 0),
(2098, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'No Property Flag Categories available', 'No Property Flag Categories available', 0, 0, 0),
(2099, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Flag This Property', 'Flag This Property', 0, 0, 0),
(2100, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'All Property flagged by %s', 'All Property flagged by %s', 0, 0, 0),
(2101, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Show all propertys flagged by %s ', 'Show all propertys flagged by %s ', 0, 0, 0),
(2102, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'No Flags available', 'No Flags available', 0, 0, 0),
(2103, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Submit Dispute', 'Submit Dispute', 0, 0, 0),
(2104, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Dispute is possible only for the following cases.', 'Dispute is possible only for the following cases.', 0, 0, 0),
(2105, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Currently, Your booking hasn''t met those cases.', 'Currently, Your booking hasn''t met those cases.', 0, 0, 0),
(2106, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Current dispute for this booking hasn''t been closed yet. Only one dispute at a time for an booking is possible.', 'Current dispute for this booking hasn''t been closed yet. Only one dispute at a time for an booking is possible.', 0, 0, 0),
(2107, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Booking #', 'Booking #', 0, 0, 0),
(2108, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Booking Status', 'Booking Status', 0, 0, 0),
(2109, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Property User Type', 'Property User Type', 0, 0, 0),
(2110, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Dispute Type', 'Dispute Type', 0, 0, 0),
(2111, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Dispute Status', 'Dispute Status', 0, 0, 0),
(2112, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Resolved', 'Resolved', 0, 0, 0),
(2113, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Favor user type', 'Favor user type', 0, 0, 0),
(2114, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Last Replied Date', 'Last Replied Date', 0, 0, 0),
(2115, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Dispute Conversation Count', 'Dispute Conversation Count', 0, 0, 0),
(2116, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'View activities', 'View activities', 0, 0, 0),
(2117, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Not yet', 'Not yet', 0, 0, 0),
(2118, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Auto Dispute Action:', 'Auto Dispute Action:', 0, 0, 0),
(2119, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'If', 'If', 0, 0, 0),
(2120, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'makes a reply/opens a dispute, you need to make a reply within', 'makes a reply/opens a dispute, you need to make a reply within', 0, 0, 0),
(2121, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'in booking to avoid making descision in favor of', 'in booking to avoid making descision in favor of', 0, 0, 0),
(2122, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, ', after that it''ll', ', after that it''ll', 0, 0, 0),
(2123, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'turn to make a response untill the same alloted days for him to avoid dispute be closed in favor of you.', 'turn to make a response untill the same alloted days for him to avoid dispute be closed in favor of you.', 0, 0, 0),
(2124, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Administrator Decision:', 'Administrator Decision:', 0, 0, 0),
(2125, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'The administrator decision will takes place when the total converstation count for the dispute reaches', 'The administrator decision will takes place when the total converstation count for the dispute reaches', 0, 0, 0),
(2126, '2012-01-11 17:04:40', '2012-01-11 17:04:40', 42, 'Dispute Information', 'Dispute Information', 0, 0, 0),
(2127, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Dispute ID', 'Dispute ID', 0, 0, 0),
(2128, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Disputer', 'Disputer', 0, 0, 0),
(2129, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Waiting for response from the other user', 'Waiting for response from the other user', 0, 0, 0),
(2130, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Converstation Underway', 'Converstation Underway', 0, 0, 0),
(2131, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Last Replied', 'Last Replied', 0, 0, 0),
(2132, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Disputed On', 'Disputed On', 0, 0, 0),
(2133, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Disputed', 'Disputed', 0, 0, 0),
(2134, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Dispute Reason', 'Dispute Reason', 0, 0, 0),
(2135, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Dispute Actions', 'Dispute Actions', 0, 0, 0),
(2136, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'The below action will be automatically be taken, if the disputer didn''t reply in', 'The below action will be automatically be taken, if the disputer didn''t reply in', 0, 0, 0),
(2137, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Review and rate this Traveler', 'Review and rate this Traveler', 0, 0, 0),
(2138, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Are you satisfied this traveler?', 'Are you satisfied this traveler?', 0, 0, 0),
(2139, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Pending Approval', 'Pending Approval', 0, 0, 0),
(2140, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Traveler review', 'Traveler review', 0, 0, 0),
(2141, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Host review', 'Host review', 0, 0, 0),
(2142, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Trip Id #', 'Trip Id #', 0, 0, 0),
(2143, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Site Commission Amount', 'Site Commission Amount', 0, 0, 0),
(2144, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Paid Amount to host', 'Paid Amount to host', 0, 0, 0),
(2145, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Traveler Service Fee', 'Traveler Service Fee', 0, 0, 0),
(2146, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Original Search Address', 'Original Search Address', 0, 0, 0),
(2147, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Cancel and refund', 'Cancel and refund', 0, 0, 0),
(2148, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'View Transactions', 'View Transactions', 0, 0, 0),
(2149, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'No Property Users available', 'No Property Users available', 0, 0, 0),
(2150, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Order confirmation request will be expired automatically in ', 'Order confirmation request will be expired automatically in ', 0, 0, 0),
(2151, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, ' hrs, please hurry to confirm.', ' hrs, please hurry to confirm.', 0, 0, 0),
(2152, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Check in Date', 'Check in Date', 0, 0, 0),
(2153, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Check out Date', 'Check out Date', 0, 0, 0),
(2154, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Trip Id', 'Trip Id', 0, 0, 0),
(2155, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Gross', 'Gross', 0, 0, 0),
(2156, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Booking code', 'Booking code', 0, 0, 0),
(2157, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'No of Days', 'No of Days', 0, 0, 0),
(2158, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Booked Date', 'Booked Date', 0, 0, 0),
(2159, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Top Code', 'Top Code', 0, 0, 0),
(2160, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Bottom Code', 'Bottom Code', 0, 0, 0),
(2161, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Under dispute. Continued only after dispute gets closed.', 'Under dispute. Continued only after dispute gets closed.', 0, 0, 0),
(2162, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Private note', 'Private note', 0, 0, 0),
(2163, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Respond', 'Respond', 0, 0, 0),
(2164, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Negotiated', 'Negotiated', 0, 0, 0),
(2165, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'In the calendar, you can override your properties prices and also confirm bookings.', 'In the calendar, you can override your properties prices and also confirm bookings.', 0, 0, 0),
(2166, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'If you want to view property wise calendar, visit', 'If you want to view property wise calendar, visit', 0, 0, 0),
(2167, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Legends', 'Legends', 0, 0, 0),
(2168, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Available', 'Available', 0, 0, 0),
(2169, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Not Available', 'Not Available', 0, 0, 0),
(2170, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Booking Requested', 'Booking Requested', 0, 0, 0),
(2171, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Booking Confirmed', 'Booking Confirmed', 0, 0, 0),
(2172, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Negotiation Requested', 'Negotiation Requested', 0, 0, 0),
(2173, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'If you have a disagreement or argument about your booking or not satisfied about the property and looking for claim your amount or require any other support based on below show cases, you can open a dispute.<br/>Note: Your posted dispute will be monitored by administrator and favor for the traveler/host will made by administrator alone.', 'If you have a disagreement or argument about your booking or not satisfied about the property and looking for claim your amount or require any other support based on below show cases, you can open a dispute.<br/>Note: Your posted dispute will be monitored by administrator and favor for the traveler/host will made by administrator alone.', 0, 0, 0),
(2174, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Show', 'Show', 0, 0, 0),
(2175, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'List', 'List', 0, 0, 0),
(2176, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Grid', 'Grid', 0, 0, 0),
(2177, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Trip Id# ', 'Trip Id# ', 0, 0, 0),
(2178, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Host: ', 'Host: ', 0, 0, 0),
(2179, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Private note: ', 'Private note: ', 0, 0, 0),
(2180, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Print Ticket', 'Print Ticket', 0, 0, 0),
(2181, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Book it', 'Book it', 0, 0, 0),
(2182, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Days', 'Days', 0, 0, 0),
(2183, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'No trips available', 'No trips available', 0, 0, 0),
(2184, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Select Date', 'Select Date', 0, 0, 0),
(2185, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'This check in date is for your own tracking purpose. %s will always consider the check in time mentioned while booking for any transaction--including payment release.', 'This check in date is for your own tracking purpose. %s will always consider the check in time mentioned while booking for any transaction--including payment release.', 0, 0, 0),
(2186, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'This check out date is for your own tracking purpose. %s will always consider the check out time mentioned while booking for any transaction--including payment release.', 'This check out date is for your own tracking purpose. %s will always consider the check out time mentioned while booking for any transaction--including payment release.', 0, 0, 0),
(2187, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Backup phone:', 'Backup phone:', 0, 0, 0),
(2188, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'House rule', 'House rule', 0, 0, 0),
(2189, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Location Manual', 'Location Manual', 0, 0, 0),
(2190, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, ' Notes', ' Notes', 0, 0, 0),
(2191, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Full payment will be released on %s. (check in date at the time of booking + %s day(s))', 'Full payment will be released on %s. (check in date at the time of booking + %s day(s))', 0, 0, 0),
(2192, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Problems? Raise dispute before ', 'Problems? Raise dispute before ', 0, 0, 0),
(2193, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, ' at ', ' at ', 0, 0, 0),
(2194, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Raising dispute will be available from %s. (check in date at the time of booking)', 'Raising dispute will be available from %s. (check in date at the time of booking)', 0, 0, 0),
(2195, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'To track your trip visit activities page ', 'To track your trip visit activities page ', 0, 0, 0),
(2196, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'After the check out, be sure to give feedback about the property in ', 'After the check out, be sure to give feedback about the property in ', 0, 0, 0),
(2197, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Host copy', 'Host copy', 0, 0, 0),
(2198, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, '2011', '2011', 0, 0, 0),
(2199, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, '. All rights reserved.', '. All rights reserved.', 0, 0, 0),
(2200, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Viewed By', 'Viewed By', 0, 0, 0),
(2201, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Viewed On', 'Viewed On', 0, 0, 0),
(2202, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'No Property Views available', 'No Property Views available', 0, 0, 0),
(2203, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'No Request Favorites available', 'No Request Favorites available', 0, 0, 0),
(2204, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Request Flag Count', 'Request Flag Count', 0, 0, 0),
(2205, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'No Request Flag Categories available', 'No Request Flag Categories available', 0, 0, 0),
(2206, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Flag This Request', 'Flag This Request', 0, 0, 0),
(2207, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Request Flag Category', 'Request Flag Category', 0, 0, 0),
(2208, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'No Request Flags available', 'No Request Flags available', 0, 0, 0),
(2209, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'No Request Views available', 'No Request Views available', 0, 0, 0),
(2210, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Related Properties', 'Related Properties', 0, 0, 0),
(2211, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Any Type', 'Any Type', 0, 0, 0),
(2212, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, '(OR)', '(OR)', 0, 0, 0),
(2213, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'If the above related property does not match your exact request . You can click \\"Post\\" below to create a new one', 'If the above related property does not match your exact request . You can click \\"Post\\" below to create a new one', 0, 0, 0),
(2214, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Post', 'Post', 0, 0, 0),
(2215, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Active:', 'Active:', 0, 0, 0),
(2216, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Admin Suspended:', 'Admin Suspended:', 0, 0, 0),
(2217, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'User Suspended:', 'User Suspended:', 0, 0, 0),
(2218, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'System Flagged:', 'System Flagged:', 0, 0, 0),
(2219, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Total:', 'Total:', 0, 0, 0),
(2220, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Offered', 'Offered', 0, 0, 0),
(2221, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Accomodates', 'Accomodates', 0, 0, 0),
(2222, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Posted On', 'Posted On', 0, 0, 0),
(2223, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'No requests available', 'No requests available', 0, 0, 0),
(2224, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, ' - ', ' - ', 0, 0, 0),
(2225, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'No Requests available', 'No Requests available', 0, 0, 0),
(2226, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Exact', 'Exact', 0, 0, 0),
(2227, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Posted', 'Posted', 0, 0, 0),
(2228, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Flag this request', 'Flag this request', 0, 0, 0),
(2229, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Related Requests', 'Related Requests', 0, 0, 0),
(2230, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Other Request by ', 'Other Request by ', 0, 0, 0),
(2231, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Traveler Stats', 'Traveler Stats', 0, 0, 0),
(2232, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'No Room Types available', 'No Room Types available', 0, 0, 0),
(2233, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Search Keyword', 'Search Keyword', 0, 0, 0),
(2234, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Auto detected', 'Auto detected', 0, 0, 0),
(2235, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'No Search Logs available', 'No Search Logs available', 0, 0, 0),
(2236, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Setting Category', 'Setting Category', 0, 0, 0),
(2237, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Translations add', 'Translations add', 0, 0, 0),
(2238, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Application Info', 'Application Info', 0, 0, 0),
(2239, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Credentials', 'Credentials', 0, 0, 0),
(2240, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Other Info', 'Other Info', 0, 0, 0),
(2241, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Here you can update Facebook credentials . Click ''Update Facebook Credentials'' link below and Follow the steps. Please make sure that you have updated the API Key and Secret before you click this link.', 'Here you can update Facebook credentials . Click ''Update Facebook Credentials'' link below and Follow the steps. Please make sure that you have updated the API Key and Secret before you click this link.', 0, 0, 0),
(2242, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Here you can update Twitter credentials like Access key and Accss Token. Click ''Update Twitter Credentials'' link below and Follow the steps. Please make sure that you have updated the Consumer Key and  Consumer secret before you click this link.', 'Here you can update Twitter credentials like Access key and Accss Token. Click ''Update Twitter Credentials'' link below and Follow the steps. Please make sure that you have updated the Consumer Key and  Consumer secret before you click this link.', 0, 0, 0),
(2243, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, '<span>Update Facebook Credentials</span>', '<span>Update Facebook Credentials</span>', 0, 0, 0),
(2244, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Here you can update Facebook credentials . Click this link and Follow the steps. Please make sure that you have updated the API Key and Secret before you click this link.', 'Here you can update Facebook credentials . Click this link and Follow the steps. Please make sure that you have updated the API Key and Secret before you click this link.', 0, 0, 0),
(2245, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, '<span>Update Twitter Credentials</span>', '<span>Update Twitter Credentials</span>', 0, 0, 0),
(2246, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Here you can update Twitter credentials like Access key and Accss Token. Click this link and Follow the steps. Please make sure that you have updated the Consumer Key and  Consumer secret before you click this link.', 'Here you can update Twitter credentials like Access key and Accss Token. Click this link and Follow the steps. Please make sure that you have updated the Consumer Key and  Consumer secret before you click this link.', 0, 0, 0),
(2247, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'hrs', 'hrs', 0, 0, 0),
(2248, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'registration', 'registration', 0, 0, 0),
(2249, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'SiteLogo', 'SiteLogo', 0, 0, 0),
(2250, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Not Allow Beyond Original', 'Not Allow Beyond Original', 0, 0, 0),
(2251, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Allow Handle Aspect', 'Allow Handle Aspect', 0, 0, 0),
(2252, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'No settings available', 'No settings available', 0, 0, 0),
(2253, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'No Site Categories available', 'No Site Categories available', 0, 0, 0),
(2254, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Is Active', 'Is Active', 0, 0, 0),
(2255, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Adm1code', 'Adm1code', 0, 0, 0),
(2256, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Edit State - ', 'Edit State - ', 0, 0, 0),
(2257, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Add New State', 'Add New State', 0, 0, 0),
(2258, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'No states available', 'No states available', 0, 0, 0),
(2259, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Contacts found in your friends list', 'Contacts found in your friends list', 0, 0, 0),
(2260, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Contacts found in', 'Contacts found in', 0, 0, 0),
(2261, '2012-01-11 17:04:41', '2012-01-11 17:04:41', 42, 'Invite your contacts to', 'Invite your contacts to', 0, 0, 0),
(2262, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Contact Name', 'Contact Name', 0, 0, 0),
(2263, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Contact E-mail', 'Contact E-mail', 0, 0, 0),
(2264, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'friends available in your mail', 'friends available in your mail', 0, 0, 0),
(2265, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'contacts available in your mail', 'contacts available in your mail', 0, 0, 0),
(2266, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'No contacts available in your mail', 'No contacts available in your mail', 0, 0, 0),
(2267, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Credit', 'Credit', 0, 0, 0),
(2268, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'No Transaction Types available', 'No Transaction Types available', 0, 0, 0),
(2269, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Booking has high priority than', 'Booking has high priority than', 0, 0, 0),
(2270, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'CSV', 'CSV', 0, 0, 0),
(2271, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Export This Report In CSV', 'Export This Report In CSV', 0, 0, 0),
(2272, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Debit', 'Debit', 0, 0, 0),
(2273, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'No Transactions available', 'No Transactions available', 0, 0, 0),
(2274, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Account Summary', 'Account Summary', 0, 0, 0),
(2275, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Account Balance', 'Account Balance', 0, 0, 0),
(2276, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Withdraw Request', 'Withdraw Request', 0, 0, 0),
(2277, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'To ', 'To ', 0, 0, 0),
(2278, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Total ', 'Total ', 0, 0, 0),
(2279, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'English', 'English', 0, 0, 0),
(2280, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'To Language', 'To Language', 0, 0, 0),
(2281, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'It will only populate site labels for selected new language. You need to manually enter all the equivalent translated labels.', 'It will only populate site labels for selected new language. You need to manually enter all the equivalent translated labels.', 0, 0, 0),
(2282, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'It will automatically translate site labels into selected language with Google. You may then edit necessary labels.', 'It will automatically translate site labels into selected language with Google. You may then edit necessary labels.', 0, 0, 0),
(2283, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Google Translate service is currently a paid service and you''d need API key to use it.', 'Google Translate service is currently a paid service and you''d need API key to use it.', 0, 0, 0),
(2284, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Please enter Google Translate API key in ', 'Please enter Google Translate API key in ', 0, 0, 0),
(2285, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Original', 'Original', 0, 0, 0),
(2286, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Make New Translation', 'Make New Translation', 0, 0, 0),
(2287, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Add New Text', 'Add New Text', 0, 0, 0),
(2288, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Sorry, in order to translate, default English strings should be extracted and available. Please contact support.', 'Sorry, in order to translate, default English strings should be extracted and available. Please contact support.', 0, 0, 0),
(2289, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Not Verified', 'Not Verified', 0, 0, 0),
(2290, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Manage', 'Manage', 0, 0, 0),
(2291, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Delete Translation', 'Delete Translation', 0, 0, 0),
(2292, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'No Translations available', 'No Translations available', 0, 0, 0),
(2293, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Unverified', 'Unverified', 0, 0, 0),
(2294, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Verified: ', 'Verified: ', 0, 0, 0),
(2295, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'If you translated with Google Translate, it may not be perfect translation and it may have mistakes. So you need to manually check all translated texts. The translation stats will give summary of verified/unverified translated text.', 'If you translated with Google Translate, it may not be perfect translation and it may have mistakes. So you need to manually check all translated texts. The translation stats will give summary of verified/unverified translated text.', 0, 0, 0),
(2296, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Translated', 'Translated', 0, 0, 0),
(2297, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'No translations available', 'No translations available', 0, 0, 0),
(2298, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Lang Text', 'Lang Text', 0, 0, 0),
(2299, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'No User Add Wallet Amounts available', 'No User Add Wallet Amounts available', 0, 0, 0),
(2300, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'The requested amount will be deducted from your wallet and the amount will be blocked until it get approved or rejected by the administrator. Once its approved, the requested amount will be sent to your paypal account. In case of failure, the amount will be refunded to your wallet.', 'The requested amount will be deducted from your wallet and the amount will be blocked until it get approved or rejected by the administrator. Once its approved, the requested amount will be sent to your paypal account. In case of failure, the amount will be refunded to your wallet.', 0, 0, 0),
(2301, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Minimum withdraw amount: %s <br/> Maximum withdraw amount: %s', 'Minimum withdraw amount: %s <br/> Maximum withdraw amount: %s', 0, 0, 0),
(2302, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Edit Withdraw Fund Request', 'Edit Withdraw Fund Request', 0, 0, 0),
(2303, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Withdrawal Status ', 'Withdrawal Status ', 0, 0, 0),
(2304, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Your money transfer account is empty, so click here to update money transfer account.', 'Your money transfer account is empty, so click here to update money transfer account.', 0, 0, 0),
(2305, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'money transfer accounts', 'money transfer accounts', 0, 0, 0),
(2306, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'No withdraw fund requests available', 'No withdraw fund requests available', 0, 0, 0),
(2307, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Add your recommendation for ', 'Add your recommendation for ', 0, 0, 0),
(2308, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Add your recommendation', 'Add your recommendation', 0, 0, 0),
(2309, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Add User Comment', 'Add User Comment', 0, 0, 0),
(2310, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Posted User', 'Posted User', 0, 0, 0),
(2311, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Edit User Comment', 'Edit User Comment', 0, 0, 0),
(2312, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Posted user', 'Posted user', 0, 0, 0),
(2313, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'User Comments', 'User Comments', 0, 0, 0),
(2314, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Commented User', 'Commented User', 0, 0, 0),
(2315, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Comments', 'Comments', 0, 0, 0),
(2316, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Ban User IP', 'Ban User IP', 0, 0, 0),
(2317, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'No User Comments available', 'No User Comments available', 0, 0, 0),
(2318, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'User Comment', 'User Comment', 0, 0, 0),
(2319, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Posted User Id', 'Posted User Id', 0, 0, 0),
(2320, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Recommended', 'Recommended', 0, 0, 0),
(2321, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'No recommendations available', 'No recommendations available', 0, 0, 0),
(2322, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'No Educations available', 'No Educations available', 0, 0, 0),
(2323, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'No Employments available', 'No Employments available', 0, 0, 0),
(2324, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Remove Friend', 'Remove Friend', 0, 0, 0),
(2325, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'No User Friends available', 'No User Friends available', 0, 0, 0),
(2326, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Friend User Id', 'Friend User Id', 0, 0, 0),
(2327, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Friend Status', 'Friend Status', 0, 0, 0),
(2328, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Contacts', 'Contacts', 0, 0, 0),
(2329, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'No user contacts available.', 'No user contacts available.', 0, 0, 0),
(2330, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'YAHOO!', 'YAHOO!', 0, 0, 0),
(2331, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'MSN', 'MSN', 0, 0, 0),
(2332, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'CSV Import', 'CSV Import', 0, 0, 0),
(2333, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'You need to give %s permission to access your Yahoo! Mail address book.', 'You need to give %s permission to access your Yahoo! Mail address book.', 0, 0, 0),
(2334, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'We''ll take you to Yahoo! where you''ll be asked to let %s take a peek at your address book. Once you get there, click \\"Grant access\\" and you''ll be returned here to find your friends.', 'We''ll take you to Yahoo! where you''ll be asked to let %s take a peek at your address book. Once you get there, click \\"Grant access\\" and you''ll be returned here to find your friends.', 0, 0, 0),
(2335, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Your privacy is our top concern', 'Your privacy is our top concern', 0, 0, 0),
(2336, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Your contacts are your private information. Only you have access to your contacts, and %s will not send them any email. For more information please see the %', 'Your contacts are your private information. Only you have access to your contacts, and %s will not send them any email. For more information please see the %', 0, 0, 0),
(2337, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Privacy Policy', 'Privacy Policy', 0, 0, 0),
(2338, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Go', 'Go', 0, 0, 0),
(2339, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'You need to give %s permission to access your Gmail address book.', 'You need to give %s permission to access your Gmail address book.', 0, 0, 0),
(2340, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'We''ll take you to Google where you''ll be asked to let %s take a peek at your address book. Once you get there, click \\"Grant access\\" and you''ll be returned here to find your friends.', 'We''ll take you to Google where you''ll be asked to let %s take a peek at your address book. Once you get there, click \\"Grant access\\" and you''ll be returned here to find your friends.', 0, 0, 0),
(2341, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'You need to give %s permission to access your Windows Live Hotmail address book.', 'You need to give %s permission to access your Windows Live Hotmail address book.', 0, 0, 0),
(2342, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'We''ll take you to Windows Live where you''ll be asked to let %s take a peek at your address book. Once you get there, click \\"Grant access\\" and you''ll be returned here to find your friends.', 'We''ll take you to Windows Live where you''ll be asked to let %s take a peek at your address book. Once you get there, click \\"Grant access\\" and you''ll be returned here to find your friends.', 0, 0, 0),
(2343, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'You can export contacts to a file (csv - comma separated values) from any address book software and upload that file.', 'You can export contacts to a file (csv - comma separated values) from any address book software and upload that file.', 0, 0, 0),
(2344, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'View Sample CSV File', 'View Sample CSV File', 0, 0, 0),
(2345, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Upload Friends', 'Upload Friends', 0, 0, 0),
(2346, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Reject ', 'Reject ', 0, 0, 0),
(2347, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Accept ', 'Accept ', 0, 0, 0),
(2348, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Remove ', 'Remove ', 0, 0, 0),
(2349, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'No approved friends available', 'No approved friends available', 0, 0, 0),
(2350, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'No rejected friends available', 'No rejected friends available', 0, 0, 0),
(2351, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'No pending friends available', 'No pending friends available', 0, 0, 0),
(2352, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'No friends available', 'No friends available', 0, 0, 0),
(2353, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Find people you know on %s', 'Find people you know on %s', 0, 0, 0),
(2354, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Received Friends Requests', 'Received Friends Requests', 0, 0, 0),
(2355, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Sent Friends Requests', 'Sent Friends Requests', 0, 0, 0),
(2356, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'No Income Ranges available', 'No Income Ranges available', 0, 0, 0),
(2357, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Login Time', 'Login Time', 0, 0, 0),
(2358, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'User Login IP', 'User Login IP', 0, 0, 0),
(2359, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'User Agent', 'User Agent', 0, 0, 0),
(2360, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'No User Logins available', 'No User Logins available', 0, 0, 0),
(2361, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Send notification when you receive a booking for your property', 'Send notification when you receive a booking for your property', 0, 0, 0),
(2362, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Send notification when you make an booking', 'Send notification when you make an booking', 0, 0, 0),
(2363, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Send notification when you accept an booking', 'Send notification when you accept an booking', 0, 0, 0),
(2364, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Send notification when your property booking was accepted', 'Send notification when your property booking was accepted', 0, 0, 0),
(2365, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Send notification when your property booking by a traveler was canceled by admin', 'Send notification when your property booking by a traveler was canceled by admin', 0, 0, 0),
(2366, '2012-01-11 17:04:42', '2012-01-11 17:04:42', 42, 'Send notification when the property booking made by you was canceled by admin', 'Send notification when the property booking made by you was canceled by admin', 0, 0, 0),
(2367, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Send notification when you make change the status of traveler to checkin', 'Send notification when you make change the status of traveler to checkin', 0, 0, 0),
(2368, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Send notification when you change the status to checkin on arrival to the host location', 'Send notification when you change the status to checkin on arrival to the host location', 0, 0, 0),
(2369, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Send notification when your property booked was reviewed by the traveler', 'Send notification when your property booked was reviewed by the traveler', 0, 0, 0),
(2370, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Send notification when you make an review for the book made', 'Send notification when you make an review for the book made', 0, 0, 0),
(2371, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Send notification when your property booked was expired on non-acceptance by you', 'Send notification when your property booked was expired on non-acceptance by you', 0, 0, 0),
(2372, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Send notification when the booking made by you was expired on non-acceptance by the host', 'Send notification when the booking made by you was expired on non-acceptance by the host', 0, 0, 0),
(2373, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Send notification when your property booked was canceled by the traveler', 'Send notification when your property booked was canceled by the traveler', 0, 0, 0),
(2374, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Send notification when you cancel the booked you have made', 'Send notification when you cancel the booked you have made', 0, 0, 0),
(2375, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Send notification when you reject an booking', 'Send notification when you reject an booking', 0, 0, 0),
(2376, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Send notification when your booking was rejected by the host', 'Send notification when your booking was rejected by the host', 0, 0, 0),
(2377, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Send notification when your amount for the booking was cleared for withdrawal', 'Send notification when your amount for the booking was cleared for withdrawal', 0, 0, 0),
(2378, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Send notification when your booking was completed and waiting for your review', 'Send notification when your booking was completed and waiting for your review', 0, 0, 0),
(2379, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Send notification when you have contacted by other users', 'Send notification when you have contacted by other users', 0, 0, 0),
(2380, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Add New OpenID', 'Add New OpenID', 0, 0, 0),
(2381, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'No User Openids available', 'No User Openids available', 0, 0, 0),
(2382, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Manage your OpenIDs', 'Manage your OpenIDs', 0, 0, 0);
INSERT INTO `translations` (`id`, `created`, `modified`, `language_id`, `key`, `lang_text`, `is_translated`, `is_google_translate`, `is_verified`) VALUES
(2383, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'The following OpenIDs are currently attached to your %s account. You can use any of them to sign in.', 'The following OpenIDs are currently attached to your %s account. You can use any of them to sign in.', 0, 0, 0),
(2384, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'No OpenIDs available', 'No OpenIDs available', 0, 0, 0),
(2385, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Attach a new OpenID', 'Attach a new OpenID', 0, 0, 0),
(2386, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'First name', 'First name', 0, 0, 0),
(2387, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Last name', 'Last name', 0, 0, 0),
(2388, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Card Verification Number', 'Card Verification Number', 0, 0, 0),
(2389, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, '-- Please Select --', '-- Please Select --', 0, 0, 0),
(2390, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'For security reason, we are not saved the credit card details. You have to specify again.', 'For security reason, we are not saved the credit card details. You have to specify again.', 0, 0, 0),
(2391, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Billing address', 'Billing address', 0, 0, 0),
(2392, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Select Country', 'Select Country', 0, 0, 0),
(2393, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Credit Card', 'Credit Card', 0, 0, 0),
(2394, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Default', 'Default', 0, 0, 0),
(2395, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Set as default', 'Set as default', 0, 0, 0),
(2396, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'No credit cards available', 'No credit cards available', 0, 0, 0),
(2397, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Inactive:', 'Inactive:', 0, 0, 0),
(2398, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'If you want to delete any of the connections, you can click the \\"Inactive\\" link.', 'If you want to delete any of the connections, you can click the \\"Inactive\\" link.', 0, 0, 0),
(2399, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'It will deactivate the connection. It will not displayed in User side, where as it will displayed here for your reference.', 'It will deactivate the connection. It will not displayed in User side, where as it will displayed here for your reference.', 0, 0, 0),
(2400, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Pre Approval Key', 'Pre Approval Key', 0, 0, 0),
(2401, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Validity', 'Validity', 0, 0, 0),
(2402, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Purchases', 'Purchases', 0, 0, 0),
(2403, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Default?', 'Default?', 0, 0, 0),
(2404, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Charged', 'Charged', 0, 0, 0),
(2405, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Click inactive to delete PayPal connection', 'Click inactive to delete PayPal connection', 0, 0, 0),
(2406, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'PayPal Connections available', 'PayPal Connections available', 0, 0, 0),
(2407, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Add New Connection', 'Add New Connection', 0, 0, 0),
(2408, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'You can connect your PayPal account with', 'You can connect your PayPal account with', 0, 0, 0),
(2409, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'To connect your account, you will be taken to paypal.com and once connected, you can make orders without leaving to paypal.com again.', 'To connect your account, you will be taken to paypal.com and once connected, you can make orders without leaving to paypal.com again.', 0, 0, 0),
(2410, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Note: We do not save your PayPal password and the connection is enabled through PayPal standard alone. Anytime, you can disable the connection.', 'Note: We do not save your PayPal password and the connection is enabled through PayPal standard alone. Anytime, you can disable the connection.', 0, 0, 0),
(2411, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Paypal Email', 'Paypal Email', 0, 0, 0),
(2412, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'No PayPal Connections available', 'No PayPal Connections available', 0, 0, 0),
(2413, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Profile', 'Profile', 0, 0, 0),
(2414, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Middle Name', 'Middle Name', 0, 0, 0),
(2415, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'About Me', 'About Me', 0, 0, 0),
(2416, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Employment Status', 'Employment Status', 0, 0, 0),
(2417, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Income range (', 'Income range (', 0, 0, 0),
(2418, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Own Home?', 'Own Home?', 0, 0, 0),
(2419, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Relationship status', 'Relationship status', 0, 0, 0),
(2420, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Have Children?', 'Have Children?', 0, 0, 0),
(2421, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'School', 'School', 0, 0, 0),
(2422, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Work', 'Work', 0, 0, 0),
(2423, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Habit', 'Habit', 0, 0, 0),
(2424, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Contact details', 'Contact details', 0, 0, 0),
(2425, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Paypal', 'Paypal', 0, 0, 0),
(2426, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'As given in PayPal', 'As given in PayPal', 0, 0, 0),
(2427, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'No Relationships available', 'No Relationships available', 0, 0, 0),
(2428, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Viewed Time', 'Viewed Time', 0, 0, 0),
(2429, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Viewed User', 'Viewed User', 0, 0, 0),
(2430, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'No User Views available', 'No User Views available', 0, 0, 0),
(2431, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'You have not yet activated your account. Please activate it. If you have not received the activation mail, %s to resend the activation mail.', 'You have not yet activated your account. Please activate it. If you have not received the activation mail, %s to resend the activation mail.', 0, 0, 0),
(2432, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Your current available balance:', 'Your current available balance:', 0, 0, 0),
(2433, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Amount (', 'Amount (', 0, 0, 0),
(2434, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Add to Wallet', 'Add to Wallet', 0, 0, 0),
(2435, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Add User', 'Add User', 0, 0, 0),
(2436, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'User Type', 'User Type', 0, 0, 0),
(2437, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Diagnostics are for developer purpose only.', 'Diagnostics are for developer purpose only.', 0, 0, 0),
(2438, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Adaptive Payment Transaction Log', 'Adaptive Payment Transaction Log', 0, 0, 0),
(2439, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'View the transaction details done via PayPal Adaptive Payment', 'View the transaction details done via PayPal Adaptive Payment', 0, 0, 0),
(2440, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Mass Payment Transaction Log', 'Mass Payment Transaction Log', 0, 0, 0),
(2441, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'View the transaction details done via Mass PayPal', 'View the transaction details done via Mass PayPal', 0, 0, 0),
(2442, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'View the transaction logs done via Authorizenet', 'View the transaction logs done via Authorizenet', 0, 0, 0),
(2443, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Debug & Error Log', 'Debug & Error Log', 0, 0, 0),
(2444, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'View debug, error log, used cache memory and used log memory', 'View debug, error log, used cache memory and used log memory', 0, 0, 0),
(2445, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Search Log', 'Search Log', 0, 0, 0),
(2446, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'View the search log searched in property and request page', 'View the search log searched in property and request page', 0, 0, 0),
(2447, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Active Users: ', 'Active Users: ', 0, 0, 0),
(2448, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Active users', 'Active users', 0, 0, 0),
(2449, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Inactive Users: ', 'Inactive Users: ', 0, 0, 0),
(2450, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Inactive users', 'Inactive users', 0, 0, 0),
(2451, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'OpenID Users: ', 'OpenID Users: ', 0, 0, 0),
(2452, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'OpenID users', 'OpenID users', 0, 0, 0),
(2453, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Gmail Users: ', 'Gmail Users: ', 0, 0, 0),
(2454, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Gmail users', 'Gmail users', 0, 0, 0),
(2455, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Yahoo Users: ', 'Yahoo Users: ', 0, 0, 0),
(2456, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Yahoo users', 'Yahoo users', 0, 0, 0),
(2457, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Facebook Users: ', 'Facebook Users: ', 0, 0, 0),
(2458, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Facebook users', 'Facebook users', 0, 0, 0),
(2459, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Twitter Users: ', 'Twitter Users: ', 0, 0, 0),
(2460, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Twitter users', 'Twitter users', 0, 0, 0),
(2461, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Total Users:', 'Total Users:', 0, 0, 0),
(2462, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Total Users', 'Total Users', 0, 0, 0),
(2463, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Available Balance', 'Available Balance', 0, 0, 0),
(2464, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Site Revenue', 'Site Revenue', 0, 0, 0),
(2465, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Count', 'Count', 0, 0, 0),
(2466, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Time', 'Time', 0, 0, 0),
(2467, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Resend Activation', 'Resend Activation', 0, 0, 0),
(2468, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Earned', 'Earned', 0, 0, 0),
(2469, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Pending Approval:', 'Pending Approval:', 0, 0, 0),
(2470, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Enabled:', 'Enabled:', 0, 0, 0),
(2471, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Disabled:', 'Disabled:', 0, 0, 0),
(2472, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Unsuccessful', 'Unsuccessful', 0, 0, 0),
(2473, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Reviews:', 'Reviews:', 0, 0, 0),
(2474, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Amount:', 'Amount:', 0, 0, 0),
(2475, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Paid', 'Paid', 0, 0, 0),
(2476, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Bookings:', 'Bookings:', 0, 0, 0),
(2477, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Successful:', 'Successful:', 0, 0, 0),
(2478, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Unsuccessful:', 'Unsuccessful:', 0, 0, 0),
(2479, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'As User', 'As User', 0, 0, 0),
(2480, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Wallet', 'Wallet', 0, 0, 0),
(2481, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Withdrawn', 'Withdrawn', 0, 0, 0),
(2482, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Total Site Revenue', 'Total Site Revenue', 0, 0, 0),
(2483, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Registered 0n', 'Registered 0n', 0, 0, 0),
(2484, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Facebook User ID', 'Facebook User ID', 0, 0, 0),
(2485, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Twitter User ID', 'Twitter User ID', 0, 0, 0),
(2486, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Membership Paid', 'Membership Paid', 0, 0, 0),
(2487, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Email Activated', 'Email Activated', 0, 0, 0),
(2488, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'No users available', 'No users available', 0, 0, 0),
(2489, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Online Users', 'Online Users', 0, 0, 0),
(2490, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'No users online', 'No users online', 0, 0, 0),
(2491, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Recently Registered Users', 'Recently Registered Users', 0, 0, 0),
(2492, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Recently no users registered', 'Recently no users registered', 0, 0, 0),
(2493, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Bulk Mail Option', 'Bulk Mail Option', 0, 0, 0),
(2494, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Send To', 'Send To', 0, 0, 0),
(2495, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Timings', 'Timings', 0, 0, 0),
(2496, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Current time: ', 'Current time: ', 0, 0, 0),
(2497, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Last login: ', 'Last login: ', 0, 0, 0),
(2498, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Burrow', 'Burrow', 0, 0, 0),
(2499, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Version', 'Version', 0, 0, 0),
(2500, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Product Support', 'Product Support', 0, 0, 0),
(2501, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Product Manual', 'Product Manual', 0, 0, 0),
(2502, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'CSSilize', 'CSSilize', 0, 0, 0),
(2503, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Agriya Blog', 'Agriya Blog', 0, 0, 0),
(2504, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Redirecting you to authorize %s', 'Redirecting you to authorize %s', 0, 0, 0),
(2505, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'If your browser doesn''t redirect you please %s to continue.', 'If your browser doesn''t redirect you please %s to continue.', 0, 0, 0),
(2506, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Old password', 'Old password', 0, 0, 0),
(2507, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Enter a new password', 'Enter a new password', 0, 0, 0),
(2508, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Confirm Password', 'Confirm Password', 0, 0, 0),
(2509, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Balance', 'Balance', 0, 0, 0),
(2510, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Total Earned', 'Total Earned', 0, 0, 0),
(2511, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Reservation', 'Reservation', 0, 0, 0),
(2512, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Booked Trips', 'Booked Trips', 0, 0, 0),
(2513, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Forgot your password?', 'Forgot your password?', 0, 0, 0),
(2514, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Enter your Email, and we will send you instructions for resetting your password.', 'Enter your Email, and we will send you instructions for resetting your password.', 0, 0, 0),
(2515, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Sign in using: ', 'Sign in using: ', 0, 0, 0),
(2516, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Sign in with Facebook', 'Sign in with Facebook', 0, 0, 0),
(2517, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Sign in with Twitter', 'Sign in with Twitter', 0, 0, 0),
(2518, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Sign in with Yahoo', 'Sign in with Yahoo', 0, 0, 0),
(2519, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, '[Image: Yahoo]', '[Image: Yahoo]', 0, 0, 0),
(2520, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, 'Sign in with Gmail', 'Sign in with Gmail', 0, 0, 0),
(2521, '2012-01-11 17:04:43', '2012-01-11 17:04:43', 42, '[Image: Gmail]', '[Image: Gmail]', 0, 0, 0),
(2522, '2012-01-11 17:04:44', '2012-01-11 17:04:44', 42, 'Sign in with Open ID', 'Sign in with Open ID', 0, 0, 0),
(2523, '2012-01-11 17:04:44', '2012-01-11 17:04:44', 42, 'Remember me on this computer.', 'Remember me on this computer.', 0, 0, 0),
(2524, '2012-01-11 17:04:44', '2012-01-11 17:04:44', 42, 'Signup', 'Signup', 0, 0, 0),
(2525, '2012-01-11 17:04:44', '2012-01-11 17:04:44', 42, 'Sign up using: ', 'Sign up using: ', 0, 0, 0),
(2526, '2012-01-11 17:04:44', '2012-01-11 17:04:44', 42, 'Sign up with Facebook', 'Sign up with Facebook', 0, 0, 0),
(2527, '2012-01-11 17:04:44', '2012-01-11 17:04:44', 42, 'Sign up with Twitter', 'Sign up with Twitter', 0, 0, 0),
(2528, '2012-01-11 17:04:44', '2012-01-11 17:04:44', 42, 'Sign up with Yahoo', 'Sign up with Yahoo', 0, 0, 0),
(2529, '2012-01-11 17:04:44', '2012-01-11 17:04:44', 42, 'Sign up with Gmail', 'Sign up with Gmail', 0, 0, 0),
(2530, '2012-01-11 17:04:44', '2012-01-11 17:04:44', 42, 'Sign up with Open ID', 'Sign up with Open ID', 0, 0, 0),
(2531, '2012-01-11 17:04:44', '2012-01-11 17:04:44', 42, 'Terms & Policies', 'Terms & Policies', 0, 0, 0),
(2532, '2012-01-11 17:04:44', '2012-01-11 17:04:44', 42, 'I have read, understood & agree to the', 'I have read, understood & agree to the', 0, 0, 0),
(2533, '2012-01-11 17:04:44', '2012-01-11 17:04:44', 42, 'Reset your password', 'Reset your password', 0, 0, 0),
(2534, '2012-01-11 17:04:44', '2012-01-11 17:04:44', 42, 'Show Facebook friends level in properties list page.', 'Show Facebook friends level in properties list page.', 0, 0, 0),
(2535, '2012-01-11 17:04:44', '2012-01-11 17:04:44', 42, 'Joined on', 'Joined on', 0, 0, 0),
(2536, '2012-01-11 17:04:44', '2012-01-11 17:04:44', 42, 'Friend Request is Pending', 'Friend Request is Pending', 0, 0, 0),
(2537, '2012-01-11 17:04:44', '2012-01-11 17:04:44', 42, 'Click to remove from friends list', 'Click to remove from friends list', 0, 0, 0),
(2538, '2012-01-11 17:04:44', '2012-01-11 17:04:44', 42, 'Add as Friend', 'Add as Friend', 0, 0, 0),
(2539, '2012-01-11 17:04:44', '2012-01-11 17:04:44', 42, 'My Request', 'My Request', 0, 0, 0),
(2540, '2012-01-11 17:04:44', '2012-01-11 17:04:44', 42, 'Friends Comments', 'Friends Comments', 0, 0, 0),
(2541, '2012-01-11 17:04:44', '2012-01-11 17:04:44', 42, 'Referred by', 'Referred by', 0, 0, 0),
(2542, '2012-01-11 17:04:44', '2012-01-11 17:04:44', 42, 'Email confirmed', 'Email confirmed', 0, 0, 0),
(2543, '2012-01-11 17:04:44', '2012-01-11 17:04:44', 42, 'OpenID count', 'OpenID count', 0, 0, 0),
(2544, '2012-01-11 17:04:44', '2012-01-11 17:04:44', 42, 'Login count', 'Login count', 0, 0, 0),
(2545, '2012-01-11 17:04:44', '2012-01-11 17:04:44', 42, 'View count', 'View count', 0, 0, 0),
(2546, '2012-01-11 17:04:44', '2012-01-11 17:04:44', 42, 'Reffered count', 'Reffered count', 0, 0, 0),
(2547, '2012-01-11 17:04:44', '2012-01-11 17:04:44', 42, 'Facebook user id', 'Facebook user id', 0, 0, 0),
(2548, '2012-01-11 17:04:44', '2012-01-11 17:04:44', 42, 'twitter user id', 'twitter user id', 0, 0, 0),
(2549, '2012-01-11 17:04:44', '2012-01-11 17:04:44', 42, 'Signup IP', 'Signup IP', 0, 0, 0),
(2550, '2012-01-11 17:04:44', '2012-01-11 17:04:44', 42, 'Debug setting does not allow access to this url.', 'Debug setting does not allow access to this url.', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_type_id` int(5) unsigned NOT NULL,
  `attachment_id` bigint(20) NOT NULL default '1',
  `username` varchar(255) collate utf8_unicode_ci default NULL,
  `email` varchar(255) collate utf8_unicode_ci default NULL,
  `password` varchar(100) collate utf8_unicode_ci default NULL,
  `available_wallet_amount` double(10,2) NOT NULL,
  `blocked_amount` double(10,2) NOT NULL,
  `cleared_amount` double(10,2) NOT NULL,
  `fb_user_id` bigint(20) default NULL,
  `fb_access_token` varchar(255) collate utf8_unicode_ci default NULL,
  `total_amount_withdrawn` double(10,2) NOT NULL,
  `total_withdraw_request_count` bigint(20) NOT NULL,
  `total_amount_deposited` double(10,2) NOT NULL,
  `property_feedback_count` bigint(20) NOT NULL,
  `host_expired_count` bigint(20) NOT NULL,
  `host_canceled_count` bigint(20) NOT NULL,
  `host_rejected_count` bigint(20) NOT NULL,
  `host_completed_count` bigint(20) NOT NULL,
  `host_review_count` bigint(20) NOT NULL,
  `host_arrived_count` bigint(20) NOT NULL,
  `host_confirmed_count` bigint(20) NOT NULL,
  `host_waiting_for_acceptance_count` bigint(20) NOT NULL,
  `host_negotiation_count` bigint(20) NOT NULL default '0',
  `host_payment_cleared_count` bigint(20) NOT NULL,
  `host_total_booked_count` bigint(20) NOT NULL,
  `host_total_lost_booked_count` bigint(20) NOT NULL,
  `host_total_earned_amount` double(10,2) NOT NULL,
  `host_total_lost_amount` double(10,2) NOT NULL,
  `host_total_pipeline_amount` double(10,2) NOT NULL,
  `host_total_site_revenue` double(10,2) NOT NULL,
  `travel_expired_count` bigint(20) NOT NULL,
  `travel_rejected_count` bigint(20) NOT NULL,
  `travel_canceled_count` bigint(20) NOT NULL,
  `travel_review_count` bigint(20) NOT NULL,
  `travel_completed_count` bigint(20) NOT NULL,
  `travel_arrived_count` bigint(20) NOT NULL,
  `travel_confirmed_count` bigint(20) NOT NULL,
  `travel_payment_pending_count` bigint(20) NOT NULL default '0',
  `travel_waiting_for_acceptance_count` bigint(20) NOT NULL,
  `travel_negotiation_count` bigint(20) NOT NULL default '0',
  `travel_payment_cleared_count` bigint(20) NOT NULL,
  `traveler_positive_feedback_count` bigint(20) NOT NULL default '0',
  `traveler_property_user_count` bigint(20) NOT NULL default '0',
  `travel_total_booked_count` bigint(20) NOT NULL,
  `travel_total_booked_amount` double(10,2) NOT NULL,
  `travel_total_lost_booked_count` bigint(20) NOT NULL,
  `travel_total_site_revenue` double(10,2) NOT NULL,
  `positive_feedback_count` bigint(20) NOT NULL,
  `property_favorite_count` bigint(20) NOT NULL,
  `property_user_count` bigint(20) NOT NULL,
  `request_count` bigint(20) NOT NULL,
  `property_count` bigint(20) NOT NULL,
  `property_pending_approval_count` bigint(20) NOT NULL,
  `property_inactive_count` bigint(20) NOT NULL,
  `referred_by_user_id` bigint(20) default NULL,
  `referred_by_user_count` bigint(20) NOT NULL default '0',
  `referred_booking_count` bigint(20) NOT NULL default '0',
  `affiliate_refer_booking_count` bigint(20) NOT NULL default '0',
  `user_referred_count` bigint(20) NOT NULL default '0',
  `total_commission_pending_amount` double(10,2) NOT NULL default '0.00',
  `total_commission_canceled_amount` double(10,2) NOT NULL default '0.00',
  `total_commission_completed_amount` double(10,2) NOT NULL default '0.00',
  `commission_line_amount` double(10,2) default '0.00',
  `commission_withdraw_request_amount` double(10,2) default '0.00',
  `commission_paid_amount` double(10,2) default '0.00',
  `is_yahoo_register` bigint(20) NOT NULL,
  `is_facebook_register` tinyint(1) NOT NULL,
  `is_twitter_register` tinyint(1) NOT NULL,
  `twitter_user_id` bigint(20) NOT NULL,
  `cim_profile_id` bigint(20) default NULL,
  `is_gmail_register` bigint(20) NOT NULL,
  `user_openid_count` bigint(20) unsigned NOT NULL,
  `user_login_count` bigint(20) unsigned NOT NULL,
  `user_view_count` bigint(20) unsigned NOT NULL,
  `user_friend_count` bigint(20) NOT NULL,
  `user_comment_count` bigint(20) NOT NULL,
  `cookie_hash` varchar(50) collate utf8_unicode_ci default NULL,
  `cookie_time_modified` datetime NOT NULL,
  `is_openid_register` tinyint(1) NOT NULL default '0',
  `is_agree_terms_conditions` tinyint(1) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `is_email_confirmed` tinyint(1) NOT NULL,
  `is_affiliate_user` tinyint(1) NOT NULL default '0',
  `signup_ip` varchar(15) collate utf8_unicode_ci default NULL,
  `last_login_ip` varchar(15) collate utf8_unicode_ci default NULL,
  `last_logged_in_time` datetime NOT NULL,
  `user_facebook_friend_count` bigint(20) NOT NULL default '0',
  `is_show_facebook_friends` tinyint(1) NOT NULL default '1',
  `is_facebook_friends_fetched` tinyint(1) NOT NULL default '0',
  `network_fb_user_id` bigint(20) NOT NULL default '0',
  `last_facebook_friend_fetched_date` date default NULL,
  `is_paid` tinyint(1) NOT NULL default '0',
  `pay_key` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`),
  KEY `user_type_id` (`user_type_id`),
  KEY `username` (`username`),
  KEY `email` (`email`),
  KEY `fb_user_id` (`fb_user_id`),
  KEY `referred_by_user_id` (`referred_by_user_id`),
  KEY `twitter_user_id` (`twitter_user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='User Details';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `created`, `modified`, `user_type_id`, `attachment_id`, `username`, `email`, `password`, `available_wallet_amount`, `blocked_amount`, `cleared_amount`, `fb_user_id`, `fb_access_token`, `total_amount_withdrawn`, `total_withdraw_request_count`, `total_amount_deposited`, `property_feedback_count`, `host_expired_count`, `host_canceled_count`, `host_rejected_count`, `host_completed_count`, `host_review_count`, `host_arrived_count`, `host_confirmed_count`, `host_waiting_for_acceptance_count`, `host_negotiation_count`, `host_payment_cleared_count`, `host_total_booked_count`, `host_total_lost_booked_count`, `host_total_earned_amount`, `host_total_lost_amount`, `host_total_pipeline_amount`, `host_total_site_revenue`, `travel_expired_count`, `travel_rejected_count`, `travel_canceled_count`, `travel_review_count`, `travel_completed_count`, `travel_arrived_count`, `travel_confirmed_count`, `travel_payment_pending_count`, `travel_waiting_for_acceptance_count`, `travel_negotiation_count`, `travel_payment_cleared_count`, `traveler_positive_feedback_count`, `traveler_property_user_count`, `travel_total_booked_count`, `travel_total_booked_amount`, `travel_total_lost_booked_count`, `travel_total_site_revenue`, `positive_feedback_count`, `property_favorite_count`, `property_user_count`, `request_count`, `property_count`, `property_pending_approval_count`, `property_inactive_count`, `referred_by_user_id`, `referred_by_user_count`, `referred_booking_count`, `affiliate_refer_booking_count`, `user_referred_count`, `total_commission_pending_amount`, `total_commission_canceled_amount`, `total_commission_completed_amount`, `commission_line_amount`, `commission_withdraw_request_amount`, `commission_paid_amount`, `is_yahoo_register`, `is_facebook_register`, `is_twitter_register`, `twitter_user_id`, `cim_profile_id`, `is_gmail_register`, `user_openid_count`, `user_login_count`, `user_view_count`, `user_friend_count`, `user_comment_count`, `cookie_hash`, `cookie_time_modified`, `is_openid_register`, `is_agree_terms_conditions`, `is_active`, `is_email_confirmed`, `is_affiliate_user`, `signup_ip`, `last_login_ip`, `last_logged_in_time`, `user_facebook_friend_count`, `is_show_facebook_friends`, `is_facebook_friends_fetched`, `network_fb_user_id`, `last_facebook_friend_fetched_date`, `is_paid`, `pay_key`) VALUES
(1, '2009-04-28 10:09:35', '2011-06-06 15:10:51', 1, 0, 'admin', 'productdemo.admin@gmail.com', 'df250333cfb72ae1fc70c47880fc514af892bfea', 0.00, 0.00, 0.00, 0, '140288029383119|4a2150db764397490b578551.1-100000754103010|F9ZI_NC1U2q69BxIYMdNlwO3j1c', 0.00, 0, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0682b4ee5683deadfc5c3d56d73e947f', '2011-06-30 11:58:30', 0, 1, 1, 1, 0, '', '127.0.0.1', '2011-07-26 05:49:26', 0, 1, 0, 0, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_add_wallet_amounts`
--

DROP TABLE IF EXISTS `user_add_wallet_amounts`;
CREATE TABLE IF NOT EXISTS `user_add_wallet_amounts` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `amount` double(10,2) NOT NULL,
  `pay_key` varchar(100) collate utf8_unicode_ci default NULL,
  `payment_gateway_id` bigint(20) NOT NULL,
  `is_success` tinyint(1) NOT NULL default '0',
  `user_paypal_connection_id` bigint(20) default NULL,
  `description` text collate utf8_unicode_ci,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `payment_gateway_id` (`payment_gateway_id`),
  KEY `user_paypal_connection_id` (`user_paypal_connection_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_add_wallet_amounts`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_cash_withdrawals`
--

DROP TABLE IF EXISTS `user_cash_withdrawals`;
CREATE TABLE IF NOT EXISTS `user_cash_withdrawals` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `withdrawal_status_id` bigint(20) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `remark` text collate utf8_unicode_ci,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `withdrawal_status_id` (`withdrawal_status_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=FIXED;

--
-- Dumping data for table `user_cash_withdrawals`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_comments`
--

DROP TABLE IF EXISTS `user_comments`;
CREATE TABLE IF NOT EXISTS `user_comments` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `posted_user_id` bigint(20) NOT NULL,
  `comment` text collate utf8_unicode_ci,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `to_user_id` (`posted_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_comments`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_educations`
--

DROP TABLE IF EXISTS `user_educations`;
CREATE TABLE IF NOT EXISTS `user_educations` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `education` varchar(255) collate utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_educations`
--

INSERT INTO `user_educations` (`id`, `created`, `modified`, `education`, `is_active`) VALUES
(1, '2010-11-23 19:46:37', '2010-11-23 19:46:39', 'Some high school', 1),
(2, '2010-11-23 19:46:57', '2010-11-23 19:47:00', 'High school graduate or equivalent', 1),
(3, '2010-11-23 19:47:27', '2010-11-23 19:47:30', 'Trade or vocational degree', 1),
(4, '2010-11-23 19:47:44', '2010-11-23 19:47:47', 'Some college', 1),
(5, '2010-11-23 19:47:59', '2010-11-23 19:48:01', 'Associate degree', 1),
(6, '2010-11-23 19:48:03', '2010-11-23 19:48:06', 'Bachelor''s degree', 1),
(7, '2010-11-23 19:48:34', '2010-11-23 19:48:36', 'Graduate or professional degree', 1),
(8, '2010-11-23 19:49:02', '2010-11-23 19:49:05', 'Prefer not to share', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_employments`
--

DROP TABLE IF EXISTS `user_employments`;
CREATE TABLE IF NOT EXISTS `user_employments` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `employment` varchar(255) collate utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_employments`
--

INSERT INTO `user_employments` (`id`, `created`, `modified`, `employment`, `is_active`) VALUES
(1, '2010-11-23 19:50:45', '2010-11-23 19:50:48', 'Employed full time', 1),
(2, '2010-11-23 19:51:03', '2010-11-23 19:51:05', 'Not employed but looking for work', 1),
(3, '2010-11-23 19:51:23', '2010-11-23 19:51:25', 'Not employed and not looking for work', 1),
(4, '2010-11-23 19:51:29', '2010-11-23 19:51:31', 'Retired', 1),
(5, '2010-11-23 19:51:57', '2010-11-23 19:51:59', 'Student', 1),
(6, '2010-11-23 19:52:06', '2010-11-23 19:52:08', 'Homemaker', 1),
(7, '2010-11-23 19:52:21', '2010-11-23 19:52:24', 'Prefer not to share', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_facebook_friends`
--

DROP TABLE IF EXISTS `user_facebook_friends`;
CREATE TABLE IF NOT EXISTS `user_facebook_friends` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `facebook_friend_id` bigint(20) unsigned NOT NULL,
  `facebook_friend_name` varchar(100) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`),
  KEY `facebook_friend_id` (`facebook_friend_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Facebook Friend Details';

--
-- Dumping data for table `user_facebook_friends`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_friends`
--

DROP TABLE IF EXISTS `user_friends`;
CREATE TABLE IF NOT EXISTS `user_friends` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `friend_user_id` bigint(20) NOT NULL,
  `friend_status_id` bigint(20) NOT NULL,
  `is_requested` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `friend_user_id` (`friend_user_id`),
  KEY `friend_status_id` (`friend_status_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='User Friend Details';

--
-- Dumping data for table `user_friends`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_income_ranges`
--

DROP TABLE IF EXISTS `user_income_ranges`;
CREATE TABLE IF NOT EXISTS `user_income_ranges` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `income` varchar(255) collate utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_income_ranges`
--

INSERT INTO `user_income_ranges` (`id`, `created`, `modified`, `income`, `is_active`) VALUES
(1, '2010-11-23 19:54:35', '2010-11-23 19:54:37', 'Under 20,000', 1),
(2, '2010-11-23 19:54:55', '2010-11-23 19:54:58', '20,000 - 29,000', 1),
(3, '2010-11-23 19:55:18', '2010-11-23 19:55:24', '30,000 - 39,999', 1),
(4, '2010-11-23 19:55:38', '2010-11-23 19:55:40', '40,000 - 49,999', 1),
(5, '2010-11-23 19:55:57', '2010-11-23 19:56:00', '50,000 - 69,999', 1),
(6, '2010-11-23 19:56:11', '2010-11-23 19:56:14', '70,000 - 99,999', 1),
(7, '2010-11-23 19:56:28', '2010-11-23 19:56:30', '100,000 - 149,000', 1),
(8, '2010-11-23 19:56:45', '2010-11-23 19:56:47', '150,000 or more', 1),
(9, '2010-11-23 19:57:03', '2010-11-23 19:57:05', 'Prefer not to share', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_logins`
--

DROP TABLE IF EXISTS `user_logins`;
CREATE TABLE IF NOT EXISTS `user_logins` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `user_login_ip` varchar(20) collate utf8_unicode_ci default NULL,
  `user_agent` varchar(500) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='User Login Details';

--
-- Dumping data for table `user_logins`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_notifications`
--

DROP TABLE IF EXISTS `user_notifications`;
CREATE TABLE IF NOT EXISTS `user_notifications` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `user_id` bigint(20) default NULL,
  `is_new_property_order_host_notification` tinyint(1) default '1',
  `is_new_property_order_traveler_notification` tinyint(1) default '1',
  `is_accept_property_order_traveler_notification` tinyint(1) default '1',
  `is_accept_property_order_host_notification` tinyint(1) default '1',
  `is_reject_property_order_traveler_notification` tinyint(1) default '1',
  `is_reject_property_order_host_notification` tinyint(1) default '1',
  `is_cancel_property_order_host_notification` tinyint(1) default '1',
  `is_cancel_property_order_traveler_notification` tinyint(1) default '1',
  `is_arrival_host_notification` tinyint(1) default '1',
  `is_arrival_traveler_notification` tinyint(1) default '1',
  `is_review_property_order_traveler_notification` tinyint(1) default '1',
  `is_review_property_order_host_notification` tinyint(1) default '1',
  `is_cleared_notification` tinyint(1) default '1',
  `is_complete_property_order_host_notification` tinyint(1) default '1',
  `is_complete_property_order_traveler_notification` tinyint(1) default '1',
  `is_expire_property_order_host_notification` tinyint(1) default '1',
  `is_expire_property_order_traveler_notification` tinyint(1) default '1',
  `is_admin_cancel_property_order_host_notification` tinyint(1) default '1',
  `is_admin_cancel_traveler_notification` tinyint(1) default '1',
  `is_complete_later_property_order_host_notification` tinyint(1) default '1',
  `is_complete_later_property_order_traveler_notification` tinyint(1) default '1',
  `is_recieve_dispute_notification` tinyint(1) default '1',
  `is_contact_notification` tinyint(1) default '1',
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_notifications`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_openids`
--

DROP TABLE IF EXISTS `user_openids`;
CREATE TABLE IF NOT EXISTS `user_openids` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `openid` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='User OpenID Details';

--
-- Dumping data for table `user_openids`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_payment_profiles`
--

DROP TABLE IF EXISTS `user_payment_profiles`;
CREATE TABLE IF NOT EXISTS `user_payment_profiles` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `cim_payment_profile_id` varchar(255) collate utf8_unicode_ci NOT NULL,
  `masked_cc` varchar(255) collate utf8_unicode_ci NOT NULL,
  `is_default` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `cim_payment_profile_id` (`cim_payment_profile_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_payment_profiles`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_paypal_connections`
--

DROP TABLE IF EXISTS `user_paypal_connections`;
CREATE TABLE IF NOT EXISTS `user_paypal_connections` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `valid_from` date NOT NULL,
  `valid_to` date NOT NULL,
  `sender_email` varchar(100) collate utf8_unicode_ci default NULL,
  `pre_approval_key` blob,
  `amount` double NOT NULL,
  `charged_amount` double(10,2) default NULL,
  `charged_count` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL default '0',
  `is_default` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `valid_from` (`valid_from`),
  KEY `valid_to` (`valid_to`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_paypal_connections`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

DROP TABLE IF EXISTS `user_profiles`;
CREATE TABLE IF NOT EXISTS `user_profiles` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `language_id` bigint(20) default NULL,
  `first_name` varchar(100) collate utf8_unicode_ci default NULL,
  `last_name` varchar(100) collate utf8_unicode_ci default NULL,
  `middle_name` varchar(100) collate utf8_unicode_ci default NULL,
  `gender_id` int(2) NOT NULL,
  `dob` date NOT NULL,
  `about_me` text collate utf8_unicode_ci,
  `school` text collate utf8_unicode_ci,
  `work` text collate utf8_unicode_ci,
  `paypal_account` varchar(250) collate utf8_unicode_ci default NULL,
  `paypal_first_name` varchar(250) collate utf8_unicode_ci default NULL,
  `paypal_last_name` varchar(250) collate utf8_unicode_ci default NULL,
  `own_home` tinyint(1) NOT NULL default '0',
  `have_children` tinyint(1) NOT NULL default '0',
  `user_education_id` bigint(20) default NULL,
  `user_employment_id` bigint(20) default NULL,
  `user_incomerange_id` bigint(20) default NULL,
  `user_relationship_id` bigint(20) default NULL,
  `address` varchar(500) collate utf8_unicode_ci default NULL,
  `city_id` bigint(20) NOT NULL,
  `state_id` bigint(20) NOT NULL,
  `country_id` bigint(20) NOT NULL,
  `zip_code` int(10) default NULL,
  `phone` varchar(250) collate utf8_unicode_ci default NULL,
  `backup_phone` varchar(250) collate utf8_unicode_ci default NULL,
  `message_page_size` int(3) unsigned NOT NULL default '0',
  `message_signature` text collate utf8_unicode_ci,
  PRIMARY KEY  (`id`),
  KEY `city_id` (`city_id`),
  KEY `state_id` (`state_id`),
  KEY `country_id` (`country_id`),
  KEY `gender_id` (`gender_id`),
  KEY `user_id` (`user_id`),
  KEY `language_id` (`language_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='User Profile Details';

--
-- Dumping data for table `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `created`, `modified`, `user_id`, `language_id`, `first_name`, `last_name`, `middle_name`, `gender_id`, `dob`, `about_me`, `school`, `work`, `paypal_account`, `paypal_first_name`, `paypal_last_name`, `own_home`, `have_children`, `user_education_id`, `user_employment_id`, `user_incomerange_id`, `user_relationship_id`, `address`, `city_id`, `state_id`, `country_id`, `zip_code`, `phone`, `backup_phone`, `message_page_size`, `message_signature`) VALUES
(2, '2009-05-04 07:59:48', '2011-04-26 09:44:01', 1, 42, '', '', '', 1, '2001-03-04', '', '', '', '', '', '', 0, 0, NULL, NULL, NULL, NULL, '', 13147, 5400, 2, NULL, '', '', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `user_relationships`
--

DROP TABLE IF EXISTS `user_relationships`;
CREATE TABLE IF NOT EXISTS `user_relationships` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `relationship` varchar(255) collate utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_relationships`
--

INSERT INTO `user_relationships` (`id`, `created`, `modified`, `relationship`, `is_active`) VALUES
(1, '2010-11-23 20:01:39', '2010-11-23 20:01:41', 'Single, not married', 1),
(2, '2010-11-23 20:01:54', '2010-11-23 20:01:57', 'Married', 1),
(3, '2010-11-23 20:02:07', '2010-11-23 20:02:09', 'Living with partner', 1),
(4, '2010-11-23 20:02:21', '2010-11-23 20:02:23', 'Separated', 1),
(5, '2010-11-23 20:02:41', '2010-11-23 20:02:44', 'Divorced', 1),
(6, '2010-11-23 20:02:53', '2010-11-23 20:02:55', 'Widowed', 1),
(7, '2010-11-23 20:03:10', '2010-11-23 20:03:12', 'Prefer not to share', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_types`
--

DROP TABLE IF EXISTS `user_types`;
CREATE TABLE IF NOT EXISTS `user_types` (
  `id` int(5) unsigned NOT NULL auto_increment,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `name` varchar(250) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='User Type Details';

--
-- Dumping data for table `user_types`
--

INSERT INTO `user_types` (`id`, `created`, `modified`, `name`) VALUES
(1, NULL, NULL, 'admin'),
(2, NULL, NULL, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `user_views`
--

DROP TABLE IF EXISTS `user_views`;
CREATE TABLE IF NOT EXISTS `user_views` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `viewing_user_id` bigint(20) default NULL,
  `ip_id` bigint(20) default NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `viewing_user_id` (`viewing_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='User View Details';

--
-- Dumping data for table `user_views`
--


-- --------------------------------------------------------

--
-- Table structure for table `withdrawal_statuses`
--

DROP TABLE IF EXISTS `withdrawal_statuses`;
CREATE TABLE IF NOT EXISTS `withdrawal_statuses` (
  `id` bigint(20) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `user_cash_withdrawal_count` bigint(20) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `withdrawal_statuses`
--

INSERT INTO `withdrawal_statuses` (`id`, `created`, `modified`, `name`, `user_cash_withdrawal_count`) VALUES
(1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Pending', 1),
(2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Under Process', 0),
(3, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Rejected', 0),
(4, '2010-04-15 14:20:17', '2010-04-15 14:20:17', 'Failed', 0),
(5, '2010-04-15 14:20:17', '2010-04-15 14:20:17', 'Success', 0);
