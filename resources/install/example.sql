-- --------------------------------------------------------

--
-- Table structure for table `[component]_tags`
--

CREATE TABLE `#__tags` (
  `tag_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `modified_by` int(10) unsigned DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  `locked_by` int(10) unsigned DEFAULT NULL,
  `locked_on` datetime DEFAULT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`tag_id`),
  UNIQUE KEY `slug` (`slug`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `[component]_tags_relations`
--

CREATE TABLE `#__tags_relations` (
	`tag_id` bigint(20) unsigned NOT NULL,
  `uuid` VARCHAR(36) NOT NULL,
  PRIMARY KEY  (`tag_id`,`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
