<h2>This is a page</h2>
<?php foreach($this->images as $image):?>
	<img src="<?=URL.$image['path'];?>" alt="<?=$image['name'];?>"/>
<?php endforeach;?>