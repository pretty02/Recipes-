<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
* {
  box-sizing: border-box;
}

 input         {
  font-size:80px;
  padding:10px 10px 10px 5px;
  display:flex;
  width:400px;
  border:none;
  border-bottom:1px solid #757575;
  flex-direction: column;
  
}
input:focus     { outline:none; } 

.row::after {
  content: "";
  clear: both;
  display: block;
}

[class*="col-"] {
  float: left;
  padding: 15px;
}

html {
  font-family: "Lucida Sans", sans-serif;
}

.header {
  background-color: #3A6DAF;
  text-align: center;
  color: black;
  padding: 15px;
 
}


/* For desktop: */
.col-1 {width: 8.33%;}
.col-2 {width: 16.66%;}
.col-3 {width: 35%;}
.col-4 {width: 33.33%;}
.col-5 {width: 41.66%;}
.col-6 {width: 50%;}
.col-7 {width: 58.33%;}
.col-8 {width: 66.66%;}
.col-9 {width: 75%;}
.col-10 {width: 83.88%;}
.col-11 {width: 91.66%;}
.col-12 {width: 100%;}

@media only screen and (max-width: 768px) {
  /* mobile-Responsive: */
  [class*="col-"] {
    width: 100%;
  }
}
table {
		border-collapse: collapse;
		width: 100%;   
        font-size: 20px;
		}

		th, td {
		padding: 0px;
		text-align: left;
		border-bottom: 1px solid #DDD;
		}

		tr:hover {background-color: #D6EEEE;}
</style>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<?php session_start();
    if(isset($_POST['search'])){
        $searchStr = $_POST['gsearch'];
        $_SESSION['meal'] = $searchStr;
    }
?>
<body>

<div class="header">
    <div class="row">
        <div class="col-6">
            <h1>Cooking Recipe</h1>
        </div>

<div class="col-4">
<form action="" method="post">
    <input type="text" id="gsearch" name="gsearch" placehoalder="Search......" value="<?php if($_SESSION['meal'] != null) echo $_SESSION['meal']; ?>">
    <div class="col-11">
    <button  name="search" value="search" left: 100px;>Search</button>
    </div>
</form>

</div>
    </div>
</div>

<div class="row">
  <div class="col-3">
  </div>
  <div class="col-2">
      <!-- <h2>Image</h2> -->
      <img id="imgRecipe" src="" alt="Recipe Image" width="400" height="400">
    </div>

</div>


<div class="row">
        <div class="container">
    <div class="panel-group">
        <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
            <a data-toggle="collapsed"  href="#collapse"><h1>Ingredients</h1></a>
            </h4>
        </div>
        <div id="collapse" class="panel-collapse collapse in">

        <div class="col-12">
      <table id="tabIngredient">
        <thead>
            <tr>
                <th>Quantity <i onclick="sortTable(0)" class='fas fa-sort' style='font-size:26px'></i></th>
                <th>Name <i onclick="sortTable(1)" class='fas fa-sort' style='font-size:26px'></i></th>
                <th>Type <i onclick="sortTable(2)" class='fas fa-sort' style='font-size:26px'></i></th>
            </tr>
            </thead>
            <tbody id= "ingResult"></tbody>
        </table>
    </div>
        </div>
        </div>
    </div>
    </div>
</div>


<div class="row">
        <div class="container">
    <div class="panel-group">
        <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
            <a data-toggle="collapse" href="#collapse1"><h1>Steps</h1></a>
            </h4>
        </div>
        <div id="collapse1" class="panel-collapse collapse">

        <div class="col-12">
      <!-- <h1>Steps</h1> -->
      <table id="tabSteps">
        <thead>
            <tr>
                <th>Steps <i onclick="sortTable(0)" class='fas fa-sort' style='font-size:26px'></i></th>
                <th>Timers <i onclick="sortTable(1)" class='fas fa-sort' style='font-size:26px'></i></th>
            </tr>
            </thead>
            <tbody id= "result"></tbody>
        </table>
    </div>
        </div>
        </div>
    </div>
    </div>
</div>
  </body>
  </html>

 <?php

  $searchStr = "";
  $searchIndx = "";
    //session_start();
    if(isset($_POST['search'])){
        $searchStr = $_POST['gsearch'];
        $_SESSION['meal'] = $searchStr;
     //   header("Refresh:3");
    }

 
$Json = file_get_contents("recipes.json");
// Converts to an array 
$myArray = json_decode($Json, true);
//var_dump($myArray); // prints array
for($x=0; $x < count($myArray); $x++){
    if($searchStr == $myArray[$x]['name']){
        $searchIndx = $x;
    }
}

$arrSteps = array();
$arrTimes = array();
$arrIng = array();
$imgUrl = $myArray[$searchIndx]['imageURL'];

$arrSteps = $myArray[$searchIndx]['steps'];
$arrTimes = $myArray[$searchIndx]['timers'];
$arrIng = $myArray[$searchIndx]['ingredients'];
$arrCount = count($arrSteps);

//var_dump($imgUrl);
 ?>

<script>
    var arrSteps = <?php echo json_encode($arrSteps); ?>;
    var arrTimers = <?php echo json_encode($arrTimes); ?>;
    var arrCount = <?php echo json_encode($arrCount); ?>;
    var arrIng = <?php echo json_encode($arrIng); ?>;
    var imgName = <?php echo json_encode($imgUrl); ?>;
    var sdata = arrSteps;
    var tdata = arrTimers;
    var idata = arrIng;
    var image = "";
    //console.log("Name "+arrSteps[0]['name']);
    function populateData(){
        var table = "" ;
        
            for(var i=0; i<arrCount; i++){
                table += "<tr>";
                table += "<td>" 
                     + sdata[i] +"</td>" 
                        + "<td>" + tdata[i]+" Min</td>";
                table += "</tr>";
            }

            var table1 = "" ;
        
            for(var x in idata){
                table1 += "<tr>";
                table1 += "<td>" 
                        + idata[x]['quantity'] +"</td>" 
                        + "<td>"  + idata[x]['name'] +"</td>" 
                        + "<td>" + idata[x]['type']+"</td>";
                table1 += "</tr>";
            }

        document.getElementById("ingResult").innerHTML = table1;
        document.getElementById("result").innerHTML = table;
        document.getElementById("imgRecipe").src = imgName;
    }
</script>
<script>
    //load data from onclick
    window.addEventListener('load', function () {
        populateData();
    })
</script>
