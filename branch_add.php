<?php
$page = "Branch";
require_once './dbconfig.php';
$branch_name = $branch_name_err = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(!empty($_POST["branch_name"]))
    {
        $sql = "SELECT id FROM branch WHERE branch_name = :branch_name";

        if($stmt = $pdo->prepare($sql)){
            $stmt->bindParam(":branch_name", $param_branch_name, PDO::PARAM_STR);
            $param_branch_name = trim($_POST["branch_name"]);
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $branch_name_err = "This branch is already registered.";
                } else{
                    $branch_name = trim($_POST["branch_name"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            unset($stmt);
        }
        $maker = "0";
        if(empty($branch_name_err)){
            $sql = "INSERT INTO branch (branch_name, maker) VALUES (:branch_name, :maker)";
            if($stmt = $pdo->prepare($sql)){
                $stmt->bindParam(":branch_name", $param_branch_name, PDO::PARAM_STR);
                $stmt->bindParam(":maker", $param_maker, PDO::PARAM_STR);
                $param_branch_name = $branch_name;
                $param_maker = $maker;
                if($stmt->execute()){
                    header("location: branch.php");
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
                unset($stmt);
            }
        }
    }
}
require_once './header.php';
?>
<h1>Branch Add</h1>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <div class="">
        <label for="branch_name">Branch Name: </label>
        <input type="text" name="branch_name" id="branch_name" required>
    </div>
    <div class="">
        <input type="submit" value="Add">
    </div>
</form>
</body>

</html>