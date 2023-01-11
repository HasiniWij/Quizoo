<!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Quizoo</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<style>
			body { padding-top: 70px; } 

			img {
				height: 175px;
				border-radius: 10px;
			}
			h5{
				color:red;
			}
		</style>
    </head>
    <body>
	<div class="container">
		<div class='row'>
            <div class="col-md-6">
                <h1>Signin to </h1>
				<h2>Quizoo</h2>
				<p>If you don't have a account you can register now</p>
				<p>You can <a href="<?php echo base_url()?>index.php/userAuthentication/signupView">Register Here</a></p>
            </div>
            <div class="col-md-6">
				<h2>Sign in</h2>
				<div id="errorMessage"></div>
				<input class="form-control rounded" placeholder="Enter email" aria-label="email" aria-describedby="search-addon" id="email" />
				<input  class="form-control rounded" placeholder="password" aria-label="password" aria-describedby="search-addon" id="password"/>
                <button type="button" class="btn btn-outline-primary" id="login">Login</button>
            </div>
        </div>
	</div> 
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
		<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
		
		<script>
			$(document).ready(function(){
						$("#login").click(function(event){
							event.preventDefault();
							var obj  = $.ajax(
								{
									url: "<?php echo base_url()?>index.php/userAuthentication/authenticate",
									method:'POST',
									data: {'email':$("#email").val(), 'password':$("#password").val()}
								}
							);
							obj.done(function(data){
								if(data){
									document.location.href = "<?php echo base_url()?>index.php";
								}
								else{
									document.getElementById("errorMessage").innerHTML =
           							 "<h5>Invalid username or password entered</h5>";
								}
							});

						});
					});
		</script>			
    </body>
    </html>