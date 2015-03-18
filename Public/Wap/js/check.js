function check(){
	var result=false;
	var user = $("#email");
	var psw = $("#password");
	var repsw = $("#password2");
	var chnum = $("#chnum");
	if(user.val()=="" || user.val()==null || user.val()=="邮箱/手机号"){
		user.focus();
		alert("请输入用户名！");
	}else if(user.val().length < 4 || user.val().length > 12){
		user.focus(); 
		alert("长度应为4-12之间");
	}else if(checksafestr(user.val(),true)){
		user.focus();
		alert("用户名包含非法字符");
	}else if(psw.val()=="" || psw.val()==null){
		psw.focus();
		alert("请输入密码！");
	}else if(psw.val().length < 4 || psw.val().length > 12){
		psw.focus(); 
		alert("长度应为4-12之间");
	}else if(repsw.val() != psw.val()){
		repsw.focus(); 
		alert("两次密码不一致!");
	}else if(chnum.val()=="" || chnum.val()==null){
		chnum.focus(); 
		alert("请输入验证码!");
	}else
		result=true;
	return result;
}
function checksafestr(str,isspace){             //设置非法字符，防SQL、JS注入攻击
	var result=false;
	var arr=new Array(";",",",".","!","<",">","@","#","?");
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