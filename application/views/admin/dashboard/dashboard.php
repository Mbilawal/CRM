<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="screen-options-area"></div>
   
    <div class="screen-options-btn">
        <?php echo _l('dashboard_options'); ?>
    </div>
    
    <div class="content">
        <div class="row">

            <?php if($this->session->userdata('franchise')==1){ ?>
            <style>
			
			.menu-item-mailbox{
				display:none!important;
			}
			
			
			</style>
            
             <div class="col-md-12"><iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe>
                  <p class="pull-left mtop5">Weekly Payment Records</p>
                                    <a href="https://crm.dryvarfoods.com/admin/reports/sales" class="pull-right mtop5">Full Report</a>
                  <div class="clearfix"></div>
                                    <div class="clearfix"></div>
                  <div class="row mtop5">
                     <hr class="hr-panel-heading-dashboard">
                  </div>
                                     <canvas height="420" class="weekly-payments-chart-dashboard" id="weekly-payment-statistics" width="971" style="display: block; height: 336px; width: 777px;"></canvas>
                   <div class="clearfix"></div>
                </div>

            <div class="col-md-8" data-container="left-8">
                <?php render_dashboard_widgets('left-12'); ?>
            </div>
            

            <div class="clearfix"></div>

           
            
            
            <?php }else{?>
            <?php $this->load->view('admin/includes/alerts'); ?>

            <?php hooks()->do_action( 'before_start_render_dashboard_content' ); ?>

            <div class="clearfix"></div>

            <div class="col-md-12 mtop30" data-container="top-12">
                <?php render_dashboard_widgets('top-12'); ?>
            </div>

            <?php hooks()->do_action('after_dashboard_top_container'); ?>

            <div class="col-md-6" data-container="middle-left-6">
                <?php render_dashboard_widgets('middle-left-6'); ?>
            </div>
            <div class="col-md-6" data-container="middle-right-6">
                <?php render_dashboard_widgets('middle-right-6'); ?>
            </div>

            <?php hooks()->do_action('after_dashboard_half_container'); ?>

            <div class="col-md-8" data-container="left-8">
                <?php render_dashboard_widgets('left-8'); ?>
            </div>
            <div class="col-md-4" data-container="right-4">
                <?php render_dashboard_widgets('right-4'); ?>
            </div>

            <div class="clearfix"></div>

            <div class="col-md-4" data-container="bottom-left-4">
                <?php render_dashboard_widgets('bottom-left-4'); ?>
            </div>
             <div class="col-md-4" data-container="bottom-middle-4">
                <?php render_dashboard_widgets('bottom-middle-4'); ?>
            </div>
            <div class="col-md-4" data-container="bottom-right-4">
                <?php render_dashboard_widgets('bottom-right-4'); ?>
            </div>
            
            <?php }?>
            

            <?php hooks()->do_action('after_dashboard'); ?>
        </div>
    </div>
</div>
<script>
    app.calendarIDs = '<?php echo json_encode($google_ids_calendars); ?>';
</script>
<?php init_tail(); ?>
<?php $this->load->view('admin/utilities/calendar_template'); ?>
<?php $this->load->view('admin/dashboard/dashboard_js'); ?>
</body>
</html>
