<script>
var data_check = {};
var data_color = {};
var hot;
var tasks;
var gantt;
(function($) {
"use strict";
  // Init datepickers
  init_datepicker();

  var hotElement = document.querySelector('#workload');
  var hotSettings = {
    data: <?php echo html_entity_decode(json_encode($data_workload['data'])); ?>,
    columns: <?php echo html_entity_decode(json_encode($columns)); ?>,
    stretchH: 'all',
    autoWrapRow: true,
    rowHeaders: true,
    nestedHeaders: <?php echo html_entity_decode(json_encode($nestedheaders)); ?>,
      columnSorting: {
      indicator: true
    },
    licenseKey: 'non-commercial-and-evaluation',
    autoColumnSize: true,
    width: '100%',
    height: 400,
    dropdownMenu: true,
    mergeCells: true,
    contextMenu: true,
    manualRowMove: true,
    manualColumnMove: true,
    multiColumnSorting: {
      indicator: true
    },
     hiddenColumns: {
      columns: [1],
      indicators: true
    },
    filters: true,
    manualRowResize: true,
    manualColumnResize: true,
    comments: true,
    cell: <?php echo html_entity_decode(json_encode($data_workload['data_tooltip'])); ?>,
    cells: function(row, col, prop) {
      var cellProperties = {};
      cellProperties.renderer = myRenderer;
      return cellProperties;
    }
  };

  hot = new Handsontable(hotElement, hotSettings);

  Highcharts.chart('container_task', {
    chart: {
      type: 'pie',
      options3d: {
        enabled: true,
        alpha: 45
      }
    },
    title: {
      text: '<?php echo _l('statistics_by_estimate_hours'); ?>'
    },
    plotOptions: {
      pie: {
        innerSize: 100,
        depth: 45
      }
    },
    credits: {
        enabled: false
    },
    series: [{
        innerSize: '20%',
        name: '<?php echo _l('total_hours'); ?>',
        data: <?php echo html_entity_decode($estimate_stats); ?>
      }]
  });

  Highcharts.chart('container_time', {
    chart: {
        type: 'pie',
        options3d: {
            enabled: true,
            alpha: 45
        }
    },

    title: {
        text: '<?php echo _l('statistics_by_spent_hours'); ?>'
    },
    plotOptions: {
        pie: {
            innerSize: 100,
            depth: 45
        }
    },
    credits: {
        enabled: false
    },
    series: [{
        innerSize: '20%',
        name: '<?php echo _l('total_hours'); ?>',
        data: <?php echo html_entity_decode($spent_stats); ?>
      }]
  });

  Highcharts.chart('container_priority', {
    chart: {
        type: 'column'
    },
    title: {
        text: '<?php echo _l('statistics_by_departments'); ?>'
    },
    xAxis: {
        categories: <?php echo html_entity_decode($column_department); ?>
    },
    yAxis: {
        allowDecimals: false,
        min: 0,
        title: {
            text: '<?php echo _l('total_hours'); ?>'
        }
    },
    tooltip: {
        formatter: function () {
            return '<b>' + this.x + '</b><br/>' +
                this.series.name + ': ' + this.y + '<br/>' +
                'Total: ' + this.point.stackTotal;
        }
    },
    credits: {
        enabled: false
    },
    plotOptions: {
        column: {
            stacking: 'normal'
        }
    },
    series: <?php echo html_entity_decode($department_stats); ?>
  });

  tasks = <?php echo html_entity_decode(json_encode($data_timeline)); ?>;


  gantt = new Gantt("#timeline", tasks, {
      custom_popup_html: function(task) {
        // the task object will contain the updated
        // dates and progress value

        var total_time = 0;
        if(task.total_time != undefined){
          total_time = '<p class="details_title"> Total time: '+task.total_time+'</p>';
        }else{
          total_time = ''
        }
        var estimate_hour = 0;
        if(task.estimate_hour != undefined){
          estimate_hour = '<p class="details_title"> Estimate hour: '+task.estimate_hour+'</p>';
        }else{
          estimate_hour = ''
        }
        return `
        <div class="details-container">
          <h5 class="details_title">  ${task.name}</h5>
          <hr>
          ${total_time}
          ${estimate_hour}
          <p class="details_title"> Start date: ${task.start}</p>
          <p class="details_title"> End date: ${task.end}</p>
        </div>
        `;
      },
  });

  $("body").on('click', '#timeline-tab', function() {
    setTimeout(
      function()
      {
        gantt.refresh(tasks);
        //do something special
      }, 10);
  });

})(jQuery);

function get_data_workload(project_id,id) {
  "use strict";
  var data = {};
  data.department = $('select[name="department"]').val();
  data.role = $('select[name="role"]').val();
  data.project = $('select[name="project"]').val();
  data.staff = $('select[name="staff"]').val();
  data.from_date = $('input[name="from_date"]').val();
  data.to_date = $('input[name="to_date"]').val();
  $.post(admin_url + 'resource_workload/get_data_workload', data).done(function(response) {
    response = JSON.parse(response);
    hot.updateSettings({
      data: response.data_workload,
      columns: response.columns,
      nestedHeaders: response.nestedheaders,
      cell: response.data_tooltip,
      })
  });
  $.post(admin_url + 'resource_workload/get_data_timeline', data).done(function(response) {
    var numberRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;
    response = JSON.parse(response);
    tasks = response.data_timeline;
    gantt.refresh(tasks);
  });
};

function myRenderer(instance, td, row, col, prop, value, cellProperties) {
  "use strict";
  Handsontable.renderers.TextRenderer.apply(this, arguments);
  var basework = <?php echo html_entity_decode(get_option('standard_workload')); ?>;
  if (value > basework) {
    td.style.color = 'red';
  }
}

function yellowRenderer(instance, td, row, col, prop, value, cellProperties) {
  "use strict";
  Handsontable.renderers.TextRenderer.apply(this, arguments);
  td.style.backgroundColor = 'yellow';
}
</script>