import $ from 'jquery';
import Inputmask from 'inputmask';


export default {
    inserted(el, binding, a, b){
        let elem = $(el);
        Inputmask({mask: '(+7|8) (999) 999-9999'}).mask(el);
        elem.on('focus', () => {
            if (!el.value.length) {
                setTimeout(() => {
                    el.setSelectionRange(4,4);
                }, 0);
            }
        }).on('blur', () => {
            if (el.value.length < 5) {
                el.value = '';
            }
        });
    }
}
