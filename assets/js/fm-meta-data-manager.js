jQuery(document).ready(function ($) {
    const showMessage = (msg, type = 'success') => {
        const $msg = $('.fm-meta-message');
        $msg
            .hide()
            .removeClass()
            .addClass(`notice notice-${type} is-dismissible`)
            .html(`<p>${msg}</p>`)
            .fadeIn();
        setTimeout(() => $msg.fadeOut(), 3000);
    };

    // Add new meta
    $('#fm-add-meta-btn').on('click', function (e) {
        e.preventDefault();

        const key = $('#fm-new-meta-key').val().trim();
        const value = $('#fm-new-meta-value').val().trim();
        const post_id = $('#post_ID').val();

        if (!key) {
            showMessage('Please enter a meta key.', 'error');
            return;
        }

        $.post(FM_MetaDataManager.ajaxurl, {
            action: 'fmmetadata_add_meta_value',
            nonce: FM_MetaDataManager.nonce,
            post_id,
            key,
            value
        }, (response) => {
            if (response.success) {
                // Add new row dynamically
                const newRow = `
                    <tr data-key="${response.data.key}">
                        <td class="meta-key"><code>${response.data.key}</code></td>
                        <td class="meta-value-cell"><input type="text" class="meta-value" value="${response.data.value}" /></td>
                        <td class="meta-actions">
                            <button class="button button-primary fm-save-meta" title="Save Meta"><span class="dashicons dashicons-yes-alt"></span></button>
                            <button class="button button-secondary fm-delete-meta" title="Delete Meta"><span class="dashicons dashicons-trash"></span></button>
                        </td>
                    </tr>`;
                $('.fm-meta-table tbody').append(newRow);
                $('#fm-new-meta-key, #fm-new-meta-value').val(''); // clear inputs
                showMessage(response.data.message, 'success');
            } else {
                showMessage(FM_MetaDataManager.error, 'error');
            }
        });
    });

    // Save meta
    $('.fm-save-meta').on('click', function (e) {
        e.preventDefault();
        const $row = $(this).closest('tr');
        const key = $row.data('key');
        const value = $row.find('.meta-value').val();
        const post_id = $('#post_ID').val();

        $.post(FM_MetaDataManager.ajaxurl, {
            action: 'fmmetadata_update_meta_value',
            nonce: FM_MetaDataManager.nonce,
            post_id,
            key,
            value
        }, (response) => {
            if (response.success) {
                showMessage(FM_MetaDataManager.success, 'success');
            } else {
                showMessage(FM_MetaDataManager.error, 'error');
            }
        });
    });

    // Delete meta
    $('.fm-delete-meta').on('click', function (e) {
        e.preventDefault();
        if (!confirm('Are you sure you want to delete this meta key?')) return;

        const $row = $(this).closest('tr');
        const key = $row.data('key');
        const post_id = $('#post_ID').val();

        $.post(FM_MetaDataManager.ajaxurl, {
            action: 'fmmetadata_delete_meta_value',
            nonce: FM_MetaDataManager.nonce,
            post_id,
            key
        }, (response) => {
            if (response.success) {
                $row.fadeOut();
                showMessage(FM_MetaDataManager.deleted, 'success');
            } else {
                showMessage(FM_MetaDataManager.error, 'error');
            }
        });
    });
});
