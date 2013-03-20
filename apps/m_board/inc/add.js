function FaceChoose(n){
	var ClassName = "Face"+n;
	document.getElementById("Peview").setAttribute("class",ClassName);
	document.getElementById("Peview").setAttribute("className",ClassName);
	frmAdd.face.value = n;
}
function IconChange(n){
	var IconUrl = "images/icon"+n+".gif";
	document.getElementById("IconImg").src = IconUrl;	
	frmAdd.icon.value = n;	
}
function InputName(OriInput, GoalArea){
	document.getElementById(GoalArea).innerHTML = OriInput.value;
}
function strCounter(field){
	if (field.value.length > 70)
		field.value = field.value.substring(0, 70);
	else{
		document.getElementById("Char").innerHTML = 70 - field.value.length;
		document.getElementById("AreaText").innerHTML = field.value;
	}
}
function getTime(){
	var ThisTime = new Date();
	document.write(ThisTime.getFullYear()+"-"+(ThisTime.getMonth()+1)+"-"+ThisTime.getDate()+" "+ThisTime.getHours()+":"+ThisTime.getMinutes()+":"+ThisTime.getSeconds()); 
}
function chkphpk(obj){
    if(obj.info.value==""){
        alert("请填写[字条内容]");
        obj.info.focus();
        return false;
    }
	if(obj.send.value==""){
        alert("请填写[发送人]");
        obj.send.focus();
        return false;
    }
    if(obj.seccode.value==""){
        alert("请输入[验证码]");
        obj.key.focus();
        return false;
    }else{
		var noStr = obj.key.value;
		var no = parseInt(noStr);
	}
	frmAdd.submit.disabled=true;
    return true;
}