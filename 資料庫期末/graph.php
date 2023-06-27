<?php 
  header("Content-Type: text/html; charset=utf-8");
  include("connect.php");
  $seldb = @mysqli_select_db($db_link, "accountbook");
  if (!$seldb) die("資料庫選擇失敗！");
  $mid = $_GET['mid'];
  $accnum = $_GET['accnum'];
  $password = $_GET['password'];
  $mname = $_GET['mname']; 
  $yeartime=date("Y");
  $jan=0;
  $feb=0;
  $mar=0;
  $apr=0;
  $may=0;
  $jun=0;
  $july=0;
  $aug=0;
  $sep=0;
  $oct=0;
  $nov=0;
  $dec=0;


$januser_sql = "SELECT `eMoney` FROM expenses AS E NATURAL JOIN record AS R  WHERE R.mid=$mid AND E.rid=R.rid AND `date` LIKE '$yeartime-01%'";
$januser_result = mysqli_query($db_link, $januser_sql);

if($januser_result) {
  while ($janrow_result = mysqli_fetch_assoc($januser_result)) {  
              $jan=$jan + $janrow_result["eMoney"];
  }
  $jan=$jan*-1;   
}

$febuser_sql = "SELECT `eMoney` FROM expenses AS E NATURAL JOIN record AS R  WHERE R.mid=$mid AND E.rid=R.rid AND `date` LIKE '$yeartime-02%'";
$febuser_result = mysqli_query($db_link, $febuser_sql);

if($febuser_result) {
  while ($febrow_result = mysqli_fetch_assoc($febuser_result)) {  
              $feb=$feb + $febrow_result["eMoney"];
  }
  $feb=$feb*-1;   
}

$maruser_sql = "SELECT `eMoney` FROM expenses AS E NATURAL JOIN record AS R  WHERE R.mid=$mid AND E.rid=R.rid AND `date` LIKE '$yeartime-03%'";
$maruser_result = mysqli_query($db_link, $maruser_sql);

if($maruser_result) {
  while ($marrow_result = mysqli_fetch_assoc($maruser_result)) {  
              $mar=$mar + $marrow_result["eMoney"];
  }
  $mar=$mar*-1;   
}

$apruser_sql = "SELECT `eMoney` FROM expenses AS E NATURAL JOIN record AS R  WHERE R.mid=$mid AND E.rid=R.rid AND `date` LIKE '$yeartime-04%'";
$apruser_result = mysqli_query($db_link, $apruser_sql);

if($apruser_result) {
  while ($aprrow_result = mysqli_fetch_assoc($apruser_result)) {  
              $apr=$apr + $aprrow_result["eMoney"];
  }
  $apr=$apr*-1;
}
$mayuser_sql = "SELECT `eMoney` FROM expenses AS E NATURAL JOIN record AS R  WHERE R.mid=$mid AND E.rid=R.rid AND `date` LIKE '$yeartime-05%'";
$mayuser_result = mysqli_query($db_link, $mayuser_sql);

if($mayuser_result) {
  while ($mayrow_result = mysqli_fetch_assoc($mayuser_result)) {  
              $may=$may + $mayrow_result["eMoney"];
  }
  $may=$may*-1;   
}

$junuser_sql = "SELECT `eMoney` FROM expenses AS E NATURAL JOIN record AS R  WHERE R.mid=$mid AND E.rid=R.rid AND `date` LIKE '$yeartime-06%'";
$junuser_result = mysqli_query($db_link, $junuser_sql);

if($junuser_result) {
  while ($junrow_result = mysqli_fetch_assoc($junuser_result)) {  
              $jun=$jun + $junrow_result["eMoney"];
  }
  $jun=$jun*-1;   
}

$julyuser_sql = "SELECT `eMoney` FROM expenses AS E NATURAL JOIN record AS R  WHERE R.mid=$mid AND E.rid=R.rid AND `date` LIKE '$yeartime-07%'";
$julyuser_result = mysqli_query($db_link, $julyuser_sql);

