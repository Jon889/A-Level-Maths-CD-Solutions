$(function () {
    $("#moduleSelect").change(updateUnitList);
    $("#unitSelect").change(updateChapterList);
    $("#chapterSelect").change(updateExerciseList);
    $("#exerciseSelect").change(updateQuestionsList);
    $("#questionSelect").change(goToCurrentQuestion);
    function goToCurrentQuestion() {
        var module = $("#moduleSelect").val();
        var unit = $("#unitSelect").val();
        var chapter = $("#chapterSelect").val();
        var exercise = $("#exerciseSelect").val();
        var question = $("#questionSelect").val();
        if (module && unit && chapter && exercise && question) {
            window.location.href = window.location.pathname + "?q=" + module + "_" + unit + "_" +  chapter + "_" + exercise + "_" + question;
        }
    }
    $("#next").click(function () {
        nextFn();
        goToCurrentQuestion();
    });
    $("#previous").click(function () {
        prevFn();
        goToCurrentQuestion();
    });
    $("#toggleSolution").click(toggleSolution);
    $("#goButton").click(goToCurrentQuestion);
    $(document).keydown(function(){
        if ( event.which == 39 && !$("#error > span").is(":focus")) {
            nextFn();
            goToCurrentQuestion();
        }
        if (event.which == 37 && !$("#error > span").is(":focus")) {
            prevFn();
            goToCurrentQuestion();
        }
    });
});