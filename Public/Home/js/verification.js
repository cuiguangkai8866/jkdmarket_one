$(function(){
	$(".footer_copy_nav li:last").children('span').remove();
    $(".tabnav a").click(function(event) {
        var index = $(this).index();
        $(this).addClass('curr').siblings('a').removeClass('curr');
        $(".content_body form").eq(index).show().siblings('form').hide();
    });
    $("#signup-submit").click(function(event) {
    	return check();
    });
    /*$("#signup-email-address").blur(function(){
		isEmail(this.value);
	});*/
	/*$("#signup-username").blur(function(){
		isString(this.value);
	});*/

})
var result,email,user,psw,repsw,chnum;
function check(){
result=false;
email = $("#signup-email-address");
user = $("#signup-username");
psw = $("#signup-password");
repsw = $("#signup-password-confirm");
chnum = $("#signup-hashcode-confirm");
	if(email.val()=="" || email.val()==null){
		email.focus();
		email.parent().addClass('error_ui');
		email.siblings('.invalid').show().children('i').show().siblings('.required').show().siblings('.format').hide();
	}else if(user.val()=="" || user.val()==null){
		user.focus(); 
		user.parent().addClass('error_ui');
		user.siblings('.invalid').show().children('i').show().siblings('.required').show().siblings();
	}else if(psw.val()=="" || psw.val()==null){
		psw.focus(); 
		psw.parent().addClass('error_ui');
		psw.siblings('.invalid').show().children('i').show().siblings('.required').show().siblings();
	}else if(repsw.val()=="" || repsw.val()==null){
		repsw.focus(); 
		repsw.parent().addClass('error_ui');
		repsw.siblings('.invalid').show().children('i').show().siblings('.required').show().siblings();
	}else if(repsw.val() != psw.val()){
		repsw.focus();
		repsw.siblings('.invalid').show().children('i').show().siblings('.custom').show().siblings();
	}else if(chnum.val()=="" || chnum.val()==null){
		chnum.focus();
		chnum.siblings('.invalid').show().children('i').show().siblings('.required').show().siblings();
	}else
		result=true;
	return result;
}

function checksafestr(str,isspace){             //设置非法字符，防SQL、JS注入攻击
	var result=false;
	var arr=new Array(";",",","!","<",">","#","?","；","，","。","！","《","》","·","￥","？","%","……","—","*","（","）","——","＝","－","=");
	if(isspace && str.indexOf(" ")!=-1)
		result=true;
	for(var i=0;i<arr.length;i++){
		if(str.indexOf(arr[i])!=-1){
			result=true;
			break;
		}
	}
	return result;
}
/*function isInteger(obj){
    reg=/^[-+]?\d+$/;    
    if(!reg.test(obj)){   
        $("#test").html("<b>Please input correct figures</b>");   
    }else{   
        $("#test").html("");   
    }   
} */
function isEmail(obj){   
    reg=/^\w{3,}@\w+(\.\w+)+$/;   
    if(!reg.test(obj) && obj.length > 0){
    	$("#signup-email-address").parent().addClass('error_ui');
		$("#signup-email-address").siblings('.invalid').show().children('i').show().siblings('.format').show().siblings('.required').hide();         
    }else{   
        $("#signup-email-address").parent().removeClass('error_ui');
        $(".invalid").hide();
    }
}
function isString(obj,un){   
    reg=/^[a-z,A-Z]+$/;
    if(!reg.test(obj) && obj.length > 4){
    	$("#signup-username").parent().removeClass('error_ui');
        $(".invalid").hide();
    	
    }else{  
    	$("#signup-username").parent().addClass('error_ui');
		$("#signup-username").siblings('.invalid').show().children('i').show().siblings('.format').show().siblings('.required').hide();
    }   
}   
function isTelephone(obj){   
    reg=/^(\d{3,4}\-)?[1-9]\d{6,7}$/;   
    if(!reg.test(obj)){   
        $("#test").html("<b>请输入正确的电话号码！</b>");   
    }else{   
        $("#test").html("");   
    }   
}   
function isMobile(obj){   
    reg=/^(\+\d{2,3}\-)?\d{11}$/;   
    if(!reg.test(obj)){   
        $("#test").html("请输入正确移动电话");   
    }else{   
        $("#test").html("");   
    }   
}   
function isUri(obj){   
    reg=/^http:\/\/[a-zA-Z0-9]+\.[a-zA-Z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/;   
    if(!reg.test(obj)){   
        $("#test").html($("#uri").val()+"请输入正确的inernet地址");   
    }else{   
        $("#test").html("");   
    }   
}