if($julyuser_result) {
  while ($julyrow_result = mysqli_fetch_assoc($julyuser_result)) {  
              $july=$july + $julyrow_result["eMoney"];
  }
  $july=$july*-1;   
}

$auguser_sql = "SELECT `eMoney` FROM expenses AS E NATURAL JOIN record AS R  WHERE R.mid=$mid AND E.rid=R.rid AND `date` LIKE '$yeartime-08%'";
$auguser_result = mysqli_query($db_link, $auguser_sql);
if($auguser_result) {
  while ($augrow_result = mysqli_fetch_assoc($auguser_result)) {  
              $aug=$aug + $augrow_result["eMoney"];
  }
  $aug=$aug*-1;   
}

$sepuser_sql = "SELECT `eMoney` FROM expenses AS E NATURAL JOIN record AS R  WHERE R.mid=$mid AND E.rid=R.rid AND `date` LIKE '$yeartime-09%'";
$sepuser_result = mysqli_query($db_link, $sepuser_sql);
if($sepuser_result) {
  while ($seprow_result = mysqli_fetch_assoc($sepuser_result)) {  
              $sep=$sep + $seprow_result["eMoney"];
  }
  $sep=$sep*-1;   
}

$octuser_sql = "SELECT `eMoney` FROM expenses AS E NATURAL JOIN record AS R  WHERE R.mid=$mid AND E.rid=R.rid AND `date` LIKE '$yeartime-10%'";
$octuser_result = mysqli_query($db_link, $octuser_sql);
if($octuser_result) {
  while ($octrow_result = mysqli_fetch_assoc($octuser_result)) {  
              $oct=$oct + $octrow_result["eMoney"];
  }
  $oct=$oct*-1;   
}

$novuser_sql = "SELECT `eMoney` FROM expenses AS E NATURAL JOIN record AS R  WHERE R.mid=$mid AND E.rid=R.rid AND `date` LIKE '$yeartime-11%'";
$novuser_result = mysqli_query($db_link, $novuser_sql);
if($novuser_result) {
  while ($novrow_result = mysqli_fetch_assoc($novuser_result)) {  
              $nov=$nov + $novrow_result["eMoney"];
  }
  $nov=$nov*-1;   
}
$decuser_sql = "SELECT `eMoney` FROM expenses AS E NATURAL JOIN record AS R  WHERE R.mid=$mid AND E.rid=R.rid AND `date` LIKE '$yeartime-12%'";
$decuser_result = mysqli_query($db_link, $decuser_sql);
if($decuser_result) {
  while ($decrow_result = mysqli_fetch_assoc($decuser_result)) {  
              $dec=$dec + $decrow_result["eMoney"];
  }
  $dec=$dec*-1;   
}
/*========================================================================*/

$janin=0;
$febin=0;
$marin=0;
$aprin=0;
$mayin=0;
$junin=0;
$julyin=0;
$augin=0;
$sepin=0;
$octin=0;
$novin=0;
$decin=0;


$janinuser_sql = "SELECT `iMoney` FROM income AS I NATURAL JOIN record AS R  WHERE R.mid=$mid AND I.rid=R.rid AND `date` LIKE '$yeartime-01%'";
$janinuser_result = mysqli_query($db_link, $janinuser_sql);

if($janinuser_result) {
while ($janinrow_result = mysqli_fetch_assoc($janinuser_result)) {  
            $janin=$janin + $janinrow_result["iMoney"];
}
$janin=$janin;
}

$febinuser_sql = "SELECT `iMoney` FROM income AS I NATURAL JOIN record AS R  WHERE R.mid=$mid AND I.rid=R.rid AND `date` LIKE '$yeartime-02%'";
$febinuser_result = mysqli_query($db_link, $febinuser_sql);

