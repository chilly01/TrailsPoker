
		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="container-fluid">
			<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>                        
      </button>
				<a class="navbar-brand" href="#image_header">Cody Hillyard</a>
			</div>
			<div class="collapse navbar-collapse" id="myNavbar">
			<ul class="nav navbar-nav">
				<li><a href="#home">Home</a></li>				
				<li><a href="#store">Store</a></li>			
				<li><a href="#resume">Resume</a></li>
				<li><a href="#blog">Blog</a></li>
				<li><a href="#projects">Projects</a></li>
			</ul>
			</div></div>
		</nav>
            <div id="background_container" class="container-fluid">
              
		<div id="image_header">
                </div>
                <div id="news_feed" class="row content">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-8 text-left">
                    <div id="home">
                     <div class="ch_msg">
                         <img src="<?= $this->config->item('image_url').'assets/images/';?>lucky_small.png"/>

				<h1>Cody Hillyard</h1>
				<p>Born and raised in Logan Utah.</p>
                    </div>
			<div class="ch_act">
                            <div class='list-group'>
                                <a href='https://www.linkedin.com/in/cody-hillyard' target="_blank" class='list-group-item'><i class="fa fa-linkedin-square" aria-hidden="true"></i> LinkedIn</a>
                                <a href='https://www.facebook.com/cody.hillyard' target="_blank" class='list-group-item'><i class="fa fa-facebook-square" aria-hidden="true"></i> Facebook</a>
                                <a href='https://twitter.com/chillyard' target="_blank" class='list-group-item'><i class="fa fa-twitter-square" aria-hidden="true"></i> Twitter</a>
                                <a href='https://github.com/chilly01' target="_blank" class='list-group-item'><i class="fa fa-github-square" aria-hidden="true"></i> GitHub</a>
                                <a data-toggle="modal" data-target="#myModal" class='list-group-item'><i class="fa fa-envelope-open" aria-hidden="true"></i> Email</a>
                            </div>
		</div>
		</div>
		<div id="store" >
			<div class="ch_msg">
				<h1>Things I'm trying to sell</h1>
				<p>please browse through the items I have listed here and contact me if you want to buy any of them</p>
			</div>
			<div class="ch_act">
                        <div id="accordion" role="tablist" aria-multiselectable="true">
  <div class="card">
    <div class="card-header" role="tab" id="headingOne">
      <h5 class="mb-0">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Collapsible Group Item #1
        </a>
      </h5>
    </div>

    <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
      <div class="card-block">
          <p> this is my test </p>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" role="tab" id="headingTwo">
      <h5 class="mb-0">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Collapsible Group Item #2
        </a>
      </h5>
    </div>
    <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
      <div class="card-block">
          <p>Placeholder for ps_3 games</p>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" role="tab" id="headingThree">
      <h5 class="mb-0">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Collapsible Group Item #3
        </a>
      </h5>
    </div>
    <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree">
      <div class="card-block">
          <p>Placeholer for other things to sell</p> </div>
    </div>
  </div>
</div>
			
		</div>
		</div>
                        
                <div id="resume" >
			<div class="ch_msg">
				<h1> Cody Hillyard</h1>
				<p>This is a test of the programming and web site building skills you have</p>
			</div>                   
			<div class="ch_act">
			
		</div>
		</div>
		
		
		<div id="blog" >
			<div class="ch_msg">
				<h1> Cody Hillyard</h1>
				<p>This is a test of the programming and web site building skills you have</p>
			</div>
			<div class="ch_act">
			
		</div>
		</div>
		
		<div id="projects">
			<div class="ch_msg">
                            
				<h1 > Cody Hillyard</h1>
				<p>Tic Tac Toe in ReactJS</p>
                                <br/>                                
                            <div id="react_box"></div>
                            <script src="https://unpkg.com/react@15/dist/react.js"></script>
                            <script src="https://unpkg.com/react-dom@15/dist/react-dom.js"></script>
                            <script src="<?= $this->config->item('image_url').'assets/' ?>react/tictactoe.js"></script>
                            <link rel="stylesheet" href="<?= $this->config->item('image_url').'assets/' ?>react/index.css">
               
			</div>
			<div class="ch_act">
                            <a href="<?=$this->config->item('image_url').'assets/' ?>react/index.js">React Code</a>
                            
			
		</div>
		</div>
            </div>
                    </div>
                </div>

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">My Personal Email</h4>
        </div>
        <div class="modal-body">
          <p>You can email me at: codyhillyard@gmail.com</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
            	
