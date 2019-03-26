
  $(function () {
 
    $("button.create-category").click(function () {

      var route  = $(this).data("route");

      alertify.prompt("Category","Name", '',
        function(evt, value ){

          axios.post(route,{
            name:value
          })
          .then(function (response) { 
            location.reload()
          })
          .catch(function (error) {
            alertify.alert(error.response.data.message)
          });          

        },
        function(){ 
      });

    });

    $("a.edit-category").click(function () {
        var route  = $(this).data("route");
        var value = $(this).data("name");

        alertify.prompt("Category","Name", value,
            function(evt, value ){

                axios.put(route,{
                    name:value
                })
                .then(function (response) {  
                    $("#category_name_"+response.data.category.id).html(response.data.category.name)
                })
                .catch(function (error) {  
                    alertify.alert('Category',error.response.data.message)
                });          

        },
        function(){ 
        });
    });    

    $('[data-toggle=confirmation]').confirmation({
      rootSelector: '[data-toggle=confirmation]' 
    });     

    $("a.delete-category").click(function () {

      axios.delete($(this).data("route"))
      .then(function (response) {
        location.reload()
      })
      .catch(function (error) {
        alertify.alert(error.message)
      });

    });

  });
