<?php 

class carouselCreator extends Plugin {


   
   
      public function adminView()
    {


     global $security;
        $tokenCSRF = $security->getTokenCSRF();

   

   if(isset($_GET['addnew'])){


      include($this->phpPath().'php/formCarousel.php');

   } elseif(isset($_GET['edit'])){

      include($this->phpPath().'php/formCarousel.php');

   }elseif(isset($_GET['uploader'])){

    include($this->phpPath().'php/uploader.php');

 }elseif(isset($_GET['filebrowser'])){

  include($this->phpPath().'php/imagebrowser.php');

}elseif(isset($_GET['editfile'])){

  include($this->phpPath().'php/filebrowser.php');

}elseif(isset($_GET['migrator'])){

  include($this->phpPath().'php/migrate.php');

}else{

include($this->phpPath().'php/list.php');

   }


echo '<div class="bg-light col-md-12 my-3 py-3 d-block text-center border">
      
<p class="lead">Buy me ☕ if you want to see new plugins :) </p>

<a href="https://www.paypal.com/donate/?hosted_button_id=TW6PXVCTM5A72">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif"  />
</a>

</div>
';
 

    }



   public function adminSidebar()
    {
        $pluginName = Text::lowercase(__CLASS__);
        $url = HTML_PATH_ADMIN_ROOT.'plugin/'.$pluginName;
        $urlUploader = HTML_PATH_ADMIN_ROOT.'plugin/'.$pluginName.'?uploader';
        $html = '<a id="current-version" class="nav-link" href="'.$url.'">🎠 Carousel Creator</a>';
        $html .= '<a id="current-version" class="nav-link" href="'.$urlUploader.'">🎠 Carousel Uploader</a>';
        return $html;
    }




    public function adminController()
    {






if(isset($_POST['changeURL'])){
    foreach(glob($this->phpPath().'/carouselList/*.json')as $file){

        $fileContent = file_get_contents($file);
    
     
        $oldurl = str_replace('/','\/',$_POST['oldurl']);
        $newurl = str_replace('/','\/',$_POST['newurl']);
    
 
        $newContent = str_replace([$oldurl, $oldurl.'/'],[$newurl, $newurl.'/'],$fileContent);
    
        file_put_contents($file,$newContent);
    
    }

    echo '<div class="alert alert-primary">done!</div>';
        
};





      $ds   = DIRECTORY_SEPARATOR;

$storeFolder = PATH_UPLOADS.'carouselCreator/';
        $chmod = 0755;


       if (!file_exists($storeFolder)){

                mkdir($storeFolder, $chmod, true);

      };



      if (!empty($_FILES)){


  
          $tempFile = $_FILES['file']['tmp_name'];
          $targetPath =    $storeFolder;

          $names = $_FILES['file']['name'];
          $noSpaceName = str_replace(' ','-',pathinfo($_FILES['file']['name'])['filename']);
      $newName = preg_replace('/[^0-9a-zA-Z-]+/', '', $noSpaceName); 

          $targetFile =  $targetPath .$newName.'.'.pathinfo($_FILES['file']['name'])['extension'];
          move_uploaded_file($tempFile, $targetFile);
      };
     
      
      if(isset($_GET['delete'])){

unlink($this->phpPath().'carouselList/'.$_GET['delete'].'.json');


      }


if(isset($_POST['submit'])){
     $carouselList = array();
     $carouselList['sliderItem'] = [];
     $carouselList['settings'] = [];
        $image = @$_POST['carouselimage'];
        $content = @$_POST['carouselcontent'];
        $carouseltitle = @$_POST['carouseltitle'];

     $autotimer = $_POST['autotimer'];
     $transition = $_POST['transition'];
     $fog= $_POST['fog'];
     $height = $_POST['height'];
     $width = $_POST['width'];
     $arrow = $_POST['arrow'];


      foreach ($content as $key => $value){
    array_push($carouselList['sliderItem'],array('image'=>$image[$key],'content'=>$content[$key],'carouseltitle'=>$carouseltitle[$key]));


    array_push($carouselList['settings'],array('autotimer'=>$autotimer,'transition'=>$transition,'fog'=>$fog,'height'=>$height,'width'=>$width,'arrow'=>$arrow));



    $jser = json_encode($carouselList,true);
    file_put_contents($this->phpPath().'carouselList/'.@$_POST['title'].'.json',$jser);
    };

 
 };
       
		


if(isset($_POST['delthisimage'])){

$imgs = $_POST['delphoto'];

foreach($imgs as $items){
unlink(PATH_UPLOADS. 'carouselCreator/'.$items);
};

};


    }


    public function siteHead(){
      echo '<link rel="stylesheet" href="'.$this->domainPath().'css/carousel.css">';

    }
 



       public function pageBegin(){
 


            global $page;
    
            $newcontent = preg_replace_callback(
     '/\\[% carousel=(.*) %\\]/i',
                'runCarouselShortcode',
                $page->content()
            );
    
    
            global $page;
            $page->setField('content', $newcontent);
        }

};

   
//carouselShortcode 

