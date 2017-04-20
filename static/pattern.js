function register_events_pattern()
{
	$('#btn-pattern-add').click(function(e){
		$("#form-pattern-pattern").val("");
		$("#form-pattern-priority").val(5);
		$('#modal-pattern').modal('show');
	});

	$("#form-pattern-submit").click(function(e){
		$("#form-pattern-submit").attr("disabled", "disabled");
		var pattern = $("#form-pattern-pattern").val();
		var priority = $("#form-pattern-priority").val();
		var ajax = $.ajax({
			url: "ajax.php?action=add_pattern",
			type: 'POST',
			data: {
				pattern: pattern,
				priority: priority
			}
		});
		ajax.done(function(json){
			var res = JSON.parse(json);
			if(res["errno"] == 0){
				$('#modal-pattern').modal('hide');
				$('#table-pattern').bootstrapTable("refresh");
			}else{
				$("#form-pattern-msg").html(res["msg"]);
				$("#modal-pattern").effect("shake");
			}
			$("#form-pattern-submit").removeAttr("disabled");
		});
		ajax.fail(function(jqXHR,textStatus){
			alert("Request failed :" + textStatus);
			$("#form-pattern-submit").removeAttr("disabled");
		});
	});
}

function load_patterns()
{
	$table = $("#table-pattern");
	$table.bootstrapTable({
		url: 'ajax.php?action=get_patterns',
		responseHandler: patternResponseHandler,
		cache: true,
		striped: true,
		pagination: false,
		pageSize: 25,
		pageList: [10, 25, 50, 100, 200],
		search: false,
		showColumns: false,
		showRefresh: false,
		showToggle: false,
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
			field: 'pattern',
			title: 'Pattern',
			align: 'center',
			valign: 'middle',
			sortable: false
		}, {
			field: 'priority',
			title: 'Priority',
			align: 'center',
			valign: 'middle',
			sortable: false
		}, {
			field: 'operate',
			title: 'Operate',
			align: 'center',
			events: patternOperateEvents,
			formatter: patternOperateFormatter
		}]
	});
}

function patternResponseHandler(res)
{
	var records = [];
	if(res['errno'] == 0){
		var patterns = res["patterns"];
		$.each(patterns, function(index ,value){
			var record = { "pattern": index, "priority": value };
			records.push(record);
		});
		return records;
	}
	alert(res['msg']);
	return [];
}

function patternOperateFormatter(value, row, index)
{
	return [
		'<button class="btn btn-primary edit" href="javascript:void(0)">',
		'<i class="glyphicon glyphicon-cog"></i>&nbsp;Config',
		'</button>&nbsp;',
		'<button class="btn btn-danger remove" href="javascript:void(0)">',
		'<i class="glyphicon glyphicon-remove"></i>&nbsp;Delete',
		'</button>'
	].join('');
}

window.patternOperateEvents = {
	'click .edit': function (e, value, row, index) {
		var pattern = row.pattern;
		show_config(pattern);
	},
	'click .remove': function (e, value, row, index) {
		var pattern = row.pattern;
		if(!confirm('Are you sure to remove this pattern (permanently) ?')){ return; }
		var ajax = $.ajax({
			url: "ajax.php?action=remove_pattern",
			type: 'POST',
			data: { pattern: pattern }
		});
		ajax.done(function(json){
			var res = JSON.parse(json);
			if(res["errno"] == 0){
				$('#table-pattern').bootstrapTable("refresh");
			}else{
				alert(res["msg"]);
			}
		});
	}
};
