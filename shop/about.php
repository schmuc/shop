<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>About</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->





<!--about section -->

<section class="about">
   <div class="row">
      <div class="image">
         <img src="images/about-img.svg" alt="">
      </div>
      <div class="content">
         <h3>Why dine in us?</h3>
         <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Corporis doloremque ex, optio repellat aspernatur voluptatibus expedita eligendi aperiam nisi fugiat nobis consectetur, eum quam quis officiis saepe porro voluptate dignissimos. Quae quos ullam saepe nam dicta, sunt asperiores impedit reiciendis laudantium? Quis neque ipsam vitae eius doloremque, nemo distinctio odit.</p>
         <a href="menu.php" class="btn">MENU</a>
      </div>
   </div>
</section>

<!--about section -->














<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->








<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>