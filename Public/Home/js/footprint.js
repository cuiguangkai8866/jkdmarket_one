/*
 JD Modules Compressed by uglify 
 Author:keelii 
 Date: 2014-09-23 
 */
function log(a,b){var c="";for(i=2;i<arguments.length;i++)c=c+arguments[i]+"|||";var d=decodeURIComponent(escape(getCookie("pin"))),e="http://csc."+pageConfig.FN_getDomain()+"/log.ashx?type1=$type1$&type2=$type2$&data=$data$&pin=$pin$&referrer=$referrer$&jinfo=$jinfo$&callback=?",f=e.replace(/\$type1\$/,escape(a));f=f.replace(/\$type2\$/,escape(b)),f=f.replace(/\$data\$/,escape(c)),f=f.replace(/\$pin\$/,escape(d)),f=f.replace(/\$referrer\$/,escape(document.referrer)),f=f.replace(/\$jinfo\$/,escape("")),$.getJSON(f,function(){});var g=("https:"==document.location.protocol?"https://mercuryssl":"http://mercury")+".jd.com/log.gif?t=other.000000&m=UA-J2011-1&v="+encodeURIComponent("t1="+a+"$t2="+b+"$p0="+c)+"&ref="+encodeURIComponent(document.referrer)+"&rm="+(new Date).getTime(),h=new Image(1,1);h.src=g}function clsPVAndShowLog(a,b,c,d){var e=a+"."+c+"."+skutype(b)+"."+d;log("d","o",e)}function clsClickLog(a,b,c,d,e,f){var g=a+"."+d+"."+skutype(b);appendCookie(f,c,g),log("d","o",g+".c")}function appendCookie(reCookieName,sku,key){var reWidsCookies=eval("("+getCookie(reCookieName)+")");(null==reWidsCookies||""==reWidsCookies)&&(reWidsCookies=new Object),null==reWidsCookies[key]&&(reWidsCookies[key]="");var pos=reWidsCookies[key].indexOf(sku);0>pos&&(reWidsCookies[key]=reWidsCookies[key]+","+sku),setCookie(reCookieName,$.toJSON(reWidsCookies),15)}function skutype(a){if(a){var b=a.toString().length;return 10==b?1:0}return 0}function setCookie(a,b,c){var d=c,e=new Date;e.setTime(e.getTime()+24*d*60*60*1e3),document.cookie=a+"="+escape(b)+";expires="+e.toGMTString()+";path=/;domain=."+pageConfig.FN_getDomain()}function getCookie(a){var b=document.cookie.match(new RegExp("(^| )"+a+"=([^;]*)(;|$)"));return null!=b?unescape(b[2]):null}function clsLog(a,b,c,d,e){appendCookie(e,c,a),c=c.split("#")[0],log(3,a,c)}function initFootmark(){var a=pageConfig.wideVersion&&pageConfig.compatible?23:19,b="book"==document.body.id,c=pageConfig.product&&pageConfig.product.skuid?pageConfig.product.skuid:"",d='        <div class="mt">            <h2 class="title">\u6700\u8fd1\u6d4f\u89c8</h2>            <div class="extra"><a clstag="personal|keycount|myhistory|gdll407" href="http://my.jd.com/history/list.html" target="_blank">\u66f4\u591a\u6d4f\u89c8\u8bb0\u5f55</a></div>        </div>        <div class="mc">            <ul class="recent-view-list clearfix">                {for item in data}                <li ${pageConfig.getFootPrintClk(item, item_index).recent} data-push="${pageConfig.footmarkSkus.push(item.sku)}" data-clk="${item.clk}">                    <div class="p-img">                        <a href="http://item.jd.com/${item.sku}.html" title="${item.t}" target="_blank">                            <img src="${pageConfig.FN_GetImageDomain(item.sku)}cms/s70x70_${item.img}" alt="${item.t}" width="70px" height="70px" />                        </a>                    </div>                    <div class="p-price J-p-${item.sku}">&yen;</div>                </li>                {/for}            </ul>        </div>',e='        <div class="mt clearfix">            <h2 class="title">\u6839\u636e\u6d4f\u89c8\u731c\u4f60\u559c\u6b22</h2>            <div class="extra"><a clstag="personal|keycount|myhistory|hyp407" href="#none" class="change"><i class="ico"></i><span class="txt">\u6362\u4e00\u6279</span></a></div>        </div>        <div class="mc">            <ul class="may-like-list clearfix">                {for item in data}                <li ${pageConfig.getFootPrintClk(item, item_index).guess} data-push="${pageConfig.footmarkSkus.push(item.sku)}" data-clk="${item.clk}">                    <div class="p-img">                        <a href="http://item.jd.com/${item.sku}.html" title="${item.t}" target="_blank">                            <img src="${pageConfig.FN_GetImageDomain(item.sku)}n3/${item.img}" alt="${item.t}" width="130" height="130" />                        </a>                    </div>                    <div class="p-name"><a href="http://item.jd.com/${item.sku}.html" target="_blank" title="${item.t}">${item.t}</a></div>                    <div class="p-review"><a class="p-comm-${item.sku}" href="http://club.jd.com/review/${item.sku}-1-1.html" target="_blank">(\u5df2\u6709\u4eba\u8bc4\u4ef7)</a></div>                    <div class="p-price J-p-${item.sku}">&yen;</div>                </li>                {/for}            </ul>        </div>';!function(){var a=$("#product-track").parent(),b='            <div class="m hide may-like">                <div class="loading-style1"><b></b>\u52a0\u8f7d\u4e2d\uff0c\u8bf7\u7a0d\u5019...</div>            </div>            <div class="m hide recent-view">                <div class="loading-style1"><b></b>\u52a0\u8f7d\u4e2d\uff0c\u8bf7\u7a0d\u5019...</div>            </div>';a.after('<div id="footmark" class="w footmark"></div>'),$(".footmark").html(b),a.remove()}(),mlazyload&&mlazyload({defObj:"#footmark",defHeight:0,fn:function(){b?(new Footmark({el:$(".recent-view"),template:d,param:{p:202001,sku:c,ck:"pin,bview",lim:a},onLoad:function(){log("BOOK&HomeHis","Show")}}),new Footmark({el:$(".may-like"),template:e,param:{p:202e3,sku:c,ck:"pin,ipLocation,btw,bview",lim:a},onLoad:function(){log("BOOK&HomeTrack","Show")}})):(new Footmark({el:$(".may-like"),template:e,param:{p:202002,sku:c,ck:"pin,ipLocation,atw,aview",lim:a},onLoad:function(){clsPVAndShowLog("","",2,"s")}}),new Footmark({el:$(".recent-view"),template:d,param:{p:202001,sku:c,ck:"pin,aview",lim:a},onLoad:function(){clsPVAndShowLog("","",3,"s")}}))}})}pageConfig.getFootPrintClk=function(a,b){var c="book"==document.body.id,d={item:a,ind:b};return c?{recent:" onclick=\"clsLog('${item.sku}&HomeHis', '', '${item.sku}#${item.jp}', ${ind}, 'reWidsBookHis');\"".process(d),guess:" onclick=\"clsLog('${item.sku}&HomeTrack', '', '${item.sku}#${item.jp}', ${ind}, 'reWidsBookTrack');\"".process(d)}:{recent:" onclick=\"clsClickLog('', '', '${item.sku}', 3, ${ind}, 'rodGlobalHis');\"".process(d),guess:" onclick=\"clsClickLog('', '', '${item.sku}', 2, ${ind}, 'rodGlobalTrack');\"".process(d)}};var Footmark=function(a){if(this.param=$.extend({lid:"1",lim:10,ec:"utf-8",uuid:-1,pin:readCookie("pin")||""},a.param),this.el=a.el,this.template=a.template,this.onLoad=a.onLoad||function(){},this.debug=a.debug,!this.param.p)throw new Error("The param [p] is not Specificed");this.init()};Footmark.prototype={init:function(){var a=readCookie("__jda");this.param.lid=this.param.lid.indexOf("-")>0?this.param.lid.split("-")[0]:this.param.lid,this.param.uuid=a?"-"==a.split(".")[1]?-1:a.split(".")[1]:-1,this.get(this.rid)},get:function(){/testParam/.test(location.href)&&(pageConfig.queryParam={c1:670,c2:671,c3:672,brand:"11516|12345",price:"M4800L7099",keyword:"\u563f\u563f",page:2});var a,b,c=this,d=pageConfig.queryParam,e=[];if(pageConfig.product)for(a=0;a<pageConfig.product.cat.length;a++)this.param["c"+(a+1)]=pageConfig.product.cat[a];if(d){for(var b in d)d.hasOwnProperty(b)&&("c1"==b||"c2"==b||"c3"==b?c.param[b]=d[b]:e.push(b+":"+d[b]));c.param.hi=e.join(",")}this.debug,$.ajax({url:"http://diviner.jd.com/diviner?"+decodeURIComponent($.param(this.param)),dataType:"jsonp",scriptCharset:this.param.ec,success:function(a){a.success&&a&&a.data?c.set(a):c.el.html('<div class="ac">\u300c\u6682\u65e0\u6570\u636e\u300d</div>'),this.debug}})},set:function(a){this.el,this.tpl||"";pageConfig.footmarkSkus=[],this.el.show().html(this.template.process(a)),this.getPriceNum(pageConfig.footmarkSkus,this.param.lid,this.el),this.getCommentData(pageConfig.footmarkSkus,this.el),this.setTrackCode(a.impr),this.bindChange(),this.onLoad(this,a)},bindChange:function(){function a(a,b,c){var d=0,f=a.length,g=1;a.each(function(a){a%c==0&&d++,$(this).attr({"data-gid":d,clstag:e.replace("{GROUP}",d)})}),b.unbind("click").bind("click",function(){g>=f/c&&(g=0);var b=a.filter('[data-gid="'+ ++g+'"]');a.hide(),b.show()})}function b(a,b){var c;a.addClass(b),clearTimeout(c),c=setTimeout(function(){a.removeClass(b)},1e3)}var c=this.el.find(".mt .change"),d=pageConfig.wideVersion&&pageConfig.compatible?6:5,e="";e=".may-like"==this.el.selector?"personal|keycount|myhistory|hyp{GROUP}":"personal|keycount|myhistory|zjll",a(this.el.find(".mc ul li"),c,d),c.click(function(){b($(this),"change-clicked")})},getCommentData:function(a,b,c){a=a||[],b=b||$("body").eq(0),c=c||"p-comm-",$.ajax({url:"http://club.jd.com/clubservice.aspx?method=GetCommentsCount&referenceIds="+a,dataType:"jsonp",success:function(a){var b;if(a&&a.CommentsCount.length){b=a.CommentsCount.length;for(var d=0;b>d;d++)$("."+c+a.CommentsCount[d].SkuId).html("(\u5df2\u6709"+a.CommentsCount[d].CommentCount+"\u4eba\u8bc4\u4ef7)")}}})},setTrackCode:function(a){var b=this.el.find("li"),c=this,d="&m=UA-J2011-1&ref="+encodeURIComponent(document.referrer);b.each(function(){var a=$(this).attr("data-clk");$(this).bind("click",function(b){var e=$(b.target);(e.is("a")||e.is("img")||e.is("span"))&&c.newImage(a+d,!0),e.is("input")&&1==e.attr("checked")&&c.newImage(a+d,!0)})}),this.newImage(a+d,!0)},newImage:function(a,b,c){var d=new Image;a=b?a+"&random="+Math.random()+new Date:a,d.onload=function(){"undefined"!=typeof c&&c(a)},d.setAttribute("src",a)},getPriceNum:function(a,b,c,d,e){a="string"==typeof a?[a]:a,c=c||$("body"),d=d||"J-p-";var f="";if(null!==b&&(f=readCookie("ipLoc-djd")?"&area="+readCookie("ipLoc-djd").replace(/-/g,"_"):"&area=1"),"undefined"!=typeof a){var g="http://p.3.cn/prices/mgets?type=1&skuIds=J_"+a.join(",J_")+f;$.ajax({url:g,dataType:"jsonp",success:function(a){if(!a&&!a.length)return!1;for(var b=0;b<a.length;b++){if(!a[b].id)return!1;{var f=a[b].id.replace("J_",""),h=parseFloat(a[b].p);parseFloat(a[b].m)}c.find("."+d+f).html(h>0?"\uffe5"+a[b].p:"\u6682\u65e0\u62a5\u4ef7"),"function"==typeof e&&e(f,a[b],g)}}})}}},initFootmark();