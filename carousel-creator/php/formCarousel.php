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
<button class="settings btn-warning btn mr-1">Settings 🔨</button>
<button class="help btn-info btn mr-1">How to use? 🤔</button>

</div>


<div class="border helpcontent my-2 mt-3 bg-light p-4">

    <p class="h4 mb-4">How to use it?</p>
    <ul class="p-0" style="list-style-type:square;margin-left:15px;">
        <li>
            <p>
                <b>1.</b>
                Upload photos to carousel folder
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
                Set photo and content to every slider</p>
        </li>
        <li>
            <p>
                <b>4.</b>
                Configure settings on carousel
            </p>
        </li>
        <li>
            <p>
                <b>5.</b>
                Add
                <code>&#60;?php runCarousel('name');?&#62;</code>
                to your template</p>
        </li>

        <li>
			<p>
			<b>6. New!</b> You can use shortcode - paste this code on TinyMCE <code>[% carousel=name %]</code> <p>
		</li>
    </ul>

</div>

<form method="POST" action="<?php echo DOMAIN_ADMIN.'plugin/carouselcreator';?>">


<h4 class=" d-block mt-3"">Edit Carousel</h4>
<input type="text" pattern="[A-Za-z0-9]+" required class="form-control placeholder="title carousel without spacebar and special characters" name="title" 

<?php 

if(isset($_GET['edit'])){

echo 'value="'.$_GET['edit'].'"';


}

;?>

>


<input type="hidden" id="jstokenCSRF" name="tokenCSRF" value="'<?php echo $tokenCSRF;?>'">


 

 

 <input type="hidden" id="jstokenCSRF" name="tokenCSRF" value="<?php echo $tokenCSRF;?>">

 

<div class=" mt-4" id="sliderlist">
<h4 class="my-3">Slider Item Manager</h4>
    <div class="col-md-12 bg-light  border p-2" style="position:sticky;top:0;left:0;z-index:99;">
        <button class="btn-primary btn addslider">Add slider ➕</button>
        <input type="submit" name="submit" class="btn btn-success" value="Save Settings 💾">
    </div>

    <div class="sliderlist" id="sliderlister">

    <?php


if(isset($_GET['edit'])){

$filecontent = file_get_contents($this->phpPath().'carouselList/'.$_GET['edit'].'.json');


$resultMe = json_decode($filecontent);

foreach($resultMe->sliderItem as $res){


echo '<div class="carousel bg-light  shadow-sm border p-3 my-3 carousel-items"><button class="drag btn btn-warning btn-sm px-3" style="font-size:1.3rem;">↕</button> 
 <button class="closethis btn btn-danger btn-sm">Delete ❌</button>    

 <div style="display:grid;grid-template-columns:100px 1fr;margin-bottom:20px;align-items:center;">

 <img class="thumbs m-0  img-thumbnail" src="'.$res->image.'">

<h4>'.( $res->carouseltitle !== "" ? $res->carouseltitle:"Slider item").'</h4>

 </div>
 ';
echo '<input class="form-control mb-2 title-car" type="text" value="'.@$res->carouseltitle.'" name="carouseltitle[]" placeholder="slider title">';
echo '<input class="form-control mb-2 image-car" type="text" value="'.$res->image.'" name="carouselimage[]" placeholder="image">';
echo '<button class="takephoto btn-secondary btn my-2">Choose photo 📸</button>';
echo '<button class="editcontent ml-2 btn-dark btn my-2">Edit content📝 </button>';
 
echo '<div class="editcontentshow">';
echo '<textarea class="carousel-text" id="editor1" name="carouselcontent[]">'.$res->content.'</textarea>

</div>
</div>


';


};

};

;?>

 

</div>
</div>



<?php if(isset($_GET['edit'])){
$settingsFile = file_get_contents($this->phpPath().'carouselList/'.$_GET['edit'].'.json');
$jsonSettings = json_decode($filecontent);
};?>

    
<div class="bg-primary text-light col-md-12 my-3 py-3 my-3 border config">
<h4>Settings</h4>

