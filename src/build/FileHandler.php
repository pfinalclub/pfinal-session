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
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
            file_put_contents($dir . '/index.html', '');
        }
        $this->dir = realpath($dir);
        $this->file = $this->dir . '/' . $this->session_id . '.php';
    }

    public function read()
    {
        if (!is_file($this->file)) {
            return [];
        }
        return unserialize(file_get_contents($this->file));
    }

    public function write()
    {
        $data = serialize($this->items);
        return file_put_contents($this->file, $data, LOCK_EX);
    }

    public function gc()
    {
        foreach (glob($this->dir . '/*.php') as $f) {
            if (basename($f) != basename($this->file) && (filemtime($f) + $this->expire + 3600) < time()) {
                unlink($f);
            }
        }
    }
}