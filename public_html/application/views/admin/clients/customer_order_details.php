<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php //echo "<pre>";  print_r($customer); exit;?>
<?php init_head();?>
<style>
.hrm-minheight198{
	min-height:198px;
}
.error{
	color:red;
}
.border-right h3{
	font-size:18px;
}
.top_stats_wrapper a p{
	font-size:12px;
}
   .loader
{
    display: none;
    position:absolute;
    width:100%;
    height:100%;
    left:0;
    top:0;
    text-align: center;
    margin-top: -100px;
    z-index: 2;
}
  .highcharts-figure, .highcharts-data-table table {
    /*min-width: 310px; 
    max-width: 800px;
    margin: 1em auto;*/
  }
  .highcharts-credits{
	  display:none;
	  }
  #container {
    height: 400px;
  }
  .highcharts-data-table table {
    font-family: Verdana, sans-serif;
    border-collapse: collapse;
    border: 1px solid #EBEBEB;
    margin: 10px auto;
    text-align: center;
    width: 100%;
   /* max-width: 1200px;*/
  }
  .highcharts-data-table caption {
  padding: 1em 0;
  font-size: 1.2em;
  color: #555;
  }
  .highcharts-data-table th {
  font-weight: 600;
  padding: 0.5em;
  }
  .highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
  padding: 0.5em;
  }
  .highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
  background: #f8f8f8;
  }
  .highcharts-data-table tr:hover {
  background: #f1f7ff;
  }
  .hr_style {
    margin-top: 10px;
    border: 0.5px solid;
    color: #03a9f4;
}
</style>

<style type="text/css">
  #containerTimeline2 {
      height: 400px; 
  }

  .highcharts-figure, .highcharts-data-table table {
      min-width: 310px; 
      max-width: 800px;
      margin: 1em auto;
  }

  .highcharts-data-table table {
      font-family: Verdana, sans-serif;
      border-collapse: collapse;
      border: 1px solid #EBEBEB;
      margin: 10px auto;
      text-align: center;
      width: 100%;
      max-width: 500px;
  }
  .highcharts-data-table caption {
      padding: 1em 0;
      font-size: 1.2em;
      color: #555;
  }
  .highcharts-data-table th {
    font-weight: 600;
      padding: 0.5em;
  }
  .highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
      padding: 0.5em;
  }
  .highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
      background: #f8f8f8;
  }
  .highcharts-data-table tr:hover {
      background: #f1f7ff;
  }
</style>

