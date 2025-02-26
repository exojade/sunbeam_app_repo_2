<?php
    if($_SERVER["REQUEST_METHOD"] === "POST") {

		if($_POST["action"] == "addUser"):
			// dump($_POST);
			$fullname = $_POST["username"];
			$fullname = str_replace(' ', '_', $fullname);
			$target_pdf = "uploads/users/";

			if($_FILES["profile_image"]["size"] != 0){
				
				$path_parts = pathinfo($_FILES["profile_image"]["name"]);
				$extension = $path_parts['extension'];
				$target = $target_pdf . "fullname" . "." . $extension;
                    if(!move_uploaded_file($_FILES['profile_image']['tmp_name'], $target)){
                        echo("FAMILY Do not have upload files");
                        exit();
                    }
			}

			else{
				$target="uploads/users/default.jpg";
			}
			$user_id = create_uuid("USR");
			if (query("insert INTO users (id, username, password, role, 
						fullname,active_remarks, gender, profile_image) 
			  VALUES(?,?,?,?,?,?,?,?)", 
				$user_id, $_POST["username"], password_hash("p@55word", PASSWORD_DEFAULT), $_POST["role"], strtoupper($_POST["fullname"]),
				"active",$_POST["gender"], $target) === false)
				{
					$res_arr = [
						"result" => "failed",
						"title" => "Failed",
						"message" => "User already Registered",
						"link" => "users",
						];
						echo json_encode($res_arr); exit();
				}

			// query("update users set profile_image = '".$target."'
			// 	where user_id = '".$user_id."'");	

		$res_arr = [
			"result" => "success",
			"title" => "Success",
			"message" => "Success",
			"link" => "users",
			];
			echo json_encode($res_arr); exit();
		
		elseif($_POST["action"] == "modalUpdateUser"):
			// dump($_POST);
			// dump($_POST);

			$user = query("select * from users where id = ?", $_POST["user_id"]);
			$user = $user[0];

			$html = "";

			$html .= '
				<input type="hidden" name="user_id" value="'.$_POST["user_id"].'">
				<div class="form-group">
					<label>Username</label>
					<input class="form-control" name="username" required value="'.$user["username"].'">
				</div>

				<div class="form-group">
					<label>Full Name</label>
					<input class="form-control" name="fullname" required value="'.$user["fullname"].'">
				</div>
				

				<div class="form-group">
					<label>Active Status</label>
					<select class="form-control" required name="active_remarks">
					<option value="'.$user["active_remarks"].'" selected>'.$user["active_remarks"].'</option>
					<option value="active" >active</option>
					<option value="inactive" >inactive</option>

					</select>
				</div>
			
			';

			echo($html);

		elseif($_POST["action"] == "updateUser"):
			// dump($_POST);

			query("update users set 
						username = ?,
						fullname = ?,
						active_remarks = ?
						where id = ?",
					$_POST["username"],
					$_POST["fullname"],
					$_POST["active_remarks"],
					$_POST["user_id"]
				);

				$res_arr = [
					"result" => "success",
					"title" => "Success",
					"message" => "User updated successfully",
					"link" => "users",
					];
					echo json_encode($res_arr); exit();

		elseif($_POST["action"] == "reset_password"):
			// dump($_POST);

			query("update users set password = ? where id = ?", password_hash("p@55word", PASSWORD_DEFAULT), $_POST["user_id"]);
			$res_arr = [
				"result" => "success",
				"title" => "Success",
				"message" => "Reset Password Successfully",
				"link" => "users",
				];
				echo json_encode($res_arr); exit();
		endif;
    }



	else {
			$users = query("select * from users");
			render("public/users_system/users_list.php",[
				"users" => $users,
			]);
	}
?>
