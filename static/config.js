function register_events_config()
{
	$("#form-config-submit").click(function(e){
		$("#form-config-submit").attr("disabled", "disabled");
		var pattern = $("#form-config-pattern").val();
		var expire = $("#form-config-expire").val();
		var limitation = $("#form-config-limitation").val();
		var interval = $("#form-config-interval").val();
		var parallelism = $("#form-config-parallelism").val();
		var ajax = $.ajax({
			url: "ajax.php?action=update_config",
			type: 'POST',
			data: {
				pattern: pattern,
				expire: expire,
				limitation: limitation,
				interval: interval,
				parallelism: parallelism
			}
		});
		ajax.done(function(json){
			var res = JSON.parse(json);
			if(res["errno"] == 0){
				$('#modal-config').modal('hide');
			}else{
				$("#form-config-msg").html(res["msg"]);
				$("#modal-config").effect("shake");
			}
			$("#form-config-submit").removeAttr("disabled");
		});
		ajax.fail(function(jqXHR,textStatus){
			alert("Request failed :" + textStatus);
			$("#form-config-submit").removeAttr("disabled");
		});
	});
}

function show_config(pattern)
{
	$('#modal-config').modal('show');
	$('#form-config-pattern').val(pattern);
	var ajax = $.ajax({
		url: "ajax.php?action=get_config",
		type: 'GET',
		data: { pattern: pattern }
	});
	ajax.done(function(json){
		var res = JSON.parse(json);
		if(res["errno"] == 0){
			var pairs = res["config"];
			$('#form-config-expire').val(pairs['expire']);
			$('#form-config-limitation').val(pairs['limitation']);
			$('#form-config-interval').val(pairs['interval']);
			$('#form-config-parallelism').val(pairs['parallelism']);
		}else{
			alert(res["msg"]);
		}
	});
	
}
