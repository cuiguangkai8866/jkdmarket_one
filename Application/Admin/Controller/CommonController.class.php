<?php
namespace Admin\Controller;
use Think\Controller;
use Org\Util\Rbac;
header('cotent-type:text/html;charset=utf-8');
class CommonController extends Controller {

    public $loginMarked;

    /**
      +----------------------------------------------------------
     * 初始化
     * 如果 继承本类的类自身也需要初始化那么需要在使用本继承类的类里使用parent::_initialize();
      +----------------------------------------------------------
     */
    public function _initialize() {
        header("Content-Type:text/html; charset=utf-8");
        header('Content-Type:application/json; charset=utf-8');
        $systemConfig = include WEB_ROOT . 'Common/Conf/systemConfig.php';
        if (empty($systemConfig['TOKEN']['admin_marked'])) {
            $systemConfig['TOKEN']['admin_marked'] = "http://www.conist.com";
            $systemConfig['TOKEN']['admin_timeout'] = 3600;
            $systemConfig['TOKEN']['member_marked'] = "http://www.conist.com";
            $systemConfig['TOKEN']['member_timeout'] = 3600;
            set_config("systemConfig", $systemConfig, WEB_ROOT . "Common/Conf/");
            if (is_dir(WEB_ROOT . "install/")) {
                //delDirAndFile(WEB_ROOT . "install/", TRUE);
            }
        }
        $this->loginMarked = md5($systemConfig['TOKEN']['admin_marked']);
        $this->checkLogin();
        // 用户权限检查
        if (C('USER_AUTH_ON') && !in_array(CONTROLLER_NAME, explode(',', C('NOT_AUTH_MODULE')))) {
           // import('ORG.Util.RBAC');
            if (!RBAC::AccessDecision()) {
                //检查认证识别号
                if (!$_SESSION [C('USER_AUTH_KEY')]) {
                    //跳转到认证网关
                    redirect(C('USER_AUTH_GATEWAY'));
//                    redirect(PHP_FILE . C('USER_AUTH_GATEWAY'));
                }
                // 没有权限 抛出错误
                if (C('RBAC_ERROR_PAGE')) {
                    // 定义权限错误页面
                    redirect(C('RBAC_ERROR_PAGE'));
                } else {
                    if (C('GUEST_AUTH_ON')) {
                        $this->assign('jumpUrl', C('USER_AUTH_GATEWAY'));
                    }
                    // 提示错误信息
//                     echo L('_VALID_ACCESS_');
                    $this->error(L('_VALID_ACCESS_'));
                }
            }
        }
        $this->assign("menu", $this->show_menu());
        $this->assign("sub_menu", $this->show_sub_menu());
        $this->assign("my_info", $_SESSION['my_info']);
        $this->assign("site", $systemConfig);

      //  $this->getQRCode();
    }

    protected function getQRCode($url = NULL) {
        if (IS_POST) {
            $this->assign("QRcodeUrl", "");
        } else {
//            $url = empty($url) ? C('WEB_ROOT') . $_SERVER['REQUEST_URI'] : $url;
            $url = empty($url) ? C('WEB_ROOT') . U(CONTROLLER_NAME . '/' . ACTION_NAME) : $url;
            /*import('QRCode');
            $QRCode = new QRCode('', 80);
            $QRCodeUrl = $QRCode->getUrl($url);
            $this->assign("QRcodeUrl", $QRCodeUrl);*/
        }
    }

    public function checkLogin() {
        if (isset($_COOKIE[$this->loginMarked])) {
            $cookie = explode("_", $_COOKIE[$this->loginMarked]);
            $timeout = C("TOKEN");
            if (time() > (end($cookie) + $timeout['admin_timeout'])) {
                setcookie("$this->loginMarked", NULL, -3600, "/");
                unset($_SESSION[$this->loginMarked], $_COOKIE[$this->loginMarked]);
                $this->error("登录超时，请重新登录", U("Public/index"));
            } else {
                if ($cookie[0] == $_SESSION[$this->loginMarked]) {
                    setcookie("$this->loginMarked", $cookie[0] . "_" . time(), 0, "/");
                    session('elfinder',true);
                } else {
                    setcookie("$this->loginMarked", NULL, -3600, "/");
                    unset($_SESSION[$this->loginMarked], $_COOKIE[$this->loginMarked]);
                    $this->error("帐号异常，请重新登录", U("Public/index"));
                }
            }
        } else {
            $this->redirect("Public/index");
        }
        return TRUE;
    }

