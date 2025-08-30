<?php
// $connect=new mysqli('localhost','root','','perfume');

// if($connect->connect_error){
//     die("Connection error: ".$connect->connection_error);
// }


include '../connect.php';

if($_SERVER['REQUEST_METHOD']=='POST'){
    $name=$_POST['name'];
    $concentration=$_POST['concentration'];
    $price=$_POST['price'];


    $targetDir='../uploads/';
    $targetFile=$targetDir.basename($_FILES['photo']['name']);
    move_uploaded_file($_FILES['photo']['tmp_name'],$targetFile);


    $stmt=$connect->prepare("INSERT INTO info (name, concentration, price, photo) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $name, $concentration, $price, $targetFile);

    if($stmt->execute()){
        // echo "Colone added successfully";
        header("Location: create.php");
    }else{
        echo "Error: ".$stmt->error;
    }

    $stmt->close();
    // $connect->close(); close korle somossa hoy

}

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Create Perfume</title>
</head>
<body>
    <div class="container mt-5">
        <h1>Add Perfume</h1>
        <form action="create.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Perfume Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group mt-3">
                <label for="concentration">Concentration</label>
                <input type="text" class="form-control" id="concentration" name="concentration" required>
            </div>
            <div class="form-group mt-3">
                <label for="price">Price</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" required>
            </div>
            <div class="form-group mt-3">
                <label for="photo">Upload Photo</label>
                <input type="file" class="form-control" id="photo" name="photo" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Submit</button>
        </form>

        <hr>
        <h2>Available Perfumes</h2>
                    <table class="table table-bordered mt-3">
            <thead>
                <tr>
                <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Concentration</th>
                    <th scope="col">Price</th>
                    <th scope="col">Photo</th>
                    <th scope="col">Actions</th>
                
                </tr>
            </thead>
            <tbody>
                        <?php
                            $result=$connect->query("SELECT * FROM info");
                            while($row=$result->fetch_assoc()){
                                echo "<tr>
                                <td>".$row['id']."</td>
                                <td>".$row['name']."</td>
                                <td>".$row['concentration']."</td>
                                <td>".$row['price']."</td>
                                <td><img src='".$row['photo']."' alt='Perfume Photo' style='width: 100px;'></td>
                                <td>
                                    <a href='update.php?id=".$row['id']."' class='btn btn-warning btn-sm'>Edit</a>
                                    <a href='delete.php?id=".$row['id']."' class='btn btn-danger btn-sm'>Delete</a>
                                </td>
                                </tr>";
                            }


                        ?>
            </tbody>
            </table>
                    


    </div>
</body>
</html>