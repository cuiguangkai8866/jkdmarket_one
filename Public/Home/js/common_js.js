$(function(){
    $('.ask_insert').click(function(){
        $('#ask').ajaxSubmit({
            url:location.href,
            type:"POST",
            success:function(data, st) {
                if(data == 1){
                    popup.success('咨询提交成功,等待客服回复!');
                    // ifr.location.reload();
                    setTimeout(function(){
                        location.reload(true);
                        // popup.close('asyncbox_success');
                    },2000)
                }else{
                    popup.error(data);
                    setTimeout(function(){
                        popup.close('asyncbox_error');
                    },2000)
                }
            }
        })
    })
    
})
function AddCommect(){
    $.post(location.href,{type:'addcommect'},function(data){
        popup.success(data);
        setTimeout(function(){
            location.reload();
            //window.location.href="/Login.html";
        },1500)
    },'json')
}
function DelCommect(url,obj){
    var url = (url == null) ? location.href : url;
    $.post(url,{type:'delcommect',obj:obj},function(data){
        popup.success(data);
        setTimeout(function(){
            location.reload();
        },1500);
    },'json');
}
$(function(){
    $(".productTabTit li").bind('click', function(event) {
        $(this).addClass('on').siblings('li').removeClass('on');
        var thindex = $(this).index();
        $(".dRight-wrap").children('.dRight-tab-con').eq(thindex).show().siblings().hide();
    });
    /////////详情页加减数量///////////////


    $(".add").click(function(){
        var stock = parseInt($('.stock').html());
		var zdMin = parseInt($("#zdMin").text());
		var zdMax = parseInt($("#zdMax").text());
        if(stock <= 0){
            popup.error('库存不足');
        }else{
            var num = parseInt($("#pd_number").val()) + 1;
            if(num <= stock){
                $("#pd_number").val(num);
            }

            if(num == 1 || num < 0){
                $(".sub").addClass("buyNub-nub-blus");
            }else{
                $(".sub").removeClass("buyNub-nub-blus");
            }

            if(num >= stock){
                $(".add").addClass("buyNub-nub-top-s");
            }else{
                $(".add").removeClass("buyNub-nub-top-s");
            }
        }

    })

	$(".sub").click(function(){
        var stock = parseInt($('.stock').html());
        var num = parseInt($("#pd_number").val()) - 1;
        if(num > 0 && num < stock){
            $("#pd_number").val(num);
        }
        if(num <= 1){
            $(".sub").addClass("buyNub-nub-blus");
        }else{
            $(".sub").removeClass("buyNub-nub-blus");
        }

        if(num >= stock){
            $(".add").addClass("buyNub-nub-top-s");
        }else{
            $(".add").removeClass("buyNub-nub-top-s");
        }
    });

	$(".tadd").click(function(){
        var stock = parseInt($('.stock').html());
		var zdMin = parseInt($("#zdMin").text());
		var zdMax = parseInt($("#zdMax").text());
        if(stock <= 0){
            popup.error('库存不足');
        }else{
            var num = parseInt($("#pd_number").val()) + 1;
            if(num <= zdMax && num >= zdMin && num <= stock){
                $("#pd_number").val(num);
            }

            if(num < zdMin){
                $(".tsub").addClass("buyNub-nub-blus");
            }else{
                $(".tsub").removeClass("buyNub-nub-blus");
            }

            if(num >= stock){
                $(".tadd").addClass("buyNub-nub-top-s");
            }else{
                $(".tadd").removeClass("buyNub-nub-top-s");
            }
        }

    })

    $(".tsub").click(function(){
        var stock = parseInt($('.stock').html());
        var num = parseInt($("#pd_number").val()) - 1;
		var zdMin = parseInt($("#zdMin").text());
		var zdMax = parseInt($("#zdMax").text());
        if(num <= zdMax && num >= zdMin){
            $("#pd_number").val(num);
        }
        if(num <= zdMin){
            $(".tsub").addClass("buyNub-nub-blus");
        }else{
            $(".tsub").removeClass("buyNub-nub-blus");
        }

        if(num >= stock){
            $(".tadd").addClass("buyNub-nub-top-s");
        }else{
            $(".tadd").removeClass("buyNub-nub-top-s");
        }
    });

    $("#pd_number").blur(function(event) {
        var stock = parseInt($('.stock').html());
        var num = parseInt($("#pd_number").val());
        if(num <= 1){
            $(".sub").addClass("buyNub-nub-blus");
            $("#pd_number").val(1);
        }else{
            $(".sub").removeClass("buyNub-nub-blus");
        }

        if(num >= stock){
            $(".add").addClass("buyNub-nub-top-s");
        }else{
            $(".add").removeClass("buyNub-nub-top-s");
        }
    });

    $("#pd_number").keyup(function(event) {
        var tval = $(this).val();
        var kc = parseInt($(".buyNub-tit .stock").text());
        $(this).val(tval.replace(/[^\d]/g,'1'));
        if(tval > kc){
            $(this).val(kc);
        }

        if(tval == ''){
            $(this).val(1);
        }

        if(isNaN(tval)){
            $(this).val('1');
        }
    });
})
function performOrderAction(obj,type,url){
    var url = (url == null)?location.href:url;
    var title = '';
    var content = '';
    if(obj == null){
        popup.error('obj is not defined');
        setTimeout(function(){
            popup.close('asyncbox_error');
        },1500);
    }
    if(type == null){
        popup.error('type is not defined');
        setTimeout(function(){
            popup.close('asyncbox_error');
        },1500);
    }
    switch(type){
        // case 'cancelOrder':
        //     title = '操作提示';
        //     content = '即将取消订单,是否继续?';
        //     break;
        case 'cancelRefund':
            title = '操作提示';
            content = '您确定要取消吗?';
            break;
        case 'pleaseReallyOrderInfo':
            title= '确定收货';
            content = '您确定要确认收货吗?';
            break;
        default:
            popup.error('Action Error!');
            setTimeout(function(){
                popup.close('asyncbox_error');
            },1500);
            break;
    }
    if(type == 'cancelOrder'){
        $.post(url,{obj:obj,type:type,action:'perform'},function(data){
            if(data.status == 1){
                popup.success(data.info);
                setTimeout(function(){
                    location.reload();
                    popup.close('asyncbox_success');
                },1500);
            }else{
                popup.error(data.info);
                setTimeout(function(){
                    popup.close('asyncbox_error');
                },1500);
            }
        },'json');
    }else{
        asyncbox.confirm(content,title,function(action){
            if(action == 'ok'){
                asyncbox.prompt('操作提示','请输入您的支付密码','','password',function(action,val){
                    if(action == 'ok'){
                        $.post(url,{obj:obj,type:type,action:'perform',val:val},function(data){
                            if(data.status == 1){
                                popup.success(data.info);
                                setTimeout(function(){
                                    location.reload();
                                    popup.close('asyncbox_success');
                                },1500);
                            }else{
                                popup.error(data.info);
                                setTimeout(function(){
                                    popup.close('asyncbox_error');
                                },1500);
                            }
                        },'json');
                    }
                })
            }
        });
    }
    
}
function askDataAction(obj){
    if(obj == null){
        popup.error('obj is not defined !');
        setTimeout(function(){
            popup.close('asyncbox_error');
        },1500);
        return;
    }
    asyncbox.prompt('商品咨询追问','请输入您的提问','','textarea',function(action,val){
        if(action == 'ok'){
            $.post(location.href,{obj:obj,val:val},function(data){
                if(data.status == 1){
                    popup.success(data.info);
                    setTimeout(function(){
                        popup.close('asyncbox_success');
                        location.reload();
                    },1500);
                }else{
                    popup.error(data.info);
                    setTimeout(function(){
                        popup.close('asyncbox_error');
                    },1500);
                }
            })
        }
    });
}
function AddEvaluation(pid,obj){
    asyncbox.prompt('追评操作','请输入内容','','textarea',function(action,val){
        if(action == 'ok'){
            $.post(location.href,{pid:pid,obj:obj,val:val},function(data){
                if(data.status == 1){
                    popup.success(data.info);
                    setTimeout(function(){
                        popup.close('asyncbox_success');
                        location.reload();
                    },1500);
                }else{
                    popup.error(data.info);
                    setTimeout(function(){
                        popup.close('asyncbox_error');
                    },1500);
                }
            })
        }
    })
}
$(function(){
    $('.u-buy').click(function(){
        var price = parseInt($('#pai_number').val());
        $.post(location.href,{price:price},function(data){
            if(data.status == 'isNoLogin'){
                popup.confirm(data.info,'操作提示',function(action){
                    if(action == 'ok'){
                        location.href = data.url;
                    }
                });
            }else if(data.status == 'isSuccess'){
                //popup.success(data.info);
                setTimeout(function(){
                    //popup.close('asyncbox_success');
                    location.reload();
                },1500);
            }else{
                popup.error(data.info);
                setTimeout(function(){
                    popup.close('asyncbox_error');
                },1500)
            }
        },'json')
    })

    $('form').submit(function() {
        if(typeof jQuery.data(this, "disabledOnSubmit") == 'undefined') {
            jQuery.data(this, "disabledOnSubmit", { submited: true });
            $('input[type=submit], input[type=button]', this).each(function() {
            $(this).attr("disabled", "disabled");
        });
            return true;
        }
        else{
            return false;
        }
    });

    // 搜索框为空的判断
    $(".form .button").click(function(){
        var kv = $('#key').val();
        if(!kv){
            $(".form .text").focus();
            return false;
        }
    })
})