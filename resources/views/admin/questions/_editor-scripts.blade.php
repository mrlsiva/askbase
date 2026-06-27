@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#answer',
            height: 350,
            menubar: false,
            plugins: 'table lists link code',
            toolbar: 'undo redo | blocks | bold italic underline | bullist numlist | table | link | code | removeformat',
            table_toolbar: 'tableprops tabledelete | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol',
            table_default_attributes: { border: '1' },
            table_default_styles: { 'border-collapse': 'collapse', width: '100%' },
            license_key: 'gpl',
        });

        document.getElementById('question-form').addEventListener('submit', function () {
            tinymce.triggerSave();
        });
    </script>
@endpush
