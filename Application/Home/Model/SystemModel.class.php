<?php
/* * * * * * * * * * * * * * * * * * * *
 * 系统数据处理方法库                     *
 * * * * * * * * * * * * * * * * * * * */

    namespace Home\Model;
    use Think\Model;
class SystemModel extends Model{
    public function __construct(){
        parent::__construct();
    }

    /*邮箱发送*/
    public function SendEmail($user_mail,$mail_title,$mail_content){
        return send_mail($user_mail,"",$mail_title,$mail_content,"");
    }


}