    /**
      +----------------------------------------------------------
     * 验证token信息
      +----------------------------------------------------------
     */
    protected function checkToken() {
        if (IS_POST) {
            if (!M("Admin")->autoCheckToken($_POST)) {
                die(json_encode(array('status' => 0, 'info' => '令牌验证失败')));
            }
            unset($_POST[C("TOKEN_NAME")]);
        }
    }

    /**
      +----------------------------------------------------------
     * 显示一级菜单
      +----------------------------------------------------------
     */
    private function show_menu() {
        $cache = C('admin_big_menu');
        $model=M('model')->where('is_inner=0')->field('tbl_name,menu_name')->select();
        foreach ($model as $key => $value) {
          $k=ucwords(str_replace(C('DB_PREFIX'),'', $value['tbl_name']));
          $cache[$k]=$value['menu_name'];
        }
        $count = count($cache);
        $i = 1;
        $menu = "";
        foreach ($cache as $url => $name) {
            if ($i == 1) {
                $css = $url == CONTROLLER_NAME || !$cache[CONTROLLER_NAME] ? "fisrt_current" : "fisrt";
                $menu.='<li class="' . $css . '"><span><a href="' . U($url . '/index') . '">' . $name . '</a></span></li>';
            } else if ($i == $count) {
                $css = $url == CONTROLLER_NAME ? "end_current" : "end";
                $menu.='<li class="' . $css . '"><span><a href="' . U($url . '/index') . '">' . $name . '</a></span></li>';
            } else {
                $css = $url == CONTROLLER_NAME ? "current" : "";
                $menu.='<li class="' . $css . '"><span><a href="' . U($url . '/index') . '">' . $name . '</a></span></li>';
            }
            $i++;
        }
        return $menu;
    }

    /**
      +----------------------------------------------------------
     * 显示二级菜单
      +----------------------------------------------------------
     */
    private function show_sub_menu() {
        $big = CONTROLLER_NAME == "Index" ? "Common" : CONTROLLER_NAME;
        $cache = C('admin_sub_menu');       
        if($mo=C($big)){
          $model[$big]=array();
          foreach ($mo['sub_menu'] as $value) {
              if(!$value['hidden']){
                  foreach ($value['item'] as $k => $v) {
                    $kv=explode('/', $k);
                    $model[$big][$kv[1]]=$v;
                  }
              }
          }
          $cache=array_merge($cache,$model);
        }
        $sub_menu = array();
        if ($cache[$big]) {
            $cache = $cache[$big];
            foreach ($cache as $url => $title) {
                $url = $big == "Common" ? $url : "$big/$url";
                $sub_menu[] = array('url' => U("$url"), 'title' => $title);
            }
            return $sub_menu;
        } else {
            return $sub_menu[] = array('url' => '#', 'title' => "该菜单组不存在");
        }
    }


    /**
     * 得到数据分页
     * @param  string $modelName 模型名称
     * @param  array  $where     分页条件
     * @return array
     */
    protected function getPagination($modelName, $where, $fields, $order) {
        $service = D($modelName, 'Service');
        // 总数据行数
        $totalRows = $service->getCount($where);
        // 实例化分页
        $page = new \Think\Page($totalRows, C('PAGE_LIST_ROWS'));
        $result['show'] = $page->show();
        // 得到分页数据
        $data = $service->getPagination($where,
                                        $fields,
                                        $order,
                                        $page->firstRow,
                                        $page->listRows);
        $result['data'] = $data;
        $result['total_rows'] = $totalRows;
        return $result;
    }

    /**
     * { status : true, info: $info}
     * @param  string $info
     * @param  string $url
     * @return
     */
    protected function successReturn($info, $url) {
        $this->resultReturn(true, $info, $url);
    }

    /**
     * { status : false, info: $info}
     * @param  string $info
     * @param  string $url
     * @return
     */
    protected function errorReturn($info, $url) {
        $this->resultReturn(false, $info, $url);
    }

    /**
     * 返回带有status、info键值的json数据
     * @param  boolean $status
     * @param  string $info
     * @param  string $url
     * @return
     */
    protected function resultReturn($status, $info, $url) {
        $json['status'] = $status;
        $json['info'] = $info;
        $json['url'] = isset($url) ? $url : '';

        return $this->ajaxReturn($json);
    }

