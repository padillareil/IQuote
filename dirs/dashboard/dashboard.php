<div class="card shadow-sm">
	<div class="card-body">
		<div id="load_dashboard">
		</div>
	</div>
</div>


<script src="dirs/dashboard/script/dashboard.js"></script>


<!-- Modal reset account -->
<div class="modal fade" id="mdl-reset" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body p-4 text-center">
        <p class="mb-0">Do you want to start re-setup user accounts?</p>
      </div>
      <input type="hidden" id="del-branch">
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-outline-secondary me-2" onclick="resetNow()">Yes</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>