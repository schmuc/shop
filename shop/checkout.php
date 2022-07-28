<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:login.php');
};

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $total_products = $_POST['total_products'];
   $total_products = filter_var($total_products, FILTER_SANITIZE_STRING);
   $total_price = $_POST['total_price'];
   $total_price = filter_var($total_price, FILTER_SANITIZE_STRING);

   $check_cart = $con->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if($check_cart->rowCount() > 0){

      if($number == ''){
         $message[] = 'Please add your number!';
      }else{
         
         $insert_order = $con->prepare("INSERT INTO `orders`(user_id, name, number, email, total_products, total_price) VALUES(?,?,?,?,?,?)");
         $insert_order->execute([$user_id, $name, $number, $email, $total_products, $total_price]);

         $delete_cart = $con->prepare("DELETE FROM `cart` WHERE user_id = ?");
         $delete_cart->execute([$user_id]);

         $message[] = 'Order placed successfully!';
      }
      
   }else{
      $message[] = 'Cart is empty';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<div class="heading">
   <h3>Checkout</h3>
   <p><a href="home.php">home</a> <span> / checkout</span></p>
</div>

<!-- checkout section starts  -->
<section class="checkout">

   <h1 class="title">Order Summary</h1>

<form action="" method="POST">

   <div class="cart-items">
      <h3>Items</h3>
      <?php
         $grand_total = 0;
         $cart_items[] = '';
         $select_cart = $con->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
               $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - ';
               $total_products = implode($cart_items);
               $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
      ?>
      <p><span class="name"><?= $fetch_cart['name']; ?></span><span class="price">₱<?= $fetch_cart['price']; ?> x <?= $fetch_cart['quantity']; ?></span></p>
      <?php
            }
         }else{
            echo '<p class="empty">your cart is empty!</p>';
         }
      ?>
      <p class="grand-total"><span class="name">grand total :</span><span class="price">₱<?= $grand_total; ?></span></p>

   </div>

   <input type="hidden" name="total_products" value="<?= $total_products; ?>">
   <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
   <input type="hidden" name="name" value="<?= $fetch_profile['name'] ?>">
   <input type="hidden" name="number" value="<?= $fetch_profile['number'] ?>">
   <input type="hidden" name="email" value="<?= $fetch_profile['email'] ?>">

   <div class="user-info">
      <h3>Information</h3>
      <p><i class="fas fa-user"></i><span><?= $fetch_profile['name'] ?></span></p>
      <p><i class="fas fa-phone"></i><span><?= $fetch_profile['number'] ?></span></p>
      <p><i class="fas fa-envelope"></i><span><?= $fetch_profile['email'] ?></span></p>
      <a href="update_profile.php" class="btn">Update Information</a>
      <input type="submit" value="Place Order" class="btn <?php if($grand_total== '0'){echo 'disabled';} ?>" style="width:100%; background: #00ff3c; color:var(--white); margin-top: 2rem;" name="submit">
      <a href="cart.php" class="btn" style=" background-color: var(--red); width: 100%; text-align: center;">GO BACK</a>
   </div>

</form>
   
</section>
<!-- checkout section ends -->









<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->






<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>