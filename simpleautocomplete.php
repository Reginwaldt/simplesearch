<!--
How can we quickly fetch South African school names on a search box?
-->

<form>
  <strong>Search S.A schools</strong><br>
    <div id="the-basics" >
      <input class="typeahead" type="text" name="school" placeholder="Start typing at least 3 letters" style="width: 352px;">
    </div>
</form>
<?php

$servername = "localhost";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$servername;dbname=test", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully"; 
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }

$return_arr = array();//An array to hold you SQL data
$counter = 0;
 $sql = 'SELECT schoolName FROM school_name';
    foreach ($conn->query($sql) as $row) {
        $return_arr[$counter] = $row['schoolName'];
        $counter++;
    }

?>

<script src="jquery.js"></script>
<script src="typeahead.js"></script>
<script>
  var substringMatcher = function(strs) {
  return function findMatches(q, cb) {
    var matches, substringRegex;

    // an array that will be populated with substring matches
    matches = [];

    // regex used to determine if a string contains the substring `q`
    substrRegex = new RegExp(q, 'i');

    // iterate through the pool of strings and for any string that
    // contains the substring `q`, add it to the `matches` array
    $.each(strs, function(i, str) {
      if (substrRegex.test(str)) {
        matches.push(str);
      }
    });

    cb(matches);
  };
};
    
  var schools = <?php echo json_encode($return_arr) ?>;
    $('#the-basics .typeahead').typeahead({
  hint: true,
  highlight: true,
  minLength: 3
},
{
  name: 'schools',
  source: substringMatcher(schools)
});
</script>
