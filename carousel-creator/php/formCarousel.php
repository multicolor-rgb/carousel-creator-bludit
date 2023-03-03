<style>
    .carousel-text {
        height: 300px;
    }

    .carousel-items {
        position: relative;
        padding-top: 20px !important;

    }

    .carousel-items .closethis {

        position: absolute;
        top: 0;
        right: 0;
        padding: 10px;
        margin-bottom: 20px;

    }

    .carousel-items .drag {
        position: absolute;
        top: 0;
        right: 80px;
        padding: 6px;
        margin-bottom: 20px;
    }

    .thumbs {
        width: 90px;
        height: 90px;
        object-fit: cover;
        margin-bottom: 20px;
    }

    /*listfile */

    .listfile {
        width: 100%;
        height: 300px;
        overflow-y: scroll;
        background: #ddd;
        margin-top: 20px;
        color: #000;
        padding: 10px;
        display: grid;
        grid-template-columns: repeat(3,minmax(150px,1fr));
        gap: 10px;
        margin: 20px 0;

    }

    .thisphoto {
        text-align: center;
        cursor: pointer;
        width: 100%;
        display: block;
        word-break: break-all;
        color: #000 !important;
        text-decoration: none !important;
        font-weight: 300 !important;
        font-size: 12px !important;
    }

    .thisphoto:hover {
        background: rgba(0,0,0,0.1);
        font-weight: 300 !important;
        font-weight: normal !important;
        text-decoration: none !important;
    }



</style>





<div class="col-md-12 bg-light border p-3 options">

<button class="sliderbtn btn-primary btn mr-1">Slider Item Manager 📷 </button>
<button class="settings btn-success btn mr-1">Settings 🔨</button>
<button class="help btn-danger btn mr-1">How to use? 🤔</button>

</div>


<div class="border helpcontent my-2 mt-3 bg-light p-4">

    <p class="h4 mb-4">How to use it?</p>
    <ul class="p-0" style="list-style-type:square;margin-left:15px;">
        <li>
            <p>
                <b>1.</b>
                upload photos to carousel folder
            </p>
        </li>
        <li>
            <p>
                <b>2.</b>
                Add slider to your carousel on button "add slider"</p>
        </li>
        <li>
            <p>
                <b>3.</b>
                set photo and content to every slider</p>
        </li>
        <li>
            <p>
                <b>4.</b>
                Config settings on carousel
            </p>
        </li>
        <li>
            <p>
                <b>5.</b>
                put
                <code>
                    &#60;?php Theme::plugins('runCarousel');?&#62;</code>
                on your template or use "add carousel" button on edit page</p>
        </li>

        <li>
6. <b>New!</b> You can use shortcode - paste this code on TinyMCE <code>[% carousel %]</code> 
</li>
    </ul>

</div>

<div class="bg-primary text-light uploader border py-2 p-3 mt-3 col-md-12">
    <h4 class="mb-4">Upload photo to plugin folder (2mb max)</h4>
    <input type="file" name="image"><br>
    <hr style="border:solid 1px rgba(255,255,255,0.3); height:0;">
    <input type="submit" value="send photo 🗃️" class="btn btn-light">

</div>

 

<div class=" mt-4" id="sliderlist">
<h4 class="my-3">Slider Item Manager</h4>
    <div class="col-md-12 bg-light  border p-2" style="position:sticky;top:0;left:0;z-index:99;">
        <button class="btn-primary btn addslider">Add slider ➕</button>
        <input type="submit" class="btn btn-light" value="Save Settings 💾">
    </div>

    <div class="sliderlist" id="sliderlister">

    <?php


$filecontent = file_get_contents($this->phpPath().'sliders.json');
          
$resultMe = json_decode($filecontent);

foreach($resultMe as $res){


echo '<div class="carousel bg-light  shadow-sm border p-3 my-3 carousel-items"><button class="drag btn btn-primary btn-sm px-3" style="font-size:1.3rem;">↕</button> 
 <button class="closethis btn btn-danger btn-sm">Close ❌</button>    

 <div style="display:grid;grid-template-columns:100px 1fr;margin-bottom:20px;align-items:center;">

 <img class="thumbs m-0  img-thumbnail" src="'.$res->image.'">

<h4>'.( $res->carouseltitle !== "" ? $res->carouseltitle:"Slider item").'</h4>

 </div>
 ';
echo '<input class="form-control mb-2 title-car" type="text" value="'.@$res->carouseltitle.'" name="carouseltitle[]" placeholder="slider title">';
echo '<input class="form-control mb-2 image-car" type="text" value="'.$res->image.'" name="carouselimage[]" placeholder="image">';
echo '<button class="takephoto btn-primary btn my-2">Choose photo 📸</button>';
echo '<button class="editcontent ml-2 btn-success btn my-2">Edit content📝 </button>';

echo'<div class="listfile">';
 
$folder = PATH_UPLOADS."carouselCreator/";
$htmlfolder = HTML_PATH_UPLOADS."carouselCreator/";

foreach (glob($folder."*.{jpg,png,gif,bmp,jpeg,webp}",GLOB_BRACE) as $images) {
   
  $dater = $htmlfolder.basename($images);
  $newimagedir=str_replace( $htmlfolder, "" , $images);
  
  $img = '
       <a href="'.DOMAIN.$dater.'" class="thisphoto">
       <img src="'. $dater.'" style="width:100%;height:150px;object-fit:cover">
       <br>
       <p>'.basename($images).'</p>
       </a>';
          echo $img;
  };
 
echo '</div>';
echo '<div class="editcontentshow">';
echo '<textarea class="carousel-text" id="editor1" name="carouselcontent[]">'.$res->content.'</textarea>

</div>
</div>


';



};

