<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="amartinez" >
    <link rel="shortcut icon" href="favicon.png">

    <title>Gestion de Actividades</title>

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
			    url: "controllers/eEntrada.php",
			    data: "id="+id,
			    success: function(html){
			    if(html=='1'){
			    	bootbox.alert("Fue eliminado correctamente", function() {
                		document.location="iEntrada.php";
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
    	
	function edit(id,id_pelicula,costo,hora){
		document.getElementById("codigo").value=id;
		document.getElementById("id_pelicula").value=id_pelicula;
		document.getElementById("costo").value=costo;
	
    	}
    	
	   $(document).ready(function(){
		$("#ingresar").click(function(){ 
			codigo=$("#codigo").val();
			id_pelicula=$("#id_pelicula").val();
			costo=$("#costo").val();

			 $.ajax({
			    type: "POST",
			    url: "controllers/iEntrada.php",
			    data: "codigo="+codigo+"&id_pelicula="+id_pelicula+"&costo="+costo,
			    success: function(html){ 
alert("  ->"+html+" res");
			    if(html=='1'){
			    	bootbox.alert("Fue registrado correctamente", function() {
				document.location="iEntrada.php";
				});
			    }
			    else{
				if(html=='2'){
				    	bootbox.alert("El registro fue modificado con éxito", function() {
				    	document.location="iEntrada.php";
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
  <h3>Entrada</h3>
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Código</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="codigo" placeholder="Código de la actividad" required />
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">Costo</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="costo" placeholder="Costo de la pelicula" required />
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">Pelicula</label>
    <div class="col-sm-10">
      <?php
	ini_set('display_errors', 'on');
	include_once("models/class.entrada.php");
	$obj = new entrada;
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
	//ini_set('display_errors', 'on');
	//include_once("models/class.entrada.php");
	$obj = new entrada;
	$obj->getTabla();
?>
  </body>
</html>
