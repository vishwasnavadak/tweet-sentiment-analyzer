<!DOCTYPE html>
<html>
<head>
  <title>Twitter Analyzer - Results</title>
  <link rel="stylesheet" type="text/css" href="../style.css">
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
  
</head>
<body>
<div class="container">
<!--Div that will hold the pie chart-->
    <div id="chart_div" style="width:600px; height:400px;margin:0 auto;"></div>

    
    

<?php
if (PHP_SAPI != 'cli') {
	echo "<pre>";
}
$t=array();
$sql= new mysqli("localhost","sagricag_kvndemo","2015FORdemotesting","sagricag_vishwasdemos");
if($sql->connect_error)
    die("Coudn't connect");
$dat=$sql->query("select * from twitter");



$result["neu"]=$result["neg"]=$result["pos"]=0;
$cresult["neu"]=$cresult["neg"]=$cresult["pos"]=0;

require_once 'autoload.php';
$sentiment = new \PHPInsight\Sentiment();
while($strings = $dat->fetch_assoc()){
foreach ($strings as $value) {
	
//foreach ($value as $key => $string) {

	// calculations:
	$scores = $sentiment->score($value);
	$class = $sentiment->categorise($value);

	if($class=="pos")
		$col="rgba(0, 0, 210, 0.4)";
	else if($class=="neg")
		$col="rgba(255, 0, 0, 0.5)";
	else
		$col="rgba(197, 165, 9, 0.5)";
	// output:
	if(isset($_GET["show_tweets"])){
		echo "<div class=\"tweet\" style=\"background:$col;\">";
	echo "String: $value\n";
	echo "Nature: $class </div>";	
    }
	$result["$class"]+=$scores["$class"];
	$cresult["$class"]++;
//}
}
}


$hash=$sql->query("select hashtag from twitter limit 1;");
$hashtag=$hash->fetch_assoc();
if(!($sql->query("select hashtag from twitter limit 1;")))
        {
          echo $sql->error."<br/>"; exit();
        }

if(!isset($_GET["show_tweets"]))
echo "<br/><a href=\"index.php?show_tweets=true\" >Click to show all tweets</a>   ";
$maxsen=array_keys($cresult,max($cresult));
?>
   <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'No. of Tweets'],
          ['Positive',     <?php echo $cresult["pos"]; ?>],
          ['Negative',      <?php echo $cresult["neg"]; ?>],
          ['Neutral',  <?php echo $cresult["neu"]; ?>],
          
        ]);
        var ti="<?php echo 'Overall Outcome of #'.$hashtag['hashtag'].': '.$maxsen['0']; ?>";
        var options = {
          title: ti,
          titleTextStyle: { fontSize:20,bold:true,},
          width: 600,
          height: 400,
          is3D: true,
          backgroundColor: '#fdfdfd',
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
  


</body>
</html>