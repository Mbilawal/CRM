<?php defined('BASEPATH') or exit('No direct script access allowed');?>

<?php init_head();?>
<div id="wrapper">
   <div class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="panel_s">
              <div class="panel-body">
                <div class="border-right">
                  <h4 class="no-margin font-bold"><?php echo _l($title); ?></h4>
                  <hr />
                </div>
                <div class="row">
                  <div class="col-md-2">
                    <?php echo render_select('department', $departments, array('departmentid', 'name'), 'department', '', array('multiple' => true, 'data-actions-box' => true), array(), '', '', false); ?>
                  </div>
                  <div class="col-md-2">
                    <?php echo render_select('role', $roles, array('roleid', 'name'), 'role', '', array('multiple' => true, 'data-actions-box' => true), array(), '', '', false); ?>
                  </div>
                  <div class="col-md-2">
                    <?php echo render_select('project', $projects, array('id', 'name'), 'project', '', array('multiple' => true, 'data-actions-box' => true), array(), '', '', false); ?>
                  </div>
                  <div class="col-md-2">
                    <?php echo render_select('staff', $staffs, array('staffid', 'firstname', 'lastname'), 'staff', '', array('multiple' => true, 'data-actions-box' => true), array(), '', '', false); ?>
                  </div>
                  <div class="col-md-4">
                    <div class="col-md-5">
                      <?php echo render_date_input('from_date', 'from_date', date('Y-m-d', strtotime('-7 day', strtotime(date('Y-m-d'))))); ?>
                    </div>
                    <div class="col-md-5">
                      <?php echo render_date_input('to_date', 'to_date', date('Y-m-d')); ?>
                    </div>
                    <div class="col-md-2">
                      <a href="#" onclick="get_data_workload(); return false;" class="px-0 btn btn-info display-block mtop25"><i class="fa fa-search"></i></a>
                    </div>
                  </div>
                </div>
                <nav>
               <ul class="nav nav-tabs resource_workload_tab" id="myTab" role="tablist">
                 <li class="nav-item active">
                   <a class="nav-link" id="workload-tab" data-toggle="tab" href="#tab_workload" role="tab" aria-controls="workload" aria-selected="true"><?php echo _l('workload'); ?></a>
                 </li>
                 <li class="nav-item">
                   <a class="nav-link" id="timeline-tab" data-toggle="tab" href="#tab_timeline" role="tab" aria-controls="timeline" aria-selected="false"><?php echo _l('timeline'); ?></a>
                 </li>
                 <li class="nav-item">
                   <a class="nav-link" id="chart-tab" data-toggle="tab" href="#tab_chart" role="tab" aria-controls="chart" aria-selected="false"><?php echo _l('chart'); ?></a>
                 </li>
               </ul>
            </nav>
            <br>
            <div class="tab-content" id="nav-tabContent">
                  <div class="tab-pane active in" id="tab_workload" role="tabpanel" aria-labelledby="nav-home-tab">
                    <label><?php echo _l('note_workload'); ?></label>
                    <div id="workload"></div>
                  </div>
                  <div class="tab-pane" id="tab_timeline" role="tabpanel" aria-labelledby="nav-home-tab">
                    <label class="control-label"><div class="calendar-cpicker cpicker cpicker-big br_customer" data-toggle="tooltip" title="<?php echo _l('client'); ?>"></div>
                    <div class="calendar-cpicker cpicker cpicker-big br_project" data-toggle="tooltip" title="<?php echo _l('project'); ?>"></div>
                    <div class="calendar-cpicker cpicker cpicker-big br_expense" data-toggle="tooltip" title="<?php echo _l('expense'); ?>"></div>
                    <div class="calendar-cpicker cpicker cpicker-big br_ticket" data-toggle="tooltip" title="<?php echo _l('ticket'); ?>"></div>
                    <div class="calendar-cpicker cpicker cpicker-big br_lead" data-toggle="tooltip" title="<?php echo _l('lead'); ?>"></div>
                    <div class="calendar-cpicker cpicker cpicker-big br_contract" data-toggle="tooltip" title="<?php echo _l('contract'); ?>"></div>
                    <div class="calendar-cpicker cpicker cpicker-big br_invoice" data-toggle="tooltip" title="<?php echo _l('invoice'); ?>"></div>
                    <div class="calendar-cpicker cpicker cpicker-big br_estimate" data-toggle="tooltip" title="<?php echo _l('estimate'); ?>"></div>
                    <div class="calendar-cpicker cpicker cpicker-big br_proposal" data-toggle="tooltip" title="<?php echo _l('proposal'); ?>"></div>
                  </label>

                    <svg id="timeline"></svg>
                  </div>
                  <div class="tab-pane " id="tab_chart" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="col-md-4">
                      <div class="panel_s">
                        <div class="panel-body">
                          <div id="container_task"></div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="panel_s">
                        <div class="panel-body">
                          <div id="container_time" class="container_time"></div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="panel_s">
                        <div class="panel-body">
                          <div id="container_priority" class="container_priority"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php init_tail();?>
<?php require 'modules/resource_workload/assets/js/resource_workload_js.php';?>
</body>
</html>
