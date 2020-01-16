<html>
    <head>
    <title>My first PHP Website</title>
	<link rel="stylesheet" type="text/css" href="mystyle.css">
    </head>
    <body>
	
		<div class="wrap">
   <div class="search">
      <input type="text" class="searchTerm" placeholder="Block, Block Hash, Transactions Hash" id="-1" >
      <button type="submit" class="searchButton" onClick="testJS2('-1')" >
	  <img src="fa-search.png" width="100%" height="100%">
     </button>
   </div>
</div>

<?php
set_include_path(get_include_path() . PATH_SEPARATOR . 'phpseclib');
include('Net/SSH2.php');
$ssh = new Net_SSH2('158.129.140.201', 3637);
$ssh->login('user017', 'OuIaeY7O') or die("Login failed");
error_reporting(0);

$data = substr("$_SERVER[REQUEST_URI]", 25);
$temp=$ssh->exec('bitcoin-cli getrawtransaction '.$data);
$temp=substr($temp,0,5);

if($temp<>"error")
{
	echo "<h1 id='noborder'>RESULT<br>TRANSACTION INFO</h1>";
	$traninfo=$ssh->exec('bitcoin-cli getrawtransaction '.$data.' 1');
	//$traninfo=$ssh->exec('bitcoin-cli decoderawtransaction '.$traninfo,TRUE);
	$c=json_decode($traninfo, TRUE);
	$cm=$c['blockhash'];
	$blockinfo=$ssh->exec('bitcoin-cli getblock '.$cm);
	$blockinfo=json_decode($blockinfo, TRUE);
	$a=$c['hash'];
	echo "<div class='wrap2'>hash: $a </div>";
	$a=$blockinfo['time'];
	$b=gmdate("Y-m-d H:i:s", $a);
	echo "<div class='wrap2'>time: $b </div>";
	$a=$c['size'];
	echo "<div class='wrap2'>size: $a bytes</div>";
	$a=$c['weight'];
	echo "<div class='wrap2'>weight: $a WU</div>";
	$a=$blockinfo['height'];
	echo "<div class='wrap2'>included in block: $a</div>";
			$top=750;		
			$sender='';			
			$total=0;
			foreach($c['vin'] as  &$vin)
			{
			$vintx=$vin['txid'];
			$vinvout=$vin['vout'];
			$traninfo2=$ssh->exec('bitcoin-cli getrawtransaction '.$vintx);
			$traninfo2=$ssh->exec('bitcoin-cli decoderawtransaction '.$traninfo2);
			$d=json_decode($traninfo2, TRUE);
				
				foreach($d['vout'] as  &$n)
			{
				if($n['n']==$vinvout) {
					$plus2=$plus2+35;
			$sender=$sender.$n['scriptPubKey']['addresses'][0].' '.number_format($n['value'],10).' BTC <br>';
				}				
			}			
			}						
			$reciever="";
			foreach($c['vout'] as  &$re)
			{
				$reciever=$reciever.' '.$re['scriptPubKey']['addresses'][0].' '.number_format($re['value'],10).' BTC <br>';
				$total=$re['value']+$total;
					$plus=$plus+35;
			}
			if($plus2>$plus) $plus=$plus2;
		$plus=$plus+35;
		$height=$height+$plus;
		$arrow=$height/2.2+$top;
	$h=$c['hash'];
$total=number_format($total,10);
		echo "<div class='border' style='position: absolute; height: $height ; width: 600px; top: $top ; left: 20; border-left-width:inherit;
    border-right-style:none;'>$sender</br>$fee</div>";
	echo"<img src='arrow.png' style='position: absolute; height: 5% ; width: 5%; top: $arrow ; left: 650;'>";
		echo "<div class='border' style='position: absolute; height: $height ; width: 600px; top: $top ; left: 800; border-left-width:inherit;
    border-right-style:none;'>$reciever <br> value: $total  BTC  </br></div>";
		$top=$top+$height;
		$plus=0;
		$plus2=0;
		$height=0;	
}

