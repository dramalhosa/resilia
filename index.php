<?php
	//This script lets you read the excel that was imported
	require_once 'SimpleXLSX.php';
	//This connect to the database
	$db = new PDO('mysql:host=localhost;dbname=resilia', DBUSER, DBPASS);
	//This checks if a file has been submitted
	if(isset($_POST['submit'])){
		//This formats the name to a variable
		$filename=$_FILES["fileImport"]["tmp_name"];
		//Use what was required to read the file
		if ($xlsx = SimpleXLSX::parse($filename)){
			//Each rows() is a sheet in the file.  The first is the Nonprofit Organization list
			foreach($xlsx->rows(0) as $key => $orgs){
				//Skip the first row because it is the headers
				if($key === 0){
					continue;
				}
				//Prepare the sql statement.  This will insert new rows into the database and update any existing ones
				$stmt = $db->prepare('INSERT INTO nonprofitorglist (`name`, `501C3Status`, `state`, `city`) values(:name, :status, :state, :city) ON DUPLICATE KEY UPDATE 501C3Status = :status');
				//Bind what is in the excel file to the parameters
				$stmt->bindParam(':name', $orgs[0], PDO::PARAM_STR);
				$stmt->bindParam(':status', $orgs[1], PDO::PARAM_STR);
				$stmt->bindParam(':state', $orgs[2], PDO::PARAM_STR);
				$stmt->bindParam(':city', $orgs[3], PDO::PARAM_STR);
				$stmt->execute();
			}
			//Now look at the  second sheet
			foreach($xlsx->rows(1) as $key => $users){
				//Skip headers again
				if($key === 0){
					continue;
				}
				//I am using email  and organization as unique constraints.  The reason for this is in case one person is a part of multiple organizations
				//This will insert the data and ignore any duplicates
				$stmt = $db->prepare('INSERT IGNORE INTO userlist (`name`, `email`, `role`, `org`) values(:name, :email, :role, :org)');
				$stmt->bindParam(':name', $users[0], PDO::PARAM_STR);
				$stmt->bindParam(':email', $users[1], PDO::PARAM_STR);
				$stmt->bindParam(':role', $users[2], PDO::PARAM_STR);
				$stmt->bindParam(':org', $users[3], PDO::PARAM_STR);
				$stmt->execute();
			}
			//This alerts the user that the table has been updated
			echo "Table updated";
		}
	}
	?>
	<!--This is the form that lets users import the excel file-->
	<form action='index.php' enctype='multipart/form-data' method='post'>
      <div class="col-auto my-1">
        <label for="exampleFormControlFile1">Import File</label>
        <input type="file" class="form-control-file" name="fileImport">
      </div>
      <div>
        <div class="col-auto my-1">
          <button type="submit" name='submit' value="import" class="btn btn-file">Import</button>
        </div>
    </form>

<?php
	//This gets a distinct count of non profits by state from the nonprofit list
	$statement = $db->query('SELECT DISTINCT state, count(state) over (PARTITION BY state) as total FROM `nonprofitorglist` ORDER BY total DESC');
	$rows = $statement->fetchAll();
	//To display which state has the most, it needs to compared.  Max is initially set to 0
	$max = 0;
	//For each row, it will compare the total to Max.  If it is bigger, it will save the state with the total.  This will then set a new max.
	//If two or more states have the same max, it will save all of them
	foreach($rows as $row){
		if($row['total'] >= $max){
			$maxList[$row['state']] = $row['total'];
			$max = $row['total'];
		}
	}
	//This displays which state(s) have the most non profits with their counts
	echo "The following states have the most nonprofits at " . $max . ": ";
	foreach($maxList as $state => $value){
		echo $state . " ";
	}
	//This gets a distinct count of non profits by organization from the user list
	$statement = $db->query('SELECT DISTINCT org, count(org) over (PARTITION BY org) as total FROM `userList` ORDER BY total DESC;');
	$rows = $statement->fetchAll();
	//Count and total are initially set to 0
	$count = 0;
	$total = 0;
	//For each row, it will add the total and up the count by one
	foreach($rows as $row){
		$total = $total + $row['total'];
		$count++;
	}
	//This will get the average by dividing total / count and display the answer
	echo "<br>The average # of users at a nonprofit is: " . $total / $count;
	//This will get a distinct count of non profits, states they are in, and counts of users.  It joins together the two tables to do so
	$statement = $db->query('SELECT DISTINCT userlist.org, nonprofitorglist.state, count(userlist.org) over (PARTITION BY userlist.org) as total FROM `userList` INNER JOIN nonprofitorglist WHERE nonprofitorglist.name = userlist.org;');
	$rows = $statement->fetchAll();
	//$state by default is an emptry array.  This will be used to see the max number of users per state
	$state = [];
	foreach($rows as $row){
		//If the state in the current row is not in the state array, it will be added since it is the first instance
		//If the state in the current row is already in the state array, it will compare who is larger.  If the new one is, it will overwrite it
		if(!isset($state[$row['state']]) || $state[$row['state']]['total'] < $row['total']){
			$state[$row['state']]['org'] = $row['org'];
			$state[$row['state']]['total'] = $row['total'];
			//If the state in the current row has the same total as what is in the state array, it will add that organization to it
		} else if($state[$row['state']]['total'] == $row['total']){
			$state[$row['state']]['org'] .= ", " . $row['org'];
		}
	}
?>
<!--This table will diplay the results-->
<table>
	<tr>
		<th>State</th>
		<th>Number of users</th>
		<th>Total</th>
	</tr>
	<?php
		foreach($state as $key => $value){
			echo "<tr>";
				echo "<td>" . $key . "</td>";
				echo "<td>" . $value['org'] . "</td>";
				echo "<td>" . $value['total'] . "</td>";
			echo "</tr>";
		}
	?>
</table>
