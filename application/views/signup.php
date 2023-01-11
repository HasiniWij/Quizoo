<!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Quizoo</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<style>
			h5{
				color:red;
			}
		</style>
    </head>
    <body>
	<div class="container" id="contentarea">
		<div class='row'>
            <div class="col-md-6">
                <h1>Sign Up to </h1>
				<h2>Quizoo</h2>
				<p>If you already have an account</p>
                <p>You can <a href="<?php echo base_url()?>index.php/userAuthentication/signinView"> login here! </a></p>
            </div>
            <div class="col-md-6">
				<h2>Sign up</h2>
					<input class="form-control rounded" placeholder="Enter email" aria-label="email" id="email"/>
					<input  class="form-control rounded" placeholder="Create Username" aria-label="username" id="username" />
					<input class="form-control rounded" placeholder="password" aria-label="password" id="password" />
					<input  class="form-control rounded" placeholder="confirmPassword" aria-label="confirmPassword" id="confirmPassword" />
					<div id="errorMessage"></div>
					<button type="button" class="btn btn-outline-primary" id='register'>Register</button>
			</div>
        </div>
	</div> 
    		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
		<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
		<script>
			$(document).ready(function(){
						$("#register").click(function(event){
							
							if(!$("#email").val() || !$("#username").val() || !$("#password").val() ){
								document.getElementById("errorMessage").innerHTML =
           							 "<h5>Please fill all the fields </h5>";
							}
					
							else if($("#confirmPassword").val()==$("#password").val()){
							var obj  = $.ajax(
								{
									url: "<?php echo base_url()?>index.php/userAuthentication/user",
									method:'POST',
									data: {'email':$("#email").val(), 'username':$("#username").val(), 'password':$("#password").val()}
								}
							);
							console.log("x");
							obj.done(function(data){
								console.log("false");
								document.location.href = "<?php echo base_url()?>index.php";
							});
							}
							 
							else{
								document.getElementById("errorMessage").innerHTML =
           							 "<h5>Confirm password mismatch</h5>";
							}

						});

					});
		</script>			
    </body>
    </html>