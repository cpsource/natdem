<?php
$cp_border = false;

?>

<!-- <body> -->

<?php
// setup our configuration
include 'config.php';
?>

<div class="container">
    <div class="left-column-a">
    </div>
    <div class="right-column-b darker-green-bg">
      <div class="row">
	
	<div class="col-md-4 black-border">
          <div class="p-3 border bg-light">
            <!-- Content for the first column -->
	    <img src="rights/author/Bill_Page_In_Uniform.jpg" alt="Bill Page in Uniform" class="img-fluid">
          </div>
	</div>

	<div class="col-md-4 center-content black-border">
          <div class="p-3 border bg-light">
            <!-- Content for the second column -->
	    <h1 class="text-black">Natural Democracy</h1>
	    <p>Natural Democracy by William R. Page</p>
          </div>
	</div>

	<div class="col-md-4 black-border">
	  <div class="p-3 border bg-light">
	    <!-- Content for the third column -->
            <img src="./images/WRPBookCover.jpg" alt="WRP Book Cover" class="img-fluid">
	  </div>
	</div>
      </div>
    </div>
</div>

    <hr class="custom-hr">

<div class="container mt-5 text-center">
    <h1 class="mb-4">Natural Democracy Podcast</h1>
    
    <!-- Audio Player -->
    <audio id="podcastAudio" src="audio/NatDem.mp3"></audio>
    
    <!-- Play Button -->
    <button onclick="document.getElementById('podcastAudio').play()" 
            class="btn btn-primary btn-lg">
        Play Podcast
    </button>
</div>

    <hr class="custom-hr">

<!-- </body> -->

