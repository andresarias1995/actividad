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
      function elimina(codigoequ){
			$.ajax({
			    type: "POST",
			    url: "controllers/eEquipo_tecnico.php",
			    data: "codigoequ="+codigoequ,
			    success: function(html){
			    if(html=='1'){
			    	bootbox.alert("Fue eliminado correctamente", function() {
                		document.location="iEquipo_tecnico.php";
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
    	
	function edit(codigoequ, nombre,descripcion){
		document.getElementById("codigo").value=codigoequ;
		document.getElementById("nombre").value=nombre;
		document.getElementById("descripcion").value=descripcion;
    	}
    	
	   $(document).ready(function(){
alert("aqui");
		$("#ingresar").click(function(){ 
			codigo=$("#codigo").val();
			nombre=$("#nombre").val();
			descripcion=$("#descripcion").val();

			 $.ajax({
			    type: "POST",
			    url: "controllers/iEquipo_tecnico.php",
			    data: "codigo="+codigo+"&nombre="+nombre+"&descripcion="+descripcion,
			    success: function(html){ 
alert(html+"info");
			    if(html=='1'){
			    	bootbox.alert("Fue registrado correctamente", function() {
				document.location="iEquipo_tecnico.php";
				});
			    }
			    else{
				if(html=='2'){
				    	bootbox.alert("El registro fue modificado con éxito", function() {
				    	document.location="iEquipo_tecnico.php";
		        	 	});
				 }
				 else{
					if(html=='-1'){
				    		bootbox.alert("No fue procesado, verifique, lio en el SQL", function() {
		        	 	});
			         	}
					else{
						bootbox.alert("No se que hp paso", function() {
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
      <input type="text" class="form-control" id="codigo" placeholder="Código del Empleado" required />
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">nombre</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="nombre" placeholder="nombre del empleado" required />
    </div>
	<div class="form-group">
    <label for="inputPassword2" class="col-sm-2 control-label">descripcion</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="descripcion" placeholder="descripcion" required />
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button id="ingresar" type="submit" class="btn">Guardar</button>
    </div>
  </div>
</form>
<?php
	ini_set('display_errors', 'on');
	include_once("models/class.equipo_tecnico.php");
	$obj = new equipo_tecnico;
	$obj->getTabla();
?>
  </body>
</html>
