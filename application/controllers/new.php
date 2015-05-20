<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="css/install.css"/>
<link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
<link href="css/bootstrap.min.css" rel="stylesheet">

<script src="js/bootstrap.js" ></script>

</head>

<body>
<div class="container">
	<div class="row">
    	<div class="well" style="position: relative">
        	<div calss="intall_logo">
            	<img src="image/opixlogo3.png" />
          </div>
          
          <h4>Step.1 Please enter the database information </h4>
          </br>
         <form class="form-horizontal" role="form">
  			<div class="form-group">
    <label for="database_host" class="col-sm-2 control-label">Database host</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" name="database_host" id="database_host" placeholder="localhost"/>
    </div>
        <span class="install_text_warning">*</span>
        You should be able to get this info from your web host
  </div>
  
  <div class="form-group">
    <label for="port" class="col-sm-2 control-label">Port</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" name="port" id="port" placeholder="3306"/>
    </div>
    	<span class="install_text_warning">*</span>
        	e.g. localhost:3306
  </div>
  
  <div class="form-group">
    <label for="database_name" class="col-sm-2 control-label">Database name</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" name="database_name" id="database_name" placeholder="opixproject"/>
    </div>
    	<span class="install_text_warning">*</span>
        	The name of the database you want to run OpixManager in
  </div>
  
  <div class="form-group">
    <label for="database_user_name" class="col-sm-2 control-label">User name</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" name="database_user_name" id="database_user_name" placeholder="root"/>
    </div>
    	<span class="install_text_warning">*</span>
        	e.g.root
  </div>
  
  <div class="form-group">
    <label for="password" class="col-sm-2 control-label">Password</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" name="password" id="password" placeholder="password"/>
    </div>
        	Your MySQL password
  </div>
  
  <div class="form-group">
    <label for="table_prefi" class="col-sm-2 control-label">Table prefi</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" name="table_prefi" id="table_prefi" placeholder="opix_"/>
    </div>
        	Table Prefix
  </div>  

  
</form>
      
      
                  

      </div>
            
  </div>
    </div>
</body>
</html>
