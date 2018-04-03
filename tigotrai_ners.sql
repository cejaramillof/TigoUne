/*
 Navicat Premium Data Transfer

 Source Server         : TigoUne
 Source Server Type    : MySQL
 Source Server Version : 50505
 Source Host           : entrenadorcomercial.com
 Source Database       : tigotrai_ners

 Target Server Type    : MySQL
 Target Server Version : 50505
 File Encoding         : utf-8

 Date: 02/26/2018 08:06:15 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `Matriz Home`
-- ----------------------------
DROP TABLE IF EXISTS `Matriz Home`;
CREATE TABLE `Matriz Home` (
  `title` varchar(255) DEFAULT NULL,
  `business_unit` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- ----------------------------
--  Table structure for `forvas_07_data`
-- ----------------------------
DROP TABLE IF EXISTS `forvas_07_data`;
CREATE TABLE `forvas_07_data` (
  `form_id` int(11) NOT NULL,
  `latitud` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `longitud` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `fecha_actividad` date DEFAULT NULL,
  `canal` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tipo_asesor` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `poscode` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `asesor_cc` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `asesor_name` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `asesor_msisdn` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `asesor_boss_name` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `asesor_position_dealer` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `asesor_antiquity` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `client_present` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `mac_1` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `mac_2` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `mac_3` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `mac_4` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `mac_5` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `mac_6` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `mac_7` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `mac_8` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `mac_9` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `mac_10` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `mac_11` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `mac_12` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `training_time` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `field_notes_prepara_items` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `field_notes_prepara_herramientas` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `field_notes_concluye_items` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `field_notes_exceeded_time` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `field_notes_others` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `action_plan` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  KEY `form_id` (`form_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- ----------------------------
--  Table structure for `forvas_10_data`
-- ----------------------------
DROP TABLE IF EXISTS `forvas_10_data`;
CREATE TABLE `forvas_10_data` (
  `form_id` int(11) NOT NULL,
  `latitud` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `longitud` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `fecha_actividad` date DEFAULT NULL,
  `asesor_cc` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `asesor_name` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  KEY `form_id` (`form_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- ----------------------------
--  Table structure for `forvas_33_attendants`
-- ----------------------------
DROP TABLE IF EXISTS `forvas_33_attendants`;
CREATE TABLE `forvas_33_attendants` (
  `form_id` int(11) NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  KEY `form_id` (`form_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- ----------------------------
--  Table structure for `forvas_33_data`
-- ----------------------------
DROP TABLE IF EXISTS `forvas_33_data`;
CREATE TABLE `forvas_33_data` (
  `form_id` int(11) NOT NULL,
  `latitud` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `longitud` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `fecha_actividad` date DEFAULT NULL,
  `canal` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `dia_entrenamiento` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `quiz_done` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `duracion` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `observaciones` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  KEY `form_id` (`form_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- ----------------------------
--  Table structure for `forvas_33_themes`
-- ----------------------------
DROP TABLE IF EXISTS `forvas_33_themes`;
CREATE TABLE `forvas_33_themes` (
  `form_id` int(11) NOT NULL,
  `theme` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  KEY `form_id` (`form_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- ----------------------------
--  Table structure for `forvas_34_attendants`
-- ----------------------------
DROP TABLE IF EXISTS `forvas_34_attendants`;
CREATE TABLE `forvas_34_attendants` (
  `form_id` int(11) NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  KEY `form_id` (`form_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- ----------------------------
--  Table structure for `forvas_34_data`
-- ----------------------------
DROP TABLE IF EXISTS `forvas_34_data`;
CREATE TABLE `forvas_34_data` (
  `form_id` int(11) NOT NULL,
  `latitud` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `longitud` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `fecha_actividad` date DEFAULT NULL,
  `canal` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tipo_entrenamiento` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `poscode` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `id_punto` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `duracion` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `observaciones` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  KEY `form_id` (`form_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- ----------------------------
--  Table structure for `forvas_34_themes`
-- ----------------------------
DROP TABLE IF EXISTS `forvas_34_themes`;
CREATE TABLE `forvas_34_themes` (
  `form_id` int(11) NOT NULL,
  `theme` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  KEY `form_id` (`form_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- ----------------------------
--  Table structure for `ttr_ariadminer_connections`
-- ----------------------------
DROP TABLE IF EXISTS `ttr_ariadminer_connections`;
CREATE TABLE `ttr_ariadminer_connections` (
  `connection_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('server','sqlite','pgsql','oracle','mssql','firebird','simpledb','mongo','elastic') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'server',
  `host` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `db_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pass` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  `crypt` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`connection_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Table structure for `ttr_commentmeta`
-- ----------------------------
DROP TABLE IF EXISTS `ttr_commentmeta`;
CREATE TABLE `ttr_commentmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`meta_id`),
  KEY `comment_id` (`comment_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Table structure for `ttr_comments`
-- ----------------------------
DROP TABLE IF EXISTS `ttr_comments`;
CREATE TABLE `ttr_comments` (
  `comment_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_post_ID` bigint(20) unsigned NOT NULL DEFAULT '0',
  `comment_author` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_author_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_author_url` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_author_IP` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_karma` int(11) NOT NULL DEFAULT '0',
  `comment_approved` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `comment_agent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_ID`),
  KEY `comment_post_ID` (`comment_post_ID`),
  KEY `comment_approved_date_gmt` (`comment_approved`,`comment_date_gmt`),
  KEY `comment_date_gmt` (`comment_date_gmt`),
  KEY `comment_parent` (`comment_parent`),
  KEY `comment_author_email` (`comment_author_email`(10))
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Table structure for `ttr_control_forms`
-- ----------------------------
DROP TABLE IF EXISTS `ttr_control_forms`;
CREATE TABLE `ttr_control_forms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(140) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `form` varchar(140) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=423247 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Table structure for `ttr_control_forms_meta`
-- ----------------------------
DROP TABLE IF EXISTS `ttr_control_forms_meta`;
CREATE TABLE `ttr_control_forms_meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_id` int(11) NOT NULL,
  `meta` varchar(140) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6161107 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Table structure for `ttr_control_structure`
-- ----------------------------
DROP TABLE IF EXISTS `ttr_control_structure`;
CREATE TABLE `ttr_control_structure` (
  `id` bigint(20) NOT NULL,
  `user_name` varchar(140) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_role` varchar(140) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_regional` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_channel` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `business_unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `to_stats` tinyint(4) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `estado` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ACTIVO',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Table structure for `ttr_control_training_themes`
-- ----------------------------
DROP TABLE IF EXISTS `ttr_control_training_themes`;
CREATE TABLE `ttr_control_training_themes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(140) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `variations` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `channels` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_begin` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `business_unit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orden` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1322 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Table structure for `ttr_links`
-- ----------------------------
DROP TABLE IF EXISTS `ttr_links`;
CREATE TABLE `ttr_links` (
  `link_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `link_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_target` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_visible` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `link_owner` bigint(20) unsigned NOT NULL DEFAULT '1',
  `link_rating` int(11) NOT NULL DEFAULT '0',
  `link_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link_rel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_notes` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_rss` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`link_id`),
  KEY `link_visible` (`link_visible`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Table structure for `ttr_options`
-- ----------------------------
DROP TABLE IF EXISTS `ttr_options`;
CREATE TABLE `ttr_options` (
  `option_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `option_value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `autoload` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `option_name` (`option_name`)
) ENGINE=MyISAM AUTO_INCREMENT=626 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Table structure for `ttr_planner_poscodes`
-- ----------------------------
DROP TABLE IF EXISTS `ttr_planner_poscodes`;
CREATE TABLE `ttr_planner_poscodes` (
  `poscode` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `poscode_name` varchar(140) COLLATE utf8mb4_unicode_ci NOT NULL,
  `channel` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `regional` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`poscode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Table structure for `ttr_planner_registry`
-- ----------------------------
DROP TABLE IF EXISTS `ttr_planner_registry`;
CREATE TABLE `ttr_planner_registry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date` date DEFAULT NULL,
  `poscode` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `poscode_name` varchar(140) COLLATE utf8mb4_unicode_ci NOT NULL,
  `channel` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `regional` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity` varchar(140) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(140) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=78251 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Table structure for `ttr_postmeta`
-- ----------------------------
DROP TABLE IF EXISTS `ttr_postmeta`;
CREATE TABLE `ttr_postmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`meta_id`),
  KEY `post_id` (`post_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Table structure for `ttr_posts`
-- ----------------------------
DROP TABLE IF EXISTS `ttr_posts`;
CREATE TABLE `ttr_posts` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_author` bigint(20) unsigned NOT NULL DEFAULT '0',
  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_excerpt` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'publish',
  `comment_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `ping_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `post_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `post_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `to_ping` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pinged` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_modified_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content_filtered` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `guid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `menu_order` int(11) NOT NULL DEFAULT '0',
  `post_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'post',
  `post_mime_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `post_name` (`post_name`(191)),
  KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`ID`),
  KEY `post_parent` (`post_parent`),
  KEY `post_author` (`post_author`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Table structure for `ttr_term_relationships`
-- ----------------------------
DROP TABLE IF EXISTS `ttr_term_relationships`;
CREATE TABLE `ttr_term_relationships` (
  `object_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_taxonomy_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`object_id`,`term_taxonomy_id`),
  KEY `term_taxonomy_id` (`term_taxonomy_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Table structure for `ttr_term_taxonomy`
-- ----------------------------
DROP TABLE IF EXISTS `ttr_term_taxonomy`;
CREATE TABLE `ttr_term_taxonomy` (
  `term_taxonomy_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `taxonomy` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_taxonomy_id`),
  UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`),
  KEY `taxonomy` (`taxonomy`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Table structure for `ttr_termmeta`
-- ----------------------------
DROP TABLE IF EXISTS `ttr_termmeta`;
CREATE TABLE `ttr_termmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`meta_id`),
  KEY `term_id` (`term_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Table structure for `ttr_terms`
-- ----------------------------
DROP TABLE IF EXISTS `ttr_terms`;
CREATE TABLE `ttr_terms` (
  `term_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `slug` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `term_group` bigint(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_id`),
  KEY `slug` (`slug`(191)),
  KEY `name` (`name`(191))
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Table structure for `ttr_user_database`
-- ----------------------------
DROP TABLE IF EXISTS `ttr_user_database`;
CREATE TABLE `ttr_user_database` (
  `ID` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dealer_name` varchar(140) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Table structure for `ttr_usermeta`
-- ----------------------------
DROP TABLE IF EXISTS `ttr_usermeta`;
CREATE TABLE `ttr_usermeta` (
  `umeta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`umeta_id`),
  KEY `user_id` (`user_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=MyISAM AUTO_INCREMENT=26864 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Table structure for `ttr_users`
-- ----------------------------
DROP TABLE IF EXISTS `ttr_users`;
CREATE TABLE `ttr_users` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_login` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_pass` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_nicename` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_url` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_activation_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_status` int(11) NOT NULL DEFAULT '0',
  `display_name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`),
  KEY `user_login_key` (`user_login`),
  KEY `user_nicename` (`user_nicename`),
  KEY `user_email` (`user_email`)
) ENGINE=MyISAM AUTO_INCREMENT=1858 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
--  Table structure for `userstemp`
-- ----------------------------
DROP TABLE IF EXISTS `userstemp`;
CREATE TABLE `userstemp` (
  `cedula` bigint(20) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cargo` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `proveedor` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estrategia` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `regional` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ciudad` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `canal` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `punto_venta` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `fuente` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`cedula`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
--  View structure for `Planner`
-- ----------------------------
DROP VIEW IF EXISTS `Planner`;
CREATE ALGORITHM=UNDEFINED DEFINER=`entren8`@`localhost` SQL SECURITY DEFINER VIEW `Planner` AS select `ttr_planner_registry`.`id` AS `id`,`ttr_planner_registry`.`user_id` AS `user_id`,`ttr_planner_registry`.`date` AS `date`,`ttr_planner_registry`.`poscode` AS `poscode`,`ttr_planner_registry`.`poscode_name` AS `poscode_name`,`ttr_planner_registry`.`channel` AS `channel`,`ttr_planner_registry`.`department` AS `department`,`ttr_planner_registry`.`city` AS `city`,`ttr_control_structure`.`user_name` AS `user_name`,`ttr_control_structure`.`user_regional` AS `user_regional`,`ttr_control_structure`.`business_unit` AS `business_unit` from (`ttr_planner_registry` join `ttr_control_structure` on((`ttr_control_structure`.`id` = `ttr_planner_registry`.`user_id`)));

-- ----------------------------
--  View structure for `all_trained_cc`
-- ----------------------------
DROP VIEW IF EXISTS `all_trained_cc`;
CREATE ALGORITHM=UNDEFINED DEFINER=`entren8`@`localhost` SQL SECURITY DEFINER VIEW `all_trained_cc` AS select `ttr_control_forms_meta`.`form_id` AS `form_id`,(case when (`ttr_control_forms_meta`.`meta` = 'asesor_cc') then `ttr_control_forms_meta`.`value` end) AS `cedula_participante` from `ttr_control_forms_meta` where (`ttr_control_forms_meta`.`meta` = 'asesor_cc');

-- ----------------------------
--  View structure for `trained_cc_by_date`
-- ----------------------------
DROP VIEW IF EXISTS `trained_cc_by_date`;
CREATE ALGORITHM=UNDEFINED DEFINER=`entren8`@`localhost` SQL SECURITY DEFINER VIEW `trained_cc_by_date` AS (select `all_trained_cc`.`cedula_participante` AS `cedula_participante`,year(`ttr_control_forms`.`timestamp`) AS `año`,month(`ttr_control_forms`.`timestamp`) AS `mes` from (`all_trained_cc` join `ttr_control_forms` on(((`ttr_control_forms`.`id` = `all_trained_cc`.`form_id`) and (`ttr_control_forms`.`form` in ('for_vas_34_movil','for_vas_33_movil'))))));

-- ----------------------------
--  View structure for `trnrs_acompanamiento_data`
-- ----------------------------
DROP VIEW IF EXISTS `trnrs_acompanamiento_data`;
CREATE ALGORITHM=UNDEFINED DEFINER=`entren8`@`localhost` SQL SECURITY DEFINER VIEW `trnrs_acompanamiento_data` AS select `a`.`form_id` AS `form_id`,max((case when (`a`.`meta` = 'latitude') then `a`.`value` end)) AS `latitud`,max((case when (`a`.`meta` = 'longitude') then `a`.`value` end)) AS `longitud`,max((case when (`a`.`meta` = 'activity_date') then str_to_date(`a`.`value`,'%d/%m/%Y') end)) AS `fecha_actividad`,max((case when (`a`.`meta` = 'channel') then `a`.`value` end)) AS `canal`,max((case when (`a`.`meta` = 'module_subject') then `a`.`value` end)) AS `modulo_tema`,max((case when (`a`.`meta` like 'poscode_circuit%') then `a`.`value` end)) AS `codigo_pos_circuito`,max((case when (`a`.`meta` in ('asesor_cc','tecnico_cc')) then `a`.`value` end)) AS `cedula_participante`,max((case when (`a`.`meta` in ('asesor_name','tecnico_name')) then `a`.`value` end)) AS `nombre_participante`,max((case when (`a`.`meta` in ('asesor_msisdn','tecnico_msisdn')) then `a`.`value` end)) AS `celular_participante`,max((case when (`a`.`meta` in ('asesor_boss_name','tecnico_boss_name')) then `a`.`value` end)) AS `jefe_participante`,max((case when (`a`.`meta` = 'training_time') then `a`.`value` end)) AS `tiempo_entrenamiento`,max((case when (`a`.`meta` = 'asesor_boss_agency_name') then `a`.`value` end)) AS `interventor_agencia`,max((case when (`a`.`meta` like '%asesor_antiquity%') then `a`.`value` end)) AS `antiguedad_asesor`,max((case when (`a`.`meta` like '%mac_1%') then `a`.`value` end)) AS `mac_1`,max((case when (`a`.`meta` like '%mac_2%') then `a`.`value` end)) AS `mac_2`,max((case when (`a`.`meta` like '%mac_3%') then `a`.`value` end)) AS `mac_3`,max((case when (`a`.`meta` like '%mac_4%') then `a`.`value` end)) AS `mac_4`,max((case when (`a`.`meta` like '%mac_5%') then `a`.`value` end)) AS `mac_5`,max((case when (`a`.`meta` like '%mac_6%') then `a`.`value` end)) AS `mac_6`,max((case when (`a`.`meta` like '%mac_7%') then `a`.`value` end)) AS `mac_7`,max((case when (`a`.`meta` like '%mac_8%') then `a`.`value` end)) AS `mac_8`,max((case when (`a`.`meta` like '%mac_9%') then `a`.`value` end)) AS `mac_9`,max((case when (`a`.`meta` like '%mac_10%') then `a`.`value` end)) AS `mac_10`,max((case when (`a`.`meta` like '%mac_11%') then `a`.`value` end)) AS `mac_11`,max((case when (`a`.`meta` like '%mac_12%') then `a`.`value` end)) AS `mac_12`,max((case when (`a`.`meta` like '%mac_13%') then `a`.`value` end)) AS `mac_13`,max((case when (`a`.`meta` = 'training_time') then `a`.`value` end)) AS `duracion_entrenamiento`,max((case when (`a`.`meta` = 'field_notes') then `a`.`value` end)) AS `observaciones` from `ttr_control_forms_meta` `a` group by `a`.`form_id`;

-- ----------------------------
--  View structure for `trnrs_all_cc`
-- ----------------------------
DROP VIEW IF EXISTS `trnrs_all_cc`;
CREATE ALGORITHM=UNDEFINED DEFINER=`tigotrai_b1wNeVN`@`localhost` SQL SECURITY DEFINER VIEW `trnrs_all_cc` AS (select `ttr_control_forms_meta`.`form_id` AS `form_id`,(`ttr_control_forms_meta`.`value` * 1) AS `cedula` from `ttr_control_forms_meta` where (`ttr_control_forms_meta`.`meta` in ('asesor_cc','tecnico_cc','id_visited')));

-- ----------------------------
--  View structure for `trnrs_forvas07`
-- ----------------------------
DROP VIEW IF EXISTS `trnrs_forvas07`;
CREATE ALGORITHM=UNDEFINED DEFINER=`entren8`@`localhost` SQL SECURITY INVOKER VIEW `trnrs_forvas07` AS select `ttr_control_forms`.`id` AS `id`,`trnrs_all_cc`.`cedula` AS `cedula`,`trnrs_forvas07_data`.`latitud` AS `latitud`,`trnrs_forvas07_data`.`longitud` AS `longitud`,`trnrs_forvas07_data`.`fecha_actividad` AS `fecha_actividad`,convert_tz(`ttr_control_forms`.`timestamp`,'+00:00','-05:00') AS `fecha_registro`,(case when (`trnrs_forvas07_data`.`canal` = 'cde') then 'TIENDAS_PROPIAS' when (`trnrs_forvas07_data`.`canal` = 'fvd') then 'FUERZA_VD' when (`trnrs_forvas07_data`.`canal` = 'retail') then 'RETAIL' when (`trnrs_forvas07_data`.`canal` = 'dealer') then 'DISTRIBUIDORES' when (`trnrs_forvas07_data`.`canal` = 'cvds') then 'CDVS' when (`trnrs_forvas07_data`.`canal` = 'pap') then 'PAP' when (`trnrs_forvas07_data`.`canal` = 'aur y constructores') then 'AUR y Constructores' when (`trnrs_forvas07_data`.`canal` = 'puntos fijos') then 'Puntos Fijos' when (`trnrs_forvas07_data`.`canal` = 'contact center') then 'Contact Center' else `trnrs_forvas07_data`.`canal` end) AS `canal`,`trnrs_forvas07_data`.`modulo_tema` AS `modulo_tema`,`trnrs_forvas07_data`.`pedido` AS `pedido`,`trnrs_forvas07_data`.`codigo_pos_circuito` AS `codigo_pos_circuito`,`trnrs_forvas07_data`.`nombre_participante` AS `nombre_participante`,`trnrs_forvas07_data`.`celular_participante` AS `celular_participante`,`trnrs_forvas07_data`.`jefe_participante` AS `jefe_participante`,`trnrs_forvas07_data`.`interventor_agencia` AS `interventor_agencia`,`trnrs_forvas07_data`.`antiguedad_asesor` AS `antiguedad_asesor`,`trnrs_forvas07_data`.`presencia_de_clientes` AS `presencia_de_clientes`,`trnrs_forvas07_data`.`presencia_de_clientes` AS `objetivo_acompanamiento`,`trnrs_forvas07_data`.`mac_1` AS `mac_1`,`trnrs_forvas07_data`.`mac_2` AS `mac_2`,`trnrs_forvas07_data`.`mac_3` AS `mac_3`,`trnrs_forvas07_data`.`mac_4` AS `mac_4`,`trnrs_forvas07_data`.`mac_5` AS `mac_5`,`trnrs_forvas07_data`.`mac_6` AS `mac_6`,`trnrs_forvas07_data`.`mac_7` AS `mac_7`,`trnrs_forvas07_data`.`mac_8` AS `mac_8`,`trnrs_forvas07_data`.`mac_9` AS `mac_9`,`trnrs_forvas07_data`.`mac_10` AS `mac_10`,`trnrs_forvas07_data`.`mac_11` AS `mac_11`,`trnrs_forvas07_data`.`mac_12` AS `mac_12`,`trnrs_forvas07_data`.`mac_13` AS `mac_13`,`trnrs_forvas07_data`.`mac_14` AS `mac_14`,`trnrs_forvas07_data`.`mac_14` AS `mac_15`,`trnrs_forvas07_data`.`mac_14` AS `mac_16`,`trnrs_forvas07_data`.`mac_14` AS `mac_17`,`trnrs_forvas07_data`.`mac_14` AS `mac_18`,`trnrs_forvas07_data`.`mac_14` AS `mac_19`,`trnrs_forvas07_data`.`mac_14` AS `mac_20`,`trnrs_forvas07_data`.`mac_14` AS `mac_21`,`trnrs_forvas07_data`.`duracion_entrenamiento` AS `duracion_entrenamiento`,`trnrs_forvas07_data`.`observaciones_prepara_items` AS `observaciones_prepara_items`,`trnrs_forvas07_data`.`observaciones_prepara_herramientas` AS `observaciones_prepara_herramientas`,`trnrs_forvas07_data`.`observaciones_concluye` AS `observaciones_concluye`,`trnrs_forvas07_data`.`observaciones_tiempo_excedido` AS `observaciones_tiempo_excedido`,`trnrs_forvas07_data`.`observaciones_otras` AS `observaciones_otras`,`trnrs_forvas07_data`.`plan_de_accion` AS `plan_de_accion`,`trnrs_forvas07_data`.`oportunidades_mejora` AS `oportunidades_mejora`,`ttr_control_structure`.`id` AS `cedula_entrenador`,`ttr_control_structure`.`user_name` AS `nombre_entrenador`,`ttr_control_structure`.`user_regional` AS `regional_entrenador`,`ttr_control_structure`.`business_unit` AS `unidad_negocio`,`ttr_control_structure`.`user_role` AS `role` from (((`trnrs_all_cc` join `trnrs_forvas07_data`) join `ttr_control_forms`) join `ttr_control_structure` on(((`trnrs_all_cc`.`form_id` = `ttr_control_forms`.`id`) and (`trnrs_forvas07_data`.`form_id` = `ttr_control_forms`.`id`) and (`ttr_control_forms`.`form` like '%for_vas_07%') and (`ttr_control_forms`.`user_id` = `ttr_control_structure`.`id`))));

-- ----------------------------
--  View structure for `trnrs_forvas07_data`
-- ----------------------------
DROP VIEW IF EXISTS `trnrs_forvas07_data`;
CREATE ALGORITHM=UNDEFINED DEFINER=`entren8`@`localhost` SQL SECURITY INVOKER VIEW `trnrs_forvas07_data` AS (select `ttr_control_forms_meta`.`form_id` AS `form_id`,max((case when (`ttr_control_forms_meta`.`meta` = 'latitude') then `ttr_control_forms_meta`.`value` end)) AS `latitud`,max((case when (`ttr_control_forms_meta`.`meta` = 'longitude') then `ttr_control_forms_meta`.`value` end)) AS `longitud`,max((case when (`ttr_control_forms_meta`.`meta` = 'activity_date') then str_to_date(`ttr_control_forms_meta`.`value`,'%d/%m/%Y') end)) AS `fecha_actividad`,max((case when (`ttr_control_forms_meta`.`meta` = 'channel') then `ttr_control_forms_meta`.`value` end)) AS `canal`,max((case when (`ttr_control_forms_meta`.`meta` = 'module_subject') then `ttr_control_forms_meta`.`value` end)) AS `modulo_tema`,max((case when (`ttr_control_forms_meta`.`meta` = 'pedido') then `ttr_control_forms_meta`.`value` end)) AS `pedido`,max((case when (`ttr_control_forms_meta`.`meta` like '%poscode_circuit%') then `ttr_control_forms_meta`.`value` end)) AS `codigo_pos_circuito`,max((case when (`ttr_control_forms_meta`.`meta` regexp 'asesor_name|tecnico_name') then `ttr_control_forms_meta`.`value` end)) AS `nombre_participante`,max((case when (`ttr_control_forms_meta`.`meta` regexp 'asesor_msisdn|tecnico_msisdn') then `ttr_control_forms_meta`.`value` end)) AS `celular_participante`,max((case when (`ttr_control_forms_meta`.`meta` regexp 'asesor_boss_name|tecnico_boss_name') then `ttr_control_forms_meta`.`value` end)) AS `jefe_participante`,max((case when (`ttr_control_forms_meta`.`meta` = 'asesor_boss_agency_name') then `ttr_control_forms_meta`.`value` end)) AS `interventor_agencia`,max((case when (`ttr_control_forms_meta`.`meta` like '%asesor_antiquity%') then `ttr_control_forms_meta`.`value` end)) AS `antiguedad_asesor`,max((case when (`ttr_control_forms_meta`.`meta` = 'client_present') then `ttr_control_forms_meta`.`value` end)) AS `presencia_de_clientes`,max((case when (`ttr_control_forms_meta`.`meta` = 'coach_objective') then `ttr_control_forms_meta`.`value` end)) AS `objetivo_acompanamiento`,max((case when (`ttr_control_forms_meta`.`meta` like '%mac_1%') then `ttr_control_forms_meta`.`value` end)) AS `mac_1`,max((case when (`ttr_control_forms_meta`.`meta` like '%mac_2%') then `ttr_control_forms_meta`.`value` end)) AS `mac_2`,max((case when (`ttr_control_forms_meta`.`meta` like '%mac_3%') then `ttr_control_forms_meta`.`value` end)) AS `mac_3`,max((case when (`ttr_control_forms_meta`.`meta` like '%mac_4%') then `ttr_control_forms_meta`.`value` end)) AS `mac_4`,max((case when (`ttr_control_forms_meta`.`meta` like '%mac_5%') then `ttr_control_forms_meta`.`value` end)) AS `mac_5`,max((case when (`ttr_control_forms_meta`.`meta` like '%mac_6%') then `ttr_control_forms_meta`.`value` end)) AS `mac_6`,max((case when (`ttr_control_forms_meta`.`meta` like '%mac_7%') then `ttr_control_forms_meta`.`value` end)) AS `mac_7`,max((case when (`ttr_control_forms_meta`.`meta` like '%mac_8%') then `ttr_control_forms_meta`.`value` end)) AS `mac_8`,max((case when (`ttr_control_forms_meta`.`meta` like '%mac_9%') then `ttr_control_forms_meta`.`value` end)) AS `mac_9`,max((case when (`ttr_control_forms_meta`.`meta` like '%mac_10%') then `ttr_control_forms_meta`.`value` end)) AS `mac_10`,max((case when (`ttr_control_forms_meta`.`meta` like '%mac_11%') then `ttr_control_forms_meta`.`value` end)) AS `mac_11`,max((case when (`ttr_control_forms_meta`.`meta` like '%mac_12%') then `ttr_control_forms_meta`.`value` end)) AS `mac_12`,max((case when (`ttr_control_forms_meta`.`meta` like '%mac_13%') then `ttr_control_forms_meta`.`value` end)) AS `mac_13`,max((case when (`ttr_control_forms_meta`.`meta` like '%mac_14%') then `ttr_control_forms_meta`.`value` end)) AS `mac_14`,max((case when (`ttr_control_forms_meta`.`meta` like '%mac_15%') then `ttr_control_forms_meta`.`value` end)) AS `mac_15`,max((case when (`ttr_control_forms_meta`.`meta` like '%mac_16%') then `ttr_control_forms_meta`.`value` end)) AS `mac_16`,max((case when (`ttr_control_forms_meta`.`meta` like '%mac_17%') then `ttr_control_forms_meta`.`value` end)) AS `mac_17`,max((case when (`ttr_control_forms_meta`.`meta` like '%mac_18%') then `ttr_control_forms_meta`.`value` end)) AS `mac_18`,max((case when (`ttr_control_forms_meta`.`meta` like '%mac_19%') then `ttr_control_forms_meta`.`value` end)) AS `mac_19`,max((case when (`ttr_control_forms_meta`.`meta` like '%mac_20%') then `ttr_control_forms_meta`.`value` end)) AS `mac_20`,max((case when (`ttr_control_forms_meta`.`meta` like '%mac_21%') then `ttr_control_forms_meta`.`value` end)) AS `mac_21`,max((case when (`ttr_control_forms_meta`.`meta` = 'training_time') then `ttr_control_forms_meta`.`value` end)) AS `duracion_entrenamiento`,max((case when (`ttr_control_forms_meta`.`meta` = 'field_notes_prepara_items') then `ttr_control_forms_meta`.`value` end)) AS `observaciones_prepara_items`,max((case when (`ttr_control_forms_meta`.`meta` = 'field_notes_prepara_herramientas') then `ttr_control_forms_meta`.`value` end)) AS `observaciones_prepara_herramientas`,max((case when (`ttr_control_forms_meta`.`meta` = 'field_notes_concluye_items') then `ttr_control_forms_meta`.`value` end)) AS `observaciones_concluye`,max((case when (`ttr_control_forms_meta`.`meta` = 'field_notes_exceeded_time') then `ttr_control_forms_meta`.`value` end)) AS `observaciones_tiempo_excedido`,max((case when (`ttr_control_forms_meta`.`meta` = 'field_notes') then `ttr_control_forms_meta`.`value` end)) AS `observaciones_otras`,group_concat((case when (`ttr_control_forms_meta`.`meta` = 'oportunities') then `ttr_control_forms_meta`.`value` end) separator ',') AS `oportunidades_mejora`,max((case when (`ttr_control_forms_meta`.`meta` = 'revision_date') then `ttr_control_forms_meta`.`value` end)) AS `fecha_revision`,group_concat((case when (`ttr_control_forms_meta`.`meta` = 'basic_training_module') then `ttr_control_forms_meta`.`value` end) separator ',') AS `plan_de_accion` from `ttr_control_forms_meta` group by `ttr_control_forms_meta`.`form_id`);

-- ----------------------------
--  View structure for `trnrs_forvas33`
-- ----------------------------
DROP VIEW IF EXISTS `trnrs_forvas33`;
CREATE ALGORITHM=UNDEFINED DEFINER=`entren8`@`localhost` SQL SECURITY INVOKER VIEW `trnrs_forvas33` AS select `ttr_control_forms`.`id` AS `id`,`trnrs_all_cc`.`cedula` AS `cedula`,`trnrs_forvas33_data`.`latitud` AS `latitud`,`trnrs_forvas33_data`.`longitud` AS `longitud`,`ttr_control_forms`.`timestamp` AS `fecha_registro`,`trnrs_forvas33_data`.`fecha_actividad` AS `fecha_actividad`,`trnrs_forvas33_data`.`canal` AS `canal`,`trnrs_forvas33_data`.`nivel_entrenamiento` AS `nivel_entrenamiento`,`trnrs_forvas33_data`.`tema_entrenamiento` AS `tema_entrenamiento`,`trnrs_forvas33_data`.`se_hizo_evaluacion` AS `se_hizo_evaluacion`,`trnrs_forvas33_data`.`tiempo_entrenamiento` AS `tiempo_entrenamiento`,`trnrs_forvas33_data`.`observaciones` AS `observaciones`,`ttr_control_structure`.`id` AS `cedula_entrenador`,`ttr_control_structure`.`user_name` AS `nombre_entrenador`,`ttr_control_structure`.`user_regional` AS `regional_entrenador`,`ttr_control_structure`.`business_unit` AS `unidad_negocio` from (((`trnrs_all_cc` join `trnrs_forvas33_data`) join `ttr_control_forms`) join `ttr_control_structure` on(((`trnrs_all_cc`.`form_id` = `ttr_control_forms`.`id`) and (`trnrs_forvas33_data`.`form_id` = `ttr_control_forms`.`id`) and (`ttr_control_forms`.`form` like '%for_vas_33%') and (`ttr_control_forms`.`user_id` = `ttr_control_structure`.`id`))));

-- ----------------------------
--  View structure for `trnrs_forvas33_data`
-- ----------------------------
DROP VIEW IF EXISTS `trnrs_forvas33_data`;
CREATE ALGORITHM=UNDEFINED DEFINER=`entren8`@`localhost` SQL SECURITY DEFINER VIEW `trnrs_forvas33_data` AS select `ttr_control_forms_meta`.`form_id` AS `form_id`,max((case when (`ttr_control_forms_meta`.`meta` = 'latitude') then `ttr_control_forms_meta`.`value` end)) AS `latitud`,max((case when (`ttr_control_forms_meta`.`meta` = 'longitude') then `ttr_control_forms_meta`.`value` end)) AS `longitud`,max((case when (`ttr_control_forms_meta`.`meta` = 'activity_date') then str_to_date(`ttr_control_forms_meta`.`value`,'%d/%m/%Y') end)) AS `fecha_actividad`,max((case when (`ttr_control_forms_meta`.`meta` = 'channel') then `ttr_control_forms_meta`.`value` end)) AS `canal`,max((case when (`ttr_control_forms_meta`.`meta` = 'training_level') then `ttr_control_forms_meta`.`value` end)) AS `nivel_entrenamiento`,max((case when (`ttr_control_forms_meta`.`meta` in ('basic_training_module','intermediate_training_module','advanced_training_module','training_module','Complementary_b2b_training_module')) then `ttr_control_forms_meta`.`value` end)) AS `tema_entrenamiento`,max((case when (`ttr_control_forms_meta`.`meta` = 'quiz_done') then `ttr_control_forms_meta`.`value` end)) AS `se_hizo_evaluacion`,max((case when (`ttr_control_forms_meta`.`meta` = 'training_time') then `ttr_control_forms_meta`.`value` end)) AS `tiempo_entrenamiento`,max((case when (`ttr_control_forms_meta`.`meta` = 'field_notes') then `ttr_control_forms_meta`.`value` end)) AS `observaciones` from `ttr_control_forms_meta` group by `ttr_control_forms_meta`.`form_id`;

-- ----------------------------
--  View structure for `trnrs_forvas34`
-- ----------------------------
DROP VIEW IF EXISTS `trnrs_forvas34`;
CREATE ALGORITHM=UNDEFINED DEFINER=`entren8`@`localhost` SQL SECURITY INVOKER VIEW `trnrs_forvas34` AS select `ttr_control_forms`.`id` AS `id`,`trnrs_all_cc`.`cedula` AS `cedula/id_punto`,`trnrs_forvas34_data`.`latitud` AS `latitud`,`trnrs_forvas34_data`.`longitud` AS `longitud`,`ttr_control_forms`.`timestamp` AS `fecha_registro`,`trnrs_forvas34_data`.`fecha_actividad` AS `fecha_actividad`,(case when (`trnrs_forvas34_data`.`canal` = 'cde') then 'TIENDAS_PROPIAS' when (`trnrs_forvas34_data`.`canal` = 'fvd') then 'FUERZA_VD' when (`trnrs_forvas34_data`.`canal` = 'retail') then 'RETAIL' when (`trnrs_forvas34_data`.`canal` = 'dealer') then 'DISTRIBUIDORES' when (`trnrs_forvas34_data`.`canal` = 'cvds') then 'CDVS' when (`trnrs_forvas34_data`.`canal` = 'pap') then 'PAP' when (`trnrs_forvas34_data`.`canal` = 'aur y contructores') then 'AUR y Constructores' when (`trnrs_forvas34_data`.`canal` = 'puntos fijos') then 'Puntos Fijos' when (`trnrs_forvas34_data`.`canal` = 'contact center') then 'Contact Center' else `trnrs_forvas34_data`.`canal` end) AS `canal`,`trnrs_forvas34_data`.`codigo_punto` AS `codigo_punto`,`trnrs_forvas34_data`.`tipo_entrenamiento` AS `tipo_entrenamiento`,`trnrs_forvas34_data`.`temas_entrenamiento` AS `temas_entrenamiento`,`trnrs_forvas34_data`.`tiempo_entrenamiento` AS `tiempo_entrenamiento`,`trnrs_forvas34_data`.`observaciones` AS `observaciones`,`ttr_control_structure`.`id` AS `cedula_entrenador`,`ttr_control_structure`.`user_name` AS `nombre_entrenador`,`ttr_control_structure`.`user_regional` AS `regional_entrenador`,`ttr_control_structure`.`business_unit` AS `unidad_negocio` from (((`trnrs_all_cc` join `trnrs_forvas34_data`) join `ttr_control_forms`) join `ttr_control_structure` on(((`trnrs_all_cc`.`form_id` = `ttr_control_forms`.`id`) and (`trnrs_forvas34_data`.`form_id` = `ttr_control_forms`.`id`) and (`ttr_control_forms`.`form` like 'for_vas_34%') and (`ttr_control_forms`.`user_id` = `ttr_control_structure`.`id`))));

-- ----------------------------
--  View structure for `trnrs_forvas34_data`
-- ----------------------------
DROP VIEW IF EXISTS `trnrs_forvas34_data`;
CREATE ALGORITHM=UNDEFINED DEFINER=`entren8`@`localhost` SQL SECURITY DEFINER VIEW `trnrs_forvas34_data` AS select `ttr_control_forms_meta`.`form_id` AS `form_id`,max((case when (`ttr_control_forms_meta`.`meta` = 'latitude') then `ttr_control_forms_meta`.`value` end)) AS `latitud`,max((case when (`ttr_control_forms_meta`.`meta` = 'longitude') then `ttr_control_forms_meta`.`value` end)) AS `longitud`,max((case when (`ttr_control_forms_meta`.`meta` = 'activity_date') then str_to_date(`ttr_control_forms_meta`.`value`,'%d/%m/%Y') end)) AS `fecha_actividad`,max((case when (`ttr_control_forms_meta`.`meta` = 'channel') then `ttr_control_forms_meta`.`value` end)) AS `canal`,max((case when (`ttr_control_forms_meta`.`meta` = 'poscode_circuit') then `ttr_control_forms_meta`.`value` end)) AS `codigo_punto`,max((case when (`ttr_control_forms_meta`.`meta` = 'training_type') then `ttr_control_forms_meta`.`value` end)) AS `tipo_entrenamiento`,group_concat((case when (`ttr_control_forms_meta`.`meta` = 'training_theme') then ifnull((select `ttr_control_training_themes`.`title` from `ttr_control_training_themes` where (`ttr_control_training_themes`.`id` = `ttr_control_forms_meta`.`value`)),`ttr_control_forms_meta`.`value`) end) separator ', ') AS `temas_entrenamiento`,max((case when (`ttr_control_forms_meta`.`meta` = 'training_time') then `ttr_control_forms_meta`.`value` end)) AS `tiempo_entrenamiento`,max((case when (`ttr_control_forms_meta`.`meta` = 'field_notes') then `ttr_control_forms_meta`.`value` end)) AS `observaciones` from `ttr_control_forms_meta` group by `ttr_control_forms_meta`.`form_id`;

-- ----------------------------
--  View structure for `trnrs_forvas34_data2`
-- ----------------------------
DROP VIEW IF EXISTS `trnrs_forvas34_data2`;
CREATE ALGORITHM=UNDEFINED DEFINER=`tigotrai_b1wNeVN`@`localhost` SQL SECURITY DEFINER VIEW `trnrs_forvas34_data2` AS select `ttr_control_forms_meta`.`form_id` AS `form_id`,(`ttr_control_forms_meta`.`meta` = 'training_theme') AS `training_theme`,max((case when (`ttr_control_forms_meta`.`meta` = 'latitude') then `ttr_control_forms_meta`.`value` end)) AS `latitud`,max((case when (`ttr_control_forms_meta`.`meta` = 'longitude') then `ttr_control_forms_meta`.`value` end)) AS `longitud`,max((case when (`ttr_control_forms_meta`.`meta` = 'activity_date') then str_to_date(`ttr_control_forms_meta`.`value`,'%d/%m/%Y') end)) AS `fecha_actividad`,max((case when (`ttr_control_forms_meta`.`meta` = 'channel') then `ttr_control_forms_meta`.`value` end)) AS `canal`,max((case when (`ttr_control_forms_meta`.`meta` = 'poscode_circuit') then `ttr_control_forms_meta`.`value` end)) AS `codigo_punto`,max((case when (`ttr_control_forms_meta`.`meta` = 'training_type') then `ttr_control_forms_meta`.`value` end)) AS `tipo_entrenamiento`,max((case when (`ttr_control_forms_meta`.`meta` = 'training_theme') then ifnull((select `ttr_control_training_themes`.`title` from `ttr_control_training_themes` where (`ttr_control_training_themes`.`id` = `ttr_control_forms_meta`.`value`)),`ttr_control_forms_meta`.`value`) end)) AS `temas_entrenamiento`,max((case when (`ttr_control_forms_meta`.`meta` = 'training_time') then `ttr_control_forms_meta`.`value` end)) AS `tiempo_entrenamiento`,max((case when (`ttr_control_forms_meta`.`meta` = 'field_notes') then `ttr_control_forms_meta`.`value` end)) AS `observaciones` from `ttr_control_forms_meta` group by (`ttr_control_forms_meta`.`meta` = 'training_theme');

SET FOREIGN_KEY_CHECKS = 1;
