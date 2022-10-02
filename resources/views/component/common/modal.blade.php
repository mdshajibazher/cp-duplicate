<div class="modal fade" id="{{$modal_id}}"  tabindex="-1" role="dialog">
<div class="modal-dialog @if(isset($modal_size)) {{$modal_size}}@endif" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{$modal_title}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      
        {{$modal_form}}

        <div class="modal-body">
          {{$modal_body}}
        </div>
        <div class="modal-footer">
          
        <button type="submit" class="btn btn-primary @if(isset($modal_button_class)) {{$modal_button_class}}@endif"  id="@if(isset($submit_button)){{$submit_button}}@endif">
          Submit</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </form>
      </div>
    </div>
  </div>