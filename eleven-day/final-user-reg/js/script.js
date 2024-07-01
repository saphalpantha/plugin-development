function submitform(event) {
    event.preventDefault();
    let userInput = {};
    


    const formData = new FormData();

    jQuery('form.main_form :input').each(function() {
        var key = jQuery(this).attr('name');

        
        if (key) {
            formData.append(`${key}`,jQuery(this).val());
        }


    })

    formData.append("action",'handle_form_submission');
    formData.append("profile",document.getElementById("profile").files[0]);

    console.log(formData);
    jQuery.ajax({
        url: `${ajax_object.ajax_url}`,
        type: 'post',
        data: formData,
        processData: false,
        contentType: false,
        success: function(res) {
            alert(`${res.data}`);
        },
        error: function(err) {
            alert('Form submission failed!');
        }
    });
}



function loginHandler(event){
    event.preventDefault()
    
    let userInput = {}
    jQuery('form.main_form :input').each(function(){
        var key = jQuery(this).attr('name');
        if(key){
            userInput[key] = jQuery(this).val();
        }
    })


    
    jQuery.ajax({
        url: `${ajax_object.ajax_url}`,
        type: 'post',

        data: {
            action: 'handle_login_form_submission',
            ...userInput
        },
        success: function(res) {

            if(res.success){
                console.log(res, 'for sucess status');
                window.location.href = res.data.redirect_to;
                return;
            }
         console.log('Login Failed');
        },
        error: function(err) {
            console.log(err)
        }
    });

}




jQuery('#user-reg-form').on('submit', (e) => submitform(e));