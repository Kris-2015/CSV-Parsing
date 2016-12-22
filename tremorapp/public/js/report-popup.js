/**
 * Name: Report Popup js
 * Purpose: Triggering Modal
 * Package: public / js
 * Created on: 26th October, 2016
 * Author: mfsi-krishnadev
 */

 var show = {

    /**
     * Function to trigger the modal & submit form data
     *
     * @param void
     * @return void 
     */
     global : function() {

        // Submit the form data
        $('#getReport').submit(function() {
            var formObj = $(this);
            var formUrl = formObj.attr('action');
            var formValidUrl = formObj.attr('data-validurl');
            var pin = $.trim(formObj.find('input[name="pin"]').val());
            $('.pin-error-ctr').html('');

            $.ajax({
                'url': formUrl,
                'dataType': 'json',
                'type': 'post',
                data: {
                    'pin': pin,
                    '_token': formObj.find('input[name="_token"]').val(),
                    'tokenId': formObj.find('input[name="tokenId"]').val(),
                    'hashId': formObj.find('input[name="hashId"]').val()
                },
                success: function (response) {
                    if (typeof response.success !== 'undefined') {

                        $('#getReport .modal-body').html('Thank you. Your report will be downloaded shortly. You may close the window once the download is finished.');

                        $('#heading').text('Note');

                        $('.btn-submit').addClass('hidden');
                        $('.btn-closed-tab').removeClass('hidden');

                        // open a new tab with post parameter
                        var form = document.createElement("form");
                        form.setAttribute("method", "post");
                        form.setAttribute("action", formValidUrl);
                        
                        var pinHiddenField = document.createElement("input");
                        pinHiddenField.setAttribute("type", "hidden");
                        pinHiddenField.setAttribute("name", "pin");
                        pinHiddenField.setAttribute("value", pin);

                        form.appendChild(pinHiddenField);

                        var csrfTokenHiddenField = document.createElement("input");
                        csrfTokenHiddenField.setAttribute("type", "hidden");
                        csrfTokenHiddenField.setAttribute("name", "_token");
                        csrfTokenHiddenField.setAttribute("value", $.trim(formObj.find('input[name="_token"]').val()));

                        form.appendChild(csrfTokenHiddenField);

                        var hashIdHiddenField = document.createElement("input");
                        hashIdHiddenField.setAttribute("type", "hidden");
                        hashIdHiddenField.setAttribute("name", "hashId");
                        hashIdHiddenField.setAttribute("value", $.trim(formObj.find('input[name="hashId"]').val()));

                        form.appendChild(hashIdHiddenField);

                        var tokenIdHiddenField = document.createElement("input");
                        tokenIdHiddenField.setAttribute("type", "hidden");
                        tokenIdHiddenField.setAttribute("name", "tokenId");
                        tokenIdHiddenField.setAttribute("value", $.trim(formObj.find('input[name="tokenId"]').val()));

                        form.appendChild(tokenIdHiddenField);

                        form.submit();
                    } else if (typeof response.error !== 'undefined') {
                        $('.pin-error-ctr').html(
                            '<div class="alert alert-danger">' +
                                '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
                                    response.error +
                            '</div>'
                        );
                    } else if (typeof response.file !== 'undefined') {
                        $('.pin-error-ctr').html(
                            '<div class="alert alert-danger">' +
                                '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
                                    response.file +
                            '</div>'
                        );
                    } 
                }
            });

            return false;
        });

        // Trigger the modal
        $('#login').modal({
            backdrop: 'static',
            keyboard: false
        }, show);
    }
};

show.global();