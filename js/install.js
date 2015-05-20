$(document).ready(function(){
    
    if($('#install_envrionment').find('.has-error').length){
                $("#enviroment_submit").removeAttr("onclick");
              
        }
    
    $("#enviroment_submit" ).click(function() {
        if($('#install_envrionment').find('.has-error').length){
                $('#install_envrionment').effect("shake"); 
        } 
    }); 
    
    $("#check_database" ).click(function() {

                $('#envrionment').effect("shake"); 
         
    }); 
    
    $("#refresh_envrionment").click(function(){
        $.ajax({
            url:js_base_url+ "index.php/install/environment",
            dataType:"html",
            cache: false
            
        }).done(function (html){
            
          $("body").html(html);
            
        })
        
    });
    
    $("#check_database").click(function(){
        var checkDb=checkDbContent();
        if(checkDb){
        var dbhost = $("#txt_database_host").val();
	var dbname = $("#txt_database_name").val();
	var dbuser = $("#txt_database_user_name").val();
	var dbpwd = $("#txt_password").val();
        
       
        $.ajax({
            url:js_base_url+ "index.php/install/check_database",
            data:{
                dbhost:dbhost,
                dbname:dbname,
                dbuser:dbuser,
                dbpwd:dbpwd
            },
            dataType:"json",
            success:function(res){
                if(res["code"]==1){
                     $("#step1").css('display','none');
                     $("#step2").removeAttr("style");
                     
                }else{
                    $("#step1").css('display','none');
                    $("#step3").removeAttr("style");
                }
            }
                });}
        })
        
     function checkDbContent(){
        var isOk=true;
        
        var dbhost = $("#txt_database_host").val();
	var dbname = $("#txt_database_name").val();
	var dbuser = $("#txt_database_user_name").val();
        
        if(dbhost==""){
            $("#txt_database_host").addClass("install_error");
            isOk=false;
            }else{
            $("#txt_database_host").removeClass("install_error");
		}  
                
        if(dbname==""){
            $("#txt_database_name").addClass("install_error");
            isOk=false;
        }else{
            $("#txt_database_name").removeClass("install_error");
        }
        
        if(dbuser==""){
            $("#txt_database_user_name").addClass("install_error");
            isOk=false;
        }else{
            $("#txt_database_user_name").removeClass("install_error");
        } 
            
        return isOk;     
     }
     
     $("#try_install_again" ).click(function() {
            $("#step1").css('display','initial');
            $("#step2").css('display','none');
            $("#step3").css('display','none');
         
        });
        
     
});

