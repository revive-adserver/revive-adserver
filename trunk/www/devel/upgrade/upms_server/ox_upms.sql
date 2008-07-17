-- phpMyAdmin SQL Dump
-- version 2.11.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 25, 2008 at 04:48 PM
-- Server version: 5.0.48
-- PHP Version: 5.1.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `ox_upms`
--

-- --------------------------------------------------------

--
-- Table structure for table `changesets`
--

CREATE TABLE `changesets` (
  `schema` varchar(32) NOT NULL default 'tables_core',
  `id` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `comments` text,
  `registered` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`schema`,`id`),
  FULLTEXT KEY `user` (`user`,`comments`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `changesets`
--

INSERT INTO `changesets` (`schema`, `id`, `user`, `comments`, `registered`) VALUES
('tables_core', 100, 'Unknown User', '-', '2008-03-25 13:02:38'),
('tables_core', 108, 'Unknown User', 'Added all missing tables to 2.0 schema. Effectively this changeset can be used in place of changesets 109-120!', '2008-03-25 13:02:38'),
('tables_core', 121, 'Unknown User', 'Changed the length of the column to 32.', '2008-03-25 13:02:38'),
('tables_core', 122, 'Unknown User', 'The table changed so it now contains all the required columns and unnecessary columns were removed.', '2008-03-25 13:02:38'),
('tables_core', 123, 'Unknown User', 'Added fields missing from table affiliates to the schema.', '2008-03-25 13:02:38'),
('tables_core', 124, 'Unknown User', 'Added changes required for upgrade from 2.0 schema to 2.3 schema.', '2008-03-25 13:02:38'),
('tables_core', 125, 'Unknown User', 'Added the maintenance_cron_timestamp column to bring schema up to version 2.3.', '2008-03-25 13:02:38'),
('tables_core', 126, 'Unknown User', 'Renamed and changed type of the field clientid, now campaignid.', '2008-03-25 13:02:38'),
('tables_core', 127, 'Unknown User', 'Added missing columns to upgrade from 2.0 to 2.3.', '2008-03-25 13:02:38'),
('tables_core', 128, 'Unknown User', 'Changed the type of the transparent field, added parameters and acls_updated columns.', '2008-03-25 13:02:38'),
('tables_core', 129, 'Unknown User', 'Migration of warn_limit_days (preference) and new ad selection fields', '2008-03-25 13:02:38'),
('tables_core', 130, 'Unknown User', 'Changed acls.logical to varchar', '2008-03-25 13:02:38'),
('tables_core', 131, 'Unknown User', 'Added the missing indices: affiliates.agencyid, banners.campaignid, clients.agencyid, zones.affiliateid.', '2008-03-25 13:02:38'),
('tables_core', 199, 'Unknown User', 'Removed tables no longer used in 2.3: adclicks, adstats, adviews, cache, config.', '2008-03-25 13:02:38'),
('tables_core', 308, 'Unknown User', 'Added all missing tables to 2.1 schema', '2008-03-25 13:02:38'),
('tables_core', 321, 'Unknown User', 'Changes acls table', '2008-03-25 13:02:38'),
('tables_core', 322, 'Unknown User', 'Add columns required by clients table', '2008-03-25 13:02:38'),
('tables_core', 323, 'Unknown User', 'Add fields requried by table affiliates', '2008-03-25 13:02:38'),
('tables_core', 324, 'Unknown User', 'Add fields required by banners table', '2008-03-25 13:02:38'),
('tables_core', 325, 'Unknown User', 'Add fields required by agency table', '2008-03-25 13:02:38'),
('tables_core', 326, 'Unknown User', 'Add fields required by campaigns table', '2008-03-25 13:02:38'),
('tables_core', 327, 'Unknown User', 'Add columns required by zones table', '2008-03-25 13:02:38'),
('tables_core', 328, 'Unknown User', 'Add fields required by trackers table', '2008-03-25 13:02:38'),
('tables_core', 329, 'Unknown User', 'Add fields required by campaigns_trackers table', '2008-03-25 13:02:38'),
('tables_core', 330, 'Unknown User', 'Add fields required by variables table', '2008-03-25 13:02:38'),
('tables_core', 331, 'Unknown User', 'Added the missing indexes', '2008-03-25 13:02:38'),
('tables_core', 332, 'Unknown User', 'Added tables/fields required by 2.0 functional enhancements', '2008-03-25 13:02:38'),
('tables_core', 334, 'Unknown User', 'Remove tables no longer used in 2.3', '2008-03-25 13:02:38'),
('tables_core', 336, 'Unknown User', 'Changed blob types to text', '2008-03-25 13:02:38'),
('tables_core', 399, 'Unknown User', 'Remove tables no longer used in 2.3', '2008-03-25 13:02:38'),
('tables_core', 505, 'Unknown User', '-', '2008-03-25 13:02:38'),
('tables_core', 506, 'Unknown User', '-', '2008-03-25 13:02:38'),
('tables_core', 507, 'Unknown User', '-', '2008-03-25 13:02:38'),
('tables_core', 510, 'Unknown User', 'Added tables/fields required by 2.0 functional enhancements', '2008-03-25 13:02:38'),
('tables_core', 511, 'Unknown User', 'new fields ad_zone_assoc.priority_factor,  ad_zone_assoc.to_be_delivered, data_summary_ad_zone_assoc.to_be_delivered', '2008-03-25 13:02:38'),
('tables_core', 512, 'Unknown User', ' field to the banners for SWF feature porting from 2.0.', '2008-03-25 13:02:38'),
('tables_core', 513, 'Unknown User', 'Added warn_day_limit column to preference table, needed for date-based expiring campaign alert', '2008-03-25 13:02:38'),
('tables_core', 515, 'Unknown User', 'altered type preference.gui_invocation_3rdparty_default', '2008-03-25 13:02:38'),
('tables_core', 516, 'Unknown User', 'Removed tables that were used for custom data summarisation.', '2008-03-25 13:02:38'),
('tables_core', 530, 'Unknown User', 'Added primary key to application_variable', '2008-03-25 13:02:38'),
('tables_core', 531, 'Unknown User', 'Added OAC fields, removed instance_id from preference', '2008-03-25 13:02:38'),
('tables_core', 532, 'Unknown User', 'Added oac_adnetwork_id to clients table', '2008-03-25 13:02:38'),
('tables_core', 533, 'Unknown User', 'Added OAC fields to the affiliate table', '2008-03-25 13:02:38'),
('tables_core', 534, 'Unknown User', 'Added field to note if a ZIF value is based on the default value or not.', '2008-03-25 13:02:38'),
('tables_core', 535, 'Unknown User', 'Remove data_raw_tracker_click', '2008-03-25 13:02:38'),
('tables_core', 536, 'Unknown User', 'Removed redundant geotargeting columns from data_raw_ad_request', '2008-03-25 13:02:38'),
('tables_core', 537, 'Unknown User', 'new audit table', '2008-03-25 13:02:38'),
('tables_core', 538, 'Unknown User', 'Timezone support', '2008-03-25 13:02:38'),
('tables_core', 539, 'Unknown User', 'Status to statustext', '2008-03-25 13:02:38'),
('tables_core', 540, 'Unknown User', 'Active to status and other', '2008-03-25 13:02:38'),
('tables_core', 541, 'Unknown User', 'Affiliates', '2008-03-25 13:02:38'),
('tables_core', 542, 'Unknown User', 'Added as_reject_reason', '2008-03-25 13:02:38'),
('tables_core', 543, 'Unknown User', 'UAPP Step 1', '2008-03-25 13:02:38'),
('tables_core', 544, 'Unknown User', 'UAPP Step 2', '2008-03-25 13:02:38'),
('tables_core', 546, 'Unknown User', 'Removal of the old preference table', '2008-03-25 13:02:38'),
('tables_core', 547, 'Unknown User', 'M2M Implementation', '2008-03-25 13:02:38'),
('tables_core', 548, 'Unknown User', 'Added account_id foreign key to audit table', '2008-03-25 13:02:38'),
('tables_core', 580, 'Unknown User', 'Added sso_user_id', '2008-03-25 13:02:38'),
('tables_core', 581, 'Unknown User', 'Ad Direct changes', '2008-03-25 13:02:38');
