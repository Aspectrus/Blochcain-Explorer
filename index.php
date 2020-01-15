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

 "<div class='wrap2'  id='noborder' >
    <div class='height' >
	blockheight
	</div>
	  <div class='hash' >
	blockhash
	</div>
	 <div class='height' >
	time 
	</div>
		 <div class='height' >
	size 
	</div>

</div>

        <?php
set_include_path(get_include_path() . PATH_SEPARATOR . 'phpseclib');
include('Net/SSH2.php');
$ssh = new Net_SSH2('158.129.140.201', 3637);
$ssh->login('user017', 'OuIaeY7O') or die("Login failed");




$highestblock =$ssh->exec('bitcoin-cli getblockcount');

for ($x = 0; $x < 15; $x++) {
	$blockheight=(int)$highestblock-$x;
	$blockhash =$ssh->exec('bitcoin-cli getblockhash '.$blockheight);
	$blockinfo=$ssh->exec('bitcoin-cli getblock '.$blockhash);
	$blockinfo=json_decode($blockinfo);
	$time=microtime(true);
	$time=(int)$time-$blockinfo->{'time'};
	$size=$blockinfo->{'size'};
	$unit='s';
	$b=$x+20;
	if($time>60) {
		$time=(int)($time/60);
		$unit='min';
	}
	$blockhash=substr($blockhash,0,64);
	echo "<div class='wrap2' >
    <div class='height' >
	 <a href=javascript:testJS('$x'); id='$x'>$blockheight</a>
	</div>
	  <div class='hash' ><a href=javascript:testJS('$b'); id='$b'>$blockhash</a>
	</div>
	 <div class='height' >
	$time $unit
	</div>
		 <div class='height' >
	$size  bytes
	</div>
	</div>";
	
}
        ?>
		
		<script>
function testJS(id) {
   var b = document.getElementById(id).innerHTML;
	
        url = 'http://localhost/MYWEBSITE/next.php?name=' + encodeURIComponent(b);
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

