<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <?php include 'inc/config.php'; ?>
    <title><?=SITENAAM; ?> | <?= htmlspecialchars(str_replace('-', ' ', $_GET['c'])); ?></title>
    <link rel="stylesheet" href="/css/bootstrap.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="/css/custom.css" media="screen" title="no title" charset="utf-8">
    <link href='//fonts.googleapis.com/css?family=Raleway:400,300,600' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css"/>
  </head>
  <body>
<?php
include  'class/class.bbcode.php';
include 'inc/navbar.php'; ?>

<div class="container">
<div class="card nobottom noradius noborder shadow">
  <div class="card-block nobottom">

    <?php
if(isset($_GET['c'])) {
$select = htmlspecialchars(str_replace('-', ' ', $_GET['c']));
$id = htmlspecialchars($_GET['id']);
$articles = $db->prepare("SELECT * FROM posts WHERE id = {$id } LIMIT 1;");
$articles->execute();
$articles = $articles->fetchAll(PDO::FETCH_ASSOC);
}
foreach($articles as $nieuws): ?>
<img class="thumbnail img-responsive notop" src="<?= $nieuws['image_url']; ?>">
<h1><?= ucfirst($nieuws['title']); ?></h1>
<em>Artikel geplaatst door <?= $nieuws['auteur']; ?> op <?= date("d-m-Y", strtotime($nieuws['date_added'])); ?> om <?= date("h:s", strtotime($nieuws['date_added'])); ?></em>
<p> <?= $propertyUbb->Parse($nieuws['content']); ?> </p>

<?php endforeach; ?>

</div>
</div>
