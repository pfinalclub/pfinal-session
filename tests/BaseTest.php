<?php

use pf\config\Config;
use pf\session\Session;

/**
 * Created by PhpStorm.
 * User: 南丞
 * Date: 2019/2/13
 * Time: 17:52
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
class BaseTest extends \PHPUnit\Framework\TestCase
{
    public function test_set_and_get()
    {
        Config::loadFiles(__DIR__ . '/config');
        $this->assertTrue(Session::set('name', 'pfinal'));
        $this->assertInternalType('string', Session::get('name'));
        $this->assertEquals('pfinal', Session::get('name'));
    }

    public function testAll()
    {
        Config::loadFiles(__DIR__ . '/config');
        Session::bootstrap()->set('name', 'pfinal');
        Session::write();
        $this->assertInternalType('array', Session::all());
    }
}
