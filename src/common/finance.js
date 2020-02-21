const units = {
    rur: {
        appendix: ' \u20bd',
        dot: 2
    },
    ue: {
        appendix: ' ue',
        dot: 2
    },
    currency: {
        appendix: '',
        dot: 2
    },
    percent: {
        appendix: '%',
        dot: 2
    },
    difference: {
        appendix: '%',
        dot: 2,
        signed: true
    },
    '%': {
        appendix: '%',
        dot: 2
    },
    count: {
        appendix: '',
        dot: 0
    }
};

function addLeading(number, length) {
    let n_ = Math.abs(number);
    let zeros = Math.max(0, length - Math.floor(n_).toString().length);
    let zeroString = Math.pow(10, zeros).toString().substr(1);
    if (number < 0) {
        zeroString = '-' + zeroString;
    }

    return zeroString + number;
}

export default {
    filters: {
        finance(val, options) {
            let c_options = {
                min_dot: options && options.dot ? options.dot : 0,
                max_dot: options && options.dot ? options.dot : 20,
                length: options && options.length ? options.length : 1,
            };
            if (isNaN(val) || !val) {
                val = 0;
            }
            let appendix = '', sign = false;
            if (options) {
                if (options.unit) {
                    appendix = units[options.unit].appendix;
                    c_options.min_dot = units[options.unit].dot;
                    c_options.max_dot = units[options.unit].dot;
                    sign = units[options.unit].signed;
                }
                if (options.signed !== undefined) {
                    sign = options.signed;
                }
                if (options.zero && +(+val).toFixed(c_options.min_dot) === 0) {
                    return options.zero;
                }
            }
            let ret = (sign && val > 0 ? '+' : '') +
                val.toLocaleString('ru', {
                    minimumIntegerDigits: c_options.length,
                    minimumFractionDigits: c_options.min_dot,
                    maximumFractionDigits: c_options.max_dot,
                });
            return ret + appendix;
        },
        numbersFormat(num, size, options) { // just backward compatibility feature!!!!
            if (!options) options = {};

            if (options.floor) {
                num = _.floor(+num, +size);
            } else {
                num = _.round(+num, +size);
            }

            if (num === 0) {
                return options.zero || '0' + (options.unit || '');
            }
            if (!isFinite(num) || (!(num > -9999999) && (options.nan))) {
                return (options.nan !== undefined) ? options.nan : '0';
            }
            let ret = num.toLocaleString('ru');
            if (options.unit) {
                ret = ret + options.unit;
            }
            return ret;
        }
    }
}