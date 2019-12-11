<?php
$listdata="";$jumlah = ""; $literasi="";$gbest="";
if(!empty($_POST)){
	$listdata = $_POST['data'];
	$data = array_map('intval', explode(';', $listdata));
	$jumlah = count($data);
	$v = array_fill(0, $jumlah, 0);
	$pbest = $data;
	$gbest = getGbest($data);
	//echo $gbest;
	$c1 = 1;
	$c2 = 1;
	/*for($i = 0; $i<$jumlah; $i++){
		$data[$i] = rand();
		echo $data[$i]."<br>";
	}*/
	$literasi =$_POST["literasi"];
	for($i=0;$i<$literasi;$i++){
		$r1 = (rand(0, 10)/10);
		$r2 = (rand(0, 10)/10);
		foreach($data as $key => $value){
			$fungsi = fungsi_tujuan($value);
			if($fungsi < fungsi_tujuan($pbest[$key])){
				$pbest[$key] = $value;
			}
			if($fungsi < fungsi_tujuan($gbest)){
				$gbest = $value;
			}
			$v[$i+1] = $i + $c1 * $r1* ($pbest[$key] - $value)  + $c2 * $r2 *($gbest - $value);
		//	echo $v[$i+1]."<br>";
		
			$hasil["data"][$i][$key] = $data[$key]; 
			$hasil["v"][$i][$key] =$v[$i+1];
			$hasil["pbest"][$i][$key] =$pbest[$key];
			
			$hasil["fungsi"][$i][$key] = $fungsi; 
			$data[$key] = $data[$key] + $v[$i+1];
		}	
		$hasil["gbest"][$i] = $gbest;
	}
}
//var_dump($hasil);
?>
<html>
<head>
<title>Kecerdasan Komputasional</title>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link href="css/style.css" rel="stylesheet" />
<script src="highcharts.js"></script>
<script src="jquery/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Kecerdasan Komputasional</a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="index.php">Particle Swarm Optimization</a></li>
    </div>
  </div>
</nav>

<div class="container">
	<div class="row">
		<div class="col-md-6">
			<form action="index.php" method="POST" autocomplete="off" >
				  <div class="form-group">
					<label for="data">Masukkan  Data:</label>
					<input type="text" class="form-control  input-sm" name="data" value="<?php echo $listdata;?>" placeholder="Contoh: 80;90;110;75" required>
				  </div>
				  <div class="form-group">
					<label for="class">Jumlah Literasi</label>
					<input type="text" class="form-control input-sm" name="literasi"  value="<?php echo $literasi;?>" placeholder="Jumlah Literasi" required>
				  </div>
				  <button type="submit" name="hitung" class="btn btn-success">Submit</button>
			</form>	
			<div id="chart"></div>
		</div>		
		<div class="col-md-6">
		<div class="table-responsive">
			<table class="table table-bordered">
				<tr class="bg-primary">
					<td>No</td>
					<td>Data</td>
					<td>Velocity</td>
					<td>Fungsi</td>
					<td>PBest</td>
					<td>GBest</td>
				</tr>
				<?php 
				if(!empty($hasil["data"])){
					foreach($hasil["data"] as $key => $value){
						if($key%2==0){$bg = "#fff";}else{ $bg = "#ccc";}
						foreach($hasil["data"][$key] as $key2 => $value2){
					?>
					<tr style="background-color:<?php echo $bg;?>">
						<td><?php echo $key+1;?></td>
						<td><?php echo $value2;?></td>
						<td><?php echo $hasil["v"][$key][$key2];?></td>
						<td><?php echo $hasil["fungsi"][$key][$key2];?></td>
						<td><?php echo $hasil["pbest"][$key][$key2];?></td>
						<td><?php echo $hasil["gbest"][$key]?></td>
					</tr>
					<?php				
						}
					}
				}
				?>
			</table>
		</div>
		</div>
	</div>
</div>
</body>
</html>
<?php 
function fungsi_tujuan($nilai){
	//fungsi tujuan f(x) = (100-x)^2;
	$hasil = pow((100 - $nilai), 2);
	return $hasil;
}
function getGbest($pbest){
	$gbest = $pbest[0];
	for($i=1; $i<count($pbest);$i++){
		if(fungsi_tujuan($pbest[$i]) < fungsi_tujuan($gbest)){
			$gbest = $pbest[$i];
		}
	}
return $gbest;
}
?>