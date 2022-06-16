<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
	<meta charset="UTF-8">
	<title>MSOApp - Nouveau dossier</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<?php 
include 'connection.php';

if (!empty($_POST)) {
	$libelle = isset($_POST['libelle']) ? $_POST['libelle'] : '';
	$numClasseur = isset($_POST['numClasseur']) ? $_POST['numClasseur'] : '';
	$domaine = isset($_POST['domaine']) ? $_POST['domaine'] : '';

	if(isset ($_FILES['image'] ))
	{
		
		$fileInfo = pathinfo($_FILES['image']['name']);
		$extension = $fileInfo['extension'];
		$allowedExtension = ['jpg', 'JPG', 'JPEG', 'jpeg', 'png', 'PNG'];

		if (in_array($extension,$allowedExtension))
		{
			move_uploaded_file($_FILES['image']['tmp_name'],'../img/'.basename($_FILES['image']['name']));
			$image = '../img/'.basename($_FILES['image']['name']);
		}
	
	} 

	$stmt = $db->prepare('INSERT INTO document VALUES (DEFAULT,?, ?, ?, ?)');
	$stmt->execute([$numClasseur, $libelle, $image, $domaine]);

}

?>


<body>
	<nav class="navbar navbar-expand-sm bg-secondary navbar-dark fixed-top">
	  <div class="container-fluid">
	    <ul class="navbar-nav">
	      <li class="nav-item">
	        <a class="navbar-brand" href="main.php"><img alt="logo" width="120px" src="../img/logo.png"></a>
	      </li>
	      <li class="nav-item mt-3 ml-3">
	        <a href="AddNewDossier.php" class="btn btn-secondary btn-sm mb-2">Nouveau dossier</a>
	      </li>
	    </ul>
	  </div>
	</nav>
        <br/><br/><br/>
        <br/>
	<div class="container mt-5">
		<div class="row">
			<div class="col-lg-8 col-md-8 col-sm-8 container justify-center card">
				<h1 class="text-center">Ajout d'un nouveau dossier</h1>
				
				<div class="card-body">
					<form action="AddNewDossier.php" method="POST" enctype="multipart/form-data" >
						<div class="form-group">
							<label> Nom du document</label>
							<input
							type = "text"
							name = "libelle"
							class = "form-control"
							placeholder="saisir le libellé"
							/>
						</div>
						
						<div class="form-group">
							<label> Numéro de classeur</label>
							<input
							type = "text"
							name = "numClasseur"
							class = "form-control"
							placeholder="saisir le numéro"
							/>
						</div>
						
						<div class="form-group">
							<label> Domaine</label>
							<select id="inputDomaine" name="domaine" class = "form-control" placeholder="choix du domaine">
								<option value="ASST">ASST</option>
								<option value="BTP">BTP</option>
								<option value="EPOT">EPOT</option>
								<option value="EPOT / ASST">EPOT / ASST</option>
								<option value="GC">GC</option>
						</select>
						</div>
						
						<div class="form-group">
							<label> Photo du classeur</label>
							<input
							type = "file"
							name = "image"
							class = "form-control"
							placeholder="sélectionner la photo"
							/>
						</div>
						
						<div class="box-footer text-center">
							<button type="submit" class="btn btn-success">Enregistrer</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

</body>
</html>