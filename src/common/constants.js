import CF from './common-functions';
import CarsInfo from './cars-info';

const prices = CarsInfo.CARS.map(el => el.price);
const advantages = CarsInfo.CARS.map(el => el.advantage);
const payments = CarsInfo.CARS.map(el => el.payment);
const MAX_ADVANTAGE = Math.max.apply(null, advantages);
const MIN_PRICE = Math.min.apply(null, prices);
const MIN_PAYMENT = Math.min.apply(null, payments);

let today = new Date();
let days_total = Math.floor((new Date(today.getFullYear(), today.getMonth(), today.getDate(), 0, 0, 0)).getTime() / (1000 * 60 * 60 * 24));
let date = CF.getNewDate();

const PHONE = '+7 (495) 933-40-33'.replace(/\s/g, '\u00A0').replace(/-/g, '\u2011');

const PHONE_RAW = PHONE.replace(/\D+/g, "");



export default {
    brand: 'LADA Кунцево',
    phone: PHONE,
    phone_raw: PHONE_RAW,
    end_date: date,
    worktime: 'Ждём Вас с <b>с 8:30 до 21:00</b>',
    max_advantage: MAX_ADVANTAGE,
    min_price: MIN_PRICE,
    min_payment: MIN_PAYMENT,
    offices: [
        {
            id: 0,
            short_address: 'улица Горбунова, 14',
            name: 'Кунцево',
            address: 'Москва, ул.Горбунова, 14 (МКАД, 56км)',
            worktime: 'Ждём Вас с 8:30 до 21:00',
            phone: PHONE,
            phone_raw: PHONE_RAW,
            coords: {
                x: 37.3743102,
                y: 55.7254598
            }
        },

    ],
    center_coords: {
        x: 37.3694102,
        y: 55.7254598
    },
    need_agreement: true,
    cKeeper: 'undefined',
}
