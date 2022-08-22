<html>
    <head>
        <title>Dating Application Database</title>
    </head>

    <body>
        <h1>Dating Application Database</h1>
        <h3>Sam Zhao, Aaron Chan, Alvin Zhou</h3>
        <hr/>
        <!-- <h2>Reset</h2>
        <p>If you wish to reset the table press on the reset button. If this is the first time you're running this page, you MUST use reset</p>

        <form method="POST" action="project.php">
            if you want another page to load after the button is clicked, you have to specify that page in the action parameter
            <input type="hidden" id="resetTablesRequest" name="resetTablesRequest">
            <p><input type="submit" value="Reset" name="reset"></p>
        </form>

        <hr /> -->

        <h2>Insert New Profile</h2>
        <form method="POST" action="project.php"> <!--refresh page when submitted-->
            <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
            Profile ID: <input type="text" name="id"> <br /><br />
            Name: <input type="text" name="name"> <br /><br />
            Height (cm): <input type="int" name="height"> <br /><br />
            Gender: <input type="text" name="gender"> <br /><br />
            Date of Birth: <input type="date" name="dob"> <br /><br />
            Age: <input type="int" name="age"> <br /> <br />
            Horoscope: <input type="text" name="horoscope"> <br /> <br />
            <input type="submit" value="Insert" name="insertSubmit"></p>
        </form>

        <hr />

        <h2>Select Attributes from Any Table</h2>
        <form method="GET" action="project.php"> <!--refresh page when submitted-->
            <input type="hidden" id="selectQueryRequest" name="selectQueryRequest">
            Table to select from: <input type="text" name="tableName"> <br /> <br />
            Attributes (seperate with comma): <input type="text" name="attributes"> <br /><br />
            Filters (Field): <input type="text" name="filters"> <br /><br />
            <input type="submit"  name="selectSubmit"></p>
        </form>

        <hr />

        <h2>Delete Profile</h2>
        <form method="POST" action="project.php"> <!--refresh page when submitted-->
            <input type="hidden" id="deleteQueryRequest" name="deleteQueryRequest">
            Profile ID: <input type="text" name="profileID"> <br /><br />
            <input type="submit" value="Delete" name="deleteSubmit"></p>
        </form>

        <hr />

        <h2>Update Profile Settings</h2>
        <p>The values are case sensitive and if you enter in the wrong case, the update statement will not do anything.</p>
        <form method="POST" action="project.php"> <!--refresh page when submitted-->
            <input type="hidden" id="updateQueryRequest" name="updateQueryRequest">
            Profile ID : <input type="text" name="profileID"> <br /><br />
            Attribute to Change: <input type="text" name="attribute"> <br /><br />
            Values of Attribute: <input type="text" name="newValue"> <br /><br />
            Update dob (click checkbox) <input type = "date" name = "newDob"><br /><br />
            <input type = "checkbox" name = "dobCheckbox">
            <input type="submit" value="Update" name="updateSubmit"></p>
        </form>

        <hr />

        <h2>Distance Filter (Premium Feature)</h2>
        <p>Find the names of people closest to your location!</p>
        <form method="GET" action="project.php"> <!--refresh page when submitted-->
            <input type="hidden" id="showDistanceRequest" name="showDistanceRequest">
            Must be less than (km) : <input type="text" name="distance"> <br /><br />
            <input type="submit" value="Submit" name="distanceSubmit"></p>
        </form>

        <hr/>
        <!-- <h2>Count the Tuples in DemoTable</h2>
        <form method="GET" action="project.php"> 
            <input type="hidden" id="countTupleRequest" name="countTupleRequest">
            <input type="submit" name="countTuples"></p>
        </form>

        <hr />

        <h2>Display Tuples</h2>
        <form method="GET" action="project.php">
            <input type="hidden" id="printResult" name="printResult">
            <input type="submit" name="printResult"></p>
        </form> -->


        <h2>Aggregation Group By: Count the Number of Profiles for Each Gender </h2>
        <form method="GET" action="project.php"> <!--refresh page when submitted-->
            <input type="hidden" id="AggregationGroupByRequest" name="AggregationGroupByRequest">
            <input type="submit" name="AggregationGroupBy"></p>
        </form>

        <hr />

        <h2>Aggregation Having: Count The Number of Males and Females</h2>
        <form method="GET" action="project.php">
            <input type="hidden" id="showAggregationHavingRequest" name="showAggregationHavingRequest">
            <input type="submit" name="aggregationHavingSubmit"></p>
        </form>

        <hr />

        <h2>Nested Aggregation: Find Information from the Tallest People for Each Gender </h2>
        <form method="GET" action="project.php"> <!--refresh page when submitted-->
            <input type="hidden" id="nestedRequest" name="nestedRequest">
            <input type="submit" name="showNestedAggregationHavingRequest"></p>
        </form>

        <hr/>

        <h2>Division: Find Profile Who Have Received Every Single Match </h3>
        <form method="GET" action="project.php"> <!--refresh page when submitted-->
            <input type="hidden" id="divisionRequest" name="divisionRequest">
            <input type="submit" name="showDivision"></p>
        </form>

        <hr/>

        <?php
		//this tells the system that it's no longer just parsing html; it's now parsing PHP

        $success = True; //keep track of errors so it redirects the page only if there are no errors
        $db_conn = NULL; // edit the login credentials in connectToDB()
        $show_debug_alert_messages = False; // set to True if you want alerts to show you which methods are being triggered (see how it is used in debugAlertMessage())

        function debugAlertMessage($message) {
            global $show_debug_alert_messages;

            if ($show_debug_alert_messages) {
                echo "<script type='text/javascript'>alert('" . $message . "');</script>";
            }
        }

        function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
            //echo "<br>running ".$cmdstr."<br>";
            global $db_conn, $success;

            $statement = OCIParse($db_conn, $cmdstr);
            //There are a set of comments at the end of the file that describe some of the OCI specific functions and how they work

            if (!$statement) {
                echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($db_conn); // For OCIParse errors pass the connection handle
                echo htmlentities($e['message']);
                $success = False;
            }

            $r = OCIExecute($statement, OCI_DEFAULT);
            if (!$r) {
                echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
                echo htmlentities($e['message']);
                $success = False;
            }

			return $statement;
		}

        function executeBoundSQL($cmdstr, $list) {
            /* Sometimes the same statement will be executed several times with different values for the variables involved in the query.
		In this case you don't need to create the statement several times. Bound variables cause a statement to only be
		parsed once and you can reuse the statement. This is also very useful in protecting against SQL injection.
		See the sample code below for how this function is used */

			global $db_conn, $success;
			$statement = OCIParse($db_conn, $cmdstr);

            if (!$statement) {
                echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($db_conn);
                echo htmlentities($e['message']);
                $success = False;
            }

            foreach ($list as $tuple) {
                foreach ($tuple as $bind => $val) {
                    //echo $val;
                    //echo "<br>".$bind."<br>";
                    OCIBindByName($statement, $bind, $val);
                    unset ($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype
				}

                $r = OCIExecute($statement, OCI_DEFAULT);
                if (!$r) {
                    echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                    $e = OCI_Error($statement); // For OCIExecute errors, pass the statementhandle
                    echo htmlentities($e['message']);
                    echo "<br>";
                    $success = False;
                }
            }
        }

        function printResult($result) { //prints results from a select statement
            echo "<br>Retrieved data from Dating Application:<br>";
            echo "<table>";
            echo "<tr><th>ID</th><th>Name</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row["id"] . "</td><td>" . $row["name"] . "</td></tr>"; //or just use "echo $row[0]"
            }

            echo "</table>";
        }

        function connectToDB() {
            global $db_conn;

            // Your username is ora_(CWL_ID) and the password is a(student number). For example,
			// ora_platypus is the username and a12345678 is the password.
            $db_conn = OCILogon("ora_aaronc73", "a78154739", "dbhost.students.cs.ubc.ca:1522/stu");

            if ($db_conn) {
                debugAlertMessage("Database is Connected");
                return true;
            } else {
                debugAlertMessage("Cannot connect to Database");
                $e = OCI_Error(); // For OCILogon errors pass no handle
                echo htmlentities($e['message']);
                return false;
            }
        }

        function disconnectFromDB() {
            global $db_conn;

            debugAlertMessage("Disconnect from Database");
            OCILogoff($db_conn);
        }

        function handleUpdateRequest() {
            global $db_conn;
            
            $profileID = $_POST['profileID'];
            $attribute = $_POST['attribute'];
            $newValue = $_POST['newValue'];
            $newDob = $_POST['newDob'];
            $checkBox = $_POST['dobCheckbox'];

            // // you need the wrap the old name and new name values with single quotations
            // // executePlainSQL("UPDATE ProfileCreate_3 SET name='" . $new_name . "' WHERE name='" . $old_name . "'");

            if (isset($checkBox)) {
                $attribute = 'dob';
                $newValue = $newDob;
                executePlainSQL("UPDATE ProfileCreate_3 SET " . $attribute . " = to_date('" . $newValue . "', 'YYYY-MM-DD') WHERE id='" . $profileID . "'");
            } else {
                executePlainSQL("UPDATE ProfileCreate_3 SET " . $attribute . " = '" . $newValue . "' WHERE id='" . $profileID . "'");

            }            

            $result = executePlainSQL("SELECT * FROM ProfileCreate_3");

            echo "<br>Updated Attributes in Profile<br>";
            echo "<table>";
            echo "<tr><th>id</th><th>name</th><th>height</th><th>gender</th><th>dob</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3] . "</td><td>" . $row[4] . "</td></tr>"; //or just use "echo $row[0]"
            }

            echo "</table>";

            OCICommit($db_conn);
        }

        function handleJoinRequest() {
            global $db_conn;
            $distance = $_GET['distance'];

            $result = executePlainSQL(
            "SELECT p.id, p.name FROM ProfileCreate_3 p
            JOIN PremiumSet ps
            ON p.id = ps.id
            JOIN Preference pr
            ON ps.id = pr.pid
            WHERE pr.distance < ". $distance ." ");
            
            echo "<br>Retrieved names from Dating Application:<br>";
            echo "<table>";
            echo "<tr><th>ID</th><th>Name</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>"; //or just use "echo $row[0]"
            }

            echo "</table>";

            OCICommit($db_conn);
        }

        function handleResetRequest() {
            global $db_conn;
            // Drop old table
            executePlainSQL("DROP TABLE demoTable");

            // Create new table
            echo "<br> creating new table <br>";
            executePlainSQL("CREATE TABLE demoTable (id int PRIMARY KEY, name char(30))");
            OCICommit($db_conn);
        }

        function handleInsertRequest() {
            global $db_conn;

            //Getting the values from profile and insert data into the table
            $tuple3 = array (
                ":bind1" => $_POST['id'],
                ":bind2" => $_POST['name'],
                ":bind3" => $_POST['height'],
                ":bind4" => $_POST['gender'],
                ":bind5" => $_POST['dob']
            );

            $tuple2 = array (
                ":bind1" => $_POST['dob'],
                ":bind2" => $_POST['horoscope']

            );

            $tuple1 = array (
                ":bind1" => $_POST['dob'],
                ":bind2" => $_POST['age']
            );

            $alltuples3 = array (
                $tuple3
            );

            $alltuples2 = array (
                $tuple2
            );

            $alltuples1 = array (
                $tuple1
            );

            executeBoundSQL("INSERT into ProfileCreate_1(dob, age) values (to_date(:bind1, 'YYYY-MM-DD'), :bind2)", $alltuples1);
            executeBoundSQL("INSERT into ProfileCreate_2 (dob, horoscope) values (to_date(:bind1, 'YYYY-MM-DD'), :bind2)", $alltuples2);
            executeBoundSQL("INSERT into ProfileCreate_3 (id, name, height, gender, dob) values (:bind1, :bind2, :bind3, :bind4, to_date(:bind5, 'YYYY-MM-DD'))", $alltuples3);

            $result = executePlainSQL("SELECT id, name FROM ProfileCreate_3");

            echo "<br>Retrieved data from table:<br>";
            echo "<table>";
            echo "<tr><th>ID</th><th>Name</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>"; //or just use "echo $row[0]"
            }

            echo "</table>";

            OCICommit($db_conn);
        }

        function handleSelectRequest() {
            global $db_conn;

            $tableName = $_GET['tableName'];
            $attributes = $_GET['attributes'];
            $filters = $_GET['filters'];

            $result = executePlainSQL("SELECT " . $attributes . " FROM " . $tableName . " WHERE " . $filters . "");
            
            echo "<br>Attributes Selected: $attributes<br>";
            echo "<br>Retrieved data from table:<br>";
            echo "<table>";
            echo "<tr><th>Attribute 1</th><th>Attribute 2</th><th>Attribute 3</th><th>Attribute 4</th><th>Attribute 5</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3] . "</td><td>" . $row[4] . "</td></tr>"; //or just use "echo $row[0]"
            }

            echo "</table>";

            OCICommit($db_conn);
        }
        
        function handleCountRequest() {
            global $db_conn;

            $result = executePlainSQL("SELECT Count(*) FROM ProfileCreate_3");

            if (($row = oci_fetch_row($result)) != false) {
                echo "<br> The number of tuples in demoTable: " . $row[0] . "<br>";
            }
        }

        function handlePrintRequest() {
            global $db_conn;

            $result = executePlainSQL("SELECT * FROM ProfileCreate_3");

            printResult($result);
        }

        function handleDeleteRequest() {
            global $db_conn;

            $profileID = $_POST['profileID'];

            executePlainSQL("DELETE FROM ProfileCreate_3 WHERE id='" . $profileID . "'");

            echo "<br> Profile with ID " .  $profileID . " deleted <br>";

            $result_pc = executePlainSQL("SELECT id, name, dob FROM ProfileCreate_3");
            $result_ud = executePlainSQL("SELECT * FROM UserDeactivate_2");

            echo "<br>ProfileCreate:<br>";
            echo "<table>";
            echo "<tr><th>Profile ID</th><th>Name</th><th>DoB</th></tr>";

            while ($row = OCI_Fetch_Array($result_pc, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td></tr>"; //or just use "echo $row[0]"
            }

            echo "</table>";

            echo "<br>UserDeactivate:<br>";
            echo "<table>";
            echo "<tr><th>User ID</th><th>Email</th><th>Profile ID</th></tr>";

            while ($row = OCI_Fetch_Array($result_ud, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td></tr>"; //or just use "echo $row[0]"
            }

            echo "</table>";

            OCICommit($db_conn);
        }

        function handleAggregationHavingRequest() {
            global $db_conn;
            
            $result = executePlainSQL("SELECT gender, COUNT(*) AS Count FROM ProfileCreate_3 GROUP BY gender HAVING gender<>'other'");

            echo "<br>Count By Male and Female<br>";
            echo "<table>";
            echo "<tr><th>Gender</th><th>Count</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr>
                    <td>" . $row[0] . "</td>
                    <td>" . $row[1] . "</td>
                </tr>";
            }

            echo "</table>";

            OCICommit($db_conn);
        }
        

        function handleAggregationGroupByRequest() {
            global $db_conn;

            $result = executePlainSQL("SELECT gender, COUNT(*) AS Count FROM ProfileCreate_3 GROUP BY gender");

            echo "<br>Count by Gender<br>";
            echo "<table>";
            echo "<tr><th>Gender</th><th>Count</th>";
            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr>
                    <td>" . $row[0] . "</td>
                    <td>" . $row[1] . "</td>
                    <td>" . $row[2] . "</td>
                </tr>";
            }

            echo "</table>";
            OCICommit($db_conn);

        }
 
        function handleNestedAggregationGroupByRequest() {
            global $db_conn;

            $result = executePlainSQL(
                "SELECT p.name, p.id, p.height, p.gender FROM ProfileCreate_3 p 
                 WHERE height IN 
                (SELECT MAX(height) FROM ProfileCreate_3 GROUP BY gender)");

            echo "<br>Tallest Height by Gender<br>";
            echo "<table>";
            echo "<tr><th>Name</th><th>ID</th><th>Height</th><th>Gender</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] .  "</td><td>" . $row[3] . "</td></tr>";
            }

            echo "</table>";

            OCICommit($db_conn);
        }

        function handleDivisionRequest() {
            global $db_conn;

            $result = executePlainSQL("SELECT p.id, p.name FROM ProfileCreate_3 p WHERE NOT EXISTS
               ((SELECT m.mid 
                FROM Match m)  -- Select all matches that have not matched with profile
                MINUS
               (SELECT r.mid 
                FROM Receive r -- Select all match id's with that matched with the profile
                WHERE r.id = p.id))");

            echo "<br>Name of Profiles with Every Single Match<br>";
            echo "<table>";
            echo "<tr><th>Profile ID</th><th>Name</th></tr>";
            
            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>";
            }

            echo "</table>";
                 
            OCICommit($db_conn);
        }

        // HANDLE ALL POST ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handlePOSTRequest() {
            if (connectToDB()) {
                if (array_key_exists('resetTablesRequest', $_POST)) {
                    handleResetRequest();
                } else if (array_key_exists('updateQueryRequest', $_POST)) {
                    handleUpdateRequest();
                } else if (array_key_exists('insertQueryRequest', $_POST)) {
                    handleInsertRequest();
                } else if (array_key_exists('deleteQueryRequest', $_POST)) {
                    handleDeleteRequest();
                } 

                disconnectFromDB();

            }
        }

        // HANDLE ALL GET ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handleGETRequest() {
            if (connectToDB()) {
                if (array_key_exists('countTuples', $_GET)) {
                    handleCountRequest();
                } else if (array_key_exists('printResult', $_GET)) {
                    handlePrintRequest();
                } else if (array_key_exists('selectQueryRequest', $_GET)) {
                    handleSelectRequest();
                } else if (array_key_exists('showDistanceRequest', $_GET)) {
                    handleJoinRequest();
                } else if (array_key_exists('showAggregationHavingRequest', $_GET)) {
                    handleAggregationHavingRequest();
                } else if (array_key_exists('AggregationGroupByRequest', $_GET)) {
                    handleAggregationGroupByRequest();
                } else if (array_key_exists('nestedRequest', $_GET)) {
                    handleNestedAggregationGroupByRequest();
                } else if (array_key_exists('divisionRequest', $_GET)) {
                    handleDivisionRequest();
                }

                disconnectFromDB();
                
            }
        }
        
        if (isset($_POST['updateSubmit']) || isset($_POST['insertSubmit']) || isset($_POST['deleteSubmit']) || isset($_POST['updateSubmit'])) {
            handlePOSTRequest();
        } else if (isset($_GET['printResult']) || isset($_GET['distanceSubmit']) || isset($_GET['selectSubmit']) || isset($_GET['aggregationHavingSubmit']) || isset($_GET['AggregationGroupBy']) || isset($_GET['showNestedAggregationHavingRequest']) || isset($_GET['showDivision'])) {
            handleGETRequest();
        }
		?>
	</body>
</html>