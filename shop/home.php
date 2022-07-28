<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}else{
    $user_id = '';
}

if(isset($_POST['submit1'])){

    $name =$_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email =$_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $msg =$_POST['message'];
    $msg = filter_var($msg, FILTER_SANITIZE_STRING);
 
    $select_message = $con->prepare("SELECT * FROM `messages` WHERE name=? 
    AND email= ? AND message = ?");
    $select_message->execute([$name, $email, $msg]);
 
    if($select_message->rowCount() > 0){
       $message[] = 'Message sent already!';
    }else{
       $insert_message = $con->prepare("INSERT INTO `messages` (user_id, name, 
       email, message) VALUES(?,?,?,?)");
       $insert_message->execute([$user_id, $name, $email, $msg]);
       $message[] = 'message sent successfully!';
    }
 
 }

include 'components/add_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link
        rel="stylesheet"
        href="https://unpkg.com/swiper@8/swiper-bundle.min.css"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    
<!-- Header -->
<?php include 'components/user_header.php'?>
<!-- Header -->

<!--home section-->
<section class="home">
    <div class="swiper home-slider">
        <div class="swiper-wrapper">

            <div class="swiper-slide">
                <div class="content">
                    <span>RESERVE NOW</span>
                    <h3>BURGER</h3>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Commodi, rem!</p>
                    <a href="menu.php" class="btn">SHOP NOW</a>
                </div>
                <div class="image">
                    <img src="images/home-1.png" alt="">
                </div>
            </div>

            <div class="swiper-slide">
                <div class="content">
                    <span>RESERVE NOW</span>
                    <h3>FRIES</h3>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Commodi, rem!</p>
                    <a href="menu.php" class="btn">SHOP NOW</a>
                </div>
                <div class="image">
                    <img src="images/home-2.png" alt="">
                </div>
            </div>

            <div class="swiper-slide">
                <div class="content">
                    <span>RESERVE NOW</span>
                    <h3>MILKTEA</h3>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Commodi, rem!</p>
                    <a href="menu.php" class="btn">SHOP NOW</a>
                </div>
                <div class="image">
                    <img src="images/home-3.png" alt="">
                </div>
            </div>
            
      </div>
      <div class="swiper-pagination"></div>
    </div>
</section>
<!--home section-->

<!--home category section-->
<section class="home-category" id="menu-section">
        <h1 class="title">FOOD CATEGORY</h1>
        <div class="box-container">
            <a href="category.php?category=fast food" class="box">
                <img src="images/cate-1.png" alt="">
                <h3>FAST FOOD</h3>
            </a>
            <a href="category.php?category=main dish"  class="box">
                <img src="images/cate-2.png" alt="">
                <h3>DISH</h3>
            </a>
            <a href="category.php?category=drinks"  class="box">
                <img src="images/cate-3.png" alt="">
                <h3>DRINKS</h3>
            </a>
            <a href="category.php?category=desserts"  class="box">
                <img src="images/cate-4.png" alt="">
                <h3>DESSERTS</h3>
            </a>
        </div>
</section>
<!--home category section-->

<!--home products section-->
<section class="products">
    <h1 class="title">LATEST FOOD</h1>
    <div class="more-products">
        <a href="menu.php"><span>SEE ALL</span>→</a>
    </div>
    <div class="box-container">
     <?php
        $select_products = $con->prepare("SELECT * FROM `products` LIMIT 8");
        $select_products->execute();
        if($select_products->rowCount() > 0){
            while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC))
            {
     ?>
    <form action="" method="POST" class="box">
        <input type="hidden" name="pid" value="<?= $fetch_products['id'];?>">
        <input type="hidden" name="name" value="<?= $fetch_products['name'];?>">
        <input type="hidden" name="price" value="<?= $fetch_products['price'];?>">
        <input type="hidden" name="image" value="<?= $fetch_products['image'];?>">
        <a href="quick_view.php?pid=<?= $fetch_products['id'];?>" class="fas fa-eye"></a>
        <button type="submit" name="add_to_cart" class="fas fa-shopping-cart"></button>
        <img src="projects images/<?= $fetch_products['image'];?>" class="image" alt="">
        <a href="category.php?category=<?= $fetch_products['category'];?>" class="cat"><?= $fetch_products['category'];?></a>
        <div class="name"><?= $fetch_products['name'];?></div>
        <div class="flex">
            <div class="price"><span>₱</span><?= $fetch_products['price'];?></div>
            <input type="number" name="qty" class="qty" value="1" min="1" max="99" maxlength="2">
        </div>
    </form>
     <?php
            }
       }else{
            echo'<div class="empty">no products added yet!</div>';
       }
        
     ?>
    </div>
</section>
<!--home products section-->

<!--about section -->

<section class="about" id="about-section">
    <h1 class="title">ABOUT US</h1>
   <div class="row">
      <div class="image">
         <img src="images/about-us.png" alt="">
      </div>
      <div class="content">
         <h3>Why dine in us?</h3>
         <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Corporis doloremque ex, optio repellat aspernatur voluptatibus expedita eligendi aperiam nisi fugiat nobis consectetur, eum quam quis officiis saepe porro voluptate dignissimos. Quae quos ullam saepe nam dicta, sunt asperiores impedit reiciendis laudantium? Quis neque ipsam vitae eius doloremque, nemo distinctio odit.</p>
         <a href="menu.php" class="btn">MENU</a>
      </div>
   </div>
</section>

<!--about section -->

<section class="contact" id="contact-section">
   <h1 class="title">QUESTIONS?</h1>
   <div class="row">

      <div class="image">
         <img src="images/contact-us.png" alt="">
      </div>

      <form action="" method="POST">
         <h3>Contact Us!</h3>
         <input type="text" required placeholder="enter your name" 
         maxlength="50" name="name" class="box">
         <input type="email" required placeholder="enter your email" 
         maxlength="50" name="email" class="box">
         <textarea name="message" class="box" required maxlength="500" 
         cols="30" rows="10" placeholder="enter your message"></textarea>
         <input type="submit" value="send message" class="btn" name="submit1">
      </form>
   
   </div>

</section>

<!-- contact section ends -->










<!--footer-->
<?php include 'components/footer.php';?>
<!--footer-->



<script src="js/script.js"></script>
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper(".home-slider", {
        effect: "flip",
        grabCursor: true,
        loop:true,
        autoplay: {
          delay: 3000,
          disableOnInteraction: false,
        },
        pagination: {
            clickable: true,
          el: ".swiper-pagination",
        },
      });
</script>

</body>
</html>
