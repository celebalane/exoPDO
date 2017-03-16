<?php
	$pdo = new PDO('mysql:host=localhost;dbname=colyseum;charset=utf8','live','live');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
	$statement = $pdo->query("SELECT * FROM clients where card=1");
	$resultatExo1 = $statement->fetchAll();

	$statement = $pdo->query("
						SELECT showTypes.type, genres.genre AS firstGenre, secondGenres.genre AS secondGenre 
						FROM showTypes,genres,genres AS secondGenres 
						WHERE showTypes.id=genres.showTypesId AND showTypes.id=secondGenres.showTypesId 
						ORDER BY genres.id");  //On peut réutiliser plusieurs fois une colonne
	$resultatExo2 = $statement->fetchAll();

	$statement = $pdo->query("SELECT lastName,firstName FROM clients WHERE lastName LIKE 'M%' ORDER BY lastName");
	$resultatExo3 = $statement->fetchAll();

	$statement = $pdo->query("SELECT title,performer,date,startTime FROM shows ORDER BY title");
	$resultatExo4 = $statement->fetchAll();

	$statement = $pdo->query("SELECT * FROM clients");
	$resultatExo5 = $statement->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
	<title>Test pdo</title>
</head>
<body>
	<h2>Exercice 1</h2>
		<table>
			<thead>
				<tr>
					<th>Id</th>
					<th>Nom</th>
					<th>Prénom</th>
					<th>Date de naissance</th>
					<th>Carte</th>
					<th>Numéro de carte</th>
				</tr>
			</thead>
			<tbody>
				
				<?php
					//Afficher tout les clients
					foreach ($resultatExo1 as $value) : ?>
				<tr>
					<td><?= $value->id; ?></td>
					<td><?= $value->lastName; ?></td>
					<td><?= $value->firstName; ?></td>
					<td><?= $value->birthDate; ?></td>
					<td><?= $value->card; ?></td>
					<td><?= $value->cardNumber; ?></td>
				</tr>

				<?php endforeach ?>
			</tbody>
		</table>
		<h2>Exercice 3</h2>
		<?php
			foreach ($resultatExo3 as$value):?> 
				<p><u>Nom :</u><?=$value->lastName ;?> <u>Prénom :</u><?= $value->firstName; ?></p>
			<?php endforeach ?>

		<h2>Exercice 4</h2>
		<?php
			foreach ($resultatExo4 as$value):?> 
				<p>Le spectacle <?=$value->title ;?> par <?=$value->performer ;?> , le <?=$value->date ;?> à <?=$value->startTime; ?></p>
			<?php endforeach ?>

			<h2>Exercice 4</h2>
		<?php
			foreach ($resultatExo4 as$value):?> 
				<p>Le spectacle <?=$value->title ;?> par <?=$value->performer ;?> , le <?=$value->date ;?> à <?=$value->startTime; ?></p>
			<?php endforeach ?>

		<h2>Exercice 5</h2>
		<?php
			foreach ($resultatExo5 as$value):?> 
				<p>Nom : <?=$value->lastName ;?>, Prénom : <?=$value->firstName ;?>, Date de naissance : <?=$value->birthDate ;?>, Carte de fidélité : 
				<?php if($value->card==1){ ?>
					oui, Numéro carte : <?=$value->cardNumber ;?>.<p>
				<?php }else{?>
					non</p>
				<?php } endforeach ?>


		<h2>Exercice 2</h2>
		<table>
			<thead>
				<tr>
					<th>Type</th>
					<th>Genre</th>
					<th>Genre 2</th>
				</tr>
			</thead>
			<tbody>

				<?php
					//Afficher tout les types de spectacle possible
					foreach ($resultatExo2 as $value) : ?>
				<tr>
					<td><?= $value->type; ?></td>
					<td><?= $value->firstGenre; ?></td>
					<td><?= $value->secondGenre; ?></td>
				</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	
</body>
</html>
