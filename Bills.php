



<?php
    
//script to link in when the Bills1 php is called.........


//Retrieve API json data using form input values........
//API Key: 52bf01e9cad0422c8e3c1faa809ad959
$formVals = array();

foreach($_POST as $key => $value) {   //array of form values excluding submit button
	if ($key != "submit") {
		array_push($formVals,$value);

	}
}

//Call state keymap to get state abreviation........
$states = array("Alabama" => "AL", "Montana" => "MT", "Alaska" => "AK", "Nebraska" => "NE", "Arizona" => "AZ", "Nevada" => "NV",
		"Mississippi" => "MS", "Wyoming" => "WY", "Missouri" => "MO", "Wisconsin" => "WI", "Minnesota" => "MN","West Virginia" => "WV",
		"Michigan" => "MI", "Washington" => "WA", "Massachusetts" => "MA", "Virginia" => "VA", "Maryland" => "MD", "Vermont" => "VT", "Maine" => "ME",
		"Louisiana" => "LA", "Tennessee" => "TN", "Kentucky" => "KY", "Utah" => "UT", "Texas" => "TX", "Kansas" => "KS", "South Dakota" => "SD",
		"Iowa" => "IA",  "South Carolina" => "SC", "Indiana" => "IN", "Rhode Island" => "RI", "Illinois" => "IL", "Pennsylvania" => "PA",
		"Idaho" => "ID", "Oregon" => "OR",  "Hawaii" => "HI", "Oklahoma" => "OK", "Georgia" => "GA", "Ohio" => "OH", "Florida" => "FL",
		"North Dakota" => "ND", "District Of Columbia" => "DC", "North Carolina" => "NC", "Deleware" => "DE", "New York" => "NY",
		"Connecticut" => "CT", "New Mexico" => "NM", "Colorado" => "CO", "New Jersey" => "NJ", "California" => "CA", "Arkansas" => "AR", "New Hampshire" => "NH");


//call url and get json object
$url=  "http://congress.api.sunlightfoundation.com/" . $formVals[0]. "?bill_id=" . $formVals[2] . "&chamber=" . $formVals[1] . "&apikey=52bf01e9cad0422c8e3c1faa809ad959" ;
$content = file_get_contents($url);

//load json object using json_decode........
$json = json_decode($content, true);

//if($json == ""){
//	echo "The API returned zero results for the request"
//}
//else

//write out html table.......   columns are Name/State/Chamber/Details(links)
//....first put data into associative array.....
//output table is..... bill ID  / short title / Chamber / view details
$BIDRay = array();
$BNameRay = array();
$chamberRay = array();
$detailRay = array();


$legisTable = array( "ID" =>$BIDRay , "name" =>$BNameRay , "Chamber" =>$chamberRay, "details" =>$detailRay );


foreach($json['results'] as $item) {
	array_push($legisTable["ID"], $item['bill_id'] );
	array_push($legisTable["name"], $item['short_title']) ;
	array_push($legisTable["Chamber"], $item['chamber']) ;
	array_push($legisTable["details"], $url);       //this is just the url which is the same API call, will be used in bills2.php to create second form edit for bills
}

?>

<!-- this creates a new form input type for the inital form, once this first table is displayed
will make it so that form will be resubmitted upon clicking bio link in the first table created -->

<input type="hidden" name="supporttype" id= "bioguide" />

<Script LANGUAGE="javascript">

function bioguide(idnum){
	//alert("HI DEBUG");
	thisForm.supporttype.value = idnum; //get idnumber from link clicked on
	thisForm.submit();  //resubmit form with old values and now this id number......
}
</script>

<?php 

// This is the php output for the first table created.....
//    which contains the links

if(empty($json['results'])){
	echo " \n \n The API returned zero results for the request";
}else{

    $i = 0;
    echo "<br><br><table border ='2'><tbody>";
    echo "<th>bill ID</th>";
    echo "<th>short title</th>";
    echo "<th>chamber</th>";
    echo "<th>details</th>";
    foreach ($legisTable["ID"] as $row) {
        echo "<tr>";
            echo "<td>  " . $legisTable["ID"][$i] . "  </td>";
            echo "<td>  " . $legisTable["name"][$i] . "  </td>";
            echo "<td>  " . $legisTable["Chamber"][$i] . "  </td>";
            $temp = $legisTable["details"][$i];
            //print_r($temp);//debug
            //$temp = $legisTable["Details"][$i];
            //echo "<td>  " . "<a href= \"javascript:bioguide('".$temp."')\" > View Details</a>"  . "  </td>";
            echo "<td>  " . "<a href= \"javascript:bioguide('".$temp."')\" > View Details</a>"  . "  </td>";  //calls function and gives url which is the API call for Bills2
        echo "</tr>";
        $i = $i + 1;
    }
    echo "</tbody></table>";
    
}
?>




        
        
 