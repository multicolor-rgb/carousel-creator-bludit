 

 
<?php 

global $security;
$tokenCSRF = $security->getTokenCSRF();

;?>
<h3>Migrate Carousel Creator</h3>

 <form action="#" method="post" class="migrateMe text-dark bg-light border p-3">
 <input type="hidden" id="jstokenCSRF" name="tokenCSRF" value="<?php echo $tokenCSRF;?>">

<label for="">Old Url</label>
 <input type="text" name="oldurl"  class="form-control" placeholder="https://youroldadress.com/">
 <label for="">New Url</label>
 <input type="text" name="newurl" class="form-control"  placeholder="https://yournewadress.com/">
 <input type="submit" name="changeURL" class="btn btn-dark mt-2" value="Change carousel url">
 </form>



 