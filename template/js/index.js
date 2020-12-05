$(window).on('load', function () {
    $("select#sorting").change(function() {
        var option = $(this).find('option:selected');
        window.location.href = option.data("url");
    });

    $("form").on("submit",(function(e) {
        let formId = $(this).attr("id");
        let action = $("#"+formId).attr("action");

        if ( action != '/search' ) {
            e.preventDefault();

            let formId = $(this).attr("id");

            let action = $("#"+formId).attr("action");
            let formData = new FormData(this);

            $.ajax({
                type:"POST",
                url: action,
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(data){
                    if ( data != true ){
                        alert(data);
                    }else{
                        if ( formId == "new-product" || formId == "edit-product" ) {
                            alert("Дані успішно збережено!");
                            location.reload();
                        }else if(formId == "delete-product"){
                            window.location.replace("/");
                        }else{
                            alert("Дані успішно збережено!");
                            $(".new-product-wrapper").removeClass("active");
                        }
                    }
                }
            });
        }
        
    }));
});