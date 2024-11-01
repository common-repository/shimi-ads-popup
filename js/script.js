
var jshimi = jQuery.noConflict();

//kiem tra browser cho dung cookie khong
function checkBrowserEnableCookie(){
var cookieEnabled = (navigator.cookieEnabled)? true : false

//if not IE4+ nor NS6+
if (typeof navigator.cookieEnabled=="undefined" &&!cookieEnabled){
document.cookie = "testcookie"
cookieEnabled = (document.cookie.indexOf("testcookie")!=-1)? true : false
}

if (cookieEnabled) return true;
else return false;
}

//tao cookie
function createCookie(name, value, days) {
if (days) {
var date = new Date();
date.setTime(date.getTime()+(days*24*60*60*1000));
var expires = "; expires="+date.toGMTString();
}
else var expires = "";
document.cookie = name+"="+value+expires+"; path=/";
}

//doc cookie
function readCookie(name) {
var nameEQ = name + "=";
var ca = document.cookie.split(';');
for(var i = 0;
i < ca.length;
i++) {
var c = ca[i];
while (c.charAt(0)==' ') c = c.substring(1, c.length);
if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
}
return "";
}

//xoa bo cookie
function eraseCookie(name) {
createCookie(name, "", -1);
}

/* * ************************ */
//@Author: Adrian "yEnS" Mato Gondelle
//@website: www.yensdesign.com
//@email: yensamg@gmail.com
//@license: Feel free to use it, but keep this credits please!                    
/* * ************************ */

//SETTING UP OUR POPUP
//0 means disabled; 1 means enabled;
var popupStatus = 0;

//loading popup with jQuery magic!
function loadPopup(){

//loads popup only if it is disabled
if(popupStatus==0){
jshimi("#backgroundPopup").css({
"opacity": "0.8"
});
jshimi("#backgroundPopup").fadeIn("slow");
jshimi("#popupContact").fadeIn("slow");
popupStatus = 1;
}
}

//disabling popup with jQuery magic!
function disablePopup(){
//disables popup only if it is enabled
if(popupStatus==1){
jshimi("#backgroundPopup").fadeOut("slow");
jshimi("#popupContact").fadeOut("slow");
popupStatus = 0;
}
}

//centering popup
function centerPopup(){
//request data for centering
var windowWidth = document.documentElement.clientWidth;
var windowHeight = document.documentElement.clientHeight;
var popupHeight = jshimi("#popupContact").height();
var popupWidth = jshimi("#popupContact").width();
//centering
jshimi("#popupContact").css({
"position": "absolute",
 "top": "100px", // windowHeight/2-popupHeight/2,
"left": (windowWidth/2)-(popupWidth/2)
});
//only need force for IE6

jshimi("#backgroundPopup").css({
"height": windowHeight
});

}


//CONTROLLING EVENTS IN jQuery
jshimi(document).ready(function(){

//LOADING POPUP
//centering with css
centerPopup();
//load popup
loadPopup();
//Click the button event!
jshimi("#button").click(function(){
//centering with css
centerPopup();
//load popup
loadPopup();
});

//CLOSING POPUP
//Click the x event!
jshimi("#popupContactClose").click(function(){
disablePopup();
});
//Click out event!
jshimi("#backgroundPopup").click(function(){
//disablePopup();
});
//Press Escape event!
jshimi(document).keyup(function(e){
if(e.keyCode==27 && popupStatus==1){
disablePopup();
}
});

});
