<?php
ini_set('auto_detect_line_endings',TRUE);
$row = 1;
$csv_data = array();
if (($handle = fopen("data.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
		if($row++ == 1) continue;
        for ($c=0; $c < $num; $c++) {
			$csv_data[$row][] = $data[$c];
        }
    }
    fclose($handle);
}

function getItemId($str) {
	$extension = pathinfo($str, PATHINFO_EXTENSION);
    $regexp = '@\.'.$extension.'$@';
    return preg_replace("!_!","",preg_replace($regexp, "", $str));
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Kijiji Sale Items</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="css/bootstrap-lightbox.min.css" rel="stylesheet" media="screen">
	<link href="css/styles.css" rel="stylesheet" media="screen">
	<style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
  </head>
  <body>

	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="brand" href="#">Kijiji House Sale</a>
				<div class="nav-collapse collapse">
					<ul class="nav">
						<li class="active"><a href="#">Top</a></li>
						<?php foreach($csv_data as $item): ?>
							<?php if(!empty($item[0]) && empty($item[3])): ?>
								<li><a href="#<?php print preg_replace("![^A-z]!","",$item[0]); ?>"><?php print $item[0]; ?></a></li>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row-fluid">
			<h1>House Sale</h1>
			<p>House being demolished, everything available for sale, including windows, doors hardwood floors,
				 electrical plates etc. If you are interested in any of the items below, or would like to inquire about
				 items not listed, please feel free to contact me.</p>
			 Contact Tania via email <a href="mailto:tania_daf@hotmail.com?subject=House%20Sale">tania_daf@hotmail.com</a> or phone 416-931-9699</p>
		</div>
		
		<?php $i = 0;?>
		<div class="row-fluid">
		<?php foreach($csv_data as $item): ?>
			<?php if(!empty($item[0]) && empty($item[3])): ?>
				</div><div class="row-fluid"><a id="<?php print preg_replace("![^A-z]!","",$item[0]); ?>">&nbsp;</a><h2><?php print $item[0]; ?></h2>
					<?php 
						$i = 0; 
						continue;
					?>
			<?php endif; ?>
		<?php if($i++ % 3 == 0):?></div><div class="row-fluid"><?php endif; ?>
			<div class="span4 text-center item">
				<a data-toggle="lightbox" href="#<?php echo getItemId($item[0]); ?>">
					<img src="thumbnails/<?php echo $item[0]; ?>" class="thumbnail" />
					<?php if(isset($item[4]) && $item[4]): ?><span class="sold">Sold</span><?php endif; ?>
					<br />
					<?php echo $item[1]; ?> - <?php echo $item[3]; ?>
				</a>
			</div>
		<?php endforeach; ?>
		</div>

		<?php foreach($csv_data as $item): ?>
		<div id="<?php echo getItemId($item[0]); ?>" class="lightbox hide fade" role="dialog" aria-hidden="true">
			<div class="lightbox-content">
				<img src="images/<?php echo $item[0]; ?>" />
				<div class="lightbox-caption">
					<h2><?php echo $item[1]; ?></h2>
					<h3><?php echo $item[3]; ?></h3>
					<p><?php echo $item[2]; ?></p>
				</div>
			</div>
		</div>
		<?php endforeach; ?>
	</div> <!-- /container -->


    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script src="js/bootstrap-lightbox.min.js"></script>
  </body>
</html>