else{
	echo "<h1 id='noborder'>RESULT<br>BLOCK INFO</h1>";
	echo"<h1 id='noborder' top='50%' style='
    width: 100%;
    position: absolute;
    top: 65%;
'>Transactions</h1>";

if (strlen($data)<32) 	$blockhash =$ssh->exec('bitcoin-cli getblockhash '.$data);
else $blockhash=$data;
	$blockinfo=$ssh->exec('bitcoin-cli getblock '.$blockhash);
	$blockinfo=json_decode($blockinfo);
	$a=$blockinfo->{'hash'};
	echo "<div class='wrap2'>hash: $a </div>";
	$a=$blockinfo->{'confirmations'};
	echo "<div class='wrap2'>confirmations: $a </div>";
	$a=$blockinfo->{'time'};
	$b=gmdate("Y-m-d H:i:s", $a);
	echo "<div class='wrap2'>time: $b </div>";
	$a=$blockinfo->{'merkleroot'};
	echo "<div class='wrap2'>merkleroot: $a </div>";
	$a=$blockinfo->{'nonce'};
	echo "<div class='wrap2'>nonce: $a </div>";
	$a=$blockinfo->{'nTx'};
	echo "<div class='wrap2'>Number of transactions: $a </div>";
	$a=$blockinfo->{'difficulty'};
	echo "<div class='wrap2'>difficulty: $a </div>";
	$a=$blockinfo->{'size'};
	echo "<div class='wrap2'>size: $a bytes</div>";
	$a=$blockinfo->{'weight'};
	echo "<div class='wrap2'>weight: $a WU</div>";
	$id=0;
	$plus=0;
	$arrow=0;
	$plus2=0;
	$height=40;
	$top=750;
	foreach($blockinfo->{'tx'} as &$tx)
		{
			$sender='';
			$traninfo=$ssh->exec('bitcoin-cli getrawtransaction '.$tx);
			$traninfo=$ssh->exec('bitcoin-cli decoderawtransaction '.$traninfo);
			$c=json_decode($traninfo, TRUE);
			$total=0;
			foreach($c['vin'] as  &$vin)
			{
			$vintx=$vin['txid'];
			$vinvout=$vin['vout'];
			$traninfo2=$ssh->exec('bitcoin-cli getrawtransaction '.$vintx);
			$traninfo2=$ssh->exec('bitcoin-cli decoderawtransaction '.$traninfo2);
			$d=json_decode($traninfo2, TRUE);
				
				foreach($d['vout'] as  &$n)
			{
				if($n['n']==$vinvout) {
					$plus2=$plus2+35;
					$bitc=(floatval)($n['value']);
			$sender=$sender.$n['scriptPubKey']['addresses'][0].' '.number_format($bitc,10).' BTC <br>';
				}				
			}			
			}
						
			$reciever="";
			foreach($c['vout'] as  &$re)
			{
				$reciever=$reciever.' '.$re['scriptPubKey']['addresses'][0].' '.number_format($re['value'],10).' BTC <br>';
				$total=$re['value']+$total;
				
					$plus=$plus+35;
			}
			if($plus2>$plus) $plus=$plus2;
		$plus=$plus+35;
		$height=$height+$plus;
		$arrow=$height/2.5+$top;
		$total=number_format($total,10);
		echo "<a  href=javascript:testJS('$tx'); class='border' style=' position: absolute; height: $height ; width: 700px; top: $top ; left: 20; border-left-width:inherit;
    border-right-style:none; text-decoration:none;'>$tx <br><br><div style='color: black;'>$sender</div></br></a>";
	echo"<img src='arrow.png' style='position: absolute; height: 6% ; width: 6%; top: $arrow ; left: 750;'>";
		echo "<div class='border' style='position: absolute; height: $height ; width: 700px; top: $top ; left: 1000; border-left-width:inherit;
    border-right-style:none;'>$reciever <br> value:  $total  BTC  </br></div>";
		$top=$top+$height;
		$plus=0;
		$plus2=0;
		$height=0;
		$id=$id+1;
		}
}

?>


			<script>
function testJS(id) {
        url = 'http://localhost/MYWEBSITE/next.php?name=' + encodeURIComponent(id);
    document.location.href = url;
}

function testJS2(id) {
   var b = document.getElementById(id).value;
	
        url = 'http://localhost/MYWEBSITE/next.php?name=' + encodeURIComponent(b);
   document.location.href = url;
}
</script>
    </body>
</html>

