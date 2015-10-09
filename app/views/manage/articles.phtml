
<head>

<meta charset="utf-8" />
<style>
    table{
        margin: 0 auto;
    }
    td,th{
        border: 1px solid grey;
    }
</style>
</head>

<?php echo Phalcon\Tag::linkTo('/manage/editArticle', '添加 article'); ?>

<table cellpadding="10" cellspacing="2">
    <tr>
        <td colspan="6"></td>
    </tr>
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Content</th>
        <th>PubTime</th>
        <th>Author</th>
        <th>Option</th>
    </tr>

    <?php foreach($page->items as $v) { ?>
    <tr>
        <td><?php echo $v->id; ?></td>
        <td><?php echo $v->title; ?></td>
        <td><?php echo $v->content; ?></td>
        <td><?php echo date('Y-m-d H:i:s', $v->pubtime); ?></td>
        <td><?php echo $v->author; ?></td>
        <td>
            <a href="/manage/editArticle?i=<?php echo $v['id']; ?>">edit</a>
            <a href="javascript:;" class="del" data="<?php echo $v['id']; ?>">del</a>
        </td>
    </tr>
    <?php } ?>

    <tr>
        <td><a href="/manage/articles?page=<?php echo $page->before; ?>"> 上一页</a></td>
        <td><a href="/manage/articles?page=<?php echo $page->next; ?>">下一页</a></td>
        <td><a href="/manage/articles?page=<?php echo $page->last; ?>">最后页</a></td>
        <td colspan="3">共<?php echo $page->total_items; ?>条 <?php echo $page->current,'/',$page->total_pages; ?>页</td>
    </tr>
</table>



<script type="text/javascript" src="http://libs.baidu.com/jquery/1.9.0/jquery.min.js"></script>
<script type="text/javascript">
    $('.del').click(function () {
        if (confirm('删除后不可找回，确认删除？')) {
            $.post('/manage/delArticle', 'seri=,'+$(this).attr('data'), function (resp) {
                var j = JSON.parse(resp);
                if (j && j.error == 0) {
                    setTimeout(function () {
                        location.reload();
                    }, 700);
                }
            });
        }
    });
</script>
