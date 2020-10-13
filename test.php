<!doctype html>
<html>
	<head>
		<style type="text/css">

			body
			{
				font-family: serif;
				margin:50px;
				padding:25px;
			}
			div
			{
				margin-top:25px;
				margin-bottom:25px;
			}

			input, textarea
			{
				float:right;
				width:100px;
				box-sizing: border-box;
				width:50%;
				border-radius:10px;
			}

			input
			{
				height:25px;
			}

			form
			{
				width:75%;
				margin:0 auto;
			}

			textarea
			{
				display:block;
				height:100px;
			}

			input[type='submit']
			{
				background: linear-gradient(white,#97c3cc);
				width:25%;
			}

			img
			{
				border: solid 1px black;
				border-radius: 5px;
			}

			figure
			{
				margin-left: 50px;
			}
			
		</style>
	</head>
	<body>
		<form method="post" enctype="multipart/form-data">
			<h1>
				Please upload a picture
			</h1>
			<?php

				function connect($servername, $usernameDB,$passwordDB)
				{
					$GLOBALS['conn'] = new mysqli($servername, $usernameDB, $passwordDB);
					// Check connection
					if ($GLOBALS['conn']->connect_error)
					{
						echo $GLOBALS['conn']->error;
					}
				}
				
				function useDB($dbname)
				{
					$sql="create database if not exists ".$dbname;
					$GLOBALS['conn']->query($sql);
					$sql="use ".$dbname;
					$GLOBALS['conn']->query($sql);
					$sql="SET time_zone = '+00:00'";
					$GLOBALS['conn']->query($sql);
				}

				if(!empty($_POST['upload']))
				{
					if(!empty($_POST['name']) && !empty($_POST['caption']) && !empty($_FILES['picture']['tmp_name']))
					{
						connect("localhost", "user1", "vv7xEQceR7W0VN2H");
						useDB("test");
						$name=addslashes($_POST['name']);
						$caption=addslashes($_POST['caption']);
						$image = addslashes(file_get_contents($_FILES['picture']['tmp_name']));
						$sql="insert into pictures(name,caption,picture) VALUES ('$name','$caption','$image')";
						$result=$GLOBALS['conn']->query($sql);
						if(!$result)
						{
							echo $GLOBALS['conn']->error;
						}
						else
						{
							$last_picture_id=$GLOBALS['conn']->insert_id;
							$sql="select * from pictures where pictureId='$last_picture_id'";
							$result=$GLOBALS['conn']->query($sql);
							if(!$result)
							{
								echo $GLOBALS['conn']->error;
							}
							else
							{
								if($result->num_rows>0)
								{
									$row=$result->fetch_assoc();
									echo "
											<figure>	
												<img src='data:image/jpeg;base64,".base64_encode( $row['picture'] )."' width='200' height='200'>
											<figcaption>".$row['name']." - ".$row['caption']."</figcaption></figure>";
								}
								else
								{
									echo "something went wrong :(";
								}
							}
						}
						$GLOBALS['conn']->close();
					}
					else
					{
						echo "Please enter a name, caption, and picture to upload";
					}
				}
			?>
			<div>
				<label for="name">
					Name:
				</label>
				<input type="text" id="name" name="name">
			</div>

			<div>
				<label for="picture">
					Choose a profile picture:
				</label>
				<input type="file" id="picture" name="picture" accept="image/png, image/jpeg, image/gif, image/jpg">
			</div>

			<div style="margin-bottom:150px;">
				<label for="caption">
					Caption:
				</label>
				<textarea id="caption" name="caption" cols="25" rows="5"></textarea>
			</div>

			<div>
				<input type="submit" id="upload" name="upload" value="upload">
			</div>
		</form>
	</body>
</html>