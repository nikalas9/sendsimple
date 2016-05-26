<?php
include('icons.data.php');
foreach($icons as $key => $value){
	echo '<a title="fa fa-'.$key.'" href="#"><span class="fa fa-'.$key.'"></span><div>'.ucfirst($key).'</div></a>';
}