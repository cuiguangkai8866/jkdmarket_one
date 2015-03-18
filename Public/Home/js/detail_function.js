//添加商品至购物  
// 添加商品至购物车的公共方法



/*function addSkuToCartWithSrcForDetail(type,goods,count,pack,src,local){
	var proxy_url = "/httpProxyAccess.htm?t="+(new Date()).getTime();
	var shop_cart_request_url = domain_cart+"/addToCart.htm";
	if(src != null && src == '5'){
		pack = "QC";
	}
	jQuery.post(proxy_url,{target:shop_cart_request_url,"pack":pack,"count":count,"goods":goods,"src":src},function(data){
		
		if(data.status==1){
			if(data.cart_key){setCookie("cart",data.cart_key,7);}
			if(data.goods_count){setCookie("cart_goods_count",data.goods_count,7);}
			if(type==1){
				var itop=$('.buyNub-buy').offset().top-$(window).scrollTop();
				if(itop<$(window).height()/2)
				{
					$("#u-buy-layId").attr("class","u-buy-lay");
					$("#u-buy-layId").fadeIn(100);
				}
				else
				{
					$("#u-buy-layId").attr("class","u-buy-lay-on");
					$("#u-buy-layId").fadeIn(100);
					$('.depict-order,.buyNub-buy').css('z-index','9');
				}
				$("#u-buy-layId").show();
				$("#u-buy-layId2").hide();
			}else if(type==2){
				$("#u-buy-laycl").show();
				$("#u-buy-laycl2").hide();
			}else if(type==3){
				var l=$(local).position().left - 10;
				var t=$(local).position().top - 23;
				$("#u-buy-left_one").css({left:l,top:t}).fadeIn(100);
			}
			
			
		}else if(data.status==2){
			$("#u-buy-layId2 ._cartstatus").html(data.stack);
			$("#u-buy-layId2").show();
			$("#u-buy-layId").hide();
		}else{
			var isorderbuypros = 0;
			var alertstr="";
			if(data.stack.indexOf("]")>0){
				isorderbuypros=1;
				var alertstrtpm = data.stack;
				
				var eint = alertstrtpm.indexOf("]");
				alertstr=alertstrtpm.substring(eint+1,alertstrtpm.length);
				alertstr = "此商品"+alertstr;
			}
			if(type==1){
				var itop=$('.buyNub-buy').offset().top-$(window).scrollTop();
				if(itop<$(window).height()/2)
				{
					$("#u-buy-layId").attr("class","u-buy-lay");
					$("#u-buy-layId").fadeIn(100);
					
				}
				else
				{	
					$("#u-buy-layId").attr("class","u-buy-lay-on");
					$("#u-buy-layId").fadeIn(100);
					$('.depict-order,.buyNub-buy').css('z-index','9');
				}
				if(isorderbuypros==1){
					$("#u-buy-layId2 ._cartstatus").html(alertstr);
				}
				
				$("#u-buy-layId2").show();
				$("#u-buy-layId").hide();
			}else if(type==2){
				if(isorderbuypros==1){
					$("#u-buy-laycl2 ._cartstatus").html(alertstr);
				}
			
				$("#u-buy-laycl2").show();
				$("#u-buy-laycl").hide();
			}else if(type==3){
				if(isorderbuypros==1){
					$("#u-buy-left_two ._cartstatus").html(alertstr);
				}
				var l=$(local).position().left - 10;
				var t=$(local).position().top - 23;
				
				$("#u-buy-left_two").css({left:l,top:t}).fadeIn(100);
			}
			
		}
		
	}, 'JSON');
}*/

