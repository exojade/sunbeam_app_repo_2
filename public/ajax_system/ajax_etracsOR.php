<?php
// dump($_REQUEST);

use mikehaertl\pdftk\Pdf;

    if($_SERVER["REQUEST_METHOD"] === "POST") {
	

    


        if($_POST["action"] == "etracsOR"){
            // dump($_POST);
           $html = "";
            // if($_POST["options"] == "etracs"):
                $cashreceipt = query_etracs("SELECT * FROM cashreceipt WHERE receiptno = ?", $_POST["official_receipt"]);
                if(empty($cashreceipt)):
                  $html .= "<h1>Receipt Not Found!</h1>";
                else:
                  $cashitems =  query_etracs("SELECT * FROM cashreceiptitem WHERE receiptid = ?", $cashreceipt[0]["objid"]);
                // dump($cashitems);

                $html = $html . '
                <dl>
                <div class="row">
                    <div class="col-md-3">
                        <dt>OR Number</dt>
                        <dd>'.$cashreceipt[0]["receiptno"].'</dd>
                    </div>
                    <div class="col-md-3">
                    <dt>Total Amount</dt>
                    <dd>'.$cashreceipt[0]["amount"].'</dd>
                    </div>
                    <div class="col-md-6">
                    <dt>Paid By</dt>
                    <dd>'.$cashreceipt[0]["paidby"].' on '.$cashreceipt[0]["receiptdate"].'</dd>
                    </div>
                </div>
                </dl>
                ';

                $html = $html . '<table class="table table-bordered">';
                    $html = $html . '<thead>';
                        $html = $html . '<th>Item Title</th>';
                        $html = $html . '<th>Item Amount</th>';
                    $html = $html . '</thead>';
                    $html = $html . '<tbody>';
                        foreach($cashitems as $item):
                            $html = $html . '<tr>';
                                $html = $html . '<td>'.$item["item_title"].'</td>';
                                $html = $html . '<td>'.$item["amount"].'</td>';
                            $html = $html . '</tr>';
                        endforeach;
                    $html = $html . '</tbody>';
                $html = $html . '</table>';
                endif;

                
                
            // endif;

            echo($html);

        }



    }
	else {
		if(isset($_GET["action"])){
			if($_GET["action"] == "list"){
				render("public/mtop_system/mtop_form.php",[
				]);
			}


			if($_GET["action"] == "profile"){

				$mtop = query("select * from operator o
								left join vehicle v
								on v.MTOP_NO = o.MTOP_NO
								where o.MTOP_NO = ?", $_GET["mtop"]);
				// dump($mtop);

				render("public/mtop_system/mtop_profile.php",[
					"mtop" => $mtop[0],
				]);
			}
		}
		

		
	}
?>
