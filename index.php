<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <?php include 'inc/config.php'; ?>
    <title><?=SITENAAM; ?> | Home</title>
    <link rel="stylesheet" href="/css/bootstrap.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="/css/custom.css" media="screen" title="no title" charset="utf-8">
    <link href='//fonts.googleapis.com/css?family=Raleway:400,300,600' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css"/>
  </head>
  <body>
    <?php include 'inc/navbar.php';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = '15';
$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

$articles = $db->prepare("
  SELECT SQL_CALC_FOUND_ROWS *
  FROM posts
    ORDER BY date_added ASC
  LIMIT 0, {$perPage};
  ");
$articles->execute();
$articles = $articles->fetchAll(PDO::FETCH_ASSOC);
$total = $db->query("SELECT FOUND_ROWS() as total")->fetch()['total'];
$pages = ceil($total / $perPage);
?>
  <div class="container">
  <div class="col-lg-9">

    <?php foreach($articles as $blog): ?>
      <div class="card noradius noborder shadow">
        <div class="card-block">
          <?php $url = '/artikel/'.$blog["id"].'-'.str_replace(" ", "-", $blog['title']); ?>
				<a href="<?= $url; ?>" class="head-link"><h3 class="title" href="henk"><?= $blog['title']; ?></h3></a>
          <img class="thumbnail img-responsive" src="<?= $blog['image_url']; ?>">
          <p class="date"><i class="fa fa-clock-o"></i> 18 minuten geleden geplaatst door <?= $blog['auteur']; ?></p>

				<div class="text">
					<?= substr($blog['content'], 0, 100); ?>
				</div>
			</div>
    </div>
  <?php endforeach; ?>
</div>



<div class="col-lg-3">
  <a class="btn btn-block btn-social bg-facebook" onclick="_gaq.push(['_trackEvent', 'btn-social', 'click', 'btn-facebook']);"><span class="fa fa-facebook"></span> Like ons op Facebook</a>
  <a class="btn btn-block btn-social bg-twitter" onclick="_gaq.push(['_trackEvent', 'btn-social', 'click', 'btn-twitter']);"><span class="fa fa-twitter"></span> Volg ons op Twitter</a>
  <a class="btn btn-block btn-social bg-instagram" onclick="_gaq.push(['_trackEvent', 'btn-social', 'click', 'btn-instagram']);"><span class="fa fa-instagram"></span> Volg ons op Instagram</a>

</div>
<div class="col-lg-12">

          <?php for($x = 1; $x <= $pages; $x++): ?>
          <a href="#"<?php echo $x; ?> </a></a>
          <ul class="pagination pull-xs-left">
          <li class="page-item"><a class="page-link" href="?page=1">« Eerste</a></li>
          <li class="page-item <?php if($page == $x) {echo 'active';} ?>"><a class="page-link" href="?page=<?php echo $x; ?>"><?php echo $x; ?></a></li>
          <li class="page-item"><a class="page-link" href="?page=<?php echo $pages; ?>">Laatste »</a></li>
          <li class="page-item">
          </li>
          </ul>
          <?php endfor; ?>

<div class="pull-xs-right">
<div class="btn-group pagination" role="group" aria-label="Social stuff">
<a type="button" class="btn bg-twitter"><i class="fa fa-twitter"></i> Twitter</a>
<a type="button" class="btn bg-instagram"><i class="fa fa-instagram"></i> Instagram</a>
<a type="button" class="btn bg-facebook"><i class="fa fa-facebook"></i> Facebook</a>
</div></div></div>


  </body>
</html>
