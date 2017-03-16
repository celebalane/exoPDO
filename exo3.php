<?php
	$message = [];

	$pdo = new PDO(
				'mysql:host=localhost;dbname=colyseum;charset=UTF8',
				'live',
				'live');

	$pdo->setAttribute(
				PDO::ATTR_ERRMODE,
			 	PDO::ERRMODE_EXCEPTION);

	$pdo->setAttribute(
				PDO::ATTR_DEFAULT_FETCH_MODE,
			 	PDO::FETCH_OBJ);

	$statement = $pdo->query('SELECT id, type FROM showTypes');
	$typeSpectacle	=  $statement->fetchAll();

	$statement = $pdo->query('SELECT id, genre, showTypesId FROM genres');
	$categories	=  $statement->fetchAll();

	if(isset($_POST) && !empty($_POST)){
		$donne=[];
		if (isset($_POST['titre']) && $_POST['titre']!='') {
			$donne['titre'] = $_POST['titre'];
		}else{
			$message['danger'][]= 'merci de mettre un titre';
		}
		if (isset($_POST['artiste']) && !empty($_POST['artiste'])) {
			$donne['artiste'] = $_POST['artiste'];
		}else{
			$message['danger'][] = 'merci de mettre un artiste';
		}
		if (isset($_POST['date']) && $_POST['date']!='') {
			$donne['date'] = $_POST['date'];
		}else{
			$message['danger'][] = 'merci de mettre une date';
		}
		if (isset($_POST['showtype']) && $_POST['showtype']!='') {
			$donne['showtype'] = $_POST['showtype'];
		}else{
			$message['danger'][] = 'merci de mettre un showtype';
		}
		if (isset($_POST['genre1']) && $_POST['genre1']!='') {
			$donne['genre1'] = $_POST['genre1'];
		}else{
			$message['danger'][] = 'merci de mettre un genre1';
		}
		if (isset($_POST['genre2']) && $_POST['genre2']!='') {
			$donne['genre2'] = $_POST['genre2'];
		}else{
			$message['danger'][] = 'merci de mettre un genre2';
		}
		if (isset($_POST['duree']) && $_POST['duree']!='') {
			$donne['duree'] = $_POST['duree'];
		}else{
			$message['danger'][] = 'merci de mettre une duree';
		}
		if (isset($_POST['heuredebut']) && $_POST['heuredebut']!='') {
			$donne['heuredebut'] = $_POST['heuredebut'];
		}else{
			$message['danger'][] = 'merci de mettre une heure debut';
		}


		if (!isset($message['danger'])){


			$statement = $pdo->prepare("
				INSERT INTO shows
				SET title 			= :titre,
					performer 		= :artiste,
					date 			= :date,
					showTypesId		= :showtype,
					firstGenresId 	= :genre1,
					secondGenreId 	= :genre2,
					duration 		= :duree,
					startTime 		= :heuredebut
				");
			$statement->execute($donne);

			$message['sucess'][] = 'le spectacle est bien ajouté';
		}

	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Ajout de spectacle</title>
	<link rel="stylesheet" type="text/css" href="style/css/style.css">
	<script type="text/javascript">
		function choix(form){
			

			i = form.showtype.selectedIndex;
			if (i == 0){
				return;
			}
			switch(i){
				<?php foreach ($typeSpectacle as $value) {
					$ligne = "case ".$value->id." : var txt = new Array (";
					foreach ($categories as $categorie) {
						if($value->id == $categorie->showTypesId){ 
						$ligne .= "['".$categorie->id."','".$categorie->genre."'],";
						}
					}
				$ligne = substr($ligne, 0, -1)."); break;\n";
				echo $ligne;
				} ?>
			}
			
			<?php  for ($sousmenu=1; $sousmenu <= 2; $sousmenu++) { 
				echo ' form.genre'.$sousmenu.'.innerHTML =\'<option value="">----Choisir la catégorie '.$sousmenu.'----</option>\';
				for (i=0;i<=txt.length-1;i++) {
				form.genre'.$sousmenu.'.innerHTML +=\'<option value="\'+txt[i][0]+\'">\'+txt[i][1]+\'</option>\';
				} ';
			} ?>
		} </script>
</head>
<body>
<a href="index.php">retour</a>

	<h1>Ajout de spectacles</h1>

	<ul>
	<?php 
		foreach ($message as $key => $tableau) {
				foreach ($tableau as  $value) {
				echo "<li class=\"$key\">$value</li>";
			}
		}
	?>
	</ul>

	<form method="post"	action="">
		<input type="text" name="titre" placeholder="Quel est son titre">
		<input type="text" name="artiste" placeholder="Le nom de l'artiste">
		<label for="date">À quel date va être ce spectacle</label>
		<input type="date" name="date">
		<select name="showtype" onchange="choix(this.form)">
			<option value="">Choisir le type</option>
			<?php foreach ($typeSpectacle as $value) {
				echo "\t<option value=\"$value->id\">$value->type</option>\n";
			}
			?>
		</select>	
		<select name="genre1">
			<option value="">Choisir la catégorie 1</option>
		</select>
		<select name="genre2">
			<option value="">Choisir la catégorie 2</option>
		</select>
		<label for="duree">Quel est la durée de celui-ci?</label>
		<input type="time" name="duree" step="1">
		<label for="heuredebut">A quel heure commence t'il?</label>
		<input type="time" name="heuredebut" step="1">
		<button type="submit">aller go on y va ;)</button>
	</form>
</body>
</html>