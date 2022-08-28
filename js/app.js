window.onload = (e) => {

};

document.addEventListener(`change`, (e) => {

    // チェックボックス選択
    if (e.target.name == `checklist[q4][]`) {
        let checklist = document.querySelectorAll(`[name="checklist[q4][]"]:checked`);
        let sum = 0;
        [...checklist].forEach(e => {
            sum += Number(e.dataset.bitvalue);
        });
        let target = document.querySelector(`[name="input[answer4]"]`);
        target.value = sum;

        let feedback_target = document.querySelector(`#q4>.feedback>input[type="checkbox"]`);
        feedback_target.checked = (checklist.length > 0);
    }

    // ファイル選択
    if (e.target.name == `file[answer5]`) {
        let files = e.target.files;
        if (files.length > 0) {
            let feedback_target = document.querySelector(`#q5>.feedback>input[type="checkbox"]`);
            feedback_target.checked = (files[0].type == "image/png");
        }
    }
});
