<div id="edit_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Modal</h4>
      </div>
      <form method="post">
        <div class="modal-body">
          <div class="form-group modal-group">
            <input id="hidden" type="hidden" name="id" value="">
            <input id="input" type="text" class="form-control edit-modal-input" name="name" value="" required>
          </div>
        </div>
        <div class="modal-footer">
          <div class="form-group">
            <input class="btn btn-warning" type="submit" name="edit" value="Edit">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>