CREATE TABLE IF NOT EXISTS `__PREFIX__flow_instance` (
  `id` char(36) NOT NULL,
  `originator` char(36) NOT NULL,
  `scheme` char(36) NOT NULL,
  `createtime` datetime DEFAULT NULL,
  `instancestatus` int(11) NOT NULL COMMENT '0 草稿1 进行中 2 完成 3 取消',
  `bizobjectid` char(36) DEFAULT NULL,
  `instancecode` varchar(255) DEFAULT NULL,
  `completedtime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='流程实例';

--
-- 表的结构 `__PREFIX__flow_scheme`
--
CREATE TABLE IF NOT EXISTS `__PREFIX__flow_scheme` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `flowcode` varchar(255) DEFAULT NULL COMMENT '流程代码',
  `flowname` varchar(255) DEFAULT NULL COMMENT '流程名称',
  `flowtype` varchar(255) DEFAULT NULL COMMENT '流程类型',
  `flowversion` varchar(255) DEFAULT NULL COMMENT '版本',
  `flowcanuser` varchar(255) DEFAULT NULL,
  `flowcontent` longtext COMMENT '流程json',
  `frmcode` varchar(255) DEFAULT NULL,
  `frmtype` varchar(255) DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `createtime` datetime DEFAULT NULL,
  `createuser` varchar(255) DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  `updateuser` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `bizscheme` varchar(255) DEFAULT '' COMMENT '对应业务表',
  `isenable` tinyint(1) unsigned zerofill DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 COMMENT='分组管理';

--
-- 表的结构 `__PREFIX__flow_task`
--
CREATE TABLE IF NOT EXISTS `__PREFIX__flow_task` (
  `id` char(36) NOT NULL COMMENT '主键',
  `previd` int(11) DEFAULT NULL ,
  `prevstepid` int(11) DEFAULT NULL,
  `receiveid` char(36) DEFAULT NULL COMMENT '审批人',
  `stepid` varchar(255) DEFAULT NULL COMMENT '步骤id',
  `flowid` int(11) DEFAULT NULL COMMENT '流程id',
  `stepname` varchar(255) DEFAULT NULL COMMENT '步骤名称',
  `instanceid` char(36) DEFAULT NULL COMMENT '实例id',
  `groupid` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `tittle` varchar(255) DEFAULT NULL,
  `senderid` int(11) DEFAULT NULL COMMENT '上一步审核人',
  `opentime` datetime DEFAULT NULL COMMENT '打开流程时间',
  `completedtime` datetime DEFAULT NULL COMMENT '审批时间',
  `comment` varchar(255) DEFAULT NULL COMMENT '部门负责人',
  `isSign` varchar(255) DEFAULT NULL,
  `status` int(10) DEFAULT NULL COMMENT '状态 0-审批中 2-完成 3-取消',
  `note` varchar(255) DEFAULT NULL,
  `sort` varchar(255) DEFAULT NULL,
  `createtime` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='流程任务';

-- ----------------------------
-- Table structure for __PREFIX__flow_number
-- ----------------------------
CREATE TABLE IF NOT EXISTS `__PREFIX__flow_number` (
  `id` int(13) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL COMMENT '流程代码',
  `year` varchar(255) DEFAULT NULL COMMENT '年',
  `month` varchar(255) DEFAULT NULL COMMENT '月',
  `index` int(13) DEFAULT NULL COMMENT '当前序号',
  `lengh` int(13) DEFAULT NULL COMMENT '长度',
  `pre` varchar(255) DEFAULT NULL COMMENT '前缀',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of __PREFIX__flow_number
-- ----------------------------
INSERT INTO `__PREFIX__flow_number` VALUES ('1', 'leave', 'Y', 'Y', '45', '5', 'QJ');
SET FOREIGN_KEY_CHECKS=1;

--
-- 视图结构 `__PREFIX__view_instance`
--
DROP TABLE IF EXISTS `__PREFIX__view_instance`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `__PREFIX__view_instance` AS select `a`.`id` AS `id`,`a`.`originator` AS `originator`,`a`.`scheme` AS `scheme`,`a`.`createtime` AS `createtime`,`a`.`instancestatus` AS `instancestatus`,`a`.`bizobjectid` AS `bizobjectid`,`a`.`instancecode` AS `instancecode`,`a`.`completedtime` AS `completedtime`,`b`.`nickname` AS `nickname`,`c`.`flowname` AS `flowname` from ((`__PREFIX__flow_instance` `a` left join `__PREFIX__admin` `b` on((`a`.`originator` = `b`.`id`))) left join `__PREFIX__flow_scheme` `c` on((`a`.`scheme` = `c`.`id`)));

-- --------------------------------------------------------

--
-- 视图结构 `__PREFIX__view_workitem`
--
DROP view IF EXISTS `__PREFIX__view_workitem`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `__PREFIX__view_workitem` AS select `b`.`instancestatus` AS `instancestatus`,`b`.`instancecode` AS `instancecode`,`b`.`bizobjectid` AS `bizobjectid`,`c`.`bizscheme` AS `bizscheme`,`e`.`nickname` AS `receivename`,`c`.`flowname` AS `flowname`,`c`.`flowcode` AS `flowcode`,`c`.`url` AS `url`,`b`.`originator` AS `originator`,`d`.`nickname` AS `nickname`,`a`.`id` AS `id`,`a`.`previd` AS `previd`,`a`.`prevstepid` AS `prevstepid`,`a`.`receiveid` AS `receiveid`,`a`.`stepid` AS `stepid`,`a`.`flowid` AS `flowid`,`a`.`stepname` AS `stepname`,`a`.`instanceid` AS `instanceid`,`a`.`groupid` AS `groupid`,`a`.`type` AS `type`,`a`.`tittle` AS `tittle`,`a`.`senderid` AS `senderid`,`a`.`opentime` AS `opentime`,`a`.`completedtime` AS `completedtime`,`a`.`comment` AS `comment`,`a`.`isSign` AS `isSign`,`a`.`status` AS `status`,`a`.`note` AS `note`,`a`.`sort` AS `sort`,`a`.`createtime` AS `createtime` from ((((`__PREFIX__flow_instance` `b` left join `__PREFIX__flow_task` `a` on((`a`.`instanceid` = `b`.`id`))) left join `__PREFIX__flow_scheme` `c` on((`b`.`scheme` = `c`.`id`))) left join `__PREFIX__admin` `d` on((`b`.`originator` = `d`.`id`))) left join `__PREFIX__admin` `e` on((`a`.`receiveid` = `e`.`id`)));

--
-- 表的结构 `__PREFIX__flow_leave`
--

CREATE TABLE IF NOT EXISTS `__PREFIX__flow_leave` (
  `id` char(36) NOT NULL,
  `start_time` datetime DEFAULT NULL COMMENT '开始时间',
  `end_time` datetime DEFAULT NULL COMMENT '结束时间',
  `content` varchar(255) DEFAULT '' COMMENT '请假原因',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='请假表';

-- 请假表添加天数字段
BEGIN;
ALTER TABLE `__PREFIX__flow_leave` ADD  COLUMN   `day` int(10)  COMMENT '请假天数';
COMMIT;

BEGIN;

INSERT INTO `__PREFIX__flow_scheme` (`id`, `flowcode`, `flowname`, `flowtype`, `flowversion`, `flowcanuser`, `flowcontent`, `frmcode`, `frmtype`, `weight`, `description`, `createtime`, `createuser`, `updatetime`, `updateuser`, `url`, `bizscheme`, `isenable`) VALUES
(33, 'leave', '请假流程', NULL, NULL, NULL, '{"nodes":[{"left":85,"type":"start","removable":false,"name":"开始","className":"node-start","id":"1523002631942","positionX":150,"positionY":20,"alt":true,"setInfo":{"nodeName":"开始"}},{"left":81,"top":159,"type":"node","id":"1523002636766","name":"上级领导","positionX":140,"positionY":120,"className":"node-process","removable":true,"setInfo":{"NodeDesignateData":{"users":[""],"role":["1"],"org":[]},"nodeName":"上级领导","nodeCode":"node_2","nodeRejectType":"0","nodeDesignate":"role","Taged":1,"UserId":"00000000-0000-0000-0000-000000000000","UserName":"超级管理员","Description":"自己处理一下","TagedTime":"2018-04-06 16:22","method":"admin","users":"admin2899999","confluence":"any"}},{"className":"node-end","top":368,"type":"end","name":"结束","id":"1523002639310","positionX":150,"positionY":440,"removable":false,"setInfo":{"NodeDesignateData":{"users":["49df1602-f5f3-4d52-afb7-3802da619558"],"role":[],"org":[]},"nodeName":"结束","nodeCode":"node_3","nodeRejectType":"0","nodeDesignate":"SPECIAL_USER"}},{"name":"用户审批","procId":"0","type":"node","username":"aaaaa","desc":"","nodeType":1,"id":"flow-chart-node01560705015364","setInfo":{"nodeName":"用户审批","NodeDesignateData":{"users":["1"],"role":[""]},"nodeDesignate":"user"},"positionX":140,"positionY":320,"className":"node-process","removable":true},{"name":"角色审批","procId":"0","type":"node","username":"aaaaa","removable":true,"desc":"审批节点","nodeType":1,"id":"flow-chart-node01568377281166","setInfo":{"nodeName":"角色审批","NodeDesignateData":{"users":[""],"role":["1"]},"nodeDesignate":"role","confluence":"any"},"positionX":360,"positionY":220,"className":"node-process"}],"lines":[{"id":"con_25","from":"1523002631942","to":"1523002636766","data":{}},{"id":"con_31","from":"1523002636766","to":"flow-chart-node01568377281166","data":{"setInfo":{"express":"day  >  3","label":"请假天数大于3"}}},{"id":"con_37","from":"flow-chart-node01568377281166","to":"flow-chart-node01560705015364","data":{}},{"id":"con_43","from":"flow-chart-node01560705015364","to":"1523002639310","data":{}},{"id":"con_49","from":"1523002636766","to":"flow-chart-node01560705015364","data":{"setInfo":{"express":"day < 3 or day =3","label":"请假天输小于3"}}}]}', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00', NULL, NULL, '__PREFIX__flow_leave', 1);
-- --------------------------------------------------------
COMMIT;

BEGIN;

INSERT INTO `__PREFIX__flow_leave` (`id`, `start_time`, `end_time`, `content`,`day`) VALUES
('0d2c5685-7403-48cf-91e1-00975cf143dd', '2019-06-09 10:50:38', '2019-06-09 10:50:38', '生病',1),
('77b64a55-5ef4-4703-bf3d-eac67fbcb8d7', '2019-06-09 10:49:09', '2019-06-09 10:49:09', '生病',1);
COMMIT;

-- 用户表添加部门字段
BEGIN;
ALTER TABLE `__PREFIX__admin` ADD  COLUMN department_id int(10);
COMMIT;


-- 修改默认用户部门
BEGIN;
UPDATE `__PREFIX__admin`
SET department_id=2
WHERE id='3';
COMMIT;

CREATE TABLE IF NOT EXISTS `__PREFIX__flow_department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `createtime` int(11) DEFAULT NULL,
  `updatetime` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `manager` varchar(255) DEFAULT NULL COMMENT '部门负责人',
  `managername` varchar(255) DEFAULT NULL COMMENT '部门负责人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `__PREFIX__flow_department`
--

INSERT INTO `__PREFIX__flow_department` (`id`, `pid`, `name`, `createtime`, `updatetime`, `status`, `manager`,`managername`) VALUES
(1, 0, '福威集团', 1566095563, 1566095563, 'normal', NULL,''),
(2, 1, '信息技术部', 1566095563, 1568346179, 'normal', '1','admin'),
(3, 2, '硬件组', 1566095563, 1568346198, 'normal', '1','admin'),
(4, 1, '人事部', 1566095563, 1568346135, 'normal', '1','admin'),
(6, 1, '软件组', 1568346286, 1568346286, 'normal', '1','admin');

-- Table structure for __PREFIX__flow_mail
-- ----------------------------
CREATE TABLE IF NOT EXISTS `__PREFIX__flow_mail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `address` varchar(255) DEFAULT NULL COMMENT '地址',
  `subject` varchar(255) DEFAULT NULL COMMENT '主题',
  `content` text COMMENT '内容',
  `createdtime` datetime DEFAULT NULL COMMENT '创建时间',
  `issend` varchar(255) DEFAULT NULL COMMENT '是否成功',
  `senddate` datetime DEFAULT NULL COMMENT '发送时间',
  `message` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 MIN_ROWS=2;

-- ----------------------------
-- Records of __PREFIX__flow_mail
-- ----------------------------
INSERT INTO `__PREFIX__flow_mail` VALUES ('1', '31040327@qq.com', 'test', 'test', null, '1', '2019-12-22 12:23:03', '发送成功');
INSERT INTO `__PREFIX__flow_mail` VALUES ('2', '31040327@qq.com', '无审批人', '实例id 465d5d2b-5757-46e6-9637-2ffe74fd8fca 无审批人请及时处理', '2019-12-22 13:17:26', '1', '2019-12-22 13:21:03', '发送成功');
SET FOREIGN_KEY_CHECKS=1;

-- 2.0.0版本
-- 添加组织授权表
-- ----------------------------
-- Table structure for __PREFIX__flow_right
-- ----------------------------
CREATE TABLE IF NOT EXISTS `__PREFIX__flow_right` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL COMMENT '类型',
  `key` varchar(255) DEFAULT NULL COMMENT '授权对象',
  `value` varchar(255) DEFAULT NULL COMMENT '授权值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of __PREFIX__flow_right
-- ----------------------------
INSERT INTO `__PREFIX__flow_right` VALUES ('1', 'dept', '5', '2');
SET FOREIGN_KEY_CHECKS=1;

-- 添加部门代码字段
BEGIN;
ALTER TABLE `__PREFIX__flow_department` ADD  COLUMN code varchar(255);
COMMIT;

-- 添加委托人字段
BEGIN;
ALTER TABLE `__PREFIX__flow_task` ADD  COLUMN delegateid int(10);
COMMIT;

-- 修改测试数据创建时间 不然严格模式会报错
UPDATE `__PREFIX__flow_scheme`
SET frmtype = '2',createtime = SYSDATE(),updatetime = SYSDATE();

-- 修改scheme表frmcode字段类型
ALTER TABLE `__PREFIX__flow_scheme` modify  COLUMN frmcode longtext;

-- 修改默认表单类型
UPDATE `__PREFIX__flow_scheme`
SET frmcode = '{"list":[{"type":"date","label":"开始时间","options":{"width":"100%","defaultValue":"","rangeDefaultValue":[],"range":false,"showTime":false,"disabled":false,"hidden":false,"clearable":false,"placeholder":"请选择","rangePlaceholder":["开始时间","结束时间"],"format":"YYYY-MM-DD"},"model":"start_time","key":"date_1596343979276","rules":[{"required":false,"message":"必填项"}]},{"type":"input","label":"原因","options":{"type":"text","width":"100%","defaultValue":"","placeholder":"请输入","clearable":false,"maxLength":null,"hidden":false,"disabled":false},"model":"content","key":"input_1596345496471","rules":[{"required":false,"message":"必填项"}]},{"type":"number","label":"请假天输","options":{"width":"100%","defaultValue":0,"min":null,"max":null,"precision":null,"step":1,"hidden":false,"disabled":false,"placeholder":"请输入"},"model":"day","key":"number_1596345487278","rules":[{"required":false,"message":"必填项"}]}],"config":{"layout":"horizontal","labelCol":{"span":4},"wrapperCol":{"span":18},"hideRequiredMark":false,"customStyle":""}}'
where flowcode = 'leave';


-- 添加流程委托表
SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for __PREFIX__flow_delegate
-- ----------------------------
CREATE TABLE IF NOT EXISTS `__PREFIX__flow_delegate` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `admin_id` int(10) DEFAULT NULL COMMENT '被委托人',
  `delegate_id` int(10) DEFAULT NULL COMMENT '委托人',
  `begin_date` datetime DEFAULT NULL COMMENT '开始时间',
  `end_date` datetime DEFAULT NULL COMMENT '结束时间',
  `updatetime` int(11) DEFAULT NULL COMMENT '更新时间',
  `createtime` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
SET FOREIGN_KEY_CHECKS=1;


-- 给视图添加前缀 避免冲突
DROP view IF EXISTS `__PREFIX__view_workitem`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `__PREFIX__view_flow_workitem` AS 
SELECT
	`b`.`instancestatus` AS `instancestatus`,
	`b`.`instancecode` AS `instancecode`,
	`b`.`bizobjectid` AS `bizobjectid`,
	`c`.`bizscheme` AS `bizscheme`,
	`e`.`nickname` AS `receivename`,
	`c`.`flowname` AS `flowname`,
	`c`.`flowcode` AS `flowcode`,
	`c`.`url` AS `url`,
  `c`.`frmtype` AS `frmtype`,
  `c`.id As `schemeid`,
	`b`.`originator` AS `originator`,
	`d`.`nickname` AS `nickname`,
	`a`.`id` AS `id`,
	`a`.`previd` AS `previd`,
	`a`.`prevstepid` AS `prevstepid`,
	`a`.`receiveid` AS `receiveid`,
	`a`.`stepid` AS `stepid`,
	`a`.`flowid` AS `flowid`,
	`a`.`stepname` AS `stepname`,
	`a`.`instanceid` AS `instanceid`,
	`a`.`groupid` AS `groupid`,
	`a`.`type` AS `type`,
	`a`.`tittle` AS `tittle`,
	`a`.`senderid` AS `senderid`,
	`a`.`opentime` AS `opentime`,
	`a`.`completedtime` AS `completedtime`,
	`a`.`comment` AS `comment`,
	`a`.`isSign` AS `isSign`,
	`a`.`status` AS `status`,
	`a`.`note` AS `note`,
	`a`.`sort` AS `sort`,
	`a`.`createtime` AS `createtime`,
	`a`.`delegateid` AS `delegateid`,
	`f`.`nickname` AS `delegatename`
FROM
	`__PREFIX__flow_instance` `b`
LEFT JOIN `__PREFIX__flow_task` `a` ON `a`.`instanceid` = `b`.`id`
LEFT JOIN `__PREFIX__flow_scheme` `c` ON `b`.`scheme` = `c`.`id`
LEFT JOIN `__PREFIX__admin` `d` ON `b`.`originator` = `d`.`id`
LEFT JOIN `__PREFIX__admin` `e` ON `a`.`receiveid` = `e`.`id`
LEFT JOIN `__PREFIX__admin` `f` ON `a`.`delegateid` = `f`.`id`
ORDER BY
	a.createtime DESC;

-- 给视图添加前缀 避免冲突
DROP view IF EXISTS `__PREFIX__view_instance`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `__PREFIX__view_flow_instance` AS 
SELECT
	`a`.`id` AS `id`,
	`a`.`originator` AS `originator`,
	`a`.`scheme` AS `scheme`,
	`a`.`createtime` AS `createtime`,
	`a`.`instancestatus` AS `instancestatus`,
	`a`.`bizobjectid` AS `bizobjectid`,
	`a`.`instancecode` AS `instancecode`,
	`a`.`completedtime` AS `completedtime`,
	`b`.`nickname` AS `nickname`,
	`c`.`flowname` AS `flowname`
FROM
	(
		(
			`__PREFIX__flow_instance` `a`
			LEFT JOIN `__PREFIX__admin` `b` ON (
				(`a`.`originator` = `b`.`id`)
			)
		)
		LEFT JOIN `__PREFIX__flow_scheme` `c` ON ((`a`.`scheme` = `c`.`id`))
	);

-- 新增委托视图
DROP view IF EXISTS `__PREFIX__view_flow_delegate`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `__PREFIX__view_flow_delegate` AS 
SELECT
	`a`.`id` AS `id`,
	`a`.`admin_id` AS `admin_id`,
	`a`.`begin_date` AS `begin_date`,
	`a`.`createtime` AS `createtime`,
	`a`.`delegate_id` AS `delegate_id`,
	`a`.`end_date` AS `end_date`,
	`a`.`updatetime` AS `updatetime`,
	`b`.`nickname` AS `admin_name`,
	`c`.`nickname` AS `delegate_name`
FROM
	(
		(
			`__PREFIX__flow_delegate` `a`
			LEFT JOIN `__PREFIX__admin` `b` ON ((`a`.`admin_id` = `b`.`id`))
		)
		LEFT JOIN `__PREFIX__admin` `c` ON (
			(`a`.`delegate_id` = `c`.`id`)
		)
	);
-- 添加默认字段视图 2.0.2
DROP view IF EXISTS `__PREFIX__view_flow_field_default`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `__PREFIX__view_flow_field_default` AS 
SELECT
	`a`.`TABLE_SCHEMA` AS `TABLE_SCHEMA`,
	`a`.`COLUMN_KEY` AS `COLUMN_KEY`,
	`a`.`COLUMN_NAME` AS `field`,
	`a`.`TABLE_NAME` AS `table_name`,
	1 AS `read`,
	0 AS `write`,
	'' AS `id`,
	'' AS `flow_id`,
	'' AS `node_id`
FROM
	`information_schema`.`columns` `a`;
-- 新增角色权限字段表
CREATE TABLE IF NOT EXISTS `__PREFIX__flow_field` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `node_id` varchar(100) DEFAULT NULL COMMENT '节点Id',
  `flow_id` int(11) DEFAULT NULL COMMENT '流程Id',
  `field` varchar(255) DEFAULT NULL COMMENT '字段名称',
  `read` int(11) DEFAULT NULL COMMENT '是否可读',
  `write` int(10) DEFAULT NULL COMMENT '是否可写',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1607689667 DEFAULT CHARSET=utf8;
SET FOREIGN_KEY_CHECKS=1;
-- code field
UPDATE `__PREFIX__flow_department`
SET code = '1' where name ='福威集团';
UPDATE `__PREFIX__flow_department`
SET code = '1.1' where name ='信息技术部';
UPDATE `__PREFIX__flow_department`
SET code = '1.1.1' where name ='硬件组';
UPDATE `__PREFIX__flow_department`
SET code = '1.2' where name ='人事部';
UPDATE `__PREFIX__flow_department`
SET code = '1.1.2' where name ='软件组';