    protected function _QueryDays($month,$year) {
        switch ($month) {
            case 4 :
            case 6 :
            case 9 :
            case 11 :
                $days = 30;
                break;
            case 2 :
                if ($year % 4 == 0) {
                    if ($year % 100 == 0) {
                        $days = $year % 400 == 0 ? 29 : 28;
                    } else {
                        $days = 29;
                    }
                } else {
                    $days = 28;
                }
                break;

            default :
                $days = 31;
                break;
        }
        return $days;
    }
        public function cancelOrRefundAction(){
        if(IS_POST){
            switch (I('post.type')) {
              case 'tyRefund':
                  $type = 1;
                  $status = 6;
                  break;
              case 'qxRefund':
                  $type = 2;
                  break;
              case 'zxOrder':
                  $type = 3;
                  $status = 7;
                  $content = '作废订单';
                  break;
              case 'qxOrder':
                  $type = 1;
                  $status = 1;
                  break;
              case 'swyzfOrder':
                  $type = 3;
                  $status = 2;
                  $content = '设为已支付';
                  break;
              case 'yshOrder':
                  $type = 3;
                  $status = 5;
                  $content = '设为已收货';
                  break;
              case 'writeOrder':
              case 'writeKuaidi':
                  $this->ajaxReturn(array('status'=>1,'info'=>'提交成功,等待执行...','url'=>U('Common/'.I('post.type')).'?id='.rtrim(I('post.id'),',').'&type='.I('post.type')));
                  break;
              case 'dcOrder':
                  $this->ajaxReturn(array('status'=>1,'info'=>'正在解析数据...','url'=>U('Common/'.I('post.type')).'?id='.rtrim(I('post.id'),',').'&type='.I('post.type')));
                  break;
            }
            $where['id'] = array('exp','IN('.rtrim(I('post.id'),',').')');
            $pro['update_time'] = time();
            if($type === 1){
              $this->ajaxReturn(array('status'=>1,'info'=>'2秒后跳转支付宝!','url'=>U('Product/cancelOrRefund').'?id='.rtrim(I('post.id'),',').'&type='.I('post.type')));
              exit();
            }else if($type === 2){
                $proOldStatus = M('Product_order')->where($where)->field('id,old_status,oid')->select();
                foreach ($proOldStatus as $k => $v) {
                    $pro['status'] = $v['old_status'];
                    $pro['old_status'] = 0;
                    if(!M('Product_order')->where('id = '.$v['id'])->save($pro)){
                        $actionInfo[] = $v['oid'];
                    }
                }
                if($actionInfo != null){
                    $this->ajaxReturn(array('status'=>0,'info'=>'订单号'.implode('&',$actionInfo).'执行失败!'));
                    exit();
                }else{
                    $this->ajaxReturn(array('status'=>1,'info'=>'批量修改操作成功!'));
                    exit();
                }
            }else if($type === 3){
              $pro['update_time'] = time();
              $pro['status'] = $status;
              if(M('Product_order')->where($where)->save($pro)){
                $this->ajaxReturn(array('status'=>1,'info'=>'批量'.$content.'成功!'));
                    exit();
              }else{
                $this->ajaxReturn(array('status'=>0,'info'=>'批量'.$content.'失败!'.M('Product_order')->_sql()));
                    exit();
              }
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>'选择的操作类型不合法!'));
                exit;
            }
        }
    }

    public function writeOrder(){
        if(I('get.id') != null){
            $where['id'] = array('exp','IN('.I('get.id').')');
            $orderInfo = M('Product_order')->where($where)->field('oid,published,cart_id,total_money,freight,aid,uid')->select();
            foreach ($orderInfo as $k => $v) {
                $addressInfo = M('Member_address')->where('id = '.$v['aid'])->find();
                foreach ($addressInfo as $k1 => $v1) {
                    $orderInfo[$k][$k1] = $v1;
                }
                $proWhere['id'] = array('exp','IN('.$v['cart_id'].')');
                $proInfo = M('Product_cart')->where($proWhere)->field('title,price,credit,num,present')->select();
                foreach ($proInfo as $k1 => $v1) {
                    $orderInfo[$k]['proinfo'][$k1] = $v1;
                }
            }
            $this->assign('orderInfo',$orderInfo);
            $this->display();
        }else{
            echo "<script>alert('订单不合法!');window.close()</script>";
        }
    }

    public function writeKuaidi(){
      if(I('get.id') != null){
            $where['id'] = array('exp','IN('.I('get.id').')');
            $orderInfo = M('Product_order')->where($where)->field('id,oid,published,cart_id,total_money,freight,aid,uid,fee_kid')->select();
            foreach ($orderInfo as $k => $v) {
                $addressInfo = M('Member_address')->where('id = '.$v['aid'])->find();
                foreach ($addressInfo as $k1 => $v1) {
                    $orderInfo[$k][$k1] = $v1;
                }
            }
            $this->assign('info',$orderInfo);
            $this->display();
        }else{
            echo "<script>alert('订单不合法!');window.close()</script>";
        }
    }

    public function sitemap() {
        if(IS_POST){
          $pid = M('Nav')->where('parent_id = 0')->field('id,tag')->select();
          $site = array();
          foreach($pid as $k=>$v){
            $list = M('Nav')->where('parent_id = '.$v['id'])->field('tag,guide,id,parent_id')->select();
            foreach ($list as $k1 => $v1) {
              if($v['tag'] == 'Help'){
                $listOne = M('Nav')->where('parent_id = '.$v1['id'])->field('tag,guide,id,parent_id')->select();
                foreach ($listOne as $k2 => $v2) {
                  $site[]['url'] = U('/Help/'.$v2['tag']).'.html';
                  $site[]['time'] = date('Y-m-d',time());
                }
              }elseif($v['tag'] == 'nav'){
                if($v1['tag'] == 'shop'){
              $site[]['url'] = U('/shop').'.html?Mid='.base64_encode($v1['guide']);
                }else{
                  $site[]['url'] = U('/'.$v1['tag']).'.html';
                }
                $site[]['time'] = date('Y-m-d',time());
              }elseif($v['tag'] == 'miscell'){
                $article = M('Nav')->where('parent_id = '.$v['id'])->getField('guide',true);
                $aWhere['cid'] = array('exp','IN('.implode(',',$article).')');
                $newsInfo = M('News')->where($aWhere)->getField('id',true);
                foreach ($newsInfo as $k2 => $v2) {
                  $site[]['url'] = U('/newsInfo/'.$v2).'.html';
                  $site[]['time'] = date('Y-m-d',time());
                }
              }
        }
          }
          foreach ($site as $k => $v) {
            $site[$k]['url'] = 'http://'.rtrim($_SERVER['SERVER_NAME'],'/').$v['url'];
          }
          $sitemap = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\r\n";
          foreach($site as $k=>$v){
              $sitemap .= "<url>\r\n"."<loc>".$v['url']."</loc>\r\n"."<priority>0.6</priority>\r\n<lastmod>".$v['time']."</lastmod>\r\n<changefreq>weekly</changefreq>\r\n</url>\r\n";
          }
          $sitemap .= '</urlset>';
          //生成或更新Sitemap XML 格式文件
          $file = fopen(__ROOT__."sitemap.xml","w");
          fwrite($file,$sitemap);
          fclose($file);
          $this->ajaxReturn(array('status'=>1,'info'=>'Sitemap更新成功!'));
          exit();
        }else{
          echo '请通过后台生成SITEMAP';
          exit();
        }
    }

    public function dcOrder(){
        $xls = new \Org\Util\Excel_XML();
        $xwhere['p.id'] = array('exp','IN('.rtrim(I('get.id'),',').')');
        $xwhere['_string'] = 'p.uid = m.uid AND a.id = p.aid';
        $list = M()->table(
          array(
            C('DB_PREFIX').'product_order'=>'p',
            C('DB_PREFIX').'member'=>'m',
            C('DB_PREFIX').'member_address'=>'a',
            )
          )
        ->field('a.shen_cityname,a.shi_cityname,a.xian_cityname,a.address,a.username,a.postcode,a.phone,m.nickname,p.oid,p.delivery,p.invoice,p.total_money,p.total_credit,p.present,p.freight,p.content,p.order_ip,p.published,p.update_time,p.fee_name,p.fee_kid,p.alipay_id,p.payway,p.fee_code')
        ->where($xwhere)
        ->select();
        $data = array('收货地址(省份)','收货地址(市区)','收货地址(县城)','收货地址(详细地址)','收货地址(收货人)','收货地址(邮编)','收货地址(电话)','用户昵称','站内订单号','配送时间','发票信息','订单总金额','订单总积分','订单赠品','订单运费','订单描述','订单创建IP','订单创建时间','订单更新时间','快递公司名称','快递单号','第三方交易平台订单号','支付方式','快递公司代码');
        array_unshift($list,$data);
        foreach ($list as $k => $v) {
          $list[$k]['published'] = date('Y-m-d H:i:s',$v['published']);
          $list[$k]['update_time'] = date('Y-m-d H:i:s',$v['update_time']);
        }
        $xls = new \Org\Util\Excel_XML('UTF-8', false, 'ArGentum 制作');
        $xls->addArray($list);
        $xls->generateXML(date('Y_m_d_H_i_s',time()).'批量导出订单');
        exit();
    }
    
}