function runCarouselShortcode($matches){
 
 $name = $matches[1];
  $car = new carouselCreator();

  $filecontent = file_get_contents($car->phpPath().'carouselList/'.$name.'.json');
$resultMe = json_decode($filecontent);

$carousel = '';

  $carousel .= '<div class="slider-container" style="width:'.$resultMe->settings[0]->width.'">';
$carousel .=  '<div id="slider'.$name.'" class="swipe">';
$carousel .=  '<div class="swipe-wrap">';


if(isset($resultMe)){

foreach($resultMe->sliderItem as $res){

  $carousel .= '<div class="slider-item" style="background:url('.$res->image.');background-size:cover;background-position:center center;width:'.$resultMe->settings[0]->width.';
  height:'.$resultMe->settings[0]->height.';">';
  $carousel .= '<div class="slider-fog" style="background:rgba(0,0,0,'.$resultMe->settings[0]->fog.');">';
$carousel .= '<div class="slider-item-content">'.$res->content.'</div>';
 $carousel .= '</div>';
 $carousel .= '</div>';

};

};

if($resultMe->settings[0]->arrow!=='2'){

$carousel .=  '</div></div><button class="slider-prev" ><img src="'.$car->domainPath().'images/left'.
$resultMe->settings[0]->arrow.'.svg"></button>';
$carousel .=  '<button class="slider-next" >
<img src="'.$car->domainPath().'images/right'.$resultMe->settings[0]->arrow.'.svg"></button>
';

};


$carousel .= '</div>';




$carousel .= '
<script src="'.$car->domainPath().'js/swipe.min.js"></script>

<script>

var element = document.querySelector("#slider'.$name.'");
window.mySwipe = new Swipe(element, {
  startSlide: 0,
  auto: '.$resultMe->settings[0]->autotimer.',';

  if(isset($resultMe->settings[0]->transition)){

$carousel .= ' speed:'.$resultMe->settings[0]->transition.',';

  };
$carousel .='
  draggable: true,
  autoRestart: true,
  continuous: true,
  disableScroll: true,
  stopPropagation: true,
  callback: function(index, element) {},
  transitionEnd: function(index, element) {}
});
';

 if($resultMe->settings[0]->arrow!=='2'){


$carousel .="
prevBtn = document.querySelector('.slider-prev');
nextBtn = document.querySelector('.slider-next');
nextBtn.onclick = mySwipe.next;
prevBtn.onclick = mySwipe.prev;

";

 };





$carousel .='</script>';


return $carousel;

}

//carousel 

function runCarousel($name){
 
  $car = new carouselCreator();

  $filecontent = file_get_contents($car->phpPath().'carouselList/'.$name.'.json');
$resultMe = json_decode($filecontent);

$carousel = '';

  $carousel .= '<div class="slider-container" style="width:'.$resultMe->settings[0]->width.'">';
$carousel .=  '<div id="slider'.$name.'" class="swipe">';
$carousel .=  '<div class="swipe-wrap">';


if(isset($resultMe)){

foreach($resultMe->sliderItem as $res){

  $carousel .= '<div class="slider-item" style="background:url('.$res->image.');background-size:cover;background-position:center center;
  height:'.$resultMe->settings[0]->height.';">';


 $carousel .= '<div class="slider-fog" style="background:rgba(0,0,0,'.$resultMe->settings[0]->fog.');">';
$carousel .= '<div class="slider-item-content">'.$res->content.'</div>';
 $carousel .= '</div>';
 $carousel .= '</div>';

};

};

if($resultMe->settings[0]->arrow!=='2'){

$carousel .=  '</div></div><button class="slider-prev" ><img src="'.$car->domainPath().'images/left'.
$resultMe->settings[0]->arrow.'.svg"></button>';
$carousel .=  '<button class="slider-next" >
<img src="'.$car->domainPath().'images/right'.$resultMe->settings[0]->arrow.'.svg"></button>
';

};


$carousel .= '</div>';




$carousel .= '
<script src="'.$car->domainPath().'js/swipe.min.js"></script>

<script>


var element = document.querySelector("#slider'.$name.'");
window.mySwipe = new Swipe(element, {
  startSlide: 0,
  auto: '.$resultMe->settings[0]->autotimer.',
  draggable: true,
  autoRestart: true,
  continuous: true,
  disableScroll: true,
  stopPropagation: true,
  callback: function(index, element) {},
  transitionEnd: function(index, element) {}
});';



 if($resultMe->settings[0]->arrow!=='2'){


$carousel .="
prevBtn = document.querySelector('.slider-prev');
nextBtn = document.querySelector('.slider-next');
nextBtn.onclick = mySwipe.next;
prevBtn.onclick = mySwipe.prev;

";

 };






$carousel .='</script>';


echo $carousel;

}



;
