// require('./bootstrap');

$('#name-field').dblclick(function () {
    var elem = $(this).find('p');
    if (elem != undefined) {
        var parent = $(elem).parent();
        var text = elem.text();

        $(elem).remove()
        $(parent).append('<input class="form-control" type="text" name="name" id="nameInputs" required value="' + text + '">');
        $('#nameInputs').focus().attr('placeholder', 'username');
    } else {
        var elem = $(this).find('#nameInputs');
        var text = elem.val();

        $(elem).remove();
        $(parent).append('<p>' + text + '</p>');
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
    } else {
        var elem = $(this).find('#emailInputs');
        var text = elem.val();

        $(elem).remove();
        $(parent).append('<p>' + text + '</p>');
    }
});

$('#password-field').dblclick(function () {
    var elem = $(this).find('p');
    if (elem != undefined) {
        var parent = $(elem).parent();

        $(elem).remove()
        $(parent).append("<div class='pop-up change-password'><input class='form-control' type='password' name='password' placeholder='password' required><input class='form-control' type='password' name='password_confirmation' placeholder='password confirmation' required></div>");
    } else {
        var elem = $(this).find('.change-password')[0];

        $(elem).children().each(function (item) {
            item.remove();
        });
        
        $(parent).append('<p>Click to the field for change password</p>');
    }

})