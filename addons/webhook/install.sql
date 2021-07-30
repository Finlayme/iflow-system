CREATE TABLE IF NOT EXISTS `__PREFIX__webhook_record`
(
    `id`    int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
    `provider`    varchar(50) NOT NULL COMMENT '服务商',
    `type`   varchar(50) NOT NULL COMMENT '加密方法',
    `status`     tinyint(1) NOT NULL COMMENT '状态:0=失败,1=成功',
    `request_data`    text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '请求参数',
    `response_data`   text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '响应参数',
    `header_data`     text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '请求Header',
    `createtime` int(10) NOT NULL COMMENT '创建时间',
    PRIMARY KEY (`id`) USING BTREE
) ENGINE = Innodb AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'WebHook 请求记录表';

update `__PREFIX__webhook_record` set status = 0 where status = 2