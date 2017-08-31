


 
<HTML><HEAD>

<style>

	p {
    margin: 0;
    padding: 0;
}


table{
    border-collapse: collapse;
    padding: 20px;
}

td{ width: 600px;
    height: 20px;
}

.center {
    margin: auto;
    width: 50%;
    padding: 20px;
}


</style>

<TITLE> Congress Information Search </TITLE></HEAD>

<BODY class ="center" >
<!-- THIS IS THE INITIAL FORM WHICH ALWAYS REMAINS AT THE TOP OF THE PAGE
	 THE OPTIONS SELECTED REMAIN SELECTED, UNLESS THE CLEAR BUTTON IS USED
	 OUTPUT IS DISPLAYED BELOW THIS INITIAL FORM........
 -->
<H2>&emsp;&nbsp;&nbsp;&emsp;&emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;&emsp;&emsp;Congress Information Search</H2>
  
<FORM METHOD="POST" ACTION="" id ="myForm" name="myForm" onsubmit="return validateMyForm();" >
<table border="1"  align="center" width ="300px" style="margin-left: 200px;"><td>


Congress Database <SELECT id = 'opts' name="opts" >
<OPTION value="Select your option"> Select your option </option>
<OPTION value="legislators"> Legislators </option>
<OPTION value ="committees"> Committees </option>
<OPTION value ="bills"> Bills </option>
<OPTION value ="amendments"> Amendments </option>
</SELECT>



<!-- retain values -->
<script type="text/javascript">
document.getElementById('opts').value = "<?php echo $_POST['opts'];?>";
</script>


<!-- retain values -->
<br>&emsp;&nbsp;&nbsp;Chamber&emsp;&nbsp;&nbsp;&emsp;<INPUT type=radio id='amount1' name= "senate/house"  value= "senate"  
	<?php if (isset($_POST["senate/house"]) && $_POST["senate/house"] == "senate") { echo " checked = checked";}   ?> > Senate </Input>
<INPUT type=radio id='amount2' name = "senate/house" value= "house"   <?php if (isset($_POST["senate/house"]) && $_POST["senate/house"] =="house" )  
	{echo "checked = checked";}  ?> > House </Input>



<!-- retain values -->
</br><span id ='keyword'> &nbsp;Keyword* &emsp;&nbsp;&nbsp;</span>
<INPUT type = "text" name= "Keyword*" id= 'Keyword*' value= "<?php echo isset($_POST["Keyword*"]) ? $_POST["Keyword*"] : "" ?>"  > </INPUT></br>






<SCRIPT LANGUAGE="JavaScript">
//this is so keyword will have multiple options.........
//........depending upon dropdown menu
// works before form submit, upon change of dropdown menu.......



//select is pulldown option 
select = document.getElementById('opts');
thisForm = document.myForm;



//vars to validate form......
keywrd = document.getElementById('Keyword*');  //amount1 amount2 Keyword*
amnt1 = document.getElementById('amount1');
amnt2 = document.getElementById('amount2');


function keyWord(){
    
    if(select.value == "Select your option"){
        
        document.getElementById('keyword').innerHTML="Keyword* &emsp;&emsp;";
        
    }
    
    else if(select.value =="legislators"){
        document.getElementById('keyword').innerHTML="State/Representative*";
        
    }
    else if(select.value == "committees"){
        document.getElementById('keyword').innerHTML="Committee ID*  &emsp;&emsp;";
        
    }
    else if(select.value == "bills"){
        document.getElementById('keyword').innerHTML="Bill ID* &emsp;&emsp;&emsp;&emsp;";
        
    }
    else if(select.value == "amendments"){
        document.getElementById('keyword').innerHTML="Amendment ID* &emsp;&emsp;  ";
        
    }
    
};

select.addEventListener('change', keyWord, false );



//function returnToPreviousPage() {
    //window.history.back();
    //actually just stay on current page.....
//}



//this function validates the form information
//upon submittal.....................

function validateMyForm()
{
    
    var o ="";
    var k =".";
    var a ="";
    
    
    if(select.value == "Select your option"){
        o = "Congress Database, ";
        
    }
    if(keywrd.value ==""){
        k ="keyword. ";
    }
    
    if(!amnt1.checked && !amnt2.checked){
        a =" chamber, ";
    }
    
    
    
    if(select.value == "Select your option" || keywrd.value =="" || (amnt1.checked && amnt2.checked))
    {
        
        alert("Please enter the following missing information  :" +o +a +k );
       
        return false;
    }
    
    return true;
}

