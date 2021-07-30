<?php

namespace addons\webhook\library;

use addons\webhook\exception\CommandException;

class Command
{
    /**
     * Git pull
     * @var string
     */
    private static $pull_command = 'git pull origin master';

    /**
     * 执行命令
     * @return mixed
     * @throws CommandException
     */
    public static function execute()
    {
        $root_path = ROOT_PATH;
        $command = self::$pull_command;
        if (!self::checkGitCommand($command)) {
            throw new CommandException(__('Illegal command'));
        }
        $command = "cd $root_path && $command 2<&1";
        exec($command, $result);
        return $result;
    }

    /**
     * 检查 Git 命令是否非法
     * 非法定义：存在多个执行命令或非 Git 命令
     * @param $command
     * @return bool
     */
    public static  function checkGitCommand($command): bool
    {
        if (!preg_match('/^git|^sudo git/', $command)) {
            return false;
        }
        return !preg_match('/[|&;]/', $command);
    }
}