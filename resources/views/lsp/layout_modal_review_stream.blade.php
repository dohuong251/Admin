<div class="modal fade" id="suspendModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="modal-content" method="post" action="{{route('admin.lsp.streams.suspend')}}">
            <div class="modal-header">
                <h4>Review Stream</h4>
            </div>
            <div class="modal-body">
                @csrf
                <input name="SongId" value="{{$song->SongId??""}}" type="hidden">
                <div class="form-group">
                    <label for="reason" class="control-label">Suspend Reason</label>
                    <select class="custom-select" name="Reason" id="reason">
                        <option value="Copyright">Copyright</option>
                        <option value="Nudity or sexual content">Nudity or sexual content</option>
                        <option value="Violent or graphic content">Violent or graphic content</option>
                        <option value="Spam, misleading metadata, and scams">Spam, misleading metadata, and scams</option>
                        <option value="Harmful or dangerous content">Harmful or dangerous content</option>
                        <option value="Hateful content">Hateful content</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Go</button>
            </div>
        </form>
    </div>
</div>