if($febinuser_result) {
while ($febinrow_result = mysqli_fetch_assoc($febinuser_result)) {  
            $febin=$febin + $febinrow_result["iMoney"];
}
$febin=$febin;   
}

$marinuser_sql = "SELECT `iMoney` FROM income AS I NATURAL JOIN record AS R  WHERE R.mid=$mid AND I.rid=R.rid AND `date` LIKE '$yeartime-03%'";
$marinuser_result = mysqli_query($db_link, $marinuser_sql);

if($marinuser_result) {
while ($marinrow_result = mysqli_fetch_assoc($marinuser_result)) {  
            $marin=$marin + $marinrow_result["iMoney"];
}
$marin=$marin;   
}

$aprinuser_sql = "SELECT `iMoney` FROM income AS I NATURAL JOIN record AS R  WHERE R.mid=$mid AND I.rid=R.rid AND `date` LIKE '$yeartime-04%'";
$aprinuser_result = mysqli_query($db_link, $aprinuser_sql);

if($janinuser_result) {
while ($aprinrow_result = mysqli_fetch_assoc($aprinuser_result)) {  
            $aprin=$aprin + $aprinrow_result["iMoney"];
}
$aprin=$aprin;
}

$mayinuser_sql = "SELECT `iMoney` FROM income AS I NATURAL JOIN record AS R  WHERE R.mid=$mid AND I.rid=R.rid AND `date` LIKE '$yeartime-05%'";
$mayinuser_result = mysqli_query($db_link, $mayinuser_sql);

if($mayinuser_result) {
while ($mayinrow_result = mysqli_fetch_assoc($mayinuser_result)) {  
            $mayin=$mayin + $mayinrow_result["iMoney"];
}
$mayin=$mayin;   
}

$juninuser_sql = "SELECT `iMoney` FROM income AS I NATURAL JOIN record AS R  WHERE R.mid=$mid AND I.rid=R.rid AND `date` LIKE '$yeartime-06%'";
$juninuser_result = mysqli_query($db_link, $juninuser_sql);

if($juninuser_result) {
while ($juninrow_result = mysqli_fetch_assoc($juninuser_result)) {  
            $junin=$junin + $juninrow_result["iMoney"];
}
$junin=$junin;   
}

$julyinuser_sql = "SELECT `iMoney` FROM income AS I NATURAL JOIN record AS R  WHERE R.mid=$mid AND I.rid=R.rid AND `date` LIKE '$yeartime-07%'";
$julyinuser_result = mysqli_query($db_link, $julyinuser_sql);

if($julyinuser_result) {
while ($julyinrow_result = mysqli_fetch_assoc($julyinuser_result)) {  
            $julyin=$julyin + $julyinrow_result["iMoney"];
}
$julyin=$julyin;   
}

$auginuser_sql = "SELECT `iMoney` FROM income AS I NATURAL JOIN record AS R  WHERE R.mid=$mid AND I.rid=R.rid AND `date` LIKE '$yeartime-08%'";
$auginuser_result = mysqli_query($db_link, $auginuser_sql);
if($auginuser_result) {
while ($auginrow_result = mysqli_fetch_assoc($auginuser_result)) {  
            $augin=$augin+ $auginrow_result["iMoney"];
}
$augin=$augin;   
}

$sepinuser_sql = "SELECT `iMoney` FROM income AS I NATURAL JOIN record AS R  WHERE R.mid=$mid AND I.rid=R.rid AND `date` LIKE '$yeartime-09%'";
$sepinuser_result = mysqli_query($db_link, $sepinuser_sql);
if($sepinuser_result) {
while ($sepinrow_result = mysqli_fetch_assoc($sepinuser_result)) {  
            $sepin=$sepin + $sepinrow_result["eMoney"];
}
$sepin=$sepin;   
}

