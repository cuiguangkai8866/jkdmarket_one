;(function(){
	if (typeof(jsf) == 'undefined'){
		var jsf = {};
	}
	window.jsf = jsf;

	jsf.createXMLHttpRequest =  function() {
		if (window.ActiveXObject) {
			var aVersions = ["MSXML2.XMLHttp.5.0", "MSXML2.XMLHttp.4.0", "MSXML2.XMLHttp.3.0", "MSXML2.XMLHttp", "Microsoft.XMLHttp"];
			for (var i = 0; i < aVersions.length; i++) {
				try {
					return new ActiveXObject(aVersions[i]);
				} catch(oError) {
					continue;
				}
			}
		} else if (window.XMLHttpRequest) {
			return new XMLHttpRequest();
		}

		throw new Error("XMLHttp object could not be created.");
	}

	jsf.ajax =  function(opts) {
		var _xmlHttp = jsf.createXMLHttpRequest();
		
		var query = [], data;
		for(var key in opts.data) {
			query[query.length] = encodeURI(key) + "=" + encodeURIComponent(opts.data[key]);
		}
		data = query.join('&');
		if (opts.method== "GET" && data !='') {
			opts.url += '?'+data;
		}

		_xmlHttp.open(opts.method, opts.url, true);
		_xmlHttp.setRequestHeader("cache-control", "no-cache");
		
		if (opts.method.toUpperCase() == "POST") {
			_xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		}

		_xmlHttp.onreadystatechange = function() {
			if (_xmlHttp.readyState == 4 && _xmlHttp.status == 200) {
				var response = null;
				switch (opts.dataType.toUpperCase()) {
				case "json":
					response = eval(_xmlHttp.responseText);
					break;
				case "xml":
					response = _xmlHttp.responseXML;
					break;
				case "html":
					response = _xmlHttp.responseText;
					break;
				default:
					response = _xmlHttp.responseText;
					break;
				}
				if (typeof(opts.success) != 'undefined') {
					opts.success(_xmlHttp.responseText);
				}
			}else if (_xmlHttp.readyState == 4) {
				var codes = ['500', '501', '502', '503', '504', '505', '404'];
				if (codes.join(',').indexOf(_xmlHttp.status.toString()) >= 0 && typeof(opts.error) != 'undefined') {
					opts.error(_xmlHttp.status, _xmlHttp.responseText);
				}
			}
		}
		
		//开始发送数据
		_xmlHttp.send(data);
	}
	
	jsf.referer = function(){
		 return document.referer ? document.referer : '';
	}

	jsf.insertAfter = function (newEl, targetEl) {
		var parentEl = targetEl.parentNode;
		if (parentEl.lastChild == targetEl) {
			parentEl.appendChild(newEl);
		} else {
			parentEl.insertBefore(newEl, targetEl.nextSibling);
		}
	}

	jsf.ready = (function() {
		var funcs = [];
		var ready = false;
		
		function handler(e) {
			if(ready) return;
			
			if(e.type === 'onreadystatechange' && document.readyState !== 'complete') {
				return;
			}
			
			for(var i=0; i<funcs.length; i++) {
				funcs[i].call(document);
			}
			ready = true;
			funcs = null;
		}
		if(document.addEventListener) {
			document.addEventListener('DOMContentLoaded', handler, false);
			document.addEventListener('readystatechange', handler, false);            //IE9+
			window.addEventListener('load', handler, false);
		}else if(document.attachEvent) {
			document.attachEvent('onreadystatechange', handler);
			window.attachEvent('onload', handler);
		}
		return function whenReady(fn) {
			if(ready) { fn.call(document); }
			else { funcs.push(fn); }
		}
	})();

	jsf.getPreviousSibling = function(ele,idName){
		var node = ele.previousSibling;
		while (node.nodeType != 1) {
			node = node.previousSibling;
			if (!node) return null;
		};
		return node;
	}

	jsf.getNextSibling = function(ele,idName){
		var node = ele.nextSibling;
		while (node.nodeType != 1) {
			node = node.nextSibling;
			if (!node) return null;
		};
		return node;
	}

	jsf.loadScript = function (url, callback){
		var head = document.getElementsByTagName('head')[0];
		var script = document.createElement('script');
		script.type = 'text/javascript';
		script.src = url;
		script.onreadystatechange = callback;
		script.onload = callback;
		head.appendChild(script);
	}

	jsf.getJsonp = (function () {
		var counter = 0,head, query, key, window = this;
		function load(url) {
			var script = document.createElement('script');
			var done = false;
			script.src = url;
			script.async = true;

			script.onload = script.onreadystatechange = function () {
				if (!done && (!this.readyState || this.readyState === "loaded" || this.readyState === "complete")) {
					done = true;
					script.onload = script.onreadystatechange = null;
					if (script && script.parentNode) {
						script.parentNode.removeChild(script);
					}
				}
			};
			if (!head) {
				head = document.getElementsByTagName('head')[0];
			}
			head.appendChild(script);
		}

		function jsonp(url, params, callback, error) {
			query = "?";
			params = params || {};
			for (key in params) {
				if (params.hasOwnProperty(key)) {
					query += encodeURIComponent(key) + "=" + encodeURIComponent(params[key]) + "&";
				}
			}
			var jsonp = "jsf_jsonp_" + (++counter);
			window[jsonp] = function (data) {
				callback(data);
				try {
					delete window[jsonp];
				} catch (e) {}
				window[jsonp] = null;
			};

			load(url + query + "callback=" + jsonp);

			//error = error || function () {};
			return jsonp;
		}
		return jsonp;
	}());

	if (typeof(ssp) == 'undefined'){
		var ssp = {};
	}
	window.ssp = ssp;

	ssp.getErrorData = function(random){
		var m = document.getElementById('sspid'+random);
		var mHtml =  m.innerHTML;
		if(mHtml.length==0){
		m.innerHTML = '<div style="	position:relative;top:50%;left:50%;margin-top:-25px;margin-left:-75px;float:left;width:150px;height:50px;font-weight:bold;text-align:center;font-size:36px;font-family:\'Microsoft YaHei\'"><a href="http://www.jd.com/" target="_blank" style="color:#C81623;text-decoration:none;">JD.COM</a></div>';
		}
	}
	ssp.getData = function(random,param){
		var ajaxData = {};

		if (typeof(param) == 'object') {
			if (param.jd_ad_client) {
				//广告位id
				ajaxData.ad_ids = param.jd_ad_client+":"+1;
			}
			
			if (param.jd_ad_category) {
				//三级分类id
				ajaxData.urlcid3 = param.jd_ad_category;
			}
		}

		ajaxData.r=random;
		ajaxData.ad_type=8;	
		ajaxData.debug=0;
		ajaxData.spread_type = 1;	
		ajaxData.location_info=0;
		
		var doError = function(){
			 var m = document.getElementById('sspid'+random);
			m.innerHTML = '<div style="	position:relative;top:50%;left:50%;margin-top:-25px;margin-left:-75px;float:left;width:150px;height:50px;font-weight:bold;text-align:center;font-size:36px;font-family:\'Microsoft YaHei\'"><a href="http://www.jd.com/" target="_blank" style="color:#C81623;text-decoration:none;">JD.COM</a></div>';
			m.style.border = '1px solid #C81623';
		}
		
		var doSuccess = function(data){
			 if (data) {
				//data = eval( '(' +data+ ')' );
				if (data.errcode == 0) {

					var el = document.getElementById('sspid'+data.id);
					if (!el) {
						return;
					}

					var data2 =/<script type=\"text\/javascript\">(.*?)<\/script>/gim.exec(data.data);
					
					if (data2) {
						var data3 = data2[1];
						var dataHtml = data.data.replace(/<script type=\"text\/javascript\">.*?<\/script>/gmi,'');
						el.innerHTML = dataHtml;
						eval(data3);
					}else {
						el.innerHTML = data.data;
					}

					if (data.scriptsrc) {
						jsf.loadScript(data.scriptsrc);
					}
				}
			}else {
				doError();
			}
		}

		var url ="http://x.jd.com/ShowInterface";
		/*
		jsf.ajax({ 
			url: url,	
			method: "GET",
			data:ajaxData,
			dataType: "json",
			success: function(data) {
				doSuccess(data);
			},
			error: function(){
				doError();
			}
		});
		*/

		setTimeout(function(){
			jsf.getJsonp(url,ajaxData,function(data){
				 doSuccess(data);
			})
		},0);
	}

	ssp.init = function(){
		var s = document.getElementsByTagName('script');
		for (var i=0  ; i<s.length  ;i++  ){
			if (s[i].src && /ssp.js/.test(s[i].src)) {
				//取参数
				var config = jsf.getPreviousSibling(s[i]);
				var configText = config.innerHTML.replace(/\s/gim,'');
				var configArray  = configText.split(';');
				var configObj = {};
				for (var m = 0  ,n = configArray.length ; m <n; m++  ){
					var c = configArray[m];
					var d  = c.split('=');
					if (d[0] != '' && !/\/\//.test(d[0])) {
						configObj[d[0]] = d[1];
					}
				}
			
				var d = document.createElement('div');
				var random  = Math.floor(Math.random() * 1e8);
				d.id = 'sspid'+random;

				if (configObj.jd_ad_width) {
					d.style.width = configObj.jd_ad_width  +'px';
				}

				if (configObj.jd_ad_height) {
					d.style.height = configObj.jd_ad_height  +'px';
				}
				d.style.overflow =  'hidden';
				d.style.margin =  '0 auto';

				jsf.insertAfter(d,s[i]);
				d = null;
			//	setTimeout(function(){
				ssp.getData(random,configObj)//;},0);

				setTimeout(function(){ssp.getErrorData(random,configObj)},500);
			}
		}
	}
})();



//初始化
if (typeof(sspTag) == 'undefined') {
	var sspTag = 1;
	jsf.ready(function(){
		ssp.init();
	});
}
