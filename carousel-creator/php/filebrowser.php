
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap');

    body{
      margin:0;
      padding:15px;
      font-family: 'Roboto', sans-serif;
    }

ul{
   list-style-type: none;
   display:grid;
   grid-template-columns: 1fr 1fr;
   margin:0;
   padding:0;
   gap:20px;
}

@media(max-width:960px){
   grid-template-columns: 1fr;
}

img{
   border-radius:5px;
}

li{text-align: center;}

.thisphoto{
   cursor: pointer;
}

</style>
 
<ul>
<?php 


$dir    = '../img/';
$files1 = array_diff(scandir($dir), array('..', '.'));



foreach($files1 as $value){

   echo '<li class="thisphoto"> <img data-img="'.$value.'" style=" width:100%;height:150px;object-fit:cover;margin:10px 0;display:block;" src="/bl-plugins/carousel-creator/img/'.$value.'">
   
   <p>'.$value.'</p>
   </li>';
  
}

;?>
</ul>