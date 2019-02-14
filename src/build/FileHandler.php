<?php
/**
 * Created by PhpStorm.
 * User: 南丞
 * Date: 2019/2/14
 * Time: 10:04
 *
 *
 *                      _ooOoo_
 *                     o8888888o
 *                     88" . "88
 *                     (| ^_^ |)
 *                     O\  =  /O
 *                  ____/`---'\____
 *                .'  \\|     |//  `.
 *               /  \\|||  :  |||//  \
 *              /  _||||| -:- |||||-  \
 *              |   | \\\  -  /// |   |
 *              | \_|  ''\---/''  |   |
 *              \  .-\__  `-`  ___/-. /
 *            ___`. .'  /--.--\  `. . ___
 *          ."" '<  `.___\_<|>_/___.'  >'"".
 *        | | :  `- \`.;`\ _ /`;.`/ - ` : | |
 *        \  \ `-.   \_ __\ /__ _/   .-` /  /
 *  ========`-.____`-.___\_____/___.-`____.-'========
 *                       `=---='
 *  ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
 *           佛祖保佑       永无BUG     永不修改
 *
 */

namespace pf\session\build;

use pf\config\Config;

class FileHandler implements BasicsSession
{
    use Base;
    protected $dir;
    protected $file;

    public function connect()
    {
        $dir = Config::get('session.file.path');
        var_dump($dir);
        exit;
    }

    public function read()
    {
        // TODO: Implement read() method.
    }

    public function gc()
    {
        // TODO: Implement gc() method.
    }

    public function flush()
    {
        // TODO: Implement flush() method.
    }
}