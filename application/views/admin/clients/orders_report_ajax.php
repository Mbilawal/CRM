 		<div class="row">
		<div class="col-md-12">
		<div class="col-md-12">
        <figure class="highcharts-figure">
                      <div id="containermonthly"></div>
                      <div class="revenue_report_container"></div>
                  </figure>
        </div>
		
		</div>
		</div>
		<br/>
		


<script>

 Highcharts.chart('containermonthly', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Over All Orders Report'
    },
    subtitle: {
        text: 'Source: dryvarfoods.com'
    },
    xAxis: {
        categories: [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec'
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'No of Orders'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
  
  
    series: [{
          name: '  COMPLETED',
		color: '#5cb85c',
        data: [<?php echo json_encode($orders_count_completed);?>]

    }, {
        name: '  INCART',
		color: '#337ab7',
        data: [<?php echo json_encode($orders_count_pending);?>]

    }, {
        name: '  CANCELLED',
		color: '#337ab7',
        data: [<?php echo json_encode($orders_count_cancelled);?>]

    }, {
         name: '  DECLINED',
		color: '#fc2d42',
        data: [<?php echo json_encode($orders_count_declined);?>]

    }]});
	
		
</script>