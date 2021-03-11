<?php defined('BASEPATH') or exit('No direct script access allowed');

$standard_workload = get_option('standard_workload');
?>
<div class="row">
    <div class="col-md-12">
        <?php echo render_input('settings[standard_workload]', 'standard_workload', $standard_workload); ?>
    </div>
</div>

