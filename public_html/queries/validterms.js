function validateForm() {
    // Define a regex pattern for valid query terms (query[1-15])
    var validQueryPattern = /^query(?:1[0-5]|[1-9])$/;

    // Retrieve the search term from the form
    var searchTerm = document.getElementById("search_bar").value;

    var formquery2 = document.getElementById("form_query2");

    var formquery11 = document.getElementById("form_query11");

    var formquery12 = document.getElementById("form_query12");

    var formquery6 = document.getElementById("form_query6");

    var formquery4 = document.getElementById("form_query4");

    var formquery5 = document.getElementById("form_query5");

    // Check if the search term matches the regex pattern
    if (validQueryPattern.test(searchTerm)) {

        if(searchTerm == "query1")
        window.location.href = 'queries/query1.php?search=' + searchTerm; // Valid query entered, redirect to query1.php
        
        else if(searchTerm == "query2"){
        formquery2.style.display = 'block';
        }

        else if(searchTerm == "query3"){
        window.location.href = 'queries/query3.php?search=' + searchTerm; // Valid query entered, redirect to query1.php
        }

        else if(searchTerm == "query4"){
        formquery4.style.display = 'block';
        }

        else if(searchTerm == "query5"){
            formquery5.style.display = 'block';
        }

            else if(searchTerm == "query6"){
        formquery6.style.display = 'block';
        }

        else if(searchTerm == "query7"){
        window.location.href = 'queries/query7.php?search=' + searchTerm; // Valid query entered, redirect to query1.php
        }

        else if(searchTerm == "query8"){
        window.location.href = 'queries/query8.php?search=' + searchTerm; // Valid query entered, redirect to query1.php
        }

        else if(searchTerm == "query9"){
        window.location.href = 'queries/query9.php?search=' + searchTerm; // Valid query entered, redirect to query1.php
        }

        else if(searchTerm == "query10"){
        window.location.href = 'queries/query10.php?search=' + searchTerm; // Valid query entered, redirect to query1.php
        }

        else if(searchTerm == "query11"){
        formquery11.style.display = 'block';
        }

        else if(searchTerm == "query12"){
        formquery12.style.display = 'block';
        }

        else if(searchTerm == "query13"){
        window.location.href = 'queries/query13.php?search=' + searchTerm; // Valid query entered, redirect to query1.php
        }

        else{

        }
        // Prevent form submission
        return false;
    } else {
        // Invalid query entered, display a warning message
        alert("Invalid query format. Please enter a valid query term (query1 to query15).");
        
        // Prevent form submission
        return false;
    }
}