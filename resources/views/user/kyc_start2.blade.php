{{-- i want the dojah widget to be big on big sscreen and small on smaill screen --}}

<!DOCTYPE html>
<html>
<head>
    <title>KYC Verification</title>
    <script src="https://widget.dojah.io/widget.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<script>
    window.onload = function () {
        let kycCompleted = false; // ✅ Track if KYC succeeded

        const options = {
            app_id: "{{ $appId }}",
            p_key: "{{ $publicKey }}",
            type: "verification",
            config: { widget_id: "{{ $widgetId }}" },
            user_data: {
                first_name: "{{ $user->first_name }}",
                last_name: "{{ $user->last_name }}",
                email: "{{ $user->email }}",
            },
            metadata: {
                user_id: "{{ $user->id }}",
                reference: "{{ $reference }}",
            },

            // ✅ When KYC is successful, set flag and redirect
            onSuccess: (response) => {
                console.log('KYC Success', response);
                kycCompleted = true;
                window.location.href = "{{ route('kyc.complete') }}";
            },

            // ✅ Only show SweetAlert if KYC was NOT successful
            onClose: () => {
                if (!kycCompleted) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'KYC Process Closed',
                        text: 'You closed the KYC verification. Click OK to return to the dashboard.',
                        confirmButtonText: 'OK',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{ route('dashboard') }}";
                        }
                    });
                }
            },

            // ✅ Show alert for errors only
            onError: (err) => {
                console.error('KYC Error', err);
                Swal.fire({
                    icon: 'error',
                    title: 'KYC Verification Failed',
                    text: 'An error occurred during the KYC process. Click OK to return to the dashboard.',
                    confirmButtonText: 'OK',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('dashboard') }}";
                    }
                });
            }
        };

        const connect = new window.Connect(options);
        connect.setup();
        connect.open();
    };
</script>
</body>
</html>