/*function toCart(type,goodsId,num,rec_type,is_gift,local) {
	if(!num ||num==0 ){
		num = $("#_nub").val();
	}
  var isorderbuypro = $("#_isorderbuypro").val();
//  if(isorderbuypro==1){
//	  jQuery.ajax({
//	        type: "post",
//	        url: "/pro/selectLoginSession.htm?t="+getCurDate(),
//	        data: {},
//	        dataType:"json",
//	        async: true,
//	        success: function(data) {
//	            if (data && data.code == 0 && data.loginUser) {
//	            	
//	            }else{
//	            	window.location.href=domain_passprot+'/login.htm';
//					return false;
//	            }
//	        }
//	  });
//  }
  var fromId = goodsfrom.getGoodsFromId(goodsId);
  addSkuToCartWithSrcForDetail(type,goodsId,num,'',fromId,local);
	setTimeout(function(){
		$("#u-buy-left_one").hide();
		$("#u-buy-left_two").hide();
		return false;
	},5000);    
}*/

/*function toAdvance(goodsId,nub){
	var proxy_url = "/httpProxyAccess.htm?t="+(new Date()).getTime();
	var shop_cart_request_url = domain_cart+"order/confirm.htm";
	jQuery.post(proxy_url,{target:shop_cart_request_url,"submitType":2,"product":goodsId+"_"+nub},function(data){
		window.location.href=domain_cart+"order/confirm.htm";
	}
	)
}*/


/*function timeAct() {
    var day = null;
    var hour = null;
    var minute = null;
    var second = null;
    day = leaveTimeLen / (60 * 60 * 24);
    hour = leaveTimeLen % (60 * 60 * 24) / (60 * 60);
    minute = leaveTimeLen % (60 * 60 * 24) % (60 * 60) / 60;
    second = leaveTimeLen % (60 * 60 * 24) % (60 * 60) % 60;
    var time = "";
    if (parseInt(day) != 0) {
        time = "<span class='tim-shi'>" + parseInt(day) + "</span>天" + "<span class='tim-shi'>" + parseInt(hour) + "</span>时" + "<span class='tim-shi'>" + parseInt(minute) + "</span>分" + "<span class='tim-shi'>" + parseInt(second) + "</span>秒";
    } else {
        if (parseInt(hour) != 0) {
            time = "<span class='tim-shi'>" + parseInt(hour) + "</span>时" + "<span class='tim-shi'>" + parseInt(minute) + "</span>分" + "<span class='tim-shi'>" + parseInt(second) + "</span>秒";
        } else {
            if (parseInt(minute) != 0) {
                time = "<span class='tim-shi'>" + parseInt(minute) + "</span>分" + "<span class='tim-shi'>" + parseInt(second) + "</span>秒";
            } else {
                time = "<span class='tim-shi'>" + parseInt(second) + "</span>秒";
            }
        }
        //<span class="tim-shi">13</span>时<span class="tim-shi">47</span>分<span class="tim-shi">00.0</span>秒
    }
   
    $(".t").html(time);
   
   
    if (leaveTimeLen <= 0) {
    	 $("._leaveTimeLen").hide();
    } else {
    	 $("._leaveTimeLen").show();
        leaveTimeLen--;
        setTimeout(timeAct, 1000);
        
    }
}*/
/*function initpl(plnubs) {
	if(0==plnubs){
		  jQuery('#_nopl').show();
	}else{
		getEvaluateContent(1);
		jQuery('#_havapl').show();
	}
	
	isplzxislogined();
	        
	
	
}*/

/*function isplzxislogined(){
	 jQuery.ajax({
	        type: "post",
	        url: "/pro/selectLoginSession.htm?t="+getCurDate(),
	        data: {},
	        dataType:"json",
	        async: true,
	        success: function(data) {
	            if (data && data.code == 0 && data.loginUser) {
	            	
	            }else{
	            	 jQuery('._notislogined').show();
	            }
	        }
	       });
	
}

function initzx(zxtype) {
	
	getConsultContent(1,zxtype);
	isplzxislogined();

}


//评论加载
function getEvaluateContent(pageNum) {
	
    $("#_detailEvaluateContent").load(
    		"/pro/selectProEvaluate.htm", 
    		{
		        "proId": goodsId,
		        "pageNum": pageNum
		    },
		    function() {}).show();
}

function getCountConsultContent() {
	jQuery.ajax({
        type: "post",
        url: "/pro/selectCountProConsult.htm?t="+getCurDate(),
        data: { "proId": goodsId},
        dataType:"json",
        async: true,
        success: function(data) {
        	 if (data && data.code==0 && data.countmap ){
                 $("#_zx1").html('('+data.countmap['a1']+')');
                 $("#_zx2").html('('+data.countmap['a2']+')');
                 $("#_zx3").html('('+data.countmap['a3']+')');
                 $("#_zx4").html('('+data.countmap['a4']+')');
                 $("#_zx0").html('('+data.countmap['a0']+')');
        	 }else{
        		 $("#_zx1").html('('+0+')');
                 $("#_zx2").html('('+0+')');
                 $("#_zx3").html('('+0+')');
                 $("#_zx4").html('('+0+')');
                 $("#_zx0").html('('+0+')');
        	 }
        }
  });
}*/


