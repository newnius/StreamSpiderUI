function register_events_count()
{
}

function load_counts()
{
	$table = $("#table-count");
	$table.bootstrapTable({
		url: 'ajax.php?action=get_counts',
		responseHandler: countResponseHandler,
		cache: true,
		striped: true,
		pagination: true,
		pageSize: 10,
		pageList: [10, 25, 50, 100, 200],
		search: true,
		showColumns: false,
		showRefresh: true,
		showToggle: true,
		showPaginationSwitch: false,
		minimumCountColumns: 2,
		clickToSelect: false,
		sortName: 'nobody',
		sortOrder: 'desc',
		smartDisplay: true,
		mobileResponsive: true,
		showExport: false,
		columns: [{
			field: 'selected',
			title: 'Select',
			checkbox: true
		}, {
			field: 'key',
			title: 'Key',
			align: 'center',
			valign: 'middle',
			sortable: true
		}, {
			field: 'count',
			title: 'Count',
			align: 'center',
			valign: 'middle',
			sortable: true
		}, {
			field: 'ttl',
			title: 'TTL',
			align: 'center',
			valign: 'middle',
			sortable: true
		}, {
			field: 'operate',
			title: 'Operate',
			align: 'center',
			events: countOperateEvents,
			formatter: countOperateFormatter
		}]
	});
}

function countResponseHandler(res)
{
	if(res['errno'] == 0){
		return res['records'];
	}
	alert(res['msg']);
	return [];
}

function countOperateFormatter(value, row, index)
{
	return [
		'<button class="btn btn-default reset" href="javascript:void(0)">',
		'<i class="glyphicon glyphicon-remove"></i>&nbsp;Reset',
		'</button>'
	].join('');
}

window.countOperateEvents = {
	'click .reset': function (e, value, row, index) {
		if(!confirm('Are you sure to reset count ?')){ return; }
		var ajax = $.ajax({
			url: "ajax.php?action=reset_count",
			type: 'POST',
			data: { key: row.key }
		});
		ajax.done(function(json){
			var res = JSON.parse(json);
			if(res["errno"] == 0){
				$('#table-count').bootstrapTable("refresh");
			}else{
				alert(res['msg']);
			}
		});
  }
};
