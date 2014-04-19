function updateQuestionsList(pushState, selectedQuestion) {
	var module = $("#moduleSelect").val();
	var unit = $("#unitSelect").val();
	var chapter = $("#chapterSelect").val();
	var exercise = $("#exerciseSelect").val();
	$("#questionSelect")[0].options.length = 0;
	var questions = map[module][unit][chapter][exercise];
	if (questions.length == 1) {
		for (i = 1; i <= questions[0]; i++) {
			$("#questionSelect")[0].options.add(new Option(i.toString(), i.toString()));
		}
	} else { 
		$.each(questions, function() {
			$("#questionSelect")[0].options.add(new Option(this, this));
		});
	}
	if (selectedQuestion) {
		$("#questionSelect").val(selectedQuestion);
	}
}

function updateExerciseList (pushState, selectedExercise, selectedQuestion) {
	var module = $("#moduleSelect").val();
	var unit = $("#unitSelect").val();
	var chapter = $("#chapterSelect").val();
	$("#exerciseSelect")[0].options.length = 0;
	$.each(Object.keys(map[module][unit][chapter]), function() {
		$("#exerciseSelect")[0].options.add(new Option(this, this));
	});
	if (selectedExercise) {
		$("#exerciseSelect").val(selectedExercise);
	}
	updateQuestionsList(pushState, selectedQuestion);
}

function updateChapterList(pushState, selectedChapter, selectedExercise, selectedQuestion) {
	var module = $("#moduleSelect").val();
	var unit = $("#unitSelect").val();
	$("#chapterSelect")[0].options.length = 0;
	$.each(Object.keys(map[module][unit]), function() {
		$("#chapterSelect")[0].options.add(new Option(this, this));
	});
	if (selectedChapter) {
		$("#chapterSelect").val(selectedChapter);
	}
	updateExerciseList(pushState, selectedExercise, selectedQuestion);
}

function updateUnitList(pushState, selectedUnit, selectedChapter, selectedExercise, selectedQuestion) {
	var module = $("#moduleSelect").val();
	$("#unitSelect")[0].options.length = 0;
	$.each(Object.keys(map[module]), function() {
		$("#unitSelect")[0].options.add(new Option(this, this));
	});
	if (selectedUnit) {
		$("#unitSelect").val(selectedUnit);
	}
	updateChapterList(pushState, selectedChapter, selectedExercise, selectedQuestion);
}

function updateModuleList(pushState, selectedModule, selectedUnit, selectedChapter, selectedExercise, selectedQuestion) {
	$("#moduleSelect")[0].options.length = 0;
	$.each(Object.keys(map), function() {
		$("#moduleSelect")[0].options.add(new Option(this, this));
	});
	if (selectedModule) {
		$("#moduleSelect").val(selectedModule);
	}
	updateUnitList(pushState, selectedUnit, selectedChapter, selectedExercise, selectedQuestion);
}

function nextFn() {
	goToQuestion({ question : parseInt($("#questionSelect").val()) + 1}, true);
}

function prevFn() {
	goToQuestion({ question : parseInt($("#questionSelect").val()) - 1}, true);
}

function goToQuestionManually() {
	var moduleValue = prompt("Module","C");
	if (!moduleValue) return;
	var unitValue = prompt("Unit", "1");
	if (!unitValue) return;
	var chapterValue = prompt("Chapter", "1");
	if (!chapterValue) return;
	var exerciseValue = prompt("Exercise", "A");
	if (!exerciseValue) return;
	var questionValue = prompt("Question", "1");
	if (!questionValue) return;
	goToQuestion({module : moduleValue,  unit : unitValue, chapter : chapterValue, exercise : exerciseValue, question : questionValue});	
}
function currentQuestionDict() {
	var moduleV = $("#moduleSelect").val();
	var unitV = $("#unitSelect").val();
	var chapterV = $("#chapterSelect").val();
	var exerciseV = $("#exerciseSelect").val();
	var questionV = $("#questionSelect").val();
	if (moduleV && unitV && chapterV && exerciseV && questionV) {
		return { module : moduleV, unit : unitV, chapter : chapterV, exercise : exerciseV, question : questionV};
	}
	return null;
}
function goToQuestion(dict, pushState) { //dictionary of keys: module, unit,  chapter, exercise, question.
	var extended = $.extend({}, currentQuestionDict(), dict);
	console.log(extended);
	console.log(dict);
	updateModuleList(pushState, extended.module.toString(), extended.unit.toString(), extended.chapter.toString(), extended.exercise.toString(), extended.question.toString());
}


function setSolutionVisible(visible) {
	if (visible) {
		localStorage.setItem("solutionVisible", true);
		$("#toggleSolution").html("Hide");
		$("#solution").show();
	} else {
		localStorage.setItem("solutionVisible", false);
		$("#toggleSolution").html("Show");
		$("#solution").hide();
	}
}

function toggleSolution() {
	setSolutionVisible($("#solution").is(":hidden"));
}
