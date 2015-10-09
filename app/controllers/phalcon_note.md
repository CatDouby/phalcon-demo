                --------------------------------------------------------------------
                             Note About Learning Phalcon Framework
                --------------------------------------------------------------------

||||   Controller:  ||||
    常用组件：
        $this->request      // 请求
            exam: $this->request->get(); getPost(); isPost(); ...

        $this->session      // session
            exam: $this->session->isStarted(); start(); set('k', 'v'); get('k'); destroy(); ...

        $this->view         // 视图
            exam: $this->view->data = $res; // 将控制器中的$res变量传值到视图的$data变量

        $this->flash        // 闪存消息
            exam: $this->flash->error('error happened'); warn(); success(); notice(); message; ...

        $this->flashSession // 闪存消息至session
            exam: $this->flashSession->success('succ'); $this->flashSession->output();

        $this->security     // 安全性操作
            exam: $hspwd = $this->security->hash($passwd); checkHash($passwd, $hspwd); getTokenKey(); getToken(); ...
                  <input type="hidden" name="<? echo getTokenKey();?>" value="<? echo getToken();?> />
                  getTokenKey()获取表单的token，此表单标签需要用Tag生成，使用token时session要处于start状态，所以最好注册组件时就开启


    常用对象：
        use Phalcon\Mvc\Micro;  // 用于快速创建微应用
            exam: $app = new Micro(); $app->response->redirect('/manage/lists'); // 重定向
                  重定向不会禁用视图组件。因此，如果你想从一个controller/action重定向到另一个controller/acton上，视图将正常显示。
                  当然，你也可以使用 $this->view->disable() 禁用视图输出
                  $app->response->setContentType('text/plain')->sendHeaders();   // 设置响应头


        use Phalcon\Db\Adapter\Pdo\Mysql as Conn    // db连接对象
            exam: $conn = new Conn($configArr); $conn->connect(); fetchOne(); fetchAll(); execute()

                  $sql   = "select id,name,passwd,email from users where name=? and passwd=?";
                  $res = $conn->fetchOne($sql, Phalcon\Db::FETCH_ASSOC, array($name, $pwd));

        $response = new Phalcon\Http\Response();       // 响应对象
            exam: $response->setContentType('text/plain'); setContent('abcde');



||||    Model:   ||||
link = https://docs.phalconphp.com/zh/latest/reference/models.html

    initialize() 方法在请求期间仅会被调用一次，目的是为应用中所有该模型的实例进行初始化。
    如果需要为每一个实例在创建的时候单独进行初始化， 可以使用 ‘onConstruct’ 事件方法

    查询：
    ::findFirst(); ::find();
    $resObj = Article::findFirst(array('id'=>3));

    一旦记录被加载到内存中之后，你可以修改它的数据并保存所做的修改：
    $robot       = Robots::findFirst(3);
    $robot->name = "RoboCop";
    $robot->save();

    通过模型的属性查询：
    ::findByAttr(); ::findFirstByAttr()
    如，有Article模型含有id属性，则可以Article::findById(7)， 模型自动去根据这个属性查找。

    findFirst() 方法直接返回一个被调用对象的实例（如果有结果返回的话）通过::find()得到的是一个 Phalcon\Mvc\Model\Resultset\Simple对象
    这些对象比一般数组功能更强大。最大的特点是 Phalcon\Mvc\Model\Resultset 每时每刻只有一个结果在内存中。这对操作大数据量时的内存管理相当有帮助
    $resObj->toArray(); serialize(); delete(); update(); filter(); ...

    $filtered = $robots->filter(function($robot){
        if ($robot->id < 3) {
                return $robot;
        }
    }); //在结果集中筛选

    查询构造器：
    $robots = Robots::query()
        ->where("type = :type:")
        ->andWhere("year < 2000")
        ->bind(array("type" => "mechanical"))
        ->order("name")
        ->execute();
        这样得到的是一个Phalcon\Mvc\Model\Criteria对象


// todo 模型操作、事件监听


View:
https://docs.phalconphp.com/zh/latest/reference/volt.html
创建标签：
        <?php echo Phalcon\Tag::form('register') ?>
        <?php echo Phalcon\Tag::linkTo('/manage/editArticle', 'add article'); ?>
        <?php echo Phalcon\Tag::passwordField('passwd') ?>
        <?php echo Phalcon\Tag::submitButton('Go') ?>

        <?php echo $this->tag->form('signup/register') ?>
        <?php echo $this->tag->textField("name") ?>
        <?php echo $this->tag->submitButton("Register") ?>


赋值：
        {% set fruits = ['Apple', 'Banana', 'Orange'] %}
        {% set name = robot.name %}
比较运算：
        == +=  != <> > < >= <= === !==
算数运算：
        + - * / %
逻辑运算：
        or and not
其它运算：
        (~) (|) (..) (is)  (is not) (in) ( ? : ) ( ++ ) (--)
测试运算：
        {% for position, name in robots %}
            {% if position is odd %}    // is odd 测试是否为偶数
                {{ name }}
            {% endif %}
        {% endfor %}

注释：
        {# note: this is a comment
            {% set price = 100; %}
        #}

循环：
        {% for robot in robots %}
          <li>{{ robot.name|e }}</li>
        {% endfor %}
循环控制：
        continue break
条件判断：
        if elseif else

过滤器：
        {{ post.title|e }}
        {{ post.content|striptags }

宏定义：
        {%- macro related_bar(related_links) %}
            <div></div>
            {% return text_field(name, 'class': class) %}   // 宏定义返回一个值
        {%- endmacro %} // 定义一个宏

        {{ related_bar(links) }}    // 调用宏

标签助手：
        {{ javascript_include("js/jquery.js") }}

        {{ form('products/save', 'method': 'post') }}

            <label for="name">Name</label>
            {{ text_field("name", "size": 32) }}

            <label for="type">Type</label>
            {{ select("type", productTypes, 'using': ['id', 'name']) }}

            {{ submit_button('Send') }}
        {{ end_form() }}

集成：

包含：
        <div id="footer">{% include "partials/footer.volt" %}</div>
继承：
        {% extends "templates/base.volt" %}
多重继承（Multiple Inheritance）：
        {{ super() }}

自动编码模式：

配置 Volt 引擎：
        $di->set('voltService', function ($view, $di) {

            $volt = new Volt($view, $di);

            $volt->setOptions(array(
                "compiledPath" => "../app/compiled-templates/",
                "compiledExtension" => ".compiled"
            ));

            return $volt;
        });


