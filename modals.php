<div class="modal fade" id="modal-pattern" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Add pattern</h4>
			</div>
			<div class="modal-body">
				<form id="form-pattern" action="javascript:void(0)">
					<label for="pattern" class="sr-only">Pattern</label>
					<input type="text" id="form-pattern-pattern" class="form-group form-control" placeholder="http://example.com/list/.*" />
					<label for="priority" class="sr-only">Priority</label>
					<select id="form-pattern-priority" class="form-group form-control" required>
						<option value="1">1 (Highest)</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5" selected>5 (Lowset)</option>
					</select>
					<div>
						<button id="form-pattern-submit" type="submit" class="btn btn-primary">Save</button>
						<span id="form-pattern-msg" class="text-danger"></span>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Update Config</h4>
			</div>
			<div class="modal-body">
				<form id="form-config" action="javascript:void(0)">
					<label for="pattern" class="sr-only">Pattern</label>
					<input type="text" id="form-config-pattern" class="form-group form-control" disabled required />
					
					<label for="expire" class="sr-only">Expire</label>
					<input type="number" id="form-config-expire" class="form-group form-control" placeholder="expire" required />
					
					<label for="limitation" class="sr-only">Limitation</label>
					<input type="number" id="form-config-limitation" class="form-group form-control" placeholder="limitation" required />
					
					<label for="expire" class="sr-only">Interval</label>
					<input type="number" id="form-config-interval" class="form-group form-control" placeholder="interval" required />
					
					<label for="expire" class="sr-only">Parallelism</label>
					<input type="number" id="form-config-parallelism" class="form-group form-control" placeholder="parallelism" required />
					
					<div>
						<button id="form-config-submit" type="submit" class="btn btn-primary">Save</button>
						<span id="form-config-msg" class="text-danger"></span>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-verify-site" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Verify Site</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" id="input-verify-site" />
				<h4>Your are verifing:&nbsp;&nbsp;<span id="modal-verify-site-site" class="text-success"></span></h4>
				<h4>Step1 Create file:&nbsp;<span id="modal-verify-site-file" class="text-info">Loading...</span></h4>
				<h4>Step2 Click the button below to finish.</h4>
				<div>
					<button id="btn-verify-site" type="button" class="btn btn-primary" disabled>Verify</button>
					<span id="verify-site-msg" class="text-danger"></span>
				</div>
			</div>
		</div>
	</div>
</div>
