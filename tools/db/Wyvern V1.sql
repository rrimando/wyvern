-- phpMyAdmin SQL Dump
-- version 4.3.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 04, 2015 at 02:55 AM
-- Server version: 5.5.42-37.1
-- PHP Version: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pxljmp_lenovoph`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fuel_archives`
--

CREATE TABLE IF NOT EXISTS `fuel_archives` (
  `id` int(10) unsigned NOT NULL,
  `ref_id` int(10) unsigned NOT NULL,
  `table_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci NOT NULL,
  `version` smallint(5) unsigned NOT NULL,
  `version_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `archived_user_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fuel_blocks`
--

CREATE TABLE IF NOT EXISTS `fuel_blocks` (
  `id` smallint(5) unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `view` text COLLATE utf8_unicode_ci NOT NULL,
  `language` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'english',
  `published` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `date_added` datetime DEFAULT NULL,
  `last_modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fuel_categories`
--

CREATE TABLE IF NOT EXISTS `fuel_categories` (
  `id` int(11) unsigned NOT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  `slug` varchar(100) NOT NULL DEFAULT '',
  `context` varchar(100) NOT NULL DEFAULT '',
  `precedence` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `published` enum('yes','no') NOT NULL DEFAULT 'yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fuel_logs`
--

CREATE TABLE IF NOT EXISTS `fuel_logs` (
  `id` int(10) unsigned NOT NULL,
  `entry_date` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fuel_navigation`
--

CREATE TABLE IF NOT EXISTS `fuel_navigation` (
  `id` int(10) unsigned NOT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'The part of the path after the domain name that you want the link to go to (e.g. comany/about_us)',
  `group_id` int(5) unsigned NOT NULL DEFAULT '1',
  `nav_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'The nav key is a friendly ID that you can use for setting the selected state. If left blank, a default value will be set for you.',
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'The name you want to appear in the menu',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Used for creating menu hierarchies. No value means it is a root level menu item',
  `precedence` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'The higher the number, the greater the precedence and farther up the list the navigational element will appear',
  `attributes` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Extra attributes that can be used for navigation implementation',
  `selected` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'The pattern to match for the active state. Most likely you leave this field blank',
  `hidden` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no' COMMENT 'A hidden value can be used in rendering the menu. In some areas, the menu item may not want to be displayed',
  `language` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'english',
  `published` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes' COMMENT 'Determines whether the item is displayed or not'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fuel_navigation_groups`
--

CREATE TABLE IF NOT EXISTS `fuel_navigation_groups` (
  `id` int(3) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `published` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fuel_navigation_groups`
--

INSERT INTO `fuel_navigation_groups` (`id`, `name`, `published`) VALUES
(1, 'main', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `fuel_pages`
--

CREATE TABLE IF NOT EXISTS `fuel_pages` (
  `id` int(10) unsigned NOT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Add the part of the url after the root of your site (usually after the domain name). For the homepage, just put the word ''home''',
  `layout` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'The name of the template to associate with this page',
  `published` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes' COMMENT 'A ''yes'' value will display the page and an ''no'' value will give a 404 error message',
  `cache` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes' COMMENT 'Cache controls whether the page will pull from the database or from a saved file which is more effeicent. If a page has content that is dynamic, it''s best to set cache to ''no''',
  `date_added` datetime DEFAULT NULL,
  `last_modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_modified_by` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fuel_page_variables`
--

CREATE TABLE IF NOT EXISTS `fuel_page_variables` (
  `id` int(10) unsigned NOT NULL,
  `page_id` int(10) unsigned NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `scope` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('string','int','boolean','array') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'string',
  `language` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'english',
  `active` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fuel_permissions`
--

CREATE TABLE IF NOT EXISTS `fuel_permissions` (
  `id` int(10) unsigned NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'In most cases, this should be the name of the module (e.g. news)',
  `active` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes'
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fuel_permissions`
--

INSERT INTO `fuel_permissions` (`id`, `description`, `name`, `active`) VALUES
(1, 'Pages', 'pages', 'yes'),
(2, 'Pages: Create', 'pages/create', 'yes'),
(3, 'Pages: Edit', 'pages/edit', 'yes'),
(4, 'Pages: Publish', 'pages/publish', 'yes'),
(5, 'Pages: Delete', 'pages/delete', 'yes'),
(6, 'Blocks', 'blocks', 'yes'),
(7, 'Blocks: Create', 'blocks/create', 'yes'),
(8, 'Blocks: Edit', 'blocks/edit', 'yes'),
(9, 'Blocks: Publish', 'blocks/publish', 'yes'),
(10, 'Blocks: Delete', 'blocks/delete', 'yes'),
(11, 'Navigation', 'navigation', 'yes'),
(12, 'Navigation: Create', 'navigation/create', 'yes'),
(13, 'Navigation: Edit', 'navigation/edit', 'yes'),
(14, 'Navigation: Publish', 'navigation/publish', 'yes'),
(15, 'Navigation: Delete', 'navigation/delete', 'yes'),
(16, 'Categories', 'categories', 'yes'),
(17, 'Categories: Create', 'categories/create', 'yes'),
(18, 'Categories: Edit', 'categories/edit', 'yes'),
(19, 'Categories: Publish', 'categories/publish', 'yes'),
(20, 'Categories: Delete', 'categories/delete', 'yes'),
(21, 'Tags', 'tags', 'yes'),
(22, 'Tags: Create', 'tags/create', 'yes'),
(23, 'Tags: Edit', 'tags/edit', 'yes'),
(24, 'Tags: Publish', 'tags/publish', 'yes'),
(25, 'Tags: Delete', 'tags/delete', 'yes'),
(26, 'Site Variables', 'sitevariables', 'yes'),
(27, 'Assets', 'assets', 'yes'),
(28, 'Site Documentation', 'site_docs', 'yes'),
(29, 'Users', 'users', 'yes'),
(30, 'Permissions', 'permissions', 'yes'),
(31, 'Manage', 'manage', 'yes'),
(32, 'Cache', 'manage/cache', 'yes'),
(33, 'Logs', 'logs', 'yes'),
(34, 'Settings', 'settings', 'yes'),
(35, 'Generate Code', 'generate', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `fuel_relationships`
--

CREATE TABLE IF NOT EXISTS `fuel_relationships` (
  `id` bigint(20) unsigned NOT NULL,
  `candidate_table` varchar(100) COLLATE utf8_unicode_ci DEFAULT '',
  `candidate_key` int(11) NOT NULL,
  `foreign_table` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `foreign_key` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fuel_settings`
--

CREATE TABLE IF NOT EXISTS `fuel_settings` (
  `id` bigint(20) unsigned NOT NULL,
  `module` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `key` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `value` longtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fuel_site_variables`
--

CREATE TABLE IF NOT EXISTS `fuel_site_variables` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `scope` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'leave blank if you want the variable to be available to all pages',
  `active` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fuel_tags`
--

CREATE TABLE IF NOT EXISTS `fuel_tags` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `precedence` int(11) NOT NULL,
  `published` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fuel_users`
--

CREATE TABLE IF NOT EXISTS `fuel_users` (
  `id` int(10) unsigned NOT NULL,
  `user_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `language` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `reset_key` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `salt` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `super_admin` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `active` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `entity` varchar(22) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n/a'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wyvern_entities`
--

CREATE TABLE IF NOT EXISTS `wyvern_entities` (
  `id` tinyint(22) NOT NULL,
  `entity_name` varchar(255) NOT NULL,
  `entity_slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `wyvern_entity_fields`
--

CREATE TABLE IF NOT EXISTS `wyvern_entity_fields` (
  `id` tinyint(22) NOT NULL,
  `parent_id` tinyint(22) NOT NULL,
  `entity_field_name` varchar(220) NOT NULL,
  `entity_field_slug` varchar(220) NOT NULL,
  `entity_field_desc` tinyblob NOT NULL,
  `entity_value_type` varchar(220) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `wyvern_entity_values`
--

CREATE TABLE IF NOT EXISTS `wyvern_entity_values` (
  `entity_field_id` tinyint(22) NOT NULL,
  `id` int(50) NOT NULL,
  `value` blob NOT NULL,
  `parent_entity_id` tinyint(22) NOT NULL,
  `unique_id` varchar(100) NOT NULL COMMENT 'This collates the Entity'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `wyvern_files`
--

CREATE TABLE IF NOT EXISTS `wyvern_files` (
  `id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `wyvern_model`
--

CREATE TABLE IF NOT EXISTS `wyvern_model` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`session_id`), ADD KEY `last_activity_idx` (`last_activity`);

--
-- Indexes for table `fuel_archives`
--
ALTER TABLE `fuel_archives`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fuel_blocks`
--
ALTER TABLE `fuel_blocks`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `name` (`name`,`language`);

--
-- Indexes for table `fuel_categories`
--
ALTER TABLE `fuel_categories`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `fuel_logs`
--
ALTER TABLE `fuel_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fuel_navigation`
--
ALTER TABLE `fuel_navigation`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `group_id_nav_key_language` (`group_id`,`nav_key`,`language`);

--
-- Indexes for table `fuel_navigation_groups`
--
ALTER TABLE `fuel_navigation_groups`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `fuel_pages`
--
ALTER TABLE `fuel_pages`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `location` (`location`), ADD KEY `layout` (`layout`);

--
-- Indexes for table `fuel_page_variables`
--
ALTER TABLE `fuel_page_variables`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `page_id` (`page_id`,`name`,`language`);

--
-- Indexes for table `fuel_permissions`
--
ALTER TABLE `fuel_permissions`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `fuel_relationships`
--
ALTER TABLE `fuel_relationships`
  ADD PRIMARY KEY (`id`), ADD KEY `candidate_table` (`candidate_table`,`candidate_key`), ADD KEY `foreign_table` (`foreign_table`,`foreign_key`);

--
-- Indexes for table `fuel_settings`
--
ALTER TABLE `fuel_settings`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `module` (`module`,`key`);

--
-- Indexes for table `fuel_site_variables`
--
ALTER TABLE `fuel_site_variables`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `fuel_tags`
--
ALTER TABLE `fuel_tags`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `fuel_users`
--
ALTER TABLE `fuel_users`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `wyvern_entities`
--
ALTER TABLE `wyvern_entities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wyvern_entity_fields`
--
ALTER TABLE `wyvern_entity_fields`
  ADD PRIMARY KEY (`id`), ADD KEY `id` (`id`);

--
-- Indexes for table `wyvern_entity_values`
--
ALTER TABLE `wyvern_entity_values`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wyvern_files`
--
ALTER TABLE `wyvern_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wyvern_model`
--
ALTER TABLE `wyvern_model`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fuel_archives`
--
ALTER TABLE `fuel_archives`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fuel_blocks`
--
ALTER TABLE `fuel_blocks`
  MODIFY `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fuel_categories`
--
ALTER TABLE `fuel_categories`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fuel_logs`
--
ALTER TABLE `fuel_logs`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fuel_navigation`
--
ALTER TABLE `fuel_navigation`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fuel_navigation_groups`
--
ALTER TABLE `fuel_navigation_groups`
  MODIFY `id` int(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `fuel_pages`
--
ALTER TABLE `fuel_pages`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fuel_page_variables`
--
ALTER TABLE `fuel_page_variables`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fuel_permissions`
--
ALTER TABLE `fuel_permissions`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `fuel_relationships`
--
ALTER TABLE `fuel_relationships`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fuel_settings`
--
ALTER TABLE `fuel_settings`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fuel_site_variables`
--
ALTER TABLE `fuel_site_variables`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fuel_tags`
--
ALTER TABLE `fuel_tags`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fuel_users`
--
ALTER TABLE `fuel_users`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wyvern_entities`
--
ALTER TABLE `wyvern_entities`
  MODIFY `id` tinyint(22) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wyvern_entity_fields`
--
ALTER TABLE `wyvern_entity_fields`
  MODIFY `id` tinyint(22) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wyvern_entity_values`
--
ALTER TABLE `wyvern_entity_values`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wyvern_files`
--
ALTER TABLE `wyvern_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wyvern_model`
--
ALTER TABLE `wyvern_model`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

ALTER TABLE  `wyvern_entity_values` CHANGE  `unique_id`  `unique_id` VARCHAR( 100 ) NOT NULL COMMENT  'This collates the Entity';
ALTER TABLE  `wyvern_entity_values` CHANGE  `id`  `id` INT( 50 ) NOT NULL AUTO_INCREMENT;
# ALTER TABLE  `wyvern_entities` CHANGE  `id`  `id` INT( 22 ) NOT NULL AUTO_INCREMENT;
# ALTER TABLE  `wyvern_entity_fields` CHANGE  `id`  `id` INT( 22 ) NOT NULL AUTO_INCREMENT;
# ALTER TABLE  `wyvern_entity_fields` CHANGE  `parent_id`  `parent_id` INT( 22 ) NOT NULL;
# ALTER TABLE  `wyvern_entity_values` CHANGE  `parent_entity_id`  `parent_entity_id` INT( 22 ) NOT NULL;
# ALTER TABLE  `wyvern_entity_values` CHANGE  `entity_field_id`  `entity_field_id` INT( 22 ) NOT NULL;
# ALTER TABLE `wyvern_entity_values` CHANGE `entity_field_id` `entity_field_id` INT(22) NOT NULL, CHANGE `parent_entity_id` `parent_entity_id` INT(22) NOT NULL;

# duplicate entry for 127 fix
ALTER TABLE `wyvern_entity_fields` CHANGE `id` `id` INT(22) NOT NULL AUTO_INCREMENT; 

