

<?php include('includes/includedFiles.php')?>

<!--Add bootstrap-->

	<h1 class="pageHeadingBig">You Might Also Like</h1>
	<div class="gridVeiwContainer">
		
		<div class="row">
		<?php $albumQuery=mysqli_query($con, "SELECT * FROM albums ORDER BY RAND() LIMIT 10");
		while($row=mysqli_fetch_array($albumQuery)){
			echo "
			<div class='column gridViewItem'>
			<span role='link' tabindex='0' onclick='openPage(\"albums.php?id=".$row['id']."\")'>
			<img src='".$row['artworkPath']."'>
			<div class='gridViewInfo'>"
			.$row['title'].
			"</div> 
			</span>
			</div>
			";
		}
		 ?>
		</div>
	</div>

	