<!-- Model for Proposal  -->
<style type="text/css">

    a, a:hover, button, input[type="submit"]{
            transition: all 0.3s ease 0s;
        -webkit-transition: all 0.3s ease 0s;
        -moz-transition: all 0.3s ease 0s;
        -o-transition: all 0.3s ease 0s;
        -ms-transition: all 0.3s ease 0s;
        text-decoration: none;
        outline:0!important;
    }
    /*model-header*/
    .modal.preview-model {
        overflow: auto;
    }
    .modeldesign-inner {
        width: 70%;
        margin: 40px auto;
        background: #fff;
        border-radius: 20px;
    }
    .model-head {
        background: #21ae73;
        border: 1px solid #dbdbdb;
        padding: 20px 40px;
        width: 100%;
    }
    .modeldesign-inner .model-body {
        padding:3px 32px 30px 32px;
    }
    .model-head button.close {
        position: absolute;
        right: 250px;
        top: 10px;
    }
    .modeldesign-inner input[type="text"], .modeldesign-inner input[type="email"], 
    .modeldesign-inner input[type="password"], .modeldesign-inner textarea{
        height: 40px;
        width: 100%;
        box-sizing: border-box;
        padding: 10px;
        border: 1px solid #ccc; 
        font-size: 16px;
            border-radius: 2px;
        -webkit-border-radius: 2px;
        color: #202124;
        font-weight: 600;
        border-radius: 3px;
    }
  
  
    label.custom-check i span {
        display: block;
        font-weight: 500;
        font-size: 11px;
    }
    label.custom-check i {
        font-style: normal;
        font-weight: 800;
        text-transform: capitalize;
        display: inline-block;
        font-size: 14px;
    }
    label.custom-check:nth-child(2) {
        margin-left: 40px;
    }
    /******end custom check******/
    .right-send .form-group {
        width: 50%;
        float: left;
    }
    .right-send .form-group {
        padding-right: 15px;
        width: 45%;
    }
    .send-form-msg textarea, .send-form-msg input , .view_proposal_body_text textarea{
        /*background: #f2f2f2;
        border: -1 !important;*/
        height: 120px;
        font-size: 15px;
        text-align: left;
    }
    .form-group.mesaage .subject input {
        width: 100%;
        background: transparent;
        border: 1px solid #e9e9e9 !important;
    }
    .form-group.mesaage .subject {
        display:flex; 
        align-items: center;
    }
    .form-group.mesaage textarea {
        background: transparent;
        border: 1px solid #e9e9e9 !important;
        height: 220px;
    }
    .subject {
        margin-bottom: 16px;
        margin-top: 4px;
       /* display: none;*/
    }
    .subject label {
        padding-right:15px;
    }
    .form-group.mesaage > label {
        margin-bottom: 16px;
    }
    .right-send {
        opacity: .3;
    }
    .div_opacity {
        opacity: 1;
    }
    .send-form-msg.row {
        border-top: 1px solid #e9e9e9;
        padding: 30px 0px 0;
        /* margin-top: 30px; */
    }
    /**proview model**/
    .preview-model .modal-dialog {
        width: 100%;
        max-width: 70%;
    }
    .preview-model .modal-header {
        background: #333333;
        text-align: center;
    }
    .preview-model .modal-content {
        background: #e6e6e6;
        border: 0;
    }
    .preview-model .modal-header h5#exampleModalLabel {
        width: 100%; text-transform: capitalize;
    }
    .preview-body {
        width: 82%;
        background: #fff;
        margin: 40px auto;
            padding: 30px;
    }
    .preview-body .modal-body .row {
        align-items: center;
    }
    .proposal-title h5 {
        text-align: center;
        text-transform: uppercase;
        font-weight: 800;
        letter-spacing: .8px;
        font-size: 24px;
        line-height: 28px;
        color: #333;
    }
    .preview-body  .media-left p {
        border: 1px dashed #e9e9e9;
        text-align: center;
        padding: 30px 10px;
        text-transform: capitalize;
        color: #dedede;
        font-weight: 600;
    }
    .preview-body  .media-left {
        width: 50%;
        padding-right: 30px;
            border-right: 1px solid #333;
    }
    .preview-body .media-body {
        padding-left: 30px;
    }
    .preview-body .media-body p {
        line-height: 27px;
        font-size: 15px;
        color: #333333;
        font-weight: 600;
    }
    a.bg-gray {
        background: #333333;
    }
    .acccpt-decline a {
        display: inline-block;
        width: 70px;
        height: 70px;
        border-radius: 100%;
        text-align: center;
        color: #fff;
        font-size: 12px;
        font-weight: 500;
            margin: 0 10px;
    }
    .acccpt-decline a i {
        font-size: 15px;
    }
    .acccpt-decline a span {
        display: inline-block;
        margin-top: 17px;
            font-weight: 600;
    }
    a.bg-green {
        background: #62A000;
    }
    .row.accepted .media-left {
        border: 0;
        text-align: right;
        padding: 0 0px 0 0px;
       color: #333;
        font-weight: 800;
    }
    .row.accepted {
        border-top: 1px solid #e9e9e9;
        padding: 30px 0px 0;
        margin-top: 10px;
    }
    .deal-structure-pre h5 {
        background: #f2f2f2;
        padding: 10px;
        text-transform: capitalize;
        font-size: 20px;
        margin-bottom: 20px;
       color: #333;
        font-weight: 800;
    }
    .deal-structure-pre {
        margin-top: 50px;
    }
    .inventory-img img {
        width: 100%;
        border: 1px dashed #e9e9e9;
        height: auto;
        object-fit: contain;
    }
    .inventory-img {
        width: 50%;
        float: left;
        padding: 5px;
    }
    .deal-structure-pre ul li {
        color: #333;
        font-size: 15px;
        padding-bottom: 6px;
        font-weight: 600;
    }
    .propsal-name {
        margin-top: 10px;
        margin-bottom: 30px;
    }
    .propsal-name strong {
        margin-bottom: 20px;
        display: inline-block;
        color: #333;
        font-weight: 800;
    }
    .btm-text.text-center {
        font-size: 12px;
        color: #666;
        margin-top: 80px;
            font-weight: 500;
    }
    .preview-model .modal-footer {
        justify-content: center;
    }
    .preview-model .modal-footer button {
        background: #333333;
        border: 0;
    }
    .modeldesign-inner .model-body fieldset:nth-child(3) button.save-preview {
        background: #333;
    }
    .modeldesign-inner .model-body fieldset:nth-child(3) button.saveclose {
         background: #48a700; margin-right: 10px; color: #fff;
    }

    /**tab 4**/
    .sent-success p {
        font-weight: 600;
    }
    .sent-success {
        width:90%;
        margin:20px auto 30px;    
    }
    .proposalheading.text-center h5 {
        color: #333;
        font-weight: 800;
        text-transform: capitalize;
        font-size: 20px;
    }
    ul.status li a {
        font-size: 14px;
        font-weight: 800;
    }
    ul.status li.send a {
        color: #008ABA;
    }
    ul.status li:first-child:after, ul.status li:last-child:after {
        background: transparent;
    }
    ul.status li:after {
        position: absolute;
        content: '';
        background: #666;
        width: 2px;
        height: 13px;
        transform: skew(-21deg, -5deg);
        top: 6px;
        right: 0;
    }
    ul.status li {
        display: inline-block;
        text-transform: capitalize;
        position: relative;
        padding-right: 6px;
    }
    ul.status li.accept a {
        color: #62A000;
    }
    ul.status li.dcline a {
        color: #ED1C24;
    }
    ul.view-share-delete li {
        width: 47%;
        float: left;
        margin: 5px;
    }
    ul.view-share-delete LI h5 {
        color: #333333;
        font-size: 16px;
        font-weight: 800;
        margin-top: 20px;
        text-transform: capitalize;
    }
    ul.view-share-delete LI a {
        background: #f2f2f2;
        text-align: center;
        border-radius: 4px;
        padding: 30px;
        height: 170px;
        box-shadow: 1px 1px 1px #e8e8e8;
        display: inline-block;
        width: 100%;
    }
    ul.view-share-delete LI a i {
        border-radius: 100%;
        width: 50px;
        height: 50px;
        text-align: center;
        line-height: 50px;
        color: #fff;
        font-size: 22px;
    }
    ul.view-share-delete LI.share a i {
    background: #0089bf;
    }
    ul.view-share-delete LI.edit a i {
    background: #00ae9f;
    }
    ul.view-share-delete LI.delete a i {
    background: #ff4b00;
    }
    ul.view-share-delete {
        width: 70%;
        margin: 60px auto 0;
    }
    ul.status {
        margin-top: 30px;
    }
    .done-btn button{
        background: #333333;
        border: 0;
        color: #fff;
    }
    .done-btn {
        margin-top: 20px;
        margin-bottom: 0;
    }
    ul.view-share-delete li img {
        width: 50px;
        height: : 50px;
    }
    .fw-container{
        float: left;
        width: 100%;
    }
    /**Share proposal link**/
    .share_proposal-sec {
        clear: both;
            display: none;
                margin-top: 60px;
    }
    ul.view-share-delete {
        width: 70%;
        margin: 60px auto 0;
    }
    .share_proposal-sec ul.sec-body {
        width: 70%;
        margin: 0 auto;
        background: #f2f2f2;
        padding: 20px;
        border-radius: 4px;
    }
    .sec-header h5 {
        float: left;
        text-align: center;
        width: 95%;
    }
    .sec-header a {
        float: left;
        color: #666;
        font-size: 20px;
        padding-right: 10px;
    }
    .sec-header h5 {
        float: left;
        text-align: center;
        width: 95%;
        color: #333;
        text-transform: capitalize;
        font-weight: 800;
        font-size: 20px;
    }
    .sec-header {
        margin-bottom: 30px;
        width: 100%;
        float: left;
        display: flex;
    }
    .share_proposal-sec ul.sec-body li {
        color: #4D4D4D;
        font-size: 16px;
        padding-bottom: 60px;
        font-weight: 600;
    }
    .share_proposal-sec ul.sec-body li strong {
        font-weight: 800;
    }
    .sec-header a i {
        color: #808080;
        font-weight: 600;
    }
    .share_proposal-sec ul.sec-body li a {
        display: block;
        color: #3289bf;
        font-size: 12px;
        margin-top: 15px;
            font-weight: 600;
    }
    .share_proposal-sec ul.sec-body li a strong {
        font-size: 16px;
        color: #666;
        font-weight: 600;
        margin-right: 6px;
    }
    .someClass {
        opacity: 0;
        overflow: hidden;
        visibility: hidden;
        display: none;
    }
    .someClass + .share_proposal-sec{
      display: block;
    }
    .hide_subject_Div {
        display: block;
    }


    /***************Mobile View*****************/
    @media (max-width: 991px) {
        .modeldesign-inner {width:86%;} 
        .form-card {padding:0;}
        .model-head { padding: 15px 15px;}
        .border_lft_rht {
            border: 0;
        }
        .preview-model .modal-dialog {
            max-width: 96%;
        }
        .preview-body {
            width: 95%;
            margin: 23px auto;
            padding: 15px;
        }
    }
        
    @media (max-width: 768px) {
        .modeldesign-inner {width: 90%;}
        #progressbar li {
            font-size: 12px;
            font-weight: 500;
            line-height: 13px;
        }
        .custom-select-trigger, .modeldesign-inner input[type="text"], .modeldesign-inner input[type="email"], 
        .modeldesign-inner input[type="password"], .modeldesign-inner textarea, 
        .inventory-desp, a.moreless-button span, .action-button{
            font-size: 14px;
        }
        #progressbar li:after {
            top: 20px;
        }
        #progressbar li:before {
            width: 40px;
            height: 40px;
            line-height: 36px;
            font-size: 15px;
        }
        #progressbar li:last-child:after {
            width: calc(100% - 80px);
        }
        #progressbar li.step-completed i , #progressbar li span{
            display:block;
        }
        .right-send .form-group, ul.view-share-delete LI, ul.view-share-delete, .share_proposal-sec ul.sec-body{
            width: 100%;
        }
        .done-btn {;
            text-align: center !important;
        }
        ul.view-share-delete LI {
            margin: 0 0 10px;
        }
        ul.view-share-delete li img {
            width: 20%;
        }
        .row.accepted .media-left{
          text-align: left;
        }
        .preview-body .modal-body .row{
            flex-direction: column-reverse;
        }
        .proposal-title h5 {
            font-size: 22px;
            line-height: 26px;
            margin-bottom: 20px;
        }
        .row.accepted .col-lg-6.col-md-6.col-sm-12.float-right.text-right {
            float: left !important;
            text-align: left !important;
        }
        .row.accepted .media-left, .row.accepted .media-body, .preview-body .media-left, 
        .preview-body .media-body {
            width: 100%;     
            border: 0;
        }
        .row.accepted .media, .preview-body .media{
            display: block;
        }
        .row.accepted .media-body {
            padding-left: 0;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .preview-body .media-body {
            padding-left: 0;
            margin-top: 20px;
        }
        .model-head button.close {
            right: 2px;
            top: -1px;
        }
    }

    @media (max-width: 680px) {
        .action-button {
            width: 100%;
            margin: 0 0 10px;
        }
        .custom-check {
            width: 100% !important;
            margin: 0 0 26px !important;
        }
        .modeldesign-inner .model-body fieldset:nth-child(3) button.saveclose {
            margin: 0 0 10px;
        }
    }

    @media (max-width: 560px) {
        #progressbar li:last-child:after {
            width: calc(100% - 60px);
        }
    }

    @media (max-width: 480px) {
        #progressbar li:first-child:after {
            width: calc(100% - 0px);
        }
        #progressbar li:before {
            width: 30px;
            height: 30px;
            line-height: 28px;
            font-size: 12px;
        }
        #progressbar li:after {
            top: 14px;
        }
        #progressbar li:last-child:after {
            width: calc(100% - 37px);
        }
        .modeldesign-inner {
            width: 97%;
        }
    }

    #deal_proposal_details_btn {
         z-index: 999; 
        color: #fff;
        cursor: pointer;
    }
    #delete_proposal_ajax {
        color: #f5f1f1;
        cursor: pointer;
        font-size: 14px;
        font-weight: bold;
        padding-top: 0px;
        position: absolute;
        right: 0px;
        text-align: center;
        top: -7px;
    }
    .propsal_dgn{
        width:100%;
    }
    .img_wrapper{
        position: relative;
        overflow: hidden;
        text-align: center;
        height: 220px;

    }
    .img_wrapper img{
        min-width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
        margin: auto;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .autoload_suggest_box2 {
        position: absolute;
        z-index: 9;
        background: #fff;
        width: 93%;
        border: 1px solid #ccc;
        top: 77px;
        border-radius: 0 0 8px 8px;
        overflow: hidden;
        box-shadow: 0 9px 19px 6px rgba(0,0,0,0.1);
        cursor: pointer;
    }

    /*preview model*/
    .KzzPreview .modal-dialog {
        max-width: 40%;
    }
    .view_user_inventory{
        background: #fff;
        width: 100%;
        border: 1px solid #ccc;
        border-radius: 0 0 8px 8px;
        overflow: hidden;
        box-shadow: 0 9px 19px 6px rgba(0,0,0,0.1);
        cursor: pointer;
    }
    .view_user_inventory .autoload_suggest_ul {
        max-height: 80vh;
    }
    button#view_inventory {
        background: limegreen;
    }
    .total-finace {
        font-size: 16px;
        margin-left: 42px;
    }
    .show-advance1 a {
        color: #62A000;
        font-size: 14px;
        font-weight: 600;
    }
    input#total_tax{
        background: #f2f2f2;
    }
    input#trade_net_allowance{
        background: #f2f2f2;
    }
    .bsc_field_label{
        color: #5f6368;
        text-transform: capitalize;
        font-size: 15px;
        font-weight: 800;
        display: inline-block;
        margin-bottom: 1px;
    }
    .default_field_label{
        color: #808080;
        font-size: 12px;
        font-weight: 800;
        float: right;
        margin-right: 22px;
        cursor: POINTER;
    }
    .is_default_field_label{
        color: rgb(0, 138, 186);
    }
    .contact_product_section{
        margin-bottom: 20px;
    }

    .contact_deal_response{
        margin-bottom: 20px;
    }

    @media(max-width: 1000px){
        .acccpt-decline{
          margin-right: 0;
          width: 100%;
          text-align: center;
          margin-top: 0;
        }
        .media-left img {
          width: 50%;
        }
        .proposal-title h5 {
          margin-bottom: 40px;
          margin-top: 30px;
        }
        .row_text_align{
            margin:0 0 0 0;
        }   
        .row_text_align .col-md-12, .row_text_align .col-md-6,.row_text_align .col-sm-12, .row_text_align .col-xs-12{
            padding: 0;
        }
    }

    .fw{
        float: left;
        width: 100%;
    }
    span.edditor_deal_structure_upper {
      float: right;
    }
