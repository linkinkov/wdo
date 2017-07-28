<div class="row">
	<div class="col">
		<h44 class="text-yellow text-roboto-cond-bold">ФИЛЬТР СПЕЦИАЛИЗАЦИЙ</h44>
		<ul class="list-group categories">
			<?php
			$cats = Category::get_list(false,array("col"=>"sort","dir"=>"ASC"));
			foreach ( $cats as $cat )
			{
				echo sprintf('<li class="list-group-item justify-content-between category" data-cat_id="%d">
					<label class="custom-control custom-radio custom-radio-cat">
						<input name="radio-c%d" type="radio" class="custom-control-input">
						<span class="custom-control-indicator"></span>
						<span class="custom-control-description custom-control-description-cat strong">%s</span>
					</label>
					<span class="pull-right"><i class="fa fa-chevron-left icon-rotate-90 toggle-category"></i></span>
				</li>',$cat->id,$cat->id,$cat->cat_name);
				$subcats = SubCategory::get_list($cat->id,false,array("col"=>"sort","dir"=>"ASC"));
				echo sprintf('<ul class="list-group subcategories" data-parent_cat_id="%d">',$cat->id);
				foreach ( $subcats as $subcat )
				{
					echo sprintf('<li class="list-group-item justify-content-between subcategory" data-parent_cat_id="%d" data-subcat_id="%d">
						<label class="custom-control custom-radio custom-radio-cat" style="margin-left: -20px;">
							<input name="radio-sc%d" type="radio" class="custom-control-input">
							<span class="custom-control-indicator"></span>
							<span class="custom-control-description custom-control-description-cat">%s</span>
						</label>
					</li>',$subcat->parent_cat_id,$subcat->id,$subcat->id,$subcat->subcat_name);
				}
				echo '</ul>';
			}
			?>
		</ul>
	</div>
</div>