;?>

 

</div>
</div>



    
<div class="bg-primary text-light col-md-12 my-3 py-3 my-3 border config">
<h4>Config</h4>

<p>Time between next slider, if 0 -autoplay disable (milliseconds)</p>
<input name="autotimer"  type="text" class="form-control autotimer"  value="<?php echo $this->getValue('autotimer');?>" >
<br>
<p>Darkens the image below the text ( 0 - 1 example: 0.2)</p>
<input name="fog" type="text"   value="<?php echo $this->getValue('fog');?>" >
<br>
<p>Slider height in px or vh (example 450px)</p>
<input name="height"  type="text"  value="<?php echo $this->getValue('height');?>" >

<p>Arrow style</p>
<select name="arrow">
<option value="0" <?php echo ($this->getValue('arrow')==="0"?"selected":"");?>>style 1</option>
<option value="1" <?php echo ($this->getValue('arrow')==="1"?"selected":"");?>>style 2</option>
<option value="2" <?php echo ($this->getValue('arrow')==="2"?"selected":"");?>>without arrow</option>
</select>
<br>
<input type="submit" class="btn btn-light" value="Save Settings 💾">
</div>

 



 



<script src="https://cdn.ckeditor.com/4.19.0/full/ckeditor.js"></script>

<script>

    if (document.querySelector('textarea')) {

        document
            .querySelectorAll('textarea')
            .forEach(c => {

                CKEDITOR.replace(c, {
                    height: 230,
                    toolbar: 'basic'

                });

            });

    };

    let counters = 1;

 

    if (document.querySelector('.closethis')) {

        document
            .querySelectorAll('.closethis')
            .forEach((x, i) => {

                x.addEventListener('click', (c) => {
                    c.preventDefault();
                    x
                        .parentElement
                        .remove()

                });

            })

    }
</script>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

 

<script>
    var el = document.getElementById('sliderlister');
var sortable = Sortable.create(el, {
    animation: 200,
    group: 'slidelist',
    handle: '.drag'
});

//listfile

document
    .querySelectorAll('.listfile')
    .forEach(x => {
        x.style.display = "none";
    })

//drag

document
    .querySelectorAll('.drag')
    .forEach(x => {
        x.addEventListener('click', e => {
            e.preventDefault();
        })
    })

//editcontentshow hidden
document
    .querySelectorAll('.editcontentshow')
    .forEach(x => {
        x.style.display = "none";
    })

document
    .querySelectorAll('.carousel-items')
    .forEach((c, i) => {

        c
            .querySelector('.editcontent')
            .addEventListener('click', e => {
                e.preventDefault();

                if (c.querySelector('.editcontentshow').style.display == "none") {
                    c
                        .querySelector('.editcontentshow')
                        .style
                        .display = "block";
                } else {
                    c
                        .querySelector('.editcontentshow')
                        .style
                        .display = "none";
                }

            });

        c
            .querySelector('.takephoto')
            .addEventListener('click', x => {

                x.preventDefault();

                if (c.querySelector('.listfile').style.display === "none") {
                    c
                        .querySelector('.listfile')
                        .style
                        .display = "grid"
                } else if (c.querySelector('.listfile').style.display === "grid") {
                    c
                        .querySelector('.listfile')
                        .style
                        .display = "none";
                }

            })

        c
            .querySelectorAll('.thisphoto')
            .forEach(x => {

                x.addEventListener('click', b => {

                    b.preventDefault();

                    const link = x.getAttribute('href');

                    c
                        .querySelector('.image-car')
                        .value = link;

                    c
                        .querySelector('.listfile')
                        .style
                        .display = "none";

                })

            })

    })




    document.querySelector('.helpcontent').style.display="none";
    document.querySelector('.config').style.display="none";
   


    const options = document.querySelector('.options');

    options.querySelector('.help').addEventListener('click',(z)=>{

        z.preventDefault();

        document.querySelector('.config').style.display="none";
        document.querySelector('.uploader').style.display="none";

        document.querySelector('.helpcontent').style.display="block";
        document.querySelector('#sliderlist').style.display="none";

      });


      options.querySelector('.settings').addEventListener('click',(z)=>{

z.preventDefault();

document.querySelector('.config').style.display="block";
document.querySelector('.uploader').style.display="none";

document.querySelector('.helpcontent').style.display="none";
document.querySelector('#sliderlist').style.display="none";

});


