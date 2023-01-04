<!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Quizoo</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		
		<style>
			body { padding-top: 70px; } /* needed to position navbar properly */
            .buttonStyle {
                background-color: #4D47C3;
				padding: 6px 15px;
				border: none;
				color: white;
				text-align: center;
				text-decoration: none;
				display: inline-block;
				font-size: 14px;
				cursor: pointer;
                margin-top:6%;
            }
		</style>
    </head>
    <body>
        <div class="container">
            <div class='row' style="margin-top:15%">
                <div class="col-md-4">
                    <h1>Congratulations you completed the quiz!</h1>
                    <h1>Score : <?php echo $score ?></h1>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-6">
                    <img src="<?php echo base_url() ?>/application/resource/congratulations.png" alt="congratulations">	
                </div>
            </div>
            <div class="row">
                    
                    <div class='col-md-2'>
                        <button type="button"class="buttonStyle" onClick="window.history.back()" >
                            Try Again
                        </button>
                    </div>
                    <div class='col-md-2'>
                        <button type="button" class="buttonStyle" id="addQuestion" onClick="window.location.href = '<?php echo base_url()?>index.php/userAuthentication/home';" style="background-color:grey;">
                            Go to home
                        </button>
                    </div>		
            </div>
        </div> 
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
		<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>	
    </body>
</html>