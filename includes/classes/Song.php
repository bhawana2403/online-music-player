<?php 

	class Song {

		private $id;
		private $con;
		private $mysqliData;
		private $title;
		private $genre;
		private $path;
		private $artistId;
		private $duration;
		private $albumId;

	public function __construct($con,$id) {
	$this->con= $con;	
	$this->id = $id;

	$query=mysqli_query($this->con,"SELECT * FROM songs WHERE id='$this->id'");
	$this->mysqliData=mysqli_fetch_array($query);
	$this->title = $this->mysqliData['title'];
	$this->genre = $this->mysqliData['genre'];
	$this->path = $this->mysqliData['path'];
	$this->artistId = $this->mysqliData['artist'];
	$this->albumId = $this->mysqliData['album'];
	$this->duration = $this->mysqliData['duration'];
	}

		public function getId(){
		return $this->id;
	}

		public function getDuration(){
		return $this->duration;
	}
		public function getGenre(){
		return $this->genre;
	}
		public function getTitle(){
		return $this->title;
	}
		public function getPath(){
		return $this->path;
	}
		public function getArtist(){
		return new Artist($this->con,$this->artistId);
	}
		public function getAlbum(){
		return new Album($this->con,$this->albumId);
	}
		public function getMySqliData(){
		return $this->mysqliData;
	}
}?>