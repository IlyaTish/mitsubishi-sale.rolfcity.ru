import $ from 'jquery';


export default {
    data() {
        return {
            device_platform: 'desktop'
        }
    },
    mounted() {
        let handleResize = () => {
            const initial = [
                {
                    size: 1200,
                    key: 'desktop'
                },
                {
                    size: 800,
                    key: 'tablet'
                },
                {
                    size: 0,
                    key: 'mobile'
                }
            ];
            let width = initial[0];
            for (let i = 0; i < initial.length; ++i) {
                if ($(window).width() > initial[i].size) {
                    width = initial[i];
                    break;
                }
            }
            this.device_platform = width.key;
        };
        $(window).on('resize', handleResize);
        handleResize();
    },
    computed: {},
    methods: {
        getCall(type) {
            this.$emit('getCall', type);
        },
        blockScroll() {
            $('body').addClass('scroll-blocked');
        },
        unblockScroll() {
            $('body').removeClass('scroll-blocked');
        }
    }
}