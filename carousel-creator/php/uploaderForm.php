<form method="POST">

 <input type="hidden" id="jstokenCSRF" name="tokenCSRF" value="<?php echo $tokenCSRF;?>">


<div class="bg-primary text-light uploader border py-2 p-3 mt-3 col-md-12">
    <h4 class="mb-4">Upload photo to plugin folder (2mb max)</h4>
    <input type="file" name="image"><br>
    <hr style="border:solid 1px rgba(255,255,255,0.3); height:0;">
    <input type="submit" name="uploadPhoto" value="Upload photo 🗃️" class="btn btn-light">

</div>

</form>