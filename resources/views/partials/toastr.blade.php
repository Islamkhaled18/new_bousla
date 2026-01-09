<script>
    // Toastr Configuration
    toastr.options = {
        closeButton: false,
        progressBar: true,
        positionClass: "toast-top-right",
        timeOut: 5000,
        extendedTimeOut: 1000,
        showMethod: 'fadeIn',
        hideMethod: 'fadeOut',
        preventDuplicates: true,
    };

    // Success Message
    @if (session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    // Error Message
    @if (session('error'))
        toastr.error("{{ session('error') }}");
    @endif

    // Warning Message
    @if (session('warning'))
        toastr.warning("{{ session('warning') }}");
    @endif

    // Info Message
    @if (session('info'))
        toastr.info("{{ session('info') }}");
    @endif

    // Validation Errors
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}");
        @endforeach
    @endif
</script>