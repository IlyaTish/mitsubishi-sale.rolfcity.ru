<template lang='pug'>
  .block-stock-container(:class='[device_platform]')
    .container
      .stock-selector
        .drop-down(v-for='(selector, idx) in selectors')
          .drop-down__box(
            :class='["dd-" + idx, { active: expanded === selector.alias }]'
            @click='expand(selector.alias)') {{ (expanded === selector.alias || cur[selector.alias] === 'Все') ? selector.placeholder : cur[selector.alias] }}
            .arrow
          .drop-down__list(
            v-outer-click='{func: closeAll, friend: '.dd-' + idx}'
            v-if='expanded === selector.alias')
            .drop-down__list-item(
              :class='{active: cur[selector.alias] === item}'
              @click='setFilter(selector.alias, item)'
              v-for='item in selector.data') {{item}}

      stock-table(:data='filtered_items' v-on='$listeners')
</template>

<script>
import Mixin from '../common/mixin';
import CarsInfo from '../common/cars-info';
import OuterClick from '../common/outer-click';
import StockTable from './stock-table';

const all_item = 'Все';

export default {
  name: 'block-stock',
  props: ['car'],
  directives: { OuterClick },
  mixins: [Mixin],
  components: { StockTable },
  data() {
    return {
      cars: CarsInfo.CARS,
      expanded: null,
      cur: {
        model: 'Все',
        comp: 'Все'
      }
    };
  },
  watch: {
    car() {
      this.cur.model = this.car.name;
    }
  },
  computed: {
    selectors() {
      return [
        {
          data: this.available_models,
          placeholder: 'Выберите модель',
          alias: 'model'
        },
        {
          data: this.available_comps,
          placeholder: 'Выберите комплектацию',
          alias: 'comp'
        },
      ];
    },
    available_models() {
      const models = this.cars.map(car => car.name);

      return [all_item].concat(models);
    },
    available_comps() {
      const cur_model = this.cur.model === 'Все' ? null : this.cur.model;
      const result = this.cars
        .filter(car => !cur_model || car.name === cur_model)
        .reduce((comps, car) => {
          car.models.forEach(model => {
            comps.push(model.comp);
          });

          return comps;
        }, []);
      const result_set = Array.from(new Set(result));

      return [all_item].concat(result_set);
    },
    filtered_items() {
      const cur_model = this.cur.model === 'Все' ? null : this.cur.model;
      const cur_comp = this.cur.comp === 'Все' ? null : this.cur.comp;

      return this.cars
        .filter(car => !cur_model || cur_model === car.name)
        .reduce((ret, car) => {
          const models_to_show = car.models
            .filter(
              model =>
                (!cur_comp || model.comp === cur_comp)
            )
            .map(item => {
              item.model = car.name;
              item.id = car.id;
              return item;
            });
          ret = ret.concat(models_to_show);

          return ret;
        }, []);
    }
  },
  methods: {
    expand(alias) {
      this.expanded = this.expanded ? null : alias;
    },
    closeAll() {
      this.expanded = null;
    },
    setFilter(alias, item) {
      this.cur[alias] = item;
      this.closeAll();

      const avails = {
        model: this.available_models,
        comp: this.available_comps
      };

      const params = ['model', 'comp'];
      const idx = params.indexOf(alias);

      params.slice(idx + 1).forEach(key => {
        if (avails[key].length === 2) {
          this.cur[key] = avails[key][1];
        } else {
          this.cur[key] = 'Все';
        }
      });
    }
  }
};
</script>

<style lang="sass">
.mobile
  .stock-selector
    flex-direction: column

  .drop-down
    width: 100%
    margin: 0 0 6px

.tablet
  .drop-down
    width: 48%

.block-stock-container
  margin: 60px auto

.stock-selector
  width: 100%
  display: flex
  justify-content: space-between
  align-items: center
  margin-top: 30px

.drop-down
  width: 48%
  height: 42px
  font-size: 16px
  border: 1px solid #000000
  border-radius: 4px
  background-color: #FFFFFF
  position: relative
  &__box
    height: 100%
    padding: 0 26px
    position: relative
    display: flex
    justify-content: flex-start
    align-items: center
    font-family: 'MMCOFFICE-Bold'
    background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAECAQAAAD2Bt1FAAAAK0lEQVR42mNgmMnwHwm+YwhlAIJyuMBdBmMGKAgFC5xhUGJAAi5AAUEIEwB0NRG8kqWfJwAAAABJRU5ErkJggg==')
    background-repeat: no-repeat
    background-position: calc(100% - 20px) center
    cursor: pointer
    &.active
      background: #FFFFFF

.drop-down__list
  position: absolute
  bottom: 0
  left: 0
  transform: translateY(100%)
  padding: 10px 15px
  background: #fff
  z-index: 1
  width: 100%

.drop-down__list-item
  height: 25px
  cursor: pointer
  display: flex
  align-items: center
  justify-content: flex-start
  padding: 5px
  &:hover
    background: #f5f5f5
  &.active
    background: #ebebeb

.arrow
  width: 20px
  height: 20px
  position: absolute
  right: 10px
  top: 50%
  transform: translateY(-50%)
</style>