<p>Time between next slider, if 0 -autoplay disable (milliseconds)</p>
<input name="autotimer"   class="form-control" type="text" class="form-control autotimer" 
 value="<?php echo @$jsonSettings->settings[0]->autotimer ?? '3000';?>" >
<br>


<p>Transition speed (milliseconds)</p>
<input name="transition"   class="form-control" type="text" class="form-control transition" 
 value="<?php echo @$jsonSettings->settings[0]->transition ?? '500';?>" >
<br>

<p>Darkens the image below the text ( 0 - 1 example: 0.2)</p>
<input name="fog" type="text"    class="form-control" value="<?php echo @$jsonSettings->settings[0]->fog ?? '0.2';?>" >
<br>

<p>Slider width(example 450px ord 20% or 20vw)</p>

<input name="width"  class="form-control" type="text"  value="<?php echo @$jsonSettings->settings[0]->width ?? '100%';?>" >
<br>
<p>Slider height  (example 450px or 20% or 20vh)</p>
<input name="height"  class="form-control" type="text"  value="<?php echo @$jsonSettings->settings[0]->height ?? '450px';?>" >
<br>
<p>Arrow style</p>
<select name="arrow" class="form-control">
<option value="0" <?php echo (@$jsonSettings->settings[0]->arrow==="0"?"selected":"");?>>style 1</option>
<option value="1" <?php echo (@$jsonSettings->settings[0]->arrow==="1"?"selected":"");?>>style 2</option>
<option value="2" <?php echo (@$jsonSettings->settings[0]->arrow==="2"?"selected":"");?>>without arrow</option>
</select>
<br>
<input type="submit" name="submit" class="btn btn-success" value="Save Settings 💾">
</div>

 



</form>




 



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

 
document.querySelectorAll('.takephoto').forEach((item,index)=>{

    item.addEventListener('click',(e)=>{
        e.preventDefault();
e.preventDefault();
window.open('<?php echo DOMAIN.HTML_PATH_ADMIN_ROOT;?>plugin/carouselcreator?&filebrowser&class=takephoto&index='+index,"", "width=1200,height=400");
 
    })

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



    })





 

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
 <button class="closethis btn btn-danger btn-sm">Delete ❌</button>   
<h4>Carousel item</h4>
<input class="form-control mb-2 title-car" type="text"  name="carouseltitle[]" placeholder="title slide">
<input class="form-control mb-2 image-car newimagecar" type="text"  name="carouselimage[]" placeholder="image url">
<button class="takephotos take-${counters} btn-primary my-2 btn">Choose photo 📸</button>
<button class="editcontent editcon-${counters} btn-success my-2 btn">Edit content📝 </button>


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

        

        })


 
 
 
                counters++;
          

                document.querySelectorAll('.takephotos').forEach((item,index)=>{

item.addEventListener('click',(e)=>{
    e.preventDefault();
e.preventDefault();
window.open('<?php echo DOMAIN.HTML_PATH_ADMIN_ROOT;?>plugin/carouselcreator?&filebrowser&class=takephotos&index='+index,"", "width=1200,height=400");

})

})
        })





document.querySelector('.sliderlist').style.display="block";
document.querySelector('.helpcontent').style.display="none";
document.querySelector('.config').style.display="none";


document.querySelector('button.settings').addEventListener('click',(e)=>{

e.preventDefault();
document.querySelector('.config').style.display="block";
document.querySelector('.sliderlist').style.display="none";
document.querySelector('.helpcontent').style.display="none";

})


document.querySelector('button.help').addEventListener('click',(e)=>{

e.preventDefault();
document.querySelector('.config').style.display="none";
document.querySelector('.sliderlist').style.display="none";
document.querySelector('.helpcontent').style.display="block";

})


document.querySelector('button.sliderbtn').addEventListener('click',(e)=>{

e.preventDefault();
document.querySelector('.config').style.display="none";
document.querySelector('.sliderlist').style.display="block";
document.querySelector('.helpcontent').style.display="none";

})

</script>

