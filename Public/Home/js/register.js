function SendMail(obj,url){
    $('.phonecode').click(function(){
        if(obj == null){
            var info = $("#signup-email-address").val();
        }else{
            var info = obj;
        }
        if(url == null){
            var urls = location.href;
        }else{
            var urls = url;
        }
        var check_email = /^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/;
        var check_phone = /^[0-9]{11}$/;
        if(check_email.test(info)){
            $.post(urls,{email:info},function(data){
                if(data.status == 1){
                    popup.success(data.info);
					          time($('.phonecode'),300);
                }else{
                    popup.error(data.info);
                }
            },'json');
        }else if(check_phone.test(info)){
            $.post(urls,{phone:info},function(data){
                if(data.status == 1){
                    popup.success(data.info);
                }else{
                    popup.error(data.info);
                }
            },'json');
        }else{
            popup.error('邮箱或者手机号码是错误的!');
        }
    });
}
function SendNowCode(obj,url){
    if(obj == null){
        var info = $("input[name='info[email]']").val();
        var urls = location.href;
    }else{
        var urls = url;
        var info = obj;
    }
    var check_email = /^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/;
    var check_phone = /^[0-9]{11}$/;
    if(check_email.test(info)){
        $.post(urls,{email:info},function(data){
            if(data.status == 1){
                popup.success(data.info);
                time($('.phonecode'),300);
            }else{
                popup.error(data.info);
            }
        },'json');
    }else if(check_phone.test(info)){
        $.post(urls,{phone:info},function(data){
            if(data.status == 1){
                popup.success(data.info);
            }else{
                popup.error(data.info);
            }
        },'json');
    }else{
        popup.error('邮箱或者手机号码是错误的!');
    }
}
function time(obj,mytime) {
    if(mytime == 0){
        obj.attr('class','phonecode');
        obj.html('获取效验码');
        location.reload();
    }else{
        obj.attr('class','sendcode');
        mytime --;
        obj.html('等待(<span>'+mytime+'</span>秒)后重新发送');
        setTimeout(function(){
            time(obj,mytime);
        },1000)
    }
}

//修改密码
$(function(){
    $('.set_pass').click(function(){
        asyncbox.prompt($('.set_pass:first').text(),$('.set_pass:first').text(),'','password',function(action,val){
            if(action == 'ok'){
                $.post(location.href,{pass:val,type:'pass'},function(data){
                    if(data.status == 1){
                        popup.success(data.info);
                        location.reload();
                    }else{
                        popup.error(data.info);
                    }
                },'json');
            }
        })
    })
})

