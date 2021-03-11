<select class="js-example-data-ajax form-control select_filters " name="restaurant_id" id="restaurant_id" required="true">
								<option value="all" selected>All Merchants</option>
								<?php if(count($merchants)>0){
									foreach($merchants as $val){?>
								      <option value="<?php echo $val['dryvarfoods_id'];?>"><?php echo $val['company'];?></option>
								<?php } } ?>
								</select>