$octinuser_sql = "SELECT `iMoney` FROM income AS I NATURAL JOIN record AS R  WHERE R.mid=$mid AND I.rid=R.rid AND `date` LIKE '$yeartime-10%'";
$octinuser_result = mysqli_query($db_link, $octinuser_sql);
if($octinuser_result) {
while ($octinrow_result = mysqli_fetch_assoc($octinuser_result)) {  
            $octin=$octin + $octinrow_result["iMoney"];
}
$octin=$octin;   
}

$novinuser_sql = "SELECT `iMoney` FROM income AS I NATURAL JOIN record AS R  WHERE R.mid=$mid AND I.rid=R.rid AND `date` LIKE '$yeartime-11%'";
$novinuser_result = mysqli_query($db_link, $novinuser_sql);
if($novinuser_result) {
while ($novinrow_result = mysqli_fetch_assoc($novinuser_result)) {  
            $novin=$novin + $novinrow_result["iMoney"];
}
$novin=$novin;   
}

$decinuser_sql = "SELECT `iMoney` FROM income AS I NATURAL JOIN record AS R  WHERE R.mid=$mid AND I.rid=R.rid AND `date` LIKE '$yeartime-12%'";
$decinuser_result = mysqli_query($db_link, $decinuser_sql);
if($decinuser_result) {
while ($decinrow_result = mysqli_fetch_assoc($decinuser_result)) {  
            $decin=$decin + $decinrow_result["iMoney"];
}
$decin=$decin;   
}


require_once ("C:/xampp/htdocs/Final project/jpgraph-4.3.4/src/jpgraph.php");  
require_once ("C:/xampp/htdocs/Final project/jpgraph-4.3.4/src/jpgraph_bar.php");  
require_once ('C:/xampp/htdocs/Final project/jpgraph-4.3.4/src/jpgraph_line.php');



$data1y=array($jan,$feb,$mar,$apr,$may,$jun,$july,$aug,$sep,$oct,$nov,$dec);
$data2y=array($janin,$febin,$marin,$aprin,$mayin,$junin,$julyin,$augin,$sepin,$octin,$novin,$decin);


// Create the graph. These two calls are always required
$graph = new Graph(800,400,'auto');
$graph->SetScale("textlin");

$theme_class=new UniversalTheme;
$graph->SetTheme($theme_class);

$graph->yaxis->SetTickPositions(array(0,1000,5000,10000,15000,20000), array(500,2500,7500,12500,17500));
$graph->SetBox(false);

$graph->ygrid->SetFill(false);
$graph->xaxis->SetTickLabels(array('1','2','3','4','5','6','7','8','9','10','11','12'));
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);

// Create the bar plots
$b1plot = new BarPlot($data1y);
$b2plot = new BarPlot($data2y);

// Create the grouped bar plot
$gbplot = new GroupBarPlot(array($b1plot,$b2plot));
// ...and add it to the graPH
$graph->Add($gbplot);


$b1plot->SetColor("#cc1111");
$b1plot->SetFillColor("#cc1111");
$b1plot->SetLegend("expencese");

$b2plot->SetColor("#11cccc");
$b2plot->SetFillColor("#11cccc");
$b2plot->SetLegend("income");
$graph->img->SetMargin(150,10,50,100);
$graph->legend->SetFrameWeight(1);
$graph->legend->SetColumns(2);
$graph->legend->SetColor('#4E4E4E','#00A78A');

$graph->title->Set("Bar Plots");
$graph->title->SetFont(FF_SIMSUN, FS_BOLD);//設定字型
$graph->yaxis->title->SetFont(FF_SIMSUN, FS_BOLD,12);
$graph->xaxis->title->SetFont(FF_SIMSUN, FS_BOLD,12);
$graph->xaxis->title->SetMargin(20);//距離座標軸的距離
$graph->yaxis->title->SetMargin(20);
$graph->xaxis->title->Set(iconv('utf-8', 'GB2312//IGNORE', "month"));//設定x軸的標題
$graph->yaxis->title->Set(iconv('utf-8', 'GB2312//IGNORE', "money"));
// Display the graph

$graph->Stroke();
?>  