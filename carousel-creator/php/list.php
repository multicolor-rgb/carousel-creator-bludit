


<h3>Carousel Creator List item</h3>


<style>

.carList{
	margin: 0;
	padding: 0;
	list-style-type: none;
	text-align: center;
}

</style>


<div class="col-md-12 py-2 px-0 mb-2">
<a href="<?php echo DOMAIN_ADMIN.'plugin/carouselcreator?addnew';?>" class="btn btn-primary">Add new</a>
</div>


<ul class="col-md-12 carList">

<li class="col-md-12 border p-2 font-weight-bold">
	
	<div class="row">
<div class="col-md-3">
	Name
</div>
<div class="col-md-7">
	Shortcode
</div>
<div class="col-md-2">
	Edit

</div>

	</div>


</li>


	
	<?php


foreach(glob($this->phpPath().'carouselList/*.json') as $item){

$name = pathinfo($item)['filename'];

echo '<li class="col-md-12 border p-2">
<div class="row align-items-center">
<div class="col-md-3">
<b>'.$name.'</b>
</div>

<div class="col-md-7">

<code> [% carousel='.$name.' %]
</code>
</div>

<div class="col-md-2">
<a href="'.DOMAIN_ADMIN.'plugin/carouselcreator?edit='.$name.'" class="btn btn-warning btn-sm">Edit</a>
<a href="'.DOMAIN_ADMIN.'plugin/carouselcreator?delete='.$name.'" onclick="return confirm(`Are you sure you want to delete this item?`);"  class="btn btn-danger btn-sm">Delete</a>
</div>
</li>';


}


	;?>


</ul>