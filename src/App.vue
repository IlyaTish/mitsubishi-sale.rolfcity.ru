<template lang='pug'>
  #app
    block-header(v-on='block_handles')
    block-main(v-on='block_handles')
    block-cars#cars(v-on='block_handles' @chooseComp='setCar')
    block-stock#stock(:car='car' v-on='block_handles')
    block-advantages#advantages(v-on='block_handles')
    block-offer#offer(v-on='block_handles')
    block-info#info(v-on='block_handles')
    block-contacts#contacts(v-on='block_handles')
    block-legal(v-on='block_handles')
    full-get(
      v-if='show.get'
      :data='data'
      @close='closeThings'
      v-on='block_handles'
    )
    full-thanks(
      v-if='show.thanks'
      @close='closeThings'
    )
    full-agreement(
      v-if='show.agreement'
      @close='closeAgreement'
    )
</template>

<script>
  import BlockHeader from './components/block-header';
  import BlockMain from './components/block-main';
  import BlockCars from './components/block-cars';
  import BlockStock from './components/block-stock';
  import BlockAdvantages from './components/block-advantages';
  import BlockOffer from './components/block-offer';
  import BlockInfo from './components/block-info';
  import BlockContacts from './components/block-contacts';
  import BlockLegal from './components/block-legal';
  import FullGet from './components/full-get';
  import FullThanks from './components/full-thanks';
  import FullAgreement from './components/full-agreement';
  import Mixin from './common/mixin';
  import axios from 'axios';
  import Send from './common/send';
  import $ from 'jquery';
  import smoothScrollTo from './common/smoothScrollTo';

  export default {
    name: 'app',
    components: {
      BlockHeader,
      BlockMain,
      BlockCars,
      BlockStock,
      BlockAdvantages,
      BlockOffer,
      BlockInfo,
      BlockContacts,
      BlockLegal,
      FullThanks,
      FullGet,
      FullAgreement
    },
    mixins: [Mixin],
    data: function() {
      return {
        show: {
          agreement: false,
          load: false,
          get: false,
          thanks: false
        },
        cur_office: 1,
        data: {},
        car: null
      };
    },
    mounted() {
      $('html').on('keyup', event => {
        if (event.keyCode === 27) {
          this.closeThings();
        }
      });
      history.scrollRestoration = 'manual';
      let hash = window.location.hash.replace('#', '');
      if (hash) {
        this.scrollTo(hash);
      }
    },
    computed: {
      block_handles() {
        return {
          getAgreement: this.getAgreement,
          scrollTo: this.scrollTo,
          callBack: this.callThere,
          getCall: this.handleGetCall
        };
      }
    },
    methods: {
      closeThings() {
        this.show.get = false;
        this.show.thanks = false;
        this.show.agreement = false;
        this.data = {};
        this.unblockScroll();
      },
      closeAgreement() {
        this.show.agreement = false;
        if (!this.show.get) {
          this.unblockScroll();
        }
      },
      setCar(car) {
        this.cur_car = car;
        this.scrollTo('stock');
      },
      getAgreement() {
        this.show.agreement = true;
        this.blockScroll();
      },
      handleGetCall(data) {
        this.show.get = true;
        this.data = data;
        this.blockScroll();
      },
      scrollTo(where) {
        let target = document.getElementById(where);

        smoothScrollTo(
          $('#' + where).offset().top -
            (this.device_platform === 'desktop' ? 100 : 200)
        );
      },
      showOffice(id) {
        this.cur_office = id;
      },
      callThere(event) {
        let cKeeper = this.CONSTANTS.cKeeper,
          manager_phone = this.CONSTANTS.need_manager_phone
            ? $('#phone')
                .text()
                .replace(/\s/g, '\u00A0')
                .replace(/-/g, '\u2011')
                .replace(/\D+/g, '')
            : '',
          req = Send(event, this.data, cKeeper, manager_phone);
        this.show.load = true;

        if (cKeeper === 'actioncall') {
          const finishCall = () => {
            this.closeThings();
            this.show.load = false;
            this.show.thanks = true;
            if (typeof window.dataLayer !== 'undefined') {
              window.dataLayer.push({
                event: 'callkeeper-call_order-ckaction',
                eventCategory: 'callkeeper',
                eventAction: 'call_order',
                eventLabel: 'ckaction'
              });
            }
            console.log('done');
          };

          if (!req) {
            finishCall();
          } else {
            req.finally(finishCall);
          }
        } else {
          this.closeThings();
          this.show.load = false;
          this.show.thanks = true;
        }
      }
    }
  };
</script>