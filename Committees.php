


<?php
    
//script to link in when the committees php is called.........


//Retrieve API json data using form input values........
//API Key: 52bf01e9cad0422c8e3c1faa809ad959
$formVals = array();

foreach($_POST as $key => $value) {   //array of form values excluding submit button
	if ($key != "submit") {
		array_push($formVals,$value);

	}
}


//Call state keymap to get state abreviation........
//still need to do this


$states = array("Alabama" => "AL", "Montana" => "MT", "Alaska" => "AK", "Nebraska" => "NE", "Arizona" => "AZ", "Nevada" => "NV",
		"Mississippi" => "MS", "Wyoming" => "WY", "Missouri" => "MO", "Wisconsin" => "WI", "Minnesota" => "MN","West Virginia" => "WV",
		"Michigan" => "MI", "Washington" => "WA", "Massachusetts" => "MA", "Virginia" => "VA", "Maryland" => "MD", "Vermont" => "VT", "Maine" => "ME",
		"Louisiana" => "LA", "Tennessee" => "TN", "Kentucky" => "KY", "Utah" => "UT", "Texas" => "TX", "Kansas" => "KS", "South Dakota" => "SD",
		"Iowa" => "IA",  "South Carolina" => "SC", "Indiana" => "IN", "Rhode Island" => "RI", "Illinois" => "IL", "Pennsylvania" => "PA",
		"Idaho" => "ID", "Oregon" => "OR",  "Hawaii" => "HI", "Oklahoma" => "OK", "Georgia" => "GA", "Ohio" => "OH", "Florida" => "FL",
		"North Dakota" => "ND", "District Of Columbia" => "DC", "North Carolina" => "NC", "Deleware" => "DE", "New York" => "NY",
		"Connecticut" => "CT", "New Mexico" => "NM", "Colorado" => "CO", "New Jersey" => "NJ", "California" => "CA", "Arkansas" => "AR", "New Hampshire" => "NH");



//call url and get json object
$url=  "http://congress.api.sunlightfoundation.com/" . $formVals[0]. "?committee_id=" . $formVals[2] . "&chamber=" . $formVals[1] . "&apikey=52bf01e9cad0422c8e3c1faa809ad959" ;
$content = file_get_contents($url);


//load json object using json_decode........
$json = json_decode($content, true);

//if($json == ""){
//	echo "The API returned zero results for the request"
//}
//else

//write out html table.......   columns are Name/State/Chamber/Details(links)
//....first put data into associative array.....
//output table is..... committe ID  / committe Name / Chamber
$CIDRay = array();
$CNameRay = array();
$chamberRay = array();

$legisTable = array( "ID" =>$CIDRay , "name" =>$CNameRay , "Chamber" =>$chamberRay );


foreach($json['results'] as $item) {
	array_push($legisTable["ID"], $item['committee_id'] );
	array_push($legisTable["name"], $item['name']) ;
	array_push($legisTable["Chamber"], $item['chamber']) ;
}


// This is the php output for the first table created.....

if(empty($json['results'])){
	echo " \n \n The API returned zero results for the request";
}else{

    $i = 0;
    echo "<br><br><table border ='2'><tbody>";
    echo "<th>committee ID</th>";
    echo "<th>committee name</th>";
    echo "<th>chamber</th>";
    foreach ($legisTable["ID"] as $row) {
        echo "<tr>";
            echo "<td>  " . $legisTable["ID"][$i] . "  </td>";
            echo "<td>  " . $legisTable["name"][$i] . "  </td>";
            echo "<td>  " . $legisTable["Chamber"][$i] . "  </td>";
        echo "</tr>";
        $i = $i + 1;
    }
    echo "</tbody></table>";
}
?>





