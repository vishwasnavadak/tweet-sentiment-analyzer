<!DOCTYPE html>
<html>
<head>
	<title>Twitter Analyzer</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="mbox">
<form  action="twitter.php" method="post">
	<input type="text" name="queryt" placeholder="Enter search keyword" required autofocus autocomplete="off"/><br/>
	<div style="text-align: justify !important;"><br/><b>Search by:</b><br/>
	&nbsp;&nbsp;&nbsp;<input type="radio" name="typ" value="username" required/><label for="typ">Username</label><br/>
	&nbsp;&nbsp;&nbsp;<input type="radio" name="typ" value="hashtag" required/><label for="typ">Hashtag</label>
	</div>
	<br/><input type="submit" value="Submit"/><input type="reset" value="Reset"/><br/>
					<p><?php if(isset($_GET["upload"])){ echo "done uploading to database. <br/><a href=\"analyzer/\" >click here to analyze</a>"; } ?>
</form>
</div>
</body>
</html>

