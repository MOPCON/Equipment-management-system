<template>
    <div class="box-body col-lg-offset-7">
        <div class="dataTables_wrapper form-inline dt-bootstrap">
            <input type="button" v-on:click="printBarcode()" value="列印"/>
            <input type="button" v-on:click="genrateBarcode()" value="產生"/>
            <input type="button" v-on:click="getBarcode()" value="取得資料"/>
            Total: {{ count }} <br>
            Backup: <input type="number" v-model="backup"/>

        </div>
        <div id="print_parts" style="height: 29.5cm; width: 21cm; position: absolute;left: 0;top: 0;bottom: 0; padding-top: 5px;">
            <div v-for="i in count"
                 style="height: 2.48cm; width: 4.2cm; float: left; text-align: center;">
                <img v-bind:id="'barcode'+i"/>
            </div>
        </div>

    </div>
</template>
<script>
    export default {
        data: function () {
            return {
                config: [],
                barcode: [],
                count: 0,
                backup: 10,
            }
        },
        computed: {},
        methods: {
            initConfig: function () {
//                var self = this;
//                self.config = {
//                    height: 29.7,
//                    width: 21,
//                    box_height: 2.48,
//                    box_width: 4.2,
//                }
            },
            printBarcode: function (printlist) {
                var value = $('#print_parts')[0].outerHTML;
                var printPage = window.open("", "Printing...", "");
                printPage.document.open();
                printPage.document.write("<HTML><head></head><BODY onload='window.print();window.close()'>");
                printPage.document.write(value);
                printPage.document.close("</BODY></HTML>");
            },
            genrateBarcode: function () {
                var self = this;
                for (var i = 1; i <= self.count; i++) {
                    JsBarcode('#barcode' + i, self.barcode[i-1], {
                        width: 1,
                        height: 25,
                    });
                }

            },
            getBarcode: function () {
                var self = this;
                axios.get(
                    '/api/barcode' + '?backup=' + self.backup
                ).then(response => {
                    var res = response.data.data;
                    self.barcode = res.barcode;
                    self.count = res.count;
                    console.log(response);
                }).catch(error => {
                    console.log(error);
                });
            }
        },
        created: function () {
            this.getBarcode();
//            this.initConfig();
        },
        watch: {}
    }
</script>
