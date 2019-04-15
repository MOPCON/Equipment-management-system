<template>
    <div>
        <div class="modal fade" :id="target" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" :class="size !== '' ? `modal-${size}` : 'modal-lg'">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><slot name="title"></slot></h5>
                        <slot name="header"></slot>
                    </div>
                    <div class="modal-body">
                        <slot name="body"></slot>
                    </div>
                    <div class="modal-footer">
                        <slot name="footer"></slot>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<!--<Modal :target="target" size="xs">-->
<!--<template v-slot:title>-->
<!---->
<!--</template>-->
<!--<template v-slot:header>-->
<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
<!--<span aria-hidden="true">&times;</span>-->
<!--</button>-->
<!--</template>-->
<!--<template v-slot:body>-->
<!---->
<!--</template>-->
<!--<template v-slot:footer>-->
<!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
<!--</template>-->
<!--</Modal>-->

<script>
    export default {
        props: [
            'target', 'size'
        ],

        data() {
            return {

            }
        },
        methods: {

        },
        computed: {

        },
        watch: {

        },
        components: {

        },
        mounted() {
            let self = this;
            $(`#${this.target}`).on('hide.bs.modal', function (e) {
                self.$emit('onClose', e);
            });

            $(`#${this.target}`).on('show.bs.modal', function (e) {
                self.$emit('onShow', e);
            });
        }
    }
</script>

<style scoped lang="scss">

</style>