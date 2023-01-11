<!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Quizo</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		
		<style>
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
			.editIconStyle{
				width:25px;
				height:25px;
				margin-top:15px;
				margin-left:5px;
			}
			.quizButtonStyle{
				margin-left:20px;
			}
			.titleStyle{
				text-align: center;
			}
			.usernameStyle{margin:0;}
			.renameButtonStyle{margin-top:10%}
			.cancelButtonStyle{margin-top:5%;background-color:grey; margin-left:-10%}
		</style>
    </head>
    <body>
	<div>
		<div class="titleStyle">
	       	<h1>Profile</h1>
		</div>
        <div class="container" id="contentArea">
			<div class='row'>
                <div class='col-md-2'>
                    <h3>Email:</h3>
                </div>
                <div class='col-md-6'id="emailArea" ></div>
			</div>
            <div class='row'>
                <div class='col-md-1 usernameStyle'>
                    <h3>Username:</h3>
                </div>
				<div class='col-md-1' id="pencilArea"> 
					<button type="button" id="editUsername">
						<img src="<?php echo base_url() ?>/application/resource/edit.png" class="editIconStyle" alt="edit">
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
        </div>
	</div> 
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
		<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>
	

        <script language="Javascript">
		$(document).ready(function () {
			var User = Backbone.Model.extend({
				url: function () {
					return "<?php echo base_url() ?>index.php/userAuthentication/user";
				},
				idAttribute: "id",
				defaults: {
					email: null,
					username: null,
					score: null,
					quizzes:null
				}
			});

			var user = new User();

			function resetUsernameArea() {
				$( "#pencilArea" ).append( 
					`<button type="button" id="editUsername">
						<img src="<?php echo base_url() ?>/application/resource/edit.png" alt="edit" class="editIconStyle">
					</button>`
				);
				$( "#usernameArea" ).empty();
				$( "#usernameArea" ).append( "<h3>"+ user.get('username') + "</h3>");
				$( "#usernameButtonArea" ).empty();
				$( "#cancelButtonArea" ).empty();
			}

			var ContentAreaView = Backbone.View.extend({
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
						user.fetch({async:false});
						this.render();
					},
					render : function () {
						$( "#emailArea" ).append( "<h3>"+ user.get('email') + "</h3>");
						$( "#usernameArea" ).append( "<h3>"+ user.get('username') + "</h3>");
						$( "#scoreArea" ).append( "<h3>"+ user.get('score') + "</h3>");
						if(user.get('quizzes')){
							user.get('quizzes').forEach(function(quiz) { 
								$( "#quizArea" ).append( 
									"<button class='buttonStyle quizButton quizButtonStyle' data-id='"+quiz.quizId+"'>"
										+quiz.title+
									"</button>"
								);
							});
						}
						else{
							$( "#quizArea" ).append( "<h3>-</h3>");
						}
					},
					changeUsernameEvent : function (event) {
                        if($("#newUsername").val()){
							var result = user.save({username : $("#newUsername").val()});
							resetUsernameArea();
                        }
					},
					editUsernameEvent : function (event) {
						$( "#pencilArea" ).empty();
						$( "#usernameArea" ).empty();
						$( "#usernameArea" ).append( 
							"<input type='text' class=form-control rounded' id='newUsername' placeholder='Enter username'/>"
						);
						$( "#usernameButtonArea" ).append(
							 `<button type='button' id='changeUsername' class='buttonStyle renameButtonStyle'>
							 	Change username
							</button>`
						);
						$( "#cancelButtonArea" ).append( 
							`<button type='button' id='cancel' class='buttonStyle cancelButtonStyle'>
								Cancel
							</button>`
						 );
					
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
							document.getElementById('newPassword').value = '';
                    	}
					},
					quizButtonEvent: function(event){
						var id = $(event.currentTarget).data('id');
						window.location.href="<?php echo base_url()?>index.php/quizController/editQuizView/"+id;
					}
			})
			
			var contentView = new ContentAreaView();
			
		});
		</script>
			
    </body>
    </html>