<!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Quizoo</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		
		<style>
			body { padding-top: 70px; } 
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
            .titleStyle{
                margin-top:15%
            }
            #exitButton{
               background-color:grey
            }
            img{
                height:250px;
                width:250px;
            }
		</style>
    </head>
    <body>
        <div class="container contentView">
            <div class='row titleStyle'>
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
                        <button type="button"class="buttonStyle" id="tryAgainButton" >
                            Try Again
                        </button>
                    </div>
                    <div class='col-md-2'>
                        <button type="button" class="buttonStyle" id="exitButton">
                            Go to home
                        </button>
                    </div>		
            </div>
        </div> 
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
		<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>
		
        <script language="Javascript">
		$(document).ready(function () {
			var ContentAreaView = Backbone.View.extend(
				{
					el : $('#contentView'),
					events : {
						"click #tryAgainButton" : "tryAgainEvent",
                        "click #exitButton" : "exitEvent"
					},
					exitEvent : function (event) {
                        console.log("in")
                        document.location.href  = '<?php echo base_url()?>index.php'
					},
                    tryAgainEvent : function (event) {
                        // onClick="window.history.back()"
						// document.location.href = "<?php echo base_url()?>index.php/SearchQuizController/browseQuizzesView/tag/"+$("#keywords").val();
					}
				}
			)

			var contentView = new ContentAreaView();
		});
		</script>
    </body>
</html>