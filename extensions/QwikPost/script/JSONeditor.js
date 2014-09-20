var JSONeditor={start:function(_1,_2,_3,_4,_5,_6){
if(this.start==true) return;
this.start=true;
this.treeBuilder.ext=_5;
if(this.examples.length<6){
var e=this.treeBuilder.JSONstring.make(this);
eval("this.examples[5]={JSONeditor:"+e+"}");
}

this.treeDivName=_1;
var t=this.treeBuilder,$f=t.$;
t.images.path=_5 + t.images.path;
treeBuilder=t;
var s=$f(_1).style;
var f=$f(_2);
var fs=f.style;
f.innerHTML=this.formHTML;
if(_6) document.forms.jsoninput.mode.selectedIndex=parseInt(_6)
if(!_4){
$f("jExamples").style.display="none";
}
fs.fontSize=s.fontSize="11px";
fs.fontFamily=s.fontFamily="Verdana,Arial,Helvetica,sans-serif";
var e=f.getElementsByTagName("*");
for(var i=0;i<e.length;i++){
var s=e[i].style;
if(s){
s.fontSize="11px";
s.fontFamily="Verdana,Arial,Helvetica,sans-serif";
}
}
_3=_3||{};

t.JSONbuild(_1,_3);
for(var i in t.json.media){
break;
}
for(var q in t.json.type){
break;
}
if(q.indexOf("\\")!=-1||q.indexOf("\"")!=-1||q.indexOf(".")!=-1){
t.jsonResponder("json.type[\""+q+"\"]");
}else{
t.jsonResponder("json.type."+q);
}
if(i.indexOf("\\")!=-1||i.indexOf("\"")!=-1||i.indexOf(".")!=-1){
t.jsonResponder("json.media[\""+i+"\"]");
}else{
t.jsonResponder("json.media."+i);
}
t.jsonResponder("json");
},loadExample:function(x){
treeBuilder.hasRunJSONbuildOnce=false;
treeBuilder.JSONbuild(this.treeDivName,this.examples[x/1]);
},formHTML:"<form name=\"jsoninput\" onsubmit=\"return send()\">"+"<div id=\"jExamples\" style=\"display:none\">Load an example:&nbsp;<select name=\"jloadExamples\" onchange=\"JSONeditor.loadExample(this.value)\"><option value=\"0\">None/empty</option><option value=\"1\">Employee data</option><option value=\"2\">Sample Konfabulator Widget</option><option value=\"3\">Member data</option><option value=\"4\">A menu system</option><option value=\"5\">The source code of this JSON editor</option></select><br><br>\nLabel:<br><input name=\"jlabel\" type=\"text\" value=\"\" size=\"60\" style=\"width:600px\" disabled=\"disabled\"><br><br></div>"+"Value: <br><textarea onchange=\"document.getElementById(\'jformMessage\').innerHTML=\'\'\" onkeyup=\"if(!document.forms.jsoninput.jSafeChange.disabled){document.getElementById(\'jformMessage\').innerHTML=\'Click on \\'Change\\' to change\';}else{document.getElementById(\'jformMessage\').innerHTML=\'\';}\" name=\"jvalue\" rows=\"15\" cols=\"50\" style=\"width:620px\" disabled=\"disabled\"></textarea>\n"+"<br><br>"+"Render Mode: <select name=\"mode\"><option value=\"0\">Server</option><option value=\"1\">Client</option><option value=\"2\">Either</option></select>"+"<br><br>"+"<input name=\"jAddMedia\" onfocus=\"this.blur()\" type=\"button\" onclick=\"treeBuilder.jsonAddMedia()\" value=\"Add Media\">"+"&nbsp;&nbsp;"+"<input name=\"jAddParam\" onfocus=\"this.blur()\" type=\"button\" onclick=\"treeBuilder.jsonAddParam()\" value=\"Add Param\" disabled=\"disabled\">"+"&nbsp;&nbsp;"+"<input name=\"jAddType\" onfocus=\"this.blur()\" type=\"button\" onclick=\"treeBuilder.jsonAddType()\" value=\"Add Type\">"+"&nbsp;&nbsp;"+"<input name=\"jUp\" onfocus=\"this.blur()\" type=\"button\" onclick=\"treeBuilder.jsonMove(true)\" value=\"&#8593;\" disabled=\"disabled\">"+"&nbsp;&nbsp;"+"<input name=\"jDown\" onfocus=\"this.blur()\" type=\"button\" onclick=\"treeBuilder.jsonMove(false)\" value=\"&#8595;\" disabled=\"disabled\">"+"&nbsp;&nbsp;"+"<input name=\"jSafeChange\" onfocus=\"this.blur()\" type=\"button\" onclick=\"treeBuilder.jsonSafeChange()\" value=\"Change\">"+"&nbsp;&nbsp;"+"<input name=\"jSafeRename\" onfocus=\"this.blur()\" type=\"button\" onclick=\"treeBuilder.jsonSafeRename(this.parentNode)\" value=\"Rename\">"+"&nbsp;&nbsp;"+"<input name=\"jSafeDelete\" onfocus=\"this.blur()\" type=\"button\" onclick=\"treeBuilder.jsonSafeDelete()\" value=\"Delete\" disabled=\"disabled\">"+"&nbsp;&nbsp;"+"<input name=\"jSave\" onfocus=\"this.blur()\" type=\"submit\" value=\"Save\" >"+"<div style=\"display:none\">"+"Data type: <select onchange=\"treeBuilder.changeJsonDataType(this.value,this.parentNode)\" name=\"jtype\">\n<option value=\"object\">object</option>\n<option value=\"array\">array</option>\n<option value=\"function\">function</option>\n<option value=\"string\">string</option>\n<option value=\"number\">number</option>\n<option value=\"boolean\">boolean</option>\n<option value=\"null\">null</option>\n<option value=\"undefined\">undefined</option>\n</select>&nbsp;&nbsp;&nbsp;&nbsp;\n<input name=\"orgjlabel\" type=\"hidden\" value=\"\" size=\"50\" style=\"width:300px\">\n<input onfocus=\"this.blur()\" type=\"submit\" value=\"Save\">"+"&nbsp;\n<br><br>\n<input name=\"jAddChild\" onfocus=\"this.blur()\" type=\"button\" onclick=\"treeBuilder.jsonAddChild(this.parentNode)\" value=\"Add child\">\n<input name=\"jAddSibling\" onfocus=\"this.blur()\" type=\"button\" onclick=\"treeBuilder.jsonAddSibling(this.parentNode)\" value=\"Add sibling\">\n<br><br>\n<input name=\"jRemove\" onfocus=\"this.blur()\" type=\"button\" onclick=\"treeBuilder.jsonRemove(this.parentNode)\" value=\"Delete\">&nbsp;\n<input name=\"jRename\" onfocus=\"this.blur()\" type=\"button\" onclick=\"treeBuilder.jsonRename(this.parentNode)\" value=\"Rename\">&nbsp;\n<input name=\"jCut\" onfocus=\"this.blur()\" type=\"button\" onclick=\"treeBuilder.jsonCut(this.parentNode)\" value=\"Cut\">&nbsp;\n<input name=\"jCopy\" onfocus=\"this.blur()\" type=\"button\" onclick=\"treeBuilder.jsonCopy(this.parentNode)\" value=\"Copy\">&nbsp;\n<input name=\"jPaste\" onfocus=\"this.blur()\" type=\"button\" onclick=\"treeBuilder.jsonPaste(this.parentNode)\" value=\"Paste\">&nbsp;\n<br><br>\n<input type=\"checkbox\" name=\"jbefore\">Add children first/siblings before\n<br>\n<input type=\"checkbox\" name=\"jPasteAsChild\">Paste as child on objects & arrays\n<br><br></div><div id=\"jformMessage\" style=\"padding-top:20px;\"></div>"+"\n</form>",examples:[{},{employee:{gid:102,companyID:121,defaultActionID:444,names:{firstName:"Stive",middleInitial:"Jr",lastName:"Martin"},address:{city:"Albany",state:"NY",zipCode:"14410-585",addreess:"41 State Street"},job:{departmentID:102,jobTitleID:100,hireDate:"1/02/2000",terminationDate:"1/12/2007"},contact:{phoneHome:"12-123-2133",beeper:"5656",email1:"info@soft-amis.com",fax:"21-321-23223",phoneMobile:"32-434-3433",phoneOffice:"82-900-8993"},login:{employeeID:"eID102",password:"password",superUser:true,lastLoginDate:"1/12/2007",text:"text",regexp:/^mmm/,date:new Date()},comment:{PCDATA:"comment"},roles:[{role:102},{role:103}]}},{"widget":{"debug":true,"window":{"title":"Sample Konfabulator Widget","name":"main_window","width":500,"height":500},"Pairs":[{"src":"Images/Sun.png","name":"sun1"},{"hOffset":250,"vOffset":200},null,{"alignment":"center"}],"text":{"a very long item label here":"Click Here","size":36,"style":"null","name":"text1","hOffset":250,"vOffset":100,"alignment":"center","onmouseover":function(){
alert("Hello World");
},"onMouseUp":"sun1.opacity = (sun1.opacity / 100) * 90;"}}},{"members":[{"href":"1","entity":{"category":[{"term":"weblog","label":"Weblog stuff"}],"updated":"2007-05-02T23:32:03Z","title":"This is the second post","author":{"uri":"http://dealmeida.net/","email":"roberto@dealmeida.net","name":"Rob de Almeida"},"summary":"Testing search","content":{"content":"This is my second post, to test the search.","type":"text"},"id":"1"}},{"href":"0","entity":{"category":[{"term":"weblog","label":"Weblog stuff"},{"term":"json","label":"JSON"}],"updated":"2007-05-02T23:25:59Z","title":"This is the second version of the first post","author":{"uri":"http://dealmeida.net/","email":"roberto@dealmeida.net","name":"Rob de Almeida"},"summary":"This is my first post here, after some modifications","content":{"content":"This is my first post, testing the jsonstore WSGI microapp PUT.","type":"html"},"id":"0"}}],"next":null},{"menu":{"header":"SVG Viewer","items":[{"id":"Open"},{"id":"OpenNew","label":"Open New","thing":"thing"},{"id":"ZoomIn","label":"Zoom In"},{"id":"ZoomOut","label":"Zoom Out"},{"id":"OriginalView","label":"Original View"},null,{"id":"Quality"},{"id":"Pause"},{"id":"Mute"},null,{"id":"Find","label":"Find..."},{"id":"FindAgain","label":"Find Again"},{"id":"Copy"},{"id":"CopyAgain","label":"Copy Again"},{"id":"CopySVG","label":"Copy SVG"},{"id":"ViewSVG","label":"View SVG"}]}}]};
JSONeditor.treeBuilder={stateMem:{},images:{folderNode:"",folderNodeOpen:"",folderNodeLast:"",folderNodeOpenLast:"",docNode:"",docNodeLast:"",folder:"",folderOpen:"",doc:"",vertLine:"",folderNodeFirst:"",folderNodeOpenFirst:"",folderNodeLastFirst:"",folderNodeOpenLastFirst:"",path:"treeBuilderImages/",nodeWidth:16},$:function(x){
return document.getElementById(x);
},preParse:function(x){
var x=x.innerHTML.split("\n");
var d=[];
for(var i=0;i<x.length;i++){
if(x[i]){
var y=x[i].split("\t");
var l=0;
while(!y[l]){
l++;
}
var la=y[l]?y[l]:"";
l++;
var t=y[l]?y[l]:"";
d.push({level:l,label:la,todo:t});
}
}
return d;
},isArray:function(x){
return x.constructor==Array;
},jSyncTree:function(x){
var d=this.$(this.baseDiv).getElementsByTagName("div");
for(var i=0;i<d.length;i++){
treeBuilder.maniClick="giveItBack";
var p=d[i].onclick();
if(p==x){
var t=d[i];
treeBuilder.maniClick="selectIt";
t.onclick();
t=t.parentNode;
while(t.id!=this.baseDiv){
if(t.style){
this.openAndClose(t.id,"open");
}
t=t.parentNode;
}
}
}
treeBuilder.maniClick=false;
},jsonResponder:function(x){
this.jTypeChanged=false;
treeBuilder.jSyncTree(x);
var t=treeBuilder;
eval("var a=treeBuilder."+x);
eval("var ap=treeBuilder."+t.jsonParent(x));
var b=t.JSONstring.make(a);
var t=(a&&treeBuilder.isArray(a))?"array":typeof a;
var tp=(ap&&treeBuilder.isArray(ap))?"array":typeof ap;
if(a===null){
t="null";
}
var f=document.forms.jsoninput;
if(t=="string"){
b=b.substring(1,b.length-1);
b=treeBuilder.jsonUnEscapeText(b);
}
f.jlabel.value=x;
f.orgjlabel.value=x;
f.jvalue.value=b;
f.jtype.value=t;
f.jlabel.disabled=true;
f.jvalue.disabled=!x.match(/^(json\.media\[[^\]]+\]\.((params\.[^\.]+)|(id)))$|^(json\.media\.[^\.]+\.((params\.[^\.]+)|(id)))$|^(json\.type\.[^\.]+)$/);
f.jSafeChange.disabled=f.jvalue.disabled;
f.jAddParam.disabled=!x.match(/^(json\.media\[[^\]]+\]\.params)$|^(json\.media\.[^\.]+\.params)$/);
f.jUp.disabled=!x.match(/^(json\.type\.[^\.]+)$|^(json\.media\[[^\]]+\])$|^(json\.media\.[^\.]+)$/);
f.jDown.disabled=f.jUp.disabled;
f.jSafeRename.disabled=!x.match(/^(json\.media\[[^\]]+\](\.params\.[^\.]+)?)$|^(json\.media\.[^\.]+(\.params\.[^\.]+)?)$/);
f.jSafeRename.disabled=f.jSafeRename.disabled?!x.match(/^(json\.type\.[^\.]+)$/):x.substring(x.lastIndexOf(".")+1)=="type";
f.jSafeDelete.disabled=!x.match(/^(json\.type\.[^\.]+)$|^(json\.media\[[^\]]+\](\.params\.[^\.]+)?)$|^(json\.media\.[^\.]+(\.params\.[^\.]+)?)$/);
},jsonEscapeText:function(x){
x=x.replace(/\\/g,'\\\\').replace(/\\"/g,'\"')
return x;
},jsonUnEscapeText:function(x){
x=x.replace(/\\(")/g,'$1')
return x;
},jsonEscapeLabel:function(x){
var a=0,b=0,c,d;
while((a=x.indexOf("[\"",a))!=-1&&(b=x.indexOf("\"]",a))!=-1){
c=x.substring(0,a+2);
d=x.substring(a+2,b);
d=treeBuilder.jsonEscapeText(d);
x=c+d+"\"]";
a=x.length;
x+=x.substring(a);
}
return x;
},jsonEmpty:function(x){
return !x||x.match(/^\s+$/);
},jsonAddMedia:function(){
var t=this;
var _28=prompt("Please enter the media name. E.g. \"youtube.com\".\nThis is the unique part of the url for a straight string comparison to identify the provider.\nIt doesn't have to point to a specific address/sub-domain\nIf you want several unique names you can use a pipe to separate them E.g. \".jpg|.gif|.png\"");
if(t.jsonEmpty(_28)||t.json.media[_28]||_28.indexOf("\"")!=-1||_28.indexOf("\\")!=-1||_28.indexOf("[")!=-1||_28.indexOf("]")!=-1){
alert("Media name empty, already exists or invalid. Add media aborted!");
return;
}
var id=prompt("Please enter the id. E.g. \"/(watch?)?v(=|/)([A-Za-z0-9_-]+)/\".\nThis is a case insensitive regular expression used to match the media item.\nIf you are using \"/\" there is no need for these to be escaped,\nthey are treated as the character and not to encase the expression");
if(t.jsonEmpty(id)){
alert("Id empty. Add media aborted!");
return;
}
var _2a=prompt("Please enter the type name. E.g. \"embed\".\nThis matched with a corresponding type\n");
if(!_2a||t.jsonEmpty(_2a)||_2a.indexOf("\"")!=-1||_2a.indexOf("\"")!=-1||_2a.indexOf("\\")!=-1||_2a.indexOf("[")!=-1||_2a.indexOf("]")!=-1){
alert("Type empty or invalid. Add media aborted!");
return;
}
var t=this;
if(!t.json.type[_2a]&&confirm("The type doesn't exist would you like to create it?")){
t.jsonAddType(_2a);
}
t.jsonResponder("json.media");
var f=document.forms.jsoninput;
t.jsonAddChild(f,_28);
f.jvalue.value="{id:\""+id.replace("\\","\\\\").replace("\"","\\\"")+"\",params:{type:\""+_2a+"\"}}";
t.jsonChange(f);
if(_28.indexOf("\\")!=-1||_2a.indexOf("\"")!=-1||_2a.indexOf(".")!=-1){
t.jsonResponder("json.media[\""+_28+"\"].params");
}else{
t.jsonResponder("json.media."+_28+".params");
}
alert("To add a parameter click on \"Add Param\"");
},jsonAddType:function(_2c){
var t=this;
if(!_2c){
var _2c=prompt("Please enter the type name. E.g. \"embed\".\nThis can correspond with the a type parameter of media");
if(t.jsonEmpty(_2c)||t.json.type[_2c]||_2c.indexOf(".")!=-1||_2c.indexOf("\"")!=-1||_2c.indexOf("\\")!=-1||_2c.indexOf("[")!=-1||_2c.indexOf("]")!=-1){
alert("Type name empty or exists. Add Type aborted!");
return;
}
}
var _2e=prompt("Please enter the tags/xhtml you would like to use for you type.\nE.g. \"<a href='#{href}' alt='link' target='_blank' rel='nofollow\" >[[_link_]]</a>\"\nnote that parameters from the media can be included like so #{param}");
if(!_2e||t.jsonEmpty(_2e)){
alert("No tags/xhtml of Type. Add Type aborted!");
return;
}
t.jsonResponder("json.type");
var f=document.forms.jsoninput;
t.jsonAddChild(f,_2c);
f.jtype.value="string";
f.jvalue.value=_2e;
t.jsonChange(f);
},jsonAddParam:function(){
var t=this;
var f=document.forms.jsoninput;
var x=f.orgjlabel.value;
var ap=t.jsonParent(x);
var app=t.jsonParent(ap);
if(app!="json.media"&&x.substring(x.lastIndexOf(".")+1)!="params"){
return;
}
var _35=prompt("Please enter the param name.");
eval("var paramEx = t."+t.jsonEscapeLabel(x)+"[\""+_35+"\"]");
if(!_35||t.jsonEmpty(_35)||_35=="type"||paramEx||_35.indexOf(".")!=-1||_35.indexOf("\"")!=-1||_35.indexOf("\\")!=-1||_35.indexOf("[")!=-1||_35.indexOf("]")!=-1){
alert("Param name empty, invalid, reserved or alread exists. Add Param aborted!");
return;
}
var _36=prompt("Please enter value of the param.\nThis is used for stuff like attributes used in you type tags/xhtml\nId matches can be inserted.\nE.g. If you have the id of \"/(watch?)?v(=|/)([A-Za-z0-9_-]+)/\" you can insert the third partial match by putting $3 like so \"http://www.youtube.com/v/$3\"");
if(!_36||t.jsonEmpty(_36)){
alert("Param value empty. Add Param aborted!");
return;
}
var a=x+"."+_35;
t.jsonResponder(x);
t.jsonAddChild(f,_35);
t.jsonResponder(a);
f=document.forms.jsoninput;
f.jtype.value="string";
f.jvalue.value=_36;
t.jsonChange(f);
t.jsonResponder(x);
},jsonMove:function(_38){
var t=this;
var f=document.forms.jsoninput;
var x=f.orgjlabel.value;
var v=f.jvalue.value;
var c=t.jsonChild(x);
var ap=t.jsonParent(x);
eval("var apo=treeBuilder."+ap);
var j=false,_40,_41,_42,_43;
for(i in apo){
if(j){
_41=i;
break;
}
if(i==c){
j=true;
continue;
}
_40=i;
}
if((_38&&!_40)||(!_38&&!_41)){
return;
}
t.jsonCut(f);
t.jsonResponder(ap+"[\""+(_38?_40:_41)+"\"]");
f=document.forms.jsoninput;
f.jbefore.checked=_38;
t.jsonPaste(f,true);
},jsonSafeChange:function(){
var t=this;
var f=document.forms.jsoninput;
var x=f.orgjlabel.value;
var v=f.jvalue.value;
var ap=t.jsonParent(x);
var app=t.jsonParent(ap);
if(app=="json.media"&&x.substring(x.lastIndexOf(".")+1)=="id"){
try{
new RegExp(v);
}
catch(e){
alert("Id not a valid regular expression");
return;
}
}
if(t.jsonEmpty(v)){
alert("Value can not be empty");
return;
}
t.jsonChange(f);
},jsonSafeDelete:function(){
if(!confirm("Are you sure you wish to delete?")){
return;
}
var f=document.forms.jsoninput;
this.jsonRemove(f);
},jsonSafeRename:function(f){
var _4c=l=f.orgjlabel.value;
var ap=this.jsonParent(_4c);
var app=this.jsonParent(ap);
l=this.jsonChild(l);
var nl=prompt("Label (without path):",l);
if(this.jsonEmpty(nl)){
alert("Label can not be empty");
return;
}
this.jsonResponder(_4c);
if(ap=="json.media"){
if(ap[nl]||nl.indexOf("\"")!=-1||nl.indexOf("\\")!=-1||nl.indexOf("[")!=-1||nl.indexOf("]")!=-1){
alert("Media name already exists or invalid.");
return;
}
}else{
if(ap[nl]||nl.indexOf(".")!=-1||nl.indexOf("\"")!=-1||nl.indexOf("\\")!=-1||nl.indexOf("[")!=-1||nl.indexOf("]")!=-1){
alert("Invalid Name or already exists");
return;
}
}
var nl=nl.replace(/\w/g,"")===""?"."+nl:"[\""+nl+"\"]";
f.jlabel.value=this.jsonParent(_4c)+nl;
this.jsonChange(f,false,true);
},jsonParent:function(x){
if(x=="json"){
return "treeBuilder";
}
if(x.charAt(x.length-1)=="]"){
return x.substring(0,x.lastIndexOf("["));
}
return x.substring(0,x.lastIndexOf("."));
},jsonChild:function(el1){
var p=this.jsonParent(el1);
el1=el1.split(p).join("");
if(el1.charAt(0)=="."){
el1=el1.substring(1);
}
if(el1.charAt(0)=="["){
el1=el1.substring(2,el1.length-2);
}
return el1;
},jsonRemove:function(f){
this.jsonChange(f,true);
},jsonAlreadyExists:function(o,l){
if(o[l]!==undefined){
var co=2;
while(o[l+"_"+co]!==undefined){
co++;
}
var n=l+"_"+co;
var p="\""+l+"\" already exists in this object.\nDo you want to rename? (otherwise the old \""+l+"\" will be overwritten.)";
p=prompt(p,n);
if(p){
l=p;
}
}
return l;
},jsonAddChild:function(f,_5a){
_5a.replace("\"","\\\"");
var _5b=f.jbefore.checked;
var l=f.orgjlabel.value;
eval("var o=this."+this.jsonEscapeLabel(l));
var t=(o&&this.isArray(o))?"array":typeof o;
if(t=="object"){
var nl=_5a||prompt("Label (without path):","");
if(!nl){
return;
}
if(nl/1==nl){
nl="$"+nl;
}
nl=this.jsonAlreadyExists(o,nl);
var n=nl.replace(/\w/g,"")===""?l+"."+nl:l+"[\""+nl+"\"]";
eval("this."+n+"={}");
if(_5b){
eval("var t=this."+this.jsonEscapeLabel(l)+";this."+this.jsonEscapeLabel(l)+"={};var s=this."+l);
eval("this."+n+"={}");
for(var i in t){
s[i]=t[i];
}
}
}
if(t=="array"){
o.push({});
n=l+"["+(o.length-1)+"]";
if(_5b){
for(var i=o.length-1;i>0;i--){
o[i]=o[i-1];
}
o[0]={};
n=l+"[0]";
}
}
this.JSONbuild(this.baseDiv,this.json);
for(var i in this.stateMem){
this.openAndClose(i,true);
}
this.jsonResponder(n);
},jsonAddSibling:function(f,_62){
var _63=f.jbefore.checked;
var l=f.orgjlabel.value;
var r=Math.random();
eval("var temp=this."+this.jsonEscapeLabel(l));
eval("this."+this.jsonEscapeLabel(l)+"=r");
var s=this.JSONstring.make(this.json);
s=s.split(r+",");
if(s.length<2){
s=s[0].split(r);
}
var lp=this.jsonParent(l);
eval("var o=this."+this.jsonEscapeLabel(lp));
var t=(o&&this.isArray(o))?"array":typeof o;
if(t=="object"){
var nl=_62||prompt("Label (without path):","");
if(!nl){
return;
}
if(nl/1==nl){
nl="$"+nl;
}
nl=this.jsonAlreadyExists(o,nl);
var n=nl.replace(/\w/g,"")===""?"."+nl:"[\""+nl+"\"]";
s=s.join("null,\""+nl+"\":{},");
lp+=n;
}
if(t=="array"){
s=s.join("null,{},");
var k=l.split("[");
k[k.length-1]=(k[k.length-1].split("]").join("")/1+1)+"]";
lp=k.join("[");
}
s=s.split("},}").join("}}");
eval("this.json="+this.jsonEscapeText(s));
eval("this."+this.jsonEscapeLabel(l)+"=temp");
if(_63){
lp=this.jsonSwitchPlace(this.jsonParent(l),l,lp);
}
this.JSONbuild(this.baseDiv,this.json);
for(var i in this.stateMem){
this.openAndClose(i,true);
}
this.jsonResponder(lp);
},jSaveFirst:function(f,a){
var l=f.orgjlabel.value;
eval("var orgj=this."+this.jsonEscapeLabel(l));
orgj=this.JSONstring.make(orgj);
var v=f.jvalue.value;
v=f.jtype.value=="string"?this.JSONstring.make(v):v;
v=v.split("\r").join("");
if(orgj!=v||f.orgjlabel.value!=f.jlabel.value||this.jTypeChanged){
var k=confirm("Save before "+a+"?");
if(k){
this.jsonChange(f);
}
}
},jsonRename:function(f){
this.jSaveFirst(f,"renaming");
var _73=l=f.orgjlabel.value;
l=this.jsonChild(l);
var nl=prompt("Label (without path):",l);
if(!nl){
return;
}
this.jsonResponder(_73);
var nl=nl.replace(/\w/g,"")===""?"."+nl:"[\""+nl+"\"]";
f.jlabel.value=this.jsonParent(_73)+nl;
this.jsonChange(f,false,true);
},jsonSwitchPlace:function(p,el1,el2){
var _78=el1,_79=el2;
eval("var o=this."+this.jsonEscapeLabel(p));
if(this.isArray(o)){
eval("var t=this."+el1);
eval("this."+el1+"=this."+el2);
eval("this."+el2+"=t");
return _78;
}
el1=this.jsonChild(el1);
el2=this.jsonChild(el2);
var o2={};
for(var i in o){
if(i==el1){
o2[el2]=o[el2];
o2[el1]=o[el1];
continue;
}
if(i==el2){
continue;
}
o2[i]=o[i];
}
eval("this."+this.jsonEscapeLabel(p)+"=o2");
return _79;
},jsonCut:function(f){
this.jSaveFirst(f,"cutting");
this.jsonCopy(f,true);
this.jsonChange(f,true);
//this.setJsonMessage("Cut to clipboard!");
},jsonCopy:function(f,r){
if(!r){
this.jSaveFirst(f,"copying");
}
var l=f.orgjlabel.value;
eval("var v=this."+this.jsonEscapeLabel(l));
v=this.JSONstring.make(v);
var l=this.jsonChild(l);
this.jClipboard={label:l,jvalue:v};
this.jsonResponder(f.jlabel.value);
if(!r){
this.setJsonMessage("Copied to clipboard!");
}
},jsonPaste:function(f,r){
var t=f.jtype.value;
var _83=t!="object"&&t!="array";
if(!f.jPasteAsChild.checked){
_83=true;
}
if(f.orgjlabel.value=="json"){
_83=false;
}

if(_83){
this.jsonAddSibling(f,this.jClipboard.label);
}else{
this.jsonAddChild(f,this.jClipboard.label);
}
var l=f.orgjlabel.value;

eval("this."+this.jsonEscapeLabel(l)+"="+this.jsonEscapeText(this.jClipboard.jvalue));
this.jsonResponder(l);
this.jsonChange(f);
if(!r){
this.setJsonMessage("Pasted!");
}
},setJsonMessage:function(x){
this.$("jformMessage").innerHTML=x;
setTimeout("treeBuilder.$('jformMessage').innerHTML=''",1500);
},changeJsonDataType:function(x,f){
this.jTypeChanged=true;
var v=f.jvalue.value;
var _89=v;
v=x=="object"?"{\"label\":\""+v+"\"}":v;
v=x=="array"?"[\""+v+"\"]":v;
if(!_89){
v=x=="object"?"{}":v;
v=x=="array"?"[]":v;
}
v=x=="function"?"function(){"+v+"}":v;
v=x=="string"?v:v;
v=x=="number"?v/1:v;
v=x=="boolean"?!!v:v;
v=x=="null"?"null":v;
v=x=="undefined"?"undefined":v;
f.jvalue.value=v;
},jsonChange:function(f,_8b,_8c){
try{
var str=false;
var l=f.jlabel.value;
var _8f=f.orgjlabel.value||"json.not1r2e3a4l";
eval("var cur=this."+this.jsonEscapeLabel(l));
if(l!=_8f&&cur!==undefined){
}
var v=f.jvalue.value.split("\r").join("");
if(f.jtype.value=="string"){
v=this.JSONstring.make(v);
str=true;
}
if(l=="json"){
eval("v="+v);
this.JSONbuild(this.baseDiv,v);
for(var i in this.stateMem){
this.openAndClose(i,true);
}
this.setJsonMessage("Changed!");
return false;
}
eval("var json="+this.jsonEscapeText(this.JSONstring.make(this.json)));
var _92=Math.random();
eval(_8f+"="+_92);
var _93=this.jsonParent(_8f);
var _94=this.jsonParent(_8f)==this.jsonParent(l);
eval("var pa="+_93);
if(this.isArray(pa)){
eval(_93+"=[];var newpa="+_93);
for(var i=0;i<pa.length;i++){
if(pa[i]!=_92){
newpa[i]=pa[i];
}
}
if(_8b){
var pos=l.substring(l.lastIndexOf("[")+1,l.lastIndexOf("]"))/1;
newpa=newpa.splice(pos,1);
}
if(!_8b){
eval(l+"="+v);
}
}else{
eval(_93+"={};var newpa="+_93);
for(var i in pa){
if(pa[i]!=_92){
newpa[i]=pa[i];
}else{
if(_94&&!_8b){
if(str){
eval(l+"=\""+this.jsonEscapeText(v.substring(1,v.length-1))+"\"");
}else{
eval(l+"="+v);
}
}
}
}
if(!_94&&!_8b){
if(str){
eval(l+"=\""+this.jsonEscapeText(v.substring(1,v.length-1))+"\"");
}else{
eval(l+"="+v);
}
}
}
this.json=json;
var _96=this.selectedElement?this.selectedElement.id:null;
this.JSONbuild(this.baseDiv,this.json);
for(var i in this.stateMem){
this.openAndClose(i,true);
}
this.selectedElement=this.$(_96);
if(this.selectedElement&&!_8b&&_8f!="json.not1r2e3a4l"){
this.selectedElement.style.fontWeight="bold";
}
if(_8b){
l="";
}
this.setJsonMessage(_8b?"":_8c?"Renamed!":"Changed!");
if(!_8b){
this.jsonResponder(l);
}
}
catch(err){
alert("Save error!");
}
return false;
},JSONbuild:function(_97,x,y,z){
if(!z){
this.partMem=[];
this.JSONmem=[];
this.json=x;
this.baseDiv=_97;
}
var t=(x&&this.isArray(x))?"array":typeof x;
y=y===undefined?"json":y;
z=z||0;
this.partMem[z]="[\""+y+"\"]";
if(typeof y!="number"&&y.replace(/\w/g,"")===""){
this.partMem[z]="."+y;
}
if(typeof y=="number"){
this.partMem[z]="["+y+"]";
}
if(z===0){
this.partMem[z]="json";
}
this.partMem=this.partMem.slice(0,z+1);
var x2=x;
this.JSONmem.push({type:t,label:y,todo:this.partMem.join(""),level:z+1});
if(t=="object"){
for(var i in x){
this.JSONbuild(false,x[i],i,z+1);
}
}
if(t=="array"){
for(var i=0;i<x.length;i++){
this.JSONbuild(false,x[i],i,z+1);
}
}
if(_97){
this.build(_97,this.jsonResponder,this.JSONmem);
if(!this.hasRunJSONbuildOnce){
this.jsonResponder("json");
}
this.hasRunJSONbuildOnce=true;
}
},build:function(_9e,_9f,_a0){
var d=_a0,n=_9e,$f=this.$,_a4=0,_a5=[],im=this.images;
this.treeBaseDiv=_9e;
if(!d){
var c=$f(_9e).childNodes;
for(var i=0;i<c.length;i++){
if((c[i].tagName+"").toLowerCase()=="pre"){
d=this.preParse(c[i]);
}
}
if(!d){
return;
}
}
$f(n).style.display="none";
while($f(n).firstChild){
$f(n).removeChild($f(n).firstChild);
}
for(var i=0;i<d.length;i++){
if(d[i].level&&!_a4){
_a4=d[i].level;
}
if(d[i].level&&d[i].level>_a4){
_a5.push(n);
n=d[i-1].id;
}
if(d[i].level&&d[i].level>_a4+1){
return "Trying to jump levels!";
}
if(d[i].level&&d[i].level<_a4){
for(var j=d[i].level;j<_a4;j++){
n=_a5.pop();
}
}
if(!d[i].id){
d[i].id=n+"_"+i;
}
if(!d[i].pid){
d[i].pid=n;
}
_a4=d[i].level;
var a=document.createElement("div");
var t=document.createElement("span");
t.style.verticalAlign="middle";
if(i==0){
t.style.fontStyle="italic";
}
if((_a4==4&&d[i].label=="id")||(_a4==5&&d[i].label=="type")){
t.style.color="#aaaaaa";
t.style.fontStyle="italic";
}
a.style.whiteSpace="nowrap";
var t2=document.createTextNode(i==0?"QwikPost":d[i].label);
t.appendChild(t2);
a.style.paddingLeft=d[i].pid==_9e?"0px":im.nodeWidth+"px";
a.style.cursor="pointer";
a.style.display=(d[i].pid==_9e)?"":"none";
a.id=d[i].id;
a.t=t;
var f=function(){
var _ae=d[i].todo;
var _af=_9f;
a.onclick=function(e){
if(treeBuilder.maniClick=="giveItBack"){
return _ae;
}
if(treeBuilder.selectedElement){
treeBuilder.selectedElement.style.fontWeight="";
}
this.style.fontWeight="bold";
treeBuilder.selectedElement=this;
if(treeBuilder.maniClick=="selectIt"){
return;
}
_af(_ae);
if(!e){
e=window.event;
}
e.cancelBubble=true;
if(e.stopPropagation){
e.stopPropagation();
}
};
a.onmouseover=function(e){
if(!e){
e=window.event;
}
e.cancelBubble=true;
if(e.stopPropagation){
e.stopPropagation();
}
};
a.onmouseout=function(e){
if(!e){
e=window.event;
}
e.cancelBubble=true;
if(e.stopPropagation){
e.stopPropagation();
}
};
};
f();
$f(d[i].pid).appendChild(a);
if(d[i].pid==_9e&&!a.previousSibling){
a.first=true;
}
}
for(var i=0;i<d.length;i++){
var x=$f(d[i].id);
if(x&&x.style.display!="none"){
this.setElementLook(x);
}
}
$f(_9e).style.display="";
},setElementLook:function(m){
var $f=this.$,im=this.images;
if(!m.inited){
var co=0;
for(var j in im){
if(!Object.prototype[j]){
if(j=="vertLine"){
break;
}
var img=document.createElement("img");
var k=(m.first&&j.indexOf("Node")>=0)?j+"First":j;
img.src=im.path+(im[k]?im[k]:k+".gif");
img.style.display="none";
img.style.verticalAlign="middle";
img.id=m.id+"_"+j;
if(j.indexOf("folderNode")==0){
img.onclick=function(e){
treeBuilder.openAndClose(this);
if(!e){
e=window.event;
}
e.cancelBubble=true;
if(e.stopPropagation){
e.stopPropagation();
}
};
}
if(m.firstChild){
m.insertBefore(img,m.childNodes[co]);
co++;
}else{
m.appendChild(img);
}
}
}
m.insertBefore(m.t,m.childNodes[co]);
m.inited=true;
}
var _bc=m.childNodes[m.childNodes.length-1];
var _bd=(_bc.tagName+"").toLowerCase()=="div";
var _be=!m.nextSibling;
var _bf=_bd&&_bc.style.display!="none";
$f(m.id+"_folder").style.display=!_bf&&_bd?"":"none";
$f(m.id+"_folderOpen").style.display=_bf&&_bd?"":"none";
$f(m.id+"_doc").style.display=_bd?"none":"";
$f(m.id+"_docNode").style.display=_bd||_be?"none":"";
$f(m.id+"_docNodeLast").style.display=_bd||!_be?"none":"";
$f(m.id+"_folderNode").style.display=_bf||!_bd||_be?"none":"";
$f(m.id+"_folderNodeLast").style.display=_bf||!_bd||!_be?"none":"";
$f(m.id+"_folderNodeOpen").style.display=!_bf||!_bd||_be?"none":"";
$f(m.id+"_folderNodeOpenLast").style.display=!_bf||!_bd||!_be?"none":"";
var p=m.parentNode.nextSibling;
if(p&&p.id){
var sp=p;
insideBase=false;
while(sp){
if(sp==$f(this.treeBaseDiv)){
insideBase=true;
}
sp=sp.parentNode;
}
if(!insideBase){
return;
}
var bg=im.path+(im.vertLine?im.vertLine:"vertLine.gif");
m.style.backgroundImage="url("+bg+")";
m.style.backgroundRepeat="repeat-y";
}
},openAndClose:function(x,_c4){
var o,div=_c4?this.$(x):x.parentNode;
if(!div){
return;
}
if(_c4){
o=this.stateMem[div.id];
}else{
o=x.id.indexOf("Open")<0;
}
if(_c4=="open"){
o=true;
}
this.stateMem[div.id]=o;
var c=div.childNodes;
for(var i=0;i<c.length;i++){
if(c[i].tagName.toLowerCase()!="div"){
continue;
}
c[i].style.display=o?"":"none";
if(o&&!c[i].inited){
this.setElementLook(c[i]);
}
}
this.setElementLook(div);
}};
JSONeditor.treeBuilder.JSONstring={compactOutput:false,includeProtos:false,includeFunctions:true,detectCirculars:false,restoreCirculars:false,make:function(arg,_ca){
this.restore=_ca;
this.mem=[];
this.pathMem=[];
return this.toJsonStringArray(arg).join("");
},toObject:function(x){
eval("this.myObj="+x);
if(!this.restoreCirculars||!alert){
return this.myObj;
}
this.restoreCode=[];
this.make(this.myObj,true);
var r=this.restoreCode.join(";")+";";
eval("r=r.replace(/\\W([0-9]{1,})(\\W)/g,\"[$1]$2\").replace(/\\.\\;/g,\";\")");
eval(r);
return this.myObj;
},toJsonStringArray:function(arg,out){
if(!out){
this.path=[];
}
out=out||[];
var u;
switch(typeof arg){
case "object":
this.lastObj=arg;
if(this.detectCirculars){
var m=this.mem;
var n=this.pathMem;
for(var i=0;i<m.length;i++){
if(arg===m[i]){
out.push("\"JSONcircRef:"+n[i]+"\"");
return out;
}
}
m.push(arg);
n.push(this.path.join("."));
}
if(arg){
if(arg.constructor==Array){
out.push("[");
for(var i=0;i<arg.length;++i){
this.path.push(i);
if(i>0){
out.push(",\n");
}
this.toJsonStringArray(arg[i],out);
this.path.pop();
}
out.push("]");
return out;
}else{
if(typeof arg.toString!="undefined"){
out.push("{");
var _d3=true;
for(var i in arg){
if(!this.includeProtos&&arg[i]===arg.constructor.prototype[i]){
continue;
}
this.path.push(i);
var _d4=out.length;
if(!_d3){
out.push(this.compactOutput?",":",\n");
}
this.toJsonStringArray(i,out);
out.push(":");
this.toJsonStringArray(arg[i],out);
if(out[out.length-1]==u){
out.splice(_d4,out.length-_d4);
}else{
_d3=false;
}
this.path.pop();
}
out.push("}");
return out;
}
}
return out;
}
out.push("null");
return out;
case "unknown":
case "undefined":
case "function":
try{
eval("var a="+arg);
}
catch(e){
arg="function(){alert(\"Could not convert the real function to JSON, due to a browser bug only found in Safari. Let us hope it will get fixed in future versions of Safari!\")}";
}
out.push(this.includeFunctions?arg:u);
return out;
case "string":
if(this.restore&&arg.indexOf("JSONcircRef:")==0){
this.restoreCode.push("this.myObj."+this.path.join(".")+"="+arg.split("JSONcircRef:").join("this.myObj."));
}
out.push("\"");
var a=["\n","\\n","\r","\\r","\"","\\\""];
arg+="";
for(var i=0;i<6;i+=2){
arg=arg.split(a[i]).join(a[i+1]);
}
out.push(arg);
out.push("\"");
return out;
default:
out.push(String(arg));
return out;
}
}};

