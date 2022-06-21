const selectData = document.querySelector('#show_result');
const showResult = document.querySelector('#select_data');
const selectDataShowing = document.querySelector('.select_data_showing')
const resultDataShowing = document.querySelector('.result_data_showing')
const Data = document.querySelector('#data');

selectData.addEventListener('click', () => {
    selectDataShowing.style.display = "block";
    resultDataShowing.style.display = "none";

});
showResult.addEventListener('click', () => {
    selectDataShowing.style.display = "none";
    resultDataShowing.style.display = "block";
});