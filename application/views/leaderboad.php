<!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Quizoo</title>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		
		<style>
			/* body { padding-top: 70px; } needed to position navbar properly */
			img {
				height: 60px;
				width:60px;
				padding-right:5px;
			}
            .form-control{
                margin-top:6%;
            }
            .row{
                margin-top:2%;
            }
            button:disabled,
            button[disabled]{
            border: 1px solid #999999;
            background-color: #cccccc;
            color: #666666;
            }
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
			#editUsername{
				border-width:0;
				background-color:white;
			}
			.wrapper {
				display: grid;
				grid-template-columns: repeat(5, 1fr);
				gap: 10px;
				grid-auto-rows: minmax(50px, auto);
			}
		</style>
    </head>
    <body>
	<div>
			
	<div class="container">
		<div class="row" style="text-align: center;">
	       	<h1>Leaderboard</h1>
		</div>
		<div class="row" id="userInfor">
		</div>
        <table class="table">
            <thead>
                <tr>
                <th scope="col">Rank</th>
                <th scope="col">Username</th>
                <th scope="col">Score</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
		</div>
        <!-- div class="container" id="contentArea">
			<div class='row'>
                <div class='col-md-2'>
                    <h3>Email:</h3>
                </div>
                <div class='col-md-6'id="emailArea" ></div>
			</div>
            <div class='row'>
                <div class='col-md-1' style="margin:0;">
                    <h3>Username:</h3>
                </div>
				<div class='col-md-1' id="pencilArea"> 
					<button type="button" id="editUsername">
						<img src="<?php echo base_url() ?>/application/resource/edit.png" alt="edit" style="width:25px; height:25px; margin-top:15px; margin-left:5px ">
					</button>
                </div>
                <div class='col-md-3' id="usernameArea"></div>	
				<div class='col-md-2' id="usernameButtonArea"></div>	
				<div class='col-md-4' id="cancelButtonArea"> </div>
			</div>
            <div class='row'>
                <div class='col-md-2'>
                    <h3>Score:</h3>
                </div>
                <div class='col-md-6' id="scoreArea"></div>
			</div>
            <div class='row'>
                <div class='col-md-3'>
                    <h3>Change Password:</h3>
                </div>
                <div class='col-md-3'>
                    <input type="password" class="form-control rounded" placeholder="Enter current password" id="password" />
                </div>
                <div class='col-md-3'>
                    <input type="password" class="form-control rounded" placeholder="Enter new password" id="newPassword" />
                </div>
                <div class='col-md-3'>
                    <button type="button" class="buttonStyle" id="changePassword">
						Change password
					</button>
                </div>
			</div>
			<div class='row'>
                <div class='col-md-2'>
                    <h3>My Quizzes:</h3>
                </div>
                <div class='col-md-6' id="quizArea" class="wrapper"></div>
			</div>
        </div>< -->
	</div> <!-- container -->
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
		<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>
	

        <script language="Javascript">
		$(document).ready(function () {
			var User = Backbone.Model.extend({
				url: function () {
					return "<?php echo base_url() ?>index.php/userAuthentication/userRank";
				},
				idAttribute: "id",
				defaults: {
					username: null,
					score: null,
				}
			});

			var Users = Backbone.Collection.extend(
				{
					model : User,
					url: "<?php echo base_url() ?>index.php/userAuthentication/maxScoreUsers"
				}
			);

			// create collections object
			var users = new Users();
			var user = new User();

		

			var ContentAreaView = Backbone.View.extend(
				{
					model: user, 
					el : $('#contentArea'), 
					events : {
						"click #changeUsername" : "changeUsernameEvent",
						"click #editUsername" : "editUsernameEvent",
						"click #cancel" : "cancelEditEvent",
						"click #changePassword" : "changePasswordEvent",
						"click .quizButton" :"quizButtonEvent"
					},
					initialize : function () {
						users.fetch({async:false});
						user.fetch({async:false});
						console.log(users);
						
						console.log(user)
						this.render();
					},
					render : function () {
						var self = this;
						var count=0;
						$( "#userInfor" ).append( "<h3>"+user.get("username")+" Score "+user.get("score")+"</h3>");
						users.each(function (user) {
										$( "tbody" ).append( 
							`<tr>
								<th scope="row">`+count+`</th>
								<td>`+user.get('username')+`</td>
								<td>`+user.get('score')+`</td>
							</tr>`)
							count=count+1;
							})
						
						// users.get().forEach(function(questionAnswer) {
					
						// })
					},
					changeUsernameEvent : function (event) {
                        if($("#newUsername").val()){
							var result = user.save({username : $("#newUsername").val()});
							console.log(result);
							resetUsernameArea();
                        }
					},
					editUsernameEvent : function (event) {
						// console.log('x');
						$( "#pencilArea" ).empty();
						$( "#usernameArea" ).empty();
						$( "#usernameArea" ).append( "<input type='text' class=form-control rounded' id='newUsername' placeholder='Enter username'/>" );
						$( "#usernameButtonArea" ).append( "<button type='button' id='changeUsername' class='buttonStyle' style='margin-top:10%'>Change username</button>" );
						$( "#cancelButtonArea" ).append( "<button type='button' id='cancel' class='buttonStyle' style='margin-top:5%;background-color:grey; margin-left:-10%'>Cancel</button>" );
					
					},
					cancelEditEvent : function (event) {
						resetUsernameArea();
					},
					changePasswordEvent : function (event) {
                        if($("#password").val() && $("#newPassword").val()){
							var result = user.save({
								password : $("#password").val(),
								newPassword:$("#newPassword").val()
							});
							document.getElementById('password').value = '';
							document.getElementById('newPassword').value = '';;
							console.log(result);
							// console.log(result.responseJSON);
							// getResponseHeader
                    	}
					},
					quizButtonEvent: function(event){
						var id = $(event.currentTarget).data('id');
						console.log(id)
						window.location.href="<?php echo base_url()?>index.php/quizController/editQuiz/"+id;
					}
				}
			)
			
		

			// var Celebrities = Backbone.Collection.extend(
			// 	{
			// 		model : Celeb,
			// 		url: "http://localhost:8999/6cosc005w/ilikecelebs/index.php/celebs/celeb"
			// 	}
			// )
            // var self = this;
            //             var cimg = "<div class='row'><div class='col-md-2'><h3>Email:</h3></div><div class='col-md-6'> <h3>"+ 
            //            user.get('email') +
            //            "</h3> </div> </div>  <div class='row'> <div class='col-md-2'> <h3>Username:</h3>  </div> <div class='col-md-6'> <h3>
            //            user.get('username') + "</h3>  </div></div>"
			// create collections object
			var contentView = new ContentAreaView();
			
		});
		</script>
			
    </body>
    </html>