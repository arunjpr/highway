jQuery(function(){
    //Keep track of last scroll
    var lastScroll = 0;
    jQuery(window).scroll(function(event){
        //Sets the current scroll position
        var st = jQuery(this).scrollTop();

        //Determines up-or-down scrolling
        if (st > lastScroll){
            jQuery(".footer").addClass('footer-fixed');
            jQuery(".footer").removeClass('footer-fixed-top');
        } 
        if(st == 0){
          jQuery(".footer").removeClass('footer-fixed');
          jQuery(".footer").addClass('footer-fixed-top');
        }
        //Updates scroll position
        lastScroll = st;
    });
});
function fetchClose(){
    jQuery("#short-info").hide();
}
function fetchShortProfile(id){
    jQuery.ajax({ 
        url: '/user/user-short-info/ajax/1/id/'+id,
        success: function(rawdata) {
            //console.log(rawdata);
            jQuery("#short-info").html(rawdata);
            jQuery("#short-info").show();            
        }
    });
}
function dullShortProfile(id){
    console.log(id);
}
function checkLockedEdit(type,id,user,is_lock,locktime){
    var typeText="";
    switch(type){
        case "1":
            typeText="Qualification";
        break;
        case "2":
            typeText="Subject";
        break;
        case "3":
            typeText="Wil";
        break;
        case "9":
            typeText="Outcome";
        break;
        case "10":
            typeText="Wil Assessment";
        break;
        case "8":
            typeText="Wil Assessment Criteria";
        break;        
        case "5":
            typeText="Activity";
        break;
        case "6":
            typeText="Question";
        break;
        case "7":
            typeText="Activity Outcome";
        break;
        
        case "10":
            typeText="Activity Assessment Criteria";
        break;
    }
    jQuery.ajax({ 
        url: '/setup/checklock/ajax/2/type/'+type+'/id/'+id+'/user/'+user+"/is_lock/"+is_lock,
        dataType: 'json',
        success: function(rawdata) {
            if(is_lock=="false"){
                if(rawdata.locked == "1"){
                    jQuery("#lock_text").html("This "+typeText+" is locked by "+rawdata.username+" for editing. Reload to check lock. Lock time is of "+locktime);
                    jQuery("#lock_text").show();
                    jQuery('#disable-button').show();
                    jQuery('#enable-button').hide();
                }
            }
            else{
                if(rawdata.locked == "1"){
                    jQuery("#lock_text").html("This "+typeText+" is locked by "+rawdata.username+" for editing. Reload to check lock. Lock time is of "+locktime);
                }
            }
        }
    });	
    setTimeout("checkLockedEdit('"+type+"','"+id+"','"+user+"','"+is_lock+"')",30000);
}
function enableEditor(){
    jQuery("#editPart").show();
    jQuery("#viewPart").hide();
}
function disableEditor(){
    jQuery("#editPart").hide();
    jQuery("#viewPart").show();
}
/*
function onlyAlpha(value, element, params) { 
    if(value.match(/^[abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ \s]*$/)){
        return true;
    }else{
        return false;
    }
}
function alphaNumeric(value, element, params) { 
    if(value.match(/^[abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789\s]*$/)){
        return true;
    }else{
        return false;
    }
}
function alphaNumericWithSpace(value, element, params) { 
    if(value.match(/^[abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789 \s]*$/)){
        return true;
    }else{
        return false;
    }
}
*/
function alphanumeric(alphane) {
    var numaric = alphane;
    for(var j=0; j<numaric.length; j++) {
        var alphaa = numaric.charAt(j);
        var hh = alphaa.charCodeAt(0);
        if((hh > 47 && hh<59) || (hh > 64 && hh<91) || (hh > 96 && hh<123)){
        } else {
            return false;
        }
    }
    return true;
}

function spaceBar(alphane) {
    var numaric = alphane;
    for(var j=0; j<numaric.length; j++) {
        var alphaa = numaric.charAt(j);
        var hh = alphaa.charCodeAt(0);
        if((hh==32)){
            return false;
        } else {
        }
    }
    return true;
}

function alphanumericwithspace(alphane) {
    var numaric = alphane;
    for(var j=0; j<numaric.length; j++) {
        var alphaa = numaric.charAt(j);
        var hh = alphaa.charCodeAt(0);
        if((hh > 47 && hh<59) || (hh > 64 && hh<91) || (hh > 96 && hh<123) || hh==32 || hh==38 || hh==39 || hh==43 || hh==44 || hh==45 || hh==46 || hh==95){
        } else {
            return false;
        }
    }
    return true;
}
function numeric(alphane) {
    var numaric = alphane;
    for(var j=0; j<numaric.length; j++) {
        var alphaa = numaric.charAt(j);
        var hh = alphaa.charCodeAt(0);
        if((hh > 47 && hh<59)){
        } else {
            return false;
        }
    }
    return true;
}
function numericwithdot(alphane) {
    var numaric = alphane;
    for(var j=0; j<numaric.length; j++) {
        var alphaa = numaric.charAt(j);
        var hh = alphaa.charCodeAt(0);
        if((hh > 47 && hh<59) || hh==46 ){
        } else {
            return false;
        }
    }
    return true;
}
function hideAction(cnt){
    if(cnt=='0'){
        jQuery("#frm_grid_action").hide();
    }
}
function checkHtml(value) { 
    if(value.match(/([\<])([^\>]{1,})*([\>])/i)==null){
        return true;
    }else{
        return false;
    }
}
function confirmFirst(text){
    var r = confirm("Are you sure you want to "+text+" ? !");
    if (r == true) {
        return true;
    } else {
        return false;
    }
}
function showCitiesByProvince(province_id,city_id,suburb_id){
    jQuery.ajax({ 
        url:  '/guest/populate-city/pid/'+province_id+'/cid/'+city_id+'/sid/'+suburb_id+'/ajax/2',
        success: function(data) {
            jQuery('#city_container').html(data);
            showSuburbsByCity(city_id,suburb_id);
        },
       timeout : 600000
    });
}
function showSuburbsByCity(city_id,suburb_id){
    jQuery.ajax({ 
        url:  '/guest/populate-suburb/cid/'+city_id+'/sid/'+suburb_id+'/ajax/2',
        success: function(data) {
            jQuery('#suburb_container').html(data);
        },
       timeout : 600000
   });
}