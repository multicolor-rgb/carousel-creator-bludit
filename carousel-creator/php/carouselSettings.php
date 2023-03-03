<script>
   
   if(document.getElementById("slider")){
    var mySwipeElement = document.getElementById("slider");
    window.mySwipe = new Swipe(mySwipeElement, {
      startSlide: 0,
  auto: <?php echo $this->getValue('autotimer');?>,
  draggable: true,
  autoRestart: true,
  continuous: true,
  disableScroll:  false,
  stopPropagation: true,
  callback: function(index, element) {},
  transitionEnd: function(index, element) {}
    });

<?php if($this->getValue('arrow')!=='2') :?>



          prevBtn = document.querySelector('.slider-prev');
          nextBtn = document.querySelector('.slider-next');
      nextBtn.onclick = mySwipe.next;
     prevBtn.onclick = mySwipe.prev;

<?php endif;?>


   }

 
    </script>