<?php
	require_once('../../inc/dbconnect.php');
    session_start();
	
	require_once('../../inc/global.php');
	
	$ligaId = $_GET['liga']??0;
	$userId = $_SESSION['userId']??0;
	$darfBearbeiten = istMeineLiga($db, $userId, $ligaId) || (isset($_SESSION['status']) && $_SESSION['status'] == 'admin');
?>
<!doctype html>
<html lang="de">
	<head>
		<title>Vereine</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" href="/ligatabelle/img/favicon.png" type="image/png">
		<link rel="stylesheet" href="/ligatabelle/css/style.css">
		<link rel="stylesheet" href="/ligatabelle/css/verein.css">
		<link href="https://fonts.googleapis.com/css2?family=Roboto" rel="stylesheet">
		<meta name="description" content="">
		<meta name="keywords" content="">
	</head>
	<body>
		<?php include_once('../../inc/header.php') ?>
		<div id="content">
		<?php
			if (isset($_GET['erfolg'])) {
				echo '<p class="erfolg">'.$_GET['erfolg'].'</p>';
			}
			if (isset($_GET['error'])) {
				echo '<p class="error">'.$_GET['error'].'</p>';
			}

			$abfrage = "SELECT * FROM vereine
						INNER JOIN `liga-verein` ON `liga-verein`.ligaId = $ligaId
						WHERE vereine.vereinsId = `liga-verein`.vereinsId";
			$abfragen = mysqli_query($db, $abfrage);
			while ($row = mysqli_fetch_object($abfragen)) {
		?>
				<div class="verein">
					<a href="index.php?verein=<?=$row->vereinsId?>">
						<span><img src="../../img/vereine/<?=$row->logo?>"><?=$row->name?></span>
					</a>
					<span>
						<?php if ($darfBearbeiten) { ?>
						<a href="php/entfernen.php?liga=<?=$ligaId?>&verein=<?=$row->vereinsId?>&return=../alle.php" title="Verein Löschen">
							<img class="img_btn" src="../../img/loeschen.png">
						</a>
						<?php } ?>
					</span>
				</div>
		<?php
			}
		?>
		</div>
		<aside>
			<div class="buttons">
				<a href="../index.php?liga=<?=$ligaId?>" class="btn">Zurück zur Liga</a>
				<a href="../spieltag/alle.php?liga=<?=$ligaId?>" class="btn" title="Alle Spieltage mit Spielen der Liga">Spieltage und Spiele</a>
			</div>
		</aside>
		<?php include_once('../../inc/footer.php') ?>
	</body>
</html>