</script>



<!-- Continue form......submit -->



&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<INPUT type="submit" name= "FORMsubmit" value="Search">
<INPUT type="button" id = "clear" value ="Clear"/>



<!-- function to clear the form with clear button -->




<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href = "http://www.sunlightfoundation.com"> Powered By Sunlight Foundation </a><br>

</td></table>
<!-- End of initial form -->





<!-- This is called if form is submitted.... first time
     Will display first table below form depending upon form options selected
     Supportype is not yet set.... is for the second call back to the server -->

<p id ="outs1">
<?php if(isset($_POST["FORMsubmit"])  && !isset($_POST["supporttype"])  ):  ?>
<table align="center" width = "700px"><td>


<!-- if statements to call script for committes/bills/amendments, in of the below script for legislators-->
<?php  if(  $_POST["opts"]== "committees"   ):  ?>
	<?php include("/home/scf-09/jschnall/apache2/htdocs/Committees.php") ?>
<?php  elseif(  $_POST["opts"]== "bills"   ):  ?>
	<?php include("/home/scf-09/jschnall/apache2/htdocs/Bills1.php") ?>
<?php elseif(  $_POST["opts"]== "amendments"   ):  ?>
	<?php include("/home/scf-09/jschnall/apache2/htdocs/Amendments.php") ?>



<?php else :?>

