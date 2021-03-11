<!DOCTYPE html>
<html>

<head>

  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <title><?php echo $meta_title ?></title>
  <meta name="keywords" content="<?php echo $meta_keywords ?>" />
  <meta name="description" content="<?php echo $meta_description ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php echo $INC_header_script_top; ?>
</head>

<body>

  <!-- Start: Header -->
  <?php echo $INC_top_header; ?>
  <!-- End: Header -->
  <!-- Start: Main -->

  <!-- Start: Sidebar -->

  <!-- End: Sidebar -->
  <!-- Start: Content -->
  <div class="page-wrapper"> <?php echo $INC_breadcrum ?>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12" style="min-height:1300px;">
          <div class="row">
            <div class="col-md-12">
              <div class="panel panel-default panel-visible">
                <div class="panel-heading bg-success">

                  <div class="row">
                    <div class="col-md-10">
                      <div class="panel-title"> <span class="glyphicon glyphicon-list-alt"></span> Manage Customers</div>
                    </div>
                    <div class="col-md-2" align="right">
                      <?php
                      if ($ALLOW_pages_add == 1) {
                      ?>
                        <a class="btn btn-sm btn-blue" href="<?php echo SURL ?>customers/manage-customers/add-new-customer"><span class="glyphicons glyphicons-circle_plus text-info"></span> Add New</a> <?php  }  ?>
                    </div>
                  </div>


                </div>
                <div class="panel-body padding-bottom-none">

                  <?php
                  if ($this->session->flashdata('err_message')) {
                  ?>
                    <div class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?></div>
                  <?php
                  } //end if($this->session->flashdata('err_message'))

                  if ($this->session->flashdata('ok_message')) {
                  ?>
                    <div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('ok_message'); ?></div>
                  <?php
                  } //if($this->session->flashdata('ok_message'))

                  if ($customers_user_list_count > 0) {
                  ?>

                    <table class="table table-striped table-bordered table-hover" id="manage_all_customers">
                      <thead>
                        <tr>
                          <th>Display Name</th>
                          <th class="hidden-xs">Account Type</th>
                          <th class="hidden-xs">Username</th>
                          <th class="hidden-xs">Last SignIn Date</th>
                          <th class="hidden-xs">Created Date</th>
                          <th class="hidden-xs">Status</th>
                          <th class="hidden-xs">Options</th>

                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>

                  <?php
                  } else {
                  ?>
                    <div class="alert alert-danger alert-dismissable">
                      <strong>No Customer(s) Found</strong> </div>
                  <?php
                  } //end if
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="row" style="min-height:250px;">&nbsp;</div>
    </div>


 <!-- End: Main -->
  <!-- Start: Footer -->
  <?php echo $INC_footer; ?>
</div>
</div>
  <!-- End: Footer -->
  <?php echo $INC_header_script_footer; ?>
  <script type="application/javascript">
    $('#manage_all_customers').dataTable({

      "bProcessing": true,
      "bServerSide": true,
      "sServerMethod": "POST",
      "sAjaxSource": "<?php echo base_url() ?>customers/manage-customers/process-customer-grid",
      "aoColumnDefs": [{
        'bSortable': false,
        'aTargets': [-1, -2]
      }],
      "aaSorting": [],
      "iDisplayLength": 50,
      "bPaginate": true,
      "bLengthChange": true,
      "bFilter": true,
      "aLengthMenu": [
        [25, 50, 75, 100],
        [25, 50, 75, 100]
      ],
      "aoColumns": [{
          "bSearchable": true
        },
        {
          "bSearchable": false
        },
        {
          "bSearchable": false
        },
        {
          "bSearchable": false
        },
        {
          "bSearchable": false
        },
        {
          "bSearchable": false
        },
        {
          "bSearchable": false
        }
      ],
      "oLanguage": {
        "sProcessing": "Searching Please Wait..."
      }

    }).fnSetFilteringDelay(700);
  </script>

  <script type="application/javascript">
    $('#manage_cms_pages').dataTable({
      "aoColumnDefs": [{
        'bSortable': false,
        'aTargets': [-1, -4, -5, -7]
      }],
      "aaSorting": [],
      "oLanguage": {
        "oPaginate": {
          "sPrevious": "",
          "sNext": ""
        }
      },
      "iDisplayLength": 25,
      "bPaginate": true,
      "bLengthChange": true,
      "bFilter": true,
      "aLengthMenu": [
        [25, 50, 75, 100],
        [25, 50, 75, 100]
      ],
      // "sDom": 'T<"panel-menu dt-panelmenu"lfr><"clearfix">tip',
      "oTableTools": {
        "sSwfPath": "<?php echo VENDOR ?>plugins/datatables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf"
      }

    });
  </script>
</body>

</html>