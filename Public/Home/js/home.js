/*
 myjd-2014 Compressed by uglify 
 Author:jd.com 
 Date: 2014-09-02 
 */
define("../common/Base",[],function(){var a=function(a){var b=function(){this.init.apply(this,arguments)};if(a){var c=function(){};c.prototype=a.prototype,b.prototype=new c}return b.prototype.init=function(){},b.fn=b.prototype,b.proxy=function(a){var b=this;return function(){return a.apply(b,arguments)}},b.fn.parent=b,b._super=b.__proto__,b.extend=function(a){var c=a.extended;for(var d in a)b[d]=a[d];c&&c(b)},b.include=function(a){var c=a.included;for(var d in a)b.fn[d]=a[d];c&&c(b)},b.fn.proxy=b.proxy,b};return a}),define("../common/Util",["./Base"],function(a){var b=new a;return b.extend({throttle:function(a,b){var c=null;return function(){var d=this,e=arguments;clearTimeout(c),c=setTimeout(function(){a.apply(d,e)},b)}},hashTable:{},isIE6:$.browser.msie&&6==$.browser.version,isEmpty:function(a){var b;for(b in a)return!1;return!0},setTimer:function(a,b){var c=setInterval(function(){a()?clearInterval(c):b()},500)}}),b}),define("../common/Slider",["./Base","./Util"],function(a,b){var c=new a;return c.include({typeList:{t1:{step:4},t2:{step:5}},init:function(a,c){var d={step:3,duration:500,isResize:!0,isLazyLoad:!0,callback:function(){}},d=$.extend(d,this.getType()),e=$.extend({},d,c),f=$(a),g=f.find("li").size(),h=e.width||f.find("li:first").get(0).offsetWidth,i=e.height||f.find("li:first").get(0).offsetHeight,j=f.find(".prev"),k=f.find(".next"),l=$("#content")[0].offsetWidth-70-300,m=e.fix||0;e.isResize&&(h=l/e.step),e.isResize&&(b.hashTable[a]=this),f.find("li").css({width:h-10-m}),l=e.isResize?l:e.step*h,f.find("ul").css({position:"absolute",top:0,left:0,width:b.isIE6?(h+2)*g:h*g}),f.css({width:l}),$(".ctrl",f).css({height:i}),$(".slider-show, .slider-show-ctn",f).css({height:i}),this.prevEle=j,this.nextEle=k,this.step=e.step,this.liWdt=h,this.outCon=f,this.liNum=g,this.duration=e.duration,this.cutIndex=this.step,this.isAnimate=!1,this.settings=e,this.callback=e.callback,this.isLazyLoad=e.isLazyLoad,this.prevEle.unbind("click").click(this.proxy(this.prev)).hide(),this.nextEle.unbind("click").click(this.proxy(this.next)),this.liNum>this.step?this.nextEle.show():this.nextEle.hide(),this.resize(),this.loadImg()},loadImg:function(){var a=this;this.isLazyLoad&&function(){a.outCon.find("ul li img:lt("+a.cutIndex+")").each(function(){$(this).attr("src",$(this).attr("data-src"))})}()},gotoLoc:function(a){var b=parseFloat(this.outCon.find("ul").css("left")),c=this,d=0;this.isAnimate=!0,this.cutIndex<=2*this.step&&1==a&&(d=2*this.step-this.cutIndex),this.cutIndex+this.step>=this.liNum&&-1==a&&(d=this.step-(this.liNum-this.cutIndex)),this.outCon.find("ul").animate({left:(b+(this.step-d)*this.liWdt*a).toFixed(1)},this.duration,function(){c.isAnimate=!1,1==a?c.cutIndex-=c.step-d:c.cutIndex+=c.step-d;var b=parseFloat(c.outCon.find("ul").css("left"));c.isStart(b)?c.prevEle.show():c.prevEle.hide(),c.isEnd(b,c.liWdt,c.liNum)?c.nextEle.show():c.nextEle.hide(),c.loadImg(),"function"==typeof c.callback&&c.callback()})},prev:function(){!this.isAnimate&&this.gotoLoc(1)},next:function(){!this.isAnimate&&this.gotoLoc(-1)},isStart:function(a){return 0!==a},isEnd:function(a,b,c){return Math.abs(a)/b+this.step!==c},getType:function(){var a=document.documentElement.clientWidth;return a>1e3&&!b.isIE6?this.typeList.t2:this.typeList.t1},resize:function(){window.onresize=b.throttle(function(){for(var a in b.hashTable){var c=b.hashTable[a],d=$.extend({},c.settings,c.getType());c.init(c.outCon,d)}},1)}}),c}),define("../common/Template",[],function(){var a=function(a,b){for(var c,d=/<%(.+?)%>/g,e=/(^( )?(if|for|else|switch|case|break|{|}|;))(.*)?/g,f="var r=[];\n",g=0,h=function(a,b){return f+=b?a.match(e)?a+"\n":"r.push("+a+");\n":""!=a?'r.push("'+a.replace(/"/g,'\\"')+'");\n':"",h};match=d.exec(a);)h(a.slice(g,match.index))(match[1],!0),g=match.index+match[0].length;h(a.substr(g,a.length-g)),f=(f+'return r.join("");').replace(/[\r\t\n]/g,"");try{c=new Function(f).apply(b)}catch(i){console&&console.error("'"+i.message+"'"," in \n\nCode:\n",f,"\n")}return c};return a}),define("../common/Tab",["./Base","./Util"],function(a){var b=new a;return b.include({init:function(a,b){var c={eventType:"mouseover",currClass:"curr",tabItem:".tab li>a",tabContent:".tab-con",source:"href",callback:function(){},index:0},d=$.extend({},c,b);this.container=a,this.tabItem=d.tabItem,this.tabContent=d.tabContent,this.eventType=d.eventType,this.currClass=d.currClass,this.index=d.index,this.source=d.source,this.callback=d.callback,this.bindEvent()},bindEvent:function(){var a=this;$(this.tabItem,$(this.container)).each(function(){$(this).bind(a.eventType,function(){var b=$(a.tabItem).index($(this));$(a.container).find(a.tabItem).removeClass(a.currClass),$(this).addClass(a.currClass),$(a.container).trigger("change.tab",b)})}),$(this.container).bind("change.tab",function(b,c){a.callback(c)})}}),b}),define("product",["../common/Base","../common/Template"],function(a,b){var c=new a;return c.extend({tpl:'<%for(var i = 0; i < this.length; i++) {%><li><div class="p-img"><a href="http://item.jd.com/<%this[i].productId%>.html" target="_blank" clstag="click|keycount|myhome|skuguanzhutu0<%i+1%>" title="<%this[i].productName%>"><img class="err-product" width="100" height="100" src="http://misc.360buyimg.com/lib/img/e/blank.gif" data-src="<%pageConfig.FN_GetImageDomain(this[i].productId)%>/n4/<%this[i].productLogo %>" alt="<%this[i].productName%>"></a></div><div class="p-price">\uffe5<%this[i].currentPrice > 0 ? this[i].currentPrice : "\u6682\u65e0\u62a5\u4ef7"%></div><%if(this[i].followPrice > this[i].currentPrice && this[i].currentPrice > 0) {%><span class="p-cut">\u964d\u4ef7<span class="font-price">\uffe5<%Math.ceil(this[i].followPrice * 1000-this[i].currentPrice * 1000) / 1000%></span></span><%}%></li><%}%>'}),c.include({init:function(a,d){d.empty().append(b(c.tpl,a))}}),c}),define("shop",["../common/Base","../common/Template"],function(a,b){var c=new a;return c.extend({tpl:'<%for(var i = 0; i < this.length; i++) {%><li venderId=<%this[i].venderId%>><div class="p-img"><a href="<%this[i].venderUrl%>" target="_blank" title="<%this[i].venderName%>" clstag="click|keycount|myhome|shopguanzhutu0<%i+1%>"><img data-img="2" class="err-product" width="100%" src="http://misc.360buyimg.com/lib/img/e/blank.gif" data-src="<%this[i].venderLogo%>" alt="<%this[i].venderName%>"></a></div><div class="p-name"><a href="<%this[i].venderUrl%>" target="_blank"><%this[i].venderName%></a></div><div class="p-follow mb5 mt5"><%this[i].followCount || this[i].count%>\u4eba\u5173\u6ce8</div><span class="p-cut" clstag="click|keycount|myhome|PromotionActivity">\u4fc3\u9500\u6d3b\u52a8<span class="num">0</span></span></li><%}%>'}),c.include({init:function(a,d){d.empty().append(b(c.tpl,a));var e=$.map($("li[venderId]"),function(a){return $(a).attr("venderId")}).join(",");$.ajax({url:"http://t.jd.com/vender/querySaleCountByShopIds.action?shopIdes="+e,dataType:"jsonp",success:function(a){var b=a.result;if(b)for(var c in b.shopTopicMap)if(b.shopTopicMap.hasOwnProperty(c)){var d=b.shopTopicMap[c];$("li[venderId="+c+"] .p-cut span.num").text(d)}}})}}),c}),define("orderList",["../common/Base","../common/Template"],function(a,b){var c=new a;return c.extend({tpl:'<%for(var i = 0, size = Math.min(this.length, 3); i < size; i++) {%><tbody class="fore<%i + 1%>"><tr><td><div class="img-list"><%this[i].WareImgUrl.split("</a>").length > 3 ? this[i].WareImgUrl.split("</a>").slice(0, 3).join("") + "</a><span class=more-icon></span>" : this[i].WareImgUrl%></div></td><td><div class="u-name"><%this[i].CustomerName%></div></td><td><%this[i].ShouldPay%><br><%this[i].IdPaymentTypeName%></td><td><span class="ftx-03"><%this[i].DateSubmit%></span></td><%this[i].StateMsg.replace(/(onmouseover=[^>]+)|(onmouseout=[^>]+)/g, "orderid=" + this[i].OrderId)%><td class="order-doi"><%this[i].StateBtn%></td></tr></tbody><%}%>',tipTip:'<div class="prompt-01"><div class="pc"><div class="close" onclick="$(this).parent().parent().hide()"></div><dl><dt>\u5904\u7406\u65f6\u95f4</dt><dd>\u5904\u7406\u4fe1\u606f</dd></dl><ul><%for(var i = 0; i < this.orderTrackGroupInfoList.length; i++) {%><%if(!this.orderTrackGroupInfoList[i].shipId) { %><%for(var k = 0, obj = this.orderTrackGroupInfoList[i].orderTrackShowList; k < obj.length; k++) {%><li><div class="fore1"><%obj[k].CreationTime%></div><div class="fore2"><%obj[k].Content%></div></li><%}%><%} else {%><li class="pr-more"><div class="fore1">&nbsp;</div><div>\u8fd0\u5355\u53f7\uff1a<%this.orderTrackGroupInfoList[i].shipId%><br>\u4fe1\u606f\u6765\u6e90\uff1a<strong><%this.orderTrackGroupInfoList[i].thirdName%></strong><em class="icon-show"></em></div></li><li class="third-li"><ul><%for(var k = 0, obj = this.orderTrackGroupInfoList[i].orderTrackShowList || []; k < obj.length; k++) {%><li><div class="fore1"><%obj[k].CreationTime%></div><div class="fore2"><%obj[k].Content%></div></li><%}%></ul></li><%}%><%}%></ul></div><div class="p-arrow p-arrow-left"></div></div>'}),c.include({init:function(a,d){d.empty().append(b(c.tpl,a)),this.bindEvent(d)},bindEvent:function(a){var b,c=this;$(".tooltip").hover(function(){b=$(this).attr("orderId"),$(".prompt-01",$(".tooltip[orderid="+b+"]",a)).size()?$(".prompt-01",this).show():c.loadData(b,a)},function(){$(".prompt-01").hide()})},loadData:function(a,d){$.ajax({url:"http://order.jd.com/lazy/getOrderTrackInfoForList.action",dataType:"jsonp",data:{orderId:a},success:function(e){$(".tooltip[orderid="+a+"]",d).append(b(c.tipTip,e.info)).find(".prompt-01").show()}})}}),c}),define("menu",["../common/Base","../common/Template"],function(a,b){var c=new a;c.extend({commonTpl:'<div id="menu"><h3><%this.title%></h3><%for(var i = 0, l = this.list.length; i < l; i++) { %><dl class="fore<%i+1%><%i == l-1 ? " last " : ""%>"><%if(this.list[i].dtTitle) { %><%if(this.list[i].ddList) { %><dt class="hc"><b></b><%} else {%><dt><%}%><a <%if(this.list[i].clstag) { %>clstag="homepage|keycount|home2013|<%this.list[i].clstag%>"<%}%> id="<%this.list[i].dtId%>" href="<%this.list[i].dtHref%>"><%this.list[i].dtTitle%></a></dt><%}%><%if(this.list[i].ddList) { %><%for(var k = 0, s = this.list[i].ddList.length, dd = this.list[i].ddList; k < s; k++) { %><dd class="fore<%k+1%><%k == s-1 ? " last " : ""%>"><div class="item" id="<%dd[k].id%>"><a <%if(dd[k].clstag) { %>clstag="homepage|keycount|home2013|<%dd[k].clstag%>"<%}%> href="<%dd[k].href%>"><%dd[k].ctn%></a></div></dd><%}%><%}%></dl><%}%></div><div id="da-home" class="da-box"></div>',setAndInfoTpl:'<%for(var i = 0, l = this.list.length; i < l; i++) { %><a tid="<%this.list[i].dtId%>" href="<%this.list[i].dtHref%>"><span><%this.list[i].dtTitle%></span></a><%}%>',commonData:{title:"\u6211\u7684\u4ea4\u6613",list:[{dtTitle:"\u6211\u7684\u8ba2\u5355",dtId:"_MYJD_ordercenter",dtHref:"http://order.jd.com/center/list.action",clstag:"hdd"},{dtTitle:"\u6211\u7684\u672c\u5730\u751f\u6d3b",dtId:"_MYJD_locallife",dtHref:"http://life.jd.com/localOrder/iniOrder.do",clstag:"hbdsh"},{dtTitle:"\u6211\u7684\u5b9a\u671f\u9001",dtId:"_MYJD_ding",dtHref:"http://ding.jd.com/plan/showPlans.action",clstag:"hdqs"},{dtTitle:"\u6211\u7684\u56e2\u8d2d",dtId:"_MYJD_tuan",dtHref:"http://tuan.jd.com/order/index.php",clstag:"htg"},{dtTitle:"\u4ef7\u683c\u4fdd\u62a4",dtId:"_MYJD_protection",dtHref:"http://jiabao.jd.com/protecting",clstag:"hjg"},{dtTitle:"\u6211\u7684\u5173\u6ce8",dtId:"_MYJD_gz",dtHref:"#none",ddList:[{href:"http://t.jd.com/home/follow",ctn:"\u5173\u6ce8\u7684\u5546\u54c1",id:"_MYJD_product",clstag:"hgz"},{href:"http://t.jd.com/vender/followVenderList.action",ctn:"\u5173\u6ce8\u7684\u5e97\u94fa",id:"_MYJD_vender",clstag:"hdp"},{href:"http://t.jd.com/activity/followActivityList.action",ctn:"\u5173\u6ce8\u7684\u6d3b\u52a8",id:"_MYJD_activity",clstag:"hhd"},{href:"http://my.jd.com/history/list.html",ctn:"\u6d4f\u89c8\u5386\u53f2",id:"_MYJD_history",clstag:"hll"}]},{dtTitle:"\u6211\u7684\u8d44\u4ea7",dtId:"_MYJD_zc",dtHref:"#none",ddList:[{href:"http://jinku.pay.jd.com/xjk/income.action",ctn:"\u6211\u7684\u5c0f\u91d1\u5e93",id:"_MYJD_cashbox",clstag:"hjk"},{href:"http://mobile.jd.com/yyswt/myjd.do",ctn:"\u4eac\u4e1c\u901a\u4fe1",id:"_MYJD_tx",clstag:"htx"},{href:"http://mymoney.jd.com/finance/recently.action",ctn:"\u4f59\u989d",id:"_MYJD_balance",clstag:"hye"},{href:"http://quan.jd.com/user_quan.action",ctn:"\u4f18\u60e0\u5238",id:"_MYJD_ticket",clstag:"hyh"},{href:"http://giftcard.jd.com/giftcard/index.action",ctn:"\u4eac\u4e1c\u5361/E\u5361",id:"_MYJD_card",clstag:"he"},{href:"http://bean.jd.com/myJingBean/list",ctn:"\u4eac\u8c46",id:"_MYJD_bean",clstag:"hjd"},{href:"http://bankws.jd.com/score/Integral/ScoreExhibit.aspx",ctn:"\u79ef\u5206",id:"_MYJD_score",clstag:"hjf"}]},{dtTitle:"\u5ba2\u6237\u670d\u52a1",dtId:"_MYJD_fw",dtHref:"#none",ddList:[{href:"http://myjd.jd.com/repair/orderlist.action",ctn:"\u8fd4\u4fee\u9000\u6362\u8d27",id:"_MYJD_repair",clstag:"hfx"},{href:"http://rps.fm.jd.com/rest/refund/refundList",ctn:"\u53d6\u6d88\u8ba2\u5355\u8bb0\u5f55",id:"_MYJD_refundment",clstag:"hqx"},{href:"http://myjd.jd.com/opinion/orderList.action",ctn:"\u6211\u7684\u6295\u8bc9",id:"_MYJD_complaint",clstag:"htx"}]}]},setAndInfoData:{set:{title:"\u8bbe\u7f6e",list:[{dtHref:"http://i.jd.com/user/info",dtTitle:"\u4e2a\u4eba\u4fe1\u606f",dtId:"_MYJD_info"},{dtHref:"http://safe.jd.com/user/paymentpassword/safetyCenter.action",dtTitle:"\u8d26\u6237\u5b89\u5168",dtId:"_MYJD_safe"},{dtHref:"http://usergrade.jd.com/user/grade",dtTitle:"\u6211\u7684\u7ea7\u522b",dtId:"_MYJD_grade"},{dtHref:"http://i.jd.com/user/userinfo/zpzz.html",dtTitle:"\u589e\u7968\u8d44\u8d28",dtId:"_MYJD_zpzz"},{dtHref:"http://easybuy.jd.com/address/getEasyBuyList.action",dtTitle:"\u6536\u8d27\u5730\u5740",dtId:"_MYJD_add"},{dtHref:"https://quickpay.jd.com/bankCard.action",dtTitle:"\u5feb\u6377\u652f\u4ed8",dtId:"_MYJD_pay"},{dtHref:"http://share.jd.com/share/index.html",dtTitle:"\u5206\u4eab\u8bbe\u7f6e",dtId:"_MYJD_share"},{dtHref:"http://edm.jd.com/front/subscribe/index.aspx",dtTitle:"\u90ae\u4ef6\u8ba2\u9605",dtId:"_MYJD_rss"},{dtHref:"http://usergrade.jd.com/user/consume",dtTitle:"\u6d88\u8d39\u8bb0\u5f55",dtId:"_MYJD_record"},{dtHref:"http://jbox.jcloud.com",dtTitle:"\u4eac\u4e1c\u4e91\u76d8",dtId:"_MYJD_pan"},{dtHref:"http://fw.jd.com/home/auth_list.action",dtTitle:"\u5e94\u7528\u6388\u6743",dtId:"_MYJD_app"}]},info:{title:"\u793e\u533a",list:[{dtHref:"http://club.jd.com/mycomments.aspx",dtTitle:"\u8bc4\u4ef7\u6652\u5355",dtId:"_MYJD_comments"},{dtHref:"http://club.jd.com/myjd/userConsultationList_1.html",dtTitle:"\u8d2d\u4e70\u54a8\u8be2",dtId:"_MYJD_consultation"},{dtHref:"http://joycenter.jd.com",dtTitle:"\u6d88\u606f\u7cbe\u7075",dtId:"_MYJD_joy"}]}}}),c.include({init:function(){},render:function(a,c,d,e){d.append(b(a,c)),"function"==typeof e&&e()},setSelectItem:function(){var a=$("body").attr("myjd");$("#"+a).addClass("curr")},loadAds:function(){"undefined"!=typeof asyncScript&&asyncScript("http://fa.360buy.com/loadFa.js?aid=2_102_413-14_720_4497")},loadExtraMenu:function(){$("body").attr("myjd");$.ajax({url:"http://joycenter.jd.com/msgCenter/getUnreadNum.action",dataType:"jsonp",success:function(a){if(a.msgUnreadCount){var b=a.msgUnreadCount>99?"n+":a.msgUnreadCount;$("[tid=_MYJD_joy] span").append("<b>("+b+")</b>").parent().parent().prev().find("span").append("<i>("+b+")</i>")}}}),$.ajax({url:"http://api.credit.wangyin.com/veyron/query/queryCreditJsonp",dataType:"jsonp",data:{platform:1,userId:decodeURIComponent(readCookie("pin")),productId:-1},success:function(a){var b=[{text:"\u4eac\u4e1c\u767d\u6761",url:["http://baitiao.jd.com/creditUser/list","http://baitiao.jd.com/creditUser/record"],productId:1},{text:"\u4eac\u4e1c\u91d1\u91c7",url:["http://baitiao.jd.com/jinCai/list","http://baitiao.jd.com/jinCai/record"],productId:3}],c=a[0].productId||1,d=$("body").attr("myjd"),e=a[0].activatedStatus,f=b[0].productId==c?b[0].text:b[1].text,g=b[0].productId==c?b[0].url[e]:b[1].url[e];$("#_MYJD_tx").parent().before('<dd><div class="item'+("_MYJD_credit"==d?" curr":"")+'" id="_MYJD_credit"><a clstag="homepage|keycount|home2013|hbt" tag="213" href='+g+">"+f+'</a>&nbsp;<img width="24" height="11" src="http://misc.360buyimg.com/jd2008/skin/df/i/myjd-new-ico.png"></div></dd>');var h=$("#_MYJD_tx").parent().parent().find("dd").removeClass();h.each(function(a){$(this).addClass("fore"+(a+1))}),h.end().find("dd:last").addClass("last")}}),$.getJSON("http://giftcard.jd.com/service/getGiftCardCount.action?callback=?",function(a){a.GiftCardCount&&$("#_MYJD_card").append("<b>("+a.GiftCardCount+")</b>")}),$.getJSON("http://quan.jd.com/getcouponcount.action?callback=?",function(a){a.CouponCount&&$("#_MYJD_ticket").append("<b>("+a.CouponCount+")</b>")}),$("#_MYJD_cashbox a, #_MYJD_tx a").append('&nbsp;<img width="24" height="11" src="http://misc.360buyimg.com/jd2008/skin/df/i/myjd-new-ico.png">')},bindEvent:function(){var a;$("#myjd-shortcut dl").hover(function(){var b=this;clearTimeout(a),a=setTimeout(function(){$(b).addClass("hover")},300)},function(){var b=this;clearTimeout(a),$(b).removeClass("hover")}),$("#menu dl dt").click(function(){$(this).parent().toggleClass("close")})},getContent:function(){var a=$("body").attr("menuId");return a?{tpl:c.setAndInfoTpl,data:c.setAndInfoData[a]}:{tpl:c.commonTpl,data:c.commonData}}});var d=new c;d.render(c.commonTpl,d.getContent().data,$("#left"),d.loadAds),d.render(c.setAndInfoTpl,c.setAndInfoData.set,$(".myjd-set dd")),d.render(c.setAndInfoTpl,c.setAndInfoData.info,$(".myjd-info dd")),d.setSelectItem(),d.bindEvent(),d.loadExtraMenu()}),require(["../common/Slider","./product","../common/Util"],function(Slider,Product,Util){function log(a,b){var c="";for(i=2;i<arguments.length;i++)c=c+arguments[i]+"|||";var d=decodeURIComponent(escape(getCookie("pin"))),e="http://csc."+pageConfig.FN_getDomain()+"/log.ashx?type1=$type1$&type2=$type2$&data=$data$&pin=$pin$&referrer=$referrer$&jinfo=$jinfo$&callback=?",f=e.replace(/\$type1\$/,escape(a));f=f.replace(/\$type2\$/,escape(b)),f=f.replace(/\$data\$/,escape(c)),f=f.replace(/\$pin\$/,escape(d)),f=f.replace(/\$referrer\$/,escape(document.referrer)),f=f.replace(/\$jinfo\$/,escape("")),$.getJSON(f,function(){});var g=("https:"==document.location.protocol?"https://mercuryssl":"http://mercury")+".jd.com/log.gif?t=other.000000&m=UA-J2011-1&v="+encodeURIComponent("t1="+a+"$t2="+b+"$p0="+c)+"&ref="+encodeURIComponent(document.referrer)+"&rm="+(new Date).getTime(),h=new Image(1,1);h.src=g}function clsPVAndShowLog(a,b,c,d){var e=a+"."+c+"."+skutype(b)+"."+d;log("d","o",e)}function clsClickLog(a,b,c,d,e,f){var g=a+"."+d+"."+skutype(b);appendCookie(f,c,g),log("d","o",g+".c")}function appendCookie(reCookieName,sku,key){var reWidsCookies=eval("("+getCookie(reCookieName)+")");(null==reWidsCookies||""==reWidsCookies)&&(reWidsCookies=new Object),null==reWidsCookies[key]&&(reWidsCookies[key]="");var pos=reWidsCookies[key].indexOf(sku);0>pos&&(reWidsCookies[key]=reWidsCookies[key]+","+sku),setCookie(reCookieName,$.toJSON(reWidsCookies),15)}function skutype(a){if(a){var b=a.toString().length;return 10==b?1:0}return 0}function setCookie(a,b,c){var d=c,e=new Date;e.setTime(e.getTime()+24*d*60*60*1e3),document.cookie=a+"="+escape(b)+";expires="+e.toGMTString()+";path=/;domain=."+pageConfig.FN_getDomain()}function getCookie(a){var b=document.cookie.match(new RegExp("(^| )"+a+"=([^;]*)(;|$)"));return null!=b?unescape(b[2]):null}function clsLog(a,b,c,d,e){appendCookie(e,c,a),c=c.split("#")[0],log(3,a,c)}var Footprint=function(a,b,c,d,e,f){this.sku=a,this.rid=b,this.locId=c,this.lim=e||20,this.onLoad=f||function(){},this.pin=readCookie("pin"),this.pid=null===c?1:c.split("-")[0],this.el=d,this.init()};Footprint.prototype={init:function(){var a=readCookie("__jda"),b="book"==document.body.id;this.uuid=a?"-"==a.split(".")[1]?-1:a.split(".")[1]:-1,202001===this.rid&&(this.ck=b?"bview":"aview"),202e3===this.rid&&(this.ck="pin,ipLocation,btw,bview"),202002===this.rid&&(this.ck="pin,ipLocation,atw,aview"),this.get(this.rid)},get:function(a){var b=this,c={sku:this.sku,p:a||this.rid,lid:this.pid,lim:this.lim,uuid:this.uuid,ec:"utf-8",ck:this.ck},d=[];if("undefined"!=typeof pageConfig&&pageConfig.product)for(var e=0;e<pageConfig.product.cat.length;e++)c["c"+(e+1)]=pageConfig.product.cat[e];Util.setTimer(function(){return d.length>0},function(){$.ajax({url:"http://diviner.jd.com/diviner",data:c,cache:!0,dataType:"jsonp",scriptCharset:"utf-8",success:function(c){202001===a?(d.push(0),b.set(c)):(d=c.data||[],d.length>0&&b.set(c))}})})},set:function(a){var b=this,c=(b.el,pageConfig.wideVersion&&pageConfig.compatible?5:4,'<div class="slider-show-ctn">    <ul>        {for item in data}        <li ${pageConfig.getFootPrintClk(item, item_index).recent} data-push="${pageConfig.footPrintSkus.push(item.sku)}" data-clk="${item.clk}">            <div class="p-img" title="${item.t}">                <a target="_blank" href="http://item.jd.com/${item.sku}.html">                   <img alt="" width="100" height="100" class="err-product" src="http://misc.360buyimg.com/lib/img/e/blank.gif" data-src="${pageConfig.FN_GetImageDomain(item.sku)}n4/${item.img}" alt="${item.t}">                </a>            </div>            <div class="p-price J-p-${item.sku}">\uffe5</div>        </li>        {/for}    </ul></div>'),d='{for item in data}<li ${pageConfig.getFootPrintClk(item, item_index).guess} id="guess-${item.sku}" data-push="${pageConfig.footPrintSkus.push(item.sku)}" data-clk="${item.clk}"><div class="p-img"><a target="_blank" title="${item.t}" href="http://item.jd.com/${item.sku}.html"><img class="err-product" width="100" height="100" src="http://misc.360buyimg.com/lib/img/e/blank.gif" data-src="${pageConfig.FN_GetImageDomain(item.sku)}n4/${item.img}" alt="${item.t}"></a></div><div class="p-price J-p-${item.sku}">\uffe5</div></li>{/for}';a.success&&a.data&&a.data.length>0?(pageConfig.footPrintSkus=[],202001===this.rid&&(this.el.html(c.process(a)),this.onLoad&&this.onLoad(a)),202002===this.rid&&(this.el.html(d.process(a)),this.onLoad&&this.onLoad(a)),this.el.find("img").Jlazyload({type:"image"}),this.setTrackCode(a.impr),this.getPriceNum(pageConfig.footPrintSkus,this.wrap)):(this.el.next().show(),this.el.parent().parent().parent().prev(".nocont-box").show())},getPriceNum:function(a,b,c,d){a="string"==typeof a?[a]:a,b=b||$("body"),c=c||"J-p-",$.ajax({url:"http://p.3.cn/prices/mgets?skuIds=J_"+a.join(",J_")+"&type=1",dataType:"jsonp",success:function(a){if(!a&&!a.length)return!1;for(var e=0;e<a.length;e++){var f=a[e].id.replace("J_",""),g=parseFloat(a[e].p,10);g>0?b.find("."+c+f).html("\uffe5"+a[e].p):b.find("."+c+f).html("\u6682\u65e0\u62a5\u4ef7"),"function"==typeof d&&d(f,g,a)}}})},setTrackCode:function(a){var b=this.el.find("li"),c=this,d="&m=UA-J2011-1&ref="+encodeURIComponent(document.referrer);b.each(function(){var a=$(this).attr("data-clk");$(this).bind("click",function(b){var e=$(b.target);(e.is("a")||e.is("img")||e.is("span"))&&c.newImage(a+d,!0)})}),this.newImage(a+d,!0)},newImage:function(a,b,c){var d=new Image;a=b?a+"&random="+Math.random()+new Date:a,d.setAttribute("src",a),d.onload=function(){"undefined"!=typeof c&&c(a)}}},pageConfig.getFootPrintClk=function(a,b){var c={item:a,ind:b};return{recent:" onclick=\"clsClickLog('', '', '${item.sku}', 3, ${ind}, 'rodGlobalHis');\"".process(c)}};var rec_202001=new Footprint("",202001,readCookie("ipLoc-djd"),$(".fol-history .slider-show"),20,function(){new Slider(".fol-history",{isResize:!1,step:2});clsPVAndShowLog("","",3,"s")});$.ajax({url:"http://t.jd.com/product/myFollowProductList.action",dataType:"jsonp",scriptCharset:"utf-8",success:function(a){if(a.length>0){{new Product(a,$("#fol-p-con ul")),new Slider("#fol-p-con")}$("#fol-produce>div.mc div.iloading").hide()}else{new Footprint("",202002,readCookie("ipLoc-djd"),$("#fol-p-con .slider-show ul"),20,function(){new Slider("#fol-p-con");$("#fol-p-con").prev(".nocont-box").show(),$("#fol-produce>div.mc div.iloading").hide(),clsPVAndShowLog("","",2,"s")})}}}),window.log=log,window.clsPVAndShowLog=clsPVAndShowLog,window.clsClickLog=clsClickLog,window.appendCookie=appendCookie,window.skutype=skutype,window.setCookie=setCookie,window.getCookie=getCookie,window.clsLog=clsLog}),define("history",function(){}),define("home-guide",["../common/Base"],function(a){var b=new a;b.include({end:function(){$.cookie("home-guide-close",!0,{expires:3e3}),$("#guide-mod").remove(),$(".guide-outer").removeClass("guide-outer"),$("#guide-mask").remove(),window.guider=void 0},showStep0:function(){$("body").prepend('<div id="guide-mask"><iframe id="guide-iframe" src="javascript:false;document.write(\'\');" crolling="no" frameborder="0" marginheight="0" marginwidth="0"></iframe></div>'),$('<div id="guide-mod" class="guide-step0"><a href="#none" onclick="guider.end()" class="btn-esc"></a><a href="#none" class="btn-next" onclick="guider.showStep1()"></a></div>').appendTo("body")},showStep1:function(){$("#guide-mod").remove(),$(".guide-outer").removeClass("guide-outer"),$("#left").addClass("guide-outer"),$("#myjd-shortcut .myjd-set").addClass("guide-outer"),$("#myjd-shortcut .myjd-info").addClass("guide-outer"),$('<div id="guide-mod" class="guide-step1"><a href="#none" onclick="guider.end()" class="btn-esc"></a><a href="#none" class="btn-next" onclick="guider.showStep2()"></a></div>').appendTo("body")},showStep2:function(){var a=$("#myjd-shortcut .myjd-info");$("#guide-mod").remove(),$(".guide-outer").removeClass("guide-outer"),a.addClass("guide-outer"),$('<div id="guide-mod" class="guide-step2"><a href="#none" onclick="guider.end()" class="btn-esc"></a><a href="#none" class="btn-next" onclick="guider.showStep3()"></a></div>').appendTo("body").css({left:a.offset().left+20,top:a.offset().top+20,"margin-left":0})},showStep3:function(){var a=$("#myjd-shortcut .myjd-set");$("#guide-mod").remove(),$(".guide-outer").removeClass("guide-outer"),a.addClass("guide-outer"),$('<div id="guide-mod" class="guide-step3"><a href="#none" onclick="guider.end()" class="btn-esc"></a><a href="#none" class="btn-next" onclick="guider.showStep4()"></a></div>').appendTo("body").css({left:a.offset().left+10,top:a.offset().top+10,"margin-left":0})},showStep4:function(){$("#guide-mod").remove(),$(".guide-outer").removeClass("guide-outer"),$("#fol-produce").addClass("guide-outer"),$("#fol-shop").addClass("guide-outer"),$('<div id="guide-mod" class="guide-step4"><a href="#none" onclick="guider.end()" class="btn-esc"></a><a href="#none" class="btn-next" onclick="guider.end()"></a></div>').appendTo("body").css({top:$("#fol-produce").offset().top-310})}}),window.guider=new b,"true"!==$.cookie("home-guide-close")&&guider.showStep0()}),define("toppanel",["../common/Base"],function(a){var b=new a;b.include({init:function(){$("#toppanel").length||$(document.body).prepend('<div class="w ld" id="toppanel"></div>'),$("#toppanel").append('<div id="sidepanel" class="hide"></div>'),this.obj=$("#sidepanel")},scroll:function(){var a=this;$(window).bind("scroll",function(){var b=document.body.scrollTop||document.documentElement.scrollTop;0==b?a.obj.hide():a.obj.show()}),a.initCss(),$(window).bind("resize",function(){a.initCss()})},initCss:function(){var a,b=$("#toppanel").width(),c=document.documentElement.clientWidth;a=c>1024?$.browser.msie&&$.browser.version<=6?{right:"-26px"}:{right:(c-b)/2-26+"px"}:{right:"0"},this.obj.css(a)},addCss:function(a){this.obj.css(a)},addItem:function(a){this.obj.append(a)},setTop:function(){this.addItem("<a href='#' class='gotop' title='\u4f7f\u7528\u5feb\u6377\u952eT\u4e5f\u53ef\u8fd4\u56de\u9876\u90e8\u54e6\uff01'><b></b>\u8fd4\u56de\u9876\u90e8</a>")}});var c=new b;c.addItem("<a class='research' target='_blank' href='http://surveys.jd.com/index.php?r=survey/index/sid/829769/lang/zh-Hans'><b></b>\u8c03\u67e5\u95ee\u5377</a><a title='\u4f7f\u7528\u5feb\u6377\u952eT\u4e5f\u53ef\u8fd4\u56de\u9876\u90e8\u54e6\uff01' class='gotop' href='#'><b></b>\u8fd4\u56de\u9876\u90e8</a>"),c.scroll()}),require(["../common/Base","../common/Slider","../common/Template","../common/Util","../common/Tab","./product","./shop","./orderList","./menu","./history","./home-guide","./toppanel"],function(a,b,c,d,e,f,g,h){var i={_toFix:function(){var a='<div class="iloading">\u6b63\u5728\u52a0\u8f7d\u4e2d\uff0c\u8bf7\u7a0d\u5019...</div>';document.domain="jd.com",$("#fol-produce>div.mc, #fol-shop>div.mc").prepend(a),"undefined"!=typeof asyncScript&&asyncScript("http://fa.360buy.com/loadFa.js?aid=2_102_4806-2_102_4807-2_102_4808-2_102_4809-2_102_4810-2_102_4811-2_102_412")},detect:function(){var a,b='<style type="text/css" id="mediaDetectStyle">@media screen {#mediaDetect {color: rgb(12, 34, 56)}}</style>',c='<div id="mediaDetect"></div>';return $("head").append(b).append(c),a="rgb(12, 34, 56)"==$("#mediaDetect").css("color"),function(){return $("#mediaDetect, #mediaDetectStyle").remove(),d.isIE6&&$("body").addClass("root59"),{mediaSupport:a||d.isIE6}}()},scope:{min:1024,max:1280},ajaxAction:function(a){$.ajax({url:a.url,dataType:a.dataType||"jsonp",timeout:2500,scriptCharset:a.scriptCharset,data:a.data||{},success:function(b){a.callback(b)},error:function(a,b,c){console.info(c)}})},delLink:function(a){a.each(function(){var a=$(this).find("em").text();0==+a?$(this).find("em").removeClass("ftx01").addClass("ftx03").end().find("a").attr("href","javascript:;").attr("target",""):$(this).find("em").removeClass("ftx03").addClass("ftx01")})},init:function(){var a=this,f='<div class="baitiao-info"><%if(!this.hasOwnProperty("debt")) { %><div class="mb5"><%this.bTitle%><%if(this.limit) {%><a href="<%this.href%>" target="_blank"><%this.limit%></a><%}%></div><div><a class="alink" href="<%this.href%>" target="_blank" clstag="click|keycount|wdjd|ljjh"><%this.bStatus%></a></div><%} else {%><div>\u767d\u6761\u6b20\u6b3e<span class="ftx03">\uff08\u5143\uff09</span></div><div class="ftx01 profit"><a href="<%this.href%>" target="_blank" clstag="click|keycount|wdjd|btqk"><%this.debt%></a></div><div>\u767d\u6761\u989d\u5ea6\uff1a<a href="<%this.href%>" target="_blank" clstag="click|keycount|wdjd|bted"><%this.limit%></a></div><%}%></div>';this.ajaxAction({url:"/myjd_getDataCount.action?t="+(new Date).getTime(),callback:function(a){$("#BalanceCount").text(a.balance),$("#LipinkaCount").text(a.lipinka),$("#JingdouCount").text(a.jingdou),$("#CouponCount").text(a.coupon)}}),this.ajaxAction({url:"http://api.credit.wangyin.com/veyron/query/queryCreditJsonp",data:{platform:1,userId:decodeURIComponent(readCookie("pin")),productId:-1},callback:function(b){if(1==b[0].activatedStatus)a.ajaxAction({url:"/myjd_queryPayCheckPermit.action",dataType:"json",callback:function(a){try{if(a.needPayTotal&&a.permLimit){var b={debt:+a.needPayTotal,limit:a.permLimit,href:"http://baitiao.jd.com/creditUser/list"};$(".acco-info-2 .fore3").prepend($(".acco-info-2 .fore2 div")).addClass("merge"),$(".acco-info-2 .fore2").append(c(f,b))}}catch(d){}}});else{var d={limit:0,bTitle:"\u4eac\u4e1c\u767d\u6761",bStatus:"\u7acb\u5373\u6fc0\u6d3b",href:"http://baitiao.jd.com/creditUser/list"};$(".acco-info-2 .fore3").prepend($(".acco-info-2 .fore2 div")).addClass("merge"),$(".acco-info-2 .fore2").append(c(f,d))}}}),this.ajaxAction({url:"http://trade.jr.jd.com/centre/accountcoffer.action",callback:function(a){if(d.isEmpty(a)||0==a.balance)d.isEmpty(a)?$("#balance").hide():$("#balance span.ftx01 a").text(a.balance.toFixed(2)),$("#xjk0").show();else{var b=$("#xjk0 a").text("\u8f6c\u5165").clone().text("\u8f6c\u51fa").attr("href","http://trade.jr.jd.com/pay/topayout.action").addClass("ml10");$("#profit").html('<a class="ftx01" href="http://jinku.pay.jd.com/xjk/income.action" clstag="click|keycount|myhome|jinku">'+a.income.toFixed(2)+"</a>"),$("#balance span.ftx01 a").text(a.balance.toFixed(2)),$("#xjk0").show().append(b)}}}),this.ajaxAction({url:"http://order.jd.com/lazy/getOrderListCount.action",callback:function(b){$("#order-list ul.extra-l li.fore-1 em").text(b.info.waitPay),$("#order-list ul.extra-l li.fore-2 em").text(b.info.waitReceive),$("#order-list ul.extra-l li.fore-3 em").text(b.info.waitPick),a.delLink($("#order-list .extra-l li:not(.fore-last)"))
}}),this.ajaxAction({url:"http://club.jd.com/MyJDIndexService.aspx?method=GetCount",callback:function(b){try{$("#order-list ul.extra-l li.fore-last em").text(b.ProductCount),a.delLink($("#order-list .extra-l li.fore-last"))}catch(c){}}}),this.ajaxAction({url:"http://order.jd.com/lazy/getOrderListJson.action",data:{action:"GetBeforeOneMonthOrderList"},callback:function(a){a.info.length&&(new h(a.info,$(".tb-order table")),$(".tb-order .nocont-box").hide())}}),this.ajaxAction({url:"http://follow.soa.jd.com/product/queryForReduceProductCount",callback:function(b){$("#fol-produce ul.extra-l li:first em").text(b.data),a.delLink($("#fol-produce .extra-l li:first"))}}),this.ajaxAction({url:"http://follow.soa.jd.com/product/queryForSaleProductCount",callback:function(b){$("#fol-produce ul.extra-l li:eq(1) em").text(b.data),a.delLink($("#fol-produce .extra-l li:eq(1)"))}}),this.ajaxAction({url:"http://follow.soa.jd.com/product/queryForStockProductCount",callback:function(b){$("#fol-produce ul.extra-l li:eq(2) em").text(b.data),a.delLink($("#fol-produce .extra-l li:eq(2)"))}}),this.ajaxAction({url:"http://t.jd.com/vender/myFollowVenderList.action",callback:function(c){if(c.length){{new g(c,$("#fol-s-con ul"))}c.length>0&&new b("#fol-s-con",{fix:2}),$("#fol-shop>div.mc div.iloading").hide()}else{var c=[];d.setTimer(function(){return c.length>0&&!d.isEmpty(c[0])},function(){a.ajaxAction({url:"http://t.jd.com/vender/queryRecommendVenders.action",scriptCharset:"utf-8",callback:function(a){if(c=a,a.length>0){{new g(a,$("#fol-s-con ul")),new b("#fol-s-con",{fix:2})}$("#fol-s-con").prev(".nocont-box").show(),$("#fol-shop>div.mc div.iloading").hide()}}})})}}}),this.ajaxAction({url:"http://t.jd.com/vender/querySaleCount.action?isSale=true",callback:function(b){b>0?$("#fol-shop em").removeClass("ftx03").addClass("ftx01").text(b):$("#fol-shop em").removeClass("ftx03").text(0),a.delLink($("#fol-shop .extra-l li:first"))}}),this.ajaxAction({url:"http://safe.jd.com/user/paymentpassword/getUserSafeInfo.action",callback:function(a){var b,c=a.safeLevel+1;switch(c){case 6:b="\u9ad8\u7ea7",$("#up").hide();break;case 5:b="\u8f83\u9ad8",$("#up").hide();break;case 4:b="\u4e2d\u7ea7";break;case 3:b="\u6bd4\u8f83\u4f4e";break;case 2:b="\u975e\u5e38\u4f4e";break;default:b="\u5f88\u5371\u9669"}$("#cla").removeClass().addClass("safe-rank0"+c).after("<strong class='rank-text ftx-02'>"+b+"</strong>")}});new e(".quick-ser",{tabItem:".f-tab li>a",tabContent:".tab-con",callback:function(a){$(".f-tab-con").hide(),$(".f-tab-con:eq("+a+")").show()}})},bindEvent:function(){!this.detect().mediaSupport&&function(a){$(window).resize(d.throttle(function(){var b=$("body").attr("clientWidth");b<a.scope.min?$("body").removeClass().addClass("root59"):b>=a.scope.min&&b<a.scope.max?$("body").removeClass().addClass("root60"):$("body").removeClass().addClass("root61")}),10),$(window).resize()}(this),$(function(){$("#user-info .u-pic").hover(function(){$(".face-link,.face-link-box",this).not(".face-link").fadeTo("normal",.7).end().show()},function(){$(".face-link,.face-link-box",this).fadeOut()})})}};i._toFix(),i.init(),i.bindEvent()}),define("home",function(){});