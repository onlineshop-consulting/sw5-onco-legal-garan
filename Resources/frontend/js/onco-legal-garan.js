(function () {
    var link = document.querySelector('[data-onco-legal-garan="true"]'),
        template = document.querySelector('.onco-legal-garan--modal-template');

    if (!link || !template) {
        return;
    }

    link.addEventListener('click', function (event) {
        if (!window.jQuery || !window.jQuery.modal) {
            return;
        }

        event.preventDefault();

        window.jQuery.modal.open(template.innerHTML, {
            title: link.getAttribute('data-modal-title') || '',
            sizing: 'content',
            additionalClass: 'onco-legal-garan--modal'
        });
    });
})();
