<!-- Imperavi -->
<script src="{{ asset('packages/adminPanel/imperavi/redactor.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('packages/adminPanel/imperavi/redactor.css') }}"/>

<script src="{{ asset('packages/adminPanel/imperavi/lang/ru.js') }}"></script>
<script src="{{ asset('packages/adminPanel/imperavi/plugins/imagemanager/imagemanager.js') }}"></script>
<script type="text/javascript">
    $(function () {

        $('textarea').redactor({
            lang: 'ru',
            focus: true,
            imageUpload: '/ajax/upload-image',
            imageManagerJson: '/ajax/load-images',
            plugins: ['imagemanager'],
            uploadImageFields: {
                '_token': '<?= csrf_token() ?>'
            }
        });
    });
</script>
<!-- /Imperavi -->