 <style>



   .sidebar {
     display: none !important;
   }

   .container {
     max-width: unset !important;
     width: 100% !important;
   }

   .col-lg-10 {
     all: unset;
     width: 100% !important;
   }
 </style>

 <?php

  $count = 0;
  foreach (glob(PATH_UPLOADS. 'carouselCreator/*') as $img) {

    $base = pathinfo($img)['basename'];

    echo '<a href="' . $base . '" class="photo" onclick="event.preventDefault();submitLink(' . $count . ')">
    <img src="' . $base . '" style="width:100px;height:100px;object-fit:cover;margin:10px;"></a>';
    $count++;
  }; ?>


 <script>
   document.querySelectorAll('.photo').forEach(x => {
  x.setAttribute('href', window.location.origin + '/bl-content/uploads/carouselCreator/' + x.getAttribute('href'))
 x.querySelector('img').setAttribute('src', window.location.origin + '/bl-content/uploads/carouselCreator/' + x.querySelector('img').getAttribute('src'));

   })


   function submitLink(e) {


     let linker = document.querySelectorAll('.photo img')[e].getAttribute('src');
     console.log(linker);
     let linkerNew = linker;


if('<?php echo $_GET['class'];?>'=='takephoto'){
     window.opener.document.querySelectorAll('input[name="carouselimage[]"]')[<?php echo $_GET['index'];?>].setAttribute('value',linker);

}else{
       window.opener.document.querySelectorAll('input.newimagecar')[<?php echo $_GET['index'];?>].setAttribute('value',linker);
}


 
     window.close();
   }


  
 </script>



 </div>
 </div>
 </div>
 </body>

 </html>