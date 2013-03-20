<!--
//xmlhttp��xmldom����
var XHTTP = null;
var XDOM = null;
var Container = null;
var ShowError = false;
var ShowWait = false;
var ErrCon = "";
var ErrDisplay = "��������ʧ��";
var WaitDisplay = "������������...";

//��ȡָ��ID��Ԫ��
//function $(eid){
//	return document.getElementById(eid);
//}

function $DE(id) {
	return document.getElementById(id);
}

//gcontainer �Ǳ���������ɵ����ݵ�����
//mShowError �Ƿ���ʾ������Ϣ
//ShowWait �Ƿ���ʾ�ȴ���Ϣ
//mErrCon ����������ʲô�ַ�����Ϊ����
//mErrDisplay ��������ʱ��ʾ����Ϣ
//mWaitDisplay �ȴ�ʱ��ʾ��Ϣ
//Ĭ�ϵ��� Ajax('divid',false,false,'','','')

function Ajax(gcontainer,mShowError,mShowWait,mErrCon,mErrDisplay,mWaitDisplay){

Container = gcontainer;
ShowError = mShowError;
ShowWait = mShowWait;
if(mErrCon!="") ErrCon = mErrCon;
if(mErrDisplay!="") ErrDisplay = mErrDisplay;
if(mErrDisplay=="x") ErrDisplay = "";
if(mWaitDisplay!="") WaitDisplay = mWaitDisplay;


//post��get�������ݵļ�ֵ��
this.keys = Array();
this.values = Array();
this.keyCount = -1;

//http����ͷ
this.rkeys = Array();
this.rvalues = Array();
this.rkeyCount = -1;

//����ͷ����
this.rtype = 'text';

//��ʼ��xmlhttp
if(window.ActiveXObject){//IE6��IE5
   try { XHTTP = new ActiveXObject("Msxml2.XMLHTTP");} catch (e) { }
   if (XHTTP == null) try { XHTTP = new ActiveXObject("Microsoft.XMLHTTP");} catch (e) { }
}
else{
	 XHTTP = new XMLHttpRequest();
}

//����һ��POST��GET��ֵ��
this.AddKey = function(skey,svalue){
	this.keyCount++;
	this.keys[this.keyCount] = skey;
	svalue = svalue.replace(/\+/g,'$#$');
	this.values[this.keyCount] = escape(svalue);
};

//����һ��Http����ͷ��ֵ��
this.AddHead = function(skey,svalue){
	this.rkeyCount++;
	this.rkeys[this.rkeyCount] = skey;
	this.rvalues[this.rkeyCount] = svalue;
};

//�����ǰ����Ĺ�ϣ�����
this.ClearSet = function(){
	this.keyCount = -1;
	this.keys = Array();
	this.values = Array();
	this.rkeyCount = -1;
	this.rkeys = Array();
	this.rvalues = Array();
};


XHTTP.onreadystatechange = function(){
	//��IE6�в�����ϻ��첽ģʽ����ִ������¼���
	if(XHTTP.readyState == 4){
    if(XHTTP.status == 200){
       if(XHTTP.responseText!=ErrCon){
         Container.innerHTML = XHTTP.responseText;
       }else{
       	 if(ShowError) Container.innerHTML = ErrDisplay;
       }
       XHTTP = null;
    }else{ if(ShowError) Container.innerHTML = ErrDisplay; }
  }else{ if(ShowWait) Container.innerHTML = WaitDisplay; }
};

//������ģʽ��״̬
this.BarrageStat = function(){
	if(XHTTP==null) return;
	if(typeof(XHTTP.status)!=undefined && XHTTP.status == 200)
  {
     if(XHTTP.responseText!=ErrCon){
         Container.innerHTML = XHTTP.responseText;
     }else{
       	if(ShowError) Container.innerHTML = ErrDisplay;
     }
  }
};

//����http����ͷ
this.SendHead = function(){
	if(this.rkeyCount!=-1){ //�����û������趨������ͷ
  	for(;i<=this.rkeyCount;i++){
  		XHTTP.setRequestHeader(this.rkeys[i],this.rvalues[i]); 
  	}
  }
��if(this.rtype=='binary'){
  	XHTTP.setRequestHeader("Content-Type","multipart/form-data");
  }else{
  	XHTTP.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  }
};

//��Post��ʽ��������
this.SendPost = function(purl){
	var pdata = "";
	var i=0;
	this.state = 0;
	XHTTP.open("POST", purl, true); 
	this.SendHead();
  if(this.keyCount!=-1){ //post����
  	for(;i<=this.keyCount;i++){
  		if(pdata=="") pdata = this.keys[i]+'='+this.values[i];
  		else pdata += "&"+this.keys[i]+'='+this.values[i];
  	}
  }
  XHTTP.send(pdata);
};

//��GET��ʽ��������
this.SendGet = function(purl){
	var gkey = "";
	var i=0;
	this.state = 0;
	if(this.keyCount!=-1){ //get����
  	for(;i<=this.keyCount;i++){
  		if(gkey=="") gkey = this.keys[i]+'='+this.values[i];
  		else gkey += "&"+this.keys[i]+'='+this.values[i];
  	}
  	if(purl.indexOf('?')==-1) purl = purl + '?' + gkey;
  	else  purl = purl + '&' + gkey;
  }
	XHTTP.open("GET", purl, true); 
	this.SendHead();
  XHTTP.send(null);
};

//��GET��ʽ�������ݣ�����ģʽ
this.SendGet2 = function(purl){
	var gkey = "";
	var i=0;
	this.state = 0;
	if(this.keyCount!=-1){ //get����
  	for(;i<=this.keyCount;i++){
  		if(gkey=="") gkey = this.keys[i]+'='+this.values[i];
  		else gkey += "&"+this.keys[i]+'='+this.values[i];
  	}
  	if(purl.indexOf('?')==-1) purl = purl + '?' + gkey;
  	else  purl = purl + '&' + gkey;
  }
	XHTTP.open("GET", purl, false); 
	this.SendHead();
  XHTTP.send(null);
  //firefox��ֱ�Ӽ��XHTTP״̬
  this.BarrageStat();
};

//��Post��ʽ��������
this.SendPost2 = function(purl){
	var pdata = "";
	var i=0;
	this.state = 0;
	XHTTP.open("POST", purl, false); 
	this.SendHead();
  if(this.keyCount!=-1){ //post����
  	for(;i<=this.keyCount;i++){
  		if(pdata=="") pdata = this.keys[i]+'='+this.values[i];
  		else pdata += "&"+this.keys[i]+'='+this.values[i];
  	}
  }
  XHTTP.send(pdata);
  //firefox��ֱ�Ӽ��XHTTP״̬
  this.BarrageStat();
};


} // End Class Ajax

//��ʼ��xmldom
function InitXDom(){
  if(XDOM!=null) return;
  var obj = null;
  if (typeof(DOMParser) != "undefined") { // Gecko��Mozilla��Firefox
    var parser = new DOMParser();
    obj = parser.parseFromString(xmlText, "text/xml");
  } else { // IE
    try { obj = new ActiveXObject("MSXML2.DOMDocument");} catch (e) { }
    if (obj == null) try { obj = new ActiveXObject("Microsoft.XMLDOM"); } catch (e) { }
  }
  XDOM = obj;
};

-->
