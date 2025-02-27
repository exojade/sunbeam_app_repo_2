<?php
    if($_SERVER["REQUEST_METHOD"] === "POST") {


		if($_POST["action"] == "notifications_list"):
			// dump($_REQUEST);
			$draw = isset($_POST["draw"]) ? $_POST["draw"] : 1;
			$offset = $_POST["start"];
			$limit = $_POST["length"];
			$search = $_POST["search"]["value"];

			$limitString = " limit " . $limit;
			$offsetString = " offset " . $offset;

			$where = " where receiver_id = '".$_SESSION["sunbeam_app"]["userid"]."'";

		

			if($search != ""):
			$where .= ' and (firstname like "%'.$search.'%" or surname like "%'.$search.'%" or username like "%'.$search.'%")';
			$baseQuery = "select u.*,r.role_name from users u 
						left join roles r on r.id = u.role_id" . $where;
			else:
				$baseQuery = "select * from notification" . $where . " order by created desc";
			endif;

			$data = query($baseQuery . $limitString . " " . $offsetString);
			$all_data = query($baseQuery);

			$Users = [];
			$users = query("select * from users");
			foreach($users as $row):
				$Users[$row["id"]] = $row;
			endforeach;



			$i = 0;
			foreach($data as $row):
				$message=unserialize($row["message"]);
				$data[$i]["number"] = $i + 1;
				$data[$i]["message"] = '<a href="notifications?action=read&id='.$row["notification_id"].'">'.$message["message"].'</a>';
				$data[$i]["date"] = date("F d, Y", $row["created"]);
				$i++;
			endforeach;
			$json_data = array(
				"draw" => $draw + 1,
				"iTotalRecords" => count($all_data),
				"iTotalDisplayRecords" => count($all_data),
				"aaData" => $data
			);
			echo json_encode($json_data);

		endif;
	}
	else {

			if(!isset($_GET["action"])):
				$users = query("select * from users");
				render("public/notifications_system/notifications_list.php",[
				]);
			else:
				if($_GET["action"] == "read"):
					$notif = query("select * from notification where notification_id = ?", $_GET["id"]);
					$notif = $notif[0];
					$theMessage = unserialize($notif["message"]);

					query("update notification set read_at = ? where notification_id = ?", time(), $_GET["id"]);
					redirect($theMessage["link"]);
				endif;
			endif;

			
	}
?>
