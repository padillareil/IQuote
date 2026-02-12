$(document).ready(function(){
    loadDashboard();

});



function loadDashboard() {
    $.post("dirs/findings/components/main.php", {
    }, function (data){
        $("#load_Findings").html(data);
        loadQuotationsFindings();
      
    });
}


    $(document).ready(function() {
      OverlayScrollbars(document.getElementById("quotation-container"), {
          className: "os-theme-dark",
          scrollbars: {
            autoHide: "leave",
            clickScrolling: true
          }
        });
    });


    /* --- Pagination and Data Fetching --- */
    var currentPage = 1;
    var pageSize = 100; 
    var isLoading = false;

    $("#btn-preview").prop("disabled", true);

    function loadQuotationsFindings(page = 1) {
      if (isLoading) return;


      isLoading = true;
      $("#page-loader").show();

      $.post("dirs/findings/actions/get_findings.php", {

        CurrentPage: page,
        PageSize: pageSize
      })
      .done(function(data) {
        let response;
        try {
          response = JSON.parse(data);
        } catch (e) {
          console.error("Invalid JSON:", data);
          Swal.fire({
            icon: "error",
            title: "Error",
            text: "Invalid server response."
          });
          return;
        }

        if ($.trim(response.isSuccess) === "success") {
          renderPage(response.Data);
          currentPage = page;
          $("#btn-preview").prop("disabled", currentPage === 1);
          $("#btn-next").prop("disabled", response.Data.length < pageSize);
        } else {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: $.trim(response.Data)
          });
        }
      })
      .fail(function() {
        Swal.fire({
          icon: "error",
          title: "Network Error",
          text: "Failed to fetch quotations."
        });
      })
      .always(function() {
        isLoading = false;
        $("#page-loader").hide();
      });
    }

    /* --- Render Table Rows --- */
    function renderPage(pageData) {
      const $list = $("#display-quotation");
      $list.empty();

      if (!pageData || pageData.length === 0) {
        $list.append(`
          <tr>
            <td colspan="5" class="text-center py-4 text-muted">
              <i class="bi bi-file-earmark fs-1 d-block mb-2"></i>
              No Quotation Available
            </td>
          </tr>
        `);
        return;
      }

      pageData.forEach(item => {
        $list.append(`
          <tr class='text-center'>
            <td>${item.QNumber}</td>
            <td>${item.Branch}</td>
            <td>${item.Customer}</td>
            <td>
              <button class="btn btn-outline-secondary btn-sm" type="button" onclick="mdlIncidentReport('${item.QNumber}')">
                Incident Report
              </button>
            </td>
          </tr>
        `);
      });
    }

    /* --- Pagination Buttons --- */
    $("#btn-preview").on("click", function() {
      if (currentPage > 1) loadQuotationsFindings(currentPage - 1);
    });

    $("#btn-next").on("click", function() {
      loadQuotationsFindings(currentPage + 1);
    });

      /*Script for search*/
      $(document).ready(function () {
        $('#search-quotation').on('input', function () {
          const search = $(this).val().toLowerCase();
          $('#display-quotation a.list-group-item').each(function () {
            const status = $(this).find('[id="quote-status"]').text().toLowerCase(); // if you have a span for status
            const rowText = $(this).text().toLowerCase();

            if (status.includes(search) || rowText.includes(search)) {
              $(this).show();
            } else {
              $(this).hide();
            }
          });
        });
      });

/*
function get_student(StudentID){
    $.post("registry/sipedept/student/actions/get_student.php",{
        StudentID : StudentID
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#StudentName").val(response.Data.StudentName);
            $("#Address").val(response.Data.Address);
            $("#Age").val(response.Data.Age);
            $("#Status").val(response.Data.Status);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}


function update_student() {
    var StudentID   = $("#frm-add-student").attr("studentid");
    var StudentName = $("#StudentName").val();
    var Address     = $("#Address").val();
    var Age         = $("#Age").val();
    var Status      = $("#Status").val();

    $.post("registry/sipedept/student/actions/update_student.php", {
        StudentID   : StudentID,
        StudentName : StudentName,
        Address     : Address,
        Age         : Age,
        Status      : Status,
    }, function(data) {
        if(jQuery.trim(data) === "success") {
            $("#modal-add-student").modal('hide');
            load_student_list(); 
            alert('Update successful');
        } else {
            alert(data);
        }
    });
}


function delete_student(StudentID){
    $.post("registry/sipedept/student/actions/delete_student.php", {
        StudentID : StudentID
    },function(data){
        if(jQuery.trim(data) == "success"){
            $("#modal-add-student").modal('hide');
            load_student_list();
            alert('delete success');   
        }else{
            alert(data); 
        }
    });
}

function save_student(){
    var StudentName = $("#StudentName").val();
    var Address     = $("#Address").val();
    var Age         = $("#Age").val();
    var Status      = $("#Status").val();

    $.post("registry/sipedept/student/actions/save_student.php", {
        StudentName : StudentName,
        Address     : Address,
        Age         : Age,
        Status      : Status,
    }, function(data){
        if($.trim(data) == "OK"){
            alert("Student added.");
            $("#modal-add-student").modal("hide");
            load_student_list();
        }else{
            alert("Error: " + data);
        }
    });
}

*/