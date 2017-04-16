<ul class="list-group categories">
	<?php
	$cats = Category::getList();
	foreach ( $cats as $cat )
	{
		echo sprintf('<li class="list-group-item justify-content-between category" data-cat_id="%d" data-cat_name_transliterated="%s">
			<label class="custom-control custom-radio">
				<input name="radio-c%d" type="radio" class="custom-control-input">
				<span class="custom-control-indicator"></span>
				<span class="custom-control-description strong">%s</span>
			</label>
			<span class="pull-right"><i class="fa fa-chevron-left icon-rotate-90 toggle-category"></i></span>
		</li>',$cat->id,strtolower(r2t($cat->cat_name)),$cat->id,$cat->cat_name);
		$subcats = SubCategory::getList($cat->id);
		echo sprintf('<ul class="list-group subcategories" data-parent_cat_id="%d">',$cat->id);
		foreach ( $subcats as $subcat )
		{
			echo sprintf('<li class="list-group-item justify-content-between subcategory" data-parent_cat_id="%d" data-subcat_id="%d">
				<label class="custom-control custom-radio" style="margin-left: -20px;">
					<input name="radio-sc%d" type="radio" class="custom-control-input">
					<span class="custom-control-indicator"></span>
					<span class="custom-control-description">%s</span>
				</label>
			</li>',$subcat->parent_cat_id,$subcat->id,$subcat->id,$subcat->subcat_name);
		}
		echo '</ul>';
	}
	?>
</ul>