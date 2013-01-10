DROP TABLE IF EXISTS `tag`;

CREATE TABLE `tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(20) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tag_user1_idx` (`user_id`),
  CONSTRAINT `fk_tag_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
