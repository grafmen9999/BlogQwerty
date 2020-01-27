// require('./bootstrap');

$('#name-field').dblclick(function () {
    var elem = $(this).find('p');
    if (elem != undefined) {
        var parent = $(elem).parent();
        var text = elem.text();

        $(elem).remove()
        $(parent).append('<input class="form-control" type="text" name="name" id="nameInputs" required value="' + text + '">');
        $('#nameInputs').focus().attr('placeholder', 'username');
    }
});

$('#email-field').dblclick(function () {
    var elem = $(this).find('p');
    if (elem != undefined) {
        var parent = $(elem).parent();
        var text = elem.text();

        $(elem).remove()
        $(parent).append('<input class="form-control" type="email" name="email" id="emailInputs" required value="' + text + '">');
        $('#emailInputs').focus().attr('placeholder', 'email');
    }
});

$('#password-field').dblclick(function () {
    var elem = $(this).find('p');
    if (elem != undefined) {
        var parent = $(elem).parent();

        $(elem).remove()
        $(parent).append("<div class='pop-up change-password'><input class='form-control' type='password' name='password' placeholder='password' required><input class='form-control' type='password' name='password_confirmation' placeholder='password confirmation' required></div>");
    }

})