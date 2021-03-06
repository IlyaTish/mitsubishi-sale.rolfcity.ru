import MODELS from './models';

const PRICES = {
  outlander:     1195000,
  pajero_sport:  1827000,
  eclipse_cross: 1449000,
  asx:           1019000,
  l200:          1699000,
  pajero:        2539000
};

const ADVANTAGES = {
  outlander:     650000,
  pajero_sport:  1050000,
  eclipse_cross: 700000,
  asx:           310000,
  l200:          450000,
  pajero:        550000
};

const DOPINFO = {
  outlander: [
    'Рассрочка 0%**',
    'Кредит от 6 190 ₽/мес',
    'Бонус по Трейд-ин 300 000 ₽',
    'В наличии с ПТС',
    'Без первого взноса',
    'КАСКО в подарок',
    '+ 50 000 ₽ на ТО'
  ],
  pajero_sport: [
    'Рассрочка 0%**',
    'Кредит от 5 307 ₽/мес',
    'Бонус по Трейд-ин 400 000 ₽',
    'В наличии с ПТС',
    'Охранный комплекс бонусом',
    'КАСКО в подарок',
    '+ 50 000 ₽ на ТО'
  ],
  eclipse_cross: [
    'Рассрочка 0%**',
    'Бонус по Трейд-ин 200 000 ₽',
    'В наличии с ПТС',
    'Тур в подарок',
    'КАСКО в подарок',
    '+ 50 000 ₽ на ТО'
  ],
  asx: [
    'Рассрочка 0%**',
    'Кредит от 4 931 ₽/мес',
    'Бонус по Трейд-ин 50 000 ₽',
    'В наличии с ПТС',
    'Тур в подарок',
    'КАСКО в подарок',
    'Охранный комплекс бонусом'
  ],
  l200: [
    'Рассрочка 0%**',
    'Кредит от 8 690 ₽/мес',
    'Бонус по Трейд-ин 250 000 ₽',
    'В наличии с ПТС',
    'Тур в подарок',
    'КАСКО в подарок',
    'Охранный комплекс бонусом'
  ],
  pajero: [
    'Рассрочка 0%**',
    'Кредит от 13 067 ₽/мес',
    'Бонус по Трейд-ин 150 000 ₽',
    'Без первого взноса',
    'Тур в подарок',
    'КАСКО в подарок',
    'Охранный комплекс бонусом',
    '+ 50 000 ₽ на ТО'
  ]
};

export default {
  CARS: [
    {
      id:           'outlander',
      name:         'OUTLANDER',
      price:        PRICES.outlander,
      advantage:    ADVANTAGES.outlander,
      dopInfo:      DOPINFO.outlander,
      stock:        17,
      amount:       8,
      imgUrl:       require('../images/cars/outlander.png'),
      models:       MODELS.outlander
    },
    {
      id:        'pajero_sport',
      name:      'PAJERO SPORT',
      price:     PRICES.pajero_sport,
      advantage: ADVANTAGES.pajero_sport,
      dopInfo:   DOPINFO.pajero_sport,
      stock:     5,
      amount:    17,
      imgUrl:    require('../images/cars/pajero_sport.png'),
      models:    MODELS.pajero_sport
    },
    {
      id:        'eclipse_cross',
      name:      'ECLIPSE CROSS',
      price:     PRICES.eclipse_cross,
      advantage: ADVANTAGES.eclipse_cross,
      dopInfo:   DOPINFO.eclipse_cross,
      stock:     11,
      amount:    19,
      imgUrl:    require('../images/cars/eclipse_cross.png'),
      models:    MODELS.eclipse_cross
    },
    {
      id:        'asx',
      name:      'ASX',
      price:     PRICES.asx,
      advantage: ADVANTAGES.asx,
      dopInfo:   DOPINFO.asx,
      stock:     6,
      amount:    19,
      imgUrl:    require('../images/cars/asx.png'),
      models:    MODELS.asx
    },
    {
      id:        'l200',
      name:      'L200',
      price:     PRICES.l200,
      advantage: ADVANTAGES.l200,
      dopInfo:   DOPINFO.l200,
      stock:     12,
      amount:    19,
      imgUrl:    require('../images/cars/l200_new.png'),
      models:    MODELS.l200_new
    },
    {
      id:        'pajero',
      name:      'PAJERO',
      price:     PRICES.pajero,
      advantage: ADVANTAGES.pajero,
      dopInfo:   DOPINFO.pajero,
      stock:     17,
      amount:    7,
      imgUrl:    require('../images/cars/pajero.png'),
      models:    MODELS.pajero
    }
  ]
};