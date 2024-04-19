{{-- @extends('layouts.view-main')


@push('js')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env("MIDTRANS_CLIENT_KEY") }}"></script>

    <!-- Your JavaScript code -->
    <script type="text/javascript">
        // Define your snap token
        var snapToken = "{{ $data['snap_token'] }}";
    
        window.onload = function() {
            snap.pay(snapToken, {
                // Optional callbacks
                onSuccess: function(result){
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                },
                onPending: function(result){
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                },
                onError: function(result){
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                }
            });
        };
    </script>
@endpush --}}