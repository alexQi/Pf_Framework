function gotoPages(url,page){
	var realUrl = url+'&onPage='+page;
	window.location.href=realUrl;
}

/**
 +----------------------------------------------------------
 * 字符串空格的去除
 +----------------------------------------------------------
 */

String.prototype.trim = function()
{
    return this.replace(/(^\s*)|(\s*$)/g, "");
};

String.prototype.ltrim = function()
{
    return str.replace(/(^\s*)/g,"");
};


String.prototype.rtrim = function()
{
    return str.replace(/(\s*$)/g,"");
};


/**
 +----------------------------------------------------------
 * 截取指定长度数据，"..."补足
 +----------------------------------------------------------
 */
String.prototype.sub = function(n)
{
    var r = /[^\x00-\xff]/g;
    if(this.replace(r, "mm").length <= n) return this;
    var m = Math.floor(n/2);
    for(var i=m; i<this.length; i++) {
        if(this.substr(0, i).replace(r, "mm").length>=n) {
            return this.substr(0, i) +"...";
        }
    }
    return this;
};



/**
 +----------------------------------------------------------
 * 返回数组最大值
 +----------------------------------------------------------
 */
Array.prototype.arrayMax=function()
{
    if(typeof this)
    var i, max = this[0];
    for (i = 1; i < this.length; i++){
        if (max < this[i]) max = this[i];
    }
    return max;
};



/**
 +----------------------------------------------------------
 * 判断值是否在数组中
 +----------------------------------------------------------
 */
Array.prototype.in_array = function(e)
{
    for(i=0;i<this.length;i++){
        if(this[i] == e)
        return true;
    }
    return false;
};

/**
 * fun    : showBox()_Box隐藏显示
 * param  : BoxId
 * return : Null
 * example: showBox('BoxId');
 */

function showBox(boxId){
    if(boxId=='') return false;
    var boxes = document.getElementById(boxId);
    if(boxes.style.display=='none'){
        boxes.style.display=''
    }else{
        boxes.style.display='none'
    }
}


/**
 * fun    : getCheckBoxValue()_获取对应Name的CheckBox已选值
 * param  : checkBoxName
 * return : Boolean
 * example: getCheckBoxValue(checkBoxName);
 */

function getCheckBoxValue(checkBoxName){
    var result = new Array();
    if(checkBoxName=='') return;
    var boxes = document.getElementsByName(checkBoxName);
    for (var i = 0; i < boxes.length; i++){
        if(boxes[i].checked ==true) {
			result.push(boxes[i].value);
		}
    }
    return result.join(',');
}


/**
 * fun    : selectAll()_checkBOX的全选
 * param  : memberBox,actType=>1->冻结 0->解冻
 * return : Boolean
 * example: selectAll('btnId',checkBoxName);
 */

function selectAll(clickBtn,domName){
	var boxes = document.getElementsByName(domName);
	var sclTrue = document.getElementById(clickBtn);
	if(sclTrue.checked){
		for (var i = 0; i < boxes.length; i++){
			boxes[i].checked = true;
		}
	}else{
		for (var i = 0; i < boxes.length; i++){
			boxes[i].checked = false;
		}
	}
}

/**
 * fun    : formatNumber()_数字的千分转换
 * param  : numbers 需要转换成千分的数字
 * return : Number
 * example: formatNumber('31232131313');
 */

function formatNumber(numbers) {
    var strInput = Math.abs(numbers).toString(),strXS = "";
    if (strInput.indexOf(".", 0) != -1) {
        strXS = strInput.substring(strInput.split(".")[0].length, strInput.length);
        strInput = strInput.split(".")[0];
    }
    var iLen = strInput.length;

    if(iLen <= 3) {
        return numbers;
    }else{
        var iMod = iLen % 3,iStart = iMod,aryReturn = [];
        while (iStart + 3 <= iLen) {
            aryReturn[aryReturn.length] = strInput.substring(iStart, iStart + 3);
            iStart = iStart + 3;
        }
        aryReturn = aryReturn.join(",");
        if(iMod != 0) aryReturn = strInput.substring(0, iMod) + "," + aryReturn;
        if(numbers < 0) aryReturn = "-" + aryReturn;
        return aryReturn + strXS;
    }
}



