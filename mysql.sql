
CREATE TABLE IF NOT EXISTS `ci_manager` (
  `id` tinyint(2) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL,
  `realname` varchar(16) NOT NULL,
  `password` char(32) NOT NULL,
  `salt` varchar(6) NOT NULL,
  `role` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `ip` varchar(16) DEFAULT NULL COMMENT '��ip',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- ת����е����� `ci_manager`
--

INSERT INTO `ci_manager` (`id`, `username`, `realname`, `password`, `salt`, `role`, `ip`) VALUES
(1, 'ci_admin', 'CI��', 'd28977ad3fca08b59034acbf57dec561', '8kAl2', 1, NULL);


-- --------------------------------------------------------

--
-- ��Ľṹ `ci_online`
--

CREATE TABLE IF NOT EXISTS `ci_online` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `token` varchar(32) NOT NULL COMMENT 'session_id',
  `ip` varchar(16) NOT NULL COMMENT 'ip��ַ',
  `login_time` int(10) unsigned NOT NULL,
  `logout_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`),
  UNIQUE KEY `user_id` (`user_id`,`ip`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='�����û���¼' AUTO_INCREMENT=2 ;

--
-- ת����е����� `ci_online`
--

INSERT INTO `ci_online` (`id`, `user_id`, `token`, `ip`, `login_time`, `logout_time`) VALUES
(1, 1, '5dc4edecc9eb9cb0c793ed2c3ad86dff', '::1', 1501044908, 0);