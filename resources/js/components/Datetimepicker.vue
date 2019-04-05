<template>
    <div>
        <div class="input-group date" :id="target" data-target-input="nearest">
            <input type="text" class="form-control datetimepicker-input" :data-target="`#${target}`"/>
            <div class="input-group-append" :data-target="`#${target}`" data-toggle="datetimepicker">
                <div class="input-group-text">
                    <font-awesome-icon icon="calendar"/>
                </div>
            </div>
        </div>
    </div>
</template>

<!--<div class="form-group">-->
    <!--<Datetimepicker target="sending_time" :value="datetime" @onChangeValue="onChangeValue"/>-->
<!--</div>-->

<script>
    export default {
        props: ['target', 'value'],

        data() {
            return {

            }
        },
        methods: {

        },
        computed: {

        },
        watch: {
            value(value) {
                let id = `#${this.target} input`;
                $(id).val(value)
            }
        },
        components: {

        },
        mounted() {
            let self = this;
            $(`#${this.target}`).datetimepicker();
            $(`#${this.target}`).on('hide.datetimepicker', function (e) {
                let id = `#${self.target} input`;
                console.log($(id).val());
                self.$emit('onChangeValue', $(id).val());
            });
        }
    }
</script>

<style scoped lang="scss">

</style>