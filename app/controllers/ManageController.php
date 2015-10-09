<?php

/**
 * Created by PhpStorm.
 * User: sks
 * Date: 2015/9/8
 * Time: 13:20
 */

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Micro;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use Phalcon\Paginator\Adapter\NativeArray as PaginatorArray;
use Phalcon\Paginator\Adapter\QueryBuilder as PaginatorQueryBuilder;

class ManageController extends Controller
{
    const sessPrefix = 'user-';
    private $app;
    private $noCheck = array(
        '/manage/index', '/manage/logout'
    );

    /**
     * 初始化访问控制
     */
    public function initialize()
    {
        $this->app = new Micro();

        $uri = $this->request->getURI();
        if (!in_array($uri, $this->noCheck)) {
            if (!$this->checkAuth()) {
                $this->app->response->redirect('/manage/index');
            }
        }
    }

    public function indexAction()
    {

    }

    /**
     * 登录
     */
    public function loginAction()
    {
        if (!$this->checkAuth()) {
            $post = $this->request->getPost();
            if ($this->checkLogin($post['name'], $post['passwd'])) {
                // redirect to manage page
                $this->app->response->redirect("/manage/articles");
            } else {
                $this->app->response->redirect("/manage/index");
            }
        } else {
            // redirect to manage page
            $this->app->response->redirect("/manage/articles");
        }
    }

    /**
     * 退出登录
     */
    public function logoutAction()
    {
        $this->session->start();
        $this->session->destroy();

        $this->app->response->redirect('/manage/index');
    }

    /* 是否已经登录 */
    private function checkAuth()
    {
        if (!$this->session->isStarted()) {
            $this->session->start();
        }
        return $this->session->has('user-name');
    }

    /* 得到一个mysql的connection */
    private function getConnection(){
        $conn = new \Phalcon\Db\Adapter\Pdo\Mysql(array(
            "host"     => "localhost",
            "username" => "root",
            "password" => "123456",
            "dbname"   => "tutorial"
        ));
        $conn->connect();
        return $conn;
    }

    /**
     * 根据用户名和账号检查登录
     * @param $name
     * @param $pwd
     * @return bool
     */
    private function checkLogin($name, $pwd)
    {
        $conn = $this->getConnection();
        $sql   = "select id,name,passwd,email from users where name=? and passwd=?";
        $res = $conn->fetchOne($sql, Phalcon\Db::FETCH_ASSOC, array($name, $pwd));

        unset($conn);

        if (!empty($res)) {
            $this->setLogInfo($res);
            return true;
        }

        return false;
    }

    /**
     * 设置登录者信息 $data必须是k=>v形式
     * @param $data
     */
    private function setLogInfo($data)
    {
        if (!$this->session->isStarted()) {
            $this->session->start();
        }

        foreach ($data as $k => $v) {
            $this->session->set(self::sessPrefix. $k, $v);
        }
    }

    /**
     * 管理列表页面
     */
    public function articlesAction()
    {
        $currentPage = intval($this->request->get('page'));
        $currentPage = $currentPage ? $currentPage : 1;

        $author = $this->session->get(self::sessPrefix. 'name');

        $builder = $this->modelsManager->createBuilder()
            ->columns('id, title, content, pubtime, author')
            ->where('author = :author:', array('author'=>$author))
            ->from('Article')
            ->orderBy('id desc');
        $paginator = new PaginatorQueryBuilder(array(
            "builder" => $builder,
            "limit"   => 5,
            "page"    => $currentPage
        ));
        $page = $paginator->getPaginate();
        $this->view->page = $page;

        /*$sql = 'select id,title,content,pubtime,author from article where author=? order by pubtime desc';
        $this->session->start();
        $author = $this->session->get(self::sessPrefix. 'name');

        $conn = $this->getConnection();
        $res = $conn->fetchAll($sql, Phalcon\Db::FETCH_ASSOC, array($author));
        if (!$res) $res = array();
        $this->view->data = $res;

        $paginator = new PaginatorArray(
            array(
                "data"  => $res,
                "limit" => 3,
                "page"  => $currentPage
            )
        );
        $page = $paginator->getPaginate();*/
//die;
    }

    /**
     * 编辑页面
     */
    public function editArticleAction()
    {
        error_reporting(11); // 1开启fatal 2开启warning 8开启notice 0关闭
        $id = (int)$this->request->get('i');


//        $this->session->start();
//        $author = $this->session->get(self::sessPrefix.'name');
//        $conn = $this->getConnection();
//        $sql = 'select id,title,content from article where id=? and author=?';
//        $row = $conn->fetchOne($sql, Phalcon\Db::FETCH_ASSOC, array($id, $author));

        $this->view->title = 'this is a tt';
        $this->view->tag = '<script>console.dir(console);</script>';
        $this->view->loop = array(
            'a1' => 'aaaaa',
            'a2' => 'bbbbb',
            'a3' => 'ccccc',
        );

        if ($id) {
            $row = Article::findFirstById($id);
            $this->view->info = $row;
        }
    }

    /**
     * 保存数据
     */
    public function saveArticleAction()
    {
        if (!$this->request->isPost()) {
            $this->app->response->redirect('/manage/editArticle'); exit;
        }

        $post = $this->request->getPost();
        $this->session->start();
        $author = $this->session->get(self::sessPrefix. 'name');

        $sql = '';
        $tmp = array();
        if ($post['idd']) { // 修改
            $sql = 'update article set title=?,content=? where id=? and author=?';
            $tmp = array($post['title'], $post['content'], $post['idd'], $author);
        }
        else {              // 添加
            $sql = 'insert into article values(null,?,?,?,?)';
            $tmp = array( $post['title'], $post['content'], time(), $author);
        }

        $conn = $this->getConnection();
        if ($conn->execute($sql, $tmp)) {
            unset($conn);

            $this->app->response->redirect("/manage/articles");
        } else {
            echo '<script type="text/javascript">history.go(-1);</script>';
        }
    }

    public function delArticleAction()
    {
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $ids = $post['seri'];
            $tmp = explode(',', $ids);
            if ($this->delArticleApi($tmp)) {
                exit(json_encode(array('info'=>'success', 'error'=>0)));
            } else {
                exit(json_encode(array('info'=>'fail', 'error'=>1)));
            }
        }
        exit(json_encode(array('info'=>'illegal', 'error'=>2)));
    }

    private function delArticleApi($ids = array())
    {
        $newArr = $this->formatArr2Int($ids);
        if (count($newArr) != count($ids) || !$newArr) {
            return false; //数组中含有不合法内容或为空
        }
        $idStr = join(',', $newArr);
        $sql = 'delete from article where id in('. $idStr. ')';

        $conn = $this->getConnection();
        $b = $conn->execute($sql);

        return $b === false ? false : true;
    }

    /**
     * 如果是数组递归的格式化数组参数的值为整型，字符串使用intval格式化，其他类型返回0；
     * 格式化后有去重操作；
     * @param $arr
     * @return array|int
     */
    private function formatArr2Int($arr)
    {
        if (is_array($arr)) {
            array_walk_recursive($arr, function ($v, $k) use(&$arr) {
                if ($v != intval($v)) {
                    return false;
                }
                $arr[$k] = intval($v);
            });

            return array_unique($arr);
        } elseif (is_string($arr)) {
            return intval($arr);
        } else {
            return 0;
        }
    }
}