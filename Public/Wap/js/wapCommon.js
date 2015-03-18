//执行加入购物车操作
function wapAddCart(url,obj,val,type){
    if(url == null || url == ''){
        url = location.href;
    }
    if(obj == null || obj == ''){
        return false;
    }
    if(val == null || val == ''){
        return false;
    }
    if(type == null || type == ''){
        return false;
    }
    $.post(url,{obj:obj,val:val,type:type},function(data){
        var top = parseInt($(window).height())/2-25;
        if(data.status == 1){
            if(url ==null || url == ''){
                $("#cart").show().css('top', top);
            }else{
                layer.open({
                    content: data.info,
                    style: 'background-color:#42EE1B; color:#fff; border:2px solid #fff;text-align:center;',
                    time: 2
                });
                setTimeout(function(){
                    if(data.url != null && data.url != ''){
                        location.href=data.url;
                    }
                },2000);
            }
        }else{
            layer.open({
                content: data.info,
                style: 'background-color:#f00; color:#fff; border:2px solid #fff;text-align:center;',
                time: 2
            });
			setTimeout(function(){
				if(data.url != null){
					location.href = data.url;
				}
			},2000)
        }
    },'json')
}
function checkLogin(){
    var user = $('#email').val();
    var pwd = $('#password').val();
    $.post(location.href,{user:user,pwd:pwd},function(data){
        if(data.status == 1){
            layer.open({
                content: data.info,
                style: 'background-color:#42EE1B; color:#fff; border:2px solid #fff;text-align:center;',
                time: 2
            });
            if(data.url != null && data.url != ''){
                setTimeout(function(){
                    location.href = data.url;
                },2000);
            }
        }else{
            layer.open({
                content: data.info,
                style: 'background-color:#f00; color:#fff; border:2px solid #fff;text-align:center;',
                time: 2
            });
        }
    },'json');
    return false;
}
function checkLogout(url){
    $.post(url,function(data){
        if(data.status == 1){
            layer.open({
                content: data.info,
                style: 'background-color:#42EE1B; color:#fff; border:2px solid #fff;text-align:center;',
                time: 2
            });
            if(data.url != null && data.url != ''){
                setTimeout(function(){
                    location.href = data.url;
                },2000);
            }
        }else{
            layer.open({
                content: data.info,
                style: 'background-color:#f00; color:#fff; border:2px solid #fff;text-align:center;',
                time: 2
            });
        }
    },'json');
    return false;
}
function changeOrderStatus(url,obj,type){
    $.post((url == null || url == '')?location.href:url,{obj:obj,type:type},function(data){
        if(data.status == 1){
            layer.open({
                content: data.info,
                style: 'background-color:#42EE1B; color:#fff; border:2px solid #fff;text-align:center;',
                time: 2
            });

            if(data.url != null || data.url != ''){
                setTimeout(function(){
                    location.href= data.url;
                },2000)
            }
        }else if(data.status == 2){
            layer.open({
                content:data.info,
                btn: ['确认', '取消'],
                shadeClose: false,
                yes: function(){
                    $.post((url == null || url == '')?location.href:url,{obj:obj,type:type+'Really'},function(data){
                        if(data.status == 1){
                            layer.open({content:data.info, time: 1});
                            setTimeout(function(){
                                location.reload();
                            },1100)
                        }else{
                            layer.open({content:data.info, time: 1});
                        }
                    },'json');
                }, no: function(){
                    layer.open({content: '您已取消本次操作!', time: 1});
                }
            });
        }else{
            layer.open({
                content: data.info,
                style: 'background-color:#f00; color:#fff; border:2px solid #fff;text-align:center;',
                time: 2
            });
        }
    },'json');
}
function delCookieList(url){
    $.post((url == null )?location.href:url,function(data){
        if(data.status == 1){
            layer.open({
                content: data.info,
                style: 'background-color:#42EE1B; color:#fff; border:2px solid #fff;text-align:center;',
                time: 2
            });
            setTimeout(function(){
                location.reload();
            },2000)
        }else{
            layer.open({
                content: data.info,
                style: 'background-color:#f00; color:#fff; border:2px solid #fff;text-align:center;',
                time: 2
            });
        }
    })
}
function delMyFavorite(url,obj,type){
    switch(type){
        case 'delFavorite':
            var info = '删除此条收藏';
            break;
        case 'delAddress':
            var info = '删除此收货地址';
            break;
        case 'delCartData':
            var info = '删除此商品信息';
            break;
    }
    layer.open({
        content:'您确定要'+info+'吗？',
        btn: ['确认', '取消'],
        shadeClose: false,
        yes: function(){
            $.post((url == null || url == '')?location.href:url,{obj:obj,type:type},function(data){
                if(data.status == 1){
                    layer.open({content:data.info, time: 1});
                    setTimeout(function(){
                        location.reload();
                    },2000);
                }else{
                    layer.open({content:data.info, time: 1});
                }
            },'json');
        }, no: function(){
            layer.open({content: '您已取消本次操作!', time: 1});
        }
    });
}
function addressForm(url,obj){
    var username = $('#username').val();
    var phone = $('#phone').val();
    var postcode = $('#postcode').val();
    var shen_cityname = $('#s_province').val();
    var shi_cityname = $('#s_city').val();
    var xian_cityname = $('#s_county').val();
    var address = $('#address').val();
    $.post((url == null)?location.href:url,{obj:obj,name:username,postcode:postcode,phone:phone,shen_cityname:shen_cityname,shi_cityname:shi_cityname,xian_cityname:xian_cityname,address:address},function(data){
        if(data.status == 1){
            layer.open({
                content: data.info,
                style: 'background-color:#42EE1B; color:#fff; border:2px solid #fff;text-align:center;',
                time: 2
            });
            setTimeout(function(){
                if(data.url == null || data.url == ''){
                    location.reload();
                }else{
                    location.href = data.url;
                }
            },2000);
        }else{
            layer.open({
                content: data.info,
                style: 'background-color:#f00; color:#fff; border:2px solid #fff;text-align:center;',
                time: 2
            });
        }
    },'json')
}
function updateNum(obj,val,type,url){
    if(val != null && val != '' && !isNaN(val)){
        $.post((url == null) ? location.href:url,{obj:obj,val:val,type:type},function(data){
            if(data.status == 1){
                updateTotal();
            }else{
                layer.open({
                    content: data.info,
                    style: 'background-color:#f00; color:#fff; border:2px solid #fff;text-align:center;',
                    time: 2
                });
                setTimeout(function(){
                    location.reload();
                },2000)
            }
        },'json');
    }
}
function saveTwoSmallNumber(x){
    var f_x = parseFloat(x);
    if (isNaN(f_x))
    {
        return false;
    }
    f_x = Math.round(f_x*100)/100;
    var s_x = f_x.toString();
    var pos_decimal = s_x.indexOf('.');
    if (pos_decimal < 0)
    {
        pos_decimal = s_x.length;
        s_x += '.';
    }
    while (s_x.length <= pos_decimal + 2)
    {
        s_x += '0';
    }
    return s_x;
}
function updateTotal(type){
    var allMoney = 0;
    var allMarket = 0;
    var allNum = 0;
    if(type == 'all'){
        if($('.cartProInfo').is(':checked')){
            $.each($('.list > li > div > input'),function(k,v){
                allNum = allNum+1;
                var obj = parseInt($(this).attr('kid'));
                var price = saveTwoSmallNumber($('#price'+obj).html());
                var market = saveTwoSmallNumber($('#market'+obj).html());
                var num = parseInt($('#num'+obj).val());
                if(allNum == 1){
                    allMoney = price*parseInt(num);
                    allMarket = market*parseInt(num);
                }else{
                    allMoney += saveTwoSmallNumber(price)*parseInt(num);
                    allMarket += saveTwoSmallNumber(market)*parseInt(num);
                }
            });
        }else{
            allMoney = 0;
            allMarket = 0;
            allNum = 0;
        }
    }else{
        $.each($('.list > li > div > input'),function(k,v){
            if($(this).is(':checked')){
                allNum = allNum+1;
                var obj = parseInt($(this).attr('kid'));
                var price = saveTwoSmallNumber($('#price'+obj).html());
                var market = saveTwoSmallNumber($('#market'+obj).html());
                var num = parseInt($('#num'+obj).val());
                if(allNum == 1){
                    allMoney = price*parseInt(num);
                    allMarket = market*parseInt(num);
                }else{
                    allMoney += saveTwoSmallNumber(price)*parseInt(num);
                    allMarket += saveTwoSmallNumber(market)*parseInt(num);
                }
            }
        });
    }
    $('.cart_realPrice').html(saveTwoSmallNumber(allMoney));
    $('.cart_oriPrice').html(saveTwoSmallNumber(allMoney));
    $('#cart_rePrice').html(saveTwoSmallNumber(allMarket));
    $('#checkedNum').html(parseInt(allNum));
}
function reallyBuy(url,obj,type){
    if(obj == null || obj == ''){
        var proInfo = '';
        var allNum = 0;
        $.each($('.list > li > div > input'),function(k,v){
            if($(this).is(':checked')){
                allNum = allNum+1;
                var obj = parseInt($(this).attr('kid'));
                if(allNum == 1){
                    proInfo = obj+',';
                }else{
                    proInfo += obj+','
                }
            }
        });
        if(proInfo == null || proInfo == ''){
            layer.open({
                content: '请选择您的商品!',
                style: 'background-color:#f00; color:#fff; border:2px solid #fff;text-align:center;',
                time: 2
            });
            setTimeout(function(){
                location.reload();
            },2000)
        }
    }
    $.post((url == null)?location.href:url,{obj:(obj == null)?proInfo:obj,lx:type},function(data){
        if(data.status == 1){
            layer.open({
                content: data.info,
                style: 'background-color:#42EE1B; color:#fff; border:2px solid #fff;text-align:center;',
                time: 2
            });
            setTimeout(function(){
                if(data.url == null || data.url == ''){
                    location.reload();
                }else{
                    location.href = data.url;
                }
            },2000);
        }else{
            layer.open({
                content: data.info,
                style: 'background-color:#f00; color:#fff; border:2px solid #fff;text-align:center;',
                time:2
            });
            setTimeout(function(){
                location.reload();
            },2000)
        }
    },'json');
}
function favoriteAction(url,obj,type,types){
    if(obj == null){
        return false;
    }
    $.post((url == null ?location.href:url),{obj:obj,type:type,types:types},function(data){
       if(data.status == 1){
           $(".icon-succ").text(data.info);
       }else{
           layer.open({
               content: data.info,
               style: 'background-color:#f00; color:#fff; border:2px solid #fff;text-align:center;',
               time: 2
           });
           return false;
       }
    });
}
function register(){
    var username = $('#email').val();
    var pass = $('#password').val();
    var rePass = $('#password2').val();
    var reCheck = $('#recheck').val();

    $.post(location.href,{username:username,pass:pass,rePass:rePass,reCheck:reCheck},function(data){
        if(data.status == 1){
            layer.open({
                content: data.info,
                style: 'background-color:#42EE1B; color:#fff; border:2px solid #fff;text-align:center;',
                time: 2
            });
            setTimeout(function(){
                if(data.url == null || data.url == ''){
                    location.reload();
                }else{
                    location.href = data.url;
                }
            },2000);
        }else{
            layer.open({
                content: data.info,
                style: 'background-color:#f00; color:#fff; border:2px solid #fff;text-align:center;',
                time: 2
            });
            setTimeout(function(){
                if(data.url != null && data.url != ''){
                    location.href = data.url;
                }
            },2000);
        }
    },'json')
}
function getPhoneCode(phone,url){
	$.post((url == null)?location.href:url,{phone:phone},function(data){
		if(data.status == 1){
			$('.get_btn').hide();
            $(".get-num").show();
            var time = 300;
            var Int = setInterval(function(){
              time--;
              $(".get-num i").html(time + "秒");
              if(time == 0){
                $(".get-num").hide();
                $(".get_btn").show();
                time = 60;
                clearInterval(Int);
              }
            },1000)
			layer.open({
                content: data.info,
                style: 'background-color:#42EE1B; color:#fff; border:2px solid #fff;text-align:center;',
                time: 2
            });
		}else{
			layer.open({
                content: data.info,
                style: 'background-color:#f00; color:#fff; border:2px solid #fff;text-align:center;',
                time: 2
            });
		}
	},'json');
}