
var erpAd = {
    sortRfidMap : {"798":"3100","870":"3101","878":"3102","880":"3103","823":"3104","965":"3105","1199":"3106","1300":"3107","1706":"3108","1301":"3109","1707":"3110","877":"3111","1013":"3112"},

    isErp:function(_cid){
      var c3 = _cid.split("-")[2];
      return !!this.sortRfidMap[c3];
    },
    getErpHotSale: function (_cid) {
        var _categories = _cid.split("-");
        var c2 = _categories[1];
        var c3 = _categories[2];
        var rfId = this.sortRfidMap[c3];
        var provinecId = this.getProvinecId() || 1;

        var param = "[{\"size\":3,\"sizeNation\":2,\"provinecId\":" + provinecId + ",\"rfid\":"+rfId+",\"categoryId\":"+c3+",\"compare\":1}]" ;/**热卖推荐**/
        var paramObj = {jsonStr:encodeURIComponent(param), key:provinecId + '-' + rfId}
        if(!!rfId) paramObj['resource'] = 'new';
        dspTools.jsonP("http://d.360buy.com/vclist/getvclist.action?callback=getErpHostSalCallBack&" + (function(){
                var str = [];
                for(var p in paramObj){
                    str.push(p + "=" + paramObj[p]);
                }
                return str.join("&");
            })()
        );

    },
    getProvinecId : function(){
        return this.getCookie("areaId");
    },
    getCookie :function(name) {
        var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
        if(arr=document.cookie.match(reg))
            return unescape(arr[2]);
        else
            return null;
    }
};


function formatErpAdData(_dataObj){
    var rs = [];
    for(var _rfId in _dataObj){
        var rfList = _dataObj[_rfId];
        for(var i=0;i< rfList.length;i++) {
            var item = rfList[i];
            var _skuObj = new skuObj();
            _skuObj.Id = item.skuid;
            _skuObj.Name = item.title + (!!item.wareTitle? "<font color='#ff6600'>" + item.wareTitle+'</font>':'');
            _skuObj.Img = item.imgurl;
            _skuObj.Ptype = 7;
            _skuObj.Index = i;
            rs.push(_skuObj);
        }
    }
    return rs;
}

function getErpHostSalCallBack(_res){
    try{
        var _sl = formatErpAdData(_res);

        for (var i = 0; i < _sl.length; i++) {
            if (_sl[i].Index < mainsl.length) {
                mainsl[_sl[i].Index] = _sl[i];
            }
        }
    }catch (ex) {
    }

    var _num = haveNullNum(mainsl);

    if (_num > 0) {
        getjjsku_callback(_global_dsp_data,_global_dsp_tag,_global_dsp_cid);
    }
    else {
        buildHtml(mainsl);
    }
}



