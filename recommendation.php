<?php
 $conn=mysqli_connect("localhost","droiddynasty_apptest","datingapptest","droiddynasty_apptest");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$query="select id,iStatus,iPersonalPriority,iImportantInOthers,iSmokingViews,iAlcoholViews from users";
$result=mysqli_query($conn,$query);
$rows = mysqli_num_rows($result);
$n_array = array();
    
while( $row = mysqli_fetch_assoc( $result)){
    $n_array[]=$row;
}

// $primaryquery="SELECT pid from recommend";
// $primaryresult=mysqli_query($conn,$primaryquery);
// if(mysqli_num_rows($result)!=((pow($rows,2)+$rows)/2))
// {
 for($m=0;$m<$rows;$m++){ 
    for($n=0;$n<$rows;$n++){
            if($m!=$n and $m<$n)
            {
        $in_query="INSERT INTO recommend (id, compare_id, score) VALUES ($m,$n,0)";
        $inresult=mysqli_query($conn, $in_query);
            }
    }
 }
// }
 //just to insert blank data so later no check necessary
 
 for($i=0;$i<$rows;$i++){ 
    for($j=0;$j<$rows;$j++){
            if($i!=$j and $i<$j)
            {
                $vec1=array($n_array[$i]["iStatus"],$n_array[$i]["iPersonalPriority"],$n_array[$i]["iImportantInOthers"],$n_array[$i]["iSmokingViews"],$n_array[$i]["iAlcoholViews"]);
                $vec2=array($n_array[$j]["iStatus"],$n_array[$j]["iPersonalPriority"],$n_array[$j]["iImportantInOthers"],$n_array[$j]["iSmokingViews"],$n_array[$j]["iAlcoholViews"]);


        // var_dump($vec2);
        $dotproduct = 0; 
        for ($k = 0; $k <= 4; $k++) {
        $dotproduct = $dotproduct + $vec1[$k]*$vec2[$k]; 
        } //ends for loop for mathiko dot product

        $intsum1 =pow($vec1[0],2) +  pow($vec1[1],2) + pow($vec1[2],2)+ pow($vec1[3],2)+pow($vec1[4],2) ; // first ko sum
        $intsum2 =pow($vec2[0],2) +  pow($vec2[1],2) + pow($vec2[2],2)+ pow($vec2[3],2)+pow($vec2[4],2) ; //second ko sum                      
        $Sqrt1=sqrt($intsum1); //first ko squareroot
        $Sqrt2=sqrt($intsum2); //second ko squareroot
        $Abs=$Sqrt1*$Sqrt2; // talako final multiply
        //  echo nl2br("\n loop outer".$i."@@@@ and"."\n inner loop ".$j."xxxxxx");
        $similar=$dotproduct/$Abs;
        
        //max($Abs,0.001);

        //recommend table ma update garne rows effect bhayena bhane insert garne
        $up_query="UPDATE recommend SET id=$i, compare_id=$j, score=$similar WHERE id=$i AND compare_id=$j"; 
        $upresult=mysqli_query($conn,$up_query);
        // var_dump($upresult);

// $updatecount=mysqli_num_rows($upresult);
// echo $updatecount;

// REPLACE into recommend (id, compare_id, score) values(1, "A", 19)

//   if(mysqli_num_rows($upresult)<1){
//       $in_query="INSERT INTO recommend (id, compare_id, score) VALUES ($i,$j,$similar)";
//         $inresult=mysqli_query($conn, $in_query);
  
//     // var_dump($inresult);
//         // mysqli_free_result($result);
//   }//ends row check

unset($vec1); 
unset($vec2); 


        }
    // inner j for
          
      }// outer i for
      
      
}

mysqli_close($conn);
  ?>
  
