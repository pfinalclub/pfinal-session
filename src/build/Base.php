<?php
/**
 * Created by PhpStorm.
 * User: 南丞
 * Date: 2019/2/14
 * Time: 10:43
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

trait Base
{
    protected $session_id;
    protected $session_name;
    protected $expire;
    protected $items = [];
    static protected $startTime;

    public function bootstrap()
    {
        $this->session_name = Config::get('session.name');
        $this->expire = intval(Config::get('session.expire'));
        $this->session_id = $this->getSessionId();
        $this->connect();
        $content = $this->read() ?: [];
        $this->items = is_array($content) ? $content : [];
        if (is_null(self::$startTime)) {
            self::$startTime = microtime(true);
        }
        return $this;
    }

    final protected function getSessionId()
    {
        $id = 'pfinal' . md5(microtime(true) . mt_rand(1, 6));
        return $id;
    }

    public function set($name, $value)
    {
        $tmp = &$this->items;
        $exts = explode('.', trim($name, '.'));
        //var_dump($exts);exit;
        if (is_array($exts) && !empty($exts)) {
            foreach ($exts as $key) {
                if (!isset($tmp[$key])) {
                    $tmp[$key] = [];
                }
                $tmp = &$tmp[$key];
            }
            $tmp = $value;
            return true;
        }
        return false;
    }

    public function get($name = '', $value = null)
    {
        $tmp = $this->items;
        $arr = explode('.', trim($name, '.'));
        if (count($arr) > 0) {
            foreach ((array)$arr as $item) {
                if (isset($tmp[$item])) {
                    $tmp = $tmp[$item];
                } else {
                    return $value;
                }
            }
        }
        return $tmp;
    }

    public function has($name)
    {
        return isset($this->items[$name]);
    }

    public function del($name)
    {
        $arr = explode('.', trim($name, '.'));
        if (count($arr) > 0) {
            foreach ((array)$arr as $d) {
                if (isset($this->items[$name])) {
                    unset($this->items[$name]);
                }
            }
        }
        return true;
    }

    public function flush()
    {
        $this->items = [];
        return true;
    }

    public function all()
    {
        return $this->items;
    }

    public function flash($name = null, $value = '[get]')
    {
        foreach ($name as $name => $value) {
            $this->set('_FLASH_.'.$name, [$value, self::$startTime]);
        }
    }
}