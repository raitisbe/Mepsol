-- phpMyAdmin SQL Dump
-- version 3.2.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 27, 2010 at 07:13 AM
-- Server version: 5.0.51
-- PHP Version: 5.2.6-1+lenny9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `mepsol`
--

-- --------------------------------------------------------

--
-- Table structure for table `connections`
--

CREATE TABLE IF NOT EXISTS `connections` (
  `id` int(11) NOT NULL auto_increment,
  `id1` int(11) NOT NULL,
  `id2` int(11) NOT NULL,
  `expr` varchar(200) NOT NULL,
  `serviceid` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=295 ;

--
-- Dumping data for table `connections`
--

INSERT INTO `connections` (`id`, `id1`, `id2`, `expr`, `serviceid`) VALUES
(283, 142, 144, 'All by property', 1),
(45, 130, 134, '', 1),
(47, 127, 137, '', 1),
(49, 137, 129, 'Individual', 1),
(285, 130, 142, 'How to pay equity capital?', 1),
(53, 134, 128, 'General partnership', 1),
(54, 127, 138, '', 1),
(55, 138, 0, '', 1),
(56, 138, 138, '', 1),
(57, 138, 137, '', 1),
(58, 130, 130, 'Ltd', 1),
(289, 131, 128, 'General partnership', 1),
(288, 131, 130, 'Limited company', 1),
(72, 127, 131, 'What type of company do you want to  establish?', 1),
(69, 127, 131, 'What type of company do you want to  establish?', 1),
(282, 142, 145, 'Both', 1),
(70, 127, 131, 'What type of company do you want to  establish?', 1),
(148, 143, 147, 'Are all board directors founders?', 1),
(206, 169, 171, 'No', 1),
(205, 169, 170, 'Yes', 1),
(156, 149, 151, 'Is the company established by one or more persons?', 1),
(204, 129, 169, 'Specific license required?', 1),
(197, 147, 151, 'Is the company established by one or more persons?', 1),
(196, 147, 151, 'Is the company established by one or more persons?', 1),
(284, 144, 147, 'Are all board directors founders?', 1),
(149, 143, 147, 'Are all board directors founders?', 1),
(168, 155, 164, 'Join', 1),
(203, 151, 156, 'More persons', 1),
(202, 151, 155, 'One person', 1),
(157, 150, 151, 'Is the company established by one or more persons?', 1),
(169, 156, 164, 'Join', 1),
(162, 159, 160, 'Yes', 1),
(163, 159, 161, 'No', 1),
(294, 158, 159, 'Will the input be submitted by a representative?', 1),
(170, 164, 163, 'Fast procedure or slow?', 1),
(210, 163, 165, '1 day', 1),
(209, 163, 166, '3 days', 1),
(175, 165, 167, '', 1),
(176, 166, 167, '', 1),
(177, 167, 158, 'In which region is the company located (legal address)?', 1),
(212, 171, 172, 'Fast procedure or slow?', 1),
(213, 172, 173, '1 day', 1),
(214, 172, 174, '3 days', 1),
(217, 174, 175, 'Join', 1),
(218, 173, 175, 'Join', 1),
(219, 175, 167, '', 1),
(220, 147, 149, 'No', 1),
(221, 147, 150, 'Yes', 1),
(287, 131, 129, 'Individual merchantman', 1),
(223, 176, 175, 'Join', 1),
(224, 128, 175, 'Join', 1),
(225, 177, 178, 'Life insurance', 1),
(226, 177, 179, 'Other insurance', 1),
(227, 177, 180, 'Pawnshop', 1),
(228, 177, 181, 'Other', 1),
(229, 177, 182, 'Exchange', 1),
(230, 141, 177, 'What is the type of SC', 1),
(231, 178, 183, 'How to pay equity capital', 1),
(232, 179, 183, 'How to pay equity capital', 1),
(233, 180, 183, 'How to pay equity capital', 1),
(234, 181, 183, 'How to pay equity capital', 1),
(235, 182, 183, 'How to pay equity capital', 1),
(236, 183, 185, 'All in money', 1),
(237, 183, 184, 'Both in money and in property', 1),
(238, 185, 186, 'Is the company established by one or more persons?', 1),
(239, 184, 186, 'Is the company established by one or more persons?', 1),
(244, 188, 163, 'Fast procedure or slow?', 1),
(241, 186, 188, 'More persons', 1),
(242, 186, 187, 'One person', 1),
(245, 187, 163, 'Fast procedure or slow?', 1),
(248, 165, 175, 'Join', 1),
(249, 166, 175, 'Join', 1),
(250, 175, 158, 'In which region is the company located (legal address)?', 1),
(251, 189, 191, 'No', 1),
(252, 189, 190, 'Yes', 1),
(253, 160, 189, 'Will the application be signed by other persons on behalf of the founders?', 1),
(254, 161, 189, 'Will the application be signed by other persons on behalf of the founders?', 1),
(255, 188, 163, 'Fast procedure or slow?', 1),
(281, 142, 143, 'All in money', 1),
(290, 131, 141, 'Stock company', 1),
(291, 131, 176, 'Limited partnership', 1),
(293, 145, 147, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE IF NOT EXISTS `services` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(200) character set utf8 NOT NULL,
  `description` text character set utf8 NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `description`) VALUES
(1, 'Enterprise registration', 'How to register an enterprise?'),
(6, 'lalala', 'la');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE IF NOT EXISTS `states` (
  `id` int(11) NOT NULL auto_increment,
  `name` text NOT NULL,
  `x` float NOT NULL,
  `y` float NOT NULL,
  `w` float NOT NULL,
  `h` float NOT NULL,
  `type` char(1) character set latin1 NOT NULL,
  `description_lv` text NOT NULL,
  `description_gr` text NOT NULL,
  `description_en` text NOT NULL,
  `info_lv` text NOT NULL,
  `info_gr` text NOT NULL,
  `info_en` text NOT NULL,
  `document_lv` text NOT NULL,
  `document_gr` text NOT NULL,
  `document_en` text NOT NULL,
  `video_link_lv` text NOT NULL,
  `video_link_gr` text NOT NULL,
  `video_link_en` text NOT NULL,
  `question_lv` text NOT NULL,
  `question_gr` text NOT NULL,
  `question_en` text NOT NULL,
  `answers_lv` text NOT NULL,
  `answers_gr` text NOT NULL,
  `answers_en` text NOT NULL,
  `decision_type` varchar(30) NOT NULL,
  `decision_variable` varchar(30) NOT NULL,
  `store_variable` varchar(30) NOT NULL,
  `input_type` varchar(30) NOT NULL,
  `checked` char(7) NOT NULL,
  `serviceid` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=192 ;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name`, `x`, `y`, `w`, `h`, `type`, `description_lv`, `description_gr`, `description_en`, `info_lv`, `info_gr`, `info_en`, `document_lv`, `document_gr`, `document_en`, `video_link_lv`, `video_link_gr`, `video_link_en`, `question_lv`, `question_gr`, `question_en`, `answers_lv`, `answers_gr`, `answers_en`, `decision_type`, `decision_variable`, `store_variable`, `input_type`, `checked`, `serviceid`) VALUES
(141, 'Stock company', 1.00008e+07, 9.99993e+06, 155, 40, 's', '', '', '', '', '', 'State fee: 250LVL|Announcement fee: 24LVL', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1),
(128, 'General partnership', 1.00005e+07, 9.99983e+06, 194, 40, 's', '', '', '', '', '', 'State fee: 100LVL|Announcement fee: 24LVL', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1),
(129, 'Individual', 9.99952e+06, 9.99999e+06, 120, 38, 's', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1),
(130, 'Ltd', 9.99904e+06, 9.99999e+06, 38, 39, 's', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1),
(131, 'What type of company do you want to  establish?', 9.99964e+06, 1.00001e+07, 492, 40, 'd', '', '', 'What type of company do you want to  establish?', '', '', '', '', '', '', '', '', '', '', '', 'What is the type of the company?', '', '', '', 'Input', '', '', 'DropDown', 'checked', 1),
(142, 'How to pay equity capital?', 9.9987e+06, 9.99989e+06, 265, 40, 'd', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Will you pay the equitycapital in money, by property contribution or both?', '', '', '', 'Input', '', '', 'DropDown', '', 1),
(143, 'All in money', 9.99866e+06, 9.99978e+06, 127, 40, 's', '', '', '', '', '', 'Notice from a bang regarding the payment of equity capital', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1),
(144, 'All by property', 9.99906e+06, 9.9997e+06, 148, 40, 's', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1),
(145, 'Both', 9.99885e+06, 9.99977e+06, 52, 40, 's', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1),
(147, 'Are all board directors founders?', 9.99872e+06, 9.99955e+06, 326, 40, 'd', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Did all the board directors sign the application as founders?', '', '', '', 'Input', '', '', 'DropDown', '', 1),
(170, 'Yes', 9.99943e+06, 9.9998e+06, 41, 40, 's', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1),
(149, 'No', 9.99876e+06, 9.99946e+06, 34, 40, 's', '', '', '', '', '', 'Written acceptance of thees member of the board directors to be a member of the board director and Notarized sample signatures of these members', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1),
(150, 'Yes', 9.99895e+06, 9.99947e+06, 41, 40, 's', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1),
(151, 'Is the company established by one or more persons?', 9.99857e+06, 9.9993e+06, 525, 40, 'd', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Is the company established by one or more persons?', '', '', '', 'Input', '', '', 'DropDown', '', 1),
(155, 'One person', 9.99888e+06, 9.99921e+06, 118, 40, 's', '', '', '', '', '', 'The signature on the application may be certified in the Register of Enterprises and he/she shall draft and sign the decision on foundation instead the memorandum of association', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1),
(156, 'More persons', 9.99865e+06, 9.9992e+06, 137, 40, 's', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1),
(158, 'In which region is the company located (legal address)?', 9.99917e+06, 9.99852e+06, 552, 40, 'd', '', '', 'In which region is the company located (legal address)?', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Variable', '', '', 'DropDown', '', 1),
(159, 'Will the input be submitted by a representative?', 9.99914e+06, 9.99844e+06, 471, 40, 'd', '', '', 'Will the input be submitted by a representative?', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Input', '', '', 'DropDown', '', 1),
(160, 'Yes', 9.99934e+06, 9.99832e+06, 41, 40, 's', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1),
(161, 'No', 9.99948e+06, 9.99832e+06, 34, 40, 's', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1),
(164, 'Join', 9.99882e+06, 9.99908e+06, 47, 40, 's', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1),
(163, 'Fast procedure or slow?', 9.99987e+06, 9.99872e+06, 240, 40, 'd', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Do you want your application to follow the normal procedure (3 days) or the minimum one (1 day)?', '', '', '', 'Input', '', '', 'DropDown', '', 1),
(165, '1 day', 9.99983e+06, 9.99905e+06, 64, 40, 's', '', '', '', '', '', 'The Threefold state fee', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1),
(166, '3 days', 9.99994e+06, 9.99906e+06, 72, 40, 's', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1),
(189, 'Will the application be signed by other persons on behalf of the founders?', 9.99914e+06, 9.99814e+06, 729, 40, 'd', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Will the application be signed by other persons on behalf of the founders?', '', '', '', 'Input', '', '', 'DropDown', '', 1),
(172, 'Fast procedure or slow?', 9.99948e+06, 9.99968e+06, 241, 40, 'd', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Do you want your application to follow the normal procedure (3 days) or the minimum one (1 day)?', '', '', '', 'Input', '', '', 'DropDown', '', 1),
(169, 'Specific license required?', 9.99944e+06, 9.9999e+06, 252, 40, 'd', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Does your business activity type require a specific license but it is not issued for an IM(e.g. alcohol trade)?', '', '', '', 'Input', '', '', 'DropDown', '', 1),
(171, 'No', 9.99954e+06, 9.99981e+06, 34, 40, 's', '', '', '', '', '', 'State fee 20LVL|Announcement fee 16LVL', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1),
(173, '1 day', 9.99938e+06, 9.99951e+06, 64, 40, 's', '', '', '', '', '', 'Additional application', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1),
(174, '3 days', 9.99963e+06, 9.99956e+06, 74, 40, 's', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1),
(175, 'Join', 9.99978e+06, 9.99928e+06, 47, 40, 's', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1),
(176, 'Limited partnership', 9.9999e+06, 9.99985e+06, 192, 40, 's', '', '', '', '', '', 'State fee: 100LVL|Announcement fee: 24LVL', '', '', '', '', '', 'http://www.youtube.com/watch?v=p4lu2sOlo3Y', '', '', '', '', '', '', '', '', '', '', '', 1),
(177, 'What is the type of SC', 1.00008e+07, 9.99972e+06, 229, 40, 'd', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'What is the type of SC', '', '', '', 'Input', '', '', 'DropDown', '', 1),
(178, 'Life insurance', 1.00005e+07, 9.99955e+06, 142, 40, 's', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1),
(179, 'Other insurance', 1.00007e+07, 9.99956e+06, 160, 40, 's', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1),
(180, 'Pawnshop', 1.00009e+07, 9.99956e+06, 103, 40, 's', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1),
(181, 'Other', 1.00011e+07, 9.99956e+06, 60, 40, 's', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1),
(182, 'Exchange', 1.00012e+07, 9.99957e+06, 98, 40, 's', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1),
(183, 'How to pay equity capital', 1.00009e+07, 9.99945e+06, 254, 40, 'd', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Will you pay the equity capital only in money or both in money and by property contribution?', '', '', '', 'Input', '', '', 'DropDown', '', 1),
(184, 'Both in money and in property', 1.0001e+07, 9.99934e+06, 305, 40, 's', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1),
(185, 'All in money', 1.00008e+07, 9.99935e+06, 127, 40, 's', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1),
(186, 'Is the company established by one or more persons?', 1.00007e+07, 9.99923e+06, 525, 40, 'd', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Is the company established by one or more persons?', '', '', '', 'Input', '', '', 'DropDown', '', 1),
(187, 'One person', 1.0001e+07, 9.99912e+06, 118, 40, 's', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1),
(188, 'More persons', 1.00008e+07, 9.99912e+06, 137, 40, 's', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1),
(190, 'Yes', 9.99953e+06, 9.99804e+06, 41, 40, 's', '', '', '', '', '', 'The warrant of the founders must be presented', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1),
(191, 'No', 9.99935e+06, 9.99804e+06, 34, 40, 's', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1);
