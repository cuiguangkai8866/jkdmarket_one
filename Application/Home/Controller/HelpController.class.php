<?php
    namespace Home\Controller;
    use Think\Controller;
    class HelpController extends CommonController{
        public function __construct(){
            parent::__construct();
            $this->title = M('Nav')->where("tag = '".ACTION_NAME."'")->getField('nav_name');
        }
        public function process(){
            $this->assign(ACTION_NAME,$this->_QueryPageData(ACTION_NAME,null,'p.content'));
            $this->display();
        }

        public function userinfo(){
            $this->assign(ACTION_NAME,$this->_QueryPageData(ACTION_NAME,null,'p.content'));
            $this->display();
        }
        public function problems(){
            $this->assign(ACTION_NAME,$this->_QueryPageData(ACTION_NAME,null,'p.content'));
            $this->display();
        }
        public function aboutus(){
            $this->assign(ACTION_NAME,$this->_QueryPageData(ACTION_NAME,null,'p.content'));
            $this->display();
        }
        public function about(){
            $this->assign(ACTION_NAME,$this->_QueryPageData(ACTION_NAME,null,'p.content'));
            $this->display();
        }

        public function onlinepay(){
            $this->assign(ACTION_NAME,$this->_QueryPageData(ACTION_NAME,null,'p.content'));
            $this->display();
        }
        public function pstime(){
            $this->assign(ACTION_NAME,$this->_QueryPageData(ACTION_NAME,null,'p.content'));
            $this->display();
        }
        public function receiving(){
            $this->assign(ACTION_NAME,$this->_QueryPageData(ACTION_NAME,null,'p.content'));
            $this->display();
        }
        public function tracking(){
            $this->assign(ACTION_NAME,$this->_QueryPageData(ACTION_NAME,null,'p.content'));
            $this->display();
        }
        public function myjiufu(){
            $this->assign(ACTION_NAME,$this->_QueryPageData(ACTION_NAME,null,'p.content'));
            $this->display();
        }
        public function orderstatus(){
            $this->assign(ACTION_NAME,$this->_QueryPageData(ACTION_NAME,null,'p.content'));
            $this->display();
        }
        public function cancelorder(){
            $this->assign(ACTION_NAME,$this->_QueryPageData(ACTION_NAME,null,'p.content'));
            $this->display();
        }
        public function forgetpwd(){
            $this->assign(ACTION_NAME,$this->_QueryPageData(ACTION_NAME,null,'p.content'));
            $this->display();
        }
        public function refundinfo(){
            $this->assign(ACTION_NAME,$this->_QueryPageData(ACTION_NAME,null,'p.content'));
            $this->display();
        }
        public function netrefund(){
            $this->assign(ACTION_NAME,$this->_QueryPageData(ACTION_NAME,null,'p.content'));
            $this->display();
        }
        public function invoice(){
            $this->assign(ACTION_NAME,$this->_QueryPageData(ACTION_NAME,null,'p.content'));
            $this->display();
        }
        public function creditinfo(){
            $this->assign(ACTION_NAME,$this->_QueryPageData(ACTION_NAME,null,'p.content'));
            $this->display();
        }
		public function jiufuxy(){
            $this->assign(ACTION_NAME,$this->_QueryPageData(ACTION_NAME,null,'p.content'));
            $this->display();
        }
    }
?>