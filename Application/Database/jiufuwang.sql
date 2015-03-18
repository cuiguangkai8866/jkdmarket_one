-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2015-03-14 07:47:46
-- 服务器版本： 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `jiufuwang`
--

-- --------------------------------------------------------

--
-- 表的结构 `jkd_ad`
--

CREATE TABLE IF NOT EXISTS `jkd_ad` (
`id` smallint(5) unsigned NOT NULL,
  `ad_name` varchar(60) NOT NULL DEFAULT '',
  `ad_link` varchar(255) NOT NULL DEFAULT '',
  `ad_img` varchar(255) NOT NULL,
  `position` char(10) NOT NULL DEFAULT '0',
  `sort` tinyint(1) unsigned NOT NULL DEFAULT '50',
  `lang` varchar(10) NOT NULL DEFAULT 'zh-cn'
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `jkd_ad`
--

INSERT INTO `jkd_ad` (`id`, `ad_name`, `ad_link`, `ad_img`, `position`, `sort`, `lang`) VALUES
(1, '首页中间展示1', 'http://www.jiufu9.com/detail.html?9b2cfa29e7882e3649d5f3b9921afdb0=Mjc=', '54b0bdae3ce39.jpg', 'index_m1', 1, 'zh-cn'),
(2, '首页中间展示2', 'http://www.jiufu9.com/detail.html?9b2cfa29e7882e3649d5f3b9921afdb0=NTk=', '54b0c54d56c16.jpg', 'index_m2', 2, 'zh-cn'),
(3, '喜迎羊年', 'http://www.jiufu9.com/shop.html?Mid=MjA3', '54af3db556f13.gif', 'index_top', 0, 'zh-cn'),
(4, '拍拍图', 'http://www.jiufu9.com', '546164bf03638.png', 'paipai', 4, 'zh-cn'),
(5, '秒杀图', 'http://www.jiufu9.com', '547525b8273e8.png', 'ms', 5, 'zh-cn'),
(6, '团购图', 'http://www.jiufu9.com', '547d78686238d.png', 'tuan', 6, 'zh-cn'),
(7, '登陆页', 'http://www.jiufu9.com', '548028f7e4ee2.png', 'login', 6, 'zh-cn'),
(10, '送礼啦，最高送2000元', 'http://www.jiufu9.com/shop.html?Mid=MQ==', '54af3ec615ea8.jpg', 'index_top', 0, 'zh-cn'),
(11, '享受法国浪漫', 'http://www.jiufu9.com/shop.html?Mid=MjQ=', '54b77bd159d96.jpg', 'index_top', 0, 'zh-cn');

-- --------------------------------------------------------

--
-- 表的结构 `jkd_admin`
--

CREATE TABLE IF NOT EXISTS `jkd_admin` (
`aid` int(11) NOT NULL,
  `nickname` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL COMMENT '登录账号',
  `pwd` char(32) DEFAULT NULL COMMENT '登录密码',
  `status` int(11) DEFAULT '1' COMMENT '账号状态',
  `remark` varchar(255) DEFAULT '' COMMENT '备注信息',
  `find_code` char(5) DEFAULT NULL COMMENT '找回账号验证码',
  `time` int(10) DEFAULT NULL COMMENT '开通时间'
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='网站后台管理员表';

--
-- 转存表中的数据 `jkd_admin`
--

INSERT INTO `jkd_admin` (`aid`, `nickname`, `email`, `pwd`, `status`, `remark`, `find_code`, `time`) VALUES
(1, '超级管理员', 'admin@qq.com', 'e5e4ad197497fc75565982791b425b51', 1, '超级管理员', NULL, 1408686625);

-- --------------------------------------------------------

--
-- 表的结构 `jkd_category`
--

CREATE TABLE IF NOT EXISTS `jkd_category` (
`id` int(10) unsigned NOT NULL,
  `parent_id` int(10) unsigned NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `is_show` int(1) DEFAULT NULL,
  `sort` int(10) unsigned DEFAULT '255'
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `jkd_field`
--

CREATE TABLE IF NOT EXISTS `jkd_field` (
`id` int(11) NOT NULL COMMENT 'ID',
  `model_id` int(11) NOT NULL COMMENT '所属模型id',
  `name` varchar(128) NOT NULL COMMENT '字段名称',
  `comment` varchar(32) NOT NULL COMMENT '字段注释',
  `type` varchar(32) NOT NULL COMMENT '字段类型',
  `length` varchar(16) NOT NULL COMMENT '字段长度',
  `value` varchar(128) NOT NULL COMMENT '字段默认值',
  `is_require` tinyint(4) DEFAULT '0' COMMENT '是否必需',
  `is_unique` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否唯一',
  `is_index` tinyint(4) DEFAULT '0' COMMENT '是否添加索引',
  `is_system` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否系统字段',
  `is_list_show` tinyint(4) NOT NULL DEFAULT '1' COMMENT '列表中显示',
  `auto_filter` varchar(32) NOT NULL COMMENT '自动过滤函数',
  `auto_fill` varchar(32) NOT NULL COMMENT '自动完成函数',
  `fill_time` varchar(16) NOT NULL DEFAULT 'both' COMMENT '填充时机',
  `relation_model` int(11) NOT NULL COMMENT '关联的模型',
  `relation_field` varchar(128) NOT NULL COMMENT '关联的字段',
  `relation_value` varchar(128) NOT NULL COMMENT '关联显示的值',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='数据模型字段';

-- --------------------------------------------------------

--
-- 表的结构 `jkd_images`
--

CREATE TABLE IF NOT EXISTS `jkd_images` (
`id` int(11) NOT NULL,
  `catname` varchar(20) NOT NULL,
  `savename` varchar(100) NOT NULL,
  `savepath` varchar(255) NOT NULL,
  `create_time` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=814 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `jkd_images`
--

INSERT INTO `jkd_images` (`id`, `catname`, `savename`, `savepath`, `create_time`) VALUES
(91, 'product', '20141022085257_78359.jpg', '/Uploads/image/product/20141022/20141022085257_78359.jpg', 1413967979),
(58, 'product', '20141015023802_47974.jpg', '/Uploads/image/product/20141015/20141015023802_47974.jpg', 1413453212),
(61, 'product', '20141016095331_26721.jpg', '/Uploads/image/product/20141016/20141016095331_26721.jpg', 1413453260),
(68, 'product', '20141017005113_61135.jpg', '/Uploads/image/product/20141017/20141017005113_61135.jpg', 1413507085),
(66, 'product', '20141016095419_55266.jpg', '/Uploads/image/product/20141016/20141016095419_55266.jpg', 1413453792),
(80, 'product', '20141016152824_99005.jpg', '/Uploads/image/product/20141016/20141016152824_99005.jpg', 1413507102),
(70, 'product', '20141016152824_99005.jpg', '/Uploads/image/product/20141016/20141016152824_99005.jpg', 1413507085),
(79, 'product', '20141017005113_61135.jpg', '/Uploads/image/product/20141017/20141017005113_61135.jpg', 1413507102),
(72, 'product', '20141017005113_61135.jpg', '/Uploads/image/product/20141017/20141017005113_61135.jpg', 1413507085),
(74, 'product', '20141017005113_61135.jpg', '/Uploads/image/product/20141017/20141017005113_61135.jpg', 1413507090),
(78, 'product', '20141017005113_61135.jpg', '/Uploads/image/product/20141017/20141017005113_61135.jpg', 1413507102),
(86, 'product', '20141016152824_99005.jpg', '/Uploads/image/product/20141016/20141016152824_99005.jpg', 1413507108),
(108, 'product', '20141025080214_11554.jpg', '/Uploads/image/product/20141025/20141025080214_11554.jpg', 1414545794),
(84, 'product', '20141017005113_61135.jpg', '/Uploads/image/product/20141017/20141017005113_61135.jpg', 1413507108),
(87, 'product', '20141016152824_99005.jpg', '/Uploads/image/product/20141016/20141016152824_99005.jpg', 1413507108),
(110, 'product', '20141022085257_78359.jpg', '/Uploads/image/product/20141022/20141022085257_78359.jpg', 1414545794),
(89, 'product', '20141017005113_61135.jpg', '/Uploads/image/product/20141017/20141017005113_61135.jpg', 1413507108),
(109, 'product', '20141025080221_24916.jpg', '/Uploads/image/product/20141025/20141025080221_24916.jpg', 1414545794),
(123, 'product', '20141025080214_11554.jpg', '/Uploads/image/product/20141025/20141025080214_11554.jpg', 1416447866),
(124, 'product', '20141022085257_78359.jpg', '/Uploads/image/product/20141022/20141022085257_78359.jpg', 1416447867),
(114, 'product', '20141029012257_55700.jpg', '/Uploads/image/product/20141029/20141029012257_55700.jpg', 1416193158),
(116, 'product', '20141029012257_55700.jpg', '/Uploads/image/product/20141029/20141029012257_55700.jpg', 1416193200),
(117, 'product', '20141029012257_55700.jpg', '/Uploads/image/product/20141029/20141029012257_55700.jpg', 1416193203),
(118, 'product', '20141029012257_55700.jpg', '/Uploads/image/product/20141029/20141029012257_55700.jpg', 1416193214),
(119, 'product', '20141118065603_53714.jpg', '/Uploads/image/product/20141118/20141118065603_53714.jpg', 1416293773),
(120, 'product', '20141118065612_46804.jpeg', '/Uploads/image/product/20141118/20141118065612_46804.jpeg', 1416293773),
(244, 'product', '20141125164746_32491.jpg', '/Uploads/image/product/20141125/20141125164746_32491.jpg', 1417766239),
(243, 'product', '20141125164738_13043.jpg', '/Uploads/image/product/20141125/20141125164738_13043.jpg', 1417766239),
(242, 'product', '20141125164732_94130.jpg', '/Uploads/image/product/20141125/20141125164732_94130.jpg', 1417766239),
(241, 'product', '20141125164724_35933.jpg', '/Uploads/image/product/20141125/20141125164724_35933.jpg', 1417766239),
(240, 'product', '20141125164719_39303.jpg', '/Uploads/image/product/20141125/20141125164719_39303.jpg', 1417766239),
(745, 'product', '20141206170009_56727.jpg', '/Uploads/image/product/20141206/20141206170009_56727.jpg', 1420709991),
(730, 'product', '20141206164401_52827.jpg', '/Uploads/image/product/20141206/20141206164401_52827.jpg', 1420709934),
(731, 'product', '20141206164407_30692.jpg', '/Uploads/image/product/20141206/20141206164407_30692.jpg', 1420709934),
(732, 'product', '20141206164414_96410.jpg', '/Uploads/image/product/20141206/20141206164414_96410.jpg', 1420709934),
(693, 'product', '20141206103632_86239.jpg', '/Uploads/image/product/20141206/20141206103632_86239.jpg', 1420709694),
(720, 'product', '20141206162353_72495.jpg', '/Uploads/image/product/20141206/20141206162353_72495.jpg', 1420709890),
(710, 'product', '20141206160824_94377.jpg', '/Uploads/image/product/20141206/20141206160824_94377.jpg', 1420709860),
(711, 'product', '20141206160832_25924.jpg', '/Uploads/image/product/20141206/20141206160832_25924.jpg', 1420709860),
(712, 'product', '20141206160837_83759.jpg', '/Uploads/image/product/20141206/20141206160837_83759.jpg', 1420709860),
(713, 'product', '20141206160848_52593.jpg', '/Uploads/image/product/20141206/20141206160848_52593.jpg', 1420709860),
(714, 'product', '20141206160854_23526.jpg', '/Uploads/image/product/20141206/20141206160854_23526.jpg', 1420709860),
(694, 'product', '20141206114510_92348.jpg', '/Uploads/image/product/20141206/20141206114510_92348.jpg', 1420709749),
(692, 'product', '20141208100458_24106.jpg', '/Uploads/image/product/20141208/20141208100458_24106.jpg', 1420709681),
(356, 'product', '20141206110324_46985.jpg', '/Uploads/image/product/20141206/20141206110324_46985.jpg', 1417850318),
(357, 'product', '20141206110333_11260.jpg', '/Uploads/image/product/20141206/20141206110333_11260.jpg', 1417850318),
(358, 'product', '20141206110347_51712.jpg', '/Uploads/image/product/20141206/20141206110347_51712.jpg', 1417850318),
(359, 'product', '20141206110357_52583.jpg', '/Uploads/image/product/20141206/20141206110357_52583.jpg', 1417850318),
(360, 'product', '20141206110411_51970.jpg', '/Uploads/image/product/20141206/20141206110411_51970.jpg', 1417850318),
(636, 'product', '20141206110956_41541.jpg', '/Uploads/image/product/20141206/20141206110956_41541.jpg', 1420000737),
(635, 'product', '20141206110929_52852.jpg', '/Uploads/image/product/20141206/20141206110929_52852.jpg', 1420000737),
(634, 'product', '20141206110909_64170.jpg', '/Uploads/image/product/20141206/20141206110909_64170.jpg', 1420000737),
(633, 'product', '20141206110858_47413.jpg', '/Uploads/image/product/20141206/20141206110858_47413.jpg', 1420000737),
(632, 'product', '20141206110806_72954.jpg', '/Uploads/image/product/20141206/20141206110806_72954.jpg', 1420000737),
(733, 'product', '20141206164418_61838.jpg', '/Uploads/image/product/20141206/20141206164418_61838.jpg', 1420709934),
(734, 'product', '20141206164424_55293.jpg', '/Uploads/image/product/20141206/20141206164424_55293.jpg', 1420709934),
(724, 'product', '20141206162424_94136.jpg', '/Uploads/image/product/20141206/20141206162424_94136.jpg', 1420709890),
(723, 'product', '20141206162419_50663.jpg', '/Uploads/image/product/20141206/20141206162419_50663.jpg', 1420709890),
(655, 'product', '20141206111934_57301.jpg', '/Uploads/image/product/20141206/20141206111934_57301.jpg', 1420709292),
(656, 'product', '20141206111940_38847.jpg', '/Uploads/image/product/20141206/20141206111940_38847.jpg', 1420709292),
(657, 'product', '20141206111948_87956.jpg', '/Uploads/image/product/20141206/20141206111948_87956.jpg', 1420709292),
(658, 'product', '20141206111955_71292.jpg', '/Uploads/image/product/20141206/20141206111955_71292.jpg', 1420709292),
(659, 'product', '20141206112001_47938.jpg', '/Uploads/image/product/20141206/20141206112001_47938.jpg', 1420709292),
(699, 'product', '20141206152741_11293.jpg', '/Uploads/image/product/20141206/20141206152741_11293.jpg', 1420709749),
(698, 'product', '20141206152733_53126.jpg', '/Uploads/image/product/20141206/20141206152733_53126.jpg', 1420709749),
(697, 'product', '20141206152724_63044.jpg', '/Uploads/image/product/20141206/20141206152724_63044.jpg', 1420709749),
(696, 'product', '20141206152713_36081.jpg', '/Uploads/image/product/20141206/20141206152713_36081.jpg', 1420709749),
(695, 'product', '20141206152704_66939.jpg', '/Uploads/image/product/20141206/20141206152704_66939.jpg', 1420709749),
(552, 'product', '20141206134544_20903.jpg', '/Uploads/image/product/20141206/20141206134544_20903.jpg', 1418260703),
(551, 'product', '20141206134534_28844.jpg', '/Uploads/image/product/20141206/20141206134534_28844.jpg', 1418260703),
(550, 'product', '20141206134529_83399.jpg', '/Uploads/image/product/20141206/20141206134529_83399.jpg', 1418260703),
(549, 'product', '20141206134524_21755.jpg', '/Uploads/image/product/20141206/20141206134524_21755.jpg', 1418260703),
(548, 'product', '20141206134517_37496.jpg', '/Uploads/image/product/20141206/20141206134517_37496.jpg', 1418260703),
(722, 'product', '20141206162412_99428.jpg', '/Uploads/image/product/20141206/20141206162412_99428.jpg', 1420709890),
(721, 'product', '20141206162407_80628.jpg', '/Uploads/image/product/20141206/20141206162407_80628.jpg', 1420709890),
(691, 'product', '20141206150656_79779.jpg', '/Uploads/image/product/20141206/20141206150656_79779.jpg', 1420709641),
(690, 'product', '20141206150649_49355.jpg', '/Uploads/image/product/20141206/20141206150649_49355.jpg', 1420709641),
(700, 'product', '20141206140445_38028.jpg', '/Uploads/image/product/20141206/20141206140445_38028.jpg', 1420709765),
(701, 'product', '20141206140454_99522.jpg', '/Uploads/image/product/20141206/20141206140454_99522.jpg', 1420709765),
(702, 'product', '20141206140500_79002.jpg', '/Uploads/image/product/20141206/20141206140500_79002.jpg', 1420709765),
(703, 'product', '20141206140508_34697.jpg', '/Uploads/image/product/20141206/20141206140508_34697.jpg', 1420709765),
(704, 'product', '20141206140517_80908.jpg', '/Uploads/image/product/20141206/20141206140517_80908.jpg', 1420709765),
(689, 'product', '20141206150635_74838.jpg', '/Uploads/image/product/20141206/20141206150635_74838.jpg', 1420709641),
(688, 'product', '20141206150622_13663.jpg', '/Uploads/image/product/20141206/20141206150622_13663.jpg', 1420709641),
(687, 'product', '20141206150612_59792.jpg', '/Uploads/image/product/20141206/20141206150612_59792.jpg', 1420709641),
(686, 'product', '20141206144445_21447.jpg', '/Uploads/image/product/20141206/20141206144445_21447.jpg', 1420709626),
(709, 'product', '20141206142045_74124.jpg', '/Uploads/image/product/20141206/20141206142045_74124.jpg', 1420709778),
(708, 'product', '20141206142039_90601.jpg', '/Uploads/image/product/20141206/20141206142039_90601.jpg', 1420709778),
(707, 'product', '20141206142033_25768.jpg', '/Uploads/image/product/20141206/20141206142033_25768.jpg', 1420709778),
(706, 'product', '20141206142027_20206.jpg', '/Uploads/image/product/20141206/20141206142027_20206.jpg', 1420709778),
(670, 'product', '20141206143527_98239.jpg', '/Uploads/image/product/20141206/20141206143527_98239.jpg', 1420709587),
(671, 'product', '20141206143534_67161.jpg', '/Uploads/image/product/20141206/20141206143534_67161.jpg', 1420709587),
(672, 'product', '20141206143541_92674.jpg', '/Uploads/image/product/20141206/20141206143541_92674.jpg', 1420709587),
(673, 'product', '20141206143552_37185.jpg', '/Uploads/image/product/20141206/20141206143552_37185.jpg', 1420709587),
(674, 'product', '20141206143601_90581.jpg', '/Uploads/image/product/20141206/20141206143601_90581.jpg', 1420709587),
(675, 'product', '20141206143609_48122.jpg', '/Uploads/image/product/20141206/20141206143609_48122.jpg', 1420709587),
(681, 'product', '20141206143859_95643.jpg', '/Uploads/image/product/20141206/20141206143859_95643.jpg', 1420709598),
(680, 'product', '20141206143853_65395.jpg', '/Uploads/image/product/20141206/20141206143853_65395.jpg', 1420709598),
(679, 'product', '20141206143844_54165.jpg', '/Uploads/image/product/20141206/20141206143844_54165.jpg', 1420709598),
(678, 'product', '20141206143835_76497.jpg', '/Uploads/image/product/20141206/20141206143835_76497.jpg', 1420709598),
(677, 'product', '20141206143827_58218.jpg', '/Uploads/image/product/20141206/20141206143827_58218.jpg', 1420709598),
(676, 'product', '20141206143818_21884.jpg', '/Uploads/image/product/20141206/20141206143818_21884.jpg', 1420709598),
(682, 'product', '20141206144415_39783.jpg', '/Uploads/image/product/20141206/20141206144415_39783.jpg', 1420709626),
(683, 'product', '20141206144422_55980.jpg', '/Uploads/image/product/20141206/20141206144422_55980.jpg', 1420709626),
(684, 'product', '20141206144430_65003.jpg', '/Uploads/image/product/20141206/20141206144430_65003.jpg', 1420709626),
(685, 'product', '20141206144436_40176.jpg', '/Uploads/image/product/20141206/20141206144436_40176.jpg', 1420709626),
(779, 'product', '20150105232209_64580.png', '/Uploads/image/product/20150105/20150105232209_64580.png', 1420774529),
(746, 'product', '20141206170024_33933.jpg', '/Uploads/image/product/20141206/20141206170024_33933.jpg', 1420709991),
(747, 'product', '20141206170033_51119.jpg', '/Uploads/image/product/20141206/20141206170033_51119.jpg', 1420709991),
(748, 'product', '20141206170045_47183.jpg', '/Uploads/image/product/20141206/20141206170045_47183.jpg', 1420709991),
(749, 'product', '20141206170100_21565.jpg', '/Uploads/image/product/20141206/20141206170100_21565.jpg', 1420709991),
(754, 'product', '20141206171627_58735.jpg', '/Uploads/image/product/20141206/20141206171627_58735.jpg', 1420710048),
(753, 'product', '20141206171617_88099.jpg', '/Uploads/image/product/20141206/20141206171617_88099.jpg', 1420710048),
(752, 'product', '20141206171605_25551.jpg', '/Uploads/image/product/20141206/20141206171605_25551.jpg', 1420710048),
(751, 'product', '20141206171556_84775.jpg', '/Uploads/image/product/20141206/20141206171556_84775.jpg', 1420710048),
(750, 'product', '20141206171359_95009.jpg', '/Uploads/image/product/20141206/20141206171359_95009.jpg', 1420710048),
(755, 'product', '20141206172117_22145.jpg', '/Uploads/image/product/20141206/20141206172117_22145.jpg', 1420710086),
(756, 'product', '20141206172126_76816.jpg', '/Uploads/image/product/20141206/20141206172126_76816.jpg', 1420710086),
(757, 'product', '20141206172132_60767.jpg', '/Uploads/image/product/20141206/20141206172132_60767.jpg', 1420710086),
(758, 'product', '20141206172139_54294.jpg', '/Uploads/image/product/20141206/20141206172139_54294.jpg', 1420710086),
(759, 'product', '20141206172147_47122.jpg', '/Uploads/image/product/20141206/20141206172147_47122.jpg', 1420710086),
(760, 'product', '20141206172155_68417.jpg', '/Uploads/image/product/20141206/20141206172155_68417.jpg', 1420710086),
(439, 'product', '20141206173239_44840.jpg', '/Uploads/image/product/20141206/20141206173239_44840.jpg', 1417858826),
(438, 'product', '20141206173225_97176.jpg', '/Uploads/image/product/20141206/20141206173225_97176.jpg', 1417858826),
(437, 'product', '20141206173219_80968.jpg', '/Uploads/image/product/20141206/20141206173219_80968.jpg', 1417858826),
(436, 'product', '20141206173209_75956.jpg', '/Uploads/image/product/20141206/20141206173209_75956.jpg', 1417858826),
(435, 'product', '20141206173202_56958.jpg', '/Uploads/image/product/20141206/20141206173202_56958.jpg', 1417858826),
(434, 'product', '20141206173153_11977.jpg', '/Uploads/image/product/20141206/20141206173153_11977.jpg', 1417858826),
(761, 'product', '20141206175002_42297.jpg', '/Uploads/image/product/20141206/20141206175002_42297.jpg', 1420710183),
(762, 'product', '20141206175351_62857.jpg', '/Uploads/image/product/20141206/20141206175351_62857.jpg', 1420710215),
(763, 'product', '20141206175751_50564.jpg', '/Uploads/image/product/20141206/20141206175751_50564.jpg', 1420710240),
(768, 'product', '20141208090840_55008.jpg', '/Uploads/image/product/20141208/20141208090840_55008.jpg', 1420767191),
(765, 'product', '20141208091805_40110.jpg', '/Uploads/image/product/20141208/20141208091805_40110.jpg', 1420710299),
(645, 'product', '20141208102510_74866.jpg', '/Uploads/image/product/20141208/20141208102510_74866.jpg', 1420162939),
(627, 'product', '20141208103421_26300.jpg', '/Uploads/image/product/20141208/20141208103421_26300.jpg', 1419994256),
(628, 'product', '20141208103426_78367.jpg', '/Uploads/image/product/20141208/20141208103426_78367.jpg', 1419994256),
(629, 'product', '20141208103433_76634.jpg', '/Uploads/image/product/20141208/20141208103433_76634.jpg', 1419994256),
(630, 'product', '20141208103440_21321.jpg', '/Uploads/image/product/20141208/20141208103440_21321.jpg', 1419994256),
(786, 'product', '20141208104739_52915.jpg', '/Uploads/image/product/20141208/20141208104739_52915.jpg', 1420792145),
(787, 'product', '20141208104810_88667.jpg', '/Uploads/image/product/20141208/20141208104810_88667.jpg', 1420792145),
(788, 'product', '20141208104815_43362.jpg', '/Uploads/image/product/20141208/20141208104815_43362.jpg', 1420792145),
(789, 'product', '20141208104819_87475.jpg', '/Uploads/image/product/20141208/20141208104819_87475.jpg', 1420792145),
(790, 'product', '20141208104828_65958.jpg', '/Uploads/image/product/20141208/20141208104828_65958.jpg', 1420792145),
(791, 'product', '20141208104859_26677.jpg', '/Uploads/image/product/20141208/20141208104859_26677.jpg', 1420792157),
(792, 'product', '20141208104904_59985.jpg', '/Uploads/image/product/20141208/20141208104904_59985.jpg', 1420792157),
(793, 'product', '20141208104909_93682.jpg', '/Uploads/image/product/20141208/20141208104909_93682.jpg', 1420792157),
(794, 'product', '20141208104913_72976.jpg', '/Uploads/image/product/20141208/20141208104913_72976.jpg', 1420792157),
(795, 'product', '20141208104918_24713.jpg', '/Uploads/image/product/20141208/20141208104918_24713.jpg', 1420792157),
(796, 'product', '20141208104934_81548.jpg', '/Uploads/image/product/20141208/20141208104934_81548.jpg', 1420792168),
(797, 'product', '20141208104944_32376.jpg', '/Uploads/image/product/20141208/20141208104944_32376.jpg', 1420792168),
(798, 'product', '20141208104949_14965.jpg', '/Uploads/image/product/20141208/20141208104949_14965.jpg', 1420792168),
(799, 'product', '20141208104953_22680.jpg', '/Uploads/image/product/20141208/20141208104953_22680.jpg', 1420792168),
(800, 'product', '20141208104958_77719.jpg', '/Uploads/image/product/20141208/20141208104958_77719.jpg', 1420792168),
(547, 'product', '20141208110653_10557.jpg', '/Uploads/image/product/20141208/20141208110653_10557.jpg', 1418260684),
(504, 'product', '20141208111250_16069.jpg', '/Uploads/image/product/20141208/20141208111250_16069.jpg', 1418009313),
(583, 'product', '20141208111750_19209.jpg', '/Uploads/image/product/20141208/20141208111750_19209.jpg', 1418782431),
(506, 'product', '20141208113058_92721.jpg', '/Uploads/image/product/20141208/20141208113058_92721.jpg', 1418009567),
(514, 'product', '20141208113357_57949.jpg', '/Uploads/image/product/20141208/20141208113357_57949.jpg', 1418011702),
(517, 'news', '20141208150251_28863.jpg', '/Uploads/image/news/20141208/20141208150251_28863.jpg', 1418022711),
(631, 'product', '20141208103449_93877.jpg', '/Uploads/image/product/20141208/20141208103449_93877.jpg', 1419994256),
(776, 'product', '20141208160146_87382.jpg', '/Uploads/image/product/20141208/20141208160146_87382.jpg', 1420774379),
(611, 'product', '20141216122428_55288.jpg', '/Uploads/image/product/20141216/20141216122428_55288.jpg', 1419642509),
(610, 'product', '20141216122423_90815.jpg', '/Uploads/image/product/20141216/20141216122423_90815.jpg', 1419642509),
(609, 'product', '20141216122419_65686.jpg', '/Uploads/image/product/20141216/20141216122419_65686.jpg', 1419642509),
(608, 'product', '20141216122414_48413.jpg', '/Uploads/image/product/20141216/20141216122414_48413.jpg', 1419642509),
(607, 'product', '20141216122409_84830.jpg', '/Uploads/image/product/20141216/20141216122409_84830.jpg', 1419642509),
(570, 'product', '20141216122842_74443.jpg', '/Uploads/image/product/20141216/20141216122842_74443.jpg', 1418704184),
(571, 'product', '20141216122846_56183.jpg', '/Uploads/image/product/20141216/20141216122846_56183.jpg', 1418704184),
(572, 'product', '20141216122850_95594.jpg', '/Uploads/image/product/20141216/20141216122850_95594.jpg', 1418704184),
(573, 'product', '20141216141405_35029.jpg', '/Uploads/image/product/20141216/20141216141405_35029.jpg', 1418711197),
(574, 'product', '20141216141410_93226.jpg', '/Uploads/image/product/20141216/20141216141410_93226.jpg', 1418711197),
(575, 'product', '20141216141415_50954.jpg', '/Uploads/image/product/20141216/20141216141415_50954.jpg', 1418711197),
(576, 'product', '20141216143439_30019.jpg', '/Uploads/image/product/20141216/20141216143439_30019.jpg', 1418711760),
(577, 'product', '20141216143443_42162.jpg', '/Uploads/image/product/20141216/20141216143443_42162.jpg', 1418711760),
(578, 'product', '20141216143447_19928.jpg', '/Uploads/image/product/20141216/20141216143447_19928.jpg', 1418711760),
(579, 'product', '20141216143758_61586.jpg', '/Uploads/image/product/20141216/20141216143758_61586.jpg', 1418711941),
(580, 'product', '20141216143802_22126.jpg', '/Uploads/image/product/20141216/20141216143802_22126.jpg', 1418711941),
(581, 'product', '20141216143807_50814.jpg', '/Uploads/image/product/20141216/20141216143807_50814.jpg', 1418711941),
(582, 'product', '20141216143812_20780.jpg', '/Uploads/image/product/20141216/20141216143812_20780.jpg', 1418711941),
(584, 'news', '20141208150251_28863.jpg', '/Uploads/image/news/20141208/20141208150251_28863.jpg', 1418803166),
(585, 'news', '20141220143048_12650.jpg', '/Uploads/image/news/20141220/20141220143048_12650.jpg', 1419057098),
(586, 'news', '20141220143100_67024.jpg', '/Uploads/image/news/20141220/20141220143100_67024.jpg', 1419057098),
(587, 'product', '20141220164750_87596.jpg', '/Uploads/image/product/20141220/20141220164750_87596.jpg', 1419065353),
(588, 'product', '20141220164759_47543.jpg', '/Uploads/image/product/20141220/20141220164759_47543.jpg', 1419065353),
(589, 'product', '20141220164804_45315.jpg', '/Uploads/image/product/20141220/20141220164804_45315.jpg', 1419065353),
(590, 'product', '20141220164808_54239.jpg', '/Uploads/image/product/20141220/20141220164808_54239.jpg', 1419065353),
(591, 'product', '20141220165132_72380.jpg', '/Uploads/image/product/20141220/20141220165132_72380.jpg', 1419065556),
(592, 'product', '20141220165137_14617.jpg', '/Uploads/image/product/20141220/20141220165137_14617.jpg', 1419065556),
(593, 'product', '20141220165141_39503.jpg', '/Uploads/image/product/20141220/20141220165141_39503.jpg', 1419065556),
(621, 'product', '20141220165637_79647.jpg', '/Uploads/image/product/20141220/20141220165637_79647.jpg', 1419834115),
(620, 'product', '20141220165631_24790.jpg', '/Uploads/image/product/20141220/20141220165631_24790.jpg', 1419834115),
(619, 'product', '20141220165622_48012.jpg', '/Uploads/image/product/20141220/20141220165622_48012.jpg', 1419834115),
(618, 'product', '20141222164300_71993.jpg', '/Uploads/image/product/20141222/20141222164300_71993.jpg', 1419834105),
(617, 'product', '20141222164256_83460.jpg', '/Uploads/image/product/20141222/20141222164256_83460.jpg', 1419834105),
(616, 'product', '20141222164251_75140.jpg', '/Uploads/image/product/20141222/20141222164251_75140.jpg', 1419834105),
(769, 'product', '20141222164718_23507.jpg', '/Uploads/image/product/20141222/20141222164718_23507.jpg', 1420768892),
(770, 'product', '20141222164722_67807.jpg', '/Uploads/image/product/20141222/20141222164722_67807.jpg', 1420768892),
(771, 'product', '20141222164728_91309.jpg', '/Uploads/image/product/20141222/20141222164728_91309.jpg', 1420768892),
(644, 'product', '20141208102043_51050.jpg', '/Uploads/image/product/20141208/20141208102043_51050.jpg', 1420162939),
(780, 'product', '20141022085257_78359.jpg', '/Uploads/image/product/20141022/20141022085257_78359.jpg', 1420774529),
(705, 'product', '20141206142002_18852.jpg', '/Uploads/image/product/20141206/20141206142002_18852.jpg', 1420709778),
(801, 'news', '20150110100256_26476.jpg', '/Uploads/image/news/20150110/20150110100256_26476.jpg', 1420855527),
(802, 'news', '20150112140844_17308.jpg', '/Uploads/image/news/20150112/20150112140844_17308.jpg', 1421042999),
(803, 'news', '20150110100256_26476.jpg', '/Uploads/image/news/20150110/20150110100256_26476.jpg', 1421043047),
(804, 'news', '20150113112017_89153.jpg', '/Uploads/image/news/20150113/20150113112017_89153.jpg', 1421119279),
(805, 'news', '20150113112017_89153.jpg', '/Uploads/image/news/20150113/20150113112017_89153.jpg', 1421119313),
(806, 'news', '20150114110716_86404.jpg', '/Uploads/image/news/20150114/20150114110716_86404.jpg', 1421204907),
(807, 'news', '20150114110729_55425.jpg', '/Uploads/image/news/20150114/20150114110729_55425.jpg', 1421204907),
(808, 'news', '20150115103859_83495.jpg', '/Uploads/image/news/20150115/20150115103859_83495.jpg', 1421289596),
(809, 'news', '20150115103910_38407.jpg', '/Uploads/image/news/20150115/20150115103910_38407.jpg', 1421289596),
(810, 'product', '20150313090559_48501.jpg', '/Uploads/image/product/20150313/20150313090559_48501.jpg', 1426234682),
(811, 'product', '20150313090610_30267.jpg', '/Uploads/image/product/20150313/20150313090610_30267.jpg', 1426234682),
(812, 'product', '20150314072636_87118.jpg', '/Uploads/image/product/20150314/20150314072636_87118.jpg', 1426314405),
(813, 'product', '20150314073155_69353.jpg', '/Uploads/image/product/20150314/20150314073155_69353.jpg', 1426314717);

-- --------------------------------------------------------

--
-- 表的结构 `jkd_input`
--

CREATE TABLE IF NOT EXISTS `jkd_input` (
`id` int(11) NOT NULL COMMENT 'ID',
  `field_id` int(11) NOT NULL COMMENT '字段id',
  `is_show` tinyint(4) NOT NULL DEFAULT '0' COMMENT '表单域是否显示',
  `label` varchar(32) NOT NULL COMMENT '表单域标签',
  `remark` varchar(128) NOT NULL COMMENT '表单域域',
  `type` varchar(32) NOT NULL COMMENT '表单域类型',
  `width` int(11) NOT NULL DEFAULT '20' COMMENT '表单域宽度',
  `height` int(11) NOT NULL DEFAULT '8' COMMENT '表单域高度',
  `opt_value` text NOT NULL COMMENT '表单域可选值',
  `value` varchar(128) NOT NULL COMMENT '表单域默认值',
  `editor` varchar(32) NOT NULL COMMENT '编辑器类型',
  `html` text NOT NULL COMMENT '表单域html替换',
  `show_order` int(11) DEFAULT NULL COMMENT '表单域显示顺序',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='字段表单域信息';

-- --------------------------------------------------------

--
-- 表的结构 `jkd_kuaidi`
--

CREATE TABLE IF NOT EXISTS `jkd_kuaidi` (
`id` int(11) NOT NULL,
  `name` varchar(15) NOT NULL,
  `code` varchar(50) NOT NULL,
  `published` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `uname` varchar(30) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `jkd_kuaidi`
--

INSERT INTO `jkd_kuaidi` (`id`, `name`, `code`, `published`, `update_time`, `uname`) VALUES
(12, '顺丰快递', 'SF', 1419227933, 1420776128, '超级管理员'),
(11, '天天快递', 'tiantian', 1418787279, 1418787279, '超级管理员');

-- --------------------------------------------------------

--
-- 表的结构 `jkd_link`
--

CREATE TABLE IF NOT EXISTS `jkd_link` (
`id` int(11) NOT NULL,
  `title` varchar(32) NOT NULL,
  `display` int(1) NOT NULL,
  `link` varchar(255) NOT NULL,
  `sort` int(11) NOT NULL,
  `target` varchar(10) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `jkd_link`
--

INSERT INTO `jkd_link` (`id`, `title`, `display`, `link`, `sort`, `target`) VALUES
(1, '酒富网', 1, 'http://www.jiufu9.com', 1, '1');

-- --------------------------------------------------------

--
-- 表的结构 `jkd_log`
--

CREATE TABLE IF NOT EXISTS `jkd_log` (
`id` int(11) NOT NULL,
  `log_id` int(11) NOT NULL,
  `type` varchar(15) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `insert_time` int(11) NOT NULL DEFAULT '0',
  `nickname` varchar(30) NOT NULL DEFAULT '',
  `ip` char(16) NOT NULL DEFAULT '',
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `jkd_member`
--

CREATE TABLE IF NOT EXISTS `jkd_member` (
`uid` int(11) NOT NULL,
  `username` varchar(5) DEFAULT NULL COMMENT '真实姓名',
  `money` double(20,2) DEFAULT '0.00' COMMENT '消费总计',
  `email` varchar(100) DEFAULT NULL COMMENT '邮箱地址',
  `nickname` varchar(20) DEFAULT NULL COMMENT '用户昵称',
  `pwd` char(32) DEFAULT NULL COMMENT '密码',
  `reg_date` int(10) DEFAULT NULL COMMENT '注册时间',
  `reg_ip` char(15) DEFAULT NULL COMMENT '注册IP地址',
  `birthday_year` int(4) DEFAULT NULL COMMENT '生日年份',
  `birthday_month` int(2) DEFAULT NULL COMMENT '生日月份',
  `birthday_day` int(2) DEFAULT NULL COMMENT '生日日期',
  `set_pass_time` int(12) DEFAULT NULL COMMENT '密码修改时间',
  `pay_pass` varchar(32) DEFAULT NULL COMMENT '支付密码',
  `avatar_old` varchar(255) DEFAULT NULL COMMENT '头像原图',
  `avatar_32` varchar(255) DEFAULT NULL COMMENT '头像32*32',
  `marriage` int(1) DEFAULT NULL COMMENT '用户婚姻状态0，未。1，已。2，保密',
  `edu` int(1) DEFAULT NULL COMMENT '教育程度',
  `sex` int(1) DEFAULT NULL COMMENT '0女1男',
  `address` varchar(50) DEFAULT NULL COMMENT '地址',
  `industry` int(1) DEFAULT NULL COMMENT '所属行业',
  `income` int(1) DEFAULT NULL COMMENT '月均收入',
  `jiu` varchar(255) DEFAULT NULL COMMENT '个人介绍',
  `jiu_brand` text COMMENT '酒的品牌',
  `phone` char(15) DEFAULT NULL COMMENT '电话',
  `login_ip` varchar(15) DEFAULT NULL COMMENT '登录ip',
  `login_time` int(10) DEFAULT NULL COMMENT '登录时间',
  `last_login_time` int(12) DEFAULT NULL,
  `last_login_ip` varchar(16) DEFAULT NULL,
  `avatar_50` varchar(255) DEFAULT NULL COMMENT '头像50*50',
  `avatar_100` varchar(255) DEFAULT NULL COMMENT '头像100*100',
  `credit` int(20) DEFAULT '0' COMMENT '积分总计',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '0冻结  1 为启用',
  `ali_login_uid` varchar(18) NOT NULL COMMENT '支付宝登陆的ID',
  `qq_login_openid` char(32) NOT NULL COMMENT 'QQ登陆用户'
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='网站前台会员表';

--
-- 转存表中的数据 `jkd_member`
--

INSERT INTO `jkd_member` (`uid`, `username`, `money`, `email`, `nickname`, `pwd`, `reg_date`, `reg_ip`, `birthday_year`, `birthday_month`, `birthday_day`, `set_pass_time`, `pay_pass`, `avatar_old`, `avatar_32`, `marriage`, `edu`, `sex`, `address`, `industry`, `income`, `jiu`, `jiu_brand`, `phone`, `login_ip`, `login_time`, `last_login_time`, `last_login_ip`, `avatar_50`, `avatar_100`, `credit`, `status`, `ali_login_uid`, `qq_login_openid`) VALUES
(1, '花花花啊啊', 0.01, 'huakaiquan@qq.com', 'Heart', 'e8954dc6820fdfd09865b75742676881', 1413442834, '127.0.0.1', 2014, 1, 0, 1420614844, 'bf9aa6eaf39b82e37f58575dd63ff079', '/Uploads/avatar/php_source_20141110075046_76_MPY7XZC4.jpg', '/Uploads/avatar/php_avatar1_20141218135343_37_CKX46IXL.jpg', 0, 5, 0, NULL, 3, 3, '1,24,25,26', '48989987', '18516222423', '上海市-上海市', 1421303668, 1421306305, '上海市-上海市', '/Uploads/avatar/php_avatar1_20141218135343_37_087RI1VW.jpg', '/Uploads/avatar/php_avatar1_20141218135343_35_ALO72OGV.jpg', 0, 1, '2088802316537904', 'ABC7298A87F7E5FE7071DE2837AF648B'),
(4, NULL, 0.00, '416845137@qq.com', 'JFW_201410290337445', 'e8954dc6820fdfd09865b75742676881', 1414568264, '192.168.11.102', NULL, NULL, NULL, 1418193660, NULL, NULL, '/Uploads/avatar/php_avatar1_20141210144914_223_7TX5J2V3.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '上海市-上海市', 1418195693, 1418195691, '上海市-上海市', '/Uploads/avatar/php_avatar1_20141210144914_223_VGFLBJSZ.jpg', '/Uploads/avatar/php_avatar1_20141210144914_222_Y6LS7O0C.jpg', 0, 1, '0', ''),
(5, NULL, 0.00, 'huahua', 'JFW_201411150922506', '0', 1416014570, '127.0.0.1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0', ''),
(6, NULL, 0.00, 'souzl.com', 'JFW_201411150924285', 'e8954dc6820fdfd09865b75742676881', 1416014668, '127.0.0.1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0', ''),
(7, NULL, 0.00, 'service@souzl.com', 'JFW_201411150925529', 'e8954dc6820fdfd09865b75742676881', 1416014752, '127.0.0.1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0', ''),
(8, NULL, 0.00, '12012935@qq.com', 'JFW_201412040517423', 'ba68c1d542f3ef93be5ff71b4fdc78ff', 1417684662, '180.175.223.19', NULL, NULL, NULL, NULL, NULL, NULL, '/Uploads/avatar/php_avatar1_20141210162318_753_9RWY0S5C.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '未知省-未知市', 1419210203, 1418981335, '上海市-上海市', '/Uploads/avatar/php_avatar1_20141210162318_752_2CSNFXQV.jpg', '/Uploads/avatar/php_avatar1_20141210162318_738_6BAORC4G.jpg', 0, 1, '0', ''),
(9, '了', 0.00, '1020358873@qq.com', '了', '58fa97fb20c23bc5f24159149b16b632', 1417746800, '180.175.223.19', 1990, 1, 1, NULL, 'ba18048b8f9a428db4b23bb515ade518', NULL, '/Uploads/avatar/php_avatar1_20141210150027_306_YC5TGZGB.jpg', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, '上海市-上海市', 1421146305, 1421146340, '上海市-上海市', '/Uploads/avatar/php_avatar1_20141210150027_302_LU9XQKQG.jpg', '/Uploads/avatar/php_avatar1_20141210150027_301_G31H3SF8.jpg', 0, 1, '0', ''),
(11, '王', 0.00, '1765774435@qq.com', 'wang007', '0f2d84efc3db49912e412a2fee5f4d38', 1418004622, '180.175.250.50', NULL, NULL, NULL, 1418782074, '1b4e257c1cea440f56ffdf3be66da661', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '上海市-上海市', 1421303441, 1421302836, '上海市-上海市', NULL, NULL, 0, 1, '0', ''),
(23, NULL, 0.00, NULL, 'JFW_201412201712569', NULL, 1419066776, '182.131.19.96', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '四川省-成都市', 1419066773, NULL, NULL, NULL, NULL, 0, 1, '', 'E59C08BB025F4B1D584762D506CF2EC5'),
(13, NULL, 0.00, NULL, 'JFW_201412170120488', '58fa97fb20c23bc5f24159149b16b632', 1418793648, '180.175.223.19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '18521310002', NULL, NULL, 1418793669, '上海市-上海市', NULL, NULL, 0, 1, '0', ''),
(14, NULL, 0.00, NULL, 'JFW_201412181201187', 'e8954dc6820fdfd09865b75742676881', 1418875278, '180.175.105.0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '18017154565', '上海市-上海市', 1418878156, NULL, NULL, NULL, NULL, 0, 1, '0', ''),
(22, NULL, 0.00, NULL, 'JFW_201412191602576', NULL, 1418976177, '42.122.47.168', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '天津市-天津市', 1418976199, 1418976325, '天津市-天津市', NULL, NULL, 0, 1, '2088511051825222', ''),
(28, NULL, 0.00, NULL, 'JFW_201501030812575', NULL, 1420243977, '171.8.55.154', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '河南省-郑州市', 1420243977, NULL, NULL, NULL, NULL, 0, 1, '2088802189082736', ''),
(41, '问问', 0.00, '2422433962@qq.com', '问问', 'b75be325af454da8fe67139e56fa3c9e', 1421027045, '125.122.107.84', 2004, 6, 16, 1421027716, NULL, NULL, '/Uploads/avatar/php_avatar1_20150112094500_162_PB658BMD.jpg', 0, 2, 1, NULL, 2, 1, '1,24,25,208,207', '', NULL, '浙江省-杭州市', 1421027045, 1421028098, '浙江省-杭州市', '/Uploads/avatar/php_avatar1_20150112094500_161_R9DVB1KV.jpg', '/Uploads/avatar/php_avatar1_20150112094500_160_LIDIBRDW.jpg', 0, 1, '', '93867185D565C015FA7711B463A93037'),
(25, NULL, 0.00, NULL, 'JFW_201412221133418', NULL, 1419219221, '180.175.87.229', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '上海市-上海市', 1419219221, NULL, NULL, NULL, NULL, 0, 1, '', 'E9E1D3651985394C4F0C540277AC6E1C'),
(42, NULL, 0.00, NULL, 'JFW_201501121154256', 'f95f99fff2580e4cfaa15a7cd09d142f', 1421034865, '117.11.164.187', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '15822725993', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '', ''),
(27, NULL, 0.00, NULL, 'JFW_201412310907585', NULL, 1419988078, '180.213.131.220', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '天津市-天津市', 1421118499, 1420684104, '天津市-天津市', NULL, NULL, 0, 1, '', 'B4C28B696C97DA754855581057322C60'),
(29, '减肥的沙发', 0.00, NULL, 'JFW_201501052236198', 'ba18048b8f9a428db4b23bb515ade518', 1420468579, '180.175.156.130', 2001, 4, 18, 1420468744, NULL, NULL, '/Uploads/avatar/php_avatar1_20150105224646_441_GLF60VTK.jpg', 1, 1, 0, NULL, 17, 2, '1,24,25,26,207', '范德萨分的说法德萨范德萨法师大发生大幅&lt;script&gt;alert(&quot;fdsafdsf&quot;)&lt;/script&gt;', NULL, '未知省-未知市', 1420468868, 1420470682, '上海市-上海市', '/Uploads/avatar/php_avatar1_20150105224646_440_Q9WXPEP2.jpg', '/Uploads/avatar/php_avatar1_20150105224646_439_6U860JT0.jpg', 0, 1, '', 'FC0B9AB6B3DF182424E52BF7163D9918'),
(30, NULL, 0.00, '335112158@qq.com', 'JFW_201501051116139', '326f3b325f488e982b61fe06f9f7c0ea', 1420470973, '180.175.156.130', NULL, NULL, NULL, 1420471088, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '上海市-上海市', 1420471101, NULL, NULL, NULL, NULL, 0, 1, '', ''),
(32, NULL, 0.00, 'huahua@zecms.com', 'JFW_201501061149304', 'e8954dc6820fdfd09865b75742676881', 1420516170, '180.175.87.229', NULL, NULL, NULL, NULL, NULL, NULL, '/Uploads/avatar/php_avatar1_20150106155916_219_KGRIX7X9.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '上海市-上海市', 1420709177, 1420708875, '上海市-上海市', '/Uploads/avatar/php_avatar1_20150106155916_219_QL05V9E6.jpg', '/Uploads/avatar/php_avatar1_20150106155916_214_TXZVJZ0M.jpg', 0, 1, '', ''),
(33, NULL, 0.00, NULL, 'JFW_201501062324187', NULL, 1420557858, '60.55.11.30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 4, NULL, NULL, 4, 2, '1,24,25', 'fffff', NULL, '浙江省-宁波市', 1420557857, NULL, NULL, NULL, NULL, 0, 1, '', '7E7121CAC04194C6952F50A1C13FF4C4'),
(36, NULL, 0.00, NULL, 'JFW_201501081722235', NULL, 1420708943, '180.213.135.124', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '天津市-天津市', 1420708943, NULL, NULL, NULL, NULL, 0, 1, '2088202384597754', ''),
(34, NULL, 0.00, NULL, 'JFW_201501071659259', NULL, 1420621165, '180.175.87.229', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '上海市-上海市', 1420790378, 1420790422, '上海市-上海市', NULL, NULL, 0, 1, '', 'F8EEDEADA2CD3ADD9140AD9CC0485EB7'),
(35, NULL, 0.00, '401571918@qq.com', 'JFW_201501070733094', '97f9b9421e0b5398616ba5152700eb35', 1420630389, '180.175.87.229', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '上海市-上海市', 1421136132, 1420959888, '上海市-上海市', NULL, NULL, 0, 1, '', ''),
(43, NULL, 0.00, 'fcdcyy@sina.cn', 'JFW_201501130654019', '58fa97fb20c23bc5f24159149b16b632', 1421146441, '180.175.36.19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '上海市-上海市', 1421146457, NULL, NULL, NULL, NULL, 0, 1, '', ''),
(44, NULL, 0.00, '1637648177@qq.com', 'JFW_201501140848525', '708909d39da78ef5b0ab7a05064b4ece', 1421196532, '183.63.44.122', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '广东省-广州市', 1421196544, NULL, NULL, NULL, NULL, 0, 1, '', ''),
(45, NULL, 0.00, NULL, 'JFW_201501151015307', '3e84f26324233b6229bc78e59e9754f8', 1421288130, '180.213.95.42', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '13662157150', '天津市-天津市', 1421369880, 1421288152, '天津市-天津市', NULL, NULL, 0, 1, '', 'C054CD8B6A0A5A2023724594C65D2B3D');

-- --------------------------------------------------------

--
-- 表的结构 `jkd_member_address`
--

CREATE TABLE IF NOT EXISTS `jkd_member_address` (
`id` int(11) NOT NULL,
  `shen_cityname` varchar(50) DEFAULT NULL,
  `shi_cityname` varchar(50) DEFAULT NULL,
  `xian_cityname` varchar(50) DEFAULT NULL,
  `postcode` char(6) DEFAULT NULL,
  `address` text,
  `username` varchar(50) DEFAULT NULL,
  `phone` char(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '0',
  `uid` int(11) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `jkd_member_address`
--

INSERT INTO `jkd_member_address` (`id`, `shen_cityname`, `shi_cityname`, `xian_cityname`, `postcode`, `address`, `username`, `phone`, `status`, `uid`) VALUES
(24, '上海市', '上海市', '黄浦区', '312312', 'fdsafdsf范德萨范德萨分苏定方速度法师大是是法师大', '许国汭', '21312312332', 0, 29),
(21, '北京市', '北京市', '西城区', '123456', '57545', '华看来全', '18516222423', 1, 1),
(23, '天津市', '天津市', '东丽区', '300300', '李明庄', '刘善明', '13662157150', 0, 27),
(15, '上海市', '上海市', '嘉定区', '220000', '环城路2222号', '彭', '18651720719', 0, 8),
(16, '天津市', '天津市', '东丽区', '300300', '李明庄', '刘善明', '13662157150', 1, 10),
(17, '天津市', '天津市', '东丽区', '300300', '李明庄', '刘善明', '13662157150', 1, 12),
(18, '天津市', '天津市', '和平区', '888888', '上', '王', '13838384735', 0, 11),
(22, '天津市', '天津市', '东丽区', '300300', '李明庄', '刘善明', '13662157150', 0, 21),
(25, '山西省', '大同市', '矿区', '444304', '范德萨富士达 妃思傲芙132123123           ', '方法', '18521503123', 0, 29),
(26, '北京市', '北京市', '西城区', '123456', '花花', '花花', '18516222423', 1, 19),
(27, '北京市', '北京市', '东城区', '123456', '哈啊款了皇帝了哇', '花开全', '18516222423', 0, 19),
(28, '天津市', '天津市', '和平区', '121211', '1121', '我', '15345678901', 1, 11),
(29, '上海市', '上海市', '嘉定区', '123123', 'asdfsadasdffasdf', '工工', '15555555555', 0, 9),
(30, '上海市', '上海市', '黄浦区', '123123', '工五块石震天压下', '大规模', '15555555555', 1, 9),
(31, '浙江省', '杭州市', '江干区', '884597', '浙江省杭州市江干区秋涛北路327号', '九口袋', '15620552535', 0, 41);

-- --------------------------------------------------------

--
-- 表的结构 `jkd_message`
--

CREATE TABLE IF NOT EXISTS `jkd_message` (
`id` int(11) NOT NULL,
  `uid` int(11) NOT NULL COMMENT '用户的iD',
  `username` varchar(20) NOT NULL,
  `email` varchar(32) NOT NULL,
  `moblie` char(15) NOT NULL,
  `display` int(1) NOT NULL DEFAULT '0',
  `addtime` int(11) NOT NULL,
  `content` text NOT NULL,
  `address` varchar(255) NOT NULL,
  `t_content` text COMMENT '回复内容'
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `jkd_message`
--

INSERT INTO `jkd_message` (`id`, `uid`, `username`, `email`, `moblie`, `display`, `addtime`, `content`, `address`, `t_content`) VALUES
(1, 1, '花花', '188802862@qq.com', '18516222423', 0, 1415849836, '5', '4', NULL),
(2, 1, '花花', '188802862@qq.com', '18516222423', 0, 1415849847, '5', '4', '123456'),
(3, 1, '花花', '188802862@qq.com', '18516222423', 0, 1415850639, '5', '4', NULL),
(4, 1, '花花', '188802862@qq.com', '18516222423', 0, 1415850755, '5', '4', NULL),
(5, 29, '范德萨', '335112158@qq.com', '13621213435', 0, 1420470061, '&lt;script&gt;alert(&quot;fdsafdsf&quot;)&lt;/script&gt;', 'fdaffsdafdsa', NULL),
(6, 29, '范德萨', '335112158@qq.com', '13621213435', 0, 1420470357, '&lt;script&gt;alert(&quot;fdsafdsf&quot;)&lt;/script&gt;', 'fdaffsdafdsa', NULL),
(7, 19, '花花', '123456@qq.com', '18516222422', 0, 1420526857, '啊', '江苏', NULL),
(8, 41, '大声道', '2422433962@qq.com', '15620552535', 0, 1421027776, '111111111111', '浙江省江干区', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `jkd_model`
--

CREATE TABLE IF NOT EXISTS `jkd_model` (
`id` int(11) NOT NULL COMMENT 'ID',
  `name` varchar(32) NOT NULL COMMENT '模型名称',
  `tbl_name` varchar(32) NOT NULL COMMENT '数据表名称',
  `menu_name` varchar(32) NOT NULL COMMENT '菜单名称',
  `is_inner` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否为内部表',
  `has_pk` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否包含主键',
  `tbl_engine` varchar(16) NOT NULL DEFAULT 'InnoDB' COMMENT '引擎类型',
  `description` text NOT NULL COMMENT '模型描述',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='数据模型信息';

-- --------------------------------------------------------

--
-- 表的结构 `jkd_nav`
--

CREATE TABLE IF NOT EXISTS `jkd_nav` (
`id` mediumint(8) NOT NULL,
  `module` varchar(20) NOT NULL,
  `nav_name` varchar(255) NOT NULL,
  `parent_id` smallint(5) NOT NULL DEFAULT '0',
  `guide` int(11) NOT NULL,
  `type` varchar(10) NOT NULL,
  `link` varchar(225) NOT NULL,
  `lang` varchar(10) NOT NULL DEFAULT 'zh-cn' COMMENT '语言',
  `sort` tinyint(1) unsigned NOT NULL DEFAULT '50',
  `tag` varchar(50) DEFAULT NULL,
  `target` int(1) NOT NULL DEFAULT '0',
  `keywords` varchar(255) NOT NULL,
  `description` text,
  `title` varchar(255) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `jkd_nav`
--

INSERT INTO `jkd_nav` (`id`, `module`, `nav_name`, `parent_id`, `guide`, `type`, `link`, `lang`, `sort`, `tag`, `target`, `keywords`, `description`, `title`) VALUES
(1, 'product', '白酒', 9, 1, 'top', '/jiufuwang/index.php/product/index/cid/1', 'zh-cn', 1, 'shop', 0, '酒富网白酒', '酒富网白酒', '酒富网白酒'),
(3, 'product', '红酒', 9, 24, 'top', '/jiufuwang/index.php/product/index/cid/24', 'zh-cn', 3, 'shop', 0, '酒富网红酒', '酒富网红酒', '酒富网红酒'),
(4, 'product', '洋酒', 9, 25, 'middle', '/jiufuwang/index.php/product/index/cid/25', 'zh-cn', 4, 'shop', 0, '酒富网洋酒', '酒富网洋酒', '酒富网洋酒'),
(5, 'product', '其他', 9, 208, 'middle', '/jiufuwang/index.php/product/index/cid/26', 'zh-cn', 5, 'shop', 0, '酒富网', '酒富网', '酒富网'),
(6, 'link', '拍拍', 9, 0, 'middle', '', 'zh-cn', 7, 'paipai', 0, '拍拍', '拍拍', '拍拍'),
(7, 'link', '秒杀', 9, 0, 'top', '', 'zh-cn', 8, 'ms', 0, '秒杀', '秒杀秒杀', '秒杀'),
(8, 'link', '团购', 9, 0, 'top', '', 'zh-cn', 9, 'tuan', 0, '团购', '团购', '团购'),
(9, 'link', 'NAV头部导航', 0, 0, 'top', '', 'zh-cn', 0, 'nav', 0, 'NAV头部导航1', 'NAV头部导航', 'NAV头部导航1'),
(10, 'page', '帮助中心', 0, 1, 'bottom', '/index.php/page/index/name/%E5%B8%AE%E5%8A%A9%E4%B8%AD%E5%BF%83', 'zh-cn', 2, 'Help', 0, '帮助中心', '帮助中心', '帮助中心'),
(11, 'page', '新手指南', 10, 2, 'bottom', '/index.php/page/index/name/%E6%96%B0%E6%89%8B%E6%8C%87%E5%8D%97', 'zh-cn', 1, 'newbie', 0, '新手指南', '新手指南', '新手指南'),
(12, 'page', '购物流程', 11, 3, 'bottom', '/index.php/page/index/name/%E8%B4%AD%E7%89%A9%E6%B5%81%E7%A8%8B', 'zh-cn', 1, 'process', 1, '购物流程', '购物流程', '购物流程'),
(13, 'page', '会员介绍', 11, 4, 'bottom', '/index.php/page/index/name/%E6%96%B0%E6%89%8B%E6%8C%87%E5%8D%97', 'zh-cn', 2, 'userinfo', 0, '会员介绍', '会员介绍', '会员介绍'),
(14, 'page', '常见问题', 11, 5, 'bottom', '/index.php/page/index/name/%E5%B8%B8%E8%A7%81%E9%97%AE%E9%A2%98', 'zh-cn', 3, 'problems', 0, '常见问题', '常见问题', '常见问题'),
(15, 'page', '联系我们', 11, 6, 'bottom', '/index.php/page/index/name/%E8%81%94%E7%B3%BB%E6%88%91%E4%BB%AC', 'zh-cn', 4, 'aboutus', 0, '联系我们', '联系我们', '联系我们'),
(16, 'page', '关于我们', 11, 7, 'bottom', '/index.php/page/index/name/%E5%85%B3%E4%BA%8E%E6%88%91%E4%BB%AC', 'zh-cn', 5, 'about', 0, '关于我们', '关于我们', '关于我们'),
(17, 'page', '在线支付', 11, 8, 'bottom', '/index.php/page/index/name/%E5%9C%A8%E7%BA%BF%E6%94%AF%E4%BB%98', 'zh-cn', 6, 'onlinepay', 0, '在线支付', '在线支付', '在线支付'),
(18, 'page', '配送服务', 10, 9, 'bottom', '/index.php/page/index/name/%E5%B8%AE%E5%8A%A9%E4%B8%AD%E5%BF%83', 'zh-cn', 2, 'psservice', 0, '配送服务', '配送服务', '配送服务'),
(19, 'page', '配送时效及运费', 18, 10, 'bottom', '/index.php/page/index/name/%E9%85%8D%E9%80%81%E6%97%B6%E6%95%88%E5%8F%8A%E8%BF%90%E8%B4%B9', 'zh-cn', 1, 'pstime', 0, '配送时效及运费', '配送时效及运费', '配送时效及运费'),
(20, 'page', '验货与签收', 18, 11, 'bottom', '/index.php/page/index/name/%E9%AA%8C%E8%B4%A7%E4%B8%8E%E7%AD%BE%E6%94%B6', 'zh-cn', 2, 'receiving', 0, '验货与签收', '验货与签收', '验货与签收'),
(21, 'page', '配送信息跟踪', 18, 12, 'bottom', '/index.php/page/index/name/%E9%85%8D%E9%80%81%E4%BF%A1%E6%81%AF%E8%B7%9F%E8%B8%AA', 'zh-cn', 3, 'tracking', 0, '配送信息跟踪', '配送信息跟踪', '配送信息跟踪'),
(22, 'page', '账户及订单信息', 10, 13, 'bottom', '/index.php/page/index/name/%E8%B4%A6%E6%88%B7%E5%8F%8A%E8%AE%A2%E5%8D%95%E4%BF%A1%E6%81%AF', 'zh-cn', 3, 'orderinfo', 0, '账户及订单信息', '账户及订单信息', '账户及订单信息'),
(23, 'page', '我的酒富', 22, 14, 'bottom', '/index.php/page/index/name/%E6%88%91%E7%9A%84%E9%85%92%E5%AF%8C', 'zh-cn', 1, 'myjiufu', 0, '我的酒富', '我的酒富', '我的酒富'),
(24, 'page', '订单状态及修改订单', 22, 15, 'bottom', '/index.php/page/index/name/%E8%AE%A2%E5%8D%95%E7%8A%B6%E6%80%81%E5%8F%8A%E4%BF%AE%E6%94%B9%E8%AE%A2%E5%8D%95', 'zh-cn', 1, 'orderstatus', 0, '订单状态及修改订单', '订单状态及修改订单', '订单状态及修改订单'),
(25, 'page', '取消订单', 22, 16, 'bottom', '/index.php/page/index/name/%E5%8F%96%E6%B6%88%E8%AE%A2%E5%8D%95', 'zh-cn', 3, 'cancelorder', 0, '取消订单', '取消订单', '取消订单'),
(26, 'page', '忘记密码', 22, 17, 'bottom', '/index.php/page/index/name/%E5%BF%98%E8%AE%B0%E5%AF%86%E7%A0%81', 'zh-cn', 5, 'forgetpwd', 0, '忘记密码', '忘记密码', '忘记密码'),
(27, 'page', '售后服务', 10, 18, 'bottom', '/index.php/page/index/name/%E5%94%AE%E5%90%8E%E6%9C%8D%E5%8A%A1', 'zh-cn', 4, 'shservice', 0, '售后服务', '售后服务', '售后服务'),
(28, 'page', '退换货政策', 27, 19, 'bottom', '/index.php/page/index/name/%E9%80%80%E6%8D%A2%E8%B4%A7%E6%94%BF%E7%AD%96', 'zh-cn', 1, 'refundinfo', 0, '退换货政策', '退换货政策', '退换货政策'),
(29, 'page', '退换货网上办理', 27, 20, 'bottom', '/index.php/page/index/name/%E9%80%80%E6%8D%A2%E8%B4%A7%E7%BD%91%E4%B8%8A%E5%8A%9E%E7%90%86', 'zh-cn', 2, 'netrefund', 0, '退换货网上办理', '退换货网上办理', '退换货网上办理'),
(30, 'page', '发票说明', 27, 21, 'bottom', '/index.php/page/index/name/%E5%8F%91%E7%A5%A8%E8%AF%B4%E6%98%8E', 'zh-cn', 3, 'invoice', 0, '发票说明', '发票说明', '发票说明'),
(31, 'page', '会员计划及积分', 10, 22, 'bottom', '/index.php/page/index/name/%E4%BC%9A%E5%91%98%E8%AE%A1%E5%88%92%E5%8F%8A%E7%A7%AF%E5%88%86', 'zh-cn', 5, 'memberjs', 0, '会员计划及积分', '会员计划及积分', '会员计划及积分'),
(32, 'page', '积分说明', 31, 23, 'bottom', '/index.php/page/index/name/%E7%A7%AF%E5%88%86%E8%AF%B4%E6%98%8E', 'zh-cn', 1, 'creditinfo', 0, '积分说明', '积分说明', '积分说明'),
(33, 'news', '杂类信息', 0, 0, 'middle', '/index.php/news/index', 'zh-cn', 3, 'miscell', 0, '杂类信息', '杂类信息', '杂类信息'),
(34, 'news', '商场公告', 33, 205, 'middle', '/index.php/news/index/cid/202', 'zh-cn', 1, 'scgg', 0, '商场公告', '商场公告', '商场公告'),
(35, 'news', '促销信息', 33, 206, 'middle', '/index.php/news/index/cid/203', 'zh-cn', 2, 'cxxx', 0, '促销信息', '促销信息', '促销信息'),
(36, 'product', '礼品选酒', 9, 207, 'top', '/index.php/product/index/cid/207', 'zh-cn', 0, 'shop', 0, '礼品选酒', '礼品选酒', '礼品选酒'),
(37, 'page', '酒富网协议', 11, 24, 'bottom', '/page/index/name/%E9%85%92%E5%AF%8C%E7%BD%91%E5%8D%8F%E8%AE%AE', 'zh-cn', 7, 'jiufuxy', 0, '酒富网协议', '酒富网协议', '酒富网协议');

-- --------------------------------------------------------

--
-- 表的结构 `jkd_news`
--

CREATE TABLE IF NOT EXISTS `jkd_news` (
`id` mediumint(8) NOT NULL,
  `cid` smallint(3) DEFAULT NULL COMMENT '所在分类',
  `title` varchar(200) DEFAULT NULL COMMENT '新闻标题',
  `keywords` varchar(50) DEFAULT NULL COMMENT '文章关键字',
  `description` mediumtext COMMENT '文章描述',
  `status` tinyint(1) DEFAULT NULL,
  `summary` varchar(255) DEFAULT NULL COMMENT '文章摘要',
  `published` int(10) DEFAULT NULL,
  `update_time` int(10) DEFAULT NULL,
  `content` text,
  `click` int(11) NOT NULL DEFAULT '0',
  `aid` smallint(3) DEFAULT NULL COMMENT '发布者UID',
  `is_recommend` int(1) NOT NULL DEFAULT '0',
  `image_id` varchar(100) NOT NULL DEFAULT '0',
  `lang` varchar(5) NOT NULL DEFAULT 'zh-cn'
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='新闻表';

--
-- 转存表中的数据 `jkd_news`
--

INSERT INTO `jkd_news` (`id`, `cid`, `title`, `keywords`, `description`, `status`, `summary`, `published`, `update_time`, `content`, `click`, `aid`, `is_recommend`, `image_id`, `lang`) VALUES
(8, 205, '酒富网泸州陈坛老窖尚坛', '酒富网,泸州老窖,尚坛', '酒富网泸州老窖陈坛老窖尚坛', 1, '酒富网尚坛美酒，口感蜜香清柔、幽雅纯净、绵甜醇厚、回味怡畅，饮前不辛、不辣、不冲；饮中上口性好，口感、口味绝佳；饮后不上头，不干喉，不伤胃。', 1421119279, 1421119313, '<p class="MsoNormal" align="left" style="text-indent:24pt;">\n	<a href="http://www.jiufu9.com" target="_blank">酒富网</a>：中国的白酒作为世界六大蒸馏酒之一，具有悠久的历史。其中原浆酒在中国白酒千年的历史长河中可谓占着主导地位，随着历史不同时期的发展，上世纪原浆酒曾一度消失。但随着现代人们对白酒消费观念的改变，原浆酒再次被推出舞台有着重大的意义。<span></span> \n</p>\n<p class="MsoNormal" align="left" style="text-indent:24pt;">\n	夏、商时期，泸州为“梁州之域”，至周代则属“巴子之地”。正所谓“清酒之美，始于耒耜”，巴蜀出产“巴乡清”酒，曾是向周王朝交纳的贡品，江阳人尹吉甫在《诗经<span>-</span>大雅》中曾云：“显父浅之，清酒百壶。”而北魏地理学家、散文家郦道元在所撰地理名著《水经注》卷<span>33</span>《江水<span>(</span>一<span>)</span>》中记述江阳县时有云：“有巴人村，村人善酿，故俗称巴乡清，郡出名酒。”可见，巴乡清酒，无论从地域上，还是与泸州人尹吉甫的诗文记载。因此，尚坛的设计理念就来源于此，实木打造的外包装，表现着自然与原始古朴之美，瓶身以手工陶瓷制作，打造成化石般的造型，彰显出白酒如化石一般见证了中国几千年的文化历史，瓶身装有五斤的原浆酒，具有的口味纯正、酒质优良、营养丰富、健康时尚的特性，根本特点就不是新工艺白酒所能勾兑、调对出来的。并且原浆酒区别与新工艺白酒的最大特点是不伤身，对人体刺激小，从健康的角度上看饮用者在原浆酒中还能摄取到很多的营养成分。原浆酒重新被推出历史舞台，\n由于其重多的优势于一身，顺应了当代消费者的需求，必定会在<span>21</span>世纪的白酒市场上大放异彩，成为白酒走入健康时代的开拓者。<span></span> \n</p>\n<p class="MsoNormal" align="left" style="text-indent:24pt;">\n	酒富网尚坛美酒，口感蜜香清柔、幽雅纯净、绵甜醇厚、回味怡畅，饮前不辛、不辣、不冲；饮中上口性好，口感、口味绝佳；饮后不上头，不干喉，不伤胃。<span></span> \n</p>\n<p class="MsoNormal" align="left" style="text-indent:24pt;">\n	尚坛白酒可以说是最具有收藏价值的白酒之一，不仅因为原浆酒是中国历史最为悠久的白酒，经历了中国白酒是起源和发展，还源于独特的设计理念和艺术品一般的外观。但在上世纪<span>60</span>年代粮荒期间，由于原浆酒酿造工艺的复发性和高耗粮，逐渐被新工艺代替后，曾一度消失。进入<span>21</span>世纪原浆酒才重新得以发展，悠久的原浆酒文化和原浆酒稀缺性也正是白酒收藏的价值所在。<span></span> \n</p>\n众多的酒富网尚坛酒收藏者看重原浆酒文化和稀少性的同时，更是看到了酒富网尚坛白酒本身的价值和潜力，酒质上乘，口味甜美，健康营养，时尚可调制等特点都是尚坛白酒的优势，并且这个特点优势也正是未来白酒行业的发展走向，众多的特点决定了其升值的潜力，并且酒富网尚坛原浆酒本身的特点是时间越久，酒质越好，价格也随之提高，收藏酒富网尚坛就是在不断升值的一个过程。', 0, 1, 1, '805', 'zh-cn'),
(6, 205, '酒富网泸州陈坛老窖贡坛', '泸州老窖,陈坛老窖,贡坛,酒富网', '酒富网泸州陈坛老窖贡坛介绍', 1, '介绍酒富网泸州陈坛老窖贡坛美酒', 1420855527, 1421043047, '<p class="MsoNormal" style="text-indent:21.0pt;">\n	泸州酒的历史，与源远流长巴蜀酒文化密切相关。无论是黄河文明还是长江文明都是中华五千年文明的重要源头。而三星堆文化遗址的时间上限为<span>4800</span>年前，与众多巴蜀文化遗存相互印证，也为泸州老窖的发展历史寻到了直接的源头。另据学者研究，古代巴蜀盛行“撒满文化”，巫师以酒精性饮料使自己处于麻醉状态，以便与天神交接。从中，我们不难看出古代巴蜀酒文化的早熟、繁荣，以及特有风姿。<span></span> \n</p>\n<p class="MsoNormal" style="text-indent:21.0pt;">\n	巴蜀人酿酒，从来就是自成体系并富有建树。北魏的贾思勰《齐民要术•\n七•笨曲饼酒》记载了巴蜀人的酿酒方法：“蜀人做酴酒，十二月朝，取流水五斗，渍小麦曲两斤，密泥封，至正月二月冻释，发漉去滓，但取汁三斗，谷米三斗， 炊做饭，调强软合和，复密封数日，便热。合滓餐之，甘辛滑如甜酒味，不能醉人，人多啖温，温小暖而面热也。”\n这里的“酴酒”即醪糟酒<span>(</span>浊醪<span>)</span>。<span></span> \n</p>\n<p class="MsoNormal" style="text-indent:21.0pt;">\n	据史料记载，泸州，上古至秦朝时属于巴国。专家考证，巴人<span>(</span>包括泸州人<span>)</span>曾参加周武王伐纣，建立奇功，得到封赏。其中尹吉甫是辅佐周宣王的重臣。作为全球尹氏华人公认的先祖第一人尹吉甫，是《诗经》的作者之一，也是古江阳人。汉初毛公著《毛诗故训传》训释诗经及西汉扬雄<span>(</span>前<span>53</span>——后<span>18)</span>著《琴清音》时，对其均有所言载。据明嘉靖十三年甲午<span>(</span>一五三四年<span>)</span>雷洁撰《重修周卿士尹吉甫庙记》曰：尹吉甫者，江阳人。”中华书局<span>2002</span>年版《平遥古城志》第<span>248</span>页亦载：“尹吉甫<span>(</span>生淬年不详<span>)</span>，即兮伯吉父。兮氏，名甲，字伯吉父<span>(</span>一作甫<span>)</span>，尹是官名。古蜀国江阳<span>(</span>今四川省泸州市龙马潭区石洞镇<span>)</span>人矣”。<span></span> \n</p>\n<p class="MsoNormal" style="text-indent:21.0pt;">\n	夏、商时期，泸州为“梁州之域”，至周代则属“巴子之地”。正所谓“清酒之美，始于耒耜”，巴蜀出产“巴乡清”酒，曾是向周王朝交纳的贡品，江阳人尹吉甫在《诗经<span>-</span>大雅》中曾云：“显父浅之，清酒百壶。”而北魏地理学家、散文家郦道元在所撰地理名著《水经注》卷<span>33</span>《江水<span>(</span>一<span>)</span>》中记述江阳县时有云：“有巴人村，村人善酿，故俗称巴乡清，郡出名酒。”可见，巴乡清酒，无论从地域上，还是与泸州人尹吉甫的诗文记载。<span></span> \n</p>\n贡坛美酒，百年浓香精髓技艺，结合现代流行口感，致醇、致顺而不缺传递老窖纯厚品质，红色锦缎外包装，金属酒坛标志镶嵌于锦缎外，里面透明瓶身相得益彰，口感绵甜、久香，古时皇家之选，是朋友小聚、走亲访友、孝敬长辈的上佳之选。<a href="http://www.jiufu9.com/" target="_blank">http://www.jiufu9.com/</a>', 0, 1, 1, '803', 'zh-cn'),
(7, 205, '酒富网五粮液锦绣前程荣世', '酒富网,五粮液,荣世', '酒富网五粮液锦绣前程荣世介绍', 1, '酒富网荣世美酒以荣耀一世，锦绣前程的美好寓意，是您走亲访友，答谢领导，婚庆喜宴，孝敬老人的上佳之选。', 1421042999, NULL, '<p class="MsoNormal" align="left" style="text-indent:24pt;">\n	酒富网五粮液锦绣前程荣世的生产班组是从生产五粮液的班组里抽调精兵强将组成，五粮液酒厂调动了生产系统、产品研发系统等各大系统协作，此款酒可说是集大成者的上佳之选。<span></span>\n</p>\n<p class="MsoNormal" align="left" style="text-indent:24pt;">\n	酒，在中国源远流长文化历史的长河中，已不仅仅是一种客观的物质存在，而是一种文化象征，即酒神精神的象征。<span></span>\n</p>\n<p class="MsoNormal" align="left" style="text-indent:24pt;">\n	宜宾，自古以来就是一个多民族杂居的地区。聚居此地的各族人民依托世代承传的习俗和经验，曾经在不同的历史时期，酿制出了各具特色的历史美酒，有史可考的，诸如先秦时期僚人酿制的清酒、秦汉时期僰人酿制的蒟酱酒、三国时期鬏鬏苗人用野生小红果酿制的果酒等，都是当时宜宾地区少数民族的杰作，无不闪烁着古代中国人对酿酒技术的独到见解和聪明才智。<span></span>\n</p>\n<p class="MsoNormal" align="left" style="text-indent:24pt;">\n	在白酒文化营销上，五粮液可谓把文化营销诠释得淋漓尽致。中华民族传承了五千年的传统文化精髓，正是五粮液所体现的 “和谐”的品质，<span>"</span>五粮文化<span>"</span>自不用多言，是中国<span>5000</span>年农耕文化的代表，将中国酒文化和中华民族的大中华文化融会贯通，不能不让人产生无尽的遐想。<span></span>\n</p>\n<p class="MsoNormal" align="left" style="text-indent:24pt;">\n	酒富网五粮液锦绣前程荣世系列，系出名门，可以说是浓香型白酒的典范之作，实木打造的外包装，表现着自然与原始古朴之美，着色以中国红为主色调，象征热忱、奋进、团结的民族品格；瓶身打造成螺旋状造型，图案以凤凰扶摇直上，取其凤凰涅槃之意，荣世保持了“五粮液”原有的香味和风格，具有窖香浓郁、口味醇厚、入喉甘美、净爽的特点，为五粮液系列中的精品。\n</p>\n<p class="MsoNormal" align="left" style="text-indent:24pt;">\n	<span style="line-height:1.5;"><a href="http://www.jiufu9.com" target="_blank">酒富网</a>荣世美酒以荣耀一世，锦绣前程的美好寓意，是您走亲访友，答谢领导，婚庆喜宴，孝敬老人的上佳之选。</span>\n</p>', 0, 1, 1, '802', 'zh-cn'),
(9, 205, '酒富网泸州陈坛老窖福坛美酒', '酒富网,泸州老窖,福坛', '酒富网泸州陈坛老窖福坛美酒', 1, '酒富网陈坛老窖系列酒，产自四川泸州。2011年泸州老窖酒厂正式推出陈坛老窖系列，开始投放全国市场。', 1421204907, NULL, '<p class="MsoNormal" style="text-indent:36.0pt;">\n	<a href="http://www.jiufu9.com" target="_blank">酒富网</a>陈坛老窖系列酒，产自四川泸州。<span>2011</span>年泸州老窖酒厂正式推出陈坛老窖系列，开始投放全国市场，作为全国四大名酒之一泸州老窖（茅台，汾酒，西凤）旗下产品，陈坛老窖秉承了泸州老窖酒的香气幽雅，醇厚谐调，绵甜爽净，回味悠长，风格典雅独特的风格和传统，酒体丰满完美，自古浓香独秀，风华绝世，诚为天工开物，琼浆玉液，国色天香。此外与泸州老窖酒相比陈坛酒还有更加鲜明的独立个性：年代久远，窖藏时长。<span></span>\n</p>\n<p class="MsoNormal">\n	&nbsp;&nbsp; 酿造陈坛老窖的窖池位处四川泸州合江，这里山清水秀，位于四川盆地南缘。西面与江阳区、纳溪区、泸县相邻，东面与重庆市江津区接壤，北面与永川区接壤，南面与贵州省赤水市、习水县毗邻。合江县位于长江、赤水河、习水河交汇处，是长江出入川的第一县。陈坛窖池原名天富窖池，是泸州老窖十五大窖池之一。最早建于春秋时期，经战乱被毁，几经磨难后，于唐朝泸州本土人通过秘方重建（于合江出土的唐代史料记载）。天富窖池与其他<span>14</span>座窖池不同，是规模最小，窖井最深的一个。其酿造特色与女儿红相似，均需在地下埋藏数年之后方可酿成。由于其产量稀少，一直未能像其他产品一样大量的出现在市场上。直到<span>2010</span>年经过泸州老窖股份有限公司利用现代工艺大批量成产，才正式铺盖市场。<span></span>\n</p>\n&nbsp;&nbsp; 目前的酒富网，陈坛老窖系列品类正在逐渐增加，在完美的保留了古时酿造工艺带来的优质口感外，酒富网陈坛老窖还推出了适合不同消费者的酒种，其中陈坛老窖福坛就是其中之一。这款酒酒花纯净，酒香浓郁名并且还分为高度酒和低度酒两个品级供消费者筛选。在<span>2012</span>年，酒富电子商务有限公司正式与泸州老窖股份有限公司合作，共同设计了陈坛老窖福坛的外包装，并正式推向市场，有着精美绝伦的包装和优质浓香酒的陈坛老窖迅速的受到了广大消费者的喜爱，成为了一款经典的畅销白酒。是酒富网的一款主打商品。', 0, 1, 1, '806,807', 'zh-cn'),
(10, 205, '酒富网泸州陈坛老窖珍坛', '酒富网,泸州老窖,珍坛', '酒富网泸州陈坛老窖珍坛', 1, '酒富网泸州陈坛老窖珍坛美酒瓶身修长、晶莹剔透，包装精美、大气，适合宴请四方，或是送礼。是朋友小聚、走亲访友、孝敬长辈的上佳之选。', 1421289596, NULL, '<p class="MsoNormal" style="text-indent:24.0pt;">\n	<a href="http://www.jiufu9.com" target="_blank">酒富网</a>：泸州酒，西凤酒，汾酒，茅台酒是我国四大名酒。泸州地处巴蜀，泸州酒的历史，与源远流长巴蜀酒文化密切相关。无论是黄河文明还是长江文明都是中华五千年文明的重要源头。而三星堆文化遗址的时间上限为<span>4800</span>年前，与众多巴蜀文化遗存相互印证，也为泸州酒的发展历史寻到了直接的源头。另据学者研究，古代巴蜀盛行“萨满文化”，巫师以酒精性饮料使自己处于麻醉状态，以便与天神交接。从中，我们不难看出古代巴蜀酒文化的早熟、繁荣，以及特有风姿。<span></span>\n</p>\n<p class="MsoNormal" style="text-indent:24.0pt;">\n	泸州酒业，始于秦汉，兴于唐宋，盛于明清，发展在新中国，与之一脉相承的泸州老窖集团是响誉海内外的百年中华老字号名酒企业，是在明清<span>36</span>家古老酿酒作坊群的基础上，陈坛老窖发展起来的国有大型骨干酿酒集团。陈坛老窖以众多独特优势在中国酒业独树一帜。拥有我国建造最早（始建于公元<span>1573</span>年）、连续使用时间最长、保护最完整的<span>1573</span>国宝窖池群，<span>1996</span>年经国务院批准为行业首家全国重点文物保护单位，<span>2006</span>年被国家文物局列入“世界文化遗产预备名录”。<span></span>\n</p>\n<p class="MsoNormal" style="text-indent:24.0pt;">\n	酒富网陈坛老窖是泸州老窖集团针对中低端白酒市场重金打造，与高端品牌“国窖<span>1573</span>”、“泸州老窖”是同一原料、同一配方、同一工艺、同一生产线！但是窖藏相对较短，所以价格优惠，被广大群众所喜爱。经口味测试，陈坛老窖不但好喝，而且喝多了也不会有头疼等不舒服的感觉。<span></span>\n</p>\n<p class="MsoNormal" style="text-indent:24.0pt;">\n	酒富网珍坛美酒是陈坛老窖出品一款中端酒，口味纯正，口感蜜香清柔、幽雅纯净、绵甜醇厚、回味怡畅，饮前不辛、不辣、不冲；饮中上口性好，口感、口味绝佳；饮后不上头，不干喉，不伤胃。<span></span>\n</p>\n酒富网泸州陈坛老窖珍坛美酒瓶身修长、晶莹剔透，包装精美、大气，适合宴请四方，或是送礼。是朋友小聚、走亲访友、孝敬长辈的上佳之选。', 0, 1, 1, '808,809', 'zh-cn');

-- --------------------------------------------------------

--
-- 表的结构 `jkd_node`
--

CREATE TABLE IF NOT EXISTS `jkd_node` (
`id` smallint(6) unsigned NOT NULL,
  `name` varchar(20) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `remark` varchar(255) DEFAULT NULL,
  `sort` smallint(6) unsigned DEFAULT NULL,
  `pid` smallint(6) unsigned NOT NULL,
  `level` tinyint(1) unsigned NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=85 DEFAULT CHARSET=utf8 COMMENT='权限节点表';

--
-- 转存表中的数据 `jkd_node`
--

INSERT INTO `jkd_node` (`id`, `name`, `title`, `status`, `remark`, `sort`, `pid`, `level`) VALUES
(1, 'Admin', '后台管理', 1, '网站后台管理项目', 0, 0, 1),
(2, 'Index', '管理首页', 1, '', 1, 1, 2),
(3, 'Member', '注册会员管理', 1, '', 2, 1, 2),
(4, 'Webinfo', '系统管理', 1, '', 3, 1, 2),
(5, 'index', '默认页', 1, '', 5, 2, 3),
(6, 'myInfo', '我的个人信息', 1, '', 6, 2, 3),
(7, 'index', '会员首页', 1, '', 7, 3, 3),
(8, 'index', '管理员列表', 1, '', 8, 14, 3),
(9, 'addAdmin', '添加管理员', 1, '', 9, 14, 3),
(10, 'index', '系统设置首页', 1, '', 10, 4, 3),
(11, 'setEmailConfig', '设置系统邮件', 1, '', 12, 4, 3),
(12, 'testEmailConfig', '发送测试邮件', 1, '', 0, 4, 3),
(13, 'setSafeConfig', '系统安全设置', 1, '', 0, 4, 3),
(14, 'Access', '权限管理', 1, '权限管理，为系统后台管理员设置不同的权限', 0, 1, 2),
(15, 'nodeList', '查看节点', 1, '节点列表信息', 0, 14, 3),
(16, 'roleList', '角色列表查看', 1, '角色列表查看', 0, 14, 3),
(17, 'addRole', '添加角色', 1, '', 0, 14, 3),
(18, 'editRole', '编辑角色', 1, '', 0, 14, 3),
(19, 'opNodeStatus', '便捷开启禁用节点', 1, '', 0, 14, 3),
(20, 'opRoleStatus', '便捷开启禁用角色', 1, '', 0, 14, 3),
(21, 'editNode', '编辑节点', 1, '', 0, 14, 3),
(22, 'addNode', '添加节点', 1, '', 0, 14, 3),
(23, 'addAdmin', '添加管理员', 1, '', 0, 14, 3),
(24, 'editAdmin', '编辑管理员信息', 1, '', 0, 14, 3),
(25, 'changeRole', '权限分配', 1, '', 0, 14, 3),
(26, 'News', '资讯管理', 1, '', 0, 1, 2),
(27, 'index', '新闻列表', 1, '', 0, 26, 3),
(28, 'category', '新闻分类管理', 1, '', 0, 26, 3),
(29, 'add', '发布新闻', 1, '', 0, 26, 3),
(30, 'edit', '编辑新闻', 1, '', 0, 26, 3),
(31, 'del', '删除信息', 0, '', 0, 26, 3),
(32, 'SysData', '数据库管理', 1, '包含数据库备份、还原、打包等', 0, 1, 2),
(33, 'index', '查看数据库表结构信息', 1, '', 0, 32, 3),
(34, 'backup', '备份数据库', 1, '', 0, 32, 3),
(35, 'restore', '查看已备份SQL文件', 1, '', 0, 32, 3),
(36, 'restoreData', '执行数据库还原操作', 1, '', 0, 32, 3),
(37, 'delSqlFiles', '删除SQL文件', 1, '', 0, 32, 3),
(38, 'sendSql', '邮件发送SQL文件', 1, '', 0, 32, 3),
(39, 'zipSql', '打包SQL文件', 1, '', 0, 32, 3),
(40, 'zipList', '查看已打包SQL文件', 1, '', 0, 32, 3),
(41, 'unzipSqlfile', '解压缩ZIP文件', 1, '', 0, 32, 3),
(42, 'delZipFiles', '删除zip压缩文件', 1, '', 0, 32, 3),
(43, 'downFile', '下载备份的SQL,ZIP文件', 1, '', 0, 32, 3),
(44, 'repair', '数据库优化修复', 1, '', 0, 32, 3),
(46, 'Siteinfo', '网站功能', 1, '', 0, 1, 2),
(47, 'index', '菜单列表', 1, '', 0, 46, 3),
(48, 'add_nav', '添加/编辑菜单', 1, '', 0, 46, 3),
(49, 'adindex', '轮播列表', 1, '', 0, 46, 3),
(50, 'add_ad', '添加/编辑轮播', 1, '', 0, 46, 3),
(51, 'page', '单页列表', 1, '', 0, 46, 3),
(52, 'add_page', '添加/编辑单页', 1, '', 0, 46, 3),
(53, 'tag_index', '标签列表', 1, '', 0, 46, 3),
(54, 'add_tag', '添加/编辑标签', 1, '', 0, 46, 3),
(55, 'create_tag', '模版标签生成', 1, '', 0, 46, 3),
(56, 'file_index', '文件管理', 1, '', 0, 46, 3),
(57, 'link_index', '友情链接列表', 1, '', 0, 46, 3),
(58, 'add_link', '添加/编辑友情链接', 1, '', 0, 46, 3),
(59, 'message', '留言信息列表', 1, '', 0, 46, 3),
(60, 'Product', '产品管理', 1, '', 0, 1, 2),
(61, 'delpage', '删除单页', 1, '', 0, 46, 3),
(62, 'delad', '删除轮播', 1, '', 0, 46, 3),
(63, 'dellink', '删除友情链接', 1, '', 0, 46, 3),
(64, 'delmessage', '删除留言', 1, '', 0, 46, 3),
(65, 'deltag', '删除标签', 1, '', 0, 46, 3),
(66, 'selectCat', '文章分类', 1, '', 0, 46, 3),
(67, 'index', '产品列表', 1, '', 0, 60, 3),
(68, 'edit', '编辑产品', 1, '', 0, 60, 3),
(69, 'add', '添加产品', 1, '', 0, 60, 3),
(70, 'category', '分类列表', 1, '', 0, 60, 3),
(71, 'del', '删除产品', 1, '', 0, 60, 3),
(72, 'changeAttr', '快速推荐', 1, '', 0, 60, 3),
(73, 'changeStatus', '快速审核', 0, '', 0, 60, 3),
(74, 'changePhoneStatus', '手机推荐', 1, '', 0, 60, 3),
(75, 'checkProductTitle', '标题检查', 1, '', 0, 60, 3),
(76, 'changeAttr', '快速推荐', 1, '', 0, 26, 3),
(77, 'changeStatus', '快速审核', 1, '', 0, 26, 3),
(78, 'Models', '模型管理', 1, '', 0, 1, 2),
(79, 'index', '模型列表', 1, '', 0, 78, 3),
(80, 'add', '添加模型', 1, '', 0, 78, 3),
(83, 'orderEdit', '订单编辑', 1, '订单编辑', 11, 0, 3),
(84, 'deliveryEdit', '订单发货', 1, '订单发货', 12, 0, 3);

-- --------------------------------------------------------

--
-- 表的结构 `jkd_page`
--

CREATE TABLE IF NOT EXISTS `jkd_page` (
`id` mediumint(8) unsigned NOT NULL,
  `unique_id` varchar(30) NOT NULL DEFAULT '',
  `parent_id` smallint(5) NOT NULL DEFAULT '0',
  `page_name` varchar(150) NOT NULL DEFAULT '',
  `content` longtext NOT NULL,
  `display` int(1) NOT NULL DEFAULT '0',
  `keywords` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `lang` varchar(10) NOT NULL DEFAULT 'zh-cn',
  `image_id` varchar(255) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `jkd_page`
--

INSERT INTO `jkd_page` (`id`, `unique_id`, `parent_id`, `page_name`, `content`, `display`, `keywords`, `description`, `lang`, `image_id`) VALUES
(1, '帮助中心', 0, '帮助中心', '', 1, '', '', 'zh-cn', ''),
(2, '新手指南', 1, '新手指南', '', 1, '', '', 'zh-cn', ''),
(4, '会员介绍', 2, '会员介绍', '<p style="text-indent:2em;color:#666666;font-family:宋体;font-size:13px;">\n	欢迎您访问酒富网网站(www.jiufu.com) 的会员计划。本计划由酒富网（以下称为 "我们"）提供。以下计划条款和条件，连同与计划有关的任何促销内容的相应条款和条件，构成本计划会员与我们之间关于计划的完整协议。如果您参加计划，您就接受了这些条款、条件、限制和要求。请注意，您对酒富网网站的使用以及您的计划会员资格还受制于酒富网网站上时常更新的所有其它条款、条件、限制和要求。请仔细阅读这些条款和条件。\n</p>\n<div class="Shopping_Process" style="margin:0px;padding:0px;color:#666666;font-family:宋体;font-size:13px;">\n	<span>一</span><b>什么是"勋章"和"积分"？</b> \n</div>\n<span style="color:#666666;font-family:宋体;font-size:13px;line-height:22px;">会员级别是按照积分数目来判定的，积分数目越多，级别越高得到的特权也就越多。</span><br />\n<span style="color:#666666;font-family:宋体;font-size:13px;line-height:22px;">• 勋章：是会员在酒富网、社区的资深程度的表现，勋章是通过累计购物、发帖、互动获得的积分总数来决定；勋章分为4种：鲜花勋章、酒富勋章、酒王勋章、终身"蜂后"勋章。</span><br />\n<span style="color:#666666;font-family:宋体;font-size:13.3333339691162px;line-height:22px;background-color:#FFFFFF;">• 积分：是酒富积分的专属名称，是会员在酒富商城通过购物、评价商品、晒单等行为而获得的"钱"。</span><br />\n<br />\n<div class="Shopping_Process" style="margin:0px;padding:0px;color:#666666;font-family:宋体;font-size:13px;">\n	<span>二</span><b>如何获得"积分"？</b> \n</div>\n<span style="color:#666666;font-family:宋体;font-size:13px;line-height:22px;">会员每消费1元人民币获得1个积分</span><br />\n<br />\n<div class="Shopping_Process" style="margin:0px;padding:0px;color:#666666;font-family:宋体;font-size:13px;">\n	<span>三</span><b>"积分"特殊细则</b> \n</div>\n<span style="color:#666666;font-family:宋体;font-size:13px;line-height:22px;">• 不同的帐户中的积分不可合并使用；&nbsp;</span><br />\n<span style="color:#666666;font-family:宋体;font-size:13px;line-height:22px;">• 积分只用于个人用途而进行的购物及促销活动，不适用于团体购物、以营利或销售为目的的购买行为、其它非个人用途购买行为。&nbsp;</span><br />\n<span style="color:#666666;font-family:宋体;font-size:13px;line-height:22px;">• 会员积分计划及会员等级制度的最终解释权归酒富网所有</span>', 1, '', '', 'zh-cn', ''),
(5, '常见问题', 2, '常见问题', '<div class="ask" style="margin:0px;padding:20px;color:#333333;font-family:宋体;font-size:12px;">\n	<div class="rightbox fl" id="rightbox_helpcenterdetail" style="margin:0px;padding:0px;">\n		<div class="rightbox_firstrow" style="margin:0px;padding:0px;">\n			<div class="Shopping_Process" style="margin:0px 0px 5px;padding:0px;font-weight:bold;font-size:12px;background:#F3EEF2;">\n				<span>一</span><b>常见问题</b> \n			</div>\n			<p class="ask" style="margin-left:17px;color:#666666;">\n				如何在酒富网购物？\n			</p>\n			<p class="answer" style="background:#FAF8F8;">\n				<span style="color:#777777;"><b>酒富网为会员提供了网站下单、手机订购，会员可以采用利于自己方便的购物方式</b></span> \n			</p>\n			<p class="ask" style="margin-left:17px;color:#666666;">\n				为什么下完订单在账户里看不见？\n			</p>\n			<p class="answer" style="background:#FAF8F8;">\n				<span style="color:#777777;"><b>您好，一般此情况可能是您在酒富有多个账户，建议您核实一下当时下订单的具体账户，如有问题您可与我们电话客服（400-069-1573 ）、在线客服取得联系，帮您核查</b></span> \n			</p>\n			<p class="ask" style="margin-left:17px;color:#666666;">\n				积分是怎么使用的？\n			</p>\n			<p class="answer" style="background:#FAF8F8;">\n				<span style="color:#777777;"><b>您好，积分可以用来兑换积分换购专区的商品<br />\n积分商城专区：<a class="yellow" target="_blank" href="http://www.jiufu.com/user/userJifen.jsp">http://www.jiufu.com/user/userJifen.jsp</a></b>欢迎您使用</span> \n			</p>\n			<p class="ask" style="margin-left:17px;color:#666666;">\n				酒富网的商品都是正品吗？\n			</p>\n			<p class="answer" style="background:#FAF8F8;">\n				<span style="color:#777777;"><b>您好，酒富网的商品都是从正规渠道进货，并且进行严格把关，产品都是正品（100%保证是正品），可以放心选购</b></span> \n			</p>\n			<p class="ask" style="margin-left:17px;color:#666666;">\n				为什么之前我将产品加入购物车了，现在有没有了？\n			</p>\n			<p class="answer" style="background:#FAF8F8;">\n				<span style="color:#777777;"><b>您好，放入购物车里面的商品，账户不做永久保留，如您在本台电脑使用加入购物车，然后再去另一台电脑查看购物车的明细是没有的，所以建议可以把选中的商品放在收藏夹里，可更方便选购</b></span> \n			</p>\n			<p>\n				<br />\n			</p>\n			<div class="Shopping_Process" style="margin:0px 0px 5px;padding:0px;font-weight:bold;font-size:12px;background:#F3EEF2;">\n				<span>二</span><b>常见支付问题</b> \n			</div>\n			<p class="ask" style="margin-left:17px;color:#666666;">\n				进行网上在线支付前，银行卡需要办理开通手续吗？\n			</p>\n			<p class="answer" style="background:#FAF8F8;">\n				<span style="color:#777777;"><b>如您是第一次进行在线支付，建议事先拨打银行卡所属发卡银行的热线电话，详细咨询可在其网上进行在线支付的银行卡种类及相关开通手续</b></span> \n			</p>\n			<p class="ask" style="margin-left:17px;color:#666666;">\n				订购后如何付款呢？\n			</p>\n			<p class="answer" style="background:#FAF8F8;">\n				<span style="color:#777777;"><b>您好，我们为您提供在线支付、货到付款（POS机刷卡）、银行汇款、礼品卡支付。酒富网支持绝大多数银行借记卡及信用卡在线支付，即时到帐，准确快捷，推荐您使用！</b></span> \n			</p>\n			<p class="ask" style="margin-left:17px;color:#666666;">\n				我已经支付订单了，但是你们系统还是显示我没有支付订单，怎么回事？\n			</p>\n			<p class="answer" style="background:#FAF8F8;">\n				<span style="color:#777777;"><b>您好，此情况一般是第三方支付平台未及时调取您的支付成功信息，如果您是支付宝支付，需要您提供16位交易号或者是支付订单的准确时间和金额，再与我们酒富网客服取得联系，会帮您及时处理。如果您是汇款的情况，建议您耐心等待，汇款的方式到账时间较长，收款时间一般为汇款出后的3-5个工作日内，您可以向我们客服提供汇款金额、汇款时间、汇款人姓名、订单号，帮您核实款向是否到账，如果已经到账即可发货</b></span> \n			</p>\n			<p class="ask" style="margin-left:17px;color:#666666;">\n				为什么我选择不了"货到付款"？\n			</p>\n			<p class="answer" style="background:#FAF8F8;">\n				<span style="color:#777777;"><b>出现这种情况，很可能是因为您的收货地址不在我们货到付款的配送范围内，采取不了货到付款这种支付方式，您可以选择在线支付哦！</b></span> \n			</p>\n			<p class="ask" style="margin-left:17px;color:#666666;">\n				收到快递送到货品后能现场刷卡或部分签收吗？\n			</p>\n			<p class="answer" style="background:#FAF8F8;">\n				<span style="color:#777777;"><b>酒富网目前合作的物流商部分城市提供货到POS机刷卡服务，如果您的订单收货地址支持"货到POS刷卡"请您在提交订单时直接选择即可。另目前酒富网暂未开通部分签收，如收货时有遇到问题，可以及时反馈我们客服帮您处理，感谢您的配合！</b></span> \n			</p>\n			<p>\n				<br />\n			</p>\n			<div class="Shopping_Process" style="margin:0px 0px 5px;padding:0px;font-weight:bold;font-size:12px;background:#F3EEF2;">\n				<span>三</span><b>常见配送问题</b> \n			</div>\n			<p class="ask" style="margin-left:17px;color:#666666;">\n				我购买的商品不到100元，如何收取运费？\n			</p>\n			<p class="answer" style="background:#FAF8F8;">\n				<span style="color:#777777;"><b>运费收取的标准，请查阅&nbsp;<a class="yellow" href="http://www.lefeng.com/help/s_sy.html">配送服务介绍</a></b></span> \n			</p>\n			<p class="ask" style="margin-left:17px;color:#666666;">\n				我的订单什么时候能到货呢？\n			</p>\n			<p class="answer" style="background:#FAF8F8;">\n				<span style="color:#777777;"><b>根据客户不同的区域的地址，送货的时间长短不一致，如果您的订单已经超出网站配送时间，建议您拨打400-000-1818 与客服联系，帮您安排尽快送货，如在正常范围内，请您耐心等待</b></span> \n			</p>\n			<p class="ask" style="margin-left:17px;color:#666666;">\n				收货时可以先验货再签收吗？\n			</p>\n			<p class="answer" style="background:#FAF8F8;">\n				<span style="color:#777777;"><b>当您在收到有酒富网标识的货物包装后，请当场开箱验货，在与随货订单明细核对确认无误后，再签收具体请查阅了解&nbsp;<a class="yellow" href="http://www.lefeng.com/help/s3.html">收货及验货</a></b></span> \n			</p>\n			<p class="ask" style="margin-left:17px;color:#666666;">\n				收货时发现问题可以拒收吗？\n			</p>\n			<p class="answer" style="background:#FAF8F8;">\n				<span style="color:#777777;"><b>在签收货物时如发现货物有损坏，请与我司客服联系可申请拒收退回我公司</b></span> \n			</p>\n			<p class="ask" style="margin-left:17px;color:#666666;">\n				为什么我的订单金额是99.9元，快递收费的时候收取了我100元？\n			</p>\n			<p class="answer" style="background:#FAF8F8;">\n				<span style="color:#777777;"><b>一般快递人员在送货时，由于零钱不足，订单的金额会四舍五入，所以收了您100元，如遇到此事建议您可以反馈给酒富网客服帮您处理，非常抱歉给您带来的不便</b></span> \n			</p>\n			<p>\n				<br />\n			</p>\n			<div class="Shopping_Process" style="margin:0px 0px 5px;padding:0px;font-weight:bold;font-size:12px;background:#F3EEF2;">\n				<span style="background:url(file://192.168.11.227/jiufu/%E5%B8%AE%E5%8A%A9%E4%B8%AD%E5%BF%83/Help/gwlc_title_bg.jpg) 50% 0% no-repeat;">四</span><b>常见售后问题</b> \n			</div>\n			<p class="ask" style="margin-left:17px;color:#666666;">\n				为什么产品没有塑封，没有包装之类，产品像被使用过？\n			</p>\n			<p class="answer" style="background:#FAF8F8;">\n				<span style="color:#777777;"><b>化妆品大部分都是没有塑封包装，这一般是根每个品牌的环保政策有关。许多牌子由于不想浪费资源，崇尚环保，因此其在专柜出售的所有货物，不论是正式装，还是小样中样，都一律没有盒子，或者没有塑封的，酒富网的所有产品都是从正规渠道进货，所有包装是根据厂家所提供的，所以请您放心使用</b><br />\n<b><strong>特别说明：</strong>&nbsp;产品的包装有时与网站不同，是因为厂家会在没有任何提前通知的情况下更改产品包装、产地或者一些附件，酒富不能确保客户收到的货物与酒富图片、产地、附件说明完全一致。另有部分的产品因厂家换新包装，会造成网站销售的产品新老包装交替，如有疑问可以与客服联系，取得确认</b></span> \n			</p>\n			<p class="ask" style="margin-left:17px;color:#666666;">\n				为什么没收到网页上标注的赠品，或是收到的赠品和网页标志的不一样？\n			</p>\n			<p class="answer" style="background:#FAF8F8;">\n				<span style="color:#777777;"><b>促销活动的赠品都是数量有限的，为了让活动继续，我们临时会调整赠品满足用户，所以可能您收到的商品与宣传页 上面不一致</b></span> \n			</p>\n			<p>\n				<br />\n			</p>\n		</div>\n	</div>\n</div>', 1, '', '', 'zh-cn', ''),
(3, '购物流程', 2, '购物流程', '<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<img width="678" height="651" src="/Public/Home/images/help/gwlc_03.jpg" alt="" /> \n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<br />\n</p>\n<div class="Shopping_Process" style="margin:0px;padding:0px;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	二<b>如何注册会员</b> \n</div>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<br />\n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<strong>1. 在酒富网首页上方点击"免费注册"进入注册页面</strong> \n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<img width="678" height="150" src="/Public/Home/images/help/gwlc_06.jpg" alt="" /> \n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<br />\n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<strong>2. 可使用邮箱或者手机注册</strong> \n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	邮箱注册：根据提示填写邮箱、密码、确认密码、验证码\n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<img width="678" height="439" src="/Public/Home/images/help/gwlc_12.jpg" alt="" /> \n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<br />\n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	手机注册：先填写手机、密码、确认密码，然后点击"获取短信验证码"按钮，我们会发送手机短信验证码到您的手机\n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<img width="678" height="439" src="/Public/Home/images/help/gwlc_09.jpg" alt="" /> \n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<br />\n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<strong>3. 请您仔细阅读《酒富网用户协议》，同意后点击"同意协议并注册"按钮完成注册</strong> \n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<span style="color:#F52648;">注：请在注册后完善个人资料</span> \n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<br />\n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<strong>4. 注册会员后如忘记密码了，可按照以下方式找回密码</strong> \n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	在登录页面，点击"忘记密码"，将自动跳转到"找回密码"页面\n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<img width="440" height="393" src="/Public/Home/images/help/gwlc_14.jpg" alt="" /> \n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<br />\n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	填写账号（可为用户名、注册邮箱或者注册手机）、验证码，点击"下一步"\n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<img width="656" height="268" src="/Public/Home/images/help/gwlc_16.jpg" alt="" /> \n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<br />\n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	使用邮箱找回密码：系统会给您的邮箱发送一份验证邮件，点击邮件中重置密码链接，即可重新设置密码\n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	重新设置密码页面\n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<img width="654" height="275" src="/Public/Home/images/help/gwlc_25.jpg" alt="" /> \n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<br />\n</p>\n<div class="Shopping_Process" style="margin:0px;padding:0px;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	三<b>查找商品</b> \n</div>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<br />\n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<strong>1. 您可以通过在首页输入关键字的方法来搜索您想要购买的商品</strong> \n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<img width="90%" height="90%" src="/Public/Home/images/help/bzzx01.jpg" alt="" /> \n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<br />\n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<strong>2. 您还可以通过酒富网的分类导航来找到您想要购买的商品分类，选购商品</strong> \n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<img width="90%" height="90%" src="/Public/Home/images/help/bzzx02.jpg" alt="" /> \n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<br />\n</p>\n<div class="Shopping_Process" style="margin:0px;padding:0px;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	四<b>如何提交订单</b> \n</div>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<br />\n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<strong>1. 放入购物车</strong> \n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<strong>在您想要购买的商品详情页点击"加入购物车"，商品会添加到您的购物车中，您还可以继续挑选商品放入购物车，一起结算：</strong> \n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	A. 在购物车中，可更改商品数量\n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	B. 在购物车中，您可以将商品移至收藏，或是选择删除\n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	C. 在购物车中，您可以直接查看到购买这些正常商品后享受的活动（如赠品，对应花粉）和参加促销活动的商品名称、促销主题（如加价购，买满赠等活动）\n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	D. 商品价格会不定期调整，最终价格以您提交订单后订单中的价格为准\n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	E. 优惠政策、配送时间、运费收取标准等都有可能进行调整，最终成交信息以您提交订单时网站公布的最新信息为准\n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	F. 放入购物车里面的商品，账户不做永久保留，如您在本台电脑将商品加入购物车，然后再去另一台电脑查看购物车的明细是没有的，所以建议可以把选中的商品放在收藏夹里，可更方便选购\n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<strong>核实自己所订购的商品与赠品是否有误，确认后点击"确认结算"</strong> \n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<strong>填写收货地址信息：</strong> \n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	A. 请填写正确完整的收货人姓名、收货人联系方式、详细的收货地址和邮编，否则将会影响您订单的处理或配送\n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	B. 您可以进入"我的蜂巢—账户管理—收货地址管理"编辑常用收货地址，保存成功后，再订购时，可以直接选择使用\n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<br />\n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<strong>2. 选择支付方式</strong> \n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	酒富网提供多种支付方式，订购过程中您可以选择：\n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<img width="90%" height="90%" src="/Public/Home/images/help/bzzx03.jpg" alt="" /> \n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<br />\n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<strong>3. 选择快递配送时间</strong> \n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<img width="100%" height="100%" src="/Public/Home/images/help/bzzx04.jpg" alt="" /> \n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<br />\n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<strong>4. 确认商品清单</strong> \n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<img width="90%" height="90%" src="/Public/Home/images/help/bzzx05.jpg" alt="" /> \n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<br />\n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<strong>5. 酒富网默认为您开具发票抬头：个人，发票内容：化妆品，您可以根据网页提示更改所需发票信息，发票将与订单货物一起送达，酒富网不能开具增值税发票</strong> \n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<img width="100%" height="100%" src="/Public/Home/images/help/bzzx06.jpg" alt="" /> \n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<br />\n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<strong>6. 以上信息核实无误后，请点击"确认订单"，系统自动生成一个订单号，就说明您已经成功提交订单</strong> \n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<img width="100%" height="100%" src="/Public/Home/images/help/bzzx08.jpg" alt="" /> \n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<br />\n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<strong>7.若您帐户中有酒富贵宾卡/礼品卡，先选择"在线支付"，再"使用礼品卡支付"</strong> \n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<img width="100%" height="100%" src="/Public/Home/images/help/bzzx07.jpg" alt="" /> \n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<br />\n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<strong>8.如果您在酒富网有多个账户，我们建议您从始至终选择一个账户进行订购，这样不影响您的会员级别及花粉的累计，同时也不会造成您下订单后不知道在哪个账户里查找订单</strong> \n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<br />\n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<strong>9.如订单支付后长时间未看到订单支付成功，一般是因为支付平台有时会超时，建议您耐心等待或与我们客服联系，提供您支付时提交的信息，我们会及时帮您办理</strong> \n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<br />\n</p>\n<div class="Shopping_Process" style="margin:0px;padding:0px;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	五<b>如何查看订单状态</b> \n</div>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<br />\n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<strong>1. 如何查找订单</strong> \n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	登录酒富网，在"我的订单"中查询、修改、支付、取消订单\n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<img width="95%" height="95%" src="/Public/Home/images/help/bzzx09.jpg" alt="" /> \n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<br />\n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<strong>2. 查看订单状态</strong> \n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<img width="95%" height="95%" src="/Public/Home/images/help/bzzx10.jpg" alt="" /> \n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<br />\n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<strong>3. 查看订单配送状态</strong> \n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	当您订单订购成功后，一定是想了解发货的状态，那如何查询呢？\n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	可以通过以下操作查询到订单的配送状态信息：\n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<span style="color:#C29721;">登录酒富网——我的订单——查询到需要跟踪的订单号——点击"查看"——订单跟踪</span> \n</p>\n<p style="text-indent:2em;color:#666666;font-family:宋体;background-color:#FFFFFF;">\n	<img width="690" height="100" src="http://img6.imglefeng.com/images/zt/201409/gwlc_58.jpg" alt="" /> \n</p>', 1, '', '', 'zh-cn', ''),
(6, '联系我们', 2, '联系我们', '<div class="__kindeditor_paste__">\n	<p style="color:#333333;font-family:宋体;font-size:12px;">\n		<span style="color:#777777;"><strong>售后服务热线：</strong></span> \n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		<span style="color:#777777;">400-069-1573</span> \n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		<span style="color:#777777;">服务时间： 7*24小时</span> \n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		<br />\n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;">\n		<span style="color:#777777;"><strong>邮箱服务：</strong></span> \n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		<span style="color:#777777;">CEO邮箱：&nbsp;<a href="mailto:jiufu@sina.com">jiufu@sina.com</a></span> \n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		<span style="color:#777777;">客服邮箱：<a href="mailto:jiufu@sina.com">jiufu@sina.com</a></span> \n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		<span style="color:#777777;">客服邮箱：<a href="mailto:852960935@qq.com">852960935@qq.com</a></span> \n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		<span style="color:#777777;">服务时间： 周一至周日9:00~18:00，特殊节假日的服务时间将另行通知</span> \n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		<br />\n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;">\n		<span style="color:#777777;"><strong>在线客服：</strong></span> \n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		<span style="color:#777777;">在酒富网首页右下方点击"在线客服"图标进行联系</span> \n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		<span style="color:#777777;">服务时间： 7*24小时</span> \n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		<br />\n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;">\n		<span style="color:#777777;"><strong>微博联系：</strong></span> \n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		<span style="color:#777777;">新老用户可以在新浪微博上@ 或私信ID为"酒富网客服中心"的微博用户</span> \n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		<br />\n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;">\n		<span style="color:#777777;"><strong>微信联系：</strong></span> \n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		<span style="color:#777777;">新老用户可以通过微信添加酒富网官方微信号 "jiufu" 进行联系</span> \n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		<br />\n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;">\n		<span style="color:#777777;"><strong>客服传真：</strong></span> \n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		<span style="color:#777777;">021-22253232</span> \n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		<br />\n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;">\n		<span style="color:#777777;"><strong>邮寄信息：</strong></span> \n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		<span style="color:#777777;">邮件地址：上海市嘉定区（注：此地址不接受退换货）</span> \n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		<span style="color:#777777;">邮政编码：201824</span> \n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		<span style="color:#777777;">邮局规定，发出后将无法修改地址</span> \n	</p>\n</div>', 1, '', '', 'zh-cn', ''),
(7, '关于我们', 2, '关于我们', '<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	酒富网全称酒富（北京）电子商务有限公司，是国内著名的从事酒类销售的电子商务综合服务平台主要经营国内知名白酒品牌，国际知名洋酒品牌以及国内外优秀的葡萄酒品牌等各种酒类产品的线上零售，并通过综合型电子商务经营多种酒类，包括：啤酒、白酒、洋酒、葡萄酒等。为顾客提供最优质的商品，最合适的价格，最便捷的购物方式。\n</p>\n<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	&nbsp;\n</p>\n<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	　　酒富网电子商务有限公司的总部位于北京，在天津、上海、郑州等各地都有分公司和货运及库储中心。公司通过经营现代化网络商务平台对全部类别的酒品进行全国统一销售，除了优秀的线上销售之外，酒富网还逐渐的整合了线下的销售资源，为国内乃至国际的各大知名酒类生产厂家提供了网络营销方面的综合服务，酒富网与国内100多家酒类企业以及国外的酒类企业建立了深度合作伙伴关系。实现了垂直化销售，省去中间成本并真正的让利于消费者。\n</p>\n<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	&nbsp;\n</p>\n<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	　　酒富网总部位于北京，在天津、郑州等地拥有运营中心，并在天津建立库房，集中发货。公司借助现代电子商务平台进行全品类酒类的销售服务，除了做好酒类线上零售外，我们还会做一些线下品牌酒类展销活动及品牌店。\n</p>\n<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	&nbsp;\n</p>\n<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	　　酒富网是随着电子商务时代的到来应运而生的，网购已是人们不可缺少的选择了，但是我国现在的酒类销售网站并不是很多，这样给顾客购买酒水产生了很大的麻烦，如果选择去超市或者商店的话，可以选择的品牌和种类都很少。为了解决广大顾客的选择局限性及性价比而成立的网站，酒富网尽最大的努力，让您的购买更方便快捷。\n</p>\n<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	&nbsp;\n</p>\n<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	　　酒富网严格遵循“货真价实，全优服务”的经营理念，真正实现了让利于消费者，为广大消费者提供保证真品、优秀品牌、高速物流、零破损的专业化个性服务，实现每一位消费者的具体要求。酒富网以真品为本，低价为辅，视信誉为生命，通过不断累计线上线下的销售经验，忠实的履行着“买品质酒就上酒富网”的服务承诺。\n</p>', 1, '', '', 'zh-cn', ''),
(8, '在线支付', 2, '在线支付', '<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	酒富网支持绝大多数银行借记卡及信用卡在线支付，即时到帐，准确快捷！选择在线支付，您的银行卡需要开通相应的在线业务。因各地银行政策不同，建议您在网上支付前拨打所在地银行电话，咨询该行可供网上支付的银行卡种类及开通手续\n</p>\n<div class="Shopping_Process" style="margin:10px 0px;padding:0px;color:#333333;font-weight:bold;font-size:12px;font-family:宋体;background:#F3EEF2;">\n	<span>一</span><b>第三方支付平台</b> \n</div>\n<p style="font-family:宋体;font-size:12px;color:#666666;background-color:#FFFFFF;">\n	<strong>1. 支付宝：</strong>如您己经拥有支付宝账户，可选择支付宝进行付款\n</p>\n<p style="font-family:宋体;font-size:12px;color:#666666;background-color:#FFFFFF;">\n	<strong>3. 快钱：</strong>您可以根据自己的情况选择快钱账户支付或银行卡支付，快钱账户免费注册，帐户里的资金不足时可随时充值，也可以随时提现\n</p>\n<p style="font-family:宋体;font-size:12px;color:#666666;background-color:#FFFFFF;">\n	<strong>4. 财付通：</strong>您可以根据自己的情况选择财付通余额支付、银行卡支付和快捷支付。只要拥有QQ号就可以激活财付通账户\n</p>\n<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	<img width="687" height="100%" src="file://192.168.11.227/jiufu/%E5%B8%AE%E5%8A%A9%E4%B8%AD%E5%BF%83/Help/zf02.jpg" alt="" /> \n</p>\n<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	<br />\n</p>\n<div class="Shopping_Process" style="margin:10px 0px;padding:0px;color:#333333;font-weight:bold;font-size:12px;font-family:宋体;background:#F3EEF2;">\n	<span>二</span><b>网银支付</b> \n</div>\n<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	酒富网支持绝大多数银行借记卡及信用卡在线支付，即时到帐，准确快捷！\n</p>\n<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	<img width="687" height="100%" src="file://192.168.11.227/jiufu/%E5%B8%AE%E5%8A%A9%E4%B8%AD%E5%BF%83/Help/zf01.jpg" alt="" /> \n</p>\n<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	<br />\n</p>\n<div class="Shopping_Process" style="margin:10px 0px;padding:0px;color:#333333;font-weight:bold;font-size:12px;font-family:宋体;background:#F3EEF2;">\n	<span>三</span><b>快捷支付（支付宝信用卡）</b> \n</div>\n<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	您无需开通网银，<strong>首次使用或非快捷用户</strong>只需在支付宝页面上填写卡号、姓名、证件号码、手机号码等信息，并输入有效的手机\n</p>\n<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	动态口令便可完成支付。<strong>成为快捷用户后</strong>只需输入支付宝支付密码或者是支付密码及手机动态口令即可完成支付\n</p>\n<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	<img width="687" height="100%" src="file://192.168.11.227/jiufu/%E5%B8%AE%E5%8A%A9%E4%B8%AD%E5%BF%83/Help/zf03.jpg" alt="" /> \n</p>', 1, '', '', 'zh-cn', ''),
(9, '配送服务', 1, '配送服务', '', 1, '', '', 'zh-cn', ''),
(10, '配送时效及运费', 9, '配送时效及运费', '<div class="ask" style="margin:0px;padding:20px;color:#333333;font-family:宋体;font-size:12px;">\n	<div class="rightbox_firstrow" style="margin:0px;padding:0px;">\n		<div style="margin:0px;padding:0px;">\n			<div class="Shopping_Process" style="margin:0px 0px 10px;padding:0px;font-weight:bold;font-size:12px;background:#F3EEF2;">\n				<span style="background:url(http://img2.imglefeng.com/images/zt/201409/gwlc_title_bg.jpg) 50% 0% no-repeat;">一</span><b>快递区域时效及收费表</b> \n			</div>\n			<p>\n				<img width="100%" height="35" alt="" src="file://192.168.11.227/jiufu/%E5%B8%AE%E5%8A%A9%E4%B8%AD%E5%BF%83/Help/ps01.jpg" /> \n			</p>\n		</div>\n<br />\n		<div class="Shopping_Process" style="margin:0px 0px 10px;padding:0px;font-weight:bold;font-size:12px;background:#F3EEF2;">\n			<span style="background:url(http://img2.imglefeng.com/images/zt/201409/gwlc_title_bg.jpg) 50% 0% no-repeat;">二</span><b>配送说明</b> \n		</div>\n		<p>\n			1.订购发出后，您可以通过我们发出的订单确认邮件或者在"我的帐户"中查询订单发货时间。\n		</p>\n		<p>\n			2.请您务必在订单中填写真实姓名和具体收货地址（省、市、县/镇、街道名称及门牌号），以便订单顺利投递。\n		</p>\n		<p>\n			3.送货上门时间:08：00--19：00。\n		</p>\n		<p>\n			<br />\n		</p>\n		<div class="Shopping_Process" style="margin:0px 0px 10px;padding:0px;font-weight:bold;font-size:12px;background:#F3EEF2;">\n			<span style="background:url(http://img2.imglefeng.com/images/zt/201409/gwlc_title_bg.jpg) 50% 0% no-repeat;">三</span><b>配送费标准</b> \n		</div>\n		<table width="98%" bgcolor="#c9c9c9" cellspacing="1" cellpadding="5" border="0" class="ke-zeroborder">\n			<tbody>\n				<tr>\n					<td height="45" bgcolor="#c9c9c9" align="center">\n						运费收费标准\n					</td>\n					<td height="45" bgcolor="#c9c9c9" align="center">\n						运费优惠政策\n					</td>\n				</tr>\n				<tr>\n					<td height="45" bgcolor="#ffffff" align="left">\n						10元/单\n					</td>\n					<td height="45" bgcolor="#ffffff" align="left">\n						100元以上（含100元）即免运费&nbsp;<br />\n&nbsp;\n					</td>\n				</tr>\n			</tbody>\n		</table>\n		<div style="margin:0px;padding:0px;">\n			&nbsp;\n		</div>\n	</div>\n</div>', 1, '', '', 'zh-cn', ''),
(11, '验货与签收', 9, '验货与签收', '<h3 style="font-size:14px;color:#333333;font-family:宋体;background-color:#FFFFFF;">\n	1.酒富网（www.jiufu.com）包装标识：\n</h3>\n<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	您在酒富网订购的商品，都将采用印有酒富网LOGO标识 的精美包装，并且在包装的正面和反面由带LOGO的胶带封箱。（具体如下图所示）\n</p>\n<h3 style="font-size:14px;color:#333333;font-family:宋体;background-color:#FFFFFF;">\n	2.酒富网（www.jiufu.com）提示您，验货方法如下：\n</h3>\n<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	货到付款方式：当您在收到有酒富网标识的货物包装后，请当场开箱验货，在与随货订单明细核对无误后，方可交付货款给快递人员。对于采用EMS方式快递到您手中的货物，按照邮政规定，需要先行付款，但可要求邮局送货人员在场，开箱验货，确认无误后，方可请配送人员离开。如货物有任何问题，可马上与酒富网客服中心进行联系。 网上支付或汇款方式：当您在收到有酒富网标识的货物包装后，请当场开箱验货，在与随货订单明细核对确认无误后，方可请配送人员离开。如货物有任何问题，可马上与酒富网客服中心进行联系。\n</p>\n<h3 style="font-size:14px;color:#333333;font-family:宋体;background-color:#FFFFFF;">\n	3、酒富网（www.jiufu.com）客服中心联系方式：400-069-1573\n</h3>', 1, '', '', 'zh-cn', ''),
(12, '配送信息跟踪', 9, '配送信息跟踪', '<div class="ask" style="margin:0px;padding:20px;color:#333333;font-family:宋体;font-size:12px;">\n	<div class="rightbox_firstrow" style="margin:0px;padding:0px;">\n		<div style="margin:0px;padding:0px;">\n			<div class="Logistics Logistics_step1" style="margin:0px;padding:0px;color:#FFFFFF;font-size:12px;">\n				<span>点击"我的</span> \n			</div>\n			<div class="Logistics Logistics_step2" style="margin:0px;padding:0px;color:#FFFFFF;font-size:12px;">\n				<span>进入"我的订单"，直接点击"查看物流"或者"查看"</span> \n			</div>\n			<p>\n				<span style="color:#777777;"><img width="95%" height="100%" src="file://192.168.11.227/jiufu/%E5%B8%AE%E5%8A%A9%E4%B8%AD%E5%BF%83/help/bzzx09.jpg" alt="" /></span> \n			</p>\n			<div class="Logistics Logistics_step3" style="margin:0px;padding:0px;color:#FFFFFF;font-size:12px;">\n				<span>点击查看后显示：订单跟踪信息</span> \n			</div>\n			<p>\n				<span style="color:#777777;"><img width="90%" height="100%" src="file://192.168.11.227/jiufu/%E5%B8%AE%E5%8A%A9%E4%B8%AD%E5%BF%83/help/zf04.jpg" alt="" /></span> \n			</p>\n		</div>\n	</div>\n</div>', 1, '', '', 'zh-cn', ''),
(13, '账户及订单信息', 1, '账户及订单信息', '', 1, '', '', 'zh-cn', ''),
(14, '我的酒富', 13, '我的酒富', '<div class="ask" style="margin:0px;padding:20px;color:#333333;font-family:宋体;font-size:12px;">\n	<div class="rightbox_firstrow" style="margin:0px;padding:0px;">\n		<div style="margin:0px;padding:0px;">\n			<p>\n				1. 我的订单：<b>可以查看最近的订单，查看已取消的订单，也可以修改订单</b> \n			</p>\n			<p>\n				2. 我的收藏：<b>当您遇到感兴趣的商品，但还未决定立即购买，或者该商品因暂时缺货而无法购买时，您可以先把它加入"我的收藏"，以便今后查找、购买</b> \n			</p>\n			<p>\n				3. 我的优惠劵：<b>可以查看账户中未使用、已使用、已过期的代金劵、兑换劵</b> \n			</p>\n			<p>\n				4. 余额<b>可以查看支付宝余额</b> \n			</p>\n			<p>\n				5. 我的红包：<b>可以看到账户中可使用、不可用的红包明细</b> \n			</p>\n			<p>\n				6. 我的评价：<b>可以对购买的商品发表评论或晒货，还可以查看已发表的评价</b> \n			</p>\n			<p>\n				7. 我的拍卖：<b>可以查询参与竞拍的记录</b> \n			</p>\n			<p>\n				8. 为我推荐：<b>可以查询到酒富网为您推荐的商品</b> \n			</p>\n			<p>\n				<br />\n			</p>\n			<div class="Shopping_Process" style="margin:0px 0px 5px;padding:0px;font-weight:bold;font-size:12px;background:#F3EEF2;">\n				<span>二</span><b>账户管理</b> \n			</div>\n			<p>\n				1. 个人资料设置：<b>可以根据提示内容更改您的账户信息，并且可以进行邮箱验证和手机验证</b> \n			</p>\n			<p>\n				2. 账户安全设置：<b>可以设置修改酒富网登录密码、支付密码，同时还可以修改验证邮箱、手机</b> \n			</p>\n			<p>\n				3. 收货地址管理：<b>可以新建、修改、删除和设置默认地址</b> \n			</p>\n			<p>\n				<br />\n			</p>\n			<div class="Shopping_Process" style="margin:0px 0px 5px;padding:0px;font-weight:bold;font-size:12px;background:#F3EEF2;">\n				<span>三</span><b>服务中心</b> \n			</div>\n			<p>\n				1. 申请退换货/投诉：<b>可以在线自助申请退换货，在您提交申请后，请等待客服审核</b> \n			</p>\n			<p>\n				2. 退货管理：<b>可以查询您申请的退货处理进度</b> \n			</p>\n			<p>\n				3. 换货管理：<b>可以查询您申请的换货处理进度</b> \n			</p>\n			<p>\n				4. 店铺取消订单管理：<b>可以查询到申请取消的店铺订单处理进度，也可以点击撤销取消</b> \n			</p>\n			<p>\n				5. 我的投诉：<b>可以查询您申请的投诉处理进度</b> \n			</p>\n		</div>\n	</div>\n</div>', 1, '', '', 'zh-cn', ''),
(15, '订单状态及修改订单', 13, '订单状态及修改订单', '<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	1. 订单成功提交后，您可以通过"我的订单"查询到订单状态，如果您的订单在等待处理状态时，您可以自助修改订单的支付方 式、送货方式、送货地址、发票等信息，或取消订单\n</p>\n<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	2. 已发货的订单，则无法添加或修改商品\n</p>\n<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	3. 订单发货后，如需修改地址，请与客服中心联系确认是否可以修改。国内特快专递（EMS）因邮局规定，发出后将无法修改地址\n</p>', 1, '', '', 'zh-cn', ''),
(16, '取消订单', 13, '取消订单', '<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	1）当订单为“待处理”的状态时您可以进入“我的订单”，在列表页取消您的订单；\n</p>\n<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	2）如果您选择的支付方式是在线支付、支付宝快捷支付等非货到付款的支付方式，在乐蜂网还未收到您的款项时，您的订单显示“待处理”，此时您可以进入“我的订单”，在列表页取消您的订单\n</p>', 1, '', '', 'zh-cn', '');
INSERT INTO `jkd_page` (`id`, `unique_id`, `parent_id`, `page_name`, `content`, `display`, `keywords`, `description`, `lang`, `image_id`) VALUES
(17, '忘记密码', 13, '忘记密码', '<div class="lostpassword lostpassword_step1" style="margin:0px;padding:0px;color:#FFFFFF;font-size:12px;font-family:宋体;background:url(/Public/Home/images/help/wjmm_03.jpg) 0% 0% no-repeat #FFFFFF;text-indent: 40px; line-height: 30px;">\n	<span>在登录页面，点击"忘记密码"，将自动跳转到"找回密码"页面</span> \n</div>\n<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	<span style="color:#777777;"><img width="440" height="393" alt="" src="/Public/Home/images/help/gwlc_14.jpg" /></span> \n</p>\n<div class="lostpassword lostpassword_step2" style="margin:0px;padding:0px;color:#FFFFFF;font-size:12px;font-family:宋体;background:url(/Public/Home/images/help/wjmm_10.jpg) 0% 0% no-repeat #FFFFFF;text-indent: 40px; line-height: 30px;">\n	<span>填写账号（可为用户名、注册邮箱或者注册手机）、验证码，点击"下一步"</span> \n</div>\n<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	<span style="color:#777777;"><img width="656" height="268" alt="" src="/Public/Home/images/help/gwlc_16.jpg" /></span> \n</p>\n<div class="lostpassword lostpassword_step3" style="margin:0px;padding:0px;color:#FFFFFF;font-size:12px;font-family:宋体;background:url(/Public/Home/images/help/wjmm_17.jpg) 0% 0% no-repeat #FFFFFF;text-indent: 40px; line-height: 30px;">\n	<span>使用手机找回密码：先点击"获取短信验证码"，然后输入手机验证码点击下一步后，即可重新设置密码</span> \n</div>\n<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	<span style="color:#777777;"><img width="654" height="275" alt="" src="/Public/Home/images/help/gwlc_25.jpg" /></span> \n</p>\n<div style="clear: both;"></div>', 1, '', '', 'zh-cn', ''),
(18, '售后服务', 1, '售后服务', '', 1, '', '', 'zh-cn', ''),
(19, '退换货政策', 18, '退换货政策', '<div class="Shopping_Process" style="margin:0px 0px 5px;padding:0px;color:#333333;font-weight:bold;font-size:12px;font-family:宋体;background:#F3EEF2;">\n	<span>一</span><b>退换货规则</b> \n</div>\n<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	退换货按签收商品之日起，45天之内酒富将为您提供退换货服务。请根据以下退换货流程操作：\n</p>\n<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	<img width="557" height="330" src="/Public/Home/images/help/pimg.jpg" alt="" /> \n</p>\n<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	1、申请退换货，可通过电话、E-mail、在线申请的方式与我们客服取得联系。\n</p>\n<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	客服电话：400-069-1573；E-Mail：jiufu@sina.com ；\n</p>\n<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	在线申请退换货请登录"我的账户——我的蜂巢"选择"退换货/投诉"，提供您的订单号或会员信息及退换货原因、联系方式等，我们将竭诚为您解决相关问题。\n</p>\n<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	2、办理退换货时，如订单中有赠品，请一并退回。\n</p>\n<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	3、遇过敏问题产生退换货需要提供三甲医院的相关证明。\n</p>\n<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	4、服装类商品退换货需保留吊牌完整、未拆（贴身衣物无质量问题不可退换）。\n</p>\n<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	5、预售商品退换货流程以每次预售活动细则为准。\n</p>\n<div class="Shopping_Process" style="margin:0px 0px 5px;padding:0px;color:#333333;font-weight:bold;font-size:12px;font-family:宋体;background:#F3EEF2;">\n	<span>二</span><b>不支持45天无条件退换货政策的情况</b> \n</div>\n<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	1、任何非由酒富网出售的商品；<br />\n2、任何因非正常使用及保管导致出现质量问题的商品；<br />\n3、服装鞋包类商品退换货周期为7天；<br />\n4、手机退换货时间为7天，超过7天按国家规定三包政策执行。<br />\n5、商品的外包装、附件、赠品（券）（需要和主商品一起退换） 、说明书不完整；发票（券）缺失或涂改；<br />\n6、礼包或套装中的商品不可以部分退换货，<br />\n7、贴身衣物一旦穿着无质量问题不可退换货，食品外包装一旦打开不可退换货；<br />\n8、计生情趣类用品属于个人卫生用品，一经使用无质量问题不可退换货&nbsp;<br />\n9、因个人原因造成的商品损坏（如自行修改尺寸，洗涤沾染，皮具打油，刺绣，长时间穿着等），以及附着化妆品、香水、气味等不予退货。<br />\n10、清仓专区中销售的包装破损商品、临近有效期商品、清仓甩货商品，不予退换货。<br />\n11、超过网站承诺退换货周期的商品。<br />\n12、奢侈品品牌商品可能不享受该政策，请留意页面"特别说明"。<br />\n13、客户验收饰品时请查验清楚，一经售出，饰品的磨损、划痕、变形等破坏商品外观的问题，一律不予退换。\n</p>\n<div class="Shopping_Process" style="margin:0px 0px 5px;padding:0px;color:#333333;font-weight:bold;font-size:12px;font-family:宋体;background:#F3EEF2;">\n	<span>三</span><b>退换货区域</b> \n</div>\n<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	酒富网已在全国9个城市开通上门取货退款，45个城市开通上门取货服务。具体如下：\n</p>\n<table width="100%" cellspacing="0" cellpadding="0" border="0" class="tabbox ke-zeroborder" style="border:1px solid #CCCCCC;color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	<tbody>\n		<tr>\n			<td width="20%" height="30" bgcolor="#95b3d7" align="center" style="border:1px solid #CCCCCC;">\n				退换货方式\n			</td>\n			<td width="55%" height="30" bgcolor="#95b3d7" align="center" style="border:1px solid #CCCCCC;">\n				&nbsp;服务地区（收货地址所在区域）\n			</td>\n			<td width="25%" height="30" bgcolor="#95b3d7" align="center" style="border:1px solid #CCCCCC;">\n				办理时效\n			</td>\n		</tr>\n		<tr>\n			<td align="center" style="border:1px solid #CCCCCC;">\n				上门取货退款<br />\n（只限货到付款订单）\n			</td>\n			<td style="border:1px solid #CCCCCC;">\n				<p>\n					北京、上海、广州、深圳、苏州、无锡、南京、杭州、天津\n				</p>\n			</td>\n			<td align="center" style="border:1px solid #CCCCCC;">\n				申请被确认后的3个工作日内\n			</td>\n		</tr>\n		<tr>\n			<td align="center" style="border:1px solid #CCCCCC;">\n				上门取货\n			</td>\n			<td style="border:1px solid #CCCCCC;">\n				<p>\n					北京、上海、广州、深圳、佛山、东莞、中山、苏州、无锡、南京、徐州、常州、南通、杭州、宁波、温州、嘉兴、绍兴、金华、天津、石家庄、保定、沈阳、大连、长春、哈尔滨、济南、青岛、烟台、淄博、潍坊、太原、大同、郑州、西安、长沙、株洲、合肥、南昌、武汉、重庆、成都、绵阳、福州、厦门\n				</p>\n			</td>\n			<td align="center" style="border:1px solid #CCCCCC;">\n				申请被确认后的3个工作日内\n			</td>\n		</tr>\n		<tr>\n			<td height="33" align="center" style="border:1px solid #CCCCCC;">\n				客户帮助寄回\n			</td>\n			<td style="border:1px solid #CCCCCC;">\n				<p>\n					除以上区域外，发生退换货时需要客户帮助寄回酒富网库房。\n				</p>\n			</td>\n			<td style="border:1px solid #CCCCCC;">\n				&nbsp;\n			</td>\n		</tr>\n	</tbody>\n</table>\n<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	注：以货换货类型的订单，上门取货、换货时间以新订单配送时间为准， 具体时间可参考网站帮助中心内的配送时效及运费\n</p>\n<br />\n<div class="Shopping_Process" style="margin:0px 0px 5px;padding:0px;color:#333333;font-weight:bold;font-size:12px;font-family:宋体;background:#F3EEF2;">\n	<span>四</span><b>退换货说明</b> \n</div>\n<strong>【费用说明】</strong><span style="color:#333333;font-family:宋体;font-size:12px;line-height:24px;background-color:#FFFFFF;"></span> \n<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	1、上门取货<br />\n因酒富网原因造成的商品退、换货免费取货。 非酒富网原因造成的商品退、换货，取货费用由客户承担。北京、上海、广州、成都地区5元/单，其他地区12元/单。\n</p>\n<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	2、非上门取货（客户帮助寄回）<br />\n因酒富网原因造成的商品退、换货，需要您帮助邮寄，我们将为您报销寄回费用（最高20元），此费用将打入您的指定银行帐户中。（请客户在申请退、换货时将帐户告知客服）；非酒富网原因造成的商品退、换货，平邮/快递费用由客户承担。\n</p>', 1, '', '', 'zh-cn', ''),
(20, '退换货网上办理', 18, '退换货网上办理', '<div class="__kindeditor_paste__">\n	<p class="stlTitle stlTitle01" style="font-size:12px;font-family:''Microsoft Yahei'';color:#FFFFFF;">\n		登录后进入"我的酒富-服务中心-申请退换货/投诉"\n	</p>\n	<div style="margin:0px;padding:0px;color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		<img width="270" height="225" alt="" src="/Public/Home/images/help/hh_05.jpg" /> \n	</div>\n	<p class="stlTitle stlTitle02" style="font-size:12px;font-family:''Microsoft Yahei'';color:#FFFFFF;">\n		点击"酒富订单"查询需要办理的订单，在相应操作栏点击"申请退/换货"开始办理\n	</p>\n	<div style="margin:0px;padding:0px;color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		<img width="702" height="292" alt="" src="/Public/Home/images/help/hh_09.jpg" /> \n	</div>\n	<p class="stlTitle stlTitle03" style="font-size:12px;font-family:''Microsoft Yahei'';color:#FFFFFF;">\n		勾选需要办理换货的商品后，点击" 我要换货\n	</p>\n	<div style="margin:0px;padding:0px;color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		<img width="636" height="442" alt="" src="/Public/Home/images/help/hh_13.jpg" /> \n	</div>\n	<p class="stlTitle stlTitle04" style="font-size:12px;font-family:''Microsoft Yahei'';color:#FFFFFF;">\n		提交您所需更换商品数量、换货原因等信息，系统将为您更换同款同尺寸商品\n	</p>\n	<div style="margin:0px;padding:0px;color:#333333;font-family:宋体;font-size:12px;background-color:#ffffff;">\n		<img width="636" height="403" alt="" src="/Public/Home/images/help/hh_17.jpg" /> \n	</div>\n	<p class="stlTitle stlTitle05" style="font-size:12px;font-family:''Microsoft Yahei'';color:#FFFFFF;">\n		提交成功后，可点击"查看我的换货"进入"我的换货申请"页\n	</p>\n	<div style="margin:0px;padding:0px;color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		<img width="704" height="314" alt="" src="/Public/Home/images/help/hh_21.jpg" /> \n	</div>\n	<p class="stlTitle stlTitle06" style="font-size:12px;font-family:''Microsoft Yahei'';color:#FFFFFF;">\n		进入"我的换货申请"页后，可进行查看申请及取消申请\n	</p>\n	<div style="margin:0px;padding:0px;color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		<img width="672" height="271" src="/Public/Home/images/help/hh_24.jpg" /> \n	</div>\n</div>', 1, '', '', 'zh-cn', ''),
(21, '发票说明', 18, '发票说明', '<div class="__kindeditor_paste__">\n	<div class="Shopping_Process" style="margin:0px 0px 5px;padding:0px;color:#333333;font-weight:bold;font-size:12px;font-family:宋体;background:#F3EEF2;">\n		<span>一</span><b>发票政策</b> \n	</div>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		<strong>1. 发票性质</strong> \n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		<span style="color:#777777;">为了给顾客提供更快速、便捷的服务，根据中国税法及税务管理部门的要求，酒富网就其所销售的商品可以同时开具发票，您收到的发票为"<strong>酒富（上海）信息技术有限公司</strong>"，所有酒富网开具的发票均合法有效</span> \n	</p>\n	<p style="font-family:宋体;font-size:12px;color:#888888;background-color:#FFFFFF;">\n		温馨提示：本公司所使用的是经税务局批准的正规自印发票，发票信息查询网址：\n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		<a class="yellow" target="_blank" href="http://www.tax.sh.gov.cn/wsbs/WSBSptFpCx_loginsNewl.jsp">http://www.tax.sh.gov.cn/wsbs/WSBSptFpCx_loginsNewl.jsp</a> \n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		<br />\n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		<strong>2. 发票信息</strong> \n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		<span style="color:#777777;">发票抬头：</span> \n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		<span style="color:#777777;">发票抬头不能为空；您可填写："个人"、您的姓名、或您的单位名称</span> \n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		<span style="color:#777777;">发票内容：</span> \n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		<span style="color:#777777;">酒富网可开具的发票内容：酒水，请您根据需要选择</span> \n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		<br />\n	</p>\n	<div class="Shopping_Process" style="margin:0px 0px 5px;padding:0px;color:#333333;font-weight:bold;font-size:12px;font-family:宋体;background:#F3EEF2;">\n		<span>二</span><b>如何获得发票</b> \n	</div>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		1. 当您电话订购时，确认好所需要的产品后，请您将需要的发票信息提供给销售人员，确认后发票将随同商品一起为您送到\n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		2. 如您在酒富网站订购，请在提交订单前在"您是否需要开具发票"处选择"是"，并填写发票抬头和发票内容，发票将随商品一起送到\n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		<img width="690" height="230" src="/Public/Home/images/help/fpsm_03.jpg" alt="" /> \n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		<br />\n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		<strong>温馨提示：</strong> \n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		1. 酒富网提供的发票为普通发票，所有酒富网开具的发票均合法有效。\n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		2. 一张订单对应一张发票，发票会随每次包裹一同发出。\n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		3. 酒富网提供的发票包含配送费用的金额。\n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		4. 发票金额不能高于订单金额。\n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		5. 以下金额不具备开发票的条件：\n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		<span style="color:#777777;">酒富网促销活动中赠送给客户商品的金额 虚拟账户（如花粉兑换） 已获得过的发票的金额</span> \n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		6. 如您购买的是酒富贵宾卡/礼品卡，发票只能按您实际支付的金额开具，其中返还的礼金或折扣部分不包含在内\n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		<span style="color:#777777;">如您购买的贵宾卡/礼品卡已开具发票，当您在下订单时，使用贵宾卡/礼品卡支付的订单金额不能开具发票</span> \n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		7. 发票是您退换货的重要凭证。如发生退换货时，我们会依据退换货政策，在退换货申请确认后的2-3个工作日内，为您办理取货服务，也请您将原发票及"酒富网发货单"随包裹一同给到快递员手中\n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		<br />\n	</p>\n	<div class="Shopping_Process" style="margin:0px 0px 5px;padding:0px;color:#333333;font-weight:bold;font-size:12px;font-family:宋体;background:#F3EEF2;">\n		<span>三</span><b>补开/换发票说明</b> \n	</div>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		1. 补开/换开发票期限可以补100天之内订购的订单\n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		2. 补开发票需提供"酒富网发货单"或详细的订购信息\n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		3. 若您提交订单时未选择发票，请接收到商品后在补开发票期限内，联系酒富网在线客服、电话客服400 000 1818进行补开，您需提供：订单号、发票抬头、发票内容、邮寄地址、邮编及收件人，我们会在2-3天内为您开具发票并以快递方式为您寄出\n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		4. 若您接收到的发票信息有误，请在换开发票期限内，联系酒富网在线客服、电话客服400 000 1818处理\n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		5. 补开或换开的发票信息提供格式：\n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		<span style="color:#777777;"><strong>提交日期 订单号 发票抬头 发票内容 发票总金额 收件人姓名 收件人地址 邮编 联系电话</strong></span> \n	</p>\n	<p style="font-family:宋体;font-size:12px;color:#888888;background-color:#FFFFFF;">\n		另：酒富网日常出货量较大，导致部分商品在用户订购后发生断发票问题。不能与订单一同发出，请您联系酒富网客服进行登记，我们会以快递形式寄出，感谢您的理解和支持\n	</p>\n	<p style="color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n		<br />\n	</p>\n</div>', 1, '', '', 'zh-cn', ''),
(22, '会员计划及积分', 1, '会员计划及积分', '', 1, '', '', 'zh-cn', ''),
(23, '积分说明', 22, '积分说明', '<div class="text" style="margin:0px;padding:0px;color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	酒富网积分奖励计划是为酒富网会员而设立的专享服务计划，会员通过商城购物、评论商品和完善个人资料等获得相应积分，并以积分享受不同程度的专属礼品兑换、抽奖及参与酒富网不定期举行的活动。\n</div>\n<div class="blank40" style="margin:0px;padding:0px;color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	&nbsp;\n</div>\n<div id="1" class="Shopping_Process" style="margin:0px 0px 10px;padding:0px;color:#333333;font-weight:bold;font-size:12px;font-family:宋体;background:#F3EEF2;">\n	<span style="background:url(http://img2.imglefeng.com/images/zt/201409/gwlc_title_bg.jpg) 50% 0% no-repeat;">一</span><b>什么是"积分"？</b>\n</div>\n<div class="text" style="margin:0px;padding:0px;color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	<p>\n		<strong>积分：</strong>是酒富积分的专属名称，是会员在酒富商城，通过购物、评论、完善各人资料以及超时赔付等获得的虚拟的"钱"。是会员在酒富网尊贵身份的象征，积分获得的越多，会员等级越高，享受的会员权益越丰厚。\n	</p>\n	<p>\n		&nbsp;\n	</p>\n</div>\n<div class="blank40" style="margin:0px;padding:0px;color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	&nbsp;\n</div>\n<div id="2" class="Shopping_Process" style="margin:0px 0px 10px;padding:0px;color:#333333;font-weight:bold;font-size:12px;font-family:宋体;background:#F3EEF2;">\n	<span style="background:url(http://img2.imglefeng.com/images/zt/201409/gwlc_title_bg.jpg) 50% 0% no-repeat;">二</span><b>如何获得"积分"？</b>\n</div>\n<div class="tbox" style="margin:0px;padding:0px;color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	<table width="100%" cellspacing="0" cellpadding="0" border="0" style="text-align:center;" class="ke-zeroborder">\n		<tbody>\n			<tr class="tbtit">\n				<td width="116">\n					<strong>获得积分渠道</strong>\n				</td>\n				<td width="362">\n					<strong>获得积分规则</strong>\n				</td>\n				<td width="139">\n					<strong>获得积分值</strong>\n				</td>\n				<td width="83">\n					<strong>每日封顶</strong>\n				</td>\n			</tr>\n			<tr>\n				<td>\n					登录商城购物\n				</td>\n				<td>\n					在商城购物每消费1元，获得一个积分\n				</td>\n				<td>\n					1积分/消费1元\n				</td>\n				<td>\n					无封顶\n				</td>\n			</tr>\n			<tr>\n				<td>\n					对商品评论\n				</td>\n				<td>\n					购物后给商品评论（需审核）成功后将获得10积分，另外抢到商品的首次评价，用户将获得双倍积分，即20积分\n				</td>\n				<td>\n					10积分/1条\n				</td>\n				<td>\n					无封顶\n				</td>\n			</tr>\n			<tr>\n				<td>\n					完善个人资料\n				</td>\n				<td>\n					注册后，在"<b>个人信息管理—修改个人资料</b>"里填写完整的会员资料，即可获得50积分\n				</td>\n				<td>\n					50积分/1人\n				</td>\n				<td>\n					一次性\n				</td>\n			</tr>\n			<tr>\n				<td>\n					超时赔付\n				</td>\n				<td>\n					全国40个城市范围内，订单自发出之日起，若因酒富网配送原因造成订单未能在承诺时效内送达，赔偿500积分作为补偿\n				</td>\n				<td>\n					500积分/订单\n				</td>\n				<td>\n					无封顶\n				</td>\n			</tr>\n		</tbody>\n	</table>\n</div>\n<div class="blank40" style="margin:0px;padding:0px;color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	&nbsp;\n</div>\n<div id="3" class="Shopping_Process" style="margin:0px 0px 10px;padding:0px;color:#333333;font-weight:bold;font-size:12px;font-family:宋体;background:#F3EEF2;">\n	<span style="background:url(http://img2.imglefeng.com/images/zt/201409/gwlc_title_bg.jpg) 50% 0% no-repeat;">三</span><b>如何查询积分？</b>\n</div>\n<div class="text" style="margin:0px;padding:0px;color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	<p>\n		在"我的蜂巢"-"我的积分"里查看积分的详细明细\n	</p>\n	<p>\n		步骤：登陆酒富网—点击我的蜂巢—交易管理栏目中"<a href="http://active.lefeng.com/point/userJifen.jsp" target="_blank">我的积分（积分）</a>&nbsp;"\n	</p>\n	<p>\n		&nbsp;\n	</p>\n</div>\n<div class="blank40" style="margin:0px;padding:0px;color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	&nbsp;\n</div>\n<div id="4" class="Shopping_Process" style="margin:0px 0px 10px;padding:0px;color:#333333;font-weight:bold;font-size:12px;font-family:宋体;background:#F3EEF2;">\n	<span style="background:url(http://img2.imglefeng.com/images/zt/201409/gwlc_title_bg.jpg) 50% 0% no-repeat;">四</span><b>何时获得积分？</b>\n</div>\n<div class="text" style="margin:0px;padding:0px;color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	<p>\n		1.购物获得积分：订单发货后，在"我的积分"中为冻结状态，即未到帐积分，暂时无法使用。订单完成后（确认收货），未到账积分24小时内解冻，变为可用积分。\n	</p>\n	<p>\n		2.评价获得积分：会员对商品评价后，需要人工审核，通过后即会发放积分。\n	</p>\n	<p>\n		3.完善个人资料：注册后，在"<a href="http://passport.lefeng.com/user/userInfo.jsp" target="_blank">我的个人信息管理-修改个人资料</a>&nbsp;"里填写完整的会员资料，即可获得50积分。\n	</p>\n	<p>\n		4.超时赔付：赔偿积分将在承诺时效（<a href="http://www.lefeng.com/zhuanti/help/pssj.html" target="_blank">全国40个城市承诺时效点击查询</a>&nbsp;）截止后的48小时内发放到您的酒富账户中。\n	</p>\n	<p>\n		&nbsp;\n	</p>\n</div>\n<div id="5" class="Shopping_Process" style="margin:0px 0px 10px;padding:0px;color:#333333;font-weight:bold;font-size:12px;font-family:宋体;background:#F3EEF2;">\n	<span style="background:url(http://img2.imglefeng.com/images/zt/201409/gwlc_title_bg.jpg) 50% 0% no-repeat;">五</span><b>如何使用"积分"？</b>\n</div>\n<div class="tbox" style="margin:0px;padding:0px;color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	<table width="100%" cellspacing="0" cellpadding="0" border="0" style="text-align:center;" class="ke-zeroborder">\n		<tbody>\n			<tr class="tbtit">\n				<td width="92">\n					使用项目\n				</td>\n				<td width="207">\n					兑换说明\n				</td>\n				<td width="318">\n					兑换规则\n				</td>\n				<td width="83">\n					兑换页面\n				</td>\n			</tr>\n			<tr>\n				<td>\n					N元兑\n				</td>\n				<td class="tbtit">\n					最新、最炫的爆款商品，价格更低，积分随心兑\n				</td>\n				<td>\n					积分购买价=现金+积分，现金部分还可获得积分，如积分不足无法购买。\n				</td>\n				<td>\n					<a href="http://huafen.lefeng.com/pollentrade/pollen_nyuan_list.jsp" target="_blank">点击兑换</a>\n				</td>\n			</tr>\n			<tr>\n				<td>\n					特色兑\n				</td>\n				<td>\n					超多兑换礼品可供选择，少量现金加积分兑换你心仪的礼品\n				</td>\n				<td>\n					积分购买价=现金+积分，现金部分还可获得积分，如积分不足无法购买。\n				</td>\n				<td>\n					<a href="http://huafen.lefeng.com/pollentrade/pollen_ts_list.jsp" target="_blank">点击兑换</a>\n				</td>\n			</tr>\n			<tr>\n				<td>\n					兑礼券\n				</td>\n				<td>\n					可享受各种优惠的代金券，无需花钱，积分兑换，一券在手，购物巨实惠！\n				</td>\n				<td>\n					100积分可享受1元优惠\n				</td>\n				<td>\n					<a href="http://huafen.lefeng.com/pollentrade/pollen_voucher_list.jsp" target="_blank">点击兑换</a>\n				</td>\n			</tr>\n			<tr>\n				<td>\n					积分抵运费\n				</td>\n				<td>\n					使用积分免运费，只要有足够的积分，运费抵扣随心享！\n				</td>\n				<td>\n					100积分抵1元运费，300积分抵3元运费，500积分抵5元运费，800积分抵8元运费，1000积分抵10元运费。\n				</td>\n				<td>\n					<a href="http://www.lefeng.com/zhuanti/hfdyf.html" target="_blank">点击兑换</a>\n				</td>\n			</tr>\n			<tr>\n				<td>\n					抽大奖\n				</td>\n				<td>\n					积分抽奖，只需手指轻轻一动，梦想大奖随时拿回家！\n				</td>\n				<td>\n					抽奖1次仅需50积分\n				</td>\n				<td>\n					<a href="http://active.lefeng.com/active/pointExchange/index.html" target="_blank">点击查看</a>\n				</td>\n			</tr>\n		</tbody>\n	</table>\n</div>\n<div id="6" class="Shopping_Process" style="margin:0px 0px 10px;padding:0px;color:#333333;font-weight:bold;font-size:12px;font-family:宋体;background:#F3EEF2;">\n	<span style="background:url(http://img2.imglefeng.com/images/zt/201409/gwlc_title_bg.jpg) 50% 0% no-repeat;">六</span><b>如何消耗积分？</b>\n</div>\n<div class="text" style="margin:0px;padding:0px;color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	<p>\n		会员参加积分商城N元兑、特色兑、积分抽奖、积分兑礼券、积分抵运费等活动后，系统将根据活动规则在30分钟内扣除对应的积分；订单退货后，将在30分钟内扣除所退商品的相应积分，并相应调整会员的等级。详见会员等级及勋章说明 。\n	</p>\n	<p>\n		&nbsp;\n	</p>\n</div>\n<div id="7" class="Shopping_Process" style="margin:0px 0px 10px;padding:0px;color:#333333;font-weight:bold;font-size:12px;font-family:宋体;background:#F3EEF2;">\n	<span style="background:url(http://img2.imglefeng.com/images/zt/201409/gwlc_title_bg.jpg) 50% 0% no-repeat;">七</span><b>积分有哪些状态？</b>\n</div>\n<div class="text" style="margin:0px;padding:0px;color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	<p>\n		目前积分有两种状态分别为目前可用积分、未到账积分。<br />\n目前可用积分：为有效积分，可以立即使用的积分数。<br />\n未到账积分：为会员下单购物后，订单状态为已发货，但未完成整个购物流程，所获的积分为未到账积分，此积分为冻结状态，不能使用。&nbsp;\n	</p>\n</div>\n<div id="8" class="Shopping_Process" style="margin:0px 0px 10px;padding:0px;color:#333333;font-weight:bold;font-size:12px;font-family:宋体;background:#F3EEF2;">\n	<span style="background:url(http://img2.imglefeng.com/images/zt/201409/gwlc_title_bg.jpg) 50% 0% no-repeat;">八</span><b>积分使用注意事项</b>\n</div>\n<div class="text" style="margin:0px;padding:0px;color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	<p>\n		（1）不同的帐户中的积分不可合并使用；<br />\n（2）积分只用于个人用途而进行的购物及促销活动，不适用于团体购物、以营利或销售为目的的购买行为、其它非个人用途购买行为；<br />\n（3）部分兑换商品有时间和数量的限制，先兑先得，兑完即止；<br />\n（4）积分抵扣金额不参与各类满额赠促销活动；满额赠送以订单实际支付金额为准；<br />\n（5）积分兑换标准及兑换规则均以兑换当时最新活动公告或目录为准，公告或目录如有有效期限的，逾期即不得兑换；<br />\n（6）使用积分兑换的商品，属于对会员的回馈行为而非交易，积分部分不提供发票；<br />\n（7）以积分兑换的商品（包括但不限于化妆品、服装等）折价、代金券或其他凭证，是有使用期限的，您需要在该折价、兑换券或其他凭证所标注的有效期内使用，否则即丧失使用权利，亦无法退换或延续；<br />\n（8）由于酒富网承诺45天退换货，因此需在交易款项完成45天后进行会员级别及积分状态（冻结积分转为有效积分）变更，如交易款项完成后发生退换货，酒富网有权根据退换货金额对会员级别及积分获取进行相应调整；<br />\n（9）积分是酒富网对用户行为的记录数据，不构成用户资产。\n	</p>\n	<p>\n		&nbsp;\n	</p>\n</div>\n<div class="Shopping_Process" style="margin:0px 0px 10px;padding:0px;color:#333333;font-weight:bold;font-size:12px;font-family:宋体;background:#F3EEF2;">\n	<span style="background:url(http://img2.imglefeng.com/images/zt/201409/gwlc_title_bg.jpg) 50% 0% no-repeat;">九</span><b><a name="9"></a>积分有效期多长？</b>\n</div>\n<div class="text" style="margin:0px;padding:0px;color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	<p>\n		在当年7月1日之前，会员所获得的积分，于当年的12月31日自动清零。<br />\n例：会员在2012年5月16日（7月1日之前）获得了500积分，假如没有使用，在2012的12月31日将系统自动清零。<br />\n在当年7月1日之后，会员所获得的积分，保留到第二年6月30日自动清零。<br />\n例：会员在2012年9月29日（7月1日之后）获得1000积分，假如没有使用，在2013年6月30日系统自动清零。\n	</p>\n	<p>\n		&nbsp;\n	</p>\n</div>\n<div id="10" class="Shopping_Process" style="margin:0px 0px 10px;padding:0px;color:#333333;font-weight:bold;font-size:12px;font-family:宋体;background:#F3EEF2;">\n	<span style="background:url(http://img2.imglefeng.com/images/zt/201409/gwlc_title_bg.jpg) 50% 0% no-repeat;">十</span><b>违规处理</b>\n</div>\n<div class="text" style="margin:0px;padding:0px;color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	<p>\n		如果会员利用系统漏洞作弊等违规方式获得积分，经查证后，将查封会员帐号，并追缴相关积分，并保留追究相应法律责任的权利。\n	</p>\n	<p>\n		&nbsp;\n	</p>\n</div>\n<div id="11" class="Shopping_Process" style="margin:0px 0px 10px;padding:0px;color:#333333;font-weight:bold;font-size:12px;font-family:宋体;background:#F3EEF2;">\n	<span style="background:url(http://img2.imglefeng.com/images/zt/201409/gwlc_title_bg.jpg) 50% 0% no-repeat;">十一</span><b>修改及终止</b>\n</div>\n<div class="text" style="margin:0px;padding:0px;color:#333333;font-family:宋体;font-size:12px;background-color:#FFFFFF;">\n	<p>\n		酒富网保留对本活动细则中条款的解释的权利，并有权根据需要取消本细则或增删、修订细则的权利（包括但不限于参加资格、积分计算及兑换标准）。\n	</p>\n	<p>\n		&nbsp;\n	</p>\n</div>', 1, '', '', 'zh-cn', '');
INSERT INTO `jkd_page` (`id`, `unique_id`, `parent_id`, `page_name`, `content`, `display`, `keywords`, `description`, `lang`, `image_id`) VALUES
(24, '酒富网协议', 2, '酒富网协议', '酒富网用户服务协议<br />\n<br />\n本协议为您与酒富网平台（即酒富网网，域名为 jiufu9.com）管理者之间所订立的契约，具有合同的法律效力，请您仔细阅读。<br />\n<br />\n一、 本协议内容、生效、变更<br />\n本协议内容包括协议正文及所有酒富网已经发布的或将来可能发布的各类规则。所有规则为本协议不可分割的组成部分，与协议正文具有同等法律效力。除另行明确声明外，任何酒富网及其关联公司提供的服务（以下称为酒富网平台服务）均受本协议约束。<br />\n本协议中，“用户”、“会员”为买方、卖方的统称；可单指买方，平台注册的购物的会员；也可单指卖方，即在酒富网开设店铺的商家。<br />\n您应当在使用酒富网平台服务之前认真阅读全部协议内容。如您对协议有任何疑问，应向酒富网咨询。您在同意所有协议条款并完成注册程序，才能成为本站的正式用户，您注册酒富网账号后，本协议即生效，对双方产生约束力。<br />\n只要您使用酒富网平台服务，则本协议即对您产生约束，届时您不应以未阅读本协议的内容或者未获得酒富网对您问询的解答等理由，主张本协议无效，或要求撤销本协议。<br />\n您确认：本协议条款是处理双方权利义务的契约，始终有效，法律另有强制性规定或双方另有特别约定的，依其规定。<br />\n您承诺接受并遵守本协议的约定。如果您不同意本协议的约定，您应立即停止注册程序或停止使用酒富网平台服务。<br />\n酒富网有权根据需要不定期地制订、修改本协议及/或各类规则，并在酒富网平台公示，不再另行单独通知用户。变更后的协议和规则一经在网站公布，立即生效。如您不同意相关变更，应当立即停止使用酒富网平台服务。您继续使用酒富网平台服务的，即表明您接受修订后的协议和规则。<br />\n二、 注册<br />\n注册资格<br />\n用户须具有法定的相应权利能力和行为能力的自然人、法人或其他组织，能够独立承担法律责任。您完成注册程序或其他酒富网平台同意的方式实际使用本平台服务时，即视为您确认自己具备主体资格，能够独立承担法律责任。若因您不具备主体资格，而导致的一切后果，由您及您的监护人自行承担。<br />\n注册资料 2.1用户应自行诚信向本站提供注册资料，用户同意其提供的注册资料真实、准确、完整、合法有效，用户注册资料如有变动的，应及时更新其注册资料。如果用户提供的注册资料不合法、不真实、不准确、不详尽的，用户需承担因此引起的相应责任及后果，并且酒富网保留终止用户使用本平台各项服务的权利。 2.2用户在本站进行浏览、下单购物等活动时，涉及用户真实姓名/名称、通信地址、联系电话、电子邮箱等隐私信息的，本站将予以严格保密，除非得到用户的授权或法律另有规定，本站不会向外界披露用户隐私信息。<br />\n账户 3.1您注册成功后，即成为酒富网平台的会员，将持有酒富网平台唯一编号的会员名和密码等账户信息，您可以根据本站规定改变您的密码。 3.2您设置的会员名不得侵犯或涉嫌侵犯他人合法权益。否则，酒富网有权终止向 您提供酒富网平台服务，注销您的账户。账户注销后，相应的会员名将开放给任意用户注册登记使用。 3.3您应谨慎合理的保存、使用您的会员名和密码，应对通过您的会员名和密码实施的行为负责。除非有法律规定或司法裁定，且征得酒富网的同意，否则，会员名和密码不得以任何方式转让、赠与或继承（与账户相关的财产权益除外）。 3.4用户不得将在本站注册获得的账户借给他人使用，否则用户应承担由此产生的全部责任，并与实际使用人承担连带责任。 3.5如果发现任何非法使用等可能危及您的账户安全的情形时，您应当立即以有效方式通知酒富网，要求酒富网暂停相关服务，并向公安机关报案。您理解酒富网对您的请求采取行动需要合理时间，酒富网对在采取行动前已经产生的后果（包括但不限于您的任何损失）不承担任何责任。 3.6为方便您使用酒富网平台服务及酒富网关联公司或其他组织的服务（以下称其他服务），您同意并授权酒富网将您在注册、使用酒富网平台服务过程中提供、形成的信息传递给向您提供其他服务的酒富网关联公司或其他组织，或从提供其他服务的酒富网关联公司或其他组织获取您在注册、使用其他服务期间提供、形成的信息。<br />\n用户信息的合理使用 4.1您同意，酒富网平台拥有通过邮件、短信电话等形式，向在本站注册、购物用户、收货人发送订单信息、促销活动等告知信息的权利。 4.2您了解并同意，酒富网有权应国家司法、行政等主管部门的要求，向其提供您在酒富网平台填写的注册信息和交易记录等必要信息。如您涉嫌侵犯他人知识产权，则酒富网亦有权在初步判断涉嫌侵权行为存在的情况下，向权利人提供您必要的身份信息。 4.3用户同意，酒富网有权使用用户的注册信息、用户名、密码等信息，登陆进入用户的注册账户，进行证据保全，包括但不限于公证、见证等。<br />\n三、 酒富网平台服务规范<br />\n通过酒富网及其关联公司提供的酒富网平台服务和其它服务，会员可在酒富网平台上发布交易信息、查询商品和服务信息、达成交易意向并进行交易、对其他会员进行评价、参加酒富网组织的活动以及使用其它信息服务及技术服务。<br />\n在酒富网平台上使用酒富网服务过程中，您同意严格遵守以下义务： 2.1不得传输或发表损害国家、社会公共利益和涉及国家安全的信息资料或言论； 2.2不利用本站从事窃取商业秘密、窃取个人信息等违法犯罪活动； 2.3不采取不正当竞争行为，不扰乱网上交易的正常秩序，不从事与网上交易无关的行为； 2.4不发布任何侵犯他人著作权、商标权等知识产权或合法权利的内容； 2.5不以虚构或歪曲事实的方式不当评价其他会员； 2.6不对酒富网平台上的任何数据作商业性利用，包括但不限于在未经酒富网事先书面同意的情况下，以复制、传播等任何方式使用酒富网平台上展示的资料。不使用任何装置、软件或程序干预酒富网平台的正常运营。 2.7本站保有删除站内各类不符合法律政策或不真实的信息内容而无须通知用户的权利。 2.8您同意，若您未遵守以上规定的，本站有权作出独立判断并采取暂停或关闭用户帐号、订单等措施。 2.9经国家行政或司法机关的生效法律文书确认您存在违法或侵权行为，或者酒富网根据自身的判断，认为您的行为涉嫌违反本协议和/或规则的条款或涉嫌违反法律法规的规定的，则酒富网有权在本平台上公示您的该等涉嫌违法或违约行为及酒富网已对您采取的措施。 2.10对于您在酒富网平台上发布的涉嫌违法或涉嫌侵犯他人合法权利或违反本协议和/或规则的信息，酒富网有权不经通知您即予以删除，且按照规则的规定进行处罚。 2.11对于您在酒富网平台上实施的行为，包括您未在酒富网平台上实施但已经对酒富网平台及其用户产生影响的行为，酒富网有权单方认定您行为的性质及是否构成对本协议和/或规则的违反，并采取暂停或关闭用户帐号及其他措施。 2.12对于您涉嫌违反承诺的行为对任意第三方造成损害的，您均应当以自己的名义独立承担所有的法律责任，并应确保酒富网免于因此产生损失或增加费用。 2.13如您涉嫌违反有关法律或者本协议之规定，使酒富网遭受任何损失，或受到任何第三方的索赔，或受到任何行政管理部门的处罚，您应当赔偿酒富网因此造成的损失及（或）发生的费用，包括合理的律师费用。<br />\n四、订单<br />\n在本网站平台购物的用户，请您仔细确认所购商品的名称、价格、数量、型号、规格、尺寸等信息。因店铺商家展示的商品和价格等信息仅仅是要约邀请，您下单时须完整填写您希望购买的商品数量、价款及支付方式、收货人、联系方式、收货地址等内容。如果您提供的注册资料不合法、不真实、不准确、不详尽的，用户需承担因此引起的相应责任及后果，并且酒富网保留终止用户使用<span id="__kindeditor_bookmark_start_0__"></span>美<span id="__kindeditor_bookmark_end_1__"></span><span>酒富网</span>东各项服务的权利。<br />\n系统生成的订单信息是计算机信息系统根据您填写的内容自动生成的数据，仅是您向店铺商家发出的合同要约；店铺商家收到您的订单信息后，将订单中的商品从仓库实际向您发出时（ 以商品出库为标志），方视为您与店铺商家之间就实际发出的商品建立了合同关系；如果一份订单里订购了多种商品并且店铺商家只给您发出了部分商品时，您与店铺商家之间仅就实际向您发出的商品建立了合同关系。<br />\n您了解并同意，本平台上的商品、价格、数量、是否有货等商品信息随时可能发生变动，本站不作特别通知。由于互联网技术原因导致网页显示信息可能会有一定的滞后性或差错，对此在合同未成立前，您接受本平台在发现网页错误，正式向您发出通知后，对商品信息进行调整，订单按照正确的信息执行，或取消订单。<br />\n<span>酒富网</span>所服务的客户为以终端消费为目的的个人、企、事业单位及其他社会团体，不包括经销商，如发现经销商购物，<span>酒富网</span>将拒绝为其服务。由此产生的一切后果由经销商自行承担。<br />\n您了解并同意，如您购买商品，发生缺货，您有权取消订单；本平台无法保证您提交的订单信息中希望购买的商品都会有货。<br />\n酒富网、酒富网关联公司或店铺商家将会把商品（货物）送到您所指定的收货地址。您了解本平台所提示的送货时间供参考，实际送货会与参考时间略有差异。平台管理者和所有者或其关联公司不对因您及收货人原因导致无法送货或延迟送货承担责任。若发生不可抗力或其他正当合理理由导致发货延迟的，您将给予充分理解。<br />\n<span>酒富网</span>保留在中华人民共和国大陆地区法施行之法律允许的范围内独自决定拒绝服务、关闭用户账户、清除或编辑内容或取消订单的权利。<br />\n五、责任范围和责任限制<br />\n本平台作为您进行了解、咨询、协商、交易的场所，提示您：应谨慎判断确定相关物品及/或信息的真实性、合法性和有效性。除非另有明确的书面说明，本平台不对各商家在本平台上发布的信息、内容、材料、产品和服务及各方在交易中各项义务的履行能力作任何形式的担保，法律法规另有规定的除外。<br />\n酒富网在接到您投诉、主管机关通知或按照法律法规规定，有合理的理由认为特定会员及具体交易事项可能存在重大违法或违约情形时,酒富网可依约定或依法采取相应 措施。<br />\n您了解并同意，酒富网不对因下述任一情况而导致您的任何损害承担赔偿责任，包括但不限于利润、商誉、使用、数据等方面的损失或其它无形损失的损害赔偿： 3.1第三方未经批准的使用您的账户或更改您的数据。 3.2您对酒富网平台服务的误解。 3.3任何非因酒富网的原因而引起的与酒富网平台服务有关的其它损失。<br />\n由于法律规定的不可抗力，信息网络正常的设备维护，信息网络连接故障，电脑、通讯或其他系统的故障，电力故障，劳动争议，生产力或生产资料不足，司法行政机关的命令或第三方的不作为及其他本平台无法控制的原因造成的本平台不能服务或延迟服务、丢失数据信息、记录的，酒富网不承担责任，但酒富网将协助处理相关事宜。<br />\n六、协议终止<br />\n您同意，酒富网有权自行全权决定以任何理由不经事先通知的中止、终止向您提供部分或全部酒富网平台服务，暂时冻结或永久冻结（注销）您的账户，且无须为此向您或任何第三方承担任何责任。<br />\n出现以下情况时，酒富网有权直接以注销账户的方式终止本协议: 2.1酒富网终止向您提供服务后，您涉嫌再一次直接或间接或以他人名义注册为酒富网用户的； 2.2您提供的电子邮箱不存在或无法接收电子邮件，且没有其他方式可以与您进行联系，或酒富网以其它联系方式通知您更改电子邮件信息，而您在酒富网通知后三个工作日内仍未更改为有效的电子邮箱的。 2.3您注册信息中的主要内容不真实或不准确或不及时或不完整。 2.4本协议（含规则）变更时，您明示并通知酒富网不愿接受新的服务协议的； 2.5其它酒富网认为应当终止服务的情况。<br />\n您有权向酒富网要求注销您的账户，经酒富网审核同意的，酒富网注销（永久冻结）您的账户，届时，您与酒富网基于本协议的合同关系即终止。您的账户被注销（永久冻结）后，酒富网没有义务为您保留或向您披露您账户中的任何信息，也没有义务向您或第三方转发任何您未曾阅读或发送过的信息。<br />\n您同意，您与酒富网的合同关系终止后，酒富网仍享有下列权利： 4.1继续保存您的注册信息及您使用酒富网平台服务期间的所有交易信息。 4.2您在使用酒富网平台服务期间存在违法行为或违反本协议和/或规则的行为的，酒富网仍可依据本协议向您主张权利。<br />\n酒富网中止或终止向您提供酒富网平台服务后，对于您在服务中止或终止之前的交易行为依下列原则处理，您应独力处理并完全承担进行以下处理所产生的任何争议、损失或增加的任何费用，并应确保酒富网免于因此产生任何损失或承担任何费用： 5.1您在服务中止或终止之前已经上传至酒富网平台的物品尚未交易的，酒富网有权在中止或终止服务的同时删除此项物品的相关信息； 5.2您在服务中止或终止之前已经与其他会员达成买卖合同，但合同尚未实际履行的，酒富网有权删除该买卖合同及其交易物品的相关信息； 5.3您在服务中止或终止之前已经与其他会员达成买卖合同且已部分履行的，酒富网可以不删除该项交易，但酒富网有权在中止或终止服务的同时将相关情形通知您的交易对方。<br />\n七、法律适用、管辖与其他<br />\n本协议包含了您使用酒富网平台需遵守的一般性规范，您在使用某个酒富网平台时还需遵守适用于该平台的特殊性规范。一般性规范如与特殊性规范不一致或有冲突，则特殊性规范具有优先效力。<br />\n本协议的订立、执行和解释及争议的解决均应适用在中华人民共和国大陆地区适用之有效法律（但不包括其冲突法规则）。 如发生本协议与适用之法律相抵触时，则这些条款将完全按法律规定重新解释，而其它有效条款继续有效。<br />\n因本协议履行过程中，因您使用酒富网网服务产生争议应由酒富网与您沟通并协商处理。协商不成时，双方均同意以酒富网平台管理者住所地人民法院为管辖法院。<br />', 1, '', '', 'zh-cn', '');

-- --------------------------------------------------------

--
-- 表的结构 `jkd_paipai`
--

CREATE TABLE IF NOT EXISTS `jkd_paipai` (
`id` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '0为未发布  1为已发布',
  `pro_id` int(11) NOT NULL,
  `min_price` int(15) NOT NULL DEFAULT '0',
  `basic_price` int(15) NOT NULL DEFAULT '0',
  `offer_num` int(15) NOT NULL DEFAULT '0',
  `start_time` int(12) NOT NULL DEFAULT '0',
  `end_time` int(12) NOT NULL DEFAULT '0',
  `ensure_price` int(15) NOT NULL DEFAULT '0',
  `now_price` int(15) NOT NULL DEFAULT '0',
  `published` int(12) NOT NULL DEFAULT '0',
  `update_time` int(12) NOT NULL DEFAULT '0',
  `keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '关键字',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `content` text COMMENT '内容'
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `jkd_paipai`
--

INSERT INTO `jkd_paipai` (`id`, `status`, `pro_id`, `min_price`, `basic_price`, `offer_num`, `start_time`, `end_time`, `ensure_price`, `now_price`, `published`, `update_time`, `keywords`, `description`, `content`) VALUES
(6, 1, 18, 10, 10, 0, 1416211200, 1416280500, 10, 0, 1416195928, 1416280438, '12', '12', '424532'),
(2, 1, 9, 0, 0, 0, 1416302520, 1416475320, 0, 0, 1416193262, 1416216179, '', '', ''),
(3, 1, 16, 0, 1000, 0, 1416211200, 1418288400, 0, 1500, 1416193311, 1418779579, '', '', ''),
(4, 1, 5, 100, 1000, 0, 1416387120, 1417078320, 500, 0, 1416193715, 1416299179, '', '', '<div style="text-align:center;">\n	<img src="/jiufuwang/Public/kindeditor/php/../../../Uploads/image/product/20141118/20141118082614_18253.jpeg" alt="" />\n</div>');

-- --------------------------------------------------------

--
-- 表的结构 `jkd_paipai_offer`
--

CREATE TABLE IF NOT EXISTS `jkd_paipai_offer` (
`id` int(11) NOT NULL,
  `price` int(15) NOT NULL DEFAULT '0' COMMENT '出价的价格',
  `pai_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `nickname` varchar(30) NOT NULL DEFAULT ' ',
  `published` int(12) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `jkd_paipai_offer`
--

INSERT INTO `jkd_paipai_offer` (`id`, `price`, `pai_id`, `uid`, `nickname`, `published`) VALUES
(1, 101, 4, 1, 'Heart', 1416301429),
(2, 102, 4, 1, 'Heart', 1416301429),
(3, 103, 4, 1, 'Heart', 1416301429),
(4, 104, 4, 1, 'Heart', 1416301429),
(5, 105, 4, 1, 'Heart', 1416301429),
(6, 101, 4, 1, 'Heart', 1416301963),
(7, 102, 4, 1, 'Heart', 1416301963),
(8, 103, 4, 1, 'Heart', 1416301963),
(9, 104, 4, 1, 'Heart', 1416301963),
(10, 105, 4, 1, 'Heart', 1416301963),
(11, 101, 4, 1, 'Heart', 1416301965),
(12, 102, 4, 1, 'Heart', 1416301965),
(13, 103, 4, 1, 'Heart', 1416301965),
(14, 104, 4, 1, 'Heart', 1416301965),
(15, 105, 4, 1, 'Heart', 1416301965);

-- --------------------------------------------------------

--
-- 表的结构 `jkd_product`
--

CREATE TABLE IF NOT EXISTS `jkd_product` (
`id` mediumint(8) NOT NULL,
  `title` varchar(200) DEFAULT NULL COMMENT '产品标题',
  `image_id` varchar(255) NOT NULL COMMENT '图片',
  `keywords` varchar(50) DEFAULT NULL COMMENT '产品关键字',
  `description` mediumtext COMMENT '产品描述',
  `status` tinyint(1) DEFAULT NULL COMMENT '产品状态',
  `summary` text COMMENT '产品摘要',
  `unit` varchar(100) DEFAULT NULL COMMENT '计量单位',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(10) DEFAULT NULL COMMENT '更新时间',
  `content` text,
  `lang` varchar(10) NOT NULL DEFAULT 'zh-cn',
  `buy_times` smallint(3) DEFAULT '0' COMMENT '购买次数',
  `click` int(11) NOT NULL DEFAULT '0' COMMENT '浏览数量',
  `is_recommend` int(1) NOT NULL DEFAULT '0',
  `wap_display` int(1) NOT NULL DEFAULT '0',
  `number` varchar(100) DEFAULT NULL COMMENT '商品编号',
  `props` varchar(1000) DEFAULT NULL COMMENT '格式 pid:vid',
  `category_id` int(10) unsigned DEFAULT NULL COMMENT '属性cid'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='产品表';

-- --------------------------------------------------------

--
-- 表的结构 `jkd_product_ask`
--

CREATE TABLE IF NOT EXISTS `jkd_product_ask` (
`id` int(11) NOT NULL,
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT 'pid父级ID',
  `uname` varchar(50) NOT NULL,
  `pro_id` int(11) NOT NULL,
  `mold_name` varchar(20) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `published` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `ask_content` text NOT NULL COMMENT '回复内容'
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `jkd_product_ask`
--

INSERT INTO `jkd_product_ask` (`id`, `uid`, `uname`, `pro_id`, `mold_name`, `status`, `content`, `published`, `update_time`, `ask_content`) VALUES
(9, 1, '', 1, '商品提问', 0, '北京北三环现在下单，晚上下班前能到否？', 1414205565, 1414205565, ''),
(10, 1, '', 1, '商品提问', 0, '到杭州17号能不能到货', 1414205714, 1414205714, ''),
(11, 1, '', 1, '商品提问', 0, '到杭州17号能不能到货', 1414205724, 1414205724, ''),
(12, 1, '', 1, '商品提问', 0, '到杭州17号能不能到货', 1414205787, 1414205787, ''),
(13, 1, '1232', 1, '商品提问', 0, '购买后能发到河北省蠡县县城吗', 1414217801, 1414218510, ''),
(14, 1, '1232', 1, '促销活动提问', 0, '请问下是发什么快递呢 ？单号JX8576636', 1414217946, 1414218504, ''),
(15, 1, '1232', 1, '库存及物流提问', 1, '加价购怎么操作', 1414217970, 1414219054, '亲爱的会员，我看到您的订单已经发货成功，订单号是【门对门】【JX8576636】，请您耐心等待，美酒很快就到家了。嘿嘿，感谢您对酒富网的支持，祝您每天都有一个好心情。'),
(18, 1, 'BoosIsMe', 17, '商品提问', 0, '112', 1415243038, 1415243038, ''),
(19, 1, 'BoosIsMe', 3, '商品提问', 1, '测试', 1415588634, 1415588968, '亲关于这个那个说呢么的'),
(20, 1, 'BoosIsMe', 17, '商品提问', 0, '测试', 1415840996, 1415840996, ''),
(21, 1, 'BoosIsMe', 17, '商品提问', 0, '这个真的 吗，啊', 0, 0, ''),
(22, 1, 'BoosIsMe', 17, '商品提问', 0, '这个您确定?', 1415845214, 1415845214, ''),
(23, 1, 'Heart', 23, '商品提问', 0, 'aa', 1417509800, 1417509800, ''),
(24, 1, 'Heart', 23, '商品提问', 0, '415', 1417510452, 1417510452, ''),
(25, 1, 'Heart', 1, '商品提问', 0, '1236565', 1417658349, 1417658349, ''),
(26, 0, '', 12, '促销活动提问', 0, 'wewqe', 1417751513, 1417751513, ''),
(27, 0, '', 12, '促销活动提问', 0, 'wewqe', 1417751522, 1417751522, ''),
(28, 0, '', 12, '促销活动提问', 0, 'wewqe', 1417751524, 1417751524, ''),
(29, 0, '', 12, '促销活动提问', 0, 'wewqe', 1417751526, 1417751526, ''),
(30, 0, '', 50, '商品提问', 0, 'tEST', 1417868183, 1417868183, ''),
(31, 0, '', 64, '商品提问', 0, '电饭锅', 1418095112, 1418095112, ''),
(32, 9, 'JFW_201412051033205', 28, '商品提问', 0, 'asfsdf', 1418195978, 1418195978, ''),
(33, 9, 'JFW_201412051033205', 28, '商品提问', 0, 'asfsdf', 1418196017, 1418196017, ''),
(34, 0, '', 29, '商品提问', 0, 'jfwoefoirj', 1418816639, 1418816639, ''),
(46, 1, 'Heart', 45, '商品提问', 1, '123456', 1420796942, 1420796976, '123456'),
(45, 0, '', 52, '商品提问', 0, '123', 1420791149, 1420791149, ''),
(37, 0, '', 70, '商品提问', 0, 'aaa', 1418872082, 1418872082, ''),
(38, 0, '', 70, '商品提问', 0, 'sss', 1418872167, 1418872167, ''),
(39, 0, '', 70, '商品提问', 0, 'eee', 1418872211, 1418872211, ''),
(40, 9, 'JFW_201412051033205', 43, '商品提问', 0, 'asdf', 1418874513, 1418874513, ''),
(41, 29, 'JFW_201501052236198', 32, '商品提问', 0, 'dsfdsfsdaf', 1420470261, 1420470261, ''),
(42, 9, '了', 47, '商品提问', 0, ' 雪老百姓厅李斐莉雪塔顶地模压 基本面', 1420707764, 1420707764, ''),
(44, 9, '了', 59, '商品提问', 0, 'dfvdafsdfsdc', 1420789984, 1420789984, ''),
(47, 0, '', 36, '商品提问', 0, '我大多数的的发顺丰大大大二维我去亲亲啊恶趣味的时候', 1421026810, 1421026810, ''),
(48, 9, '了', 59, '商品提问', 0, '', 1421127878, 1421127878, '');

-- --------------------------------------------------------

--
-- 表的结构 `jkd_product_cart`
--

CREATE TABLE IF NOT EXISTS `jkd_product_cart` (
`id` int(11) NOT NULL,
  `img` varchar(255) NOT NULL,
  `title` varchar(100) NOT NULL,
  `price` double(12,2) NOT NULL DEFAULT '0.00',
  `num` int(3) NOT NULL DEFAULT '0',
  `credit` int(15) NOT NULL DEFAULT '0',
  `uid` int(11) DEFAULT NULL,
  `pro_id` int(11) DEFAULT NULL,
  `published` int(11) NOT NULL DEFAULT '0',
  `present` varchar(255) DEFAULT NULL COMMENT '赠品',
  `market` double(11,2) DEFAULT '0.00' COMMENT '市场价',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '购物车商品状态0未创建订单1为已创建订单'
) ENGINE=MyISAM AUTO_INCREMENT=393 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `jkd_product_cart`
--

INSERT INTO `jkd_product_cart` (`id`, `img`, `title`, `price`, `num`, `credit`, `uid`, `pro_id`, `published`, `present`, `market`, `status`) VALUES
(148, '/Public/Home/images/no_goods.jpg', '陈坛老窖珍坛酒52度 500ml*6', 469.00, 2, 0, 1, 15, 1415348614, NULL, 2208.00, 1),
(149, '/Public/Home/images/no_goods.jpg', '陈坛老窖八年酒52度 500ml*6', 359.00, 1, 0, 1, 12, 1415350101, NULL, 1008.00, 1),
(150, '/Public/Home/images/no_goods.jpg', '陈坛老窖六年酒52度 500ml*6', 349.00, 1, 0, 1, 11, 1415350103, NULL, 708.00, 1),
(151, '/Public/Home/images/no_goods.jpg', '五粮液锦绣前程荣誉酒52度 500ml*2', 138.00, 3, 0, 1, 10, 1415350105, '', 298.00, 1),
(152, '/Uploads/image/product/20141025/20141025080214_11554.jpg', '正在做这种重中之重', 0.00, 6, 0, 1, 2, 1415350153, '', 0.00, 1),
(153, '/Uploads/image/product/20141025/20141025080214_11554.jpg', '贵州正宗茅台酒', 110.00, 2, 0, 1, 1, 1415350157, '', 120.00, 1),
(154, '/Public/Home/images/no_goods.jpg', '陈坛老窖悦坛酒52度 500ml*6', 469.00, 1, 0, 1, 16, 1415355436, '', 1008.00, 1),
(158, '/Uploads/image/product/20141025/20141025080214_11554.jpg', '正在做这种重中之重', 0.00, 6, 0, 1, 2, 1415670441, '', 0.00, 1),
(157, '/Public/Home/images/no_goods.jpg', '陈坛老窖八年酒52度 500ml*2', 119.00, 6, 0, 1, 9, 1415670151, NULL, 336.00, 1),
(159, '/Public/Home/images/no_goods.jpg', '陈坛老窖珍坛酒52度 500ml*6', 469.00, 2, 0, 1, 15, 1415670465, NULL, 2208.00, 1),
(160, '/Uploads/image/product/20141025/20141025080214_11554.jpg', '贵州正宗茅台酒', 110.00, 12, 0, 1, 1, 1415670625, '', 120.00, 1),
(161, '/Public/Home/images/no_goods.jpg', '超级赛亚人！！！！！！', 21525.12, 17, 12, 1, 3, 1415670669, '', 999525.12, 1),
(162, '/Public/Home/images/no_goods.jpg', '陈坛老窖悦坛酒52度 500ml*6', 469.00, 1, 0, 1, 16, 1415777797, '', 1008.00, 1),
(163, '/Public/Home/images/no_goods.jpg', '陈坛老窖六年酒52度 500ml*6', 349.00, 1, 0, 1, 11, 1415777823, NULL, 708.00, 1),
(164, '/Public/Home/images/no_goods.jpg', '陈坛老窖八年酒52度 500ml*6', 359.00, 1, 0, 1, 12, 1415777825, NULL, 1008.00, 1),
(165, '/Public/Home/images/no_goods.jpg', '陈坛老窖八年酒52度 500ml*2', 119.00, 1, 0, 1, 9, 1415777827, NULL, 336.00, 1),
(166, '/Public/Home/images/no_goods.jpg', '陈坛老窖珍坛酒52度 500ml*2', 79.00, 1, 0, 1, 7, 1415777831, NULL, 368.00, 1),
(167, '/Public/Home/images/no_goods.jpg', '陈坛老窖珍坛酒52度 500ml*6', 469.00, 1, 0, 1, 15, 1415777833, NULL, 2208.00, 1),
(168, '/Public/Home/images/no_goods.jpg', '超级赛亚人！！！！！！', 21525.12, 1, 12, 1, 3, 1415777860, '', 999525.12, 1),
(172, '/Public/Home/images/no_goods.jpg', '陈坛老窖八年酒52度 500ml*2', 119.00, 1, 0, 1, 9, 1415860173, NULL, 336.00, 1),
(173, '/Public/Home/images/no_goods.jpg', '陈坛老窖珍坛酒52度 500ml*2', 79.00, 1, 0, 1, 7, 1415860177, NULL, 368.00, 1),
(174, '/Public/Home/images/no_goods.jpg', '陈坛老窖珍坛酒45度 500ml', 160.00, 1, 0, 1, 6, 1415860180, NULL, 360.00, 1),
(175, '/Public/Home/images/no_goods.jpg', '陈坛老窖福坛酒 52度 500ml*2', 119.00, 1, 0, 1, 5, 1415936805, '', 276.00, 1),
(178, '/Public/Home/images/no_goods.jpg', '陈坛老窖福坛酒 52度 500ml*2', 119.00, 1, 0, 1, 5, 1416197911, '', 276.00, 1),
(179, '/Public/Home/images/no_goods.jpg', '陈坛老窖福坛酒52度 500ml*6', 269.00, 1, 0, 1, 13, 1416363298, '', 708.00, 1),
(180, '/Uploads/image/product/20141025/20141025080214_11554.jpg', '正在做这种重中之重', 0.10, 5, 0, 1, 2, 1416386771, '', 0.00, 1),
(181, '/Uploads/image/product/20141025/20141025080214_11554.jpg', '正在做这种重中之重', 0.10, 5, 0, 1, 2, 1416390102, '', 0.00, 1),
(182, '/Uploads/image/product/20141025/20141025080214_11554.jpg', '正在做这种重中之重', 0.10, 5, 0, 1, 2, 1416390178, '', 0.00, 1),
(183, '/Uploads/image/product/20141025/20141025080214_11554.jpg', '正在做这种重中之重', 0.01, 5, 0, 1, 2, 1416447893, '', 0.00, 1),
(184, '/Uploads/image/product/20141025/20141025080214_11554.jpg', '正在做这种重中之重', 0.01, 5, 0, 1, 2, 1416450094, '', 0.00, 1),
(185, '/Uploads/image/product/20141025/20141025080214_11554.jpg', '正在做这种重中之重', 0.01, 5, 0, 1, 2, 1416463420, '', 0.00, 1),
(186, '/Uploads/image/product/20141025/20141025080214_11554.jpg', '正在做这种重中之重', 0.01, 3, 0, 1, 2, 1416466675, '', 0.00, 1),
(187, '/Uploads/image/product/20141025/20141025080214_11554.jpg', '正在做这种重中之重', 0.01, 3, 0, 1, 2, 1416468308, '', 0.00, 1),
(188, '/Uploads/image/product/20141025/20141025080214_11554.jpg', '正在做这种重中之重', 0.01, 3, 0, 1, 2, 1416470897, '', 0.00, 1),
(189, '/Uploads/image/product/20141025/20141025080214_11554.jpg', '正在做这种重中之重', 0.01, 3, 0, 1, 2, 1416471162, '', 0.00, 1),
(190, '/Uploads/image/product/20141025/20141025080214_11554.jpg', '正在做这种重中之重', 0.01, 3, 0, 1, 2, 1416477147, '', 0.00, 1),
(191, '/Uploads/image/product/20141025/20141025080214_11554.jpg', '正在做这种重中之重', 0.01, 3, 0, 1, 2, 1416532123, '', 0.00, 1),
(192, '/Uploads/image/product/20141025/20141025080214_11554.jpg', '正在做这种重中之重', 0.01, 3, 0, 1, 2, 1416552930, '', 0.00, 1),
(193, '/Uploads/image/product/20141025/20141025080214_11554.jpg', '正在做这种重中之重', 0.01, 3, 0, 1, 2, 1416556111, '', 0.00, 1),
(194, '/Uploads/image/product/20141025/20141025080214_11554.jpg', '正在做这种重中之重', 0.01, 3, 0, 1, 2, 1416560909, '', 0.00, 1),
(226, '/Uploads/image/product/20141025/20141025080214_11554.jpg', '正在做这种重中之重', 0.01, 3, 0, 1, 2, 1417515474, '', 0.00, 1),
(224, '/Public/Home/images/no_goods.jpg', '法国香奈精选黑歌海娜干红葡萄', 0.01, 1, 0, 1, 22, 1417485492, '', 0.00, 1),
(223, '/Public/Home/images/no_goods.jpg', '法国香奈精选黑歌海娜干红葡萄', 0.00, 1, 0, 1, 22, 1417485303, '', 0.00, 1),
(228, '/Uploads/image/product/20141202/20141202064640_89562.jpeg', '测试商品...', 0.01, 1, 0, 1, 23, 1417572335, '', 100.00, 1),
(208, '/Uploads/image/product/20141127/20141127025936_99403.jpg', '法国香奈精选黑歌海娜干红葡萄2', 59.80, 1, 0, 1, 21, 1417078352, '', 1000.00, 1),
(209, '/Uploads/image/product/20141127/20141127025936_99403.jpg', '法国香奈精选黑歌海娜干红葡萄2', 59.80, 1, 0, 1, 21, 1417078969, '', 1000.00, 1),
(210, '/Uploads/image/product/20141127/20141127025936_99403.jpg', '法国香奈精选黑歌海娜干红葡萄2', 59.80, 4, 0, 1, 21, 1417078997, '', 1000.00, 1),
(211, '/Uploads/image/product/20141127/20141127025936_99403.jpg', '法国香奈精选黑歌海娜干红葡萄2', 59.80, 4, 0, 1, 21, 1417079048, '', 1000.00, 1),
(212, '/Uploads/image/product/20141127/20141127025936_99403.jpg', '法国香奈精选黑歌海娜干红葡萄2', 59.80, 1, 0, 1, 21, 1417079277, '', 1000.00, 1),
(213, '/Uploads/image/product/20141127/20141127025936_99403.jpg', '法国香奈精选黑歌海娜干红葡萄2', 59.80, 1, 0, 1, 21, 1417079353, '', 1000.00, 1),
(214, '/Uploads/image/product/20141127/20141127025936_99403.jpg', '法国香奈精选黑歌海娜干红葡萄2', 59.80, 1, 0, 1, 21, 1417079584, '', 1000.00, 1),
(215, '/Uploads/image/product/20141127/20141127025936_99403.jpg', '法国香奈精选黑歌海娜干红葡萄2', 59.80, 1, 0, 1, 21, 1417079747, '', 1000.00, 1),
(216, '/Uploads/image/product/20141127/20141127025936_99403.jpg', '法国香奈精选黑歌海娜干红葡萄2', 0.10, 1, 0, 1, 21, 1417081750, '', 1000.00, 1),
(217, '/Uploads/image/product/20141127/20141127025936_99403.jpg', '法国香奈精选黑歌海娜干红葡萄2', 0.10, 1, 0, 1, 21, 1417082081, '', 1000.00, 1),
(218, '/Uploads/image/product/20141127/20141127025936_99403.jpg', '法国香奈精选黑歌海娜干红葡萄2', 0.10, 1, 0, 1, 21, 1417082254, '', 1000.00, 1),
(219, '/Uploads/image/product/20141127/20141127025936_99403.jpg', '法国香奈精选黑歌海娜干红葡萄2', 0.01, 1, 0, 1, 21, 1417082618, '', 1000.00, 1),
(220, '/Uploads/image/product/20141025/20141025080214_11554.jpg', '贵州正宗茅台酒', 110.00, 1, 0, 1, 1, 1417416836, '', 120.00, 1),
(229, '/Uploads/image/product/20141029/20141029012257_55700.jpg', '五粮液锦绣前程荣誉酒52度 500ml*2', 138.00, 2, 0, 8, 10, 1417742216, '', 298.00, 1),
(230, '/Uploads/image/product/20141029/20141029012257_55700.jpg', '五粮液锦绣前程荣誉酒52度 500ml*2', 138.00, 1, 0, 8, 10, 1417745424, '', 298.00, 1),
(233, '/Uploads/image/product/20141127/20141127110514_31332.jpg', '古越龙山状元红喜尚喜花雕酒糯米酒婚庆喜宴礼酒手工半甜绍兴黄酒', 220.00, 1, 0, 1, 9, 1417767778, '', 642.00, 1),
(234, '/Uploads/image/product/20141127/20141127110514_31332.jpg', '古越龙山状元红喜尚喜花雕酒糯米酒婚庆喜宴礼酒手工半甜绍兴黄酒', 220.00, 1, 0, 1, 9, 1417768114, '', 642.00, 1),
(235, '/Uploads/image/product/20141127/20141127110514_31332.jpg', '古越龙山状元红喜尚喜花雕酒糯米酒婚庆喜宴礼酒手工半甜绍兴黄酒', 220.00, 1, 0, 1, 9, 1417768353, '', 642.00, 1),
(237, '/Uploads/image/product/20141206/20141206144415_39783.jpg', '五粮液 锦绣前程 42度荣迁500ml 浓香型白酒 礼盒特价', 388.00, 1, 0, 10, 37, 1417848703, '', 698.00, 1),
(238, '/Uploads/image/product/20141206/20141206160824_94377.jpg', '泸州老窖 东方之珠 H3单瓶500ml 浓香型白酒礼盒 38度', 138.00, 1, 0, 11, 44, 1418004824, '', 180.00, 1),
(239, '/Uploads/image/product/20141208/20141208102043_51050.jpg', '五粮液 锦绣前程  52度荣誉500ml*2 白酒特价礼盒装（一盒两瓶）送礼首选', 198.00, 10000, 0, 8, 59, 1418016684, '', 368.00, 1),
(240, '/Uploads/image/product/20141208/20141208113058_92721.jpg', '（整箱）弗瑞斯  老藤拉歌王子一级干红葡萄酒 法国波尔多原瓶进口 750ml*6', 594.00, 1, 0, 8, 64, 1418095389, '', 1788.00, 1),
(242, '/Uploads/image/product/20141206/20141206110806_72954.jpg', '泸州老窖 陈坛老窖 52度珍坛500ml 浓香型白酒特价', 69.00, 13, 0, 8, 29, 1418095774, '', 325.00, 1),
(243, '/Uploads/image/product/20141208/20141208102043_51050.jpg', '五粮液 锦绣前程  52度荣誉500ml*2 白酒特价礼盒装（一盒两瓶）送礼首选', 198.00, 1, 0, 8, 59, 1418108263, '', 368.00, 1),
(355, '/Uploads/image/product/20141206/20141206175751_50564.jpg', '弗瑞斯 老藤慕斯卡特甜白葡萄酒 法国波尔多原瓶进口 750ml ', 328.00, 1, 0, 11, 56, 1420793018, '', 798.00, 1),
(344, '/Uploads/image/product/20141206/20141206134517_37496.jpg', '泸州老窖 陈坛老窖 45度珍坛500ml 浓香型单瓶白酒 自饮应酬婚宴必备', 360.00, 1, 0, 32, 32, 1420708274, '', 540.00, 0),
(349, '/Uploads/image/product/20150105/20150105232209_64580.png', '测试111', 2222.00, 1, 222, 9, 80, 1420774581, '', 3333.00, 1),
(278, '/Uploads/image/product/20141208/20141208102043_51050.jpg', '五粮液 锦绣前程  52度荣誉500ml*2 白酒特价礼盒装（一盒两瓶）送礼首选', 198.00, 9999, 0, 19, 59, 1418905309, '', 368.00, 0),
(252, '/Uploads/image/product/20141208/20141208160146_87382.jpg', '51°慎初酱酒小坛醉清风500ml  慎初好酱酒，小坛醉清风。显示抢购！', 99999.00, 1, 0, 1, 41, 1418289191, '', 999999.00, 0),
(256, '/Uploads/image/product/20141208/20141208160146_87382.jpg', '51°慎初酱酒小坛醉清风500ml  慎初好酱酒，小坛醉清风。显示抢购！', 99999.00, 0, 0, 1, 41, 1418700328, '', 999999.00, 0),
(257, '/Uploads/image/product/20141208/20141208160146_87382.jpg', '51°慎初酱酒小坛醉清风500ml  慎初好酱酒，小坛醉清风。显示抢购！', 99999.00, 0, 0, 1, 41, 1418700690, '', 999999.00, 0),
(258, '/Uploads/image/product/20141208/20141208160146_87382.jpg', '51°慎初酱酒小坛醉清风500ml  慎初好酱酒，小坛醉清风。显示抢购！', 99999.00, 1, 0, 1, 41, 1418700757, '', 999999.00, 0),
(259, '/Uploads/image/product/20141208/20141208160146_87382.jpg', '51°慎初酱酒小坛醉清风500ml  慎初好酱酒，小坛醉清风。显示抢购！', 99999.00, 4, 0, 1, 41, 1418701187, '', 999999.00, 1),
(264, '/Uploads/image/product/20141216/20141216141405_35029.jpg', '杰克丹尼威士忌', 138.00, 40, 0, 11, 71, 1418782188, NULL, 163.00, 1),
(261, '/Uploads/image/product/20141208/20141208111750_19209.jpg', '（整箱）弗瑞斯 老藤慕斯卡特甜白葡萄酒 法国波尔多原瓶进口 750ml*6', 1968.00, 1, 0, 12, 63, 1418712167, '', 0.00, 1),
(263, '/Uploads/image/product/20141206/20141206110806_72954.jpg', '泸州老窖 陈坛老窖 52度珍坛500ml 浓香型白酒特价', 69.00, 1, 0, 1, 29, 1418721563, '', 325.00, 1),
(267, '/Uploads/image/product/20141206/20141206111934_57301.jpg', '泸州老窖 陈坛老窖 38度六年500ml 浓香型白酒特价', 88.00, 2, 0, 1, 30, 1418803670, '', 180.00, 1),
(271, '/Uploads/image/product/20141206/20141206142002_18852.jpg', '泸州老窖 陈坛老窖  42度福坛500ml 浓香型单瓶白酒', 108.00, 1, 0, 1, 34, 1418866302, '', 198.00, 1),
(282, '/Uploads/image/product/20141222/20141222164718_23507.jpg', '孟买蓝宝石金', 77.00, 1, 7, 21, 78, 1419472819, NULL, 83.00, 1),
(283, '/Uploads/image/product/20141206/20141206134517_37496.jpg', '泸州老窖 陈坛老窖 45度珍坛500ml 浓香型单瓶白酒 自饮应酬婚宴必备', 360.00, 1, 0, 21, 32, 1419472915, '', 540.00, 1),
(354, '/Uploads/image/product/20141206/20141206175751_50564.jpg', '弗瑞斯 老藤慕斯卡特甜白葡萄酒 法国波尔多原瓶进口 750ml ', 328.00, 1, 0, 11, 56, 1420790488, '', 798.00, 1),
(281, '/Uploads/image/product/20141206/20141206162353_72495.jpg', '泸州老窖 东方之珠 H6单瓶500ml 浓香型白酒礼盒 38度', 189.00, 1, 0, 21, 46, 1419472543, '', 368.00, 1),
(348, '/Uploads/image/product/20150105/20150105232209_64580.png', '测试111', 44444.00, 0, 222, 9, 80, 1420774469, '', 3333.00, 0),
(277, '/Uploads/image/product/20141216/20141216143439_30019.jpg', '君度力娇', 103.00, 10, 0, 11, 72, 1418887463, NULL, 117.00, 1),
(279, '/Uploads/image/product/20141206/20141206175751_50564.jpg', '弗瑞斯 老藤慕斯卡特甜白葡萄酒 法国波尔多原瓶进口 750ml ', 328.00, 1, 0, 21, 56, 1419044515, '', 798.00, 1),
(284, '/Uploads/image/product/20141206/20141206172117_22145.jpg', '泸州老窖 陈坛老窖 原浆酒 60度尚坛 5斤收藏酒 白酒礼盒装', 990.00, 1, 0, 21, 52, 1419476299, '', 1980.00, 1),
(285, '/Uploads/image/product/20141206/20141206111934_57301.jpg', '泸州老窖 陈坛老窖 38度六年500ml 浓香型白酒特价', 88.00, 1, 0, 1, 30, 1419560393, '', 180.00, 1),
(286, '/Uploads/image/product/20141206/20141206111934_57301.jpg', '泸州老窖 陈坛老窖 38度六年500ml 浓香型白酒特价', 88.00, 1, 0, 1, 30, 1419563351, '', 180.00, 1),
(287, '/Uploads/image/product/20141206/20141206111934_57301.jpg', '泸州老窖 陈坛老窖 38度六年500ml 浓香型白酒特价', 88.00, 1, 0, 1, 30, 1419563451, '', 180.00, 1),
(288, '/Uploads/image/product/20141222/20141222164718_23507.jpg', '孟买蓝宝石金', 77.00, 1, 7, 1, 78, 1419563544, NULL, 83.00, 1),
(289, '/Uploads/image/product/20141206/20141206150612_59792.jpg', '五粮液 锦绣前程 52度荣迁500ml 浓香型白酒 送礼首选', 388.00, 1, 0, 21, 42, 1419566527, '', 698.00, 1),
(290, '/Uploads/image/product/20141206/20141206150612_59792.jpg', '五粮液 锦绣前程 52度荣迁500ml 浓香型白酒 送礼首选', 388.00, 1, 0, 21, 42, 1419567409, '', 698.00, 1),
(291, '/Uploads/image/product/20141220/20141220164750_87596.jpg', '百加得白朗姆', 58.00, 1, 0, 1, 74, 1419578193, NULL, 59.00, 1),
(292, '/Uploads/image/product/20141220/20141220164750_87596.jpg', '百加得白朗姆', 58.00, 1, 0, 1, 74, 1419578314, NULL, 59.00, 1),
(293, '/Uploads/image/product/20141220/20141220164750_87596.jpg', '百加得白朗姆', 58.00, 1, 0, 1, 74, 1419578479, NULL, 59.00, 1),
(294, '/Uploads/image/product/20141220/20141220164750_87596.jpg', '百加得白朗姆', 58.00, 1, 0, 1, 74, 1419578707, NULL, 59.00, 1),
(295, '/Uploads/image/product/20141220/20141220164750_87596.jpg', '百加得白朗姆', 58.00, 1, 0, 1, 74, 1419578875, NULL, 59.00, 1),
(296, '/Uploads/image/product/20141220/20141220164750_87596.jpg', '百加得白朗姆', 58.00, 1, 0, 1, 74, 1419578962, NULL, 59.00, 1),
(297, '/Uploads/image/product/20141220/20141220164750_87596.jpg', '百加得白朗姆', 58.00, 1, 0, 1, 74, 1419579013, NULL, 59.00, 1),
(298, '/Uploads/image/product/20141220/20141220164750_87596.jpg', '百加得白朗姆', 58.00, 1, 0, 1, 74, 1419579235, NULL, 59.00, 1),
(299, '/Uploads/image/product/20141220/20141220164750_87596.jpg', '百加得白朗姆', 58.00, 1, 0, 1, 74, 1419579437, NULL, 59.00, 1),
(300, '/Uploads/image/product/20141220/20141220164750_87596.jpg', '百加得白朗姆', 58.00, 1, 0, 1, 74, 1419579608, NULL, 59.00, 1),
(301, '/Uploads/image/product/20141206/20141206175002_42297.jpg', '弗瑞斯 莱纳干红葡萄酒 法国波尔多原瓶进口 750ml ', 238.00, 1, 0, 21, 54, 1419581823, '', 398.00, 1),
(302, '/Uploads/image/product/20141206/20141206175002_42297.jpg', '弗瑞斯 莱纳干红葡萄酒 法国波尔多原瓶进口 750ml ', 238.00, 1, 0, 21, 54, 1419581873, '', 398.00, 1),
(303, '/Uploads/image/product/20141206/20141206170009_56727.jpg', '五粮液 锦绣前程 52度荣世 500ml 浓香型白酒', 668.00, 1, 0, 21, 50, 1419586293, '', 798.00, 1),
(304, '/Uploads/image/product/20141206/20141206134517_37496.jpg', '泸州老窖 陈坛老窖 45度珍坛500ml 浓香型单瓶白酒 自饮应酬婚宴必备', 360.00, 1, 0, 21, 32, 1419651765, '', 540.00, 1),
(305, '/Uploads/image/product/20141206/20141206114510_92348.jpg', '泸州老窖 陈坛老窖  52度八年500ml 浓香型单瓶白酒 自饮应酬婚宴必备', 118.00, 1, 0, 1, 31, 1419815139, '', 256.00, 1),
(306, '/Uploads/image/product/20141206/20141206114510_92348.jpg', '泸州老窖 陈坛老窖  52度八年500ml 浓香型单瓶白酒 自饮应酬婚宴必备', 118.00, 1, 0, 1, 31, 1419815200, '', 256.00, 1),
(307, '/Uploads/image/product/20141206/20141206114510_92348.jpg', '泸州老窖 陈坛老窖  52度八年500ml 浓香型单瓶白酒 自饮应酬婚宴必备', 118.00, 1, 0, 1, 31, 1419819065, '', 256.00, 1),
(308, '/Uploads/image/product/20141206/20141206114510_92348.jpg', '泸州老窖 陈坛老窖  52度八年500ml 浓香型单瓶白酒 自饮应酬婚宴必备', 118.00, 1, 0, 1, 31, 1419819290, '', 256.00, 1),
(309, '/Uploads/image/product/20141206/20141206114510_92348.jpg', '泸州老窖 陈坛老窖  52度八年500ml 浓香型单瓶白酒 自饮应酬婚宴必备', 118.00, 1, 0, 1, 31, 1419819429, '', 256.00, 1),
(310, '/Uploads/image/product/20141208/20141208160146_87382.jpg', '51°慎初酱酒小坛醉清风500ml  慎初好酱酒，小坛醉清风。显示抢购！', 99999.00, 2, 0, 1, 41, 1419822720, '', 999999.00, 1),
(311, '/Public/Home/images/no_goods.jpg', 'doubi', 0.01, 1, 0, 1, 23, 1419823477, '', 0.00, 1),
(323, '/Uploads/image/product/20141206/20141206103632_86239.jpg', '泸州老窖 陈坛老窖  52度悦坛500ml 浓香型白酒特价', 1688.00, 1, 0, 24, 27, 1419992499, '', 188.00, 0),
(322, '/Uploads/image/product/20141220/20141220165622_48012.jpg', '懒虫银快活', 85.00, 1, 0, 27, 76, 1419988345, '', 94.00, 1),
(314, '/Uploads/image/product/20141206/20141206173153_11977.jpg', '泸州老窖 国窖1573蓝花釉 500ml ', 999.00, 5, 0, 26, 53, 1419905805, '', 1860.00, 0),
(315, '/Uploads/image/product/20141220/20141220165622_48012.jpg', '懒虫银快活', 85.00, 1, 0, 24, 76, 1419909256, '', 94.00, 0),
(316, '/Uploads/image/product/20141208/20141208090840_55008.jpg', '弗瑞斯  老藤拉歌王子一级干红葡萄酒 法国波尔多原瓶进口 750ml', 99.00, 1, 0, 21, 57, 1419909481, '', 298.00, 1),
(317, '/Uploads/image/product/20141208/20141208110653_10557.jpg', '（整箱）弗瑞斯 里昂之心干红葡萄酒 法国波尔多原瓶进口 750ml*24', 1656.00, 1, 0, 21, 61, 1419909602, '', 0.00, 1),
(318, '/Uploads/image/product/20141208/20141208103421_26300.jpg', '五粮液 52度真藏五粮液 浓香型白酒 500ml ', 599.00, 1, 0, 11, 60, 1419918644, '', 1038.00, 1),
(321, '/Uploads/image/product/20141220/20141220165622_48012.jpg', '懒虫银快活', 85.00, 1, 0, 27, 76, 1419988106, '', 94.00, 1),
(320, '/Uploads/image/product/20141208/20141208104739_52915.jpg', '泸州老窖 东方之珠 H9单瓶500ml 浓香型白酒礼盒 52度', 296.00, 9999, 0, 1, 49, 1419918725, '', 568.00, 1),
(328, '/Uploads/image/product/20141206/20141206134517_37496.jpg', '泸州老窖 陈坛老窖 45度珍坛500ml 浓香型单瓶白酒 自饮应酬婚宴必备', 360.00, 1, 0, 11, 32, 1420354903, '', 540.00, 1),
(327, '/Uploads/image/product/20141206/20141206134517_37496.jpg', '泸州老窖 陈坛老窖 45度珍坛500ml 浓香型单瓶白酒 自饮应酬婚宴必备', 360.00, 1, 0, 11, 32, 1420354183, '', 540.00, 1),
(326, '/Uploads/image/product/20141206/20141206110324_46985.jpg', '泸州老窖 陈坛老窖 45度畅坛500ml 浓香型白酒特价 ', 99.00, 2, 0, 28, 28, 1420244118, '', 399.00, 0),
(333, '/Uploads/image/product/20141208/20141208090840_55008.jpg', '弗瑞斯  老藤拉歌王子一级干红葡萄酒 法国波尔多原瓶进口 750ml', 99.00, 1, 0, 29, 57, 1420469486, '', 298.00, 1),
(334, '/Uploads/image/product/20141206/20141206144415_39783.jpg', '五粮液 锦绣前程 42度荣迁500ml 浓香型白酒 礼盒特价', 388.00, 1, 0, 19, 37, 1420526927, '', 698.00, 0),
(335, '/Uploads/image/product/20141208/20141208102043_51050.jpg', '五粮液 锦绣前程  52度荣誉500ml*2 白酒特价礼盒装（一盒两瓶）送礼首选', 228.00, 5, 0, 33, 59, 1420557876, '', 368.00, 0),
(336, '/Uploads/image/product/20141208/20141208102043_51050.jpg', '五粮液 锦绣前程  52度荣誉500ml*2 白酒特价礼盒装（一盒两瓶）送礼首选', 228.00, 1, 0, 11, 59, 1420614384, '', 368.00, 1),
(337, '/Uploads/image/product/20141208/20141208102043_51050.jpg', '五粮液 锦绣前程  52度荣誉500ml*2 白酒特价礼盒装（一盒两瓶）送礼首选', 228.00, 100, 0, 11, 59, 1420616021, '', 368.00, 1),
(338, '/Uploads/image/product/20141206/20141206111934_57301.jpg', '泸州老窖 陈坛老窖 38度六年500ml 浓香型白酒特价', 88.00, 2, 0, 11, 30, 1420616141, '', 180.00, 1),
(353, '/Uploads/image/product/20141206/20141206140445_38028.jpg', '泸州老窖 陈坛老窖 52度福坛500ml 浓香型单瓶白酒', 108.00, 6, 0, 9, 33, 1420790461, '', 198.00, 1),
(352, '/Uploads/image/product/20141208/20141208090840_55008.jpg', '弗瑞斯  老藤拉歌王子一级干红葡萄酒 法国波尔多原瓶进口 750ml', 128.00, 1, 0, 11, 57, 1420787016, '', 298.00, 1),
(356, '/Uploads/image/product/20141206/20141206175751_50564.jpg', '弗瑞斯 老藤慕斯卡特甜白葡萄酒 法国波尔多原瓶进口 750ml ', 328.00, 1, 0, 11, 56, 1420793494, '', 798.00, 1),
(357, '/Uploads/image/product/20141206/20141206175751_50564.jpg', '弗瑞斯 老藤慕斯卡特甜白葡萄酒 法国波尔多原瓶进口 750ml ', 328.00, 1, 0, 11, 56, 1420793517, '', 798.00, 1),
(358, '/Uploads/image/product/20141208/20141208091805_40110.jpg', '弗瑞斯 拉歌王子传统干红葡萄酒 法国波尔多原瓶进口 750ml', 265.00, 1, 0, 11, 58, 1420793781, '', 598.00, 1),
(359, '/Uploads/image/product/20141208/20141208104934_81548.jpg', '泸州老窖 东方之珠 H3单瓶500ml 浓香型白酒礼盒 52度', 138.00, 1, 0, 1, 45, 1420796536, '', 268.00, 1),
(360, '/Uploads/image/product/20141208/20141208100458_24106.jpg', '泸州老窖 陈坛老窖  38度悦坛500ml 浓香型白酒特价', 138.00, 1, 0, 9, 43, 1420960566, '', 198.00, 1),
(363, '/Uploads/image/product/20141208/20141208104739_52915.jpg', '泸州老窖 东方之珠 H9单瓶500ml 浓香型白酒礼盒 52度', 296.00, 1, 0, 11, 49, 1420976900, '', 568.00, 1),
(364, '/Uploads/image/product/20141208/20141208104859_26677.jpg', '泸州老窖 东方之珠 H6单瓶500ml 浓香型白酒礼盒 52度', 189.00, 23, 0, 41, 47, 1421027220, '', 368.00, 1),
(365, '/Uploads/image/product/20141208/20141208104934_81548.jpg', '泸州老窖 东方之珠 H3单瓶500ml 浓香型白酒礼盒 52度', 138.00, 1, 0, 42, 45, 1421034905, '', 268.00, 0),
(366, '/Uploads/image/product/20141208/20141208102043_51050.jpg', '五粮液 锦绣前程  52度荣誉500ml*2 白酒特价礼盒装（一盒两瓶）送礼首选', 228.00, 1, 0, 9, 59, 1421059017, '', 368.00, 1),
(367, '/Uploads/image/product/20141206/20141206172117_22145.jpg', '泸州老窖 陈坛老窖 原浆酒 60度尚坛 5斤收藏酒 白酒礼盒装', 990.00, 1, 0, 1, 52, 1421119805, '', 1980.00, 1),
(368, '/Uploads/image/product/20141206/20141206171359_95009.jpg', '泸州老窖 陈坛老窖 52度贡坛白酒 500ml', 268.00, 1, 0, 9, 51, 1421128168, '', 598.00, 1),
(369, '/Public/Home/images/no_goods.jpg', 'test测试测试', 0.01, 1, 2, 9, 81, 1421136666, '', 123.00, 1),
(370, '/Uploads/image/product/20141208/20141208104934_81548.jpg', '泸州老窖 东方之珠 H3单瓶500ml 浓香型白酒礼盒 52度', 138.00, 1, 0, 44, 45, 1421196589, '', 268.00, 0),
(371, '/Uploads/image/product/20141206/20141206111934_57301.jpg', '泸州老窖 陈坛老窖 38度六年500ml 浓香型白酒特价', 49.00, 1, 0, 11, 30, 1421302631, '', 180.00, 1),
(372, '/Uploads/image/product/20141206/20141206150612_59792.jpg', '五粮液 锦绣前程 52度荣迁500ml 浓香型白酒 送礼首选', 388.00, 1, 0, 11, 42, 1421303450, '', 698.00, 1),
(373, '/Uploads/image/product/20141206/20141206150612_59792.jpg', '五粮液 锦绣前程 52度荣迁500ml 浓香型白酒 送礼首选', 388.00, 1, 0, 11, 42, 1421303576, '', 698.00, 1),
(374, '/Uploads/image/product/20141206/20141206143527_98239.jpg', '五粮液 锦绣前程  52度荣升500ml 浓香型纯粮白酒礼盒装', 179.00, 1, 0, 1, 36, 1421303677, '', 328.00, 1),
(375, '/Uploads/image/product/20141206/20141206143527_98239.jpg', '五粮液 锦绣前程  52度荣升500ml 浓香型纯粮白酒礼盒装', 179.00, 1, 0, 1, 36, 1421303692, '', 328.00, 1),
(376, '/Uploads/image/product/20141206/20141206110806_72954.jpg', '泸州老窖 陈坛老窖 52度珍坛500ml 浓香型白酒特价', 69.00, 3, 0, 11, 29, 1421303765, '', 325.00, 1),
(377, '/Uploads/image/product/20141206/20141206110806_72954.jpg', '泸州老窖 陈坛老窖 52度珍坛500ml 浓香型白酒特价', 69.00, 3, 0, 11, 29, 1421303776, '', 325.00, 1),
(378, '/Uploads/image/product/20141206/20141206110806_72954.jpg', '泸州老窖 陈坛老窖 52度珍坛500ml 浓香型白酒特价', 69.00, 3, 0, 11, 29, 1421303790, '', 325.00, 1),
(379, '/Uploads/image/product/20141208/20141208090840_55008.jpg', '弗瑞斯  老藤拉歌王子一级干红葡萄酒 法国波尔多原瓶进口 750ml', 128.00, 2, 0, 1, 57, 1421303843, '', 298.00, 1),
(382, '/Uploads/image/product/20141206/20141206110806_72954.jpg', '泸州老窖 陈坛老窖 52度珍坛500ml 浓香型白酒特价', 69.00, 2, 0, 11, 29, 1421304013, '', 325.00, 1),
(387, '/Uploads/image/product/20141206/20141206170009_56727.jpg', '五粮液 锦绣前程 52度荣世 500ml 浓香型白酒', 668.00, 1, 0, 1, 50, 1421304355, '', 798.00, 1),
(383, '/Uploads/image/product/20141206/20141206114510_92348.jpg', '泸州老窖 陈坛老窖  52度八年500ml 浓香型单瓶白酒 自饮应酬婚宴必备', 118.00, 1, 0, 11, 31, 1421304126, '', 256.00, 0),
(384, '/Uploads/image/product/20141208/20141208102043_51050.jpg', '五粮液 锦绣前程  52度荣誉500ml*2 白酒特价礼盒装（一盒两瓶）送礼首选', 228.00, 1, 0, 11, 59, 1421304143, '', 368.00, 1),
(385, '/Uploads/image/product/20141206/20141206175751_50564.jpg', '弗瑞斯 老藤慕斯卡特甜白葡萄酒 法国波尔多原瓶进口 750ml ', 328.00, 1, 0, 1, 56, 1421304260, '', 798.00, 1),
(388, '/Uploads/image/product/20141208/20141208091805_40110.jpg', '弗瑞斯 拉歌王子传统干红葡萄酒 法国波尔多原瓶进口 750ml', 265.00, 1, 0, 1, 58, 1421304369, '', 598.00, 1),
(389, '/Uploads/image/product/20141208/20141208091805_40110.jpg', '弗瑞斯 拉歌王子传统干红葡萄酒 法国波尔多原瓶进口 750ml', 265.00, 1, 0, 1, 58, 1421304435, '', 598.00, 1),
(390, '/Uploads/image/product/20141208/20141208104934_81548.jpg', '泸州老窖 东方之珠 H3单瓶500ml 浓香型白酒礼盒 52度', 138.00, 1, 0, 1, 45, 1421304627, '', 268.00, 0),
(391, '/Uploads/image/product/20141206/20141206171359_95009.jpg', '泸州老窖 陈坛老窖 52度贡坛白酒 500ml', 268.00, 1, 0, 1, 51, 1421304636, '', 598.00, 0),
(392, '/Public/Home/images/no_goods.jpg', 'test测试测试', 0.01, 1, 2, 45, 81, 1421369884, '', 123.00, 0);

-- --------------------------------------------------------

--
-- 表的结构 `jkd_product_collect`
--

CREATE TABLE IF NOT EXISTS `jkd_product_collect` (
`id` int(11) NOT NULL,
  `pro_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `published` int(11) NOT NULL,
  `update_time` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `jkd_product_collect`
--

INSERT INTO `jkd_product_collect` (`id`, `pro_id`, `uid`, `published`, `update_time`) VALUES
(28, 4, 1, 1415591351, 1415591351),
(35, 9, 8, 1417758927, 1417758927),
(36, 15, 8, 1417760808, 1417760808),
(38, 12, 8, 1417768735, 1417768735),
(58, 43, 9, 1420961490, 1420961490),
(40, 29, 8, 1418104530, 1418104530),
(56, 47, 9, 1420707869, 1420707869),
(44, 71, 11, 1418782530, 1418782530),
(55, 42, 29, 1420469230, 1420469230);

-- --------------------------------------------------------

--
-- 表的结构 `jkd_product_comment`
--

CREATE TABLE IF NOT EXISTS `jkd_product_comment` (
`id` int(11) NOT NULL,
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父级ID',
  `uid` int(11) NOT NULL,
  `pro_id` int(11) NOT NULL,
  `published` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `feel` tinyint(4) NOT NULL DEFAULT '5',
  `content` text NOT NULL,
  `oid` int(15) NOT NULL COMMENT '关联订单的id',
  `t_content` text COMMENT '客服回复'
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `jkd_product_comment`
--

INSERT INTO `jkd_product_comment` (`id`, `pid`, `uid`, `pro_id`, `published`, `update_time`, `status`, `feel`, `content`, `oid`, `t_content`) VALUES
(10, 1, 1, 23, 1415959645, 1415959645, 1, 5, '哈哈哈哈哈哈', 2, NULL),
(14, 1, 1, 2, 1415959734, 1417588334, 1, 5, 'ARD', 2, '测试');

-- --------------------------------------------------------

--
-- 表的结构 `jkd_product_order`
--

CREATE TABLE IF NOT EXISTS `jkd_product_order` (
`id` int(11) NOT NULL,
  `oid` char(20) NOT NULL,
  `uid` int(11) NOT NULL,
  `cart_id` varchar(255) NOT NULL COMMENT '购物车关联',
  `pro_id` varchar(255) NOT NULL,
  `aid` int(11) NOT NULL,
  `delivery` varchar(30) NOT NULL,
  `invoice` varchar(30) NOT NULL,
  `total_money` double(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单总金额',
  `total_credit` int(15) NOT NULL DEFAULT '0' COMMENT '订单总积分',
  `present` text NOT NULL,
  `freight` int(11) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `order_ip` char(16) NOT NULL,
  `published` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `old_status` int(1) NOT NULL DEFAULT '0' COMMENT '申请退款取消订单之前的状态',
  `t_why` varchar(100) NOT NULL COMMENT '退款原因',
  `t_content` text COMMENT '退款备注',
  `sq_status` int(1) NOT NULL DEFAULT '0' COMMENT '0为未申请 1 已申请退款 2为系统同意',
  `t_phone` int(12) DEFAULT NULL COMMENT '退款联系人的手机号',
  `t_username` varchar(10) DEFAULT NULL COMMENT '退款人姓名',
  `fee_name` varchar(30) NOT NULL DEFAULT '' COMMENT '物流公司名称',
  `fee_kid` char(20) NOT NULL DEFAULT '' COMMENT '快递单号',
  `alipay_id` char(30) NOT NULL DEFAULT '' COMMENT '支付宝订单号',
  `payway` char(30) NOT NULL DEFAULT '' COMMENT '支付方式',
  `order_status` int(1) NOT NULL DEFAULT '0' COMMENT '0为普通订单 1为拍拍订单 2为秒杀订单 3为团购订单',
  `fee_code` varchar(30) NOT NULL COMMENT '物流公司代码'
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 COMMENT='订单表';

--
-- 转存表中的数据 `jkd_product_order`
--

INSERT INTO `jkd_product_order` (`id`, `oid`, `uid`, `cart_id`, `pro_id`, `aid`, `delivery`, `invoice`, `total_money`, `total_credit`, `present`, `freight`, `status`, `content`, `order_ip`, `published`, `update_time`, `old_status`, `t_why`, `t_content`, `sq_status`, `t_phone`, `t_username`, `fee_name`, `fee_kid`, `alipay_id`, `payway`, `order_status`, `fee_code`) VALUES
(1, 'JFW2014122910111078', 1, '307', '31', 21, '不限时间', '不开具发票', 0.01, 0, '无礼品', 0, 1, '', '180.175.87.229', 1419819070, 1419819127, 0, '', NULL, 0, NULL, NULL, '', '', '2014122902651290', '支付宝在线支付', 0, ''),
(2, 'JFW2014122910145589', 1, '308', '31', 21, '不限时间', '不开具发票', 0.01, 0, '无礼品', 0, 4, '', '180.175.87.229', 1419819295, 1419822496, 3, '实物与网站不符', '1213144', 1, 2147483647, '华看来全', '天天快递', '15651515', '2014122902657590', '支付宝在线支付', 0, 'tiantian'),
(3, 'JFW2014122910171536', 1, '309', '31', 21, '不限时间', '不开具发票', 118.00, 0, '无礼品', 0, 7, '', '180.175.87.229', 1419819435, 1419905944, 0, '', NULL, 0, NULL, NULL, '', '', '', '', 0, ''),
(4, 'JFW2014122911120367', 1, '310', '41', 21, '不限时间', '不开具发票', 0.01, 0, '无礼品', 0, 5, '', '180.175.87.229', 1419822723, 1420596136, 0, '', NULL, 0, NULL, NULL, 'TNT', '2654845154', '2014122902751990', '支付宝在线支付', 3, 'tnt'),
(5, 'JFW2014122911244024', 1, '311', '23', 21, '不限时间', '不开具发票', 0.01, 0, '无礼品', 0, 5, '', '180.175.87.229', 1419823480, 1420596136, 0, '', NULL, 0, NULL, NULL, 'TNT', '123', '2014122902762790', '支付宝在线支付', 2, 'tnt'),
(6, 'JFW2014122915374025', 1, '312', '60', 21, '不限时间', '发票抬头:个人-发表内容:酒水', 1198.00, 0, '无礼品', 0, 5, '', '117.185.27.104', 1419838660, 1420797861, 0, '', NULL, 0, NULL, NULL, '天天快递', '123456', '', '', 0, 'tiantian'),
(7, 'JFW2014122915400114', 1, '313', '79', 21, '不限时间', '发票抬头:个人-发表内容:酒水', 222.00, 0, '无礼品', 0, 5, '', '180.175.87.229', 1419838801, 1420596136, 0, '', NULL, 0, NULL, NULL, '天天快递', '111', '', '', 0, 'tiantian'),
(8, 'JFW2014123011181080', 21, '316', '57', 22, '不限时间', '不开具发票', 99.00, 0, '无礼品', 10, 2, '', '42.122.45.147', 1419909490, 1419909525, 0, '', NULL, 0, NULL, NULL, '', '', '', '', 0, ''),
(9, 'JFW2014123011200816', 21, '317', '61', 22, '不限时间', '不开具发票', 1656.00, 0, '无礼品', 0, 7, '', '180.213.131.220', 1419909608, 1420596108, 0, '', NULL, 0, NULL, NULL, '天天快递', '111', '', '', 0, 'tiantian'),
(10, 'JFW2014123013520524', 11, '277,318', '72,60', 18, '不限时间', '不开具发票', 1629.00, 0, '无礼品', 0, 7, '', '180.175.156.130', 1419918725, 1420005315, 0, '', NULL, 0, NULL, NULL, '', '', '', '', 0, ''),
(11, 'JFW2014123109090527', 27, '321', '76', 23, '不限时间', '不开具发票', 85.00, 0, '无礼品', 10, 7, '', '180.213.131.220', 1419988145, 1420075398, 0, '', NULL, 0, NULL, NULL, '', '', '', '', 0, ''),
(12, 'JFW2014123109125334', 27, '322', '76', 23, '不限时间', '不开具发票', 85.00, 0, '无礼品', 10, 7, '', '42.122.45.147', 1419988373, 1420075398, 0, '', NULL, 0, NULL, NULL, '', '', '', '', 0, ''),
(13, 'JFW2015010414495230', 11, '327', '32', 18, '不限时间', '不开具发票', 360.00, 0, '无礼品', 0, 7, '', '180.175.156.130', 1420354192, 1420441337, 0, '', NULL, 0, NULL, NULL, '', '', '', '', 0, ''),
(14, 'JFW2015010522565168', 29, '333', '57', 25, '周六日/节假日', '发票抬头:公司-发票内容:明细', 99.00, 0, '无礼品', 10, 7, '', '180.175.156.130', 1420469811, 1420556992, 0, '', NULL, 0, NULL, NULL, '', '', '', '', 0, ''),
(15, 'JFW2015010715064435', 11, '328,336', '32,59', 18, '不限时间', '不开具发票', 588.00, 0, '无礼品', 0, 7, '', '180.175.87.229', 1420614404, 1420700805, 0, '', NULL, 0, NULL, NULL, '', '', '', '', 0, ''),
(16, 'JFW2015010715355678', 11, '337,338', '59,30', 28, '周一至周五', '不开具发票', 22976.00, 0, '无礼品', 0, 7, '', '180.175.156.130', 1420616156, 1420702708, 0, '', NULL, 0, NULL, NULL, '', '', '', '', 0, ''),
(17, 'JFW2015010911381476', 9, '349', '80', 29, '不限时间', '发票抬头:公司-发票内容:保健品', 2222.00, 222, '无礼品', 0, 1, '', '180.175.87.229', 1420774694, 1421127896, 0, '', NULL, 0, NULL, NULL, '', '', '', '', 3, ''),
(18, 'JFW2015010915035277', 11, '352', '57', 18, '不限时间', '不开具发票', 128.00, 0, '无礼品', 0, 0, '', '180.175.156.130', 1420787032, 1420787032, 0, '', NULL, 0, NULL, NULL, '', '', '', '', 0, ''),
(19, 'JFW2015010916013873', 11, '354', '56', 28, '不限时间', '不开具发票', 328.00, 0, '无礼品', 0, 0, '', '180.175.156.130', 1420790498, 1420790498, 0, '', NULL, 0, NULL, NULL, '', '', '', '', 0, ''),
(20, 'JFW2015010916434689', 11, '355', '56', 18, '不限时间', '不开具发票', 328.00, 0, '无礼品', 0, 0, '', '180.175.156.130', 1420793026, 1420793026, 0, '', NULL, 0, NULL, NULL, '', '', '', '', 0, ''),
(21, 'JFW2015010916514152', 11, '356', '56', 18, '不限时间', '不开具发票', 328.00, 0, '无礼品', 0, 0, '', '180.175.156.130', 1420793501, 1420793501, 0, '', NULL, 0, NULL, NULL, '', '', '', '', 0, ''),
(22, 'JFW2015010916521333', 11, '357', '56', 18, '不限时间', '不开具发票', 328.00, 0, '无礼品', 0, 0, '', '180.175.156.130', 1420793533, 1420793533, 0, '', NULL, 0, NULL, NULL, '', '', '', '', 0, ''),
(23, 'JFW2015010916563523', 11, '358', '58', 18, '不限时间', '不开具发票', 265.00, 0, '无礼品', 0, 0, '', '180.175.156.130', 1420793795, 1420793795, 0, '', NULL, 0, NULL, NULL, '', '', '', '', 0, ''),
(24, 'JFW2015011108431148', 1, '320,359', '49,45', 21, '不限时间', '不开具发票', 2959842.00, 0, '无礼品', 0, 1, '', '180.175.36.19', 1420936991, 1420944774, 0, '', NULL, 0, NULL, NULL, '', '', '', '', 0, ''),
(25, 'JFW2015011115161651', 9, '353,360', '33,43', 30, '不限时间', '不开具发票', 786.00, 0, '无礼品', 0, 1, '', '180.175.36.19', 1420960576, 1421128054, 0, '', NULL, 0, NULL, NULL, '', '', '', '', 0, ''),
(26, 'JFW2015011209512480', 41, '364', '47', 31, '周六日/节假日', '不开具发票', 4347.00, 0, '无礼品', 0, 0, '', '125.122.107.84', 1421027484, 1421027484, 0, '', NULL, 0, NULL, NULL, '', '', '', '', 0, ''),
(27, 'JFW2015011311300997', 1, '367', '52', 21, '不限时间', '不开具发票', 990.00, 0, '无礼品', 0, 1, '', '180.175.36.19', 1421119809, 1421128280, 0, '', NULL, 0, NULL, NULL, '', '', '', '', 0, ''),
(28, 'JFW2015011313493448', 9, '366,368', '59,51', 30, '不限时间', '不开具发票', 496.00, 0, '无礼品', 0, 1, '', '180.175.36.19', 1421128174, 1421128268, 0, '', NULL, 0, NULL, NULL, '', '', '', '', 0, ''),
(29, 'JFW2015011316131342', 9, '369', '81', 30, '周一至周五', '不开具发票', 0.01, 2, '无礼品', 10, 0, '', '180.175.36.19', 1421136793, 1421136793, 0, '', NULL, 0, NULL, NULL, '', '', '', '', 0, ''),
(30, 'JFW2015011514172069', 11, '363,371', '49,30', 28, '不限时间', '不开具发票', 345.00, 0, '无礼品', 0, 0, '', '180.175.217.222', 1421302640, 1421302640, 0, '', NULL, 0, NULL, NULL, '', '', '', '', 0, ''),
(31, 'JFW2015011514305989', 11, '372', '42', 18, '不限时间', '不开具发票', 388.00, 0, '无礼品', 0, 0, '', '180.175.217.222', 1421303459, 1421303459, 0, '', NULL, 0, NULL, NULL, '', '', '', '', 0, ''),
(32, 'JFW2015011514331629', 11, '373', '42', 18, '不限时间', '不开具发票', 388.00, 0, '无礼品', 0, 0, '', '180.175.217.222', 1421303596, 1421303596, 0, '', NULL, 0, NULL, NULL, '', '', '', '', 0, ''),
(33, 'JFW2015011514344564', 1, '374', '36', 21, '不限时间', '不开具发票', 179.00, 0, '无礼品', 0, 0, '', '180.175.36.19', 1421303685, 1421303685, 0, '', NULL, 0, NULL, NULL, '', '', '', '', 0, ''),
(34, 'JFW2015011514345924', 1, '375', '36', 21, '不限时间', '不开具发票', 179.00, 0, '无礼品', 0, 0, '', '180.175.36.19', 1421303699, 1421303699, 0, '', NULL, 0, NULL, NULL, '', '', '', '', 0, ''),
(35, 'JFW2015011514361251', 11, '376', '29', 18, '不限时间', '不开具发票', 69.00, 0, '无礼品', 10, 0, '', '180.175.217.222', 1421303772, 1421303772, 0, '', NULL, 0, NULL, NULL, '', '', '', '', 0, ''),
(36, 'JFW2015011514362485', 11, '377', '29', 18, '不限时间', '不开具发票', 69.00, 0, '无礼品', 10, 0, '', '180.175.217.222', 1421303784, 1421303784, 0, '', NULL, 0, NULL, NULL, '', '', '', '', 0, ''),
(37, 'JFW2015011514365222', 11, '378', '29', 18, '不限时间', '不开具发票', 138.00, 0, '无礼品', 0, 0, '', '180.175.217.222', 1421303812, 1421303812, 0, '', NULL, 0, NULL, NULL, '', '', '', '', 0, ''),
(38, 'JFW2015011514373621', 1, '379', '57', 21, '不限时间', '不开具发票', 256.00, 0, '无礼品', 0, 0, '', '180.175.36.19', 1421303856, 1421303856, 0, '', NULL, 0, NULL, NULL, '', '', '', '', 0, ''),
(39, 'JFW2015011514404019', 11, '382', '29', 18, '不限时间', '不开具发票', 138.00, 0, '无礼品', 0, 0, '', '180.175.217.222', 1421304040, 1421304040, 0, '', NULL, 0, NULL, NULL, '', '', '', '', 0, ''),
(40, 'JFW2015011514425883', 11, '384', '59', 18, '不限时间', '不开具发票', 228.00, 0, '无礼品', 0, 0, '', '180.175.217.222', 1421304178, 1421304178, 0, '', NULL, 0, NULL, NULL, '', '', '', '', 0, ''),
(41, 'JFW2015011514445918', 1, '385', '56', 21, '不限时间', '不开具发票', 328.00, 0, '无礼品', 0, 0, '', '180.175.36.19', 1421304299, 1421304299, 0, '', NULL, 0, NULL, NULL, '', '', '', '', 0, ''),
(42, 'JFW2015011514463839', 1, '388', '58', 21, '不限时间', '不开具发票', 265.00, 0, '无礼品', 0, 0, '', '180.175.36.19', 1421304398, 1421304398, 0, '', NULL, 0, NULL, NULL, '', '', '', '', 0, ''),
(43, 'JFW2015011514491061', 1, '387', '50', 21, '不限时间', '不开具发票', 668.00, 0, '无礼品', 0, 0, '', '180.175.36.19', 1421304550, 1421304550, 0, '', NULL, 0, NULL, NULL, '', '', '', '', 0, ''),
(44, 'JFW2015011514510263', 1, '389', '58', 21, '不限时间', '不开具发票', 265.00, 0, '无礼品', 0, 0, '', '180.175.36.19', 1421304662, 1421304662, 0, '', NULL, 0, NULL, NULL, '', '', '', '', 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `jkd_product_prop`
--

CREATE TABLE IF NOT EXISTS `jkd_product_prop` (
`id` int(10) unsigned NOT NULL COMMENT '属性 ID',
  `category_id` int(10) unsigned NOT NULL,
  `parent_prop_id` int(10) unsigned DEFAULT '0' COMMENT '上级属性ID',
  `prop_name` varchar(100) DEFAULT NULL,
  `type` enum('input','optional','multiCheck') DEFAULT NULL COMMENT '属性值类型。可选值：input(输入)、optional（单选）multiCheck （多选）',
  `is_image_prop` int(1) NOT NULL DEFAULT '0' COMMENT '是否关键属性。可选值:1(是),0(否)',
  `is_sale_prop` int(1) NOT NULL DEFAULT '0' COMMENT '是否销售属性，用于商品属性的组合',
  `status` int(11) DEFAULT '0' COMMENT '状态。可选值:normal(正常),deleted(删除)',
  `sort` tinyint(3) unsigned DEFAULT '255'
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `jkd_prop_value`
--

CREATE TABLE IF NOT EXISTS `jkd_prop_value` (
`id` int(10) unsigned NOT NULL COMMENT '属性值ID',
  `category_id` int(10) unsigned NOT NULL,
  `value_name` varchar(255) DEFAULT NULL COMMENT '属性值',
  `prop_id` int(10) unsigned NOT NULL COMMENT '商品属性ID',
  `sort` tinyint(3) unsigned DEFAULT '255' COMMENT '排列序号。取值范围:大于零的整数'
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `jkd_role`
--

CREATE TABLE IF NOT EXISTS `jkd_role` (
`id` smallint(6) unsigned NOT NULL,
  `name` varchar(20) NOT NULL,
  `pid` smallint(6) DEFAULT NULL,
  `status` tinyint(1) unsigned DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='权限角色表';

--
-- 转存表中的数据 `jkd_role`
--

INSERT INTO `jkd_role` (`id`, `name`, `pid`, `status`, `remark`) VALUES
(1, '超级管理员', 0, 1, '系统内置超级管理员组，不受权限分配账号限制'),
(2, '管理员', 1, 1, '拥有系统仅此于超级管理员的权限'),
(3, '领导', 1, 1, '拥有所有操作的读权限，无增加、删除、修改的权限'),
(4, '测试组', 1, 1, '测试');

-- --------------------------------------------------------

--
-- 表的结构 `jkd_role_user`
--

CREATE TABLE IF NOT EXISTS `jkd_role_user` (
  `role_id` mediumint(9) unsigned DEFAULT NULL,
  `user_id` char(32) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户角色表';

--
-- 转存表中的数据 `jkd_role_user`
--

INSERT INTO `jkd_role_user` (`role_id`, `user_id`) VALUES
(3, '4');

-- --------------------------------------------------------

--
-- 表的结构 `jkd_sku`
--

CREATE TABLE IF NOT EXISTS `jkd_sku` (
`id` int(10) unsigned NOT NULL COMMENT 'sku的id',
  `product_id` int(11) unsigned NOT NULL,
  `props` varchar(1000) DEFAULT NULL COMMENT 'sku的销售属性组合字符串（颜色，大小，等等，可通过类目API获取某类目下的销售属性）,格式是p1:v1;p2:v2',
  `prop_names` text COMMENT '对应的销售属性名称的中文名字串，格式如：pid1:pid_name1:vid_name1;pid2:vid2:pid_name2……',
  `stock` int(11) NOT NULL DEFAULT '0' COMMENT '属于这个sku的商品的数量，',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '属于这个sku的商品的价格 取值范围:0-100000000;精确到2位小数;单位:元。如:200.07，表示:200元7分。',
  `market_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `pic` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT '0' COMMENT 'sku状态。0:正常;1:下架;2:已售罄',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `jkd_sku`
--

INSERT INTO `jkd_sku` (`id`, `product_id`, `props`, `prop_names`, `stock`, `price`, `market_price`, `pic`, `status`, `create_time`, `update_time`) VALUES
(87, 86, '5:9,7:6,14:14', NULL, 1000, '50.00', '70.00', NULL, 0, 1426252840, 1426252840),
(88, 87, '5:9,7:5,14:14', NULL, 10, '50.00', '70.00', NULL, 0, 1426303328, 1426303328),
(89, 90, '5:9,7:6,14:14', '蓝色,L,234', 29, '15.00', '20.00', NULL, 0, 1426305940, 1426314717),
(90, 90, '5:9,7:5,14:14', '蓝色,M,234', 28, '16.00', '20.00', NULL, 0, 1426305940, 1426314717),
(91, 1, '5:8,7:6,14:14', '红色,L,234', 59, '15.00', '30.00', NULL, 0, 1426310823, 1426310823),
(92, 1, '5:8,7:5,14:14', '红色,M,234', 58, '13.00', '20.00', NULL, 0, 1426310823, 1426310823),
(93, 1, '5:9,7:6,14:14', '蓝色,L,234', 57, '12.00', '20.00', NULL, 0, 1426310823, 1426310823),
(94, 1, '5:9,7:7,14:14', '蓝色,XL,234', 30, '14.00', '20.00', NULL, 0, 1426310880, 1426310880),
(95, 1, '5:9,7:6,14:14', '蓝色,L,234', 29, '15.00', '20.00', NULL, 0, 1426310880, 1426310880),
(96, 1, '5:9,7:5,14:14', '蓝色,M,234', 28, '16.00', '20.00', NULL, 0, 1426310880, 1426310880),
(97, 1, '5:9,7:7,14:14', '蓝色,XL,234', 30, '14.00', '20.00', NULL, 0, 1426311013, 1426311013),
(98, 1, '5:9,7:6,14:14', '蓝色,L,234', 29, '15.00', '20.00', NULL, 0, 1426311013, 1426311013),
(99, 1, '5:9,7:5,14:14', '蓝色,M,234', 28, '16.00', '20.00', NULL, 0, 1426311013, 1426311013),
(100, 1, '5:9,7:7,14:14', '蓝色,XL,234', 30, '14.00', '20.00', NULL, 0, 1426311026, 1426311026),
(101, 1, '5:9,7:6,14:14', '蓝色,L,234', 29, '15.00', '20.00', NULL, 0, 1426311026, 1426311026),
(102, 1, '5:9,7:5,14:14', '蓝色,M,234', 28, '16.00', '20.00', NULL, 0, 1426311026, 1426311026),
(103, 1, '5:9,7:7,14:14', '蓝色,XL,234', 30, '14.00', '20.00', NULL, 0, 1426311196, 1426311196),
(104, 1, '5:9,7:6,14:14', '蓝色,L,234', 29, '15.00', '20.00', NULL, 0, 1426311196, 1426311196),
(105, 1, '5:9,7:5,14:14', '蓝色,M,234', 28, '16.00', '20.00', NULL, 0, 1426311196, 1426311196),
(106, 1, '5:9,7:7,14:14', '蓝色,XL,234', 30, '14.00', '20.00', NULL, 0, 1426311210, 1426311210),
(107, 1, '5:9,7:6,14:14', '蓝色,L,234', 29, '15.00', '20.00', NULL, 0, 1426311210, 1426311210),
(108, 1, '5:9,7:5,14:14', '蓝色,M,234', 28, '16.00', '20.00', NULL, 0, 1426311210, 1426311210),
(109, 1, '5:9,7:7,14:14', '蓝色,XL,234', 30, '14.00', '20.00', NULL, 0, 1426311594, 1426311594),
(110, 90, '5:9,7:7,14:14', '蓝色,XL,234', 30, '14.00', '20.00', NULL, 0, 1426311692, 1426314717);

-- --------------------------------------------------------

--
-- 表的结构 `jkd_tag`
--

CREATE TABLE IF NOT EXISTS `jkd_tag` (
`id` int(11) NOT NULL,
  `name` char(20) NOT NULL,
  `unique_id` char(20) NOT NULL,
  `content` text NOT NULL,
  `lang` varchar(10) NOT NULL DEFAULT 'zh-cn'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jkd_ad`
--
ALTER TABLE `jkd_ad`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jkd_admin`
--
ALTER TABLE `jkd_admin`
 ADD PRIMARY KEY (`aid`);

--
-- Indexes for table `jkd_category`
--
ALTER TABLE `jkd_category`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jkd_field`
--
ALTER TABLE `jkd_field`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_field_model` (`model_id`);

--
-- Indexes for table `jkd_images`
--
ALTER TABLE `jkd_images`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jkd_input`
--
ALTER TABLE `jkd_input`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_field_input` (`field_id`);

--
-- Indexes for table `jkd_kuaidi`
--
ALTER TABLE `jkd_kuaidi`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jkd_link`
--
ALTER TABLE `jkd_link`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jkd_log`
--
ALTER TABLE `jkd_log`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jkd_member`
--
ALTER TABLE `jkd_member`
 ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `jkd_member_address`
--
ALTER TABLE `jkd_member_address`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jkd_message`
--
ALTER TABLE `jkd_message`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jkd_model`
--
ALTER TABLE `jkd_model`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jkd_nav`
--
ALTER TABLE `jkd_nav`
 ADD PRIMARY KEY (`id`,`keywords`);

--
-- Indexes for table `jkd_news`
--
ALTER TABLE `jkd_news`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jkd_node`
--
ALTER TABLE `jkd_node`
 ADD PRIMARY KEY (`id`), ADD KEY `level` (`level`), ADD KEY `pid` (`pid`), ADD KEY `status` (`status`), ADD KEY `name` (`name`);

--
-- Indexes for table `jkd_page`
--
ALTER TABLE `jkd_page`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jkd_paipai`
--
ALTER TABLE `jkd_paipai`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jkd_paipai_offer`
--
ALTER TABLE `jkd_paipai_offer`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jkd_product`
--
ALTER TABLE `jkd_product`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jkd_product_ask`
--
ALTER TABLE `jkd_product_ask`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jkd_product_cart`
--
ALTER TABLE `jkd_product_cart`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jkd_product_collect`
--
ALTER TABLE `jkd_product_collect`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jkd_product_comment`
--
ALTER TABLE `jkd_product_comment`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jkd_product_order`
--
ALTER TABLE `jkd_product_order`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `oid` (`oid`);

--
-- Indexes for table `jkd_product_prop`
--
ALTER TABLE `jkd_product_prop`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jkd_prop_value`
--
ALTER TABLE `jkd_prop_value`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jkd_role`
--
ALTER TABLE `jkd_role`
 ADD PRIMARY KEY (`id`), ADD KEY `pid` (`pid`), ADD KEY `status` (`status`);

--
-- Indexes for table `jkd_role_user`
--
ALTER TABLE `jkd_role_user`
 ADD KEY `group_id` (`role_id`), ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `jkd_sku`
--
ALTER TABLE `jkd_sku`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_sku_item1` (`product_id`);

--
-- Indexes for table `jkd_tag`
--
ALTER TABLE `jkd_tag`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jkd_ad`
--
ALTER TABLE `jkd_ad`
MODIFY `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `jkd_admin`
--
ALTER TABLE `jkd_admin`
MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `jkd_category`
--
ALTER TABLE `jkd_category`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `jkd_field`
--
ALTER TABLE `jkd_field`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT for table `jkd_images`
--
ALTER TABLE `jkd_images`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=814;
--
-- AUTO_INCREMENT for table `jkd_input`
--
ALTER TABLE `jkd_input`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT for table `jkd_kuaidi`
--
ALTER TABLE `jkd_kuaidi`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `jkd_link`
--
ALTER TABLE `jkd_link`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `jkd_log`
--
ALTER TABLE `jkd_log`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jkd_member`
--
ALTER TABLE `jkd_member`
MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `jkd_member_address`
--
ALTER TABLE `jkd_member_address`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `jkd_message`
--
ALTER TABLE `jkd_message`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `jkd_model`
--
ALTER TABLE `jkd_model`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT for table `jkd_nav`
--
ALTER TABLE `jkd_nav`
MODIFY `id` mediumint(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `jkd_news`
--
ALTER TABLE `jkd_news`
MODIFY `id` mediumint(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `jkd_node`
--
ALTER TABLE `jkd_node`
MODIFY `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=85;
--
-- AUTO_INCREMENT for table `jkd_page`
--
ALTER TABLE `jkd_page`
MODIFY `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `jkd_paipai`
--
ALTER TABLE `jkd_paipai`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `jkd_paipai_offer`
--
ALTER TABLE `jkd_paipai_offer`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `jkd_product`
--
ALTER TABLE `jkd_product`
MODIFY `id` mediumint(8) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jkd_product_ask`
--
ALTER TABLE `jkd_product_ask`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `jkd_product_cart`
--
ALTER TABLE `jkd_product_cart`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=393;
--
-- AUTO_INCREMENT for table `jkd_product_collect`
--
ALTER TABLE `jkd_product_collect`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=59;
--
-- AUTO_INCREMENT for table `jkd_product_comment`
--
ALTER TABLE `jkd_product_comment`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `jkd_product_order`
--
ALTER TABLE `jkd_product_order`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT for table `jkd_product_prop`
--
ALTER TABLE `jkd_product_prop`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '属性 ID',AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `jkd_prop_value`
--
ALTER TABLE `jkd_prop_value`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '属性值ID',AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `jkd_role`
--
ALTER TABLE `jkd_role`
MODIFY `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `jkd_sku`
--
ALTER TABLE `jkd_sku`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'sku的id',AUTO_INCREMENT=111;
--
-- AUTO_INCREMENT for table `jkd_tag`
--
ALTER TABLE `jkd_tag`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 限制导出的表
--

--
-- 限制表 `jkd_field`
--
ALTER TABLE `jkd_field`
ADD CONSTRAINT `jkd_field_ibfk_1` FOREIGN KEY (`model_id`) REFERENCES `jkd_model` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `jkd_input`
--
ALTER TABLE `jkd_input`
ADD CONSTRAINT `jkd_input_ibfk_1` FOREIGN KEY (`field_id`) REFERENCES `jkd_field` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
