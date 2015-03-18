$(function(){
    // 拍拍开拍提醒
    // var jfClock_con
    $(".jfplist li:nth-child(4n+1)").css('margin-left', '0');
    $(".jfplist_state_notice .jfplist_bh").click(function() {
        var clock_con = $(this).parents(".jfplist_state").siblings(".clock_con").val();
        var clock_time = $(this).parents(".jfplist_state").siblings(".clock_time").val();
        var clock_url = $(this).parents(".jfplist_state").siblings(".clock_url").val();
        var __jfClock = {
            content: clock_con,
            time: clock_time,
            advance: 5,
            url: clock_url
        };
        //var a = $('a')[0];
        var a = $('<a href="http://qzs.qq.com/snsapp/app/bee/widget/open.htm#content=' + encodeURIComponent(__jfClock.content) +'&time=' + encodeURIComponent(__jfClock.time) +'&advance=' + __jfClock.advance +'&url=' + encodeURIComponent(__jfClock.url) + '" target="_blank"></a>').get(0);
        
        var e = document.createEvent('MouseEvents');
        e.initEvent( 'click', true, true );
        a.dispatchEvent(e);
    });

    // 日期转为时间戳
    function js_strto_time(str_time){
        var new_str = str_time.replace(/:/g,'-');
        new_str = new_str.replace(/ /g,'-');
        var arr = new_str.split("-");
        var datum = new Date(Date.UTC(arr[0],arr[1]-1,arr[2],arr[3]-8,arr[4],arr[5]));
        return strtotime = datum.getTime()/1000;
    }
    // 时间戳转为日期
    function js_date_time(unixtime) {
        var timestr = new Date(parseInt(unixtime) * 1000);
        var datetime = timestr.toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ");
        return datetime;
    }
    // 已知日期输出时间戳
    /*var str_time = '2014-11-3 10:55:00';
    var rst_strto_time = js_strto_time(str_time);
    alert("转换后的UNIX时间戳为: "+rst_strto_time);*/

     // 已知时间戳输出日期
    /*var unixstr = js_strto_time(str_time);
    var rst_date_time = js_date_time(unixstr);
    alert("转换后的日期为: "+rst_date_time);*/
})

var hastime;
    var curtime = 0;
    // 获取当前时间
    var d = new Date();
    var rtime = parseInt(d.getTime()/1000);
    // alert(rtime);
function daojishi(a){
        window.setInterval(function(){
            a.each(function() {
                // 获取结束时间
                var etime = $(this).attr("date-endtime");
                // 获取差值
                hastime = rtime-etime;
                hastime += curtime;
                if(hastime==0){
                    parent.location.reload();
                }else{
                    
                    if(hastime>0){
                        // hastime -= curtime;
                        var hh=parseInt(hastime/3600);
                        var mm=parseInt(hastime%3600/60);
                        var ss=parseInt(hastime%60);
                        $(this).find('i').html("<span>" + hh + "</span>" + "时" + "<span>" + mm + "</span>" + "分" + "<span>" + ss + "</span>" + "秒");
                    }else if(hastime<0){
                        var hh=Math.abs(parseInt(hastime/3600));
                        var mm=Math.abs(parseInt(hastime%3600/60));
                        var ss=Math.abs(parseInt(hastime%60));
                        if(hh > 24){
                            var dd = Math.floor(hh/24); //天数
                            hh = hh - dd*24;
                            $(this).find('i').html("<span>" + dd + "</span>" + "天"+"<span>" + hh + "</span>"+"时"+"<span>" + mm + "</span>" + "分"+"<span>" + ss + "</span>" + "秒");
                        }else{
                            $(this).find('i').html("<span>" + hh + "</span>" + "时" + "<span>" + mm + "</span>" + "分"+ "<span>" + ss + "</span>" + "秒");
                        }
                    }
                }
            });
            curtime++;
        },1000)
    }