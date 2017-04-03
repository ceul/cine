<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="amartinez" >
    <link rel="shortcut icon" href="favicon.png">

    <title>Gestion de Sillas</title>

    <link rel="stylesheet" type="text/css" href="dist/css/dt/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="dist/css/dt/DT_bootstrap.css">
	 
    <script type="text/javascript" charset="utf-8" language="javascript" src="dist/js/dt/jquery.js"></script>
    <script type="text/javascript" charset="utf-8" language="javascript" src="dist/js/dt/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf-8" language="javascript" src="dist/js/dt/DT_bootstrap.js"></script>
    <script src="dist/js/bootstrap.min.js"></script>
    <script src="dist/js/bootbox.js"></script>	 
	 
    <script type="text/javascript">
      function elimina(id){
			$.ajax({
			    type: "POST",
			    url: "controllers/eSilla.php",
			    data: "id="+id,
			    success: function(html){
			    if(html=='1'){
			    	bootbox.alert("Fue eliminado correctamente", function() {
                		document.location="iSilla.php";
                	        });
			    }
			    else{
			    	bootbox.alert("No fue eliminado, verifique", function() {
	               });
					 }
			    },
			    beforeSend:function(){
				 	$("#add_err").html("Loading...")
			    }
			});
    	}
    	
	function edit(id,color,fila,columna,sala){
		document.getElementById("codigo").value=id;
		document.getElementById("color").value=color;
                document.getElementById("fila").value=fila;
		document.getElementById("columna").value=columna;
		document.getElementById("sala").value=sala;
    	}
    	
	   $(document).ready(function(){
alert("aqui");
		$("#ingresar").click(function(){ 
			codigo=$("#codigo").val();
			sala=$("#sala").val();
			color=$("#color").val();
                        fila=$("#fila").val();
			columna=$("#columna").val();
			
			 $.ajax({
			    type: "POST",
			    url: "controllers/iSilla.php",
			    data: "codigo="+codigo+"&color="+color+"&fila="+fila+"&columna="+columna+"&sala="+sala,
			    success: function(html){ 
alert("  ->"+html+" res");
			    if(html=='1'){
			    	bootbox.alert("Fue registrado correctamente", function() {
				document.location="iSilla.php";
				});
			    }
			    else{
				if(html=='2'){
				    	bootbox.alert("El registro fue modificado con éxito", function() {
				    	document.location="iSilla.php";
		        	 	});
				 }
				 else{
					if(html=='-1'){
				    		bootbox.alert("No fue procesado, verifique, lio en el SQL", function() {
		        	 	});
			         	}
					else{
						bootbox.alert("No se que ptas paso"+html, function() {
				       		});
				 	}
				 }
			    }
			    },
			    beforeSend:function(){
				 	$("#add_err").html("Loading...");
			    }
			});
			return false;
		   });
		});
  </script>
  
  </head>

  <body>
  <form class="form-horizontal" role="form">
  <h3>Actividades</h3>
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Código</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="codigo" placeholder="Código del estado" required />
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">Color</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="color" placeholder="Nombre del estado" required />
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">Fila</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="fila" placeholder="Descripcion del estado" required />
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">Columna</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="columna" placeholder="Descripcion del estado" required />
    </div>
  </div>
<div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">Sala</label>
    <div class="col-sm-10">
      <?php
	ini_set('display_errors', 'on');
	include_once("models/class.silla.php");
	$obj = new silla;
	$obj->getCombo();
      ?>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button id="ingresar" type="submit" class="btn">Guardar</button>
    </div>
  </div>
</form>
<?php
	$obj = new silla;
	$obj->getTabla();
?>
  </body>
</html>
