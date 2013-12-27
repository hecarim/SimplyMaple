<?php
	if (@$_POST["doVote"] != "1") {
} else {
		$earnednx = false;
		$account = $_POST['name'];
		$account = mysql_real_escape_string($account);
		mysql_select_db($host['database']);
		$query=mysql_query("SELECT * FROM accounts WHERE name='" . mysql_real_escape_string($_POST["name"]) . "'");
		$info=mysql_fetch_assoc($query);
		if($_POST["name"] == "") {
			echo 'Please fill in the correct account credentials.';
		} elseif(mysql_num_rows($query) < 1) {
			echo 'Please fill in the correct account credentials.';
		} elseif($info["loggedin"] > 0) {
			echo 'You must be logged out to vote for rewards.';
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
			$time = time();
			$get = "SELECT *, SUM(`times`) as amount FROM voterecords WHERE account='$account'";
			$query1 = mysql_query($get);
			$lasttime = mysql_fetch_array($query1);
			$amount = $lasttime['amount'];
			$insertnew = false;	
			if ($amount == "") {
				$insertnew = true;
			}
			$timecalc = $time - $lasttime['date'];
			if (!$insertnew) {
				if ($timecalc < 22100) {
					date_default_timezone_set(''.$timezone.'');
					$_SESSION['vote_date'] = date('M d\, h:i:s A', $lasttime['date']);
					echo 'You\'ve already voted with this account in the past 6 hours!<br />Last time you voted was on: '.$_SESSION['vote_date'].'! <br><br>';
				} else {			
					$update = mysql_query("SELECT * from voterecords WHERE ip='$ip' AND account = '$account'");
					if ($update) {
						mysql_query("UPDATE voterecords SET account='$account', date='$time', times=times+1 WHERE account='$account'");
						mysql_query("UPDATE voterecords SET account='$account', date='$time', times=times+1 WHERE ip='$ip'");
						$earnednx = true;
					} elseif (!$update) {	
						$ipinsert = mysql_query("INSERT INTO voterecords (`account`, `ip`, `date`, `times`) VALUES ('$account', '$ip', '$time', 1)");
						if (!$ipinsert) {
							$message  = 'Invalid query: ' . mysql_error() . "\n";
							$message .= 'Whole query: ' . $ipinsert;
							die($message);
						} else {
							$earnednx = true;
						}
					} else {
						$message  = 'Invalid query: ' . mysql_error() . "\n";
						$message .= 'Whole query: ' . $update;
						die($message);
					}
				}
			} else {
				$success = mysql_query("INSERT INTO voterecords (`account`, `ip`, `date`, `times`) VALUES ('$account', '$ip', '$time', 1)");
				if (!$success) {
					$message  = 'Invalid query: ' . mysql_error() . "\n";
					$message .= 'Whole query: ' . $success;
					die($message);
				} else {
					$earnednx = true;
				}
			}
			if ($earnednx) {
				mysql_query("UPDATE accounts SET vpoints = vpoints + '1' WHERE name='" . mysql_real_escape_string($_POST["name"]) . "'");
				mysql_query("UPDATE accounts SET lastvote='" .time(). "' WHERE name='" . mysql_real_escape_string($_POST["name"]) . "'");
				mysql_close();
				echo '<html>';
				echo '<head>';
				unset($_SESSION['vote_err']);
				echo '<meta HTTP-EQUIV="REFRESH" content="0; url='.$gtop.'">';
				echo '</head>';
				echo '</html>';
			}
		}
}
?>
<div id="body">
<form action="?page=vote" method="POST">
<center>
<div>Not interested in any rewards, but still wanna vote? <a href="<?php echo $gtop ?>" target="_blank">Click Here</a></div><br/>

<font color="red"><strong>Please Read Before Voting:</strong></font> 
<p>You can only vote 1 time every 6 hours for 1 Vote Point.</p>
<p>Account Id is NOT Character Name..</p>
<p>It does not require you to log off to receive your vote points.</p>
<p>After clicking vote, fill in the Captcha, or you won't receive your prize for voting.</p>
<p>We track all votes, do not misuse this system or you will be permantly banned.</p>
<br/>
<br/><input type="text" name="name" class="input" placeholder="Account Username" required style="top: 0px"/>
<input type="submit" id="be_banned"  class="votebtn" onClick="javascript:ajaxFunction();" name="doVote" value="Vote" class="doVote" style="margin-top: 5px;">
<input type="hidden" name="doVote" value="1">
</form>
</div>