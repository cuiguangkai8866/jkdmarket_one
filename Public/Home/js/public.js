function stripscript(s) {
	var pattern = new RegExp(
			"[`~!@#$%^&*()+=|{}':;',\\\\\\[\\].<>/?~！@#￥%……&*（）——+|{}【】‘；：”“’。，、？]");
	var rs = "";
	for ( var i = 0; i < s.length; i++) {
		rs = rs + s.substr(i, 1).replace(pattern, "")
	}
	return rs
}
function getCookie(objName) {
	var arrStr = document.cookie.split("; ");
	for ( var i = 0; i < arrStr.length; i++) {
		var temp = arrStr[i].split("=");
		if (temp[0] == objName) {
			return unescape(temp[1])
		}
	}
	return ""
}/*
function setCookie(c_name, value, expiredays) {
	var exdate = new Date();
	exdate.setDate(exdate.getDate() + expiredays);
	document.cookie = c_name + "=" + escape(value)
			+ ((expiredays == null) ? "" : ";expires=" + exdate.toGMTString())
			+ ";path=/;domain=jiuxian.com"
}
function delCookie(name) {
	var exp = new Date();
	exp.setTime(exp.getTime() - 1);
	var cval = getCookie(name);
	if (cval != null) {
		document.cookie = name + "=" + cval + ";expires=" + exp.toGMTString()
	}
}*/
var returnArrya = function(n, p) {
	for ( var j = 0; j < K.kind_region[n].length; j++) {
		if (K.kind_region[n][j][0] == p) {
			return K.kind_region[n][j]
		}
	}
};

//20140923 anhui 注释

function getProductActPrice(proIds, callback) {
	if (proIds != "") {
		var act_request_url = domain_activity + "/act/selectPricebypids.htm";
		var proxy_url = "/httpProxyAccess.htm?t=" + new Date().getTime();
		$.post(proxy_url, {
			target : act_request_url,
			ids : proIds
		}, function(result) {
			if (result != null) {
				if (result.status == 1) {
					callback(result.data)
				}
			}
		}, "JSON")
	}
}

//默认jsonp回调函数
function priceBack(data) {

	data = eval('(' + data + ')');

	var arr = data.data;
	for ( var i in arr) {
		var me = arr[i];
		$("[_data='price'][_proid='" + i + "']").text(me.np);
	}
}

// 加载商品的价格的公共方法
function getProductActPrice(proIds, callback) {

	if (typeof callback == 'function') {

		if (proIds != "") {
			var act_request_url = domain_activity
					+ "/act/selectPricebypids.htm";
			var proxy_url = "/httpProxyAccess.htm?t=" + new Date().getTime();

			$.post(proxy_url, {
				target : act_request_url,
				ids : proIds
			}, function(result) {
				if (result != null) {
					if (result.status == 1) {
						callback(result.data);
					} else {
						// alert(result.msg);
					}
				}
			}, 'JSON');
		}
	} else if (typeof callback == 'string') {
		
		
		if(proIds=="")
			return ;
		getProductActPriceWidthJsonp(proIds, callback);
	}
}

// 加载商品价格的公共方法
// anhui 20140922 添加 jsonp 获取价格方式
function getProductActPriceWidthJsonp(proIds, callback) {

	var act_request_url = domain_activity + "/act/selectPricebypids.htm";
	jQuery.ajax({

		url : act_request_url + "?ids=" + proIds + "&callback=" + callback,
		dataType : "jsonp",
		jsonp : callback,
		success : function(data) {

		}
	});
}

