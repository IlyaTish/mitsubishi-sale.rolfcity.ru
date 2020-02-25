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

const PHONE = '+7 (495) 785-19-94'.replace(/\s/g, '\u00A0').replace(/-/g, '\u2011');

const PHONE_RAW = PHONE.replace(/\D+/g, "");

export default {
  brand: "MITSUBISHI РОЛЬФ",
  phone: PHONE,
  phone_raw: PHONE_RAW,
  end_date: date,
  worktime: "Ждём Вас с <b>с 8:30 до 21:00</b>",
  max_advantage: MAX_ADVANTAGE,
  min_price: MIN_PRICE,
  min_payment: MIN_PAYMENT,
  offices: [
    {
      id: 0,
      short_address: "Алтуфьевское ш., 31",
      name: "РОЛЬФ Диамант",
      address: "<b>РОЛЬФ Диамант</b><br>Москва, Алтуфьевское ш., 31, стр. 1",
      coords: {
        x: 37.58040899999989,
        y: 55.86146406889051
      }
    },
    {
      id: 1,
      short_address: "Рязанский пр-т, 24",
      name: "РОЛЬФ Восток",
      address: "<b>РОЛЬФ Восток</b><br>Москва, Рязанский пр-т, д. 24, к.3",
      worktime: "Ждём Вас с 8:30 до 21:00",
      coords: {
        x: 37.776224,
        y: 55.72010906900426
      }
    },
    {
      id: 2,
      short_address: "Ярославское ш., 31",
      name: "РОЛЬФ Сити",
      address: "<b>РОЛЬФ Сити</b><br>Москва, Ярославское ш., д. 31",
      worktime: "Ждём Вас с 8:30 до 21:00",
      coords: {
        x: 37.68801849999996,
        y: 55.85994806888662
      }
    },
    {
      id: 3,
      short_address: "Ленинградское ш., 21",
      name: "РОЛЬФ Химки",
      address: "<b>РОЛЬФ Химки</b><br>Химки, Ленинградское ш., вл. 21",
      worktime: "Ждём Вас с 8:30 до 21:00",
      coords: {
        x: 37.412751407409594,
        y: 55.90567363918124
      }
    },
    {
      id: 4,
      short_address: "Ленинградское ш., 21",
      name: "РОЛЬФ Юг",
      address: "<b>РОЛЬФ Юг</b><br>Москва, ул. Обручева, д. 27, корп. 1",
      worktime: "Ждём Вас с 8:30 до 21:00",
      coords: {
        x: 37.53606849999994,
        y: 55.656859069079985
      }
    }
  ],
  center_coords: {
    x: 37.706814953826896,
    y: 55.75969980398249
  },
  need_agreement: true,
  cKeeper: "undefined"
};
