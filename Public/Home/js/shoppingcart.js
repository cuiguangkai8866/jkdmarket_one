function shoppingCart(url,obj,num,login_url,type){
    $.post(url,{obj:obj,num:(num == null)?1:num,login_url:(login_url == null)?'':location.href,type:type},function(data){
        if(data.status == 1){
            $('.shoppingcartinfo').html(data.info);
            $('#u-buy-layId').show();
            if(data.content != null){
                if(data.content == num){
                    $('.cart_num'+obj).html(Number($('.cart_num'+obj).html()) + Number(num));
                    $('#cart_money').html(Number($('#cart_money').html()) + (Number($('.cart_price'+obj).html())* Number(num)));
                }else{
                    $('#shopping-amount').html(Number($('#shopping-amount').html()) + 1);
                    $('#total_shop').html(Number($('#total_shop').html()) + 1);
                    $('#cart_money').html(Number($('#cart_money').html()) + Number(data.content.price*data.content.num));
                    $('#mcart-gift').append('<li id="buycart'+data.content.id+'">'
                        +
                        '<div class="p-img fl">'
                            +
                            '<a href="'+data.content.url+'" target="_blank">'
                                +
                                '<img src="'+data.content.img+'" alt="'+data.content.title+'" width="50" height="50" />'
                                +
                            '</a>'
                            +
                        '</div>'
                        +
                        '<div class="p-name fl">'
                            +
                            '<a href="'+data.content.url+'" title="'+data.content.title+'" target="_blank">'+data.content.title2+'</a>'
                            +
                        '</div>'
                        +
                        '<div class="p-detail fr ar">'
                            +
                            '<span class="p-price">'
                                +
                                '<strong>￥ <span id="cart_price'+data.content.id+'" class="cart_price'+data.content.pro_id+'">'+data.content.price+'</span></strong>'
                                +
                                '×<span id="cart_num'+data.content.id+'" class="cart_num'+data.content.pro_id+'">'+data.content.num+'</span>'
                                +
                            '</span>'
                            +
                            '<br><a class="delete" style="cursor: pointer;" onclick="delBuyCart('+data.content.id+','+data.content.del_url+')">'
                                +
                                '删除'
                                +
                            '</a>'
                            +
                        '</div>'
                        +
                        '</li>');
                }
            }
            if(type != 'detail'){
                popup.success(data.info);
            }
            setTimeout(function(){
                $('#u-buy-layId').hide();
                popup.close('asyncbox_success');
            },10000)
        }else if(data.status == 2){
            asyncbox.confirm(data.info,'操作提示',function(action){
                if(action == 'ok'){
                    location.href = data.url;
                }
            })
        }else{
            $('.shoppingcartinfo').html(data.info);
            popup.error(data.info);
            $('#u-buy-layId2').show();
            setTimeout(function(){
                $('#u-buy-layId2').hide();
                popup.close('asyncbox_error');
            },10000)
        }
    },'json')
}
function delBuyCart(obj,url){
    asyncbox.confirm('删除操作','删除后是无法恢复,您确定删除吗?',function(action){
        if(action == 'ok'){
            $.post(url,{obj:obj},function(data){
                if(data == 1){
                    $('#buycart'+obj).hide();
                    $('#shopping-amount').html(Number($('#shopping-amount').html()) - 1);
                    $('#total_shop').html(Number($('#total_shop').html()) - 1);
                    $('#cart_money').html(changeTwoDecimal_f($('#cart_money').html() - ((Number($('#cart_price'+obj).html())) * Number($('#cart_num'+obj).html()))));
                }else{
                    popup.error('操作失败!');
                }
            },'json');
        }

    })
}
function delBuyCartInfo(obj,url){
    asyncbox.confirm('删除后无法恢复,确定删除吗?','操作提示',function(action){
        if(action == 'ok'){
            $.post(url,{obj:obj},function(data){
                if(data == 1){
                    $('.cart_money').html(changeTwoDecimal_f($('.cart_money').html()) - (Number($('#cart_price'+obj).html()) * Number($('.cart_num'+obj).val())));
                    $('#selectedCount').html(Number($('#selectedCount').html()) - 1);
                    $('#cart_market').html(changeTwoDecimal_f($('#cart_market').html() - ((Number($('#cart_market'+obj).html()) - Number($('#cart_price'+obj).html())) * Number($('.cart_num'+obj).val()))));
                    popup.success('删除成功!');
                    $('.buycart'+obj).hide();
                    setTimeout(function(){
                        popup.close('asyncbox_success');
                    },2000);
                }else{
                    popup.error('删除失败!');
                    setTimeout(function(){
                        popup.close('asyncbox_error');
                    },2000);
                }
            },'json');
        }
    });
}
function addBuyNum(obj,url,type){
    if(type == 'add'){
        var num = Number($('.cart_num'+obj).val()) + 1;
    }else if(type == 'reduce'){
        var num = Number($('.cart_num'+obj).val()) - 1;
    }else if(type == null){
        var num = Number($('.cart_num'+obj).val());
    }
    if(num != null && num >= 1 && num != 'NaN'){
        $.post(url,{obj:obj,num:num},function(data){
            if(data.status == 1){
                if(type == 'add'){
                    var allMoney;
                    var allMarket;
                    var i = 0;
                    $.each($("#product-list input[name='checkItem']"),function(k){
                        if($(this).prop('checked')){
                            var obj = Number($(this).val());
                            i = parseInt(i)+1;
                            if(i == 1){
                                allMoney = Number($('#cart_price'+obj).html())*parseInt($('.cart_num'+obj).val());
                                allMarket = Number($('#cart_market'+obj).html())*parseInt($('.cart_num'+obj).val());
                            }else{
                                allMoney += Number($('#cart_price'+obj).html())*parseInt($('.cart_num'+obj).val());
                                allMarket += Number($('#cart_market'+obj).html())*parseInt($('.cart_num'+obj).val());
                            }

                        }
                        if(i == 0){
                            allMarket = 0;
                            allMoney = 0;
                        }
                    });

                    $('#selectedCount').html(i);
                    $('.cart_money').html(changeTwoDecimal_f(allMoney));
                    $('#cart_market').html(changeTwoDecimal_f(allMarket));
                }else if(type == 'reduce'){
                    var allMoney;
                    var allMarket;
                    var i = 0;
                    $.each($("#product-list input[name='checkItem']"),function(k){
                        if($(this).prop('checked')){
                            var obj = Number($(this).val());
                            i = parseInt(i)+1;
                            if(i == 1){
                                allMoney = Number($('#cart_price'+obj).html())*parseInt($('.cart_num'+obj).val());
                                allMarket = Number($('#cart_market'+obj).html())*parseInt($('.cart_num'+obj).val());
                            }else{
                                allMoney += Number($('#cart_price'+obj).html())*parseInt($('.cart_num'+obj).val());
                                allMarket += Number($('#cart_market'+obj).html())*parseInt($('.cart_num'+obj).val());
                            }

                        }
                        if(i == 0){
                            allMarket = 0;
                            allMoney = 0;
                        }
                    });

                    $('#selectedCount').html(i);
                    $('.cart_money').html(changeTwoDecimal_f(allMoney));
                    $('#cart_market').html(changeTwoDecimal_f(allMarket));
                }else if(type == null){
                    var allMoney;
                    var allMarket;
                    var i = 0;
                    $.each($("#product-list input[name='checkItem']"),function(k){
                        if($(this).prop('checked')){
                            var obj = Number($(this).val());
                            i = parseInt(i)+1;
                            if(i == 1){
                                allMoney = Number($('#cart_price'+obj).html())*parseInt($('.cart_num'+obj).val());
                                allMarket = Number($('#cart_market'+obj).html())*parseInt($('.cart_num'+obj).val());
                            }else{
                                allMoney += Number($('#cart_price'+obj).html())*parseInt($('.cart_num'+obj).val());
                                allMarket += Number($('#cart_market'+obj).html())*parseInt($('.cart_num'+obj).val());
                            }

                        }
                        if(i == 0){
                            allMarket = 0;
                            allMoney = 0;
                        }
                    });

                    $('#selectedCount').html(i);
                    $('.cart_money').html(changeTwoDecimal_f(allMoney));
                    $('#cart_market').html(changeTwoDecimal_f(allMarket));
                }
            }else{
                $('.cart_num'+obj).val(data.num);
                popup.error(data.info);
            }
        },'json');
    }else{
        $('.cart_num'+obj).val(1);
    }
}
function delCheckedBox(url){
    $.each($("#product-list input[type='checkbox']"),function(){
        if($(this).prop('checked')){
            var obj = $(this).val();
            $.post(url,{obj:$(this).val()},function(data){
                if(data == 1){
                    popup.success('删除成功！');
                    setTimeout(function(){
                        popup.close('asyncbox_success');
                    },1500)
                    setTimeout(function(){
                        location.reload();
                    },2000)
                }else{
                    popup.error('删除失败!');
                    setTimeout(function(){
                        popup.close('asyncbox_error');
                    },2000)
                }
            });
        }
    });
}
function reallyOrder(url){
    var reallyObj = '';
    $.each($("#product-list input[name='checkItem']"),function(k){
        if($(this).prop('checked')){
            reallyObj += $(this).val()+',';
        }
    });
    if(reallyObj != null){
        $.post(url,{obj:reallyObj,type:'reallyOrder'},function(data){
            if(data == 1){
                location.href= url;
            }else{
                popup.error(data);
                setTimeout(function(){
                    popup.close('asyncbox_error');
                },1500)
            }
        });
    }else{
        popup.error('请至少选择一样商品!');
        setTimeout(function(){
            popup.close('asyncbox_error');
        },1500)
    }
}
function saveAddressInfo(obj,type){
    //收货人姓名
    var username = $('#username'+obj).html();
    //收货人电话
    var phone = $('#phone'+obj).html();
    //收货人地区
    var shen_cityname = $('#shen_cityname'+obj).html();
    var shi_cityname = $('#shi_cityname'+obj).html();
    var xian_cityname = $('#xian_cityname'+obj).html();
    //详细地址
    var address = $('#address'+obj).html();
    //邮政地址
    var postcode = $('#postcode'+obj).html();
    if(type == 'load'){
        $('#shipwindow_receiver').val(username);
        $('#s_province').append('<option selected value="'+shen_cityname+'">'+shen_cityname+'</option>');
        $('#s_city').append('<option selected value="'+shi_cityname+'">'+shi_cityname+'</option>');
        $('#s_county').append('<option selected value="'+xian_cityname+'">'+xian_cityname+'</option>');
        $('#shipwindow_address').val(address);
        $('#shipwindow_areacode').val(postcode);
        $('#shipwindow_mobile').val(phone);
        $('#save_id').val(obj);
    }else if(type == 'submit'){
        commonAjaxSubmit(location.href,obj);
    }else if(type == 'status'){
        $.post(location.href,{obj:obj,type:type},function(data){
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
        },'json');
    }
}
function delAddress(url){
    asyncbox.confirm('该操作将会删除您的收货地址,确认删除?','操作提示',function(action){
         if(action == 'ok'){
             $.get(url,function(data){
                 if(data == 1){
                     popup.success('删除成功!');
                     setTimeout(function(){
                         popup.close('asyncbox_success');
                         location.reload();
                     },1500);
                 }else{
                    popup.error(data);
                     setTimeout(function(){
                         popup.close('asyncbox_error');
                     },1500);
                 }
             },'json')
         }
    })
}
function setOrderInfo(obj,type){
    if(type == 'setInvoice'){
        if(obj == '#invoices'){
            var title = $("#invoices input[name='invoice[title]']:checked").val();
            var content = $("#invoices input[name='invoice[content]']:checked").val();
            $.post(location.href,{title:title,content:content,type:type},function(data){
                if(data.status == 1){
                    //$('#invoice_need_save_title').html(data.title);
                    $('#invoice_need_save_content').html(data.content);
                }
            });
        }else{
            $.post(location.href,{obj:obj,type:type});
        }
    }else{
        $.post(location.href,{obj:obj,type:type});
    }
}
function updateCheckBox(){
    var allMoney = 0;
    var allMarket = 0;
    var i = 0;
    $.each($("#product-list input[name='checkItem']"),function(k){
        if($(this).prop('checked')){
            var obj = Number($(this).val());
            i = parseInt(i)+1;
            if(i == 1){
                allMoney = Number($('#cart_price'+obj).html())*Number($('.cart_num'+obj).val());
                allMarket = Number($('#cart_market'+obj).html())*Number($('.cart_num'+obj).val());
            }else{
                allMoney += Number($('#cart_price'+obj).html())*Number($('.cart_num'+obj).val());
                allMarket += Number($('#cart_market'+obj).html())*Number($('.cart_num'+obj).val());
            }

        }
        if(i == 0){
            allMarket = 0;
            allMoney = 0;
        }
    });

    $('#selectedCount').html(i);
    $('.cart_money').html(changeTwoDecimal_f(allMoney));
    $('#cart_market').html(changeTwoDecimal_f(allMarket));
}
function updateAllCheckBox(){
    var allMoney = 0;
    var allMarket = 0;
    var i = 0;
    if($('.jdcheckbox').prop('checked')){
        $.each($("#product-list input[name='checkItem']"),function(k){
            var obj = Number($(this).val());
            i = parseInt(i)+1;
            if(i == 1){
                allMoney = Number($('#cart_price'+obj).html())*Number($('.cart_num'+obj).val());
                allMarket = Number($('#cart_market'+obj).html())*Number($('.cart_num'+obj).val());
            }else{
                allMoney += Number($('#cart_price'+obj).html())*Number($('.cart_num'+obj).val());
                allMarket += Number($('#cart_market'+obj).html())*Number($('.cart_num'+obj).val());
            }
            if(i == 0){
                allMarket = 0;
                allMoney = 0;
            }
        });
    }else{
        i=0;
        allMarket = 0;
        allMoney = 0;
    }
    $('#selectedCount').html(i);
    $('.cart_money').html(changeTwoDecimal_f(allMoney));
    $('#cart_market').html(changeTwoDecimal_f(allMarket));
}
function changeTwoDecimal_f(x){
    var f_x = parseFloat(x);
    if (isNaN(f_x))
    {
        alert('输入的数值是不合法的!');
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