function checkProNum(num,type){
	//if(singleAmount){
	//	if(parseInt(num)>parseInt(xg)){
	//		$(".buyNub-nub").find('input').val(xg).blur();
	//		alert("此商品限购"+xg+"瓶 / 套");
	//		return false;
	//		}
	//	}
	}

function getConsultContent(pageNum, type) {
	$("#_detailConsultContent"+type).load("/pro/selectProConsult.htm", {
        "proId": goodsId,
        "type": type,
        "pageNum": pageNum
    },
    function() {}).show();
}

function sub(pageNum, type) {
    if (type == -1) {
    	var topHeight1=$(".detail-box2").offset().top;
    	$(window).scrollTop(topHeight1);
        getEvaluateContent(pageNum);
    }else if(type == -2){
    	var uri = window.location.href;
    	var pageNumIndex = uri.indexOf("&pageNum=");
    	if(pageNumIndex > 0){
    		uri = uri.substring(0, pageNumIndex);
    	}
    	location = uri + "&pageNum=" + pageNum;
    } else {
    	var topHeight2=$(".detail-box2").offset().top;
    	$(window).scrollTop(topHeight2);
        getConsultContent(pageNum, type);
    }
}
function setPage(pageNo,pageSize,totalPages,totalResults,type){
    var pageNo = parseInt(pageNo);
    var pageSize = parseInt(pageSize);
    var totalPages = parseInt(totalPages);
    var totalResults = parseInt(totalResults);
    var page= '<div class="u-evaluate-page">';
                 if(totalPages==1){
                	 page+='<a class="prve" href="javascript:void(0);" title="上一页">上一页</a>'
                                       +'<a class="current" >1</a>'
                                       +'<a class="next" href="javascript:void(0);" title="下一页">下一页</a>';
                 }
                 var totle=5;
                 if(totalPages>1){
                     if(pageNo>1){
                    	 page+='<a class="prve" href="javascript:void(0);" title="上一页" onclick="sub('+(pageNo-1)+','+type+');">上一页</a>';
                     }else if(pageNo==1){
                    	 page+='<a class="prve" href="javascript:void(0);" title="上一页">上一页</a>';
                     }
                     
                     var content='';
                     var left='';
                     var leftlength=0;
                     var right='';
                     var rightlength=0;
                     var midle='';
                     for(var i=pageNo-Math.floor(totle/2);i<pageNo;i++){
                         if(i>0){
                            left+='<a href="javascript:void(0);" onclick="sub('+i+','+type+');">'+i+'</a>';
                            leftlength++;
                         }
                     }
                     midle='<a class="current" >'+pageNo+'</a>';
                     for(var i=pageNo+1;i<=pageNo+Math.floor(totle/2);i++){
                         if(i<=totalPages){
                             right+='<a href="javascript:void(0);" onclick="sub('+i+','+type+');"  >'+i+'</a>';
                             rightlength++;
                         }
                     }
                     
                     if(leftlength+rightlength < totle-1){
                        if(pageNo-leftlength-1>0 || pageNo+rightlength<totalPages){
                             while(leftlength+rightlength<totle-1){
                                 if(pageNo-leftlength-1>0){
                                     leftlength++;
                                     left='<a href="javascript:void(0);"  onclick="sub('+(pageNo-leftlength)+','+type+');"   >'+(pageNo-leftlength)+'</a>'+left;    
                                 }else if(pageNo+rightlength<totalPages){
                                     rightlength++;
                                     right+='<a href="javascript:void(0);" onclick="sub('+(pageNo+rightlength)+','+type+');"     >'+(pageNo+rightlength)+'</a>';    
                                 }else break;
                             }
                         }
                     }
                     content=left+midle+right;
                    
                     if(pageNo-leftlength-1 > 1){
                    	 page+='<a href="javascript:void(0);" onclick="sub(1,'+type+');">1</a><span>...</span>';
                     }
                     else if(pageNo-leftlength-1 == 1) {
                    	 page+='<a href="javascript:void(0);" onclick="sub(1,'+type+');">1</a>';
                     }
                     page+=content;
                    
                     if(pageNo+rightlength < totalPages-1){
                    	 page+='<span>...</span><a href="javascript:void(0);" onclick="sub('+totalPages+','+type+');">'+totalPages+'</a>';
                    }
                     else if(pageNo+rightlength == totalPages-1){
                    	 page+='<a href="javascript:void(0);" onclick="sub('+totalPages+','+type+');">'+totalPages+'</a>';
                     }
                    
                     if(pageNo<totalPages){
                    	 page+='<a class="next" href="javascript:void(0);" title="下一页" onclick="sub('+(pageNo+1)+','+type+');">下一页</a>';
                     }
                     else if(pageNo==totalPages){
                    	 page+='<a class="next" href="javascript:void(0);" title="下一页">下一页</a>';
                     }
                 }
                page+='</div>';
              return page;  
}

