<div class="col-md-12">
<div class="panel_s">
  <div class="panel-body">
    
      <div class="row col-md-12">

        <h4 class="h4-color"><?php echo _l('general_infor'); ?></h4>
        <hr class="hr-color">

        <div class="col-md-5">
          <div class="gallery">
            <div class="wrapper-masonry">
              <div id="masonry" class="masonry-layout columns-2">
            <?php if(isset($item_file) && count($item_file) > 0){ ?>
              <?php foreach ($item_file as $key => $value) { ?>
                  <?php if(file_exists(PURCHASE_MODULE_ITEM_UPLOAD_FOLDER .$value["rel_id"].'/'.$value["file_name"])){ ?>
                        <a  class="images_w_table" href="<?php echo site_url('modules/purchase/uploads/item_img/'.$value["rel_id"].'/'.$value["file_name"]); ?>"><img class="images_w_table" src="<?php echo site_url('modules/purchase/uploads/item_img/'.$value["rel_id"].'/'.$value["file_name"]); ?>" alt="<?php echo html_entity_decode($value['file_name']) ?>"/></a>
                    <?php }else{ ?>
                       <a  class="images_w_table" href="<?php echo site_url('modules/warehouse/uploads/item_img/'.$value["rel_id"].'/'.$value["file_name"]); ?>"><img class="images_w_table" src="<?php echo site_url('modules/warehouse/uploads/item_img/'.$value["rel_id"].'/'.$value["file_name"]); ?>" alt="<?php echo html_entity_decode($value['file_name']) ?>"/></a>
                    <?php } ?>
            <?php } ?>
          <?php }else{ ?>

                <a href="<?php echo site_url('modules/purchase/uploads/nul_image.jpg'); ?>"><img class="images_w_table" src="<?php echo site_url('modules/purchase/uploads/nul_image.jpg'); ?>" alt="nul_image.jpg"/></a>

          <?php } ?>
            <div class="clear"></div>
          </div>
        </div>
        </div>
        </div>
        
        <div class="col-md-7 panel-padding">
          <table class="table border table-striped no-margin">
              <tbody>
                  <tr class="project-overview">
                    <td class="bold" width="30%"><?php echo _l('commodity_code'); ?></td>
                    <td><?php echo html_entity_decode($item->commodity_code) ; ?></td>
                 </tr>
                 <tr class="project-overview">
                    <td class="bold"><?php echo _l('commodity_name'); ?></td>
                    <td><?php echo html_entity_decode($item->description) ; ?></td>
                 </tr>
                 <tr class="project-overview">
                    <td class="bold"><?php echo _l('commodity_barcode'); ?></td>
                    <td><?php echo html_entity_decode($item->commodity_barcode) ; ?></td>
                 </tr>
                 <tr class="project-overview">
                    <td class="bold"><?php echo _l('sku_code'); ?></td>
                    <td><?php echo html_entity_decode($item->sku_code) ; ?></td>
                 </tr>
                 <tr class="project-overview">
                    <td class="bold"><?php echo _l('sku_name'); ?></td>
                    <td><?php echo html_entity_decode($item->sku_name) ; ?></td>
                 </tr>
                 <tr class="project-overview">
                    <td class="bold"><?php echo _l('item_group'); ?></td>
                    <td><?php echo get_group_name_item(html_entity_decode($item->group_id)) != null ? get_group_name_item(html_entity_decode($item->group_id))->name : '' ; ?></td>
                 </tr>
                 
                 <tr class="project-overview">
                    <td class="bold"><?php echo _l('rate'); ?></td>
                    <td><?php echo app_format_money((float)$item->rate,'') ; ?></td>
                 </tr>
                 <tr class="project-overview">
                    <td class="bold"><?php echo _l('purchase_price'); ?></td>
                    <td><?php echo app_format_money((float)$item->purchase_price,'') ; ?></td>
                 </tr>
                 
                 <tr class="project-overview">
                    <td class="bold"><?php echo _l('unit_id'); ?></td>
                    <td><?php echo html_entity_decode($item->unit_id) != '' && get_unit_type_item($item->unit_id) != null ? get_unit_type_item($item->unit_id)->unit_name : ''; ?></td>
                 </tr>
                 <tr class="project-overview">
                    <td class="bold"><?php echo _l('tax'); ?></td>
                    <td><?php echo html_entity_decode($item->tax) != '' && get_tax_rate_item($item->tax) != null ? get_tax_rate_item($item->tax)->name : '';  ?></td>
                 </tr> 
                </tbody>
          </table>
      </div>
    </div>
      <div class="col-md-12">
      <?php if(isset($inventory_item)){ 
            foreach ($inventory_item as $value) {
              $purchase_code = $value['purchase_code'] ? $value['purchase_code'] :'' ;
              $inventory_number = $value['inventory_number'] ? $value['inventory_number'] :'' ;
              $unit_name = $value['unit_name'] ? $value['unit_name'] :'' ;
        ?>
        <div class="col-md-3 bg-c-blue card1" >
            <div class="card-block">
                <h3 class="text-right h3-card-block-margin"><i class="fa fa-cart-plus f-left"></i><span class="h3-span-font-size"><?php echo html_entity_decode($purchase_code); ?></span></h3>
                <p class="m-b-0 p-card-block-font-size"><?php echo _l('inventory_number') ;?><span class="f-right p-card-block-font-size" ><?php echo html_entity_decode($inventory_number); ?></span></p>
            </div>
        </div>
        <?php } ?>
      <?php } ?>
      </div>
    </div>
    </div>
  </div>
<script type="text/javascript">
  (function() {
        var gallery = new SimpleLightbox('.gallery a', {});
    })();
</script>