</style>
<input type="hidden" id="contact_select" value="<?php echo $userid; ?>">
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-body">
            
            <div class="clearfix"></div>
            <div class="row mbot15">
              
			  
			  <div class="col-md-12 col-xs-12 bold p_style" style=""><h3> Filter Customer Data   </h3> </div>
                <form id="customersFilter" method="post" action="">
				<input type="hidden" name="customer_id" id="customer_id" value="<?php echo $customer['dryvarfoods_id'];?>">
				<div class='col-md-6'>
                    <label><strong>Date From *</strong></label>
                    <div class='input-group date' id='datetimepicker1'>
                        <input type="text" id="date_from" name="date_from" class="form-control datepicker select_filters" value="" placeholder="From Date" autocomplete="off" aria-invalid="false" required="true">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
					<div class="date_from_error"></div>
                  </div>
                  <div class='col-md-6'>
                    <label><strong>Date To *</strong></label>
                    <div class='input-group date' id='datetimepicker2'>
                        <input type="text" id="date_to" placeholder="To Date" name="date_to" class="form-control datepicker select_filters" value="" autocomplete="off" aria-invalid="false" required="true">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
					<div class="date_to_error"></div>
                  </div>
				  <div class="col-md-12">
				    <div class="pull-right" style="margin-top:15px;">
					  <input class="btn btn-info" type="button" name="search_btn" id="search_btn" value="Search">
					</div>
				  </div>
              
				</form>
				<div class="col-md-12">
                <h3 class="padding-5">
                  Customer Sales Profile <span style="float: right" ><?php echo ($customer['last_order']);?></span>
                </h3>
              </div>
                 <hr class="hr_style" />
				<div class="loader">
			   <center>
				   <img class="loading-image" src="<?php echo base_url();?>assets/images/search.gif" alt="loading..">
			   </center>
			</div>
		    <div class="customer_container">
              <div class="col-md-3 col-xs-6 border-right" style="border-bottom: 2px solid #03a9f4;">
                <h3 class="bold"  ><?php echo ucfirst($customer['firstname'])?></h3>
                <span class="text-primary"><?php echo ucfirst($customer['email'])." | ".ucfirst($customer['phonenumber'])?></span>
              </div>
              <div class="col-md-3 col-xs-6 border-right" style="border-bottom: 2px solid #31f300;">
                <h3 class="bold"><?php if($customer['datecreated']!=""){ echo date("F j, Y, g:i a", strtotime($customer['datecreated']));} ?></h3>
                <span class="text-success">Joining Date</span>
              </div>
              <div class="col-md-3 col-xs-6 border-right" style="border-bottom: 2px solid #f32200;">
                <h3 class="bold"><?php echo ucfirst($customer['total_orders'])?> </h3>
                <span class="text-danger">Total Orders</span>
              </div>
              <div class="col-md-3 col-xs-6 border-right" style="border-bottom: 2px solid #ff9900;">
                <h3 class="bold"><?php if($customer['total_orders']>0){ echo round($customer['total_amount']/$customer['total_orders'],2); }?> R</h3>
                <span class="text-warning">Average Order Value</span>
              </div>
            
            <hr class="hr-panel-heading" />
            <div class="clearfix mtop20"></div>
            
            <div class="col-md-12">
              <div class="row mbot15">
                <div class="quick-stats-invoices col-xs-12 col-md-3 col-sm-6">
                  <div class="top_stats_wrapper hrm-minheight85">
                     <a class="text-default mbot15">
                     <p class="text-uppercase mtop5 hrm-minheight35"><i class="hidden-sm glyphicon glyphicon-edit"></i> Total Possible Revenue </p>
                        <span class="pull-right no-mtop hrm-fontsize24"><?php echo ucfirst($customer['total_amount'])?> R</span>
                     </a>
                     <div class="clearfix"></div>
                     <div class="progress no-margin progress-bar-mini">
                        <div class="progress-bar progress-bar-default no-percent-text not-dynamic hrm-fullwidth" role="progressbar" aria-valuenow="13" aria-valuemin="0" aria-valuemax="13" data-percent="100%">
                        </div>
                     </div>
                  </div>
                </div>
       
                <div class="quick-stats-invoices col-xs-12 col-md-3 col-sm-6">
                   <div class="top_stats_wrapper hrm-minheight85">
                       <a class="text-success mbot15">
                       <p class="text-uppercase mtop5 hrm-minheight35"><i class="hidden-sm glyphicon glyphicon-edit"></i> Total Completed Orders Revenue </p>
                          <span class="pull-right bold no-mtop hrm-fontsize24" id="completedcount"><?php echo number_format($completed_orders_revenue["total_revenue"], 2, ".", ""); ?> R</span>
                       </a>
                       <div class="clearfix"></div>
                       <div class="progress no-margin progress-bar-mini">
                          <div class="progress-bar progress-bar-success no-percent-text not-dynamic hrm-fullwidth" role="progressbar" aria-valuenow="13" aria-valuemin="0" aria-valuemax="13" data-percent="100%">
                          </div>
                       </div>
                    </div>
                </div>
         
                <div class="quick-stats-invoices col-xs-12 col-md-3 col-sm-6">
                  <div class="top_stats_wrapper hrm-minheight85">
                      <a class="text-danger mbot15">
                        <p class="text-uppercase mtop5 hrm-minheight35">
                          <i class="hidden-sm glyphicon glyphicon-remove"></i>
                          Total Declined Orders Revenue
                        </p>
                        <span class="pull-right bold no-mtop hrm-fontsize24" id="declinecount">
                          <?php echo number_format($declined_orders_revenue["total_revenue"], 2, ".", ""); ?> R
                        </span>
                       </a>
                       <div class="clearfix"></div>
                        <div class="progress no-margin progress-bar-mini">
                          <div class="progress-bar progress-bar-danger no-percent-text not-dynamic hrm-fullwidth" role="progressbar" aria-valuenow="13" aria-valuemin="0" aria-valuemax="13" data-percent="100%">
                          </div>
                        </div>
                    </div>
                </div>
         
                <div class="quick-stats-invoices col-xs-12 col-md-3 col-sm-6">
                   <div class="top_stats_wrapper hrm-minheight85">
                       <a class="text-warning mbot15">
                       <p class="text-uppercase mtop5 hrm-minheight35"><i class="hidden-sm glyphicon glyphicon-envelope"></i> Total Pending Orders Revenue          </p>
                          <span class="pull-right bold no-mtop hrm-fontsize24" id="pendingcount"><?php echo ($orders_count_pending); ?> R</span>
                       </a>
                       <div class="clearfix"></div>
                       <div class="progress no-margin progress-bar-mini">
                          <div class="progress-bar progress-bar-warning no-percent-text not-dynamic hrm-fullwidth" role="progressbar" aria-valuenow="13" aria-valuemin="0" aria-valuemax="13" data-percent="100%">
                          </div>
                       </div>
                    </div>
                </div>
             </div>
			</div>
			<div class="col-md-12">
              <div class="row mbot15">
			 <div class="quick-stats-invoices col-xs-12 col-md-3 col-sm-6">
                  <div class="top_stats_wrapper hrm-minheight198">
                      <a class="text-success mbot15">
					    <h2><center><i class="hidden-sm glyphicon glyphicon-home"></i></center></h2>
                        <center>
                        <p class="text-uppercase mtop5 hrm-minheight35">
                  
                          Favourite Store that Customer Likes
                        </p>
                        <span class="pull-right bold no-mtop hrm-fontsize24" id="declinecount">
                          <?php echo $favourite_store["company"];?>
                        </span>
						</center>
                       </a>
                       <div class="clearfix"></div>
                        
                    </div>
                </div>
				
				<div class="quick-stats-invoices col-xs-12 col-md-3 col-sm-6">
                  <div class="top_stats_wrapper hrm-minheight198">
                      <a class="text-danger mbot15">
					   <h2><center><i class="hidden-sm glyphicon glyphicon-heart"></i></center></h2>
                        <center>
                        <p class="text-uppercase mtop5 hrm-minheight35">
                          Favourite Meal Item
                        </p>
                        <span class="bold no-mtop hrm-fontsize24" id="declinecount">
                          <?php if($favourite_meal_item["name"]!=""){ echo $favourite_meal_item["name"]; } else{ echo ""; }?>
                        </span>
						</center>
                       </a>
                       <div class="clearfix"></div>
                       
                    </div>
                </div>
				
				<div class="quick-stats-invoices col-xs-12 col-md-3 col-sm-6">
                  <div class="top_stats_wrapper hrm-minheight198">
                      <a class="text-warning mbot15">
					    <h2><center><i class="hidden-sm glyphicon glyphicon-shopping-cart"></i></center></h2>
                        <center>
                        <p class="text-uppercase mtop5 hrm-minheight35">
                          Order Frequency
                        </p>
                        <span class="bold no-mtop hrm-fontsize24" id="declinecount">
                          <?php echo $order_frequency;?>
                        </span>
						</center>
                       </a>
                       <div class="clearfix"></div>
                        
                    </div>
                </div>
				
				<div class="quick-stats-invoices col-xs-12 col-md-3 col-sm-6">
                  <div class="top_stats_wrapper hrm-minheight198">
                      <a class="text-success mbot15">
					    <h2><center><i class="hidden-sm glyphicon glyphicon-cutlery"></i></center></h2>
                        <center><p class="text-uppercase mtop5 hrm-minheight35">
                          Customer Meal Preference Of Extras Added On
                        </p>
                        <span class="bold no-mtop hrm-fontsize24" id="declinecount">
                          
                        </span>
						</center>
                       </a>
                       <div class="clearfix"></div>
                    </div>
                </div>
         
             
			 </div>
            </div>
            
            
            <div class="col-md-12">
			   <div class="panel_s contracts-expiring">
                <div class="panel-body padding-10" >
                  <h3 class="padding-5" style="    color: #03a9f4;">TimeLine</h3>
                  <hr class="hr-panel-heading-dashboard">
                  <div class="text-center padding-5">
                    <div id="containerTimeline"></div>
                    <div class="alert alert-warning noorders" role="alert" style="display:none;">
                      0ops! No orders found against customer.
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <h3 class="padding-5"><?php echo ucfirst($customer)?> <b>Order Detail</b></h3>
          <!--<hr class="hr-panel-heading-dashboard">-->
          <div class="text-center padding-5">
            <div class="row">
              <div class=" col-md-12 col-xs-12"  style="font-weight: bold;">
                <table class="table table-hover  no-footer dtr-inline collapsed orderstable" >
                  <thead>
                    <tr role="row" style="background:#f6f8fa; border-top: 1px solid #f0f0f0!important;border-left: 0;border-right: 1px solid #f0f0f0;">
                      <th style="min-width: 30px;font-weight: bold;">S.NO</th>
                      <th style="min-width: 50px;font-weight: bold;">Order ID</th>
                      <th style="min-width: 120px;font-weight: bold;">Customer</th>
                      <th style="min-width: 120px;font-weight: bold;">Resturant</th>
                      <th style="min-width: 120px;font-weight: bold;">Suburb</th>
                      <th style="min-width: 120px;font-weight: bold;">Status</th>
                      <th style="min-width: 120px;font-weight: bold;">Reward Point</th>
                      <th style="min-width: 120px;font-weight: bold;">Loyalty Point</th>
                      <!--<th style="min-width: 120px;font-weight: bold;">Time Lapse</th>-->
                      <th style="min-width: 120px;font-weight: bold;">Total Amout</th>
                      <th style="min-width: 120px;font-weight: bold;">Driver</th>
                      <th style="min-width: 120px;font-weight: bold;">Date</th>
                    </tr>
                  </thead>
                  <tbody id="order_list">
                  </tbody>
                </table>
                <div class="alert alert-warning noorders" role="alert" style="display:none;">
                  0ops! No orders found against customer.
                </div>
                <span id="response_pagination">
                    <div class="row_iner">
                      <div id="pagigi">
                        <div id="page_links"></div>
                      </div>
                    </div>
                </span>
              </div>
            </div>
          </div>
          </div><!--End of customer_container-->
		  </div>
        </div>
      </div>
    </div>
  </div>
