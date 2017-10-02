<?php
    include_once 'psl-config.php';

    $action=$_POST["action"];
    if($action=="showdata")
    {
        // Our database object
        $db = new Db();
        // Quote and escape form submitted values
        $rows = $db -> select("SELECT a.ID,a.fname,a.lname,a.DOB,b.row_id, b.home, b.work, b.cell
FROM basicInfo a LEFT JOIN contactInfo b ON a.ID = b.ID ORDER BY fname");
       $row_cnt = sizeof($rows);
        $id_flag = '00000';
        $count_flag = 0;
        foreach($rows as $row){
            if($count_flag<$row_cnt)
                $count_flag += 1;
            echo "<div class='row'>";
                echo "<div class='col-sm-2'></div>";
                echo "<div class='col-sm-8'>";
                        if($id_flag!=$row['ID']){
                            $id_flag = $row['ID'];
                            echo "<div class='form-group row name-header'>";
                                echo "<div class='col-xs-10'>";
                                    echo "<h3>".$row['fname']."</h3>";
                                echo "</div>";
                                echo "<div class='col-xs-2'>";
                                    echo "<button class='del-btn btn btn-primary' id='d-a-".$row['ID']."' type='submit'>Delete</button>";
                                echo "</div>";
                            echo "</div>";
                        }
                        else{

                        }
                        echo "<div class='form-group row'>";
                            echo "<div class='col-sm-2'></div>";
                            echo "<div class='col-sm-8'>";
                                if($row['home']>""){
                                        echo "<div class='row'>";
                                            echo "<div class='col-sm-4'>";
                                                echo "<h4>Home: </h4>";
                                            echo "</div>";
                                            echo "<div class='col-sm-4'>";
                                                echo "<h4>".FormatNumber($row['home'])."</h4>";
                                            echo "</div>";
                                            echo "<div class='col-sm-4 del-btn-2'>";
                                                echo "<button class='btn btn-default' id='d-p-".$row['row_id']."' type='submit'>X</button>";
                                            echo "</div>";
                                        echo "</div>";
                                }
                                if($row['work']>""){
                                        echo "<div class='row'>";
                                            echo "<div class='col-sm-4'>";
                                                echo "<h4>Work: </h4>";
                                            echo "</div>";
                                            echo "<div class='col-sm-4'>";
                                                echo "<h4>".FormatNumber($row['work'])."</h4>";
                                            echo "</div>";
                                            echo "<div class='col-sm-4 del-btn-2'>";
                                                echo "<button class='btn btn-default' id='d-p-".$row['row_id']."' type='submit'>X</button>";
                                            echo "</div>";
                                        echo "</div>";
                                }
                                if($row['cell']>""){
                                        echo "<div class='row'>";
                                            echo "<div class='col-sm-4'>";
                                                echo "<h4>Cell: </h4>";
                                            echo "</div>";
                                            echo "<div class='col-sm-4'>";
                                                echo "<h4>".FormatNumber($row['cell'])."</h4>";
                                            echo "</div>";
                                            echo "<div class='col-sm-4 del-btn-2'>";
                                                echo "<button class='btn btn-default' id='d-p-".$row['row_id']."' type='submit'>X</button>";
                                            echo "</div>";
                                        echo "</div>";
                                }
                                if($count_flag<=$row_cnt){
                                    if($rows[$count_flag]['ID']!=$row['ID'])
                                    {
                                            echo "<div class='row'>";
                                                echo "<div class='col-sm-4'>";
                                                ?>
                                                    <div class="form-group">
                                                      <select class="form-control" id="<?php echo "a-t-".$row['ID'] ?>">
                                                        <option>Home</option>
                                                        <option>Work</option>
                                                        <option>Cell</option>
                                                      </select>
                                                    </div>
                                                <?php
                                                echo "</div>";
                                                echo "<div class='col-sm-4'>";
                                                    echo "<input type='text' class='form-control input-field' id='a-p-".$row['ID']."' placeholder=''>";
                                                echo "</div>";
                                                echo "<div class='col-sm-4 add-btn-2'>";
                                                    echo "<button class='btn btn-default' id='a-b-".$row['ID']."' type='submit'>Add</button>";
                                                echo "</div>";
                                            echo "</div>";
                                    }
                                }
                            echo "</div>";
                            echo "<div class='col-sm-2'></div>";
                        echo "</div>";
                echo "</div>";
                echo "<div class='col-sm-2'></div>";
            echo "</div>";

        } //end of foreach

    }
    if($action=="addname")
    {
        if(strlen($_POST['name'])==0)
        {
            echo "error : no input";
            exit;
        }
        else
        {
            // Our database object
            $db = new Db();
            // Quote and escape form submitted values
            $name = $db -> quote(ucfirst(strtolower($_POST['name'])));
            $rows = $db -> select("SELECT IFNULL(MAX(ID)+1,10001) AS ID FROM `basicInfo`");

            // Insert the values into the database
            $result = $db -> query("INSERT INTO `basicInfo` (`ID`,`fname`) VALUES (" . $rows[0]['ID'] . "," . $name .  ")");

          if($result){
              echo json_encode("Data Inserted Successfully");
              }
          else {
              echo json_encode($rows);
              }
        }
    }
    if($action=="addnumber")
    {
        if(strlen($_POST['num'])!==10)
        {
            echo "error : not valid";
            exit;
        }
        else
        {
            // Our database object
            $db = new Db();
            // Quote and escape form submitted values
            $num = $db -> quote($_POST['num']);
            $id = $db -> quote($_POST['id']);
            $rows = $db -> select("SELECT IFNULL(MAX(row_id)+1,1) AS row_id FROM `contactInfo`");

            // Insert the values into the database
            $result = $db -> query("INSERT INTO `contactInfo` (`row_id`,`ID`,".$_POST['type'].") VALUES (" . $rows[0]['row_id'] . ",". $id . "," . $num .  ")");

          if($result){
              echo "DATA inserted: INSERT INTO `contactInfo` (`row_id`,".$_POST['type'].") VALUES (" . $rows[0]['row_id'] . "," . $num .  ")";
              }
          else {
              echo "INSERT INTO `contactInfo` (`row_id`,".$_POST['type'].") VALUES (" . $rows[0]['row_id'] . "," . $num .  ")";
              }
        }
    }
if($action=="delnumber")
    {

            // Our database object
            $db = new Db();
            // Quote and escape form submitted values
            $row_id = $db -> quote($_POST['row_id']);

            // Delete from the database
            $result = $db -> query("DELETE FROM contactInfo WHERE row_id=".$row_id);

          if($result){
              echo "DELETE FROM contactInfo WHERE row_id=".$row_id;
              }
          else {
              echo "DELETE FROM contactInfo WHERE row_id=".$row_id;
              }

    }

if($action=="delperson")
    {

            // Our database object
            $db = new Db();
            // Quote and escape form submitted values
            $id = $db -> quote($_POST['ID']);

            // Delete from database
            $result = $db -> query("DELETE FROM basicInfo WHERE ID=".$id);

            $result = $db -> query("DELETE FROM contactInfo WHERE ID=".$id);

          if($result){
             echo "Deleted person";
              }
          else {
              echo "ERROR: Unable to delete";
              }

    }
function FormatNumber($num){
    if(  preg_match( '/^(\d{3})(\d{3})(\d{4})$/', $num,  $matches ) )
    {
        $result = $matches[1] . '.' .$matches[2] . '.' . $matches[3];
        return $result;
    }
}
?>
