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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Heebo:100,900" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="style/css/style.css">
	<title>Exercice 1</title>
</head>
<body onload="affichage('spectacle');affichage('client');">
	<div class="container-fluid">
		<div class="col-md-2 col-md-offset-10">
			<a href="index.php" class="btn btn-primary btn-lg btn-block" role="button" id="btnAccueil">Accueil</a>
		</div>
		<section class="row">
			<h2>Résultat 1</h2>
			<div class="col-md-6 col-md-offset-3 fondExo">
				<h3>Afficher tous les types de spectacles possibles</h3>
				<button type="button" class="btn btn-primary btnExo" onclick="affichage('spectacle');">Afficher</button>
				<div id="spectacle">
					<table>
						<thead>
							<tr>
								<th>Type</th>
								<th>Genre</th>
								<th>Genre 2</th>
							</tr>
						</thead>
						<tbody>

						<?php foreach ($resultatExo2 as $value) : ?>
							<tr>
								<td><?= $value->type; ?></td>
								<td><?= $value->firstGenre; ?></td>
								<td><?= $value->secondGenre; ?></td>
							</tr>
						<?php endforeach ?>

						</tbody>
					</table>
				</div>
			</div>
		</section>
		<section class="row">
			<h2>Résultat 2</h2>
			<div class="col-md-6 col-md-offset-3 fondExo">
				<h3>Afficher les clients possédant une carte de fidélité</h3>
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
						<?php foreach ($resultatExo1 as $value) : ?>

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
			</div>
		</section>
		<section class="row">
			<h2>Résultat 3</h2>
			<div class="col-md-6 col-md-offset-3 fondExo">
				<h3>Afficher uniquement le nom et le prénom de tous les clients dont le nom commence par la lettre "M". Les afficher comme ceci :Nom : Nom du client, Prénom : Prénom du client<br>Trier les noms par ordre alphabétique</h3>
				<?php foreach ($resultatExo3 as$value):?> 

					<p><u>Nom</u> : <?=$value->lastName ;?> , <u>Prénom</u> : <?= $value->firstName; ?></p>

				<?php endforeach ?>
			</div>
		</section>
		<section class="row">
			<h2>Résultat 4</h2>
			<div class="col-md-6 col-md-offset-3 fondExo">
				<h3>Afficher le titre de tous les spectacles ainsi que l'artiste, la date et l'heure. Trier les titres par ordre alphabétique. Afficher les résultat comme ceci : Spectacle par artiste, le date à heure</h3>
				<?php foreach ($resultatExo4 as$value):?> 

					<p><?=$value->title ;?> par <?=$value->performer ;?> , le <?=$value->date ;?> à <?=$value->startTime; ?></p>

				<?php endforeach ?>
			</div>
		</section>
		<section class="row">
			<h2>Résultat 5</h2>
			<div class="col-md-6 col-md-offset-3 fondExo">
				<h3>Afficher tous les clients comme ceci : Nom : Nom de famille du client, Prénom : Prénom du client, Date de naissance : Date de naissance du client, Carte de fidélité : Oui (si le client en possède une) ou Non (s'il n'en possède pas), Numéro de carte : Numéro de la carte fidélité du client, s'il en possède une</h3>
				<button type="button" class="btn btn-primary btnExo" onclick="affichage('client');">Afficher</button>
				<div id="client">
					<?php foreach ($resultatExo5 as$value):?>

						<p><u>Nom</u> : <?=$value->lastName ;?>, <u>Prénom</u> : <?=$value->firstName ;?>, <u>Date de naissance</u> : <?=$value->birthDate ;?>, <u>Carte de fidélité</u> : 

					<?php if($value->card==1){ ?>

						oui, <u>Numéro carte</u> : <?=$value->cardNumber ;?>.</p>

					<?php }else{?>

						non</p>

					<?php } endforeach ?>
				</div>
			</div>
		</section>
		<div class="col-md-2 col-md-offset-10">
			<a href="index.php" class="btn btn-primary btn-lg btn-block" role="button" id="btnAccueil">Accueil</a>
		</div>
	</div>
<script type="text/javascript" src="js/script.js"></script>
</body>
</html>
