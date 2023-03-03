<?php 

class carouselCreator extends Plugin {

   
   public function init()
   {
    
 
       $this->dbFields = array(
         'height' => '450px',
         'fog' => '0.2',
         'autotimer' => '3000',
         'arrow' =>'0',
       );

     $this->customHooks = array(
      'runCarousel',
     );

   }

   
   
    public function form(){

      include($this->phpPath().'php/formCarousel.php');
 
    $html = '




 
<div class="bg-light col-md-12 my-3 py-3 d-block text-center border">
      
<p class="lead">buy me ☕ if you want saw new plugins:)  </p>

<a href="https://www.paypal.com/donate/?hosted_button_id=TW6PXVCTM5A72">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif"  />
</a>

</div> ';




    return $html;



    }


    public function post(){

     
      
        $carouselList = array();
        $image = $_POST['carouselimage'];
        $content = $_POST['carouselcontent'];
        $carouseltitle = $_POST['carouseltitle'];

   

      foreach ($content as $key => $value){
    array_push($carouselList,array('image'=>$image[$key],'content'=>$content[$key],'carouseltitle'=>$carouseltitle[$key]));
    $jser = json_encode($carouselList,true);
    file_put_contents($this->phpPath().'sliders.json',$jser);
    };


    if(isset($_FILES['image'])){
        $errors= array();
        $file_name = $_FILES['image']['name'];
        $file_size =$_FILES['image']['size'];
        $file_tmp =$_FILES['image']['tmp_name'];
        $file_type=$_FILES['image']['type'];
        $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
        
        $extensions= array("jpeg","jpg","png","webp");
        
        if(in_array($file_ext,$extensions)=== false){
           $errors[]="extension not allowed, please choose a JPEG or PNG file.";
        }
        
        if($file_size > 2097152){
           $errors[]='File size must be excately 2 MB';
        }
        
        if(empty($errors)==true){


          $folderimg = PATH_UPLOADS."carouselCreator/";
          $chmod_mode    = 0755;
          $folder_exists = file_exists($folderimg) || mkdir($folderimg, $chmod_mode);
 
          if($folder_exists){
            move_uploaded_file($file_tmp,$folderimg.$file_name);
          }
        
        }else{
           print_r($errors);
        }
     };

     parent::post();
		
    }


    public function siteHead(){
      echo '<link rel="stylesheet" href="'.$this->domainPath().'css/carousel.css">';

    }
 
    public function siteBodyEnd(){
 
      include($this->phpPath().'php/tinyScript.php');
      echo '<script src="'.$this->domainPath().'js/swipe.min.js"></script>';
      include($this->phpPath().'php/carouselSettings.php');
    
 

   }





   public function runCarousel(){
 
      $carousel = '<style>.slider-item{ height:'.$this->getValue('height').';} .slider-fog{background:rgba(0,0,0,'.$this->getValue('fog').');}</style>';

$filecontent = file_get_contents($this->phpPath().'sliders.json');
$resultMe = json_decode($filecontent);
 
 
      $carousel .= '<div class="slider-container">';
    $carousel .=  '<div id="slider" class="swipe">';
    $carousel .=  '<div class="swipe-wrap">';


    if(isset($resultMe)){

    foreach($resultMe as $res){

      $carousel .= '<div class="slider-item" style="background:url('.$res->image.');background-size:cover;background-position:center center;">';
      $carousel .= '<div class="slider-fog">';
$carousel .= '<div class="slider-item-content">'.$res->content.'</div>';
     $carousel .= '</div>';
     $carousel .= '</div>';


    };

  };

    if($this->getValue('arrow')!=='2'){

$carousel .=  '</div></div><button class="slider-prev" ><img src="'.$this->domainPath().'images/left'.
$this->getValue('arrow').'.svg"></button>';
    $carousel .=  '<button class="slider-next" >
    <img src="'.$this->domainPath().'images/right'.$this->getValue('arrow').'.svg"></button>
    ';

    };


$carousel .= '</div>';


return $carousel;
 
   }




   public function adminBodyEnd(){

    $html = "
    
    <script>

window.addEventListener('load',()=>{

  if(document.querySelector('#jsbuttonPreview')!==null){
document.querySelector('#jsbuttonPreview').insertAdjacentHTML('afterEnd',`<button class='btn btn-sm btn-danger ml-2 add-carousel'>add carousel</button>`);


document.querySelector('.add-carousel').addEventListener('click',(e)=>{
e.preventDefault();
 let value =`
 <div class='carousel-replace'><div style='width:100%;height:300px;background:#fafafa;border:solid 1px #ddd;display:flex;align-items:center;justify-content:center;'>
 Carousel
 </div></div>
 <br>
 `;

  tinymce.activeEditor.execCommand('mceInsertContent', false, value);


})


  }

  })
</script>
   ";

    return $html;

   }







       public function pageBegin(){
 


            global $page;
    
            $newcontent = preg_replace_callback(
                '/\\[% carousel %\\]/i',
                'carouselShortcode',
                $page->content()
            );
    
    
            global $page;
            $page->setField('content', $newcontent);
        }

};

   
//carouselShortcode 

function carouselShortcode(){
 
  $car = new carouselCreator();


  $carousel = '<style>.slider-item{ height:'.$car->getValue('height').';} .slider-fog{background:rgba(0,0,0,'.$car->getValue('fog').');}</style>';

$filecontent = file_get_contents($car->phpPath().'sliders.json');
$resultMe = json_decode($filecontent);


  $carousel .= '<div class="slider-container">';
$carousel .=  '<div id="slider" class="swipe">';
$carousel .=  '<div class="swipe-wrap">';


if(isset($resultMe)){

foreach($resultMe as $res){

  $carousel .= '<div class="slider-item" style="background:url('.$res->image.');background-size:cover;background-position:center center;">';
  $carousel .= '<div class="slider-fog">';
$carousel .= '<div class="slider-item-content">'.$res->content.'</div>';
 $carousel .= '</div>';
 $carousel .= '</div>';


};

};

if($car->getValue('arrow')!=='2'){

$carousel .=  '</div></div><button class="slider-prev" ><img src="'.$car->domainPath().'images/left'.
$car->getValue('arrow').'.svg"></button>';
$carousel .=  '<button class="slider-next" >
<img src="'.$car->domainPath().'images/right'.$car->getValue('arrow').'.svg"></button>
';

};


$carousel .= '</div>';


return $carousel;

}
;?>