$(function () {
    $('#patients-first-name').keypress(function (e) {
        if (e.which === 32)
            return false;
    });
    $('#approximate-year-of-onset-of-earliest-motor-symptom-yyyy, #approximate-duration-of-parkinson-disease-in-months').numeric();
    $('#approximate-year-of-onset-of-earliest-motor-symptom-yyyy').attr('maxlength', '4');
    $('#approximate-duration-of-parkinson-disease-in-months').attr('maxlength', '3');
});