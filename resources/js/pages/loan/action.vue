<template>
    <div class="container-fluid">
        <h1>
            借還系統
            <small>loan & return</small>
        </h1>
        <ul class="nav nav-tabs mb-2" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="lend-tab" data-toggle="tab" href="#lend" role="tab" aria-controls="lend"
                   aria-selected="true" @click="autoFocus('equibar')">出借</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="return-tab" data-toggle="tab" href="#return" role="tab" aria-controls="return"
                   aria-selected="false" @click="autoFocus('equrbar')">歸還 (Barcode)</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="lend" role="tabpanel" aria-labelledby="lend-tab">
                <lend/>
            </div>
            <div class="tab-pane fade" id="return" role="tabpanel" aria-labelledby="return-tab">
                <return_barcode/>
            </div>
        </div>
    </div>
</template>
<script>
    import lend from './loan.lend.vue';
    import return_barcode from './loan.return.barcode.vue';

    export default {
        components: {lend, return_barcode},
        methods: {
            autoFocus(id) {
                setTimeout(function () {
                    $("#" + id).focus();
                }, 100);
            }
        }
    };
</script>