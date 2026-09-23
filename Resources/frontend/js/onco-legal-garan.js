(function () {
    function findNoticeLink(node) {
        while (node && node !== document) {
            if (node.getAttribute && node.getAttribute('data-onco-legal-garan') === 'true') {
                return node;
            }
            node = node.parentNode;
        }

        return null;
    }

    document.addEventListener('click', function (event) {
        var link = findNoticeLink(event.target);
        if (!link) {
            return;
        }

        var template = document.querySelector('.onco-legal-garan--modal-template');
        if (!template || !window.jQuery || !window.jQuery.modal) {
            return;
        }

        event.preventDefault();

        window.jQuery.modal.open(template.innerHTML, {
            title: link.getAttribute('data-modal-title') || '',
            sizing: 'content',
            additionalClass: 'onco-legal-garan--modal'
        });

        var image = document.querySelector('.onco-legal-garan--modal .onco-legal-garan--notice-image');
        if (image && !image.complete) {
            image.onload = function () {
                if (document.body.contains(image) && window.jQuery && window.jQuery.modal) {
                    window.jQuery.modal.center();
                }
            };
        }
    });
})();