//邮箱操作
$(function(){
    //绑定邮箱
    $('.set_email').click(function(){
        asyncbox.prompt('绑定邮箱','输入邮箱:','','text',function(action,val){
            if(action == 'ok'){
                $.post(location.href,{email:val,type:'get_check_code'},function(data){
                    if(data.status == 1){
                        popup.success(data.info);
                        setTimeout(function(){
                            popup.close("asyncbox_success");
                        },1500);
                        setTimeout(function(){
                            asyncbox.prompt('验证码验证','输入验证码:','','text',function(action,val){
                                if(action == 'ok'){
                                    $.post(location.href,{code:val,type:'check_code'},function(data2){
                                        if(data2.status == 1){
                                            popup.success(data2.info);
                                            setTimeout(function(){
                                                popup.close("asyncbox_success");
                                                location.reload();
                                            },2000);
                                        }else{
                                            popup.error(data2.info);
                                            setTimeout(function(){
                                                popup.close("asyncbox_error");
                                            },2000);
                                        }
                                    },'json')
                                }
                            });
                        },2000);
                    }else{
                        popup.error(data.info);
                        setTimeout(function(){
                            popup.close("asyncbox_error");
                        },2000);
                    }
                },'json');
            }
        })
    });
    //修改邮箱
    $('.update_email').click(function(){
        //弹出旧邮箱输入窗口
        asyncbox.prompt('更新邮箱','输入旧邮箱:','','text',function(action,val){
            if(action == 'ok'){
                $.post(location.href,{email:val,type:'get_check_code'},function(data){
                    if(data.status == 1){
                        popup.success(data.info);
                        setTimeout(function(){
                            popup.close("asyncbox_success");
                        },1500);
                        setTimeout(function(){
                            //弹出旧邮箱验证码验证
                            asyncbox.prompt('验证码验证','输入验证码:','','text',function(action,val){
                                if(action == 'ok'){
                                    $.post(location.href,{code:val,type:'check_old_email'},function(data2){
                                        if(data2.status == 1){
                                            popup.success(data2.info);
                                            setTimeout(function(){
                                                popup.close("asyncbox_success");
                                            },1500);
                                            setTimeout(function(){
                                                //弹出输入新邮箱窗口
                                                asyncbox.prompt('输入新邮箱','输入新邮箱:','','text',function(action,val){
                                                    if(action == 'ok'){
                                                        $.post(location.href,{email:val,type:'get_check_code'},function(data3){
                                                            if(data3.status == 1){
                                                                popup.success(data3.info);
                                                                setTimeout(function(){
                                                                    popup.close("asyncbox_success");
                                                                },1500);
                                                                //弹出新邮箱验证码
                                                                asyncbox.prompt('验证码验证','输入验证码:','','text',function(action,val){
                                                                    if(action == 'ok'){
                                                                        $.post(location.href,{code:val,type:'check_code'},function(data4){
                                                                            if(data4.status == 1){
                                                                                popup.success(data4.info);
                                                                                setTimeout(function(){
                                                                                    popup.close("asyncbox_success");
                                                                                },1500);
                                                                                setTimeout(function(){
                                                                                    location.reload();
                                                                                },2000);
                                                                            }else{
                                                                                popup.error(data4.info);
                                                                                setTimeout(function(){
                                                                                    popup.close("asyncbox_success");
                                                                                },1500);
                                                                            }

                                                                        },'json')
                                                                    }
                                                                });
                                                            }else{
                                                                popup.error(data3.info);
                                                                setTimeout(function(){
                                                                    popup.close("asyncbox_success");
                                                                },1500);
                                                            }
                                                        },'json')
                                                    }

                                                })
                                            },2000)
                                        }else{
                                            popup.error(data2.info);
                                            setTimeout(function(){
                                                popup.close("asyncbox_error");
                                            },2000);
                                        }
                                    },'json')
                                }
                            });
                        },2000);
                    }else{
                        popup.error(data.info);
                        setTimeout(function(){
                            popup.close("asyncbox_error");
                        },2000);
                    }
                },'json');
            }
        })
    });
})

//手机操作
$(function(){
    $('.set_phone').click(function(){
        //弹出绑定手机窗口
        asyncbox.prompt('绑定手机','输入手机号:','','text',function(action,val){
           if(action == 'ok'){
               $.post(location.href,{phone:val,type:'get_phone_check_code'},function(data){
                   if(data.status == 1){
                       popup.success(data.info);
                       setTimeout(function(){
                           popup.close("asyncbox_success");
                       },1500);
                       setTimeout(function(){
                           asyncbox.prompt('验证验证码','输入验证码:','','text',function(action,val){
                                if(action == 'ok'){
                                    $.post(location.href,{phone:val,type:'check_phone'},function(data2){
                                        if(data2 == 1){
                                            popup.success(data.info);
                                            setTimeout(function(){
                                                popup.close("asyncbox_success");
                                            },1500);
                                        }else{
                                            popup.error(data.info);
                                            setTimeout(function(){
                                                popup.close("asyncbox_error");
                                            },1500);
                                        }
                                    });
                                }
                           });
                       },2000);
                   }else{
                       popup.error(data.info);
                       setTimeout(function(){
                           popup.close("asyncbox_error");
                       },1500);
                   }
               },'json');
           }
        });
    })
})