function addComment() {
    jQuery.ajax({
        type: "post",
        url: "/pro/selectLoginSession.htm?t="+getCurDate(),
        data: {},
        dataType:"json",
        async: true,
        success: function(data) {
            if (data && data.code == 0 && data.loginUser) {
                var con = jQuery.trim($("#_ComContent").val());
                if (con == "") {
                    alert("请输入相关内容！");
                    return false;
                }
                if (con == "请输入您的评论内容...") {
                    alert("请输入您的评论内容...");
                    return false;
                }
                var aa = /[//<>@]+/;
                if(aa.test(con)){
                	alert("包含非法字符,请重新输入！");return;
                	}
                jQuery.ajax({
                	type:"post",
                	url:"/pro/saveComment.htm?t="+getCurDate(),
                	data:{"proId":goodsId,"score":score,"content":con},
                	dataType:"json",
                	contentType:"application/x-www-form-urlencoded;charset=utf-8",
                	success:function(data){
                		if(data){
                			if(data.code==-1){
                			alert("提交失败 ! ");
                			return false;
                		}else{
                			if(data.code==0){
                				alert("提交成功 ! ");
                				$("#_ComContent ").val("");
                				return false;
                			}else{if(data.code==1){
                				//alert("您还没有登录哦！");
                				window.location.href=domain_passprot+'/login.htm';
                				return false}
                			else{
                				if(data.code==2){
                					alert("您还未购买过此商品，暂时不能评论，感谢您对酒仙网的支持");
                					return false;
                				}else{
                					if(data.code==3){
                						alert("您操作频繁，请稍后再试！");
                						return false;
                					}
                					if(data.code==4){
                						alert("评价内容含有敏感词，请过滤后再提交！");
                						return false;
                					}
                				}
                				}
                			}
                			}
                		}
                		}
                	}
                )}
            else{
            	//alert("您还没有登录哦！");
            	window.location.href=domain_passprot+'/login.htm';
            	return false;
            }
            }
        }
    )}

function initpldz(plids){
    jQuery.ajax({
    type:'post',
    url:'/pro/selectPldz.htm?t='+getCurDate(),
    data:{'plids':plids},
    dataType:'json',
    cache:false,
    async:true,
    success:function(data, textStatus){
   		if(data && data.code==8){
			var finalmap = data.finalmap;
			for(var key in finalmap){   
				 if(key=='tjmap'){
					 var tjmap = finalmap['tjmap'];
					 for( var i=0; i<tjmap.length; i++){
						 var plid=tjmap[i]['plid'];
						 var sum=tjmap[i]['sum'];
						 jQuery("[pldztj='"+plid+"']").html(sum);
					 }
						 
				 }else if(key=='map'){
					 var tmap = finalmap['map'];
					 for( var i=0; i<tmap.length; i++){
						 var plid=tmap[i]['plid'];
						 jQuery("#_plidyz"+plid).show();
						 jQuery("#_pliddz"+plid).hide();
					 }
				 }
			}
		
		}
   	}
    
    });
   }
   
   
   
   
   
   
function addpldz(plid,p,proId) {
jQuery.ajax({
type: "post",
url: "/pro/selectLoginSession.htm?t="+getCurDate(),
data: {},
dataType:"json",
async: true,
success: function(data) {
if (data && data.code == 0 && data.loginUser) {

jQuery.ajax({
type:"post",
url:"/pro/savepldz.htm?t="+getCurDate(),
data:{"plid":plid},
dataType:"json",
contentType:"application/x-www-form-urlencoded;charset=utf-8",
success:function(data){
	if(data && data.code==0){
		
		jQuery("#_plidyz"+plid).show();
		jQuery("#_pliddz"+plid).hide();
		jQuery("#_plidyz"+plid).find("em").show().animate({'top':'-30px','opacity':'0.3'},500,function(){
			var tnub = $.trim($("#_nubf"+plid).text())||0;
			tnub = parseInt(tnub);
			var hnub = parseInt(tnub+1);
			$(this).siblings("span").text("已赞("+hnub+")");
			$(this).siblings("i").addClass("on");
			$(this).remove();
		});	
		
	}
	}
}
)}
else{
//alert("您还没有登录哦！");
	window.location.href=domain_passprot+"/login.htm?from="+domain_detail+"/goods-"+proId+".html";
return false;
}
}
}
)}


function addCouponForDetail(CouponId) {
    jQuery.ajax({
        type: "post",
        url: "/pro/selectLoginSession.htm?t="+getCurDate(),
        data: {},
        dataType:"json",
        async: true,
        success: function(data) {
            if (data && data.code == 0 && data.loginUser) {
                jQuery.ajax({
                	type:"post",
                	url:"/pro/saveCouponFroDetail.htm?t="+getCurDate(),
                	data:{"CouponId":CouponId},
                	dataType:"json",
                	contentType:"application/x-www-form-urlencoded;charset=utf-8",
                	success:function(data){
                		if(data){
                			if(data.code==-1){
                			alert("提交失败 ! 请进入商品纠错进行反馈！");
                			return false;
                		}else{
                			if(data.code==8){
                				alert("领券成功 ! ");
                				return false;
                			}else{
                				if(data.code==1){
                				//alert("您还没有登录哦！");
                				window.location.href=domain_passprot+'/login.htm';
                				return false
                				}else{
                				if(data.code==2){
                					alert("优惠券过期！");
                					return false;
                				}else if(data.code==3){
                					alert("您已经领过5次此优惠券！");
                					return false;
                				}else if(data.code==5){
                					alert("您操作频繁，请稍后再试！");
                					return false;
                				}else{
                					alert("其他未知错误，请进入商品纠错进行反馈！");
                					return false;
                					
                				}
                				}
                			}
                			}
                		}
                		}
                	}
                )}
            else{
            	//alert("您还没有登录哦！");
            	window.location.href=domain_passprot+'/login.htm';
            	return false;
            }
            }
        }
    )}
function addConsultation(){
	jQuery.ajax({
		type:"post",
		url:"/pro/selectLoginSession.htm?t="+getCurDate(),
		data:{},
		dataType:"json",
		async: true,
	    success: function(data) {
			if(data && data.code == 0 && data.loginUser){
				var con=jQuery.trim($("#_ComContent1 ").val());
				if(con==""){
					alert("请输入相关内容！");
					return false;
					}
				if(con=="请输入您的咨询内容..."){
					alert("请输入您的咨询内容...");
					return false;
					}
				var aa=/[//<>@]+/;
				if(aa.test(con)){
				alert("包含非法字符,请重新输入！");
				return;
				}
					var typecinss=$("input[name='faq_flag']:checked ").val();
					jQuery.ajax({
						type:"post",
						url:"/pro/saveConsultation.htm?t="+getCurDate(),
						data:{"proId":goodsId,"type":typecinss,"content":con},
						dataType:"json",
						contentType:"application/x-www-form-urlencoded;charset=utf-8",
						success:function(data){
							if(data){
								if(data.code==-1){
									alert("提交失败 ! ");
									return false;
									}else{
										if(data.code==0){
											alert("提交成功 ! ");
											$("#_ComContent1 ").val("");
											return false;
											}
										else{
											if(data.code==1){
												//alert("您还没有登录哦！");
												window.location.href=domain_passprot+'/login.htm';
												return false;
												}else{
													if(data.code==3){
														alert("您操作频繁，请稍后再试！");
														return false;
														}
													}
											}
										}
								}
							}
						}
					);
					}else{
						//alert("您还没有登录哦！");
						window.location.href=domain_passprot+'/login.htm';
						return false;
						}
					}
	}
)
}




var jsonToString = function(obj) {  
    var THIS = this;
    switch (typeof (obj)) {  
        case 'string':  
            return '"' + obj.replace(/(["\\])/g, '\\$1') + '"';  
        case 'array':  
            return '[' + obj.map(THIS.jsonToString).join(',') + ']';  
        case 'object':  
            if (obj instanceof Array) {  
                var strArr = [];  
                var len = obj.length;  
                for (var i = 0; i < len; i++) {  
                    strArr.push(THIS.jsonToString(obj[i]));  
                }  
                return '[' + strArr.join(',') + ']';  
            }  
            else if (obj == null) {  
                return 'null';  
  
            }  
            else {  
                var string = [];  
                for (var property in obj)  
                    string.push(THIS.jsonToString(property) + ':' + THIS.jsonToString(obj[property]));  
                return '{' + string.join(',') + '}';  
            }  
        case 'number':  
            return obj;  
        case false:  
            return obj;  
    }  
};



var stringToJSON = function(obj)
{
return eval('(' + obj + ')');
}; 
//删除数组元素方法   
function delArray(array, index) 
{  
    if (index < 0)  
        return array;  
    else  
        return array.slice(0, index).concat(array.slice(index + 1, array.length));  
} 
//浏览历史
//添加商品至浏览历史 
function viewhis(gid){
	
var cookieValue = getCookie("viewhis");      
var viewhis; 
if (cookieValue == "" || cookieValue == "undefined") {     
    viewhis = new Array();  
    var good = new Object();  
    good.id = gid;
    good.k = 0;  
    viewhis[0] = good;  
}  
else {  
    viewhis = stringToJSON(cookieValue);  
    var index = viewhis.length;   
    var i;  
    for (i = 0; i < index; i++) { 
        var good = viewhis[i];   
        if (good.id == gid) {
            break;  
        }  
    }  
	 	if (i == index) {     
        var good = new Object();  
   		good.id = gid; 
   		//var mytime =timestamp=new Date().getTime();
   		//good.k = mytime; 
        viewhis[index] = good;  
    }  
}
	if(i>10){viewhis = delArray(viewhis, 0);}
setCookie("viewhis", jsonToString(viewhis), 12);
} 

//收藏商品
function addCollect(proId) {
	var fromUrl=window.location.pathname;
	var act_request_url="http://www.jiuxian.com/pro/saveCollect.htm";
	var proxy_url = domain_special+"/httpProxyAccess.htm?t="+new Date().getTime();
	jQuery.ajax({
		type : 'post',
		url:proxy_url,
		data:{target:act_request_url,fromUrl:fromUrl,'proId' : proId},
		dataType : 'json',
		async : true,
		success : function(data) {
			if (data) {
				if (data.code == -1) {
					alert('收藏失败!');
					return false;
				} else if (data.code == 0) {
					alert('收藏成功!');
					return false;
				} else if (data.code == 1) {
					window.location.href = domain_passprot
							+ '/login.htm';
					return false;
				} else if (data.code == 2) {
					alert("您已经收藏过此商品了！");
					return false;
				}
			}
		}
	});
}


