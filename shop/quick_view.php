<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/add_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>quick view</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="quick-view">
    <h1 class="title">PRODUCT</h1>
        <div class="box-container">
        <?php
            $pid = $_GET['pid'];
            $select_products = $con->prepare("SELECT * FROM `products` WHERE id= ? ");
            $select_products->execute([$pid]);
            if($select_products->rowCount() > 0){
                while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC))
                {
        ?>
        <form action="" method="POST" class="box">
            <input type="hidden" name="pid" value="<?= $fetch_products['id'];?>">
            <input type="hidden" name="name" value="<?= $fetch_products['name'];?>">
            <input type="hidden" name="price" value="<?= $fetch_products['price'];?>">
            <input type="hidden" name="image" value="<?= $fetch_products['image'];?>">
            <img src="projects images/<?= $fetch_products['image'];?>" class="image" alt="">
            <a href="category.php?category=<?= $fetch_products['category'];?>" class="cat"><?= $fetch_products['category'];?></a>
            <div class="name"><?= $fetch_products['name'];?></div>
            <div class="flex">
                <div class="price"><span>₱</span><?= $fetch_products['price'];?></div>
                <input type="number" name="qty" class="qty" value="1" min="1" max="99" maxlength="2">
            </div>
            <button type="submit" name="add_to_cart" class="cart-btn">ADD TO CART</button>
        </form>
        <?php
                }
        }else{
                echo'<div class="empty">no products found</div>';
        }
            
        ?>
        </div>
</section>
















<?php include 'components/footer.php'; ?>


<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>


</body>
</html>