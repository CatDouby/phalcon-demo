<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title><?php echo $title; ?></title>
</head>

<body>
<!--
| 可用于过滤volt模板中变量
-->

<?php echo $this->escaper->escapeHtml($tag); ?>
<?php echo $tag; ?>


<?php foreach ($loop as $p) { ?>
    <div><?php echo $p; ?></div>
<?php } ?>

<?php $numbers = array('one' => '1', 'two' => 2, 'three' => 3); ?>
<?php foreach ($numbers as $name => $value) { if ($value < 2) { ?>
Name: <?php echo $name; ?> Value: <?php echo $value; ?>

Name: <?php echo $name; ?> Value: <?php echo $value; ?> >= 2
<?php } ?><?php } ?>

<?php (1 + 3); ?>
<?php echo 1 + 3; ?>

<form method="post" action="saveArticle">
    <input type="hidden" name="idd" value="">
    <ul>
        <li>title: <input type="text" name="title" value="" maxlength="20"></li>
        <li>content: <input type="text" name="content" value="" maxlength="200"></li>
        <li><input type="submit" value="DO"></li>
    </ul>
</form>
</body>
</html>