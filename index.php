<?php

date_default_timezone_set("America/Lima");

$user = "modulo6";
$password = "modulo6";
$dbname = "tcs2bk";
$port = "5432";
$host = "159.65.230.188";

$cadenaConexion = "host=$host port=$port dbname=$dbname user=$user password=$password";

$conexion = pg_connect($cadenaConexion) or die("Error en la Conexión: ".pg_last_error());

$hoy=getdate();
//$hoy['weekday']='Sunday';
switch ($hoy['weekday']) {
	case 'Sunday':
		$dia='DOMINGO';
		break;
	case 'Monday':
		$dia='LUNES';
		break;
	case 'Tuesday':
		$dia='MARTES';
		break;
	case 'Wednesday':
		$dia='MIÉRCOLES';
		break;
	case 'Thursday':
		$dia='JUEVES';
		break;
	case 'Friday':
		$dia='VIERNES';
		break;
	case 'Saturday':
		$dia='SÁBADO';
		break;
	default:
		$dia='';
		break;
}
$rest = substr("abcdef", -1);    // devuelve "f"


//$query = "select * from public.t_asistencia_postgrado  where dt_dia ='$dia'";
$query = "select * from public.t_asistencia_postgrado where dt_dia ='$dia' ";

$resultado = pg_query($conexion, $query) or die("Error en la Consulta SQL");

$numReg = pg_num_rows($resultado);
?>

<?php
function calcula_semestre($valorIngresado) {
	switch ($valorIngresado) {
		case 'ene.':
			$numeromes=1;
			break;
		case 'feb.':
			$numeromes=2;
			break;
		case 'mar.':
			$numeromes=3;
			break;
		case 'abr.':
			$numeromes=4;
			break;
		case 'may.':
			$numeromes=5;
			break;
		case 'jun.':
			$numeromes=6;
			break;
		case 'jul.':
			$numeromes=7;
			break;
		case 'ago.':
			$numeromes=8;
			break;
		case 'sept.':
			$numeromes=9;
			break;
		case 'oct.':
			$numeromes=10;
			break;
		case 'nov.':
			$numeromes=11;
			break;
		case 'dic.':
			$numeromes=12;
			break;
		default:
			$numeromes='No registrado';
			break;
	}
	return $numeromes;
	//endswitch;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="free-educational-responsive-web-template-webEdu">
	<meta name="author" content="webThemez.com">
	<title>Asistencia Docente</title>
	<link rel="favicon" href="assets/images/favicon.png">
	<link rel="stylesheet" media="screen" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/font-awesome.min.css">
	<!-- Custom styles for our template -->
	<link rel="stylesheet" href="assets/css/bootstrap-theme.css" media="screen">
	<link rel="stylesheet" href="assets/css/style.css">
	<!-- Custom styles for our digital clock -->
	<link rel="stylesheet" href="assets/css/clock.css">
	<link href="http://fonts.googleapis.com/css?family=Oswald:400,300,700" rel="stylesheet" type="text/css">

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="assets/js/html5shiv.js"></script>
	<script src="assets/js/respond.min.js"></script>
	<![endif]-->
	<style>
	table {
	    font-family: arial, sans-serif;
	    border-collapse: collapse;
	    width: 100%;
	}

	td, th, thead {
	    border: 1px solid #dddddd;
	    text-align: center;
	    padding: 4px;
	}

	tr:nth-child(even) {
	    background-color: #dddddd;
	}
	</style>
</head>

<body>
	
<div class="container">

</div>
	<div class="container">
		<div class="row">
			<section class="col-sm-12 maincontent">
				<p>
					<div class="wrap">
						<center>
						<div class="widget">
							<div class="fecha">
								<p id="diaSemana" class="diaSemana">Jueves</p>
								<p id="dia" class="dia">20 </p>
								<p>de </p>
								<p id="mes" class="mes">Agosto </p>
								<p>del </p>
								<p id="year" class="year">2017</p>
							</div>

							<div class="reloj">
								<p id="horas" class="horas">1</p>
								<p>:</p>
								<p id="minutos" class="minutos">47</p>
								<p>:</p>
								<div class="caja-segundos">
									<p id="ampm" class="ampm">AM</p>
									<p id="segundos" class="segundos">31</p>
								</div>
							</div>
						</div>
						</center>
					</div>
					<?php //echo print_r($hoy); 
					//echo date_default_timezone_get(); ?>
				</p>
				<center><h1>Asistencia docente</h1></center>
				<p>
					<table>

					  <tr>
						<th>#</th>
						<th>Semestre</th>
						<th>Periodo</th>
						<th>Programa</th>
					    <th>Docente</th>
					    <th>Curso</th>
					    <th>Aula</th>
						<th>Piso</th>
					    <th>Horario</th>
					    <th>Pabellón</th>
						<th>Estado</th>
						<th>Observación</th>
					  </tr>
				  <?php 
					if($numReg>0){
						$i=0;
						while ($fila=pg_fetch_array($resultado)) {
							//aumentado
							$fechaComparada = $fila['dt_fecha_inicio'];
							if($fechaComparada == ''){
								$numerofecha2 = 13;
							}else{
								$fechas = explode("-", $fechaComparada);
								$numerofecha2 = calcula_semestre($fechas[1]);
							}
							if($numerofecha2<12 & $numerofecha2>6){
								$semestrecalculado = date("Y")."-II";
							}else{
								if($numerofecha2==13){
									$semestrecalculado = "No registrado";
								}else{
									$semestrecalculado = date("Y")."-I";
								}
							}
							if(date("m")<6){
								$semsis = date("Y")."-I";
							}else{
								$semsis = date("Y")."-II";
							}
							
							if($semsis==$semestrecalculado){
								$i++;
								echo "<tr>";
								echo "<td>".$i."</td>";
								echo "<td>".$semestrecalculado."</td>";
								echo "<td>".$fila['dt_fecha_inicio']." - ".$fila['dt_fecha_fin']."</td>";
								echo "<td>".$fila['vc_programa']."</td>";
								echo "<td>".$fila['vc_docente']."</td>";
								echo "<td>".$fila['vc_curso']."</td>";
								echo "<td>".$fila['vc_aula']."</td>";
								echo "<td>".$fila['nu_piso']."</td>";
								echo "<td>".$fila['vc_hora_inicio']." - ".$fila['vc_hora_fin']."</td>";
								echo "<td>".$fila['vc_pabellon']."</td>";
								echo "<td>".$fila['vc_estado']."</td>";
								echo "<td>".$fila['vc_estado']."</td>";
								echo "</tr>";
							}							
							
						}
					}
					?>
					</table>
				</p>
			</section>
		</div>
	</div>
	<!-- JavaScript libs are placed at the end of the document so the pages load faster 
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
	<script src="assets/js/custom.js"></script> -->
	<!-- JavaScript lib for our digital clock -->
	<script src="assets/js/clock.js"></script>
</body>
</html>
