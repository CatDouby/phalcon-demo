<?php


use Phalcon\Mvc\Model;

class Article extends Model
{
    public $id;

    public $title;

    public $content;

    public $author;

    public $pubtime;




    // onConstruct事件
    public function onConstruct()
    {

    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($newTitle)
    {
        return $this->title = $newTitle;
    }
}