options.querySelector('.sliderbtn').addEventListener('click',(z)=>{

z.preventDefault();

document.querySelector('.config').style.display="none";
document.querySelector('.uploader').style.display="block";

document.querySelector('.helpcontent').style.display="none";
document.querySelector('#sliderlist').style.display="block";

});


document.querySelector('form').setAttribute('enctype','multipart/form-data');











 

document
        .querySelector('.addslider')
        .addEventListener('click', (e) => {
            e.preventDefault();

            document
                .querySelector('.sliderlist')
                .insertAdjacentHTML(
                    'beforeend',
                    `
<div class="carousel bg-light border p-3 my-2 carousel-items carousel-items-${counters}">
<button class="drag btn btn-primary btn-sm px-3" style="font-size:1.3rem;">↕</button> 
 <button class="closethis btn btn-danger btn-sm">Close ❌</button>   
<h4>Carousel item</h4>
<input class="form-control mb-2 title-car" type="text"  name="carouseltitle[]" placeholder="title slide">
<input class="form-control mb-2 image-car" type="text"  name="carouselimage[]" placeholder="image url">
<button class="takephoto take-${counters} btn-primary my-2 btn">Choose photo 📸</button>
<button class="editcontent editcon-${counters} btn-success my-2 btn">Edit content📝 </button>

<div class="listfile list-${counters}">
  
<?php

$folder = PATH_UPLOADS."carouselCreator/";
$htmlfolder = HTML_PATH_UPLOADS."carouselCreator/";

foreach (glob($folder."*.{jpg,png,gif,bmp,jpeg,webp}",GLOB_BRACE) as $images) {
   
  $dater = $htmlfolder.basename($images);
  $newimagedir=str_replace( $htmlfolder, "" , $images);
  
  $img = '
       <a href="'.$dater.'" class="thisphoto">
       <img src="'. $dater.'" style="width:100%;height:150px;object-fit:cover">
       <br>
       <p>'.basename($images).'</p>
       </a>';
          echo $img;
  };
  ;?>

</div>
<div class="editcontentshow edit-${counters}">
<textarea class="carousel-text" id="editor-${counters}" name="carouselcontent[]"></textarea>
</div>
</div>
    `
                );

            CKEDITOR.replace('editor-' + counters, {
                height: 230,
                toolbar: 'basic'
            });

            let eds = document.querySelector('editor-'+counters);

            document.querySelectorAll('.closethis')
                .forEach((x, i) => {

                    x.addEventListener('click', (c) => {
                        c.preventDefault();
                        x.parentElement
                            .remove()
                    });

                });



                document.querySelector(`.carousel-items-${counters} .list-${counters}`).style.display="none";
                document.querySelector(`.carousel-items-${counters} .edit-${counters}`).style.display="none";


                document
        .querySelectorAll(`.carousel-items-${counters}`)
        .forEach((c, i) => {

            c
                .querySelector('.editcontent')
                .addEventListener('click', e => {
                    e.preventDefault();

                    if (c.querySelector('.editcontentshow').style.display == "none") {
                        c
                            .querySelector('.editcontentshow')
                            .style
                            .display = "block";
                    } else {
                        c
                            .querySelector('.editcontentshow')
                            .style
                            .display = "none";
                    }

                });

            c
                .querySelector('.takephoto')
                .addEventListener('click', x => {

                    x.preventDefault();

                    if (c.querySelector('.listfile').style.display === "none") {
                        c
                            .querySelector('.listfile')
                            .style
                            .display = "grid"
                    } else if (c.querySelector('.listfile').style.display === "grid") {
                        c
                            .querySelector('.listfile')
                            .style
                            .display = "none";
                    }

                })

            c
                .querySelectorAll('.thisphoto')
                .forEach(x => {

                    x.addEventListener('click', b => {

                        b.preventDefault();

                        const link = x.getAttribute('href');

                        c
                            .querySelector('.image-car')
                            .value = link;

                        c
                            .querySelector('.listfile')
                            .style
                            .display = "none";

                    })

                })

        })


 
 
 
                counters++;
          

        })




</script>