import $ from 'jquery'


let listening = false,
    objList = [];

/*
*  Directive listens to keyup's and calls function when requirements are met.
*
* input object keys:
*
*   func: required. Calls this function. If function doesent return truthful value, it will stop event propagation.
*   param: optional. Passes this param as func argument.
*   keycode: optional. Function called only on this keycode. Default: 27 (escape)
*
*   IMPORTANT: use v-if with this directive instead of v-show
* */

export default {
    bind(el, binding) {
        let elem = $(el);

        if (!listening) {
            $('html').on('keyup', cycle);
            listening = true;
        }
        objList.push({
            elem: elem,
            func: binding.value.func,
            param: binding.value.param,
            keycode: binding.value.keycode || 27,
            event_as_param: binding.value.event_as_param || false,
        });

        function cycle(event) {
            for (let i = objList.length - 1; i >= 0; --i) {
                let item = objList[i];
                if (item.elem.is(':visible') && item.keycode === event.keyCode
                    && (item.elem.prop("tagName") !== 'INPUT' || item.elem.is(':focus'))) {
                    if (!item.func(item.event_as_param ? event : item.param)) {
                        break;
                    }
                }
            }
        }
    },
    unbind(el, binding) {
        let elem = $(el);
        let l = objList.findIndex(item => {
            return item.elem.is(elem);
        });
        objList.splice(l, 1);
    }
}