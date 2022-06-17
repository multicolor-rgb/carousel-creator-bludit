<?php 

class carouselCreator extends Plugin {

   
   public function init()
   {
    
 
       $this->dbFields = array(
         'height' => '450px',
         'fog' => '0.2',
         'autotimer' => '3000',
        
       );

     $this->customHooks = array(
      'runCarousel',
     );

   }

   
   
    public function form(){

      include($this->phpPath().'php/formCarousel.php');
 
    $html = '

    <div class="bg-dark text-light col-md-12 my-3 py-3 my-3 d-block border">
    <h4>Config</h4>

    <p>Time between next slider, if 0 -autoplay disable (milliseconds)</p>
    <input name="autotimer"  type="text" class="form-control autotimer"  value="'.$this->getValue('autotimer').'" >
    <br>
    <p>Darkens the image below the text ( 0 - 1 example: 0.2)</p>
    <input name="fog" type="text"   value="'.$this->getValue('fog').'" >
    <br>
    <p>Slider height in px or vh (example 450px)</p>
    <input name="height"  type="text"  value="'.$this->getValue('height').'" >
    


    <br>
    </div>
    
    
    


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

   

      foreach ($content as $key => $value){
    array_push($carouselList,array('image'=>$image[$key],'content'=>$content[$key]));
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
           move_uploaded_file($file_tmp,$this->phpPath()."img/".$file_name);
           echo "Success";
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
 
      echo '<script src="'.$this->domainPath().'js/swipe.min.js"></script>';
      include($this->phpPath().'php/carouselSettings.php');

 

   }






   public function runCarousel(){
 
      echo '<style>.slider-item{ height:'.$this->getValue('height').';} .slider-fog{background:rgba(0,0,0,'.$this->getValue('fog').');}</style>';

$filecontent = file_get_contents($this->domainPath().'sliders.json');
$resultMe = json_decode($filecontent);
 
 
    echo '<div class="slider-container">';
    echo '<div id="slider" class="swipe">';
    echo '<div class="swipe-wrap">';


    if(isset($resultMe)){

    foreach($resultMe as $res){

      echo'<div class="slider-item" style="background:url('.$res->image.');background-size:cover;background-position:center center;">';
      echo'<div class="slider-fog">';
echo'<div class="slider-item-content">'.$res->content.'</div>';
     echo'</div>';
     echo'</div>';


    };

  };

    echo '</div></div><button class="slider-prev" ><img src="'.$this->domainPath().'images/left.svg"></button>';
    echo '<button class="slider-next" ><img src="'.$this->domainPath().'images/right.svg"></button></div>';
 
   }
 



}

;?>