<?php
    namespace Member\Model;
    use Think\Model;
class AccountModel extends SystemModel{
    public function __construct(){
        parent::__construct();
    }

    //收货地址数据操作
    public function CheckAddress(){
        if(!IS_POST){
            return '非法提交!';
            exit;
        }

        $data = $_POST;
        if(!is_array($data) || empty($data)){
            return '提交的数据为空!';
            exit;
        }

        if($data['shen_cityname'] == '请选择省市/其他...' || empty($data['shen_cityname'])){
            return '请选择省份!';
            exit;
        }

        if($data['shi_cityname'] == '请选择城市...' || empty($data['shi_cityname'])){
            return '请选择城市!';
            exit;
        }

        if($data['xian_cityname'] == '请选择区/县...' || empty($data['xian_cityname'])){
            return '请选择县城!';
            exit;
        }

        if(!preg_match('/^[0-9]{6}$/',$data['postcode']) || empty($data['postcode'])){
            return '请填写邮政编码!';
            exit;
        }

        if(empty($data['address']) || !preg_match("/(\~|\!|\@|\#|\$|\%|\^|\&|\*|\<|\>|\[|\'|\"|\*|\`|\])/",$data['address'])){
            return '街道地址不合法或不能为空!';
            exit;
        }

        if(empty($data['username']) || preg_match("/^(\w)+$/",$data['username'])){
            return '收货人姓名不能为空并只能为中文!';
            exit;
        }

        if(!usedExp($data['phone'],'phoneExp')){
            return '请输入11位并且格式正确的手机号!';
            exit;
        }

        $data['uid'] = $_SESSION['member']['uid'];
        if($data['status1'] == 'on'){
            $data['status'] = 1;
            M('Member_address')->where('status = 1 AND uid = '.$_SESSION['member']['uid'])->setField('status','0');
        }else{
            $data['status'] = 0;
        }

        unset($data['status1']);
        if(M('Member_address')->add($data)){
            return true;
        }else{
            return '添加失败!';
        }

    }

    public function set_pass($new_pass){
        if(M('Member')->where('uid = '.$_SESSION['member']['uid'])->setField(array('pwd'=>PassWord($new_pass,null,null),'set_pass_time'=>time()))){
            return true;
        }else{
            return false;
        }
    }
}