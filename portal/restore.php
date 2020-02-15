<?php
include 'inc/header.php';
?>
<title>Staff</title>

<!-- Sidebar -->
<?php
include 'inc/menu.php';
if ($admin_flag=='1') {
?>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> 
    	<a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> 
    	<a href="#" class="current">Restore</a> 
    </div>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Restore</h5>
            <div class="buttons"> 
            	<a href="restore.php?backup=1" onclick="document.body.style.cursor='wait'; return true;" class="btn btn-inverse btn-mini"><i class="fa fa-download"></i> Create Backup</a>
            </div>
          </div>
          <div class="widget-content nopadding">
	<?php 
	if (isset($_GET['file'])) {
		$restore_file  = "backups/".$_GET['file'];
		
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "naturalfarms_new";
		
		// $servername = "localhost";
		// $username = "natural_natural";
		// $password = "=1!G5Qzp.El8";
		// $dbname = "natural_portal";
		
		//$cmd = "mysql -h {$servername} -u {$username} -p{$password} {$dbname} < $restore_file";
		//exec($cmd);
		
		include 'cron/backupdb.php';
		
		$mysqli = new mysqli($servername, $username, $password, $dbname);
		$mysqli->query('SET foreign_key_checks = 0');
		if ($result = $mysqli->query("SHOW TABLES"))
		{
			while($row = $result->fetch_array(MYSQLI_NUM))
			{
				$mysqli->query('DROP TABLE IF EXISTS '.$row[0]);
			}
		}
		
		$mysqli->query('SET foreign_key_checks = 0');
		
		
		
		# MySQL with PDO_MYSQL
		$db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		
		$stmt = $db->prepare("SET NAMES 'utf8'");
		$stmt->execute();
		
		$stmt = $db->prepare("SET foreign_key_checks = 0");
		$stmt->execute();
		
		$query = file_get_contents($restore_file);
		$stmt = $db->prepare($query);
		
		echo "<br><br>";
		
		if ($stmt->execute())
			echo "<span style='color: green'>Successfully restored</span>";
		else {
			echo "<span style='color: red'>Failed to Restore!<br></span>";
			 
			$db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
			 
			$query = file_get_contents('backups/'.$file_path);
			 
			$stmt = $db->prepare($query);
			if ($stmt->execute()) {
				$stmt = $db->prepare($query);
				$stmt->execute();
				echo "Returned to previous version before restore was triggered.";
			}
			else {
				echo "Failed to return to previous version before restore was triggered. Please contact developper immediately!";
			}
		}
		echo "<br><br>Return to <a href='restore.php'>Restore Page</a>.";
		
	}
	else if (isset($_GET['backup'])) {
		include 'cron/backupdb.php';
		
		echo "<br><br>Backup successfully created: " . $file_path;
		
		echo "<br><br>Return to <a href='restore.php'>Restore Page</a>.";
	}
	else {
		echo "<table class='table table-bordered data-table'>";
		echo "<thead><tr>";
		echo "<th id='firstSort'>Date / Time</th>";
		echo "<th>Database Backups</th><th></th>";
		echo "</tr></thead>";
		
		$dir = new DirectoryIterator(dirname(__FILE__) . '/backups');
		foreach ($dir as $fileinfo) {
			if (!$fileinfo->isDot()) {
				echo "<tr>";
				echo "<td>".date("F d Y H:i:s.", $fileinfo->getCTime())."</td>";
				echo "<td>".$fileinfo->getFilename()."</td>";
				echo "<td><a onclick=\"document.body.style.cursor='wait'; return true;\" href='?file=".$fileinfo->getFilename()."'><i class='fa fa-download'></i> Restore</a></td>";
				echo "</tr>";
			}
		}
		
		echo "</table></div>";
	}
	
	?>
		</div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<?php
}
include 'inc/footer.php';
?>