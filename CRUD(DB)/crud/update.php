<?php

include '../connect.php';
$id = $_GET['id'];
$stmt = $connect->prepare("SELECT * FROM info WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$perfume = $result->fetch_assoc();
$stmt->close();




if($_SERVER['REQUEST_METHOD']=='POST'){
    // $id=$_GET['id'];
    $name=$_POST['name'];
    $concentration=$_POST['concentration'];
    $price=$_POST['price'];

    $targetDir='../uploads/';
    $targetFile=$targetDir.basename($_FILES['photo']['name']);
    $photoUpdated=false;
    
    if(!empty($_FILES['photo']['name'])){
        move_uploaded_file($_FILES['photo']['tmp_name'],$targetFile);
        $photoUpdated=true;
    }


    if($photoUpdated){
        $stmt=$connect->prepare("UPDATE info SET name=?, concentration=?, price=?, photo=? WHERE id=?");
        $stmt->bind_param("ssdsi", $name, $concentration, $price, $targetFile, $id);
    }else{
        $stmt=$connect->prepare("UPDATE info SET name=?, concentration=?, price=? WHERE id=?");
        $stmt->bind_param("ssdi", $name, $concentration, $price, $id);
    }


    if($stmt->execute()){
        header("Location: create.php");
    }else{
        echo "Error: ".$stmt->error;
    }

    $stmt->close();
    $connect->close();

}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Update Perfume</title>
</head>
<body>
    <div class="container mt-5">
        <h1>Update Perfume</h1>
        <form action="update.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" 
            value="<?php echo $perfume['id']; ?>"
            >
            <div class="form-group">
                <label for="name">Perfume Name</label>
                <input type="text" class="form-control" id="name" name="name" 
                value="<?php echo $perfume['name']; ?>" 
                required>
            </div>
            <div class="form-group mt-3">
                <label for="concentration">Concentration</label>
                <input type="text" class="form-control" id="concentration" name="concentration" 
                value="<?php echo $perfume['concentration']; ?>"
                 required>
            </div>
            <div class="form-group mt-3">
                <label for="price">Price</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" 
                value="<?php echo $perfume['price']; ?>" 
                required>
            </div>
            <div class="form-group mt-3">
                <label for="photo">Upload New Photo (optional)</label>
                <input type="file" class="form-control" id="photo" name="photo">
            </div>
            <button type="submit" class="btn btn-primary mt-3">Update</button>
        </form>
    </div>
</body>
</html>

