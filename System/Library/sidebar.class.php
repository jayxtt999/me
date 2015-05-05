<?php
/**
 * 侧边栏类
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/4/28 0028
 * Time: 下午 1:52
 */

namespace System\Library;

class sidebar
{
    private $sidebar = array();

    /**
     * 初始化 检索缓存
     * @param $callback
     * @param $data
     * @return mixed|void
     */
    public function init($callback, $data)
    {
        if (cache('sidebar_' . $callback)) {
            return cache('sidebar_' . $callback);
        } else {
            cache('sidebar_' . $callback, self::$callback($data));
            return self::$callback($data);
        }
    }

    /**
     * blogger
     * @param null $data
     * @return array
     */
    public static function blogger($data = null)
    {
        $title = $data[0]['data'];
        $row = db()->table("member_info")->getRow(array('role' => 1))->done();
        return array('title' => $title, 'data' => $row);

    }


    /**
     * 日历
     * @param null $data
     * @return array
     */
    public static function calendar($data = null)
    {

        $title = $data[0]['data'];
        return array('title' => $title, 'data' => "");

    }


    /**
     * 最新说说
     * @param null $data
     * @return array
     */
    public static function newtwitter($data = null)
    {
        $title = $data[0]['data'];
        $number = $data[1]['data'];
        $newTwitter = db()->table("twitter")->getAll(array('status' => 1))->limit(0, $number)->done();
        return array('title' => $title, 'data' => $newTwitter);
    }


    /**
     * 标签
     * @param null $data
     * @return array
     */
    public static function tags($data = null)
    {
        $title = $data[0]['data'];
        $tags = db()->table('article_tag')->getAll()->order('id')->done();
        $color = array('default', 'red', 'blue', 'green', 'yellow', 'purple', 'dark');
        $html = "";
        foreach ($tags as $v) {
            $html .= "<a href='http://www.me.me/index.php?m=home&c=blog&a=index&tag=".$v['tagname']."' class='btn " . $color[rand(0, 6)] . "'>" . $v['tagname'] . "</a>";
        }
        return array('title' => $title, 'data' => $html);
    }


    /**
     * 分类
     * @param null $data
     * @return array
     */
    public static function category($data = null)
    {
        $title = $data[0]['data'];
        $category = db()->table("article_category")->getAll()->done();
        return array('title' => $title, 'data' => $category);
    }


    /**
     * 存档
     * @param null $data
     * @return array
     */
    public static function archive($data = null)
    {
        $title = $data[0]['data'];
        $archiveBlog = db()->table("article")->getAll(array('status' => \Admin\Article\Type\Status::STATUS_ENABLE))->done();
        $archive = array();

        foreach ($archiveBlog as $k => $v) {

            $time = gmdate("Y年n月", strtotime($v['time']));
            if ($archive[$time]) {
                $archive[$time] += 1;
            } else {
                $archive[$time] = 1;
            }
        }
        return array('title' => $title, 'data' => $archive);
    }


    /**
     * 链接
     * @param null $data
     * @return array
     */
    public static function link($data = null)
    {
        $title = $data[0]['data'];
        $link = db()->table("link")->getAll()->done();
        return array('title' => $title, 'data' => $link);

    }


    /**
     * 搜索
     * @param null $data
     * @return array
     */
    public static function search($data = null)
    {

        $title = $data[0]['data'];
        return array('title' => $title, 'data' => "");

    }


    /**
     * 最新评论
     * @param null $data
     * @return array
     */
    public static function newcomment($data = null)
    {

        $title = $data[0]['data'];
        $num = $data[1]['data'];
        $limitNum = $data[1]['data'];
        $comment = db()->table("comment")->getAll(array('status' => \Admin\Comment\Type\Status::STATUS_ENABLE))->order('crate_time desc')->limit(0, $num)->done();
        foreach ($comment as $k => $v) {
            if (strlen($v['content']) > $limitNum) {
                $comment[$k]['content'] = mb_substr($comment[$k]['content'], 0, $limitNum, 'utf-8');
            }
        }
        return array('title' => $title, 'data' => $comment);

    }


    /**
     * 最新日志
     * @param null $data
     * @return array
     */
    public static function newblog($data = null)
    {

        $title = $data[0]['data'];
        $num = $data[1]['data'];
        $newBlog = db()->table("article")->getAll(array('status' => \Admin\Article\Type\Status::STATUS_ENABLE))->order('time desc')->limit(0, $num)->done();
        return array('title' => $title, 'data' => $newBlog);

    }


    /**
     * 热门日志
     * @param null $data
     * @return array
     */
    public static function hotblog($data = null)
    {
        $title = $data[0]['data'];
        $num = $data[1]['data'];
        $hotBlog = db()->table("article")->getAll(array('status' => \Admin\Article\Type\Status::STATUS_ENABLE))->order('view_num desc')->limit(0, $num)->done();
        return array('title' => $title, 'data' => $hotBlog);

    }


    /**
     * 随机日志
     * @param null $data
     * @return array
     */
    public static function randblog($data = null)
    {

        $title = $data[0]['data'];
        $num = $data[1]['data'];
        $sql = "SELECT
            *
            FROM
            `xtt_article` AS t1
            JOIN (
            SELECT
                ROUND(
                    RAND() * (
                        (
                            SELECT
                                MAX(id)
                            FROM
                                `xtt_article`
                        ) - (
                            SELECT
                                MIN(id)
                            FROM
                                `xtt_article`
                        )
                    ) + (
                        SELECT
                            MIN(id)
                        FROM
                            `xtt_article`
                    )
                ) AS id
            ) AS t2
            WHERE
            t1.id >= t2.id
            ORDER BY
            t1.id
            LIMIT $num;";

        $randBlog = db()->table("article")->sql($sql);

        return array('title' => $title, 'data' => $randBlog);


    }


}