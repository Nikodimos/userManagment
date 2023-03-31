<?php 
    //include configuration file
    $page = "Branch";
    require_once './dbconfig.php';

    $start = 0;  $per_page = 10;
    $page_counter = 0;
    $next = $page_counter + 1;
    $previous = $page_counter - 1;
    
    if(isset($_GET['start'])){
     $start = $_GET['start'];
     $page_counter =  $_GET['start'];
     $start = $start *  $per_page;
     $next = $page_counter + 1;
     $previous = $page_counter - 1;
    }
    // query to get messages from messages table
    $q = "SELECT * FROM branch LIMIT $start, $per_page";
    $query = $pdo->prepare($q);
    $query->execute();

    if($query->rowCount() > 0){
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
    }
    // count total number of rows in students table
    $count_query = "SELECT * FROM branch";
    $query = $pdo->prepare($count_query);
    $query->execute();
    $count = $query->rowCount();
    // calculate the pagination number by dividing total number of rows with per page.
    $paginations = ceil($count / $per_page);
    require_once 'header.php';

?>

<div class="table-responsive" style="width: 600px; border: 1px solid black; margin: 10px;">
            <table class="table table-striped" class="table table-hover">
                <thead class="table-info">
                 <th scope="col" class="bg-primary" >Id</th>
                 <th scope="col" class="bg-primary">BRANCH NAME</th>
                 <th scope="col" class="bg-primary">MAKER</th>
                 <th scope="col" class="bg-primary">CREATED AT</th>
                </thead>
                <tbody>
                <?php 
                    foreach($result as $data) { 
                        echo '<tr>';
                        echo '<td>'.$data['id'].'</td>';
                        echo '<td>'.$data['branch_name'].'</td>';
                        echo '<td>'.$data['maker'].'</td>';
                        echo '<td>'.$data['date_time'].'</td>';
                        echo '</tr>';
                    }
                 ?>
                </tbody>
            </table>
            <center>
            <ul class="pagination">
            <?php
                if($page_counter == 0){
                    echo "<li><a href=?start='0' class='active'>0</a></li>";
                    for($j=1; $j < $paginations; $j++) { 
                      echo "<li><a href=?start=$j>".$j."</a></li>";
                   }
                }else{
                    echo "<li><a href=?start=$previous>Previous</a></li>"; 
                    for($j=0; $j < $paginations; $j++) {
                     if($j == $page_counter) {
                        echo "<li><a href=?start=$j class='active'>".$j."</a></li>";
                     }else{
                        echo "<li><a href=?start=$j>".$j."</a></li>";
                     } 
                  }if($j != $page_counter+1)
                    echo "<li><a href=?start=$next>Next</a></li>"; 
                } 
            ?>
            </ul>
            </center>    
        </div>  
        </body>
</html>
        