/**
 * fun    : isEmail()_验证email
 * param  : string
 * return : Boolean
 */

function isEmail(str){
    var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
    return reg.test(str);
}



/**
 * fun    : isChinese()_验证汉字
 * param  : string
 * return : Boolean
 */

function isChinese(str){
    var reg = /^[\u4e00-\u9fa5]+$/;
    return reg.test(str);
}


/**
 * fun    : isInteger()_验证是否为整数
 * param  : string
 * return : Boolean
 */

function isInteger(str){
    var reg = /^[-]{0,1}[0-9]{1,}$/;
    return reg.test(str);
}



/**
 * fun    : isNull()_验证是否为空
 * param  : string
 * return : Boolean
 */
function isNull(str){
    var str = str.replace(/(^\s*)|(\s*$)/g, "");
    if(str=="") return true;
    var o = "^[ ]+$";
    var b = new RegExp(o);
    return b.test(str);
}



/**
 * fun    : isFloat()_验证是否为整数
 * param  : string
 * return : Boolean
 */

function isFloat(str){
    //var reg = /^[1-9]d*.d*|0.d*[1-9]d*$/;
    var reg = /^\d*\.?\d*$/;
    return reg.test(str);
}

/**
 * fun    : isZern()_验证是否为0
 * param  : Must string
 * return : Boolean
 */

function isZero(str){
    if(str=='0' || str===0){
        return true;
    }else if(str=='NaN'){
        return false;
    }
    return false;
}

/**
 * fun    : isUrl()_验证是否为url
 * param  : Must string
 * return : Boolean
 */

function isUrl(str){
    var  reg= /^http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/;
    return reg.test(str);
}



/**
 * fun    : isUnionDomain()_验证是否为联盟允许url
 * param  : Must string
 * return : Boolean
 */

function isUnionDomain(domains){
	var domain = domains.match("^[0-9a-zA-Z-]*\.(com\.tw|com\.cn|com\.hk|net\.cn|org\.cn|gov\.cn|ac\.cn|bj\.cn|sh\.cn|tj\.cn|cq\.cn|he\.cn|sx\.cn|nm\.cn|ln\.cn|jl\.cn|hl\.cn|js\.cn|zj\.cn|ah\.cn|fj\.cn|jx\.cn|sd\.cn|ha\.cn|hb\.cn|hn\.cn|gd\.cn|gx\.cn|hi\.cn|sc\.cn|gz\.cn|yn\.cn|xz\.cn|sn\.cn|gs\.cn|qh\.cn|nx\.cn|xj\.cn|tw\.cn|hk\.cn|mo\.cn|com|net|org|biz|info|cn|mobi|name|sh|ac|io|tw|hk|ws|travel|us|tm|cc|mx|tv|la|in|asia|me|cm|net\.ru|be|tk|so|bo|vc|co|pw)$");
	try{
        return domain[0];
    }catch(e){}
}



/**
 * fun    : isUrl()_满足最小长度
 * param  : Must string
 * return : Boolean
 */

function minLength (str,len) {
    var str = str.replace(/(^\s*)|(\s*$)/g, "");
    if(str.length<len){
        return false;
    }
    return true;
}


/**
 * fun    : maxLength()_满足最大长度
 * param  : Must string
 * return : Boolean
 */
function maxLength (str,len) {
    var str = str.replace(/(^\s*)|(\s*$)/g, "");
    if(str.length>len){
        return false;
    }
    return true;
}

function setFocusColor(obj){
    var trBox=document.getElementById('mainTable').getElementsByTagName("tr");
    for(var i=0;i<trBox.length;i++){
        trBox[i].style.backgroundColor='';
    }
    obj.style.backgroundColor='#ECECEC';
}

function createFrame(url){
	var s = '<iframe scrolling="auto" frameborder="0"  src="'+url+'" style="width:100%;height:100%;"></iframe>';
	return s;
}