function addSkuToCartWithSrc(goods, count, pack, src, callback) {
	var proxy_url = "/httpProxyAccess.htm?t=" + (new Date()).getTime();
	var shop_cart_request_url = domain_cart + "/addToCart.htm";
	jQuery.post(proxy_url, {
		target : shop_cart_request_url,
		"pack" : pack,
		"count" : count,
		"goods" : goods,
		"src" : src
	}, function(data) {
		if (data.status == 1) {
			if (data.cart_key) {
				setCookie("cart", data.cart_key, 7)
			}
			if (data.goods_count) {
				setCookie("cart_goods_count", data.goods_count, 7)
			}
			callback(data)
		} else {
			alert(data.stack)
		}
	}, "JSON")
}
function addSkuToCartWithSrcAndNotConsiderStock(goods, count, pack, src,
		callback) {
	var proxy_url = "/httpProxyAccess.htm?t=" + (new Date()).getTime();
	var shop_cart_request_url = domain_cart + "/addToCart2.htm";
	jQuery.post(proxy_url, {
		target : shop_cart_request_url,
		"pack" : pack,
		"count" : count,
		"goods" : goods,
		"src" : src
	}, function(data) {
		if (data.status == 1) {
			if (data.cart_key) {
				setCookie("cart", data.cart_key, 7)
			}
			if (data.goods_count) {
				setCookie("cart_goods_count", data.goods_count, 7)
			}
			callback(data)
		} else {
			alert(data.stack)
		}
	}, "JSON")
}
function addSkuToCart(goods, count, pack, callback) {
	addSkuToCartWithSrc(goods, count, pack, "", callback)
}
function saves(goodsIds, callback) {
	var proxy_url = "/httpProxyAccess.htm?t=" + new Date().getTime();
	jQuery
			.ajax({
				type : "post",
				url : proxy_url,
				data : {
					target : domain_detail + "/pro/selectLoginSession.htm"
				},
				dataType : "json",
				async : true,
				success : function(data) {
					if (data && data.code == 0 && data.loginUser) {
						$
								.getJSON(
										proxy_url,
										{
											target : domain_detail
													+ "/pro/saveCollects.htm?proIds="
													+ goodsIds
										},
										function(data) {
											if (data) {
												if (callback) {
													callback(data)
												}
												if (data.code == -1) {
													alert("收藏失败!");
													return false
												} else {
													if (data.code == 0) {
														alert("收藏成功!");
														return false
													} else {
														if (data.code == 1) {
															window.location = "https://login.jiuxian.com/login.htm";
															return false
														} else {
															if (data.code == 2) {
																alert("您之前已经收藏过这件商品！");
																return false
															} else {
																if (data.code == 3) {
																	alert("部分已收藏！");
																	return false
																}
															}
														}
													}
												}
											}
										})
					} else {
						window.location = "https://login.jiuxian.com/login.htm"
					}
				}
			})
}
$(function() {
	$("[loadfrom]").each(function() {
		var e = $(this);
		e.load(e.attr("loadfrom"))
	});
	if ($("body .lazyload img").length > 0) {
		$("body .lazyload img").lazyload({
			placeholder : "http://img01.jiuxian.com/img1/loading.gif",
			threshold : 180,
			failurelimit : 10,
			effect : "fadeIn"
		})
	}
	if ($(".lazyload_index img").length > 0) {
		$(".lazyload_index img").lazyload_index({
			effect : "fadeIn"
		})
	}
	
	/*setTimeout(function(){
		jQuery.getJSON("/userprofile.htm?t=" + (new Date()).getTime(),
						function(data) {
							var _login_status_panel = $("li[name='_login_status_panel']");
							if (data.jx_user_name) {
								var old_jx_user_name = stripscript(data.jx_user_name);
								var jx_user_name;
								if (old_jx_user_name != cut_str(old_jx_user_name,
										10)) {
									jx_user_name = cut_str(old_jx_user_name, 10)
											+ "..."
								} else {
									jx_user_name = data.jx_user_name
								}
								_login_status_panel
										.html("<span ><span class='userName' title='"
												+ old_jx_user_name
												+ "'>"
												+ jx_user_name
												+ "</span><span>，欢迎光临！[<a href='http://login.jiuxian.com/logout.htm'>退出</a>]</span></span><i></i>")
							}
							if (data.jx_user_id) {
								_ozuid = data.jx_user_id
							}
							if (data.jxcart_nums) {
								if (data.jxcart_nums > 999) {
									$(".jx_car_num").text("999+")
								} else {
									$(".jx_car_num").text(data.jxcart_nums)
								}
							}
						});
	},3000);*/
	
	var page_proids = new Array();
	$("[_data='price']").each(function() {
		var e = $(this);
		var proId = e.attr("_proid");
		if (/^\d+$/.test(proId)) {
			page_proids.push(proId)
		}
	});
	
	
	/*20140925 安辉注释 修改成调用 jsonp形式
	getProductActPrice(page_proids.join(), function(data) {
	
		debugger;
		for ( var item in data) {
			

			$("[_data='price'][_proid='" + item + "']").text(data[item].np)
		}
	});
	*/
	
	getProductActPrice(page_proids.join(), "priceBack");
	
	$(".xcy_action_prtlt").bind("click", function() {
		_dmpTJclick("加入购物车")
	});
	$(".xcy_action_prtlt_list").bind("click", function() {
		var goodsId = $(this).siblings("span").find("input").attr("gid");
		_dmpTJclick("加入购物车");
		//ga("send", "event", "addcart_list", "button", "goods")
	});
	$(".xcy_action_prtlt_search").bind("click", function() {
		var goodsId = $(this).siblings("span").find("input").attr("gid");
		_dmpTJclick("加入购物车");
		//ga("send", "event", "addcart_search", "button", "goods")
	})
});
/*window._CWiQ = window._CWiQ || [];
window.BX_CLIENT_ID = 34869;
(function() {
	var c = document.createElement("script"), p = "https:" == document.location.protocol;
	c.type = "text/javascript";
	c.async = true;
	c.src = (p ? "https://" : "http://") + "whisky.ana.biddingx.com/boot/0";
	var h = document.getElementsByTagName("script")[0];
	h.parentNode.insertBefore(c, h)
})();
var ga = ga || function() {
	(ga.q = ga.q || []).push(arguments)
};*/
/*(function(i, s, o, g, r, a, m) {
	i["GoogleAnalyticsObject"] = r;
	i[r] = i[r] || function() {
		(i[r].q = i[r].q || []).push(arguments)
	}, i[r].l = 1 * new Date();
	a = s.createElement(o), m = s.getElementsByTagName(o)[0];
	a.async = 1;
	a.src = g;
	m.parentNode.insertBefore(a, m)
})(window, document, "script", "//misc.jiuxian.com/js/ga/analytics.js", "ga");*/
//ga("create", "UA-20089109-2", "jiuxian.com");
function _dmpTJclick(actionName) {
	_CWiQ.push([ "_trackPdmp", actionName, 1 ])
};
var ACTrackerz = {
	mid : 500326,
	ers : [ {
		type : "pageview"
	} ],
	track : function(er) {
		this.ers.push(er);
	}
};
/*(function() {
	var js = document.createElement("script"), scri = document
			.getElementsByTagName("script")[0];
	js.type = "text/javascript";
	js.async = true;
	scri.parentNode.insertBefore(js, scri);
	js.src = location.protocol == "https:" ? "https://secure.acs86.com/nact.js"
			: "http://static.acs86.com/nact.js";
})();*/
/*var _mixDsp_p = window._mixDsp_p;
if (_mixDsp_p == undefined) {
	_mixDsp_p = [];
}
(function() {
	function evaCheckLogin() {
		var aCookie = document.cookie.split("; ");
					var aCrumb = "";
					for ( var i = 0; i < aCookie.length; i++) {
						aCrumb = aCookie[i].split("=");
						if ("PTOKEN" == aCrumb[0]) {
							cookie_login = unescape(aCrumb[1]) + "_0";
						}
					}
				if (_mixDsp_p.length == 0) {
					_mixDsp_p.push(cookie_login);
				}
				sendItemInfo();
	}*/
/*function sendItemInfo() {
		var s = document.createElement('script');
		s.type = 'text/javascript';
		s.async = true;
		s.src = ('http://js.mixdata.com.cn/mixdsp.js');
		var s0 = document.getElementsByTagName('script')[0];
		s0.parentNode.insertBefore(s, s0);
	}
	if (_mixDsp_p.length > 1) {
		sendItemInfo();
	} else {
		var cookie_login = "";	
		setTimeout(function(){
			evaCheckLogin()
		},2000);
	}
})();
*/