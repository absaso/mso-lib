<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
	<meta charset="UTF-8">
	<title>MSOApp - Accueil</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<?php 
include 'connection.php';
if(isset($_GET['id'])){
	$stmt = $db->prepare('DELETE FROM document WHERE ID = ?');
	$stmt->execute([$_GET['id']]);
}
$sqlQuery = 'SELECT * FROM document ORDER BY numClasseur';
$documentStatement = $db->prepare($sqlQuery);
$documentStatement->execute();
$documents = $documentStatement->fetchAll();


?>
<body>
	<nav class="navbar navbar-expand-sm bg-secondary navbar-dark fixed-top">
	  <div class="container-fluid">
	    <ul class="navbar-nav">
	      <li class="nav-item">
	        <a class="navbar-brand" href="main.html"><img alt="logo" width="120px" src="../img/logo.png"></a>
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
	 	<br/>
	 	<br/><br/>
        <br/>
	<div class="container mt-3">
	
    	
         <form th:object="${dossier}" th:action="@{/SearchDossier}" method="get">
       		      
			<table class ="table table-bordered " >
			<thead class = "table-success">
	            <tr>
	               <th>Numéro de classeur  </th>
	               <th>Libelle document</th>
	               <th>Domaine</th>
	               <th> </th>
	            </tr>
	        </thead>
	        
	        <tbody>
	        	<tr>
	               <td><input id="txtSearchClasseur" name="keywordClasseur" type="text" placeholder="Numéro recherché"></td>
	               <td><input id="txtSearchLibelle" name="keywordLibelle" type="text" placeholder="Nom du document"></td>
	               <!-- <td><input id="txtSearchDomaine" name="keywordDomaine" type="text" placeholder="BTP,ASST,EPOT,GC"></td> -->
	               <td>
		               <select id="txtSearchDomaine" name="keywordDomaine">
						    <option value="ASST">ASST</option>
						    <option value="BTP">BTP</option>
						    <option value="EPOT">EPOT</option>
						    <option value="EPOT / ASST">EPOT / ASST</option>
						    <option value="GC">GC</option>
					</select>
					</td>
	               <td><button class="btn" type="submit">Rechercher</button></td>
            </tr>
	        </tbody>
            
        	 </table> 
         </form>        
         
         <div class="row">
         	<div class="col-lg-3">
         		<form th:action="@{/mainPage}" method="get">         
		         	<button class="btn btn-secondary btn-sm mb-2" type="submit">Tout afficher</button>
		         </form>
         	</div>
		</div>          
         
         <br/>
	 	<br/>
		 

         <table class ="table table-bordered table-hover" >
	         <thead class = "table-success">
	         	<tr>
	               <th>Numéro classeur</th>
	               <th>Libelle document</th>
	               <th>Image</th>
	               <th>Domaine</th>
	               <th>Action</th>
	            </tr>
	         </thead>

			 <?php foreach ($documents as $doc) 
				{ 
				?> 
            <tbody>
            	<tr>
	               <td><?php echo $doc['numClasseur']; ?></td>
	               <td><?php echo $doc['libelle']; ?></td>
				   <td><img alt="logo" width="120px" src=<?php echo $doc['image']; ?>></td>
				   <td><?php echo $doc['domaine']; ?></td>
	               <td><a href="EditDossier.php?id=<?php echo $doc['ID']; ?>" class="btn btn-primary">Modifier</a></td>
            	</tr>
            </tbody>

			<?php 
				} 
				?> 
            
         </table>
      </div>
</body>
</html>