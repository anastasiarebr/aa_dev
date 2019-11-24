var ast = $("#answer-select-type-one-list");
var divAst = ("div#answer-select-type-one");

var divAstLast = ast.find(divAst).last();
$('#add-answer-select-type-one').click(function () {
    var countast = ast.find(divAst).length;
    var next = countast+1;
    if (countast < 7) {
        $(divAstLast).clone().attr('data-answer-index', next)
            .find('label:first')
            .text('Вариант ответа ' + next)
            .end()
            .find('input[type=checkbox]')
            .prop({'checked': false, 'value': countast})
            .end()
            .find('input[type=text]')
            .val('')
            .end()
            .appendTo(ast);
    }
});

$('#save-answer-select-type-one').click(function (e) {
    e.preventDefault();
    var valid  = true;
    var validInput = true;
    var error = $("#error-message");
    error.text("");
    var form = $('#form-question-select-type-one');
    var countCheckAnswer =  ast.find('input:checked').length;

    if (countCheckAnswer !== 1) {
        error.text('Должен быть один правильный ответ');
        valid = valid && false;
    }

    var countAnswerIsNull =  ast.find('input[type=text]').length;
    for (var i = 0; i < countAnswerIsNull; i++) {
        input = ast.find('input[type=text]')[i];
        value = $.trim(input.value);
        if(!value) {
            input.value = "";
            input.style = "border: 1px solid red";
            valid = valid && false;
            validInput = validInput && false;
        } else {
            input.style = "border: 1px solid green";
        }
    }

    if (!validInput) {
        error.text(' Необходимо заполнить  варианты ответов!');
    }

    if (valid) {
        form.submit();
    }
});
