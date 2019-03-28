<template>
    <div>
        <section class="content-header">
            <h1>
                借還系統
                <small>loan & return</small>
            </h1>
        </section>
        <section class="content">
            <div class="container-fluid spark-screen">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#lend" data-toggle="tab" aria-expanded="true" v-on:click="autoFocus('equibar')">出借</a></li>
                        <li class=""><a href="#return" data-toggle="tab" aria-expanded="false" v-on:click="autoFocus('equrbar')">歸還 (Barcode)</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="lend">
                            <lend></lend>
                        </div>
                        <div class="tab-pane" id="return">
                            <return_barcode></return_barcode>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
<script>
    import lend from './loan.lend.vue'
    import return_barcode from './loan.return.barcode.vue'

    export default {
        components: {lend, return_barcode},
        methods: {
            autoFocus(id) {
                setTimeout(function () {
                    $("#" + id).focus();
                }, 100);
            }
        }
    }
</script>