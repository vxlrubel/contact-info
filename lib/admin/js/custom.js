;(function($){
    const doc = $(document);
    const CONTACTINCO_PARENT = $('.contact-info-parent');
    const CONTACTINFO_FORM = $('.contact-info-form');
    class ContactInfo{
        init(){
            this.updateContactItem();
            this.deleteContactInfoSingleItem();
        }

        deleteContactInfoSingleItem(){
            CONTACTINCO_PARENT.on('click', 'a.contact_info_delete', function(e){
                e.preventDefault();
                let row  = $(this).closest('tr');
                let id   = $(this).data('id');
                let data = {
                    action: 'contact_info_delete_single_item',
                    id    : id
                }
                
                $.ajax({
                    type      : 'POST',
                    url       : ajaxurl,
                    data      : data,
                    beforeSend: ()=>{
                        console.log('deleting...');
                    },
                    success   : ( response ) => {
                        row.css('background-color', 'red').fadeOut(300, ()=>{
                            row.remove();
                        });
                    },
                });

                
            });
        }

        get_single_data( editId ){

            var accessToken = 'contact_info_access_token';

            let data = CONTACTINFO_FORM.serialize();
            
            alert( ci.rest_url + '/' + editId );
            
            $.ajax({
                type: "POST",
                url: ci.rest_url + '/' + editId,
                data: data,
                success: function (xhr) {
                    xhr.setRequestHeader('Content-Type', 'application/json');
                    xhr.setRequestHeader('Authorization', 'Bearer ' + accessToken);                
                }
            });
        }
        
        updateContactItem(){
            CONTACTINCO_PARENT.on('click', '#update-contact-item', (e)=>{
                e.preventDefault();
                let editId = e.target.dataset.edit;

                this.get_single_data( editId );
            });
        }
    }
    
    doc.ready(()=>{

        const CONTACT_INFO = new ContactInfo();

        CONTACT_INFO.init();
        
    });
})(jQuery);