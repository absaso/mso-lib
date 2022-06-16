<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
	<meta charset="UTF-8">
	<title>MSOApp - Modification dossier</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<?php 
include 'connection.php';
if (isset($_GET['id'])) {

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
				echo 'okk';
			}
		
		} else {
			$ID_DOC = $_GET['id'];
			$sqlQuery = "SELECT * FROM document WHERE ID = $ID_DOC";
			$documentStatement = $db->prepare($sqlQuery);
			$documentStatement->execute();
			$documents = $documentStatement->fetchAll();
			foreach ($documents as $doc) 
				{
					$image = $doc['image'] ;
				}
		}

		$stmt = $db->prepare('UPDATE document SET numClasseur = ?, libelle = ?, image = ?, domaine = ? WHERE ID = ?');
        $stmt->execute([$numClasseur, $libelle, $image, $domaine, $_GET['id']]);
        $msg = 'Updated Successfully!';

	}

	$ID_DOC = $_GET['id'];
	$sqlQuery = "SELECT * FROM document WHERE ID = $ID_DOC";
	$documentStatement = $db->prepare($sqlQuery);
	$documentStatement->execute();
	$documents = $documentStatement->fetchAll();
	if (!$documents) {
        exit('Ce document n\'existe pas avec cet ID!');
    } 
	} else {
		exit('No ID specified!');
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
		  <?php echo date('d/m/Y h:i:s'); ?>
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
				<h1 class="text-center">Modification du dossier</h1>
				
				<?php foreach ($documents as $doc) 
				{
					?>
				<div class="card-body">
					<form action="EditDossier.php?id=<?php echo $doc['ID']; ?>" method="POST" 	 >
						<div class="form-group">
							<label> Nom du document</label>
							<input
							type = "text"
							name = "libelle"
							class = "form-control"
							value = "<?php echo $doc['libelle']; ?>"
							/>
						</div>
						
						<div class="form-group">
							<label> Numéro de classeur</label>
							<input
							type = "text"
							name = "numClasseur"
							class = "form-control"
							value = "<?php echo $doc['numClasseur']; ?>"
							/>
						</div>

						<div class="form-group">
							<label> Domaine</label>
							<select id="inputDomaine" name="domaine" class = "form-control" placeholder="choix du domaine">
								<option value="ASST"<?php if($doc['domaine'] == 'ASST'): ?> selected="selected"<?php endif; ?>>ASST</option>
								<option value="BTP"<?php if($doc['domaine'] == 'BTP'): ?> selected="selected"<?php endif; ?>>BTP</option>
								<option value="EPOT"<?php if($doc['domaine'] == 'EPOT'): ?> selected="selected"<?php endif; ?>>EPOT</option>
								<option value="EPOT / ASST"<?php if($doc['domaine'] == 'EPOT / ASST'): ?> selected="selected"<?php endif; ?>>EPOT / ASST</option>
								<option value="GC"<?php if($doc['domaine'] == 'GC'): ?> selected="selected"<?php endif; ?>>GC</option>
						</select>
						</div>

						<div class="form-group">
							<label> Photo du classeur</label>
							<input
							type = "file"
							name = "image"
							class = "form-control"
							/>
						</div>
						
				<?php

				}
					?>
						<div class="box-footer text-center">
							<button type="submit" name="action" value="edit" class="btn btn-success">Enregistrer</button>
							<a href="main.php?id=<?php echo $doc['ID']; ?>" class="btn btn-danger">Supprimer définitivement</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

</body>
</html>