
import $ from 'jquery'


let listening = false,
    objList = [];

/*
*  Directive listens to clicks outside of bind elements and calls function when requirements are met.
*
* input object keys:
*
*   func: required. Calls this function.
*   param: optional. Passes this param as func argument.
*   friend: optional. If clicked element has a parent with this selector, then func is not called.
* */


export default {
    inserted(el, binding){
        let elem = $(el);

        if (!listening) {
            $('html').on('click', cycle);
            listening = true;
        }
        objList.push({
            elem: elem,
            func: binding.value.func,
            param: binding.value.param,
            friends: binding.value.friends || binding.value.friend || binding.value.friendly,
            parent: binding.value.parent,
        });

        function cycle(event) {
            objList.forEach(function (item) {
                let $target = $(event.target);
                if ($target.is(':visible')
                    && (!item.parent || !$target.parents().is(item.elem.parent())
                    && !$target.is(item.elem.parent()))
                    && !$target.closest(item.elem).length
                    && (!item.friends || !$target.closest(item.friends).length)) {
                    item.func(item.param);
                }
            })
        }
    },
    unbind(el, binding){
        let elem = $(el);
        let l = objList.findIndex(item => {
            return item.elem.is(elem);
        });
        objList.splice(l, 1);
    }
}
