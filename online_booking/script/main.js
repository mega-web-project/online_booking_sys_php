$(document).ready(function () {
    $(".sidebar ul li").on('click', function () {
        $(".sidebar ul li.active").removeClass('active');
        $(this).addClass('active');
    });

    $('.open-btn').on('click', function () {
        $('.sidebar').addClass('active');
    });

    $('.close-btn').on('click', function () {
        $('.sidebar').removeClass('active');
    });
    // 
    // ==============================
    // All request datatable 

    $('#all_request').DataTable({
        order: [[3, 'desc']],
    });


    // All Request datatable ends here


    // ==============================
    // Users datatable 

    $('#users').DataTable({
        order: [[3, 'desc']],
    });


    // Users datatable ends here



    // Department datatable 

    $('#department').DataTable({
        order: [[3, 'desc']],
        
    });


  
   


    // Department datatable ends here

});

    // post switch
$(document).ready(function () {
    $('#flexSwitchCheckChecked').on('click', function() {
        // Check if the div is currently visib
        var isVisible = $('#myPost').is(':visible');
      
        if (isVisible) {
          // Hide the div if it's currently visible
          $('#myPost').hide();
        } else {
          // Show the div if it's currently hidden
          $('#myPost').show();
        }
      });
   
});



// multiple selection
new MultiSelectTag('approvers'); // id




