
<link rel="stylesheet" href="<?php echo $baseUrl;?>/css/xts.base.css" type="text/css" />
<script type="text/javascript" src="<?php echo $baseUrl;?>/js/grid/xtscore.js"></script>
<script type="text/javascript" src="<?php echo $baseUrl;?>/js/grid/xtsvalidator.js"></script>
<script type="text/javascript" src="<?php echo $baseUrl;?>/js/jquery.validate.js"></script>
<script type="text/javascript">
var eI=" &nbsp;<i class='fa fa-times-circle-o redE'></i>";
var sI=" &nbsp;<i class='fa fa-check-circle-o blue'></i>";
jQuery.validator.setDefaults({
    //debug: true,
    errorClass: "invalid",
    errorElement:"span",
    invalidHandler: function(form, validator) {
        jQuery('#disable-button').hide();
        jQuery('#enable-button').show();
        var errors = validator.numberOfInvalids();
        if (errors) {
            var message = errors == 1
                ? 'You missed 1 field. It has been highlighted'
                : 'You missed ' + errors + ' fields. They have been highlighted';
            //$("#errDivId").html(message);
            //$("#errDivId").show();
        } else {
            //$("#errDivId").hide();
        }
    },
    errorPlacement: function(error, element) {
        if ( element.is(":radio") ){
            //error.appendTo( element.parent().next() );
            if(element.hasClass("radio_xtsgrid")){
                var radioClassesString = element.attr("class") ;
                var radioClasses = radioClassesString.split(" ");
                for(var rc =0; rc<(radioClasses.length);rc++){
                    var current_class = radioClasses[rc];
                    var rescheck = current_class.substring(0,5); 
                    var res = current_class.substring(5); 
                    if(rescheck=="link_"){
                        var gridelem = jQuery("#"+res+"_error");
                        //console.log(gridelem);
                        //console.log(res);                        
                        error.appendTo ( gridelem );
                    }
                }
            }
            else {
                error.appendTo ( element.next() );
            }            
        }
        else if ( element.is(":checkbox") ){
            if(element.hasClass("checkbox_xtsgrid")){
                var radioClassesString = element.attr("class") ;
                var radioClasses = radioClassesString.split(" ");
                for(var rc =0; rc<(radioClasses.length);rc++){
                    var current_class = radioClasses[rc];
                    var rescheck = current_class.substring(0,5); 
                    var res = current_class.substring(5); 
                    if(rescheck=="link_"){
                        var gridelem = jQuery("#"+res+"_error");
                        error.appendTo ( gridelem );
                    }
                }
            }
            else {
                error.appendTo ( element.next() );
            }
        }
        else if ( element.is("textarea") ){
            if(element.hasClass("teditor")){
                jQuery("#"+element.attr("id")+"_editor_error").html(error);
            }
            else {
                error.appendTo(element.parent());
            }
        }
        else {
            if(element.hasClass("dateCombo")){
                var inputClassesString = element.attr("class") ;
                var inputClasses = inputClassesString.split(" ");
                for(var ic =0; ic<(inputClasses.length);ic++){
                    var current_class = inputClasses[ic];
                    var iescheck = current_class.substring(0,6); 
                    var ies = current_class.substring(6);
                    if(iescheck=="input_"){
                        var gridelem = jQuery("#"+ies+"_error").html(error);
                    }
                }
            }
            else {
                error.appendTo(element.parent());
            }
        }
    }, 
    success: function(label) { 
        label.html(sI); 
    } 
});
jQuery.validator.addMethod("alphanumeric", alphanumeric);
jQuery.validator.addMethod("alphanumericwithspace", alphanumericwithspace);
jQuery.validator.addMethod("htmltags", checkHtml);
jQuery.validator.addMethod("expireCheck", expireCheck);
jQuery.validator.addMethod("startendCheck", startendCheck);
jQuery.validator.addMethod("customOptionalGroup", customOptionalGroup);
jQuery.validator.addMethod("checkSubjects", checkSubjects);
jQuery.validator.addMethod("checkqualexits", CheckUniqueQualification);
jQuery.validator.addMethod("checkeditqualexits", CheckEditQualification);
jQuery.validator.addMethod("checkemailexits", CheckUniqueEmail);
jQuery.validator.addMethod("checkphoneexits", CheckUniquePhone);
jQuery.validator.addMethod("checkeditphoneexits", CheckEditPhone);
jQuery.validator.addMethod("checksubjectexits", CheckUniqueSubject);
function checkSubjects(){
    var validation_subject = false;
    var selectedVal = "";
    var checkedCounter = 0;
    var checkedCCounter =0;
    var groups = jQuery("#nogroup").val();
    var min_e_sub = groups*2;
    var selected = jQuery("input[type='radio'][name='wilreadytype']:checked");
    if (selected.length > 0) {
        selectedVal = selected.val();
    }
    if(selectedVal=="1"){
        var nor = jQuery("#nor").val();
        var mansub = '';
        var optsub = '';
        for (var i=0; i < nor; i++){	
            var rdidm = "#subject_m_"+i;
            var rdido = "#subject_o_"+i;
            //console.log(jQuery(rdidm).is(':checked'));
            //console.log(jQuery(rdido).is(':checked'));
            
            if(jQuery(rdidm).is(':checked') == true ){
                checkedCCounter = checkedCCounter+1;
                mansub += jQuery(rdidm).val()+",";
            }
            if(jQuery(rdido).is(':checked') == true){
                checkedCounter = checkedCounter+1;
                optsub += jQuery(rdido).val()+",";
            }
        }
        jQuery("#man_sub").attr('value',mansub);
        jQuery("#opt_sub").attr('value',optsub);
    }
    if(min_e_sub<=checkedCounter){
        validation_subject = true;
    }
    if(min_e_sub==0){
        if(checkedCCounter>0){
            validation_subject = true;
        }
        else {
            validation_subject = false;
        }
    }
    return validation_subject;
}
function customOptionalGroup(value, element) {
    var checkClassesString = jQuery(element).attr("class");
    var checkClasses = checkClassesString.split(" ");
    var counter = 0;
    for(var rc =0; rc<(checkClasses.length);rc++){
        var current_class = checkClasses[rc];
        //checkbox_xtsgrid link_xtsgrid1 1
        var rescheck = current_class.substring(0,14);
        if(rescheck=="subject_group_"){
            counter = current_class.substring(14);
        }
    }
    var checkedCounter = 0;
    var min = jQuery("#nosubject"+counter).val();
    if(min==0 || min ==""){
        min = 1;
    }
    var allSubjects = jQuery(".subject_group_"+counter).length;
    var checkedSubjects = jQuery(".subject_group_"+counter+":checked").length;
     if(checkedSubjects>min){
        return true;
    }
    else {
        return false;
    }
}
function expireCheck(value, element) { 
    var year = jQuery('#start_year').val();
    var month = jQuery('#start_month').val();
    var day = jQuery('#start_day').val();		
    var curdate = '<?php echo date("Y-m-d");?>';
    var smallDateArr      = curdate.split("-");
    var SmallDate = new Date(smallDateArr[0]+'/'+smallDateArr[1]+'/'+smallDateArr[2]);
    var LargeDate = new Date(year+'/'+month+'/'+day);
    console.log(smallDateArr + "---"+LargeDate);
    if(SmallDate > LargeDate){
            //alert(LargeDate);
            //$("#errdate").html('<span htmlfor="duration" generated="true" class="error"> <img border="0" class="verticalMidleImg" src="/wil/public/img/redIcon.gif"><br> Expire date can not be past date.</span>');
        return false;
    }
    else{
        return true;
    }
}
function startendCheck(value, element) { 
    var start_year = jQuery('#start_year').val();
    var start_month = jQuery('#start_month').val();
    var start_day = jQuery('#start_day').val();
    var end_year = jQuery('#end_year').val();
    var end_month = jQuery('#end_month').val();
    var end_day = jQuery('#end_day').val();
    var SmallDate = new Date(start_year+'/'+start_month+'/'+start_day);
    var LargeDate = new Date(end_year+'/'+end_month+'/'+end_day);
    if(SmallDate > LargeDate){
        return false;
    }
    else{
        return true;
    }
}
Array.prototype.in_array = function(p_val) {
    for(var i = 0, l = this.length; i < l; i++) {
        if(this[i] == p_val) {
            return true;
        }
    }
    return false;
}
var month31=[1,3,5,7,8,10,12];
var month30=[4,6,9,11];
var month28=[2];
function ChangeDay(month){
    var r31=month31.in_array(month)
    var r30=month30.in_array(month)
    var r28=month28.in_array(month)
    year=document.getElementById('year').value;
    if(r31){
        ChangeOpts(31);
    }
    else if(r30){
        ChangeOpts(30);
    }
    else if(r28){
        if(year!=''){
            year=parseInt(year);
            if(year%4==0){
                ChangeOpts(29);
            }
            else{
                ChangeOpts(28);
            }
        }
        else{
            ChangeOpts(28);
        }	
    }
    else{
        ChangeOpts(31);
    }
}
function ChangeDayyear(year){            
    var month =document.getElementById('month').value;
    var r31=month31.in_array(month)
    var r30=month30.in_array(month)
    if(year!=''){
	var year =parseInt(year);
        if(year%4==0 && month=='2'){
            ChangeOpts(29);
        }
        else if(year%4 !=0 && month=='2'){
            ChangeOpts(28);
        }
        else if(r31) {
            ChangeOpts(31);
        }
        else if(r30){
            ChangeOpts(30);
        }
    }
    else{
            ChangeOpts(28);
    }
}
function ChangeOpts(days){
    var day=document.getElementById('day');
    var olen=day.options.length;
    if(olen > days ){
        for(i=olen-1;i>days;i--){
            day.remove(i);
        }
    }
    if(olen <= days){
        for(i=olen;i<=days;i++){
            var option = document.createElement('option');
            option.setAttribute('value',i);
            option.appendChild(document.createTextNode(i));
            day.appendChild(option);
        }
    }
}
</script>