<?php   
    
    //Retrieve API json data using form input values........
    //API Key: 52bf01e9cad0422c8e3c1faa809ad959
   
   
    //parse form values for url
    $formVals = array();
    
    foreach($_POST as $key => $value) {   //array of form values excluding submit button
        if ($key != "submit") {
            array_push($formVals,$value);
            //print_r($formVals." ".$value);//DEBUG
            
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
    //will be different for each drop down option
    $url ="";
    if( array_key_exists($formVals[2] , $states) ){
    	$stAbr = $states[$formVals[2]];
    	$url=  "http://congress.api.sunlightfoundation.com/" . $formVals[0]. "?chamber=" . $formVals[1] . "&state=" . $stAbr . "&apikey=52bf01e9cad0422c8e3c1faa809ad959" ;
    	
    }else{
    	$stAbr = $formVals[2];
    	$url="http://congress.api.sunlightfoundation.com/" . $formVals[0]. "?chamber=" . $formVals[1] . "&query=" . $stAbr . "&apikey=52bf01e9cad0422c8e3c1faa809ad959";
    }
    //$GLOBALS = array('state' => "");
    //$GLOBALS['state'] =  clone $states[$formVals[2]];  //make this global so can be used later
   
    
    
    
    //$url=  "http://congress.api.sunlightfoundation.com/" . $formVals[0]. "?chamber=" . $formVals[1] . "&state=" . $stAbr . "&apikey=52bf01e9cad0422c8e3c1faa809ad959" ;
    $content = file_get_contents($url);
    
    
    //load json object using json_decode........
    $json = json_decode($content, true);
    
    
    
    //write out html table.......   columns are Name/State/Chamber/Details(links)
    //....first put data into associative array.....
    $nameRay = array();
    $stateRay = array();
    $chamberRay = array();
    $detailsRay = array();
    
    $legisTable = array( "Name" =>$nameRay , "State" =>$stateRay , "Chamber" =>$chamberRay , "Details"=>$detailsRay  );
    
    
    foreach($json['results'] as $item) {
        array_push($legisTable["Name"], $item['first_name'] . " " . $item['last_name']);
        array_push($legisTable["State"], $item['state_name']) ;
        array_push($legisTable["Chamber"], $item['chamber']) ;
        array_push($legisTable["Details"], $item['bioguide_id']);
    }
  
?>


<!-- this creates a new form input type for the inital form, once this first table is displayed
     will make it so that form will be resubmitted upon clicking bio link in the first table created -->

<input type="hidden" name="supporttype" id= "bioguide" />

<Script LANGUAGE="javascript">

function bioguide(idnum){
    thisForm.supporttype.value = idnum; //get idnumber from link clicked on
    thisForm.submit();  //resubmit form with old values and now this id number......
}
</script>



<!-- This is the php output for the first table created.....
     which contains the links which resubmit the form using the input type hidden above -->
<?php

	if(empty($json['results'])){
		echo " <br> <br> &emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;
    			&emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;&emsp;&nbsp;The API returned zero results for the request";
	}else{

	


    $i = 0;
    echo "<br><br><table border ='2'><tbody>";
    echo "<th>Name</th>";
    echo "<th>State</th>";
    echo "<th>Chamber</th>";
    echo "<th>Details</th>";
    foreach ($legisTable["Name"] as $row) {
        echo "<tr>";
            echo "<td>  " . $legisTable["Name"][$i] . "  </td>";
            echo "<td>  " . $legisTable["State"][$i] . "  </td>";
            echo "<td>  " . $legisTable["Chamber"][$i] . "  </td>";
            $temp = $legisTable["Details"][$i];
            echo "<td>  " . "<a href= \"javascript:bioguide('".$temp."')\" > View Details</a>"  . "  </td>";
        echo "</tr>";
        $i = $i + 1;
    }
    echo "</tbody></table>";
    
	}
?>

<?php endif; ?>

<?php endif; ?>

</p>




<!-- This PHP is called after the first table is created......
	if there is now a hidden option to submit the form a second time, using supportype input in form -->

<p id = "outs2">
<?php if(isset($_POST["supporttype"])): ?>
<br><br>
<table align="center" border = "1" width = "500"><td>

<!-- if Bills is called as oposed to legislators below -->

<?php if( $_POST["opts"] == "bills"): ?>
	
	<?php include("/home/scf-09/jschnall/apache2/htdocs/Bills2.php") ?>


<?php else: ?>

<?php
    
    //create new table based on bioguide id
    /*https://congress.api.sunlightfoundation.com/legislators?chamber=house&state=WA&bioguide_id=N000189&apikey=YOUR_API_KEY_HERE
     */    
    $formVals = array();    
    foreach($_POST as $key => $value) {
        if ($key != "submit") {
            array_push($formVals,$value);
            
        }
    }
    
    //get idnum
    foreach($_POST as $key => $value) {
        if ($key == "supporttype") {
             $idnum = $value;
        }
    }
    
    //create  new API call link
    $states = array("Alabama" => "AL", "Montana" => "MT", "Alaska" => "AK", "Nebraska" => "NE", "Arizona" => "AZ", "Nevada" => "NV",
    		"Mississippi" => "MS", "Wyoming" => "WY", "Missouri" => "MO", "Wisconsin" => "WI", "Minnesota" => "MN","West Virginia" => "WV",
    		"Michigan" => "MI", "Washington" => "WA", "Massachusetts" => "MA", "Virginia" => "VA", "Maryland" => "MD", "Vermont" => "VT", "Maine" => "ME",
    		"Louisiana" => "LA", "Tennessee" => "TN", "Kentucky" => "KY", "Utah" => "UT", "Texas" => "TX", "Kansas" => "KS", "South Dakota" => "SD",
    		"Iowa" => "IA",  "South Carolina" => "SC", "Indiana" => "IN", "Rhode Island" => "RI", "Illinois" => "IL", "Pennsylvania" => "PA",
    		"Idaho" => "ID", "Oregon" => "OR",  "Hawaii" => "HI", "Oklahoma" => "OK", "Georgia" => "GA", "Ohio" => "OH", "Florida" => "FL",
    		"North Dakota" => "ND", "District Of Columbia" => "DC", "North Carolina" => "NC", "Deleware" => "DE", "New York" => "NY",
    		"Connecticut" => "CT", "New Mexico" => "NM", "Colorado" => "CO", "New Jersey" => "NJ", "California" => "CA", "Arkansas" => "AR", "New Hampshire" => "NH");
    
    
    
    $urlnew ="";
    if( array_key_exists($formVals[2] , $states) ){
    	$stAbr = $states[$formVals[2]];
    	//$url=  "http://congress.api.sunlightfoundation.com/" . $formVals[0]. "?chamber=" . $formVals[1] . "&state=" . $stAbr . "&apikey=52bf01e9cad0422c8e3c1faa809ad959" ;
    	$urlnew=  "http://congress.api.sunlightfoundation.com/" . $formVals[0]. "?chamber=" . $formVals[1] . "&state=" . $stAbr . "&bioguide_id=" .$idnum. "&apikey=52bf01e9cad0422c8e3c1faa809ad959" ; 
    }else{
    	$stAbr = $formVals[2];
    	//$url="http://congress.api.sunlightfoundation.com/" . $formVals[0]. "?chamber=" . $formVals[1] . "&query=" . $stAbr . "&apikey=52bf01e9cad0422c8e3c1faa809ad959";
    	$urlnew=  "http://congress.api.sunlightfoundation.com/" . $formVals[0]. "?chamber=" . $formVals[1] . "&query=" . $stAbr . "&bioguide_id=" .$idnum. "&apikey=52bf01e9cad0422c8e3c1faa809ad959" ;
    }
    
    
    //$stAbr = $states[$formVals[2]];
    //$urlnew=  "http://congress.api.sunlightfoundation.com/" . $formVals[0]. "?chamber=" . $formVals[1] . "&state=" . $stAbr . "&bioguide_id=" .$idnum. "&apikey=52bf01e9cad0422c8e3c1faa809ad959" ;
    //print_r($urlnew); //DEBUG  
    
    //call for json
    $content1 = file_get_contents($urlnew);
    
    //load json object using json_decode........   
    $json1 = json_decode($content1, true);
    
    
    //print_r($json1) ; DEBUG
    
    //write out html table.......   columns are Name/State/Chamber/Details(links)
    //....first put data into associative array.....
    $bioTable = array( "Image" => "" , "Name" => "" , "Term" => "" , "Website"=> "",
                      "Office" => "", "Facebook" => "", "Twitter" => "");
    
    foreach($json1['results'] as $item) {
        $bioTable["Name"] = $item['first_name'] . " " . $item['last_name'] ;
        $bioTable["Image"]= $item["bioguide_id"];
        //https://theunitedstates.io/images/congress/225x275/bioguide_id.jpg
        $bioTable["Term"] = $item["term_end"];
        $bioTable["Website"]= $item['website'];
        $bioTable["Office"] = $item['office'];
        $bioTable["Facebook"]= $item['facebook_id'];
        //https://www.facebook.com/facebook_id
        $bioTable["Twiter"]= $item['twitter_id'] ;
        //https://www.twitter,com/twitter_id
    }
    
    
      
    //$i = 0;
    echo "<br><br><table align =\"center\" width = 650px><tbody>";
    echo "<center><img src=" . " \"http://theunitedstates.io/images/congress/225x275/" . $bioTable["Image"]. ".jpg\" " .  "  width = 220 height = 200 ></center>" ; //person image
   
    
    	echo "<center><tr><td> Full Name </td> <td align =\"right\">  " . $bioTable["Name"] . "  </td></tr></center>";
    	echo "<center><tr><td> Term ends on	</td> <td align =\"right\">" . $bioTable["Term"] . "  </center></td></tr></center>";
    	echo "<center><tr><td> Website	</td> <td align =\"right\">" . "<a href=\" " . $bioTable["Website"] . "\">". $bioTable["Website"]."<a/>". "</center></td></tr></center>";   
    	echo "<center><tr><td> Office 	</td> <td align =\"right\">" . $bioTable["Office"] . "  </center></td></tr></center>";
    	echo "<center><tr><td> Facebook 	</td> <td align =\"right\">" . "<a href=\"//https://www.facebook.com/". $bioTable["Facebook"]   ."\">"  .$bioTable["Name"] . "<a/>"  . "</td></tr></center>";   
    	echo "<center><tr><td> Twitter 	</td> <td align =\"right\">" . "<a href=\"//https://www.twitter.com/". $bioTable["Twitter"]   ."\">"  .$bioTable["Name"] . "<a/>"  . "</td></tr></center>";
    	//$i = $i + 1;
    
    echo "</tbody></table>";
    
    
?>

<?php endif; ?>

<?php endif; ?>
</p>
</td></table>


 
<script Language ="Javascript" >
var clear = document.getElementById("clear");  //id
var form = document.getElementById("myForm");  //id

function clearfield() {
	 form.reset();
	 //alert(document.getElementById('Keyword*').value);
     document.getElementById('Keyword*').value ='';
     //document.getElementById('amount1').removeAttr('checked');
     //document.getElementById('amount2').removeAttr('checked');
     //alert("HERE");
     document.getElementById("outs1").innerHTML = ""; //document.body.removeChild
     document.getElementById("outs2").innerHTML ="";
   
    //return false;
}

clear.addEventListener("click", clearfield, false);
</Script>

</FORM>
 
</BODY>
</HTML>