</div>



<!-- Model For Proposal -->
<div class="modeldesign-main modal fade preview-model" id="deal_proposal_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modeldesign-inner">
    
    <div class="model-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
      
    </div>
  </div>
</div>
<!--End Model For Proposal-->


<?php init_tail(); ?>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.highcharts.com/modules/timeline.js"></script>

<script type="text/javascript">
  
$( document ).ready(function() {
    
    var page = 0;
    var client   = 0;
    var driver   = 0;
    var contact  = $('#contact_select').val();
    
    $.ajax({
        url: "<?php echo admin_url(); ?>clients/orders_ajax/"+page,
        type: "POST",
        data: {contact:contact},
        success: function(response){
			
            if(response=='nororders'){
			   $(".noorders").show();
			   $(".orderstable").hide();
			   $("#containerTimeline").hide();
			   
			   
			}else{
				var res_arr = response.split('***||***');
				$(".noorders").hide();
				$(".orderstable").show();
				$("#containerTimeline").show();
				$('#order_list').html(res_arr[0]);
				$('#record_count').html(res_arr[1]);
				$('#page_links').html(res_arr[2]);
				$('#pendingcount').html(res_arr[3]+' R');
				//$('#completedcount').html(res_arr[4]+' R');
				//$('#declinecount').html(res_arr[5]+' R');
			}

        }
    });
    get_time_line_data();

});



