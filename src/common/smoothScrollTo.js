import $ from 'jquery';
function smoothScrollTo(y = 0) {
    $('html, body').animate({
        scrollTop: y
    }, 500);
}
export default smoothScrollTo;
