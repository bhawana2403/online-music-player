<?php
include("includes/includedFiles.php");
if(isset($_GET['term'])){
	$term = urldecode($_GET['term']);

}
else{
	$term = "";
}
?>
<div class="searchContainer">
	<h4>Search for an album, song or artist</h4>
<input type="text" class="searchInput" value="<?php echo $term;?>" placeholder="Start Typing..." 
onfocus='this.value=this.value'>

</div>
<script>
	$(".searchInput").focus();	

	$(function(){
	
	$(".searchInput").keyup(function(){
		clearTimeout(timer);
		timer = setTimeout(function(){
			var val = $(".searchInput").val();
			openPage("search.php?term="+val);
		},2000);
	})	
	})
</script>
<?php if($term =="") exit();?>

<div class="tracklistContainer borderBottom">
	<h2 style="text-align: center;">SONGS</h2>	
	<ul class="tracklist">
		<?php
		$songsQuery = mysqli_query($con,"SELECT id FROM songs WHERE title LIKE '$term%' LIMIT 10");
		 
		 if(mysqli_num_rows($songsQuery) == 0){
		 	echo "<span class='noResults'>No matching songs found for ". $term ."</span>"; 
		 }

		 $i=1;

		$songIdArray=array();
		while ($row = mysqli_fetch_array($songsQuery)) {
			# code...
			if($i > 15 ){
				break;
			}
			array_push($songIdArray, $row['id']); 


			$albumSong = new Song($con,$row['id']);
			$albumArtist= $albumSong->getArtist();
			echo "<li class='tracklistRow'>
			
			<div class='trackCount'>
			<img class='play' src='assets/images/icons/play-white.png' onclick = 'setTrack(\"".
			$albumSong->getId()."\",tempPlaylist, true)'/>
			<span class='tracknumber'>$i</span>
			</div>

			<div class='trackInfo'>
			<span class='trackNamee'>".$albumSong->getTitle()."</span>
			<span class='artistNamee'>".$albumArtist->getName()."</span>
			</div>

			<div class='trackOptions'>
			<input type='hidden' class='songId' value='" . $albumSong->getId() . "'>
			<img class='optionsButton' src='assets/images/icons/more.png' onclick='showOptionsMenu(this)'>
			</div>

			<div class='trackDuration'>
			<span class='duration'>".$albumSong->getDuration()."</span>
			</div>

			</li>";
			$i++;
		}?>

		<script>
			var tempSongIds = '<?php echo json_encode($songIdArray);?>';
			tempPlaylist = JSON.parse(tempSongIds);
			
		</script>
		
	</ul>
	</div>

<div class="artistsContainer borderBottom">
	<h2 style="text-align: center;">
		ARTISTS
	</h2>
		<?php 
		$artistQuery = mysqli_query($con,"SELECT id FROM artist WHERE name LIKE '$term%' LIMIT 10");
		if(mysqli_num_rows($artistQuery) == 0){
		 	echo "<span class='noResults'>No matching artists found for ". $term ."</span>";
		 }
		 	while($row = mysqli_fetch_array($artistQuery)) 
		 {	$artistFound = new Artist($con,$row['id']);

		 	echo "<div class= 'searchresultRow'>
		 			<div class='artistName'>
		 				<span role='link' tabindex='0' onclick='openPage(\"artist.php?id=" .$artistFound->getId()."\" )'>
		 				".$artistFound->getName()."
		 				</span>
		 				
		 			</div>
		 		</div>" ;

		 }

?>
	
</div>

<div class="gridVeiwContainer">
		<h2 style="text-align: center;">ALBUMS</h2>

		<?php $albumQuery=mysqli_query($con, "SELECT * FROM albums WHERE title LIKE '$term%' LIMIT 10");

		if(mysqli_num_rows($albumQuery) == 0){
		 	echo "<span class='noResults'>No matching artists found for". $term ."</span>";
		 }

		while($row=mysqli_fetch_array($albumQuery)){
			echo "<div class='gridViewItem'>
			<span role='link' tabindex='0' onclick='openPage(\"albums.php?id=".$row['id']."\")'>
			<img src='".$row['artworkPath']."'>
			<div class='gridViewInfo'>"
			.$row['title'].
			"</div> 
			</span>
			</div>";
		}
		 ?>
		
	</div>

	<nav class="optionsMenu">
	<input type="hidden" class="songId">
	<?php echo Playlist::getPlaylistsDropdown($con, $userLoggedIn->getUsername()); ?>
</nav>
