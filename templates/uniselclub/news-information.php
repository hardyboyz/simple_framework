<?php
if( !defined( "_HARDYBOYZ_FRAMEWORK_" ) )
{
	header("HTTP/1.0 404 Not Found");
	exit();
}
?>
<div class="alert alert-info" id="register_success" style="display:none"></div>
<div class="container">
	<div class="row">
		<div class="col-md-6">
			<h1 class="page-title text-left">News</h1>
			<hr>
		<?php
		if(isset($_GET['news_id'])){
			$id = (int) $_GET['news_id'];
			$contents = get_news_info($id);
		}else{
			$contents = get_news_info();
		}

		foreach($contents as $news){ 
			if($news['category']==1) {
			?>
			
			<article class="blogpost shadow light-gray-bg bordered">
			<h3 class="page-title"><a href="?details&id_news="<?= $news['id_news'] ?>"></a><?=$news['title'] ?></a></h3> 
			<div class="separator-content'></div>
			<div class="blogpost-content">
				<p><?= $news['content'] ?></p>
			</div>
			
			<?php
			}
		}
		?>
		</article>
		</div>
		
		<div class="col-md-6">
			<h1 class="page-title text-right">Information</h1>
			<hr>
		<?php
		if(isset($_GET['news_id'])){
			$id = (int) $_GET['news_id'];
			$contents = get_news_info($id);
		}else{
			$contents = get_news_info();
		}

		foreach($contents as $news){ 
			if($news['category']==2) {
			?>
			<article class="blogpost shadow light-gray-bg bordered text-right">
			<h3 class="page-title"><a href="?details&id_news="<?= $news['id_news'] ?>"></a><?=$news['title'] ?></a></h3> 
			<div class="separator-content'></div>
			<div class="blogpost-content">
				<p><?= $news['content'] ?></p>
			</div>
			
			<?php
			}
		}
		?>
		</article>
		</div>
</div>
