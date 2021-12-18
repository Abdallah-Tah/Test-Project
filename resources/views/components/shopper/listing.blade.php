<x-table-column>
    <x-shopper.status :shopper="$shopper" />
</x-table-column>

<x-table-column>
    {{ $shopper['first_name'] }} {{ $shopper['last_name'] }}
</x-table-column>

<x-table-column>
    {{ $shopper['email'] }}
</x-table-column>

<x-table-column>
    {{ $shopper['check_in'] }}
</x-table-column>

<x-table-column>
    @if ($shopper['check_out'] == null)
    
    <button data-toggle="modal"  class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition"
    data-target="#exampleModal_{{ $shopper['id'] }}">
        Check-Out
    </button>

    <div class="modal fade" id="exampleModal_{{ $shopper['id'] }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><strong>Confirmation</strong></h5>
                    <i type="button" class="fa fa-close" data-dismiss="modal" aria-hidden="true"></i>
                </div>
                <div class="modal-body">
                    <form action="{{ route('checkout.button', $shopper['id']) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Are you sure you would like to Check-Out<span class="text-danger">*</span></label>
                            <input type="hidden" name="checkout" class="form-control" id="checkout" value="1">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                aria-label="Close">No</button>
                            <button class="btn btn-dark">Yes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
 
    @else
        {{ $shopper['check_out'] }}
    @endif
</x-table-column>

{{-- <x-table-column> --}}

{{-- </x-table-column> --}}
