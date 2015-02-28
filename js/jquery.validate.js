function MaskSSN(obj){var p=$(obj).val();if (p.length==3){len=p.length;
temp1=p.substring(0,3);temp2=p.substring(3,len);$(obj).val("");$(obj).val(temp1+"-"+temp2);}p4=p.substring(0,3);
p6=p.substring(4,p.length);p=p4+p6;if (p.length>4&&p.indexOf("-")==-1){len=p.length;temp1=p4+"-"+p6;temp2=p.substring(6,p.length);$(obj).val("");
$(obj).val(temp1+"-"+temp2);}}function MaskPhone(obj){
var p=$(obj).val();if(p.length==3){pp=p;d4=p.indexOf("(");d5=p.indexOf(")");if(d4==-1){
pp="("+pp}if(d5==-1){pp=pp+") "}$(obj).val("");$(obj).val(pp);}if(p.length>3){d1=p.indexOf("(");
d2=p.indexOf(")");if(d2==-1){l30=p.length;p30=p.substring(0,4);p30=p30+") ";p31=p.substring(4,l30);pp=p30+p31;$(obj).val("");$(obj).val(pp);}}
if(p.length>4){p11=p.substring(d1+1,d2);if(p11.length>3){p12=p11;l12=p12.length;l15=p.length;p13=p11.substring(0,3);p14=p11.substring(3,l12);p15=p.substring(d2+1,l15);
 $(obj).val("");pp="("+p13+")"+p14+p15; $(obj).val(pp);}//end if
l16=p.length;p16=p.substring(d2+1,l16);l17=p16.length;if(l17>3&&p16.indexOf("-")==-1){p17=p.substring(d2+1,d2+5);
p18=p.substring(d2+5,l16);p19=p.substring(0,d2+1);pp=p19+p17+"-"+p18;$(obj).val("");$(obj).val(pp);}}}
function isNumberKey(evt){var charCode=(evt.which)?evt.which:evt.keyCode;
if(charCode==36||charCode==40||charCode==41||charCode==42||charCode==43||charCode==45||charCode==46||charCode==47){return false;}
if(charCode>31&&(charCode<35||charCode>57)){return false;}return true;}
function isBackspace(evt){var charCode=(evt.which)?evt.which:evt.keyCode;if(charCode==8){
return true;}return false;}function validateEmail(obj) {$(obj).val($.trim($(obj).val()));if($(obj).val()==""){$(obj).attr("style"," border: 1px solid #f40505;");return false
}else if(!$(obj).val().match(/^[\w!#$%&'*+//=?`{|}~^-]+(?:\.[!#$%&'*+//=?`{|}~^-]+)*@(?:[a-zA-Z0-9-]+\.)+[a-zA-Z]{2,6}$/i)){$(obj).attr("style"," border: 1px solid #f40505;");
return false;}else{$(obj).attr("style","border: 1px solid #009900;");return true;}
}function validateString(id) {var field = "#"+id;$(field).val($.trim($(field).val()));if($(field).val()==""){$(field).attr("style"," border: 1px solid #f40505;");return false;
}else{$(field).attr("style","border: 1px solid #009900;");return true;}}
function popup(mylink, windowname){
if (! window.focus)return true;
var href;
if (typeof(mylink) == 'string')
   href=mylink;
else
   href=mylink.href;
window.open(href, windowname, 'width=500,height=540,scrollbars=yes');
return false;
}