//设置密码
$(function(){
    //设置支付密码
    $('.set_pay_pass').click(function(){
       asyncbox.prompt('设置支付密码','请输入新支付密码:','','password',function(action,val){
           if(action == 'ok'){
               $.post(location.href,{pay_pass:val,type:'set_pay_pass'},function(data){
                   if(data.status == 1){
                       popup.success(data.info);
                       setTimeout(function(){
                           popup.close("asyncbox_success");
                       },2000);
                       //验证验证码
                       setTimeout(function(){
                           asyncbox.prompt('支付密码验证码','请输入支付密码验证码:','','text',function(action,val){
                               if(action == 'ok'){
                                   $.post(location.href,{code:val,type:'set_pay_pass_start'},function(data2){
                                       if(data2.status == 1){
                                           popup.success(data2.info);
                                           setTimeout(function(){
                                               popup.close("asyncbox_success");
                                           },2000);
                                           setTimeout(function(){
                                               location.reload();
                                           },2100);
                                       }else{
                                           popup.error(data2.info);
                                           setTimeout(function(){
                                               popup.close("asyncbox_error");
                                           },2000)
                                       }
                                   },'json')
                               }
                           });
                       },2200)
                   }else{
                       popup.error(data.info);
                       setTimeout(function(){
                           popup.close("asyncbox_error");
                       },2000)
                   }
               },'json')
           }
       })
   });
    //修改支付密码
    $('.update_pay_pass').click(function(){
        asyncbox.prompt('修改支付密码','请输入旧支付密码:','','password',function(action,val){
            if(action == 'ok'){
                $.post(location.href,{set_pay_pass:val,type:'set_pay_pass'},function(data){
                    if(data.status == 1){
                        popup.success(data.info);
                        setTimeout(function(){
                            popup.close('asyncbox_success');
                        },2000);
                        setTimeout(function(){
                            asyncbox.prompt('新的支付密码','请输入新支付密码:','','password',function(action,val){
                                if(action == 'ok'){
                                    $.post(location.href,{pay_pass:val,type:'set_pay_pass'},function(data2){
                                        if(data2.status == 1){
                                            popup.success(data2.info);
                                            setTimeout(function(){
                                                popup.close("asyncbox_success");
                                            },2000);
                                            setTimeout(function(){
                                                asyncbox.prompt('支付密码验证码','请输入支付密码验证码:','','text',function(action,val){
                                                    if(action == 'ok'){
                                                        $.post(location.href,{code:val,type:'set_pay_pass_start'},function(data2){
                                                            if(data2.status == 1){
                                                                popup.success(data2.info);
                                                                setTimeout(function(){
                                                                    popup.close("asyncbox_success");
                                                                },2000);
                                                                setTimeout(function(){
                                                                    location.reload();
                                                                },2100);
                                                            }else{
                                                                popup.error(data2.info);
                                                                setTimeout(function(){
                                                                    popup.close("asyncbox_error");
                                                                },2000)
                                                            }
                                                        },'json')
                                                    }
                                                });
                                            },2200);
                                        }else{
                                            popup.error(data2.info);
                                            setTimeout(function(){
                                                popup.close("asyncbox_error");
                                            },2000)
                                        }
                                    },'json')
                                }
                            });
                        },2200);
                    }else{
                        popup.error(data.info);
                        setTimeout(function(){
                            popup.close('asyncbox_error');
                        },2000)
                    }
                });
            }
        });
    });
});



function DelAddress(url){
    $.get(url,function(data){
        if(data == 1){
            popup.success('删除成功!');
            setTimeout(function(){
                location.reload();
            },1000)
        }else{
            popup.error(data);
        }
    },'json')
}

function SendCheckCode(){

    var info = $("input[name=email_phone]").val();
    var check_email = /^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/;
    var check_phone = /^[0-9]{11}$/;
        if(check_email.test(info)){
            $.post(location.href,{email:info},function(data){
                if(data.status == 1){
                    popup.success(data.info);
                }else{
                    popup.error(data.info);
                }
            },'json');
        }else if(check_phone.test(info)){
            $.post(location.href,{phone:info},function(data){
                if(data.status == 1){
                    popup.success(data.info);
                }else{
                    popup.error(data.info);
                }
            },'json');
        }else{
            popup.error('邮箱或者手机号码是错误的!');
        }
}

$(function(){
    $('.sub_address').click(function(){
        var shen_cityname = $("select[name='shen_cityname']").val();
        var shi_cityname = $("select[name='shi_cityname']").val();
        var xian_cityname = $("select[name='xian_cityname']").val();
        var postcode = $("input[name='postcode']").val();
        var address = $("textarea[name='address']").val();
        var username = $("input[name='username']").val();
        var phone = $("input[name='phone']").val();
        var status = $("input[name='status']").val();
        $.post(location.href,{shen_cityname:shen_cityname,shi_cityname:shi_cityname,xian_cityname:xian_cityname,postcode:postcode,address:address,username:username,phone:phone,status1:status},function(data){
            if(data.status == 1){
                setTimeout(popup.success(data.info),3000);
                setTimeout(function(){
                    popup.close("asyncbox_success");
                },2000);
                setTimeout(function(){
                    location.reload();
                },1500);
            }else{
                setTimeout(popup.error(data.info),3000);
                setTimeout(function(){
                    popup.close("asyncbox_error");
                },2000);
            }

        },'json')
    })
})