function get_time_line_data(){

    var contact  = $('#contact_select').val();

        $.ajax({ 
            
            url : "<?php echo admin_url(); ?>clients/get_timeline_graph_data/"+contact,
            type: "POST",
            data : "",
            success:function(response) 
            {

                var data_arr = JSON.parse(response);

                for (var i = data_arr.length - 1; i >= 0; i--) {
                    var date = data_arr[i].x;
                    var date_arr = date.split(',');
                    data_arr[i].x = Date.UTC( parseInt(date_arr[0]), parseInt(date_arr[1]-1), parseInt(date_arr[2]));
                }

                console.log(data_arr);
                Highcharts.chart('containerTimeline', {
            
                    chart: {
                      zoomType: 'x',
                      type: 'timeline'
                    },
                    xAxis: {
                      type: 'datetime',
                      visible: false
                    },
                    yAxis: {
                      gridLineWidth: 1,
                      title: null,
                      labels: {
                          enabled: false
                    }
                },
                legend: {
                      enabled: true
                },
                title: {
                  text: 'Timeline of Customer Orders'
                },
                subtitle: {
                  text: ''
                },
                tooltip: {
                    style: {
                      width: 300
                    }
                },
                series: [{
                  dataLabels: {
                      allowOverlap: false,
                      format: '<span style="color:{point.color}">● </span><span style="font-weight: bold;" > ' +
                          '{point.x:%d %b %Y}</span><br/>{point.label}'
                  },
                marker: {
                      symbol: 'circle',
                  },
                point: {
                      events: {
                          click: function(event){
                            var id = event.point.id;
                            var win = window.open("<?php echo admin_url()?>clients/orders_detail/"+id, '_blank');
                            if (win) {
                                win.focus();
                            } else {
                                alert('Please allow popups for this website');
                                }
                            }
                        }
                    },

                    data: data_arr
                }]
            });

        }
    }); 
}


    $("body").on("click","#rewards_model",function(e){
    
        // $('#deal_proposal_model').html();
        $('#deal_proposal_model').modal('show');
    
    });


    $("body").on("click", ".order_filter_pagination li a", function(event){

        event.preventDefault();
        var page = $(this).data("ci-pagination-page");
        var client   = 0;
        var driver   = 0;
        var contact  = $('#contact_select').val();
       
        if($(this).data("ci-pagination-page")){

          $.ajax({
              url: "<?php echo admin_url(); ?>clients/orders_ajax/"+page,
              type: "POST",
              data: {contact:contact},
              success: function(response){

                  var res_arr = response.split('***||***');

                  $('#order_list').html(res_arr[0]);
                  $('#record_count').html(res_arr[1]);
                  $('#page_links').html(res_arr[2]);

              }
          });
        }    

    });
	$("document").ready(function() {
		$("#customersFilter").validate({
				errorPlacement: function (error, element) {
					if($(element).attr("name")=="date_from"){
					 $(".date_from_error").append(error);
					}
					if($(element).attr("name")=="date_to"){
					 $(".date_to_error").append(error);
					}
				}
		});
	});
	$("body").on("click", "#search_btn", function(){
	if($("#customersFilter").valid()){
		var page = 0;
		var data = $("#customersFilter").serialize();
	   
		$.ajax({
			url: "<?php echo admin_url(); ?>clients/customer_details_ajax",
			type: "POST",
			data: data,
			beforeSend: function(){
						 $('.loader').show();
					},
			success: function(response){
			  $('.loader').hide();
			  $(".customer_container").html(response);
			  var page = 0;
    var client   = 0;
    var driver   = 0;
    var contact  = $('#contact_select').val();
	var date_from  = $('#date_from').val();
	var date_to  = $('#date_to').val();
    
    $.ajax({
        url: "<?php echo admin_url(); ?>clients/orders_ajax/"+page,
        type: "POST",
        data: {contact:contact,date_from:date_from,date_too:date_to},
        success: function(response){
			
            if(response=='nororders'){
			   $(".noorders").show();
			   $(".orderstable").hide();
			   $("#containerTimeline").hide();
			   
			   
			}else{
				var res_arr = response.split('***||***');
				$(".noorders").hide();
				$(".orderstable").show();
				$("#containerTimeline").show();
				$('#order_list').html(res_arr[0]);
				$('#record_count').html(res_arr[1]);
				$('#page_links').html(res_arr[2]);
				$('#pendingcount').html(res_arr[3]+' R');
				//$('#completedcount').html(res_arr[4]+' R');
				//$('#declinecount').html(res_arr[5]+' R');
			}

        }
    });
    get_time_line_data();
			  

			}
		});  
    }	
	else{
		$("#customersFilter").validate();
	}

  });
  
</script>

</body>
</html>