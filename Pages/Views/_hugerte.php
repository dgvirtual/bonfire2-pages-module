hugerte.init({
    selector: 'textarea#content',
    height: 300,
    menubar: false,
    entity_encoding : 'raw',
    plugins: 'code',
    setup: function (editor) {
        editor.on('blur', function () {
            htmx.ajax('POST', '<?= $url ?>', { target: '#content_error' });
        });
    },
    statusbar: false,
    toolbar: 'undo redo | ' +
        'bold italic | alignleft aligncenter alignright alignjustify | ' +
        'bullist numlist outdent indent | removeformat | code | help',
});

// on htmx submit, trigger hugerte save = transfer text from editor to textarea
document.body.addEventListener('htmx:configRequest', (event) => {

    hugeRTE.triggerSave();

    let richContent = document.querySelector('#content');
    event.detail.parameters['content'] = richContent.value;
});
