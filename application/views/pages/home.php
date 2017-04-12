
<style>
    body{
        background-color: black;
        background-image: url("<?= $this->config->item('image_url').'assets/';?>images/trails_small_bg.jpg");
        background-repeat: no-repeat;
        background-position: right top;
        background-attachment: fixed;
    }
    
    
    #full_site{
        width: 1100px;
        margin: auto;
    }
    #header_main{
        height: 750px; 
    }
    
    #header_name{
        color : hotpink;
        font-family: serif;         
        text-transform: uppercase;
        font-size: 500%
    }
	.image { 
   position: relative; 
   width: 100%; /* for IE 6 */
}

h2 { 
   position: absolute; 
   top: 270px; 
   left: 0; 
   width: 100%; 
}
	
h2 span { 
   color: white; 
   font: bold 48px/45px Helvetica, Sans-Serif; 
   letter-spacing: -1px;  
   background: rgb(0, 0, 0); /* fallback color */
   background: rgba(0, 0, 0, 0.7);
   padding: 10px; 
}
    
   
#update_banner {
    background-color: black;
    width: 800px;
    height: auto;
    border-radius: 25px;
    border-color: hotpink;
    border-style: solid;
    border-width: thick;
    margin-top: 10px;
    margin-bottom: 10px;
    margin-left: auto;
    margin-right: auto;
    color: white;
    font-size: larger;
    font-style: italic; 
    padding: 10px;
}

    #points_area{
        border-radius: 25px;
        padding: 10px;
        margin-top: 20px; 
        margin-left: auto ;
        margin-right: auto ; 
    }
 
</style>
<?php
date_default_timezone_set('America/Denver');
 if  ($this->session->active){ ?>
           </br>
           </br>
<a href="<?= site_url('pages/admin/home') ?>">ADMIN PAGE</a>
<a href="<?= site_url('pages/index/logout') ?>">LOGOUT</a>
          
<?php }?>
<div id="main_body" class="container-fluid">
    <div id="full_site">
    <div id="header_main">
        <div id="header_upper" class="image"> 
			<h2><span><?= date("Y/m/d"); ?> </span></h2>		
			<img src="<?= $this->config->item('image_url').'assets/' ?>images/tp_logo.jpg" class="img-rounded img-responsive" alt="Cadence Poker" > 
		</div>            
        
    </div>
<div id="update_banner" class="jumbotron">
   <p class='update_message'> <?= $update; ?> </p>
   </br>
   <div id="points_area"><?= $points_view; ?></div>
</div>

</div></div>