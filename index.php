<!-- Boilerplate 0.0.5 by Daniel Stieber https://github.com/danielstieber/boilerplate -->
<?php
	require './vendor/autoload.php';
	// initalize CodaPHP & set Doc
	$coda = new CodaPHP\CodaPHP('5aea7886-8d02-4210-b4a0-81e1c676f9b5', true);
	$doc = "FFb1Ekjo02";
	// remote cache clearing
	if(isset($_GET['clearCache'])) {
		$coda->clearCache();
	}

	// load content
	$notice = $coda->getRow($doc, 'Other', 'Notice')['values']['Content'];
	$menuItems = $coda->listRows($doc, 'Lunch menu', ['sortBy' => 'natural'])['items'];
	// group by days
	$days = [];
	foreach($menuItems as $menuItem) {
		$date = new DateTime($menuItem['values']['Day']);
		$date->modify('+1 day');
		$days[$date->format('l, M jS')][] = $menuItem['values'];
	}
?>
<!doctype html>
<html class="no-js" lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Alfies Restaurant</title>
		<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
	</head>
	<body class="w-full overflow-x-hidden antialiased bg-yellow-50">
		<div class="max-w-screen-md w-full mt-16 mx-auto px-8 md:px-16">
			<header>
				<h1 class="sr-only">Alfies Restaurant & Bar</h1>
<?php include('img/logo.svg')?>
			</header>
			<main>
<?php if($notice) { ?>
					<div class="md:w-3/4 mx-auto mt-12 bg-white px-8 py-6 bold text-gray-800"><?=$notice?></div>
<?php } ?>
				<h2 class="text-xl font-bold mt-12 mb-4">Alfies Lunch Break</h2>
				<div>
<?php foreach($days as $day => $dishes) { ?>
					<div class="mb-6">
						<h3 class="font-bold mb-2"><?=$day?></h3>
<?php 	foreach($dishes as $dish) { ?>
							<div class="w-full flex justify-between mb-2">
								<p class=""><?=$dish['Name']?><sup class="ml-2 italic"><?=$dish['Allergens']?></sup>
									<?= ($dish['Vegan'] ? '<span class="ml-2 py-1 px-2 text-xs font-bold rounded-full bg-green-100 text-green-900">V<span class="hidden md:inline-block">EGAN</span></span>' : '' )?>
									<?= ($dish['Hot'] ? '<span class="ml-2 py-1 px-2 text-xs font-bold rounded-full bg-red-100 text-red-900">H<span class="hidden md:inline-block">OT</span></span>' : '' )?>
								</p>
								<span class="font-bold"><nobr><?=$dish['Price']?> <?=($dish['Price'] ? '€' : '')?></nobr></span>
							</div>
<?php } ?>
					</div>
<?php } ?>
				</div>
			</main>
		</div>
		<div class="fixed w-full py-2 px-4 flex bottom-0 bg-gray-800 text-white">
			<p class="self-center mx-auto text-lg text-center">This is a demo for the <a href="https://github.com/danielstieber/CodaPHP" class="underline text-yellow-300" target="_blank">CodaPHP library</a>. The content of this site can be managed by this <a href="https://coda.io/d/Alfies-Restaurant_dFFb1Ekjo02" class="underline text-yellow-300" target="_blank">Coda Doc</a>.</p>
		</div>
	</body>
</html>