DROP DATABASE IF EXISTS laravel_twitter_clone;
CREATE DATABASE laravel_twitter_clone;
USE laravel_twitter_clone;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `follows`
--

DROP TABLE IF EXISTS `follows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `follows` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `follower_id` int(11) NOT NULL,
  `followed_id` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `follows`
--

LOCK TABLES `follows` WRITE;
/*!40000 ALTER TABLE `follows` DISABLE KEYS */;
/*!40000 ALTER TABLE `follows` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `likes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `tweet_id` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `likes`
--

LOCK TABLES `likes` WRITE;
/*!40000 ALTER TABLE `likes` DISABLE KEYS */;
/*!40000 ALTER TABLE `likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `instance` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `channel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `context` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `remote_addr` int(10) unsigned DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `logs_instance_index` (`instance`),
  KEY `logs_channel_index` (`channel`),
  KEY `logs_level_index` (`level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logs`
--

LOCK TABLES `logs` WRITE;
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2020_12_01_000000_create_follows_table',1),(5,'2020_12_01_000000_create_likes_table',1),(6,'2020_12_01_000000_create_replies_table',1),(7,'2020_12_01_000000_create_retweets_table',1),(8,'2020_12_01_000000_create_tweets_table',1),(9,'2021_01_11_000000_create_pins_table',1),(10,'2021_03_15_000000_create_logs_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pins`
--

DROP TABLE IF EXISTS `pins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pins` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `tweet_id` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pins`
--

LOCK TABLES `pins` WRITE;
/*!40000 ALTER TABLE `pins` DISABLE KEYS */;
/*!40000 ALTER TABLE `pins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `replies`
--

DROP TABLE IF EXISTS `replies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `replies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `reply_id` int(11) NOT NULL,
  `reply_to` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `replies`
--

LOCK TABLES `replies` WRITE;
/*!40000 ALTER TABLE `replies` DISABLE KEYS */;
/*!40000 ALTER TABLE `replies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `retweets`
--

DROP TABLE IF EXISTS `retweets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `retweets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `tweet_id` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `retweets`
--

LOCK TABLES `retweets` WRITE;
/*!40000 ALTER TABLE `retweets` DISABLE KEYS */;
/*!40000 ALTER TABLE `retweets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tweets`
--

DROP TABLE IF EXISTS `tweets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tweets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `text` varchar(280) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tweets`
--

LOCK TABLES `tweets` WRITE;
/*!40000 ALTER TABLE `tweets` DISABLE KEYS */;
INSERT INTO `tweets` VALUES 
(1,1,'It is better to offer no excuse than a bad one.',NULL,'1789-04-30 00:00:00','2000-01-01 00:00:00'),
(2,2,'Go on and improve in everything worthy.',NULL,'1797-03-04 00:00:00','2000-01-01 00:00:00'),
(3,3,'Never put off till tomorrow what you can do today.',NULL,'1801-03-04 00:00:00','2000-01-01 00:00:00'),
(4,4,'The advancement and diffusion of knowledge is the only guardian of true liberty.',NULL,'1809-03-04 00:00:00','2000-01-01 00:00:00'),
(5,5,'We must support our rights or lose our character, and with it, perhaps, our liberties.',NULL,'1817-03-04 00:00:00','2000-01-01 00:00:00'),
(6,6,'Try and fail, but don’t fail to try.',NULL,'1825-03-04 00:00:00','2000-01-01 00:00:00'),
(7,7,'One man with courage makes a majority.',NULL,'1829-03-04 00:00:00','2000-01-01 00:00:00'),
(8,8,'It is easier to do a job right than to explain why you didn’t.',NULL,'1837-03-04 00:00:00','2000-01-01 00:00:00'),
(9,9,'The liberties of a people depend on their own constant attention to its preservation.',NULL,'1841-03-04 00:00:00','2000-01-01 00:00:00'),
(10,10,'Liberty and equality are captivating sounds, but they often captivate to destroy.',NULL,'1841-04-04 00:00:00','2000-01-01 00:00:00'),
(11,11,'No president who performs his duties faithfully and conscientiously can have any leisure.',NULL,'1845-03-04 00:00:00','2000-01-01 00:00:00'),
(12,12,'I have always done my duty. I am ready to die. My only regret is for the friends I leave behind me.',NULL,'1849-03-04 00:00:00','2000-01-01 00:00:00'),
(13,13,'Let us remember that revolutions do not always establish freedom.',NULL,'1850-07-09 00:00:00','2000-01-01 00:00:00'),
(14,14,'If your past is limited, your future is boundless.',NULL,'1853-03-04 00:00:00','2000-01-01 00:00:00'),
(15,15,'The ballot box is the surest arbiter of disputes among free men.',NULL,'1857-03-04 00:00:00','2000-01-01 00:00:00'),
(16,16,'I am a slow walker, but I never walk backwards.',NULL,'1861-03-04 00:00:00','2000-01-01 00:00:00'),
(17,17,'If you always support the correct principles then you will never get the wrong results!',NULL,'1865-04-15 00:00:00','2000-01-01 00:00:00'),
(18,18,'In every battle there comes a time when both sides consider themselves beaten, then he who continues the attack wins.',NULL,'1869-03-04 00:00:00','2000-01-01 00:00:00'),
(19,19,'Every expert was once a beginner.',NULL,'1877-03-04 00:00:00','2000-01-01 00:00:00'),
(20,20,'The truth will set you free, but first it will make you miserable.',NULL,'1881-03-04 00:00:00','2000-01-01 00:00:00'),
(21,21,'I may be president of the United States, but my private life is nobody\'s damned business.',NULL,'1881-09-19 00:00:00','2000-01-01 00:00:00'),
(22,22,'Honor lies in honest toil.',NULL,'1885-03-04 00:00:00','2000-01-01 00:00:00'),
(23,23,'Great lives never go out; they go on.',NULL,'1889-03-04 00:00:00','2000-01-01 00:00:00'),
(24,24,'I have tried so hard to do right.',NULL,'1893-03-04 00:00:00','2000-01-01 00:00:00'),
(25,25,'Strong hearts and helpful hands are needed, and, fortunately, we have them in every part of our beloved country.',NULL,'1897-03-04 00:00:00','2000-01-01 00:00:00'),
(26,26,'Do what you can, with what you have, where you are.',NULL,'1901-03-04 00:00:00','2000-01-01 00:00:00'),
(27,27,'Don\'t write so that you can be understood, write so that you can\'t be misunderstood.',NULL,'1909-03-04 00:00:00','2000-01-01 00:00:00'),
(28,28,'The seed of revolution is repression.',NULL,'1913-03-04 00:00:00','2000-01-01 00:00:00'),
(29,29,'Treat your friend as if he will one day be your enemy, and your enemy as if he will one day be your friend.',NULL,'1921-03-04 00:00:00','2000-01-01 00:00:00'),
(30,30,'It takes a great man to be a good listener.',NULL,'1923-08-02 00:00:00','2000-01-01 00:00:00'),
(31,31,'Words without actions are the assassins of idealism.',NULL,'1929-03-04 00:00:00','2000-01-01 00:00:00'),
(32,32,'The only thing we have to fear is fear itself.',NULL,'1933-03-04 00:00:00','2000-01-01 00:00:00'),
(33,33,'Study men, not historians.',NULL,'1945-04-12 00:00:00','2000-01-01 00:00:00'),
(34,34,'Pessimism never won any battle.',NULL,'1953-01-20 00:00:00','2000-01-01 00:00:00'),
(35,35,'Ask not what your country can do for you, but what you can do for your country.',NULL,'1961-01-20 00:00:00','2000-01-01 00:00:00'),
(36,36,'Yesterday is not ours to recover, but tomorrow is ours to win or lose.',NULL,'1963-11-22 00:00:00','2000-01-01 00:00:00'),
(37,37,'The finest steel has to go through the hottest fire.',NULL,'1969-01-20 00:00:00','2000-01-01 00:00:00'),
(38,38,'I am a Ford, not a Lincoln.',NULL,'1974-08-09 00:00:00','2000-01-01 00:00:00'),
(39,39,'Like music and art, love of nature is a common language that can transcend political or social boundaries.',NULL,'1977-01-20 00:00:00','2000-01-01 00:00:00'),
(40,40,'Government exists to protect us from each other. Where government has gone beyond its limits is in deciding to protect us from ourselves.',NULL,'1981-01-20 00:00:00','2000-01-01 00:00:00'),
(41,41,'I have opinions of my own, strong opinions, but I don’t always agree with them.',NULL,'1989-01-20 00:00:00','2000-01-01 00:00:00'),
(42,42,'When our memories outweigh our dreams, it is then that we become old.',NULL,'1993-01-20 00:00:00','2000-01-01 00:00:00'),
(43,43,'One of the great things about books is sometimes there are some fantastic pictures.',NULL,'2001-01-20 00:00:00','2000-01-01 00:00:00'),
(44,44,'Change will not come if we wait for some other person or some other time.',NULL,'2009-01-20 00:00:00','2000-01-01 00:00:00'),
(45,45,'I will build a great great wall on our southern border and I’ll have Mexico pay for that wall.',NULL,'2017-01-20 00:00:00','2000-01-01 00:00:00'),
(46,46,'For without unity, there\'s no peace, only bitterness and fury.',NULL,'2021-01-20 00:00:00','2000-01-01 00:00:00'); 
/*!40000 ALTER TABLE `tweets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bg` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES 
(1,'GeorgeWashington','GeorgeWashington@example.com',NULL,'jpg','George Washington','American political leader, military general, statesman, and Founding Father who served as the first president of the United States from 1789 to 1797.','Unaffiliated',NULL,NULL,'$2y$10$UF7Lauy/8Vm0Jap5EY0Kp.B/K/XhZjgxp/SyckpaNFB3A60rR8fgC',NULL,NULL,'1789-04-30 00:00:00','1789-04-30 00:00:00'),
(2,'JohnAdams','JohnAdams@example.com',NULL,'jpg','John Adams','American statesman, attorney, diplomat, writer, and Founding Father who served as the second president of the United States, from 1797 to 1801.','Federalist',NULL,NULL,'$2y$10$gLJkuhQpr3fr3yKYRfSqDuxo1lO.466Rn5PUbtCFhXyX/BY4KUppa',NULL,NULL,'1797-03-04 00:00:00','1797-03-04 00:00:00'),
(3,'ThomasJefferson','ThomasJefferson@example.com',NULL,'jpg','Thomas Jefferson','American statesman, diplomat, lawyer, architect, philosopher, and Founding Father who served as the third president of the United States from 1801 to 1809.','Democratic-Republican',NULL,NULL,'$2y$10$U4LnEqg6IeBnlZ.KuhJcBOIxIVpDtLKlhLtLaBSsX8.H..azD4Idy',NULL,NULL,'1801-03-04 00:00:00','1801-03-04 00:00:00'),
(4,'JamesMadison','JamesMadison@example.com',NULL,'jpg','James Madison','American statesman, diplomat, expansionist, philosopher, and Founding Father who served as the fourth president of the United States from 1809 to 1817.','Democratic-Republican',NULL,NULL,'$2y$10$/dWQIHj7ktXCJ/ryO2hpb.3cwa2pyMwsbMvMDABJ9d6SzXolE4Hiu',NULL,NULL,'1809-03-04 00:00:00','1809-03-04 00:00:00'),
(5,'JamesMonroe','JamesMonroe@example.com',NULL,'jpg','James Monroe','American statesman, lawyer, diplomat and Founding Father who served as the fifth president of the United States from 1817 to 1825.','Democratic-Republican',NULL,NULL,'$2y$10$tL9ijdLV5qpRIdcTxMzpnOJMKhZTUo5/O/cqCpGl3/8I4tNaW.Lrq',NULL,NULL,'1817-03-04 00:00:00','1817-03-04 00:00:00'),
(6,'JohnQuincyAdams','JohnQuincyAdams@example.com',NULL,'jpg','John Quincy Adams','American statesman, diplomat, lawyer, and diarist who served as the sixth president of the United States, from 1825 to 1829.','Democratic-Republican',NULL,NULL,'$2y$10$N6aSBPwgEgNSZdaThsyObuL/JZu4dQRTJU3usqpyz.ZMApvzuy2ee',NULL,NULL,'1825-03-04 00:00:00','1825-03-04 00:00:00'),
(7,'AndrewJackson','AndrewJackson@example.com',NULL,'jpg','Andrew Jackson','American soldier and statesman who served as the seventh president of the United States from 1829 to 1837.','Democratic','democrats.org',NULL,'$2y$10$tVD5Ppwhm10gk2IWhUCStunO.q53mbfJjxsytYGgzbknB6uZO/f.y',NULL,NULL,'1829-03-04 00:00:00','1829-03-04 00:00:00'),
(8,'MartinVanBuren','MartinVanBuren@example.com',NULL,'jpg','Martin Van Buren','American statesman who served as the eighth president of the United States from 1837 to 1841.','Democratic','democrats.org',NULL,'$2y$10$Di5iHVeGnuhr4nxe/NMPs.QVqmo/o7DYVn2fyiHgWFmZT.EHgBaXG',NULL,NULL,'1837-03-04 00:00:00','1837-03-04 00:00:00'),
(9,'WilliamHenryHarrison','WilliamHenryHarrison@example.com',NULL,'jpg','William Henry Harrison','American military officer and politician who served as the ninth president of the United States in 1841.','Whig',NULL,NULL,'$2y$10$SsgYTwtGlRC7CzqYU3cYH.apA8p64d.Sj8DECBqdCLrjvuIR/MwKG',NULL,NULL,'1841-03-04 00:00:00','1841-03-04 00:00:00'),
(10,'JohnTyler','JohnTyler@example.com',NULL,'jpg','John Tyler','Tenth president of the United States from 1841 to 1845 after briefly serving as the tenth vice president in 1841.','Whig',NULL,NULL,'$2y$10$2dGZMMOKEOTB6Q9xpbXjyuycn9JJ91af5PL4uHbXifeq4dHQ061Oy',NULL,NULL,'1841-04-04 00:00:00','1841-04-04 00:00:00'),
(11,'JamesKPolk','JamesKPolk@example.com',NULL,'jpg','James K. Polk','11th president of the United States, serving from 1845 to 1849.','Democratic','democrats.org',NULL,'$2y$10$1eSU/I02BwSUudOxE1ZlfeUJ9Z2sDcPvDd/r9lgxZekM.Yf5puI1a',NULL,NULL,'1845-03-04 00:00:00','1845-03-04 00:00:00'),
(12,'ZacharyTaylor','ZacharyTaylor@example.com',NULL,'jpg','Zachary Taylor','The 12th president of the United States, serving from March 1849 until his death in July 1850.','Whig',NULL,NULL,'$2y$10$PzSNlCgbaq1bVjaG0JA2Suq6kScTNSfoLsHt2yXZUmN2Ss9iuTEIS',NULL,NULL,'1849-03-04 00:00:00','1849-03-04 00:00:00'),
(13,'MillardFillmore','MillardFillmore@example.com',NULL,'jpg','Millard Fillmore','13th president of the United States (1850–1853), the last to be a member of the Whig Party while in the White House.','Whig',NULL,NULL,'$2y$10$G2s8ZmPNLywSaiZYMChatu1ISk0nhOaT1y23S1yusyN9D4lzpI1J2',NULL,NULL,'1850-07-09 00:00:00','1850-07-09 00:00:00'),
(14,'FranklinPierce','FranklinPierce@example.com',NULL,'jpg','Franklin Pierce','14th president of the United States (1853–1857).','Democratic','democrats.org',NULL,'$2y$10$IzOMCmr.roschT4EF4R6B.8cdqjwEwq.wbuR3metyh0tClLYaU2GG',NULL,NULL,'1853-03-04 00:00:00','1853-03-04 00:00:00'),
(15,'JamesBuchanan','JamesBuchanan@example.com',NULL,'jpg','James Buchanan','American lawyer and politician who served as the 15th president of the United States (1857–1861).','Democratic','democrats.org',NULL,'$2y$10$HbCzQ1mrSrY5cEQLCJY3zepKR.jeAYDsZoeCRSqhJD9fLxB//U/Ya',NULL,NULL,'1857-03-04 00:00:00','1857-03-04 00:00:00'),
(16,'AbrahamLincoln','AbrahamLincoln@example.com',NULL,'jpg','Abraham Lincoln','American statesman and lawyer who served as the 16th president of the United States.','Republican','gop.gov',NULL,'$2y$10$2HDinofiurDf2Tg33OXfweAJNfK9XyO7a3tZDpjTTQt4mKQWke0Wm',NULL,NULL,'1861-03-04 00:00:00','1861-03-04 00:00:00'),
(17,'AndrewJohnson','AndrewJohnson@example.com',NULL,'jpg','Andrew Johnson','17th president of the United States, serving from 1865 to 1869.','National Union',NULL,NULL,'$2y$10$L3KMg2monCyr8diq6Ub.wOs9kCFqz70wFMwD6DBibaIEp/Z3oYUOu',NULL,NULL,'1865-04-15 00:00:00','1865-04-15 00:00:00'),
(18,'UlyssesSGrant','UlyssesSGrant@example.com',NULL,'jpg','Ulysses S. Grant','American soldier and politician who served as the 18th president of the United States from 1869 to 1877.','Republican','gop.gov',NULL,'$2y$10$BoxJM.2K8n.krM8qyyFCEORKGJPvvK/dTtFRDElSbAAKrrcFs18D6',NULL,NULL,'1869-03-04 00:00:00','1869-03-04 00:00:00'),
(19,'RutherfordBHayes','RutherfordBHayes@example.com',NULL,'jpg','Rutherford B. Hayes','19th president of the United States from 1877 to 1881.','Republican','gop.gov',NULL,'$2y$10$0o5fF/vAJmAMMpg6qnunjuS1GNh1b.JRfIUqFTs1jBcSxG3LfAgwO',NULL,NULL,'1877-03-04 00:00:00','1877-03-04 00:00:00'),
(20,'JamesAGarfield','JamesAGarfield@example.com',NULL,'jpg','James A. Garfield','20th president of the United States.','Republican','gop.gov',NULL,'$2y$10$bfwuxLRD8RTQPHTS7FziTeeNsvXfwyjTL4eXFR7nt9Lsd9Bv2OgYu',NULL,NULL,'1881-03-04 00:00:00','1881-03-04 00:00:00'),
(21,'ChesterAArthur','ChesterAArthur@example.com',NULL,'jpg','Chester A. Arthur','American attorney and politician who served as the 21st president of the United States from 1881 to 1885.','Republican','gop.gov',NULL,'$2y$10$sUqYXtEcC9qiBCfd/0MPHOZ0nm7yqVYt9IL6.UdjL8c1dY9j0iVFq',NULL,NULL,'1881-09-19 00:00:00','1881-09-19 00:00:00'),
(22,'GroverCleveland','GroverCleveland@example.com',NULL,'jpg','Grover Cleveland','American politician and lawyer who was the 22nd and 24th president of the United States.','Democratic','democrats.org',NULL,'$2y$10$1U2uV29/BE1ekzsIEYXNDOqj5RmF6DAjx4MP83DvezJRfuDAYRvXm',NULL,NULL,'1885-03-04 00:00:00','1885-03-04 00:00:00'),
(23,'BenjaminHarrison','BenjaminHarrison@example.com',NULL,'jpg','Benjamin Harrison','American politician and lawyer who served as the 23rd president of the United States from 1889 to 1893.','Republican','gop.gov',NULL,'$2y$10$AOZWRmlDGKYJhcUk6XphzOz0Y3vXLvhgi.klNeziEOTLal5xXYheC',NULL,NULL,'1889-03-04 00:00:00','1889-03-04 00:00:00'),
(24,'GroverCleveland2nd','GroverCleveland2nd@example.com',NULL,'jpg','Grover Cleveland','American politician and lawyer who was the 22nd and 24th president of the United States.','Democratic','democrats.org',NULL,'$2y$10$4is5y5vBvrm/n.NHn0aUI.m52lEagiw7MRGfOew.Z49eU4MPAvTuq',NULL,NULL,'1893-03-04 00:00:00','1893-03-04 00:00:00'),
(25,'WilliamMcKinley','WilliamMcKinley@example.com',NULL,'jpg','William McKinley','25th president of the United States.','Republican','gop.gov',NULL,'$2y$10$/Wm2YRSNELxPxHxIK8UwouE/52rKTWuwKG1.7D0rV09bhsjHcJE/K',NULL,NULL,'1897-03-04 00:00:00','1897-03-04 00:00:00'),
(26,'TheodoreRoosevelt','TheodoreRoosevelt@example.com',NULL,'jpg','Theodore Roosevelt','American statesman, conservationist, naturalist, historian, and writer, who served as the 26th president of the United States from 1901 to 1909. ','Republican','gop.gov',NULL,'$2y$10$PR1u0/9ZCvT8q9zEg3S2oucAiLwgkMvUN6ZyBs8QT0pK5g9Oy/m/.',NULL,NULL,'1901-09-14 00:00:00','1901-09-14 00:00:00'),
(27,'WilliamHowardTaft','WilliamHowardTaft@example.com',NULL,'jpg','William Howard Taft','27th president of the United States (1909–1913) and the tenth Chief Justice of the United States (1921–1930).','Republican','gop.gov',NULL,'$2y$10$HKHzWqR0WE94bGXJtlMuEeUOBV3biYIVpHxz0KbJoc1SAznZiaapS',NULL,NULL,'1909-03-04 00:00:00','1909-03-04 00:00:00'),
(28,'WoodrowWilson','WoodrowWilson@example.com',NULL,'jpg','Woodrow Wilson','American politician and academic who served as the 28th president of the United States from 1913 to 1921.','Democratic','democrats.org',NULL,'$2y$10$K.aSJsbNZuWhGPlJZrwst.ZU4raVdfTvijJSAjnO88KrnL/se.2y.',NULL,NULL,'1913-03-04 00:00:00','1913-03-04 00:00:00'),
(29,'WarrenGHarding','WarrenGHarding@example.com',NULL,'jpg','Warren G. Harding','29th president of the United States from 1921 until his death in 1923.','Republican','gop.gov',NULL,'$2y$10$hsAxfVuBI8VvHTi7ygB4CO1Z8xjFGAgG7xMUyx37l/0QLGlxsIb1u',NULL,NULL,'1921-03-04 00:00:00','1921-03-04 00:00:00'),
(30,'CalvinCoolidge','CalvinCoolidge@example.com',NULL,'jpg','Calvin Coolidge','American politician and lawyer who served as the 30th president of the United States from 1923 to 1929.','Republican','gop.gov',NULL,'$2y$10$h/WjrBibgz5g/pPt21W/Duumn5fdqlmQYfYcEB139FRnV0h8cMlF2',NULL,NULL,'1923-08-02 00:00:00','1923-08-02 00:00:00'),
(31,'HerbertHoover','HerbertHoover@example.com',NULL,'jpg','Herbert Hoover','American politician, businessman, and engineer, who served as the 31st president of the United States from 1929 to 1933. ','Republican','gop.gov',NULL,'$2y$10$2grRUbl5VJlFdPXtFD7EqePz4nMWMRXeQw0w6xyuylBwnRF.hJvpu',NULL,NULL,'1929-03-04 00:00:00','1929-03-04 00:00:00'),
(32,'FranklinDRoosevelt','FranklinDRoosevelt@example.com',NULL,'jpg','Franklin D. Roosevelt','American politician who served as the 32nd president of the United States.','Democratic','democrats.org',NULL,'$2y$10$1V64Zw0Za/YJWi.88lU/qeahnRDPoRbuHWd2a6lYfLxX6RXrrJBqa',NULL,NULL,'1933-03-04 00:00:00','1933-03-04 00:00:00'),
(33,'HarrySTruman','HarrySTruman@example.com',NULL,'jpg','Harry S. Truman','33rd president of the United States from 1945 to 1953.','Democratic','democrats.org',NULL,'$2y$10$6e83vfu31eP3YHRSZ5hOq.uA5cjD4Afr8th01/T2tuX8bjmCktrPi',NULL,NULL,'1945-04-12 00:00:00','1945-04-12 00:00:00'),
(34,'DwightDEisenhower','DwightDEisenhower@example.com',NULL,'jpg','Dwight D. Eisenhower','American politician and soldier who served as the 34th president of the United States from 1953 to 1961.','Republican','gop.gov',NULL,'$2y$10$Jxqy9pDg38Yx3eWwhTgF5eoLmd4lyAquv5waaBnFxbVWqLVdX8sc.',NULL,NULL,'1953-01-20 00:00:00','1953-01-20 00:00:00'),
(35,'JohnFKennedy','JohnFKennedy@example.com',NULL,'jpg','John F. Kennedy','American politician who served as the 35th president of the United States.','Democratic','democrats.org',NULL,'$2y$10$jF9eDB7bkymRE1fVgEfv6O2VbkJNs1ZhJfsHKZbov8AOjJxHB8wsu',NULL,NULL,'1961-01-20 00:00:00','1961-01-20 00:00:00'),
(36,'LyndonBJohnson','LyndonBJohnson@example.com',NULL,'jpg','Lyndon B. Johnson','American politician who served as the 36th president of the United States from 1963 to 1969.','Democratic','democrats.org',NULL,'$2y$10$JeDtj7lWBlrBhdPxlDiCee0.LYUwoETiQMa4ZmLzwLAq.xSvcWUY.',NULL,NULL,'1963-11-22 00:00:00','1963-11-22 00:00:00'),
(37,'RichardNixon','RichardNixon@example.com',NULL,'jpg','Richard Nixon','37th president of the United States, serving from 1969 until 1974.','Republican','gop.gov',NULL,'$2y$10$2wUFmY2HlCRI2JFxCPp.0.v3UhkFXsMq2EOBc995kR7MxTvXEtUvq',NULL,NULL,'1969-01-20 00:00:00','1969-01-20 00:00:00'),
(38,'GeraldFord','GeraldFord@example.com',NULL,'jpg','Gerald Ford','American politician who served as the 38th president of the United States from August 1974 to January 1977.','Republican','gop.gov',NULL,'$2y$10$zf6qAMg1/IYX3SkR.YYt1O1TggJotmRLAQadSk1BrDbkh3hd9e.pG',NULL,NULL,'1974-08-09 00:00:00','1974-08-09 00:00:00'),
(39,'JimmyCarter','JimmyCarter@example.com',NULL,'jpg','Jimmy Carter','American politician and philanthropist who served as the 39th president of the United States from 1977 to 1981.','Democratic','democrats.org',NULL,'$2y$10$E5rIIDItM.MCKnBfSI5gEuF3rDNu1qgH3xnkPSBdZMFkiX..5wrsa',NULL,NULL,'1977-01-20 00:00:00','1977-01-20 00:00:00'),
(40,'RonaldReagan','RonaldReagan@example.com',NULL,'jpg','Ronald Reagan','American politician who served as the 40th president of the United States from 1981 to 1989.','Republican','gop.gov',NULL,'$2y$10$CiAxk20tIRf/IyuD6L3NgeDMF7PrNNdSnqnQWBgWH1HHQQGRb6BK6',NULL,NULL,'1981-01-20 00:00:00','1981-01-20 00:00:00'),
(41,'GeorgeHWBush','GeorgeHWBush@example.com',NULL,'jpg','George H. W. Bush','American politician and businessman who served as the 41st president of the United States from 1989 to 1993.','Republican','bush41.org',NULL,'$2y$10$V8wXBSc/6AwCqzH/aq3ayOKcbNB0Au7gTcJHCsPse7tq2AfhNBuO.',NULL,NULL,'1989-01-20 00:00:00','1989-01-20 00:00:00'),
(42,'BillClinton','BillClinton@example.com',NULL,'jpg','Bill Clinton','American politician and attorney who served as the 42nd president of the United States from 1993 to 2001.','Democratic','clintonfoundation.org',NULL,'$2y$10$7N/yWdbTE6.mJ712nbeIKe/n0K56SNb5IOdnyP35bzde8S0SBCtYe',NULL,NULL,'1993-01-20 00:00:00','1993-01-20 00:00:00'),
(43,'GeorgeWBush','GeorgeWBush@example.com',NULL,'jpg','George W. Bush','American politician and businessman who served as the 43rd president of the United States from 2001 to 2009.','Republican','bushcenter.org',NULL,'$2y$10$OX5n84ZlzWC37W9i/v/.3.xCPOY9qH1BZFy.v.Iff09MvCjmIkMO2',NULL,NULL,'2001-01-20 00:00:00','2001-01-20 00:00:00'),
(44,'BarackObama','BarackObama@example.com',NULL,'jpg','Barack Obama','American politician and attorney who served as the 44th president of the United States from 2009 to 2017.','Democratic','obama.org',NULL,'$2y$10$/CFY146ZtBP.Qf3p4gmGNeFbCqEgbo7q6GZ5sULEU7kUFt3Qtjub2',NULL,NULL,'2009-01-20 00:00:00','2009-01-20 00:00:00'),
(45,'DonaldTrump','DonaldTrump@example.com',NULL,'jpg','Donald Trump','American politician and businessman who was the 45th president of the United States from 2017 to 2021.','Republican','donaldjtrump.com',NULL,'$2y$10$cwojryNIuONoRgTq0o.RbuGEnGW9XztczUgAqdsnwcbVF0hnHkGo6',NULL,NULL,'2017-01-20 00:00:00','2017-01-20 00:00:00'),
(46,'JoeBiden','JoeBiden@example.com',NULL,'jpg','Joe Biden','American politician serving as the 46th and current president of the United States.','Democratic','joebiden.com',NULL,'$2y$10$cwojryNIuONoRgTq0o.RbuGEnGW9XztczUgAqdsnwcbVF0hnHkGo6',NULL,NULL,'2021-01-20 00:00:00','2021-01-20 00:00:00'),
(100,'guest','guest@example.com',NULL,NULL,'Name',NULL,NULL,NULL,NULL,'$2y$10$cwojryNIuONoRgTq0o.RbuGEnGW9XztczUgAqdsnwcbVF0hnHkGo6',NULL,NULL,'2021-01-01 00:00:00','2021-01-01 00:00:00');
