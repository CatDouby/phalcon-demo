<?php



class MicroAppController extends BaseController
{
    private $mapp;

    public function initialize()
    {
        $this->mapp = new Micro();
    }

    public function routesAction()
    {
        echo $this->request->get('param','int');
        $this->mapp->get('/MicroApp/routes/{param}', array($this, 'getParam'));

        $res = Ts::find(array('a'=>'cd'));
        echo $res->serialize();



        print_r($res->toArray());die;
        $res = Ts::findByA('cd');
//        print_r($res->next());
//        print_r($res->getFirst());
//        print_r($res->getLast());
        die;

        echo 'forward to routesAction';
    }

    public function getParam($param)
    {
        echo 'kkk',$param;
    }

    public function fwdAction()
    {
        echo $this->security->hash($this->request->get('name'));
        // has('aba') == '$2a$08$qi2miDrEOg0m3DnPOLkfUeDkrvbRLbDe7PbNfdlX5XHj3DKG5TVi6'
        $hash = '$2a$08$qi2miDrEOg0m3DnPOLkfUeDkrvbRLbDe7PbNfdlX5XHj3DKG5TVi6';
        var_dump($this->security->checkHash($this->request->get('name'), $hash));

        print_r(get_class_methods($this->security));

        $res = Article::findFirst(array('id'=>11));

        $res = Article::find(array('id'=>11, 'limit'=>10));

        echo '<pre>';
        print_r(get_object_vars($res));//die;
        print_r(get_class_vars($res));
        print_r(get_class_methods($res));die;
        $arr = $res->toArray();
//        print_r($res);die;
        $this->dispatcher->forward(array('controller'=>'microapp', 'action'=>'routes'));
        $this->view->disable();
    }
}