
 

<style>
.carousel-text{
    height: 300px;
}

.carousel-items{
  position: relative;
  padding-top: 30px !important;

}

.carousel-items .closethis{

  position: absolute;
  top:0;
  right:0;
  padding: 10px;
  margin-bottom: 20px;
  
}



</style>
 

<div class="border my-2 mt-5 bg-light p-4">


<p class="h4 mb-4">How to use it?</p>
<ul class="p-0" style="list-style-type:square;margin-left:15px;">
  <li><p><b>1.</b> upload photos to carousel folder </p></li>
  <li><p><b>2.</b> Add slider to your carousel on button "add slider"</p></li>
  <li><p><b>3.</b> set photo and content to every slider</p></li>
<li><p><b>4.</b> Config settings on carousel </p></li>
<li><p><b>5.</b> put <code> &#60;?php Theme::plugins('runCarousel');?&#62;</code> on your template </p></li>
</ul>

</div>

<div class="bg-dark text-light border py-2 p-3 col-md-12">
  <h4 class="mb-4">Upload photo to plugin folder (2mb max)</h4>
<input type="file" name="image"><br>
<hr style="border:solid 1px rgba(255,255,255,0.3); height:0;">
<input type="submit" value="send photo" class="btn btn-primary btn-sm">

</div>

<br>
<br>

<h4>Slider Item Manager </h4>

<div class=" sliderlist mt-4">

    
<div class="col-md-12 bg-dark border p-2">
<button class="btn-outline-light btn addslider">Add slider</button>
</div>


<?php


$filecontent = file_get_contents($this->phpPath().'sliders.json');
          
$resultMe = json_decode($filecontent);

foreach($resultMe as $res){


echo '<div class="carousel bg-light  shadow-sm border p-3 my-3 carousel-items"><button class="closethis btn btn-dark btn-sm">Close</button>    <h4>Carousel item</h4>';
echo '<input class="form-control mb-2 image-car" type="text" value="'.$res->image.'" name="carouselimage[]" placeholder="image">';
echo '<button class="takephoto btn-dark btn my-2">Choose photo</button>';
echo '<textarea class="carousel-text" id="editor1" name="carouselcontent[]">'.$res->content.'</textarea>';
echo ' </div>';

};

;?>



 


</div>



<script src="https://cdn.ckeditor.com/4.19.0/standard/ckeditor.js"></script>

<script>
     
  if(document.querySelector('textarea')){

    document.querySelectorAll('textarea').forEach(c=>{

CKEDITOR.replace(c, {
height: 230,
toolbar: 'basic'

});

 
});

  };


  let counters = 1;


  document.querySelector('.addslider').addEventListener('click',(e)=>{
    e.preventDefault();

    document.querySelector('.sliderlist').insertAdjacentHTML('beforeend',`
<div class="carousel bg-light border p-3 my-2 carousel-items">
<button class="closethis btn btn-dark btn-sm">Close</button>  
<h4>Carousel item</h4>
<input class="form-control mb-2 image-car" type="text"  name="carouselimage[]" placeholder="image">
<button class="takephoto btn-dark my-2 btn">Choose photo</button>
<textarea class="carousel-text" id="editor-${counters}" name="carouselcontent[]"></textarea>
</div>
    `);

    CKEDITOR.replace('editor-'+counters, {
height: 230,
toolbar: 'basic'
});

counters++;
 

document.querySelectorAll('.closethis').forEach((x,i)=>{

x.addEventListener('click',(c)=>{
 c.preventDefault();
x.parentElement.remove()
 
});


 })




 if(document.querySelector('.takephoto')){



document.querySelectorAll('.takephoto').forEach((c,i)=>{

  c.addEventListener('click',(e)=>{
  e.preventDefault();
const win = window.open('<?php echo HTML_PATH_PLUGINS.'carousel-creator/';?>'+'php/filebrowser.php', '_blank' ,"tolbar=no,scrollbars=no,menubar=no,height=600, width=600");


win.onload = () => {

win.document.querySelectorAll('.thisphoto').forEach(x=>{



  x.addEventListener('click',()=>{
 const photosatr = x.querySelector('img').getAttribute('data-img');
    document.querySelectorAll('.image-car')[i].setAttribute('value','<?php echo $this->domainPath().'img/';?>'+photosatr);
    win.close();
  })

});

};


})

})

}

  })



  if(document.querySelector('.closethis')){

    document.querySelectorAll('.closethis').forEach((x,i)=>{

   x.addEventListener('click',(c)=>{
    c.preventDefault();
   x.parentElement.remove()
    
  });


    })

  }
 

  document.querySelector('form').setAttribute('enctype','multipart/form-data');


  if(document.querySelector('.takephoto')){



  document.querySelectorAll('.takephoto').forEach((c,i)=>{

    c.addEventListener('click',(e)=>{
    e.preventDefault();
  const win = window.open('<?php echo HTML_PATH_PLUGINS.'carousel-creator/';?>'+'php/filebrowser.php', '_blank' ,"tolbar=no,scrollbars=no,menubar=no,height=600, width=600");


  win.onload = () => {

  win.document.querySelectorAll('.thisphoto').forEach(x=>{



    x.addEventListener('click',()=>{
   const photosatr = x.querySelector('img').getAttribute('data-img');
      document.querySelectorAll('.image-car')[i].setAttribute('value','<?php echo $this->domainPath().'img/';?>'+photosatr);
      win.close();
    })

  });

};




  })

  })

}
 
  </script>

 


