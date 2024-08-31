function fieldinput(){

    var fields = ['surname', 'firstname', 'username', 'email'];

    // Check if at least one field has a value
    var atLeastOneFilled = fields.some(function (field) {
        return document.getElementsByName(field)[0].value.trim() !== '';
    });

    if (atLeastOneFilled) {
        return true; // Allow form submission
    } else {
        alert('Please provide input for at least one field about Users information.');
        return false; // Prevent form submission
    }
}
